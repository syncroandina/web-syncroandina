<div class="mb-8 flex flex-col sm:flex-row justify-between items-center gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-gray-900">Repuestos</h1>
        <p class="text-gray-500 text-sm mt-1">Gestiona los casos de éxito, asigna imágenes, maneja sus galerías y publícalos en el portal.</p>
    </div>
    <div class="flex items-center gap-3">
        <button onclick="openSettingsModal()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl text-sm font-bold transition-colors flex items-center gap-2 border border-gray-200 shadow-sm">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            Configurar Textos
        </button>
        <button onclick="openProductModal()" class="bg-primary hover:bg-secondary text-white px-6 py-3 rounded-xl text-sm font-bold transition-colors flex items-center gap-2 shadow-lg shadow-primary/30">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Crear Repuesto
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
            } elseif ($_GET['success'] === 'product_duplicated') {
                echo 'El producto ha sido duplicado correctamente.';
            } elseif ($_GET['success'] === 'product_deleted') {
                echo 'El producto ha sido eliminado correctamente.';
            } else {
                echo 'El producto ha sido guardado correctamente.';
            }
            ?>
        </span>
    </div>
<?php endif; ?>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
        <div class="relative w-full max-w-md">
            <input type="text" id="search-products" oninput="filterProducts()" placeholder="Buscar producto por título o cliente..." class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-sm font-medium transition-shadow">
            <svg class="w-5 h-5 text-gray-400 absolute left-4 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white text-gray-400 text-[11px] font-bold uppercase tracking-widest border-b border-gray-100">
                    <th class="px-8 py-5">Repuesto</th>
                    <th class="px-8 py-5">Estado</th>
                    <th class="px-8 py-5 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-sm" id="products-table-body">
                <?php if(!empty($products)): ?>
                    <?php foreach($products as $product): ?>
                    <tr class="hover:bg-blue-50/30 transition-colors group product-row" data-title="<?= htmlspecialchars(strtolower($product['title'])) ?>">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-gray-200 overflow-hidden shadow-sm flex-shrink-0">
                                    <?php if(!empty($product['main_image'])): ?>
                                        <img src="<?= asset($product['main_image']) ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <span class="block font-extrabold text-gray-900 group-hover:text-secondary transition-colors"><?= htmlspecialchars($product['title']) ?></span>
                                    <span class="block text-xs text-gray-400 mt-0.5">Slug: <?= htmlspecialchars($product['slug']) ?></span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <?php if($product['is_active']): ?>
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold border border-green-200">Publicado</span>
                            <?php else: ?>
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-xs font-bold border border-yellow-200">Borrador</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex justify-end gap-2">
                                <button onclick="editProduct(<?= htmlspecialchars(json_encode($product)) ?>)" class="w-8 h-8 rounded-lg bg-gray-100 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-colors shadow-sm" title="Editar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <form action="<?= url('admin/repuestos/duplicate') ?>" method="POST" class="inline-block" onsubmit="return confirm('¿Seguro que deseas duplicar este producto? Se creará una copia con su propia imagen independiente.');">
                                    <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
                                    <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-gray-100 text-teal-600 hover:bg-teal-600 hover:text-white flex items-center justify-center transition-colors shadow-sm" title="Duplicar/Clonar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg>
                                    </button>
                                </form>
                                <form action="<?= url('admin/repuestos/delete') ?>" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este producto? Se borrará permanentemente la imagen asociada.');" class="inline-block">
                                    <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
                                    <input type="hidden" name="id" value="<?= $product['id'] ?>">
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
                        <td colspan="3" class="px-8 py-10 text-center text-gray-400 italic">No se encontraron repuestos activos.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal de Repuesto -->
<div id="product-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 max-w-2xl w-full mx-4 overflow-hidden transform scale-95 transition-all duration-300" id="product-modal-container">
        <div class="px-8 py-6 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-800" id="modal-title">Crear Nuevo Repuesto</h3>
            <button onclick="closeProductModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Pestañas del Modal -->
        <div class="px-8 border-b border-gray-100 flex gap-6 bg-gray-50/50">
            <button type="button" onclick="switchProductTab('general')" id="tab-btn-general" class="px-4 py-3 text-xs font-extrabold uppercase tracking-widest border-b-2 border-secondary text-secondary transition-all product-tab-btn">General</button>
            <button type="button" onclick="switchProductTab('custom')" id="tab-btn-custom" class="px-4 py-3 text-xs font-extrabold uppercase tracking-widest border-b-2 border-transparent text-gray-400 hover:text-gray-600 transition-all product-tab-btn">Detalles Técnicos</button>
            <button type="button" onclick="switchProductTab('gallery')" id="tab-btn-gallery" class="px-4 py-3 text-xs font-extrabold uppercase tracking-widest border-b-2 border-transparent text-gray-400 hover:text-gray-600 transition-all product-tab-btn">Galería de Fotos</button>
        </div>
        
        <form action="<?= url('admin/repuestos') ?>" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
            <input type="hidden" name="id" id="product-id">
            
            <!-- Contenido Pestaña: General -->
            <div id="content-general" class="product-tab-content space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">Título del Repuesto</label>
                        <input type="text" name="title" id="product-title" required oninput="generateProductSlug()" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-sm font-medium transition-shadow">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">Slug (URL amigable)</label>
                        <input type="text" name="slug" id="product-slug" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-sm font-medium transition-shadow">
                    </div>
                </div>
                
                <div>
                    <label class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">Imagen Principal</label>
                    <div class="flex items-center gap-6">
                        <div class="w-24 h-24 rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 flex items-center justify-center overflow-hidden flex-shrink-0" id="product-image-preview-container">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="product-image-placeholder"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <img id="product-image-preview" class="w-full h-full object-cover hidden">
                        </div>
                        <div class="flex-1">
                            <input type="file" name="main_image" id="product-image-input" onchange="previewProductImage(event)" class="hidden" accept="image/*">
                            <button type="button" onclick="document.getElementById('product-image-input').click()" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-xl transition-colors flex items-center gap-2 border border-gray-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                Seleccionar Imagen
                            </button>
                            <p class="text-xs text-gray-400 mt-2">Recomendado: Formato .webp de alta resolución (1200x800px).</p>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">Texto Alternativo de la Imagen (SEO ALT)</label>
                    <input type="text" name="image_alt" id="product-image-alt" placeholder="Ej: Instalación eléctrica corporativa de alta tensión" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-sm font-medium transition-shadow">
                </div>
                
                <div>
                    <label class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">Descripción / Contenido del Repuesto</label>
                    <textarea name="description" id="product-description" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-sm font-medium transition-shadow resize-none" placeholder="Escribe los detalles o alcance del producto..."></textarea>
                </div>
            </div>

            <!-- Contenido Pestaña: Detalles Técnicos -->
            <div id="content-custom" class="product-tab-content hidden space-y-6">
                <div>
                    <label class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">Detalles Técnicos (Ítems)</label>
                    <textarea name="technical_details" id="product-technical-details" class="hidden"></textarea>
                    
                    <div class="flex gap-2 mb-4">
                        <input type="text" id="new-tech-detail" placeholder="Ej: Voltaje 220V AC" class="flex-1 px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-sm font-medium transition-shadow" onkeydown="if(event.key === 'Enter'){ event.preventDefault(); addTechDetail(); }">
                        <button type="button" onclick="addTechDetail()" class="px-6 py-3 bg-secondary hover:bg-secondary/90 text-white text-sm font-bold rounded-xl shadow-lg shadow-secondary/30 transition-colors flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Agregar
                        </button>
                    </div>
                    
                    <ul id="tech-details-list" class="space-y-2">
                        <!-- Items rendered here via JS -->
                    </ul>
                </div>
            </div>

            <!-- Contenido Pestaña: Galería de Fotos -->
            <div id="content-gallery" class="product-tab-content hidden space-y-6">
                <div class="flex justify-between items-center bg-gray-50 p-5 rounded-2xl border border-gray-100">
                    <div>
                        <h4 class="text-sm font-extrabold text-gray-800">Galería de Fotos del Repuesto</h4>
                        <p class="text-xs text-gray-400 mt-1">Sube múltiples imágenes asociadas a este caso de éxito.</p>
                    </div>
                    <div>
                        <button type="button" onclick="document.getElementById('product-gallery-input').click()" class="px-4 py-2.5 bg-secondary text-white text-xs font-black uppercase tracking-wider rounded-xl hover:bg-primary transition-all flex items-center gap-2 shadow-sm shadow-secondary/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Sube Fotos
                        </button>
                        <input type="file" id="product-gallery-input" name="gallery_images[]" multiple class="hidden" accept="image/*" onchange="previewProductGallery(this)">
                    </div>
                </div>
                
                <div id="product-gallery-container" class="grid grid-cols-3 md:grid-cols-4 gap-4 min-h-[150px] p-4 bg-gray-50/50 rounded-2xl border border-dashed border-gray-200 overflow-y-auto max-h-[250px]">
                    <!-- Se rellenará dinámicamente con JS -->
                </div>
            </div>
            
            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                <label class="inline-flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" id="product-is-active" value="1" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-secondary relative"></div>
                    <span class="text-xs font-extrabold uppercase tracking-widest text-gray-500">Publicar de inmediato</span>
                </label>
                <div class="flex gap-3">
                    <button type="button" onclick="closeProductModal()" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-xl transition-colors">Cancelar</button>
                    <button type="submit" class="px-6 py-3 bg-primary hover:bg-secondary text-white text-sm font-bold rounded-xl shadow-lg shadow-primary/30 transition-colors">Guardar Repuesto</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal de Configuración de Textos -->
<div id="settings-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 max-w-2xl w-full mx-4 overflow-hidden transform scale-95 transition-all duration-300" id="settings-modal-container">
        <div class="px-8 py-6 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-800">Configurar Textos de Repuestos</h3>
            <button onclick="closeSettingsModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <form action="<?= url('admin/repuestos/settings') ?>" method="POST" class="p-8 space-y-6">
            <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
            
            <div class="space-y-4">
                <h4 class="text-sm font-extrabold uppercase tracking-widest text-secondary border-b border-gray-100 pb-2 mb-4">Sección en Inicio (Home)</h4>
                
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-2">Título de la Sección</label>
                    <input type="text" name="products_home_title" value="<?= htmlspecialchars($settings['products_home_title'] ?? 'Nuestros Repuestos Recientes') ?>" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-sm font-medium transition-shadow">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-2">Subtítulo de la Sección</label>
                    <textarea name="products_home_subtitle" rows="2" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-sm font-medium transition-shadow resize-none"><?= htmlspecialchars($settings['products_home_subtitle'] ?? 'Casos de éxito que demuestran nuestra capacidad de ejecución e innovación.') ?></textarea>
                </div>
            </div>

            <div class="space-y-4 pt-4 border-t border-gray-100">
                <h4 class="text-sm font-extrabold uppercase tracking-widest text-secondary border-b border-gray-100 pb-2 mb-4">Página de Repuestos General (/repuestos)</h4>
                
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-2">Título de la Página</label>
                    <input type="text" name="products_page_title" value="<?= htmlspecialchars($settings['products_page_title'] ?? 'Casos de Éxito') ?>" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-sm font-medium transition-shadow">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-2">Subtítulo de la Página</label>
                    <textarea name="products_page_subtitle" rows="2" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-sm font-medium transition-shadow resize-none"><?= htmlspecialchars($settings['products_page_subtitle'] ?? 'Repuestos emblemáticos que demuestran nuestro compromiso absoluto con la calidad corporativa y la entrega de valor real.') ?></textarea>
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
function switchProductTab(tab) {
    // Esconder todos los contenidos
    document.querySelectorAll('.product-tab-content').forEach(el => el.classList.add('hidden'));
    // Desactivar todos los botones de pestaña
    document.querySelectorAll('.product-tab-btn').forEach(btn => {
        btn.classList.remove('border-secondary', 'text-secondary');
        btn.classList.add('border-transparent', 'text-gray-400');
    });
    
    // Activar el correspondiente
    document.getElementById('content-' + tab).classList.remove('hidden');
    document.getElementById('tab-btn-' + tab).classList.remove('border-transparent', 'text-gray-400');
    document.getElementById('tab-btn-' + tab).classList.add('border-secondary', 'text-secondary');
}

function openProductModal() {
    document.getElementById('modal-title').textContent = 'Crear Nuevo Repuesto';
    document.getElementById('product-id').value = '';
    document.getElementById('product-title').value = '';
    document.getElementById('product-slug').value = '';
    document.getElementById('product-technical-details').value = '';
    document.getElementById('product-description').value = '';
    
    renderTechDetails();
    document.getElementById('product-image-alt').value = '';
    
    document.getElementById('product-is-active').checked = true;
    
    // Resetear vista de galería
    document.getElementById('product-gallery-container').innerHTML = '<div class="col-span-full py-8 text-center text-xs text-gray-400 italic">No hay fotos en la galería de este producto.</div>';
    
    // Reset image preview
    document.getElementById('product-image-preview').classList.add('hidden');
    document.getElementById('product-image-placeholder').classList.remove('hidden');
    
    // Volver a pestaña general
    switchProductTab('general');
    
    const modal = document.getElementById('product-modal');
    const container = document.getElementById('product-modal-container');
    modal.classList.remove('pointer-events-none', 'opacity-0');
    container.classList.remove('scale-95');
}

function closeProductModal() {
    const modal = document.getElementById('product-modal');
    const container = document.getElementById('product-modal-container');
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

function editProduct(product) {
    document.getElementById('modal-title').textContent = 'Editar Repuesto';
    document.getElementById('product-id').value = product.id;
    document.getElementById('product-technical-details').value = product.technical_details || '';
    document.getElementById('product-title').value = product.title;
    document.getElementById('product-slug').value = product.slug;
    document.getElementById('product-description').value = product.description || '';
    
    renderTechDetails();
    document.getElementById('product-image-alt').value = product.image_alt || '';
    
    document.getElementById('product-is-active').checked = parseInt(product.is_active) === 1;
    
    if (product.main_image) {
        let imageSrc = product.main_image;
        if (!imageSrc.startsWith('/')) {
            imageSrc = '/' + imageSrc;
        }
        document.getElementById('product-image-preview').src = '<?= rtrim(url(), '/') ?>' + imageSrc;
        document.getElementById('product-image-preview').classList.remove('hidden');
        document.getElementById('product-image-placeholder').classList.add('hidden');
    } else {
        document.getElementById('product-image-preview').classList.add('hidden');
        document.getElementById('product-image-placeholder').classList.remove('hidden');
    }
    
    // Cargar fotos de la galería
    const galleryContainer = document.getElementById('product-gallery-container');
    galleryContainer.innerHTML = '';
    
    if (product.gallery && product.gallery.length > 0) {
        product.gallery.forEach(img => {
            let galSrc = img.image_path;
            if (!galSrc.startsWith('/')) {
                galSrc = '/' + galSrc;
            }
            const fullGalSrc = '<?= rtrim(url(), '/') ?>' + galSrc;
            const div = document.createElement('div');
            div.className = 'relative group bg-white rounded-xl overflow-hidden border border-gray-200 shadow-sm flex flex-col';
            div.innerHTML = `
                <div class="relative h-24 overflow-hidden bg-gray-50">
                    <img src="${fullGalSrc}" class="w-full h-full object-cover">
                    <button type="button" onclick="deleteProductGalleryImage(${img.id}, this)" class="absolute top-1 right-1 w-6 h-6 bg-red-600 hover:bg-red-700 text-white rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-sm" title="Borrar Foto">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
                <div class="p-2 bg-gray-50/50 border-t border-gray-100">
                    <input type="text" name="product_gallery_alts[${img.id}]" value="${img.image_alt || ''}" placeholder="SEO ALT" class="w-full px-1.5 py-1 text-[9px] border border-gray-200 rounded focus:outline-none focus:border-secondary" title="Texto descriptivo para SEO">
                </div>
            `;
            galleryContainer.appendChild(div);
        });
    } else {
        galleryContainer.innerHTML = '<div class="col-span-full py-8 text-center text-xs text-gray-400 italic">No hay fotos en la galería de este producto.</div>';
    }
    
    // Volver a pestaña general
    switchProductTab('general');
    
    const modal = document.getElementById('product-modal');
    const container = document.getElementById('product-modal-container');
    modal.classList.remove('pointer-events-none', 'opacity-0');
    container.classList.remove('scale-95');
}

function generateProductSlug() {
    const title = document.getElementById('product-title').value;
    const slug = title.toLowerCase()
        .replace(/[^a-z0-9 -]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');
    document.getElementById('product-slug').value = slug;
}

function previewProductImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('product-image-preview').src = e.target.result;
            document.getElementById('product-image-preview').classList.remove('hidden');
            document.getElementById('product-image-placeholder').classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }
}

function previewProductGallery(input) {
    const galleryContainer = document.getElementById('product-gallery-container');
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

async function deleteProductGalleryImage(id, btn) {
    if (!confirm('¿Seguro que deseas eliminar esta foto de la galería?')) return;
    
    try {
        const formData = new FormData();
        formData.append('id', id);
        formData.append('csrf_token', '<?= \Core\Security::generateCSRFToken() ?>');
        
        const response = await fetch('<?= url('admin/repuestos/gallery/delete') ?>', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        if (result.success) {
            const container = btn.closest('.relative');
            container.remove();
            
            // Si ya no quedan fotos, mostrar mensaje vacío
            const galleryContainer = document.getElementById('product-gallery-container');
            if (galleryContainer.children.length === 0) {
                galleryContainer.innerHTML = '<div class="col-span-full py-8 text-center text-xs text-gray-400 italic">No hay fotos en la galería de este producto.</div>';
            }
        } else {
            alert('Error al intentar eliminar la imagen.');
        }
    } catch(err) {
        console.error(err);
        alert('Ocurrió un error en el servidor.');
    }
}

function filterProducts() {
    const search = document.getElementById('search-products').value.toLowerCase();
    const rows = document.querySelectorAll('.product-row');
    rows.forEach(row => {
        const title = row.getAttribute('data-title');
        if (title.includes(search)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function renderTechDetails() {
    const textarea = document.getElementById('product-technical-details');
    const list = document.getElementById('tech-details-list');
    list.innerHTML = '';
    
    if(!textarea.value.trim()) return;
    
    const items = textarea.value.split('\n');
    items.forEach((item, index) => {
        if(!item.trim()) return;
        const li = document.createElement('li');
        li.className = 'flex justify-between items-center bg-gray-50 p-3 rounded-xl border border-gray-100 group';
        li.innerHTML = `
            <span class="text-sm font-medium text-gray-700">${item}</span>
            <button type="button" onclick="removeTechDetail(${index})" class="text-red-500 opacity-50 group-hover:opacity-100 transition-opacity p-1 hover:bg-red-50 rounded-lg" title="Eliminar">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </button>
        `;
        list.appendChild(li);
    });
}

function addTechDetail() {
    const input = document.getElementById('new-tech-detail');
    const val = input.value.trim();
    if(!val) return;
    
    const textarea = document.getElementById('product-technical-details');
    let current = textarea.value.trim();
    textarea.value = current ? current + '\n' + val : val;
    
    input.value = '';
    renderTechDetails();
}

function removeTechDetail(index) {
    const textarea = document.getElementById('product-technical-details');
    let items = textarea.value.trim().split('\n');
    items.splice(index, 1);
    textarea.value = items.join('\n');
    renderTechDetails();
}
</script>
