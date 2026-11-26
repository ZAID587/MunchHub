@extends('layouts.admin')

@section('title', 'Inicio y Metricas')

@section('content')
<div class="space-y-8">

    <!-- Encabezado de Bienvenida -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-xs">
        <div>
            <h1 class="text-2xl font-black text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-chart-line text-red-600"></i> Panel de Control Principal
            </h1>
            <p class="text-xs text-slate-500 mt-1">Resumen en tiempo real de operaciones, ventas y pedidos de Happyfood.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.productos.crear') }}" class="px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white font-extrabold text-xs rounded-xl shadow-md shadow-red-500/20 transition-all flex items-center gap-1.5">
                <i class="fa-solid fa-plus"></i> Nuevo Alimento
            </a>
            <a href="{{ route('admin.pedidos') }}" class="px-4 py-2.5 bg-slate-900 hover:bg-black text-white font-extrabold text-xs rounded-xl transition-all flex items-center gap-1.5">
                <i class="fa-solid fa-bell-concierge"></i> Ver Cocina
            </a>
        </div>
    </div>

    <!-- Metricas Clave (Tarjetas) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Total Ingresos -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-xs flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl font-bold flex-shrink-0">
                <i class="fa-solid fa-dollar-sign"></i>
            </div>
            <div>
                <span class="block text-slate-400 text-xs font-bold uppercase">Ingresos Totales</span>
                <span class="text-2xl font-black text-slate-900">${{ number_format($totalRevenue, 2) }}</span>
                <span class="block text-[10px] text-emerald-600 font-semibold mt-0.5">Ventas confirmadas</span>
            </div>
        </div>

        <!-- Pedidos Pendientes -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-xs flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-2xl font-bold flex-shrink-0">
                <i class="fa-solid fa-fire-burner"></i>
            </div>
            <div>
                <span class="block text-slate-400 text-xs font-bold uppercase">En Preparacion</span>
                <span class="text-2xl font-black text-slate-900">{{ $pendingOrders }}</span>
                <span class="block text-[10px] text-amber-600 font-semibold mt-0.5">Pendientes de entrega</span>
            </div>
        </div>

        <!-- Total Alimentos -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-xs flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-orange-100 text-orange-600 flex items-center justify-center text-2xl font-bold flex-shrink-0">
                <i class="fa-solid fa-burger"></i>
            </div>
            <div>
                <span class="block text-slate-400 text-xs font-bold uppercase">Menu Activo</span>
                <span class="text-2xl font-black text-slate-900">{{ $totalProducts }}</span>
                <span class="block text-[10px] text-orange-600 font-semibold mt-0.5">Platillos y bebidas</span>
            </div>
        </div>

        <!-- Clientes Registrados -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-xs flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-2xl font-bold flex-shrink-0">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <span class="block text-slate-400 text-xs font-bold uppercase">Clientes Activos</span>
                <span class="text-2xl font-black text-slate-900">{{ $totalClients }}</span>
                <span class="block text-[10px] text-blue-600 font-semibold mt-0.5">Cuentas registradas</span>
            </div>
        </div>

    </div>

    <!-- Tabla de Pedidos Recientes con Acceso a Tickets y Notas de Cocina -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-xs space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div>
                <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-receipt text-red-600"></i> Ultimas Ordenes Registradas
                </h2>
                <p class="text-xs text-slate-500">Revisa los detalles que el usuario solicita en cada platillo.</p>
            </div>
            <a href="{{ route('admin.pedidos') }}" class="text-xs font-bold text-red-600 hover:underline">
                Ver todas las ordenes →
            </a>
        </div>

        <div class="overflow-x-auto text-xs">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 font-bold uppercase text-[10px]">
                        <th class="py-3 px-3">Folio</th>
                        <th class="py-3 px-3">Comensal</th>
                        <th class="py-3 px-3">Mesa / Entrega</th>
                        <th class="py-3 px-3">Platillos y Detalles Solicitados</th>
                        <th class="py-3 px-3">Total</th>
                        <th class="py-3 px-3">Estado</th>
                        <th class="py-3 px-3 text-right">Ticket</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentOrders as $ord)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3.5 px-3 font-mono font-bold text-slate-900">
                                #ORD-{{ str_pad($ord->id, 5, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="py-3.5 px-3 font-bold text-slate-800">
                                {{ $ord->user->name ?? 'Cliente Mostrador' }}
                            </td>
                            <td class="py-3.5 px-3">
                                <span class="bg-slate-100 text-slate-700 font-semibold px-2 py-0.5 rounded-full text-[11px]">
                                    {{ $ord->table_number }}
                                </span>
                            </td>
                            <td class="py-3.5 px-3 max-w-xs">
                                <div class="space-y-1">
                                    @foreach($ord->items as $it)
                                        <div class="text-[11px]">
                                            <strong class="text-orange-600">{{ $it->quantity }}x</strong> {{ $it->product->name ?? 'Platillo' }}
                                            @if($it->notes)
                                                <span class="block text-[10px] text-amber-800 bg-amber-50 px-1.5 py-0.5 rounded border border-amber-200 mt-0.5">
                                                    📌 {{ $it->notes }}
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="py-3.5 px-3 font-mono font-black text-slate-900">
                                ${{ number_format($ord->total, 2) }}
                            </td>
                            <td class="py-3.5 px-3">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase
                                    @if($ord->status == 'completado' || $ord->status == 'entregado') bg-emerald-100 text-emerald-800
                                    @elseif($ord->status == 'en_preparacion') bg-amber-100 text-amber-800
                                    @else bg-slate-200 text-slate-700 @endif">
                                    {{ str_replace('_', ' ', $ord->status) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-3 text-right">
                                <a href="{{ route('client.ticket', $ord->id) }}" class="px-3 py-1.5 bg-slate-900 hover:bg-red-600 text-white font-bold rounded-lg transition-colors inline-flex items-center gap-1 text-[11px]">
                                    <i class="fa-solid fa-receipt text-[10px]"></i> Ticket
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">
                                No hay ordenes registradas por el momento.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
