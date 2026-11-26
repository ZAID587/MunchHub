@extends('layouts.client')

@section('title', 'Aviso de Privacidad - MunchHub')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 space-y-8">
    
    <!-- Encabezado -->
    <div class="border-b border-slate-200 pb-6">
        <span class="text-xs font-bold uppercase tracking-wider text-orange-600 block mb-1">
            Protección de Datos Personales
        </span>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900">
            Aviso de Privacidad Integral
        </h1>
        <p class="text-xs text-slate-500 mt-2">
            Conforme a la Ley Federal de Protección de Datos Personales en Posesión de los Particulares &bull; MunchHub UPVT
        </p>
    </div>

    <!-- Contenido Legal -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-10 shadow-xs space-y-6 text-xs sm:text-sm text-slate-600 leading-relaxed">
        
        <section class="space-y-2">
            <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-shield-halved text-orange-600"></i> 1. Identidad y Domicilio del Responsable
            </h2>
            <p>
                <strong>MunchHub Restaurante & Cocina</strong>, con domicilio operativo en las instalaciones de la <strong>Universidad Politécnica del Valle de Toluca (UPVT)</strong>, Carretera Toluca - Almoloya de Juárez Km 5.6, Estado de México, es el responsable del uso, tratamiento y protección de sus datos personales.
            </p>
        </section>

        <section class="space-y-2">
            <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-database text-orange-600"></i> 2. Datos Personales que Recabamos
            </h2>
            <p>
                Para llevar a cabo las finalidades descritas en el presente aviso, recabamos los siguientes datos de forma directa a través de nuestros formularios web:
            </p>
            <ul class="list-disc pl-5 space-y-1">
                <li>Nombre completo y nombre de usuario.</li>
                <li>Correo electrónico institucional o personal.</li>
                <li>Número telefónico de contacto para avisos de entrega.</li>
                <li>Dirección de entrega o número de mesa dentro del restaurante.</li>
                <li>Contraseña de acceso (almacenada estrictamente bajo cifrado unidireccional Bcrypt).</li>
            </ul>
        </section>

        <section class="space-y-2">
            <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-bullseye text-orange-600"></i> 3. Finalidades del Tratamiento de Datos
            </h2>
            <p>Sus datos personales serán utilizados para las siguientes finalidades primarias y necesarias:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li>Crear y gestionar su cuenta de usuario en el sistema.</li>
                <li>Procesar, preparar y despachar sus órdenes de alimentos y bebidas.</li>
                <li>Generar comprobantes de compra y tickets digitales en PDF.</li>
                <li>Validar la seguridad de acceso y prevenir accesos no autorizados mediante sesiones seguras.</li>
                <li>Calcular costos de envío (gratuito a partir de $450.00 MXN o tarifa fija de $69.00 MXN).</li>
            </ul>
        </section>

        <section class="space-y-2">
            <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-lock text-orange-600"></i> 4. Medidas de Seguridad y Cifrado
            </h2>
            <p>
                MunchHub cuenta con estrictas medidas técnicas y administrativas para resguardar su información:
            </p>
            <ul class="list-disc pl-5 space-y-1">
                <li><strong>Cifrado SSL/TLS (HTTPS):</strong> Todas las comunicaciones entre su navegador y nuestro servidor viajan cifradas con un certificado digital emitido por Let's Encrypt.</li>
                <li><strong>Prevención de Inyecciones SQL:</strong> Todas las consultas a la base de datos se ejecutan con sentencias preparadas (PDO) a través de Laravel Eloquent.</li>
                <li><strong>Protección de Contraseñas:</strong> Ninguna contraseña se almacena en texto legible; se utiliza hash Bcrypt con sal aleatoria.</li>
                <li><strong>Protección de Pagos:</strong> Los datos de tarjetas bancarias no se almacenan permanentemente en nuestros servidores; únicamente se validan en tiempo real para autorizar la transacción.</li>
            </ul>
        </section>

        <section class="space-y-2">
            <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-id-card text-orange-600"></i> 5. Derechos ARCO (Acceso, Rectificación, Cancelación y Oposición)
            </h2>
            <p>
                Usted tiene derecho a conocer qué datos personales tenemos de usted, para qué los utilizamos y las condiciones de su uso (Acceso). Asimismo, tiene derecho a solicitar la corrección de su información personal en caso de que esté desactualizada, sea inexacta o incompleta (Rectificación); que la eliminemos de nuestros registros cuando considere que no está siendo utilizada adecuadamente (Cancelación); así como a oponerse al uso de sus datos para fines específicos (Oposición).
            </p>
            <p>
                Puede ejercer estos derechos editando directamente su información en la sección <strong>Mi Perfil</strong> dentro de la plataforma o enviando una solicitud al correo oficial del administrador del sistema.
            </p>
        </section>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
            <a href="{{ route('home') }}" class="px-5 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-extrabold text-xs rounded-xl shadow-md transition-all">
                ← Volver al Menú Principal
            </a>
            <a href="{{ route('legal.terminos') }}" class="text-xs font-bold text-orange-600 hover:underline">
                Consultar Términos y Condiciones →
            </a>
        </div>

    </div>

</div>
@endsection