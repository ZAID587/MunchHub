@extends('layouts.client')

@section('title', 'Términos y Condiciones - MunchHub')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 space-y-8">
    
    <!-- Encabezado -->
    <div class="border-b border-slate-200 pb-6">
        <span class="text-xs font-bold uppercase tracking-wider text-orange-600 block mb-1">
            Políticas y Normativa del Servicio
        </span>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900">
            Términos y Condiciones de Uso
        </h1>
        <p class="text-xs text-slate-500 mt-2">
            Última actualización: Noviembre 2026 &bull; MunchHub Restaurante & Cocina (UPVT)
        </p>
    </div>

    <!-- Contenido Legal -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-10 shadow-xs space-y-6 text-xs sm:text-sm text-slate-600 leading-relaxed">
        
        <section class="space-y-2">
            <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-shop text-orange-600"></i> 1. Aceptación del Servicio
            </h2>
            <p>
                Al acceder y utilizar el sistema web de <strong>MunchHub Restaurante & Cocina</strong> (en adelante, "la Plataforma"), el usuario acepta regirse por los presentes Términos y Condiciones. Este sistema está orientado a la comunidad universitaria de la <strong>Universidad Politécnica del Valle de Toluca (UPVT)</strong> y zonas aledañas para la visualización del menú, personalización de pedidos y generación de comprobantes digitales de compra.
            </p>
        </section>

        <section class="space-y-2">
            <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-user-check text-orange-600"></i> 2. Registro y Cuentas de Usuario
            </h2>
            <p>
                Para realizar pedidos a través del carrito de compras es indispensable registrarse proporcionando información veraz (nombre, usuario, correo electrónico y contraseña segura). Las credenciales son personales e intransferibles. Las contraseñas se almacenan mediante algoritmos criptográficos irreversibles (Bcrypt); no obstante, el usuario es responsable de resguardar la confidencialidad de su acceso.
            </p>
            <p>
                El acceso a funciones de administración está estrictamente reservado para el personal autorizado y protegido mediante doble factor de autenticación con código PIN confidencial.
            </p>
        </section>

        <section class="space-y-2">
            <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-utensils text-orange-600"></i> 3. Pedidos, Menú y Disponibilidad
            </h2>
            <p>
                Los precios de los platillos, bebidas, pizzas, tortas, tacos y postres están expresados en pesos mexicanos (MXN) e incluyen impuestos aplicables. Los platillos se preparan al momento de acuerdo con las especificaciones seleccionadas (ingredientes omitidos, términos de cocción, temperaturas y notas para el cocinero). MunchHub se reserva el derecho de modificar el catálogo y disponibilidad de alimentos según existencias en cocina.
            </p>
        </section>

        <section class="space-y-2">
            <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-truck text-orange-600"></i> 4. Política de Envíos y Entregas
            </h2>
            <p>
                MunchHub ofrece tres modalidades de servicio: consumo en mesa (Mesas 1 a 4), entrega para llevar en mostrador, y entrega a domicilio en la zona UPVT (Almoloya de Juárez / Toluca).
            </p>
            <ul class="list-disc pl-5 space-y-1 text-slate-700 font-medium">
                <li><strong>Envío GRATIS:</strong> Aplica automáticamente en órdenes con subtotal igual o superior a <strong>$450.00 MXN</strong>.</li>
                <li><strong>Envío Estándar:</strong> En compras menores a <strong>$450.00 MXN</strong>, se aplica una cuota fija de envío de <strong>$69.00 MXN</strong>.</li>
            </ul>
        </section>

        <section class="space-y-2">
            <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-credit-card text-orange-600"></i> 5. Métodos de Pago y Seguridad de Transacciones
            </h2>
            <p>
                Los usuarios pueden liquidar sus órdenes mediante:
            </p>
            <ul class="list-disc pl-5 space-y-1">
                <li><strong>Efectivo:</strong> Al recibir la orden en mostrador, en mesa o al repartidor.</li>
                <li><strong>Transferencia Electrónica (SPEI / BBVA):</strong> Vía banca móvil utilizando la CLABE interbancaria proporcionada en el resumen de orden.</li>
                <li><strong>Tarjeta de Crédito o Débito (Visa, Mastercard, American Express):</strong> Procesada con cifrado SSL/TLS. Los datos de la tarjeta son validados estrictamente en el servidor para evitar fraudes y no se almacenan en texto plano.</li>
            </ul>
        </section>

        <section class="space-y-2">
            <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-ban text-orange-600"></i> 6. Cancelaciones y Reembolsos
            </h2>
            <p>
                Debido a la naturaleza perecedera de los alimentos preparados al momento, una vez que la orden pasa al estado <em>"En preparación"</em> en cocina, no se aceptan cancelaciones directas. Si existe alguna inconsistencia con tu pedido o platillos con faltantes, el usuario puede acudir al mostrador central o presentar su ticket digital generado en la plataforma para aclaración inmediata.
            </p>
        </section>

        <section class="space-y-2">
            <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-star text-orange-600"></i> 7. Opiniones y Evaluaciones de Usuarios
            </h2>
            <p>
                Los comensales registrados pueden calificar de 1 a 5 estrellas y redactar comentarios sobre los platillos consumidos. No se permiten comentarios con lenguaje ofensivo, spam o publicidad ajena. El administrador del sistema cuenta con facultades para moderar o eliminar opiniones que infrinjan estas normas de convivencia.
            </p>
        </section>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
            <a href="{{ route('home') }}" class="px-5 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-extrabold text-xs rounded-xl shadow-md transition-all">
                ← Volver al Menú Principal
            </a>
            <a href="{{ route('legal.privacidad') }}" class="text-xs font-bold text-orange-600 hover:underline">
                Consultar Aviso de Privacidad →
            </a>
        </div>

    </div>

</div>
@endsection