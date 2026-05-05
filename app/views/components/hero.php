<?php 
$hasSliders = !empty($sliders) && isset($sliders[0]);
$bgImage = $hasSliders ? $sliders[0]['image_path'] : 'https://images.unsplash.com/photo-1497366216548-37526070297c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80';
$title = $hasSliders ? $sliders[0]['title'] : 'Innovación y <span class="text-transparent bg-clip-text bg-gradient-to-r from-secondary to-accent">Excelencia Corporativa</span>';
$subtitle = $hasSliders ? $sliders[0]['subtitle'] : 'Soluciones integrales diseñadas para impulsar el crecimiento de tu empresa con tecnología de vanguardia y metodologías ágiles.';
$btnText = $hasSliders && !empty($sliders[0]['button_text']) ? $sliders[0]['button_text'] : 'Nuestros Servicios';
$btnLink = $hasSliders && !empty($sliders[0]['button_link']) ? $sliders[0]['button_link'] : '/services';
?>
<div class="relative bg-primary overflow-hidden">
    <div class="absolute inset-0">
        <img src="<?= htmlspecialchars($bgImage) ?>" alt="Corporate Background" class="w-full h-full object-cover opacity-30 mix-blend-overlay">
        <div class="absolute inset-0 bg-gradient-to-r from-primary via-primary/80 to-transparent"></div>
    </div>
    <div class="relative container mx-auto px-4 py-32 sm:py-40 flex flex-col items-start text-left">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-white text-sm font-medium mb-8 backdrop-blur-sm animate-fade-in-up">
            <span class="flex h-2 w-2 rounded-full bg-secondary"></span>
            Transformación Digital 2026
        </div>
        <h1 class="text-5xl sm:text-7xl font-extrabold text-white tracking-tight mb-6 leading-tight max-w-4xl animate-fade-in-up" style="animation-delay: 100ms;">
            <?= $title ?>
        </h1>
        <p class="text-xl text-gray-300 max-w-2xl mb-12 leading-relaxed animate-fade-in-up" style="animation-delay: 200ms;">
            <?= htmlspecialchars($subtitle) ?>
        </p>
        <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 animate-fade-in-up" style="animation-delay: 300ms;">
            <a href="<?= htmlspecialchars($btnLink) ?>" class="px-8 py-4 bg-secondary text-white rounded-lg font-semibold hover:bg-blue-600 transition-all duration-300 shadow-lg shadow-secondary/30 flex items-center justify-center gap-2">
                <?= htmlspecialchars($btnText) ?>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
            <a href="/contact" class="px-8 py-4 bg-transparent border border-white/30 text-white rounded-lg font-semibold hover:bg-white hover:text-primary transition-colors backdrop-blur-sm flex items-center justify-center">
                Contáctanos
            </a>
        </div>
    </div>
</div>
