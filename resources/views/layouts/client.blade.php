<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Menu y Catalogo') - MunchHub</title>

    <!-- Fuentes Google: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Leaflet Maps CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- Tailwind CSS CDN Fallback -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
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

        /* Alto Contraste y Legibilidad Superior para Modo Oscuro */
        html.dark body {
            background-color: #0b0f19 !important;
            color: #f8fafc !important;
        }
        html.dark .bg-white {
            background-color: #151d30 !important;
            color: #f8fafc !important;
            border-color: #27354f !important;
        }
        html.dark .text-slate-900, 
        html.dark .text-slate-800, 
        html.dark .text-slate-700 {
            color: #f8fafc !important;
        }
        html.dark .text-slate-600, 
        html.dark .text-slate-500 {
            color: #cbd5e1 !important;
        }
        html.dark .text-slate-400 {
            color: #94a3b8 !important;
        }
        html.dark .bg-slate-50, 
        html.dark .bg-slate-100 {
            background-color: #0f172a !important;
            border-color: #27354f !important;
        }
        html.dark .border-slate-100, 
        html.dark .border-slate-200 {
            border-color: #27354f !important;
        }
        html.dark input, 
        html.dark select, 
        html.dark textarea {
            background-color: #0b0f19 !important;
            color: #ffffff !important;
            border-color: #3b4c6e !important;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col antialiased selection:bg-orange-500 selection:text-white">

    <!-- Toast de Validacion Estricta Flotante -->
    <div id="validation-toast" class="fixed top-5 left-1/2 -translate-x-1/2 z-50 hidden toast-notification max-w-md w-11/12 bg-amber-500 text-slate-950 font-bold px-5 py-3 rounded-2xl shadow-2xl border-2 border-amber-600 flex items-center gap-3">
        <i class="fa-solid fa-triangle-exclamation text-xl shrink-0"></i>
        <span id="validation-toast-msg" class="text-xs sm:text-sm">⚠️ El dato que se intenta ingresar no corresponde al solicitado.</span>
    </div>

    <!-- 2. Header Principal con Logo, Buscador y Acciones -->
    <header class="bg-white dark:bg-slate-900 sticky top-0 z-40 border-b border-slate-200 dark:border-slate-800 shadow-sm backdrop-blur-md bg-white/95 dark:bg-slate-900/95 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 gap-4">
                
                <!-- Logo de MunchHub -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0 group">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-orange-600 to-amber-500 flex items-center justify-center text-white text-2xl shadow-md shadow-orange-500/20 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-burger"></i>
                    </div>
                    <div>
                        <span class="text-2xl font-black text-slate-900 dark:text-white tracking-tight flex items-center gap-1">
                            Munch<span class="text-orange-600">Hub</span>
                        </span>
                        <span class="block text-[11px] text-slate-400 font-bold uppercase tracking-wider">Restaurante & Cocina</span>
                    </div>
                </a>

                <!-- Buscador Central -->
                <div class="flex-1 max-w-xl hidden md:block">
                    <form action="{{ route('client.buscar') }}" method="GET" class="relative">
                        <input type="text" 
                               name="q" 
                               value="{{ request('q') }}"
                               placeholder="Buscar pizzas, tortas, tacos, hamburguesas, bebidas, papas..."
                               class="w-full pl-11 pr-24 py-2.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-50 focus:bg-white dark:focus:bg-slate-900 text-slate-800 dark:text-white text-sm rounded-full border border-slate-200 dark:border-slate-700 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all outline-none">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        <button type="submit" class="absolute inset-y-1 right-1 px-4 bg-orange-600 hover:bg-orange-700 text-white text-xs font-bold rounded-full transition-colors flex items-center gap-1.5 shadow-sm">
                            <span>Buscar</span>
                        </button>
                    </form>
                </div>

                <!-- Botones y Acciones Derecha -->
                <div class="flex items-center gap-2.5 sm:gap-3">
                    
                    <!-- Boton Modo Oscuro Rapido -->
                    <button type="button" onclick="toggleAppDarkMode()" title="Alternar modo claro / oscuro"
                            class="p-2.5 rounded-2xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-amber-400 border border-slate-200 dark:border-slate-700 transition-colors">
                        <i class="fa-solid fa-moon dark:hidden text-lg"></i>
                        <i class="fa-solid fa-sun hidden dark:inline text-lg"></i>
                    </button>

                    @auth
                        @if(Auth::user()->isAdmin() || Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" 
                               class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-2 rounded-2xl bg-red-600 hover:bg-red-700 text-white font-extrabold text-xs transition-all shadow-sm">
                                <i class="fa-solid fa-shield-halved"></i> Panel Admin
                            </a>
                        @endif
                    @endauth

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
                            <h4 class="font-bold text-sm">¡Bienvenido a MunchHub! Completa tus datos de entrega</h4>
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

    <!-- 4. Footer Completo Responsivo y Limpio -->
    <footer class="bg-slate-900 text-slate-300 pt-14 pb-8 border-t border-slate-800 mt-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">
                
                <!-- Columna 1: Presentacion y Redes Sociales -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-orange-600 flex items-center justify-center text-white text-xl">
                            <i class="fa-solid fa-burger"></i>
                        </div>
                        <span class="text-2xl font-black text-white tracking-tight">
                            Munch<span class="text-orange-500">Hub</span>
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Tu comida favorita preparada al momento con ingredientes frescos, masa artesanal y el mejor sazón. Entregas en mostrador, mesas y a domicilio.
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
                        <li><a href="{{ route('legal.terminos') }}" class="hover:text-orange-400 transition-colors">Términos del Servicio</a></li>
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

                <!-- Columna 4: Contacto y Ubicacion Almoloya de Juarez -->
                <div class="space-y-3">
                    <h4 class="text-xs font-black uppercase tracking-wider text-white">Contacto & Ubicacion</h4>
                    <div class="space-y-2.5 text-xs text-slate-400">
                        <div class="flex items-start gap-2.5">
                            <i class="fa-solid fa-location-dot text-orange-500 mt-0.5 shrink-0"></i>
                            <div>
                                <strong class="text-slate-200 block">Restaurante MunchHub</strong>
                                <span>Almoloya de Juárez, Estado de México, C.P. 50900</span>
                                <a href="https://maps.app.goo.gl/DEyWRCGTGaW64gA89" target="_blank" class="block text-orange-400 hover:underline text-[11px] mt-0.5">
                                    <i class="fa-solid fa-map-location-dot"></i> Ver en Google Maps
                                </a>
                            </div>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-phone text-emerald-400 shrink-0"></i>
                            <a href="tel:7228391022" class="hover:text-white transition-colors">722 839 1022</a>
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

            <!-- Metodos de Pago Aceptados -->
            <div class="pt-6 border-t border-slate-800 flex flex-wrap items-center justify-between gap-4">
                <div>
                    <span class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wider">Metodos de Pago Aceptados:</span>
                    <div class="flex flex-wrap items-center gap-2 text-xs">
                        <span class="px-3 py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-slate-300 font-bold flex items-center gap-1.5">
                            <i class="fa-solid fa-building-columns text-emerald-400"></i> BBVA Transferencia (SPEI)
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
            </div>

            <!-- Copyright y Legales Oficiales -->
            <div class="pt-6 mt-6 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <p>&copy; 2026 MunchHub Restaurante. Todos los derechos reservados. Desarrollado para la comunidad UPVT.</p>
                <div class="flex items-center gap-4">
                    <a href="{{ route('legal.terminos') }}" class="hover:text-slate-300 transition-colors">Términos y Condiciones</a>
                    <span>&bull;</span>
                    <a href="{{ route('legal.privacidad') }}" class="hover:text-slate-300 transition-colors">Aviso de Privacidad</a>
                </div>
            </div>

        </div>
    </footer>

    <!-- Scripts de Validacion Estricta y Toast Global -->
    <script>
        function toggleAppDarkMode() {
            var html = document.documentElement;
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.setItem('MunchHub_theme', 'light');
            } else {
                html.classList.add('dark');
                localStorage.setItem('MunchHub_theme', 'dark');
            }
        }

        if (localStorage.getItem('MunchHub_theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }

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
