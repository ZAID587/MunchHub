@extends('layouts.client')

@section('title', 'Ticket de Compra #' . $order->id)

@section('content')
<style>
    @media print {
        header, footer, .no-print, nav {
            display: none !important;
        }
        body {
            background-color: white !important;
            padding: 0 !important;
        }
        main {
            padding: 0 !important;
            max-width: 100% !important;
        }
        .ticket-container {
            box-shadow: none !important;
            border: 1px dashed #cbd5e1 !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 20px !important;
        }
    }
</style>

<div class="max-w-xl mx-auto space-y-6">

    <!-- Mensaje Superior de Confirmacion (no-print) -->
    <div class="no-print bg-emerald-50 border border-emerald-200 rounded-2xl p-4 text-center shadow-xs">
        <div class="w-12 h-12 bg-emerald-600 text-white rounded-full flex items-center justify-center text-xl mx-auto mb-2 shadow-sm">
            <i class="fa-solid fa-check"></i>
        </div>
        <h2 class="text-lg font-extrabold text-emerald-900">¡Orden Registrada con Exito!</h2>
        <p class="text-xs text-emerald-700 mt-0.5">Tu pedido ha sido recibido en cocina y se prepara con todas tus indicaciones.</p>
    </div>

    <!-- TARJETA DEL TICKET DE COMPRA (ESTILO RESTAURANTE / RECIBO FORMAL) -->
    <div class="ticket-container bg-white rounded-3xl border-2 border-dashed border-slate-300 p-6 sm:p-8 shadow-md font-sans">
        
        <!-- Encabezado del Ticket -->
        <div class="text-center border-b border-slate-200 pb-5 mb-5 space-y-1">
            <div class="inline-flex items-center gap-2 mb-1">
                <div class="w-8 h-8 rounded-xl bg-orange-600 text-white flex items-center justify-center font-bold text-sm">
                    <i class="fa-solid fa-utensils"></i>
                </div>
                <span class="text-2xl font-black text-slate-900 tracking-tight">Munch<span class="text-orange-600">Hub</span></span>
            </div>
            <p class="text-xs font-bold text-slate-700">Restaurante & Especialidades Gastronómicas</p>
            <p class="text-[11px] text-slate-500">Almoloya de Juárez, Estado de México, C.P. 50900 • Tel: 722 839 1022</p>
            <p class="text-[10px] text-slate-400 font-mono">RFC: MHB-261126-ALM • zaidmed587@gmail.com</p>
        </div>

        @if($order->delivery_address)
            <div class="bg-orange-50 border border-orange-200 rounded-2xl p-3 mb-4 text-xs text-orange-950">
                <span class="font-extrabold block text-[10px] uppercase text-orange-800 tracking-wider mb-1">
                    <i class="fa-solid fa-location-dot text-orange-600"></i> Datos de Entrega a Domicilio:
                </span>
                <p class="font-medium text-slate-700">{{ $order->delivery_address }}</p>
                @if($order->delivery_lat && $order->delivery_lng)
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $order->delivery_lat }},{{ $order->delivery_lng }}" target="_blank" class="text-orange-600 hover:underline font-bold text-[11px] mt-1 inline-flex items-center gap-1">
                        <i class="fa-solid fa-diamond-turn-right"></i> Ver Ruta de Entrega en Google Maps
                    </a>
                @endif
            </div>
        @endif

        <!-- Metadatos de la Orden -->
        <div class="grid grid-cols-2 gap-2 text-xs border-b border-slate-200 pb-4 mb-4 text-slate-600">
            <div>
                <span class="text-slate-400 block text-[10px] uppercase font-bold">Numero de Folio:</span>
                <span class="font-extrabold text-slate-900 font-mono text-sm">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="text-right">
                <span class="text-slate-400 block text-[10px] uppercase font-bold">Fecha y Hora:</span>
                <span class="font-bold text-slate-800">{{ $order->created_at->format('d/m/Y h:i A') }}</span>
            </div>
            <div class="mt-2">
                <span class="text-slate-400 block text-[10px] uppercase font-bold">Comensal:</span>
                <span class="font-bold text-slate-800">{{ $order->user->name ?? 'Cliente Mostrador' }}</span>
            </div>
            <div class="mt-2 text-right">
                <span class="text-slate-400 block text-[10px] uppercase font-bold">Modalidad / Mesa:</span>
                <span class="inline-block bg-orange-100 text-orange-800 px-2 py-0.5 rounded-full font-extrabold text-[11px]">
                    {{ $order->table_number }}
                </span>
            </div>
        </div>

        <!-- Desglose de Platillos y Personalizaciones -->
        <div class="border-b border-slate-200 pb-4 mb-4">
            <span class="block text-[11px] font-extrabold uppercase text-slate-400 mb-3 tracking-wider">
                Desglose de Alimentos y Bebidas:
            </span>

            <div class="space-y-3">
                @foreach($order->items as $item)
                    <div class="text-xs">
                        <div class="flex justify-between items-baseline font-bold text-slate-800">
                            <span>
                                <strong class="text-orange-600 font-black">{{ $item->quantity }}x</strong> 
                                {{ $item->product->name ?? 'Platillo' }}
                            </span>
                            <span class="font-mono">${{ number_format($item->subtotal, 2) }}</span>
                        </div>

                        <!-- Detalles / Indicaciones del Cliente impresas en el ticket -->
                        @if($item->notes)
                            <div class="mt-1 pl-4 text-[11px] text-amber-800 bg-amber-50/70 p-1.5 rounded-lg border border-amber-100 flex items-start gap-1.5">
                                <i class="fa-solid fa-tag text-amber-600 mt-0.5 text-[10px]"></i>
                                <span><strong>Detalles:</strong> {{ $item->notes }}</span>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Totales y Metodo de Pago -->
        <div class="space-y-2 text-xs border-b border-slate-200 pb-4 mb-5">
            <div class="flex justify-between text-slate-500">
                <span>Subtotal alimentos:</span>
                <span class="font-mono font-bold text-slate-700">${{ number_format($order->total * 0.862, 2) }}</span>
            </div>
            <div class="flex justify-between text-slate-500">
                <span>IVA (16% Trasladado):</span>
                <span class="font-mono font-bold text-slate-700">${{ number_format($order->total * 0.138, 2) }}</span>
            </div>
            <div class="flex justify-between text-base font-black text-slate-900 pt-2 border-t border-slate-100">
                <span>TOTAL PAGADO:</span>
                <span class="text-orange-600 text-xl font-mono">${{ number_format($order->total, 2) }}</span>
            </div>
            <div class="pt-2 text-[11px] text-slate-600 flex items-center justify-between">
                <span>Metodo Registrado:</span>
                <strong class="text-slate-800">{{ $order->notes ?? 'Efectivo' }}</strong>
            </div>
        </div>

        <!-- Pie del Ticket / Sello Fiscal Simulado -->
        <div class="text-center space-y-1.5 text-[10px] text-slate-400">
            <p class="font-bold text-slate-600">¡GRACIAS POR TU PREFERENCIA!</p>
            <p>Conserva este ticket para cualquier aclaracion o entrega en mesa.</p>
            <div class="w-48 h-8 mx-auto bg-slate-100 rounded border border-slate-300 flex items-center justify-center font-mono text-[9px] tracking-widest text-slate-500 mt-3">
                ||| | ||||| || |||| ||| |||| |
            </div>
            <p class="text-[9px] text-slate-400 font-mono">CADENA: SHA256-{{ substr(md5($order->id . $order->created_at), 0, 16) }}</p>
        </div>

    </div>

    <!-- Botones de Accion (Imprimir / PDF, Volver) -->
    <div class="no-print flex flex-col sm:flex-row items-center justify-center gap-3 pt-2">
        <button onclick="window.print()" class="w-full sm:w-auto px-6 py-3 bg-slate-900 hover:bg-black text-white font-extrabold text-xs rounded-full shadow-lg transition-all flex items-center justify-center gap-2">
            <i class="fa-solid fa-print"></i> Imprimir Ticket / Guardar PDF
        </button>
        <a href="{{ route('client.perfil') }}" class="w-full sm:w-auto px-6 py-3 bg-white border border-slate-300 hover:border-orange-500 text-slate-700 hover:text-orange-600 font-extrabold text-xs rounded-full transition-all flex items-center justify-center gap-2 shadow-xs">
            <i class="fa-solid fa-clock-rotate-left"></i> Historial de Pedidos
        </a>
        <a href="{{ route('home') }}" class="w-full sm:w-auto px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-extrabold text-xs rounded-full shadow-md transition-all flex items-center justify-center gap-2">
            <i class="fa-solid fa-utensils"></i> Volver al Menu
        </a>
    </div>

</div>
@endsection
