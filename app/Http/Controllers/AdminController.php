<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Pantalla de Inicio / Dashboard del Administrador
     * Muestra métricas clave, balance de ventas y pedidos recientes.
     */
    public function dashboard(): View
    {
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'en_preparacion')->count();
        $totalProducts = Product::count();
        $totalClients = User::where('role', 'cliente')->count();

        $recentOrders = Order::with(['items.product', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        $productos = Product::with('reviews.user')
            ->orderBy('id', 'asc')
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'totalProducts',
            'totalClients',
            'recentOrders',
            'productos'
        ));
    }

    /**
     * Pantalla: Pedidos a realizar agrupados por mesa con visualización de notas e ingredientes
     */
    public function pedidos(Request $request): View
    {
        $filtro = $request->input('filtro', 'activas');

        $query = Order::with(['items.product', 'user'])
            ->orderBy('created_at', 'desc');

        if ($filtro === 'archivadas') {
            $query->where('status', 'archivado');
        } elseif ($filtro === 'activas') {
            $query->where('status', '!=', 'archivado');
        }

        $pedidos = $query->get();

        // Agrupar por modalidad / mesa
        $pedidosPorMesa = $pedidos->groupBy('table_number');

        return view('admin.pedidos', compact('pedidos', 'pedidosPorMesa', 'filtro'));
    }

    /**
     * Acción: Actualizar estado de un pedido
     */
    public function actualizarEstadoPedido(Request $request, int $id): RedirectResponse
    {
        $pedido = Order::findOrFail($id);
        $nuevoEstado = $request->input('status', 'entregado');

        $estadosValidos = ['en_preparacion', 'entregado', 'archivado', 'completado'];
        if (!in_array($nuevoEstado, $estadosValidos)) {
            $nuevoEstado = 'entregado';
        }

        $pedido->status = $nuevoEstado;
        $pedido->save();

        $mensaje = match ($nuevoEstado) {
            'archivado' => "La orden #{$pedido->id} fue archivada y retirada de la cocina activa.",
            'entregado' => "La orden #{$pedido->id} fue marcada como entregada exitosamente.",
            'en_preparacion' => "La orden #{$pedido->id} ha vuelto a estado en preparación.",
            default => "Estado de la orden #{$pedido->id} actualizado a {$nuevoEstado}."
        };

        return redirect()->back()->with('success', $mensaje);
    }

    /**
     * Pantalla: Detalle completo de pedido (Ticket y Desglose)
     */
    public function verPedido(int $id): View
    {
        $order = Order::with('items.product', 'user')->findOrFail($id);
        return view('admin.ver_pedido', compact('order'));
    }

    /**
     * Pantalla: Catálogo organizado de Productos
     */
    public function productos(Request $request): View
    {
        $query = Product::query();

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where('name', 'like', "%{$q}%")
                  ->orWhere('category', 'like', "%{$q}%");
        }

        if ($request->filled('category') && $request->input('category') !== 'todas') {
            $cat = $request->input('category');
            $query->where('category', $cat)->orWhere('category', rtrim($cat, 's'));
        }

        $productos = $query->orderBy('category', 'asc')->orderBy('id', 'asc')->get();
        $categories = Product::select('category')->distinct()->pluck('category');

        return view('admin.productos', compact('productos', 'categories'));
    }

    /**
     * Formulario para crear un nuevo producto
     */
    public function crearProducto(): View
    {
        $categories = Product::select('category')->distinct()->pluck('category');
        return view('admin.crear-producto', compact('categories'));
    }

    /**
     * Guardar nuevo producto con URL de imagen o subida directa desde el dispositivo
     * Nota: La calificación de estrellas no se asigna aquí; es exclusiva de los clientes vía reseñas.
     */
    public function almacenarProducto(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:150',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\.\-]+$/u',
            ],
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:1|max:50000',
            'prep_time' => 'nullable|string|max:50',
            'short_description' => 'required|string|max:255',
            'description' => 'nullable|string',
            'customizable_ingredients' => 'nullable|string|max:500',
            'image' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
        ], [
            'name.required' => 'El nombre del alimento es obligatorio.',
            'name.regex' => 'El dato que se intenta ingresar no corresponde al solicitado. El nombre del alimento solo debe contener letras (sin números).',
            'price.required' => 'El precio es obligatorio.',
            'price.numeric' => 'El precio debe ser un valor numérico.',
            'price.min' => 'El precio debe ser mayor a 0.',
            'category.required' => 'La categoría es obligatoria.',
            'image_file.image' => 'El archivo debe ser una imagen válida (JPG, PNG, WebP).',
        ]);

        $imageUrl = $request->input('image');

        // Subida de imagen directa desde el dispositivo a public/uploads/products
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $uploadPath = public_path('uploads/products');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $filename = 'alimento_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $imageUrl = asset('uploads/products/' . $filename);
        }

        if (empty($imageUrl)) {
            $imageUrl = 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&auto=format&fit=crop&q=60';
        }

        Product::create([
            'name' => trim($request->input('name')),
            'category' => trim($request->input('category')),
            'price' => (float) $request->input('price'),
            'prep_time' => $request->input('prep_time', '15 min'),
            'short_description' => trim($request->input('short_description')),
            'description' => trim($request->input('description', '')),
            'customizable_ingredients' => $request->filled('customizable_ingredients') ? trim($request->input('customizable_ingredients')) : null,
            'image' => $imageUrl,
            'is_best_seller' => $request->has('is_best_seller'),
        ]);

        return redirect()->route('admin.productos')->with('success', "¡Platillo '" . $request->input('name') . "' agregado exitosamente al catálogo!");
    }

    /**
     * Formulario para editar un producto
     */
    public function editarProducto(int $id): View
    {
        $producto = Product::findOrFail($id);
        $categories = Product::select('category')->distinct()->pluck('category');

        return view('admin.editar-producto', compact('producto', 'categories'));
    }

    /**
     * Guardar cambios del producto con soporte de URL o subida de imagen
     */
    public function guardarProducto(Request $request, int $id): RedirectResponse
    {
        $producto = Product::findOrFail($id);

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:150',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\.\-]+$/u',
            ],
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:1|max:50000',
            'prep_time' => 'nullable|string|max:50',
            'short_description' => 'required|string|max:255',
            'description' => 'nullable|string',
            'customizable_ingredients' => 'nullable|string|max:500',
            'image' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
        ], [
            'name.required' => 'El nombre del alimento es obligatorio.',
            'name.regex' => 'El dato que se intenta ingresar no corresponde al solicitado. El nombre del alimento solo debe contener letras (no números).',
            'price.required' => 'El precio es obligatorio.',
            'price.numeric' => 'El precio debe ser un número válido.',
        ]);

        // Si se subió un nuevo archivo de imagen
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $uploadPath = public_path('uploads/products');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $filename = 'alimento_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $producto->image = asset('uploads/products/' . $filename);
        } elseif ($request->filled('image')) {
            $producto->image = trim($request->input('image'));
        }

        $producto->name = trim($request->input('name'));
        $producto->category = trim($request->input('category'));
        $producto->price = (float) $request->input('price');
        $producto->prep_time = $request->input('prep_time', '15 min');
        $producto->short_description = trim($request->input('short_description'));
        $producto->description = trim($request->input('description', ''));
        $producto->customizable_ingredients = $request->filled('customizable_ingredients') ? trim($request->input('customizable_ingredients')) : null;
        $producto->is_best_seller = $request->has('is_best_seller');

        $producto->save();

        return redirect()->route('admin.productos')->with('success', "¡Platillo '{$producto->name}' actualizado correctamente!");
    }

    /**
     * Admin - Configuración del Restaurante y Código de Seguridad
     */
    public function configuracion(): View
    {
        $user = Auth::user();
        $settings = DB::table('admin_settings')->pluck('value', 'key_name')->toArray();
        $adminCode = $settings['admin_security_code'] ?? '1720';
        $restaurantAddress = $settings['restaurant_address'] ?? 'Universidad Politécnica del Valle de Toluca (UPVT), Carretera Toluca - Almoloya de Juárez Km 5.6';
        $restaurantPhone = $settings['restaurant_phone'] ?? '722 839 1022';
        $restaurantEmail = $settings['restaurant_email'] ?? 'zaidmed587@gmail.com';
        $restaurantSchedule = $settings['restaurant_schedule'] ?? 'Lunes a Sábado: 10:00 AM - 10:00 PM';

        return view('admin.configuracion', compact(
            'user', 
            'adminCode', 
            'restaurantAddress', 
            'restaurantPhone', 
            'restaurantEmail', 
            'restaurantSchedule'
        ));
    }

    /**
     * Acción: Actualizar configuración y datos del restaurante
     */
    public function actualizarConfiguracion(Request $request): RedirectResponse
    {
        $request->validate([
            'admin_code' => ['nullable', 'string', 'min:4', 'max:20', 'regex:/^[0-9]+$/'],
            'restaurant_address' => ['nullable', 'string', 'max:255'],
            'restaurant_phone' => ['nullable', 'string', 'max:50'],
            'restaurant_email' => ['nullable', 'email', 'max:100'],
            'restaurant_schedule' => ['nullable', 'string', 'max:100'],
        ], [
            'admin_code.regex' => 'El código de seguridad debe contener únicamente números.',
            'admin_code.min' => 'El código debe tener al menos 4 dígitos.',
            'restaurant_email.email' => 'Ingresa un correo electrónico válido.',
        ]);

        if ($request->filled('admin_code')) {
            DB::table('admin_settings')->updateOrInsert(
                ['key_name' => 'admin_security_code'],
                ['value' => trim($request->input('admin_code')), 'updated_at' => now()]
            );
        }

        if ($request->has('restaurant_address')) {
            DB::table('admin_settings')->updateOrInsert(
                ['key_name' => 'restaurant_address'],
                ['value' => trim($request->input('restaurant_address')), 'updated_at' => now()]
            );
        }

        if ($request->has('restaurant_phone')) {
            DB::table('admin_settings')->updateOrInsert(
                ['key_name' => 'restaurant_phone'],
                ['value' => trim($request->input('restaurant_phone')), 'updated_at' => now()]
            );
        }

        if ($request->has('restaurant_email')) {
            DB::table('admin_settings')->updateOrInsert(
                ['key_name' => 'restaurant_email'],
                ['value' => trim($request->input('restaurant_email')), 'updated_at' => now()]
            );
        }

        if ($request->has('restaurant_schedule')) {
            DB::table('admin_settings')->updateOrInsert(
                ['key_name' => 'restaurant_schedule'],
                ['value' => trim($request->input('restaurant_schedule')), 'updated_at' => now()]
            );
        }

        return redirect()->route('admin.configuracion')->with('success', '¡Configuración del restaurante y datos actualizados correctamente!');
    }

    /**
     * Acción: Eliminar producto del menú
     */
    public function eliminarProducto(int $id): RedirectResponse
    {
        $producto = Product::findOrFail($id);
        $name = $producto->name;
        $producto->delete();

        return redirect()->back()->with('success', "¡El platillo '{$name}' ha sido eliminado del menú!");
    }

    /**
     * Acción: Eliminar comentario de comensal
     */
    public function eliminarReview(int $id): RedirectResponse
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->back()->with('success', "¡El comentario ha sido eliminado del sistema!");
    }
}
