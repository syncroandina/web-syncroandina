<div class="mb-8 flex flex-col sm:flex-row justify-between items-center gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-gray-900">Scripts de Seguimiento</h1>
        <p class="text-gray-500 text-sm mt-1">Administra e inyecta códigos de seguimiento y conversión (Google Ads, Meta Pixel, TikTok Ads, etc.) en diferentes secciones del sitio.</p>
    </div>
    <button onclick="openScriptModal()" class="bg-primary hover:bg-secondary text-white px-6 py-3 rounded-xl text-sm font-bold transition-colors flex items-center gap-2 shadow-lg shadow-primary/30">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Nuevo Script
    </button>
</div>

<?php if(isset($_GET['success'])): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative mb-6 shadow-sm flex items-center gap-3">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span class="block sm:inline font-medium">
            <?php 
                if($_GET['success'] == 'script_saved') echo '¡Script guardado correctamente!';
                elseif($_GET['success'] == 'script_deleted') echo '¡Script eliminado correctamente!';
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
                    <th class="px-8 py-5">Nombre</th>
                    <th class="px-8 py-5">Ubicación (Placement)</th>
                    <th class="px-8 py-5">Ejecución (Páginas)</th>
                    <th class="px-8 py-5 text-center">Estado</th>
                    <th class="px-8 py-5 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php if(!empty($scripts)): ?>
                    <?php foreach($scripts as $script): ?>
                        <tr class="hover:bg-blue-50/30 transition-colors group">
                            <td class="px-8 py-5">
                                <span class="block font-extrabold text-gray-900 group-hover:text-secondary transition-colors"><?= htmlspecialchars($script['name']) ?></span>
                                <span class="block text-xs text-gray-400 mt-0.5 font-mono max-w-xs truncate"><?= htmlspecialchars(substr($script['code'], 0, 80)) . (strlen($script['code']) > 80 ? '...' : '') ?></span>
                            </td>
                            <td class="px-8 py-5">
                                <?php if($script['placement'] === 'head'): ?>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                                        &lt;/head&gt;
                                    </span>
                                <?php elseif($script['placement'] === 'body_start'): ?>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-purple-50 text-purple-700">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                        &lt;body&gt; Inicio
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 13l-7 7-7-7m14-6l-7 7-7-7"></path></svg>
                                        &lt;/body&gt; Fin
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-8 py-5">
                                <?php if($script['page_restriction'] === 'all'): ?>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-green-50 text-green-700">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                                        Todo el sitio
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200/50 shadow-sm animate-pulse">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Página de Agradecimiento
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" <?= $script['is_active'] ? 'checked' : '' ?> 
                                           onchange="toggleScriptStatus(<?= $script['id'] ?>, this.checked)">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-secondary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-secondary"></div>
                                </label>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <div class="flex justify-end gap-2">
                                    <button onclick='editScript(<?= json_encode($script, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP) ?>)' class="w-9 h-9 rounded-xl bg-gray-100 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-all shadow-sm" title="Editar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    <form action="<?= url('admin/scripts/delete') ?>" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este script? Se borrará permanentemente de la base de datos.');" class="inline-block">
                                        <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
                                        <input type="hidden" name="id" value="<?= $script['id'] ?>">
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
                        <td colspan="5" class="px-8 py-20 text-center text-gray-400 italic bg-gray-50/30">No se encontraron scripts configurados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal para Scripts -->
<div id="script-modal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden z-50 items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 w-full max-w-3xl overflow-hidden transform transition-all scale-95 opacity-0 duration-300" id="modal-container">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h4 id="modal-title" class="text-xl font-extrabold text-gray-900">Nuevo Script de Seguimiento</h4>
            <button onclick="closeScriptModal()" class="text-gray-400 hover:text-gray-600 transition-colors p-2 hover:bg-white rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <form action="<?= url('admin/scripts/save') ?>" method="POST" class="p-8 space-y-6">
            <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
            <input type="hidden" name="id" id="script-id" value="">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Columna Izquierda: Configuración General -->
                <div class="space-y-5">
                    <div class="border-b border-gray-100 pb-3">
                        <span class="text-xs font-extrabold text-secondary uppercase tracking-widest">1. Configuración Básica</span>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Nombre del Script</label>
                        <input type="text" name="name" id="script-name" required class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm transition-all bg-gray-50 focus:bg-white" placeholder="Ej: Meta Pixel Global">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Ubicación en la página (Placement)</label>
                        <select name="placement" id="script-placement" required class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm transition-all bg-gray-50 focus:bg-white">
                            <option value="head">Fin de la cabecera (&lt;/head&gt;)</option>
                            <option value="body_start">Inicio del cuerpo (&lt;body&gt;)</option>
                            <option value="body_end">Fin del cuerpo (&lt;/body&gt;)</option>
                        </select>
                        <p class="text-gray-400 text-[10px] mt-1 pl-1">Selecciona dónde se insertará este script. La mayoría de píxeles van en el head.</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Restricción de Ejecución (Páginas)</label>
                        <select name="page_restriction" id="script-restriction" required class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm transition-all bg-gray-50 focus:bg-white">
                            <option value="all">Todo el sitio web (Global)</option>
                            <option value="thanks_only">Solo en la página de Agradecimiento (/gracias)</option>
                        </select>
                        <p class="text-gray-400 text-[10px] mt-1 pl-1">"Solo página de Agradecimiento" es ideal para códigos de conversión de compras o registro completado.</p>
                    </div>
                </div>
                
                <!-- Columna Derecha: Código del Script -->
                <div class="space-y-5 flex flex-col justify-between">
                    <div class="w-full">
                        <div class="border-b border-gray-100 pb-3 mb-5">
                            <span class="text-xs font-extrabold text-secondary uppercase tracking-widest">2. Código HTML / JS</span>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Código del Script</label>
                            <textarea name="code" id="script-code" required rows="7" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-xs font-mono transition-all bg-gray-900 text-gray-100 focus:bg-black resize-none leading-relaxed" placeholder="<!-- Pega aquí el código proporcionado por la plataforma publicitaria -->&#10;<script>&#10;  fbq('init', '123456789');&#10;  fbq('track', 'PageView');&#10;</script>"></textarea>
                        </div>
                    </div>

                    <div class="pt-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Estado</label>
                        <div class="h-[52px] flex items-center justify-between px-4 bg-gray-50 border border-gray-200 rounded-2xl">
                            <span class="text-xs font-bold text-gray-500">¿Activar inyección de script?</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" id="script-active" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-secondary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-secondary"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 pt-6 border-t border-gray-100">
                <button type="button" onclick="closeScriptModal()" class="flex-1 px-6 py-4 bg-gray-100 text-gray-600 rounded-2xl font-bold hover:bg-gray-200 transition-all">Cancelar</button>
                <button type="submit" class="flex-[2] px-6 py-4 bg-primary text-white rounded-2xl font-bold hover:bg-secondary transition-all shadow-lg shadow-primary/20">Guardar Script</button>
            </div>
        </form>
    </div>
</div>

<script>
const modal = document.getElementById('script-modal');
const container = document.getElementById('modal-container');

function openScriptModal() {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => {
        container.classList.remove('scale-95', 'opacity-0');
        container.classList.add('scale-100', 'opacity-100');
    }, 10);
    document.body.style.overflow = 'hidden';
}

function closeScriptModal() {
    container.classList.remove('scale-100', 'opacity-100');
    container.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        resetScriptForm();
    }, 300);
    document.body.style.overflow = 'auto';
}

function resetScriptForm() {
    document.getElementById('script-id').value = '';
    document.getElementById('script-name').value = '';
    document.getElementById('script-placement').value = 'head';
    document.getElementById('script-restriction').value = 'all';
    document.getElementById('script-code').value = '';
    document.getElementById('script-active').checked = true;
    document.getElementById('modal-title').innerText = 'Nuevo Script de Seguimiento';
}

function editScript(script) {
    resetScriptForm();
    document.getElementById('script-id').value = script.id;
    document.getElementById('script-name').value = script.name;
    document.getElementById('script-placement').value = script.placement;
    document.getElementById('script-restriction').value = script.page_restriction;
    document.getElementById('script-code').value = script.code;
    document.getElementById('script-active').checked = script.is_active == 1;
    
    document.getElementById('modal-title').innerText = 'Editar Script de Seguimiento';
    openScriptModal();
}

function toggleScriptStatus(id, status) {
    fetch('<?= url('admin/scripts/toggle') ?>', {
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
</script>
