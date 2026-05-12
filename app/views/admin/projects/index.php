<div class="mb-8 flex flex-col sm:flex-row justify-between items-center gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-gray-900">Proyectos</h1>
        <p class="text-gray-500 text-sm mt-1">Gestiona los casos de éxito, asigna imágenes, maneja sus galerías y publícalos en el portal.</p>
    </div>
    <div class="flex items-center gap-3">
        <button onclick="openSettingsModal()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl text-sm font-bold transition-colors flex items-center gap-2 border border-gray-200 shadow-sm">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            Configurar Textos
        </button>
        <button onclick="openProjectModal()" class="bg-primary hover:bg-secondary text-white px-6 py-3 rounded-xl text-sm font-bold transition-colors flex items-center gap-2 shadow-lg shadow-primary/30">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Crear Proyecto
        </button>
    </div>
</div>

<?php if(isset($_GET['success'])): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-2xl relative mb-6">
        <strong class="font-bold">¡Éxito!</strong>
        <span class="block sm:inline">
            <?php
            if ($_GET['success'] === 'settings_saved') {
                echo 'Los textos de las secciones se han guardado correctamente.';
            } elseif ($_GET['success'] === 'project_duplicated') {
                echo 'El proyecto ha sido duplicado correctamente.';
            } elseif ($_GET['success'] === 'project_deleted') {
                echo 'El proyecto ha sido eliminado correctamente.';
            } else {
                echo 'El proyecto ha sido guardado correctamente.';
            }
            ?>
        </span>
    </div>
<?php endif; ?>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
        <div class="relative w-full max-w-md">
            <input type="text" id="search-projects" oninput="filterProjects()" placeholder="Buscar proyecto por título o cliente..." class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-sm font-medium transition-shadow">
            <svg class="w-5 h-5 text-gray-400 absolute left-4 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white text-gray-400 text-[11px] font-bold uppercase tracking-widest border-b border-gray-100">
                    <th class="px-8 py-5">Proyecto</th>
                    <th class="px-8 py-5">Cliente</th>
                    <th class="px-8 py-5">Estado</th>
                    <th class="px-8 py-5">Fecha</th>
                    <th class="px-8 py-5 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-sm" id="projects-table-body">
                <?php if(!empty($projects)): ?>
                    <?php foreach($projects as $project): ?>
                    <tr class="hover:bg-blue-50/30 transition-colors group project-row" data-title="<?= htmlspecialchars(strtolower($project['title'])) ?>" data-client="<?= htmlspecialchars(strtolower($project['client'] ?? '')) ?>">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-gray-200 overflow-hidden shadow-sm flex-shrink-0">
                                    <?php if(!empty($project['main_image'])): ?>
                                        <img src="<?= asset($project['main_image']) ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <span class="block font-extrabold text-gray-900 group-hover:text-secondary transition-colors"><?= htmlspecialchars($project['title']) ?></span>
                                    <span class="block text-xs text-gray-400 mt-0.5">Slug: <?= htmlspecialchars($project['slug']) ?></span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5 font-medium text-gray-600"><?= htmlspecialchars($project['client'] ?? 'N/A') ?></td>
                        <td class="px-8 py-5">
                            <?php if($project['is_active']): ?>
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold border border-green-200">Publicado</span>
                            <?php else: ?>
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-xs font-bold border border-yellow-200">Borrador</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-8 py-5 font-medium text-gray-500">
                            <?= $project['completion_date'] ? date('d M, Y', strtotime($project['completion_date'])) : 'Pendiente' ?>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex justify-end gap-2">
                                <button onclick="editProject(<?= htmlspecialchars(json_encode($project)) ?>)" class="w-8 h-8 rounded-lg bg-gray-100 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-colors shadow-sm" title="Editar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <form action="<?= url('admin/proyectos/duplicate') ?>" method="POST" class="inline-block" onsubmit="return confirm('¿Seguro que deseas duplicar este proyecto? Se creará una copia con su propia imagen independiente.');">
                                    <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
                                    <input type="hidden" name="id" value="<?= $project['id'] ?>">
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-gray-100 text-teal-600 hover:bg-teal-600 hover:text-white flex items-center justify-center transition-colors shadow-sm" title="Duplicar/Clonar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg>
                                    </button>
                                </form>
                                <form action="<?= url('admin/proyectos/delete') ?>" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este proyecto? Se borrará permanentemente la imagen asociada.');" class="inline-block">
                                    <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
                                    <input type="hidden" name="id" value="<?= $project['id'] ?>">
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-gray-100 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center transition-colors shadow-sm" title="Eliminar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="px-8 py-10 text-center text-gray-400 italic">No se encontraron proyectos activos.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal de Proyecto -->
<div id="project-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 max-w-2xl w-full mx-4 overflow-hidden transform scale-95 transition-all duration-300" id="project-modal-container">
        <div class="px-8 py-6 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-800" id="modal-title">Crear Nuevo Proyecto</h3>
            <button onclick="closeProjectModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Pestañas del Modal -->
        <div class="px-8 border-b border-gray-100 flex gap-6 bg-gray-50/50">
            <button type="button" onclick="switchProjectTab('general')" id="tab-btn-general" class="px-4 py-3 text-xs font-extrabold uppercase tracking-widest border-b-2 border-secondary text-secondary transition-all project-tab-btn">General</button>
            <button type="button" onclick="switchProjectTab('custom')" id="tab-btn-custom" class="px-4 py-3 text-xs font-extrabold uppercase tracking-widest border-b-2 border-transparent text-gray-400 hover:text-gray-600 transition-all project-tab-btn">Reto & Solución</button>
            <button type="button" onclick="switchProjectTab('gallery')" id="tab-btn-gallery" class="px-4 py-3 text-xs font-extrabold uppercase tracking-widest border-b-2 border-transparent text-gray-400 hover:text-gray-600 transition-all project-tab-btn">Galería de Fotos</button>
        </div>
        
        <form action="<?= url('admin/proyectos') ?>" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
            <input type="hidden" name="id" id="project-id">
            
            <!-- Contenido Pestaña: General -->
            <div id="content-general" class="project-tab-content space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">Título del Proyecto</label>
                        <input type="text" name="title" id="project-title" required oninput="generateProjectSlug()" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-sm font-medium transition-shadow">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">Slug (URL amigable)</label>
                        <input type="text" name="slug" id="project-slug" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-sm font-medium transition-shadow">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">Cliente</label>
                        <input type="text" name="client" id="project-client" placeholder="Ej. Global Corp" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-sm font-medium transition-shadow">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">Fecha de Finalización</label>
                        <input type="date" name="completion_date" id="project-completion-date" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-sm font-medium transition-shadow">
                    </div>
                </div>
                
                <div>
                    <label class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">Imagen Principal</label>
                    <div class="flex items-center gap-6">
                        <div class="w-24 h-24 rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 flex items-center justify-center overflow-hidden flex-shrink-0" id="project-image-preview-container">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="project-image-placeholder"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <img id="project-image-preview" class="w-full h-full object-cover hidden">
                        </div>
                        <div class="flex-1">
                            <input type="file" name="main_image" id="project-image-input" onchange="previewProjectImage(event)" class="hidden" accept="image/*">
                            <button type="button" onclick="document.getElementById('project-image-input').click()" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-xl transition-colors flex items-center gap-2 border border-gray-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                Seleccionar Imagen
                            </button>
                            <p class="text-xs text-gray-400 mt-2">Recomendado: Formato .webp de alta resolución (1200x800px).</p>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">Texto Alternativo de la Imagen (SEO ALT)</label>
                    <input type="text" name="image_alt" id="project-image-alt" placeholder="Ej: Instalación eléctrica corporativa de alta tensión" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-sm font-medium transition-shadow">
                </div>
                
                <div>
                    <label class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">Descripción / Contenido del Proyecto</label>
                    <textarea name="description" id="project-description" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-sm font-medium transition-shadow resize-none" placeholder="Escribe los detalles o alcance del proyecto..."></textarea>
                </div>
            </div>

            <!-- Contenido Pestaña: Campos Personalizados (Reto y Solución) -->
            <div id="content-custom" class="project-tab-content hidden space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">Título del Reto</label>
                        <input type="text" name="challenge_title" id="project-challenge-title" value="El Reto" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-sm font-medium transition-shadow">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">Título de la Solución</label>
                        <input type="text" name="solution_title" id="project-solution-title" value="La Solución" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-sm font-medium transition-shadow">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">Descripción del Reto</label>
                    <textarea name="challenge_desc" id="project-challenge-desc" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-sm font-medium transition-shadow resize-none" placeholder="Describe el reto que presentaba el proyecto..."></textarea>
                </div>
                <div>
                    <label class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">Descripción de la Solución</label>
                    <textarea name="solution_desc" id="project-solution-desc" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-sm font-medium transition-shadow resize-none" placeholder="Describe la solución o metodología aplicada..."></textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">Etiqueta de Impacto</label>
                        <input type="text" name="impact_label" id="project-impact-label" value="Impacto Logrado" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-sm font-medium transition-shadow">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">Valor de Impacto</label>
                        <input type="text" name="impact_value" id="project-impact-value" value="100% Optimizado" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-sm font-medium transition-shadow">
                    </div>
                </div>
            </div>

            <!-- Contenido Pestaña: Galería de Fotos -->
            <div id="content-gallery" class="project-tab-content hidden space-y-6">
                <div class="flex justify-between items-center bg-gray-50 p-5 rounded-2xl border border-gray-100">
                    <div>
                        <h4 class="text-sm font-extrabold text-gray-800">Galería de Fotos del Proyecto</h4>
                        <p class="text-xs text-gray-400 mt-1">Sube múltiples imágenes asociadas a este caso de éxito.</p>
                    </div>
                    <div>
                        <button type="button" onclick="document.getElementById('project-gallery-input').click()" class="px-4 py-2.5 bg-secondary text-white text-xs font-black uppercase tracking-wider rounded-xl hover:bg-primary transition-all flex items-center gap-2 shadow-sm shadow-secondary/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Sube Fotos
                        </button>
                        <input type="file" id="project-gallery-input" name="project_gallery_images[]" multiple class="hidden" accept="image/*" onchange="previewProjectGallery(this)">
                    </div>
                </div>
                
                <div id="project-gallery-container" class="grid grid-cols-3 md:grid-cols-4 gap-4 min-h-[150px] p-4 bg-gray-50/50 rounded-2xl border border-dashed border-gray-200 overflow-y-auto max-h-[250px]">
                    <!-- Se rellenará dinámicamente con JS -->
                </div>
            </div>
            
            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                <label class="inline-flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" id="project-is-active" value="1" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-secondary relative"></div>
                    <span class="text-xs font-extrabold uppercase tracking-widest text-gray-500">Publicar de inmediato</span>
                </label>
                <div class="flex gap-3">
                    <button type="button" onclick="closeProjectModal()" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-xl transition-colors">Cancelar</button>
                    <button type="submit" class="px-6 py-3 bg-primary hover:bg-secondary text-white text-sm font-bold rounded-xl shadow-lg shadow-primary/30 transition-colors">Guardar Proyecto</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal de Configuración de Textos -->
<div id="settings-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 max-w-2xl w-full mx-4 overflow-hidden transform scale-95 transition-all duration-300" id="settings-modal-container">
        <div class="px-8 py-6 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-800">Configurar Textos de Proyectos</h3>
            <button onclick="closeSettingsModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <form action="<?= url('admin/proyectos/settings') ?>" method="POST" class="p-8 space-y-6">
            <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
            
            <div class="space-y-4">
                <h4 class="text-sm font-extrabold uppercase tracking-widest text-secondary border-b border-gray-100 pb-2 mb-4">Sección en Inicio (Home)</h4>
                
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-2">Título de la Sección</label>
                    <input type="text" name="projects_home_title" value="<?= htmlspecialchars($settings['projects_home_title'] ?? 'Nuestros Proyectos Recientes') ?>" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-sm font-medium transition-shadow">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-2">Subtítulo de la Sección</label>
                    <textarea name="projects_home_subtitle" rows="2" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-sm font-medium transition-shadow resize-none"><?= htmlspecialchars($settings['projects_home_subtitle'] ?? 'Casos de éxito que demuestran nuestra capacidad de ejecución e innovación.') ?></textarea>
                </div>
            </div>

            <div class="space-y-4 pt-4 border-t border-gray-100">
                <h4 class="text-sm font-extrabold uppercase tracking-widest text-secondary border-b border-gray-100 pb-2 mb-4">Página de Proyectos General (/proyectos)</h4>
                
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-2">Título de la Página</label>
                    <input type="text" name="projects_page_title" value="<?= htmlspecialchars($settings['projects_page_title'] ?? 'Casos de Éxito') ?>" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-sm font-medium transition-shadow">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-2">Subtítulo de la Página</label>
                    <textarea name="projects_page_subtitle" rows="2" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-sm font-medium transition-shadow resize-none"><?= htmlspecialchars($settings['projects_page_subtitle'] ?? 'Proyectos emblemáticos que demuestran nuestro compromiso absoluto con la calidad corporativa y la entrega de valor real.') ?></textarea>
                </div>
            </div>
            
            <div class="flex justify-end gap-3 pt-6 border-t border-gray-100">
                <button type="button" onclick="closeSettingsModal()" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-xl transition-colors">Cancelar</button>
                <button type="submit" class="px-6 py-3 bg-primary hover:bg-secondary text-white text-sm font-bold rounded-xl shadow-lg shadow-primary/30 transition-colors">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>

<script>
function switchProjectTab(tab) {
    // Esconder todos los contenidos
    document.querySelectorAll('.project-tab-content').forEach(el => el.classList.add('hidden'));
    // Desactivar todos los botones de pestaña
    document.querySelectorAll('.project-tab-btn').forEach(btn => {
        btn.classList.remove('border-secondary', 'text-secondary');
        btn.classList.add('border-transparent', 'text-gray-400');
    });
    
    // Activar el correspondiente
    document.getElementById('content-' + tab).classList.remove('hidden');
    document.getElementById('tab-btn-' + tab).classList.remove('border-transparent', 'text-gray-400');
    document.getElementById('tab-btn-' + tab).classList.add('border-secondary', 'text-secondary');
}

function openProjectModal() {
    document.getElementById('modal-title').textContent = 'Crear Nuevo Proyecto';
    document.getElementById('project-id').value = '';
    document.getElementById('project-title').value = '';
    document.getElementById('project-slug').value = '';
    document.getElementById('project-client').value = '';
    document.getElementById('project-completion-date').value = '';
    document.getElementById('project-description').value = '';
    document.getElementById('project-image-alt').value = '';
    
    // Resetear campos de reto y solución
    document.getElementById('project-challenge-title').value = 'El Reto';
    document.getElementById('project-challenge-desc').value = '';
    document.getElementById('project-solution-title').value = 'La Solución';
    document.getElementById('project-solution-desc').value = '';
    document.getElementById('project-impact-label').value = 'Impacto Logrado';
    document.getElementById('project-impact-value').value = '100% Optimizado';
    
    document.getElementById('project-is-active').checked = true;
    
    // Resetear vista de galería
    document.getElementById('project-gallery-container').innerHTML = '<div class="col-span-full py-8 text-center text-xs text-gray-400 italic">No hay fotos en la galería de este proyecto.</div>';
    
    // Reset image preview
    document.getElementById('project-image-preview').classList.add('hidden');
    document.getElementById('project-image-placeholder').classList.remove('hidden');
    
    // Volver a pestaña general
    switchProjectTab('general');
    
    const modal = document.getElementById('project-modal');
    const container = document.getElementById('project-modal-container');
    modal.classList.remove('pointer-events-none', 'opacity-0');
    container.classList.remove('scale-95');
}

function closeProjectModal() {
    const modal = document.getElementById('project-modal');
    const container = document.getElementById('project-modal-container');
    modal.classList.add('pointer-events-none', 'opacity-0');
    container.classList.add('scale-95');
}

function openSettingsModal() {
    const modal = document.getElementById('settings-modal');
    const container = document.getElementById('settings-modal-container');
    modal.classList.remove('pointer-events-none', 'opacity-0');
    container.classList.remove('scale-95');
}

function closeSettingsModal() {
    const modal = document.getElementById('settings-modal');
    const container = document.getElementById('settings-modal-container');
    modal.classList.add('pointer-events-none', 'opacity-0');
    container.classList.add('scale-95');
}

function editProject(project) {
    document.getElementById('modal-title').textContent = 'Editar Proyecto';
    document.getElementById('project-id').value = project.id;
    document.getElementById('project-title').value = project.title;
    document.getElementById('project-slug').value = project.slug;
    document.getElementById('project-client').value = project.client || '';
    document.getElementById('project-completion-date').value = project.completion_date || '';
    document.getElementById('project-description').value = project.description || '';
    document.getElementById('project-image-alt').value = project.image_alt || '';
    
    // Cargar campos personalizados
    document.getElementById('project-challenge-title').value = project.challenge_title || 'El Reto';
    document.getElementById('project-challenge-desc').value = project.challenge_desc || '';
    document.getElementById('project-solution-title').value = project.solution_title || 'La Solución';
    document.getElementById('project-solution-desc').value = project.solution_desc || '';
    document.getElementById('project-impact-label').value = project.impact_label || 'Impacto Logrado';
    document.getElementById('project-impact-value').value = project.impact_value || '100% Optimizado';
    
    document.getElementById('project-is-active').checked = parseInt(project.is_active) === 1;
    
    if (project.main_image) {
        document.getElementById('project-image-preview').src = '/' + project.main_image;
        document.getElementById('project-image-preview').classList.remove('hidden');
        document.getElementById('project-image-placeholder').classList.add('hidden');
    } else {
        document.getElementById('project-image-preview').classList.add('hidden');
        document.getElementById('project-image-placeholder').classList.remove('hidden');
    }
    
    // Cargar fotos de la galería
    const galleryContainer = document.getElementById('project-gallery-container');
    galleryContainer.innerHTML = '';
    
    if (project.gallery && project.gallery.length > 0) {
        project.gallery.forEach(img => {
            const div = document.createElement('div');
            div.className = 'relative group bg-white rounded-xl overflow-hidden border border-gray-200 shadow-sm flex flex-col';
            div.innerHTML = `
                <div class="relative h-24 overflow-hidden bg-gray-50">
                    <img src="/${img.image_path}" class="w-full h-full object-cover">
                    <button type="button" onclick="deleteProjectGalleryImage(${img.id}, this)" class="absolute top-1 right-1 w-6 h-6 bg-red-600 hover:bg-red-700 text-white rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-sm" title="Borrar Foto">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
                <div class="p-2 bg-gray-50/50 border-t border-gray-100">
                    <input type="text" name="project_gallery_alts[${img.id}]" value="${img.image_alt || ''}" placeholder="SEO ALT" class="w-full px-1.5 py-1 text-[9px] border border-gray-200 rounded focus:outline-none focus:border-secondary" title="Texto descriptivo para SEO">
                </div>
            `;
            galleryContainer.appendChild(div);
        });
    } else {
        galleryContainer.innerHTML = '<div class="col-span-full py-8 text-center text-xs text-gray-400 italic">No hay fotos en la galería de este proyecto.</div>';
    }
    
    // Volver a pestaña general
    switchProjectTab('general');
    
    const modal = document.getElementById('project-modal');
    const container = document.getElementById('project-modal-container');
    modal.classList.remove('pointer-events-none', 'opacity-0');
    container.classList.remove('scale-95');
}

function generateProjectSlug() {
    const title = document.getElementById('project-title').value;
    const slug = title.toLowerCase()
        .replace(/[^a-z0-9 -]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');
    document.getElementById('project-slug').value = slug;
}

function previewProjectImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('project-image-preview').src = e.target.result;
            document.getElementById('project-image-preview').classList.remove('hidden');
            document.getElementById('project-image-placeholder').classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }
}

function previewProjectGallery(input) {
    const galleryContainer = document.getElementById('project-gallery-container');
    // Si sólo había el mensaje de "no hay fotos", lo removemos
    if (galleryContainer.querySelector('.col-span-full')) {
        galleryContainer.innerHTML = '';
    }
    
    if (input.files) {
        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative aspect-square bg-gray-100 rounded-xl overflow-hidden group border border-gray-100 shadow-sm opacity-70';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-full object-cover">
                    <span class="absolute bottom-1 left-1 bg-black/60 text-[9px] text-white px-1.5 py-0.5 rounded font-black uppercase">Nueva</span>
                `;
                galleryContainer.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }
}

async function deleteProjectGalleryImage(id, btn) {
    if (!confirm('¿Seguro que deseas eliminar esta foto de la galería?')) return;
    
    try {
        const formData = new FormData();
        formData.append('id', id);
        formData.append('csrf_token', '<?= \Core\Security::generateCSRFToken() ?>');
        
        const response = await fetch('<?= url('admin/proyectos/gallery/delete') ?>', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        if (result.success) {
            const container = btn.closest('.relative');
            container.remove();
            
            // Si ya no quedan fotos, mostrar mensaje vacío
            const galleryContainer = document.getElementById('project-gallery-container');
            if (galleryContainer.children.length === 0) {
                galleryContainer.innerHTML = '<div class="col-span-full py-8 text-center text-xs text-gray-400 italic">No hay fotos en la galería de este proyecto.</div>';
            }
        } else {
            alert('Error al intentar eliminar la imagen.');
        }
    } catch(err) {
        console.error(err);
        alert('Ocurrió un error en el servidor.');
    }
}

function filterProjects() {
    const search = document.getElementById('search-projects').value.toLowerCase();
    const rows = document.querySelectorAll('.project-row');
    rows.forEach(row => {
        const title = row.getAttribute('data-title');
        const client = row.getAttribute('data-client');
        if (title.includes(search) || client.includes(search)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
