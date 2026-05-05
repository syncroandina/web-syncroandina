<?php $this->component('header', ['title' => $title ?? 'Inicio']); ?>
<?php $this->component('navbar'); ?>

<main class="min-h-screen bg-gray-50">
    <?php $this->component('hero', ['sliders' => $sliders ?? []]); ?>
    
    <!-- Sección de Servicios (Ahora arriba) -->
    <section class="py-24 container mx-auto px-4">
        <div class="text-center mb-16">
            <p class="text-sm font-bold tracking-widest text-secondary uppercase mb-3 animate-fade-in"><?= htmlspecialchars($settings['services_label'] ?? 'Lo que hacemos') ?></p>
            <h1 class="text-4xl md:text-5xl font-extrabold text-primary mb-6 animate-fade-in"><?= htmlspecialchars($settings['services_title'] ?? 'Nuestros Servicios Especializados') ?></h1>
            <div class="w-24 h-1.5 bg-secondary mx-auto rounded-full animate-fade-in"></div>
            <p class="text-gray-600 max-w-2xl mx-auto text-lg mt-8 animate-fade-in"><?= htmlspecialchars($settings['services_description'] ?? 'Ofrecemos soluciones integrales diseñadas para impulsar el crecimiento y la seguridad de tu infraestructura corporativa.') ?></p>
        </div>
        
        <?php $this->component('cards', ['services' => $services ?? []]); ?>
    </section>

    <!-- Sección CTA Dinámica -->
    <section class="relative py-24 overflow-hidden">
        <!-- Background con Gradiente y Efectos Dinámicos -->
        <div class="absolute inset-0 bg-primary">
            <div class="absolute inset-0 opacity-30 bg-[radial-gradient(circle_at_50%_-20%,var(--secondary),transparent)]"></div>
            <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_80%_80%,var(--accent),transparent)]"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10 text-center">
            <div class="inline-block px-4 py-1.5 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-white text-[10px] font-bold uppercase tracking-[0.2em] mb-8 animate-bounce">
                ¿Listo para transformar tu empresa?
            </div>
            
            <h2 class="text-4xl md:text-6xl font-black text-white mb-8 tracking-tight leading-tight max-w-4xl mx-auto">
                Impulsa tu negocio con <br> 
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">tecnología de vanguardia</span>
            </h2>

            <p class="text-gray-400 text-lg md:text-xl max-w-2xl mx-auto mb-12 leading-relaxed">
                Nuestro equipo de expertos está listo para ayudarte a encontrar las mejores soluciones tecnológicas para tus necesidades empresariales.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-6 mb-16">
                <a href="/contact" class="group relative px-8 py-5 bg-secondary text-white font-bold rounded-2xl shadow-2xl shadow-secondary/30 hover:scale-105 active:scale-95 transition-all flex items-center gap-3">
                    Consulta Gratuita
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
                <a href="/services" class="px-8 py-5 bg-white/5 backdrop-blur-sm border border-white/10 text-white font-bold rounded-2xl hover:bg-white/10 transition-all">
                    Ver Catálogo
                </a>
            </div>

            <!-- Datos de Contacto Inferiores -->
            <div class="flex flex-wrap items-center justify-center gap-8 md:gap-16 pt-8 border-t border-white/5">
                <div class="flex items-center gap-4 group">
                    <div class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-secondary group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-gray-300 group-hover:text-white transition-colors">+57 300 123 4567</span>
                </div>
                <div class="flex items-center gap-4 group">
                    <div class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-secondary group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-gray-300 group-hover:text-white transition-colors">info@syncroandina.com</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Proyectos (Ahora abajo) -->
    <section class="py-24 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-extrabold text-primary mb-4">Nuestros Proyectos Recientes</h2>
                <p class="text-gray-600 max-w-2xl mx-auto text-lg">Casos de éxito que demuestran nuestra capacidad de ejecución e innovación.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php if(!empty($latestProjects)): ?>
                    <?php foreach($latestProjects as $index => $project): ?>
                    <div class="group relative rounded-3xl overflow-hidden shadow-lg cursor-pointer animate-fade-in-up" style="animation-delay: <?= $index * 100 ?>ms;">
                        <img src="<?= htmlspecialchars($project['main_image']) ?>" alt="<?= htmlspecialchars($project['title']) ?>" loading="lazy" class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-primary via-primary/60 to-transparent opacity-80"></div>
                        <div class="absolute bottom-0 left-0 p-8 w-full translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                            <span class="inline-block px-3 py-1 bg-secondary text-white text-xs font-bold rounded-full mb-3 shadow-md"><?= htmlspecialchars($project['client']) ?></span>
                            <h3 class="text-2xl font-bold text-white mb-2"><?= htmlspecialchars($project['title']) ?></h3>
                            <p class="text-gray-300 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100 line-clamp-2"><?= htmlspecialchars($project['description']) ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-span-full text-center text-gray-500">Aún no hay proyectos publicados.</div>
                <?php endif; ?>
            </div>
            
            <div class="text-center mt-12">
                <a href="/projects" class="inline-flex items-center gap-2 font-bold text-secondary hover:text-blue-700 transition-colors">
                    Ver todos los proyectos
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>
    </section>
    <!-- Sección de Blog -->
    <section class="py-24 container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
            <div class="max-w-2xl">
                <p class="text-sm font-bold tracking-widest text-secondary uppercase mb-3">Actualidad y Conocimiento</p>
                <h2 class="text-3xl md:text-5xl font-extrabold text-primary">Nuestro Blog Corporativo</h2>
            </div>
            <a href="/blog" class="group flex items-center gap-3 font-bold text-gray-900 hover:text-secondary transition-all">
                Explorar todos los artículos
                <div class="w-10 h-10 rounded-full bg-gray-100 group-hover:bg-secondary group-hover:text-white flex items-center justify-center transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </div>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if(!empty($latestPosts)): ?>
                <?php foreach($latestPosts as $index => $post): ?>
                <article class="group bg-white rounded-[2.5rem] p-4 shadow-sm hover:shadow-2xl transition-all duration-500 border border-gray-100 flex flex-col h-full animate-fade-in-up" style="animation-delay: <?= $index * 150 ?>ms;">
                    <div class="relative overflow-hidden rounded-[2rem] aspect-[16/10] mb-6">
                        <img src="<?= htmlspecialchars($post['image'] ?: asset('assets/img/blog-placeholder.jpg')) ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute top-4 left-4">
                            <span class="bg-white/90 backdrop-blur-md text-primary text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-full shadow-sm">
                                <?= date('d M, Y', strtotime($post['published_at'] ?? $post['created_at'])) ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="px-4 pb-4 flex flex-col flex-grow">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-primary transition-colors line-clamp-2">
                            <?= htmlspecialchars($post['title']) ?>
                        </h3>
                        <p class="text-gray-600 mb-8 line-clamp-3 text-sm leading-relaxed">
                            <?= htmlspecialchars($post['excerpt']) ?>
                        </p>
                        
                        <div class="mt-auto pt-6 border-t border-gray-50 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-secondary/10 flex items-center justify-center text-secondary font-bold text-xs">
                                    <?= substr($post['author_name'] ?? 'S', 0, 1) ?>
                                </div>
                                <span class="text-xs font-bold text-gray-400"><?= htmlspecialchars($post['author_name'] ?? 'Syncro Team') ?></span>
                            </div>
                            <a href="/blog/<?= $post['slug'] ?>" class="text-secondary font-black text-xs uppercase tracking-widest hover:underline">Leer más</a>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full py-20 text-center bg-white rounded-[3rem] border border-dashed border-gray-200">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    </div>
                    <p class="text-gray-400 font-medium">Estamos preparando contenido increíble para ti.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php $this->component('footer'); ?>
