@extends('layouts.client')

@section('title', 'Menu y Catalogo Completo')

@section('content')
<div class="space-y-12">

    <!-- 1. Hero Banner Principal con Imagen de Comida de Fondo (Inspirado en Buscamed) -->
    <div class="relative rounded-3xl overflow-hidden shadow-xl border border-slate-200">
        <div class="absolute inset-0 bg-cover bg-center" 
             style="background-image: url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=1600&auto=format&fit=crop&q=80');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/90 via-slate-900/80 to-transparent"></div>
        
        <div class="relative z-10 p-8 sm:p-12 lg:p-16 max-w-2xl text-white">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-orange-600/90 text-white text-xs font-bold uppercase tracking-wider mb-4 backdrop-blur-sm shadow-sm">
                <i class="fa-solid fa-fire text-amber-300"></i> Lo mas vendido de la semana
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight leading-tight mb-4">
                Disfruta el sabor autentico, preparado al momento.
            </h1>
            <p class="text-slate-200 text-sm sm:text-base leading-relaxed mb-8">
                Pizzas a la piedra con masa artesanal, tortas con pan telera dorado, tacos con carne marinada, papas sazonadas y bebidas bien frias.
            </p>
            <div class="flex flex-wrap items-center gap-3">
                <a href="#catalogo" class="px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-bold text-sm rounded-full shadow-lg shadow-orange-600/30 transition-all flex items-center gap-2">
                    <i class="fa-solid fa-utensils"></i> Explorar Catalogo
                </a>
                <a href="{{ route('client.buscar') }}" class="px-6 py-3 bg-white/20 hover:bg-white/30 text-white font-bold text-sm rounded-full backdrop-blur-md transition-all flex items-center gap-2">
                    <i class="fa-solid fa-magnifying-glass"></i> Buscador Avanzado
                </a>
            </div>
        </div>
    </div>

    <!-- 2. Seccion: "Lo mas vendido" (Carrusel / Tarjetas destacadas) -->
    <div>
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-star text-amber-500"></i> Lo mas vendido
                </h2>
                <p class="text-xs text-slate-500">Los platillos y bebidas preferidos por nuestra comunidad universitaria y local.</p>
            </div>
            <span class="text-xs font-semibold text-orange-600 bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                Garantia de Sabor
            </span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($masVendidos as $item)
                <div class="bg-white rounded-2xl border border-slate-200 p-3 shadow-xs hover:shadow-md transition-all flex flex-col justify-between group">
                    <div>
                        <a href="{{ route('client.platillo', $item->id) }}" class="block relative w-full aspect-square rounded-xl overflow-hidden bg-slate-100 mb-3 cursor-pointer">
                            <img src="{{ $item->image }}" 
                                 alt="{{ $item->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                 onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&auto=format&fit=crop&q=60';">
                            <span class="absolute top-2 left-2 bg-orange-600 text-white text-[10px] font-extrabold px-2 py-0.5 rounded-full">
                                TOP
                            </span>
                        </a>
                        <span class="text-[10px] font-bold uppercase text-orange-600 tracking-wider block mb-1">
                            {{ $item->category }}
                        </span>
                        <a href="{{ route('client.platillo', $item->id) }}">
                            <h3 class="text-xs font-bold text-slate-800 line-clamp-1 mb-1 hover:text-orange-600 transition-colors" title="{{ $item->name }}">
                                {{ $item->name }}
                            </h3>
                        </a>
                        <div class="flex items-center text-amber-500 text-[11px] mb-2">
                            <i class="fa-solid fa-star"></i>
                            <span class="ml-1 font-bold text-slate-700">{{ $item->averageRating() ?? '5.0' }}</span>
                        </div>
                    </div>
                    <div>
                        <div class="text-sm font-extrabold text-slate-900 mb-2">
                            ${{ number_format($item->price, 2) }}
                        </div>
                        <a href="{{ route('client.platillo', $item->id) }}" class="w-full py-1.5 bg-slate-900 hover:bg-orange-600 text-white text-[11px] font-bold rounded-lg text-center block transition-colors">
                            <i class="fa-solid fa-plus text-[10px] mr-1"></i> Agregar
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- 3. Seccion Principal: Filtros a la Izquierda y Catalogo Completo a la Derecha (Inspirado en Buscamed) -->
    <div id="catalogo" class="pt-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- Barra Lateral Izquierda: Filtros de Categoria, Rango de Precio y Disponibilidad -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs sticky top-28">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
                        <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                            <i class="fa-solid fa-sliders text-orange-600"></i> Filtros de Busqueda
                        </h3>
                        @if(request('category') || request('min_price') || request('max_price') || request('disponibilidad') || request('q'))
                            <a href="{{ route('home') }}" class="text-[11px] font-semibold text-orange-600 hover:underline">
                                Limpiar
                            </a>
                        @endif
                    </div>

                    <form action="{{ route('home') }}" method="GET" id="filtersForm" class="space-y-6 text-xs">
                        
                        <!-- Preservar busqueda de texto si existe -->
                        @if(request('q'))
                            <input type="hidden" name="q" value="{{ request('q') }}">
                        @endif

                        <!-- Categorias -->
                        <div>
                            <label class="block font-bold text-slate-800 mb-2.5 uppercase tracking-wider text-[11px]">
                                Categorias
                            </label>
                            <div class="space-y-1.5 max-h-48 overflow-y-auto pr-1">
                                <label class="flex items-center gap-2 text-slate-700 cursor-pointer hover:text-orange-600 py-1">
                                    <input type="radio" name="category" value="todos" onchange="this.form.submit()" 
                                           {{ !request('category') || request('category') == 'todos' ? 'checked' : '' }}
                                           class="text-orange-600 focus:ring-orange-500">
                                    <span class="font-medium">Todas las categorias</span>
                                </label>
                                @foreach($categories as $cat)
                                    <label class="flex items-center gap-2 text-slate-700 cursor-pointer hover:text-orange-600 py-1">
                                        <input type="radio" name="category" value="{{ $cat }}" onchange="this.form.submit()"
                                               {{ request('category') == $cat ? 'checked' : '' }}
                                               class="text-orange-600 focus:ring-orange-500">
                                        <span class="capitalize font-medium">{{ $cat }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Rango de Precios -->
                        <div class="border-t border-slate-100 pt-4">
                            <label class="block font-bold text-slate-800 mb-2.5 uppercase tracking-wider text-[11px]">
                                Rango de Precio
                            </label>
                            <div class="grid grid-cols-2 gap-2 mb-3">
                                <div>
                                    <span class="text-[10px] text-slate-400 block mb-1">Minimo ($)</span>
                                    <input type="number" name="min_price" value="{{ request('min_price', 10) }}" min="0" max="500" 
                                           class="w-full p-2 border border-slate-200 rounded-lg text-slate-700 text-xs focus:ring-2 focus:ring-orange-500 focus:outline-none">
                                </div>
                                <div>
                                    <span class="text-[10px] text-slate-400 block mb-1">Maximo ($)</span>
                                    <input type="number" name="max_price" value="{{ request('max_price', 300) }}" min="10" max="1000" 
                                           class="w-full p-2 border border-slate-200 rounded-lg text-slate-700 text-xs focus:ring-2 focus:ring-orange-500 focus:outline-none">
                                </div>
                            </div>
                            <button type="submit" class="w-full py-2 bg-slate-100 hover:bg-orange-600 hover:text-white text-slate-700 font-bold rounded-lg transition-colors text-xs">
                                Aplicar Rango
                            </button>
                        </div>

                        <!-- Disponibilidad y Promociones -->
                        <div class="border-t border-slate-100 pt-4">
                            <label class="block font-bold text-slate-800 mb-2.5 uppercase tracking-wider text-[11px]">
                                Disponibilidad
                            </label>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-slate-700 cursor-pointer">
                                    <input type="checkbox" name="disponibilidad" value="oferta" onchange="this.form.submit()"
                                           {{ request('disponibilidad') == 'oferta' ? 'checked' : '' }}
                                           class="rounded text-orange-600 focus:ring-orange-500">
                                    <span>Solo mas vendidos / Ofertas</span>
                                </label>
                            </div>
                        </div>

                        <!-- Certificaciones de Confianza (Estilo Buscamed) -->
                        <div class="border-t border-slate-100 pt-4 space-y-2.5 text-[11px] text-slate-500">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-check-circle text-emerald-600"></i>
                                <span>Ingredientes 100% frescos</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-fire text-amber-500"></i>
                                <span>Horneado al momento</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-shield-halved text-blue-600"></i>
                                <span>Higiene certificada</span>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

            <!-- Columna Derecha: Catalogo Completo de Productos -->
            <div class="lg:col-span-3">
                <div class="flex items-center justify-between mb-4 bg-white p-3.5 rounded-xl border border-slate-200 text-xs">
                    <span class="font-bold text-slate-700">
                        Mostrando <strong class="text-orange-600">{{ $productos->count() }}</strong> alimentos y bebidas disponibles
                    </span>
                    @if(request('category') && request('category') !== 'todos')
                        <span class="bg-orange-100 text-orange-800 px-2.5 py-0.5 rounded-full font-bold capitalize">
                            Categoria: {{ request('category') }}
                        </span>
                    @endif
                </div>

                @if($productos->isEmpty())
                    <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
                        <i class="fa-solid fa-utensils text-4xl text-slate-300 mb-3"></i>
                        <h3 class="text-base font-bold text-slate-800 mb-1">No se encontraron productos</h3>
                        <p class="text-xs text-slate-500 mb-4">Intenta cambiar los filtros de precio o la categoria seleccionada.</p>
                        <a href="{{ route('home') }}" class="px-4 py-2 bg-orange-600 text-white rounded-full text-xs font-bold inline-flex items-center gap-1.5">
                            Ver todo el menu
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                        @foreach($productos as $prod)
                            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs hover:shadow-lg transition-all flex flex-col justify-between group">
                                <div>
                                    <!-- Imagen con etiqueta de categoria y estrellas (Clickeable) -->
                                    <a href="{{ route('client.platillo', $prod->id) }}" class="block relative w-full h-44 bg-slate-100 overflow-hidden cursor-pointer">
                                        <img src="{{ $prod->image }}" 
                                             alt="{{ $prod->name }}" 
                                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                             onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&auto=format&fit=crop&q=60';">
                                        
                                        <span class="absolute top-3 left-3 bg-white/95 backdrop-blur-sm text-slate-800 text-[10px] font-bold px-2.5 py-1 rounded-full shadow-xs uppercase">
                                            {{ $prod->category }}
                                        </span>

                                        @if($prod->is_best_seller)
                                            <span class="absolute top-3 right-3 bg-orange-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-xs">
                                                Popular
                                            </span>
                                        @endif
                                    </a>

                                    <!-- Informacion del Platillo -->
                                    <div class="p-4">
                                        <div class="flex items-center justify-between mb-1">
                                            <div class="flex items-center text-amber-500 text-xs">
                                                @php $rating = $prod->averageRating() ?? 5; @endphp
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fa-solid fa-star {{ $i <= $rating ? '' : 'text-slate-200' }}"></i>
                                                @endfor
                                                <span class="ml-1.5 text-[11px] font-bold text-slate-600">({{ $prod->reviews->count() }})</span>
                                            </div>
                                            <span class="text-[11px] text-slate-400 flex items-center gap-1">
                                                <i class="fa-solid fa-stopwatch text-slate-400"></i> {{ $prod->prep_time ?? '15 min' }}
                                            </span>
                                        </div>

                                        <a href="{{ route('client.platillo', $prod->id) }}">
                                            <h3 class="font-extrabold text-slate-900 text-sm mb-1.5 group-hover:text-orange-600 transition-colors">
                                                {{ $prod->name }}
                                            </h3>
                                        </a>

                                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed mb-3">
                                            {{ $prod->short_description ?? $prod->description }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Precio y Accion de Agregar -->
                                <div class="p-4 pt-0 border-t border-slate-50 flex items-center justify-between mt-2">
                                    <div>
                                        <span class="text-[10px] text-slate-400 block font-medium">Precio</span>
                                        <span class="text-lg font-black text-slate-900">${{ number_format($prod->price, 2) }}</span>
                                    </div>
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
    </div>

    <!-- 4. Recuadro de Asistente WhatsApp Zaid (Inspirado en Buscamed) -->
    <div class="bg-gradient-to-r from-emerald-600 to-teal-700 rounded-3xl p-8 sm:p-10 text-white shadow-lg flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 rounded-2xl bg-white text-emerald-600 flex items-center justify-center font-bold text-3xl shadow-md flex-shrink-0">
                <i class="fa-brands fa-whatsapp text-3xl text-emerald-600"></i>
            </div>
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-200">Atención Directa y Personalizada</span>
                <h3 class="text-xl sm:text-2xl font-black mt-0.5">Hola, soy Zaid y estoy aquí para apoyarte</h3>
                <p class="text-xs sm:text-sm text-emerald-100 mt-1 max-w-xl">
                    Si tienes dudas sobre algún platillo, ingredientes para personas con alergias o necesitas confirmar tu orden, escríbeme por WhatsApp y lo resolvemos juntos al instante.
                </p>
            </div>
        </div>
        <a href="https://wa.me/527227705013?text=Hola%20Zaid,%20tengo%20dudas%20sobre%20el%20menu%20de%20Happyfood" 
           target="_blank"
           class="px-6 py-3.5 bg-white hover:bg-emerald-50 text-emerald-800 font-extrabold text-xs sm:text-sm rounded-2xl shadow-lg transition-all flex items-center gap-2 whitespace-nowrap">
            <i class="fa-brands fa-whatsapp text-lg text-emerald-600"></i> Escríbeme por WhatsApp
        </a>
    </div>
        </div>
        <a href="https://wa.me/527227705013?text=Hola%20Camila,%20tengo%20dudas%20sobre%20el%20menu%20de%20Happyfood" 
           target="_blank" 
           class="px-6 py-3.5 bg-white text-emerald-800 hover:bg-emerald-50 font-extrabold text-xs sm:text-sm rounded-full shadow-md transition-all flex items-center gap-2 whitespace-nowrap flex-shrink-0">
            <i class="fa-brands fa-whatsapp text-lg text-emerald-600"></i> Escribeme por WhatsApp
        </a>
    </div>

    <!-- 5. Seccion de Calificaciones y Opiniones Reales de Clientes -->
    <div>
        <div class="text-center max-w-xl mx-auto mb-8">
            <span class="text-xs font-bold uppercase tracking-wider text-orange-600 bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                Experiencias de Comensales
            </span>
            <h2 class="text-2xl font-extrabold text-slate-900 mt-2">Lo que dicen nuestros clientes</h2>
            <p class="text-xs text-slate-500 mt-1">Calificaciones reales otorgadas por estudiantes y familias que disfrutan nuestro sazon.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($recentReviews as $rev)
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center text-amber-500 text-xs">
                                @for($s = 1; $s <= 5; $s++)
                                    <i class="fa-solid fa-star {{ $s <= $rev->rating ? '' : 'text-slate-200' }}"></i>
                                @endfor
                            </div>
                            <span class="text-[10px] text-slate-400">{{ $rev->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-xs text-slate-700 italic leading-relaxed mb-4">
                            "{{ $rev->comment }}"
                        </p>
                    </div>
                    <div class="flex items-center gap-3 pt-3 border-t border-slate-100">
                        <div class="w-8 h-8 rounded-full bg-orange-100 text-orange-700 font-bold flex items-center justify-center text-xs">
                            {{ strtoupper(substr($rev->user->name ?? 'C', 0, 1)) }}
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-900">{{ $rev->user->name ?? 'Cliente Satisfecho' }}</span>
                            <span class="block text-[10px] text-orange-600 font-semibold">{{ $rev->product->name ?? 'Platillo' }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-8 text-xs text-slate-400">
                    Aun no hay comentarios registrados. ¡Se el primero en calificar tu platillo favorito!
                </div>
            @endforelse
        </div>
    </div>

    <!-- 6. Preguntas Frecuentes (FAQ estilo acordeon desplegable) -->
    <div class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-12">
        <div class="max-w-2xl mx-auto text-center mb-8">
            <h2 class="text-2xl font-extrabold text-slate-900">Preguntas Frecuentes</h2>
            <p class="text-xs text-slate-500 mt-1">Resolvemos las dudas mas comunes de nuestros comensales.</p>
        </div>

        <div class="max-w-3xl mx-auto space-y-4 text-xs">
            
            <details class="group bg-slate-50 p-4 rounded-2xl border border-slate-200">
                <summary class="font-bold text-slate-800 cursor-pointer list-none flex items-center justify-between">
                    <span>¿Que metodos de pago aceptan?</span>
                    <i class="fa-solid fa-chevron-down group-open:rotate-180 transition-transform text-slate-400"></i>
                </summary>
                <p class="mt-3 text-slate-600 leading-relaxed">
                    Aceptamos pago en efectivo al recibir tu orden, transferencias bancarias directas mediante SPEI (con confirmacion inmediata) y tarjetas de debito o credito Visa y Mastercard.
                </p>
            </details>

            <details class="group bg-slate-50 p-4 rounded-2xl border border-slate-200">
                <summary class="font-bold text-slate-800 cursor-pointer list-none flex items-center justify-between">
                    <span>¿Puedo pedir mi platillo sin cebolla, sin salsa o con extras?</span>
                    <i class="fa-solid fa-chevron-down group-open:rotate-180 transition-transform text-slate-400"></i>
                </summary>
                <p class="mt-3 text-slate-600 leading-relaxed">
                    ¡Por supuesto! Al dar clic en "Personalizar" en cualquier platillo, puedes seleccionar exactamente como lo quieres: con todo, sin salsa, sin cebolla, sin crema, o agregar indicaciones especiales que se imprimen directamente en el ticket del cocinero.
                </p>
            </details>

            <details class="group bg-slate-50 p-4 rounded-2xl border border-slate-200">
                <summary class="font-bold text-slate-800 cursor-pointer list-none flex items-center justify-between">
                    <span>¿Como puedo imprimir o descargar el ticket de mi orden?</span>
                    <i class="fa-solid fa-chevron-down group-open:rotate-180 transition-transform text-slate-400"></i>
                </summary>
                <p class="mt-3 text-slate-600 leading-relaxed">
                    Al finalizar tu compra o desde la seccion "Mi Perfil" en tu historial de pedidos, simplemente haz clic sobre cualquier orden para abrir su ticket detallado y presionar el boton "Imprimir / Guardar en PDF".
                </p>
            </details>

            <details class="group bg-slate-50 p-4 rounded-2xl border border-slate-200">
                <summary class="font-bold text-slate-800 cursor-pointer list-none flex items-center justify-between">
                    <span>¿Donde estan ubicados y cual es el telefono de contacto?</span>
                    <i class="fa-solid fa-chevron-down group-open:rotate-180 transition-transform text-slate-400"></i>
                </summary>
                <p class="mt-3 text-slate-600 leading-relaxed">
                    Nos encontramos en la Universidad Politecnica del Valle de Toluca (UPVT), Carretera Toluca - Almoloya de Juarez. Puedes llamarnos o enviarnos un WhatsApp directo al <strong>722 770 5013</strong> o al correo <strong>zaidmed587@gmail.com</strong>.
                </p>
            </details>

        </div>
    </div>

</div>

<!-- Modal de Bienvenida para Completar Datos de Perfil (Si el usuario es nuevo) -->
@auth
    @if(session('welcome_new_user') || Auth::user()->needsProfileCompletion())
        <div id="welcomeProfileModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl border border-slate-200">
                <div class="text-center mb-5">
                    <div class="w-14 h-14 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-3">
                        <i class="fa-solid fa-address-card"></i>
                    </div>
                    <h3 class="text-xl font-extrabold text-slate-900">¡Bienvenido a Happyfood!</h3>
                    <p class="text-xs text-slate-500 mt-1">Completa tus datos basicos para que podamos enviarte tus pedidos y tickets sin inconvenientes.</p>
                </div>

                <form action="{{ route('client.perfil.editar') }}" method="POST" class="space-y-3.5 text-xs">
                    @csrf
                    <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                    <input type="hidden" name="username" value="{{ Auth::user()->username ?? 'usuario_'.Auth::id() }}">

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Apellidos (Solo letras):</label>
                        <input type="text" name="apellido" id="modalApellidoInput" value="{{ Auth::user()->apellido }}" required placeholder="Tus apellidos"
                               class="w-full p-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-orange-500 focus:outline-none">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Telefono (10 digitos):</label>
                            <input type="text" name="telefono" id="modalTelefonoInput" maxlength="10" value="{{ Auth::user()->telefono }}" required placeholder="7221234567"
                                   class="w-full p-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-orange-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Edad (Numeros):</label>
                            <input type="number" name="edad" id="modalEdadInput" min="1" max="120" value="{{ Auth::user()->edad }}" required placeholder="Ej: 21"
                                   class="w-full p-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-orange-500 focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Localidad / Direccion:</label>
                        <input type="text" name="localidad" value="{{ Auth::user()->localidad }}" required placeholder="Toluca / Almoloya / UPVT"
                               class="w-full p-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-orange-500 focus:outline-none">
                    </div>

                    <div class="flex items-center gap-2 pt-2">
                        <button type="submit" class="flex-1 py-3 bg-orange-600 hover:bg-orange-700 text-white font-bold rounded-xl transition-all shadow-md">
                            Guardar y Continuar
                        </button>
                        <button type="button" onclick="document.getElementById('welcomeProfileModal').remove()" class="py-3 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition-all">
                            Despues
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var apInput = document.getElementById('modalApellidoInput');
                if (apInput) validateStrictLetters(apInput, 'Apellidos');
                var telInput = document.getElementById('modalTelefonoInput');
                if (telInput) validateStrictNumbers(telInput, 'Telefono');
            });
        </script>
        @endpush
    @endif
@endauth

@endsection
