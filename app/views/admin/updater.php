<?php
$pageTitle = $title ?? 'Centro de Actualizaciones';
?>

<div class="space-y-6 max-w-6xl mx-auto">
    <!-- Header de la sección (Estilo Vercel / Apple Admin) -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white p-6 rounded-2xl border border-gray-200/80 shadow-sm gap-4">
        <div>
            <div class="flex items-center gap-2.5">
                <h2 class="text-2xl font-black text-gray-900 tracking-tight">Centro de Actualizaciones</h2>
                <span class="px-3 py-1 rounded-full text-[11px] font-extrabold bg-blue-50 text-blue-700 border border-blue-200/80 uppercase tracking-wider">CMS Auto-Update</span>
            </div>
            <p class="text-xs text-gray-500 mt-1">Mantén tu sitio web al día con las últimas mejoras, parches de seguridad y funciones oficiales.</p>
        </div>
        <div class="flex items-center gap-3 shrink-0">
            <button type="button" onclick="checkGitHubUpdates()" id="btn-check-github" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition-all flex items-center gap-2 cursor-pointer whitespace-nowrap">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                Buscar Actualizaciones
            </button>
            <button type="button" onclick="runGitHubUpdate()" id="btn-run-update" class="px-5 py-2.5 bg-primary hover:bg-secondary text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-primary/20 flex items-center gap-2 cursor-pointer whitespace-nowrap transform active:scale-95">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 0115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path></svg>
                Actualizar Sistema
            </button>
        </div>
    </div>

    <!-- Grid de Estado Principal -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Bloque 1: Versión Instalada (Columna 4 de 12) -->
        <div class="lg:col-span-4 bg-white rounded-2xl border border-gray-200/80 shadow-sm p-6 flex flex-col justify-between space-y-6">
            <div>
                <span class="text-[11px] font-extrabold uppercase tracking-widest text-gray-400 block mb-3">Versión Instalada</span>
                <div class="space-y-2">
                    <div class="text-3xl font-black text-gray-900 tracking-tight">v<?= htmlspecialchars($localVersion['version'] ?? '1.0.0') ?></div>
                    <div>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-slate-100 text-slate-700 border border-slate-200/80">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                            Build <?= substr(htmlspecialchars($localVersion['commit_hash'] ?? 'initial'), 0, 7) ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                <span class="font-medium">Sincronización local:</span>
                <span class="font-semibold text-gray-700"><?= htmlspecialchars($localVersion['updated_at'] ?? 'Hoy') ?></span>
            </div>
        </div>

        <!-- Bloque 2: Estado del Servidor de Versiones (Columna 8 de 12) -->
        <div class="lg:col-span-8 bg-white rounded-2xl border border-gray-200/80 shadow-sm p-6 flex flex-col justify-between space-y-4">
            <span class="text-[11px] font-extrabold uppercase tracking-widest text-gray-400 block">Estado en Servidor Oficial</span>
            
            <div id="github-status-box" class="w-full">
                <div class="flex items-center gap-3 p-4 rounded-xl bg-slate-50 border border-slate-200/80 text-slate-600">
                    <span class="inline-block w-3 h-3 rounded-full bg-amber-400 animate-pulse shrink-0"></span>
                    <span class="text-xs font-bold">Comprobando disponibilidad de actualizaciones...</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        checkGitHubUpdates();
    });

    async function checkGitHubUpdates() {
        const btn = document.getElementById('btn-check-github');
        const statusBox = document.getElementById('github-status-box');
        if (btn) btn.innerHTML = '⏳ Comprobando...';

        try {
            const res = await fetch('<?= url("admin/actualizaciones/check") ?>', { method: 'POST' });
            const data = await res.json();

            if (data.success) {
                if (data.has_update) {
                    statusBox.innerHTML = `
                        <div class="bg-amber-50/80 border border-amber-200/80 rounded-2xl p-5 shadow-sm space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-amber-200/60 text-amber-800 flex items-center justify-center font-bold text-xs">✨</div>
                                    <h4 class="text-xs font-black text-amber-900 uppercase tracking-wide">¡NUEVA ACTUALIZACIÓN DISPONIBLE!</h4>
                                </div>
                                <span class="text-xs font-mono font-bold bg-amber-200 text-amber-900 px-3 py-1 rounded-lg border border-amber-300/50">${data.commit_short}</span>
                            </div>
                            <p class="text-xs font-bold text-gray-800 pl-9">${data.commit_message}</p>
                            <div class="flex items-center gap-3 text-[11px] text-gray-500 pl-9 font-medium border-t border-amber-200/50 pt-2">
                                <span>Publicado por: <strong>${data.commit_author}</strong></span>
                                <span>•</span>
                                <span>Fecha: ${data.commit_date}</span>
                            </div>
                        </div>
                    `;
                } else {
                    statusBox.innerHTML = `
                        <div class="bg-emerald-50/70 border border-emerald-200/80 rounded-2xl p-5 shadow-sm flex items-start gap-4">
                            <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-black text-emerald-900">¡Tu sistema está completamente al día!</h4>
                                <p class="text-xs text-emerald-700 mt-1 leading-relaxed">Cuentas con la última versión oficial sincronizada (Commit <code class="font-mono font-bold bg-emerald-100/80 px-1.5 py-0.5 rounded text-emerald-800">${data.commit_short}</code>).</p>
                            </div>
                        </div>
                    `;
                }
            } else {
                statusBox.innerHTML = `
                    <div class="text-xs font-bold text-red-600 bg-red-50 border border-red-200 p-4 rounded-xl">
                        ${data.message}
                    </div>
                `;
            }
        } catch (e) {
            statusBox.innerHTML = `
                <div class="text-xs font-bold text-red-600 bg-red-50 border border-red-200 p-4 rounded-xl">
                    Error al consultar servidor: ${e.message}
                </div>
            `;
        } finally {
            if (btn) btn.innerHTML = '<svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg> Buscar Actualizaciones';
        }
    }

    async function runGitHubUpdate() {
        const confirmResult = await Swal.fire({
            title: '¿Deseas actualizar el CMS ahora?',
            text: 'Se instalarán las últimas mejoras de código y parches de seguridad de forma transparente. Tus datos y archivos subidos están protegidos.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Actualizar Sistema',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        });

        if (!confirmResult.isConfirmed) return;

        const btn = document.getElementById('btn-run-update');
        if (btn) btn.disabled = true;

        Swal.fire({
            title: 'Actualizando el sistema...',
            html: '<p class="text-xs text-gray-500 mt-2">Por favor no cierres la ventana. Sincronizando código y ejecutando migraciones de base de datos...</p>',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        try {
            const res = await fetch('<?= url("admin/actualizaciones/run") ?>', { method: 'POST' });
            const data = await res.json();

            if (data.success) {
                await Swal.fire({
                    title: '¡Sistema Actualizado con Éxito!',
                    text: 'El CMS se ha sincronizado correctamente a la última versión oficial.',
                    icon: 'success',
                    confirmButtonText: 'Excelente'
                });
                window.location.reload();
            } else {
                Swal.fire({
                    title: 'Aviso durante la actualización',
                    text: data.message || 'No se pudo completar el proceso.',
                    icon: 'warning',
                    confirmButtonText: 'Entendido'
                });
            }
        } catch (e) {
            Swal.fire({
                title: 'Error de Servidor',
                text: 'Ocurrió un error inesperado: ' + e.message,
                icon: 'error',
                confirmButtonText: 'Cerrar'
            });
        } finally {
            if (btn) btn.disabled = false;
        }
    }
</script>
