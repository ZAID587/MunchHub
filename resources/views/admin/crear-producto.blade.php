@extends('layouts.admin')

@section('title', 'Agregar Nuevo Alimento')

@section('content')
<div class="space-y-8 max-w-4xl mx-auto">

    <div class="flex items-center justify-between border-b border-slate-200 pb-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.productos') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 flex items-center justify-center font-bold text-sm shadow-xs transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-black text-slate-900">Agregar Nuevo Alimento</h1>
                <p class="text-xs text-slate-500">Ingresa la información del nuevo platillo o bebida para el menú.</p>
            </div>
        </div>
    </div>

    <!-- Formulario con enctype para permitir subida de archivos directa -->
    <form action="{{ route('admin.productos.almacenar') }}" method="POST" enctype="multipart/form-data" id="createProductForm" class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-10 shadow-sm space-y-6 text-xs">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
            
            <!-- Vista Previa y Opciones de Imagen -->
            <div class="md:col-span-5 space-y-4">
                <label class="block font-bold text-slate-700 uppercase tracking-wider text-[11px]">
                    Imagen del Alimento: *
                </label>
                
                <div class="w-full aspect-square rounded-2xl overflow-hidden bg-slate-100 border-2 border-slate-200 shadow-xs flex items-center justify-center relative group">
                    <img id="preview-img" 
                         src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&auto=format&fit=crop&q=60" 
                         alt="Vista previa" 
                         class="w-full h-full object-cover">
                    <div class="absolute bottom-2 right-2 bg-slate-900/80 text-white text-[10px] px-2 py-1 rounded-md backdrop-blur-sm">
                        Vista previa
                    </div>
                </div>

                <!-- Opcion 1: Subir directamente desde el dispositivo -->
                <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200 space-y-1.5">
                    <label class="block font-bold text-slate-800 text-[11px] flex items-center gap-1.5">
                        <i class="fa-solid fa-cloud-arrow-up text-orange-600"></i> Opción A: Subir desde tu dispositivo
                    </label>
                    <input type="file" name="image_file" id="imageFileInput" accept="image/*"
                           class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-orange-600 file:text-white hover:file:bg-orange-700 cursor-pointer">
                    <span class="text-[10px] text-slate-400 block">Se guardará permanentemente en el servidor para que no dependa de tu dispositivo actual.</span>
                </div>

                <!-- Opcion 2: Ingresar link de internet -->
                <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200 space-y-1.5">
                    <label class="block font-bold text-slate-800 text-[11px] flex items-center gap-1.5">
                        <i class="fa-solid fa-link text-blue-600"></i> Opción B: O pegar link de imagen
                    </label>
                    <input type="url" name="image" id="imageUrlInput" value="{{ old('image') }}"
                           placeholder="https://wikipedia.org/... o facebook.com/..."
                           class="w-full p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-red-500 focus:outline-none bg-white">
                    <span class="text-[10px] text-slate-400 block">Puedes usar imágenes de Wikipedia, redes sociales o bancos de imágenes.</span>
                </div>
            </div>

            <!-- Campos del Producto -->
            <div class="md:col-span-7 space-y-4">
                
                <!-- Nombre del Alimento (VALIDACION ESTRICTA: SIN NUMEROS) -->
                <div>
                    <label class="block font-bold text-slate-700 mb-1 uppercase tracking-wider text-[11px]">
                        Nombre del Alimento (Solo letras): *
                    </label>
                    <input type="text" name="name" id="productNameInput" value="{{ old('name') }}" required
                           onkeypress="return validateStrictLetters(event)"
                           placeholder="Ej: Tacos al Pastor, Pizza Pepperoni, Hamburguesa con Queso"
                           class="w-full p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-red-500 focus:outline-none font-bold text-slate-900 text-sm">
                    <span class="text-[10px] text-slate-400 mt-1 block">Validación estricta: Bloquea números automáticamente (ej: "papas 555" denegado).</span>
                </div>

                <!-- Categoria y Precio -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1 uppercase tracking-wider text-[11px]">
                            Categoría: *
                        </label>
                        <select name="category" required class="w-full p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-red-500 focus:outline-none bg-white font-semibold">
                            <option value="Pizzas">Pizzas</option>
                            <option value="Hamburguesas">Hamburguesas</option>
                            <option value="Tortas">Tortas</option>
                            <option value="Tacos">Tacos</option>
                            <option value="Bebidas">Bebidas y Refrescos</option>
                            <option value="Papas">Papas y Snacks</option>
                            <option value="Panadería">Panadería</option>
                            <option value="Postres">Postres</option>
                            <option value="Cafetería">Cafetería Gardello</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1 uppercase tracking-wider text-[11px]">
                            Precio ($ MXN): *
                        </label>
                        <input type="text" name="price" id="productPriceInput" value="{{ old('price') }}" required 
                               onkeypress="return validateStrictNumbers(event)"
                               placeholder="Ej: 85.00"
                               class="w-full p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-red-500 focus:outline-none font-bold text-slate-900">
                    </div>
                </div>

                <!-- Tiempo de preparacion -->
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Tiempo Estimado de Preparación:</label>
                    <input type="text" name="prep_time" value="{{ old('prep_time', '15 min') }}" placeholder="15-20 min"
                           class="w-full p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-red-500 focus:outline-none">
                </div>

                <!-- Ingredientes Personalizables para el Cliente -->
                <div class="p-4 bg-orange-50/60 rounded-2xl border border-orange-200 space-y-1.5">
                    <label class="block font-bold text-orange-900 uppercase tracking-wider text-[11px] flex items-center gap-1.5">
                        <i class="fa-solid fa-sliders text-orange-600"></i> Ingredientes Personalizables por el Cliente:
                    </label>
                    <input type="text" name="customizable_ingredients" value="{{ old('customizable_ingredients') }}"
                           placeholder="Ej: Cebolla, Salsa, Crema, Cilantro, Salsas Aparte"
                           class="w-full p-2.5 rounded-xl border border-orange-200 focus:ring-2 focus:ring-orange-500 focus:outline-none bg-white text-xs text-slate-800">
                    <p class="text-[10px] text-orange-800 leading-relaxed">
                        Escribe los ingredientes separados por coma que el cliente podrá desmarcar (ej: "Sin Cebolla", "Sin Salsa", etc.). Si lo dejas vacío, se usarán los ingredientes sugeridos según la categoría.
                    </p>
                </div>

                <!-- Descripcion Corta -->
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Descripción Corta (Para tarjetas del catálogo): *</label>
                    <input type="text" name="short_description" value="{{ old('short_description') }}" required
                           placeholder="Resumen de ingredientes y sabor..."
                           class="w-full p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-red-500 focus:outline-none">
                </div>

                <!-- Descripcion Completa -->
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Descripción Detallada:</label>
                    <textarea name="description" rows="3" placeholder="Detalles de preparación artesanal, porciones e información para el comensal..."
                              class="w-full p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-red-500 focus:outline-none">{{ old('description') }}</textarea>
                </div>

                <!-- Marcar como Lo Mas Vendido -->
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                    <label class="flex items-center gap-2 cursor-pointer font-bold text-slate-800">
                        <input type="checkbox" name="is_best_seller" value="1" class="rounded text-red-600 focus:ring-red-500">
                        <span>Destacar en sección "Lo más vendido" del catálogo</span>
                    </label>
                </div>

                <!-- Botones de Accion -->
                <div class="pt-4 flex items-center gap-3">
                    <button type="submit" class="px-7 py-3 bg-red-600 hover:bg-red-700 text-white font-extrabold text-xs rounded-xl shadow-md transition-all flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Guardar Alimento en Menú
                    </button>
                    <a href="{{ route('admin.productos') }}" class="px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-colors">
                        Cancelar
                    </a>
                </div>

            </div>

        </div>

    </form>

</div>

<script>
    // Vista previa dinámica para URL
    const urlInput = document.getElementById('imageUrlInput');
    const fileInput = document.getElementById('imageFileInput');
    const previewImg = document.getElementById('preview-img');

    if (urlInput && previewImg) {
        urlInput.addEventListener('input', function() {
            if (this.value && this.value.trim().length > 10) {
                previewImg.src = this.value.trim();
            }
        });
    }

    // Vista previa dinámica para archivo del dispositivo
    if (fileInput && previewImg) {
        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    }
</script>
@endsection
