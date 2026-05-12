<div class="mb-8 flex flex-col sm:flex-row justify-between items-center gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-gray-900">Galería General</h1>
        <p class="text-gray-500 text-sm mt-1">Gestiona las fotos que aparecerán en la sección de Galería del Inicio.</p>
    </div>
    <div class="flex items-center gap-3">
        <button type="button" onclick="document.getElementById('new_images').click()" class="bg-primary hover:bg-secondary text-white px-6 py-3 rounded-xl text-sm font-bold transition-all duration-300 flex items-center gap-2 shadow-lg shadow-primary/20 transform hover:-translate-y-0.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Subir Nuevas Fotos
        </button>
    </div>
</div>

<?php if(isset($_GET['success'])): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-2xl relative mb-6 animate-fade-in-down">
        <strong class="font-bold">¡Éxito!</strong>
        <span class="block sm:inline">Los cambios en la galería han sido procesados correctamente.</span>
    </div>
<?php endif; ?>

<form action="<?= url('admin/galeria/save') ?>" method="POST" enctype="multipart/form-data" class="space-y-8">
    <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
    <input type="file" id="new_images" name="new_images[]" multiple class="hidden" accept="image/*" onchange="this.form.submit()">

    <!-- Configuración de Textos en Home -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 bg-gray-50/50 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-800">Configuración de la Sección</h2>
                <p class="text-xs text-gray-400">Personaliza los títulos que se verán en el Inicio sobre esta galería.</p>
            </div>
        </div>
        
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">Etiqueta Superior (Tagline)</label>
                <input type="text" name="gallery_home_tagline" value="<?= htmlspecialchars($settings['gallery_home_tagline'] ?? 'Visualiza Nuestro Trabajo') ?>" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-transparent text-sm font-medium transition-shadow">
            </div>
            <div>
                <label class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">Título de la Sección</label>
                <input type="text" name="gallery_home_title" value="<?= htmlspecialchars($settings['gallery_home_title'] ?? 'Galería de Excelencia') ?>" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-transparent text-sm font-medium transition-shadow">
            </div>
            <div>
                <label class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">Subtítulo / Descripción</label>
                <textarea name="gallery_home_subtitle" rows="1" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-transparent text-sm font-medium transition-shadow resize-none"><?= htmlspecialchars($settings['gallery_home_subtitle'] ?? 'Descubre en imágenes nuestro compromiso con la precisión, tecnología e innovación.') ?></textarea>
            </div>
        </div>
    </div>

    <!-- Rejilla de la Galería -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-teal-100 text-teal-600 flex items-center justify-center shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Fotos Existentes</h2>
                    <p class="text-xs text-gray-400">Arrastra y suelta para cambiar el orden de aparición.</p>
                </div>
            </div>
            
            <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl shadow-md shadow-emerald-600/20 transition-all">
                Guardar Cambios Actuales
            </button>
        </div>

        <div class="p-6">
            <?php if(empty($items)): ?>
                <div class="flex flex-col items-center justify-center py-16 border-2 border-dashed border-gray-200 rounded-3xl bg-gray-50 text-center px-4 cursor-pointer group hover:border-primary hover:bg-blue-50/30 transition-all" onclick="document.getElementById('new_images').click()">
                    <div class="w-16 h-16 rounded-full bg-white shadow-md flex items-center justify-center text-gray-400 group-hover:text-primary group-hover:scale-110 transition-transform mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <h3 class="text-lg font-extrabold text-gray-700">No hay fotos en la galería</h3>
                    <p class="text-sm text-gray-400 mt-1">Haz clic aquí o usa el botón superior para subir múltiples imágenes.</p>
                </div>
            <?php else: ?>
                <div id="gallery-grid" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                    <?php foreach($items as $item): ?>
                        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-xl transition-shadow overflow-hidden group cursor-grab active:cursor-grabbing gallery-item relative flex flex-col" data-id="<?= $item['id'] ?>">
                            <!-- Drag Handle / Imagen -->
                            <div class="relative h-40 overflow-hidden bg-gray-50 border-b border-gray-100">
                                <img src="<?= asset($item['image_path']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                
                                <!-- Botón Eliminar -->
                                <button type="button" onclick="deleteItem(<?= $item['id'] ?>)" class="absolute top-2 right-2 w-8 h-8 bg-red-600 text-white rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-lg hover:bg-red-700 z-10" title="Borrar Imagen">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>

                                <!-- Drag Indicator -->
                                <div class="absolute top-2 left-2 w-8 h-8 bg-black/50 backdrop-blur-sm text-white rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path></svg>
                                </div>
                            </div>

                            <!-- Metadatos / Inputs -->
                            <div class="p-3 space-y-2">
                                <div>
                                    <label class="block text-[9px] font-extrabold uppercase tracking-widest text-gray-400 mb-0.5">Título opcional</label>
                                    <input type="text" name="existing_items[<?= $item['id'] ?>][title]" value="<?= htmlspecialchars($item['title'] ?? '') ?>" placeholder="Ej: Equipamiento" class="w-full px-2 py-1.5 text-xs border border-gray-200 rounded-lg focus:outline-none focus:border-primary transition-colors">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-extrabold uppercase tracking-widest text-gray-400 mb-0.5">Texto ALT (SEO)</label>
                                    <input type="text" name="existing_items[<?= $item['id'] ?>][image_alt]" value="<?= htmlspecialchars($item['image_alt'] ?? '') ?>" placeholder="Ej: Tablero de control..." class="w-full px-2 py-1.5 text-xs border border-gray-200 rounded-lg focus:outline-none focus:border-primary transition-colors bg-gray-50/50">
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</form>

<!-- Form Oculto para Eliminar -->
<form id="delete-form" action="<?= url('admin/galeria/delete') ?>" method="POST">
    <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
    <input type="hidden" name="id" id="delete-item-id">
</form>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
function deleteItem(id) {
    if (confirm('¿Seguro que deseas eliminar esta imagen permanentemente?')) {
        document.getElementById('delete-item-id').value = id;
        document.getElementById('delete-form').submit();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const grid = document.getElementById('gallery-grid');
    if (grid) {
        Sortable.create(grid, {
            animation: 250,
            ghostClass: 'opacity-50',
            chosenClass: 'scale-105',
            dragClass: 'shadow-2xl',
            onEnd: function() {
                // Capturar nuevo orden
                const items = grid.querySelectorAll('.gallery-item');
                const ids = Array.from(items).map(el => el.dataset.id);
                
                // Enviar por AJAX
                fetch('<?= url('admin/galeria/reorder') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ ids: ids })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Orden actualizado');
                    }
                })
                .catch(err => console.error('Error reordenando:', err));
            }
        });
    }
});
</script>
