@extends('layouts.client')

@section('title', 'Buscar Alimentos y Bebidas')

@section('content')
<div class="space-y-8 max-w-5xl mx-auto">

    <!-- Buscador Principal -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
        <h1 class="text-xl sm:text-2xl font-black text-slate-900 mb-2 flex items-center gap-2">
            <i class="fa-solid fa-magnifying-glass text-orange-600"></i> Buscador de Alimentos y Bebidas
        </h1>
        <p class="text-xs text-slate-500 mb-6">Encuentra al instante pizzas, tortas, tacos, panaderia y bebidas por nombre o categoria.</p>

        <form action="{{ route('client.buscar') }}" method="GET" class="space-y-4">
            <div class="relative">
                <input type="text" 
                       name="q" 
                       value="{{ $query ?? '' }}"
                       placeholder="Escribe el nombre del alimento (Ej: Tacos, Pizza, Refresco...)" 
                       autofocus
                       class="w-full pl-12 pr-28 py-3.5 border-2 border-slate-200 rounded-2xl text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all bg-slate-50 focus:bg-white">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 text-base">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <button type="submit" class="absolute right-2 top-2 bottom-2 px-5 bg-orange-600 hover:bg-orange-700 text-white text-xs font-bold rounded-xl shadow-xs transition-colors">
                    Buscar
                </button>
            </div>

            <!-- Filtro Rapido de Categorias -->
            <div class="flex items-center gap-2 overflow-x-auto text-xs pt-1 pb-1 scrollbar-none">
                <span class="text-slate-400 font-bold whitespace-nowrap">Filtrar:</span>
                <a href="{{ route('client.buscar') }}" class="px-3 py-1.5 rounded-full border {{ !request('category') ? 'bg-orange-600 text-white border-orange-600' : 'bg-slate-50 text-slate-600 border-slate-200 hover:border-orange-400' }} font-semibold whitespace-nowrap transition-colors">
                    Todos
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('client.buscar', ['category' => $cat, 'q' => $query]) }}" class="px-3 py-1.5 rounded-full border {{ request('category') == $cat ? 'bg-orange-600 text-white border-orange-600' : 'bg-slate-50 text-slate-600 border-slate-200 hover:border-orange-400' }} font-semibold whitespace-nowrap capitalize transition-colors">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>
        </form>
    </div>

    <!-- Resultados de la Busqueda -->
    <div>
        <div class="flex items-center justify-between mb-4 px-1">
            <h2 class="text-sm font-extrabold text-slate-800">
                Resultados encontrados ({{ $productos->count() }})
            </h2>
            @if(!empty($query))
                <span class="text-xs text-slate-500">
                    Palabra clave: <strong class="text-slate-900">"{{ $query }}"</strong>
                </span>
            @endif
        </div>

        @if($productos->isEmpty())
            <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center shadow-xs">
                <i class="fa-solid fa-utensils text-4xl text-slate-300 mb-3 block"></i>
                <h3 class="text-base font-extrabold text-slate-800 mb-1">No encontramos platillos para tu busqueda</h3>
                <p class="text-xs text-slate-500 mb-4">Verifica que no contenga faltas de ortografia o prueba con terminos mas generales como "tacos", "pizza" o "bebida".</p>
                <a href="{{ route('client.buscar') }}" class="px-5 py-2.5 bg-orange-600 text-white rounded-full text-xs font-bold inline-flex items-center gap-2">
                    Mostrar todo el menu
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($productos as $prod)
                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs hover:shadow-md transition-all flex flex-col justify-between group">
                        <div>
                            <a href="{{ route('client.platillo', $prod->id) }}" class="block relative w-full h-44 bg-slate-100 overflow-hidden cursor-pointer">
                                <img src="{{ $prod->image }}" alt="{{ $prod->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                <span class="absolute top-3 left-3 bg-white/95 text-slate-800 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">
                                    {{ $prod->category }}
                                </span>
                            </a>
                            <div class="p-4">
                                <div class="flex items-center text-amber-500 text-xs mb-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa-solid fa-star {{ $i <= ($prod->averageRating() ?? 5) ? '' : 'text-slate-200' }}"></i>
                                    @endfor
                                    <span class="ml-1 text-[11px] font-bold text-slate-600">({{ $prod->averageRating() ?? '5.0' }})</span>
                                </div>
                                <a href="{{ route('client.platillo', $prod->id) }}">
                                    <h3 class="font-extrabold text-slate-900 text-sm mb-1 group-hover:text-orange-600 transition-colors">
                                        {{ $prod->name }}
                                    </h3>
                                </a>
                                <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                    {{ $prod->short_description ?? $prod->description }}
                                </p>
                            </div>
                        </div>

                        <div class="p-4 pt-0 border-t border-slate-50 flex items-center justify-between mt-2">
                            <span class="text-lg font-black text-slate-900">${{ number_format($prod->price, 2) }}</span>
                            <a href="{{ route('client.platillo', $prod->id) }}" class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white text-xs font-bold rounded-xl shadow-xs transition-all flex items-center gap-1.5">
                                <i class="fa-solid fa-plus text-xs"></i> Agregar
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection
