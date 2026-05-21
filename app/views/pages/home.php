<?php $this->component('header', ['title' => $title ?? 'Inicio']); ?>
<?php $this->component('navbar'); ?>

<main class="min-h-screen bg-white">
    <?php $this->component('hero', ['sliders' => $sliders ?? []]); ?>
    
    <!-- Sección de Servicios (Ahora arriba) -->
    <section class="py-24 bg-gray-50 border-b border-gray-100 overflow-hidden relative">
        <div class="container mx-auto px-4 mb-16 text-center">
            <p class="text-sm font-bold tracking-widest text-secondary uppercase mb-3 animate-fade-in"><?= htmlspecialchars($settings['services_label'] ?? 'Lo que hacemos') ?></p>
            <h1 class="text-4xl md:text-5xl font-extrabold text-primary mb-6 animate-fade-in"><?= htmlspecialchars($settings['services_title'] ?? 'Nuestros Servicios Especializados') ?></h1>
            <div class="w-24 h-1.5 bg-secondary mx-auto rounded-full animate-fade-in"></div>
            <p class="text-gray-600 max-w-2xl mx-auto text-lg mt-8 animate-fade-in"><?= htmlspecialchars($settings['services_description'] ?? 'Ofrecemos soluciones integrales diseñadas para impulsar el crecimiento y la seguridad de tu infraestructura corporativa.') ?></p>
        </div>
        
        <div class="container mx-auto px-4 relative z-10">
            <!-- Controles Personalizados -->
            <button class="services-prev absolute left-0 top-1/2 -translate-y-1/2 -translate-x-2 md:-translate-x-6 w-12 h-12 rounded-full bg-white text-primary shadow-xl border border-gray-100 flex items-center justify-center z-20 hover:bg-primary hover:text-white transition-all active:scale-90 focus:outline-none focus:ring-4 focus:ring-primary/20">
                <svg class="w-6 h-6 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button class="services-next absolute right-0 top-1/2 -translate-y-1/2 translate-x-2 md:translate-x-6 w-12 h-12 rounded-full bg-white text-primary shadow-xl border border-gray-100 flex items-center justify-center z-20 hover:bg-primary hover:text-white transition-all active:scale-90 focus:outline-none focus:ring-4 focus:ring-primary/20">
                <svg class="w-6 h-6 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
            </button>

            <!-- Estilo simple para ocultar scrollbar -->
            <style>
                .services-track::-webkit-scrollbar { display: none; }
            </style>

            <?php 
            $servicesCount = count($services ?? []);
            $justifyServicesXl = $servicesCount <= 3 ? 'xl:justify-center' : '';
            $justifyServicesLg = $servicesCount <= 2 ? 'lg:justify-center' : '';
            $justifyServicesSm = $servicesCount <= 1 ? 'sm:justify-center' : '';
            ?>
            <div class="services-track flex gap-6 overflow-x-auto snap-x snap-mandatory pt-2 pb-6 <?= $justifyServicesSm ?> <?= $justifyServicesLg ?> <?= $justifyServicesXl ?>" style="scrollbar-width: none; -ms-overflow-style: none;">
                <?php if(!empty($services)): ?>
                    <?php foreach($services as $index => $service): ?>
                    <div class="snap-start shrink-0 w-[85vw] sm:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)]">
                        <div class="group bg-white rounded-[2rem] border border-gray-200 hover:border-primary/40 transition-all duration-300 h-full flex flex-col overflow-hidden relative hover:-translate-y-1">
                            <!-- Imagen del Servicio -->
                            <div class="relative h-64 overflow-hidden border-b border-gray-200">
                                <img src="<?= htmlspecialchars($service['image'] ?: asset('assets/img/service-placeholder.jpg')) ?>" 
                                     alt="<?= htmlspecialchars($service['image_alt'] ?: $service['title']) ?>" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                            </div>

                            <div class="p-8 flex flex-col flex-grow bg-white">
                                <h2 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-primary transition-colors line-clamp-1">
                                    <?= htmlspecialchars($service['title']) ?>
                                </h2>
                                
                                <p class="text-gray-600 mb-8 leading-relaxed line-clamp-3">
                                    <?= htmlspecialchars(strip_tags($service['content'])) ?>
                                </p>
                                
                                <div class="mt-auto">
                                    <a href="/servicios/<?= $service['slug'] ?>" class="inline-flex items-center text-sm font-bold text-secondary hover:gap-3 transition-all duration-300">
                                        Ver Detalles
                                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="w-full text-center py-20 bg-gray-50 rounded-3xl border border-dashed border-gray-200">
                        <p class="text-gray-400 font-medium">No hay servicios configurados aún.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="text-center mt-16 animate-fade-in relative z-10">
            <a href="/servicios" class="inline-flex items-center gap-3 px-8 py-4 bg-primary text-white font-bold rounded-2xl hover:bg-secondary shadow-lg shadow-primary/10 hover:shadow-secondary/20 hover:scale-105 active:scale-95 transition-all duration-300">
                Ver Todos los Servicios
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </a>
        </div>
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
                <?= htmlspecialchars($settings['home_cta_tagline'] ?? '¿Listo para transformar tu empresa?') ?>
            </div>
            
            <h2 class="text-4xl md:text-6xl font-black text-white mb-8 tracking-tight leading-tight max-w-4xl mx-auto">
                <?= isset($settings['home_cta_headline']) ? $settings['home_cta_headline'] : 'Impulsa tu negocio con <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">tecnología de vanguardia</span>' ?>
            </h2>

            <p class="text-gray-400 text-lg md:text-xl max-w-2xl mx-auto mb-12 leading-relaxed">
                <?= htmlspecialchars($settings['home_cta_description'] ?? 'Nuestro equipo de expertos está listo para ayudarte a encontrar las mejores soluciones tecnológicas para tus necesidades empresariales.') ?>
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-6 mb-16">
                <a href="<?= htmlspecialchars($settings['home_cta_btn1_url'] ?? '/contacto') ?>" class="group relative px-8 py-5 bg-secondary text-white font-bold rounded-2xl shadow-2xl shadow-secondary/30 hover:scale-105 active:scale-95 transition-all flex items-center gap-3">
                    <?= htmlspecialchars($settings['home_cta_btn1_title'] ?? 'Consulta Gratuita') ?>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
                <a href="<?= htmlspecialchars($settings['home_cta_btn2_url'] ?? '/servicios') ?>" class="px-8 py-5 bg-white/5 backdrop-blur-sm border border-white/10 text-white font-bold rounded-2xl hover:bg-white/10 transition-all">
                    <?= htmlspecialchars($settings['home_cta_btn2_title'] ?? 'Ver Catálogo') ?>
                </a>
            </div>

            <!-- Datos de Contacto Inferiores -->
            <div class="flex flex-wrap items-center justify-center gap-8 md:gap-16 pt-8 border-t border-white/5">
                <a href="tel:<?= htmlspecialchars(preg_replace('/[^0-9+]/', '', $settings['contact_phone_value'] ?? '+573001234567')) ?>" class="flex items-center gap-4 group">
                    <div class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-secondary group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-gray-300 group-hover:text-white transition-colors"><?= htmlspecialchars($settings['contact_phone_value'] ?? '+57 300 123 4567') ?></span>
                </a>
                <a href="mailto:<?= htmlspecialchars($settings['contact_email_value'] ?? 'contacto@syncroandina.com') ?>" class="flex items-center gap-4 group">
                    <div class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-secondary group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-gray-300 group-hover:text-white transition-colors"><?= htmlspecialchars($settings['contact_email_value'] ?? 'contacto@syncroandina.com') ?></span>
                </a>
            </div>
        </div>
    </section>

    <!-- Sección de Repuestos Destacados -->
    <?php if(!empty($featuredProducts)): ?>
    <section class="py-24 bg-gray-50 border-b border-gray-100 overflow-hidden relative">
        <div class="container mx-auto px-4 mb-16 text-center relative z-10">
            <h2 class="text-4xl md:text-5xl font-extrabold text-primary mb-6 animate-fade-in"><?= htmlspecialchars($settings['products_home_title'] ?? 'Nuestros Repuestos Recientes') ?></h2>
            <div class="w-24 h-1.5 bg-secondary mx-auto rounded-full animate-fade-in"></div>
            <p class="text-gray-600 max-w-2xl mx-auto text-lg mt-8 animate-fade-in"><?= htmlspecialchars($settings['products_home_subtitle'] ?? 'Componentes y repuestos que demuestran nuestra calidad.') ?></p>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <!-- Controles Personalizados -->
            <button class="products-prev absolute left-0 top-1/2 -translate-y-1/2 -translate-x-2 md:-translate-x-6 w-12 h-12 rounded-full bg-white text-primary shadow-xl border border-gray-100 flex items-center justify-center z-20 hover:bg-primary hover:text-white transition-all active:scale-90 focus:outline-none focus:ring-4 focus:ring-primary/20">
                <svg class="w-6 h-6 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button class="products-next absolute right-0 top-1/2 -translate-y-1/2 translate-x-2 md:translate-x-6 w-12 h-12 rounded-full bg-white text-primary shadow-xl border border-gray-100 flex items-center justify-center z-20 hover:bg-primary hover:text-white transition-all active:scale-90 focus:outline-none focus:ring-4 focus:ring-primary/20">
                <svg class="w-6 h-6 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
            </button>

            <!-- Carrusel (Scroll Snap) con alineación inteligente y espacio para sombras -->
            <?php 
            $prodCount = count($featuredProducts);
            $justifyXl = $prodCount <= 4 ? 'xl:justify-center' : '';
            $justifyLg = $prodCount <= 3 ? 'lg:justify-center' : '';
            $justifySm = $prodCount <= 2 ? 'sm:justify-center' : '';
            ?>
            <!-- Estilo simple para ocultar scrollbar -->
            <style>
                .products-track::-webkit-scrollbar { display: none; }
            </style>

            <div class="products-track flex gap-6 overflow-x-auto snap-x snap-mandatory pt-2 pb-6 <?= $justifySm ?> <?= $justifyLg ?> <?= $justifyXl ?>" style="scrollbar-width: none; -ms-overflow-style: none;">
                <?php foreach($featuredProducts as $index => $product): ?>
                <div class="snap-start shrink-0 w-[85vw] sm:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)] xl:w-[calc(25%-18px)]">
                    <a href="/repuestos/<?= htmlspecialchars($product['slug']) ?>" class="group block bg-white rounded-3xl overflow-hidden border border-gray-200 hover:border-primary/40 transition-all duration-300 h-full flex flex-col relative hover:-translate-y-1">
                        <div class="relative bg-gray-100 overflow-hidden border-b border-gray-200 aspect-w-4 aspect-h-3">
                            <img src="<?= asset($product['main_image']) ?>" alt="<?= htmlspecialchars($product['image_alt'] ?: $product['title']) ?>" loading="lazy" class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-700">
                            <!-- Efecto gradiente premium -->
                            <div class="absolute inset-0 bg-gradient-to-t from-primary/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </div>
                        <div class="p-6 flex-1 flex flex-col bg-white">
                            <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-primary transition-colors line-clamp-1"><?= htmlspecialchars($product['title']) ?></h3>
                            <p class="text-gray-500 text-sm line-clamp-2 mb-4 flex-1 leading-relaxed"><?= htmlspecialchars($product['description']) ?></p>
                            <div class="flex items-center justify-between text-sm font-bold text-primary group-hover:text-secondary transition-colors mt-auto pt-4 border-t border-gray-100/50">
                                <span>Ver características</span>
                                <div class="w-8 h-8 rounded-full bg-gray-50 group-hover:bg-primary/5 flex items-center justify-center transition-colors">
                                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="text-center mt-12 mb-10 animate-fade-in relative z-10">
            <a href="/repuestos" class="inline-flex items-center gap-3 px-8 py-4 bg-primary text-white font-bold rounded-2xl hover:bg-secondary shadow-lg shadow-primary/10 hover:shadow-secondary/20 hover:scale-105 active:scale-95 transition-all duration-300">
                Ver Catálogo Completo
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </a>
        </div>
    </section>
    <?php endif; ?>

    <!-- Sección de Proyectos (Ahora abajo) -->
    <section class="py-24 bg-white overflow-hidden relative">
        <div class="container mx-auto px-4 mb-16 text-center">
            <h2 class="text-4xl md:text-5xl font-extrabold text-primary mb-6"><?= htmlspecialchars($settings['projects_home_title'] ?? 'Nuestros Proyectos Recientes') ?></h2>
            <div class="w-24 h-1.5 bg-secondary mx-auto rounded-full"></div>
            <p class="text-gray-600 max-w-2xl mx-auto text-lg mt-8"><?= htmlspecialchars($settings['projects_home_subtitle'] ?? 'Casos de éxito que demuestran nuestra capacidad de ejecución e innovación.') ?></p>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <!-- Controles Personalizados -->
            <button class="projects-carousel-prev absolute left-0 top-1/2 -translate-y-1/2 -translate-x-2 md:-translate-x-6 w-12 h-12 rounded-full bg-white text-primary shadow-xl border border-gray-100 flex items-center justify-center z-20 hover:bg-primary hover:text-white transition-all active:scale-90 focus:outline-none focus:ring-4 focus:ring-primary/20">
                <svg class="w-6 h-6 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button class="projects-carousel-next absolute right-0 top-1/2 -translate-y-1/2 translate-x-2 md:translate-x-6 w-12 h-12 rounded-full bg-white text-primary shadow-xl border border-gray-100 flex items-center justify-center z-20 hover:bg-primary hover:text-white transition-all active:scale-90 focus:outline-none focus:ring-4 focus:ring-primary/20">
                <svg class="w-6 h-6 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
            </button>

            <!-- Estilo simple para ocultar scrollbar -->
            <style>
                .projects-carousel-track::-webkit-scrollbar { display: none; }
            </style>

            <?php 
            $projCount = count($latestProjects ?? []);
            $justifyProjXl = $projCount <= 3 ? 'xl:justify-center' : '';
            $justifyProjLg = $projCount <= 2 ? 'lg:justify-center' : '';
            $justifyProjSm = $projCount <= 1 ? 'sm:justify-center' : '';
            ?>
            <div class="projects-carousel-track flex gap-6 overflow-x-auto snap-x snap-mandatory pt-2 pb-6 <?= $justifyProjSm ?> <?= $justifyProjLg ?> <?= $justifyProjXl ?>" style="scrollbar-width: none; -ms-overflow-style: none;">
                <?php if(!empty($latestProjects)): ?>
                    <?php foreach($latestProjects as $index => $project): ?>
                    <div class="snap-start shrink-0 w-[85vw] sm:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)]">
                        <a href="/proyectos/<?= htmlspecialchars($project['slug']) ?>" class="group relative rounded-[2rem] overflow-hidden cursor-pointer block hover:-translate-y-1 transition-all duration-300 h-80 bg-gray-150 border border-gray-200">
                            <img src="<?= htmlspecialchars($project['main_image']) ?>" alt="<?= htmlspecialchars($project['image_alt'] ?: $project['title']) ?>" loading="lazy" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-primary via-primary/60 to-transparent opacity-80"></div>
                            <div class="absolute bottom-0 left-0 p-8 w-full translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                <span class="inline-block px-3 py-1 bg-secondary text-white text-xs font-bold rounded-full mb-3"><?= htmlspecialchars($project['client']) ?></span>
                                <h3 class="text-2xl font-bold text-white mb-2"><?= htmlspecialchars($project['title']) ?></h3>
                                <p class="text-gray-300 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100 line-clamp-2 text-sm"><?= htmlspecialchars($project['description']) ?></p>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="w-full text-center py-20 bg-gray-50 rounded-3xl border border-dashed border-gray-200">
                        <p class="text-gray-400 font-medium">Aún no hay proyectos publicados.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="text-center mt-16 animate-fade-in relative z-10">
            <a href="<?= url('proyectos') ?>" class="inline-flex items-center gap-3 px-8 py-4 bg-primary text-white font-bold rounded-2xl hover:bg-secondary shadow-lg shadow-primary/10 hover:shadow-secondary/20 hover:scale-105 active:scale-95 transition-all duration-300">
                Ver Todos los Proyectos
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </a>
        </div>
    </section>

    <!-- Sección de Logos de Clientes (Carrusel Infinito Premium) -->
    <section class="py-24 bg-gray-50 border-t border-b border-gray-100 overflow-hidden relative">
        <div class="container mx-auto px-4 mb-16 text-center">
            <p class="text-xs font-bold tracking-[0.2em] text-secondary uppercase mb-3 animate-fade-in">RESPALDO CORPORATIVO</p>
            <h2 class="text-4xl md:text-5xl font-extrabold text-primary mb-6 animate-fade-in">Confían en Syncro Andina</h2>
            <div class="w-24 h-1.5 bg-secondary mx-auto rounded-full animate-fade-in"></div>
        </div>

        <div class="relative w-full overflow-hidden">
            <!-- Gradientes de desvanecimiento laterales para un efecto Glassmorphism y profundidad -->
            <div class="absolute inset-y-0 left-0 w-32 bg-gradient-to-r from-gray-50 to-transparent z-10 pointer-events-none"></div>
            <div class="absolute inset-y-0 right-0 w-32 bg-gradient-to-l from-gray-50 to-transparent z-10 pointer-events-none"></div>

            <style>
                @keyframes infiniteScroll {
                    0% { transform: translateX(0); }
                    100% { transform: translateX(-50%); }
                }
                .logo-slider-track {
                    display: flex;
                    width: max-content;
                    animation: infiniteScroll <?= htmlspecialchars($settings['clients_slider_speed'] ?? '40s') ?> linear infinite;
                }
            </style>

            <div class="logo-slider-track <?= htmlspecialchars($settings['clients_slider_gap'] ?? 'gap-6') ?> py-4 flex items-center">
                <?php 
                // Si la base de datos está vacía, mostrar logos de demostración espectaculares
                $logosToDisplay = !empty($clientLogos) ? $clientLogos : [
                    ['name' => 'Global Corp', 'logo_path' => '/assets/images/clients/logo1.webp'],
                    ['name' => 'Apex Solutions', 'logo_path' => '/assets/images/clients/logo2.webp'],
                    ['name' => 'NextGen Tech', 'logo_path' => '/assets/images/clients/logo3.webp'],
                    ['name' => 'Innova Tech', 'logo_path' => '/assets/images/clients/logo4.webp'],
                    ['name' => 'Alpha Group', 'logo_path' => '/assets/images/clients/logo5.webp'],
                    ['name' => 'Delta Systems', 'logo_path' => '/assets/images/clients/logo6.webp']
                ];
                // Asegurar que el array tenga suficientes elementos para cubrir pantallas ultra-amplias sin dejar espacios vacíos
                $doubleLogos = [];
                if (!empty($logosToDisplay)) {
                    while (count($doubleLogos) < 24) {
                        $doubleLogos = array_merge($doubleLogos, $logosToDisplay);
                    }
                }
                ?>

                <?php foreach($doubleLogos as $logo): ?>
                    <div class="flex items-center justify-center px-4 grayscale opacity-45 hover:grayscale-0 hover:opacity-100 transition-all duration-300 transform hover:scale-110 cursor-pointer">
                        <?php if (empty($clientLogos)): ?>
                            <!-- Logos Mockup con Texto e Icono Elegante si no se han subido reales -->
                            <div class="flex items-center gap-4 border border-gray-150 bg-white px-8 py-5 rounded-[24px] shadow-md hover:shadow-lg transition-shadow">
                                <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary font-black text-lg">
                                    <?= substr($logo['name'], 0, 1) ?>
                                </div>
                                <span class="text-xl font-black text-primary tracking-tight"><?= htmlspecialchars($logo['name']) ?></span>
                            </div>
                        <?php else: ?>
                            <img src="<?= htmlspecialchars($logo['logo_path']) ?>" alt="<?= htmlspecialchars($logo['image_alt'] ?: $logo['name']) ?>" class="h-16 md:h-20 max-w-[240px] object-contain select-none pointer-events-none">
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Sección de Galería de Fotos Moderna -->
    <?php if(!empty($galleryItems)): ?>
    <section class="py-24 bg-white overflow-hidden relative">
        <div class="container mx-auto px-4 mb-16 text-center">
            <p class="text-sm font-black tracking-widest text-secondary uppercase mb-3 animate-fade-in"><?= htmlspecialchars($settings['gallery_home_tagline'] ?? 'Visualiza Nuestro Trabajo') ?></p>
            <h2 class="text-4xl md:text-5xl font-extrabold text-primary mb-6 animate-fade-in"><?= htmlspecialchars($settings['gallery_home_title'] ?? 'Galería de Excelencia') ?></h2>
            <div class="w-24 h-1.5 bg-secondary mx-auto rounded-full animate-fade-in"></div>
            <p class="text-gray-600 max-w-2xl mx-auto text-lg mt-8 animate-fade-in"><?= htmlspecialchars($settings['gallery_home_subtitle'] ?? 'Descubre en imágenes nuestro compromiso con la precisión, tecnología e innovación.') ?></p>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <!-- Controles Personalizados -->
            <button class="gallery-prev absolute left-0 top-1/2 -translate-y-1/2 -translate-x-2 md:-translate-x-6 w-12 h-12 rounded-full bg-white text-primary shadow-xl border border-gray-100 flex items-center justify-center z-20 hover:bg-primary hover:text-white transition-all active:scale-90 focus:outline-none focus:ring-4 focus:ring-primary/20">
                <svg class="w-6 h-6 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button class="gallery-next absolute right-0 top-1/2 -translate-y-1/2 translate-x-2 md:translate-x-6 w-12 h-12 rounded-full bg-white text-primary shadow-xl border border-gray-100 flex items-center justify-center z-20 hover:bg-primary hover:text-white transition-all active:scale-90 focus:outline-none focus:ring-4 focus:ring-primary/20">
                <svg class="w-6 h-6 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
            </button>

            <!-- Estilo simple para ocultar scrollbar -->
            <style>
                .gallery-track::-webkit-scrollbar { display: none; }
            </style>

            <?php 
            $galCount = count($galleryItems ?? []);
            $justifyGalXl = $galCount <= 3 ? 'xl:justify-center' : '';
            $justifyGalLg = $galCount <= 2 ? 'lg:justify-center' : '';
            $justifyGalSm = $galCount <= 1 ? 'sm:justify-center' : '';
            ?>
            <div class="gallery-track flex gap-6 overflow-x-auto snap-x snap-mandatory pt-2 pb-6 <?= $justifyGalSm ?> <?= $justifyGalLg ?> <?= $justifyGalXl ?>" style="scrollbar-width: none; -ms-overflow-style: none;">
                <?php foreach($galleryItems as $index => $item): ?>
                <div class="snap-start shrink-0 w-[85vw] sm:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)]">
                    <div class="group relative rounded-[2rem] overflow-hidden border border-gray-200 hover:border-primary/40 transition-all duration-300 cursor-pointer home-gallery-trigger hover:-translate-y-1 h-80 bg-gray-100" data-src="<?= asset($item['image_path']) ?>" data-title="<?= htmlspecialchars($item['title'] ?? '') ?>" data-index="<?= $index ?>">
                        <img src="<?= asset($item['image_path']) ?>" alt="<?= htmlspecialchars($item['image_alt'] ?: ($item['title'] ?: 'Syncro Andina Galería')) ?>" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        
                        <!-- Overlay Premium -->
                        <div class="absolute inset-0 bg-gradient-to-t from-primary/90 via-primary/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex flex-col justify-end p-8">
                            <div class="translate-y-4 group-hover:translate-y-0 transition-transform duration-500 ease-out">
                                <div class="w-12 h-12 rounded-full bg-secondary text-white flex items-center justify-center shadow-lg mb-4 opacity-0 group-hover:opacity-100 transition-opacity duration-700 delay-100">
                                    <svg class="w-6 h-6 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                                <?php if(!empty($item['title'])): ?>
                                    <h3 class="text-xl font-extrabold text-white leading-tight"><?= htmlspecialchars($item['title']) ?></h3>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Lightbox Modal para Home Gallery -->
    <div id="home-gallery-lightbox" class="fixed inset-0 z-[60] hidden bg-black/95 backdrop-blur-xl opacity-0 transition-all duration-500 flex items-center justify-center">
        <button onclick="closeHomeLightbox()" class="absolute top-6 right-6 w-12 h-12 rounded-full bg-white/10 text-white hover:bg-red-600 transition-all flex items-center justify-center z-50">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <button onclick="navigateHomeLightbox(-1)" class="absolute left-4 md:left-8 top-1/2 -translate-y-1/2 w-14 h-14 rounded-full bg-white/5 border border-white/10 text-white hover:bg-secondary hover:border-secondary transition-all flex items-center justify-center z-50 shadow-xl backdrop-blur-md">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
        </button>

        <div class="relative max-w-6xl max-h-[85vh] flex flex-col items-center justify-center px-4">
            <img id="h-lightbox-img" src="" class="max-w-full max-h-[75vh] object-contain rounded-2xl shadow-2xl transform scale-90 opacity-0 transition-all duration-500">
            <div class="mt-6 text-center">
                <p id="h-lightbox-title" class="text-white font-extrabold text-xl mb-1"></p>
                <p id="h-lightbox-counter" class="text-secondary font-black text-xs uppercase tracking-widest"></p>
            </div>
        </div>

        <button onclick="navigateHomeLightbox(1)" class="absolute right-4 md:right-8 top-1/2 -translate-y-1/2 w-14 h-14 rounded-full bg-white/5 border border-white/10 text-white hover:bg-secondary hover:border-secondary transition-all flex items-center justify-center z-50 shadow-xl backdrop-blur-md">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
        </button>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const triggers = Array.from(document.querySelectorAll('.home-gallery-trigger'));
        const modal = document.getElementById('home-gallery-lightbox');
        const modalImg = document.getElementById('h-lightbox-img');
        const modalTitle = document.getElementById('h-lightbox-title');
        const modalCounter = document.getElementById('h-lightbox-counter');
        let currentImgIdx = 0;

        if(triggers.length === 0) return;

        function loadImg(index) {
            currentImgIdx = index;
            const src = triggers[currentImgIdx].dataset.src;
            const title = triggers[currentImgIdx].dataset.title;
            
            // Efecto transicion salida
            modalImg.classList.add('scale-90', 'opacity-0');
            
            setTimeout(() => {
                modalImg.src = src;
                modalTitle.textContent = title || '';
                modalCounter.textContent = `${currentImgIdx + 1} / ${triggers.length}`;
                
                modalImg.onload = () => {
                    modalImg.classList.remove('scale-90', 'opacity-0');
                    modalImg.classList.add('scale-100', 'opacity-100');
                };
            }, 200);
        }

        window.openHomeLightbox = (index) => {
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                loadImg(index);
            }, 50);
        };

        window.closeHomeLightbox = () => {
            modal.classList.add('opacity-0');
            modalImg.classList.add('scale-90', 'opacity-0');
            setTimeout(() => modal.classList.add('hidden'), 500);
        };

        window.navigateHomeLightbox = (dir) => {
            let next = (currentImgIdx + dir + triggers.length) % triggers.length;
            loadImg(next);
        };

        triggers.forEach((trigger, idx) => {
            trigger.addEventListener('click', () => openHomeLightbox(idx));
        });

        // Soporte teclado
        document.addEventListener('keydown', (e) => {
            if (modal.classList.contains('hidden')) return;
            if (e.key === 'Escape') closeHomeLightbox();
            if (e.key === 'ArrowRight') navigateHomeLightbox(1);
            if (e.key === 'ArrowLeft') navigateHomeLightbox(-1);
        });
    });
    </script>
    <?php endif; ?>

    <!-- Sección de Blog -->
    <section class="py-24 bg-gray-50 border-t border-gray-100 overflow-hidden relative">
        <div class="container mx-auto px-4 mb-16 text-center">
            <p class="text-sm font-bold tracking-widest text-secondary uppercase mb-3 animate-fade-in"><?= htmlspecialchars($settings['home_blog_tagline'] ?? 'Actualidad y Conocimiento') ?></p>
            <h2 class="text-4xl md:text-5xl font-extrabold text-primary mb-6 animate-fade-in"><?= htmlspecialchars($settings['home_blog_title'] ?? 'Nuestro Blog Corporativo') ?></h2>
            <div class="w-24 h-1.5 bg-secondary mx-auto rounded-full animate-fade-in"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <!-- Controles Personalizados -->
            <button class="blog-prev absolute left-0 top-1/2 -translate-y-1/2 -translate-x-2 md:-translate-x-6 w-12 h-12 rounded-full bg-white text-primary shadow-xl border border-gray-100 flex items-center justify-center z-20 hover:bg-primary hover:text-white transition-all active:scale-90 focus:outline-none focus:ring-4 focus:ring-primary/20">
                <svg class="w-6 h-6 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button class="blog-next absolute right-0 top-1/2 -translate-y-1/2 translate-x-2 md:translate-x-6 w-12 h-12 rounded-full bg-white text-primary shadow-xl border border-gray-100 flex items-center justify-center z-20 hover:bg-primary hover:text-white transition-all active:scale-90 focus:outline-none focus:ring-4 focus:ring-primary/20">
                <svg class="w-6 h-6 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
            </button>

            <!-- Estilo simple para ocultar scrollbar -->
            <style>
                .blog-track::-webkit-scrollbar { display: none; }
            </style>

            <?php 
            $blogCount = count($latestPosts ?? []);
            $justifyBlogXl = $blogCount <= 3 ? 'xl:justify-center' : '';
            $justifyBlogLg = $blogCount <= 2 ? 'lg:justify-center' : '';
            $justifyBlogSm = $blogCount <= 1 ? 'sm:justify-center' : '';
            ?>
            <div class="blog-track flex gap-6 overflow-x-auto snap-x snap-mandatory pt-2 pb-6 <?= $justifyBlogSm ?> <?= $justifyBlogLg ?> <?= $justifyBlogXl ?>" style="scrollbar-width: none; -ms-overflow-style: none;">
                <?php if(!empty($latestPosts)): ?>
                    <?php foreach($latestPosts as $index => $post): ?>
                    <div class="snap-start shrink-0 w-[85vw] sm:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)]">
                        <article class="group bg-white rounded-[2.5rem] p-4 border border-gray-200 hover:border-primary/40 transition-all duration-300 flex flex-col h-full hover:-translate-y-1">
                            <div class="relative overflow-hidden rounded-[2rem] aspect-[16/10] mb-6">
                                <img src="<?= asset($post['image'] ?: 'assets/images/blog-placeholder.jpg') ?>" alt="<?= htmlspecialchars($post['image_alt'] ?: $post['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                <div class="absolute top-4 left-4">
                                    <span class="bg-white/90 backdrop-blur-md text-primary text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-full shadow-sm">
                                        <?= date('d M, Y', strtotime($post['published_at'] ?? $post['created_at'])) ?>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="px-4 pb-4 flex flex-col flex-grow">
                                <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-primary transition-colors line-clamp-2">
                                    <a href="<?= url('blog/' . $post['slug']) ?>"><?= htmlspecialchars($post['title']) ?></a>
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
                                    <a href="<?= url('blog/' . $post['slug']) ?>" class="text-secondary font-black text-xs uppercase tracking-widest hover:underline">Leer más</a>
                                </div>
                            </div>
                        </article>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="w-full py-20 text-center bg-white rounded-[3rem] border border-dashed border-gray-200">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        </div>
                        <p class="text-gray-400 font-medium">Estamos preparando contenido increíble para ti.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="text-center mt-16 animate-fade-in relative z-10">
            <a href="<?= url('blog') ?>" class="inline-flex items-center gap-3 px-8 py-4 bg-primary text-white font-bold rounded-2xl hover:bg-secondary shadow-lg shadow-primary/10 hover:shadow-secondary/20 hover:scale-105 active:scale-95 transition-all duration-300">
                Ver Todos los Artículos
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </a>
        </div>
    </section>

    <?php
    $productsSpeed = (int)($settings['carousel_products_speed'] ?? 3000);
    $servicesSpeed = (int)($settings['carousel_services_speed'] ?? 3000);
    $projectsSpeed = (int)($settings['carousel_projects_speed'] ?? 3000);
    $gallerySpeed = (int)($settings['carousel_gallery_speed'] ?? 3000);
    $blogSpeed = (int)($settings['carousel_blog_speed'] ?? 3000);
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const setups = [
            { track: '.products-track', prev: '.products-prev', next: '.products-next', speed: <?= $productsSpeed ?> },
            { track: '.services-track', prev: '.services-prev', next: '.services-next', speed: <?= $servicesSpeed ?> },
            { track: '.projects-carousel-track', prev: '.projects-carousel-prev', next: '.projects-carousel-next', speed: <?= $projectsSpeed ?> },
            { track: '.gallery-track', prev: '.gallery-prev', next: '.gallery-next', speed: <?= $gallerySpeed ?> },
            { track: '.blog-track', prev: '.blog-prev', next: '.blog-next', speed: <?= $blogSpeed ?> }
        ];

        setups.forEach(setup => {
            const track = document.querySelector(setup.track);
            const prevBtn = document.querySelector(setup.prev);
            const nextBtn = document.querySelector(setup.next);

            if(track && prevBtn && nextBtn) {
                const scrollAmount = () => {
                    const item = track.querySelector('.snap-start');
                    return item ? item.offsetWidth + 24 : 300;
                };

                const doScroll = (direction) => {
                    const amount = scrollAmount();
                    const maxScrollLeft = track.scrollWidth - track.clientWidth;

                    if (direction === 'next') {
                        if (track.scrollLeft >= maxScrollLeft - 10) {
                            track.scrollTo({ left: 0, behavior: 'smooth' });
                        } else {
                            track.scrollBy({ left: amount, behavior: 'smooth' });
                        }
                    } else {
                        if (track.scrollLeft <= 10) {
                            track.scrollTo({ left: maxScrollLeft, behavior: 'smooth' });
                        } else {
                            track.scrollBy({ left: -amount, behavior: 'smooth' });
                        }
                    }
                };

                // Auto-avance automático infinito con velocidad administrable
                let intervalId = setInterval(() => {
                    doScroll('next');
                }, setup.speed);

                const resetInterval = () => {
                    clearInterval(intervalId);
                    intervalId = setInterval(() => {
                        doScroll('next');
                    }, setup.speed);
                };

                // Eventos de Click (Desktop)
                prevBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    doScroll('prev');
                    resetInterval();
                });
                nextBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    doScroll('next');
                    resetInterval();
                });

                // Eventos de Touch (Móviles - Respuesta Instantánea)
                prevBtn.addEventListener('touchstart', (e) => {
                    e.preventDefault();
                    doScroll('prev');
                    resetInterval();
                }, { passive: false });
                nextBtn.addEventListener('touchstart', (e) => {
                    e.preventDefault();
                    doScroll('next');
                    resetInterval();
                }, { passive: false });
            }
        });
    });
    </script>
</main>

<?php $this->component('footer'); ?>
