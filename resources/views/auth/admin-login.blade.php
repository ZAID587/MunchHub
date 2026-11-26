<x-guest-layout>
    
    <!-- Selector de Rol Notorio (Cliente vs Administrador) -->
    <div class="grid grid-cols-2 gap-2 p-1.5 bg-slate-100 rounded-2xl mb-6 text-xs font-bold text-center">
        <a href="{{ route('login') }}" class="py-2.5 rounded-xl text-slate-500 hover:text-slate-800 flex items-center justify-center gap-1.5 transition-all">
            <i class="fa-regular fa-user"></i> Soy Cliente
        </a>
        <a href="{{ route('admin.login') }}" class="py-2.5 rounded-xl bg-red-600 text-white shadow-md shadow-red-500/20 flex items-center justify-center gap-1.5 transition-all">
            <i class="fa-solid fa-shield-halved"></i> Soy Administrador
        </a>
    </div>

    <div class="mb-5 text-center">
        <div class="w-12 h-12 bg-red-100 text-red-600 rounded-2xl flex items-center justify-center text-xl mx-auto mb-2 shadow-xs">
            <i class="fa-solid fa-lock"></i>
        </div>
        <h2 class="text-xl font-extrabold text-slate-900">Acceso Administrativo</h2>
        <p class="text-xs text-slate-500 mt-1">Exclusivo para gestion de cocina, pedidos y catalogo de alimentos.</p>
    </div>

    @if($errors->any())
        <div class="mb-4 p-3.5 bg-red-50 border border-red-200 rounded-xl text-xs text-red-700">
            <div class="font-bold flex items-center gap-1.5 mb-1">
                <i class="fa-solid fa-circle-exclamation text-red-600"></i> Acceso denegado:
            </div>
            <ul class="list-disc pl-5 space-y-0.5 text-[11px]">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4 text-xs">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block font-bold text-slate-700 mb-1">Correo de Administrador:</label>
            <div class="relative">
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       placeholder="admin@MunchHub.com"
                       class="w-full pl-10 pr-3.5 py-3 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-red-500 focus:outline-none bg-slate-50 focus:bg-white text-slate-800">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
            </div>
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block font-bold text-slate-700 mb-1">Contraseña:</label>
            <div class="relative">
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       placeholder="••••••••"
                       class="w-full pl-10 pr-3.5 py-3 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-red-500 focus:outline-none bg-slate-50 focus:bg-white text-slate-800">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-key"></i>
                </div>
            </div>
        </div>

        <!-- CODIGO DE SEGURIDAD ESPECIAL DE ADMINISTRADOR -->
        <div class="p-3.5 bg-red-50/60 rounded-2xl border border-red-200/80 space-y-1.5">
            <div class="flex items-center justify-between">
                <label for="admin_code" class="block font-extrabold text-red-900 text-xs flex items-center gap-1.5">
                    <i class="fa-solid fa-shield-halved text-red-600"></i> Código Especial de Administrador: *
                </label>
                <span class="text-[10px] bg-red-100 text-red-800 px-2 py-0.5 rounded-full font-bold">PIN de Seguridad</span>
            </div>
            
            <div class="relative">
                <input id="admin_code" type="password" name="admin_code" required maxlength="10" placeholder="••••"
                       class="w-full pl-10 pr-3.5 py-2.5 rounded-xl border border-red-300 text-xs font-mono tracking-widest text-slate-800 bg-white focus:ring-2 focus:ring-red-500 focus:outline-none">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-red-400">
                    <i class="fa-solid fa-fingerprint"></i>
                </div>
            </div>
            <p class="text-[10px] text-red-700">
                Se requiere el PIN numérico de seguridad confidencial para autorizar el ingreso al panel administrativo.
            </p>
        </div>

        <!-- Boton Iniciar Sesion como Admin -->
        <button type="submit" class="w-full py-3.5 bg-red-600 hover:bg-red-700 text-white font-extrabold text-xs rounded-xl shadow-lg shadow-red-600/30 transition-all flex items-center justify-center gap-2">
            <i class="fa-solid fa-shield-check"></i> Validar Acceso como Administrador
        </button>

        <div class="border-t border-slate-100 pt-3 text-center">
            <a href="{{ route('login') }}" class="text-xs font-bold text-slate-500 hover:text-orange-600 transition-colors">
                ← Regresar al login de clientes
            </a>
        </div>

    </form>
</x-guest-layout>
