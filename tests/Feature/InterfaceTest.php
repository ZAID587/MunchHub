<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InterfaceTest extends TestCase
{
    use RefreshDatabase;

    protected User $client;
    protected User $admin;
    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = User::create([
            'name' => 'Juan Sanches',
            'email' => 'juansanc09@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'cliente',
            'edad' => 18,
        ]);

        $this->admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->product = Product::create([
            'name' => 'Pizza',
            'category' => 'Pizza',
            'price' => 120.00,
            'stars' => 4,
            'prep_time' => '15-20 min',
            'short_description' => 'Pizza artesanal con pepperoni',
            'description' => 'Masa tradicional fermentada a fuego lento',
            'image' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591',
            'is_best_seller' => true,
        ]);

        $order = Order::create([
            'user_id' => $this->client->id,
            'table_number' => 'Mesa 1',
            'total' => 120.00,
            'status' => 'en_preparacion',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $this->product->id,
            'quantity' => 1,
            'price' => 120.00,
        ]);
    }

    public function test_cliente_puede_ver_inicio_lo_mas_vendido(): void
    {
        $response = $this->actingAs($this->client)->get(route('client.inicio', absolute: false));

        $response->assertStatus(200);
        $response->assertSee('Lo más vendido.');
        $response->assertSee('Inicio');
        $response->assertSee('Buscar');
        $response->assertSee('Carrito');
        $response->assertSee('Perfil');
        $response->assertSee('Ver +');
    }

    public function test_cliente_puede_ver_buscar(): void
    {
        $response = $this->actingAs($this->client)->get(route('client.buscar', absolute: false));

        $response->assertStatus(200);
        $response->assertSee('¿Qué estás buscando?');
    }

    public function test_cliente_puede_ver_platillo_detalle(): void
    {
        $response = $this->actingAs($this->client)->get(route('client.platillo', $this->product->id, absolute: false));

        $response->assertStatus(200);
        $response->assertSee('Platillo');
        $response->assertSee('Agregar');
        $response->assertSee('Nota para prepararlo');
        $response->assertSee('Descripción');
    }

    public function test_cliente_puede_ver_carrito(): void
    {
        $response = $this->actingAs($this->client)->get(route('client.carrito', absolute: false));

        $response->assertStatus(200);
        $response->assertSee('Carrito');
        $response->assertSee('Eliminar');
        $response->assertSee('Pagar');
    }

    public function test_cliente_puede_ver_perfil(): void
    {
        $response = $this->actingAs($this->client)->get(route('client.perfil', absolute: false));

        $response->assertStatus(200);
        $response->assertSee('Perfil');
        $response->assertSee('Configuración');
        $response->assertSee('Juan Sanches');
        $response->assertSee('+ Editar perfil');
        $response->assertSee('( Cambiar contraseña )');
    }

    public function test_cliente_puede_ver_configuracion(): void
    {
        $response = $this->actingAs($this->client)->get(route('client.configuracion', absolute: false));

        $response->assertStatus(200);
        $response->assertSee('Configuración');
        $response->assertSee('Preferencias');
        $response->assertSee('Notificaciones');
        $response->assertSee('Datos de la cuenta');
        $response->assertSee('Tema');
        $response->assertSee('Eliminar la cuenta');
        $response->assertSee('Cerrar sesión');
    }

    public function test_admin_puede_ver_pedidos_a_realizar(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.pedidos', absolute: false));

        $response->assertStatus(200);
        $response->assertSee('Admin');
        $response->assertSee('Pedidos a realizar');
        $response->assertSee('Mesa 1');
        $response->assertSee('Pedidos');
        $response->assertSee('Productos');
    }

    public function test_admin_puede_ver_catalogo_productos(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.productos', absolute: false));

        $response->assertStatus(200);
        $response->assertSee('Productos');
        $response->assertSee('Editar');
        $response->assertSee('Pizza');
    }

    public function test_admin_puede_ver_formulario_editar_producto(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.productos.editar', $this->product->id, absolute: false));

        $response->assertStatus(200);
        $response->assertSee('Editar producto');
        $response->assertSee('Guardar');
        $response->assertSee('Nombre:');
        $response->assertSee('Precio ($):');
        $response->assertSee('Descripción');
    }

    public function test_cliente_no_puede_entrar_a_admin(): void
    {
        $response = $this->actingAs($this->client)->get(route('admin.pedidos', absolute: false));

        $response->assertRedirect(route('client.inicio', absolute: false));
    }
}
