<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Menu y Catalogo') - Happyfood</title>

    <!-- Fuentes Google: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS CDN Fallback -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            background-color: #f8fafc;
        }
        .toast-notification {
            animation: slideInDown 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        @keyframes slideInDown {
            from { transform: translate(-50%, -100%); opacity: 0; }
            to { transform: translate(-50%, 0); opacity: 1; }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col antialiased selection:bg-orange-500 selection:text-white">

    <!-- Toast de Validacion Estricta Flotante -->
    <div id="validation-toast" class="fixed top-5 left-1/2 -translate-x-1/2 z-50 hidden toast-notification max-w-md w-11/12 bg-amber-500 text-slate-950 font-bold px-5 py-3 rounded-2xl shadow-2xl border-2 border-amber-600 flex items-center gap-3">
        <i class="fa-solid fa-triangle-exclamation text-xl shrink-0"></i>
        <span id="validation-toast-msg" class="text-xs sm:text-sm">⚠️ El dato que se intenta ingresar no corresponde al solicitado.</span>
    </div>

    <!-- 1. Barra Superior Informativa (Estilo Buscamed) -->
    <div class="bg-slate-900 text-slate-300 text-xs py-2 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-wrap items-center justify-between gap-2">
            <div class="flex items-center gap-4">
                <span class="inline-flex items-center gap-1.5 text-orange-400 font-semibold">
                    <i class="fa-solid fa-truck-fast"></i> Envios rapidos a zona UPVT y alrededores
                </span>
                <span class="hidden md:inline text-slate-500">|</span>
                <a href="https://wa.me/527227705013?text=Hola%20Zaid,%20tengo%20dudas%20con%20mi%20pedido%20en%20Happyfood" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 text-slate-300 hover:text-emerald-400 transition-colors">
                    <i class="fa-brands fa-whatsapp text-emerald-400"></i> Asistente Zaid: 722 770 5013
                </a>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="hidden lg:flex items-center gap-3 text-[11px] text-slate-400">
                    <span class="flex items-center gap-1"><i class="fa-solid fa-credit-card text-blue-400"></i> Tarjeta</span>
                    <span class="flex items-center gap-1"><i class="fa-solid fa-building-columns text-emerald-400"></i> Transferencia BBVA</span>
                    <span class="flex items-center gap-1"><i class="fa-solid fa-money-bill-wave text-amber-400"></i> Efectivo</span>
                </div>
                
                @auth
                    @if(Auth::user()->isAdmin() || Auth::user()->role === 'admin')
                        <form action="{{ route('cambiar.rol', 'admin') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-600 hover:bg-red-700 text-white font-extrabold text-[11px] transition-all shadow-sm">
                                <i class="fa-solid fa-user-shield"></i> Panel Administrador
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('admin.login') }}" class="text-slate-400 hover:text-white transition-colors text-[11px] flex items-center gap-1 font-semibold">
                        <i class="fa-solid fa-lock text-red-400"></i> Acceso Admin (PIN 1720)
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- 2. Header Principal con Logo, Buscador y Acciones -->
    <header class="bg-white sticky top-0 z-40 border-b border-slate-200 shadow-sm backdrop-blur-md bg-white/95">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 gap-4">
                
                <!-- Logo de Happyfood -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0 group">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-orange-600 to-amber-500 flex items-center justify-center text-white text-2xl shadow-md shadow-orange-500/20 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-burger"></i>
                    </div>
                    <div>
                        <span class="text-2xl font-black text-slate-900 tracking-tight flex items-center gap-1">
                            Happy<span class="text-orange-600">food</span>
                        </span>
                        <span class="block text-[11px] text-slate-400 font-bold uppercase tracking-wider">Restaurante & Cocina</span>
                    </div>
                </a>

                <!-- Buscador Central Estilo Buscamed -->
                <div class="flex-1 max-w-xl hidden md:block">
                    <form action="{{ route('client.buscar') }}" method="GET" class="relative">
                        <input type="text" 
                               name="q" 
                               value="{{ request('q') }}"
                               placeholder="Buscar pizzas, tortas, tacos, hamburguesas, bebidas, papas..."
                               class="w-full pl-11 pr-24 py-2.5 bg-slate-100 hover:bg-slate-50 focus:bg-white text-slate-800 text-sm rounded-full border border-slate-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all outline-none">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        <button type="submit" class="absolute inset-y-1 right-1 px-4 bg-orange-600 hover:bg-orange-700 text-white text-xs font-bold rounded-full transition-colors flex items-center gap-1.5 shadow-sm">
                            <span>Buscar</span>
                        </button>
                    </form>
                </div>

                <!-- Botones y Acciones Derecha -->
                <div class="flex items-center gap-3">
                    
                    <!-- Boton Asistente Zaid WhatsApp -->
                    <a href="https://wa.me/527227705013?text=Hola%20Zaid,%20estoy%20viendo%20el%20menu%20de%20Happyfood%20y%20necesito%20apoyo" 
                       target="_blank"
                       class="hidden lg:flex items-center gap-2.5 px-3.5 py-2 rounded-2xl bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 text-emerald-800 text-xs font-bold transition-all shadow-sm">
                        <div class="relative">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 block animate-pulse"></span>
                        </div>
                        <i class="fa-brands fa-whatsapp text-emerald-600 text-base"></i>
                        <div class="text-left leading-tight">
                            <span class="block text-[10px] text-emerald-600 font-semibold">Ayuda en línea</span>
                            <span>Zaid</span>
                        </div>
                    </a>

                    <!-- Boton Carrito -->
                    @php
                        $totalCartItems = Auth::check() ? Auth::user()->cartItems()->sum('quantity') : 0;
                    @endphp
                    <a href="{{ route('client.carrito') }}" 
                       class="relative p-2.5 rounded-2xl bg-slate-100 hover:bg-orange-50 text-slate-700 hover:text-orange-600 border border-slate-200 hover:border-orange-200 transition-all group"
                       title="Ver Carrito de Compras">
                        <i class="fa-solid fa-cart-shopping text-xl"></i>
                        @if($totalCartItems > 0)
                            <span class="absolute -top-1.5 -right-1.5 w-5 h-5 rounded-full bg-orange-600 text-white text-[11px] font-black flex items-center justify-center shadow-md">
                                {{ $totalCartItems }}
                            </span>
                        @endif
                    </a>

                    <!-- Usuario / Login -->
                    @auth
                        <div class="flex items-center gap-2">
                            <a href="{{ route('client.perfil') }}" 
                               class="flex items-center gap-2 px-3 py-2 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold transition-colors border border-slate-200">
                                <i class="fa-solid fa-circle-user text-orange-600 text-base"></i>
                                <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
                            </a>
                            
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        title="Cerrar sesion"
                                        class="p-2.5 rounded-2xl bg-slate-100 hover:bg-red-50 text-slate-500 hover:text-red-600 border border-slate-200 transition-colors">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <a href="{{ route('login') }}" class="px-4 py-2 text-xs font-bold text-slate-700 hover:text-orange-600 transition-colors">
                                Iniciar Sesion
                            </a>
                            <a href="{{ route('register') }}" class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white text-xs font-bold rounded-2xl shadow-md shadow-orange-600/20 transition-all">
                                Registrarse
                            </a>
                        </div>
                    @endauth

                </div>
            </div>

            <!-- Buscador en Movil -->
            <div class="pb-3 md:hidden">
                <form action="{{ route('client.buscar') }}" method="GET" class="relative">
                    <input type="text" 
                           name="q" 
                           value="{{ request('q') }}"
                           placeholder="Buscar pizzas, tortas, tacos..."
                           class="w-full pl-10 pr-20 py-2 bg-slate-100 text-slate-800 text-xs rounded-xl border border-slate-200 outline-none">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </div>
                    <button type="submit" class="absolute inset-y-1 right-1 px-3 bg-orange-600 text-white text-[11px] font-bold rounded-lg">
                        Buscar
                    </button>
                </form>
            </div>
        </div>

        <!-- Barra de Categorias Rapidas (Estilo Buscamed) -->
        <div class="bg-slate-100/80 border-t border-slate-200 overflow-x-auto scrollbar-none py-2">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center gap-2 sm:gap-4 text-xs font-bold text-slate-600 whitespace-nowrap">
                <a href="{{ route('home') }}" class="px-3 py-1.5 rounded-xl hover:bg-white hover:text-orange-600 transition-colors {{ !request('category') ? 'bg-white text-orange-600 shadow-sm' : '' }}">
                    <i class="fa-solid fa-border-all mr-1"></i> Todo el Menu
                </a>
                <a href="{{ route('home', ['category' => 'Pizzas']) }}" class="px-3 py-1.5 rounded-xl hover:bg-white hover:text-orange-600 transition-colors {{ request('category') === 'Pizzas' ? 'bg-white text-orange-600 shadow-sm' : '' }}">
                    <i class="fa-solid fa-pizza-slice mr-1 text-amber-500"></i> Pizzas
                </a>
                <a href="{{ route('home', ['category' => 'Tortas']) }}" class="px-3 py-1.5 rounded-xl hover:bg-white hover:text-orange-600 transition-colors {{ request('category') === 'Tortas' ? 'bg-white text-orange-600 shadow-sm' : '' }}">
                    <i class="fa-solid fa-bread-slice mr-1 text-orange-500"></i> Tortas
                </a>
                <a href="{{ route('home', ['category' => 'Tacos']) }}" class="px-3 py-1.5 rounded-xl hover:bg-white hover:text-orange-600 transition-colors {{ request('category') === 'Tacos' ? 'bg-white text-orange-600 shadow-sm' : '' }}">
                    <i class="fa-solid fa-utensils mr-1 text-red-500"></i> Tacos
                </a>
                <a href="{{ route('home', ['category' => 'Hamburguesas']) }}" class="px-3 py-1.5 rounded-xl hover:bg-white hover:text-orange-600 transition-colors {{ request('category') === 'Hamburguesas' ? 'bg-white text-orange-600 shadow-sm' : '' }}">
                    <i class="fa-solid fa-burger mr-1 text-amber-600"></i> Hamburguesas
                </a>
                <a href="{{ route('home', ['category' => 'Bebidas']) }}" class="px-3 py-1.5 rounded-xl hover:bg-white hover:text-orange-600 transition-colors {{ request('category') === 'Bebidas' ? 'bg-white text-orange-600 shadow-sm' : '' }}">
                    <i class="fa-solid fa-bottle-water mr-1 text-blue-500"></i> Bebidas
                </a>
                <a href="{{ route('home', ['category' => 'Panadería']) }}" class="px-3 py-1.5 rounded-xl hover:bg-white hover:text-orange-600 transition-colors {{ request('category') === 'Panadería' ? 'bg-white text-orange-600 shadow-sm' : '' }}">
                    <i class="fa-solid fa-wheat-awn mr-1 text-yellow-600"></i> Panadería
                </a>
                <a href="{{ route('home', ['category' => 'Papas']) }}" class="px-3 py-1.5 rounded-xl hover:bg-white hover:text-orange-600 transition-colors {{ request('category') === 'Papas' ? 'bg-white text-orange-600 shadow-sm' : '' }}">
                    <i class="fa-solid fa-bowl-food mr-1 text-amber-500"></i> Papas y Snacks
                </a>
                <a href="{{ route('home', ['category' => 'Postres']) }}" class="px-3 py-1.5 rounded-xl hover:bg-white hover:text-orange-600 transition-colors {{ request('category') === 'Postres' ? 'bg-white text-orange-600 shadow-sm' : '' }}">
                    <i class="fa-solid fa-cake-candles mr-1 text-pink-500"></i> Postres
                </a>
                <a href="{{ route('home', ['category' => 'Cafetería']) }}" class="px-3 py-1.5 rounded-xl hover:bg-white hover:text-orange-600 transition-colors {{ request('category') === 'Cafetería' ? 'bg-white text-orange-600 shadow-sm' : '' }}">
                    <i class="fa-solid fa-mug-hot mr-1 text-amber-800"></i> Cafetería Gardello
                </a>
            </div>
        </div>
    </header>

    <!-- Notificaciones Flash -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div class="p-4 mb-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 mb-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-sm font-semibold flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-red-600 text-lg"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        <!-- Banner de Completar Perfil Si el Usuario es Nuevo -->
        @auth
            @if(method_exists(Auth::user(), 'needsProfileCompletion') && Auth::user()->needsProfileCompletion())
                <div class="p-4 mb-6 rounded-2xl bg-amber-50 border-2 border-amber-300 text-amber-900 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-200 text-amber-800 flex items-center justify-center text-lg shrink-0">
                            <i class="fa-solid fa-address-card"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm">¡Bienvenido a Happyfood! Completa tus datos de entrega</h4>
                            <p class="text-xs text-amber-700">Para procesar tus pedidos necesitamos tu apellido, telefono, fecha de nacimiento y localidad.</p>
                        </div>
                    </div>
                    <a href="{{ route('client.perfil') }}" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold rounded-xl shadow-md transition-colors whitespace-nowrap">
                        Completar Perfil Ahora
                    </a>
                </div>
            @endif
        @endauth
    </div>

    <!-- Contenido Principal -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @yield('content')
    </main>

    <!-- Boton Flotante de Zaid Asistente WhatsApp -->
    <div class="fixed bottom-6 right-6 z-40">
        <a href="https://wa.me/527227705013?text=Hola%20Zaid,%20estoy%20en%20Happyfood%20y%20necesito%20ayuda%20con%20mi%20pedido" 
           target="_blank"
           class="group flex items-center gap-3 bg-emerald-600 hover:bg-emerald-700 text-white p-3.5 sm:px-5 sm:py-3.5 rounded-full shadow-2xl shadow-emerald-600/50 hover:scale-105 transition-all">
            <div class="relative">
                <i class="fa-brands fa-whatsapp text-2xl"></i>
                <span class="absolute -top-1 -right-1 w-3 h-3 bg-white rounded-full flex items-center justify-center">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-ping"></span>
                </span>
            </div>
            <div class="hidden sm:block text-left">
                <span class="block text-[10px] font-bold text-emerald-200 uppercase tracking-wider">Asistente Virtual</span>
                <span class="block text-xs font-extrabold leading-none">Chatear con Zaid</span>
            </div>
        </a>
    </div>

    <!-- 4. Footer Estilo Buscamed Completo (4 Columnas + Certificaciones + Contacto) -->
    <footer class="bg-slate-900 text-slate-300 pt-16 pb-8 border-t border-slate-800 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
                
                <!-- Columna 1: Presentacion y Redes Sociales -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-orange-600 flex items-center justify-center text-white text-xl">
                            <i class="fa-solid fa-burger"></i>
                        </div>
                        <span class="text-2xl font-black text-white tracking-tight">
                            Happy<span class="text-orange-500">food</span>
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Tu comida favorita preparada al momento con ingredientes frescos, masa artesanal y el mejor sazón. Entregas rápidas y seguras.
                    </p>
                    <div class="pt-2">
                        <span class="block text-xs font-bold text-slate-200 mb-2 uppercase tracking-wider">Siguenos en redes:</span>
                        <div class="flex items-center gap-2">
                            <a href="https://facebook.com" target="_blank" class="w-9 h-9 rounded-xl bg-slate-800 hover:bg-blue-600 text-slate-300 hover:text-white flex items-center justify-center transition-colors">
                                <i class="fa-brands fa-facebook-f text-sm"></i>
                            </a>
                            <a href="https://instagram.com" target="_blank" class="w-9 h-9 rounded-xl bg-slate-800 hover:bg-pink-600 text-slate-300 hover:text-white flex items-center justify-center transition-colors">
                                <i class="fa-brands fa-instagram text-sm"></i>
                            </a>
                            <a href="https://tiktok.com" target="_blank" class="w-9 h-9 rounded-xl bg-slate-800 hover:bg-black text-slate-300 hover:text-white flex items-center justify-center transition-colors">
                                <i class="fa-brands fa-tiktok text-sm"></i>
                            </a>
                            <a href="https://wa.me/527227705013" target="_blank" class="w-9 h-9 rounded-xl bg-slate-800 hover:bg-emerald-600 text-slate-300 hover:text-white flex items-center justify-center transition-colors">
                                <i class="fa-brands fa-whatsapp text-sm"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Columna 2: Enlaces Rapidos -->
                <div class="space-y-3">
                    <h4 class="text-xs font-black uppercase tracking-wider text-white">Enlaces Rapidos</h4>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li><a href="{{ route('home') }}" class="hover:text-orange-400 transition-colors">Inicio y Menu Principal</a></li>
                        <li><a href="{{ route('client.buscar') }}" class="hover:text-orange-400 transition-colors">Buscador y Catalogo</a></li>
                        <li><a href="{{ route('client.carrito') }}" class="hover:text-orange-400 transition-colors">Mi Carrito de Compras</a></li>
                        <li><a href="{{ route('client.perfil') }}" class="hover:text-orange-400 transition-colors">Mis Pedidos y Tickets</a></li>
                        <li><a href="https://wa.me/527227705013" target="_blank" class="hover:text-emerald-400 transition-colors">Compra con tu asistente Zaid</a></li>
                    </ul>
                </div>

                <!-- Columna 3: Categorias Populares -->
                <div class="space-y-3">
                    <h4 class="text-xs font-black uppercase tracking-wider text-white">Categorias Populares</h4>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li><a href="{{ route('home', ['category' => 'Pizzas']) }}" class="hover:text-orange-400 transition-colors">Pizzas a la Piedra</a></li>
                        <li><a href="{{ route('home', ['category' => 'Tortas']) }}" class="hover:text-orange-400 transition-colors">Tortas Calientes con Telera</a></li>
                        <li><a href="{{ route('home', ['category' => 'Tacos']) }}" class="hover:text-orange-400 transition-colors">Tacos Tradicionales</a></li>
                        <li><a href="{{ route('home', ['category' => 'Hamburguesas']) }}" class="hover:text-orange-400 transition-colors">Hamburguesas Especiales</a></li>
                        <li><a href="{{ route('home', ['category' => 'Bebidas']) }}" class="hover:text-orange-400 transition-colors">Bebidas y Refrescos Frios</a></li>
                        <li><a href="{{ route('home', ['category' => 'Papas']) }}" class="hover:text-orange-400 transition-colors">Papas Francesas y Sazonadas</a></li>
                    </ul>
                </div>

                <!-- Columna 4: Contacto y Ubicacion UPVT -->
                <div class="space-y-3">
                    <h4 class="text-xs font-black uppercase tracking-wider text-white">Contacto & Ubicacion</h4>
                    <div class="space-y-2.5 text-xs text-slate-400">
                        <div class="flex items-start gap-2.5">
                            <i class="fa-solid fa-location-dot text-orange-500 mt-0.5 shrink-0"></i>
                            <div>
                                <strong class="text-slate-200 block">Universidad Politecnica del Valle de Toluca (UPVT)</strong>
                                <span>Carretera Toluca - Almoloya de Juarez, Km 5.6, Santiaguito Tlalcilalcalli, Edo. Mex.</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-phone text-emerald-400 shrink-0"></i>
                            <a href="tel:7227705013" class="hover:text-white transition-colors">722 770 5013</a>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-envelope text-blue-400 shrink-0"></i>
                            <a href="mailto:zaidmed587@gmail.com" class="hover:text-white transition-colors">zaidmed587@gmail.com</a>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-clock text-amber-400 shrink-0"></i>
                            <span>Lun - Sab: 9:00 AM - 10:00 PM</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Metodos de Pago Aceptados y Certificaciones (Estilo Buscamed) -->
            <div class="pt-8 border-t border-slate-800 grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                <div>
                    <span class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wider">Metodos de Pago Aceptados:</span>
                    <div class="flex flex-wrap items-center gap-2 text-xs">
                        <span class="px-3 py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-slate-300 font-bold flex items-center gap-1.5">
                            <i class="fa-solid fa-building-columns text-emerald-400"></i> BBVA Transferencia (CLABE)
                        </span>
                        <span class="px-3 py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-slate-300 font-bold flex items-center gap-1.5">
                            <i class="fa-brands fa-cc-visa text-blue-400"></i> Visa
                        </span>
                        <span class="px-3 py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-slate-300 font-bold flex items-center gap-1.5">
                            <i class="fa-brands fa-cc-mastercard text-amber-400"></i> Mastercard
                        </span>
                        <span class="px-3 py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-slate-300 font-bold flex items-center gap-1.5">
                            <i class="fa-solid fa-hand-holding-dollar text-green-400"></i> Efectivo al Recibir
                        </span>
                    </div>
                </div>

                <div class="md:text-right">
                    <span class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wider">Distintivos y Garantias:</span>
                    <div class="inline-flex flex-wrap gap-2 text-xs">
                        <span class="px-3 py-1.5 rounded-lg bg-emerald-950/60 border border-emerald-800 text-emerald-300 font-bold flex items-center gap-1.5">
                            <i class="fa-solid fa-shield-halved text-emerald-400"></i> Manejo Higienico de Alimentos
                        </span>
                        <span class="px-3 py-1.5 rounded-lg bg-blue-950/60 border border-blue-800 text-blue-300 font-bold flex items-center gap-1.5">
                            <i class="fa-solid fa-certificate text-blue-400"></i> Sabor 100% Garantizado
                        </span>
                    </div>
                </div>
            </div>

            <!-- Copyright y Legales -->
            <div class="pt-8 mt-8 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <p>&copy; 2026 Happyfood Restaurante. Todos los derechos reservados. Desarrollado para la comunidad UPVT.</p>
                <div class="flex items-center gap-4">
                    <a href="#" class="hover:text-slate-300 transition-colors">Terminos y Condiciones</a>
                    <span>&bull;</span>
                    <a href="#" class="hover:text-slate-300 transition-colors">Aviso de Privacidad</a>
                    <span>&bull;</span>
                    <a href="#" class="hover:text-slate-300 transition-colors">Mapa del Sitio</a>
                </div>
            </div>

        </div>
    </footer>

    <!-- Scripts de Validacion Estricta y Toast Global -->
    <script>
        function showValidationWarning(message) {
            const toast = document.getElementById('validation-toast');
            const msgEl = document.getElementById('validation-toast-msg');
            if (!toast || !msgEl) return;
            msgEl.textContent = message || '⚠️ El dato que se intenta ingresar no corresponde al solicitado.';
            toast.classList.remove('hidden');
            clearTimeout(window.__vToastTimeout);
            window.__vToastTimeout = setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
        }

        // Validar estrictamente letras (nombres, apellidos, comentarios)
        function validateStrictLetters(event) {
            const char = String.fromCharCode(event.which || event.keyCode);
            // Permitir letras acentuadas, espacios y teclas de control
            if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]$/.test(char) && event.keyCode > 31) {
                event.preventDefault();
                showValidationWarning('⚠️ Solo se permiten letras en este campo.');
                return false;
            }
            return true;
        }

        // Validar estrictamente numeros (telefonos, edad, precios, codigos)
        function validateStrictNumbers(event) {
            const char = String.fromCharCode(event.which || event.keyCode);
            if (!/^[0-9]$/.test(char) && event.keyCode > 31) {
                event.preventDefault();
                showValidationWarning('⚠️ Solo se permiten números en este campo.');
                return false;
            }
            return true;
        }
    </script>
    
    @stack('scripts')
</body>
</html>
