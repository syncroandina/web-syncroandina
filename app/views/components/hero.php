<?php 
$hasSliders = !empty($sliders);
if (!$hasSliders) return;
?>

<!-- Swiper Container -->
<div class="swiper heroSwiper relative group">
    <div class="swiper-wrapper">
        <?php foreach($sliders as $slider): ?>
            <div class="swiper-slide relative bg-primary overflow-hidden min-h-[600px] sm:min-h-[700px] flex items-center">
                <!-- Background Image with Overlay -->
                <div class="absolute inset-0">
                    <img src="<?= asset($slider['image_path']) ?>" alt="<?= htmlspecialchars($slider['image_alt'] ?: $slider['title']) ?>" class="w-full h-full object-cover opacity-40">
                    <div class="absolute inset-0 bg-gradient-to-r from-primary via-primary/80 to-transparent"></div>
                </div>

                <!-- Content -->
                <div class="relative container mx-auto px-4 py-32 flex flex-col items-center sm:items-start text-center sm:text-left z-10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-white text-[10px] font-bold tracking-widest mb-8 backdrop-blur-sm transform transition-all duration-700 translate-y-8 opacity-0 swiper-lazy-content">
                        <span class="flex h-2 w-2 rounded-full bg-secondary animate-pulse"></span>
                        <?= htmlspecialchars($slider['top_label'] ?? 'SYNCRO ANDINA INGENIERÍA') ?>
                    </div>
                    
                    <p class="text-5xl sm:text-7xl font-extrabold text-white tracking-tight mb-6 leading-tight max-w-4xl transform transition-all duration-700 delay-100 translate-y-8 opacity-0 swiper-lazy-content">
                        <?= $slider['title'] ?>
                    </p>
                    
                    <p class="text-xl text-gray-300 max-w-2xl mb-12 leading-relaxed transform transition-all duration-700 delay-200 translate-y-8 opacity-0 swiper-lazy-content">
                        <?= htmlspecialchars($slider['subtitle']) ?>
                    </p>
                    
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 transform transition-all duration-700 delay-300 translate-y-8 opacity-0 swiper-lazy-content">
                        <?php if(!empty($slider['button_text'])): ?>
                            <a href="<?= htmlspecialchars($slider['button_link'] ?? '#') ?>" class="px-8 py-4 bg-secondary text-white rounded-xl font-bold hover:bg-blue-600 transition-all duration-300 shadow-lg shadow-secondary/30 flex items-center justify-center gap-2 group/btn">
                                <?= htmlspecialchars($slider['button_text']) ?>
                                <svg class="w-5 h-5 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        <?php endif; ?>
                        <a href="/contact" class="px-8 py-4 bg-transparent border border-white/30 text-white rounded-xl font-bold hover:bg-white hover:text-primary transition-all backdrop-blur-sm flex items-center justify-center">
                            Contáctanos
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Navegación Refinada -->
    <?php if(count($sliders) > 1): ?>
        <button class="swiper-button-next !w-16 !h-16 bg-white/5 hover:bg-secondary border border-white/10 backdrop-blur-lg rounded-full transition-all opacity-0 group-hover:opacity-100 -translate-x-6 group-hover:translate-x-0 flex items-center justify-center">
            <svg class="text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 22px; height: 22px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5l7 7-7 7"></path></svg>
        </button>
        <button class="swiper-button-prev !w-16 !h-16 bg-white/5 hover:bg-secondary border border-white/10 backdrop-blur-lg rounded-full transition-all opacity-0 group-hover:opacity-100 translate-x-6 group-hover:translate-x-0 flex items-center justify-center">
            <svg class="text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 22px; height: 22px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 19l-7-7 7-7"></path></svg>
        </button>
        <div class="swiper-pagination !bottom-8"></div>
    <?php endif; ?>
</div>

<style>
    /* Ocultar flechas por defecto de Swiper */
    .swiper-button-next:after, .swiper-button-prev:after { content: none !important; }
    
    .swiper-lazy-content { transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1); }
    .swiper-slide-active .swiper-lazy-content { transform: translateY(0); opacity: 1; }
    .swiper-pagination-bullet { background: rgba(255,255,255,0.3) !important; opacity: 1 !important; width: 8px; height: 8px; transition: all 0.3s; }
    .swiper-pagination-bullet-active { background: var(--color-secondary, #3b82f6) !important; width: 24px; border-radius: 4px; }
</style>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const swiper = new Swiper('.heroSwiper', {
            loop: true,
            effect: 'fade',
            fadeEffect: { crossFade: true },
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    });
</script>
