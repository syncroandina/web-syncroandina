<?php 
// Usando el nuevo helper asset() definido en app/helpers.php
?>
<div class="space-y-6 max-w-full overflow-hidden">
    <div class="flex justify-between items-center px-2">
        <h2 class="text-2xl font-bold text-gray-800">Identidad Corporativa</h2>
    </div>

    <!-- Mensajes de Estado -->
    <div class="px-2">
        <?php if(isset($_GET['success'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative shadow-sm flex items-center gap-3 mb-4 animate-fade-in">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-bold">¡Éxito! Los cambios se procesaron correctamente.</span>
            </div>
        <?php endif; ?>

        <?php if(isset($_GET['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative shadow-sm flex items-center gap-3 mb-4 animate-fade-in">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <strong class="font-bold">Error:</strong>
                    <span class="block sm:inline">
                        <?php 
                            switch($_GET['error']) {
                                case 'invalid_logo_format': echo "El logo debe ser .webp, .png o .jpg"; break;
                                case 'invalid_favicon_format': echo "El favicon debe ser .png, .ico o .webp"; break;
                                case 'not_found': echo "No se encontró la imagen para eliminar."; break;
                                default: echo "Ocurrió un error al procesar la solicitud.";
                            }
                        ?>
                    </span>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Secciones Principales -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 p-2">
        
        <!-- Bloque 1: Imágenes -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex flex-col">
            <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Imágenes de Identidad
            </h3>
            
            <form action="<?= url('admin/identidad/images') ?>" method="POST" enctype="multipart/form-data" class="space-y-8 flex-grow">
                <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
                
                <!-- Logo -->
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <label class="block text-sm font-bold text-gray-700">Logo Principal</label>
                        <?php if(!empty($settings['logo_url'])): ?>
                            <button type="button" onclick="confirmDelete('logo')" class="text-xs text-red-500 hover:text-red-700 font-bold flex items-center gap-1 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Eliminar Actual
                            </button>
                        <?php endif; ?>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                        <div class="bg-gray-50 p-4 rounded-xl border border-dashed border-gray-300 flex items-center justify-center min-h-[140px] relative overflow-hidden group">
                            <?php if(!empty($settings['logo_url'])): ?>
                                <img id="preview-logo" src="<?= asset($settings['logo_url']) ?>" alt="Logo Actual" class="max-h-24 w-auto object-contain transition-transform group-hover:scale-105">
<?php else: ?>
                                <img id="preview-logo" src="" alt="Vista previa" class="hidden max-h-24 w-auto object-contain">
                                <div id="no-logo-text" class="text-center">
                                    <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-gray-400 text-xs italic">Sin logo configurado</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="space-y-3">
                            <input type="file" name="logo" id="input-logo" accept=".webp,.png,.jpg,.jpeg" class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-secondary hover:file:bg-blue-100 cursor-pointer">
                            <div class="bg-blue-50 p-3 rounded-lg border border-blue-100">
                                <p class="text-[11px] text-blue-700 leading-tight">
                                    <strong>Tip:</strong> Sube una imagen con fondo transparente para un acabado más profesional.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="pt-2">
                        <label class="block text-[11px] font-extrabold uppercase tracking-widest text-gray-500 mb-2">Texto Alternativo del Logo (SEO ALT)</label>
                        <input type="text" name="logo_alt" value="<?= htmlspecialchars($settings['logo_alt'] ?? 'Syncro Andina SAS') ?>" class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-3.5 text-sm bg-gray-50 transition-all" placeholder="Ej: Logotipo de Syncro Andina Ingeniería">
                    </div>
                </div>

                <hr class="border-gray-100">

                <!-- Favicon -->
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <label class="block text-sm font-bold text-gray-700">Favicon</label>
                        <?php if(!empty($settings['favicon_url'])): ?>
                            <button type="button" onclick="confirmDelete('favicon')" class="text-xs text-red-500 hover:text-red-700 font-bold flex items-center gap-1 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Eliminar Actual
                            </button>
                        <?php endif; ?>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                        <div class="bg-gray-50 p-4 rounded-xl border border-dashed border-gray-300 flex items-center justify-center min-h-[140px]">
                            <?php if(!empty($settings['favicon_url'])): ?>
                                <img id="preview-favicon" src="<?= asset($settings['favicon_url']) ?>" alt="Favicon Actual" class="w-16 h-16 object-contain shadow-sm bg-white rounded p-2">
                            <?php else: ?>
                                <img id="preview-favicon" src="" alt="Vista previa" class="hidden w-16 h-16 object-contain">
                                <div id="no-favicon-text" class="text-center">
                                    <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                                    <span class="text-gray-400 text-xs italic">Sin favicon</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="space-y-2">
                            <input type="file" name="favicon" id="input-favicon" accept=".png,.ico,.webp" class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-secondary hover:file:bg-blue-100 cursor-pointer">
                            <p class="text-[10px] text-gray-400">Tamaño ideal: 32x32 o 64x64 px.</p>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-secondary text-white px-6 py-4 rounded-xl font-bold hover:bg-blue-600 transition-all shadow-lg shadow-blue-100 flex items-center justify-center gap-2 mt-auto transform active:scale-[0.98]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Guardar Imágenes de Identidad
                </button>
            </form>
        </div>

        <!-- Bloque 2: Colores -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex flex-col">
            <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                Colores Corporativos
            </h3>
            <p class="text-sm text-gray-500 mb-8">Define la paleta cromática global de la interfaz pública.</p>
            
            <form action="<?= url('admin/identidad/colors') ?>" method="POST" class="space-y-6 flex-grow">
                <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                    <?php 
                    $colorLabels = [
                        'color_primary' => 'Primario',
                        'color_secondary' => 'Secundario',
                        'color_accent' => 'Énfasis',
                        'color_light_gray' => 'Gris Claro',
                        'color_gray' => 'Gris Medio',
                        'color_dark_gray' => 'Gris Oscuro'
                    ];
                    $defaultColors = [
                        'color_primary' => '#0f172a',
                        'color_secondary' => '#3b82f6',
                        'color_accent' => '#0ea5e9',
                        'color_light_gray' => '#f8fafc',
                        'color_gray' => '#64748b',
                        'color_dark_gray' => '#1e293b'
                    ];
                    foreach($colorLabels as $key => $label): ?>
                    <div class="group">
                        <label class="block text-sm font-bold text-gray-600 mb-2 transition-colors group-focus-within:text-secondary"><?= $label ?></label>
                        <div class="flex items-center gap-2">
                            <div class="relative w-12 h-10 shrink-0">
                                <input type="color" id="picker_<?= $key ?>" value="<?= htmlspecialchars($settings[$key] ?? $defaultColors[$key]) ?>" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                <div id="display_<?= $key ?>" class="w-full h-full rounded-lg border border-gray-200 shadow-sm" style="background-color: <?= htmlspecialchars($settings[$key] ?? $defaultColors[$key]) ?>"></div>
                            </div>
                            <input type="text" name="<?= $key ?>" id="input_<?= $key ?>" value="<?= htmlspecialchars($settings[$key] ?? $defaultColors[$key]) ?>" class="bg-gray-50 text-xs font-mono p-2.5 rounded-lg border border-gray-200 w-full focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all">
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <button type="submit" class="w-full bg-primary text-white px-6 py-4 rounded-xl font-bold hover:bg-gray-800 transition-all shadow-lg shadow-gray-100 mt-auto transform active:scale-[0.98]">
                    Guardar Paleta de Colores
                </button>
            </form>
        </div>

    </div>

    <!-- Bloque 3: Tipografías -->
    <div class="px-2 pb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Tipografías (Google Fonts)
            </h3>
            <p class="text-sm text-gray-500 mb-8">Personaliza las fuentes del sitio. Ingresa el nombre exacto (ej: <em>Montserrat</em>, <em>Open Sans</em>).</p>

            <form action="<?= url('admin/identidad/typography') ?>" method="POST">
                <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-8 mb-10">
                    <?php for($i=1; $i<=6; $i++): $key = "font_h{$i}"; ?>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Encabezado H<?= $i ?></label>
                        <input type="text" name="<?= $key ?>" value="<?= htmlspecialchars($settings[$key] ?? 'Inter') ?>" placeholder="Ej: Poppins" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all font-semibold text-gray-700 bg-gray-50/50">
                    </div>
                    <?php endfor; ?>
                    
                    <div class="sm:col-span-2 space-y-2">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Cuerpo de Texto (Body)</label>
                        <input type="text" name="font_body" value="<?= htmlspecialchars($settings['font_body'] ?? 'Inter') ?>" placeholder="Ej: Roboto" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all font-semibold text-gray-700 bg-gray-50/50">
                    </div>
                </div>

                <div class="flex justify-start">
                    <button type="submit" class="bg-secondary text-white px-10 py-4 rounded-xl font-bold hover:bg-blue-600 transition-all shadow-lg shadow-blue-50 flex items-center gap-2 transform active:scale-[0.98]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path></svg>
                        Actualizar Tipografías
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Formulario Oculto para Eliminación -->
<form id="delete-image-form" action="<?= url('admin/identidad/images/delete') ?>" method="POST" class="hidden">
    <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
    <input type="hidden" name="type" id="delete-type">
</form>

<script>
    // Sincronización de colores
    document.querySelectorAll('input[type="color"]').forEach(picker => {
        const id = picker.id.replace('picker_', '');
        const input = document.getElementById('input_' + id);
        const display = document.getElementById('display_' + id);
        
        picker.addEventListener('input', (e) => {
            const val = e.target.value.toUpperCase();
            input.value = val;
            display.style.backgroundColor = val;
        });
        
        input.addEventListener('input', (e) => {
            const val = e.target.value;
            if(/^#[0-9A-F]{6}$/i.test(val)) {
                picker.value = val;
                display.style.backgroundColor = val;
            }
        });
    });

    // Previsualización de imágenes
    function setupPreview(inputId, previewId, textId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        const text = document.getElementById(textId);

        input.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if (text) text.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
    }

    setupPreview('input-logo', 'preview-logo', 'no-logo-text');
    setupPreview('input-favicon', 'preview-favicon', 'no-favicon-text');

    // Confirmación de eliminación
    function confirmDelete(type) {
        if (confirm('¿Estás seguro de que deseas eliminar este archivo? Esta acción no se puede deshacer.')) {
            document.getElementById('delete-type').value = type;
            document.getElementById('delete-image-form').submit();
        }
    }
</script>

<style>
    .animate-fade-in {
        animation: fadeIn 0.3s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
