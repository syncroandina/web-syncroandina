<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Administración de Página Inicio</h2>
            <p class="text-sm text-gray-500 mt-1">Configura los parámetros globales de la optimización SEO para la página de Inicio.</p>
        </div>
        <a href="/" target="_blank" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-lg transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            Ver página pública
        </a>
    </div>

    <?php if(isset($_GET['success'])): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-2xl relative mb-6">
            <strong class="font-bold">¡Éxito!</strong>
            <span class="block sm:inline">Los cambios en la página de Inicio se guardaron correctamente.</span>
        </div>
    <?php endif; ?>

    <form action="<?= url('admin/inicio/save') ?>" method="POST" class="max-w-4xl">
        <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">

        <!-- Optimización SEO -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 space-y-6">
            <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-secondary flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Optimización SEO</h3>
                    <p class="text-xs text-gray-500">Configura los metadatos principales que Google y otros buscadores usan para indexar la página de Inicio.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest pl-1">Meta Title (Título SEO)</label>
                    <input type="text" name="home_seo_title" value="<?= htmlspecialchars($settings['home_seo_title'] ?? 'Inicio - Syncro Andina') ?>" placeholder="Título mostrado en la pestaña del navegador..." class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary text-sm transition-all bg-gray-50 focus:bg-white">
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest pl-1">Meta Keywords (Palabras clave)</label>
                    <input type="text" name="home_seo_keywords" value="<?= htmlspecialchars($settings['home_seo_keywords'] ?? 'transformación digital, desarrollo web, software a medida, aplicaciones corporativas') ?>" placeholder="Separadas por comas (ej. software, andina, tecnología)..." class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary text-sm transition-all bg-gray-50 focus:bg-white">
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest pl-1">Meta Description (Descripción SEO)</label>
                    <textarea name="home_seo_description" rows="3" placeholder="Breve resumen de 150 a 160 caracteres para Google..." class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary text-sm transition-all bg-gray-50 focus:bg-white resize-none"><?= htmlspecialchars($settings['home_seo_description'] ?? 'Syncro Andina: Desarrollo de software premium, transformación digital y modernización cloud para corporaciones.') ?></textarea>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="text-xs text-blue-700 bg-blue-50 border border-blue-100 rounded-xl p-3 flex-1">
                    <strong class="font-bold">¡Consejo SEO!</strong>
                    La página de inicio es la más importante para la reputación de tu dominio. Asegúrate de incluir la palabra clave principal de tu marca en el Meta Title y en la descripción.
                </div>
                <button type="submit" class="bg-secondary text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-600 transition-all shadow-lg shadow-secondary/20 flex justify-center items-center gap-2 group whitespace-nowrap self-stretch sm:self-auto">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Guardar Configuración
                </button>
            </div>
        </div>
    </form>
</div>
