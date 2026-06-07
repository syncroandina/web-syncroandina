<?php $this->component('header', ['title' => $title ?? 'Repuestos']); ?>
<?php $this->component('navbar'); ?>

<main class="min-h-screen bg-gray-50 pt-20 pb-32">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-5xl mx-auto mb-16 animate-fade-in-up">
            <h1 class="text-3xl md:text-5xl font-extrabold text-primary mb-6"><?= htmlspecialchars($settings['products_page_title'] ?? 'Nuestros Repuestos') ?></h1>
            <p class="text-sm sm:text-base md:text-xl text-gray-600 mt-6 leading-relaxed"><?= htmlspecialchars($settings['products_page_subtitle'] ?? 'Encuentra componentes y repuestos de la más alta calidad para asegurar el rendimiento de tus equipos.') ?></p>
        </div>
        
        <!-- Contenedor de Filtros Pegajoso (Sticky justo debajo del Navbar y Logo Sobresaliente) -->
        <div class="sticky top-[122px] md:top-[145px] z-20 bg-gray-50/95 backdrop-blur-md py-4 mb-8 border-b border-gray-100/10">
            <!-- Filtro de Categorías Móvil (Dropdown) -->
            <div class="block md:hidden relative max-w-xs mx-auto animate-fade-in-up" style="animation-delay: 100ms;">
                <button id="category-dropdown-btn" onclick="toggleCategoryDropdown()" class="w-full px-5 py-3.5 bg-white border border-gray-200 rounded-2xl shadow-sm text-gray-700 hover:border-primary flex items-center justify-between transition-all focus:outline-none text-sm font-bold">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Categoría: <span class="text-primary font-black"><?= $selectedCategory ? htmlspecialchars($selectedCategory['name']) : 'Todos' ?></span>
                    </span>
                    <svg id="category-dropdown-arrow" class="w-4 h-4 text-gray-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                
                <!-- Panel de Opciones (Dropdown Menu) -->
                <div id="category-dropdown-menu" class="absolute left-0 right-0 mt-2 bg-white border border-gray-150 rounded-2xl shadow-xl z-30 opacity-0 scale-95 pointer-events-none transition-all duration-300 overflow-hidden">
                    <div class="py-1.5 max-h-60 overflow-y-auto">
                        <a href="/repuestos" class="block px-5 py-3 text-sm font-bold text-gray-700 hover:bg-gray-50 hover:text-primary transition-colors border-b border-gray-50 <?= !$selectedCategory ? 'bg-primary/5 text-primary' : '' ?>">
                            Todos
                        </a>
                        <?php if(!empty($categories)): ?>
                            <?php foreach($categories as $cat): ?>
                                <a href="/repuestos?categoria=<?= htmlspecialchars($cat['slug']) ?>" class="block px-5 py-3 text-sm font-bold text-gray-700 hover:bg-gray-50 hover:text-primary transition-colors border-b border-gray-50/50 last:border-b-0 <?= ($selectedCategory && $selectedCategory['id'] === $cat['id']) ? 'bg-primary/5 text-primary' : '' ?>">
                                    <?= htmlspecialchars($cat['name']) ?>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Filtro de Categorías Desktop (Botones centrados horizontalmente) -->
            <div class="hidden md:flex flex-wrap justify-center gap-3 animate-fade-in-up" style="animation-delay: 100ms;">
                <a href="/repuestos" class="px-5 py-2.5 rounded-full text-xs font-bold border transition-all duration-300 <?= !$selectedCategory ? 'bg-primary border-primary text-white shadow-lg shadow-primary/25' : 'bg-white border-gray-200 text-gray-600 hover:border-primary hover:text-primary shadow-sm' ?>">
                    Todos
                </a>
                <?php if(!empty($categories)): ?>
                    <?php foreach($categories as $cat): ?>
                        <a href="/repuestos?categoria=<?= htmlspecialchars($cat['slug']) ?>" class="px-5 py-2.5 rounded-full text-xs font-bold border transition-all duration-300 <?= ($selectedCategory && $selectedCategory['id'] === $cat['id']) ? 'bg-primary border-primary text-white shadow-lg shadow-primary/25' : 'bg-white border-gray-200 text-gray-600 hover:border-primary hover:text-primary shadow-sm' ?>">
                            <?= htmlspecialchars($cat['name']) ?>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

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
            
            // Cerrar el dropdown al hacer clic fuera
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
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if(!empty($products)): ?>
                <?php foreach($products as $index => $product): ?>
                <a href="/repuestos/<?= htmlspecialchars($product['slug']) ?>" class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl border border-gray-100 transition-all duration-300 animate-fade-in-up flex flex-col" style="animation-delay: <?= $index * 100 ?>ms;">
                    <div class="relative bg-gray-100 overflow-hidden border-b border-gray-100 aspect-w-4 aspect-h-3">
                        <img src="<?= htmlspecialchars($product['main_image']) ?>" alt="<?= htmlspecialchars($product['image_alt'] ?: $product['title']) ?>" loading="lazy" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <?php if(!empty($product['category_name'])): ?>
                            <span class="inline-block text-[10px] font-black uppercase tracking-wider text-primary mb-2"><?= htmlspecialchars($product['category_name']) ?></span>
                        <?php endif; ?>
                        <h2 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-primary transition-colors"><?= htmlspecialchars($product['title']) ?></h2>
                        <p class="text-gray-500 text-sm line-clamp-2 mb-4 flex-1"><?= htmlspecialchars($product['description']) ?></p>
                        <div class="flex items-center text-sm font-bold text-primary group-hover:text-secondary transition-colors mt-auto pt-4 border-t border-gray-100/50">
                            Ver detalles
                            <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full text-center py-20 bg-white rounded-3xl border border-gray-100 shadow-sm p-8 max-w-xl mx-auto">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <p class="text-gray-500 text-lg mb-4">No se encontraron repuestos activos en esta categoría.</p>
                    <a href="/repuestos" class="inline-flex items-center px-6 py-2.5 bg-primary hover:bg-secondary text-white font-bold rounded-xl transition-colors text-sm shadow-md">
                        Ver todos los repuestos
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php $this->component('footer'); ?>
