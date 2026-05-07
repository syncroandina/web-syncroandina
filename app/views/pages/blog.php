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

<main class="min-h-screen bg-gray-50 pt-32 pb-32">
    <div class="container mx-auto px-4">
        <!-- Encabezado con animaciones Premium -->
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6 animate-fade-in-up">
            <div class="max-w-2xl">
                <span class="text-xs font-black uppercase tracking-widest text-secondary block mb-3"><?= htmlspecialchars($settings['blog_page_tagline'] ?? 'Conocimiento & Vanguardia') ?></span>
                <h1 class="text-4xl md:text-6xl font-black text-primary mb-4 leading-tight"><?= htmlspecialchars($settings['blog_page_title'] ?? 'Blog Corporativo') ?></h1>
                <p class="text-lg text-gray-600 leading-relaxed"><?= htmlspecialchars($settings['blog_page_description'] ?? 'Últimas noticias, artículos estratégicos y tendencias sobre innovación, software a medida y modernización cloud.') ?></p>
            </div>
            <div class="w-full md:w-auto">
                <div class="relative group">
                    <input type="text" id="blog-search" onkeyup="filterPosts(this.value)" placeholder="Buscar artículos..." class="w-full md:w-80 pl-12 pr-4 py-4 rounded-2xl border-none shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary transition-all bg-white group-hover:shadow-md">
                    <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2 group-hover:text-secondary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
        </div>
        
        <?php if(!empty($posts)): ?>
            <?php 
                $featured = $posts[0]; 
                $others = array_slice($posts, 1);
            ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10" id="posts-grid">
                
                <!-- Artículo Destacado (Ocupa 2 columnas en Desktop) -->
                <article class="post-card col-span-1 lg:col-span-2 bg-white rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-1 transition-all duration-500 border border-gray-100/80 flex flex-col md:flex-row animate-fade-in-up">
                    <div class="md:w-1/2 relative min-h-[300px]">
                        <?php if(!empty($featured['image'])): ?>
                            <img src="<?= asset($featured['image']) ?>" alt="<?= htmlspecialchars($featured['title']) ?>" class="absolute inset-0 w-full h-full object-cover">
                        <?php else: ?>
                            <div class="absolute inset-0 bg-primary/5 flex items-center justify-center text-gray-300">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="md:w-1/2 p-10 flex flex-col justify-center">
                        <div class="flex items-center gap-3 mb-4 text-xs text-gray-400 font-bold uppercase tracking-wider">
                            <span class="text-secondary">Destacado</span>
                            <span>&bull;</span>
                            <span><?= formatBlogDate($featured['published_at']) ?></span>
                        </div>
                        <h2 class="searchable-title text-2xl md:text-3xl font-extrabold text-gray-900 mb-4 hover:text-secondary transition-colors leading-snug">
                            <a href="<?= url('blog/' . $featured['slug']) ?>"><?= htmlspecialchars($featured['title']) ?></a>
                        </h2>
                        <p class="text-gray-500 mb-8 leading-relaxed line-clamp-3 text-sm"><?= htmlspecialchars($featured['excerpt']) ?></p>
                        <a href="<?= url('blog/' . $featured['slug']) ?>" class="inline-flex items-center text-primary font-bold hover:text-secondary transition-colors mt-auto group text-sm">
                            <span>Leer artículo completo</span> 
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </article>

                <!-- Artículos Regulares -->
                <?php foreach($others as $post): ?>
                    <article class="post-card bg-white rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 border border-gray-100/80 flex flex-col animate-fade-in-up">
                        <div class="h-64 relative overflow-hidden">
                            <?php if(!empty($post['image'])): ?>
                                <img src="<?= asset($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full bg-primary/5 flex items-center justify-center text-gray-300">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="p-8 flex flex-col flex-grow">
                            <div class="flex items-center gap-3 mb-4 text-xs text-gray-400 font-bold uppercase tracking-wider">
                                <span class="text-primary">Artículo</span>
                                <span>&bull;</span>
                                <span><?= formatBlogDate($post['published_at']) ?></span>
                            </div>
                            <h3 class="searchable-title text-xl font-extrabold text-gray-900 mb-3 hover:text-secondary transition-colors leading-snug">
                                <a href="<?= url('blog/' . $post['slug']) ?>"><?= htmlspecialchars($post['title']) ?></a>
                            </h3>
                            <p class="text-gray-500 mb-6 line-clamp-3 leading-relaxed text-sm"><?= htmlspecialchars($post['excerpt']) ?></p>
                            <a href="<?= url('blog/' . $post['slug']) ?>" class="inline-flex items-center text-sm font-bold text-secondary hover:text-primary transition-colors mt-auto group">
                                <span>Leer más</span>
                                <svg class="w-4 h-4 ml-1.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>

            </div>

            <!-- Empty search state -->
            <div id="empty-search" class="hidden flex-col items-center justify-center py-24 text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-6">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <h3 class="text-2xl font-extrabold text-gray-900 mb-2">No se encontraron artículos</h3>
                <p class="text-gray-500 max-w-sm">Prueba buscando con otros términos o palabras clave.</p>
            </div>

        <?php else: ?>
            <div class="flex flex-col items-center justify-center py-32 text-center bg-white rounded-[2.5rem] border border-gray-100 shadow-sm">
                <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center text-gray-300 mb-6">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path></svg>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-2">Próximamente más novedades</h3>
                <p class="text-gray-500 max-w-sm">Estamos preparando artículos técnicos y de estrategia digital de primer nivel para ti.</p>
            </div>
        <?php endif; ?>
    </div>
</main>

<script>
function filterPosts(query) {
    const term = query.toLowerCase().trim();
    const cards = document.querySelectorAll('.post-card');
    let foundAny = false;

    cards.forEach(card => {
        const title = card.querySelector('.searchable-title').innerText.toLowerCase();
        if (title.includes(term)) {
            card.style.display = '';
            foundAny = true;
        } else {
            card.style.display = 'none';
        }
    });

    const empty = document.getElementById('empty-search');
    const grid = document.getElementById('posts-grid');
    if (empty && grid) {
        if (!foundAny && term !== '') {
            empty.classList.remove('hidden');
            empty.classList.add('flex');
            grid.classList.add('hidden');
        } else {
            empty.classList.add('hidden');
            empty.classList.remove('flex');
            grid.classList.remove('hidden');
        }
    }
}
</script>

<?php $this->component('footer'); ?>
