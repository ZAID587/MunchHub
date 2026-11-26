@extends('layouts.admin')

@section('title', 'Gestion de Productos y Alimentos')

@section('content')
<div class="space-y-8">

    <!-- Encabezado con Filtros y Boton Nuevo -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-xs">
        <div>
            <h1 class="text-2xl font-black text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-burger text-red-600"></i> Catalogo de Alimentos y Bebidas
            </h1>
            <p class="text-xs text-slate-500 mt-1">Organiza platillos, actualiza precios, categorias e imagenes.</p>
        </div>

        <a href="{{ route('admin.productos.crear') }}" class="px-5 py-3 bg-red-600 hover:bg-red-700 text-white font-extrabold text-xs rounded-2xl shadow-md shadow-red-500/20 transition-all flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Agregar Nuevo Platillo
        </a>
    </div>

    <!-- Buscador y Filtro de Categorias -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
        <form action="{{ route('admin.productos') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3 text-xs">
            <div class="relative flex-1 w-full">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar por nombre de alimento..."
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-red-500 focus:outline-none bg-slate-50 focus:bg-white text-slate-800">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
            </div>

            <div class="w-full sm:w-56">
                <select name="category" onchange="this.form.submit()" class="w-full p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-red-500 focus:outline-none bg-slate-50 text-slate-700">
                    <option value="todas">Todas las categorias</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-slate-900 hover:bg-black text-white font-bold rounded-xl transition-colors">
                Filtrar
            </button>
            @if(request('q') || request('category'))
                <a href="{{ route('admin.productos') }}" class="text-xs text-red-600 font-bold hover:underline whitespace-nowrap">
                    Limpiar
                </a>
            @endif
        </form>
    </div>

    <!-- Tabla Organizada de Productos -->
    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-xs">
        <div class="overflow-x-auto text-xs">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-extrabold uppercase text-[10px]">
                        <th class="py-3.5 px-4">Alimento</th>
                        <th class="py-3.5 px-4">Categoria</th>
                        <th class="py-3.5 px-4">Precio</th>
                        <th class="py-3.5 px-4">Calificacion</th>
                        <th class="py-3.5 px-4">Tiempo</th>
                        <th class="py-3.5 px-4">Estado</th>
                        <th class="py-3.5 px-4 text-right">Accion</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($productos as $prod)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden flex-shrink-0 border border-slate-200">
                                        <img src="{{ $prod->image }}" alt="{{ $prod->name }}" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <span class="font-extrabold text-slate-900 block text-xs">{{ $prod->name }}</span>
                                        <span class="text-[11px] text-slate-400 block line-clamp-1">{{ $prod->short_description }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4 font-semibold text-slate-700">
                                <span class="px-2.5 py-1 bg-slate-100 rounded-full text-[10px] uppercase font-bold text-slate-600">
                                    {{ $prod->category }}
                                </span>
                            </td>
                            <td class="py-3 px-4 font-black font-mono text-slate-900 text-sm">
                                ${{ number_format($prod->price, 2) }}
                            </td>
                            <td class="py-3 px-4">
                                <span class="text-amber-500 font-bold text-xs flex items-center gap-1">
                                    <i class="fa-solid fa-star"></i> {{ $prod->averageRating() }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-slate-500">
                                {{ $prod->prep_time ?? '15 min' }}
                            </td>
                            <td class="py-3 px-4">
                                @if($prod->is_best_seller)
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-orange-100 text-orange-800">
                                        Top Venta
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">
                                        Estandar
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right">
                                <a href="{{ route('admin.productos.editar', $prod->id) }}" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-900 hover:text-white text-slate-700 font-bold rounded-xl transition-all inline-flex items-center gap-1">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i> Editar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
