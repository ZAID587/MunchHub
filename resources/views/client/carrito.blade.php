@extends('layouts.client')

@section('title', 'Mi Carrito de Compras')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto py-4">

    <!-- Encabezado del Carrito -->
    <div class="flex flex-wrap items-center justify-between border-b border-slate-200 dark:border-slate-700 pb-4 gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white flex items-center gap-3">
                <i class="fa-solid fa-cart-shopping text-orange-600"></i> Mi Carrito de Compras
            </h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Elige los platillos que deseas ordenar hoy marcando la palomita.</p>
        </div>

        @if($items->isNotEmpty())
            <form action="{{ route('client.carrito.eliminar') }}" method="POST" onsubmit="return confirm('¿Deseas vaciar todo tu carrito?');">
                @csrf
                <button type="submit" class="px-4 py-2 border border-slate-300 dark:border-slate-700 hover:border-red-500 hover:text-red-600 rounded-full text-xs font-bold text-slate-600 dark:text-slate-300 transition-colors flex items-center gap-1.5">
                    <i class="fa-regular fa-trash-can"></i> Vaciar Carrito
                </button>
            </form>
        @endif
    </div>

    @if($items->isEmpty())
        <!-- Carrito Vacio -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 p-12 text-center max-w-md mx-auto shadow-xs">
            <div class="w-20 h-20 bg-orange-50 dark:bg-orange-950/40 text-orange-600 rounded-full flex items-center justify-center text-3xl mx-auto mb-4">
                <i class="fa-solid fa-basket-shopping"></i>
            </div>
            <h2 class="text-lg font-extrabold text-slate-900 dark:text-white mb-1">Tu carrito está vacío</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-6">Aún no has agregado ningún alimento o bebida a tu pedido.</p>
            <a href="{{ route('home') }}" class="px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-extrabold text-xs rounded-full shadow-md transition-all inline-flex items-center gap-2">
                <i class="fa-solid fa-utensils"></i> Explorar el Menú
            </a>
        </div>
    @else

        <!-- Banner Promocional de Envío Gratis -->
        @if($subtotal >= 450)
            <div class="p-3.5 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 rounded-2xl flex items-center gap-3 text-xs text-emerald-800 dark:text-emerald-200 font-bold">
                <i class="fa-solid fa-truck-fast text-emerald-600 text-lg"></i>
                <span>¡Felicidades! Tu compra califica para <strong>ENVÍO GRATIS</strong> ($0.00) por superar los $450.00 MXN.</span>
            </div>
        @elseif($subtotal > 0)
            <div class="p-3.5 bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800 rounded-2xl flex items-center justify-between gap-3 text-xs text-amber-900 dark:text-amber-200">
                <div class="flex items-center gap-2.5 font-bold">
                    <i class="fa-solid fa-truck text-amber-600 text-base"></i>
                    <span>Agrega <strong>${{ number_format(450 - $subtotal, 2) }}</strong> más en platillos seleccionados para obtener <strong>ENVÍO GRATIS</strong>.</span>
                </div>
                <span class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 hidden sm:inline">Envío actual: $69.00</span>
            </div>
        @endif

        <!-- Grid de 2 Columnas -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Columna Izquierda: Lista de Platillos (7 columnas) -->
            <div class="lg:col-span-7 space-y-4">
                @foreach($items as $item)
                    <div class="bg-white dark:bg-slate-800 rounded-2xl border {{ $item->is_selected ? 'border-orange-300 dark:border-orange-700/60 shadow-xs' : 'border-slate-200 dark:border-slate-700 opacity-80' }} p-4 sm:p-5 transition-all flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        
                        <div class="flex items-center gap-3 sm:gap-4 w-full sm:w-auto">
                            <!-- Checkbox / Palomita de Selección -->
                            <form action="{{ route('client.carrito.toggle', $item->id) }}" method="POST" class="shrink-0">
                                @csrf
                                <button type="submit" title="{{ $item->is_selected ? 'Desmarcar de esta orden' : 'Incluir en esta orden' }}"
                                        class="w-7 h-7 rounded-xl flex items-center justify-center transition-all {{ $item->is_selected ? 'bg-orange-600 text-white shadow-xs' : 'border-2 border-slate-300 dark:border-slate-600 text-transparent hover:border-orange-400' }}">
                                    <i class="fa-solid fa-check text-xs"></i>
                                </button>
                            </form>

                            <!-- Imagen del Platillo -->
                            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl overflow-hidden bg-slate-100 dark:bg-slate-700 shrink-0 border border-slate-200 dark:border-slate-700">
                                <img src="{{ $item->product->image ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&auto=format&fit=crop&q=60' }}" 
                                     alt="{{ $item->product->name ?? 'Platillo' }}" 
                                     class="w-full h-full object-cover">
                            </div>

                            <!-- Informacion y Personalizacion -->
                            <div class="flex-1 min-w-0">
                                <span class="text-[10px] font-bold text-orange-600 uppercase tracking-wider block">
                                    {{ $item->product->category ?? 'Alimento' }}
                                </span>
                                <h3 class="text-sm font-extrabold text-slate-900 dark:text-white truncate mb-0.5">
                                    {{ $item->product->name ?? 'Platillo' }}
                                </h3>
                                <span class="text-xs font-bold text-slate-700 dark:text-slate-300 block mb-1">
                                    ${{ number_format($item->product->price ?? 0, 2) }} c/u
                                </span>
                                
                                @if($item->notes)
                                    <div class="inline-flex items-center gap-1.5 px-2 py-0.5 bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-900/60 text-amber-900 dark:text-amber-300 rounded-md text-[10px] font-medium max-w-sm truncate">
                                        <i class="fa-solid fa-list-check text-amber-600 text-[10px]"></i>
                                        <span>{{ $item->notes }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Controles de Cantidad y Subtotal -->
                        <div class="flex sm:flex-col items-center sm:items-end justify-between w-full sm:w-auto pt-3 sm:pt-0 border-t sm:border-t-0 border-slate-100 dark:border-slate-700 gap-2">
                            <span class="text-sm font-black text-slate-900 dark:text-white">
                                ${{ number_format($item->subtotal, 2) }}
                            </span>

                            <div class="flex items-center gap-2">
                                <div class="flex items-center border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-900 p-0.5">
                                    <form action="{{ route('client.carrito.cantidad', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="delta" value="-1">
                                        <button type="submit" class="w-6 h-6 rounded-lg bg-white dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold text-xs flex items-center justify-center transition-colors">
                                            -
                                        </button>
                                    </form>
                                    <span class="w-8 text-center text-xs font-extrabold text-slate-800 dark:text-white">
                                        {{ $item->quantity }}
                                    </span>
                                    <form action="{{ route('client.carrito.cantidad', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="delta" value="1">
                                        <button type="submit" class="w-6 h-6 rounded-lg bg-white dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold text-xs flex items-center justify-center transition-colors">
                                            +
                                        </button>
                                    </form>
                                </div>

                                <form action="{{ route('client.carrito.eliminar') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 transition-colors" title="Quitar">
                                        <i class="fa-regular fa-trash-can text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- Columna Derecha: Resumen de Orden y Pago (5 columnas) -->
            <div class="lg:col-span-5">
                <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 p-6 sm:p-7 shadow-xs sticky top-28 space-y-6">
                    <h2 class="text-base font-extrabold text-slate-900 dark:text-white border-b border-slate-100 dark:border-slate-700 pb-3 flex items-center gap-2">
                        <i class="fa-solid fa-receipt text-orange-600"></i> Resumen de la Orden
                    </h2>

                    <!-- Desglose Financiero -->
                    <div class="space-y-2.5 text-xs">
                        <div class="flex justify-between text-slate-500 dark:text-slate-400">
                            <span>Subtotal platillos seleccionados:</span>
                            <span class="font-bold text-slate-800 dark:text-slate-200">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-slate-500 dark:text-slate-400">
                            <span>Costo de envío / entrega:</span>
                            @if($subtotal >= 450)
                                <span class="font-extrabold text-emerald-600 dark:text-emerald-400">GRATIS ($0.00)</span>
                            @else
                                <span class="font-bold text-slate-800 dark:text-slate-200">$69.00</span>
                            @endif
                        </div>
                        <div class="border-t border-slate-100 dark:border-slate-700 pt-3 flex justify-between text-sm font-extrabold text-slate-900 dark:text-white">
                            <span>Total a Pagar:</span>
                            <span class="text-xl font-black text-orange-600">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <!-- FORMULARIO DE PAGO -->
                    <form action="{{ route('client.carrito.pagar') }}" method="POST" id="checkoutForm" class="space-y-4 pt-2 border-t border-slate-100 dark:border-slate-700">
                        @csrf

                        <!-- Tipo de Entrega / Mesa -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wider">
                                <i class="fa-solid fa-location-dot text-orange-600"></i> Modalidad de Pedido:
                            </label>
                            <select name="table_number" id="tableNumberSelect" onchange="toggleDeliveryBox(this.value)" class="w-full p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs text-slate-700 dark:text-slate-200 bg-slate-50 dark:bg-slate-900 focus:ring-2 focus:ring-orange-500 focus:outline-none">
                                <option value="Para llevar (En mostrador)">🛍️ Para llevar (En mostrador)</option>
                                <option value="Mesa 1">🍽️ Comer aquí - Mesa 1</option>
                                <option value="Mesa 2">🍽️ Comer aquí - Mesa 2</option>
                                <option value="Mesa 3">🍽️ Comer aquí - Mesa 3</option>
                                <option value="Mesa 4">🍽️ Comer aquí - Mesa 4</option>
                                <option value="A Domicilio (Almoloya de Juárez / Toluca)">🛵 A Domicilio (Almoloya de Juárez / Toluca)</option>
                            </select>
                        </div>

                        <!-- CAJA DINAMICA: ENTREGA A DOMICILIO CON MAPA INTERACTIVO -->
                        <div id="box-domicilio" class="hidden p-4 rounded-2xl bg-orange-50 dark:bg-orange-950/30 border border-orange-200 dark:border-orange-900/60 text-xs space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="font-extrabold text-orange-900 dark:text-orange-300 flex items-center gap-1.5">
                                    <i class="fa-solid fa-motorcycle text-orange-600"></i> Datos y Mapa para Entrega a Domicilio
                                </span>
                                <span class="text-[10px] bg-orange-600 text-white font-black px-2 py-0.5 rounded-full uppercase">Almoloya y Alrededores</span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                <div>
                                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Calle:</label>
                                    <input type="text" name="calle_entrega" id="calle_entrega" placeholder="Ej: Av. Juárez / Morelos"
                                           class="w-full p-2.5 rounded-xl border border-orange-200 dark:border-orange-900 bg-white dark:bg-slate-900 text-xs focus:ring-2 focus:ring-orange-500 focus:outline-none">
                                </div>
                                <div>
                                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Número Ext / Int:</label>
                                    <input type="text" name="numero_entrega" id="numero_entrega" placeholder="Ej: #124 Int. B"
                                           class="w-full p-2.5 rounded-xl border border-orange-200 dark:border-orange-900 bg-white dark:bg-slate-900 text-xs focus:ring-2 focus:ring-orange-500 focus:outline-none">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                <div>
                                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Colonia / Fraccionamiento:</label>
                                    <input type="text" name="colonia_entrega" id="colonia_entrega" value="{{ Auth::user()->localidad ?? '' }}" placeholder="Ej: Centro / Santiaguito"
                                           class="w-full p-2.5 rounded-xl border border-orange-200 dark:border-orange-900 bg-white dark:bg-slate-900 text-xs focus:ring-2 focus:ring-orange-500 focus:outline-none">
                                </div>
                                <div>
                                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Teléfono de Contacto:</label>
                                    <input type="text" name="telefono_entrega" id="telefono_entrega" value="{{ Auth::user()->telefono ?? '' }}" placeholder="10 dígitos"
                                           class="w-full p-2.5 rounded-xl border border-orange-200 dark:border-orange-900 bg-white dark:bg-slate-900 text-xs focus:ring-2 focus:ring-orange-500 focus:outline-none">
                                </div>
                            </div>

                            <div>
                                <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Referencias de la vivienda:</label>
                                <input type="text" name="referencias_entrega" id="referencias_entrega" placeholder="Ej: Portón blanco, entre calle Hidalgo y Zaragoza, frente a tienda"
                                       class="w-full p-2.5 rounded-xl border border-orange-200 dark:border-orange-900 bg-white dark:bg-slate-900 text-xs focus:ring-2 focus:ring-orange-500 focus:outline-none">
                            </div>

                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <label class="block font-bold text-slate-700 dark:text-slate-300">
                                        <i class="fa-solid fa-map-pin text-orange-600"></i> Ubicación exacta en el Mapa:
                                    </label>
                                    <span class="text-[10px] text-slate-500 dark:text-slate-400">Arrastra el pin o toca tu casa</span>
                                </div>
                                <div id="map-delivery" class="h-44 w-full rounded-2xl border border-orange-300 dark:border-orange-800 shadow-inner"></div>
                                <input type="hidden" name="delivery_lat" id="delivery_lat" value="19.3549894">
                                <input type="hidden" name="delivery_lng" id="delivery_lng" value="-99.7740717">
                                <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-1 flex items-center gap-1">
                                    <i class="fa-solid fa-circle-check text-emerald-600"></i> Coordenadas: <span id="coords-display" class="font-mono font-bold">19.3549894, -99.7740717</span>
                                </p>
                            </div>
                        </div>

                        <!-- Metodos de Pago -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wider">
                                <i class="fa-solid fa-credit-card text-orange-600"></i> Método de Pago:
                            </label>
                            
                            <div class="grid grid-cols-3 gap-2 text-xs">
                                <label class="flex flex-col items-center justify-center p-3 rounded-xl border border-slate-200 dark:border-slate-700 cursor-pointer hover:border-orange-400 has-[:checked]:border-orange-600 has-[:checked]:bg-orange-50 dark:has-[:checked]:bg-orange-950/40 font-bold transition-all text-center">
                                    <input type="radio" name="payment_method" value="Efectivo" checked onchange="togglePaymentBoxes('efectivo')" class="hidden">
                                    <i class="fa-solid fa-money-bill-wave text-base mb-1 text-emerald-600"></i>
                                    <span class="dark:text-slate-200">Efectivo</span>
                                </label>
                                <label class="flex flex-col items-center justify-center p-3 rounded-xl border border-slate-200 dark:border-slate-700 cursor-pointer hover:border-orange-400 has-[:checked]:border-orange-600 has-[:checked]:bg-orange-50 dark:has-[:checked]:bg-orange-950/40 font-bold transition-all text-center">
                                    <input type="radio" name="payment_method" value="Transferencia" onchange="togglePaymentBoxes('transferencia')" class="hidden">
                                    <i class="fa-solid fa-building-columns text-base mb-1 text-blue-600"></i>
                                    <span class="dark:text-slate-200">Transferencia</span>
                                </label>
                                <label class="flex flex-col items-center justify-center p-3 rounded-xl border border-slate-200 dark:border-slate-700 cursor-pointer hover:border-orange-400 has-[:checked]:border-orange-600 has-[:checked]:bg-orange-50 dark:has-[:checked]:bg-orange-950/40 font-bold transition-all text-center">
                                    <input type="radio" name="payment_method" value="Tarjeta" onchange="togglePaymentBoxes('tarjeta')" class="hidden">
                                    <i class="fa-solid fa-credit-card text-base mb-1 text-purple-600"></i>
                                    <span class="dark:text-slate-200">Tarjeta</span>
                                </label>
                            </div>
                        </div>

                        <!-- CAJA DINAMICA 1: TRANSFERENCIA -->
                        @php
                            $randomTransferConcept = 'MH-' . rand(10000, 99999);
                        @endphp
                        <input type="hidden" name="transfer_concept" value="{{ $randomTransferConcept }}">
                        <div id="box-transferencia" class="hidden p-4 rounded-2xl bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-900 text-xs space-y-2 text-blue-900 dark:text-blue-200">
                            <span class="font-extrabold flex items-center gap-1.5 text-blue-800 dark:text-blue-300">
                                <i class="fa-solid fa-circle-info"></i> Datos para Transferencia SPEI
                            </span>
                            <div class="space-y-1 bg-white dark:bg-slate-900 p-3 rounded-xl border border-blue-100 dark:border-blue-800 font-mono text-[11px]">
                                <div><span class="text-slate-400 font-sans">Banco:</span> <strong>BBVA Bancomer</strong></div>
                                <div><span class="text-slate-400 font-sans">Beneficiario:</span> <strong>MunchHub Restaurante</strong></div>
                                <div><span class="text-slate-400 font-sans">CLABE:</span> <strong class="text-blue-700 dark:text-blue-400">012 180 00456789123 4</strong></div>
                                <div><span class="text-slate-400 font-sans">Concepto Único:</span> <strong class="text-blue-700 dark:text-blue-300 bg-blue-100 dark:bg-blue-900/60 px-2 py-0.5 rounded font-mono">{{ $randomTransferConcept }}</strong></div>
                            </div>
                            <p class="text-[10px] text-blue-700 dark:text-blue-300">
                                * Usa este concepto único para que cocina identifique tu pago al instante.
                            </p>
                        </div>

                        <!-- CAJA DINAMICA 2: TARJETA CON VALIDACIONES ESTRICTAS -->
                        <div id="box-tarjeta" class="hidden p-4 rounded-2xl bg-purple-50 dark:bg-purple-950/40 border border-purple-200 dark:border-purple-900 text-xs space-y-3 text-purple-900 dark:text-purple-200">
                            <span class="font-extrabold flex items-center gap-1.5 text-purple-800 dark:text-purple-300">
                                <i class="fa-solid fa-lock"></i> Datos de la Tarjeta Bancaria
                            </span>
                            
                            <div class="flex items-center gap-3 text-lg text-slate-600 dark:text-slate-300 mb-1">
                                <i class="fa-brands fa-cc-visa text-blue-600"></i>
                                <i class="fa-brands fa-cc-mastercard text-orange-600"></i>
                                <i class="fa-brands fa-cc-amex text-cyan-600"></i>
                            </div>

                            <!-- Numero de Tarjeta: Estrictamente Numerico -->
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">
                                    Número de Tarjeta (16 dígitos numéricos): *
                                </label>
                                <input type="text" name="card_number" id="cardNumberInput" maxlength="19" 
                                       placeholder="4242 4242 4242 4242"
                                       class="w-full p-2.5 rounded-xl border border-purple-200 dark:border-purple-800 bg-white dark:bg-slate-900 text-xs font-mono focus:ring-2 focus:ring-purple-500 focus:outline-none">
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <!-- Vencimiento: Mes y Dia con diagonal MM/AA -->
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">
                                        Vencimiento (MM/AA): *
                                    </label>
                                    <input type="text" name="card_exp" id="cardExpInput" maxlength="5" 
                                           placeholder="12/28"
                                           class="w-full p-2.5 rounded-xl border border-purple-200 dark:border-purple-800 bg-white dark:bg-slate-900 text-xs font-mono focus:ring-2 focus:ring-purple-500 focus:outline-none">
                                </div>

                                <!-- CVV: Estrictamente 3 digitos numericos -->
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">
                                        CVV (3 dígitos): *
                                    </label>
                                    <input type="password" name="card_cvv" id="cardCvvInput" maxlength="3" 
                                           placeholder="•••"
                                           class="w-full p-2.5 rounded-xl border border-purple-200 dark:border-purple-800 bg-white dark:bg-slate-900 text-xs font-mono focus:ring-2 focus:ring-purple-500 focus:outline-none">
                                </div>
                            </div>
                        </div>

                        <!-- CAJA DINAMICA 3: EFECTIVO -->
                        <div id="box-efectivo" class="p-3 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-xs text-emerald-800 dark:text-emerald-300 flex items-center gap-2">
                            <i class="fa-solid fa-money-bill text-emerald-600 text-base"></i>
                            <span>Pagas en efectivo al momento de recibir tu orden en mesa o al recoger en mostrador.</span>
                        </div>

                        <!-- Boton Confirmar y Pagar -->
                        <button type="submit" class="w-full py-3.5 bg-orange-600 hover:bg-orange-700 text-white font-black text-sm rounded-2xl shadow-md transition-all flex items-center justify-center gap-2">
                            <i class="fa-solid fa-check text-base"></i> Confirmar Orden y Ver Ticket
                        </button>
                    </form>

                </div>
            </div>

        </div>
    @endif

</div>

@push('scripts')
<script>
    var deliveryMap = null;
    var deliveryMarker = null;

    function initDeliveryMap() {
        if (deliveryMap) {
            setTimeout(function() { deliveryMap.invalidateSize(); }, 200);
            return;
        }
        var mapEl = document.getElementById('map-delivery');
        if (!mapEl) return;

        var defaultLat = 19.3549894;
        var defaultLng = -99.7740717;

        deliveryMap = L.map('map-delivery').setView([defaultLat, defaultLng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(deliveryMap);

        deliveryMarker = L.marker([defaultLat, defaultLng], {
            draggable: true
        }).addTo(deliveryMap);

        function updateCoords(lat, lng) {
            var latInput = document.getElementById('delivery_lat');
            var lngInput = document.getElementById('delivery_lng');
            var disp = document.getElementById('coords-display');
            if (latInput) latInput.value = lat.toFixed(7);
            if (lngInput) lngInput.value = lng.toFixed(7);
            if (disp) disp.textContent = lat.toFixed(7) + ', ' + lng.toFixed(7);
        }

        deliveryMarker.on('dragend', function (e) {
            var pos = e.target.getLatLng();
            updateCoords(pos.lat, pos.lng);
        });

        deliveryMap.on('click', function (e) {
            deliveryMarker.setLatLng(e.latlng);
            updateCoords(e.latlng.lat, e.latlng.lng);
        });

        setTimeout(function() { deliveryMap.invalidateSize(); }, 300);
    }

    function toggleDeliveryBox(val) {
        var box = document.getElementById('box-domicilio');
        if (!box) return;
        if (val.toLowerCase().indexOf('domicilio') !== -1) {
            box.classList.remove('hidden');
            initDeliveryMap();
        } else {
            box.classList.add('hidden');
        }
    }

    function togglePaymentBoxes(method) {
        var boxTrans = document.getElementById('box-transferencia');
        var boxTarj = document.getElementById('box-tarjeta');
        var boxEfec = document.getElementById('box-efectivo');

        if (!boxTrans || !boxTarj || !boxEfec) return;

        boxTrans.classList.add('hidden');
        boxTarj.classList.add('hidden');
        boxEfec.classList.add('hidden');

        if (method === 'transferencia') {
            boxTrans.classList.remove('hidden');
        } else if (method === 'tarjeta') {
            boxTarj.classList.remove('hidden');
        } else {
            boxEfec.classList.remove('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Formateo y validacion estricta de numero de tarjeta (16 digitos numericos)
        var cardInput = document.getElementById('cardNumberInput');
        if (cardInput) {
            cardInput.addEventListener('keypress', validateStrictNumbers);
            cardInput.addEventListener('input', function (e) {
                var val = e.target.value.replace(/\D/g, '').substring(0, 16);
                var formatted = val.match(/.{1,4}/g)?.join(' ') || val;
                e.target.value = formatted;
            });
        }

        // Formateo y validacion estricta de fecha MM/AA con diagonal numerica
        var expInput = document.getElementById('cardExpInput');
        if (expInput) {
            expInput.addEventListener('keypress', function (e) {
                var char = String.fromCharCode(e.which || e.keyCode);
                if (!/[0-9\/]/.test(char) && e.keyCode > 31) {
                    e.preventDefault();
                    if (typeof showValidationWarning === 'function') {
                        showValidationWarning('⚠️ La fecha de vencimiento solo debe contener números y diagonal (MM/AA).');
                    }
                }
            });
            expInput.addEventListener('input', function (e) {
                var val = e.target.value.replace(/\D/g, '').substring(0, 4);
                if (val.length >= 3) {
                    e.target.value = val.substring(0, 2) + '/' + val.substring(2, 4);
                } else {
                    e.target.value = val;
                }
            });
        }

        // Formateo y validacion estricta de CVV (3 digitos numericos)
        var cvvInput = document.getElementById('cardCvvInput');
        if (cvvInput) {
            cvvInput.addEventListener('keypress', validateStrictNumbers);
            cvvInput.addEventListener('input', function (e) {
                e.target.value = e.target.value.replace(/\D/g, '').substring(0, 3);
            });
        }
    });
</script>
@endpush
@endsection