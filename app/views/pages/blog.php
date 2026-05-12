<?php $this->component('header', ['title' => $title ?? 'Blog']); ?>
<?php $this->component('navbar'); ?>

<?php
function formatBlogDate($dateString) {
    if (empty($dateString)) return '';
    $timestamp = strtotime($dateString);
    $months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    $day = date('d', $timestamp);
    $monthIndex = (int)date('m', $timestamp) - 1;
    $year = date('Y', $timestamp);
    return "$day de {$months[$monthIndex]}, $year";
}
?>

<main class="min-h-screen bg-gray-50 pt-28 pb-32">
    <div class="container mx-auto px-4">
        
        <!-- Encabezado Superior Directo -->
        <div class="mb-12 animate-fade-in-up">
            <div class="max-w-3xl">
                <span class="text-xs font-black uppercase tracking-widest text-secondary block mb-3">
                    <?= htmlspecialchars($settings['blog_page_tagline'] ?? 'Conocimiento & Vanguardia') ?>
                </span>
                <h1 class="text-4xl md:text-6xl font-black text-primary mb-4 leading-tight">
                    <?= htmlspecialchars($settings['blog_page_title'] ?? 'Blog Corporativo') ?>
                </h1>
                <p class="text-lg text-gray-600 leading-relaxed">
                    <?= htmlspecialchars($settings['blog_page_description'] ?? 'Últimas noticias, artículos estratégicos y tendencias.') ?>
                </p>
            </div>
        </div>

        <!-- Layout Principal: Grid de Contenido + Sidebar -->
        <div class="flex flex-col lg:flex-row gap-12 relative">
            
            <!-- COLUMNA IZQUIERDA: ARTÍCULOS (Crece dinámicamente) -->
            <div class="flex-1">
                
                <!-- Indicador de filtros activos si existen -->
                <?php if($search || $activeCategory): ?>
                    <div class="flex flex-wrap items-center gap-3 mb-8 animate-fade-in-up">
                        <span class="text-sm font-bold text-gray-400">Filtrado por:</span>
                        <?php if($activeCategory): ?>
                            <span class="bg-indigo-50 text-indigo-700 text-xs font-bold px-4 py-2 rounded-full border border-indigo-100 flex items-center gap-2">
                                Categoria: <?= htmlspecialchars($categoryData['name'] ?? '') ?>
                                <a href="<?= url('blog') . ($search ? '?s='.urlencode($search) : '') ?>" class="hover:text-indigo-900"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></a>
                            </span>
                        <?php endif; ?>
                        <?php if($search): ?>
                            <span class="bg-secondary/10 text-secondary text-xs font-bold px-4 py-2 rounded-full border border-secondary/20 flex items-center gap-2">
                                Término: "<?= htmlspecialchars($search) ?>"
                                <a href="<?= url('blog') . ($activeCategory ? '?categoria='.urlencode($activeCategory) : '') ?>" class="hover:text-primary"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></a>
                            </span>
                        <?php endif; ?>
                        <a href="<?= url('blog') ?>" class="text-xs font-bold text-gray-500 underline underline-offset-4 hover:text-primary transition-colors ml-2">Limpiar todos</a>
                    </div>
                <?php endif; ?>

                <?php if(!empty($posts)): ?>
                    <?php 
                        // Remove special featured layout, render all in uniform grid
                        $others = $posts;
                    ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                        <!-- Resto de Artículos -->
                        <?php foreach($others as $index => $post): ?>
                            <article class="post-card bg-white rounded-[2rem] overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 border border-gray-100/80 flex flex-col animate-fade-in-up" style="animation-delay: <?= ($index % 4) * 100 ?>ms;">
                                <div class="h-56 relative overflow-hidden group">
                                    <?php if(!empty($post['image'])): ?>
                                        <img src="<?= asset($post['image']) ?>" alt="<?= htmlspecialchars($post['image_alt'] ?: $post['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    <?php else: ?>
                                        <div class="w-full h-full bg-primary/5 flex items-center justify-center text-gray-300">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="p-6 md:p-8 flex flex-col flex-grow">
                                    <div class="flex items-center gap-3 mb-4 text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                                        <span class="text-primary font-extrabold"><?= htmlspecialchars($post['category_name'] ?? 'General') ?></span>
                                        <span>&bull;</span>
                                        <span><?= formatBlogDate($post['published_at']) ?></span>
                                    </div>
                                    <h2 class="text-xl font-extrabold text-gray-900 mb-3 hover:text-secondary transition-colors leading-snug">
                                        <a href="<?= url('blog/' . $post['slug']) ?>"><?= htmlspecialchars($post['title']) ?></a>
                                    </h2>
                                    <p class="text-gray-500 mb-6 line-clamp-3 leading-relaxed text-sm"><?= htmlspecialchars($post['excerpt']) ?></p>
                                    <a href="<?= url('blog/' . $post['slug']) ?>" class="inline-flex items-center text-sm font-bold text-secondary hover:text-primary transition-colors mt-auto group">
                                        <span>Ver más</span>
                                        <svg class="w-4 h-4 ml-1.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>

                <?php else: ?>
                    <!-- Empty State -->
                    <div class="flex flex-col items-center justify-center py-24 text-center bg-white rounded-[2rem] border border-gray-100 shadow-sm animate-fade-in-up">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center text-gray-300 mb-6">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <h2 class="text-2xl font-black text-gray-900 mb-2">No encontramos lo que buscas</h2>
                        <p class="text-gray-500 max-w-sm mb-8">Intenta con otras palabras clave o cambia la categoría del filtro.</p>
                        <a href="<?= url('blog') ?>" class="px-8 py-4 bg-primary text-white text-sm font-bold rounded-xl hover:bg-secondary transition-all shadow-lg shadow-primary/20">Mostrar todos los artículos</a>
                    </div>
                <?php endif; ?>

            </div>

            <!-- COLUMNA DERECHA: SIDEBAR (Desktop ONLY) -->
            <aside class="hidden lg:block w-80 flex-shrink-0 relative">
                <div class="sticky top-32 space-y-8">
                    
                    <!-- Módulo Buscador -->
                    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100">
                        <h2 class="text-sm font-black text-gray-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            Buscar Artículo
                        </h2>
                        <form action="<?= url('blog') ?>" method="GET" class="relative">
                            <?php if($activeCategory): ?>
                                <input type="hidden" name="categoria" value="<?= htmlspecialchars($activeCategory) ?>">
                            <?php endif; ?>
                            <input type="text" name="s" value="<?= htmlspecialchars($search ?? '') ?>" placeholder="Ingresa una palabra..." class="w-full px-5 py-3.5 pr-12 bg-gray-50 rounded-xl border border-gray-100 focus:bg-white focus:border-secondary focus:ring-2 focus:ring-secondary/10 text-sm font-medium transition-all">
                            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-secondary transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                        </form>
                    </div>

                    <!-- Módulo Categorías -->
                    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100">
                        <h2 class="text-sm font-black text-gray-900 uppercase tracking-wider mb-5 flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                            Categorías
                        </h2>
                        <div class="flex flex-col gap-2">
                            <a href="<?= url('blog') . ($search ? '?s='.urlencode($search) : '') ?>" 
                               class="group flex items-center justify-between px-4 py-3.5 rounded-xl text-sm font-bold transition-all <?= !$activeCategory ? 'bg-primary text-white shadow-md shadow-primary/20' : 'text-gray-600 hover:bg-gray-50 hover:text-primary' ?>">
                                <span>Todas las noticias</span>
                                <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 <?= !$activeCategory ? 'opacity-100' : '' ?> transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                            <?php if(!empty($categories)): ?>
                                <?php foreach($categories as $cat): ?>
                                    <?php 
                                        $catUrl = url('blog') . '?categoria=' . htmlspecialchars($cat['slug']);
                                        if($search) {
                                            $catUrl .= '&s=' . urlencode($search);
                                        }
                                        $isAct = ($activeCategory === $cat['slug']);
                                    ?>
                                    <a href="<?= $catUrl ?>" 
                                       class="group flex items-center justify-between px-4 py-3.5 rounded-xl text-sm font-bold transition-all <?= $isAct ? 'bg-secondary text-white shadow-md shadow-secondary/20' : 'text-gray-600 hover:bg-gray-50 hover:text-secondary border border-transparent' ?>">
                                        <span><?= htmlspecialchars($cat['name']) ?></span>
                                        <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 <?= $isAct ? 'opacity-100' : '' ?> transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- CTA Banner Lateral -->
                    <div class="bg-gradient-to-br from-primary to-indigo-900 p-8 rounded-[2rem] text-white text-center relative overflow-hidden shadow-xl">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -mr-10 -mt-10"></div>
                        <h2 class="text-lg font-black mb-3 relative z-10"><?= htmlspecialchars($settings['blog_sidebar_cta_title'] ?? '¿Tienes un proyecto en mente?') ?></h2>
                        <p class="text-xs text-indigo-100 mb-6 leading-relaxed relative z-10"><?= htmlspecialchars($settings['blog_sidebar_cta_description'] ?? 'Impulsamos tu transformación digital con tecnología premium.') ?></p>
                        <a href="<?= url('contacto') ?>" class="relative z-10 inline-block bg-white text-primary px-6 py-3 rounded-xl font-extrabold text-sm hover:bg-secondary hover:text-white transition-all shadow-md"><?= htmlspecialchars($settings['blog_sidebar_cta_btn_text'] ?? 'Contáctanos') ?></a>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</main>

<!-- BOTÓN FLOTANTE MÓVIL (FAB) -->
<button onclick="toggleFilterDrawer(true)" class="lg:hidden fixed bottom-28 right-6 z-40 w-16 h-16 bg-primary text-white rounded-full shadow-2xl flex items-center justify-center group hover:scale-110 active:scale-95 transition-transform duration-300">
    <?php if($search || $activeCategory): ?>
        <span class="absolute -top-1 right-0 w-4 h-4 bg-secondary rounded-full border-2 border-white shadow-sm animate-pulse"></span>
    <?php endif; ?>
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
</button>

<!-- CAJÓN (DRAWER) DE FILTROS MÓVIL -->
<div id="filter-drawer-backdrop" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm z-50 hidden transition-opacity duration-300 opacity-0" onclick="toggleFilterDrawer(false)"></div>
<div id="filter-drawer" class="fixed inset-y-0 right-0 w-80 max-w-[85vw] bg-white z-50 transform translate-x-full transition-transform duration-300 ease-in-out shadow-2xl flex flex-col">
    
    <!-- Drawer Header -->
    <div class="p-6 border-b border-gray-100 flex items-center justify-between bg-gray-50">
        <h2 class="text-lg font-black text-gray-900">Buscador & Filtros</h2>
        <button onclick="toggleFilterDrawer(false)" class="text-gray-400 hover:text-gray-600 p-2 bg-white rounded-lg border border-gray-100">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <!-- Drawer Content (Scrollable) -->
    <div class="p-6 flex-1 overflow-y-auto space-y-8">
        
        <!-- Mobile Search -->
        <div>
            <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">¿Qué buscas?</h3>
            <form action="<?= url('blog') ?>" method="GET" class="relative">
                <?php if($activeCategory): ?>
                    <input type="hidden" name="categoria" value="<?= htmlspecialchars($activeCategory) ?>">
                <?php endif; ?>
                <input type="text" name="s" value="<?= htmlspecialchars($search ?? '') ?>" placeholder="Escribe aquí..." class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:bg-white focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all text-sm font-bold">
                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 bg-primary text-white rounded-xl flex items-center justify-center shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </form>
        </div>

        <!-- Mobile Categories -->
        <div>
            <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Categorías</h3>
            <div class="grid grid-cols-1 gap-2">
                <a href="<?= url('blog') . ($search ? '?s='.urlencode($search) : '') ?>" 
                   class="px-5 py-3.5 rounded-xl text-sm font-extrabold border transition-all flex items-center justify-between <?= !$activeCategory ? 'bg-primary text-white border-primary shadow-lg' : 'bg-white text-gray-600 border-gray-100 active:bg-gray-50' ?>">
                    <span>Todas</span>
                    <?php if(!$activeCategory): ?> <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> <?php endif; ?>
                </a>
                <?php if(!empty($categories)): ?>
                    <?php foreach($categories as $cat): ?>
                        <?php 
                            $mCatUrl = url('blog') . '?categoria=' . htmlspecialchars($cat['slug']);
                            if($search) $mCatUrl .= '&s=' . urlencode($search);
                            $mIsAct = ($activeCategory === $cat['slug']);
                        ?>
                        <a href="<?= $mCatUrl ?>" 
                           class="px-5 py-3.5 rounded-xl text-sm font-extrabold border transition-all flex items-center justify-between <?= $mIsAct ? 'bg-secondary text-white border-secondary shadow-lg' : 'bg-white text-gray-600 border-gray-100 active:bg-gray-50' ?>">
                            <span><?= htmlspecialchars($cat['name']) ?></span>
                            <?php if($mIsAct): ?> <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Footer Drawer -->
    <div class="p-6 border-t border-gray-100 bg-gray-50 mt-auto">
        <a href="<?= url('blog') ?>" class="w-full block text-center py-3.5 border border-gray-200 text-gray-500 rounded-xl font-bold text-sm active:bg-white">Reiniciar Filtros</a>
    </div>
</div>

<script>
const drawer = document.getElementById('filter-drawer');
const backdrop = document.getElementById('filter-drawer-backdrop');

function toggleFilterDrawer(open) {
    if (open) {
        backdrop.classList.remove('hidden');
        setTimeout(() => {
            backdrop.classList.remove('opacity-0');
            drawer.classList.remove('translate-x-full');
        }, 10);
        document.body.style.overflow = 'hidden';
    } else {
        backdrop.classList.add('opacity-0');
        drawer.classList.add('translate-x-full');
        setTimeout(() => {
            backdrop.classList.add('hidden');
        }, 300);
        document.body.style.overflow = '';
    }
}
</script>

<?php $this->component('footer'); ?>
