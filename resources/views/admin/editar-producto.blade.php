@extends('layouts.admin')

@section('title', 'Editar Platillo: ' . $producto->name)

@section('content')
<div class="space-y-8 max-w-4xl mx-auto">

    <div class="flex items-center justify-between border-b border-slate-200 pb-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.productos') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 flex items-center justify-center font-bold text-sm shadow-xs transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-black text-slate-900">Editar Platillo: {{ $producto->name }}</h1>
                <p class="text-xs text-slate-500">Modifica los detalles, precios, imagen e ingredientes del menú.</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.productos.guardar', $producto->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-10 shadow-sm space-y-6 text-xs">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
            
            <!-- Vista Previa de Imagen y Subida -->
            <div class="md:col-span-5 space-y-4">
                <label class="block font-bold text-slate-700 uppercase tracking-wider text-[11px]">
                    Imagen Actual / Nueva:
                </label>
                <div class="w-full aspect-square rounded-2xl overflow-hidden bg-slate-100 border-2 border-slate-200 shadow-xs flex items-center justify-center relative">
                    <img id="preview-img" 
                         src="{{ $producto->image }}" 
                         alt="{{ $producto->name }}" 
                         class="w-full h-full object-cover">
                </div>

                <!-- Subir desde dispositivo -->
                <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200 space-y-1.5">
                    <label class="block font-bold text-slate-800 text-[11px] flex items-center gap-1.5">
                        <i class="fa-solid fa-cloud-arrow-up text-orange-600"></i> Opción A: Reemplazar imagen desde tu dispositivo
                    </label>
                    <input type="file" name="image_file" id="imageFileInput" accept="image/*"
                           class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-orange-600 file:text-white hover:file:bg-orange-700 cursor-pointer">
                    <span class="text-[10px] text-slate-400 block">Se guardará permanentemente en el servidor.</span>
                </div>

                <!-- O pegar link -->
                <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200 space-y-1.5">
                    <label class="block font-bold text-slate-800 text-[11px] flex items-center gap-1.5">
                        <i class="fa-solid fa-link text-blue-600"></i> Opción B: O actualizar con URL de internet
                    </label>
                    <input type="url" name="image" id="imageUrlInput" value="{{ old('image', $producto->image) }}"
                           placeholder="https://..."
                           class="w-full p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-red-500 focus:outline-none bg-white">
                </div>
            </div>

            <!-- Campos del Producto -->
            <div class="md:col-span-7 space-y-4">
                
                <!-- Nombre del Alimento -->
                <div>
                    <label class="block font-bold text-slate-700 mb-1 uppercase tracking-wider text-[11px]">
                        Nombre del Alimento (Solo letras): *
                    </label>
                    <input type="text" name="name" value="{{ old('name', $producto->name) }}" required
                           onkeypress="return validateStrictLetters(event)"
                           class="w-full p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-red-500 focus:outline-none font-bold text-slate-900 text-sm">
                </div>

                <!-- Categoria y Precio -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1 uppercase tracking-wider text-[11px]">
                            Categoría: *
                        </label>
                        <select name="category" required class="w-full p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-red-500 focus:outline-none bg-white font-semibold">
                            <option value="Pizzas" {{ $producto->category === 'Pizzas' ? 'selected' : '' }}>Pizzas</option>
                            <option value="Hamburguesas" {{ $producto->category === 'Hamburguesas' ? 'selected' : '' }}>Hamburguesas</option>
                            <option value="Tortas" {{ $producto->category === 'Tortas' ? 'selected' : '' }}>Tortas</option>
                            <option value="Tacos" {{ $producto->category === 'Tacos' ? 'selected' : '' }}>Tacos</option>
                            <option value="Bebidas" {{ $producto->category === 'Bebidas' ? 'selected' : '' }}>Bebidas y Refrescos</option>
                            <option value="Papas" {{ $producto->category === 'Papas' ? 'selected' : '' }}>Papas y Snacks</option>
                            <option value="Panadería" {{ $producto->category === 'Panadería' ? 'selected' : '' }}>Panadería</option>
                            <option value="Postres" {{ $producto->category === 'Postres' ? 'selected' : '' }}>Postres</option>
                            <option value="Cafetería" {{ $producto->category === 'Cafetería' ? 'selected' : '' }}>Cafetería Gardello</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1 uppercase tracking-wider text-[11px]">
                            Precio ($ MXN): *
                        </label>
                        <input type="text" name="price" value="{{ old('price', $producto->price) }}" required
                               onkeypress="return validateStrictNumbers(event)"
                               class="w-full p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-red-500 focus:outline-none font-bold text-slate-900">
                    </div>
                </div>

                <!-- Tiempo estimado -->
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Tiempo Estimado de Preparación:</label>
                    <input type="text" name="prep_time" value="{{ old('prep_time', $producto->prep_time) }}"
                           class="w-full p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-red-500 focus:outline-none">
                </div>

                <!-- Ingredientes Personalizables -->
                <div class="p-4 bg-orange-50/60 rounded-2xl border border-orange-200 space-y-1.5">
                    <label class="block font-bold text-orange-900 uppercase tracking-wider text-[11px] flex items-center gap-1.5">
                        <i class="fa-solid fa-sliders text-orange-600"></i> Ingredientes Personalizables por el Cliente:
                    </label>
                    <input type="text" name="customizable_ingredients" value="{{ old('customizable_ingredients', $producto->customizable_ingredients) }}"
                           placeholder="Ej: Cebolla, Salsa, Crema, Cilantro, Salsas Aparte"
                           class="w-full p-2.5 rounded-xl border border-orange-200 focus:ring-2 focus:ring-orange-500 focus:outline-none bg-white text-xs text-slate-800">
                    <p class="text-[10px] text-orange-800 leading-relaxed">
                        Ingredientes separados por coma que el cliente podrá desmarcar en su orden.
                    </p>
                </div>

                <!-- Descripcion Corta -->
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Descripción Corta: *</label>
                    <input type="text" name="short_description" value="{{ old('short_description', $producto->short_description) }}" required
                           class="w-full p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-red-500 focus:outline-none">
                </div>

                <!-- Descripcion Completa -->
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Descripción Detallada:</label>
                    <textarea name="description" rows="3" class="w-full p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-red-500 focus:outline-none">{{ old('description', $producto->description) }}</textarea>
                </div>

                <!-- Destacado -->
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                    <label class="flex items-center gap-2 cursor-pointer font-bold text-slate-800">
                        <input type="checkbox" name="is_best_seller" value="1" {{ $producto->is_best_seller ? 'checked' : '' }} class="rounded text-red-600 focus:ring-red-500">
                        <span>Destacar en sección "Lo más vendido" del catálogo</span>
                    </label>
                </div>

                <!-- Botones -->
                <div class="pt-4 flex items-center gap-3">
                    <button type="submit" class="px-7 py-3 bg-red-600 hover:bg-red-700 text-white font-extrabold text-xs rounded-xl shadow-md transition-all flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Guardar Cambios
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
