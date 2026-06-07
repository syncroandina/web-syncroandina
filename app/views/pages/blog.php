<?php $this->component('header', ['title' => $title ?? 'Blog']); ?>
<?php $this->component('navbar'); ?>

<?php
if (!function_exists('formatBlogDate')) {
    function formatBlogDate($dateString) {
        if (empty($dateString)) return '';
        $timestamp = strtotime($dateString);
        $months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $day = date('d', $timestamp);
        $monthIndex = (int)date('m', $timestamp) - 1;
        $year = date('Y', $timestamp);
        return "$day de {$months[$monthIndex]}, $year";
    }
}
?>

<style>
  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(30px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }

  @keyframes scaleIn {
    from {
      opacity: 0;
      transform: scale(0.96);
    }
    to {
      opacity: 1;
      transform: scale(1);
    }
  }

  .animate-fade-in-up {
    animation: fadeInUp 0.9s cubic-bezier(0.16, 1, 0.3, 1) both;
  }

  .animate-fade-in {
    animation: fadeIn 1.2s cubic-bezier(0.16, 1, 0.3, 1) both;
  }

  .animate-scale-in {
    animation: scaleIn 1s cubic-bezier(0.16, 1, 0.3, 1) both;
  }

  .delay-100 { animation-delay: 100ms; }
  .delay-200 { animation-delay: 200ms; }
  .delay-300 { animation-delay: 300ms; }

  /* Degradado Mesh sutil de fondo */
  .hero-mesh-bg {
    background-image: 
      radial-gradient(at 0% 0%, rgba(59, 130, 246, 0.03) 0, transparent 50%), 
      radial-gradient(at 100% 0%, rgba(13, 148, 136, 0.02) 0, transparent 50%),
      radial-gradient(at 50% 100%, rgba(243, 244, 246, 0.4) 0, transparent 70%);
  }

  /* Sombra flotante e interactiva premium */
  .interactive-shadow {
    box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.04);
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  }
  .interactive-shadow:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.08);
  }
</style>

<main class="min-h-screen bg-[#F8FAFC] pb-24">
    <!-- Hero / Cabecera de la Página de Blog con Mesh Gradient -->
    <header class="bg-white hero-mesh-bg pt-32 pb-16 border-b border-gray-100 relative overflow-hidden">
        <div class="absolute inset-0 bg-grid-slate-100 [mask-image:linear-gradient(0deg,white,transparent)] opacity-30"></div>
        <div class="container mx-auto px-4 max-w-4xl relative z-10 text-center">
            <div class="animate-fade-in-up">
                <span class="px-4 py-1.5 bg-secondary/10 text-secondary rounded-full font-black text-[10px] tracking-widest uppercase border border-secondary/5 mb-4 inline-block">
                    <?= html_entity_decode(htmlspecialchars_decode($settings['blog_page_tagline'] ?? 'Conocimiento & Vanguardia'), ENT_QUOTES, 'UTF-8') ?>
                </span>
                <h1 class="text-3xl md:text-5xl font-black text-gray-900 mb-6 leading-[1.15] tracking-tight max-w-3xl mx-auto">
                    <?= html_entity_decode(htmlspecialchars_decode($settings['blog_page_title'] ?? 'Blog Corporativo'), ENT_QUOTES, 'UTF-8') ?>
                </h1>
                <p class="text-base md:text-lg text-gray-500 leading-relaxed max-w-3xl mx-auto">
                    <?= html_entity_decode(htmlspecialchars_decode($settings['blog_page_description'] ?? 'Últimas noticias, artículos estratégicos y tendencias.'), ENT_QUOTES, 'UTF-8') ?>
                </p>
            </div>
        </div>
    </header>

    <!-- Layout Principal: Grid de Contenido + Sidebar -->
    <div class="container mx-auto px-4 mt-16">
        <div class="flex flex-col lg:flex-row gap-12 relative">
            
            <!-- COLUMNA IZQUIERDA: ARTÍCULOS (Crece dinámicamente) -->
            <div class="flex-1">
                
                <?php if(!empty($posts)): ?>
                    <?php 
                        // Determinar si hay un filtro o búsqueda activa
                        $hasFilter = !empty($search) || !empty($activeCategory);
                        
                        // Si no hay filtros, el primer artículo se destaca
                        if (!$hasFilter && count($posts) > 0) {
                            $featuredPost = $posts[0];
                            $others = array_slice($posts, 1);
                        } else {
                            $featuredPost = null;
                            $others = $posts;
                        }
                    ?>

                    <?php if ($featuredPost): ?>
                        <!-- Artículo Destacado Premium (Featured Post Layout) -->
                        <article class="featured-post bg-white rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 border border-gray-100/80 mb-12 animate-fade-in-up">
                            <div class="grid grid-cols-1 lg:grid-cols-12">
                                <!-- Imagen Destacada (7 columnas en LG) -->
                                <div class="lg:col-span-7 relative h-72 sm:h-96 lg:h-auto min-h-[340px] overflow-hidden group">
                                    <?php if(!empty($featuredPost['image'])): ?>
                                        <img src="<?= asset($featuredPost['image']) ?>" alt="<?= htmlspecialchars($featuredPost['image_alt'] ?: $featuredPost['title']) ?>" fetchpriority="high" class="w-full h-full object-cover lg:absolute lg:inset-0 group-hover:scale-103 transition-transform duration-700 ease-out">
                                    <?php else: ?>
                                        <div class="w-full h-full bg-primary/5 flex items-center justify-center text-gray-300 lg:absolute lg:inset-0">
                                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <!-- Contenido Destacado (5 columnas en LG) -->
                                <div class="lg:col-span-5 p-8 md:p-10 lg:p-12 flex flex-col justify-center">
                                    <div class="flex items-center gap-3 mb-6 text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                                        <span class="text-secondary bg-secondary/10 px-3 py-1.5 rounded-full font-black border border-secondary/5">
                                            <?= htmlspecialchars(html_entity_decode(htmlspecialchars_decode($featuredPost['category_name'] ?? 'General'), ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8') ?>
                                        </span>
                                        <span>&bull;</span>
                                        <span><?= formatBlogDate($featuredPost['published_at']) ?></span>
                                    </div>
                                    <h2 class="text-2xl md:text-3xl font-black text-gray-900 mb-4 hover:text-secondary transition-colors leading-tight tracking-tight">
                                        <a href="<?= url('blog/' . $featuredPost['slug']) ?>">
                                            <?= htmlspecialchars(html_entity_decode(htmlspecialchars_decode($featuredPost['title']), ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8') ?>
                                        </a>
                                    </h2>
                                    <p class="text-gray-500 mb-8 line-clamp-4 leading-relaxed text-sm">
                                        <?= htmlspecialchars(html_entity_decode(htmlspecialchars_decode($featuredPost['excerpt']), ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8') ?>
                                    </p>
                                    <a href="<?= url('blog/' . $featuredPost['slug']) ?>" class="inline-flex items-center text-xs font-bold text-secondary hover:text-primary transition-colors mt-auto group uppercase tracking-wider">
                                        <span>Leer Artículo Completo</span>
                                        <svg class="w-4 h-4 ml-1.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php endif; ?>

                    <!-- Grid de Artículos Secundarios -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <?php foreach($others as $index => $post): ?>
                            <article class="post-card bg-white rounded-[2rem] overflow-hidden border border-gray-100/80 flex flex-col interactive-shadow animate-fade-in-up" style="animation-delay: <?= ($index % 4) * 100 ?>ms;">
                                <div class="h-56 relative overflow-hidden group">
                                    <?php if(!empty($post['image'])): ?>
                                        <img src="<?= asset($post['image']) ?>" alt="<?= htmlspecialchars($post['image_alt'] ?: $post['title']) ?>" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    <?php else: ?>
                                        <div class="w-full h-full bg-primary/5 flex items-center justify-center text-gray-300">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="p-6 md:p-8 flex flex-col flex-grow">
                                    <div class="flex items-center gap-3 mb-4 text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                                        <span class="text-primary font-black bg-primary/5 px-3 py-1 rounded-full border border-primary/5">
                                            <?= htmlspecialchars(html_entity_decode(htmlspecialchars_decode($post['category_name'] ?? 'General'), ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8') ?>
                                        </span>
                                        <span>&bull;</span>
                                        <span><?= formatBlogDate($post['published_at']) ?></span>
                                    </div>
                                    <h2 class="text-lg font-extrabold text-gray-900 mb-3 hover:text-secondary transition-colors leading-snug">
                                        <a href="<?= url('blog/' . $post['slug']) ?>">
                                            <?= htmlspecialchars(html_entity_decode(htmlspecialchars_decode($post['title']), ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8') ?>
                                        </a>
                                    </h2>
                                    <p class="text-gray-500 mb-6 line-clamp-3 leading-relaxed text-sm">
                                        <?= htmlspecialchars(html_entity_decode(htmlspecialchars_decode($post['excerpt']), ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8') ?>
                                    </p>
                                    <a href="<?= url('blog/' . $post['slug']) ?>" class="inline-flex items-center text-xs font-bold text-secondary hover:text-primary transition-colors mt-auto group uppercase tracking-wider">
                                        <span>Ver más</span>
                                        <svg class="w-4 h-4 ml-1.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>

                <?php else: ?>
                    <!-- Empty State -->
                    <div class="flex flex-col items-center justify-center py-24 text-center bg-white rounded-[2.5rem] border border-slate-200/60 shadow-sm animate-fade-in-up">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-350 mb-6">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-black text-gray-900 mb-2">No encontramos lo que buscas</h3>
                        <p class="text-gray-500 max-w-sm mb-8">Intenta con otras palabras clave o cambia la categoría del filtro.</p>
                        <a href="<?= url('blog') ?>" class="px-8 py-4 bg-primary text-white text-xs font-bold rounded-xl hover:bg-secondary transition-all shadow-lg shadow-primary/20 uppercase tracking-wider">Mostrar todos los artículos</a>
                    </div>
                <?php endif; ?>

            </div>

            <!-- COLUMNA DERECHA: SIDEBAR (Desktop ONLY) -->
            <aside class="hidden lg:block w-80 flex-shrink-0 relative">
                <div class="sticky top-32 space-y-8">
                    
                    <!-- Módulo Categorías -->
                    <div class="bg-white p-7 rounded-[2.25rem] shadow-sm border border-slate-200/60">
                        <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest mb-5 flex items-center gap-2">
                            <span class="w-1.5 h-3 bg-primary rounded-full"></span>
                            Categorías
                        </h3>
                        <div class="flex flex-col gap-2">
                            <a href="<?= url('blog') ?>" 
                               onclick="window.location.href='<?= url('blog') ?>?r=' + Math.random(); return false;"
                               class="group flex items-center justify-between px-4 py-3.5 rounded-xl text-sm font-bold transition-all border <?= !$activeCategory ? 'bg-primary text-white border-primary shadow-md shadow-primary/20' : 'text-gray-600 border-slate-100 hover:bg-slate-50 hover:text-primary' ?> cursor-pointer">
                                <span class="pointer-events-none">Todas las noticias</span>
                                <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 <?= !$activeCategory ? 'opacity-100' : '' ?> transition-all pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                            <?php if(!empty($categories)): ?>
                                <?php foreach($categories as $cat): ?>
                                    <?php 
                                        $catUrl = url('blog') . '?categoria=' . htmlspecialchars($cat['slug']);
                                        $isAct = ($activeCategory === $cat['slug']);
                                    ?>
                                    <a href="<?= $catUrl ?>" 
                                       onclick="window.location.href='<?= $catUrl ?>&r=' + Math.random(); return false;"
                                       class="group flex items-center justify-between px-4 py-3.5 rounded-xl text-sm font-bold transition-all border <?= $isAct ? 'bg-secondary text-white border-secondary shadow-md shadow-secondary/20' : 'text-gray-600 border-slate-100 hover:bg-slate-50 hover:text-secondary' ?> cursor-pointer">
                                        <span class="pointer-events-none"><?= htmlspecialchars($cat['name']) ?></span>
                                        <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 <?= $isAct ? 'opacity-100' : '' ?> transition-all pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Filtros Activos Widget -->
                    <?php if($activeCategory): ?>
                        <div class="bg-white p-7 rounded-[2.25rem] shadow-sm border border-slate-200/60 animate-fade-in-up">
                            <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <span class="w-1.5 h-3 bg-secondary rounded-full"></span>
                                Filtro Activo
                            </h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between bg-red-50/50 border border-red-100/80 px-4 py-3.5 rounded-xl">
                                    <span class="text-[10px] font-black text-red-750 uppercase tracking-wider leading-relaxed pointer-events-none">
                                        Categoría: <?= htmlspecialchars($categoryData['name'] ?? '') ?>
                                    </span>
                                    <a href="<?= url('blog') ?>" onclick="window.location.href='<?= url('blog') ?>?r=' + Math.random(); return false;" class="text-red-400 hover:text-red-700 transition-colors p-1.5 bg-white hover:bg-red-100 rounded-lg shadow-sm border border-red-100 flex items-center justify-center cursor-pointer" title="Eliminar filtro">
                                        <svg class="w-3.5 h-3.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </a>
                                </div>
                                <a href="<?= url('blog') ?>" onclick="window.location.href='<?= url('blog') ?>?r=' + Math.random(); return false;" class="block text-center py-3.5 border border-dashed border-red-200 text-red-500 hover:bg-red-50 hover:border-red-400 rounded-xl font-bold text-xs transition-all uppercase tracking-wider cursor-pointer">
                                    <span class="pointer-events-none">Limpiar filtro</span>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- CTA Banner Lateral Premium (Unificado al del detalle) -->
                    <div class="bg-slate-900 rounded-[2.25rem] p-8 text-white relative overflow-hidden shadow-2xl shadow-slate-900/20 group border border-white/5">
                        <div class="absolute -top-24 -left-24 w-48 h-48 bg-primary/20 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-1000"></div>
                        <div class="absolute -bottom-24 -right-24 w-48 h-48 bg-secondary/20 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-1000"></div>
                        
                        <div class="relative z-10">
                            <span class="text-[9px] font-black uppercase tracking-widest text-secondary bg-secondary/10 px-3 py-1.5 rounded-full inline-block mb-4 border border-secondary/10">¿Hablamos?</span>
                            <h3 class="text-xl font-extrabold mb-3 leading-tight tracking-tight">
                                <?= html_entity_decode(htmlspecialchars_decode($settings['blog_sidebar_cta_title'] ?? '¿Tienes un proyecto en mente?'), ENT_QUOTES, 'UTF-8') ?>
                            </h3>
                            <p class="text-xs text-slate-400 mb-6 leading-relaxed">
                                <?= html_entity_decode(htmlspecialchars_decode($settings['blog_sidebar_cta_description'] ?? 'Impulsamos tu transformación digital con tecnología premium.'), ENT_QUOTES, 'UTF-8') ?>
                            </p>
                            
                            <a href="<?= url('contacto') ?>" 
                               id="blog-sidebar-cta-btn"
                               data-subject="Consulta desde el Blog: <?= htmlspecialchars($settings['blog_sidebar_cta_title'] ?? '¿Tienes un proyecto en mente?', ENT_QUOTES, 'UTF-8') ?>"
                               onclick="try { if (typeof openContactModal === 'function') { openContactModal(this.getAttribute('data-subject')); return false; } } catch(e) { console.error(e); } window.location.href=this.href; return false;"
                               class="w-full py-4 px-4 bg-white hover:bg-secondary text-slate-900 hover:text-white font-bold text-xs rounded-xl transition-all duration-300 flex items-center justify-center gap-2 shadow-lg shadow-white/5 hover:shadow-secondary/30 group">
                                <span class="pointer-events-none"><?= html_entity_decode(htmlspecialchars_decode($settings['blog_sidebar_cta_btn_text'] ?? 'Contáctanos'), ENT_QUOTES, 'UTF-8') ?></span>
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</main>

<!-- BOTÓN FLOTANTE MÓVIL (FAB) -->
<button onclick="toggleFilterDrawer(true)" class="lg:hidden fixed bottom-28 right-6 z-40 w-16 h-16 bg-primary text-white rounded-full shadow-2xl flex items-center justify-center group hover:scale-110 active:scale-95 transition-transform duration-300 cursor-pointer">
    <?php if($search || $activeCategory): ?>
        <span class="absolute -top-1 right-0 w-4 h-4 bg-secondary rounded-full border-2 border-white shadow-sm animate-pulse pointer-events-none"></span>
    <?php endif; ?>
    <svg class="w-6 h-6 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
</button>

<!-- CAJÓN (DRAWER) DE FILTROS MÓVIL -->
<div id="filter-drawer-backdrop" class="fixed inset-0 bg-gray-900/60 backdrop-blur-md z-50 hidden transition-opacity duration-300 opacity-0" onclick="toggleFilterDrawer(false)"></div>
<div id="filter-drawer" class="fixed inset-y-0 right-0 w-80 max-w-[85vw] bg-white z-50 transform translate-x-full transition-transform duration-300 ease-in-out shadow-2xl flex flex-col rounded-l-[2rem]">
    
    <!-- Drawer Header -->
    <div class="p-6 border-b border-gray-100 flex items-center justify-between bg-gray-50 rounded-tl-[2rem]">
        <h3 class="text-lg font-black text-gray-900">Buscador &amp; Filtros</h3>
        <button onclick="toggleFilterDrawer(false)" class="text-gray-400 hover:text-gray-600 p-2 bg-white rounded-lg border border-gray-100 cursor-pointer">
            <svg class="w-5 h-5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <!-- Drawer Content (Scrollable) -->
    <div class="p-6 flex-1 overflow-y-auto space-y-8">
        <!-- Mobile Categories -->
        <div>
            <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Categorías</h3>
            <div class="grid grid-cols-1 gap-2">
                <a href="<?= url('blog') ?>" 
                   onclick="window.location.href='<?= url('blog') ?>?r=' + Math.random(); return false;"
                   class="px-5 py-3.5 rounded-xl text-sm font-extrabold border transition-all flex items-center justify-between <?= !$activeCategory ? 'bg-primary text-white border-primary shadow-lg shadow-primary/25' : 'bg-white text-gray-600 border-slate-100 active:bg-slate-50' ?> cursor-pointer">
                    <span class="pointer-events-none">Todas</span>
                    <?php if(!$activeCategory): ?> <svg class="w-4 h-4 pointer-events-none" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> <?php endif; ?>
                </a>
                <?php if(!empty($categories)): ?>
                    <?php foreach($categories as $cat): ?>
                        <?php 
                            $mCatUrl = url('blog') . '?categoria=' . htmlspecialchars($cat['slug']);
                            $mIsAct = ($activeCategory === $cat['slug']);
                        ?>
                        <a href="<?= $mCatUrl ?>" 
                           onclick="window.location.href='<?= $mCatUrl ?>&r=' + Math.random(); return false;"
                           class="px-5 py-3.5 rounded-xl text-sm font-extrabold border transition-all flex items-center justify-between <?= $mIsAct ? 'bg-secondary text-white border-secondary shadow-lg shadow-secondary/25' : 'bg-white text-gray-600 border-slate-100 active:bg-slate-50' ?> cursor-pointer">
                            <span class="pointer-events-none"><?= htmlspecialchars($cat['name']) ?></span>
                            <?php if($mIsAct): ?> <svg class="w-4 h-4 pointer-events-none" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Footer Drawer -->
    <div class="p-6 border-t border-gray-100 bg-gray-50 mt-auto rounded-bl-[2rem]">
        <a href="<?= url('blog') ?>" onclick="window.location.href='<?= url('blog') ?>?r=' + Math.random(); return false;" class="w-full block text-center py-3.5 border border-slate-200 text-slate-500 rounded-xl font-bold text-sm bg-white hover:bg-slate-50 cursor-pointer transition-colors">Reiniciar Filtros</a>
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

// Panel de Diagnóstico Opcional via ?debug=1
if (window.location.search.includes('debug=1')) {
    (function() {
        const diag = document.createElement('div');
        diag.id = 'js-diagnostics';
        diag.style.position = 'fixed';
        diag.style.bottom = '20px';
        diag.style.left = '20px';
        diag.style.backgroundColor = 'rgba(15, 23, 42, 0.95)';
        diag.style.color = '#f8fafc';
        diag.style.padding = '16px';
        diag.style.borderRadius = '16px';
        diag.style.fontSize = '12px';
        diag.style.fontFamily = 'monospace';
        diag.style.zIndex = '999999';
        diag.style.maxWidth = '380px';
        diag.style.boxShadow = '0 20px 25px -5px rgba(0,0,0,0.5)';
        diag.style.border = '1px solid rgba(255,255,255,0.1)';
        diag.style.backdropFilter = 'blur(8px)';
        diag.innerHTML = '<div style="font-weight:bold;color:#3b82f6;margin-bottom:8px;display:flex;justify-content:space-between;align-items:center;"><span>🛠️ DIAGNÓSTICO EN TIEMPO REAL</span><span style="font-size:10px;background:#1e293b;padding:2px 6px;border-radius:4px;">DEBUG</span></div><div id="diag-log" style="max-height:200px;overflow-y:auto;line-height:1.4;">Panel de depuración cargado. Haga clic en los botones para ver el comportamiento.</div>';
        document.body.appendChild(diag);

        window.logDiag = function(msg, isError = false) {
            const log = document.getElementById('diag-log');
            if (log) {
                const time = new Date().toLocaleTimeString();
                log.innerHTML = `<div style="margin-bottom:4px;"><span style="color:#94a3b8;font-size:10px;">[${time}]</span> <span style="color:${isError ? '#ef4444' : '#10b981'}">${isError ? '❌' : 'ℹ️'} ${msg}</span></div>` + log.innerHTML;
            }
        };

        window.onerror = function(message, source, lineno, colno, error) {
            window.logDiag(`${message} (${source.split('/').pop()}:${lineno})`, true);
            return false;
        };

        window.logDiag('Sistema de diagnóstico inicializado.');
    })();
}

// Inicialización robusta del botón de llamada a la acción (CTA) del blog con try-catch fallback
function initBlogSidebarCta() {
    const ctaBtn = document.getElementById('blog-sidebar-cta-btn');
    if (ctaBtn) {
        ctaBtn.addEventListener('click', (e) => {
            const subject = ctaBtn.getAttribute('data-subject') || '';
            if (typeof window.logDiag === 'function') window.logDiag('Botón Contáctanos clickeado. Asunto: ' + subject);
            
            if (typeof openContactModal === 'function') {
                e.preventDefault();
                try {
                    if (typeof window.logDiag === 'function') window.logDiag('Intentando abrir contact_modal...');
                    openContactModal(subject);
                    if (typeof window.logDiag === 'function') window.logDiag('Modal abierto con éxito.');
                } catch (err) {
                    console.error('Error al abrir modal, redirigiendo a la página de contacto:', err);
                    if (typeof window.logDiag === 'function') window.logDiag('Error modal: ' + err.message + '. Redirigiendo...', true);
                    window.location.href = ctaBtn.href;
                }
            } else {
                if (typeof window.logDiag === 'function') window.logDiag('openContactModal no está definida. Redirigiendo...', true);
                // Si no existe la función, dejamos que ocurra la redirección nativa
            }
        });
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initBlogSidebarCta);
} else {
    initBlogSidebarCta();
}
</script>

<?php $this->component('contact_modal'); ?>
<?php $this->component('footer'); ?>
