<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Llamada a la Acción (CTA) de Inicio</h2>
            <p class="text-sm text-gray-500 mt-1">Configura los textos, enlaces y botones de la sección destacada de llamada a la acción en la página de inicio.</p>
        </div>
        <a href="/" target="_blank" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-lg transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            Ver página de inicio
        </a>
    </div>

    <?php if(isset($_GET['success']) && $_GET['success'] === 'cta_saved'): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-2xl relative mb-6 shadow-sm flex items-center gap-3 animate-fade-in">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="block sm:inline font-medium">¡Configuración del CTA guardada con éxito!</span>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden animate-fade-in-up">
        <form action="<?= url('admin/cta/save') ?>" method="POST" class="p-8 space-y-6">
            <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Columna Izquierda: Mensajes Principales -->
                <div class="space-y-5">
                    <div class="border-b border-gray-100 pb-3">
                        <span class="text-xs font-extrabold text-secondary uppercase tracking-widest">1. Mensajes Destacados</span>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Etiqueta Superior (Tagline)</label>
                        <input type="text" name="home_cta_tagline" value="<?= htmlspecialchars($settings['home_cta_tagline'] ?? '¿Listo para transformar tu empresa?') ?>" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm transition-all bg-gray-50 focus:bg-white" placeholder="Ej: ¿Listo para transformar tu empresa?">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Título de Impacto (Headline) <span class="text-gray-400 capitalize font-medium text-[11px]">(Soporta etiquetas HTML como &lt;br&gt; y &lt;span&gt; para resaltados)</span></label>
                        <textarea name="home_cta_headline" rows="3" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm transition-all bg-gray-50 focus:bg-white resize-none leading-relaxed" placeholder="Ej: Impulsa tu negocio con <br> <span class='text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300'>tecnología de vanguardia</span>"><?= htmlspecialchars($settings['home_cta_headline'] ?? 'Impulsa tu negocio con <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">tecnología de vanguardia</span>') ?></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Descripción de la Sección</label>
                        <textarea name="home_cta_description" rows="3" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm transition-all bg-gray-50 focus:bg-white resize-none leading-relaxed" placeholder="Ej: Nuestro equipo de expertos está listo para ayudarte..."><?= htmlspecialchars($settings['home_cta_description'] ?? 'Nuestro equipo de expertos está listo para ayudarte a encontrar las mejores soluciones tecnológicas para tus necesidades empresariales.') ?></textarea>
                    </div>
                </div>

                <!-- Columna Derecha: Botones de Acción -->
                <div class="space-y-5">
                    <div class="border-b border-gray-100 pb-3">
                        <span class="text-xs font-extrabold text-secondary uppercase tracking-widest">2. Acciones y Enlaces</span>
                    </div>

                    <div class="p-5 bg-gray-50 border border-gray-100 rounded-3xl space-y-4">
                        <span class="text-xs font-black text-primary uppercase tracking-wider block">Botón Principal (Relleno Azul/Celeste)</span>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5 pl-1">Texto del Botón</label>
                                <input type="text" name="home_cta_btn1_title" value="<?= htmlspecialchars($settings['home_cta_btn1_title'] ?? 'Consulta Gratuita') ?>" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-3.5 text-sm transition-all bg-white" placeholder="Ej: Consulta Gratuita">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5 pl-1">Enlace / Ruta</label>
                                <input type="text" name="home_cta_btn1_url" value="<?= htmlspecialchars($settings['home_cta_btn1_url'] ?? '/contacto') ?>" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-3.5 text-sm transition-all bg-white" placeholder="Ej: /contacto">
                            </div>
                        </div>
                    </div>

                    <div class="p-5 bg-gray-50 border border-gray-100 rounded-3xl space-y-4">
                        <span class="text-xs font-black text-primary uppercase tracking-wider block">Botón Secundario (Translúcido / Outline)</span>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5 pl-1">Texto del Botón</label>
                                <input type="text" name="home_cta_btn2_title" value="<?= htmlspecialchars($settings['home_cta_btn2_title'] ?? 'Ver Catálogo') ?>" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-3.5 text-sm transition-all bg-white" placeholder="Ej: Ver Catálogo">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5 pl-1">Enlace / Ruta</label>
                                <input type="text" name="home_cta_btn2_url" value="<?= htmlspecialchars($settings['home_cta_btn2_url'] ?? '/servicios') ?>" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-3.5 text-sm transition-all bg-white" placeholder="Ej: /servicios">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-gray-100">
                <button type="submit" class="px-8 py-4 bg-primary hover:bg-secondary text-white rounded-2xl font-bold transition-all shadow-lg shadow-primary/30 hover:shadow-secondary/30 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Guardar Configuración CTA
                </button>
            </div>
        </form>
    </div>
</div>
