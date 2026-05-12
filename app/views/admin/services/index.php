<!-- Quill Rich Text Editor Assets -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<style>
  .ql-container.ql-snow {
    border-bottom-left-radius: 1rem;
    border-bottom-right-radius: 1rem;
    border-color: #e2e8f0 !important;
    font-family: inherit;
    min-height: 180px;
  }
  .ql-toolbar.ql-snow {
    border-top-left-radius: 1rem;
    border-top-right-radius: 1rem;
    border-color: #e2e8f0 !important;
    background-color: #f8fafc;
  }
  .ql-editor {
    font-size: 0.875rem;
    color: #1e293b;
  }
  .ql-editor.ql-blank::before {
    font-style: normal;
    color: #94a3b8;
  }
</style>

<div class="space-y-10">
    <!-- Header de la Página -->
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Gestión de Servicios</h1>
            <p class="text-gray-500 text-sm mt-1">Administra las páginas de servicios que se muestran en el sitio web.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <button onclick="openSettingsModal()" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-3 rounded-xl text-sm font-bold transition-colors flex items-center gap-2 border border-gray-200 shadow-sm">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Configurar Textos Inicio
            </button>
            <button onclick="openServiceModal()" class="bg-primary hover:bg-secondary text-white px-6 py-3 rounded-xl text-sm font-bold transition-colors flex items-center gap-2 shadow-lg shadow-primary/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nuevo Servicio
            </button>
        </div>
    </div>

    <?php if(isset($_GET['success'])): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative shadow-sm flex items-center gap-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="block sm:inline font-medium">¡Operación realizada con éxito!</span>
        </div>
    <?php endif; ?>

    <!-- Tabla de Servicios -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 text-gray-400 text-[11px] font-bold uppercase tracking-widest border-b border-gray-100">
                        <th class="px-8 py-5 text-center w-20">Orden</th>
                        <th class="px-8 py-5">Imagen</th>
                        <th class="px-8 py-5">Servicio</th>
                        <th class="px-8 py-5">Slug / URL</th>
                        <th class="px-8 py-5 text-center">Estado</th>
                        <th class="px-8 py-5 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody id="sortable-services" class="divide-y divide-gray-50">
                    <?php if(!empty($services)): ?>
                        <?php foreach($services as $service): ?>
                            <tr data-id="<?= $service['id'] ?>" class="hover:bg-blue-50/30 transition-colors group">
                                <td class="px-8 py-5 text-center cursor-move text-gray-300 group-hover:text-secondary drag-handle">
                                    <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="w-20 h-12 rounded-xl bg-gray-100 overflow-hidden shadow-sm border border-gray-200">
                                        <?php if(!empty($service['image'])): ?>
                                            <img src="<?= asset($service['image']) ?>" class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="block font-extrabold text-gray-900 group-hover:text-secondary transition-colors"><?= htmlspecialchars($service['title']) ?></span>
                                    <span class="block text-xs text-gray-500 mt-0.5 line-clamp-1"><?= htmlspecialchars(strip_tags($service['content'])) ?></span>
                                </td>
                                <td class="px-8 py-5">
                                    <code class="text-[10px] bg-gray-100 px-2 py-1 rounded text-gray-500 font-bold">/services/<?= htmlspecialchars($service['slug']) ?></code>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer" <?= $service['is_active'] ? 'checked' : '' ?> 
                                               onchange="toggleServiceStatus(<?= $service['id'] ?>, this.checked)">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-secondary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-secondary"></div>
                                    </label>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <div class="flex justify-end gap-2">
                                        <button onclick='editService(<?= $service['id'] ?>)' class="w-9 h-9 rounded-xl bg-gray-100 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-all shadow-sm" title="Editar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                        <form action="<?= url('admin/servicios/duplicate') ?>" method="POST" class="inline-block">
                                            <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
                                            <input type="hidden" name="id" value="<?= $service['id'] ?>">
                                            <button type="submit" class="w-9 h-9 rounded-xl bg-gray-100 text-teal-600 hover:bg-teal-600 hover:text-white flex items-center justify-center transition-all shadow-sm" title="Duplicar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg>
                                            </button>
                                        </form>
                                        <form action="<?= url('admin/servicios/delete') ?>" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este servicio?');" class="inline-block">
                                            <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
                                            <input type="hidden" name="id" value="<?= $service['id'] ?>">
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
                            <td colspan="5" class="px-8 py-20 text-center text-gray-400 italic bg-gray-50/30">No se encontraron servicios configurados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal para Servicios -->
<div id="service-modal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden z-50 items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 w-full max-w-4xl overflow-hidden transform transition-all scale-95 opacity-0 duration-300 flex flex-col max-h-[90vh]" id="modal-container">
        <!-- Header -->
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h4 id="modal-title" class="text-xl font-extrabold text-gray-900">Nuevo Servicio</h4>
            <button onclick="closeServiceModal()" class="text-gray-400 hover:text-gray-600 transition-colors p-2 hover:bg-white rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Tabs Navigation -->
        <div class="flex border-b border-gray-100 px-8 bg-white overflow-x-auto">
            <button onclick="switchTab('general')" id="tab-general" class="px-6 py-4 text-sm font-bold border-b-2 transition-all tab-btn active border-secondary text-secondary">General</button>
            <button onclick="switchTab('items')" id="tab-items" class="px-6 py-4 text-sm font-bold border-b-2 border-transparent text-gray-400 hover:text-gray-600 transition-all tab-btn">Ítems / Detalles</button>
            <button onclick="switchTab('gallery')" id="tab-gallery" class="px-6 py-4 text-sm font-bold border-b-2 border-transparent text-gray-400 hover:text-gray-600 transition-all tab-btn">Galería de Fotos</button>
            <button onclick="switchTab('seo')" id="tab-seo" class="px-6 py-4 text-sm font-bold border-b-2 border-transparent text-gray-400 hover:text-gray-600 transition-all tab-btn">Configuración SEO</button>
        </div>
        
        <form id="service-form" action="<?= url('admin/servicios') ?>" method="POST" enctype="multipart/form-data" class="flex-1 overflow-y-auto flex flex-col">
            <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
            <input type="hidden" name="id" id="service-id" value="">
            
            <!-- Tab Content: General -->
            <div id="content-general" class="p-8 space-y-6 tab-content">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Nombre del Servicio</label>
                            <input type="text" name="title" id="service-title" required onkeyup="generateSlug(this.value)" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50" placeholder="Ej: Networking y Fibra Óptica">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Slug (URL)</label>
                            <input type="text" name="slug" id="service-slug" required class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50" placeholder="ej-networking-fibra">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Texto Alternativo de Imagen (SEO ALT)</label>
                            <input type="text" name="image_alt" id="service-image-alt" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50" placeholder="Ej: Técnico instalando panel de distribución eléctrica">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Imagen Principal</label>
                        <div class="relative group">
                            <div class="w-full aspect-[16/9] rounded-2xl bg-gray-100 border-2 border-dashed border-gray-200 overflow-hidden flex flex-col items-center justify-center relative cursor-pointer hover:border-secondary transition-colors" onclick="document.getElementById('service-image').click()">
                                <img id="image-preview" src="" class="hidden w-full h-full object-cover">
                                <div id="upload-placeholder" class="text-center">
                                    <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase">Banner del Servicio</span>
                                </div>
                            </div>
                            <input type="file" name="image" id="service-image" class="hidden" accept="image/*" onchange="previewImage(this)">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Descripción General</label>
                    <div id="quill-editor" class="bg-white"></div>
                    <input type="hidden" name="content" id="service-content">
                </div>
            </div>

            <!-- Tab Content: Items -->
            <div id="content-items" class="p-8 space-y-6 tab-content hidden">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h5 class="text-lg font-bold text-gray-900">Detalles Específicos</h5>
                        <p class="text-xs text-gray-500">Añade características o puntos clave de este servicio.</p>
                    </div>
                    <button type="button" onclick="addDetailItem()" class="px-4 py-2 bg-gray-900 text-white text-xs font-bold rounded-lg hover:bg-black transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Añadir Ítem
                    </button>
                </div>
                
                <div id="items-container" class="space-y-4">
                    <!-- Items dinámicos aquí -->
                </div>
            </div>

            <!-- Tab Content: Gallery -->
            <div id="content-gallery" class="p-8 space-y-6 tab-content hidden">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h5 class="text-lg font-bold text-gray-900">Galería del Servicio</h5>
                        <p class="text-xs text-gray-500">Sube fotos de proyectos realizados con este servicio.</p>
                    </div>
                    <button type="button" onclick="document.getElementById('gallery-upload').click()" class="px-4 py-2 bg-secondary text-white text-xs font-bold rounded-lg hover:bg-primary transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Subir Fotos
                    </button>
                    <input type="file" id="gallery-upload" name="gallery_images[]" multiple class="hidden" accept="image/*" onchange="previewGallery(this)">
                </div>

                <div id="gallery-preview-container" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <!-- Previsualización de galería aquí -->
                </div>
            </div>
            
            <!-- Tab Content: SEO -->
            <div id="content-seo" class="p-8 space-y-6 tab-content hidden">
                <div class="border-b border-gray-100 pb-4">
                    <h5 class="text-lg font-bold text-gray-900">Encabezados SEO del Servicio</h5>
                    <p class="text-xs text-gray-500">Personaliza los títulos y el llamado a la acción (CTA) de este servicio para mejorar el SEO.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Título de Sección de Descripción (H2)</label>
                        <input type="text" name="heading_description" id="service-heading-description" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50" placeholder="Ej: Descripción">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Título de Sección de Detalles (H3)</label>
                        <input type="text" name="heading_details" id="service-heading-details" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50" placeholder="Ej: Detalles del servicio">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Título de Sección de Trabajos Realizados (H3)</label>
                        <input type="text" name="heading_gallery" id="service-heading-gallery" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50" placeholder="Ej: Trabajos Realizados">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Título del Bloque de Contacto / CTA (H3)</label>
                        <input type="text" name="heading_cta" id="service-heading-cta" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50" placeholder="Ej: ¿Interesado en este Servicio?">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Descripción del Bloque de Contacto / CTA</label>
                    <textarea name="cta_description" id="service-cta-description" rows="3" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50 resize-none" placeholder="Describe brevemente la invitación a cotizar..."></textarea>
                </div>
            </div>

            <!-- Footer -->
            <div class="p-8 border-t border-gray-50 flex items-center justify-between bg-gray-50/30">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" id="service-active" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-secondary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-secondary"></div>
                    <span class="ml-3 text-sm font-bold text-gray-500">Publicar Servicio</span>
                </label>
                
                <div class="flex gap-4">
                    <button type="button" onclick="closeServiceModal()" class="px-6 py-3 bg-white border border-gray-200 text-gray-600 rounded-xl font-bold hover:bg-gray-50 transition-all">Cancelar</button>
                    <button type="submit" class="px-10 py-3 bg-gray-900 text-white rounded-xl font-bold hover:bg-black transition-all shadow-xl shadow-gray-200">Guardar Cambios</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal para Configurar Textos Inicio -->
<div id="settings-modal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden z-50 items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 w-full max-w-3xl overflow-hidden transform transition-all scale-95 opacity-0 duration-300 flex flex-col max-h-[90vh]" id="settings-modal-container">
        <!-- Header -->
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h4 class="text-xl font-extrabold text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Configurar Textos y Ajustes de Servicios
            </h4>
            <button onclick="closeSettingsModal()" class="text-gray-400 hover:text-gray-600 transition-colors p-2 hover:bg-white rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form action="<?= url('admin/servicios/settings') ?>" method="POST" class="p-8 space-y-6 overflow-y-auto flex-1">
            <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
            
            <!-- SECCIÓN EN INICIO -->
            <div class="space-y-4">
                <h5 class="text-xs font-black text-secondary uppercase tracking-widest pl-2 border-l-4 border-secondary">Sección en Portada (Inicio)</h5>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2 pl-1">Etiqueta Superior</label>
                        <input type="text" name="services_label" value="<?= htmlspecialchars($settings['services_label'] ?? 'Lo que hacemos') ?>" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2 pl-1">Título de Sección</label>
                        <input type="text" name="services_title" value="<?= htmlspecialchars($settings['services_title'] ?? 'Nuestros Servicios Especializados') ?>" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50">
                    </div>
                </div>
                
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2 pl-1">Descripción de la Sección</label>
                    <textarea name="services_description" rows="2" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50 resize-none" placeholder="Breve descripción de la sección..."><?= htmlspecialchars($settings['services_description'] ?? '') ?></textarea>
                </div>
                
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2 pl-1">Límite de Servicios en Inicio</label>
                    <input type="number" name="services_limit" min="1" max="50" value="<?= htmlspecialchars($settings['services_limit'] ?? '6') ?>" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50" placeholder="Ej: 6">
                    <p class="text-[10px] text-gray-400 mt-1.5 pl-1 font-bold uppercase tracking-wider">Indica cuántos servicios activos se mostrarán como máximo en la portada principal.</p>
                </div>
            </div>

            <hr class="border-gray-100">

            <!-- PÁGINA DE SERVICIOS -->
            <div class="space-y-4">
                <h5 class="text-xs font-black text-secondary uppercase tracking-widest pl-2 border-l-4 border-secondary">Página Principal de Servicios (/servicios)</h5>
                
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2 pl-1">Título de la Página (H1)</label>
                    <input type="text" name="page_services_title" value="<?= htmlspecialchars($settings['page_services_title'] ?? 'Soluciones Estratégicas') ?>" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50">
                </div>
                
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2 pl-1">Descripción de la Página</label>
                    <textarea name="page_services_description" rows="3" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50 resize-none" placeholder="Descripción para la página de servicios..."><?= htmlspecialchars($settings['page_services_description'] ?? 'Catálogo completo de servicios corporativos enfocados en la innovación tecnológica, diseñados modularmente para adaptarse a la escala de tu negocio.') ?></textarea>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex justify-end gap-4 pt-4 border-t border-gray-50">
                <button type="button" onclick="closeSettingsModal()" class="px-6 py-3 bg-white border border-gray-200 text-gray-600 rounded-xl font-bold hover:bg-gray-50 transition-all">Cancelar</button>
                <button type="submit" class="px-10 py-3 bg-gray-900 text-white rounded-xl font-bold hover:bg-black transition-all shadow-xl">Actualizar Cambios</button>
            </div>
        </form>
    </div>
</div>

<script>
let quill;
const modal = document.getElementById('service-modal');
const container = document.getElementById('modal-container');
const itemsContainer = document.getElementById('items-container');
const galleryContainer = document.getElementById('gallery-preview-container');

const settingsModal = document.getElementById('settings-modal');
const settingsContainer = document.getElementById('settings-modal-container');

function openSettingsModal() {
    settingsModal.classList.remove('hidden');
    settingsModal.classList.add('flex');
    setTimeout(() => {
        settingsContainer.classList.remove('scale-95', 'opacity-0');
        settingsContainer.classList.add('scale-100', 'opacity-100');
    }, 10);
    document.body.style.overflow = 'hidden';
}

function closeSettingsModal() {
    settingsContainer.classList.remove('scale-100', 'opacity-100');
    settingsContainer.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        settingsModal.classList.add('hidden');
        settingsModal.classList.remove('flex');
    }, 300);
    document.body.style.overflow = 'auto';
}

function openServiceModal() {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => {
        container.classList.remove('scale-95', 'opacity-0');
        container.classList.add('scale-100', 'opacity-100');
    }, 10);
    document.body.style.overflow = 'hidden';
}

function closeServiceModal() {
    container.classList.remove('scale-100', 'opacity-100');
    container.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        resetServiceForm();
    }, 300);
    document.body.style.overflow = 'auto';
}

function resetServiceForm() {
    document.getElementById('service-form').reset();
    document.getElementById('service-id').value = '';
    document.getElementById('service-image-alt').value = '';
    document.getElementById('image-preview').src = '';
    document.getElementById('image-preview').classList.add('hidden');
    document.getElementById('upload-placeholder').classList.remove('hidden');
    document.getElementById('modal-title').innerText = 'Nuevo Servicio';
    itemsContainer.innerHTML = '';
    galleryContainer.innerHTML = '';
    if (quill) {
        quill.setContents([]);
    }
    switchTab('general');
}

function switchTab(tabName) {
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active', 'border-secondary', 'text-secondary');
        btn.classList.add('border-transparent', 'text-gray-400');
    });
    document.querySelectorAll('.tab-content').forEach(content => content.classList.add('hidden'));

    document.getElementById('tab-' + tabName).classList.add('active', 'border-secondary', 'text-secondary');
    document.getElementById('tab-' + tabName).classList.remove('border-transparent', 'text-gray-400');
    document.getElementById('content-' + tabName).classList.remove('hidden');
}

async function editService(id) {
    resetServiceForm();
    try {
        const response = await fetch(`<?= url('admin/servicios/get') ?>?id=${id}`);
        const service = await response.json();
        
        document.getElementById('service-id').value = service.id;
        document.getElementById('service-title').value = service.title;
        document.getElementById('service-slug').value = service.slug;
        document.getElementById('service-image-alt').value = service.image_alt || '';
        document.getElementById('service-content').value = service.content || '';
        if (quill) {
            quill.root.innerHTML = service.content || '';
        }
        document.getElementById('service-active').checked = service.is_active == 1;
        
        document.getElementById('service-heading-description').value = service.heading_description || '';
        document.getElementById('service-heading-details').value = service.heading_details || '';
        document.getElementById('service-heading-gallery').value = service.heading_gallery || '';
        document.getElementById('service-heading-cta').value = service.heading_cta || '';
        document.getElementById('service-cta-description').value = service.cta_description || '';
        
        if(service.image) {
            const preview = document.getElementById('image-preview');
            let basePath = '<?= asset('') ?>';
            if (basePath.endsWith('/') && service.image.startsWith('/')) {
                preview.src = basePath + service.image.substring(1);
            } else {
                preview.src = basePath + service.image;
            }
            preview.classList.remove('hidden');
            document.getElementById('upload-placeholder').classList.add('hidden');
        }

        // Cargar Items
        if(service.items) {
            service.items.forEach(item => addDetailItem(item.title, item.description));
        }

        // Cargar Galería
        if(service.gallery) {
            service.gallery.forEach(img => addGalleryItem(img.image_path, img.id, img.image_alt));
        }
        
        document.getElementById('modal-title').innerText = 'Editar Servicio';
        openServiceModal();
    } catch (error) {
        console.error('Error al cargar servicio:', error);
        alert('Error al cargar los datos del servicio.');
    }
}

function addDetailItem(title = '', desc = '') {
    const div = document.createElement('div');
    div.className = 'group bg-gray-50 p-4 rounded-2xl border border-gray-100 flex gap-4 items-start animate-fade-in';
    div.innerHTML = `
        <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="text" name="items_titles[]" value="${title}" placeholder="Título del detalle" class="w-full border-gray-200 rounded-xl p-3 text-xs font-bold">
            <input type="text" name="items_descriptions[]" value="${desc}" placeholder="Descripción corta" class="w-full border-gray-200 rounded-xl p-3 text-xs">
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600 p-2 hover:bg-red-50 rounded-lg transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
        </button>
    `;
    itemsContainer.appendChild(div);
}

function addGalleryItem(path, id, alt = '') {
    const div = document.createElement('div');
    div.className = 'relative group rounded-xl overflow-hidden shadow-sm border border-gray-200 flex flex-col bg-white';
    let basePath = '<?= asset('') ?>';
    let fullPath = (basePath.endsWith('/') && path.startsWith('/')) ? basePath + path.substring(1) : basePath + path;
    
    div.innerHTML = `
        <div class="relative h-32 overflow-hidden bg-gray-50">
            <img src="${fullPath}" class="w-full h-full object-cover">
            <button type="button" onclick="deleteGalleryImage(${id}, this)" class="absolute top-2 right-2 w-7 h-7 bg-red-600 text-white rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-lg">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-2 border-t border-gray-100 bg-gray-50/30">
            <input type="text" name="service_gallery_alts[${id}]" value="${alt || ''}" placeholder="Texto ALT para SEO" class="w-full px-2 py-1 text-[10px] border border-gray-200 rounded focus:ring-1 focus:ring-secondary focus:border-secondary bg-white placeholder:italic" title="Configura el texto ALT de esta imagen">
        </div>
    `;
    galleryContainer.appendChild(div);
}

function previewGallery(input) {
    if (input.files) {
        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative aspect-square rounded-xl overflow-hidden shadow-sm border border-secondary/30 ring-2 ring-secondary/20';
                div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover opacity-60">
                                 <div class="absolute inset-0 flex items-center justify-center text-[10px] font-bold text-secondary uppercase bg-white/40">Nuevo</div>`;
                galleryContainer.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    }
}

async function deleteGalleryImage(id, btn) {
    if(!confirm('¿Eliminar esta imagen permanentemente?')) return;
    const formData = new FormData();
    formData.append('id', id);
    formData.append('csrf_token', '<?= \Core\Security::generateCSRFToken() ?>');

    try {
        const response = await fetch('<?= url('admin/servicios/gallery/delete') ?>', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();
        if(result.success) {
            btn.parentElement.remove();
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

function previewImage(input) {
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

function generateSlug(text) {
    const slug = text.toLowerCase()
        .normalize('NFD').replace(/[\u0300-\u036f]/g, '') // Quitar acentos
        .replace(/[^\w ]+/g, '')
        .replace(/ +/g, '-');
    document.getElementById('service-slug').value = slug;
}

function toggleServiceStatus(id, status) {
    fetch('<?= url('admin/servicios/toggle') ?>', {
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
    // Inicializar Quill Editor
    quill = new Quill('#quill-editor', {
        theme: 'snow',
        placeholder: 'Describe el servicio...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'header': [1, 2, 3, 4, false] }],
                ['clean']
            ]
        }
    });

    // Sincronizar el contenido antes de enviar el formulario
    const form = document.getElementById('service-form');
    if (form) {
        form.addEventListener('submit', function() {
            document.getElementById('service-content').value = quill.root.innerHTML;
        });
    }

    var el = document.getElementById('sortable-services');
    if (el) {
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

                fetch('<?= url('admin/servicios/reorder') ?>', {
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
    }
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
