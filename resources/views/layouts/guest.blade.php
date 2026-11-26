<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Acceso') - MunchHub Restaurante</title>

    <!-- Fuentes Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CDN Fallback -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-900 text-slate-800 min-h-screen flex items-center justify-center p-4 relative overflow-x-hidden">

    <!-- Fondo de comida con superposicion elegante -->
    <div class="fixed inset-0 bg-cover bg-center opacity-25" 
         style="background-image: url('https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=1600&auto=format&fit=crop&q=80');">
    </div>
    <div class="fixed inset-0 bg-gradient-to-t from-slate-950 via-slate-900/90 to-slate-900/70"></div>

    <div class="relative z-10 w-full max-w-md my-8">
        
        <!-- Logo y Regreso a Inicio -->
        <div class="text-center mb-6">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-amber-500 to-orange-600 flex items-center justify-center text-white text-xl shadow-lg shadow-orange-500/30 group-hover:scale-105 transition-transform">
                    <i class="fa-solid fa-utensils"></i>
                </div>
                <div class="text-left">
                    <span class="text-2xl font-black text-white tracking-tight flex items-center gap-1">
                        Happy<span class="text-orange-500">food</span>
                    </span>
                    <span class="block text-[10px] text-slate-300 font-semibold tracking-wider uppercase">Restaurante & Sabores</span>
                </div>
            </a>
        </div>

        <!-- Tarjeta de Contenido -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-2xl border border-white/20">
            {{ $slot }}
        </div>

        <!-- Regreso al menu -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-xs font-bold text-slate-300 hover:text-orange-400 transition-colors inline-flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-left"></i> Volver al Menu Principal
            </a>
        </div>

    </div>

    @stack('scripts')
</body>
</html>
