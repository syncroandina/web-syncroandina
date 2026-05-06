<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Administración de Página Contacto</h2>
            <p class="text-sm text-gray-500 mt-1">Configura el contenido del bloque informativo, el formulario y los parámetros SEO de la sección de contacto.</p>
        </div>
        <a href="/contacto" target="_blank" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-lg transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            Ver página pública
        </a>
    </div>

    <?php if(isset($_GET['success'])): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-2xl relative mb-6">
            <strong class="font-bold">¡Éxito!</strong>
            <span class="block sm:inline">Los cambios en la página de Contacto se guardaron correctamente.</span>
        </div>
    <?php endif; ?>

    <form action="<?= url('admin/contacto/save') ?>" method="POST" class="space-y-8">
        <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">

        <!-- Optimización SEO -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-secondary flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Optimización SEO</h3>
                    <p class="text-xs text-gray-500">Configura las etiquetas que Google utiliza para indexar y posicionar la sección de contacto.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest pl-1">Meta Title (Título SEO)</label>
                    <input type="text" name="contact_seo_title" value="<?= htmlspecialchars($settings['contact_seo_title'] ?? 'Contacto - Syncro Andina') ?>" placeholder="Título mostrado en la pestaña del navegador..." class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary text-sm transition-all bg-gray-50 focus:bg-white">
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest pl-1">Meta Keywords (Palabras clave)</label>
                    <input type="text" name="contact_seo_keywords" value="<?= htmlspecialchars($settings['contact_seo_keywords'] ?? 'contacto, cotización, soporte corporativo, syncro andina') ?>" placeholder="Separadas por comas (ej. contacto, soporte, software)..." class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary text-sm transition-all bg-gray-50 focus:bg-white">
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest pl-1">Meta Description (Descripción SEO)</label>
                    <textarea name="contact_seo_description" rows="3" placeholder="Descripción breve de la sección de contacto para Google..." class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary text-sm transition-all bg-gray-50 focus:bg-white resize-none"><?= htmlspecialchars($settings['contact_seo_description'] ?? 'Ponte en contacto con Syncro Andina. Solicita información comercial o de soporte técnico para escalar la tecnología de tu empresa.') ?></textarea>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Bloque Informativo de Contacto -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-secondary flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Bloque de Información Lateral</h3>
                            <p class="text-xs text-gray-500">Configura los títulos, textos y datos directos que aparecen sobre el fondo oscuro.</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest pl-1">Título de Encabezado</label>
                                <input type="text" name="contact_heading" value="<?= htmlspecialchars($settings['contact_heading'] ?? 'Hablemos de negocios') ?>" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 text-sm transition-all bg-gray-50 focus:bg-white">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest pl-1">Título del Formulario</label>
                                <input type="text" name="contact_form_heading" value="<?= htmlspecialchars($settings['contact_form_heading'] ?? 'Envíanos un mensaje') ?>" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 text-sm transition-all bg-gray-50 focus:bg-white">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest pl-1">Descripción del Bloque</label>
                            <textarea name="contact_description" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 text-sm transition-all bg-gray-50 focus:bg-white resize-none"><?= htmlspecialchars($settings['contact_description'] ?? 'Ponte en contacto con nuestro equipo comercial para agendar una consultoría de evaluación y escalar la tecnología de tu empresa.') ?></textarea>
                        </div>

                        <hr class="border-gray-100 my-6">

                        <!-- Datos Directos -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Sede Central -->
                            <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 space-y-3">
                                <div class="text-xs font-black uppercase text-secondary tracking-widest">Sede Central</div>
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Etiqueta</label>
                                    <input type="text" name="contact_address_label" value="<?= htmlspecialchars($settings['contact_address_label'] ?? 'Sede Central') ?>" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 bg-white text-xs font-bold">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Dirección</label>
                                    <textarea name="contact_address_value" rows="2" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 bg-white text-xs resize-none"><?= htmlspecialchars($settings['contact_address_value'] ?? "Torre Empresarial Andina, Piso 12\nBogotá, Colombia") ?></textarea>
                                </div>
                            </div>

                            <!-- Correo -->
                            <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 space-y-3">
                                <div class="text-xs font-black uppercase text-secondary tracking-widest">Correo</div>
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Etiqueta</label>
                                    <input type="text" name="contact_email_label" value="<?= htmlspecialchars($settings['contact_email_label'] ?? 'Correo Corporativo') ?>" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 bg-white text-xs font-bold">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Email</label>
                                    <input type="text" name="contact_email_value" value="<?= htmlspecialchars($settings['contact_email_value'] ?? 'contacto@syncroandina.com') ?>" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 bg-white text-xs">
                                </div>
                            </div>

                            <!-- Teléfono -->
                            <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 space-y-3">
                                <div class="text-xs font-black uppercase text-secondary tracking-widest">Teléfono</div>
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Etiqueta</label>
                                    <input type="text" name="contact_phone_label" value="<?= htmlspecialchars($settings['contact_phone_label'] ?? 'Línea de Atención') ?>" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 bg-white text-xs font-bold">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Número</label>
                                    <input type="text" name="contact_phone_value" value="<?= htmlspecialchars($settings['contact_phone_value'] ?? '+57 300 123 4567') ?>" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 bg-white text-xs">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botón Guardar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex flex-col justify-center sticky top-24">
                    <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4 text-xs text-blue-700 leading-relaxed mb-6">
                        <strong class="block font-bold mb-1">¡Consejo SEO!</strong>
                        Recuerda incluir palabras como "Bogotá", "Colombia" o "Soporte Técnico" en la descripción y etiquetas para fortalecer la búsqueda local de tu empresa.
                    </div>
                    
                    <button type="submit" class="w-full bg-secondary text-white py-4 rounded-xl font-bold hover:bg-blue-600 transition-all shadow-lg shadow-secondary/20 flex justify-center items-center gap-2 group">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Guardar Configuración
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
