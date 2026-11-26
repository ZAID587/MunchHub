<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ClientController extends Controller
{
    /**
     * Pantalla 1: Inicio estilo Buscamed / E-Commerce de Restaurante
     * Muestra banner, categorías, catálogo completo, filtros de precio, opiniones de clientes y FAQ.
     */
    public function inicio(Request $request): View|RedirectResponse
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $categoryFilter = $request->input('category');
        $searchQuery = $request->input('q');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $disponibilidad = $request->input('disponibilidad');

        // Consulta de productos
        $productsQuery = Product::with('reviews');

        if (!empty($categoryFilter) && $categoryFilter !== 'todos') {
            $catTrim = rtrim($categoryFilter, 's');
            $productsQuery->where(function ($q) use ($categoryFilter, $catTrim) {
                $q->where('category', $categoryFilter)
                  ->orWhere('category', $catTrim)
                  ->orWhere('category', $categoryFilter . 's')
                  ->orWhere('category', 'like', "%{$catTrim}%");
            });
        }

        if (!empty($searchQuery)) {
            $productsQuery->where(function ($q) use ($searchQuery) {
                $q->where('name', 'like', "%{$searchQuery}%")
                  ->orWhere('category', 'like', "%{$searchQuery}%")
                  ->orWhere('short_description', 'like', "%{$searchQuery}%");
            });
        }

        if (!empty($minPrice) && is_numeric($minPrice)) {
            $productsQuery->where('price', '>=', (float) $minPrice);
        }

        if (!empty($maxPrice) && is_numeric($maxPrice)) {
            $productsQuery->where('price', '<=', (float) $maxPrice);
        }

        if ($disponibilidad === 'oferta') {
            $productsQuery->where('is_best_seller', true);
        }

        $productos = $productsQuery->orderBy('id', 'asc')->get();

        // Obtener productos más vendidos para el banner superior
        $masVendidos = Product::where('is_best_seller', true)->take(6)->get();
        if ($masVendidos->isEmpty()) {
            $masVendidos = Product::take(4)->get();
        }

        // Categorías únicas
        $categories = Product::select('category')->whereNotNull('category')->distinct()->pluck('category');

        // Reseñas de clientes para el carrusel de testimonios
        $recentReviews = Review::with(['user', 'product'])->latest()->take(6)->get();

        $cartCount = Auth::check() ? Auth::user()->cartItems()->count() : 0;

        return view('client.inicio', compact(
            'productos',
            'masVendidos',
            'categories',
            'recentReviews',
            'categoryFilter',
            'searchQuery',
            'minPrice',
            'maxPrice',
            'disponibilidad',
            'cartCount'
        ));
    }

    /**
     * Pantalla 2: Buscar con filtros avanzados
     */
    public function buscar(Request $request): View
    {
        $query = $request->input('q', '');
        $category = $request->input('category');

        $queryBuilder = Product::query();

        if (!empty($query)) {
            $queryBuilder->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('category', 'like', "%{$query}%")
                  ->orWhere('short_description', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            });
        }

        if (!empty($category) && $category !== 'todos') {
            $catTrim = rtrim($category, 's');
            $queryBuilder->where(function ($q) use ($category, $catTrim) {
                $q->where('category', $category)
                  ->orWhere('category', $catTrim)
                  ->orWhere('category', $category . 's')
                  ->orWhere('category', 'like', "%{$catTrim}%");
            });
        }

        $productos = $queryBuilder->get();
        $categories = Product::select('category')->distinct()->pluck('category');
        $cartCount = Auth::check() ? Auth::user()->cartItems()->count() : 0;

        return view('client.buscar', compact('productos', 'query', 'category', 'categories', 'cartCount'));
    }

    /**
     * Pantalla 3: Detalle de Platillo con opciones personalizadas y sección de reseñas
     */
    public function platillo(int $id): View
    {
        $producto = Product::with(['reviews.user'])->findOrFail($id);
        $relacionados = Product::where('category', $producto->category)
            ->where('id', '!=', $producto->id)
            ->take(4)
            ->get();

        $cartCount = Auth::check() ? Auth::user()->cartItems()->count() : 0;

        return view('client.platillo', compact('producto', 'relacionados', 'cartCount'));
    }

    /**
     * Acción: Agregar producto al carrito estructurando las opciones elegidas
     */
    public function agregarAlCarrito(Request $request, int $id): RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Por favor inicia sesión o crea tu cuenta para agregar platillos al carrito.');
        }

        $request->validate([
            'quantity' => 'nullable|integer|min:1|max:50',
            'size' => 'nullable|string|max:50',
            'temperature' => 'nullable|string|max:50',
            'bread_type' => 'nullable|string|max:50',
            'custom_ingredients' => 'nullable|array',
            'special_notes' => 'nullable|string|max:300',
        ]);

        $quantity = (int) $request->input('quantity', 1);

        // Estructurar notas legibles
        $parts = [];
        if ($request->filled('size')) {
            $parts[] = "Tamaño: " . $request->input('size');
        }
        if ($request->filled('temperature')) {
            $parts[] = "Temp/Presentación: " . $request->input('temperature');
        }
        if ($request->filled('bread_type')) {
            $parts[] = "Pan: " . $request->input('bread_type');
        }
        if ($request->has('custom_ingredients') && is_array($request->input('custom_ingredients'))) {
            $parts[] = "Detalles: " . implode(', ', $request->input('custom_ingredients'));
        }
        if ($request->filled('special_notes')) {
            $parts[] = "Indicación: " . trim($request->input('special_notes'));
        }

        $formattedNotes = !empty($parts) ? implode(' | ', $parts) : 'Estándar';

        $user = Auth::user();

        // Crear siempre un item con sus opciones específicas para no sobreescribir personalizaciones distintas
        CartItem::create([
            'user_id' => $user->id,
            'product_id' => $id,
            'quantity' => $quantity,
            'notes' => $formattedNotes,
            'is_selected' => true,
        ]);

        return redirect()->route('client.carrito')->with('success', '¡Platillo agregado al carrito con tus especificaciones!');
    }

    /**
     * Acción: Calificar y dejar reseña a un platillo
     */
    public function guardarReview(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ], [
            'rating.required' => 'Debes seleccionar una calificación de 1 a 5 estrellas.',
        ]);

        $product = Product::findOrFail($id);

        Review::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $product->id,
            ],
            [
                'rating' => (int) $request->input('rating'),
                'comment' => $request->input('comment'),
            ]
        );

        // Actualizar promedio en el producto
        $avg = Review::where('product_id', $product->id)->avg('rating');
        if ($avg) {
            $product->stars = (int) round($avg);
            $product->save();
        }

        return back()->with('review_success', '¡Gracias por calificar este platillo! Tu opinión ayuda a otros comensales.');
    }

    /**
     * Pantalla 4: Carrito con diseño limpio e interactivo
     */
    public function carrito(): View
    {
        $user = Auth::user();
        $items = CartItem::with('product')
            ->where('user_id', $user->id)
            ->get();

        $cartCount = $items->count();

        $subtotal = $items->where('is_selected', true)->sum(function ($item) {
            return $item->subtotal;
        });

        $shippingCost = ($subtotal >= 450 || $subtotal == 0) ? 0.00 : 69.00;
        $total = $subtotal + $shippingCost;

        return view('client.carrito', compact('items', 'cartCount', 'subtotal', 'shippingCost', 'total'));
    }

    /**
     * Acción: Actualizar cantidad en carrito (+ / -)
     */
    public function actualizarCantidad(Request $request, int $id): RedirectResponse
    {
        $delta = (int) $request->input('delta', 0);
        $cartItem = CartItem::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        $newQty = $cartItem->quantity + $delta;
        if ($newQty > 0) {
            $cartItem->quantity = $newQty;
            $cartItem->save();
        } else {
            $cartItem->delete();
        }

        return redirect()->route('client.carrito');
    }

    /**
     * Acción: Alternar selección del checkbox en carrito
     */
    public function toggleSeleccion(Request $request, int $id): RedirectResponse
    {
        $cartItem = CartItem::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        $cartItem->is_selected = !$cartItem->is_selected;
        $cartItem->save();

        return redirect()->route('client.carrito');
    }

    /**
     * Acción: Eliminar elementos del carrito
     */
    public function eliminarDelCarrito(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($request->has('item_id')) {
            CartItem::where('user_id', $user->id)->where('id', $request->input('item_id'))->delete();
            return redirect()->route('client.carrito')->with('success', 'Platillo retirado del carrito.');
        }

        $deleted = CartItem::where('user_id', $user->id)->where('is_selected', true)->delete();

        if ($deleted === 0) {
            CartItem::where('user_id', $user->id)->delete();
        }

        return redirect()->route('client.carrito')->with('success', 'Elementos eliminados del carrito.');
    }

    /**
     * Acción: Realizar pedido (Pagar) con desglose de Transferencia, Tarjeta o Efectivo
     */
    public function pagar(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $items = CartItem::with('product')
            ->where('user_id', $user->id)
            ->where('is_selected', true)
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('client.carrito')->with('error', 'Selecciona al menos un platillo para ordenar.');
        }

        $tableNumber = $request->input('table_number', 'Para llevar (En mostrador)');
        $paymentMethod = $request->input('payment_method', 'Efectivo');
        $paymentDetails = '';

        if ($paymentMethod === 'Transferencia') {
            $concept = $request->input('transfer_concept', 'MH-' . rand(10000, 99999));
            $paymentDetails = "Transferencia SPEI (Banco: BBVA | CLABE: 012180004567891234 | Concepto: " . $concept . ")";
        } elseif ($paymentMethod === 'Tarjeta') {
            $request->validate([
                'card_number' => ['required', 'string', 'regex:/^[0-9\s]{16,19}$/'],
                'card_exp' => ['required', 'string', 'regex:/^(0[1-9]|1[0-2])\/[0-9]{2}$/'],
                'card_cvv' => ['required', 'string', 'regex:/^[0-9]{3}$/'],
            ], [
                'card_number.required' => 'El número de tarjeta es obligatorio.',
                'card_number.regex' => 'El dato ingresado no corresponde al solicitado. El número de tarjeta debe contener únicamente dígitos numéricos (16 dígitos).',
                'card_exp.required' => 'La fecha de vencimiento es obligatoria.',
                'card_exp.regex' => 'El dato ingresado no corresponde al solicitado. La fecha debe ser mes y año con diagonal (ejemplo: 12/28) numérico.',
                'card_cvv.required' => 'El código CVV es obligatorio.',
                'card_cvv.regex' => 'El dato ingresado no corresponde al solicitado. El código CVV debe tener exactamente 3 dígitos numéricos.',
            ]);

            $cleanNumber = preg_replace('/\s+/', '', $request->input('card_number'));
            $lastDigits = substr($cleanNumber, -4);
            $paymentDetails = "Tarjeta bancaria terminada en ****{$lastDigits} (Venc: {$request->input('card_exp')})";
        } else {
            $paymentDetails = "Efectivo al recibir";
        }

        $subtotal = $items->sum(fn ($i) => $i->subtotal);
        $shippingCost = ($subtotal >= 450) ? 0.00 : 69.00;
        $total = $subtotal + $shippingCost;

        if ($shippingCost > 0) {
            $paymentDetails .= " | Incluye envío estándar: $69.00";
        } else {
            $paymentDetails .= " | Envío GRATIS (compra >= $450)";
        }

        $deliveryAddress = null;
        $deliveryLat = $request->input('delivery_lat');
        $deliveryLng = $request->input('delivery_lng');

        if (\Illuminate\Support\Str::contains(strtolower($tableNumber), ['domicilio'])) {
            $calle = trim($request->input('calle_entrega', ''));
            $numero = trim($request->input('numero_entrega', ''));
            $colonia = trim($request->input('colonia_entrega', ''));
            $referencias = trim($request->input('referencias_entrega', ''));
            $telefono = trim($request->input('telefono_entrega', $user->telefono ?? ''));

            $parts = [];
            if ($calle) $parts[] = "Calle: " . $calle . ($numero ? " #" . $numero : "");
            if ($colonia) $parts[] = "Col: " . $colonia;
            if ($telefono) $parts[] = "Tel: " . $telefono;
            if ($referencias) $parts[] = "Ref: " . $referencias;

            $deliveryAddress = !empty($parts) ? implode(' | ', $parts) : ($user->localidad ?? 'Almoloya de Juárez');
            $paymentDetails .= " | Destino Entrega: " . $deliveryAddress;
        }

        $order = Order::create([
            'user_id' => $user->id,
            'table_number' => $tableNumber,
            'total' => $total,
            'status' => 'en_preparacion',
            'notes' => $paymentDetails,
            'delivery_address' => $deliveryAddress,
            'delivery_lat' => (!empty($deliveryLat) && is_numeric($deliveryLat)) ? floatval($deliveryLat) : null,
            'delivery_lng' => (!empty($deliveryLng) && is_numeric($deliveryLng)) ? floatval($deliveryLng) : null,
        ]);

        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->unit_price,
                'notes' => $item->notes,
            ]);
        }

        // Eliminar del carrito los ordenados
        CartItem::where('user_id', $user->id)->where('is_selected', true)->delete();

        return redirect()->route('client.ticket', ['order_id' => $order->id])
            ->with('order_success', "¡Tu orden #{$order->id} para {$tableNumber} ha sido registrada con éxito!");
    }

    /**
     * Pantalla: Ticket de compra con vista imprimible y formato PDF
     */
    public function ticket(int $order_id): View
    {
        if (Auth::user()->isAdmin()) {
            $order = Order::with(['items.product', 'user'])->findOrFail($order_id);
        } else {
            $order = Order::with(['items.product', 'user'])
                ->where('user_id', Auth::id())
                ->findOrFail($order_id);
        }

        $cartCount = Auth::user()->cartItems()->count();
        return view('client.ticket', compact('order', 'cartCount'));
    }

    /**
     * Pantalla 5: Perfil del Usuario e Historial de Pedidos
     */
    public function perfil(): View
    {
        $user = Auth::user();
        $cartCount = $user->cartItems()->count();
        $orders = Order::with(['items.product'])->where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        return view('client.perfil', compact('user', 'cartCount', 'orders'));
    }

    /**
     * Acción: Editar datos completos del perfil con validaciones estrictas
     */
    public function editarPerfil(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u',
            ],
            'apellido' => [
                'nullable',
                'string',
                'max:100',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u',
            ],
            'username' => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                'unique:users,username,'.$user->id,
            ],
            'edad' => [
                'nullable',
                'integer',
                'min:1',
                'max:120',
            ],
            'sexo' => [
                'nullable',
                'in:Masculino,Femenino,Otro',
            ],
            'fecha_nacimiento' => [
                'nullable',
                'date',
            ],
            'telefono' => [
                'nullable',
                'regex:/^[0-9]{10}$/',
            ],
            'localidad' => [
                'nullable',
                'string',
                'max:255',
            ],
            'avatar' => [
                'nullable',
                'string',
                'max:500',
            ],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.regex' => 'El dato ingresado en nombre no corresponde al solicitado. Solo se permiten letras.',
            'apellido.regex' => 'El dato ingresado en apellido no corresponde al solicitado. Solo se permiten letras.',
            'username.required' => 'El nombre de usuario es obligatorio.',
            'username.unique' => 'Este nombre de usuario ya está en uso.',
            'edad.integer' => 'La edad debe ser un número entero.',
            'edad.min' => 'Ingresa una edad válida.',
            'telefono.regex' => 'El teléfono debe contener exactamente 10 dígitos numéricos.',
        ]);

        $user->name = trim($request->name);
        $user->apellido = $request->filled('apellido') ? trim($request->apellido) : null;
        $user->username = trim($request->username);
        $user->edad = $request->filled('edad') ? (int) $request->edad : null;
        $user->sexo = $request->input('sexo');
        $user->fecha_nacimiento = $request->input('fecha_nacimiento');
        $user->telefono = $request->filled('telefono') ? trim($request->telefono) : null;
        $user->localidad = $request->filled('localidad') ? trim($request->localidad) : null;
        if ($request->filled('avatar')) {
            $user->avatar = trim($request->avatar);
        }

        $user->save();

        return redirect()->route('client.perfil')->with('success', '¡Perfil actualizado exitosamente!');
    }

    /**
     * Pantalla 6: Configuración del Cliente
     */
    public function configuracion(): View
    {
        $user = Auth::user();
        $cartCount = $user->cartItems()->count();

        return view('client.configuracion', compact('user', 'cartCount'));
    }
}
