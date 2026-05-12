<!-- Quill Rich Text Editor Assets -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<style>
  .ql-container.ql-snow {
    border-bottom-left-radius: 1.25rem;
    border-bottom-right-radius: 1.25rem;
    border-color: #e2e8f0 !important;
    font-family: inherit;
    min-height: 240px;
  }
  .ql-toolbar.ql-snow {
    border-top-left-radius: 1.25rem;
    border-top-right-radius: 1.25rem;
    border-color: #e2e8f0 !important;
    background-color: #f8fafc;
    padding: 12px !important;
  }
  .ql-editor {
    font-size: 0.875rem;
    color: #1e293b;
    line-height: 1.625;
  }
  .ql-editor.ql-blank::before {
    font-style: normal;
    color: #94a3b8;
  }
</style>

<div class="mb-8 flex flex-col sm:flex-row justify-between items-center gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-gray-900">Gestión de Blog</h1>
        <p class="text-gray-500 text-sm mt-1">Administra los artículos de noticias, tendencias y tecnología publicados en el sitio web.</p>
    </div>
    <div class="flex flex-wrap gap-3">
        <button onclick="openSettingsModal()" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-3 rounded-xl text-sm font-bold transition-colors flex items-center gap-2 border border-gray-200 shadow-sm">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            Configurar Textos Inicio
        </button>
        <button onclick="openCategoriesModal()" class="bg-white border border-indigo-100 text-indigo-700 hover:bg-indigo-50 px-6 py-3 rounded-xl text-sm font-bold transition-all flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            Gestionar Categorías
        </button>
        <button onclick="openPostModal()" class="bg-primary hover:bg-secondary text-white px-6 py-3 rounded-xl text-sm font-bold transition-colors flex items-center gap-2 shadow-lg shadow-primary/30">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Nuevo Artículo
        </button>
    </div>
</div>

<?php if(isset($_GET['success'])): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative mb-6 shadow-sm flex items-center gap-3">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span class="block sm:inline font-medium">
            <?php
                switch($_GET['success']) {
                    case 'settings_saved': echo '¡Configuración de textos guardada con éxito!'; break;
                    case 'category_saved': echo '¡Categoría guardada con éxito!'; break;
                    case 'category_deleted': echo '¡Categoría eliminada con éxito!'; break;
                    case 'post_saved': echo '¡Artículo guardado correctamente!'; break;
                    default: echo '¡Operación realizada con éxito!';
                }
            ?>
        </span>
    </div>
<?php endif; ?>

<?php if(isset($_GET['error']) && $_GET['error'] === 'category_duplicate'): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-6 shadow-sm flex items-center gap-3">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span class="block sm:inline font-medium">Error: El slug de la categoría ya está en uso. Elija otro nombre.</span>
    </div>
<?php endif; ?>



<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 text-gray-400 text-[11px] font-bold uppercase tracking-widest border-b border-gray-100">
                    <th class="px-8 py-5">Imagen</th>
                    <th class="px-8 py-5">Título / Autor</th>
                    <th class="px-8 py-5">Extracto</th>
                    <th class="px-8 py-5 text-center">Estado</th>
                    <th class="px-8 py-5 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php if(!empty($posts)): ?>
                    <?php foreach($posts as $post): ?>
                        <tr class="hover:bg-blue-50/30 transition-colors group">
                            <td class="px-8 py-5">
                                <div class="w-24 h-14 rounded-xl bg-gray-100 overflow-hidden shadow-sm border border-gray-200">
                                    <?php if(!empty($post['image'])): ?>
                                        <img src="<?= asset($post['image']) ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="block font-extrabold text-gray-900 group-hover:text-secondary transition-colors"><?= htmlspecialchars($post['title']) ?></span>
                                <span class="block text-xs text-gray-500 mt-0.5">Autor: <?= htmlspecialchars($post['author_name'] ?? 'Administrador') ?></span>
                                <?php if(!empty($post['category_name'])): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 mt-1.5 rounded-md text-[10px] font-bold bg-indigo-50 text-indigo-600 border border-indigo-100 uppercase">
                                        <?= htmlspecialchars($post['category_name']) ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-8 py-5">
                                <span class="text-xs text-gray-600 line-clamp-2 max-w-xs leading-relaxed"><?= htmlspecialchars($post['excerpt']) ?></span>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" <?= $post['status'] === 'published' ? 'checked' : '' ?> 
                                           onchange="togglePostStatus(<?= $post['id'] ?>, this.checked)">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-secondary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-secondary"></div>
                                </label>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <div class="flex justify-end gap-2">
                                    <button onclick="editPost(<?= htmlspecialchars(json_encode($post)) ?>)" class="w-9 h-9 rounded-xl bg-gray-100 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-all shadow-sm" title="Editar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    <form action="<?= url('admin/blog/duplicate') ?>" method="POST" class="inline-block">
                                        <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
                                        <input type="hidden" name="id" value="<?= $post['id'] ?>">
                                        <button type="submit" class="w-9 h-9 rounded-xl bg-gray-100 text-teal-600 hover:bg-teal-600 hover:text-white flex items-center justify-center transition-all shadow-sm" title="Duplicar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg>
                                        </button>
                                    </form>
                                    <form action="<?= url('admin/blog/delete') ?>" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este artículo? Se archivará de forma segura.');" class="inline-block">
                                        <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
                                        <input type="hidden" name="id" value="<?= $post['id'] ?>">
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
                        <td colspan="5" class="px-8 py-20 text-center text-gray-400 italic bg-gray-50/30">No se encontraron artículos creados. ¡Crea el primero!</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal para Configurar Textos Inicio -->
<div id="settings-modal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden z-50 items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 w-full max-w-3xl overflow-hidden transform transition-all scale-95 opacity-0 duration-300 flex flex-col max-h-[90vh]" id="settings-modal-container">
        <!-- Header -->
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h4 class="text-xl font-extrabold text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Configurar Textos y Ajustes del Blog
            </h4>
            <button onclick="closeSettingsModal()" class="text-gray-400 hover:text-gray-600 transition-colors p-2 hover:bg-white rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form action="<?= url('admin/blog/settings') ?>" method="POST" class="p-8 space-y-6 overflow-y-auto flex-1">
            <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
            
            <!-- SECCIÓN EN INICIO -->
            <div class="space-y-4">
                <h5 class="text-xs font-black text-secondary uppercase tracking-widest pl-2 border-l-4 border-secondary">Sección en Portada (Inicio)</h5>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2 pl-1">Etiqueta Superior</label>
                        <input type="text" name="home_blog_tagline" value="<?= htmlspecialchars($settings['home_blog_tagline'] ?? 'Actualidad y Conocimiento') ?>" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2 pl-1">Título de Sección</label>
                        <input type="text" name="home_blog_title" value="<?= htmlspecialchars($settings['home_blog_title'] ?? 'Nuestro Blog Corporativo') ?>" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50">
                    </div>
                </div>
            </div>

            <hr class="border-gray-100">

            <!-- PÁGINA DE BLOG -->
            <div class="space-y-4">
                <h5 class="text-xs font-black text-secondary uppercase tracking-widest pl-2 border-l-4 border-secondary">Página Principal del Blog (/blog)</h5>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2 pl-1">Etiqueta Superior de Página</label>
                        <input type="text" name="blog_page_tagline" value="<?= htmlspecialchars($settings['blog_page_tagline'] ?? 'Conocimiento & Vanguardia') ?>" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2 pl-1">Título de la Página (H1)</label>
                        <input type="text" name="blog_page_title" value="<?= htmlspecialchars($settings['blog_page_title'] ?? 'Blog Corporativo') ?>" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50">
                    </div>
                </div>
                
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2 pl-1">Descripción de la Página</label>
                    <textarea name="blog_page_description" rows="3" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50 resize-none" placeholder="Descripción para la página de blog..."><?= htmlspecialchars($settings['blog_page_description'] ?? 'Últimas noticias, artículos estratégicos y tendencias sobre innovación, software a medida y modernización cloud.') ?></textarea>
                </div>
            </div>

            <hr class="border-gray-100">

            <!-- SIDEBAR CTA -->
            <div class="space-y-4">
                <h5 class="text-xs font-black text-secondary uppercase tracking-widest pl-2 border-l-4 border-secondary">Banner de Contacto Lateral (Sidebar)</h5>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2 pl-1">Título del Banner</label>
                        <input type="text" name="blog_sidebar_cta_title" value="<?= htmlspecialchars($settings['blog_sidebar_cta_title'] ?? '¿Tienes un proyecto en mente?') ?>" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2 pl-1">Texto del Botón</label>
                        <input type="text" name="blog_sidebar_cta_btn_text" value="<?= htmlspecialchars($settings['blog_sidebar_cta_btn_text'] ?? 'Contáctanos') ?>" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50">
                    </div>
                </div>
                
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2 pl-1">Descripción Corta</label>
                    <textarea name="blog_sidebar_cta_description" rows="2" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50 resize-none" placeholder="Escriba una breve invitación..."><?= htmlspecialchars($settings['blog_sidebar_cta_description'] ?? 'Impulsamos tu transformación digital con tecnología premium.') ?></textarea>
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

<!-- Modal para Gestionar Categorías (CRUD Completo) -->
<div id="categories-modal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden z-50 items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 w-full max-w-2xl overflow-hidden transform transition-all scale-95 opacity-0 duration-300 flex flex-col max-h-[90vh]" id="categories-modal-container">
        <!-- Header -->
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h4 class="text-xl font-extrabold text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                Gestión de Categorías
            </h4>
            <button onclick="closeCategoriesModal()" class="text-gray-400 hover:text-gray-600 transition-colors p-2 hover:bg-white rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Formulario Inline de Categoría -->
        <div class="bg-indigo-50/50 p-6 border-b border-indigo-100">
            <form id="cat-form" action="<?= url('admin/blog/categorias/save') ?>" method="POST" class="flex flex-wrap items-end gap-4">
                <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
                <input type="hidden" name="id" id="cat-id" value="">
                
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-xs font-black text-indigo-900/50 uppercase tracking-wider mb-1.5 pl-1">Nombre de Categoría</label>
                    <input type="text" name="name" id="cat-name" required oninput="generateCatSlug(this.value)" class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 py-3 px-4 text-sm bg-white" placeholder="Ej: Innovación Tecnológica">
                </div>
                
                <div class="flex-1 min-w-[150px]">
                    <label class="block text-xs font-black text-indigo-900/50 uppercase tracking-wider mb-1.5 pl-1">Slug (Opcional)</label>
                    <input type="text" name="slug" id="cat-slug" class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 py-3 px-4 text-sm bg-white" placeholder="ej-innovacion">
                </div>
                
                <div>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl text-sm font-bold transition-all shadow-md shadow-indigo-200">Guardar</button>
                    <button type="button" id="btn-cancel-cat" onclick="resetCatForm()" class="hidden ml-2 bg-white text-gray-500 hover:text-gray-800 px-4 py-3 rounded-xl text-xs font-bold border border-gray-200 transition-all">Cancelar</button>
                </div>
            </form>
        </div>

        <!-- Lista Scrollable -->
        <div class="overflow-y-auto flex-1 p-6">
            <table class="w-full">
                <thead class="border-b border-gray-100 text-left text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">
                    <tr>
                        <th class="pb-3">Nombre</th>
                        <th class="pb-3">Slug URL</th>
                        <th class="pb-3 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php if(!empty($categories)): ?>
                        <?php foreach($categories as $cat): ?>
                            <tr class="group hover:bg-gray-50">
                                <td class="py-3.5 font-bold text-gray-800"><?= htmlspecialchars($cat['name']) ?></td>
                                <td class="py-3.5 text-xs font-mono text-gray-400"><?= htmlspecialchars($cat['slug']) ?></td>
                                <td class="py-3.5 text-right">
                                    <div class="flex justify-end gap-1.5">
                                        <button onclick="editCategory(<?= htmlspecialchars(json_encode($cat)) ?>)" class="w-8 h-8 rounded-lg text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 flex items-center justify-center transition-all" title="Editar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                        <form action="<?= url('admin/blog/categorias/delete') ?>" method="POST" class="inline" onsubmit="return confirm('¿Eliminar categoría? Los posts vinculados quedarán sin categoría.')">
                                            <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
                                            <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                                            <button type="submit" class="w-8 h-8 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 flex items-center justify-center transition-all" title="Eliminar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="py-10 text-center text-sm text-gray-400 italic">No hay categorías creadas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal para Crear / Editar Posts -->
<div id="post-modal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden z-50 items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 w-full max-w-4xl overflow-hidden transform transition-all scale-95 opacity-0 duration-300" id="modal-container">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h4 id="modal-title" class="text-xl font-extrabold text-gray-900">Nuevo Artículo</h4>
            <button onclick="closePostModal()" class="text-gray-400 hover:text-gray-600 transition-colors p-2 hover:bg-white rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <form id="post-form" action="<?= url('admin/blog/save') ?>" method="POST" enctype="multipart/form-data" class="p-8 space-y-6 max-h-[80vh] overflow-y-auto custom-scrollbar">
            <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
            <input type="hidden" name="id" id="post-id" value="">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Columna Izquierda (Ocupa 2/3): Título, Slug y Contenido -->
                <div class="lg:col-span-2 space-y-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Título del Artículo</label>
                        <input type="text" name="title" id="post-title" required oninput="generateSlug(this.value)" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm transition-all bg-gray-50 focus:bg-white" placeholder="Ej: El auge del Multicloud en la región">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Slug URL (Autogenerado si está vacío)</label>
                        <input type="text" name="slug" id="post-slug" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm transition-all bg-gray-50 focus:bg-white" placeholder="ej-el-auge-del-multicloud">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Extracto / Resumen Corto</label>
                        <textarea name="excerpt" id="post-excerpt" rows="3" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm transition-all bg-gray-50 focus:bg-white resize-none leading-relaxed" placeholder="Resumen corto que se mostrará en el listado de tarjetas..."></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Contenido Principal</label>
                        <div id="quill-editor" class="bg-white"></div>
                        <input type="hidden" name="content" id="post-content">
                    </div>
                </div>
                
                <!-- Columna Derecha (Ocupa 1/3): Imagen Destacada y Configuración -->
                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Imagen Destacada</label>
                        <div class="relative group">
                            <div class="w-full h-44 rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 overflow-hidden flex flex-col items-center justify-center relative cursor-pointer hover:border-secondary hover:bg-white transition-all duration-300" onclick="document.getElementById('post-image').click()">
                                <img id="image-preview" src="" class="hidden w-full h-full object-cover">
                                <div id="upload-placeholder" class="text-center p-4">
                                    <div class="w-10 h-10 rounded-full bg-secondary/10 flex items-center justify-center mx-auto mb-2 text-secondary group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <span class="text-xs font-extrabold text-gray-700 block mb-0.5">Seleccionar Imagen</span>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase font-mono">JPG, PNG o WEBP</span>
                                </div>
                                <div class="absolute inset-0 bg-black/45 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center text-white text-xs font-bold gap-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span>Cambiar Imagen</span>
                                </div>
                            </div>
                            <input type="file" name="image" id="post-image" class="hidden" accept="image/*" onchange="previewPostImage(this)">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Texto Alternativo Imagen (SEO ALT)</label>
                        <input type="text" name="image_alt" id="post-image-alt" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm transition-all bg-gray-50 focus:bg-white" placeholder="Ej: Portada de nube y ciberseguridad corporativa">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Categoría</label>
                        <select name="category_id" id="post-category" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50 focus:bg-white transition-all font-bold">
                            <option value="">Sin Categoría</option>
                            <?php if(!empty($categories)): ?>
                                <?php foreach($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Estado del Post</label>
                        <select name="status" id="post-status" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50 focus:bg-white transition-all font-bold">
                            <option value="draft">Borrador</option>
                            <option value="published">Publicado</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 pt-6 border-t border-gray-100">
                <button type="button" onclick="closePostModal()" class="flex-1 px-6 py-4 bg-gray-100 text-gray-600 rounded-2xl font-bold hover:bg-gray-200 transition-all">Cancelar</button>
                <button type="submit" class="flex-[2] px-6 py-4 bg-primary text-white rounded-2xl font-bold hover:bg-secondary transition-all shadow-lg shadow-primary/20">Guardar Artículo</button>
            </div>
        </form>
    </div>
</div>

<script>
const modal = document.getElementById('post-modal');
const container = document.getElementById('modal-container');

function openPostModal() {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => {
        container.classList.remove('scale-95', 'opacity-0');
        container.classList.add('scale-100', 'opacity-100');
    }, 10);
    document.body.style.overflow = 'hidden';
}

function closePostModal() {
    container.classList.remove('scale-100', 'opacity-100');
    container.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        resetPostForm();
    }, 300);
    document.body.style.overflow = 'auto';
}

let quill;

function resetPostForm() {
    document.getElementById('post-id').value = '';
    document.getElementById('post-title').value = '';
    document.getElementById('post-slug').value = '';
    document.getElementById('post-excerpt').value = '';
    document.getElementById('post-content').value = '';
    document.getElementById('post-category').value = '';
    document.getElementById('post-status').value = 'draft';
    document.getElementById('image-preview').src = '';
    document.getElementById('image-preview').classList.add('hidden');
    document.getElementById('upload-placeholder').classList.remove('hidden');
    document.getElementById('post-image-alt').value = '';
    document.getElementById('modal-title').innerText = 'Nuevo Artículo';
    if (quill) {
        quill.setContents([]);
    }
}

function editPost(post) {
    resetPostForm();
    document.getElementById('post-id').value = post.id;
    document.getElementById('post-title').value = post.title;
    document.getElementById('post-slug').value = post.slug;
    document.getElementById('post-excerpt').value = post.excerpt;
    document.getElementById('post-content').value = post.content || '';
    if (quill) {
        quill.root.innerHTML = post.content || '';
    }
    document.getElementById('post-category').value = post.category_id || '';
    document.getElementById('post-status').value = post.status;
    document.getElementById('post-image-alt').value = post.image_alt || '';
    
    if(post.image) {
        const preview = document.getElementById('image-preview');
        let basePath = '<?= asset('') ?>';
        if (basePath.endsWith('/') && post.image.startsWith('/')) {
            preview.src = basePath + post.image.substring(1);
        } else {
            preview.src = basePath + post.image;
        }
        preview.classList.remove('hidden');
        document.getElementById('upload-placeholder').classList.add('hidden');
    }
    
    document.getElementById('modal-title').innerText = 'Editar Artículo';
    openPostModal();
}

function generateCatSlug(val) {
    const slugInput = document.getElementById('cat-slug');
    if (document.getElementById('cat-id').value === '') { // solo autogenerar en creación
        slugInput.value = val.toLowerCase()
            .trim()
            .normalize("NFD").replace(/[\u0300-\u036f]/g, "") // Quitar acentos
            .replace(/[^a-z0-9\s-]/g, '') // Quitar caracteres extraños
            .replace(/[\s_]+/g, '-') // Reemplazar espacios y guiones bajos por un solo guión
            .replace(/^-+|-+$/g, ''); // Quitar guiones al principio y final
    }
}

function generateSlug(val) {
    const slugInput = document.getElementById('post-slug');
    if (document.getElementById('post-id').value === '') { 
        slugInput.value = val.toLowerCase()
            .trim()
            .normalize("NFD").replace(/[\u0300-\u036f]/g, "") // Quitar acentos
            .replace(/[^a-z0-9\s-]/g, '') 
            .replace(/[\s_]+/g, '-') 
            .replace(/^-+|-+$/g, ''); 
    }
}

function previewPostImage(input) {
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

function togglePostStatus(id, isChecked) {
    const status = isChecked ? 'published' : 'draft';
    fetch('<?= url('admin/blog/toggle') ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: id, status: status })
    })
    .then(response => response.json())
    .then(data => {
        if(!data.success) alert('Error al cambiar el estado.');
    })
    .catch(error => console.error('Error:', error));
}
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

document.addEventListener('DOMContentLoaded', function() {
    // Inicializar Quill Editor
    quill = new Quill('#quill-editor', {
        theme: 'snow',
        placeholder: 'Redacta todo el artículo aquí...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'header': [1, 2, 3, 4, false] }],
                ['clean']
            ]
        }
    });

    // Sincronizar el contenido antes de enviar el formulario del post
    const form = document.getElementById('post-form');
    if (form) {
        form.addEventListener('submit', function() {
            document.getElementById('post-content').value = quill.root.innerHTML;
        });
    }
});

// Lógica para Modal de Categorías
const catModal = document.getElementById('categories-modal');
const catContainer = document.getElementById('categories-modal-container');

function openCategoriesModal() {
    catModal.classList.remove('hidden');
    catModal.classList.add('flex');
    setTimeout(() => {
        catContainer.classList.remove('scale-95', 'opacity-0');
        catContainer.classList.add('scale-100', 'opacity-100');
    }, 10);
    document.body.style.overflow = 'hidden';
}

function closeCategoriesModal() {
    catContainer.classList.remove('scale-100', 'opacity-100');
    catContainer.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        catModal.classList.add('hidden');
        catModal.classList.remove('flex');
        resetCatForm();
    }, 300);
    document.body.style.overflow = 'auto';
}

function resetCatForm() {
    document.getElementById('cat-id').value = '';
    document.getElementById('cat-name').value = '';
    document.getElementById('cat-slug').value = '';
    document.getElementById('btn-cancel-cat').classList.add('hidden');
}

function editCategory(cat) {
    document.getElementById('cat-id').value = cat.id;
    document.getElementById('cat-name').value = cat.name;
    document.getElementById('cat-slug').value = cat.slug;
    document.getElementById('btn-cancel-cat').classList.remove('hidden');
    document.getElementById('cat-name').focus();
}
</script>
