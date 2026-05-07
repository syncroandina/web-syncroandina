<?php $this->component('header', ['title' => $title ?? 'Detalle del Proyecto']); ?>
<?php $this->component('navbar'); ?>

<main class="min-h-screen bg-slate-950 text-white overflow-hidden pb-32">
    <!-- Hero Section con efecto Parallax y Gradiente Profundo -->
    <section class="relative h-[65vh] min-h-[500px] flex items-end overflow-hidden">
        <div class="absolute inset-0">
            <img src="<?= asset($project['main_image']) ?>" alt="<?= htmlspecialchars($project['title']) ?>" class="w-full h-full object-cover transform scale-105 animate-subtle-zoom duration-[10s]">
            <!-- Superposición de degradado dramático para máxima legibilidad -->
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/80 via-transparent to-transparent"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10 pb-16 animate-fade-in-up">
            <div class="max-w-4xl">
                <!-- Enlace de regreso con micro-animación -->
                <a href="/proyectos" class="inline-flex items-center gap-2 text-sm font-extrabold text-secondary hover:text-white transition-colors uppercase tracking-widest mb-6 group">
                    <svg class="w-4 h-4 transform group-hover:-translate-x-1.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Casos de Éxito
                </a>
                
                <div class="flex flex-wrap items-center gap-3 mb-4">
                    <span class="px-4 py-1.5 bg-secondary/25 backdrop-blur-md text-secondary border border-secondary/30 rounded-full text-xs font-black uppercase tracking-widest">
                        <?= htmlspecialchars($project['client'] ?? 'Cliente Corporativo') ?>
                    </span>
                    <span class="px-4 py-1.5 bg-white/5 backdrop-blur-md text-gray-300 border border-white/10 rounded-full text-xs font-black uppercase tracking-widest">
                        <?= $project['completion_date'] ? date('d M, Y', strtotime($project['completion_date'])) : 'Completado' ?>
                    </span>
                </div>

                <h1 class="text-4xl md:text-6xl font-black tracking-tight text-white leading-tight">
                    <?= htmlspecialchars($project['title']) ?>
                </h1>
            </div>
        </div>
    </section>

    <!-- Contenido Principal Asimétrico y Ultra-Moderno -->
    <section class="container mx-auto px-4 mt-16">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            
            <!-- Columna Izquierda: Historia y Detalles del Caso -->
            <div class="lg:col-span-8 space-y-12 animate-fade-in-up" style="animation-delay: 200ms;">
                <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 md:p-12 shadow-2xl relative overflow-hidden group">
                    <!-- Brillo de fondo sutil -->
                    <div class="absolute -top-24 -left-24 w-48 h-48 bg-secondary/10 rounded-full blur-3xl group-hover:bg-secondary/20 transition-all duration-700"></div>
                    
                    <h2 class="text-2xl font-extrabold text-white mb-6 flex items-center gap-3">
                        <span class="w-1.5 h-8 bg-secondary rounded-full"></span>
                        Descripción del Proyecto
                    </h2>
                    
                    <div class="text-gray-300 text-lg leading-relaxed space-y-6">
                        <?= nl2br(htmlspecialchars($project['description'])) ?>
                    </div>
                </div>

                <!-- Tarjeta de Desafío y Solución con Diseño Creativo -->
                <?php if(!empty($project['challenge_desc']) || !empty($project['solution_desc'])): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php if(!empty($project['challenge_desc'])): ?>
                    <div class="bg-white/5 border border-white/5 rounded-3xl p-8 hover:border-secondary/20 transition-all duration-300">
                        <div class="w-12 h-12 bg-red-500/10 rounded-2xl flex items-center justify-center text-red-500 mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3"><?= htmlspecialchars($project['challenge_title'] ?? 'El Reto') ?></h3>
                        <p class="text-gray-400 text-sm leading-relaxed">
                            <?= nl2br(htmlspecialchars($project['challenge_desc'])) ?>
                        </p>
                    </div>
                    <?php endif; ?>

                    <?php if(!empty($project['solution_desc'])): ?>
                    <div class="bg-white/5 border border-white/5 rounded-3xl p-8 hover:border-secondary/20 transition-all duration-300">
                        <div class="w-12 h-12 bg-green-500/10 rounded-2xl flex items-center justify-center text-green-500 mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3"><?= htmlspecialchars($project['solution_title'] ?? 'La Solución') ?></h3>
                        <p class="text-gray-400 text-sm leading-relaxed">
                            <?= nl2br(htmlspecialchars($project['solution_desc'])) ?>
                        </p>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Columna Derecha: Tarjeta Sticky de Datos del Proyecto -->
            <div class="lg:col-span-4 lg:sticky lg:top-28 space-y-6 animate-fade-in-up" style="animation-delay: 400ms;">
                <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-2xl relative overflow-hidden">
                    <div class="absolute -bottom-24 -right-24 w-48 h-48 bg-primary/10 rounded-full blur-3xl"></div>
                    
                    <h3 class="text-lg font-extrabold text-white mb-6 flex items-center gap-2">
                        Ficha Técnica
                    </h3>
                    
                    <div class="space-y-6 border-b border-white/10 pb-6 mb-6">
                        <div>
                            <span class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Socio de Éxito</span>
                            <span class="text-white font-extrabold text-lg"><?= htmlspecialchars($project['client'] ?? 'N/A') ?></span>
                        </div>
                        
                        <div>
                            <span class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Fecha de Lanzamiento</span>
                            <span class="text-white font-extrabold text-lg"><?= $project['completion_date'] ? date('d F, Y', strtotime($project['completion_date'])) : 'Completado con Éxito' ?></span>
                        </div>

                        <div>
                            <span class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1"><?= htmlspecialchars($project['impact_label'] ?? 'Impacto Logrado') ?></span>
                            <span class="text-secondary font-black text-lg"><?= htmlspecialchars($project['impact_value'] ?? '100% Optimizado') ?></span>
                        </div>
                    </div>

                    <!-- Botón de consulta centralizado -->
                    <button onclick="openContactModal('Consulta sobre caso de éxito: <?= htmlspecialchars($project['title']) ?>')" class="w-full inline-flex items-center justify-center gap-2 px-6 py-4 bg-primary hover:bg-secondary text-white font-bold rounded-2xl transition-all shadow-lg shadow-primary/20 hover:shadow-secondary/30 transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        Contáctanos
                    </button>
                </div>
            </div>

        </div>
    </section>

    <!-- Sección de Galería de Fotos del Proyecto -->
    <?php if(!empty($gallery)): ?>
    <section class="container mx-auto px-4 mt-20 animate-fade-in-up" style="animation-delay: 600ms;">
        <h2 class="text-3xl font-black text-white mb-8 flex items-center gap-3">
            <span class="w-1.5 h-8 bg-secondary rounded-full"></span>
            Galería del Proyecto
        </h2>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php foreach($gallery as $img): ?>
            <div class="gallery-item-trigger group relative aspect-[4/3] rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl hover:shadow-secondary/20 border border-white/10 cursor-pointer transition-all duration-500 hover:-translate-y-1.5" data-src="<?= asset($img['image_path']) ?>">
                <img src="<?= asset($img['image_path']) ?>" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                    <span class="text-white text-xs font-bold uppercase tracking-widest flex items-center gap-2">
                        <svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        Ampliar Imagen
                    </span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>
</main>

<!-- Lightbox para Galería de Fotos -->
<div id="gallery-lightbox" class="fixed inset-0 z-50 hidden bg-slate-950/98 backdrop-blur-xl flex items-center justify-center transition-all duration-300 opacity-0">
    <button onclick="closeLightbox()" class="absolute top-6 right-6 text-white hover:text-secondary transition-colors z-50">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
    
    <button onclick="navigateLightbox(-1)" class="absolute left-6 text-white hover:text-secondary transition-colors z-50 p-2 bg-white/5 hover:bg-white/10 rounded-2xl">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
    </button>
    
    <div class="max-w-5xl max-h-[80vh] px-4 flex flex-col items-center justify-center">
        <img id="lightbox-img" src="" class="max-w-full max-h-[75vh] object-contain rounded-2xl shadow-2xl border border-white/10 transform scale-95 transition-transform duration-300">
        <p id="lightbox-counter" class="text-xs font-black uppercase tracking-widest text-gray-400 mt-4"></p>
    </div>
    
    <button onclick="navigateLightbox(1)" class="absolute right-6 text-white hover:text-secondary transition-colors z-50 p-2 bg-white/5 hover:bg-white/10 rounded-2xl">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
    </button>
</div>

<style>
footer {
    margin-top: 0 !important;
}
@keyframes subtle-zoom {
    0% { transform: scale(1.03); }
    50% { transform: scale(1.07); }
    100% { transform: scale(1.03); }
}
.animate-subtle-zoom {
    animation: subtle-zoom 20s infinite ease-in-out;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const galleryItems = Array.from(document.querySelectorAll('.gallery-item-trigger'));
    const lightbox = document.getElementById('gallery-lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    const lightboxCounter = document.getElementById('lightbox-counter');
    let currentIndex = 0;

    if (galleryItems.length === 0) return;

    window.openLightbox = function(index) {
        currentIndex = index;
        const src = galleryItems[currentIndex].dataset.src;
        lightboxImg.src = src;
        lightboxCounter.textContent = `${currentIndex + 1} / ${galleryItems.length}`;
        
        lightbox.classList.remove('hidden');
        setTimeout(() => {
            lightbox.classList.remove('opacity-0');
            lightboxImg.classList.remove('scale-95');
        }, 50);
    };

    window.closeLightbox = function() {
        lightbox.classList.add('opacity-0');
        lightboxImg.classList.add('scale-95');
        setTimeout(() => {
            lightbox.classList.add('hidden');
        }, 300);
    };

    window.navigateLightbox = function(direction) {
        currentIndex = (currentIndex + direction + galleryItems.length) % galleryItems.length;
        lightboxImg.classList.add('scale-95');
        setTimeout(() => {
            lightboxImg.src = galleryItems[currentIndex].dataset.src;
            lightboxCounter.textContent = `${currentIndex + 1} / ${galleryItems.length}`;
            lightboxImg.classList.remove('scale-95');
        }, 150);
    };

    galleryItems.forEach((item, index) => {
        item.addEventListener('click', () => {
            openLightbox(index);
        });
    });

    // Teclas físicas
    document.addEventListener('keydown', (e) => {
        if (lightbox.classList.contains('hidden')) return;
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowRight') navigateLightbox(1);
        if (e.key === 'ArrowLeft') navigateLightbox(-1);
    });
});
</script>

<?php $this->component('contact_modal'); ?>
<?php $this->component('footer'); ?>
