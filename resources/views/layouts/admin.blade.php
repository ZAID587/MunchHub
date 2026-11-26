<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Admin') - MunchHub Administrador</title>

    <!-- Fuentes Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Leaflet Maps CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- Tailwind CDN Fallback -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f1f5f9;
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen flex flex-col font-sans antialiased">

    <!-- Header Administrador Superior Limpio (Estilo Blanco Profesional) -->
    <header class="bg-white text-slate-800 sticky top-0 z-40 shadow-sm border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 gap-4">
                
                <!-- Logo Administrador -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-orange-600 to-amber-500 flex items-center justify-center text-white text-xl shadow-md shadow-orange-500/20 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-burger"></i>
                    </div>
                    <div>
                        <span class="text-xl font-black text-slate-900 tracking-tight flex items-center gap-1.5">
                            Munch<span class="text-orange-600">Hub</span> 
                            <span class="text-[10px] bg-slate-900 text-white px-2 py-0.5 rounded-full uppercase tracking-wider font-extrabold">ADMIN</span>
                        </span>
                        <span class="block text-[11px] text-slate-400 font-semibold tracking-wider uppercase">Gestion de Cocina e Inventario</span>
                    </div>
                </a>

                <!-- Navegacion Principal Admin -->
                <nav class="hidden md:flex items-center space-x-1.5 text-xs font-bold">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="px-4 py-2.5 rounded-xl transition-all flex items-center gap-2 {{ request()->routeIs('admin.dashboard') ? 'bg-orange-600 text-white shadow-md shadow-orange-500/25' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fa-solid fa-chart-pie"></i> Inicio / Metricas
                    </a>

                    <a href="{{ route('admin.pedidos') }}" 
                       class="px-4 py-2.5 rounded-xl transition-all flex items-center gap-2 {{ request()->routeIs('admin.pedidos*') ? 'bg-orange-600 text-white shadow-md shadow-orange-500/25' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fa-solid fa-bell-concierge"></i> Pedidos de Cocina
                    </a>

                    <a href="{{ route('admin.productos') }}" 
                       class="px-4 py-2.5 rounded-xl transition-all flex items-center gap-2 {{ request()->routeIs('admin.productos*') ? 'bg-orange-600 text-white shadow-md shadow-orange-500/25' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fa-solid fa-burger"></i> Catalogo de Alimentos
                    </a>

                    <a href="{{ route('admin.configuracion') }}" 
                       class="px-4 py-2.5 rounded-xl transition-all flex items-center gap-2 {{ request()->routeIs('admin.configuracion*') ? 'bg-orange-600 text-white shadow-md shadow-orange-500/25' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fa-solid fa-gear"></i> Configuracion & PIN
                    </a>
                </nav>

                <!-- Acciones Derecha -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="hidden sm:flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all border border-slate-200" title="Ver Tienda Cliente">
                        <i class="fa-solid fa-store text-orange-600"></i> Tienda
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" title="Cerrar Sesion Admin" class="p-2.5 rounded-xl bg-slate-100 text-slate-500 hover:text-red-600 hover:bg-red-50 border border-slate-200 transition-colors">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        </button>
                    </form>
                </div>

            </div>

            <!-- Navegacion Movil Horizontal -->
            <div class="flex md:hidden items-center justify-between border-t border-slate-100 py-2.5 overflow-x-auto text-xs font-bold gap-2">
                <a href="{{ route('admin.dashboard') }}" class="px-3 py-1.5 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-orange-600 text-white' : 'text-slate-600' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.pedidos') }}" class="px-3 py-1.5 rounded-lg {{ request()->routeIs('admin.pedidos*') ? 'bg-orange-600 text-white' : 'text-slate-600' }}">
                    Pedidos
                </a>
                <a href="{{ route('admin.productos') }}" class="px-3 py-1.5 rounded-lg {{ request()->routeIs('admin.productos*') ? 'bg-orange-600 text-white' : 'text-slate-600' }}">
                    Alimentos
                </a>
                <a href="{{ route('admin.configuracion') }}" class="px-3 py-1.5 rounded-lg {{ request()->routeIs('admin.configuracion*') ? 'bg-orange-600 text-white' : 'text-slate-600' }}">
                    Ajustes
                </a>
            </div>
        </div>
    </header>

    <!-- Alertas Globales -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-emerald-800 bg-emerald-50 rounded-2xl border border-emerald-200 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-bold">&times;</button>
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 mb-4 text-sm text-red-800 bg-red-50 rounded-2xl border border-red-200 shadow-sm">
                <div class="flex items-center gap-2 font-bold mb-1">
                    <i class="fa-solid fa-circle-exclamation text-red-600"></i>
                    <span>Atencion: Por favor corrige los siguientes datos:</span>
                </div>
                <ul class="list-disc pl-7 text-xs space-y-1">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Contenido Principal Administrador -->
    <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 w-full">
        @yield('content')
    </main>

    <!-- Footer Administrador -->
    <footer class="bg-white border-t border-slate-200 py-6 text-slate-500 text-xs text-center mt-12">
        <div class="max-w-7xl mx-auto px-4">
            <p>&copy; {{ date('Y') }} MunchHub • Panel de Control Administrativo Seguro • UPVT</p>
        </div>
    </footer>

    <!-- Scripts de Validacion y Sesion -->
    <script>
        function validateStrictLetters(input, fieldLabel) {
            input.addEventListener('input', function() {
                var original = this.value;
                var cleaned = original.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s\.\-]/g, '');
                if (original !== cleaned) {
                    alert('⚠️ El dato que se intenta ingresar no corresponde al solicitado. En "' + fieldLabel + '" solo se permiten letras (no numeros).');
                    this.value = cleaned;
                }
            });
        }

        function validateStrictNumbers(input, fieldLabel) {
            input.addEventListener('input', function() {
                var original = this.value;
                var cleaned = original.replace(/[^0-9\.]/g, '');
                if (original !== cleaned) {
                    alert('⚠️ El dato que se intenta ingresar no corresponde al solicitado. En "' + fieldLabel + '" solo se permiten numeros.');
                    this.value = cleaned;
                }
            });
        }

        // Sondeo de sesion unica de administrador
        setInterval(function() {
            fetch('{{ route('check.session') }}', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(function(res) {
                if (res.status === 401 || res.status === 419) {
                    alert('⚠️ Atencion: Sesion de administrador invalidada o iniciada en otro dispositivo.');
                    window.location.href = '{{ route('admin.login') }}';
                }
                return res.json();
            })
            .then(function(data) {
                if (data && data.authenticated === false) {
                    alert('⚠️ Atencion: Sesion de administrador invalidada o iniciada en otro dispositivo.');
                    window.location.href = '{{ route('admin.login') }}';
                }
            })
            .catch(function(err) {
                console.log('Error sesion admin:', err);
            });
        }, 5000);
    </script>

    <script>
        if (localStorage.getItem('MunchHub_theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>

    @stack('scripts')
</body>
</html>
