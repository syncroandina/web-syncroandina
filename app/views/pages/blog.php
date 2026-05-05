<?php $this->component('header', ['title' => $title ?? 'Blog']); ?>
<?php $this->component('navbar'); ?>

<main class="min-h-screen bg-gray-50 pt-20 pb-32">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6 animate-fade-in-up">
            <div class="max-w-2xl">
                <h1 class="text-4xl md:text-5xl font-extrabold text-primary mb-4">Blog Corporativo</h1>
                <p class="text-xl text-gray-600">Últimas noticias, artículos y tendencias sobre innovación, tecnología y transformación digital.</p>
            </div>
            <div class="w-full md:w-auto">
                <div class="relative">
                    <input type="text" placeholder="Buscar artículos..." class="w-full md:w-72 pl-12 pr-4 py-3.5 rounded-xl border-none shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary transition-all bg-white">
                    <svg class="w-5 h-5 text-gray-400 absolute left-4 top-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            <!-- Destacado (Ocupa 2 columnas en Desktop) -->
            <article class="col-span-1 lg:col-span-2 bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-shadow duration-500 border border-gray-100 flex flex-col md:flex-row animate-fade-in-up">
                <div class="md:w-1/2">
                    <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" alt="Tech" class="w-full h-64 md:h-full object-cover">
                </div>
                <div class="md:w-1/2 p-10 flex flex-col justify-center">
                    <div class="flex items-center gap-3 mb-4 text-sm text-gray-500 font-medium">
                        <span class="text-secondary font-bold">Innovación</span>
                        <span>&bull;</span>
                        <span>04 de Mayo, 2026</span>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4 hover:text-secondary transition-colors cursor-pointer">El impacto de la Inteligencia Artificial en la toma de decisiones directivas</h2>
                    <p class="text-gray-600 mb-8 leading-relaxed line-clamp-3">Descubre cómo los algoritmos predictivos están redefiniendo las estrategias a nivel gerencial en las grandes corporaciones de la región andina y el mundo entero, optimizando el retorno de inversión.</p>
                    <a href="#" class="inline-flex items-center text-primary font-bold hover:text-secondary transition-colors mt-auto">
                        Leer artículo completo <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </article>

            <!-- Regular post 1 -->
            <article class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-shadow duration-300 border border-gray-100 flex flex-col animate-fade-in-up">
                <img src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Cybersecurity" class="w-full h-56 object-cover">
                <div class="p-8 flex flex-col flex-grow">
                    <div class="flex items-center gap-3 mb-3 text-sm text-gray-500 font-medium">
                        <span class="text-accent font-bold">Seguridad</span>
                        <span>&bull;</span>
                        <span>28 de Abril, 2026</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 hover:text-secondary transition-colors cursor-pointer">Nuevos estándares Zero-Trust para entornos híbridos</h3>
                    <p class="text-gray-600 mb-6 line-clamp-3">Implementar arquitecturas Zero-Trust ya no es una opción, es una necesidad absoluta ante el auge del trabajo híbrido...</p>
                    <a href="#" class="inline-flex items-center text-sm font-bold text-secondary mt-auto">Leer más</a>
                </div>
            </article>

            <!-- Regular post 2 -->
            <article class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-shadow duration-300 border border-gray-100 flex flex-col animate-fade-in-up">
                <img src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Cloud" class="w-full h-56 object-cover">
                <div class="p-8 flex flex-col flex-grow">
                    <div class="flex items-center gap-3 mb-3 text-sm text-gray-500 font-medium">
                        <span class="text-primary font-bold">Cloud</span>
                        <span>&bull;</span>
                        <span>15 de Abril, 2026</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 hover:text-secondary transition-colors cursor-pointer">La evolución del Multicloud en ecosistemas empresariales</h3>
                    <p class="text-gray-600 mb-6 line-clamp-3">Estrategias efectivas para gestionar proveedores de nube múltiple sin perder el control sobre los costos de infraestructura...</p>
                    <a href="#" class="inline-flex items-center text-sm font-bold text-secondary mt-auto">Leer más</a>
                </div>
            </article>
        </div>
    </div>
</main>

<?php $this->component('footer'); ?>
