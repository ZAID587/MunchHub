@extends('layouts.client')

@section('title', 'Mi Carrito de Compras')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto">

    <!-- Encabezado del Carrito -->
    <div class="flex flex-wrap items-center justify-between border-b border-slate-200 pb-4 gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 flex items-center gap-3">
                <i class="fa-solid fa-cart-shopping text-orange-600"></i> Mi Carrito de Compras
            </h1>
            <p class="text-xs text-slate-500 mt-1">Revisa tus alimentos, personalizaciones y selecciona tu metodo de pago.</p>
        </div>

        @if($items->isNotEmpty())
            <form action="{{ route('client.carrito.eliminar') }}" method="POST" onsubmit="return confirm('¿Deseas vaciar todo tu carrito?');">
                @csrf
                <button type="submit" class="px-4 py-2 border border-slate-300 hover:border-red-500 hover:text-red-600 rounded-full text-xs font-bold text-slate-600 transition-colors flex items-center gap-1.5">
                    <i class="fa-regular fa-trash-can"></i> Vaciar Carrito
                </button>
            </form>
        @endif
    </div>

    @if($items->isEmpty())
        <!-- Carrito Vacio -->
        <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center max-w-md mx-auto shadow-xs">
            <div class="w-20 h-20 bg-orange-50 text-orange-600 rounded-full flex items-center justify-center text-3xl mx-auto mb-4">
                <i class="fa-solid fa-basket-shopping"></i>
            </div>
            <h2 class="text-lg font-extrabold text-slate-900 mb-1">Tu carrito esta vacio</h2>
            <p class="text-xs text-slate-500 mb-6">Aun no has agregado ningun platillo o bebida a tu orden.</p>
            <a href="{{ route('home') }}" class="px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-extrabold text-xs rounded-full shadow-lg shadow-orange-600/30 transition-all inline-flex items-center gap-2">
                <i class="fa-solid fa-utensils"></i> Explorar el Menu
            </a>
        </div>
    @else
        <!-- Carrito con Elementos: Grid de 2 Columnas -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Columna Izquierda: Lista de Platillos (8 columnas) -->
            <div class="lg:col-span-7 space-y-4">
                @foreach($items as $item)
                    <div class="bg-white rounded-2xl border border-slate-200 p-4 sm:p-5 shadow-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        
                        <div class="flex items-center gap-4">
                            <!-- Imagen del Platillo -->
                            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0 border border-slate-200">
                                <img src="{{ $item->product->image ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&auto=format&fit=crop&q=60' }}" 
                                     alt="{{ $item->product->name ?? 'Platillo' }}" 
                                     class="w-full h-full object-cover">
                            </div>

                            <!-- Informacion y Personalizacion -->
                            <div>
                                <span class="text-[10px] font-bold text-orange-600 uppercase tracking-wider block">
                                    {{ $item->product->category ?? 'Alimento' }}
                                </span>
                                <h3 class="text-sm font-extrabold text-slate-900 mb-1">
                                    {{ $item->product->name ?? 'Platillo' }}
                                </h3>
                                <span class="text-xs font-bold text-slate-700 block mb-1">
                                    ${{ number_format($item->product->price ?? 0, 2) }} c/u
                                </span>
                                
                                <!-- Notas / Opciones Personalizadas del Platillo -->
                                @if($item->notes)
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 border border-amber-200 text-amber-900 rounded-lg text-[11px] font-medium max-w-sm">
                                        <i class="fa-solid fa-list-check text-amber-600 text-[10px]"></i>
                                        <span>{{ $item->notes }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Controles de Cantidad y Subtotal -->
                        <div class="flex sm:flex-col items-center sm:items-end justify-between w-full sm:w-auto pt-3 sm:pt-0 border-t sm:border-t-0 border-slate-100 gap-2">
                            <span class="text-sm font-black text-slate-900">
                                ${{ number_format($item->subtotal, 2) }}
                            </span>

                            <div class="flex items-center gap-2">
                                <div class="flex items-center border border-slate-200 rounded-xl bg-slate-50 p-0.5">
                                    <form action="{{ route('client.carrito.cantidad', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="delta" value="-1">
                                        <button type="submit" class="w-6 h-6 rounded-lg bg-white hover:bg-slate-200 text-slate-700 font-bold text-xs flex items-center justify-center transition-colors">
                                            -
                                        </button>
                                    </form>
                                    <span class="w-8 text-center text-xs font-extrabold text-slate-800">
                                        {{ $item->quantity }}
                                    </span>
                                    <form action="{{ route('client.carrito.cantidad', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="delta" value="1">
                                        <button type="submit" class="w-6 h-6 rounded-lg bg-white hover:bg-slate-200 text-slate-700 font-bold text-xs flex items-center justify-center transition-colors">
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

            <!-- Columna Derecha: Resumen de Orden y Metodos de Pago Interactivos (5 columnas) -->
            <div class="lg:col-span-5">
                <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-7 shadow-xs sticky top-28 space-y-6">
                    <h2 class="text-base font-extrabold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <i class="fa-solid fa-receipt text-orange-600"></i> Resumen de la Orden
                    </h2>

                    <div class="space-y-2.5 text-xs">
                        <div class="flex justify-between text-slate-500">
                            <span>Subtotal platillos</span>
                            <span class="font-bold text-slate-800">${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-slate-500">
                            <span>Entrega / Servicio</span>
                            <span class="font-bold text-emerald-600">GRATIS</span>
                        </div>
                        <div class="border-t border-slate-100 pt-3 flex justify-between text-sm font-extrabold text-slate-900">
                            <span>Total a Pagar</span>
                            <span class="text-xl font-black text-orange-600">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <!-- FORMULARIO DE PAGO INTERACTIVO -->
                    <form action="{{ route('client.carrito.pagar') }}" method="POST" id="checkoutForm" class="space-y-4 pt-2 border-t border-slate-100">
                        @csrf

                        <!-- Tipo de Entrega / Mesa -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">
                                <i class="fa-solid fa-location-dot text-orange-600"></i> Modalidad de Pedido:
                            </label>
                            <select name="table_number" class="w-full p-2.5 rounded-xl border border-slate-200 text-xs text-slate-700 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-orange-500 focus:outline-none">
                                <option value="Para llevar">🛍️ Para llevar (En mostrador)</option>
                                <option value="Mesa 1">🍽️ Comer aqui - Mesa 1</option>
                                <option value="Mesa 2">🍽️ Comer aqui - Mesa 2</option>
                                <option value="Mesa 3">🍽️ Comer aqui - Mesa 3</option>
                                <option value="Mesa 4">🍽️ Comer aqui - Mesa 4</option>
                                <option value="A Domicilio (Toluca/Almoloya)">🛵 A Domicilio (Toluca / Almoloya)</option>
                            </select>
                        </div>

                        <!-- Seleccion de Metodo de Pago -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">
                                <i class="fa-solid fa-credit-card text-orange-600"></i> Metodo de Pago:
                            </label>
                            
                            <div class="grid grid-cols-3 gap-2 text-xs">
                                <label class="flex flex-col items-center justify-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:border-orange-400 has-[:checked]:border-orange-600 has-[:checked]:bg-orange-50 has-[:checked]:text-orange-900 font-bold transition-all text-center">
                                    <input type="radio" name="payment_method" value="Efectivo" checked onchange="togglePaymentBoxes('efectivo')" class="hidden">
                                    <i class="fa-solid fa-money-bill-wave text-base mb-1 text-emerald-600"></i>
                                    <span>Efectivo</span>
                                </label>
                                <label class="flex flex-col items-center justify-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:border-orange-400 has-[:checked]:border-orange-600 has-[:checked]:bg-orange-50 has-[:checked]:text-orange-900 font-bold transition-all text-center">
                                    <input type="radio" name="payment_method" value="Transferencia" onchange="togglePaymentBoxes('transferencia')" class="hidden">
                                    <i class="fa-solid fa-building-columns text-base mb-1 text-blue-600"></i>
                                    <span>Transferencia</span>
                                </label>
                                <label class="flex flex-col items-center justify-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:border-orange-400 has-[:checked]:border-orange-600 has-[:checked]:bg-orange-50 has-[:checked]:text-orange-900 font-bold transition-all text-center">
                                    <input type="radio" name="payment_method" value="Tarjeta" onchange="togglePaymentBoxes('tarjeta')" class="hidden">
                                    <i class="fa-solid fa-credit-card text-base mb-1 text-purple-600"></i>
                                    <span>Tarjeta</span>
                                </label>
                            </div>
                        </div>

                        <!-- CAJA DINAMICA 1: DATOS DE TRANSFERENCIA SPEI -->
                        <div id="box-transferencia" class="hidden p-4 rounded-2xl bg-blue-50 border border-blue-200 text-xs space-y-2 text-blue-900 animate-fadeIn">
                            <span class="font-extrabold flex items-center gap-1.5 text-blue-800">
                                <i class="fa-solid fa-circle-info"></i> Datos para Transferencia SPEI
                            </span>
                            <div class="space-y-1 bg-white p-3 rounded-xl border border-blue-100 font-mono text-[11px]">
                                <div><span class="text-slate-400 font-sans">Banco:</span> <strong>BBVA Bancomer</strong></div>
                                <div><span class="text-slate-400 font-sans">Beneficiario:</span> <strong>Happyfood Restaurante S.A.</strong></div>
                                <div><span class="text-slate-400 font-sans">CLABE Interbancaria:</span> <strong class="text-blue-700">012 180 00456789123 4</strong></div>
                                <div><span class="text-slate-400 font-sans">Concepto:</span> <strong>{{ Auth::user()->name }}</strong></div>
                            </div>
                            <p class="text-[10px] text-blue-700 leading-tight">
                                Transfiere el monto total (${{ number_format($total, 2) }}) y tu orden quedara lista para entrega. El ticket reflejara la referencia bancaria.
                            </p>
                        </div>

                        <!-- CAJA DINAMICA 2: DATOS DE TARJETA BANCARIA -->
                        <div id="box-tarjeta" class="hidden p-4 rounded-2xl bg-purple-50 border border-purple-200 text-xs space-y-3 text-purple-900 animate-fadeIn">
                            <span class="font-extrabold flex items-center gap-1.5 text-purple-800">
                                <i class="fa-solid fa-lock"></i> Pago Seguro con Tarjeta
                            </span>
                            
                            <div class="flex items-center gap-3 text-lg text-slate-600 mb-1">
                                <i class="fa-brands fa-cc-visa text-blue-600"></i>
                                <i class="fa-brands fa-cc-mastercard text-orange-600"></i>
                                <i class="fa-brands fa-cc-amex text-cyan-600"></i>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Numero de Tarjeta:</label>
                                <input type="text" name="card_number" id="cardNumberInput" maxlength="19" placeholder="4242 •••• •••• 4242" 
                                       class="w-full p-2.5 rounded-xl border border-purple-200 bg-white text-xs font-mono focus:ring-2 focus:ring-purple-500 focus:outline-none">
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Vencimiento (MM/AA):</label>
                                    <input type="text" maxlength="5" placeholder="12/28" 
                                           class="w-full p-2.5 rounded-xl border border-purple-200 bg-white text-xs font-mono focus:ring-2 focus:ring-purple-500 focus:outline-none">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">CVV:</label>
                                    <input type="password" maxlength="4" placeholder="123" 
                                           class="w-full p-2.5 rounded-xl border border-purple-200 bg-white text-xs font-mono focus:ring-2 focus:ring-purple-500 focus:outline-none">
                                </div>
                            </div>
                        </div>

                        <!-- CAJA DINAMICA 3: EFECTIVO -->
                        <div id="box-efectivo" class="p-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-800 flex items-center gap-2">
                            <i class="fa-solid fa-money-bill text-emerald-600 text-base"></i>
                            <span>Pagas en efectivo al momento de recibir tu orden en mesa o al recoger en mostrador.</span>
                        </div>

                        <!-- Boton Confirmar y Pagar -->
                        <button type="submit" class="w-full py-3.5 bg-orange-600 hover:bg-orange-700 text-white font-black text-sm rounded-2xl shadow-lg shadow-orange-600/30 transition-all flex items-center justify-center gap-2 transform active:scale-95">
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
    function togglePaymentBoxes(method) {
        var boxTrans = document.getElementById('box-transferencia');
        var boxTarj = document.getElementById('box-tarjeta');
        var boxEfec = document.getElementById('box-efectivo');

        boxTrans.classList.add('hidden');
        boxTarj.classList.add('hidden');
        boxEfec.classList.add('hidden');

        if (method === 'transferencia') {
            boxTrans.classList.remove('hidden');
        } else if (method === 'tarjeta') {
            boxTarj.classList.remove('hidden');
            var cardInput = document.getElementById('cardNumberInput');
            if (cardInput) validateStrictNumbers(cardInput, 'Numero de Tarjeta');
        } else {
            boxEfec.classList.remove('hidden');
        }
    }
</script>
@endpush
@endsection
