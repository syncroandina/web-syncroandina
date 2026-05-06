<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Menú Principal</h2>
    </div>

    <?php if(isset($_GET['success'])): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            <strong class="font-bold">¡Éxito!</strong>
            <span class="block sm:inline">Los cambios se guardaron correctamente.</span>
        </div>
    <?php endif; ?>
    <?php if(isset($_GET['error'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-6 shadow-sm flex items-center gap-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <strong class="font-bold">Error:</strong>
                <span class="block sm:inline">
                    <?php 
                        switch($_GET['error']) {
                            case 'invalid_format': echo "El logo debe ser una imagen en formato .webp"; break;
                            case 'invalid_favicon_format': echo "El favicon debe ser .png, .ico o .webp"; break;
                            case 'upload_failed': echo "Hubo un problema al subir el archivo."; break;
                            default: echo "Ocurrió un error inesperado.";
                        }
                    ?>
                </span>
            </div>
        </div>
    <?php endif; ?>

    <!-- Enlaces del Menú -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold text-gray-800">Enlaces del Menú Principal</h3>
            <button type="button" onclick="openModal()" class="bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 transition-all flex items-center gap-2 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Añadir Nuevo Enlace
            </button>
        </div>
        
        <p class="text-sm text-gray-500 mb-6 flex items-center gap-2 bg-gray-50 p-3 rounded-lg border border-gray-100">
            <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Arrastra y suelta las filas para cambiar el orden. Los submenús aparecerán indentados.
        </p>

        <div class="overflow-hidden rounded-xl border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-20 text-center">Orden</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Título del Enlace</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Ruta / URL</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100" id="sortable-menu">
                    <?php foreach($menuLinks as $link): ?>
                    <tr data-id="<?= $link['id'] ?>" class="hover:bg-gray-50/80 transition-colors group">
                        <td class="px-6 py-4 whitespace-nowrap cursor-move text-gray-300 group-hover:text-secondary drag-handle text-center">
                            <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-800">
                            <?= htmlspecialchars($link['title']) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span class="bg-gray-100 px-2 py-1 rounded text-xs font-mono"><?= htmlspecialchars($link['url']) ?></span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button type="button" onclick="editMenuLink(<?= $link['id'] ?>, '<?= htmlspecialchars(addslashes($link['title'])) ?>', '<?= htmlspecialchars(addslashes($link['url'])) ?>', '')" class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors mr-2">Editar</button>
                            <form action="<?= url('admin/cabecera/menu/delete') ?>" method="POST" class="inline-block" onsubmit="return confirm('¿Seguro que deseas eliminar este enlace?');">
                                <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
                                <input type="hidden" name="id" value="<?= $link['id'] ?>">
                                <button type="submit" class="bg-red-50 text-red-600 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                        <?php if(!empty($link['children'])): ?>
                            <?php foreach($link['children'] as $child): ?>
                            <tr data-id="<?= $child['id'] ?>" class="hover:bg-gray-50 transition-colors bg-gray-50/30">
                                <td class="px-6 py-4 whitespace-nowrap cursor-move text-gray-200 group-hover:text-secondary drag-handle text-center">
                                    <svg class="w-5 h-5 mx-auto ml-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-300 ml-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    <?= htmlspecialchars($child['title']) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400 italic">
                                    <span class="bg-white px-2 py-1 rounded text-xs font-mono border border-gray-100"><?= htmlspecialchars($child['url']) ?></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button type="button" onclick="editMenuLink(<?= $child['id'] ?>, '<?= htmlspecialchars(addslashes($child['title'])) ?>', '<?= htmlspecialchars(addslashes($child['url'])) ?>', '<?= $link['id'] ?>')" class="text-blue-600 hover:bg-blue-50 px-2 py-1 rounded transition-colors mr-2">Editar</button>
                                    <form action="<?= url('admin/cabecera/menu/delete') ?>" method="POST" class="inline-block" onsubmit="return confirm('¿Seguro que deseas eliminar este enlace?');">
                                        <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
                                        <input type="hidden" name="id" value="<?= $child['id'] ?>">
                                        <button type="submit" class="text-red-400 hover:text-red-600 transition-colors">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal para Enlaces -->
<div id="menu-modal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 w-full max-w-lg overflow-hidden transform transition-all">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h4 id="modal-title" class="text-xl font-bold text-gray-800">Añadir Nuevo Enlace</h4>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <form id="menu-form" action="<?= url('admin/cabecera/menu') ?>" method="POST" class="p-6 space-y-4">
            <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
            <input type="hidden" name="id" id="form-id" value="">
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Título del Enlace</label>
                <input type="text" name="title" id="form-title" required class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-3 border transition-all" placeholder="Ej: Servicios">
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">URL / Ruta Destino</label>
                <input type="text" name="url" id="form-url" required class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-3 border transition-all" placeholder="Ej: /services o https://...">
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Enlace Padre (Opcional)</label>
                <select name="parent_id" id="form-parent" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-3 border bg-white transition-all">
                    <option value="">-- Ninguno (Enlace Principal) --</option>
                    <?php foreach($topLevelLinks as $topLink): ?>
                        <option value="<?= $topLink['id'] ?>"><?= htmlspecialchars($topLink['title']) ?></option>
                    <?php endforeach; ?>
                </select>
                <p class="text-[10px] text-gray-400 mt-1 uppercase tracking-wider font-bold">Selecciona un padre si este enlace es un submenú</p>
            </div>

            <div class="flex gap-3 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeModal()" class="flex-1 px-4 py-3 bg-gray-100 text-gray-600 rounded-xl font-bold hover:bg-gray-200 transition-colors">
                    Cancelar
                </button>
                <button type="submit" id="form-btn" class="flex-2 bg-secondary text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-600 transition-all shadow-lg shadow-blue-500/30">
                    Guardar Enlace
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
const modal = document.getElementById('menu-modal');

function openModal() {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden'; // Prevent scroll
}

function closeModal() {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
    resetForm();
}

function resetForm() {
    document.getElementById('form-id').value = '';
    document.getElementById('form-title').value = '';
    document.getElementById('form-url').value = '';
    document.getElementById('form-parent').value = '';
    
    document.getElementById('modal-title').innerText = 'Añadir Nuevo Enlace';
    document.getElementById('form-btn').innerText = 'Guardar Enlace';
}

function editMenuLink(id, title, url, parent_id) {
    resetForm();
    document.getElementById('form-id').value = id;
    document.getElementById('form-title').value = title;
    document.getElementById('form-url').value = url;
    document.getElementById('form-parent').value = parent_id;
    
    document.getElementById('modal-title').innerText = 'Editar Enlace';
    document.getElementById('form-btn').innerText = 'Actualizar Enlace';
    
    openModal();
}

document.addEventListener('DOMContentLoaded', function () {
    var el = document.getElementById('sortable-menu');
    var sortable = Sortable.create(el, {
        handle: '.drag-handle',
        animation: 150,
        ghostClass: 'bg-blue-50',
        onEnd: function (evt) {
            var items = el.querySelectorAll('tr');
            var orderIds = [];
            items.forEach(function(item) {
                var id = item.getAttribute('data-id');
                if(id) orderIds.push(id);
            });

            fetch('<?= url('admin/cabecera/menu/reorder') ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ order: orderIds })
            })
            .then(response => response.json())
            .then(data => {
                if(!data.success) alert('Hubo un error al actualizar el orden.');
            })
            .catch((error) => console.error('Error:', error));
        }
    });

    // Close modal on click outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) closeModal();
    });
});
</script>
