@extends('layouts.client')

@section('title', 'Configuracion y Preferencias')

@section('content')
<div class="space-y-8 max-w-2xl mx-auto">

    <div class="flex items-center justify-between border-b border-slate-200 pb-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('client.perfil') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 flex items-center justify-center font-bold text-sm shadow-xs transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-black text-slate-900">Ajustes y Configuracion</h1>
                <p class="text-xs text-slate-500">Personaliza tus preferencias de compra, seguridad y notificaciones.</p>
            </div>
        </div>
    </div>

    <!-- Lista de Opciones -->
    <div class="bg-white rounded-3xl border border-slate-200 divide-y divide-slate-100 shadow-sm overflow-hidden text-xs">
        
        <!-- Opcion 1: Mi Perfil -->
        <a href="{{ route('client.perfil') }}" class="p-5 flex items-center justify-between hover:bg-slate-50 transition-colors">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center text-base">
                    <i class="fa-regular fa-user"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-xs">Datos Personales y de Entrega</h3>
                    <p class="text-[11px] text-slate-400">Nombre, telefono, localidad y foto de perfil</p>
                </div>
            </div>
            <i class="fa-solid fa-chevron-right text-slate-300"></i>
        </a>

        <!-- Opcion 2: Historial de Compras -->
        <a href="{{ route('client.perfil') }}#historial" class="p-5 flex items-center justify-between hover:bg-slate-50 transition-colors">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-base">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-xs">Historial de Compras y Tickets</h3>
                    <p class="text-[11px] text-slate-400">Ver e imprimir comprobantes de compras anteriores</p>
                </div>
            </div>
            <i class="fa-solid fa-chevron-right text-slate-300"></i>
        </a>

        <!-- Opcion 3: Seguridad y Contraseña -->
        <a href="{{ route('profile.edit') }}" class="p-5 flex items-center justify-between hover:bg-slate-50 transition-colors">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-base">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-xs">Seguridad y Contraseña</h3>
                    <p class="text-[11px] text-slate-400">Actualizar clave encriptada (Bcrypt) y cierre de sesiones</p>
                </div>
            </div>
            <i class="fa-solid fa-chevron-right text-slate-300"></i>
        </a>

        <!-- Opcion 4: Soporte Camila WhatsApp -->
        <a href="https://wa.me/527227705013?text=Hola%20Camila,%20necesito%20asistencia%20en%20Happyfood" target="_blank" class="p-5 flex items-center justify-between hover:bg-slate-50 transition-colors">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-base">
                    <i class="fa-brands fa-whatsapp text-lg"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-xs">Soporte Directo con Camila</h3>
                    <p class="text-[11px] text-slate-400">Atencion al cliente y aclaraciones via WhatsApp (722 770 5013)</p>
                </div>
            </div>
            <i class="fa-solid fa-chevron-right text-slate-300"></i>
        </a>

        <!-- Opcion 5: Cerrar Sesion -->
        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button type="submit" class="w-full p-5 flex items-center justify-between hover:bg-red-50 text-red-600 transition-colors text-left">
                <div class="flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center text-base">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-red-600 text-xs">Cerrar Sesion</h3>
                        <p class="text-[11px] text-red-400">Finalizar sesion de manera segura en este dispositivo</p>
                    </div>
                </div>
                <span class="text-xs font-bold text-red-500">Salir</span>
            </button>
        </form>

    </div>

</div>
@endsection
