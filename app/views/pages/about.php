<?php $this->component('header', [
    'title' => $title ?? 'La Empresa',
    'description' => $description ?? null,
    'keywords' => $keywords ?? null
]); ?>
<?php $this->component('navbar'); ?>

<main class="min-h-screen bg-gray-50 pt-20 pb-32">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center mb-20 animate-fade-in-up">
            <h1 class="text-4xl md:text-5xl font-extrabold text-primary mb-6">
                <?= htmlspecialchars($settings['about_title'] ?? 'Nuestra Visión hacia el Futuro') ?>
            </h1>
            <p class="text-xl text-gray-600 leading-relaxed">
                <?= htmlspecialchars($settings['about_description'] ?? 'En Syncro Andina creemos que la tecnología no es solo una herramienta, sino el pilar fundamental que impulsa el crecimiento corporativo sostenible. Diseñamos soluciones que trascienden fronteras.') ?>
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
            <div class="relative rounded-3xl overflow-hidden shadow-2xl animate-fade-in-up">
                <?php 
                $imgSrc = $settings['about_image'] ?? 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80';
                ?>
                <img src="<?= htmlspecialchars($imgSrc) ?>" alt="Equipo" class="w-full h-auto object-cover transform hover:scale-105 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-primary/80 to-transparent"></div>
                <div class="absolute bottom-8 left-8 text-white">
                    <h3 class="text-2xl font-bold">
                        <?= htmlspecialchars($settings['about_image_title'] ?? 'Nuestro Equipo') ?>
                    </h3>
                    <p class="text-gray-200 mt-2">
                        <?= htmlspecialchars($settings['about_image_subtitle'] ?? 'Expertos en transformación digital') ?>
                    </p>
                </div>
            </div>
            
            <div class="space-y-8 animate-fade-in-up">
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-blue-100 text-secondary rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">
                        <?= htmlspecialchars($settings['about_mission_title'] ?? 'Misión 2026') ?>
                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        <?= htmlspecialchars($settings['about_mission_desc'] ?? 'Elevar los estándares de eficiencia operativa en Latinoamérica a través de consultoría tecnológica estratégica y plataformas a medida.') ?>
                    </p>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-blue-100 text-secondary rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">
                        <?= htmlspecialchars($settings['about_impact_title'] ?? 'Impacto Global') ?>
                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        <?= htmlspecialchars($settings['about_impact_desc'] ?? 'Más de 500 proyectos corporativos entregados con éxito, optimizando la cadena de valor de empresas líderes en el mercado andino.') ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php $this->component('footer'); ?>
