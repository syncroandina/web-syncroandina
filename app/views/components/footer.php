<?php
$settingModel = new \App\Models\Setting();
$settings = $settingModel->getAll();

// Defaults for social media (visible by default, hidden only if saved as empty string)
$linkedin = isset($settings['footer_linkedin']) ? $settings['footer_linkedin'] : 'https://linkedin.com/company/syncroandina';
$facebook = isset($settings['footer_facebook']) ? $settings['footer_facebook'] : 'https://facebook.com/syncroandina';
$instagram = isset($settings['footer_instagram']) ? $settings['footer_instagram'] : 'https://instagram.com/syncroandina';
$twitter = isset($settings['footer_twitter']) ? $settings['footer_twitter'] : 'https://twitter.com/syncroandina';
$youtube = isset($settings['footer_youtube']) ? $settings['footer_youtube'] : 'https://youtube.com/c/syncroandina';
?>
    <footer class="bg-primary text-gray-300 py-12 mt-20 border-t border-gray-800">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div class="col-span-1 md:col-span-2">
                    <h2 class="text-2xl font-bold text-white mb-4"><?= htmlspecialchars($settings['footer_brand_name'] ?? $settings['identity_name'] ?? 'Syncro Andina') ?></h2>
                    <p class="max-w-md text-gray-400"><?= htmlspecialchars($settings['footer_description'] ?? 'Transformando negocios con soluciones tecnológicas innovadoras. Llevamos tu corporación al siguiente nivel de eficiencia y seguridad.') ?></p>
                    
                    <?php if(!empty($linkedin) || !empty($facebook) || !empty($instagram) || !empty($twitter) || !empty($youtube)): ?>
                    <div class="flex items-center gap-4 mt-6">
                        <?php if(!empty($linkedin)): ?>
                            <a href="<?= htmlspecialchars($linkedin) ?>" target="_blank" class="w-10 h-10 rounded-xl bg-white/5 hover:bg-[#0077b5] text-gray-400 hover:text-white flex items-center justify-center transition-all duration-300 border border-white/10" title="LinkedIn">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.779-1.75-1.75s.784-1.75 1.75-1.75 1.75.779 1.75 1.75-.784 1.75-1.75 1.75zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            </a>
                        <?php endif; ?>
                        <?php if(!empty($facebook)): ?>
                            <a href="<?= htmlspecialchars($facebook) ?>" target="_blank" class="w-10 h-10 rounded-xl bg-white/5 hover:bg-[#1877f2] text-gray-400 hover:text-white flex items-center justify-center transition-all duration-300 border border-white/10" title="Facebook">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                        <?php endif; ?>
                        <?php if(!empty($instagram)): ?>
                            <a href="<?= htmlspecialchars($instagram) ?>" target="_blank" class="w-10 h-10 rounded-xl bg-white/5 hover:bg-[#e1306c] text-gray-400 hover:text-white flex items-center justify-center transition-all duration-300 border border-white/10" title="Instagram">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                            </a>
                        <?php endif; ?>
                        <?php if(!empty($twitter)): ?>
                            <a href="<?= htmlspecialchars($twitter) ?>" target="_blank" class="w-10 h-10 rounded-xl bg-white/5 hover:bg-black text-gray-400 hover:text-white flex items-center justify-center transition-all duration-300 border border-white/10" title="Twitter / X">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            </a>
                        <?php endif; ?>
                        <?php if(!empty($youtube)): ?>
                            <a href="<?= htmlspecialchars($youtube) ?>" target="_blank" class="w-10 h-10 rounded-xl bg-white/5 hover:bg-[#ff0000] text-gray-400 hover:text-white flex items-center justify-center transition-all duration-300 border border-white/10" title="YouTube">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.163a3.003 3.003 0 00-2.11-2.107C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.388.511a3.003 3.003 0 00-2.11 2.107C0 8.046 0 12 0 12s0 3.954.502 5.837a3.003 3.003 0 002.11 2.107c1.883.511 9.388.511 9.388.511s7.505 0 9.388-.511a3.003 3.003 0 002.11-2.107C24 15.954 24 12 24 12s0-3.954-.502-5.837zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            </a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4"><?= htmlspecialchars($settings['footer_menu_heading'] ?? 'Enlaces Rápidos') ?></h3>
                    <ul class="space-y-2">
                        <?php 
                        for($i = 1; $i <= 5; $i++):
                            if(!empty($settings['footer_link_title_'.$i]) && !empty($settings['footer_link_url_'.$i])):
                                ?>
                                <li><a href="<?= htmlspecialchars($settings['footer_link_url_'.$i]) ?>" class="hover:text-secondary transition-colors"><?= htmlspecialchars($settings['footer_link_title_'.$i]) ?></a></li>
                                <?php
                            endif;
                        endfor;
                        ?>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-white mb-6">Contacto</h3>
                    <div class="space-y-4">
                        <!-- Sede / Dirección -->
                        <div class="flex items-start gap-3 group">
                            <div class="w-10 h-10 rounded-xl bg-gray-800/60 border border-gray-700/50 flex items-center justify-center text-secondary shrink-0 transition-transform group-hover:scale-105 duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-white tracking-wide"><?= htmlspecialchars($settings['contact_address_label'] ?? 'Estamos en:') ?></p>
                                <p class="text-xs text-gray-400 mt-0.5 leading-relaxed"><?= nl2br(htmlspecialchars($settings['contact_address_value'] ?? 'Bogotá, Colombia')) ?></p>
                            </div>
                        </div>

                        <!-- Correo Corporativo -->
                        <div class="flex items-start gap-3 group">
                            <div class="w-10 h-10 rounded-xl bg-gray-800/60 border border-gray-700/50 flex items-center justify-center text-secondary shrink-0 transition-transform group-hover:scale-105 duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-white tracking-wide"><?= htmlspecialchars($settings['contact_email_label'] ?? 'Correo Corporativo:') ?></p>
                                <a href="mailto:<?= htmlspecialchars($settings['contact_email_value'] ?? 'contacto@syncroandina.com') ?>" class="text-xs text-gray-400 hover:text-secondary transition-colors mt-0.5 block break-all"><?= htmlspecialchars($settings['contact_email_value'] ?? 'contacto@syncroandina.com') ?></a>
                            </div>
                        </div>

                        <!-- Teléfono / Línea de Atención -->
                        <div class="flex items-start gap-3 group">
                            <div class="w-10 h-10 rounded-xl bg-gray-800/60 border border-gray-700/50 flex items-center justify-center text-secondary shrink-0 transition-transform group-hover:scale-105 duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-white tracking-wide"><?= htmlspecialchars($settings['contact_phone_label'] ?? 'Línea de Atención:') ?></p>
                                <a href="tel:<?= htmlspecialchars(preg_replace('/[^0-9+]/', '', $settings['contact_phone_value'] ?? '+573001234567')) ?>" class="text-xs text-gray-400 hover:text-secondary transition-colors mt-0.5 block"><?= htmlspecialchars($settings['contact_phone_value'] ?? '+57 300 123 4567') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">
                <p><?= htmlspecialchars($settings['footer_copyright'] ?? '© 2026 ' . ($settings['identity_name'] ?? 'Syncro Andina') . '. Todos los derechos reservados.') ?></p>
                <a href="/iniciar-sesion" class="mt-4 md:mt-0 text-gray-700 hover:text-gray-400 transition-colors opacity-50 hover:opacity-100 flex items-center gap-1" title="Acceso Interno">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    <span>Admin</span>
                </a>
            </div>
        </div>
    </footer>
    <script>
        // Forzar scroll al inicio al cargar o actualizar la página
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }
        window.scrollTo(0, 0);
    </script>
</body>
</html>
