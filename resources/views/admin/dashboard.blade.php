@extends('layouts.admin')

@section('title', 'Inicio y Gestion del Restaurante')

@section('content')
<div class="space-y-8">

    <!-- Encabezado Principal -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-xs">
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white flex items-center gap-2">
                <i class="fa-solid fa-utensils text-red-600"></i> Panel de Administración MunchHub
            </h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Gestiona el menú de alimentos, modera opiniones y atiende los pedidos en cocina.</p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('admin.productos.crear') }}" class="px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white font-extrabold text-xs rounded-xl shadow-md shadow-red-500/20 transition-all flex items-center gap-1.5">
                <i class="fa-solid fa-plus"></i> Nuevo Alimento
            </a>
            <a href="{{ route('admin.pedidos') }}" class="px-4 py-2.5 bg-slate-900 dark:bg-slate-700 hover:bg-black text-white font-extrabold text-xs rounded-xl transition-all flex items-center gap-1.5">
                <i class="fa-solid fa-bell-concierge"></i> Ver Cocina ({{ $pendingOrders }})
            </a>
            <a href="{{ route('client.inicio') }}" target="_blank" class="px-4 py-2.5 bg-orange-50 hover:bg-orange-100 text-orange-700 font-extrabold text-xs rounded-xl border border-orange-200 transition-all flex items-center gap-1.5">
                <i class="fa-solid fa-eye"></i> Vista Pública
            </a>
        </div>
    </div>

    <!-- Metricas Operativas (Sin métricas de ingresos monetarios) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Pedidos en Preparacion -->
        <div class="bg-white dark:bg-slate-800 p-5 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-xs flex items-center gap-4">
            <div class="w-13 h-13 rounded-2xl bg-amber-100 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xl font-bold shrink-0">
                <i class="fa-solid fa-fire-burner"></i>
            </div>
            <div>
                <span class="block text-slate-400 text-xs font-bold uppercase">En Preparación</span>
                <span class="text-2xl font-black text-slate-900 dark:text-white">{{ $pendingOrders }}</span>
                <span class="block text-[10px] text-amber-600 font-semibold">Órdenes activas</span>
            </div>
        </div>

        <!-- Total de Pedidos Registrados -->
        <div class="bg-white dark:bg-slate-800 p-5 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-xs flex items-center gap-4">
            <div class="w-13 h-13 rounded-2xl bg-emerald-100 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl font-bold shrink-0">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <div>
                <span class="block text-slate-400 text-xs font-bold uppercase">Total Pedidos</span>
                <span class="text-2xl font-black text-slate-900 dark:text-white">{{ $totalOrders }}</span>
                <span class="block text-[10px] text-emerald-600 font-semibold">Tickets generados</span>
            </div>
        </div>

        <!-- Catalogo de Alimentos -->
        <div class="bg-white dark:bg-slate-800 p-5 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-xs flex items-center gap-4">
            <div class="w-13 h-13 rounded-2xl bg-orange-100 dark:bg-orange-900/40 text-orange-600 dark:text-orange-400 flex items-center justify-center text-xl font-bold shrink-0">
                <i class="fa-solid fa-burger"></i>
            </div>
            <div>
                <span class="block text-slate-400 text-xs font-bold uppercase">Catálogo del Menú</span>
                <span class="text-2xl font-black text-slate-900 dark:text-white">{{ $totalProducts }}</span>
                <span class="block text-[10px] text-orange-600 font-semibold">Platillos y bebidas</span>
            </div>
        </div>

        <!-- Clientes Registrados -->
        <div class="bg-white dark:bg-slate-800 p-5 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-xs flex items-center gap-4">
            <div class="w-13 h-13 rounded-2xl bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xl font-bold shrink-0">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <span class="block text-slate-400 text-xs font-bold uppercase">Clientes Activos</span>
                <span class="text-2xl font-black text-slate-900 dark:text-white">{{ $totalClients }}</span>
                <span class="block text-[10px] text-blue-600 font-semibold">Cuentas creadas</span>
            </div>
        </div>

    </div>

    <!-- SECCION: Catalogo Visual de Alimentos con Opciones de Administracion -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 p-6 shadow-xs space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4 gap-3">
            <div>
                <h2 class="text-lg font-black text-slate-900 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-store text-red-600"></i> Catálogo de Alimentos (Vista de Gestión)
                </h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">Visualiza cada platillo tal como lo ven los clientes, con herramientas para editar, moderar opiniones o borrar.</p>
            </div>
            <a href="{{ route('admin.productos.crear') }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-extrabold text-xs rounded-xl transition-all self-start sm:self-auto flex items-center gap-1.5 shadow-sm">
                <i class="fa-solid fa-plus"></i> Agregar Nuevo Platillo
            </a>
        </div>

        <!-- Cuadricula / Grid de Platillos Estilo Catalogo -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
            @forelse($productos as $prod)
                <div class="bg-slate-50 dark:bg-slate-900/60 rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden flex flex-col justify-between hover:shadow-md transition-all group">
                    <div>
                        <!-- Imagen con Badge de Categoria -->
                        <div class="relative h-44 w-full bg-slate-200 dark:bg-slate-800 overflow-hidden">
                            <img src="{{ $prod->image }}" alt="{{ $prod->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            <span class="absolute top-2.5 left-2.5 px-2.5 py-1 bg-white/95 dark:bg-slate-900/90 backdrop-blur-xs text-[10px] font-black uppercase text-orange-600 rounded-lg shadow-xs">
                                {{ $prod->category }}
                            </span>
                            <span class="absolute top-2.5 right-2.5 px-2 py-0.5 bg-black/70 text-white text-[10px] font-extrabold rounded-md flex items-center gap-1">
                                <i class="fa-solid fa-star text-amber-400"></i> {{ $prod->averageRating() }} ({{ $prod->reviews->count() }})
                            </span>
                        </div>

                        <!-- Detalles -->
                        <div class="p-4 space-y-2">
                            <div class="flex items-start justify-between gap-2">
                                <h3 class="font-extrabold text-slate-900 dark:text-white text-sm line-clamp-1">
                                    {{ $prod->name }}
                                </h3>
                                <span class="font-black text-slate-900 dark:text-orange-400 text-sm whitespace-nowrap">
                                    ${{ number_format($prod->price, 2) }}
                                </span>
                            </div>

                            <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed">
                                {{ $prod->short_description }}
                            </p>
                        </div>
                    </div>

                    <!-- Botones de Accion para el Administrador -->
                    <div class="p-3 bg-white dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700 flex items-center justify-between gap-1.5">
                        <a href="{{ route('client.platillo', $prod->id) }}" 
                           class="flex-1 py-1.5 px-2 rounded-lg bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 font-bold text-[11px] text-center transition-colors flex items-center justify-center gap-1"
                           title="Ver como cliente y moderar comentarios">
                            <i class="fa-solid fa-comments text-blue-500"></i> Ver
                        </a>

                        <a href="{{ route('admin.productos.editar', $prod->id) }}" 
                           class="flex-1 py-1.5 px-2 rounded-lg bg-orange-50 dark:bg-orange-950/40 hover:bg-orange-100 text-orange-700 dark:text-orange-300 font-bold text-[11px] text-center transition-colors flex items-center justify-center gap-1"
                           title="Editar este alimento">
                            <i class="fa-solid fa-pen-to-square"></i> Editar
                        </a>

                        <form action="{{ route('admin.productos.eliminar', $prod->id) }}" method="POST" 
                              onsubmit="return confirm('¿Seguro que deseas eliminar \'{{ $prod->name }}\' del menú? Esta acción no se puede deshacer.');" 
                              class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="p-1.5 rounded-lg bg-red-50 dark:bg-red-950/40 hover:bg-red-100 text-red-600 dark:text-red-400 transition-colors"
                                    title="Eliminar este platillo">
                                <i class="fa-solid fa-trash-can text-xs"></i>
                            </button>
                        </form>
                    </div>

                </div>
            @empty
                <div class="col-span-full py-12 text-center text-slate-400 text-xs">
                    No hay alimentos registrados en el catálogo.
                </div>
            @endforelse
        </div>
    </div>

    <!-- SECCION: Ultimas Ordenes Registradas en Cocina -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 p-6 shadow-xs space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
            <div>
                <h2 class="text-base font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-bell-concierge text-red-600"></i> Pedidos Recientes de Cocina
                </h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">Revisa las especificaciones exactas solicitadas por cada comensal.</p>
            </div>
            <a href="{{ route('admin.pedidos') }}" class="text-xs font-bold text-red-600 hover:underline">
                Ver todas las ordenes →
            </a>
        </div>

        <div class="overflow-x-auto text-xs">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 dark:border-slate-700 text-slate-400 font-bold uppercase text-[10px]">
                        <th class="py-3 px-3">Folio</th>
                        <th class="py-3 px-3">Comensal</th>
                        <th class="py-3 px-3">Mesa / Entrega</th>
                        <th class="py-3 px-3">Platillos y Detalles Solicitados</th>
                        <th class="py-3 px-3">Estado</th>
                        <th class="py-3 px-3 text-right">Ticket</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($recentOrders as $order)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="py-3 px-3 font-mono font-extrabold text-slate-900 dark:text-white">
                                #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="py-3 px-3 font-bold text-slate-800 dark:text-slate-200">
                                {{ $order->user->name ?? 'Cliente' }}
                            </td>
                            <td class="py-3 px-3 text-slate-600 dark:text-slate-300">
                                <span class="px-2 py-0.5 rounded-md bg-slate-100 dark:bg-slate-700 font-medium text-[11px]">
                                    {{ $order->table_number }}
                                </span>
                            </td>
                            <td class="py-3 px-3">
                                <div class="space-y-1 max-w-md">
                                    @foreach($order->items as $item)
                                        <div class="text-[11px] text-slate-700 dark:text-slate-300">
                                            <strong>{{ $item->quantity }}x</strong> {{ $item->product->name ?? 'Alimento' }}
                                            @if($item->notes)
                                                <div class="text-[10px] text-amber-700 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/40 px-2 py-0.5 rounded border border-amber-200 dark:border-amber-900 inline-block">
                                                    {{ $item->notes }}
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="py-3 px-3">
                                @if($order->status === 'completado')
                                    <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300 font-extrabold text-[10px]">
                                        COMPLETADO
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300 font-extrabold text-[10px]">
                                        EN PREPARACION
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-3 text-right">
                                <a href="{{ route('client.ticket', $order->id) }}" target="_blank" class="px-3 py-1.5 bg-slate-900 dark:bg-slate-700 hover:bg-black text-white text-[11px] font-bold rounded-lg inline-flex items-center gap-1 shadow-xs">
                                    <i class="fa-solid fa-receipt text-[10px]"></i> Ticket
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-6 text-slate-400">
                                No hay pedidos registrados recientemente.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection