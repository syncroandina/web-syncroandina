<!-- Quill Rich Text Editor Assets -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<style>
  .ql-container.ql-snow {
    border-bottom-left-radius: 1rem;
    border-bottom-right-radius: 1rem;
    border-color: #e2e8f0 !important;
    font-family: inherit;
    min-height: 130px;
  }
  .ql-toolbar.ql-snow {
    border-top-left-radius: 1rem;
    border-top-right-radius: 1rem;
    border-color: #e2e8f0 !important;
    background-color: #f8fafc;
  }
  .ql-editor {
    font-size: 0.875rem;
    color: #1e293b;
  }
  .ql-editor.ql-blank::before {
    font-style: normal;
    color: #94a3b8;
  }
</style>

<div class="space-y-10">
    <!-- Header de la Página -->
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Gestión de Servicios</h1>
            <p class="text-gray-500 text-sm mt-1">Administra las páginas de servicios que se muestran en el sitio web.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <button onclick="openSettingsModal()" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-3 rounded-xl text-sm font-bold transition-colors flex items-center gap-2 border border-gray-200 shadow-sm">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Configurar Textos Inicio
            </button>
            <button onclick="openServiceModal()" class="bg-primary hover:bg-secondary text-white px-6 py-3 rounded-xl text-sm font-bold transition-colors flex items-center gap-2 shadow-lg shadow-primary/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nuevo Servicio
            </button>
        </div>
    </div>

    <?php if(isset($_GET['success'])): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative shadow-sm flex items-center gap-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="block sm:inline font-medium">¡Operación realizada con éxito!</span>
        </div>
    <?php endif; ?>

    <!-- Tabla de Servicios -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 text-gray-400 text-[11px] font-bold uppercase tracking-widest border-b border-gray-100">
                        <th class="px-6 py-5 text-center w-16">Orden</th>
                        <th class="px-6 py-5">Imagen</th>
                        <th class="px-6 py-5">Servicio</th>
                        <th class="px-6 py-5">Slug / URL</th>
                        <th class="px-6 py-5 text-center">Clonar (SEO)</th>
                        <th class="px-6 py-5 text-center">Estado</th>
                        <th class="px-6 py-5 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody id="sortable-services" class="divide-y divide-gray-50">
                    <?php if(!empty($services)): ?>
                        <?php foreach($services as $service): 
                            $isClonedEnabled = !empty($service['enable_seo_clones']);
                        ?>
                            <tr data-id="<?= $service['id'] ?>" class="hover:bg-blue-50/30 transition-colors group">
                                <td class="px-6 py-5 text-center cursor-move text-gray-300 group-hover:text-secondary drag-handle">
                                    <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="w-16 h-12 rounded-xl bg-gray-100 overflow-hidden shadow-sm border border-gray-200">
                                        <?php if(!empty($service['image'])): ?>
                                            <img src="<?= asset($service['image']) ?>" class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="block font-extrabold text-gray-900 group-hover:text-secondary transition-colors"><?= htmlspecialchars($service['title']) ?></span>
                                    <span class="block text-xs text-gray-500 mt-0.5 line-clamp-1"><?= htmlspecialchars(mb_strimwidth(strip_tags($service['consists_of'] ?? ''), 0, 120, '...')) ?></span>
                                </td>
                                <td class="px-6 py-5">
                                    <a href="<?= url('servicios/' . $service['slug']) ?>" target="_blank" class="inline-flex items-center gap-1.5 text-[10px] bg-gray-100 hover:bg-emerald-50 text-gray-600 hover:text-emerald-700 px-2.5 py-1 rounded-lg font-bold transition-colors group/link" title="Ver página pública del servicio">
                                        <code>/servicios/<?= htmlspecialchars($service['slug']) ?></code>
                                        <svg class="w-3 h-3 text-gray-400 group-hover/link:text-emerald-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    </a>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <label class="relative inline-flex items-center cursor-pointer" title="Activar clonación SEO por ubicación">
                                        <input type="checkbox" class="sr-only peer" <?= $isClonedEnabled ? 'checked' : '' ?> 
                                               onchange="toggleServiceSeoClones(<?= $service['id'] ?>)">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                                    </label>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <label class="relative inline-flex items-center cursor-pointer" title="Activar/Desactivar servicio">
                                        <input type="checkbox" class="sr-only peer" <?= $service['is_active'] ? 'checked' : '' ?> 
                                               onchange="toggleServiceStatus(<?= $service['id'] ?>, this.checked)">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-secondary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-secondary"></div>
                                    </label>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <div class="flex justify-end items-center gap-2">
                                        <!-- Botón Flecha Acordeón para ver URLs clonadas -->
                                        <button onclick="toggleCloneAccordion(<?= $service['id'] ?>)" 
                                                class="px-2.5 py-1.5 rounded-xl bg-purple-50 text-purple-700 hover:bg-purple-100 flex items-center gap-1 transition-all text-xs font-bold shadow-2xs" 
                                                title="Ver URLs Clonadas por Ubicación">
                                            <svg id="clones-icon-<?= $service['id'] ?>" class="w-4 h-4 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                            <span class="hidden sm:inline">Clones</span>
                                        </button>

                                        <!-- Botón Ver Página Pública del Servicio Padre -->
                                        <a href="<?= url('servicios/' . $service['slug']) ?>" target="_blank" class="w-9 h-9 rounded-xl bg-gray-100 text-emerald-600 hover:bg-emerald-600 hover:text-white flex items-center justify-center transition-all shadow-sm" title="Ver servicio en la web (Página pública)">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        </a>

                                        <button onclick='editService(<?= $service['id'] ?>)' class="w-9 h-9 rounded-xl bg-gray-100 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-all shadow-sm" title="Editar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                        <form action="<?= url('admin/servicios/duplicate') ?>" method="POST" class="inline-block">
                                            <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
                                            <input type="hidden" name="id" value="<?= $service['id'] ?>">
                                            <button type="submit" class="w-9 h-9 rounded-xl bg-gray-100 text-teal-600 hover:bg-teal-600 hover:text-white flex items-center justify-center transition-all shadow-sm" title="Duplicar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg>
                                            </button>
                                        </form>
                                        <form action="<?= url('admin/servicios/delete') ?>" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este servicio?');" class="inline-block">
                                            <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
                                            <input type="hidden" name="id" value="<?= $service['id'] ?>">
                                            <button type="submit" class="w-9 h-9 rounded-xl bg-gray-100 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center transition-all shadow-sm" title="Eliminar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- Panel Acordeón de Clones por Ubicación -->
                            <tr id="clones-panel-<?= $service['id'] ?>" class="hidden bg-purple-50/20 border-b border-gray-100">
                                <td colspan="7" class="px-8 py-5">
                                    <div class="bg-white rounded-2xl p-5 border border-purple-100 shadow-sm space-y-3">
                                        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                                            <div class="flex items-center gap-2">
                                                <div class="w-7 h-7 rounded-lg bg-purple-100 text-purple-700 flex items-center justify-center font-bold">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                                </div>
                                                <h4 class="text-sm font-extrabold text-gray-900">
                                                    URLs Clonadas por Ubicación (SEO Programático)
                                                </h4>
                                                <?php if($isClonedEnabled && !empty($activeLocations)): ?>
                                                    <span class="text-xs bg-purple-100 text-purple-800 font-bold px-2.5 py-0.5 rounded-full">
                                                        <?= count($activeLocations) ?> URLs activas
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <span class="text-xs text-gray-400">
                                                Servicio Padre: <strong class="text-gray-700"><?= htmlspecialchars($service['title']) ?></strong>
                                            </span>
                                        </div>

                                        <?php if(!$isClonedEnabled): ?>
                                            <div class="p-4 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl text-xs flex items-center justify-between">
                                                <span>La clonación SEO por ubicación está desactivada para este servicio. Activa el switch "Clonar (SEO)" en la tabla para generarlas automáticamente.</span>
                                                <button onclick="toggleServiceSeoClones(<?= $service['id'] ?>)" class="bg-amber-600 text-white font-bold px-3 py-1.5 rounded-lg hover:bg-amber-700 transition-colors">
                                                    Activar Clonación SEO
                                                </button>
                                            </div>
                                        <?php elseif(empty($activeLocations)): ?>
                                            <div class="p-4 bg-gray-50 text-gray-500 rounded-xl text-xs italic">
                                                No hay lugares activos en el sistema. Dirígete a <a href="/admin/lugares" class="text-secondary font-bold hover:underline">Lugares (Ciudades/Distritos)</a> para agregar países, departamentos o distritos.
                                            </div>
                                        <?php else: 
                                            // Structuring active locations into hierarchy tree: Country -> Department -> District
                                            $treeCountries = [];
                                            $treeDepts = [];
                                            $treeDistricts = [];

                                            foreach ($activeLocations as $loc) {
                                                $type = $loc['type'] ?? 'country';
                                                if ($type === 'country') {
                                                    $treeCountries[$loc['id']] = [
                                                        'data' => $loc,
                                                        'departments' => []
                                                    ];
                                                } elseif ($type === 'department') {
                                                    $treeDepts[$loc['id']] = [
                                                        'data' => $loc,
                                                        'districts' => []
                                                    ];
                                                } else {
                                                    $treeDistricts[] = $loc;
                                                }
                                            }

                                            $unattachedDistricts = [];
                                            foreach ($treeDistricts as $dist) {
                                                $pId = $dist['parent_id'] ?? null;
                                                if ($pId && isset($treeDepts[$pId])) {
                                                    $treeDepts[$pId]['districts'][] = $dist;
                                                } else {
                                                    $unattachedDistricts[] = $dist;
                                                }
                                            }

                                            $unattachedDepts = [];
                                            foreach ($treeDepts as $deptId => $deptNode) {
                                                $pId = $deptNode['data']['parent_id'] ?? null;
                                                if ($pId && isset($treeCountries[$pId])) {
                                                    $treeCountries[$pId]['departments'][] = $deptNode;
                                                } else {
                                                    $unattachedDepts[] = $deptNode;
                                                }
                                            }
                                        ?>
                                            <div class="space-y-3 max-h-72 overflow-y-auto pr-2.5 custom-scrollbar-visible">
                                                <?php foreach ($treeCountries as $cId => $cNode): 
                                                    $country = $cNode['data'];
                                                    $cCloneUrl = url('servicios/' . $service['slug'] . '-en-' . $country['slug']);
                                                ?>
                                                    <div class="bg-emerald-50/30 border border-emerald-200/80 rounded-2xl p-3 space-y-2">
                                                        <!-- Country Row -->
                                                        <div class="flex items-center justify-between p-2.5 bg-white rounded-xl border border-emerald-200 shadow-2xs text-xs">
                                                            <div class="flex items-center gap-2 truncate pr-2">
                                                                <span class="text-[9px] px-2 py-0.5 rounded-full font-bold border bg-emerald-50 text-emerald-700 border-emerald-200">
                                                                    País
                                                                </span>
                                                                <span class="font-extrabold text-emerald-950 truncate"><?= htmlspecialchars($service['title']) ?> en <?= htmlspecialchars($country['name']) ?></span>
                                                            </div>
                                                            <div class="flex items-center gap-1 flex-shrink-0">
                                                                <a href="<?= $cCloneUrl ?>" target="_blank" class="p-1.5 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors" title="Abrir URL pública">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                                </a>
                                                                <button onclick="navigator.clipboard.writeText('<?= $cCloneUrl ?>'); alert('URL copiada al portapapeles');" class="p-1.5 text-gray-500 hover:bg-gray-200 rounded-lg transition-colors" title="Copiar URL">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012 2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                                                </button>
                                                            </div>
                                                        </div>

                                                        <!-- Departments -->
                                                        <?php if (!empty($cNode['departments'])): ?>
                                                            <div class="pl-3 md:pl-5 border-l-2 border-emerald-300/80 ml-2 space-y-2">
                                                                <?php foreach ($cNode['departments'] as $dNode): 
                                                                    $dept = $dNode['data'];
                                                                    $dCloneUrl = url('servicios/' . $service['slug'] . '-en-' . $dept['slug']);
                                                                ?>
                                                                    <div class="bg-blue-50/40 border border-blue-200/80 rounded-xl p-2.5 space-y-2 shadow-2xs">
                                                                        <div class="flex items-center justify-between p-2 bg-white rounded-lg border border-blue-200 text-xs shadow-2xs">
                                                                            <div class="flex items-center gap-2 truncate pr-2">
                                                                                <span class="text-[9px] px-2 py-0.5 rounded-full font-bold border bg-blue-50 text-blue-700 border-blue-200">
                                                                                    Dept.
                                                                                </span>
                                                                                <span class="font-bold text-blue-950 truncate"><?= htmlspecialchars($service['title']) ?> en <?= htmlspecialchars($dept['name']) ?></span>
                                                                            </div>
                                                                            <div class="flex items-center gap-1 flex-shrink-0">
                                                                                <a href="<?= $dCloneUrl ?>" target="_blank" class="p-1.5 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors" title="Abrir URL pública">
                                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                                                </a>
                                                                                <button onclick="navigator.clipboard.writeText('<?= $dCloneUrl ?>'); alert('URL copiada al portapapeles');" class="p-1.5 text-gray-500 hover:bg-gray-200 rounded-lg transition-colors" title="Copiar URL">
                                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012 2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                                                                </button>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Districts -->
                                                                        <?php if (!empty($dNode['districts'])): ?>
                                                                            <div class="pl-3 md:pl-4 border-l-2 border-blue-300/80 ml-2 space-y-1.5">
                                                                                <?php foreach ($dNode['districts'] as $dist): 
                                                                                    $distCloneUrl = url('servicios/' . $service['slug'] . '-en-' . $dist['slug']);
                                                                                ?>
                                                                                    <div class="flex items-center justify-between p-2 bg-white hover:bg-purple-50/50 rounded-lg border border-purple-200/80 text-xs transition-colors shadow-2xs">
                                                                                        <div class="flex items-center gap-2 truncate pr-2">
                                                                                            <span class="text-[9px] px-2 py-0.5 rounded-full font-bold border bg-purple-50 text-purple-700 border-purple-200">
                                                                                                Distrito
                                                                                            </span>
                                                                                            <span class="font-medium text-gray-800 truncate"><?= htmlspecialchars($service['title']) ?> en <?= htmlspecialchars($dist['name']) ?></span>
                                                                                        </div>
                                                                                        <div class="flex items-center gap-1 flex-shrink-0">
                                                                                            <a href="<?= $distCloneUrl ?>" target="_blank" class="p-1.5 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors" title="Abrir URL pública">
                                                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                                                            </a>
                                                                                            <button onclick="navigator.clipboard.writeText('<?= $distCloneUrl ?>'); alert('URL copiada al portapapeles');" class="p-1.5 text-gray-500 hover:bg-gray-200 rounded-lg transition-colors" title="Copiar URL">
                                                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012 2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                <?php endforeach; ?>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endforeach; ?>

                                                <!-- Unattached Depts -->
                                                <?php foreach ($unattachedDepts as $dNode): 
                                                    $dept = $dNode['data'];
                                                    $dCloneUrl = url('servicios/' . $service['slug'] . '-en-' . $dept['slug']);
                                                ?>
                                                    <div class="bg-blue-50/40 border border-blue-200/80 rounded-xl p-2.5 space-y-2 shadow-2xs">
                                                        <div class="flex items-center justify-between p-2 bg-white rounded-lg border border-blue-200 text-xs shadow-2xs">
                                                            <div class="flex items-center gap-2 truncate pr-2">
                                                                <span class="text-[9px] px-2 py-0.5 rounded-full font-bold border bg-blue-50 text-blue-700 border-blue-200">
                                                                    Dept.
                                                                </span>
                                                                <span class="font-bold text-blue-950 truncate"><?= htmlspecialchars($service['title']) ?> en <?= htmlspecialchars($dept['name']) ?></span>
                                                            </div>
                                                            <div class="flex items-center gap-1 flex-shrink-0">
                                                                <a href="<?= $dCloneUrl ?>" target="_blank" class="p-1.5 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors" title="Abrir URL pública">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                                </a>
                                                                <button onclick="navigator.clipboard.writeText('<?= $dCloneUrl ?>'); alert('URL copiada al portapapeles');" class="p-1.5 text-gray-500 hover:bg-gray-200 rounded-lg transition-colors" title="Copiar URL">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012 2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <?php if (!empty($dNode['districts'])): ?>
                                                            <div class="pl-3 md:pl-4 border-l-2 border-blue-300/80 ml-2 space-y-1.5">
                                                                <?php foreach ($dNode['districts'] as $dist): 
                                                                    $distCloneUrl = url('servicios/' . $service['slug'] . '-en-' . $dist['slug']);
                                                                ?>
                                                                    <div class="flex items-center justify-between p-2 bg-white hover:bg-purple-50/50 rounded-lg border border-purple-200/80 text-xs transition-colors shadow-2xs">
                                                                        <div class="flex items-center gap-2 truncate pr-2">
                                                                            <span class="text-[9px] px-2 py-0.5 rounded-full font-bold border bg-purple-50 text-purple-700 border-purple-200">
                                                                                Distrito
                                                                            </span>
                                                                            <span class="font-medium text-gray-800 truncate"><?= htmlspecialchars($service['title']) ?> en <?= htmlspecialchars($dist['name']) ?></span>
                                                                        </div>
                                                                        <div class="flex items-center gap-1 flex-shrink-0">
                                                                            <a href="<?= $distCloneUrl ?>" target="_blank" class="p-1.5 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors" title="Abrir URL pública">
                                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                                            </a>
                                                                            <button onclick="navigator.clipboard.writeText('<?= $distCloneUrl ?>'); alert('URL copiada al portapapeles');" class="p-1.5 text-gray-500 hover:bg-gray-200 rounded-lg transition-colors" title="Copiar URL">
                                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012 2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endforeach; ?>

                                                <!-- Unattached Districts -->
                                                <?php foreach ($unattachedDistricts as $dist): 
                                                    $distCloneUrl = url('servicios/' . $service['slug'] . '-en-' . $dist['slug']);
                                                ?>
                                                    <div class="flex items-center justify-between p-2 bg-white hover:bg-purple-50/50 rounded-lg border border-purple-200/80 text-xs transition-colors shadow-2xs">
                                                        <div class="flex items-center gap-2 truncate pr-2">
                                                            <span class="text-[9px] px-2 py-0.5 rounded-full font-bold border bg-purple-50 text-purple-700 border-purple-200">
                                                                Distrito
                                                            </span>
                                                            <span class="font-medium text-gray-800 truncate"><?= htmlspecialchars($service['title']) ?> en <?= htmlspecialchars($dist['name']) ?></span>
                                                        </div>
                                                        <div class="flex items-center gap-1 flex-shrink-0">
                                                            <a href="<?= $distCloneUrl ?>" target="_blank" class="p-1.5 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors" title="Abrir URL pública">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                            </a>
                                                            <button onclick="navigator.clipboard.writeText('<?= $distCloneUrl ?>'); alert('URL copiada al portapapeles');" class="p-1.5 text-gray-500 hover:bg-gray-200 rounded-lg transition-colors" title="Copiar URL">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012 2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="px-8 py-20 text-center text-gray-400 italic bg-gray-50/30">No se encontraron servicios configurados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal para Servicios -->
<div id="service-modal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden z-50 items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 w-full max-w-4xl overflow-hidden transform transition-all scale-95 opacity-0 duration-300 flex flex-col h-[90vh]" id="modal-container">
        
        <form id="service-form" action="<?= url('admin/servicios') ?>" method="POST" enctype="multipart/form-data" class="flex flex-col h-full overflow-hidden">
            <!-- Header Fijo -->
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 flex-none z-20">
                <div class="flex items-center gap-3">
                    <h4 id="modal-title" class="text-xl font-extrabold text-gray-900">Nuevo Servicio</h4>
                    <a id="modal-view-live-btn" href="#" target="_blank" class="hidden px-3 py-1.5 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 border border-emerald-200 shadow-2xs" title="Ver página pública en la web">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        <span>Ver en la web</span>
                    </a>
                </div>
                <button type="button" onclick="closeServiceModal()" class="text-gray-400 hover:text-gray-600 transition-colors p-2 hover:bg-white rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Cuerpo del Formulario (Scrollable en el centro) -->
            <div class="flex-1 overflow-y-auto overflow-x-hidden p-8 space-y-10" id="service-form-scroll-body">
                <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
                <input type="hidden" name="id" id="service-id" value="">
                
                <!-- 1. DATOS PRINCIPALES Y HERO (H1) -->
                <div class="space-y-6">
                    <h5 class="text-xs font-black text-secondary uppercase tracking-widest pl-2 border-l-4 border-secondary">
                        1. Datos Principales del Servicio (H1)
                    </h5>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Nombre del Servicio (H1)</label>
                            <input type="text" name="title" id="service-title" required onkeyup="generateSlug(this.value)" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50" placeholder="Ej: Proyectos de Generación en Baja y Media Tensión">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Slug (URL)</label>
                            <input type="text" name="slug" id="service-slug" required class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50" placeholder="proyectos-de-generacion-en-baja-y-media-tension">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Texto Alternativo de Imagen (SEO ALT)</label>
                            <input type="text" name="image_alt" id="service-image-alt" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50" placeholder="Ej: Instalación de plantas de generación térmica y subestaciones">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Imagen Principal / Banner Hero</label>
                            <div class="relative group">
                                <div class="w-full aspect-[21/9] max-h-48 rounded-2xl bg-gray-100 border-2 border-dashed border-gray-200 overflow-hidden flex flex-col items-center justify-center relative cursor-pointer hover:border-secondary transition-colors" onclick="document.getElementById('service-image').click()">
                                    <img id="image-preview" src="" class="hidden w-full h-full object-cover">
                                    <div id="upload-placeholder" class="text-center">
                                        <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span class="text-[10px] font-bold text-gray-400 uppercase">Banner del Servicio</span>
                                    </div>
                                </div>
                                <input type="file" name="image" id="service-image" class="hidden" accept="image/*" onchange="previewImage(this)">
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="border-gray-100">

                <!-- 2. ¿EN QUÉ CONSISTE EL SERVICIO? (H2) -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h5 class="text-xs font-black text-secondary uppercase tracking-widest pl-2 border-l-4 border-secondary">
                            2. ¿En qué consiste el servicio? (H2)
                        </h5>
                        <input type="text" name="heading_consists_of" id="service-heading-consists-of" class="border-gray-200 rounded-xl px-3 py-1 text-xs bg-gray-50 w-64 text-right" placeholder="Título H2: ¿En qué consiste?">
                    </div>
                    <div>
                        <div id="quill-editor-consists-of" class="bg-white"></div>
                        <input type="hidden" name="consists_of" id="service-consists-of">
                    </div>
                </div>

                <hr class="border-gray-100">

                <!-- 3. TIPOS DE SERVICIO (H2/H3) -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <div class="flex items-center gap-3">
                            <h5 class="text-xs font-black text-secondary uppercase tracking-widest pl-2 border-l-4 border-secondary">
                                3. Tipos de Servicio (H2 / H3)
                            </h5>
                            <input type="text" name="heading_types" id="service-heading-types" class="border-gray-200 rounded-xl px-3 py-1 text-xs bg-gray-50 w-52" placeholder="Título H2: Tipos de servicio">
                        </div>
                        <button type="button" onclick="addTypeItem()" class="px-4 py-2 bg-gray-900 text-white text-xs font-bold rounded-xl hover:bg-black transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Añadir Tipo (H3)
                        </button>
                    </div>
                    <div id="types-container" class="space-y-4"></div>
                </div>

                <hr class="border-gray-100">

                <!-- 4. BENEFICIOS (H2/H3) -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <div class="flex items-center gap-3">
                            <h5 class="text-xs font-black text-secondary uppercase tracking-widest pl-2 border-l-4 border-secondary">
                                4. Beneficios (H2 / H3)
                            </h5>
                            <input type="text" name="heading_benefits" id="service-heading-benefits" class="border-gray-200 rounded-xl px-3 py-1 text-xs bg-gray-50 w-52" placeholder="Título H2: Beneficios">
                        </div>
                        <button type="button" onclick="addBenefitItem()" class="px-4 py-2 bg-secondary text-white text-xs font-bold rounded-xl hover:bg-primary transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Añadir Beneficio (H3)
                        </button>
                    </div>
                    <div id="benefits-container" class="space-y-4"></div>
                </div>

                <hr class="border-gray-100">

                <!-- 5. PROCESO DE TRABAJO (H2/H3) -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <div class="flex items-center gap-3">
                            <h5 class="text-xs font-black text-secondary uppercase tracking-widest pl-2 border-l-4 border-secondary">
                                5. Proceso de Trabajo (H2 / H3)
                            </h5>
                            <input type="text" name="heading_process" id="service-heading-process" class="border-gray-200 rounded-xl px-3 py-1 text-xs bg-gray-50 w-52" placeholder="Título H2: Proceso de trabajo">
                        </div>
                        <button type="button" onclick="addProcessItem()" class="px-4 py-2 bg-gray-900 text-white text-xs font-bold rounded-xl hover:bg-black transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Añadir Paso (Evaluación, Ejecución, Entrega)
                        </button>
                    </div>
                    <div id="process-container" class="space-y-4"></div>
                </div>

                <hr class="border-gray-100">

                <!-- 6. MATERIALES O METODOLOGÍA (H2) -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h5 class="text-xs font-black text-secondary uppercase tracking-widest pl-2 border-l-4 border-secondary">
                            6. Materiales o Metodología (H2)
                        </h5>
                        <input type="text" name="heading_materials" id="service-heading-materials" class="border-gray-200 rounded-xl px-3 py-1 text-xs bg-gray-50 w-64 text-right" placeholder="Título H2: Materiales o metodología">
                    </div>
                    <div>
                        <div id="quill-editor-materials" class="bg-white"></div>
                        <input type="hidden" name="materials_methodology" id="service-materials">
                    </div>
                </div>

                <hr class="border-gray-100">

                <!-- 7. TRABAJOS REALIZADOS / GALERÍA (H2) -->
                <div class="space-y-4">
                    <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                        <div class="flex items-center gap-3">
                            <h5 class="text-xs font-black text-secondary uppercase tracking-widest pl-2 border-l-4 border-secondary">
                                7. Galería de fotos (H2)
                            </h5>
                            <input type="text" name="heading_gallery" id="service-heading-gallery" class="border-gray-200 rounded-xl px-3 py-1 text-xs bg-gray-50 w-52" placeholder="H2: Galería de fotos">
                        </div>
                        <button type="button" onclick="document.getElementById('gallery-upload').click()" class="px-4 py-2 bg-secondary text-white text-xs font-bold rounded-xl hover:bg-primary transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Subir Fotos
                        </button>
                        <input type="file" id="gallery-upload" name="gallery_images[]" multiple class="hidden" accept="image/*" onchange="previewGallery(this)">
                    </div>

                    <div id="gallery-preview-container" class="grid grid-cols-2 md:grid-cols-4 gap-4"></div>
                </div>

                <hr class="border-gray-100">

                <!-- 8. PROYECTOS RELACIONADOS (H2) -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <div class="flex items-center gap-3">
                            <h5 class="text-xs font-black text-secondary uppercase tracking-widest pl-2 border-l-4 border-secondary">
                                8. Proyectos Relacionados (H2)
                            </h5>
                            <input type="text" name="heading_projects" id="service-heading-projects" class="border-gray-200 rounded-xl px-3 py-1 text-xs bg-gray-50 w-52" placeholder="H2: Proyectos relacionados">
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">
                        <select id="related-projects-select" class="flex-1 min-w-0 max-w-full border-gray-200 rounded-xl p-3 text-xs bg-gray-50 font-medium focus:ring-2 focus:ring-secondary/20 focus:border-secondary truncate">
                            <option value="">-- Seleccionar proyecto para añadir --</option>
                            <?php if (!empty($projects)): ?>
                                <?php foreach($projects as $p): ?>
                                    <option value="<?= $p['id'] ?>" data-title="<?= htmlspecialchars($p['title'], ENT_QUOTES) ?>" data-slug="<?= htmlspecialchars($p['slug'], ENT_QUOTES) ?>">
                                        <?= htmlspecialchars($p['title']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <button type="button" onclick="addRelatedProjectFromSelect()" class="px-4 py-3 bg-secondary text-white text-xs font-bold rounded-xl hover:bg-primary transition-all flex items-center justify-center gap-2 flex-none shadow-sm whitespace-nowrap">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Añadir Proyecto
                        </button>
                    </div>

                    <div id="related-projects-container" class="space-y-3"></div>
                </div>

                <hr class="border-gray-100">

                <!-- 9. PRECIO Y TIEMPO (H2) -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h5 class="text-xs font-black text-secondary uppercase tracking-widest pl-2 border-l-4 border-secondary">
                            9. Precio y Tiempo (H2)
                        </h5>
                        <input type="text" name="heading_pricing" id="service-heading-pricing" class="border-gray-200 rounded-xl px-3 py-1 text-xs bg-gray-50 w-64 text-right" placeholder="Título H2: Precio y tiempo">
                    </div>
                    <div>
                        <div id="quill-editor-pricing" class="bg-white"></div>
                        <input type="hidden" name="pricing_timeline" id="service-pricing">
                    </div>
                </div>

                <hr class="border-gray-100">

                <!-- 10. ¿POR QUÉ ELEGIRNOS? (H2) -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h5 class="text-xs font-black text-secondary uppercase tracking-widest pl-2 border-l-4 border-secondary">
                            10. ¿Por qué elegirnos? (H2)
                        </h5>
                        <input type="text" name="heading_why_choose_us" id="service-heading-why-choose-us" class="border-gray-200 rounded-xl px-3 py-1 text-xs bg-gray-50 w-64 text-right" placeholder="Título H2: ¿Por qué elegirnos?">
                    </div>
                    <div>
                        <div id="quill-editor-why-choose-us" class="bg-white"></div>
                        <input type="hidden" name="why_choose_us" id="service-why-choose-us">
                    </div>
                </div>

                <hr class="border-gray-100">

                <!-- 11. COBERTURA (H2) -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h5 class="text-xs font-black text-secondary uppercase tracking-widest pl-2 border-l-4 border-secondary">
                            11. Cobertura Geográfica (H2)
                        </h5>
                        <input type="text" name="heading_coverage" id="service-heading-coverage" class="border-gray-200 rounded-xl px-3 py-1 text-xs bg-gray-50 w-52 text-right" placeholder="H2: Cobertura">
                    </div>
                    <div>
                        <div id="quill-editor-coverage" class="bg-white"></div>
                        <input type="hidden" name="coverage" id="service-coverage">
                    </div>
                </div>

                <hr class="border-gray-100">

                <!-- 12. PREGUNTAS FRECUENTES - FAQS (H2/H3) -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <div class="flex items-center gap-3">
                            <h5 class="text-xs font-black text-secondary uppercase tracking-widest pl-2 border-l-4 border-secondary">
                                12. Preguntas Frecuentes - FAQs (H2 / H3)
                            </h5>
                            <input type="text" name="heading_faqs" id="service-heading-faqs" class="border-gray-200 rounded-xl px-3 py-1 text-xs bg-gray-50 w-52" placeholder="H2: Preguntas frecuentes">
                        </div>
                        <button type="button" onclick="addFaqItem()" class="px-4 py-2 bg-secondary text-white text-xs font-bold rounded-xl hover:bg-primary transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Añadir Pregunta (H3)
                        </button>
                    </div>
                    <div id="faqs-container" class="space-y-4"></div>
                </div>

                <hr class="border-gray-100">

                <!-- 13. SERVICIOS RELACIONADOS (H2) -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <div class="flex items-center gap-3">
                            <h5 class="text-xs font-black text-secondary uppercase tracking-widest pl-2 border-l-4 border-secondary">
                                13. Servicios Relacionados (H2)
                            </h5>
                            <input type="text" name="heading_related" id="service-heading-related" class="border-gray-200 rounded-xl px-3 py-1 text-xs bg-gray-50 w-52" placeholder="H2: Servicios relacionados">
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">
                        <select id="related-services-select" class="flex-1 min-w-0 max-w-full border-gray-200 rounded-xl p-3 text-xs bg-gray-50 font-medium focus:ring-2 focus:ring-secondary/20 focus:border-secondary truncate">
                            <option value="">-- Seleccionar servicio para añadir --</option>
                            <?php if (!empty($services)): ?>
                                <?php foreach($services as $s): ?>
                                    <option value="<?= $s['id'] ?>" data-title="<?= htmlspecialchars($s['title'], ENT_QUOTES) ?>" data-slug="<?= htmlspecialchars($s['slug'], ENT_QUOTES) ?>">
                                        <?= htmlspecialchars($s['title']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <button type="button" onclick="addRelatedServiceFromSelect()" class="px-4 py-3 bg-secondary text-white text-xs font-bold rounded-xl hover:bg-primary transition-all flex items-center justify-center gap-2 flex-none shadow-sm whitespace-nowrap">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Añadir Servicio
                        </button>
                    </div>

                    <div id="related-services-container" class="space-y-3"></div>
                </div>

                <hr class="border-gray-100">

                <!-- 14. DETALLES / ÍTEMS ADICIONALES (H2/H3) -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <div class="flex items-center gap-3">
                            <h5 class="text-xs font-black text-secondary uppercase tracking-widest pl-2 border-l-4 border-secondary">
                                14. Ítems / Detalles Específicos (H3)
                            </h5>
                            <input type="text" name="heading_details" id="service-heading-details" class="border-gray-200 rounded-xl px-3 py-1 text-xs bg-gray-50 w-52" placeholder="Título H3: Detalles del servicio">
                        </div>
                        <button type="button" onclick="addDetailItem()" class="px-4 py-2 bg-gray-900 text-white text-xs font-bold rounded-xl hover:bg-black transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Añadir Ítem
                        </button>
                    </div>
                    <div id="items-container" class="space-y-4"></div>
                </div>

                <hr class="border-gray-100">

                <!-- 15. CTA / COTIZACIÓN (H2) -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h5 class="text-xs font-black text-secondary uppercase tracking-widest pl-2 border-l-4 border-secondary">
                            15. Solicita una Cotización (CTA)
                        </h5>
                        <input type="text" name="heading_cta" id="service-heading-cta" class="border-gray-200 rounded-xl px-3 py-1 text-xs bg-gray-50 w-52 text-right" placeholder="H2: ¿Interesado en este Servicio?">
                    </div>
                    <div>
                        <div id="quill-editor-cta-description" class="bg-white"></div>
                        <input type="hidden" name="cta_description" id="service-cta-description">
                    </div>
                </div>

                <hr class="border-gray-100">

                <!-- 16. ETIQUETAS META SEO (BUSCADORES) -->
                <div class="space-y-4">
                    <h5 class="text-xs font-black text-secondary uppercase tracking-widest pl-2 border-l-4 border-secondary">
                        16. Meta Etiquetas SEO (Buscadores)
                    </h5>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Meta Title (Título del Buscador)</label>
                            <input type="text" name="seo_title" id="service-seo-title" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50" placeholder="Ej: Servicio de Consultoría Tecnológica">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Meta Keywords (Palabras Clave)</label>
                            <input type="text" name="seo_keywords" id="service-seo-keywords" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50" placeholder="Ej: energia, tableros, mantenimiento, ingenieria">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 pl-1">Meta Description (Descripción del Buscador)</label>
                            <textarea name="seo_description" id="service-seo-description" rows="3" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50 resize-none" placeholder="Describe el servicio en 150-160 caracteres para Google..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Fijo con Botones Estáticos -->
            <div class="p-6 border-t border-gray-200 flex items-center justify-between bg-white flex-none z-20 shadow-[0_-4px_20px_rgba(0,0,0,0.04)]">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" id="service-active" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-secondary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-secondary"></div>
                    <span class="ml-3 text-sm font-bold text-gray-500">Publicar Servicio</span>
                </label>
                
                <div class="flex gap-4">
                    <button type="button" onclick="closeServiceModal()" class="px-6 py-3 bg-white border border-gray-200 text-gray-600 rounded-xl font-bold hover:bg-gray-50 transition-all">Cancelar</button>
                    <button type="submit" class="px-10 py-3 bg-gray-900 text-white rounded-xl font-bold hover:bg-black transition-all shadow-xl">Guardar Servicio</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal para Configurar Textos Inicio -->
<div id="settings-modal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden z-50 items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 w-full max-w-3xl overflow-hidden transform transition-all scale-95 opacity-0 duration-300 flex flex-col max-h-[90vh]" id="settings-modal-container">
        <!-- Header -->
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h4 class="text-xl font-extrabold text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Configurar Textos y Ajustes de Servicios
            </h4>
            <button onclick="closeSettingsModal()" class="text-gray-400 hover:text-gray-600 transition-colors p-2 hover:bg-white rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form action="<?= url('admin/servicios/settings') ?>" method="POST" enctype="multipart/form-data" class="p-8 space-y-6 overflow-y-auto flex-1">
            <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
            
            <!-- SECCIÓN EN INICIO -->
            <div class="space-y-4">
                <h5 class="text-xs font-black text-secondary uppercase tracking-widest pl-2 border-l-4 border-secondary">Sección en Portada (Inicio)</h5>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2 pl-1">Etiqueta Superior</label>
                        <input type="text" name="services_label" value="<?= htmlspecialchars($settings['services_label'] ?? 'Lo que hacemos') ?>" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2 pl-1">Título de Sección</label>
                        <input type="text" name="services_title" value="<?= htmlspecialchars($settings['services_title'] ?? 'Nuestros Servicios Especializados') ?>" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50">
                    </div>
                </div>
                
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2 pl-1">Descripción de la Sección</label>
                    <textarea name="services_description" rows="2" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50 resize-none" placeholder="Breve descripción de la sección..."><?= htmlspecialchars($settings['services_description'] ?? '') ?></textarea>
                </div>
                
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2 pl-1">Título Intermedio (H2)</label>
                    <input type="text" name="services_subtitle" value="<?= htmlspecialchars($settings['services_subtitle'] ?? '') ?>" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50" placeholder="Ej: Soluciones de Generación Eléctrica, Fabricación de Tableros y Servicios Electromecánicos">
                </div>
                
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2 pl-1">Límite de Servicios en Inicio</label>
                    <input type="number" name="services_limit" min="1" max="50" value="<?= htmlspecialchars($settings['services_limit'] ?? '6') ?>" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50" placeholder="Ej: 6">
                    <p class="text-[10px] text-gray-400 mt-1.5 pl-1 font-bold uppercase tracking-wider">Indica cuántos servicios activos se mostrarán como máximo en la portada principal.</p>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2 pl-1">Velocidad del Carrusel (Milisegundos)</label>
                    <input type="number" name="carousel_services_speed" min="500" max="20000" step="100" value="<?= htmlspecialchars($settings['carousel_services_speed'] ?? '3000') ?>" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50" placeholder="Ej: 3000">
                    <p class="text-[10px] text-gray-400 mt-1.5 pl-1 font-bold uppercase tracking-wider">Intervalo de auto-avance automático. Ej: 3000 para 3 segundos.</p>
                </div>
            </div>

            <hr class="border-gray-100">

            <!-- PÁGINA DE SERVICIOS -->
            <div class="space-y-4">
                <h5 class="text-xs font-black text-secondary uppercase tracking-widest pl-2 border-l-4 border-secondary">Página Principal de Servicios (/servicios)</h5>
                
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2 pl-1">Título de la Página (H1)</label>
                    <input type="text" name="page_services_title" value="<?= htmlspecialchars($settings['page_services_title'] ?? 'Soluciones Estratégicas') ?>" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50">
                </div>
                
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2 pl-1">Descripción de la Página</label>
                    <textarea name="page_services_description" rows="3" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50 resize-none" placeholder="Descripción para la página de servicios..."><?= htmlspecialchars($settings['page_services_description'] ?? 'Catálogo completo de servicios corporativos enfocados en la innovación tecnológica, diseñados modularmente para adaptarse a la escala de tu negocio.') ?></textarea>
                </div>
            </div>

            <hr class="border-gray-100">

            <!-- SECCIÓN DE COBERTURA GEOGRÁFICA (UBICACIONES) -->
            <div class="space-y-4">
                <h5 class="text-xs font-black text-secondary uppercase tracking-widest pl-2 border-l-4 border-secondary">Sección Cobertura por Ubicación (Enlaces SEO)</h5>
                
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2 pl-1">Título de la Sección</label>
                    <input type="text" name="services_locations_title" value="<?= htmlspecialchars($settings['services_locations_title'] ?? 'Este servicio también se brinda en:') ?>" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50" placeholder="Ej: Este servicio también se brinda en:">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2 pl-1">Mapa / Imagen de Fondo para la Sección (Fondo Oscuro)</label>
                    <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                        <?php if (!empty($settings['services_locations_bg_image'])): ?>
                            <div class="w-24 h-16 rounded-xl bg-slate-900 border border-gray-200 overflow-hidden relative group shadow-sm flex-shrink-0">
                                <img src="<?= asset($settings['services_locations_bg_image']) ?>" class="w-full h-full object-cover opacity-60">
                            </div>
                            <div class="flex-1">
                                <span class="text-xs font-bold text-gray-700 block">Mapa de Fondo Actual</span>
                                <label class="inline-flex items-center gap-1.5 text-xs text-red-600 font-bold hover:underline cursor-pointer mt-1">
                                    <input type="checkbox" name="remove_locations_bg_image" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                    <span>Eliminar mapa de fondo actual</span>
                                </label>
                            </div>
                        <?php endif; ?>
                        <div class="flex-1">
                            <input type="file" name="services_locations_bg_image" accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-gray-200 file:text-gray-700 hover:file:bg-gray-300 cursor-pointer">
                            <p class="text-[10px] text-gray-400 mt-1 pl-1">Subir imagen de mapa de fondo (PNG, JPG, WEBP o SVG).</p>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="border-gray-100">

            <!-- OPTIMIZACIÓN SEO -->
            <div class="space-y-4">
                <h5 class="text-xs font-black text-secondary uppercase tracking-widest pl-2 border-l-4 border-secondary">Optimización SEO (Página /servicios)</h5>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2 pl-1">Meta Title (Título SEO)</label>
                        <input type="text" name="services_seo_title" value="<?= htmlspecialchars($settings['services_seo_title'] ?? 'Nuestros Servicios') ?>" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50" placeholder="Título para la pestaña del navegador...">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2 pl-1">Meta Keywords (Palabras clave)</label>
                        <input type="text" name="services_seo_keywords" value="<?= htmlspecialchars($settings['services_seo_keywords'] ?? 'servicios, software, tecnología, ingeniería') ?>" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50" placeholder="Separadas por comas (ej. software, servicios)...">
                    </div>
                </div>
                
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2 pl-1">Meta Description (Descripción SEO)</label>
                    <textarea name="services_seo_description" rows="3" class="w-full border-gray-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-4 text-sm bg-gray-50 resize-none" placeholder="Breve resumen de 150 a 160 caracteres para Google..."><?= htmlspecialchars($settings['services_seo_description'] ?? 'Ofrecemos servicios especializados en ingeniería de software, consultoría y desarrollo a medida.') ?></textarea>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex justify-end gap-4 pt-4 border-t border-gray-50">
                <button type="button" onclick="closeSettingsModal()" class="px-6 py-3 bg-white border border-gray-200 text-gray-600 rounded-xl font-bold hover:bg-gray-50 transition-all">Cancelar</button>
                <button type="submit" class="px-10 py-3 bg-gray-900 text-white rounded-xl font-bold hover:bg-black transition-all shadow-xl">Actualizar Cambios</button>
            </div>
        </form>
    </div>
</div>

<script>
let quillConsistsOf, quillMaterials, quillPricing, quillWhyChooseUs, quillCoverage, quillCtaDescription;
let galleryDataTransfer = new DataTransfer();
const modal = document.getElementById('service-modal');
const container = document.getElementById('modal-container');
const itemsContainer = document.getElementById('items-container');
const galleryContainer = document.getElementById('gallery-preview-container');

const settingsModal = document.getElementById('settings-modal');
const settingsContainer = document.getElementById('settings-modal-container');

function openSettingsModal() {
    settingsModal.classList.remove('hidden');
    settingsModal.classList.add('flex');
    setTimeout(() => {
        settingsContainer.classList.remove('scale-95', 'opacity-0');
        settingsContainer.classList.add('scale-100', 'opacity-100');
    }, 10);
    document.body.style.overflow = 'hidden';
}

function closeSettingsModal() {
    settingsContainer.classList.remove('scale-100', 'opacity-100');
    settingsContainer.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        settingsModal.classList.add('hidden');
        settingsModal.classList.remove('flex');
    }, 300);
    document.body.style.overflow = 'auto';
}

function openServiceModal() {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => {
        container.classList.remove('scale-95', 'opacity-0');
        container.classList.add('scale-100', 'opacity-100');
    }, 10);
    document.body.style.overflow = 'hidden';
}

function closeServiceModal() {
    container.classList.remove('scale-100', 'opacity-100');
    container.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        resetServiceForm();
    }, 300);
    document.body.style.overflow = 'auto';
}

function resetServiceForm() {
    document.getElementById('service-form').reset();
    document.getElementById('service-id').value = '';
    document.getElementById('service-image-alt').value = '';
    document.getElementById('image-preview').src = '';
    document.getElementById('image-preview').classList.add('hidden');
    document.getElementById('upload-placeholder').classList.remove('hidden');
    document.getElementById('modal-title').innerText = 'Nuevo Servicio';
    itemsContainer.innerHTML = '';
    galleryContainer.innerHTML = '';

    const typesContainer = document.getElementById('types-container');
    const benefitsContainer = document.getElementById('benefits-container');
    const processContainer = document.getElementById('process-container');
    const faqsContainer = document.getElementById('faqs-container');
    if (typesContainer) typesContainer.innerHTML = '';
    if (benefitsContainer) benefitsContainer.innerHTML = '';
    if (processContainer) processContainer.innerHTML = '';
    if (faqsContainer) faqsContainer.innerHTML = '';

    // Limpiar Secciones
    document.getElementById('service-consists-of').value = '';
    document.getElementById('service-materials').value = '';
    document.getElementById('service-pricing').value = '';
    document.getElementById('service-why-choose-us').value = '';
    document.getElementById('service-coverage').value = '';
    document.getElementById('service-cta-description').value = '';

    // Limpiar Encabezados
    document.getElementById('service-heading-consists-of').value = '¿En qué consiste?';
    document.getElementById('service-heading-types').value = 'Tipos de servicio';
    document.getElementById('service-heading-benefits').value = 'Beneficios';
    document.getElementById('service-heading-process').value = 'Proceso de trabajo';
    document.getElementById('service-heading-materials').value = 'Materiales o metodología';
    document.getElementById('service-heading-gallery').value = 'Galería de fotos';
    document.getElementById('service-heading-projects').value = 'Proyectos relacionados';
    document.getElementById('service-heading-pricing').value = 'Precio y tiempo';
    document.getElementById('service-heading-why-choose-us').value = '¿Por qué elegirnos?';
    document.getElementById('service-heading-coverage').value = 'Cobertura';
    document.getElementById('service-heading-faqs').value = 'Preguntas frecuentes';
    document.getElementById('service-heading-related').value = 'Servicios relacionados';
    document.getElementById('service-heading-details').value = 'Detalles del servicio';
    document.getElementById('service-heading-cta').value = '¿Interesado en este Servicio?';

    const relatedContainer = document.getElementById('related-services-container');
    if (relatedContainer) relatedContainer.innerHTML = '';
    updateRelatedServicesSelect();

    const relatedProjectsContainer = document.getElementById('related-projects-container');
    if (relatedProjectsContainer) relatedProjectsContainer.innerHTML = '';
    updateRelatedProjectsSelect();
    
    // Limpiar campos SEO
    document.getElementById('service-seo-title').value = '';
    document.getElementById('service-seo-keywords').value = '';
    document.getElementById('service-seo-description').value = '';

    if (quillConsistsOf) quillConsistsOf.setContents([]);
    if (quillMaterials) quillMaterials.setContents([]);
    if (quillPricing) quillPricing.setContents([]);
    if (quillWhyChooseUs) quillWhyChooseUs.setContents([]);
    if (quillCoverage) quillCoverage.setContents([]);
    if (quillCtaDescription) quillCtaDescription.setContents([]);
    galleryDataTransfer = new DataTransfer();
    document.getElementById('gallery-upload').files = galleryDataTransfer.files;
    
    const liveBtn = document.getElementById('modal-view-live-btn');
    if (liveBtn) {
        liveBtn.classList.add('hidden');
        liveBtn.href = '#';
    }

    // Resetear posición del scroll al inicio
    const formBody = document.getElementById('service-form-scroll-body');
    if (formBody) formBody.scrollTop = 0;
}

async function editService(id) {
    resetServiceForm();
    try {
        const response = await fetch(`<?= url('admin/servicios/get') ?>?id=${id}`);
        const service = await response.json();
        
        document.getElementById('service-id').value = service.id;
        document.getElementById('service-title').value = service.title;
        document.getElementById('service-slug').value = service.slug;
        document.getElementById('service-image-alt').value = service.image_alt || '';
        document.getElementById('service-active').checked = service.is_active == 1;
        
        // Secciones principales
        document.getElementById('service-consists-of').value = service.consists_of || '';
        if (quillConsistsOf) quillConsistsOf.root.innerHTML = service.consists_of || '';

        document.getElementById('service-materials').value = service.materials_methodology || '';
        if (quillMaterials) quillMaterials.root.innerHTML = service.materials_methodology || '';

        document.getElementById('service-pricing').value = service.pricing_timeline || '';
        if (quillPricing) quillPricing.root.innerHTML = service.pricing_timeline || '';

        document.getElementById('service-why-choose-us').value = service.why_choose_us || '';
        if (quillWhyChooseUs) quillWhyChooseUs.root.innerHTML = service.why_choose_us || '';

        document.getElementById('service-coverage').value = service.coverage || '';
        if (quillCoverage) quillCoverage.root.innerHTML = service.coverage || '';

        document.getElementById('service-cta-description').value = service.cta_description || '';
        if (quillCtaDescription) quillCtaDescription.root.innerHTML = service.cta_description || '';

        // Encabezados
        document.getElementById('service-heading-consists-of').value = service.heading_consists_of || '¿En qué consiste?';
        document.getElementById('service-heading-types').value = service.heading_types || 'Tipos de servicio';
        document.getElementById('service-heading-benefits').value = service.heading_benefits || 'Beneficios';
        document.getElementById('service-heading-process').value = service.heading_process || 'Proceso de trabajo';
        document.getElementById('service-heading-materials').value = service.heading_materials || 'Materiales o metodología';
        document.getElementById('service-heading-gallery').value = service.heading_gallery || 'Galería de fotos';
        document.getElementById('service-heading-projects').value = service.heading_projects || 'Proyectos relacionados';
        document.getElementById('service-heading-pricing').value = service.heading_pricing || 'Precio y tiempo';
        document.getElementById('service-heading-why-choose-us').value = service.heading_why_choose_us || '¿Por qué elegirnos?';
        document.getElementById('service-heading-coverage').value = service.heading_coverage || 'Cobertura';
        document.getElementById('service-heading-faqs').value = service.heading_faqs || 'Preguntas frecuentes';
        document.getElementById('service-heading-related').value = service.heading_related || 'Servicios relacionados';
        document.getElementById('service-heading-details').value = service.heading_details || 'Detalles del servicio';
        document.getElementById('service-heading-cta').value = service.heading_cta || '¿Interesado en este Servicio?';
        document.getElementById('service-cta-description').value = service.cta_description || '';
        
        // Cargar campos SEO individuales
        document.getElementById('service-seo-title').value = service.seo_title || '';
        document.getElementById('service-seo-keywords').value = service.seo_keywords || '';
        document.getElementById('service-seo-description').value = service.seo_description || '';
        
        if(service.image) {
            const preview = document.getElementById('image-preview');
            let basePath = '<?= asset('') ?>';
            if (basePath.endsWith('/') && service.image.startsWith('/')) {
                preview.src = basePath + service.image.substring(1);
            } else {
                preview.src = basePath + service.image;
            }
            preview.classList.remove('hidden');
            document.getElementById('upload-placeholder').classList.add('hidden');
        }

        // Cargar Tipos
        if(service.types && Array.isArray(service.types)) {
            service.types.forEach(t => addTypeItem(t.title, t.description, t.icon));
        }

        // Cargar Beneficios
        if(service.benefits && Array.isArray(service.benefits)) {
            service.benefits.forEach(b => addBenefitItem(b.title, b.description, b.icon));
        }

        // Cargar Proceso
        if(service.process && Array.isArray(service.process)) {
            service.process.forEach(p => addProcessItem(p.step, p.title, p.description));
        }

        // Cargar FAQs
        if(service.faqs && Array.isArray(service.faqs)) {
            service.faqs.forEach(f => addFaqItem(f.question, f.answer));
        }

        // Cargar Servicios Relacionados
        let relatedIds = [];
        if (service.related_services_json) {
            try {
                relatedIds = JSON.parse(service.related_services_json);
            } catch(e) {}
        }
        const relatedContainer = document.getElementById('related-services-container');
        if (relatedContainer) relatedContainer.innerHTML = '';
        const select = document.getElementById('related-services-select');
        if (select && Array.isArray(relatedIds)) {
            relatedIds.forEach(rId => {
                const option = select.querySelector(`option[value="${rId}"]`);
                if (option) {
                    const title = option.getAttribute('data-title');
                    const slug = option.getAttribute('data-slug');
                    addRelatedServiceItem(rId, title, slug);
                }
            });
        }
        updateRelatedServicesSelect();

        // Cargar Proyectos Relacionados
        let relatedProjectIds = [];
        if (service.related_projects_json) {
            try {
                relatedProjectIds = JSON.parse(service.related_projects_json);
            } catch(e) {}
        }
        const relatedProjectsContainer = document.getElementById('related-projects-container');
        if (relatedProjectsContainer) relatedProjectsContainer.innerHTML = '';
        const selectP = document.getElementById('related-projects-select');
        if (selectP && Array.isArray(relatedProjectIds)) {
            relatedProjectIds.forEach(pId => {
                const optionP = selectP.querySelector(`option[value="${pId}"]`);
                if (optionP) {
                    const title = optionP.getAttribute('data-title');
                    const slug = optionP.getAttribute('data-slug');
                    addRelatedProjectItem(pId, title, slug);
                }
            });
        }
        updateRelatedProjectsSelect();

        // Cargar Items
        if(service.items) {
            service.items.forEach(item => addDetailItem(item.title, item.description));
        }

        // Cargar Galería
        if(service.gallery) {
            service.gallery.forEach(img => addGalleryItem(img.image_path, img.id, img.image_alt));
        }
        
        document.getElementById('modal-title').innerText = 'Editar Servicio';
        
        const liveBtn = document.getElementById('modal-view-live-btn');
        if (liveBtn && service.slug) {
            let baseUrl = '<?= rtrim(url(), '/') ?>';
            liveBtn.href = `${baseUrl}/servicios/${service.slug}`;
            liveBtn.classList.remove('hidden');
        }

        openServiceModal();
    } catch (error) {
        console.error('Error al cargar servicio:', error);
        alert('Error al cargar los datos del servicio.');
    }
}

function addTypeItem(title = '', desc = '', icon = '') {
    const container = document.getElementById('types-container');
    const div = document.createElement('div');
    div.className = 'group bg-gray-50 p-4 rounded-2xl border border-gray-100 flex gap-3 items-center animate-fade-in';
    div.innerHTML = `
        <div class="drag-handle cursor-grab active:cursor-grabbing text-gray-300 hover:text-gray-600 p-1 flex items-center justify-center self-center" title="Arrastrar para reordenar">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M9 5a1 1 0 100-2 1 1 0 000 2zM15 5a1 1 0 100-2 1 1 0 000 2zM9 12a1 1 0 100-2 1 1 0 000 2zM15 12a1 1 0 100-2 1 1 0 000 2zM9 19a1 1 0 100-2 1 1 0 000 2zM15 19a1 1 0 100-2 1 1 0 000 2z"></path></svg>
        </div>
        <div class="flex-1 grid grid-cols-1 gap-3">
            <input type="text" name="type_title[]" value="${title}" placeholder="Título del Tipo (H3)" class="w-full border-gray-200 rounded-xl p-3 text-xs font-bold bg-white">
            <input type="text" name="type_description[]" value="${desc}" placeholder="Descripción corta" class="w-full border-gray-200 rounded-xl p-3 text-xs bg-white">
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600 p-2 hover:bg-red-50 rounded-lg transition-all self-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
        </button>
    `;
    container.appendChild(div);
}

function addBenefitItem(title = '', desc = '', icon = '') {
    const container = document.getElementById('benefits-container');
    const div = document.createElement('div');
    div.className = 'group bg-gray-50 p-4 rounded-2xl border border-gray-100 flex gap-3 items-center animate-fade-in';
    div.innerHTML = `
        <div class="drag-handle cursor-grab active:cursor-grabbing text-gray-300 hover:text-gray-600 p-1 flex items-center justify-center self-center" title="Arrastrar para reordenar">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M9 5a1 1 0 100-2 1 1 0 000 2zM15 5a1 1 0 100-2 1 1 0 000 2zM9 12a1 1 0 100-2 1 1 0 000 2zM15 12a1 1 0 100-2 1 1 0 000 2zM9 19a1 1 0 100-2 1 1 0 000 2zM15 19a1 1 0 100-2 1 1 0 000 2z"></path></svg>
        </div>
        <div class="flex-1 grid grid-cols-1 gap-3">
            <input type="text" name="benefit_title[]" value="${title}" placeholder="Título del Beneficio (H3)" class="w-full border-gray-200 rounded-xl p-3 text-xs font-bold bg-white">
            <input type="text" name="benefit_description[]" value="${desc}" placeholder="Descripción del beneficio" class="w-full border-gray-200 rounded-xl p-3 text-xs bg-white">
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600 p-2 hover:bg-red-50 rounded-lg transition-all self-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
        </button>
    `;
    container.appendChild(div);
}

function addProcessItem(step = '', title = '', desc = '') {
    const container = document.getElementById('process-container');
    const stepNumber = step || (container.children.length + 1);
    const div = document.createElement('div');
    div.className = 'group bg-gray-50 p-4 rounded-2xl border border-gray-100 flex gap-3 items-center animate-fade-in';
    div.innerHTML = `
        <div class="drag-handle cursor-grab active:cursor-grabbing text-gray-300 hover:text-gray-600 p-1 flex items-center justify-center self-center" title="Arrastrar para reordenar">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M9 5a1 1 0 100-2 1 1 0 000 2zM15 5a1 1 0 100-2 1 1 0 000 2zM9 12a1 1 0 100-2 1 1 0 000 2zM15 12a1 1 0 100-2 1 1 0 000 2zM9 19a1 1 0 100-2 1 1 0 000 2zM15 19a1 1 0 100-2 1 1 0 000 2z"></path></svg>
        </div>
        <div class="step-badge flex-none w-8 h-8 rounded-xl bg-secondary/10 text-secondary font-extrabold flex items-center justify-center text-xs shadow-sm self-center">
            ${stepNumber}
        </div>
        <div class="flex-1 space-y-3">
            <input type="hidden" name="process_step[]" value="${stepNumber}">
            <input type="text" name="process_title[]" value="${title}" placeholder="Fase / Nombre (H3) ej: Evaluación" class="w-full border-gray-200 rounded-xl p-3 text-xs font-bold bg-white">
            <input type="text" name="process_description[]" value="${desc}" placeholder="Explicación detallada de este paso..." class="w-full border-gray-200 rounded-xl p-3 text-xs bg-white">
        </div>
        <button type="button" onclick="this.parentElement.remove(); reorderProcessSteps();" class="text-red-400 hover:text-red-600 p-2 hover:bg-red-50 rounded-lg transition-all self-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
        </button>
    `;
    container.appendChild(div);
}

function reorderProcessSteps() {
    const container = document.getElementById('process-container');
    if (!container) return;
    Array.from(container.children).forEach((child, index) => {
        const badge = child.querySelector('.step-badge');
        const hiddenInput = child.querySelector('input[name="process_step[]"]');
        if (badge) badge.innerText = index + 1;
        if (hiddenInput) hiddenInput.value = index + 1;
    });
}

function addFaqItem(question = '', answer = '') {
    const container = document.getElementById('faqs-container');
    const div = document.createElement('div');
    div.className = 'group bg-gray-50 p-4 rounded-2xl border border-gray-100 flex gap-3 items-center animate-fade-in';
    div.innerHTML = `
        <div class="drag-handle cursor-grab active:cursor-grabbing text-gray-300 hover:text-gray-600 p-1 flex items-center justify-center self-center" title="Arrastrar para reordenar">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M9 5a1 1 0 100-2 1 1 0 000 2zM15 5a1 1 0 100-2 1 1 0 000 2zM9 12a1 1 0 100-2 1 1 0 000 2zM15 12a1 1 0 100-2 1 1 0 000 2zM9 19a1 1 0 100-2 1 1 0 000 2zM15 19a1 1 0 100-2 1 1 0 000 2z"></path></svg>
        </div>
        <div class="flex-1 space-y-3">
            <input type="text" name="faq_question[]" value="${question}" placeholder="Pregunta Frecuente (H3)" class="w-full border-gray-200 rounded-xl p-3 text-xs font-bold bg-white">
            <textarea name="faq_answer[]" rows="2" placeholder="Respuesta..." class="w-full border-gray-200 rounded-xl p-3 text-xs bg-white resize-none">${answer}</textarea>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600 p-2 hover:bg-red-50 rounded-lg transition-all self-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
        </button>
    `;
    container.appendChild(div);
}

function addRelatedServiceFromSelect() {
    const select = document.getElementById('related-services-select');
    if (!select) return;
    const selectedOption = select.options[select.selectedIndex];
    if (!selectedOption || !selectedOption.value) return;

    const id = selectedOption.value;
    const title = selectedOption.getAttribute('data-title');
    const slug = selectedOption.getAttribute('data-slug');

    addRelatedServiceItem(id, title, slug);
    select.value = '';
}

function addRelatedServiceItem(id, title, slug) {
    const container = document.getElementById('related-services-container');
    if (!container) return;

    if (container.querySelector(`[data-related-id="${id}"]`)) {
        alert('Este servicio ya ha sido añadido a la lista.');
        return;
    }

    const currentServiceId = document.getElementById('service-id').value;
    if (currentServiceId && parseInt(currentServiceId) === parseInt(id)) {
        alert('No puedes relacionar un servicio consigo mismo.');
        return;
    }

    const div = document.createElement('div');
    div.className = 'group bg-gray-50 p-4 rounded-2xl border border-gray-100 flex gap-3 items-center min-w-0 animate-fade-in';
    div.setAttribute('data-related-id', id);
    div.innerHTML = `
        <div class="drag-handle cursor-grab active:cursor-grabbing text-gray-300 hover:text-gray-600 p-1 flex items-center justify-center self-center" title="Arrastrar para reordenar">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M9 5a1 1 0 100-2 1 1 0 000 2zM15 5a1 1 0 100-2 1 1 0 000 2zM9 12a1 1 0 100-2 1 1 0 000 2zM15 12a1 1 0 100-2 1 1 0 000 2zM9 19a1 1 0 100-2 1 1 0 000 2zM15 19a1 1 0 100-2 1 1 0 000 2z"></path></svg>
        </div>
        <input type="hidden" name="related_services[]" value="${id}">
        <div class="flex-1 min-w-0">
            <span class="text-sm font-bold text-gray-800 block truncate">${title}</span>
            <span class="text-xs text-gray-400 block truncate">/servicios/${slug}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove(); updateRelatedServicesSelect();" class="text-red-400 hover:text-red-600 p-2 hover:bg-red-50 rounded-lg transition-all self-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
        </button>
    `;
    container.appendChild(div);
    updateRelatedServicesSelect();
}

function updateRelatedServicesSelect() {
    const select = document.getElementById('related-services-select');
    if (!select) return;
    const currentServiceId = document.getElementById('service-id').value;
    const container = document.getElementById('related-services-container');
    const addedIds = container ? Array.from(container.querySelectorAll('input[name="related_services[]"]')).map(el => el.value) : [];

    Array.from(select.options).forEach(opt => {
        if (!opt.value) return;
        const isCurrent = currentServiceId && parseInt(opt.value) === parseInt(currentServiceId);
        const isAlreadyAdded = addedIds.includes(opt.value);

        if (isCurrent || isAlreadyAdded) {
            opt.disabled = true;
            opt.style.display = 'none';
        } else {
            opt.disabled = false;
            opt.style.display = '';
        }
    });
}

function addRelatedProjectFromSelect() {
    const select = document.getElementById('related-projects-select');
    if (!select) return;
    const selectedOption = select.options[select.selectedIndex];
    if (!selectedOption || !selectedOption.value) return;

    const id = selectedOption.value;
    const title = selectedOption.getAttribute('data-title');
    const slug = selectedOption.getAttribute('data-slug');

    addRelatedProjectItem(id, title, slug);
    select.value = '';
}

function addRelatedProjectItem(id, title, slug) {
    const container = document.getElementById('related-projects-container');
    if (!container) return;

    if (container.querySelector(`[data-related-project-id="${id}"]`)) {
        alert('Este proyecto ya ha sido añadido a la lista.');
        return;
    }

    const div = document.createElement('div');
    div.className = 'group bg-gray-50 p-4 rounded-2xl border border-gray-100 flex gap-3 items-center min-w-0 animate-fade-in';
    div.setAttribute('data-related-project-id', id);
    div.innerHTML = `
        <div class="drag-handle cursor-grab active:cursor-grabbing text-gray-300 hover:text-gray-600 p-1 flex items-center justify-center self-center" title="Arrastrar para reordenar">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M9 5a1 1 0 100-2 1 1 0 000 2zM15 5a1 1 0 100-2 1 1 0 000 2zM9 12a1 1 0 100-2 1 1 0 000 2zM15 12a1 1 0 100-2 1 1 0 000 2zM9 19a1 1 0 100-2 1 1 0 000 2zM15 19a1 1 0 100-2 1 1 0 000 2z"></path></svg>
        </div>
        <input type="hidden" name="related_projects[]" value="${id}">
        <div class="flex-1 min-w-0">
            <span class="text-sm font-bold text-gray-800 block truncate">${title}</span>
            <span class="text-xs text-gray-400 block truncate">/proyectos/${slug}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove(); updateRelatedProjectsSelect();" class="text-red-400 hover:text-red-600 p-2 hover:bg-red-50 rounded-lg transition-all self-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
        </button>
    `;
    container.appendChild(div);
    updateRelatedProjectsSelect();
}

function updateRelatedProjectsSelect() {
    const select = document.getElementById('related-projects-select');
    if (!select) return;
    const container = document.getElementById('related-projects-container');
    const addedIds = container ? Array.from(container.querySelectorAll('input[name="related_projects[]"]')).map(el => el.value) : [];

    Array.from(select.options).forEach(opt => {
        if (!opt.value) return;
        const isAlreadyAdded = addedIds.includes(opt.value);
        if (isAlreadyAdded) {
            opt.disabled = true;
            opt.style.display = 'none';
        } else {
            opt.disabled = false;
            opt.style.display = '';
        }
    });
}

function addDetailItem(title = '', desc = '') {
    const div = document.createElement('div');
    div.className = 'group bg-gray-50 p-4 rounded-2xl border border-gray-100 flex gap-3 items-center animate-fade-in';
    div.innerHTML = `
        <div class="drag-handle cursor-grab active:cursor-grabbing text-gray-300 hover:text-gray-600 p-1 flex items-center justify-center self-center" title="Arrastrar para reordenar">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M9 5a1 1 0 100-2 1 1 0 000 2zM15 5a1 1 0 100-2 1 1 0 000 2zM9 12a1 1 0 100-2 1 1 0 000 2zM15 12a1 1 0 100-2 1 1 0 000 2zM9 19a1 1 0 100-2 1 1 0 000 2zM15 19a1 1 0 100-2 1 1 0 000 2z"></path></svg>
        </div>
        <div class="flex-1 grid grid-cols-1 gap-3">
            <input type="text" name="items_titles[]" value="${title}" placeholder="Título del detalle" class="w-full border-gray-200 rounded-xl p-3 text-xs font-bold bg-white">
            <input type="text" name="items_descriptions[]" value="${desc}" placeholder="Descripción corta" class="w-full border-gray-200 rounded-xl p-3 text-xs bg-white">
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600 p-2 hover:bg-red-50 rounded-lg transition-all self-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
        </button>
    `;
    itemsContainer.appendChild(div);
}

function addGalleryItem(path, id, alt = '') {
    const div = document.createElement('div');
    div.className = 'relative group rounded-xl overflow-hidden shadow-sm border border-gray-200 flex flex-col bg-white';
    let basePath = '<?= asset('') ?>';
    let fullPath = (basePath.endsWith('/') && path.startsWith('/')) ? basePath + path.substring(1) : basePath + path;
    
    div.innerHTML = `
        <div class="relative h-32 overflow-hidden bg-gray-50">
            <div class="drag-handle absolute top-2 left-2 z-10 w-7 h-7 bg-black/60 hover:bg-black text-white rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-grab active:cursor-grabbing shadow-lg" title="Arrastrar para reordenar">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 5a1 1 0 100-2 1 1 0 000 2zM15 5a1 1 0 100-2 1 1 0 000 2zM9 12a1 1 0 100-2 1 1 0 000 2zM15 12a1 1 0 100-2 1 1 0 000 2zM9 19a1 1 0 100-2 1 1 0 000 2zM15 19a1 1 0 100-2 1 1 0 000 2z"></path></svg>
            </div>
            <img src="${fullPath}" class="w-full h-full object-cover">
            <button type="button" onclick="deleteGalleryImage(${id}, this)" class="absolute top-2 right-2 w-7 h-7 bg-red-600 text-white rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-lg">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-2 border-t border-gray-100 bg-gray-50/30">
            <input type="hidden" name="service_gallery_ids[]" value="${id}">
            <input type="text" name="service_gallery_alts[${id}]" value="${alt || ''}" placeholder="Texto ALT para SEO" class="w-full px-2 py-1 text-[10px] border border-gray-200 rounded focus:ring-1 focus:ring-secondary focus:border-secondary bg-white placeholder:italic" title="Configura el texto ALT de esta imagen">
        </div>
    `;
    galleryContainer.appendChild(div);
}

function previewGallery(input) {
    if (input.files) {
        Array.from(input.files).forEach(file => {
            // Validar que no se agregue el mismo archivo duplicado en la lista
            let alreadyExists = false;
            for (let i = 0; i < galleryDataTransfer.files.length; i++) {
                const f = galleryDataTransfer.files[i];
                if (f.name === file.name && f.size === file.size && f.lastModified === file.lastModified) {
                    alreadyExists = true;
                    break;
                }
            }
            if (alreadyExists) return;

            galleryDataTransfer.items.add(file);
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative aspect-square rounded-xl overflow-hidden shadow-sm border border-secondary/30 ring-2 ring-secondary/20 group';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-full object-cover opacity-60">
                    <div class="absolute inset-0 flex items-center justify-center text-[10px] font-bold text-secondary uppercase bg-white/40 select-none">Nuevo</div>
                    <button type="button" class="absolute top-2 right-2 w-7 h-7 bg-red-600 text-white rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-lg remove-new-gallery-btn">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                `;
                
                div.querySelector('.remove-new-gallery-btn').onclick = function() {
                    removeFileFromGallery(file);
                    div.remove();
                };
                
                galleryContainer.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
        
        // Sincronizar el input de archivos con la lista acumulada
        input.files = galleryDataTransfer.files;
    }
}

function removeFileFromGallery(fileToRemove) {
    const newDataTransfer = new DataTransfer();
    for (let i = 0; i < galleryDataTransfer.files.length; i++) {
        const file = galleryDataTransfer.files[i];
        if (file !== fileToRemove) {
            newDataTransfer.items.add(file);
        }
    }
    galleryDataTransfer = newDataTransfer;
    document.getElementById('gallery-upload').files = galleryDataTransfer.files;
}

async function deleteGalleryImage(id, btn) {
    if(!confirm('¿Eliminar esta imagen permanentemente?')) return;
    const formData = new FormData();
    formData.append('id', id);
    formData.append('csrf_token', '<?= \Core\Security::generateCSRFToken() ?>');

    try {
        const response = await fetch('<?= url('admin/servicios/gallery/delete') ?>', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();
        if(result.success) {
            btn.parentElement.remove();
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('image-preview');
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            document.getElementById('upload-placeholder').classList.add('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function generateSlug(text) {
    const slug = text.toLowerCase()
        .normalize('NFD').replace(/[\u0300-\u036f]/g, '') // Quitar acentos
        .replace(/[^\w ]+/g, '')
        .replace(/ +/g, '-');
    document.getElementById('service-slug').value = slug;
}

function toggleServiceStatus(id, status) {
    fetch('<?= url('admin/servicios/toggle') ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: id, status: status ? 1 : 0 })
    })
    .then(response => response.json())
    .then(data => {
        if(!data.success) alert('Error al cambiar el estado.');
    })
    .catch(error => console.error('Error:', error));
}

document.addEventListener('DOMContentLoaded', function () {
    const toolbarOptions = [
        ['bold', 'italic', 'underline', 'strike'],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{ 'header': [1, 2, 3, 4, false] }],
        ['clean']
    ];

    quillConsistsOf = new Quill('#quill-editor-consists-of', { theme: 'snow', placeholder: 'Explicación detallada de en qué consiste este servicio...', modules: { toolbar: toolbarOptions } });
    quillMaterials = new Quill('#quill-editor-materials', { theme: 'snow', placeholder: 'Describe los materiales, equipos o metodología empleados...', modules: { toolbar: toolbarOptions } });
    quillPricing = new Quill('#quill-editor-pricing', { theme: 'snow', placeholder: 'Información sobre cotizaciones, estimaciones y tiempos...', modules: { toolbar: toolbarOptions } });
    quillWhyChooseUs = new Quill('#quill-editor-why-choose-us', { theme: 'snow', placeholder: 'Ventajas competitivas, respaldo y garantía...', modules: { toolbar: toolbarOptions } });
    quillCoverage = new Quill('#quill-editor-coverage', { theme: 'snow', placeholder: 'Alcance regional, zonas de atención en el país...', modules: { toolbar: toolbarOptions } });
    quillCtaDescription = new Quill('#quill-editor-cta-description', { theme: 'snow', placeholder: 'Descripción de la invitación a cotizar...', modules: { toolbar: toolbarOptions } });

    // Sincronizar el contenido antes de enviar el formulario
    const form = document.getElementById('service-form');
    if (form) {
        form.addEventListener('submit', function() {
            document.getElementById('service-consists-of').value = quillConsistsOf ? quillConsistsOf.root.innerHTML : '';
            document.getElementById('service-materials').value = quillMaterials ? quillMaterials.root.innerHTML : '';
            document.getElementById('service-pricing').value = quillPricing ? quillPricing.root.innerHTML : '';
            document.getElementById('service-why-choose-us').value = quillWhyChooseUs ? quillWhyChooseUs.root.innerHTML : '';
            document.getElementById('service-coverage').value = quillCoverage ? quillCoverage.root.innerHTML : '';
            document.getElementById('service-cta-description').value = quillCtaDescription ? quillCtaDescription.root.innerHTML : '';
        });
    }

    var el = document.getElementById('sortable-services');
    if (el) {
        Sortable.create(el, {
            handle: '.drag-handle',
            animation: 150,
            ghostClass: 'bg-blue-50',
            onEnd: function () {
                var items = el.querySelectorAll('tr');
                var orderIds = [];
                items.forEach(function(item) {
                    var id = item.getAttribute('data-id');
                    if(id) orderIds.push(id);
                });

                fetch('<?= url('admin/servicios/reorder') ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ order: orderIds })
                })
                .then(response => response.json())
                .then(data => {
                    if(!data.success) alert('Error al actualizar el orden.');
                })
                .catch(error => console.error('Error:', error));
            }
        });
    }

    // Inicializar Drag & Drop en contenedores de ítems del Modal
    const modalSortableOptions = {
        handle: '.drag-handle',
        animation: 150,
        ghostClass: 'opacity-40'
    };

    ['types-container', 'benefits-container', 'faqs-container', 'items-container', 'gallery-preview-container', 'related-services-container', 'related-projects-container'].forEach(id => {
        const c = document.getElementById(id);
        if (c) Sortable.create(c, modalSortableOptions);
    });

    const processC = document.getElementById('process-container');
    if (processC) {
        Sortable.create(processC, {
            ...modalSortableOptions,
            onEnd: function() {
                reorderProcessSteps();
            }
        });
    }
});

function toggleServiceSeoClones(id) {
    fetch('<?= url('admin/servicios/toggle-clones') ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: id })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            location.reload();
        } else {
            alert('No se pudo actualizar el estado de la clonación SEO.');
        }
    })
    .catch(() => alert('Error de conexión con el servidor.'));
}

function toggleCloneAccordion(serviceId) {
    const el = document.getElementById('clones-panel-' + serviceId);
    const icon = document.getElementById('clones-icon-' + serviceId);
    if (el) {
        if (el.classList.contains('hidden')) {
            el.classList.remove('hidden');
            if (icon) icon.classList.add('rotate-180');
        } else {
            el.classList.add('hidden');
            if (icon) icon.classList.remove('rotate-180');
        }
    }
}
</script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

