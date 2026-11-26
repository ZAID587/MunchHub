@extends('layouts.admin')

@section('title', 'Configuracion del Sistema y Seguridad')

@section('content')
<div class="space-y-8 max-w-4xl mx-auto">

    <!-- Encabezado -->
    <div class="flex items-center justify-between border-b border-slate-200 pb-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-gear text-red-600"></i> Configuracion del Sistema
            </h1>
            <p class="text-xs text-slate-500 mt-1">Administra el PIN de seguridad de acceso, datos del local y politicas del restaurante.</p>
        </div>
        <span class="px-3 py-1 rounded-full text-xs font-black bg-red-100 text-red-800 uppercase">
            Administrador Master
        </span>
    </div>

    <!-- 1. GESTION DEL CODIGO ESPECIAL DE SEGURIDAD ADMIN (PIN 1720) -->
    <div class="bg-white rounded-3xl border-2 border-red-200 p-6 sm:p-8 shadow-sm space-y-4">
        <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
            <div class="w-12 h-12 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center text-xl shadow-xs">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <div>
                <h2 class="text-base font-black text-slate-900">Codigo de Verificacion Especial de Administrador</h2>
                <p class="text-xs text-slate-500">Este PIN protege el acceso a la cuenta de admin. Se solicita obligatoriamente en el login.</p>
            </div>
        </div>

        <form action="{{ route('admin.configuracion.actualizar') }}" method="POST" class="space-y-4 text-xs">
            @csrf
            
            <div class="max-w-md">
                <label class="block font-bold text-slate-700 mb-1 uppercase tracking-wider text-[11px]">
                    PIN / Contraseña Especial de Administrador: *
                </label>
                <div class="relative">
                    <input type="text" name="admin_code" id="adminCodeInput" value="{{ old('admin_code', $adminCode ?? '1720') }}" required maxlength="10"
                           class="w-full pl-10 pr-4 py-3 rounded-xl border border-red-300 font-mono text-base font-bold tracking-widest text-slate-900 bg-red-50/30 focus:bg-white focus:ring-2 focus:ring-red-500 focus:outline-none">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-red-500">
                        <i class="fa-solid fa-key"></i>
                    </div>
                </div>
                <span class="text-[10px] text-slate-400 mt-1.5 block">
                    Cualquier intento de inicio de sesion como administrador sin este codigo exacto sera rechazado de inmediato.
                </span>
            </div>

            <button type="submit" class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-extrabold rounded-xl shadow-md transition-all flex items-center gap-2">
                <i class="fa-solid fa-check"></i> Actualizar Codigo Especial
            </button>
        </form>
    </div>

    <!-- 2. DATOS DEL RESTAURANTE Y LOCAL (UPVT) -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-4 text-xs">
        <h2 class="text-base font-black text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
            <i class="fa-solid fa-shop text-orange-600"></i> Informacion del Restaurante Happyfood
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                <span class="text-slate-400 font-bold uppercase text-[10px] block mb-1">Ubicacion Central</span>
                <p class="font-bold text-slate-800 text-xs">Universidad Politecnica del Valle de Toluca (UPVT)</p>
                <p class="text-slate-500 text-[11px]">Carretera Toluca - Almoloya de Juarez, Edo. de Mexico.</p>
            </div>

            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                <span class="text-slate-400 font-bold uppercase text-[10px] block mb-1">Contacto Directo</span>
                <p class="font-bold text-slate-800 text-xs">Telefono / WhatsApp: 722 770 5013</p>
                <p class="text-slate-500 text-[11px]">Correo: zaidmed587@gmail.com</p>
            </div>

            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                <span class="text-slate-400 font-bold uppercase text-[10px] block mb-1">Horario de Operacion</span>
                <p class="font-bold text-slate-800 text-xs">Lunes a Sabado: 10:00 AM - 10:00 PM</p>
                <p class="text-emerald-600 font-bold text-[11px]">Estado: Abierto y Recibiendo Pedidos</p>
            </div>

            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                <span class="text-slate-400 font-bold uppercase text-[10px] block mb-1">Metodos de Pago Activos</span>
                <p class="font-bold text-slate-800 text-xs">Efectivo, Transferencia SPEI (BBVA), Tarjetas Visa/Mastercard</p>
                <p class="text-slate-500 text-[11px]">Tickets impresos y digitales en PDF</p>
            </div>
        </div>
    </div>

    <!-- 3. POLITICAS DE SEGURIDAD Y SESION -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-4 text-xs">
        <h2 class="text-base font-black text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
            <i class="fa-solid fa-lock text-emerald-600"></i> Protocolos de Seguridad Implementados
        </h2>

        <div class="space-y-3 text-slate-600">
            <div class="flex items-start gap-3 p-3 bg-emerald-50/60 rounded-xl border border-emerald-100">
                <i class="fa-solid fa-circle-check text-emerald-600 text-base mt-0.5"></i>
                <div>
                    <strong class="font-bold text-emerald-900">Manejo de Sesion Unica (Single-Device Session):</strong>
                    <p class="text-[11px] text-emerald-800 mt-0.5">Si la cuenta se abre en otra pestaña, navegador o modo incognito, la sesion previa se desconecta en tiempo real sin recargar.</p>
                </div>
            </div>

            <div class="flex items-start gap-3 p-3 bg-blue-50/60 rounded-xl border border-blue-100">
                <i class="fa-solid fa-hourglass-end text-blue-600 text-base mt-0.5"></i>
                <div>
                    <strong class="font-bold text-blue-900">Expiracion por Inactividad (5 Minutos):</strong>
                    <p class="text-[11px] text-blue-800 mt-0.5">El sistema destruye automaticamente la sesion tras 5 minutos de reposo para evitar accesos no autorizados en computadoras compartidas.</p>
                </div>
            </div>

            <div class="flex items-start gap-3 p-3 bg-purple-50/60 rounded-xl border border-purple-100">
                <i class="fa-solid fa-shield-halved text-purple-600 text-base mt-0.5"></i>
                <div>
                    <strong class="font-bold text-purple-900">Encriptacion Bcrypt y Proteccion SQL Injection:</strong>
                    <p class="text-[11px] text-purple-800 mt-0.5">Todas las claves viajan encriptadas mediante hash Bcrypt y las consultas estan 100% parametrizadas con PDO / Eloquent ORM.</p>
                </div>
            </div>
        </div>

        <div class="pt-2 flex items-center gap-3">
            <a href="{{ route('profile.edit') }}" class="px-5 py-2.5 bg-slate-900 hover:bg-black text-white font-bold rounded-xl transition-colors">
                Editar Datos de Acceso de Usuario
            </a>
        </div>
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var pinInput = document.getElementById('adminCodeInput');
        if (pinInput) {
            validateStrictNumbers(pinInput, 'Codigo Especial de Administrador');
        }
    });
</script>
@endpush
@endsection
