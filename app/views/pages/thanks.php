<?php $this->component('header', [
    'title' => $title ?? '¡Muchas Gracias! - Syncro Andina',
    'description' => $description ?? null,
    'keywords' => $keywords ?? null
]); ?>
<?php $this->component('navbar'); ?>

<main class="min-h-[75vh] bg-gray-50 flex items-center justify-center relative overflow-hidden py-16 px-4">
    <!-- Fondos Blur Decorativos (Glassmorphism blobs) -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none -z-10 opacity-60">
        <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full bg-blue-100 blur-3xl animate-pulse" style="animation-duration: 8s;"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 rounded-full bg-indigo-100 blur-3xl animate-pulse" style="animation-duration: 10s;"></div>
    </div>

    <div class="max-w-xl w-full text-center relative z-10">
        <!-- Icono de Éxito Premium Animado -->
        <div class="relative w-28 h-28 mx-auto mb-8">
            <!-- Círculos de fondo con pulsaciones -->
            <div class="absolute inset-0 bg-green-100 rounded-full scale-100 animate-ping opacity-25"></div>
            <div class="absolute inset-2 bg-green-50 rounded-full scale-105 opacity-70"></div>
            <div class="absolute inset-4 bg-green-500 rounded-full shadow-lg shadow-green-500/30 flex items-center justify-center transform transition-transform hover:scale-110 duration-300">
                <svg class="w-12 h-12 text-white animate-[bounce_1.5s_infinite]" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="animation-iteration-count: 1;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>

        <!-- Encabezado de la página -->
        <h1 class="text-4xl md:text-5xl font-black text-gray-900 tracking-tight leading-none mb-4">
            ¡Muchas Gracias!
        </h1>
        <p class="text-lg md:text-xl font-bold text-secondary mb-3">
            Tu mensaje ha sido enviado con éxito
        </p>
        <p class="text-sm md:text-base text-gray-500 max-w-md mx-auto leading-relaxed mb-10">
            Un especialista de nuestro equipo revisará tu solicitud y se pondrá en contacto contigo a la brevedad para brindarte una asesoría personalizada.
        </p>

        <!-- Botones de Acción de Alta Gama -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="/" class="w-full sm:w-auto px-8 py-4 bg-primary hover:bg-secondary text-white text-sm font-extrabold rounded-2xl transition-all duration-300 shadow-xl shadow-primary/10 hover:shadow-secondary/20 hover:-translate-y-0.5 flex items-center justify-center gap-2 group">
                <svg class="w-4 h-4 text-gray-200 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al Inicio
            </a>
            <a href="/servicios" class="w-full sm:w-auto px-8 py-4 bg-white border border-gray-200 hover:border-gray-300 text-gray-700 text-sm font-bold rounded-2xl transition-all duration-300 hover:bg-gray-50 hover:-translate-y-0.5 flex items-center justify-center gap-2">
                Explorar Servicios
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
</main>

<?php $this->component('footer'); ?>
