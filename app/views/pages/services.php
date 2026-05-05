<?php $this->component('header', ['title' => $title ?? 'Servicios']); ?>
<?php $this->component('navbar'); ?>

<main class="min-h-screen bg-gray-50 pt-20 pb-32">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-3xl mx-auto mb-20 animate-fade-in-up">
            <h1 class="text-4xl md:text-5xl font-extrabold text-primary mb-6">Soluciones Estratégicas</h1>
            <p class="text-xl text-gray-600">Catálogo completo de servicios corporativos enfocados en la innovación tecnológica, diseñados modularmente para adaptarse a la escala de tu negocio.</p>
        </div>
        
        <?php $this->component('cards'); ?>
    </div>
</main>

<?php $this->component('footer'); ?>
