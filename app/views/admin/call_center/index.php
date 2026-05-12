<div class="mb-8 flex flex-col sm:flex-row justify-between items-center gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-gray-900">Call Center Flotante</h1>
        <p class="text-gray-500 text-sm mt-1">Administra los números de WhatsApp y Líneas de Atención que aparecen en la burbuja flotante del sitio.</p>
    </div>
    <button onclick="openContactModal()" class="bg-primary hover:bg-secondary text-white px-6 py-3 rounded-xl text-sm font-bold transition-colors flex items-center gap-2 shadow-lg shadow-primary/30">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Nuevo Medio de Contacto
    </button>
</div>

<!-- Configuración del Encabezado y Pie de la Burbuja -->
<div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 mb-8">
    <div class="flex items-center gap-3 mb-6 border-b border-gray-50 pb-4">
        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
        </div>
        <div>
            <h3 class="text-base font-extrabold text-gray-900">Textos y Visibilidad Global</h3>
            <p class="text-gray-500 text-xs">Configura el diseño base de la ventana emergente del Call Center.</p>
        </div>
    </div>
    
    <form action="<?= url('admin/call-center/settings') ?>" method="POST" class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
        <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
        
        <div class="md:col-span-3">
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Título Principal (Cabecera)</label>
            <input type="text" name="call_center_main_title" value="<?= htmlspecialchars($settings['call_center_main_title'] ?? 'Central de Atención') ?>" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-3.5 text-sm bg-gray-50">
        </div>

        <div class="md:col-span-3">
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Subtítulo (Cabecera)</label>
            <input type="text" name="call_center_main_subtitle" value="<?= htmlspecialchars($settings['call_center_main_subtitle'] ?? 'ESTAMOS LISTOS PARA AYUDARTE') ?>" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-3.5 text-sm bg-gray-50">
        </div>
        
        <div class="md:col-span-3">
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Pie de Página (Copyright/Info)</label>
            <input type="text" name="call_center_footer_text" value="<?= htmlspecialchars($settings['call_center_footer_text'] ?? '© Syncro Andina - Soluciones Industriales') ?>" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-3.5 text-sm bg-gray-50">
        </div>

        <div class="md:col-span-3 flex items-center gap-4 h-[52px]">
            <div class="flex-1 bg-gray-50 border border-gray-200 rounded-2xl px-4 flex items-center justify-between h-full">
                <span class="text-xs font-bold text-gray-600">Visibilidad Web</span>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="call_center_is_visible" value="1" class="sr-only peer" <?= ($settings['call_center_is_visible'] ?? '1') == '1' ? 'checked' : '' ?>>
                    <div class="w-10 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600"></div>
                </label>
            </div>
            <button type="submit" class="bg-gray-900 hover:bg-black text-white px-6 h-full rounded-2xl text-sm font-bold transition-all shadow-md shadow-gray-900/10">
                Actualizar
            </button>
        </div>
    </form>
</div>

<?php if(isset($_GET['success'])): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative mb-6 shadow-sm flex items-center gap-3 animate-fade-in">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span class="block sm:inline font-medium">
            <?php 
            if ($_GET['success'] === 'saved') echo '¡El contacto ha sido registrado correctamente!';
            elseif ($_GET['success'] === 'updated') echo '¡El contacto ha sido actualizado correctamente!';
            elseif ($_GET['success'] === 'deleted') echo '¡Contacto eliminado permanentemente!';
            elseif ($_GET['success'] === 'settings_saved') echo '¡Configuración global de la burbuja actualizada!';
            else echo '¡Operación realizada con éxito!';
            ?>
        </span>
    </div>
<?php endif; ?>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 text-gray-400 text-[11px] font-bold uppercase tracking-widest border-b border-gray-100">
                    <th class="px-8 py-5 text-center w-20">Orden</th>
                    <th class="px-8 py-5 w-32">Canal</th>
                    <th class="px-8 py-5">Título / Etiqueta</th>
                    <th class="px-8 py-5">Número / Acción</th>
                    <th class="px-8 py-5 text-center">Estado</th>
                    <th class="px-8 py-5 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody id="sortable-contacts" class="divide-y divide-gray-50">
                <?php if(!empty($contacts)): ?>
                    <?php foreach($contacts as $contact): ?>
                        <tr data-id="<?= $contact['id'] ?>" class="hover:bg-blue-50/30 transition-colors group">
                            <td class="px-8 py-5 text-center cursor-move text-gray-300 group-hover:text-primary drag-handle">
                                <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            </td>
                            <td class="px-8 py-5">
                                <?php if($contact['type'] === 'whatsapp'): ?>
                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-green-50 text-green-600 rounded-xl text-xs font-bold border border-green-100">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"></path></svg>
                                        WhatsApp
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 text-blue-600 rounded-xl text-xs font-bold border border-blue-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        Llamada
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-8 py-5">
                                <span class="block font-extrabold text-gray-900"><?= htmlspecialchars($contact['title']) ?></span>
                                <?php if(!empty($contact['subtitle'])): ?>
                                    <span class="block text-xs text-gray-400 mt-0.5"><?= htmlspecialchars($contact['subtitle']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-8 py-5 font-mono text-sm text-gray-600 font-bold">
                                <?= htmlspecialchars($contact['phone_number']) ?>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold <?= $contact['is_active'] ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' ?>">
                                    <span class="w-1.5 h-1.5 rounded-full <?= $contact['is_active'] ? 'bg-green-500' : 'bg-gray-400' ?>"></span>
                                    <?= $contact['is_active'] ? 'Visible' : 'Oculto' ?>
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <div class="flex justify-end gap-2">
                                    <button onclick='editContact(<?= json_encode($contact, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)' class="w-9 h-9 rounded-xl bg-gray-100 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-all shadow-sm" title="Editar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    <form action="<?= url('admin/call-center/delete') ?>" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar esta opción de contacto?');" class="inline-block">
                                        <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
                                        <input type="hidden" name="id" value="<?= $contact['id'] ?>">
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
                        <td colspan="6" class="px-8 py-20 text-center text-gray-400 italic bg-gray-50/30">No se han añadido contactos flotantes aún. Haz clic en "Nuevo Medio de Contacto" para empezar.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal de Contacto -->
<div id="contact-modal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden z-50 items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 w-full max-w-md overflow-hidden transform transition-all scale-95 opacity-0 duration-300" id="modal-container">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h4 id="modal-title" class="text-xl font-extrabold text-gray-900">Nuevo Medio de Contacto</h4>
            <button onclick="closeContactModal()" class="text-gray-400 hover:text-gray-600 transition-colors p-2 hover:bg-white rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <form action="<?= url('admin/call-center/save') ?>" method="POST" class="p-8 space-y-6">
            <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
            <input type="hidden" name="id" id="contact-id" value="">
            
            <div class="space-y-5">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Canal de Contacto</label>
                    <select name="type" id="contact-type" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary p-3.5 text-sm bg-gray-50 font-bold text-gray-800">
                        <option value="whatsapp">💬 WhatsApp</option>
                        <option value="phone">📞 Llamada Telefónica</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Título visible <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="contact-title" required class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary p-3.5 text-sm transition-all bg-gray-50 focus:bg-white" placeholder="Ej: Consultar por WhatsApp">
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Subtítulo o Etiqueta (Opcional)</label>
                    <input type="text" name="subtitle" id="contact-subtitle" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary p-3.5 text-sm transition-all bg-gray-50 focus:bg-white" placeholder="Ej: ÁREA COMERCIAL">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Número / Enlace <span class="text-red-500">*</span></label>
                    <input type="text" name="phone_number" id="contact-phone" required class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary p-3.5 text-sm font-mono transition-all bg-gray-50 focus:bg-white" placeholder="Ej: +51987654321">
                    <p class="text-[10px] text-gray-400 mt-1 pl-1">Ingresa el número con código de país y sin espacios para WhatsApp.</p>
                </div>

                <div>
                    <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl">
                        <span class="text-xs font-bold text-gray-500">¿Habilitar en web?</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" id="contact-active" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500"></div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 pt-6 border-t border-gray-100">
                <button type="button" onclick="closeContactModal()" class="flex-1 px-6 py-3.5 bg-gray-100 text-gray-600 rounded-2xl font-bold hover:bg-gray-200 transition-all">Cancelar</button>
                <button type="submit" class="flex-[2] px-6 py-3.5 bg-primary text-white rounded-2xl font-bold hover:bg-secondary transition-all shadow-lg shadow-primary/20">Guardar Medio</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
const modal = document.getElementById('contact-modal');
const container = document.getElementById('modal-container');

function openContactModal() {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => {
        container.classList.remove('scale-95', 'opacity-0');
        container.classList.add('scale-100', 'opacity-100');
    }, 10);
    document.body.style.overflow = 'hidden';
}

function closeContactModal() {
    container.classList.remove('scale-100', 'opacity-100');
    container.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        resetContactForm();
    }, 300);
    document.body.style.overflow = 'auto';
}

function resetContactForm() {
    document.getElementById('contact-id').value = '';
    document.getElementById('contact-type').value = 'whatsapp';
    document.getElementById('contact-title').value = '';
    document.getElementById('contact-subtitle').value = '';
    document.getElementById('contact-phone').value = '';
    document.getElementById('contact-active').checked = true;
    document.getElementById('modal-title').innerText = 'Nuevo Medio de Contacto';
}

function editContact(item) {
    resetContactForm();
    document.getElementById('contact-id').value = item.id;
    document.getElementById('contact-type').value = item.type;
    document.getElementById('contact-title').value = item.title;
    document.getElementById('contact-subtitle').value = item.subtitle || '';
    document.getElementById('contact-phone').value = item.phone_number;
    document.getElementById('contact-active').checked = item.is_active == 1;
    
    document.getElementById('modal-title').innerText = 'Editar Medio de Contacto';
    openContactModal();
}

document.addEventListener('DOMContentLoaded', function () {
    var el = document.getElementById('sortable-contacts');
    if(el) {
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

                fetch('<?= url('admin/call-center/reorder') ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ ids: orderIds })
                })
                .then(response => response.json())
                .then(data => {
                    if(!data.success) alert('Error al actualizar el orden.');
                })
                .catch(error => console.error('Error:', error));
            }
        });
    }
});
</script>
