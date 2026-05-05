<?php $this->component('header', ['title' => $title ?? 'Inicio']); ?>
<?php $this->component('navbar'); ?>

<main class="min-h-screen bg-gray-50">
    <?php $this->component('hero', ['sliders' => $sliders ?? []]); ?>
    
    <section class="py-24 container mx-auto px-4">
        <div class="text-center mb-16 animate-fade-in-up">
            <h2 class="text-3xl md:text-4xl font-extrabold text-primary mb-4">Nuestros Proyectos Recientes</h2>
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
    </section>

    <section class="py-16 container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-sm font-bold tracking-wider text-secondary uppercase mb-2">Lo que hacemos</h2>
            <h3 class="text-3xl md:text-4xl font-extrabold text-primary">Nuestros Servicios</h3>
            <div class="mt-4 w-24 h-1 bg-secondary mx-auto rounded-full"></div>
        </div>
        
        <?php $this->component('cards'); ?>
    </section>
</main>

<?php $this->component('footer'); ?>
