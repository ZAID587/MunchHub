@extends('layouts.client')

@section('title', 'Configuracion y Preferencias')

@section('content')
<div class="space-y-8 max-w-2xl mx-auto py-6">

    <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-700 pb-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('client.perfil') }}" class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 flex items-center justify-center font-bold text-sm shadow-xs transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-black text-slate-900 dark:text-white">Ajustes y Configuracion</h1>
                <p class="text-xs text-slate-500 dark:text-slate-400">Personaliza tus preferencias de cuenta, seguridad y apariencia.</p>
            </div>
        </div>
    </div>

    <!-- Lista de Opciones Funcionales -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 divide-y divide-slate-100 dark:divide-slate-700 shadow-sm overflow-hidden text-xs">
        
        <!-- Opcion 1: Mi Perfil -->
        <a href="{{ route('client.perfil') }}" class="p-5 flex items-center justify-between hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-orange-100 dark:bg-orange-900/40 text-orange-600 dark:text-orange-300 flex items-center justify-center text-base">
                    <i class="fa-regular fa-user"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 dark:text-white text-xs">Datos Personales y de Entrega</h3>
                    <p class="text-[11px] text-slate-400">Nombre, teléfono, localidad y foto de perfil</p>
                </div>
            </div>
            <i class="fa-solid fa-chevron-right text-slate-300"></i>
        </a>

        <!-- Opcion 2: Historial de Compras -->
        <a href="{{ route('client.perfil') }}#historial" class="p-5 flex items-center justify-between hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-300 flex items-center justify-center text-base">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 dark:text-white text-xs">Historial de Compras y Tickets</h3>
                    <p class="text-[11px] text-slate-400">Ver e imprimir comprobantes de compras anteriores</p>
                </div>
            </div>
            <i class="fa-solid fa-chevron-right text-slate-300"></i>
        </a>

        <!-- Opcion 3: Seguridad y Contraseña -->
        <a href="{{ route('profile.edit') }}" class="p-5 flex items-center justify-between hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-purple-100 dark:bg-purple-900/40 text-purple-600 dark:text-purple-300 flex items-center justify-center text-base">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 dark:text-white text-xs">Seguridad y Contraseña</h3>
                    <p class="text-[11px] text-slate-400">Actualizar clave encriptada (Bcrypt) y cierre de sesiones</p>
                </div>
            </div>
            <i class="fa-solid fa-chevron-right text-slate-300"></i>
        </a>

        <!-- Opcion 4: Modo Oscuro Funcional -->
        <div class="p-5 flex items-center justify-between">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-indigo-100 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-300 flex items-center justify-center text-base">
                    <i class="fa-solid fa-moon"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 dark:text-white text-xs">Modo Oscuro</h3>
                    <p class="text-[11px] text-slate-400">Cambiar a tonos oscuros para mayor comodidad visual</p>
                </div>
            </div>
            <button type="button" onclick="toggleAppDarkMode()" class="px-3.5 py-1.5 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 font-extrabold rounded-xl transition-all">
                <span id="clientDarkModeBtn">Alternar</span>
            </button>
        </div>

        <!-- Opcion 5: Avisos Legales -->
        <div class="p-5 flex items-center justify-between">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 flex items-center justify-center text-base">
                    <i class="fa-solid fa-scale-balanced"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 dark:text-white text-xs">Políticas y Privacidad</h3>
                    <div class="flex items-center gap-2 mt-0.5 text-[11px]">
                        <a href="{{ route('legal.terminos') }}" class="text-orange-600 hover:underline">Términos y Condiciones</a>
                        <span class="text-slate-400">&bull;</span>
                        <a href="{{ route('legal.privacidad') }}" class="text-orange-600 hover:underline">Aviso de Privacidad</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Opcion 6: Cerrar Sesion -->
        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button type="submit" class="w-full p-5 flex items-center justify-between hover:bg-red-50 dark:hover:bg-red-950/30 text-red-600 transition-colors text-left">
                <div class="flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-red-100 dark:bg-red-900/40 text-red-600 flex items-center justify-center text-base">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-red-600 text-xs">Cerrar Sesion</h3>
                        <p class="text-[11px] text-red-400">Finalizar sesion de manera segura en este dispositivo</p>
                    </div>
                </div>
                <i class="fa-solid fa-chevron-right text-red-300"></i>
            </button>
        </form>

    </div>

</div>

@push('scripts')
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
</script>
@endpush
@endsection