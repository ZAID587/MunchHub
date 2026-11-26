@extends('layouts.admin')

@section('title', 'Pedidos de Cocina en Tiempo Real')

@section('content')
<div class="space-y-8">

    <!-- Encabezado -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-xs">
        <div>
            <h1 class="text-2xl font-black text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-bell-concierge text-red-600"></i> Comandas y Pedidos de Cocina
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Visualiza las especificaciones exactas del cliente (sin salsa, sin crema, bien frio, etc.) e imprime tickets.
            </p>
        </div>

        <div class="flex items-center gap-2 text-xs font-bold text-slate-600">
            <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
            <span>Cocina Conectada en Tiempo Real</span>
        </div>
    </div>

    <!-- Tarjetas de Mesas y Pedidos -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($pedidosPorMesa as $mesa => $pedidosDeMesa)
            @php
                $pedido = $pedidosDeMesa->first();
            @endphp
            
            <div class="bg-white rounded-3xl border-2 border-slate-200 overflow-hidden shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
                
                <!-- Encabezado de la Mesa y Folio -->
                <div class="bg-slate-900 text-white p-4 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-bold text-orange-400 uppercase tracking-wider block">Modalidad</span>
                        <h2 class="text-base font-black flex items-center gap-2">
                            <i class="fa-solid fa-chair text-sm"></i> {{ $mesa }}
                        </h2>
                    </div>

                    <a href="{{ route('client.ticket', $pedido->id) }}" class="text-right group" title="Clic para ver Ticket de la Orden">
                        <span class="text-[10px] text-slate-400 block uppercase font-bold">Folio (Clic Ticket)</span>
                        <span class="text-sm font-black font-mono text-orange-400 group-hover:underline">
                            #ORD-{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}
                        </span>
                    </a>
                </div>

                <!-- Cuerpo con los Platillos y Detalles Especificos -->
                <div class="p-5 space-y-4 flex-1">
                    
                    <div class="flex items-center justify-between text-xs text-slate-500 pb-2 border-b border-slate-100">
                        <span><strong>Cliente:</strong> {{ $pedido->user->name ?? 'Mostrador' }}</span>
                        <span>{{ $pedido->created_at->format('h:i A') }}</span>
                    </div>

                    <!-- Lista de Alimentos con Notas de Personalizacion -->
                    <div class="space-y-3">
                        <span class="block text-[10px] font-extrabold uppercase text-slate-400 tracking-wider">
                            Alimentos a Preparar:
                        </span>

                        @foreach($pedido->items as $it)
                            <div class="p-3 bg-slate-50 rounded-2xl border border-slate-200 text-xs space-y-1.5">
                                <div class="flex justify-between items-start">
                                    <span class="font-extrabold text-slate-900">
                                        <span class="text-red-600 text-sm font-black">{{ $it->quantity }}x</span> 
                                        {{ $it->product->name ?? 'Platillo' }}
                                    </span>
                                    <span class="text-slate-500 font-mono font-bold text-[11px]">${{ number_format($it->subtotal, 2) }}</span>
                                </div>

                                <!-- DETALLES ESPECIFICOS QUE EL USUARIO QUIERE (Sin salsa, sin crema, etc.) -->
                                @if($it->notes)
                                    <div class="text-[11px] bg-amber-50 text-amber-900 p-2 rounded-xl border border-amber-200 flex items-start gap-1.5 font-medium">
                                        <i class="fa-solid fa-circle-exclamation text-amber-600 text-xs mt-0.5"></i>
                                        <div>
                                            <strong class="font-bold text-amber-800">Especificacion:</strong>
                                            <span>{{ $it->notes }}</span>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-[10px] text-slate-400 block italic">Preparacion estandar</span>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Informacion de Pago -->
                    <div class="pt-2 text-xs text-slate-600 flex items-center justify-between bg-slate-100/70 p-2.5 rounded-xl">
                        <span>Metodo de Pago:</span>
                        <strong class="text-slate-800">{{ $pedido->notes ?? 'Efectivo' }}</strong>
                    </div>

                </div>

                <!-- Footer de la Tarjeta: Total y Acciones -->
                <div class="p-4 bg-slate-50 border-t border-slate-200 flex flex-col gap-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-500 uppercase">Total a Cobrar:</span>
                        <span class="text-lg font-black text-slate-900 font-mono">${{ number_format($pedido->total, 2) }}</span>
                    </div>

                    <!-- Cambiar Estado del Pedido -->
                    <form action="{{ route('admin.pedidos.estado', $pedido->id) }}" method="POST" class="grid grid-cols-2 gap-2 text-xs">
                        @csrf
                        @if($pedido->status === 'en_preparacion')
                            <input type="hidden" name="status" value="completado">
                            <button type="submit" class="py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition-all shadow-xs flex items-center justify-center gap-1">
                                <i class="fa-solid fa-check"></i> Marcar Listo
                            </button>
                        @else
                            <input type="hidden" name="status" value="en_preparacion">
                            <button type="submit" class="py-2.5 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-xl transition-all shadow-xs flex items-center justify-center gap-1">
                                <i class="fa-solid fa-rotate-left"></i> A Preparacion
                            </button>
                        @endif

                        <!-- Boton Notorio Ver Ticket Imprimible -->
                        <a href="{{ route('client.ticket', $pedido->id) }}" 
                           class="py-2.5 bg-slate-900 hover:bg-red-600 text-white font-bold rounded-xl transition-all shadow-xs flex items-center justify-center gap-1 text-center">
                            <i class="fa-solid fa-print"></i> Ver Ticket
                        </a>
                    </form>
                </div>

            </div>

        @empty
            <div class="col-span-3 bg-white rounded-3xl border border-slate-200 p-12 text-center shadow-xs">
                <i class="fa-solid fa-bell-concierge text-4xl text-slate-300 mb-3 block"></i>
                <h3 class="text-base font-extrabold text-slate-800 mb-1">No hay pedidos pendientes</h3>
                <p class="text-xs text-slate-500">La cocina se encuentra al corriente. Los nuevos pedidos apareceran aqui automaticamente.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection
