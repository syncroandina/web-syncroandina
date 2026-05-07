<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Administración de Pie de Página</h2>
            <p class="text-sm text-gray-500 mt-1">Configura la descripción de la marca y administra los enlaces de redes sociales que aparecen en el pie de página de la web.</p>
        </div>
        <a href="/" target="_blank" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-lg transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            Ver sitio público
        </a>
    </div>

    <?php if(isset($_GET['success'])): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-2xl relative mb-6">
            <strong class="font-bold">¡Éxito!</strong>
            <span class="block sm:inline">Los cambios en el Pie de Página se guardaron correctamente.</span>
        </div>
    <?php endif; ?>

    <form action="<?= url('admin/pie-pagina/save') ?>" method="POST" class="space-y-8">
        <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Bloque Informativo de Contacto -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Textos e Identidad del Footer -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-secondary flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Identidad y Textos del Footer</h3>
                            <p class="text-xs text-gray-500">Configura los textos corporativos principales que aparecen en las columnas del pie de página.</p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest pl-1">Nombre de la Marca</label>
                            <input type="text" name="footer_brand_name" value="<?= htmlspecialchars($settings['footer_brand_name'] ?? 'Syncro Andina') ?>" placeholder="Syncro Andina" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 text-sm transition-all bg-gray-50 focus:bg-white">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest pl-1">Descripción del Footer</label>
                            <textarea name="footer_description" rows="3" placeholder="Escribe aquí el texto del footer..." class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 text-sm transition-all bg-gray-50 focus:bg-white resize-none"><?= htmlspecialchars($settings['footer_description'] ?? 'Transformando negocios con soluciones tecnológicas innovadoras. Llevamos tu corporación al siguiente nivel de eficiencia y seguridad.') ?></textarea>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest pl-1">Texto de Derechos Reservados (Copyright)</label>
                            <input type="text" name="footer_copyright" value="<?= htmlspecialchars($settings['footer_copyright'] ?? '© 2026 Syncro Andina. Todos los derechos reservados.') ?>" placeholder="© 2026 Syncro Andina. Todos los derechos reservados." class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 text-sm transition-all bg-gray-50 focus:bg-white">
                        </div>
                    </div>
                </div>

                <!-- Enlaces Rápidos -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-secondary flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Enlaces Rápidos (Footer)</h3>
                            <p class="text-xs text-gray-500">Configura el título de la columna y los enlaces rápidos del pie de página.</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest pl-1">Título de la Columna</label>
                            <input type="text" name="footer_menu_heading" value="<?= htmlspecialchars($settings['footer_menu_heading'] ?? 'Enlaces Rápidos') ?>" placeholder="Enlaces Rápidos" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 text-sm transition-all bg-gray-50 focus:bg-white">
                        </div>

                        <div class="border-t border-gray-100 pt-4 mt-4">
                            <h4 class="text-sm font-bold text-gray-700 mb-1">Enlaces del Menú</h4>
                            <p class="text-xs text-gray-400 mb-4 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-secondary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Arrastra y suelta las tarjetas con el icono de la izquierda para reordenar los enlaces rápidos.
                            </p>
                            
                            <div class="space-y-3" id="sortable-footer-links">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100 hover:border-gray-200 hover:bg-gray-50/50 transition-all cursor-move drag-row group">
                                        <!-- Drag handle -->
                                        <div class="text-gray-300 group-hover:text-secondary drag-handle transition-colors shrink-0 p-1">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                        </div>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 flex-grow">
                                            <div class="space-y-1">
                                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider pl-1">Título del Enlace</label>
                                                <input type="text" name="footer_link_titles[]" value="<?= htmlspecialchars($settings['footer_link_title_'.$i] ?? '') ?>" placeholder="Ej: Nosotros" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 text-xs bg-white">
                                            </div>
                                            <div class="space-y-1">
                                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider pl-1">URL / Ruta de destino</label>
                                                <input type="text" name="footer_link_urls[]" value="<?= htmlspecialchars($settings['footer_link_url_'.$i] ?? '') ?>" placeholder="Ej: /nosotros" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 text-xs bg-white">
                                            </div>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Redes Sociales -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-secondary flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Enlaces de Redes Sociales</h3>
                            <p class="text-xs text-gray-500">Configura las URLs de tus perfiles oficiales. Si dejas un campo vacío, ese icono no se mostrará.</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- LinkedIn -->
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex items-center gap-4">
                            <div class="w-10 h-10 bg-[#0077b5] text-white rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.779-1.75-1.75s.784-1.75 1.75-1.75 1.75.779 1.75 1.75-.784 1.75-1.75 1.75zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            </div>
                            <div class="flex-grow space-y-1">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest pl-1">LinkedIn URL</label>
                                <input type="text" name="footer_linkedin" value="<?= htmlspecialchars($settings['footer_linkedin'] ?? 'https://linkedin.com/company/syncroandina') ?>" placeholder="https://linkedin.com/in/usuario" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 text-xs bg-white">
                            </div>
                        </div>

                        <!-- Facebook -->
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex items-center gap-4">
                            <div class="w-10 h-10 bg-[#1877f2] text-white rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </div>
                            <div class="flex-grow space-y-1">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest pl-1">Facebook URL</label>
                                <input type="text" name="footer_facebook" value="<?= htmlspecialchars($settings['footer_facebook'] ?? 'https://facebook.com/syncroandina') ?>" placeholder="https://facebook.com/pagina" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 text-xs bg-white">
                            </div>
                        </div>

                        <!-- Instagram -->
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex items-center gap-4">
                            <div class="w-10 h-10 bg-[#e1306c] text-white rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                            </div>
                            <div class="flex-grow space-y-1">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest pl-1">Instagram URL</label>
                                <input type="text" name="footer_instagram" value="<?= htmlspecialchars($settings['footer_instagram'] ?? 'https://instagram.com/syncroandina') ?>" placeholder="https://instagram.com/perfil" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 text-xs bg-white">
                            </div>
                        </div>

                        <!-- Twitter / X -->
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex items-center gap-4">
                            <div class="w-10 h-10 bg-black text-white rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            </div>
                            <div class="flex-grow space-y-1">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest pl-1">Twitter / X URL</label>
                                <input type="text" name="footer_twitter" value="<?= htmlspecialchars($settings['footer_twitter'] ?? 'https://twitter.com/syncroandina') ?>" placeholder="https://x.com/usuario" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 text-xs bg-white">
                            </div>
                        </div>

                        <!-- YouTube -->
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex items-center gap-4">
                            <div class="w-10 h-10 bg-[#ff0000] text-white rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.163a3.003 3.003 0 00-2.11-2.107C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.388.511a3.003 3.003 0 00-2.11 2.107C0 8.046 0 12 0 12s0 3.954.502 5.837a3.003 3.003 0 002.11 2.107c1.883.511 9.388.511 9.388.511s7.505 0 9.388-.511a3.003 3.003 0 002.11-2.107C24 15.954 24 12 24 12s0-3.954-.502-5.837zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            </div>
                            <div class="flex-grow space-y-1">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest pl-1">YouTube URL</label>
                                <input type="text" name="footer_youtube" value="<?= htmlspecialchars($settings['footer_youtube'] ?? 'https://youtube.com/c/syncroandina') ?>" placeholder="https://youtube.com/c/canal" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 text-xs bg-white">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botón Guardar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex flex-col justify-center sticky top-24">
                    <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4 text-xs text-blue-700 leading-relaxed mb-6">
                        <strong class="block font-bold mb-1">💡 Redes Sociales</strong>
                        Vincular tus redes sociales oficiales aumenta el PageRank, mejora la confianza del usuario y consolida tu presencia de marca en motores de búsqueda.
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

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var el = document.getElementById('sortable-footer-links');
    if (el) {
        Sortable.create(el, {
            handle: '.drag-handle',
            animation: 150,
            ghostClass: 'bg-blue-50/50',
            forceFallback: true
        });
    }
});
</script>
