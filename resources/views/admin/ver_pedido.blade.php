@extends('layouts.admin')

@section('title', 'Detalle de Orden #' . $order->id)

@section('content')
<div class="space-y-8 max-w-4xl mx-auto">

    <div class="flex items-center justify-between border-b border-slate-200 pb-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.pedidos') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 flex items-center justify-center font-bold text-sm shadow-xs transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-black text-slate-900 flex items-center gap-2">
                    Comanda de Cocina: #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                </h1>
                <p class="text-xs text-slate-500">Orden recibida el {{ $order->created_at->format('d/m/Y h:i A') }}</p>
            </div>
        </div>

        <a href="{{ route('client.ticket', $order->id) }}" class="px-5 py-2.5 bg-slate-900 hover:bg-black text-white font-extrabold text-xs rounded-xl shadow-xs transition-all flex items-center gap-2">
            <i class="fa-solid fa-print"></i> Ver e Imprimir Ticket
        </a>
    </div>

    <!-- Metadatos de la Orden -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-xs">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
            <div class="p-3 bg-slate-50 rounded-2xl">
                <span class="text-slate-400 font-bold uppercase text-[10px] block mb-1">Comensal</span>
                <span class="font-extrabold text-slate-900 text-sm block">{{ $order->user->name ?? 'Cliente Mostrador' }}</span>
                <span class="text-slate-500 text-[11px]">{{ $order->user->email ?? '' }}</span>
            </div>

            <div class="p-3 bg-slate-50 rounded-2xl">
                <span class="text-slate-400 font-bold uppercase text-[10px] block mb-1">Modalidad / Mesa</span>
                <span class="font-extrabold text-orange-600 text-sm block">{{ $order->table_number }}</span>
                <span class="text-slate-500 text-[11px]">Entrega inmediata</span>
            </div>

            <div class="p-3 bg-slate-50 rounded-2xl">
                <span class="text-slate-400 font-bold uppercase text-[10px] block mb-1">Metodo de Pago</span>
                <span class="font-bold text-slate-800 text-xs block">{{ $order->notes ?? 'Efectivo' }}</span>
            </div>

            <div class="p-3 bg-slate-50 rounded-2xl">
                <span class="text-slate-400 font-bold uppercase text-[10px] block mb-1">Total de la Orden</span>
                <span class="font-black text-slate-900 text-base font-mono block">${{ number_format($order->total, 2) }}</span>
            </div>
        </div>
    </div>

    <!-- Desglose de Alimentos con Especificaciones de Cocina -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-xs space-y-4">
        <h2 class="text-base font-black text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
            <i class="fa-solid fa-utensils text-red-600"></i> Alimentos a Preparar en Cocina
        </h2>

        <div class="space-y-3">
            @foreach($order->items as $it)
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-xs">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="w-7 h-7 rounded-lg bg-red-600 text-white font-black flex items-center justify-center text-xs">
                                {{ $it->quantity }}x
                            </span>
                            <span class="font-extrabold text-slate-900 text-sm">
                                {{ $it->product->name ?? 'Platillo' }}
                            </span>
                        </div>

                        <!-- Especificacion del Usuario (Sin salsa, sin crema, etc.) -->
                        @if($it->notes)
                            <div class="mt-1 text-[11px] text-amber-900 bg-amber-50 p-2 rounded-xl border border-amber-200 flex items-start gap-1.5 font-medium">
                                <i class="fa-solid fa-circle-exclamation text-amber-600 text-xs mt-0.5"></i>
                                <div>
                                    <strong class="font-bold text-amber-800">Especificacion de preparacion:</strong>
                                    <span>{{ $it->notes }}</span>
                                </div>
                            </div>
                        @else
                            <span class="text-[10px] text-slate-400 italic block pl-9">Preparacion regular / estandar</span>
                        @endif
                    </div>

                    <div class="text-right sm:border-l sm:border-slate-200 sm:pl-4">
                        <span class="text-slate-400 text-[10px] block">Importe:</span>
                        <span class="font-mono font-black text-slate-900 text-sm">${{ number_format($it->subtotal, 2) }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Accion de Cambiar Estado -->
        <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2 text-xs">
                <span class="text-slate-500 font-bold">Estado actual:</span>
                <span class="px-3 py-1 rounded-full text-xs font-extrabold uppercase
                    @if($order->status == 'completado') bg-emerald-100 text-emerald-800
                    @elseif($order->status == 'en_preparacion') bg-amber-100 text-amber-800
                    @else bg-slate-200 text-slate-700 @endif">
                    {{ str_replace('_', ' ', $order->status) }}
                </span>
            </div>

            <form action="{{ route('admin.pedidos.estado', $order->id) }}" method="POST" class="flex items-center gap-2">
                @csrf
                <select name="status" class="p-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-700 bg-white">
                    <option value="en_preparacion" {{ $order->status == 'en_preparacion' ? 'selected' : '' }}>En Preparacion</option>
                    <option value="completado" {{ $order->status == 'completado' ? 'selected' : '' }}>Completado / Listo</option>
                    <option value="entregado" {{ $order->status == 'entregado' ? 'selected' : '' }}>Entregado al Cliente</option>
                    <option value="cancelado" {{ $order->status == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                </select>
                <button type="submit" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-extrabold text-xs rounded-xl shadow-xs transition-colors">
                    Actualizar Estado
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
