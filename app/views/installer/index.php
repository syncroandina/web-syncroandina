<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Instalador Web - Syncro Andina') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#090d16] text-slate-100 min-h-screen flex items-center justify-center p-4 md:p-8 antialiased selection:bg-red-600 selection:text-white relative overflow-x-hidden">

    <!-- Ambient Glow background -->
    <div class="fixed -top-40 -left-40 w-96 h-96 bg-red-600/10 rounded-full blur-[140px] pointer-events-none"></div>
    <div class="fixed -bottom-40 -right-40 w-96 h-96 bg-indigo-600/10 rounded-full blur-[140px] pointer-events-none"></div>

    <div class="w-full max-w-3xl bg-slate-900/60 border border-slate-800/80 rounded-3xl shadow-[0_25px_80px_rgba(0,0,0,0.7)] backdrop-blur-2xl overflow-hidden relative z-10">
        
        <!-- Minimalist Header & Stepper Below Title -->
        <div class="p-6 md:p-8 border-b border-slate-800/80 bg-slate-900/40">
            <div class="mb-8 text-center">
                <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white justify-center">
                    Asistente de Instalación
                </h1>
                <p class="text-xs md:text-sm text-slate-400 mt-1.5 font-medium">Configuración limpia y autónoma del entorno web.</p>
            </div>

            <!-- Centered Stepper BELOW Title -->
            <div class="grid grid-cols-4 gap-2 relative max-w-lg mx-auto">
                <!-- Connecting Background Bar -->
                <div class="absolute top-4 left-[12%] right-[12%] h-[2px] bg-slate-800 -z-0">
                    <div class="h-full bg-gradient-to-r from-red-600 to-rose-500 transition-all duration-500" style="width: <?= $step === 1 ? '0%' : ($step === 2 ? '33%' : ($step === 3 ? '66%' : '100%')) ?>;"></div>
                </div>

                <!-- Step 1 -->
                <div class="relative z-10 flex flex-col items-center text-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300 <?= $step === 1 ? 'bg-red-600 text-white ring-4 ring-red-600/20 shadow-[0_0_15px_rgba(239,68,68,0.5)]' : ($step > 1 ? 'bg-emerald-500 text-slate-950 font-extrabold' : 'bg-slate-800 text-slate-500 border border-slate-700') ?>">
                        <?= $step > 1 ? '✓' : '1' ?>
                    </div>
                    <span class="text-[11px] font-semibold mt-2.5 <?= $step === 1 ? 'text-white font-bold' : ($step > 1 ? 'text-emerald-400' : 'text-slate-500') ?>">
                        Requisitos
                    </span>
                </div>

                <!-- Step 2 -->
                <div class="relative z-10 flex flex-col items-center text-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300 <?= $step === 2 ? 'bg-red-600 text-white ring-4 ring-red-600/20 shadow-[0_0_15px_rgba(239,68,68,0.5)]' : ($step > 2 ? 'bg-emerald-500 text-slate-950 font-extrabold' : 'bg-slate-800 text-slate-500 border border-slate-700') ?>">
                        <?= $step > 2 ? '✓' : '2' ?>
                    </div>
                    <span class="text-[11px] font-semibold mt-2.5 <?= $step === 2 ? 'text-white font-bold' : ($step > 2 ? 'text-emerald-400' : 'text-slate-500') ?>">
                        Base de Datos
                    </span>
                </div>

                <!-- Step 3 -->
                <div class="relative z-10 flex flex-col items-center text-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300 <?= $step === 3 ? 'bg-red-600 text-white ring-4 ring-red-600/20 shadow-[0_0_15px_rgba(239,68,68,0.5)]' : ($step > 3 ? 'bg-emerald-500 text-slate-950 font-extrabold' : 'bg-slate-800 text-slate-500 border border-slate-700') ?>">
                        <?= $step > 3 ? '✓' : '3' ?>
                    </div>
                    <span class="text-[11px] font-semibold mt-2.5 <?= $step === 3 ? 'text-white font-bold' : ($step > 3 ? 'text-emerald-400' : 'text-slate-500') ?>">
                        Administrador
                    </span>
                </div>

                <!-- Step 4 -->
                <div class="relative z-10 flex flex-col items-center text-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300 <?= $step === 4 ? 'bg-emerald-500 text-slate-950 ring-4 ring-emerald-500/20 shadow-[0_0_15px_rgba(16,185,129,0.5)]' : 'bg-slate-800 text-slate-500 border border-slate-700' ?>">
                        ✓
                    </div>
                    <span class="text-[11px] font-semibold mt-2.5 <?= $step === 4 ? 'text-emerald-400 font-bold' : 'text-slate-500' ?>">
                        Listo
                    </span>
                </div>
            </div>
        </div>

        <!-- Content Body -->
        <div class="p-6 md:p-8">

            <!-- STEP 1: SERVER REQUIREMENTS -->
            <?php if ($step === 1): ?>
                <div class="space-y-6">
                    <div>
                        <h2 class="text-lg font-bold text-white mb-1">Paso 1: Verificación de Requisitos del Servidor</h2>
                        <p class="text-xs text-slate-400">Comprobando compatibilidad de PHP, extensiones esenciales y permisos de escritura.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <?php foreach($requirements as $key => $req): if ($key === '_all_pass') continue; 
                            $isReq = $req['required'] ?? true;
                            $cardBg = $req['pass'] ? 'bg-slate-950/40 border-slate-800/80 hover:border-slate-700' : ($isReq ? 'bg-rose-950/20 border-rose-800/50' : 'bg-amber-950/20 border-amber-800/50');
                            $statusColor = $req['pass'] ? 'text-emerald-400' : ($isReq ? 'text-rose-400' : 'text-amber-400');
                        ?>
                            <div class="p-3.5 rounded-2xl border flex items-center justify-between gap-3 transition-all duration-200 <?= $cardBg ?>">
                                <div class="truncate">
                                    <span class="text-xs font-bold block text-slate-200 truncate"><?= htmlspecialchars($req['name']) ?></span>
                                    <span class="text-[11px] text-slate-400 block mt-0.5">Estado: <strong class="<?= $statusColor ?> font-semibold"><?= htmlspecialchars($req['current']) ?></strong></span>
                                </div>
                                <div class="shrink-0">
                                    <?php if ($req['pass']): ?>
                                        <div class="w-7 h-7 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center font-bold text-xs">
                                            ✓
                                        </div>
                                    <?php elseif(!$isReq): ?>
                                        <div class="w-7 h-7 rounded-xl bg-amber-500/10 text-amber-400 border border-amber-500/20 flex items-center justify-center font-bold text-xs">
                                            !
                                        </div>
                                    <?php else: ?>
                                        <div class="w-7 h-7 rounded-xl bg-rose-500/10 text-rose-400 border border-rose-500/20 flex items-center justify-center font-bold text-xs">
                                            ✕
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="pt-5 border-t border-slate-800/80 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <span class="text-xs text-slate-400 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full <?= $requirements['_all_pass'] ? 'bg-emerald-500 animate-pulse' : 'bg-rose-500' ?>"></span>
                            <?= $requirements['_all_pass'] ? '¡Todos los requisitos fueron verificados correctamente!' : 'Por favor resuelve las advertencias para continuar.' ?>
                        </span>
                        <?php if ($requirements['_all_pass']): ?>
                            <a href="<?= url('install?step=2') ?>" class="w-full sm:w-auto px-7 py-3 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-500 hover:to-rose-500 text-white font-bold text-xs rounded-xl transition-all shadow-[0_4px_20px_rgba(225,29,72,0.3)] flex items-center justify-center gap-2 group">
                                <span>Continuar a Base de Datos</span>
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        <?php else: ?>
                            <button onclick="window.location.reload()" class="w-full sm:w-auto px-6 py-3 bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs rounded-xl transition-all border border-slate-700">
                                Recomprobar Requisitos
                            </button>
                        <?php endif; ?>
                    </div>
                </div>

            <!-- STEP 2: DATABASE SETUP -->
            <?php elseif ($step === 2): ?>
                <form id="db-form" onsubmit="event.preventDefault(); submitDbStep();" class="space-y-5">
                    <div>
                        <h2 class="text-lg font-bold text-white mb-1">Paso 2: Conexión de Base de Datos MySQL</h2>
                        <p class="text-xs text-slate-400">Ingresa las credenciales de MySQL. Si la base de datos no existe, el instalador la creará.</p>
                    </div>

                    <div id="db-alert" class="hidden p-4 rounded-xl text-xs font-bold border backdrop-blur-md"></div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Servidor BD (Host)</label>
                            <input type="text" id="db-host" name="host" value="127.0.0.1" required class="w-full bg-slate-950/80 border border-slate-800 rounded-xl p-3 text-xs text-white focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-all" placeholder="127.0.0.1">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Puerto MySQL</label>
                            <input type="text" id="db-port" name="port" value="3306" required class="w-full bg-slate-950/80 border border-slate-800 rounded-xl p-3 text-xs text-white focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Nombre de Base de Datos</label>
                            <input type="text" id="db-name" name="dbname" value="syncroandina_db" required class="w-full bg-slate-950/80 border border-slate-800 rounded-xl p-3 text-xs text-white focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-all" placeholder="syncroandina_db">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Usuario de BD</label>
                            <input type="text" id="db-user" name="user" value="root" required class="w-full bg-slate-950/80 border border-slate-800 rounded-xl p-3 text-xs text-white focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-all">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Contraseña de BD</label>
                            <input type="password" id="db-pass" name="pass" class="w-full bg-slate-950/80 border border-slate-800 rounded-xl p-3 text-xs text-white focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-all" placeholder="Dejar en blanco si no requiere clave">
                        </div>
                    </div>

                    <div class="pt-5 border-t border-slate-800/80 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <a href="<?= url('install?step=1') ?>" class="text-xs font-medium text-slate-400 hover:text-white transition-colors">
                            ← Volver a Requisitos
                        </a>
                        <div class="flex items-center gap-3 w-full sm:w-auto">
                            <button type="button" onclick="testDatabaseConnection()" id="btn-test-db" class="w-1/2 sm:w-auto px-5 py-3 bg-slate-800/80 hover:bg-slate-700 text-slate-200 font-bold text-xs rounded-xl transition-all border border-slate-700">
                                Probar Conexión BD
                            </button>
                            <button type="submit" id="btn-next-db" class="w-1/2 sm:w-auto px-7 py-3 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-500 hover:to-rose-500 text-white font-bold text-xs rounded-xl transition-all shadow-[0_4px_20px_rgba(225,29,72,0.3)] flex items-center justify-center gap-2 group">
                                <span>Continuar</span>
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>
                    </div>
                </form>

            <!-- STEP 3: ADMIN & SITE SETUP -->
            <?php elseif ($step === 3): ?>
                <form id="admin-form" onsubmit="event.preventDefault(); executeInstallation();" class="space-y-5">
                    <div>
                        <h2 class="text-lg font-bold text-white mb-1">Paso 3: Datos del Sitio y Administrador Principal</h2>
                        <p class="text-xs text-slate-400">Configura el título de tu web y las credenciales para acceder al Panel CMS.</p>
                    </div>

                    <div id="install-alert" class="hidden p-4 rounded-xl text-xs font-bold border backdrop-blur-md"></div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Nombre del Sitio Web / Empresa</label>
                            <input type="text" id="site-title" name="site_title" value="Syncro Andina" required class="w-full bg-slate-950/80 border border-slate-800 rounded-xl p-3 text-xs text-white focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-all" placeholder="Ej: Syncro Andina S.A.C.">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Nombre del Administrador</label>
                            <input type="text" id="admin-name" name="admin_name" value="Administrador Director" required class="w-full bg-slate-950/80 border border-slate-800 rounded-xl p-3 text-xs text-white focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Correo Electrónico (Login Admin)</label>
                            <input type="email" id="admin-email" name="admin_email" value="admin@syncroandina.com" required class="w-full bg-slate-950/80 border border-slate-800 rounded-xl p-3 text-xs text-white focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-all">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Contraseña del Administrador</label>
                            <input type="password" id="admin-password" name="admin_password" required minlength="6" class="w-full bg-slate-950/80 border border-slate-800 rounded-xl p-3 text-xs text-white focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-all" placeholder="Mínimo 6 caracteres">
                        </div>
                    </div>

                    <div class="pt-5 border-t border-slate-800/80 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <a href="<?= url('install?step=2') ?>" class="text-xs font-medium text-slate-400 hover:text-white transition-colors">
                            ← Volver a Base de Datos
                        </a>
                        <button type="submit" id="btn-run-install" class="w-full sm:w-auto px-8 py-3.5 bg-gradient-to-r from-red-600 via-rose-600 to-red-600 hover:from-red-500 hover:to-rose-500 text-white font-extrabold text-xs rounded-xl transition-all shadow-[0_4px_25px_rgba(225,29,72,0.35)] flex items-center justify-center gap-2 group">
                            <svg class="w-4 h-4 animate-spin hidden" id="spinner-install" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            <span id="btn-run-text" class="tracking-wide">🚀 Instalar Sistema Ahora</span>
                        </button>
                    </div>
                </form>

            <!-- STEP 4: SUCCESS -->
            <?php elseif ($step === 4): ?>
                <div class="text-center py-6 space-y-5">
                    <div class="w-20 h-20 rounded-3xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center text-3xl mx-auto shadow-[0_0_30px_rgba(16,185,129,0.15)]">
                        🎉
                    </div>
                    <div>
                        <h2 class="text-2xl font-black text-white mb-1.5 tracking-tight">¡Instalación Completada con Éxito!</h2>
                        <p class="text-slate-400 text-xs md:text-sm max-w-lg mx-auto leading-relaxed">
                            Las 35 migraciones de la base de datos se ejecutaron correctamente. El sitio web y el panel CMS ya están operativos.
                        </p>
                    </div>

                    <div class="bg-slate-950/80 border border-slate-800/80 p-5 rounded-2xl max-w-md mx-auto text-left space-y-2.5 text-xs">
                        <div class="flex justify-between border-b border-slate-900 pb-2">
                            <span class="text-slate-400">Panel de Administración:</span>
                            <span class="text-red-400 font-bold">/iniciar-sesion</span>
                        </div>
                        <div class="flex justify-between border-b border-slate-900 pb-2">
                            <span class="text-slate-400">Base de Datos:</span>
                            <span class="text-emerald-400 font-bold flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                Conectada y Estructurada
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Candado de Seguridad:</span>
                            <span class="text-slate-300 font-bold">storage/installed.lock</span>
                        </div>
                    </div>

                    <div class="pt-3 flex flex-col sm:flex-row items-center justify-center gap-3">
                        <a href="<?= url('iniciar-sesion') ?>" class="w-full sm:w-auto px-7 py-3.5 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-500 hover:to-rose-500 text-white font-extrabold text-xs rounded-xl transition-all shadow-[0_4px_25px_rgba(225,29,72,0.3)] text-center">
                            Iniciar Sesión en el Panel Admin →
                        </a>
                        <a href="<?= url('') ?>" target="_blank" class="w-full sm:w-auto px-7 py-3.5 bg-slate-800/80 hover:bg-slate-700 text-white font-bold text-xs rounded-xl transition-all border border-slate-700 text-center">
                            Ver Sitio Web Público 🌐
                        </a>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <script>
        function showAlert(id, msg, isSuccess = false) {
            const el = document.getElementById(id);
            if (!el) return;
            el.innerText = msg;
            el.className = `p-4 rounded-xl text-xs font-bold border backdrop-blur-md ${isSuccess ? 'bg-emerald-950/60 border-emerald-800 text-emerald-300' : 'bg-rose-950/60 border-rose-800 text-rose-300'}`;
            el.classList.remove('hidden');
        }

        function hideAlert(id) {
            const el = document.getElementById(id);
            if (el) el.classList.add('hidden');
        }

        async function testDatabaseConnection() {
            const btn = document.getElementById('btn-test-db');
            if (btn) btn.innerText = 'Probando...';

            const formData = new FormData(document.getElementById('db-form'));
            try {
                const res = await fetch('<?= url("install/test-db") ?>', { method: 'POST', body: formData });
                const data = await res.json();
                if (data.success) {
                    showAlert('db-alert', data.message, true);
                    sessionStorage.setItem('installer_db', JSON.stringify(Object.fromEntries(formData)));
                } else {
                    showAlert('db-alert', data.message, false);
                }
            } catch (e) {
                showAlert('db-alert', 'Error de conexión con el servidor: ' + e.message, false);
            } finally {
                if (btn) btn.innerText = 'Probar Conexión BD';
            }
        }

        async function submitDbStep() {
            const formData = new FormData(document.getElementById('db-form'));
            sessionStorage.setItem('installer_db', JSON.stringify(Object.fromEntries(formData)));
            window.location.href = '<?= url("install?step=3") ?>';
        }

        async function executeInstallation() {
            const alertId = 'install-alert';
            hideAlert(alertId);

            const savedDb = sessionStorage.getItem('installer_db');
            if (!savedDb) {
                alert('Por favor completa el paso 2 de Base de Datos primero.');
                window.location.href = '<?= url("install?step=2") ?>';
                return;
            }

            const dbData = JSON.parse(savedDb);
            const adminFormData = new FormData(document.getElementById('admin-form'));
            
            // Combinar los dos formularios
            const combinedData = new FormData();
            for (let k in dbData) combinedData.append(k, dbData[k]);
            for (let [k, v] of adminFormData.entries()) combinedData.append(k, v);

            const spinner = document.getElementById('spinner-install');
            const btnText = document.getElementById('btn-run-text');
            const btn = document.getElementById('btn-run-install');

            if (spinner) spinner.classList.remove('hidden');
            if (btnText) btnText.innerText = 'Instalando Tablas y Módulos...';
            if (btn) btn.disabled = true;

            try {
                const res = await fetch('<?= url("install/process") ?>', { method: 'POST', body: combinedData });
                const data = await res.json();

                if (data.success) {
                    sessionStorage.removeItem('installer_db');
                    window.location.href = data.redirect || '<?= url("install?step=4") ?>';
                } else {
                    showAlert(alertId, data.message, false);
                    if (spinner) spinner.classList.add('hidden');
                    if (btnText) btnText.innerText = '🚀 Reintentar Instalación';
                    if (btn) btn.disabled = false;
                }
            } catch (e) {
                showAlert(alertId, 'Error en la solicitud: ' + e.message, false);
                if (spinner) spinner.classList.add('hidden');
                if (btnText) btnText.innerText = '🚀 Reintentar Instalación';
                if (btn) btn.disabled = false;
            }
        }
    </script>
</body>
</html>
