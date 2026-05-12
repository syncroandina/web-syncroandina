<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Administración de Página Nosotros</h2>
            <p class="text-sm text-gray-500 mt-1">Personaliza el contenido, la imagen y la optimización SEO de la sección corporativa de tu sitio.</p>
        </div>
        <a href="/nosotros" target="_blank" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-lg transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            Ver página pública
        </a>
    </div>

    <?php if(isset($_GET['success'])): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-2xl relative mb-6">
            <strong class="font-bold">¡Éxito!</strong>
            <span class="block sm:inline">Los cambios en la página Nosotros se guardaron correctamente.</span>
        </div>
    <?php endif; ?>

    <form action="<?= url('admin/nosotros/save') ?>" method="POST" enctype="multipart/form-data" class="space-y-8">
        <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">

        <!-- Optimización SEO -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-secondary flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Optimización SEO</h3>
                    <p class="text-xs text-gray-500">Configura las etiquetas de búsqueda de Google para favorecer la indexación de esta sección.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest pl-1">Meta Title (Título SEO)</label>
                    <input type="text" name="about_seo_title" value="<?= htmlspecialchars($settings['about_seo_title'] ?? 'La Empresa - Syncro Andina') ?>" placeholder="Título mostrado en pestañas e índices de búsqueda..." class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary text-sm transition-all bg-gray-50 focus:bg-white">
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest pl-1">Meta Keywords (Palabras clave)</label>
                    <input type="text" name="about_seo_keywords" value="<?= htmlspecialchars($settings['about_seo_keywords'] ?? 'transformación digital, desarrollo web, software a medida, aplicaciones corporativas') ?>" placeholder="Separadas por comas (ej. software, andina, tecnología)..." class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary text-sm transition-all bg-gray-50 focus:bg-white">
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest pl-1">Meta Description (Descripción SEO)</label>
                    <textarea name="about_seo_description" rows="3" placeholder="Breve resumen de 150 a 160 caracteres para Google..." class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary text-sm transition-all bg-gray-50 focus:bg-white resize-none"><?= htmlspecialchars($settings['about_seo_description'] ?? 'Syncro Andina: Desarrollo de software premium, transformación digital y modernización cloud para corporaciones.') ?></textarea>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Contenido Principal -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Textos Principales -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-secondary flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Contenido Principal de la Sección</h3>
                            <p class="text-xs text-gray-500">Ajusta el titular destacado y el párrafo de presentación de la empresa.</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest pl-1">Título de Encabezado (H1)</label>
                            <input type="text" name="about_title" value="<?= htmlspecialchars($settings['about_title'] ?? 'Nuestra Visión hacia el Futuro') ?>" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary text-sm transition-all bg-gray-50 focus:bg-white">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest pl-1">Descripción Corporativa</label>
                            <textarea name="about_description" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary text-sm transition-all bg-gray-50 focus:bg-white resize-none"><?= htmlspecialchars($settings['about_description'] ?? 'En Syncro Andina creemos que la tecnología no es solo una herramienta, sino el pilar fundamental que impulsa el crecimiento corporativo sostenible.') ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Misiones e Impacto -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-secondary flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Misión & Impacto</h3>
                            <p class="text-xs text-gray-500">Edita las tarjetas específicas de presentación institucional.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Misión Card -->
                        <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 space-y-4">
                            <div class="text-xs font-black uppercase text-secondary tracking-widest">Tarjeta 1 (Misión)</div>
                            <div class="space-y-2">
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Título</label>
                                <input type="text" name="about_mission_title" value="<?= htmlspecialchars($settings['about_mission_title'] ?? 'Misión 2026') ?>" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 bg-white text-xs font-bold">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Descripción</label>
                                <textarea name="about_mission_desc" rows="3" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 bg-white text-xs leading-relaxed resize-none"><?= htmlspecialchars($settings['about_mission_desc'] ?? 'Elevar los estándares de eficiencia operativa en Latinoamérica a través de consultoría tecnológica estratégica.') ?></textarea>
                            </div>
                        </div>

                        <!-- Impacto Card -->
                        <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 space-y-4">
                            <div class="text-xs font-black uppercase text-secondary tracking-widest">Tarjeta 2 (Impacto)</div>
                            <div class="space-y-2">
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Título</label>
                                <input type="text" name="about_impact_title" value="<?= htmlspecialchars($settings['about_impact_title'] ?? 'Impacto Global') ?>" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 bg-white text-xs font-bold">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Descripción</label>
                                <textarea name="about_impact_desc" rows="3" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 bg-white text-xs leading-relaxed resize-none"><?= htmlspecialchars($settings['about_impact_desc'] ?? 'Más de 500 proyectos corporativos entregados con éxito, optimizando la cadena de valor de empresas líderes.') ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Imagen Destacada -->
            <div class="lg:col-span-1 space-y-8">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex flex-col h-full">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-secondary flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Imagen de Portada</h3>
                            <p class="text-xs text-gray-500">Selecciona el banner destacado.</p>
                        </div>
                    </div>

                    <div class="space-y-6 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="relative group rounded-2xl overflow-hidden border border-gray-100 shadow-sm aspect-[4/3] bg-gray-50 flex flex-col items-center justify-center cursor-pointer mb-6" onclick="document.getElementById('about-img-file').click()">
                                <?php 
                                $imgSrc = $settings['about_image'] ?? 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80';
                                if (str_starts_with($imgSrc, '//')) {
                                    $imgSrc = '/' . ltrim($imgSrc, '/');
                                }
                                ?>
                                <img id="about-img-preview" src="<?= htmlspecialchars($imgSrc) ?>" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white text-xs font-bold gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                    Reemplazar Imagen
                                </div>
                            </div>
                            <input type="file" name="about_image" id="about-img-file" class="hidden" accept="image/*" onchange="previewAboutImage(this)">

                            <div class="space-y-4">
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Título de Superposición</label>
                                    <input type="text" name="about_image_title" value="<?= htmlspecialchars($settings['about_image_title'] ?? 'Nuestro Equipo') ?>" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 text-xs font-bold bg-gray-50 focus:bg-white">
                                </div>

                                <div class="space-y-1">
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Subtítulo de Superposición</label>
                                    <input type="text" name="about_image_subtitle" value="<?= htmlspecialchars($settings['about_image_subtitle'] ?? 'Expertos en transformación digital') ?>" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 text-xs bg-gray-50 focus:bg-white">
                                </div>

                                <div class="space-y-1">
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Texto Alternativo (SEO ALT)</label>
                                    <input type="text" name="about_image_alt" value="<?= htmlspecialchars($settings['about_image_alt'] ?? 'Equipo corporativo de Syncro Andina trabajando juntos') ?>" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 text-xs bg-gray-50 focus:bg-white" placeholder="Ej: Ingenieros trabajando en oficina">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full mt-8 bg-secondary text-white py-4 rounded-xl font-bold hover:bg-blue-600 transition-all shadow-lg shadow-secondary/20 flex justify-center items-center gap-2 group">
                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            Guardar Configuración
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function previewAboutImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('about-img-preview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
