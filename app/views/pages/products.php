<?php $this->component('header', ['title' => $title ?? 'Productos']); ?>
<?php $this->component('navbar'); ?>

<main class="min-h-screen bg-[#F8FAFC] pb-32">
    <!-- Hero / Cabecera de la Página de Productos -->
    <header class="bg-white pt-12 md:pt-16 pb-14 border-b border-gray-100 relative overflow-hidden mb-12">
        <div class="container mx-auto px-4 max-w-5xl text-center relative z-10">
            <div class="animate-fade-in-up">
                <span class="px-4 py-1.5 bg-secondary/10 text-secondary rounded-full font-black text-[10px] tracking-widest uppercase border border-secondary/5 mb-4 inline-block">
                    Catálogo Especializado
                </span>
                <h1 class="text-3xl md:text-5xl font-black text-primary mb-6 leading-tight tracking-tight">
                    <?= htmlspecialchars($settings['products_page_title'] ?? 'Nuestros Productos') ?>
                </h1>
                <p class="text-base md:text-lg text-gray-500 max-w-3xl mx-auto leading-relaxed">
                    <?= htmlspecialchars($settings['products_page_subtitle'] ?? 'Encuentra componentes y productos de la más alta calidad para asegurar el rendimiento de tus equipos.') ?>
                </p>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-4">
        <!-- Layout Principal: 2 Columnas (Grid de Productos + Sidebar a la derecha) -->
        <div class="flex flex-col lg:flex-row gap-10 relative">
            
            <!-- COLUMNA PRINCIPAL IZQUIERDA: Productos (2 columnas) -->
            <div class="flex-1">
                
                <!-- Barra superior móvil para filtrar categorías rápidamente -->
                <div class="block lg:hidden mb-8">
                    <div class="relative max-w-md mx-auto">
                        <button id="category-dropdown-btn" onclick="toggleCategoryDropdown()" class="w-full px-5 py-3.5 bg-white border border-gray-200 rounded-2xl shadow-sm text-gray-700 hover:border-primary flex items-center justify-between transition-all focus:outline-none text-sm font-bold">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                                Categoría: <span class="text-primary font-black"><?= $selectedCategory ? htmlspecialchars($selectedCategory['name']) : 'Todas' ?></span>
                            </span>
                            <svg id="category-dropdown-arrow" class="w-4 h-4 text-gray-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        
                        <div id="category-dropdown-menu" class="absolute left-0 right-0 mt-2 bg-white border border-gray-150 rounded-2xl shadow-xl z-30 opacity-0 scale-95 pointer-events-none transition-all duration-300 overflow-hidden">
                            <div class="py-1.5 max-h-60 overflow-y-auto">
                                <a href="/productos" class="block px-5 py-3 text-sm font-bold text-gray-700 hover:bg-gray-50 hover:text-primary transition-colors border-b border-gray-50 <?= !$selectedCategory ? 'bg-primary/5 text-primary font-black' : '' ?>">
                                    Todas las categorías
                                </a>
                                <?php if(!empty($categories)): ?>
                                    <?php foreach($categories as $cat): ?>
                                        <a href="/productos?categoria=<?= htmlspecialchars($cat['slug']) ?>" class="block px-5 py-3 text-sm font-bold text-gray-700 hover:bg-gray-50 hover:text-primary transition-colors border-b border-gray-50/50 last:border-b-0 <?= ($selectedCategory && $selectedCategory['id'] === $cat['id']) ? 'bg-primary/5 text-primary font-black' : '' ?>">
                                            <?= htmlspecialchars($cat['name']) ?>
                                        </a>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grid de Productos en 2 columnas -->
                <?php if(!empty($products)): ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                        <?php foreach($products as $index => $product): ?>
                        <a href="/productos/<?= htmlspecialchars($product['slug']) ?>" class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl border border-gray-100 transition-all duration-300 animate-fade-in-up flex flex-col" style="animation-delay: <?= ($index % 6) * 80 ?>ms;">
                            <div class="relative bg-gray-100 overflow-hidden border-b border-gray-100 aspect-w-4 aspect-h-3">
                                <img src="<?= htmlspecialchars($product['main_image']) ?>" alt="<?= htmlspecialchars($product['image_alt'] ?: $product['title']) ?>" loading="lazy" class="w-full h-60 object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-primary/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                            <div class="p-6 flex-1 flex flex-col">
                                <?php if(!empty($product['category_name'])): ?>
                                    <span class="inline-block text-[10px] font-black uppercase tracking-wider text-secondary bg-secondary/10 px-2.5 py-1 rounded-full border border-secondary/5 mb-3 self-start">
                                        <?= htmlspecialchars($product['category_name']) ?>
                                    </span>
                                <?php endif; ?>
                                <h2 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-primary transition-colors leading-snug line-clamp-2">
                                    <?= htmlspecialchars($product['title']) ?>
                                </h2>
                                <p class="text-gray-500 text-sm line-clamp-3 mb-6 flex-1 leading-relaxed">
                                    <?= htmlspecialchars($product['description']) ?>
                                </p>
                                <div class="flex items-center text-xs font-extrabold uppercase tracking-wider text-primary group-hover:text-secondary transition-colors mt-auto pt-4 border-t border-gray-100">
                                    <span>Ver detalles</span>
                                    <svg class="w-4 h-4 ml-1.5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </div>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <!-- Empty State -->
                    <div class="col-span-full text-center py-20 bg-white rounded-3xl border border-gray-100 shadow-sm p-8 max-w-xl mx-auto animate-fade-in-up">
                        <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center text-gray-300 mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">No se encontraron productos</h3>
                        <p class="text-gray-500 text-sm mb-6">No hay ítems activos disponibles en esta categoría.</p>
                        <a href="/productos" class="inline-flex items-center px-6 py-3 bg-primary hover:bg-secondary text-white font-bold rounded-xl transition-colors text-xs uppercase tracking-wider shadow-md">
                            Ver todos los productos
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- COLUMNA DERECHA: SIDEBAR (Desktop) -->
            <aside class="hidden lg:block w-80 flex-shrink-0 relative">
                <div class="sticky top-28 space-y-8">
                    
                    <!-- Módulo 1: Categorías (Estilo Blog) -->
                    <div class="bg-white p-7 rounded-[2.25rem] shadow-sm border border-slate-200/60">
                        <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest mb-5 flex items-center gap-2">
                            <span class="w-1.5 h-3 bg-primary rounded-full"></span>
                            Categorías
                        </h3>
                        
                        <div class="flex flex-col gap-2">
                            <a href="/productos" 
                               class="group flex items-center justify-between px-4 py-3.5 rounded-xl text-sm font-bold transition-all border <?= !$selectedCategory ? 'bg-primary text-white border-primary shadow-md shadow-primary/20' : 'text-gray-600 border-slate-100 hover:bg-slate-50 hover:text-primary' ?>">
                                <span>Todas las categorías</span>
                                <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 <?= !$selectedCategory ? 'opacity-100' : '' ?> transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                            
                            <?php if(!empty($categories)): ?>
                                <?php foreach($categories as $cat): ?>
                                    <?php 
                                        $isAct = ($selectedCategory && $selectedCategory['id'] === $cat['id']);
                                        $catUrl = '/productos?categoria=' . htmlspecialchars($cat['slug']);
                                    ?>
                                    <a href="<?= $catUrl ?>" 
                                       class="group flex items-center justify-between px-4 py-3.5 rounded-xl text-sm font-bold transition-all border <?= $isAct ? 'bg-secondary text-white border-secondary shadow-md shadow-secondary/20' : 'text-gray-600 border-slate-100 hover:bg-slate-50 hover:text-secondary' ?>">
                                        <span><?= htmlspecialchars($cat['name']) ?></span>
                                        <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 <?= $isAct ? 'opacity-100' : '' ?> transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Módulo 1.1: Filtro Activo Badge (Si hay categoría seleccionada) -->
                    <?php if($selectedCategory): ?>
                        <div class="bg-white p-6 rounded-[2.25rem] shadow-sm border border-slate-200/60 animate-fade-in-up">
                            <h4 class="text-xs font-black text-gray-900 uppercase tracking-widest mb-3 flex items-center gap-2">
                                <span class="w-1.5 h-3 bg-secondary rounded-full"></span>
                                Filtro Aplicado
                            </h4>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between bg-secondary/10 border border-secondary/20 px-4 py-3 rounded-xl text-xs font-bold text-secondary">
                                    <span><?= htmlspecialchars($selectedCategory['name']) ?></span>
                                    <a href="/productos" class="text-secondary/70 hover:text-secondary transition-colors" title="Limpiar filtro">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </a>
                                </div>
                                <a href="/productos" class="block text-center py-2.5 border border-dashed border-gray-300 text-gray-500 hover:bg-gray-50 rounded-xl font-bold text-xs transition-all uppercase tracking-wider">
                                    Limpiar filtro
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Módulo 2: Widget de Contacto / CTA Cotización (Estilo Detalle de Servicio) -->
                    <div class="bg-white rounded-[2.25rem] shadow-xl border border-gray-100 p-8 relative overflow-hidden">
                        <div class="absolute -top-12 -right-12 w-32 h-32 bg-secondary/10 rounded-full blur-2xl"></div>
                        
                        <h3 class="text-xl font-black text-primary mb-3 relative z-10">Solicita una Cotización</h3>
                        <p class="text-gray-500 text-xs leading-relaxed mb-6 relative z-10">
                            Nuestro equipo especializado está disponible para brindarte información técnica y cotizaciones a la medida.
                        </p>
                        
                        <div class="space-y-5 mb-8 relative z-10">
                            <div class="flex items-center gap-3.5 group">
                                <div class="w-10 h-10 rounded-xl bg-secondary/10 text-secondary flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Llámanos</p>
                                    <p class="text-xs font-extrabold text-gray-900"><?= htmlspecialchars($settings['contact_phone_value'] ?? '+57 300 123 4567') ?></p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3.5 group">
                                <div class="w-10 h-10 rounded-xl bg-secondary/10 text-secondary flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Escríbenos</p>
                                    <p class="text-xs font-extrabold text-gray-900 truncate max-w-[180px]"><?= htmlspecialchars($settings['contact_email_value'] ?? 'contacto@syncroandina.com') ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <button onclick="openContactModal('Consulta general sobre catálogo de productos', 'Productos')" class="w-full py-3.5 bg-primary hover:bg-secondary text-white text-xs font-bold rounded-xl shadow-lg shadow-primary/10 hover:shadow-secondary/20 flex items-center justify-center gap-2 transition-all duration-300 relative z-10 hover:scale-[1.02] uppercase tracking-wider">
                            <span>Solicitar Información</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>

                </div>
            </aside>
        </div>
    </div>
</main>

<script>
function toggleCategoryDropdown() {
    const menu = document.getElementById('category-dropdown-menu');
    const arrow = document.getElementById('category-dropdown-arrow');
    const isOpen = !menu.classList.contains('pointer-events-none');
    
    if (isOpen) {
        menu.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
        arrow.classList.remove('rotate-180');
    } else {
        menu.classList.remove('opacity-0', 'scale-95', 'pointer-events-none');
        arrow.classList.add('rotate-180');
    }
}

window.addEventListener('click', function(e) {
    const btn = document.getElementById('category-dropdown-btn');
    const menu = document.getElementById('category-dropdown-menu');
    if (btn && menu && !btn.contains(e.target) && !menu.contains(e.target)) {
        menu.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
        const arrow = document.getElementById('category-dropdown-arrow');
        if (arrow) arrow.classList.remove('rotate-180');
    }
});
</script>

<?php $this->component('contact_modal'); ?>
<?php $this->component('footer'); ?>
