<div class="mb-8 flex flex-col sm:flex-row justify-between items-center gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-gray-900">Sliders Principales</h1>
        <p class="text-gray-500 text-sm mt-1">Configura las imágenes y textos que aparecen en la página de inicio. Arrastra para reordenar.</p>
    </div>
    <button onclick="openSliderModal()" class="bg-primary hover:bg-secondary text-white px-6 py-3 rounded-xl text-sm font-bold transition-colors flex items-center gap-2 shadow-lg shadow-primary/30">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Nuevo Slider
    </button>
</div>

<?php if(isset($_GET['success'])): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative mb-6 shadow-sm flex items-center gap-3">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span class="block sm:inline font-medium">¡Operación realizada con éxito!</span>
    </div>
<?php endif; ?>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 text-gray-400 text-[11px] font-bold uppercase tracking-widest border-b border-gray-100">
                    <th class="px-8 py-5 text-center w-20">Orden</th>
                    <th class="px-8 py-5">Imagen</th>
                    <th class="px-8 py-5">Contenido</th>
                    <th class="px-8 py-5 text-center">Estado</th>
                    <th class="px-8 py-5 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody id="sortable-sliders" class="divide-y divide-gray-50">
                <?php if(!empty($sliders)): ?>
                    <?php foreach($sliders as $slider): ?>
                        <tr data-id="<?= $slider['id'] ?>" class="hover:bg-blue-50/30 transition-colors group">
                            <td class="px-8 py-5 text-center cursor-move text-gray-300 group-hover:text-secondary drag-handle">
                                <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            </td>
                            <td class="px-8 py-5">
                                <div class="w-24 h-14 rounded-xl bg-gray-100 overflow-hidden shadow-sm border border-gray-200">
                                    <?php if(!empty($slider['image_path'])): ?>
                                        <img src="<?= asset($slider['image_path']) ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="block font-extrabold text-gray-900 group-hover:text-secondary transition-colors"><?= htmlspecialchars($slider['title']) ?></span>
                                <span class="block text-xs text-gray-500 mt-0.5 line-clamp-1"><?= htmlspecialchars($slider['subtitle']) ?></span>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" <?= $slider['is_active'] ? 'checked' : '' ?> 
                                           onchange="toggleSliderStatus(<?= $slider['id'] ?>, this.checked)">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-secondary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-secondary"></div>
                                </label>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <div class="flex justify-end gap-2">
                                    <button onclick="editSlider(<?= htmlspecialchars(json_encode($slider)) ?>)" class="w-9 h-9 rounded-xl bg-gray-100 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-all shadow-sm" title="Editar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    <form action="<?= url('admin/sliders/duplicate') ?>" method="POST" class="inline-block">
                                        <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
                                        <input type="hidden" name="id" value="<?= $slider['id'] ?>">
                                        <button type="submit" class="w-9 h-9 rounded-xl bg-gray-100 text-teal-600 hover:bg-teal-600 hover:text-white flex items-center justify-center transition-all shadow-sm" title="Duplicar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg>
                                        </button>
                                    </form>
                                    <form action="<?= url('admin/sliders/delete') ?>" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este slider? Se borrará permanentemente la imagen asociada.');" class="inline-block">
                                        <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
                                        <input type="hidden" name="id" value="<?= $slider['id'] ?>">
                                        <button type="submit" class="w-9 h-9 rounded-xl bg-gray-100 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center transition-all shadow-sm" title="Eliminar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center text-gray-400 italic bg-gray-50/30">No se encontraron sliders configurados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal para Sliders -->
<div id="slider-modal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden z-50 items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 w-full max-w-3xl overflow-hidden transform transition-all scale-95 opacity-0 duration-300" id="modal-container">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h4 id="modal-title" class="text-xl font-extrabold text-gray-900">Nuevo Slider</h4>
            <button onclick="closeSliderModal()" class="text-gray-400 hover:text-gray-600 transition-colors p-2 hover:bg-white rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <form action="<?= url('admin/sliders/save') ?>" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
            <input type="hidden" name="id" id="slider-id" value="">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Columna Izquierda: Información del Slider -->
                <div class="space-y-5">
                    <div class="border-b border-gray-100 pb-3">
                        <span class="text-xs font-extrabold text-secondary uppercase tracking-widest">1. Contenido Escrito</span>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Etiqueta Superior</label>
                        <input type="text" name="top_label" id="slider-top-label" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm transition-all bg-gray-50 focus:bg-white" placeholder="Ej: SYNCRO ANDINA">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Título Principal</label>
                        <input type="text" name="title" id="slider-title" required class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm transition-all bg-gray-50 focus:bg-white" placeholder="Ej: Ingeniería de Vanguardia">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Subtítulo / Descripción</label>
                        <textarea name="subtitle" id="slider-subtitle" rows="4" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm transition-all bg-gray-50 focus:bg-white resize-none leading-relaxed" placeholder="Breve descripción que se mostrará sobre la imagen del slider..."></textarea>
                    </div>
                </div>
                
                <!-- Columna Derecha: Imagen del Slider y Acción -->
                <div class="space-y-5">
                    <div class="border-b border-gray-100 pb-3">
                        <span class="text-xs font-extrabold text-secondary uppercase tracking-widest">2. Aspecto Visual y Acción</span>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Imagen del Slider</label>
                        <div class="relative group">
                            <div class="w-full h-44 rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 overflow-hidden flex flex-col items-center justify-center relative cursor-pointer hover:border-secondary hover:bg-white transition-all duration-300" onclick="document.getElementById('slider-image').click()">
                                <img id="image-preview" src="" class="hidden w-full h-full object-cover">
                                <div id="upload-placeholder" class="text-center p-4">
                                    <div class="w-10 h-10 rounded-full bg-secondary/10 flex items-center justify-center mx-auto mb-2 text-secondary group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <span class="text-xs font-extrabold text-gray-700 block mb-0.5">Seleccionar Imagen</span>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase">Recomendado: 1920x1080 px</span>
                                </div>
                                <div class="absolute inset-0 bg-black/45 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center text-white text-xs font-bold gap-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span>Cambiar Imagen</span>
                                </div>
                            </div>
                            <input type="file" name="image" id="slider-image" class="hidden" accept="image/*" onchange="previewSliderImage(this)">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Texto del Botón</label>
                            <input type="text" name="button_text" id="slider-btn-text" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50 focus:bg-white transition-all" placeholder="Ej: Ver Servicios">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Link del Botón</label>
                            <input type="text" name="button_link" id="slider-btn-link" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50 focus:bg-white transition-all" placeholder="Ej: /servicios">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Estado del Slider</label>
                        <div class="h-[52px] flex items-center justify-between px-4 bg-gray-50 border border-gray-200 rounded-2xl">
                            <span class="text-xs font-bold text-gray-500">¿Mostrar en la página de inicio?</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" id="slider-active" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-secondary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-secondary"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 pt-6 border-t border-gray-100">
                <button type="button" onclick="closeSliderModal()" class="flex-1 px-6 py-4 bg-gray-100 text-gray-600 rounded-2xl font-bold hover:bg-gray-200 transition-all">Cancelar</button>
                <button type="submit" class="flex-[2] px-6 py-4 bg-primary text-white rounded-2xl font-bold hover:bg-secondary transition-all shadow-lg shadow-primary/20">Guardar Slider</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
const modal = document.getElementById('slider-modal');
const container = document.getElementById('modal-container');

function openSliderModal() {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => {
        container.classList.remove('scale-95', 'opacity-0');
        container.classList.add('scale-100', 'opacity-100');
    }, 10);
    document.body.style.overflow = 'hidden';
}

function closeSliderModal() {
    container.classList.remove('scale-100', 'opacity-100');
    container.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        resetSliderForm();
    }, 300);
    document.body.style.overflow = 'auto';
}

function resetSliderForm() {
    document.getElementById('slider-id').value = '';
    document.getElementById('slider-title').value = '';
    document.getElementById('slider-top-label').value = 'SYNCRO ANDINA INGENIERÍA';
    document.getElementById('slider-subtitle').value = '';
    document.getElementById('slider-btn-text').value = '';
    document.getElementById('slider-btn-link').value = '';
    document.getElementById('slider-active').checked = true;
    document.getElementById('image-preview').src = '';
    document.getElementById('image-preview').classList.add('hidden');
    document.getElementById('upload-placeholder').classList.remove('hidden');
    document.getElementById('modal-title').innerText = 'Nuevo Slider';
}

function editSlider(slider) {
    resetSliderForm();
    document.getElementById('slider-id').value = slider.id;
    document.getElementById('slider-title').value = slider.title;
    document.getElementById('slider-top-label').value = slider.top_label;
    document.getElementById('slider-subtitle').value = slider.subtitle;
    document.getElementById('slider-btn-text').value = slider.button_text;
    document.getElementById('slider-btn-link').value = slider.button_link;
    document.getElementById('slider-active').checked = slider.is_active == 1;
    
    if(slider.image_path) {
        const preview = document.getElementById('image-preview');
        let basePath = '<?= asset('') ?>';
        if (basePath.endsWith('/') && slider.image_path.startsWith('/')) {
            preview.src = basePath + slider.image_path.substring(1);
        } else {
            preview.src = basePath + slider.image_path;
        }
        preview.classList.remove('hidden');
        document.getElementById('upload-placeholder').classList.add('hidden');
    }
    
    document.getElementById('modal-title').innerText = 'Editar Slider';
    openSliderModal();
}

function previewSliderImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('image-preview');
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            document.getElementById('upload-placeholder').classList.add('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function toggleSliderStatus(id, status) {
    fetch('<?= url('admin/sliders/toggle') ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: id, status: status ? 1 : 0 })
    })
    .then(response => response.json())
    .then(data => {
        if(!data.success) alert('Error al cambiar el estado.');
    })
    .catch(error => console.error('Error:', error));
}

document.addEventListener('DOMContentLoaded', function () {
    var el = document.getElementById('sortable-sliders');
    Sortable.create(el, {
        handle: '.drag-handle',
        animation: 150,
        ghostClass: 'bg-blue-50',
        onEnd: function () {
            var items = el.querySelectorAll('tr');
            var orderIds = [];
            items.forEach(function(item) {
                var id = item.getAttribute('data-id');
                if(id) orderIds.push(id);
            });

            fetch('<?= url('admin/sliders/reorder') ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ order: orderIds })
            })
            .then(response => response.json())
            .then(data => {
                if(!data.success) alert('Error al actualizar el orden.');
            })
            .catch(error => console.error('Error:', error));
        }
    });
});
</script>
