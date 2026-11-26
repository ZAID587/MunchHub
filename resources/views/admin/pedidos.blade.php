@extends('layouts.admin')

@section('title', 'Pedidos de Cocina en Tiempo Real')

@section('content')
<div class="space-y-8">

    <!-- Encabezado y Filtros de Estado -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-xs">
        <div>
            <h1 class="text-2xl font-black text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-bell-concierge text-orange-600"></i> Comandas y Pedidos de Cocina
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Visualiza las comandas, especificaciones del comensal, rutas de entrega a domicilio y gestiona estados.
            </p>
        </div>

        <!-- Filtros de Pestañas: Activas / Archivadas / Todas -->
        <div class="flex items-center gap-1.5 p-1.5 bg-slate-100 rounded-2xl border border-slate-200 text-xs font-bold">
            <a href="{{ route('admin.pedidos', ['filtro' => 'activas']) }}" 
               class="px-4 py-2 rounded-xl transition-all flex items-center gap-1.5 {{ ($filtro ?? 'activas') === 'activas' ? 'bg-orange-600 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                <i class="fa-solid fa-fire-burner"></i> Activas en Cocina
            </a>
            <a href="{{ route('admin.pedidos', ['filtro' => 'archivadas']) }}" 
               class="px-4 py-2 rounded-xl transition-all flex items-center gap-1.5 {{ ($filtro ?? '') === 'archivadas' ? 'bg-slate-800 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                <i class="fa-solid fa-box-archive"></i> Archivadas
            </a>
            <a href="{{ route('admin.pedidos', ['filtro' => 'todas']) }}" 
               class="px-4 py-2 rounded-xl transition-all flex items-center gap-1.5 {{ ($filtro ?? '') === 'todas' ? 'bg-slate-800 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                <i class="fa-solid fa-list-check"></i> Todas
            </a>
        </div>
    </div>

    <!-- Tarjetas de Mesas y Pedidos -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($pedidos as $pedido)
            
            <div class="bg-white rounded-3xl border-2 {{ $pedido->status === 'archivado' ? 'border-slate-200 opacity-80' : ($pedido->status === 'entregado' ? 'border-emerald-200' : 'border-orange-200') }} overflow-hidden shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
                
                <!-- Encabezado de la Tarjeta con Modalidad y Folio -->
                <div class="p-4 flex items-center justify-between {{ $pedido->status === 'archivado' ? 'bg-slate-800 text-white' : ($pedido->status === 'entregado' ? 'bg-emerald-900 text-white' : 'bg-slate-900 text-white') }}">
                    <div>
                        <span class="text-[10px] font-bold text-orange-400 uppercase tracking-wider block">Modalidad</span>
                        <h2 class="text-base font-black flex items-center gap-2">
                            @if(Str::contains(strtolower($pedido->table_number), ['domicilio']))
                                <i class="fa-solid fa-motorcycle text-orange-400"></i> A Domicilio
                            @elseif(Str::contains(strtolower($pedido->table_number), ['mostrador', 'llevar']))
                                <i class="fa-solid fa-bag-shopping text-amber-400"></i> Mostrador
                            @else
                                <i class="fa-solid fa-chair text-amber-400"></i> {{ $pedido->table_number }}
                            @endif
                        </h2>
                    </div>

                    <div class="text-right">
                        <!-- Badge de Estado -->
                        @if($pedido->status === 'en_preparacion')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span> En Preparación
                            </span>
                        @elseif($pedido->status === 'entregado' || $pedido->status === 'completado')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                <i class="fa-solid fa-check text-[9px]"></i> Entregado
                            </span>
                        @elseif($pedido->status === 'archivado')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-slate-600 text-slate-300 border border-slate-500">
                                <i class="fa-solid fa-box-archive text-[9px]"></i> Archivado
                            </span>
                        @endif

                        <a href="{{ route('client.ticket', $pedido->id) }}" class="block text-xs font-black font-mono text-orange-400 hover:underline mt-1" title="Ver Ticket">
                            #ORD-{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}
                        </a>
                    </div>
                </div>

                <!-- Cuerpo con los Platillos y Detalles Especificos -->
                <div class="p-5 space-y-4 flex-1">
                    
                    <div class="flex items-center justify-between text-xs text-slate-500 pb-2 border-b border-slate-100">
                        <span><strong>Cliente:</strong> {{ $pedido->user->name ?? 'Mostrador' }}</span>
                        <span>{{ $pedido->created_at->format('h:i A') }} ({{ $pedido->created_at->diffForHumans() }})</span>
                    </div>

                    <!-- SECCIÓN ESPECIAL PARA PEDIDOS A DOMICILIO CON MAPA Y RUTA -->
                    @if($pedido->delivery_address || Str::contains(strtolower($pedido->table_number), ['domicilio']))
                        <div class="p-3.5 bg-orange-50/70 border border-orange-200 rounded-2xl text-xs space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="font-extrabold text-orange-950 flex items-center gap-1.5">
                                    <i class="fa-solid fa-location-dot text-orange-600"></i> Destino de Entrega
                                </span>
                                @if($pedido->delivery_lat && $pedido->delivery_lng)
                                    <span class="text-[10px] font-bold text-orange-700 bg-orange-100 px-2 py-0.5 rounded-md">
                                        GPS Listo
                                    </span>
                                @endif
                            </div>

                            <p class="text-xs text-slate-700 font-medium leading-snug">
                                {{ $pedido->delivery_address ?? 'Almoloya de Juárez, Estado de México' }}
                            </p>

                            <!-- Mapa Interactivo Miniatura si cuenta con Coordenadas -->
                            @if($pedido->delivery_lat && $pedido->delivery_lng)
                                <div id="map-admin-{{ $pedido->id }}" class="h-28 w-full rounded-xl border border-orange-200 shadow-xs"></div>
                                
                                <div class="pt-1">
                                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $pedido->delivery_lat }},{{ $pedido->delivery_lng }}" 
                                       target="_blank" 
                                       class="w-full py-2 bg-orange-600 hover:bg-orange-700 text-white font-bold rounded-xl text-center block transition-all shadow-xs text-xs">
                                        <i class="fa-solid fa-diamond-turn-right mr-1"></i> Abrir Ruta en Google Maps
                                    </a>
                                </div>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        var mapEl = document.getElementById('map-admin-{{ $pedido->id }}');
                                        if (mapEl && typeof L !== 'undefined') {
                                            var lat = {{ $pedido->delivery_lat }};
                                            var lng = {{ $pedido->delivery_lng }};
                                            var m = L.map('map-admin-{{ $pedido->id }}', { zoomControl: false }).setView([lat, lng], 15);
                                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18 }).addTo(m);
                                            L.marker([lat, lng]).addTo(m).bindPopup("Entrega: #ORD-{{ $pedido->id }}");
                                            setTimeout(function() { m.invalidateSize(); }, 300);
                                        }
                                    });
                                </script>
                            @else
                                <div class="pt-1">
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($pedido->delivery_address ?? 'Almoloya de Juarez') }}" 
                                       target="_blank" 
                                       class="w-full py-2 bg-slate-800 hover:bg-orange-600 text-white font-bold rounded-xl text-center block transition-all shadow-xs text-xs">
                                        <i class="fa-solid fa-map-location-dot mr-1"></i> Buscar Dirección en Maps
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Lista de Alimentos con Notas de Personalizacion -->
                    <div class="space-y-3">
                        <span class="block text-[10px] font-extrabold uppercase text-slate-400 tracking-wider">
                            Alimentos a Preparar:
                        </span>

                        @foreach($pedido->items as $it)
                            <div class="p-3 bg-slate-50 rounded-2xl border border-slate-200 text-xs space-y-1.5">
                                <div class="flex justify-between items-start">
                                    <span class="font-extrabold text-slate-900">
                                        <span class="text-orange-600 text-sm font-black">{{ $it->quantity }}x</span> 
                                        {{ $it->product->name ?? 'Platillo' }}
                                    </span>
                                    <span class="text-slate-500 font-mono font-bold text-[11px]">${{ number_format($it->subtotal, 2) }}</span>
                                </div>

                                <!-- DETALLES ESPECIFICOS QUE EL USUARIO QUIERE -->
                                @if($it->notes)
                                    <div class="text-[11px] bg-amber-50 text-amber-900 p-2 rounded-xl border border-amber-200 flex items-start gap-1.5 font-medium">
                                        <i class="fa-solid fa-circle-exclamation text-amber-600 text-xs mt-0.5"></i>
                                        <div>
                                            <strong class="font-bold text-amber-800">Especificación:</strong>
                                            <span>{{ $it->notes }}</span>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-[10px] text-slate-400 block italic">Preparación estándar</span>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Informacion de Pago y Concepto -->
                    <div class="pt-2 text-xs text-slate-600 bg-slate-100/70 p-2.5 rounded-xl space-y-1">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 font-semibold">Detalles de Pago:</span>
                            <span class="font-bold text-slate-800">{{ $pedido->notes ?? 'Efectivo' }}</span>
                        </div>
                    </div>

                </div>

                <!-- Footer de la Tarjeta: Total y Botones de Transición -->
                <div class="p-4 bg-slate-50 border-t border-slate-200 flex flex-col gap-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-500 uppercase">Total a Cobrar:</span>
                        <span class="text-lg font-black text-slate-900 font-mono">${{ number_format($pedido->total, 2) }}</span>
                    </div>

                    <!-- Cambiar Estado del Pedido con Flujo en_preparacion -> entregado -> archivado -->
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        @if($pedido->status === 'en_preparacion')
                            <form action="{{ route('admin.pedidos.estado', $pedido->id) }}" method="POST" class="w-full">
                                @csrf
                                <input type="hidden" name="status" value="entregado">
                                <button type="submit" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition-all shadow-xs flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-check"></i> Marcar Entregado
                                </button>
                            </form>
                        @elseif($pedido->status === 'entregado' || $pedido->status === 'completado')
                            <form action="{{ route('admin.pedidos.estado', $pedido->id) }}" method="POST" class="w-full">
                                @csrf
                                <input type="hidden" name="status" value="archivado">
                                <button type="submit" class="w-full py-2.5 bg-slate-700 hover:bg-slate-800 text-white font-bold rounded-xl transition-all shadow-xs flex items-center justify-center gap-1.5" title="Archivar y remover de la cocina">
                                    <i class="fa-solid fa-box-archive"></i> Archivar Comanda
                                </button>
                            </form>
                        @elseif($pedido->status === 'archivado')
                            <form action="{{ route('admin.pedidos.estado', $pedido->id) }}" method="POST" class="w-full">
                                @csrf
                                <input type="hidden" name="status" value="en_preparacion">
                                <button type="submit" class="w-full py-2.5 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-xl transition-all shadow-xs flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-rotate-left"></i> Reactivar
                                </button>
                            </form>
                        @endif

                        <!-- Botón Ver Ticket Imprimible -->
                        <a href="{{ route('client.ticket', $pedido->id) }}" 
                           class="py-2.5 bg-slate-900 hover:bg-orange-600 text-white font-bold rounded-xl transition-all shadow-xs flex items-center justify-center gap-1.5 text-center">
                            <i class="fa-solid fa-print"></i> Ver Ticket
                        </a>
                    </div>
                </div>

            </div>

        @empty
            <div class="col-span-1 md:col-span-2 lg:col-span-3 bg-white rounded-3xl border border-slate-200 p-12 text-center shadow-xs">
                <i class="fa-solid fa-bell-concierge text-4xl text-slate-300 mb-3 block"></i>
                <h3 class="text-base font-extrabold text-slate-800 mb-1">
                    @if(($filtro ?? '') === 'archivadas')
                        No hay pedidos archivados
                    @else
                        No hay pedidos pendientes en cocina
                    @endif
                </h3>
                <p class="text-xs text-slate-500">
                    @if(($filtro ?? '') === 'archivadas')
                        Las comandas que archives para limpiar la cocina aparecerán en este historial.
                    @else
                        La cocina se encuentra al corriente. Los nuevos pedidos aparecerán aquí automáticamente.
                    @endif
                </p>
            </div>
        @endforelse
    </div>

</div>
@endsection
