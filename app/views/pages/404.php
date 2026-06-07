<?php $this->component('header', [
    'title' => $title ?? 'Página No Encontrada',
    'description' => $description ?? null,
    'keywords' => $keywords ?? null
]); ?>
<?php $this->component('navbar'); ?>

<main class="min-h-screen flex items-center justify-center bg-slate-50 relative overflow-hidden pt-20 pb-32">
    <!-- Círculos de fondo con Mesh Gradient para dar profundidad estética -->
    <div class="absolute top-1/4 -left-32 w-96 h-96 bg-primary/10 rounded-full blur-3xl pointer-events-none select-none"></div>
    <div class="absolute bottom-1/4 -right-32 w-96 h-96 bg-secondary/10 rounded-full blur-3xl pointer-events-none select-none"></div>
    <div class="absolute top-10 right-10 w-48 h-48 bg-accent/5 rounded-full blur-2xl pointer-events-none select-none animate-pulse"></div>

    <div class="container mx-auto px-4 relative z-10 text-center">
        <div class="max-w-xl mx-auto">
            <!-- Icono animado interactivo -->
            <div class="mb-8 inline-flex items-center justify-center w-24 h-24 rounded-full bg-red-55/10 border border-red-200/20 text-red-500 shadow-lg shadow-red-500/5 animate-bounce select-none">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>

            <!-- Título 404 Gigante con Gradiente Premium -->
            <h1 class="text-8xl md:text-[10rem] font-black tracking-widest leading-none text-transparent bg-clip-text bg-gradient-to-r from-primary via-secondary to-accent drop-shadow-md select-none hover:scale-105 transition-transform duration-500">
                404
            </h1>

            <!-- Subtítulo Principal -->
            <h2 class="text-2xl md:text-3xl font-extrabold text-slate-800 mt-6 mb-4 tracking-tight leading-tight">
                Página No Encontrada
            </h2>

            <!-- Mensaje Descriptivo Dinámico -->
            <p class="text-slate-500 text-sm md:text-base leading-relaxed mb-10 max-w-md mx-auto">
                <?= htmlspecialchars($message ?? 'El recurso que estás buscando no existe, ha sido movido de ubicación o no se encuentra disponible en este momento.') ?>
            </p>

            <!-- Botones de Acción Interactivos -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="<?= url('') ?>" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 bg-primary text-white font-bold text-sm rounded-2xl hover:bg-secondary shadow-lg shadow-primary/15 hover:shadow-secondary/25 hover:scale-105 active:scale-95 transition-all duration-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Volver al Inicio
                </a>
                <a href="<?= url('contacto') ?>" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 bg-white hover:bg-slate-50 text-slate-700 font-bold text-sm rounded-2xl border border-slate-200 hover:border-slate-300 hover:scale-105 active:scale-95 transition-all duration-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    Soporte Técnico
                </a>
            </div>
        </div>
    </div>
</main>

<?php $this->component('footer'); ?>
