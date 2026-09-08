<?php
$pageTitle = $title ?? 'Exportar e Importar Sitio Web';
?>

<div class="space-y-6 max-w-6xl mx-auto">
    <!-- Header de la sección (Estilo Vercel / Apple Admin) -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white p-6 rounded-2xl border border-gray-200/80 shadow-sm gap-4">
        <div>
            <div class="flex items-center gap-2.5">
                <h2 class="text-2xl font-black text-gray-900 tracking-tight">Exportar e Importar Sitio Web</h2>
                <span class="px-3 py-1 rounded-full text-[11px] font-extrabold bg-blue-50 text-blue-700 border border-blue-200/80 uppercase tracking-wider">Full Backup System</span>
            </div>
            <p class="text-xs text-gray-500 mt-1">Genera copias de respaldo completas (Base de Datos + Archivos Uploads) o restaura tu sitio web en cualquier servidor.</p>
        </div>
    </div>

    <!-- Grid Principal de Exportación e Importación -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Bloque 1: Exportar Sitio Web Completo -->
        <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm p-6 flex flex-col justify-between space-y-6">
            <div class="space-y-4">
                <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-secondary flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-gray-900">Exportar Sitio Web Completo</h3>
                        <p class="text-xs text-gray-500">Descarga un paquete .ZIP con el volcado SQL y todos tus archivos de multimedia.</p>
                    </div>
                </div>

                <div class="bg-slate-50 border border-slate-200/80 rounded-xl p-4 space-y-2.5 text-xs text-slate-600">
                    <div class="flex justify-between items-center py-1 border-b border-slate-200/50">
                        <span class="font-medium text-slate-500">Base de Datos:</span>
                        <span class="font-bold text-slate-800 bg-white px-2.5 py-0.5 rounded border border-slate-200">Dump SQL Completo</span>
                    </div>
                    <div class="flex justify-between items-center py-1 border-b border-slate-200/50">
                        <span class="font-medium text-slate-500">Archivos Multimedia:</span>
                        <span class="font-bold text-slate-800"><?= $filesCount ?> archivos (<?= $uploadsSizeMb ?> MB)</span>
                    </div>
                    <div class="flex justify-between items-center py-1">
                        <span class="font-medium text-slate-500">Formato del Respaldo:</span>
                        <span class="font-mono font-bold text-blue-700 bg-blue-50 px-2 py-0.5 rounded border border-blue-200/80">.ZIP Comprimido</span>
                    </div>
                </div>
            </div>

            <button type="button" onclick="triggerExportBackup()" id="btn-export-submit" class="w-full py-3 bg-primary hover:bg-secondary text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-primary/20 flex items-center justify-center gap-2 transform active:scale-95 cursor-pointer">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Exportar y Descargar Sitio Web (.zip)
            </button>
        </div>

        <!-- Bloque 2: Importar / Restaurar Sitio Web -->
        <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm p-6 flex flex-col justify-between space-y-6">
            <div class="space-y-4">
                <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-gray-900">Importar / Restaurar Sitio Web</h3>
                        <p class="text-xs text-gray-500">Carga un archivo .ZIP exportado previamente para restaurar los datos y la web.</p>
                    </div>
                </div>

                <form id="import-form" enctype="multipart/form-data" class="space-y-4">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest pl-1">Seleccionar Archivo de Respaldo (.ZIP)</label>
                        <input type="file" name="backup_file" id="backup_file" accept=".zip" required class="w-full px-4 py-3 rounded-xl border border-gray-200 text-xs transition-all bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-secondary/20 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-primary file:text-white hover:file:bg-secondary cursor-pointer">
                    </div>

                    <div class="p-3.5 rounded-xl bg-amber-50/80 border border-amber-200/80 text-[11px] text-amber-900 space-y-1">
                        <span class="font-bold block">Importante antes de restaurar:</span>
                        <p class="leading-relaxed">Se sobrescribirán las tablas de la base de datos e imágenes en <code class="font-mono bg-amber-100 px-1 py-0.5 rounded">public/uploads</code>. Límite máximo de subida PHP: <strong><?= $limits['upload_max_filesize'] ?></strong>.</p>
                    </div>

                    <button type="button" onclick="submitImportBackup()" id="btn-import-submit" class="w-full py-3 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-amber-600/20 flex items-center justify-center gap-2 cursor-pointer transform active:scale-95">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        Restaurar Sitio Web
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    async function triggerExportBackup() {
        if (typeof Swal === 'undefined') {
            alert('Cargando componentes del sistema. Por favor reintenta en un momento.');
            return;
        }

        const btn = document.getElementById('btn-export-submit');
        if (btn) btn.disabled = true;

        let progressBar, progressStatus, percentStatus;

        Swal.fire({
            title: 'Generando Copia de Respaldo',
            html: `
                <div class="space-y-3 my-2 text-left">
                    <p id="swal-export-status" class="text-xs font-semibold text-slate-600">Exportando tablas de la base de datos MySQL...</p>
                    <div class="w-full bg-slate-100 rounded-full h-3.5 overflow-hidden border border-slate-200 p-0.5">
                        <div id="swal-export-bar" class="bg-gradient-to-r from-blue-600 to-indigo-600 h-full rounded-full transition-all duration-300 shadow-sm" style="width: 15%"></div>
                    </div>
                    <div class="flex justify-between text-[11px] text-slate-400 font-mono">
                        <span>Estado de Proceso</span>
                        <span id="swal-export-percent" class="font-bold text-blue-700">15%</span>
                    </div>
                </div>
            `,
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => {
                progressBar = document.getElementById('swal-export-bar');
                progressStatus = document.getElementById('swal-export-status');
                percentStatus = document.getElementById('swal-export-percent');
            }
        });

        let currentProgress = 15;
        const progressInterval = setInterval(() => {
            if (currentProgress < 90) {
                currentProgress += Math.floor(Math.random() * 8) + 3;
                if (currentProgress > 90) currentProgress = 90;
                if (progressBar) progressBar.style.width = currentProgress + '%';
                if (percentStatus) percentStatus.innerText = currentProgress + '%';

                if (currentProgress > 40 && progressStatus) {
                    progressStatus.innerText = 'Comprimiendo imágenes y archivos multimedia...';
                }
                if (currentProgress > 75 && progressStatus) {
                    progressStatus.innerText = 'Finalizando empaquetado del archivo .ZIP...';
                }
            }
        }, 350);

        try {
            const response = await fetch('<?= url("admin/backup-site/export") ?>');

            if (!response.ok) {
                let errorMsg = 'Error al generar la descarga';
                try {
                    const errJson = await response.json();
                    if (errJson.error) errorMsg = errJson.error;
                } catch (jsonErr) {}
                throw new Error(errorMsg);
            }

            const blob = await response.blob();

            clearInterval(progressInterval);
            if (progressBar) progressBar.style.width = '100%';
            if (percentStatus) percentStatus.innerText = '100%';
            if (progressStatus) progressStatus.innerText = '¡Copia generada! Iniciando descarga...';

            await new Promise(r => setTimeout(r, 400));

            const downloadUrl = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = downloadUrl;

            const contentDisposition = response.headers.get('Content-Disposition');
            let filename = 'site_backup_' + new Date().toISOString().replace(/[:.-]/g, '_') + '.zip';
            if (contentDisposition && contentDisposition.includes('filename=')) {
                const matches = contentDisposition.match(/filename="?([^";]+)"?/);
                if (matches && matches[1]) filename = matches[1];
            }

            a.download = filename;
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(downloadUrl);
            document.body.removeChild(a);

            Swal.fire({
                title: '¡Descarga Iniciada!',
                text: 'El archivo ' + filename + ' se ha generado y descargado correctamente.',
                icon: 'success',
                confirmButtonText: 'Entendido'
            });

        } catch (e) {
            clearInterval(progressInterval);
            let userMsg = e.message || 'No se pudo completar la exportación del sitio.';
            if (userMsg.toLowerCase().includes('failed to fetch')) {
                userMsg = 'No se pudo conectar con el servidor web local. Por favor verifica que el servidor dev (php -S) esté activo.';
            }
            Swal.fire({
                title: 'Error al Exportar',
                text: userMsg,
                icon: 'error',
                confirmButtonText: 'Cerrar'
            });
        } finally {
            if (btn) btn.disabled = false;
        }
    }

    async function submitImportBackup() {
        const fileInput = document.getElementById('backup_file');
        if (!fileInput.files || fileInput.files.length === 0) {
            Swal.fire({
                title: 'Selecciona un archivo',
                text: 'Por favor selecciona primero un archivo comprimido .ZIP de respaldo.',
                icon: 'warning',
                confirmButtonText: 'Entendido'
            });
            return;
        }

        const confirmResult = await Swal.fire({
            title: '¿Deseas restaurar este sitio web?',
            text: 'Esta acción reemplazará la base de datos y los archivos multimedia por el contenido del respaldo .ZIP. Esta acción es irreversible.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, Restaurar Ahora',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        });

        if (!confirmResult.isConfirmed) return;

        const btn = document.getElementById('btn-import-submit');
        if (btn) btn.disabled = true;

        let progressBar, progressStatus, percentStatus;

        Swal.fire({
            title: 'Restaurando Sitio Web',
            html: `
                <div class="space-y-3 my-2 text-left">
                    <p id="swal-import-status" class="text-xs font-semibold text-slate-600">Subiendo archivo .ZIP al servidor...</p>
                    <div class="w-full bg-slate-100 rounded-full h-3.5 overflow-hidden border border-slate-200 p-0.5">
                        <div id="swal-import-bar" class="bg-gradient-to-r from-amber-500 to-orange-600 h-full rounded-full transition-all duration-300 shadow-sm" style="width: 10%"></div>
                    </div>
                    <div class="flex justify-between text-[11px] text-slate-400 font-mono">
                        <span>Procesando Restauración</span>
                        <span id="swal-import-percent" class="font-bold text-amber-700">10%</span>
                    </div>
                </div>
            `,
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => {
                progressBar = document.getElementById('swal-import-bar');
                progressStatus = document.getElementById('swal-import-status');
                percentStatus = document.getElementById('swal-import-percent');
            }
        });

        let currentProgress = 10;
        const progressInterval = setInterval(() => {
            if (currentProgress < 90) {
                currentProgress += Math.floor(Math.random() * 6) + 2;
                if (currentProgress > 90) currentProgress = 90;
                if (progressBar) progressBar.style.width = currentProgress + '%';
                if (percentStatus) percentStatus.innerText = currentProgress + '%';

                if (currentProgress > 35 && progressStatus) {
                    progressStatus.innerText = 'Descomprimiendo paquete de datos e imágenes...';
                }
                if (currentProgress > 65 && progressStatus) {
                    progressStatus.innerText = 'Restaurando base de datos SQL e hipervínculos...';
                }
            }
        }, 400);

        const formData = new FormData(document.getElementById('import-form'));

        try {
            const res = await fetch('<?= url("admin/backup-site/import") ?>', {
                method: 'POST',
                body: formData
            });

            const data = await res.json();

            clearInterval(progressInterval);
            if (progressBar) progressBar.style.width = '100%';
            if (percentStatus) percentStatus.innerText = '100%';

            if (data.success) {
                await Swal.fire({
                    title: '¡Sitio Web Restaurado!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'Excelente'
                });
                window.location.reload();
            } else {
                Swal.fire({
                    title: 'Error al Restaurar',
                    text: data.message || 'No se pudo procesar la restauración.',
                    icon: 'error',
                    confirmButtonText: 'Cerrar'
                });
            }
        } catch (e) {
            clearInterval(progressInterval);
            let userMsg = e.message || 'Ocurrió un error al procesar el archivo.';
            if (userMsg.toLowerCase().includes('failed to fetch')) {
                userMsg = 'No se pudo conectar con el servidor web local. Por favor verifica que el servidor dev (php -S) esté activo.';
            }
            Swal.fire({
                title: 'Error de Servidor',
                text: userMsg,
                icon: 'error',
                confirmButtonText: 'Cerrar'
            });
        } finally {
            if (btn) btn.disabled = false;
        }
    }
</script>
