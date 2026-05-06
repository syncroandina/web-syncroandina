<?php $this->component('header', ['title' => $title ?? 'Proyectos']); ?>
<?php $this->component('navbar'); ?>

<main class="min-h-screen bg-gray-50 pt-20 pb-32">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-3xl mx-auto mb-20 animate-fade-in-up">
            <h1 class="text-4xl md:text-5xl font-extrabold text-primary mb-6"><?= htmlspecialchars($settings['projects_page_title'] ?? 'Casos de Éxito') ?></h1>
            <p class="text-xl text-gray-600"><?= htmlspecialchars($settings['projects_page_subtitle'] ?? 'Proyectos emblemáticos que demuestran nuestro compromiso absoluto con la calidad corporativa y la entrega de valor real.') ?></p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if(!empty($projects)): ?>
                <?php foreach($projects as $index => $project): ?>
                <a href="/proyectos/<?= htmlspecialchars($project['slug']) ?>" class="group relative rounded-3xl overflow-hidden shadow-lg cursor-pointer animate-fade-in-up block" style="animation-delay: <?= $index * 100 ?>ms;">
                    <img src="<?= htmlspecialchars($project['main_image']) ?>" alt="<?= htmlspecialchars($project['title']) ?>" loading="lazy" class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-primary via-primary/60 to-transparent opacity-80"></div>
                    <div class="absolute bottom-0 left-0 p-8 w-full translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                        <span class="inline-block px-3 py-1 bg-secondary text-white text-xs font-bold rounded-full mb-3 shadow-md"><?= htmlspecialchars($project['client']) ?></span>
                        <h3 class="text-2xl font-bold text-white mb-2"><?= htmlspecialchars($project['title']) ?></h3>
                        <p class="text-gray-300 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100 line-clamp-2"><?= htmlspecialchars($project['description']) ?></p>
                    </div>
                </a>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full text-center py-20">
                    <p class="text-gray-500 text-lg">Próximamente publicaremos nuestros casos de éxito.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php $this->component('footer'); ?>
