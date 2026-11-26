@extends('layouts.client')

@section('title', 'Mi Perfil y Pedidos')

@section('content')
<div class="space-y-10 max-w-5xl mx-auto">

    <!-- 1. Encabezado de Perfil con Tarjeta de Resumen -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
        <div class="flex flex-col sm:flex-row items-center sm:items-start justify-between gap-6">
            
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5 text-center sm:text-left">
                <!-- Avatar Circular -->
                <div class="relative w-24 h-24 sm:w-28 sm:h-28 rounded-full border-4 border-orange-500 overflow-hidden bg-orange-100 flex-shrink-0 shadow-md">
                    @if($user->avatar)
                        <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-orange-600 font-extrabold text-3xl">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    @endif
                </div>

                <div class="space-y-1">
                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                        <h1 class="text-2xl font-black text-slate-900">{{ $user->name }} {{ $user->apellido }}</h1>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase bg-orange-100 text-orange-800">
                            {{ $user->role }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-500">
                        <i class="fa-regular fa-envelope text-slate-400 mr-1"></i> {{ $user->email }}
                        <span class="mx-1">•</span>
                        <i class="fa-solid fa-at text-slate-400 mr-1"></i> {{ $user->username ?? 'sin_usuario' }}
                    </p>
                    <p class="text-xs text-slate-500">
                        <i class="fa-solid fa-location-dot text-slate-400 mr-1"></i> {{ $user->localidad ?? 'Universidad Politecnica del Valle de Toluca (UPVT)' }}
                        <span class="mx-1">•</span>
                        <i class="fa-solid fa-phone text-slate-400 mr-1"></i> {{ $user->telefono ?? 'Sin registrar' }}
                    </p>
                </div>
            </div>

            <!-- Accesos Rapidos -->
            <div class="flex items-center gap-2">
                <a href="{{ route('client.configuracion') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-full transition-colors flex items-center gap-1.5">
                    <i class="fa-solid fa-gear"></i> Ajustes
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 border border-red-200 text-red-600 hover:bg-red-50 font-bold text-xs rounded-full transition-colors flex items-center gap-1.5">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Salir
                    </button>
                </form>
            </div>

        </div>

        <!-- Estadisticas del Cliente -->
        <div class="grid grid-cols-3 gap-4 pt-6 mt-6 border-t border-slate-100 text-center text-xs">
            <div class="p-3 bg-slate-50 rounded-2xl">
                <span class="block text-slate-400 text-[11px] font-bold uppercase">Ordenes Realizadas</span>
                <span class="text-lg font-black text-slate-900">{{ $orders->count() }}</span>
            </div>
            <div class="p-3 bg-slate-50 rounded-2xl">
                <span class="block text-slate-400 text-[11px] font-bold uppercase">Total Consumido</span>
                <span class="text-lg font-black text-orange-600">${{ number_format($orders->sum('total'), 2) }}</span>
            </div>
            <div class="p-3 bg-slate-50 rounded-2xl">
                <span class="block text-slate-400 text-[11px] font-bold uppercase">Miembro Desde</span>
                <span class="text-lg font-black text-slate-800">{{ $user->created_at->format('M Y') }}</span>
            </div>
        </div>
    </div>

    <!-- 2. Formulario de Actualizacion de Datos Personales (Inspirado en Buscamed) -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
        <div class="border-b border-slate-100 pb-4 mb-6">
            <h2 class="text-lg font-extrabold text-slate-900 flex items-center gap-2">
                <i class="fa-regular fa-id-card text-orange-600"></i> Informacion Personal y de Cuenta
            </h2>
            <p class="text-xs text-slate-500 mt-0.5">Mantener tus datos al dia garantiza que tus tickets y entregas se procesen correctamente.</p>
        </div>

        <form action="{{ route('client.perfil.editar') }}" method="POST" id="perfilForm" class="space-y-5 text-xs">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nombre de la persona (Solo letras): *</label>
                    <input type="text" name="name" id="nameInput" value="{{ old('name', $user->name) }}" required
                           class="w-full p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-orange-500 focus:outline-none">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Apellidos (Solo letras): *</label>
                    <input type="text" name="apellido" id="apellidoInput" value="{{ old('apellido', $user->apellido) }}" required placeholder="Paterno y Materno"
                           class="w-full p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-orange-500 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nombre de Usuario (Username personal): *</label>
                    <input type="text" name="username" value="{{ old('username', $user->username ?? 'usuario_'.$user->id) }}" required
                           class="w-full p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-orange-500 focus:outline-none">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Correo Electronico (No modificable):</label>
                    <input type="email" value="{{ $user->email }}" disabled
                           class="w-full p-3 rounded-xl border border-slate-200 bg-slate-100 text-slate-500 cursor-not-allowed">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Sexo / Genero:</label>
                    <select name="sexo" class="w-full p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-orange-500 focus:outline-none bg-white">
                        <option value="">Seleccionar...</option>
                        <option value="Masculino" {{ $user->sexo == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                        <option value="Femenino" {{ $user->sexo == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                        <option value="Otro" {{ $user->sexo == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Fecha de Nacimiento:</label>
                    <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $user->fecha_nacimiento) }}"
                           class="w-full p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-orange-500 focus:outline-none bg-white">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Edad (Numeros):</label>
                    <input type="number" name="edad" id="edadInput" min="1" max="120" value="{{ old('edad', $user->edad) }}" placeholder="Ej: 21"
                           class="w-full p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-orange-500 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Telefono (10 digitos numericos):</label>
                    <input type="text" name="telefono" id="telefonoInput" maxlength="10" value="{{ old('telefono', $user->telefono) }}" placeholder="7227705013"
                           class="w-full p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-orange-500 focus:outline-none">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Localidad / Direccion en Toluca o Almoloya:</label>
                    <input type="text" name="localidad" value="{{ old('localidad', $user->localidad) }}" placeholder="UPVT Campus Central"
                           class="w-full p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-orange-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">URL de Foto de Perfil / Avatar:</label>
                <input type="url" name="avatar" value="{{ old('avatar', $user->avatar) }}" placeholder="https://ejemplo.com/mifoto.jpg"
                       class="w-full p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-orange-500 focus:outline-none">
                <span class="text-[10px] text-slate-400 mt-1 block">Pega un enlace de imagen para personalizar tu foto de perfil.</span>
            </div>

            <div class="pt-2">
                <button type="submit" class="px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-extrabold text-xs rounded-full shadow-md transition-all flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Guardar Cambios del Perfil
                </button>
            </div>
        </form>
    </div>

    <!-- 3. Historial de Pedidos y Acceso a Tickets (Inspirado en Buscamed) -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
        <div class="border-b border-slate-100 pb-4 mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-extrabold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-receipt text-orange-600"></i> Historial de Compras y Tickets
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">Haz clic sobre cualquier orden para ver e imprimir su ticket detallado.</p>
            </div>
            <span class="text-xs font-bold text-slate-400">{{ $orders->count() }} ordenes registradas</span>
        </div>

        @if($orders->isEmpty())
            <div class="text-center py-8 text-xs text-slate-400">
                <i class="fa-solid fa-basket-shopping text-3xl mb-2 text-slate-300 block"></i>
                Aun no has realizado ninguna compra. ¡Pide tu platillo favorito desde el menu!
            </div>
        @else
            <div class="space-y-4">
                @foreach($orders as $ord)
                    <div class="p-4 sm:p-5 rounded-2xl border border-slate-200 hover:border-orange-400 hover:shadow-md transition-all bg-slate-50/50 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                        
                        <!-- Clic al folio abre el ticket -->
                        <a href="{{ route('client.ticket', $ord->id) }}" class="space-y-1 block flex-1 group">
                            <div class="flex items-center gap-3">
                                <span class="font-black text-slate-900 text-sm font-mono group-hover:text-orange-600 transition-colors">
                                    #ORD-{{ str_pad($ord->id, 5, '0', STR_PAD_LEFT) }}
                                </span>
                                <span class="text-[10px] px-2 py-0.5 rounded-full font-bold uppercase
                                    @if($ord->status == 'completado' || $ord->status == 'entregado') bg-emerald-100 text-emerald-800
                                    @elseif($ord->status == 'en_preparacion') bg-amber-100 text-amber-800
                                    @else bg-slate-200 text-slate-700 @endif">
                                    {{ str_replace('_', ' ', $ord->status) }}
                                </span>
                                <span class="text-xs text-slate-400 font-medium">
                                    {{ $ord->created_at->format('d/m/Y h:i A') }}
                                </span>
                            </div>

                            <p class="text-xs text-slate-600">
                                <strong>Modalidad:</strong> {{ $ord->table_number }} | <strong>Pago:</strong> {{ $ord->notes ?? 'Efectivo' }}
                            </p>

                            <!-- Resumen de platillos con notas -->
                            <div class="text-[11px] text-slate-500 pt-1">
                                @foreach($ord->items as $it)
                                    <span class="inline-block bg-white px-2 py-0.5 rounded border border-slate-200 mr-1 mb-1">
                                        {{ $it->quantity }}x {{ $it->product->name ?? 'Platillo' }}
                                        @if($it->notes)
                                            <span class="text-orange-600 font-semibold">({{ $it->notes }})</span>
                                        @endif
                                    </span>
                                @endforeach
                            </div>
                        </a>

                        <!-- Total y Boton Notorio Ver Ticket -->
                        <div class="flex items-center justify-between w-full md:w-auto gap-4 pt-3 md:pt-0 border-t md:border-t-0 border-slate-200">
                            <span class="text-base font-black text-slate-900">
                                ${{ number_format($ord->total, 2) }}
                            </span>

                            <a href="{{ route('client.ticket', $ord->id) }}" 
                               class="px-4 py-2 bg-slate-900 hover:bg-orange-600 text-white font-extrabold text-xs rounded-xl transition-all shadow-xs flex items-center gap-1.5 whitespace-nowrap">
                                <i class="fa-solid fa-receipt text-xs"></i> Ver Ticket
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var nameIn = document.getElementById('nameInput');
        if (nameIn) validateStrictLetters(nameIn, 'Nombre');

        var apeIn = document.getElementById('apellidoInput');
        if (apeIn) validateStrictLetters(apeIn, 'Apellidos');

        var telIn = document.getElementById('telefonoInput');
        if (telIn) validateStrictNumbers(telIn, 'Telefono');

        var edadIn = document.getElementById('edadInput');
        if (edadIn) validateStrictNumbers(edadIn, 'Edad');
    });
</script>
@endpush
@endsection
