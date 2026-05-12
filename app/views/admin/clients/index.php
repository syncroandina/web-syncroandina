<div class="mb-8 flex flex-col sm:flex-row justify-between items-center gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-gray-900">Logos de Clientes</h1>
        <p class="text-gray-500 text-sm mt-1">Configura y gestiona los logotipos de las marcas corporativas que respaldan a Syncro Andina. Arrastra las filas para reordenar el carrusel.</p>
    </div>
    <button onclick="openClientModal()" class="bg-primary hover:bg-secondary text-white px-6 py-3 rounded-xl text-sm font-bold transition-colors flex items-center gap-2 shadow-lg shadow-primary/30">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Nuevo Logo de Cliente
    </button>
</div>

<!-- Card de Configuración del Comportamiento del Carrusel -->
<div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 mb-8">
    <div class="flex items-center gap-3 mb-4">
        <div class="w-10 h-10 rounded-full bg-secondary/10 flex items-center justify-center text-secondary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        </div>
        <div>
            <h3 class="text-base font-extrabold text-gray-900">Configuración del Carrusel de Marcas</h3>
            <p class="text-gray-500 text-xs mt-0.5">Controla la velocidad del movimiento continuo y la separación física entre los logotipos de tus clientes.</p>
        </div>
    </div>
    
    <form action="<?= url('admin/clientes/settings') ?>" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
        <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
        
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Velocidad de Movimiento</label>
            <?php $speedValue = $settings['clients_slider_speed'] ?? '40s'; ?>
            <select name="clients_slider_speed" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-3 text-sm bg-gray-50 font-medium">
                <option value="15s" <?= $speedValue === '15s' ? 'selected' : '' ?>>Muy Rápido (15 segundos)</option>
                <option value="25s" <?= $speedValue === '25s' ? 'selected' : '' ?>>Rápido (25 segundos)</option>
                <option value="40s" <?= $speedValue === '40s' ? 'selected' : '' ?>>Normal (40 segundos)</option>
                <option value="65s" <?= $speedValue === '65s' ? 'selected' : '' ?>>Lento (65 segundos)</option>
                <option value="90s" <?= $speedValue === '90s' ? 'selected' : '' ?>>Muy Lento (90 segundos)</option>
            </select>
        </div>
        
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Separación entre Logos</label>
            <?php $gapValue = $settings['clients_slider_gap'] ?? 'gap-6'; ?>
            <select name="clients_slider_gap" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-3 text-sm bg-gray-50 font-medium">
                <option value="gap-4" <?= $gapValue === 'gap-4' ? 'selected' : '' ?>>Muy Compacto (16px)</option>
                <option value="gap-6" <?= $gapValue === 'gap-6' ? 'selected' : '' ?>>Normal (24px)</option>
                <option value="gap-8" <?= $gapValue === 'gap-8' ? 'selected' : '' ?>>Espaciado (32px)</option>
                <option value="gap-12" <?= $gapValue === 'gap-12' ? 'selected' : '' ?>>Muy Espaciado (48px)</option>
            </select>
        </div>
        
        <div>
            <button type="submit" class="w-full bg-primary hover:bg-secondary text-white py-3.5 rounded-2xl text-sm font-bold transition-all shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98]">
                Guardar Ajustes de Carrusel
            </button>
        </div>
    </form>
</div>

<?php if(isset($_GET['success'])): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative mb-6 shadow-sm flex items-center gap-3 animate-fade-in">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span class="block sm:inline font-medium">
            <?php 
            if ($_GET['success'] === 'saved') echo '¡El logo de cliente ha sido registrado con éxito!';
            elseif ($_GET['success'] === 'updated') echo '¡El logo de cliente ha sido actualizado con éxito!';
            elseif ($_GET['success'] === 'deleted') echo '¡El logo de cliente ha sido eliminado permanentemente!';
            elseif ($_GET['success'] === 'settings_saved') echo '¡La configuración del carrusel de logotipos ha sido guardada con éxito!';
            else echo '¡Operación realizada con éxito!';
            ?>
        </span>
    </div>
<?php endif; ?>

<?php if(isset($_GET['error'])): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-6 shadow-sm flex items-center gap-3 animate-fade-in">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span class="block sm:inline font-medium">El archivo del logotipo es obligatorio para guardar un cliente nuevo.</span>
    </div>
<?php endif; ?>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 text-gray-400 text-[11px] font-bold uppercase tracking-widest border-b border-gray-100">
                    <th class="px-8 py-5 text-center w-20">Orden</th>
                    <th class="px-8 py-5">Logo / Marca</th>
                    <th class="px-8 py-5">Nombre de la Empresa</th>
                    <th class="px-8 py-5 text-center">Estado</th>
                    <th class="px-8 py-5 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody id="sortable-clients" class="divide-y divide-gray-50">
                <?php if(!empty($logos)): ?>
                    <?php foreach($logos as $logo): ?>
                        <tr data-id="<?= $logo['id'] ?>" class="hover:bg-blue-50/30 transition-colors group">
                            <td class="px-8 py-5 text-center cursor-move text-gray-300 group-hover:text-secondary drag-handle">
                                <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            </td>
                            <td class="px-8 py-5">
                                <div class="w-24 h-14 rounded-xl bg-gray-50 p-2 overflow-hidden shadow-sm border border-gray-100 flex items-center justify-center">
                                    <img src="<?= asset($logo['logo_path']) ?>" class="max-w-full max-h-full object-contain">
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="block font-extrabold text-gray-900 group-hover:text-secondary transition-colors"><?= htmlspecialchars($logo['name']) ?></span>
                                <span class="block text-xs text-gray-400 mt-0.5">ID: #<?= $logo['id'] ?></span>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold <?= $logo['is_active'] ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' ?>">
                                    <span class="w-1.5 h-1.5 rounded-full <?= $logo['is_active'] ? 'bg-green-500' : 'bg-gray-400' ?>"></span>
                                    <?= $logo['is_active'] ? 'Activo' : 'Inactivo' ?>
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <div class="flex justify-end gap-2">
                                    <button onclick="editClient(<?= htmlspecialchars(json_encode($logo)) ?>)" class="w-9 h-9 rounded-xl bg-gray-100 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-all shadow-sm" title="Editar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    <form action="<?= url('admin/clientes/delete') ?>" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este logotipo de cliente? Se borrará permanentemente de la base de datos.');" class="inline-block">
                                        <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
                                        <input type="hidden" name="id" value="<?= $logo['id'] ?>">
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
                        <td colspan="5" class="px-8 py-20 text-center text-gray-400 italic bg-gray-50/30">No se encontraron logotipos de clientes configurados en el sistema.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal para Clientes Logos -->
<div id="client-modal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden z-50 items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 w-full max-w-xl overflow-hidden transform transition-all scale-95 opacity-0 duration-300" id="modal-container">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h4 id="modal-title" class="text-xl font-extrabold text-gray-900">Nuevo Logo de Cliente</h4>
            <button onclick="closeClientModal()" class="text-gray-400 hover:text-gray-600 transition-colors p-2 hover:bg-white rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <form action="<?= url('admin/clientes/save') ?>" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
            <input type="hidden" name="id" id="client-id" value="">
            
            <div class="space-y-5">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Nombre de la Empresa <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="client-name" required class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm transition-all bg-gray-50 focus:bg-white" placeholder="Ej: Aceros Arequipa S.A.">
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Logotipo Corporativo</label>
                    <div class="relative group">
                        <div class="w-full h-44 rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 overflow-hidden flex flex-col items-center justify-center relative cursor-pointer hover:border-secondary hover:bg-white transition-all duration-300" onclick="document.getElementById('client-logo-file').click()">
                            <img id="logo-preview" src="" class="hidden w-full h-full object-contain p-4">
                            <div id="upload-placeholder" class="text-center p-4">
                                <div class="w-10 h-10 rounded-full bg-secondary/10 flex items-center justify-center mx-auto mb-2 text-secondary group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <span class="text-xs font-extrabold text-gray-700 block mb-0.5">Seleccionar Imagen</span>
                                <span class="text-[10px] font-bold text-gray-400 uppercase">Sugerido: PNG transparente o WebP</span>
                            </div>
                            <div class="absolute inset-0 bg-black/45 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center text-white text-xs font-bold gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span>Cambiar Imagen</span>
                            </div>
                        </div>
                        <input type="file" name="logo" id="client-logo-file" class="hidden" accept="image/*" onchange="previewClientLogo(this)">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Texto Alternativo (SEO ALT)</label>
                    <input type="text" name="image_alt" id="client-image-alt" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm transition-all bg-gray-50 focus:bg-white" placeholder="Ej: Logotipo oficial de Aceros Arequipa">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Estado del Logo</label>
                    <div class="h-[52px] flex items-center justify-between px-4 bg-gray-50 border border-gray-200 rounded-2xl">
                        <span class="text-xs font-bold text-gray-500">¿Mostrar en el carrusel principal?</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" id="client-active" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-secondary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-secondary"></div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 pt-6 border-t border-gray-100">
                <button type="button" onclick="closeClientModal()" class="flex-1 px-6 py-4 bg-gray-100 text-gray-600 rounded-2xl font-bold hover:bg-gray-200 transition-all">Cancelar</button>
                <button type="submit" class="flex-[2] px-6 py-4 bg-primary text-white rounded-2xl font-bold hover:bg-secondary transition-all shadow-lg shadow-primary/20">Guardar Logo</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
const modal = document.getElementById('client-modal');
const container = document.getElementById('modal-container');

function openClientModal() {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => {
        container.classList.remove('scale-95', 'opacity-0');
        container.classList.add('scale-100', 'opacity-100');
    }, 10);
    document.body.style.overflow = 'hidden';
}

function closeClientModal() {
    container.classList.remove('scale-100', 'opacity-100');
    container.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        resetClientForm();
    }, 300);
    document.body.style.overflow = 'auto';
}

function resetClientForm() {
    document.getElementById('client-id').value = '';
    document.getElementById('client-name').value = '';
    document.getElementById('client-active').checked = true;
    document.getElementById('client-image-alt').value = '';
    document.getElementById('logo-preview').src = '';
    document.getElementById('logo-preview').classList.add('hidden');
    document.getElementById('upload-placeholder').classList.remove('hidden');
    document.getElementById('modal-title').innerText = 'Nuevo Logo de Cliente';
    document.getElementById('client-logo-file').required = true;
}

function editClient(logo) {
    resetClientForm();
    document.getElementById('client-id').value = logo.id;
    document.getElementById('client-name').value = logo.name;
    document.getElementById('client-image-alt').value = logo.image_alt || '';
    document.getElementById('client-active').checked = logo.is_active == 1;
    document.getElementById('client-logo-file').required = false; // Al editar no es obligatorio re-subir
    
    if(logo.logo_path) {
        const preview = document.getElementById('logo-preview');
        let basePath = '<?= asset('') ?>';
        if (basePath.endsWith('/') && logo.logo_path.startsWith('/')) {
            preview.src = basePath + logo.logo_path.substring(1);
        } else {
            preview.src = basePath + logo.logo_path;
        }
        preview.classList.remove('hidden');
        document.getElementById('upload-placeholder').classList.add('hidden');
    }
    
    document.getElementById('modal-title').innerText = 'Editar Logo de Cliente';
    openClientModal();
}

function previewClientLogo(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('logo-preview');
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            document.getElementById('upload-placeholder').classList.add('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    var el = document.getElementById('sortable-clients');
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

            fetch('<?= url('admin/clientes/reorder') ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ ids: orderIds })
            })
            .then(response => response.json())
            .then(data => {
                if(!data.success) alert('Error al actualizar el orden de los logotipos.');
            })
            .catch(error => console.error('Error:', error));
        }
    });
});
</script>
