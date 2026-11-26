<x-guest-layout>
    <div class="mb-5 text-center">
        <h2 class="text-xl font-extrabold text-slate-900">Crear Nueva Cuenta</h2>
        <p class="text-xs text-slate-500 mt-1">Registrate para guardar tus pedidos, tickets y calificar platillos.</p>
    </div>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl text-xs text-red-700">
            <div class="font-bold mb-1 flex items-center gap-1.5">
                <i class="fa-solid fa-circle-exclamation text-red-600"></i> Por favor revisa tus datos:
            </div>
            <ul class="list-disc pl-5 space-y-0.5 text-[11px]">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" id="registerForm" class="space-y-4 text-xs">
        @csrf

        <!-- Nombre de la Persona -->
        <div>
            <label for="name" class="block font-bold text-slate-700 mb-1">Nombre (Solo letras): *</label>
            <div class="relative">
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                       placeholder="Ej: Zaid Juan"
                       class="w-full pl-10 pr-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-orange-500 focus:outline-none bg-slate-50 focus:bg-white text-slate-800">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-regular fa-user"></i>
                </div>
            </div>
        </div>

        <!-- Apellido de la Persona -->
        <div>
            <label for="apellido" class="block font-bold text-slate-700 mb-1">Apellidos (Solo letras):</label>
            <div class="relative">
                <input id="apellido" type="text" name="apellido" value="{{ old('apellido') }}"
                       placeholder="Ej: Medina Sanchez"
                       class="w-full pl-10 pr-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-orange-500 focus:outline-none bg-slate-50 focus:bg-white text-slate-800">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-regular fa-id-card"></i>
                </div>
            </div>
        </div>

        <!-- Nombre de Usuario (Username) -->
        <div>
            <label for="username" class="block font-bold text-slate-700 mb-1">Nombre de Usuario (Username personal): *</label>
            <div class="relative">
                <input id="username" type="text" name="username" value="{{ old('username') }}" required
                       placeholder="zaid_comensal"
                       class="w-full pl-10 pr-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-orange-500 focus:outline-none bg-slate-50 focus:bg-white text-slate-800 font-mono">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-at"></i>
                </div>
            </div>
        </div>

        <!-- Correo Electronico -->
        <div>
            <label for="email" class="block font-bold text-slate-700 mb-1">Correo Electronico: *</label>
            <div class="relative">
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                       placeholder="tu_correo@ejemplo.com"
                       class="w-full pl-10 pr-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-orange-500 focus:outline-none bg-slate-50 focus:bg-white text-slate-800">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-regular fa-envelope"></i>
                </div>
            </div>
        </div>

        <!-- Contraseña -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label for="password" class="block font-bold text-slate-700 mb-1">Contraseña: *</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                       placeholder="Min. 8 caracteres"
                       class="w-full p-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-orange-500 focus:outline-none bg-slate-50 focus:bg-white">
            </div>

            <div>
                <label for="password_confirmation" class="block font-bold text-slate-700 mb-1">Confirmar: *</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                       placeholder="Repite contraseña"
                       class="w-full p-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-orange-500 focus:outline-none bg-slate-50 focus:bg-white">
            </div>
        </div>

        <button type="submit" class="w-full py-3.5 bg-orange-600 hover:bg-orange-700 text-white font-extrabold text-xs rounded-xl shadow-lg shadow-orange-600/30 transition-all flex items-center justify-center gap-2 mt-2">
            <i class="fa-solid fa-user-plus"></i> Completar Registro
        </button>

        <div class="border-t border-slate-100 pt-3 text-center">
            <p class="text-xs text-slate-500">
                ¿Ya tienes una cuenta? 
                <a href="{{ route('login') }}" class="font-extrabold text-orange-600 hover:underline ml-1">
                    Inicia sesion aqui
                </a>
            </p>
        </div>
    </form>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var nameIn = document.getElementById('name');
            if (nameIn) {
                nameIn.addEventListener('input', function() {
                    var original = this.value;
                    var cleaned = original.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
                    if (original !== cleaned) {
                        alert('⚠️ El dato que se intenta ingresar no corresponde al solicitado. El nombre solo debe contener letras.');
                        this.value = cleaned;
                    }
                });
            }

            var apeIn = document.getElementById('apellido');
            if (apeIn) {
                apeIn.addEventListener('input', function() {
                    var original = this.value;
                    var cleaned = original.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
                    if (original !== cleaned) {
                        alert('⚠️ El dato que se intenta ingresar no corresponde al solicitado. El apellido solo debe contener letras.');
                        this.value = cleaned;
                    }
                });
            }
        });
    </script>
    @endpush
</x-guest-layout>
