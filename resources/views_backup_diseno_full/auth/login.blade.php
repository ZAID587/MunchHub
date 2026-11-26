<x-guest-layout>
    
    <!-- Selector de Rol Notorio (Cliente vs Administrador) -->
    <div class="grid grid-cols-2 gap-2 p-1.5 bg-slate-100 rounded-2xl mb-6 text-xs font-bold text-center">
        <a href="{{ route('login') }}" class="py-2.5 rounded-xl bg-white text-orange-600 shadow-sm flex items-center justify-center gap-1.5 transition-all">
            <i class="fa-regular fa-user"></i> Soy Cliente
        </a>
        <a href="{{ route('admin.login') }}" class="py-2.5 rounded-xl text-slate-500 hover:text-slate-800 flex items-center justify-center gap-1.5 transition-all">
            <i class="fa-solid fa-lock text-red-500"></i> Soy Administrador
        </a>
    </div>

    <div class="mb-5 text-center">
        <h2 class="text-xl font-extrabold text-slate-900">Iniciar Sesion</h2>
        <p class="text-xs text-slate-500 mt-1">Ingresa tus credenciales para ordenar y ver tus pedidos.</p>
    </div>

    <!-- Estado de Sesion -->
    <x-auth-session-status class="mb-4 text-xs font-bold text-emerald-600 bg-emerald-50 p-3 rounded-xl border border-emerald-200" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4 text-xs">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block font-bold text-slate-700 mb-1">Correo Electronico:</label>
            <div class="relative">
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       placeholder="tu_correo@ejemplo.com"
                       class="w-full pl-10 pr-3.5 py-3 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-orange-500 focus:outline-none bg-slate-50 focus:bg-white text-slate-800">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-regular fa-envelope"></i>
                </div>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-red-600 text-[11px]" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1">
                <label for="password" class="block font-bold text-slate-700">Contraseña:</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-[11px] font-semibold text-orange-600 hover:underline">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>
            <div class="relative">
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       placeholder="••••••••"
                       class="w-full pl-10 pr-3.5 py-3 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-orange-500 focus:outline-none bg-slate-50 focus:bg-white text-slate-800">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-lock"></i>
                </div>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-red-600 text-[11px]" />
        </div>

        <!-- Código PIN Especial para Administrador -->
        <div class="p-3 bg-amber-50/80 rounded-xl border border-amber-200">
            <label for="admin_code" class="block font-bold text-amber-900 mb-1 flex items-center justify-between">
                <span><i class="fa-solid fa-shield-halved text-amber-600 mr-1"></i> Código PIN (Solo Administradores):</span>
                <span class="text-[10px] text-amber-700 font-semibold">Obligatorio si eres Admin</span>
            </label>
            <input id="admin_code" type="password" name="admin_code" maxlength="10"
                   placeholder="Ingresa tu PIN (ej: 1720)"
                   class="w-full px-3 py-2 rounded-lg border border-amber-200 text-xs focus:ring-2 focus:ring-amber-500 focus:outline-none bg-white font-mono text-slate-800">
            <x-input-error :messages="$errors->get('admin_code')" class="mt-1 text-red-600 text-[11px]" />
        </div>

        <!-- Recordarme -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-slate-300 text-orange-600 focus:ring-orange-500 text-xs">
                <span class="ml-2 text-[11px] text-slate-600 font-medium">Recordar sesion</span>
            </label>
        </div>

        <!-- Boton Iniciar Sesion -->
        <button type="submit" class="w-full py-3.5 bg-orange-600 hover:bg-orange-700 text-white font-extrabold text-xs rounded-xl shadow-lg shadow-orange-600/30 transition-all flex items-center justify-center gap-2">
            <i class="fa-solid fa-arrow-right-to-bracket"></i> Entrar a mi Cuenta
        </button>

        <!-- Registro Link -->
        <div class="border-t border-slate-100 pt-4 text-center">
            <p class="text-xs text-slate-500">
                ¿Aun no tienes cuenta? 
                <a href="{{ route('register') }}" class="font-extrabold text-orange-600 hover:underline ml-1">
                    Crear cuenta gratis
                </a>
            </p>
        </div>

    </form>
</x-guest-layout>
