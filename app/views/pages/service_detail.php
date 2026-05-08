<?php $this->component('header', ['title' => $title ?? 'Detalle del Servicio']); ?>
<?php $this->component('navbar'); ?>

<style>
.rich-text-content ul {
    list-style-type: disc !important;
    margin-left: 1.5rem !important;
    margin-bottom: 1rem !important;
}
.rich-text-content ol {
    list-style-type: decimal !important;
    margin-left: 1.5rem !important;
    margin-bottom: 1rem !important;
}
.rich-text-content p {
    margin-bottom: 1rem !important;
}
.rich-text-content p:last-child {
    margin-bottom: 0 !important;
}
.rich-text-content strong {
    font-weight: 800 !important;
}
.rich-text-content h1, .rich-text-content h2, .rich-text-content h3, .rich-text-content h4 {
    font-weight: 800 !important;
    margin-top: 1.5rem !important;
    margin-bottom: 0.75rem !important;
}
.rich-text-content h1 { font-size: 1.875rem !important; }
.rich-text-content h2 { font-size: 1.5rem !important; }
.rich-text-content h3 { font-size: 1.25rem !important; }
.rich-text-content h4 { font-size: 1.125rem !important; }
</style>

<main class="min-h-screen bg-gray-50/50 pb-32">
    <!-- Hero / Banner de Servicio -->
    <div class="relative h-[450px] overflow-hidden bg-primary flex items-center">
        <!-- Imagen de Fondo con Parallax Efecto -->
        <img src="<?= htmlspecialchars($service['image'] ?: asset('assets/img/service-placeholder.jpg')) ?>" 
             alt="<?= htmlspecialchars($service['title']) ?>" 
             class="absolute inset-0 w-full h-full object-cover opacity-30 transform scale-105 hover:scale-100 transition-transform duration-1000">
        
        <!-- Degradados e Interposición -->
        <div class="absolute inset-0 bg-gradient-to-r from-primary via-primary/80 to-transparent"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,var(--secondary),transparent_50%)] opacity-30"></div>
        
        <div class="container mx-auto px-4 relative z-10 text-white animate-fade-in-up">
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2.5 text-xs font-bold uppercase tracking-widest text-white/60 mb-6">
                <a href="/" class="hover:text-secondary transition-colors">Inicio</a>
                <svg class="w-3.5 h-3.5 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                <a href="/servicios" class="hover:text-secondary transition-colors">Servicios</a>
                <svg class="w-3.5 h-3.5 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-white select-none"><?= htmlspecialchars($service['title']) ?></span>
            </nav>
            
            <h1 class="text-4xl md:text-6xl font-black mb-6 tracking-tight max-w-4xl leading-tight">
                <?= htmlspecialchars($service['title']) ?>
            </h1>
            <div class="w-20 h-1.5 bg-secondary rounded-full"></div>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="container mx-auto px-4 -mt-16 relative z-20">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <!-- Columna de Contenido (Izquierda 2/3) -->
            <div class="lg:col-span-2 space-y-12">
                <!-- Tarjeta Principal con Descripción -->
                <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 p-8 md:p-12 animate-fade-in-up">
                    <h2 class="text-3xl font-extrabold text-primary mb-6 flex items-center gap-3">
                        <span class="w-2.5 h-8 bg-secondary rounded-full inline-block"></span>
                        <?= htmlspecialchars($service['heading_description'] ?? 'Descripción') ?>
                    </h2>
                    <div class="text-gray-600 leading-relaxed text-lg rich-text-content">
                        <?= $service['content'] ?>
                    </div>
                </div>

                <!-- Lista de Sub-servicios o Entregables (Items) -->
                <?php if (!empty($service['items'])): ?>
                <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 p-8 md:p-12 animate-fade-in-up" style="animation-delay: 100ms;">
                    <h3 class="text-2xl font-extrabold text-primary mb-8 flex items-center gap-3">
                        <span class="w-2.5 h-8 bg-secondary rounded-full inline-block"></span>
                        <?= htmlspecialchars($service['heading_details'] ?? 'Detalles del servicio') ?>
                    </h3>
                    
                    <div class="space-y-6">
                        <?php foreach($service['items'] as $index => $item): ?>
                        <div class="group flex items-start gap-4 p-4 rounded-2xl hover:bg-gray-50 transition-all duration-300">
                            <!-- Icono check minimalista -->
                            <div class="w-8 h-8 rounded-full bg-secondary/10 text-secondary flex items-center justify-center flex-shrink-0 group-hover:bg-secondary group-hover:text-white transition-all duration-300 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-extrabold text-gray-900 text-lg mb-1 group-hover:text-primary transition-colors">
                                    <?= htmlspecialchars($item['title']) ?>
                                </h4>
                                <p class="text-gray-600 text-sm leading-relaxed">
                                    <?= htmlspecialchars($item['description']) ?>
                                </p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Galería del Servicio -->
                <?php if (!empty($service['gallery'])): ?>
                <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 p-8 md:p-12 animate-fade-in-up" style="animation-delay: 200ms;">
                    <h3 class="text-2xl font-extrabold text-primary mb-8 flex items-center gap-3">
                        <span class="w-2.5 h-8 bg-secondary rounded-full inline-block"></span>
                        <?= htmlspecialchars($service['heading_gallery'] ?? 'Trabajos Realizados') ?>
                    </h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        <?php foreach($service['gallery'] as $img): ?>
                        <div class="gallery-item-trigger group relative aspect-[4/3] rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl hover:shadow-secondary/20 border border-gray-100 cursor-pointer transition-all duration-500 hover:-translate-y-1.5" 
                             data-src="<?= htmlspecialchars($img['image_path']) ?>">
                            <img src="<?= htmlspecialchars($img['image_path']) ?>" 
                                 alt="Galería <?= htmlspecialchars($service['title']) ?>" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            
                            <!-- Overlay de Hover -->
                            <div class="absolute inset-0 bg-gradient-to-t from-primary/80 via-primary/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                                <div class="w-14 h-14 rounded-full bg-white text-primary flex items-center justify-center shadow-2xl transform scale-75 group-hover:scale-100 transition-all duration-500">
                                    <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Columna de Cotización (Derecha 1/3) -->
            <div class="lg:col-span-1">
                <div class="sticky top-28 space-y-8 animate-fade-in-up" style="animation-delay: 150ms;">
                    <!-- Widget de Contacto/CTA -->
                    <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 p-8 relative overflow-hidden">
                        <!-- Decoración de Fondo -->
                        <div class="absolute -top-12 -right-12 w-32 h-32 bg-secondary/10 rounded-full blur-2xl"></div>
                        
                        <h3 class="text-2xl font-black text-primary mb-4 relative z-10"><?= htmlspecialchars($service['heading_cta'] ?? '¿Interesado en este Servicio?') ?></h3>
                        <p class="text-gray-500 text-sm leading-relaxed mb-8 relative z-10">
                            <?= htmlspecialchars($service['cta_description'] ?? 'Nuestro equipo de especialistas está listo para diseñar una cotización personalizada adaptada a los requerimientos de tu proyecto.') ?>
                        </p>
                        
                        <div class="space-y-6 mb-8 relative z-10">
                            <div class="flex items-center gap-4 group">
                                <div class="w-12 h-12 rounded-2xl bg-secondary/10 text-secondary flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Llámanos</p>
                                    <p class="text-sm font-extrabold text-gray-900"><?= htmlspecialchars($settings['contact_phone_value'] ?? '+57 300 123 4567') ?></p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4 group">
                                <div class="w-12 h-12 rounded-2xl bg-secondary/10 text-secondary flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Escríbenos</p>
                                    <p class="text-sm font-extrabold text-gray-900"><?= htmlspecialchars($settings['contact_email_value'] ?? 'contacto@syncroandina.com') ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <button onclick="openContactModal('Información sobre el servicio: <?= addslashes(htmlspecialchars($service['title'])) ?>', '<?= addslashes(htmlspecialchars($service['title'])) ?>')" class="w-full py-4 bg-primary hover:bg-secondary text-white font-bold rounded-2xl shadow-xl shadow-primary/10 hover:shadow-secondary/20 flex items-center justify-center gap-3 transition-all duration-300 relative z-10 hover:scale-105">
                            Solicitar Información
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>

                    <!-- Enlace de retorno -->
                    <div class="text-center">
                        <a href="/servicios" class="inline-flex items-center gap-2 font-bold text-gray-500 hover:text-secondary transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Volver a servicios
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

<!-- Lightbox Modal Moderno -->
<div id="gallery-lightbox" class="fixed inset-0 z-50 hidden bg-primary/95 backdrop-blur-xl flex items-center justify-center transition-all duration-300 opacity-0">
    <!-- Botón Cerrar -->
    <button id="lightbox-close" class="absolute top-6 right-6 w-14 h-14 rounded-full bg-white/10 backdrop-blur-md text-white border border-white/20 hover:bg-white/20 hover:scale-110 active:scale-90 transition-all duration-300 flex items-center justify-center z-50">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>

    <!-- Botón Anterior -->
    <button id="lightbox-prev" class="absolute left-6 w-14 h-14 rounded-full bg-white/10 backdrop-blur-md text-white border border-white/20 hover:bg-white/20 hover:scale-110 active:scale-90 transition-all duration-300 flex items-center justify-center z-50">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
        </svg>
    </button>

    <!-- Contenedor de la Imagen con Animación -->
    <div class="relative max-w-5xl max-h-[80vh] px-4 flex flex-col items-center justify-center">
        <img id="lightbox-img" src="" alt="Trabajo Realizado" class="max-w-full max-h-[75vh] rounded-3xl shadow-2xl object-contain border border-white/10 transition-all duration-500 transform scale-95 opacity-0">
        
        <!-- Contador de Imagen -->
        <p id="lightbox-counter" class="text-white/60 font-black tracking-widest text-xs uppercase mt-6 bg-white/5 px-4 py-2 rounded-full border border-white/10"></p>
    </div>

    <!-- Botón Siguiente -->
    <button id="lightbox-next" class="absolute right-6 w-14 h-14 rounded-full bg-white/10 backdrop-blur-md text-white border border-white/20 hover:bg-white/20 hover:scale-110 active:scale-90 transition-all duration-300 flex items-center justify-center z-50">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
        </svg>
    </button>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const galleryImages = Array.from(document.querySelectorAll('.gallery-item-trigger'));
    const lightbox = document.getElementById('gallery-lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    const lightboxCounter = document.getElementById('lightbox-counter');
    const closeBtn = document.getElementById('lightbox-close');
    const prevBtn = document.getElementById('lightbox-prev');
    const nextBtn = document.getElementById('lightbox-next');
    
    let currentIndex = 0;
    
    if (galleryImages.length === 0) return;
    
    const showImage = (index) => {
        currentIndex = (index + galleryImages.length) % galleryImages.length;
        const targetImgSrc = galleryImages[currentIndex].dataset.src;
        
        // Animación de salida (fade-out y escala reducida)
        lightboxImg.classList.remove('scale-100', 'opacity-100');
        lightboxImg.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            lightboxImg.src = targetImgSrc;
            
            // Esperar a que la imagen esté cargada para animar entrada
            lightboxImg.onload = () => {
                lightboxImg.classList.remove('scale-95', 'opacity-0');
                lightboxImg.classList.add('scale-100', 'opacity-100');
            };
            
            // Si ya está en caché y no dispara onload
            if (lightboxImg.complete) {
                lightboxImg.classList.remove('scale-95', 'opacity-0');
                lightboxImg.classList.add('scale-100', 'opacity-100');
            }
            
            lightboxCounter.textContent = `${currentIndex + 1} / ${galleryImages.length}`;
        }, 150);
    };
    
    const openLightbox = (index) => {
        lightbox.classList.remove('hidden');
        // Pequeño delay para permitir que la transición CSS de opacidad funcione
        setTimeout(() => {
            lightbox.classList.remove('opacity-0');
            lightbox.classList.add('opacity-100');
            showImage(index);
        }, 10);
    };
    
    const closeLightbox = () => {
        lightbox.classList.remove('opacity-100');
        lightbox.classList.add('opacity-0');
        setTimeout(() => {
            lightbox.classList.add('hidden');
        }, 300);
    };
    
    galleryImages.forEach((element, index) => {
        element.addEventListener('click', () => {
            openLightbox(index);
        });
    });
    
    closeBtn.addEventListener('click', closeLightbox);
    prevBtn.addEventListener('click', () => showImage(currentIndex - 1));
    nextBtn.addEventListener('click', () => showImage(currentIndex + 1));
    
    // Cerrar al hacer clic en el fondo oscuro
    lightbox.addEventListener('click', (e) => {
        if (e.target === lightbox) {
            closeLightbox();
        }
    });
    
    // Soporte para teclado (flechas y escape)
    document.addEventListener('keydown', (e) => {
        if (lightbox.classList.contains('hidden')) return;
        
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') showImage(currentIndex - 1);
        if (e.key === 'ArrowRight') showImage(currentIndex + 1);
    });
});
</script>

<?php $this->component('contact_modal'); ?>
<?php $this->component('footer'); ?>
