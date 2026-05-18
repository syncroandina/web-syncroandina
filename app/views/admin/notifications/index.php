<div class="space-y-6" x-data="{ smtpEnabled: <?= ($settings['notification_use_smtp'] ?? '0') == '1' ? 'true' : 'false' ?> }">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Configuración de Notificaciones por Correo</h2>
            <p class="text-sm text-gray-500 mt-1">Administra los correos corporativos, SMTP y las respuestas automáticas de tu plataforma comercial.</p>
        </div>
    </div>

    <?php if(isset($_GET['success'])): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-2xl relative mb-6">
            <strong class="font-bold">¡Éxito!</strong>
            <span class="block sm:inline">Los ajustes de notificaciones de correo se guardaron correctamente.</span>
        </div>
    <?php endif; ?>

    <form action="/admin/notificaciones/save" method="POST" class="space-y-8">
        <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <!-- Tarjeta Principal: Ajustes Generales -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-secondary flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Parámetros del Remitente</h3>
                            <p class="text-xs text-gray-500">Configura la identidad del remitente para todos los correos del sistema.</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest pl-1">Nombre del Remitente</label>
                            <input type="text" name="notification_sender_name" value="<?= htmlspecialchars($settings['notification_sender_name'] ?? 'Syncro Andina - Notificaciones') ?>" placeholder="Nombre visible en la bandeja de entrada..." class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary text-sm transition-all bg-gray-50 focus:bg-white" required>
                            <p class="text-xs text-gray-400">Ejemplo: <i>Syncro Andina - Sistema de Consultas</i></p>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta: Destinatarios del Administrador -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-secondary flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Destinatarios Internos (Empresa)</h3>
                            <p class="text-xs text-gray-500">Define las direcciones de correo corporativas que recibirán los mensajes de contacto.</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest pl-1">Correos de Recepción</label>
                            <textarea name="notification_emails" rows="3" placeholder="ventas@syncroandina.com, comercial@syncroandina.com" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary text-sm transition-all bg-gray-50 focus:bg-white resize-none" required><?= htmlspecialchars($settings['notification_emails'] ?? 'contacto@syncroandina.com') ?></textarea>
                            <p class="text-xs text-gray-400">Ingresa una o más direcciones de correo electrónico separadas por comas (,).</p>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta: Configuración SMTP (Envío Real en Local y Hosting) -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-secondary flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Servidor de Envíos SMTP (Opcional / Recomendado)</h3>
                                <p class="text-xs text-gray-500">Configura un servidor SMTP para garantizar la entrega de correos tanto en localhost como en hosting.</p>
                            </div>
                        </div>
                        <div class="flex items-center h-5">
                            <input type="checkbox" id="notification_use_smtp" name="notification_use_smtp" value="1" @click="smtpEnabled = !smtpEnabled" <?= ($settings['notification_use_smtp'] ?? '0') == '1' ? 'checked' : '' ?> class="w-5 h-5 rounded text-secondary border-gray-300 focus:ring-secondary cursor-pointer">
                        </div>
                    </div>

                    <!-- Campos SMTP Dinámicos con Alpine.js -->
                    <div class="space-y-6" x-show="smtpEnabled" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="space-y-2 md:col-span-2">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest pl-1">Servidor Host SMTP</label>
                                <input type="text" name="notification_smtp_host" value="<?= htmlspecialchars($settings['notification_smtp_host'] ?? '') ?>" placeholder="smtp.gmail.com o mail.tuempresa.com" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 text-sm transition-all bg-gray-50 focus:bg-white">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest pl-1">Puerto SMTP</label>
                                <input type="number" name="notification_smtp_port" value="<?= htmlspecialchars($settings['notification_smtp_port'] ?? '465') ?>" placeholder="465 o 587" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 text-sm transition-all bg-gray-50 focus:bg-white">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="space-y-2">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest pl-1">Cifrado de Conexión</label>
                                <select name="notification_smtp_encryption" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 text-sm transition-all bg-gray-50 focus:bg-white">
                                    <option value="ssl" <?= ($settings['notification_smtp_encryption'] ?? 'ssl') === 'ssl' ? 'selected' : '' ?>>SSL (Recomendado para puerto 465)</option>
                                    <option value="tls" <?= ($settings['notification_smtp_encryption'] ?? '') === 'tls' ? 'selected' : '' ?>>TLS (Recomendado para puerto 587)</option>
                                    <option value="none" <?= ($settings['notification_smtp_encryption'] ?? '') === 'none' ? 'selected' : '' ?>>Ninguno (Sin cifrado / Puerto 25)</option>
                                </select>
                            </div>

                            <div class="space-y-2 md:col-span-2">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest pl-1">Usuario SMTP (Correo Autenticado)</label>
                                <input type="text" name="notification_smtp_user" value="<?= htmlspecialchars($settings['notification_smtp_user'] ?? '') ?>" placeholder="ejemplo@gmail.com o ventas@tuempresa.com" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 text-sm transition-all bg-gray-50 focus:bg-white">
                            </div>
                        </div>

                        <div class="space-y-2" x-data="{ showPass: false }">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest pl-1">Contraseña SMTP</label>
                            <div class="relative">
                                <input :type="showPass ? 'text' : 'password'" name="notification_smtp_pass" value="<?= htmlspecialchars($settings['notification_smtp_pass'] ?? '') ?>" placeholder="Contraseña de correo o contraseña de aplicación..." class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 text-sm transition-all bg-gray-50 focus:bg-white pr-12">
                                <button type="button" @click="showPass = !showPass" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600 focus:outline-none">
                                    <svg x-show="!showPass" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    <svg x-show="showPass" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Panel de Guía Rápida para Configuración SMTP -->
                        <div class="bg-blue-50/50 border border-blue-100 rounded-2xl p-5 space-y-3">
                            <h4 class="text-xs font-black uppercase text-secondary tracking-widest">📋 Guía Rápida de Configuración SMTP</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-slate-600 leading-normal">
                                <div>
                                    <span class="font-bold text-slate-800 block mb-1">Para Cuentas Gmail:</span>
                                    • Host: <code>smtp.gmail.com</code><br>
                                    • Puertos: <code>465</code> (SSL) o <code>587</code> (TLS)<br>
                                    • Contraseña: Debes generar y utilizar una <b>Contraseña de Aplicación</b> de 16 dígitos desde los ajustes de seguridad de tu cuenta Google (2FA activo).
                                </div>
                                <div>
                                    <span class="font-bold text-slate-800 block mb-1">Para Cuentas Corporativas (cPanel):</span>
                                    • Host: <code>mail.tuempresa.com</code> (o el subdominio configurado)<br>
                                    • Puerto: <code>465</code> (SSL) o <code>587</code> (TLS)<br>
                                    • Contraseña: Contraseña normal de la casilla corporativa creada en cPanel.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta: Toggles de Habilitación -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-secondary flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Eventos de Notificación</h3>
                            <p class="text-xs text-gray-500">Elige qué correos automatizados se deben disparar en el sistema.</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- Toggle 1: Notificar Administrador -->
                        <div class="flex items-start justify-between p-4 rounded-xl bg-gray-50 border border-gray-100 transition-all hover:bg-gray-100/50">
                            <div class="space-y-1">
                                <label class="text-sm font-bold text-gray-800 block cursor-pointer" for="notification_enable_admin">Notificación a la Empresa</label>
                                <span class="text-xs text-gray-500 leading-normal block">Enviar correo automático a los destinatarios internos configurados arriba cada vez que se reciba un nuevo contacto.</span>
                            </div>
                            <div class="flex items-center h-5">
                                <input type="checkbox" id="notification_enable_admin" name="notification_enable_admin" value="1" <?= ($settings['notification_enable_admin'] ?? '1') == '1' ? 'checked' : '' ?> class="w-5 h-5 rounded text-secondary border-gray-300 focus:ring-secondary transition-all cursor-pointer">
                            </div>
                        </div>

                        <!-- Toggle 2: Notificar Cliente -->
                        <div class="flex items-start justify-between p-4 rounded-xl bg-gray-50 border border-gray-100 transition-all hover:bg-gray-100/50">
                            <div class="space-y-1">
                                <label class="text-sm font-bold text-gray-800 block cursor-pointer" for="notification_enable_client">Respuesta Automática al Cliente</label>
                                <span class="text-xs text-gray-500 leading-normal block">Enviar un correo de confirmación automática de recepción directamente a la casilla de correo provista por el usuario.</span>
                            </div>
                            <div class="flex items-center h-5">
                                <input type="checkbox" id="notification_enable_client" name="notification_enable_client" value="1" <?= ($settings['notification_enable_client'] ?? '1') == '1' ? 'checked' : '' ?> class="w-5 h-5 rounded text-secondary border-gray-300 focus:ring-secondary transition-all cursor-pointer">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna Lateral Sticky: Guardado e Información -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex flex-col justify-center sticky top-24">
                    <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4 text-xs text-blue-700 leading-relaxed mb-6">
                        <strong class="block font-bold mb-1">💡 Importante</strong>
                        Los correos HTML enviados utilizarán de forma dinámica el <b>Logo Corporativo</b> y el <b>Color de Acento</b> configurados en la sección de <a href="/admin/identidad" class="font-bold underline text-secondary hover:text-blue-800">Identidad Corporativa</a> para mantener la consistencia de tu marca.
                    </div>
                    
                    <button type="submit" class="w-full bg-secondary text-white py-4 rounded-xl font-bold hover:bg-blue-600 transition-all shadow-lg shadow-secondary/20 flex justify-center items-center gap-2 group">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Guardar Ajustes
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
