@extends('layouts.client')

@section('title', $producto->name . ' - Personalizar Platillo')

@section('content')
<div class="space-y-10 max-w-6xl mx-auto">

    <!-- 1. Breadcrumbs de navegacion -->
    <nav class="flex items-center text-xs text-slate-400 gap-2">
        <a href="{{ route('home') }}" class="hover:text-orange-600 transition-colors">Inicio</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <a href="{{ route('home', ['category' => $producto->category]) }}" class="hover:text-orange-600 capitalize transition-colors">{{ $producto->category }}</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 font-semibold">{{ $producto->name }}</span>
    </nav>

    <!-- 2. Tarjeta Principal de Producto y Opciones -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-10 shadow-sm">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            
            <!-- Columna Izquierda: Imagen Grande y Badges -->
            <div class="lg:col-span-5 space-y-4">
                <div class="relative w-full aspect-square rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 shadow-xs">
                    <img src="{{ $producto->image }}" 
                         alt="{{ $producto->name }}" 
                         class="w-full h-full object-cover"
                         onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&auto=format&fit=crop&q=60';">
                    
                    <span class="absolute top-3 left-3 bg-white/95 backdrop-blur-sm text-slate-800 text-xs font-extrabold px-3 py-1 rounded-full shadow-xs uppercase">
                        {{ $producto->category }}
                    </span>
                </div>

                <div class="grid grid-cols-3 gap-2 text-center text-[11px] text-slate-600">
                    <div class="p-2.5 bg-slate-50 rounded-xl border border-slate-100">
                        <i class="fa-solid fa-clock text-orange-600 block text-base mb-1"></i>
                        <span class="font-bold text-slate-800">{{ $producto->prep_time ?? '15 min' }}</span>
                        <span class="block text-[10px] text-slate-400">Preparacion</span>
                    </div>
                    <div class="p-2.5 bg-slate-50 rounded-xl border border-slate-100">
                        <i class="fa-solid fa-utensils text-emerald-600 block text-base mb-1"></i>
                        <span class="font-bold text-slate-800">Al Momento</span>
                        <span class="block text-[10px] text-slate-400">Coccion</span>
                    </div>
                    <div class="p-2.5 bg-slate-50 rounded-xl border border-slate-100">
                        <i class="fa-solid fa-shield-heart text-blue-600 block text-base mb-1"></i>
                        <span class="font-bold text-slate-800">100% Fresco</span>
                        <span class="block text-[10px] text-slate-400">Garantia</span>
                    </div>
                </div>
            </div>

            <!-- Columna Derecha: Detalles y Formulario de Personalizacion -->
            <div class="lg:col-span-7 space-y-6">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="flex items-center text-amber-500 text-sm">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-solid fa-star {{ $i <= $producto->averageRating() ? '' : 'text-slate-200' }}"></i>
                            @endfor
                            <span class="ml-2 font-extrabold text-slate-800 text-sm">{{ $producto->averageRating() }}</span>
                        </div>
                        <span class="text-xs text-slate-400">• {{ $producto->reviews->count() }} calificaciones verificadas</span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight">
                        {{ $producto->name }}
                    </h1>

                    <div class="mt-3 flex items-baseline gap-2">
                        <span class="text-3xl font-black text-slate-900">${{ number_format($producto->price, 2) }}</span>
                        <span class="text-xs text-slate-400 font-medium">IVA y empaque incluidos</span>
                    </div>

                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mt-3 border-b border-slate-100 pb-4">
                        {{ $producto->description ?? $producto->short_description }}
                    </p>
                </div>

                <!-- FORMULARIO DE PERSONALIZACION -->
                <form action="{{ route('client.agregar', $producto->id) }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- OPCIONES DINAMICAS SEGUN LA CATEGORIA -->

                    <!-- Caso A: Bebidas -->
                    @if(Str::contains(strtolower($producto->category), ['bebida', 'refresco', 'agua', 'jugo']))
                        <div class="space-y-3 p-4 bg-blue-50/50 rounded-2xl border border-blue-100">
                            <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider">
                                <i class="fa-solid fa-temperature-three-quarters text-blue-600"></i> Temperatura y Presentacion:
                            </label>
                            <div class="grid grid-cols-3 gap-2 text-xs">
                                <label class="flex items-center justify-center gap-2 p-2.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-blue-400 has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50 has-[:checked]:text-blue-800 font-semibold transition-all">
                                    <input type="radio" name="temperature" value="Bien Fria de Refrigerador" checked class="hidden">
                                    <span>🧊 Bien Fria</span>
                                </label>
                                <label class="flex items-center justify-center gap-2 p-2.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-blue-400 has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50 has-[:checked]:text-blue-800 font-semibold transition-all">
                                    <input type="radio" name="temperature" value="Al Tiempo" class="hidden">
                                    <span>🌡️ Al Tiempo</span>
                                </label>
                                <label class="flex items-center justify-center gap-2 p-2.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-blue-400 has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50 has-[:checked]:text-blue-800 font-semibold transition-all">
                                    <input type="radio" name="temperature" value="Con Hielo y Limon" class="hidden">
                                    <span>🍋 Con Hielo</span>
                                </label>
                            </div>

                            <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider pt-2">
                                <i class="fa-solid fa-bottle-droplet text-blue-600"></i> Tamaño:
                            </label>
                            <div class="grid grid-cols-3 gap-2 text-xs">
                                <label class="flex items-center justify-center p-2.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-blue-400 has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50 has-[:checked]:text-blue-800 font-semibold transition-all">
                                    <input type="radio" name="size" value="Lata 355 ml" checked class="hidden">
                                    <span>355 ml (Lata)</span>
                                </label>
                                <label class="flex items-center justify-center p-2.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-blue-400 has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50 has-[:checked]:text-blue-800 font-semibold transition-all">
                                    <input type="radio" name="size" value="Botella 600 ml" class="hidden">
                                    <span>600 ml</span>
                                </label>
                                <label class="flex items-center justify-center p-2.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-blue-400 has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50 has-[:checked]:text-blue-800 font-semibold transition-all">
                                    <input type="radio" name="size" value="Jarra 1 Litro" class="hidden">
                                    <span>1 Litro</span>
                                </label>
                            </div>
                        </div>

                    <!-- Caso B: Pizzas -->
                    @elseif(Str::contains(strtolower($producto->category), ['pizza']))
                        <div class="space-y-3 p-4 bg-amber-50/50 rounded-2xl border border-amber-100">
                            <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider">
                                <i class="fa-solid fa-pizza-slice text-amber-600"></i> Tamaño de Pizza:
                            </label>
                            <div class="grid grid-cols-3 gap-2 text-xs">
                                <label class="flex items-center justify-center p-2.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-amber-400 has-[:checked]:border-amber-600 has-[:checked]:bg-amber-50 has-[:checked]:text-amber-900 font-semibold transition-all">
                                    <input type="radio" name="size" value="Individual (4 rebanadas)" class="hidden">
                                    <span>Individual (4 reb.)</span>
                                </label>
                                <label class="flex items-center justify-center p-2.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-amber-400 has-[:checked]:border-amber-600 has-[:checked]:bg-amber-50 has-[:checked]:text-amber-900 font-semibold transition-all">
                                    <input type="radio" name="size" value="Mediana (8 rebanadas)" checked class="hidden">
                                    <span>Mediana (8 reb.)</span>
                                </label>
                                <label class="flex items-center justify-center p-2.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-amber-400 has-[:checked]:border-amber-600 has-[:checked]:bg-amber-50 has-[:checked]:text-amber-900 font-semibold transition-all">
                                    <input type="radio" name="size" value="Familiar (12 rebanadas)" class="hidden">
                                    <span>Familiar (12 reb.)</span>
                                </label>
                            </div>

                            <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider pt-2">
                                <i class="fa-solid fa-circle-check text-amber-600"></i> Opciones de Cocina:
                            </label>
                            <div class="grid grid-cols-2 gap-2 text-xs">
                                <label class="flex items-center gap-2 p-2 bg-white border border-slate-200 rounded-xl cursor-pointer">
                                    <input type="checkbox" name="custom_ingredients[]" value="Masa Bien Dorada" class="rounded text-orange-600">
                                    <span>Masa bien crujiente</span>
                                </label>
                                <label class="flex items-center gap-2 p-2 bg-white border border-slate-200 rounded-xl cursor-pointer">
                                    <input type="checkbox" name="custom_ingredients[]" value="Orilla con Queso" class="rounded text-orange-600">
                                    <span>Orilla de queso</span>
                                </label>
                                <label class="flex items-center gap-2 p-2 bg-white border border-slate-200 rounded-xl cursor-pointer">
                                    <input type="checkbox" name="custom_ingredients[]" value="Sin Oregano" class="rounded text-orange-600">
                                    <span>Sin oregano</span>
                                </label>
                                <label class="flex items-center gap-2 p-2 bg-white border border-slate-200 rounded-xl cursor-pointer">
                                    <input type="checkbox" name="custom_ingredients[]" value="Salsa Picante Aparte" class="rounded text-orange-600">
                                    <span>Salsa picante aparte</span>
                                </label>
                            </div>
                        </div>

                    <!-- Caso C: Panaderia -->
                    @elseif(Str::contains(strtolower($producto->category), ['pan', 'postre']))
                        <div class="space-y-3 p-4 bg-orange-50/50 rounded-2xl border border-orange-100">
                            <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider">
                                <i class="fa-solid fa-bread-slice text-orange-600"></i> Selecciona el Tipo de Pan:
                            </label>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs">
                                <label class="flex items-center justify-center p-2.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-orange-400 has-[:checked]:border-orange-600 has-[:checked]:bg-orange-50 font-semibold transition-all">
                                    <input type="radio" name="bread_type" value="Bolillo Artesanal" checked class="hidden">
                                    <span>Bolillo</span>
                                </label>
                                <label class="flex items-center justify-center p-2.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-orange-400 has-[:checked]:border-orange-600 has-[:checked]:bg-orange-50 font-semibold transition-all">
                                    <input type="radio" name="bread_type" value="Telera Suave" class="hidden">
                                    <span>Telera</span>
                                </label>
                                <label class="flex items-center justify-center p-2.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-orange-400 has-[:checked]:border-orange-600 has-[:checked]:bg-orange-50 font-semibold transition-all">
                                    <input type="radio" name="bread_type" value="Pan Dulce Surtido" class="hidden">
                                    <span>Pan Dulce</span>
                                </label>
                                <label class="flex items-center justify-center p-2.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-orange-400 has-[:checked]:border-orange-600 has-[:checked]:bg-orange-50 font-semibold transition-all">
                                    <input type="radio" name="bread_type" value="Pan Brioche con Mantequilla" class="hidden">
                                    <span>Brioche</span>
                                </label>
                            </div>

                            <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider pt-2">
                                <i class="fa-solid fa-fire text-orange-600"></i> Preparacion:
                            </label>
                            <div class="grid grid-cols-2 gap-2 text-xs">
                                <label class="flex items-center gap-2 p-2 bg-white border border-slate-200 rounded-xl cursor-pointer">
                                    <input type="checkbox" name="custom_ingredients[]" value="Calientito Tostado" class="rounded text-orange-600">
                                    <span>Calientito / Tostado</span>
                                </label>
                                <label class="flex items-center gap-2 p-2 bg-white border border-slate-200 rounded-xl cursor-pointer">
                                    <input type="checkbox" name="custom_ingredients[]" value="Con Mantequilla Extra" class="rounded text-orange-600">
                                    <span>Mantequilla extra</span>
                                </label>
                            </div>
                        </div>

                    <!-- Caso D: Cafetería Gardello -->
                    @elseif(Str::contains(strtolower($producto->category), ['cafetería', 'cafe', 'cafeteria']))
                        <div class="space-y-3 p-4 bg-amber-950/10 rounded-2xl border border-amber-950/20">
                            <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider">
                                <i class="fa-solid fa-mug-hot text-amber-800"></i> Tamaño de Café:
                            </label>
                            <div class="grid grid-cols-2 gap-2 text-xs">
                                <label class="flex items-center justify-center p-2.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-amber-600 has-[:checked]:border-amber-700 has-[:checked]:bg-amber-50 font-bold transition-all">
                                    <input type="radio" name="size" value="Chico (8 oz)" checked class="hidden">
                                    <span>☕ Chico (8 oz)</span>
                                </label>
                                <label class="flex items-center justify-center p-2.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-amber-600 has-[:checked]:border-amber-700 has-[:checked]:bg-amber-50 font-bold transition-all">
                                    <input type="radio" name="size" value="Grande (16 oz)" class="hidden">
                                    <span>🥤 Grande (16 oz)</span>
                                </label>
                            </div>

                            <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider pt-2">
                                <i class="fa-solid fa-temperature-half text-amber-800"></i> Temperatura / Preparación:
                            </label>
                            <div class="grid grid-cols-3 gap-2 text-xs">
                                <label class="flex items-center justify-center p-2.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-amber-600 has-[:checked]:border-amber-700 has-[:checked]:bg-amber-50 font-semibold transition-all">
                                    <input type="radio" name="temperature" value="Bien Caliente" checked class="hidden">
                                    <span>🔥 Caliente</span>
                                </label>
                                <label class="flex items-center justify-center p-2.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-amber-600 has-[:checked]:border-amber-700 has-[:checked]:bg-amber-50 font-semibold transition-all">
                                    <input type="radio" name="temperature" value="Frappé con Hielo" class="hidden">
                                    <span>🧊 Frappé</span>
                                </label>
                                <label class="flex items-center justify-center p-2.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-amber-600 has-[:checked]:border-amber-700 has-[:checked]:bg-amber-50 font-semibold transition-all">
                                    <input type="radio" name="temperature" value="Tibio con Leche" class="hidden">
                                    <span>☕ Tibio</span>
                                </label>
                            </div>
                        </div>

                    <!-- Caso E: Tortas, Tacos, Hamburguesas, Papas y General -->
                    @else
                        <div class="space-y-3 p-4 bg-slate-50 rounded-2xl border border-slate-200">
                            <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider">
                                <i class="fa-solid fa-list-check text-orange-600"></i> ¿Cómo quieres tu orden? (Elige tus especificaciones):
                            </label>
                            
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 text-xs">
                                <label class="flex items-center gap-2 p-2.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-orange-300">
                                    <input type="checkbox" name="custom_ingredients[]" id="check-con-todo" value="Con Todo" checked class="rounded text-orange-600">
                                    <span class="font-bold text-slate-800">Con Todo</span>
                                </label>
                                @foreach($producto->ingredients_list as $ing)
                                    <label class="flex items-center gap-2 p-2.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-orange-300">
                                        <input type="checkbox" name="custom_ingredients[]" value="Sin {{ $ing }}" class="rounded text-orange-600" onchange="document.getElementById('check-con-todo').checked = false;">
                                        <span class="text-red-700 font-medium">Sin {{ $ing }}</span>
                                    </label>
                                @endforeach
                                <label class="flex items-center gap-2 p-2.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-orange-300">
                                    <input type="checkbox" name="custom_ingredients[]" value="Salsas Aparte" class="rounded text-orange-600">
                                    <span class="text-emerald-700 font-semibold">Salsas Aparte</span>
                                </label>
                            </div>
                        </div>
                    @endif

                    <!-- Campo de texto libre para indicaciones especiales -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">
                            Indicaciones adicionales al cocinero (Opcional):
                        </label>
                        <input type="text" name="special_notes" maxlength="200" 
                               placeholder="Ej: Salsa roja muy picosa aparte, papas bien doraditas..." 
                               class="w-full p-3 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-orange-500 focus:outline-none text-slate-700 bg-slate-50 focus:bg-white">
                    </div>

                    <!-- Selector de Cantidad y Boton Agregar -->
                    <div class="flex items-center gap-4 pt-3 border-t border-slate-100">
                        <div class="flex items-center border-2 border-slate-200 rounded-2xl bg-white p-1 shadow-xs">
                            <button type="button" onclick="decrementQty()" class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-black text-sm flex items-center justify-center transition-colors">
                                -
                            </button>
                            <input type="number" name="quantity" id="quantityInput" value="1" min="1" max="30" readonly 
                                   class="w-12 text-center text-sm font-extrabold text-slate-900 border-none bg-transparent focus:outline-none">
                            <button type="button" onclick="incrementQty()" class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-black text-sm flex items-center justify-center transition-colors">
                                +
                            </button>
                        </div>

                        <button type="submit" class="flex-1 py-3.5 px-6 bg-orange-600 hover:bg-orange-700 text-white font-extrabold text-sm rounded-2xl shadow-lg shadow-orange-600/30 transition-all flex items-center justify-center gap-2 transform active:scale-95">
                            <i class="fa-solid fa-cart-plus text-base"></i> Agregar al Carrito
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>

    <!-- 3. Seccion de Calificar Platillo y Comentarios Reales -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Formulario para dejar opinion -->
        <div class="lg:col-span-5 bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-xs">
            <h3 class="text-base font-extrabold text-slate-900 mb-1 flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-orange-600"></i> Califica este Platillo
            </h3>
            <p class="text-xs text-slate-500 mb-5">Tu experiencia ayuda a otros clientes a elegir lo mejor del menu.</p>

            @auth
                <form action="{{ route('client.review', $producto->id) }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    
                    <div>
                        <label class="block font-bold text-slate-700 mb-2">Selecciona tu calificacion:</label>
                        <div class="flex items-center gap-3 text-2xl text-amber-400">
                            @for($r = 5; $r >= 1; $r--)
                                <label class="cursor-pointer hover:scale-110 transition-transform">
                                    <input type="radio" name="rating" value="{{ $r }}" {{ $r == 5 ? 'checked' : '' }} class="hidden peer">
                                    <i class="fa-solid fa-star peer-checked:text-amber-500 text-slate-200"></i>
                                </label>
                            @endfor
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Tu opinion o recomendacion:</label>
                        <textarea name="comment" rows="3" required placeholder="¿Que te parecio el sabor, la temperatura y la presentacion?"
                                  class="w-full p-3 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-orange-500 focus:outline-none"></textarea>
                    </div>

                    <button type="submit" class="w-full py-2.5 bg-slate-900 hover:bg-orange-600 text-white font-bold rounded-xl transition-colors shadow-xs">
                        Publicar Calificacion
                    </button>
                </form>
            @else
                <div class="p-6 bg-slate-50 rounded-2xl text-center border border-slate-200">
                    <i class="fa-solid fa-lock text-slate-400 text-2xl mb-2"></i>
                    <p class="text-xs text-slate-600 mb-3">Debes iniciar sesion para poder calificar este platillo.</p>
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-orange-600 text-white font-bold rounded-full text-xs inline-block">
                        Iniciar Sesion
                    </a>
                </div>
            @endauth
        </div>

        <!-- Lista de Comentarios Realizados -->
        <div class="lg:col-span-7 bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-xs">
            <h3 class="text-base font-extrabold text-slate-900 mb-4 flex items-center justify-between">
                <span>Opiniones de Comensales ({{ $producto->reviews->count() }})</span>
                <span class="text-xs text-amber-500 font-bold flex items-center gap-1">
                    <i class="fa-solid fa-star"></i> {{ $producto->averageRating() }} / 5.0
                </span>
            </h3>

            <div class="space-y-4 max-h-96 overflow-y-auto pr-2">
                @forelse($producto->reviews as $rev)
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-2">
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-extrabold text-slate-900">{{ $rev->user->name ?? 'Comensal' }}</span>
                            <div class="flex items-center text-amber-500 text-[11px]">
                                @for($s = 1; $s <= 5; $s++)
                                    <i class="fa-solid fa-star {{ $s <= $rev->rating ? '' : 'text-slate-200' }}"></i>
                                @endfor
                            </div>
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed italic">
                            "{{ $rev->comment }}"
                        </p>
                        <span class="text-[10px] text-slate-400 block text-right">{{ $rev->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <div class="text-center py-8 text-xs text-slate-400">
                        Aun no hay reseñas para este platillo. ¡Se el primero en calificarlo!
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    <!-- 4. Productos Relacionados de la Misma Categoria -->
    @if($relacionados->isNotEmpty())
        <div>
            <h3 class="text-lg font-extrabold text-slate-900 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-utensils text-orange-600"></i> Tambien te podria gustar
            </h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                @foreach($relacionados as $rel)
                    <a href="{{ route('client.platillo', $rel->id) }}" class="bg-white p-3 rounded-2xl border border-slate-200 shadow-xs hover:shadow-md transition-all group block">
                        <div class="w-full aspect-square rounded-xl overflow-hidden bg-slate-100 mb-2">
                            <img src="{{ $rel->image }}" alt="{{ $rel->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        </div>
                        <h4 class="text-xs font-bold text-slate-800 truncate group-hover:text-orange-600">{{ $rel->name }}</h4>
                        <div class="flex items-center justify-between mt-1">
                            <span class="text-xs font-black text-slate-900">${{ number_format($rel->price, 2) }}</span>
                            <span class="text-[10px] text-amber-500 font-bold"><i class="fa-solid fa-star"></i> {{ $rel->averageRating() }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

</div>

@push('scripts')
<script>
    function incrementQty() {
        var input = document.getElementById('quantityInput');
        var val = parseInt(input.value) || 1;
        if (val < 30) {
            input.value = val + 1;
        }
    }
    function decrementQty() {
        var input = document.getElementById('quantityInput');
        var val = parseInt(input.value) || 1;
        if (val > 1) {
            input.value = val - 1;
        }
    }
</script>
@endpush
@endsection
