@extends('layouts.admin')

@section('title', 'Configuracion del Sistema y Restaurante')

@section('content')
<div class="space-y-8 max-w-4xl mx-auto">

    <!-- Encabezado -->
    <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-700 pb-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white flex items-center gap-2">
                <i class="fa-solid fa-gear text-red-600"></i> Configuracion del Sistema
            </h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Administra el PIN confidencial de acceso, datos operativos del local y preferencias de apariencia.</p>
        </div>
        <span class="px-3 py-1 rounded-full text-xs font-black bg-red-100 text-red-800 dark:bg-red-950/70 dark:text-red-300 uppercase">
            Administrador Master
        </span>
    </div>

    <!-- 1. GESTION DEL CODIGO ESPECIAL DE SEGURIDAD ADMIN (PIN SECRETO) -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl border-2 border-red-200 dark:border-red-900/50 p-6 sm:p-8 shadow-sm space-y-4">
        <div class="flex items-center gap-3 border-b border-slate-100 dark:border-slate-700 pb-4">
            <div class="w-12 h-12 rounded-2xl bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400 flex items-center justify-center text-xl shadow-xs">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <div>
                <h2 class="text-base font-black text-slate-900 dark:text-white">Codigo Especial de Administrador</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">PIN numérico privado que autoriza el acceso a la cuenta de administración.</p>
            </div>
        </div>

        <form action="{{ route('admin.configuracion.actualizar') }}" method="POST" class="space-y-4 text-xs">
            @csrf
            
            <div class="max-w-md">
                <label class="block font-bold text-slate-700 dark:text-slate-200 mb-1 uppercase tracking-wider text-[11px]">
                    PIN Confidencial de Administrador: *
                </label>
                <div class="relative">
                    <input type="password" name="admin_code" id="adminCodeInput" 
                           placeholder="••••" maxlength="10"
                           class="w-full pl-10 pr-4 py-3 rounded-xl border border-red-300 font-mono text-base font-bold tracking-widest text-slate-900 dark:text-white bg-red-50/30 dark:bg-slate-900 focus:bg-white focus:ring-2 focus:ring-red-500 focus:outline-none">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-red-500">
                        <i class="fa-solid fa-key"></i>
                    </div>
                </div>
                <span class="text-[10px] text-slate-400 mt-1.5 block">
                    Solo ingresa un nuevo número si deseas cambiarlo. Déjalo en blanco para conservar el actual.
                </span>
            </div>

            <button type="submit" class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-extrabold rounded-xl shadow-md transition-all flex items-center gap-2">
                <i class="fa-solid fa-check"></i> Actualizar PIN de Administrador
            </button>
        </form>
    </div>

    <!-- 2. DATOS EDITABLES DEL RESTAURANTE Y LOCAL (UPVT) -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 p-6 sm:p-8 shadow-sm space-y-4 text-xs">
        <div class="border-b border-slate-100 dark:border-slate-700 pb-3 flex items-center justify-between">
            <h2 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                <i class="fa-solid fa-shop text-orange-600"></i> Informacion del Restaurante MunchHub
            </h2>
            <span class="text-[11px] text-slate-400">Datos visibles para clientes y tickets</span>
        </div>

        <form action="{{ route('admin.configuracion.actualizar') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                
                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Ubicación / Dirección Central:</label>
                    <input type="text" name="restaurant_address" value="{{ old('restaurant_address', $restaurantAddress) }}"
                           placeholder="Ej: Universidad Politécnica del Valle de Toluca (UPVT)..."
                           class="w-full p-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-white text-xs focus:ring-2 focus:ring-orange-500 focus:outline-none">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Teléfono de Contacto:</label>
                    <input type="text" name="restaurant_phone" value="{{ old('restaurant_phone', $restaurantPhone) }}"
                           placeholder="Ej: 722 839 1022"
                           class="w-full p-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-white text-xs focus:ring-2 focus:ring-orange-500 focus:outline-none">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Correo Electrónico Oficial:</label>
                    <input type="email" name="restaurant_email" value="{{ old('restaurant_email', $restaurantEmail) }}"
                           placeholder="Ej: zaidmed587@gmail.com"
                           class="w-full p-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-white text-xs focus:ring-2 focus:ring-orange-500 focus:outline-none">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Horario de Operación:</label>
                    <input type="text" name="restaurant_schedule" value="{{ old('restaurant_schedule', $restaurantSchedule) }}"
                           placeholder="Ej: Lunes a Sábado: 10:00 AM - 10:00 PM"
                           class="w-full p-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-white text-xs focus:ring-2 focus:ring-orange-500 focus:outline-none">
                </div>

            </div>

            <button type="submit" class="px-6 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-extrabold rounded-xl shadow-md transition-all flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Guardar Cambios del Restaurante
            </button>
        </form>
    </div>

    <!-- 3. PREFERENCIAS DE APARIENCIA (MODO OSCURO FUNCIONAL) -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 p-6 sm:p-8 shadow-sm space-y-4 text-xs">
        <h2 class="text-base font-black text-slate-900 dark:text-white border-b border-slate-100 dark:border-slate-700 pb-3 flex items-center gap-2">
            <i class="fa-solid fa-circle-half-stroke text-purple-600"></i> Preferencia de Apariencia
        </h2>

        <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-purple-100 dark:bg-purple-900/40 text-purple-600 dark:text-purple-300 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-moon"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 dark:text-white text-xs">Modo Oscuro (Dark Theme)</h3>
                    <p class="text-[11px] text-slate-400">Alterna entre tema claro y tema oscuro para descanso visual.</p>
                </div>
            </div>

            <button type="button" id="toggleDarkModeBtn" onclick="toggleAppDarkMode()" class="px-4 py-2 bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 text-slate-800 dark:text-white font-extrabold rounded-xl transition-all flex items-center gap-2">
                <i class="fa-solid fa-lightbulb"></i> <span id="darkModeStatusLabel">Activar Modo Oscuro</span>
            </button>
        </div>
    </div>

</div>

@push('scripts')
<script>
    function updateDarkModeLabel() {
        var isDark = document.documentElement.classList.contains('dark');
        var label = document.getElementById('darkModeStatusLabel');
        if (label) {
            label.textContent = isDark ? 'Modo Claro (Desactivar)' : 'Activar Modo Oscuro';
        }
    }

    function toggleAppDarkMode() {
        var html = document.documentElement;
        if (html.classList.contains('dark')) {
            html.classList.remove('dark');
            localStorage.setItem('MunchHub_theme', 'light');
        } else {
            html.classList.add('dark');
            localStorage.setItem('MunchHub_theme', 'dark');
        }
        updateDarkModeLabel();
    }

    document.addEventListener('DOMContentLoaded', function () {
        if (localStorage.getItem('MunchHub_theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
        updateDarkModeLabel();
    });
</script>
@endpush
@endsection