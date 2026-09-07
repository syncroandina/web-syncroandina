<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div>
            <h1 class="text-2xl font-black text-gray-800 tracking-tight">Lugares (Países, Departamentos y Distritos)</h1>
            <p class="text-gray-500 text-sm mt-1">Estructura jerárquica de 3 niveles. Organiza países, sus departamentos y sus distritos correspondientes.</p>
        </div>
        <button onclick="openModalFor('country')" class="inline-flex items-center gap-2 bg-secondary text-white px-5 py-2.5 rounded-xl font-bold hover:bg-blue-600 transition-all shadow-lg shadow-blue-500/20 text-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Añadir Nuevo Lugar
        </button>
    </div>

    <!-- Feedback Alerts -->
    <?php if (isset($_GET['success'])): ?>
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center justify-between text-sm">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span>
                    <?php 
                        if ($_GET['success'] === 'created') echo '¡Lugar registrado correctamente!';
                        elseif ($_GET['success'] === 'updated') echo '¡Lugar actualizado correctamente!';
                        elseif ($_GET['success'] === 'deleted') echo '¡Lugar eliminado correctamente!';
                        else echo 'Operación realizada con éxito.';
                    ?>
                </span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-bold">&times;</button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl flex items-center justify-between text-sm">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                <span>Ocurrió un error al procesar la solicitud. Por favor intenta nuevamente.</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700 font-bold">&times;</button>
        </div>
    <?php endif; ?>

    <!-- Countries Cards Container -->
    <div id="sortable-countries" class="space-y-6">
        <?php if (empty($hierarchy)): ?>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center text-gray-400 text-sm">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 044 0h.5a2.5 2.5 0 002.5-2.5V3.935M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-base font-bold text-gray-600 mb-1">No hay lugares registrados</p>
                <p class="text-xs text-gray-400 mb-4">Haz clic en "Añadir Nuevo Lugar" para comenzar la jerarquía.</p>
                <button onclick="openModalFor('country')" class="inline-flex items-center gap-2 bg-secondary text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-blue-600 transition-all">
                    + Añadir Nuevo Lugar
                </button>
            </div>
        <?php else: ?>
            <?php foreach ($hierarchy as $country): ?>
                <div data-id="<?= $country['id'] ?>" class="country-card bg-white rounded-2xl shadow-md border border-gray-200/90 overflow-hidden transition-all">
                    <!-- LEVEL 1: Country Header -->
                    <div class="bg-emerald-950/5 border-b border-emerald-900/10 px-6 py-4 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <button title="Arrastrar para reordenar países" class="drag-handle-country cursor-move text-gray-400 hover:text-emerald-700 transition-colors p-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            </button>
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 044 0h.5a2.5 2.5 0 002.5-2.5V3.935M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <h2 class="text-lg font-black text-gray-900 flex items-center gap-2">
                                        <?= htmlspecialchars($country['name']) ?>
                                        <span class="text-xs bg-emerald-100 text-emerald-800 px-2.5 py-0.5 rounded-full font-extrabold uppercase tracking-wider">País</span>
                                    </h2>
                                    <span class="text-xs text-gray-500 font-medium">
                                        <?= count($country['departments']) ?> <?= count($country['departments']) === 1 ? 'departamento / provincia' : 'departamentos / provincias' ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Country Actions -->
                        <div class="flex items-center gap-2">
                            <button onclick="toggleStatus(<?= $country['id'] ?>)" 
                                    class="px-3 py-1 rounded-full text-xs font-bold transition-all <?= $country['is_active'] ? 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200' : 'bg-gray-200 text-gray-500 hover:bg-gray-300' ?>">
                                <?= $country['is_active'] ? 'Activo' : 'Inactivo' ?>
                            </button>

                            <button onclick="openModalFor('department', <?= $country['id'] ?>)" 
                                    class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200 px-3 py-1.5 rounded-xl text-xs font-bold transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Añadir Departamento
                            </button>

                            <button type="button" 
                                    data-id="<?= $country['id'] ?>"
                                    data-name="<?= htmlspecialchars($country['name'], ENT_QUOTES) ?>"
                                    data-parent=""
                                    data-type="country"
                                    data-active="<?= $country['is_active'] ?>"
                                    onclick="openEditLocation(this)" 
                                    class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-3 py-1.5 rounded-xl text-xs font-bold transition-colors">
                                Editar
                            </button>

                            <form action="<?= url('admin/lugares/delete') ?>" method="POST" class="inline-block" onsubmit="return confirm('¿Seguro que deseas eliminar este país? Se eliminarán todos sus departamentos y distritos.');">
                                <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
                                <input type="hidden" name="id" value="<?= $country['id'] ?>">
                                <button type="submit" class="bg-red-50 text-red-600 hover:bg-red-100 px-3 py-1.5 rounded-xl text-xs font-bold transition-colors">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- LEVEL 2: Departments Container -->
                    <div class="p-5 bg-gray-50/50 space-y-4">
                        <?php if (empty($country['departments'])): ?>
                            <div class="border border-dashed border-gray-200 rounded-xl p-5 text-center text-gray-400 text-xs bg-white">
                                No hay departamentos registrados en <?= htmlspecialchars($country['name']) ?>.
                                <button onclick="openModalFor('department', <?= $country['id'] ?>)" class="text-secondary font-bold hover:underline ml-1">
                                    + Añadir primer departamento
                                </button>
                            </div>
                        <?php else: ?>
                            <div id="sortable-departments-<?= $country['id'] ?>" class="sortable-departments space-y-4">
                                <?php foreach ($country['departments'] as $dept): ?>
                                    <div data-id="<?= $dept['id'] ?>" class="department-card bg-white rounded-xl border border-gray-200/90 shadow-2xs overflow-hidden">
                                        <!-- Department Header -->
                                        <div class="bg-blue-50/50 px-5 py-3 border-b border-gray-200 flex flex-col md:flex-row md:items-center justify-between gap-3">
                                            <div class="flex items-center gap-3">
                                                <button title="Arrastrar para reordenar departamentos" class="drag-handle-department cursor-move text-gray-400 hover:text-blue-600 transition-colors p-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                                </button>
                                                <div class="flex items-center gap-2.5">
                                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                                    <h3 class="text-sm font-extrabold text-gray-900 flex items-center gap-2">
                                                        <?= htmlspecialchars($dept['name']) ?>
                                                        <span class="text-[10px] bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full font-bold">Departamento</span>
                                                    </h3>
                                                    <span class="text-[11px] text-gray-400 font-medium">
                                                        (<?= count($dept['districts']) ?> <?= count($dept['districts']) === 1 ? 'distrito' : 'distritos' ?>)
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-2">
                                                <button onclick="toggleStatus(<?= $dept['id'] ?>)" 
                                                        class="px-2.5 py-0.5 rounded-full text-[11px] font-bold transition-all <?= $dept['is_active'] ? 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200' : 'bg-gray-200 text-gray-500 hover:bg-gray-300' ?>">
                                                    <?= $dept['is_active'] ? 'Activo' : 'Inactivo' ?>
                                                </button>

                                                <button onclick="openModalFor('district', <?= $dept['id'] ?>)" 
                                                        class="inline-flex items-center gap-1 bg-purple-50 text-purple-700 hover:bg-purple-100 border border-purple-200 px-2.5 py-1 rounded-lg text-xs font-bold transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                    Añadir Distrito
                                                </button>

                                                <button type="button" 
                                                        data-id="<?= $dept['id'] ?>"
                                                        data-name="<?= htmlspecialchars($dept['name'], ENT_QUOTES) ?>"
                                                        data-parent="<?= $country['id'] ?>"
                                                        data-type="department"
                                                        data-active="<?= $dept['is_active'] ?>"
                                                        onclick="openEditLocation(this)" 
                                                        class="text-blue-600 hover:bg-blue-100 px-2.5 py-1 rounded-lg text-xs font-bold transition-colors">
                                                    Editar
                                                </button>

                                                <form action="<?= url('admin/lugares/delete') ?>" method="POST" class="inline-block" onsubmit="return confirm('¿Seguro que deseas eliminar este departamento? Se eliminarán sus distritos.');">
                                                    <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
                                                    <input type="hidden" name="id" value="<?= $dept['id'] ?>">
                                                    <button type="submit" class="text-red-500 hover:bg-red-50 px-2.5 py-1 rounded-lg text-xs font-bold transition-colors">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- LEVEL 3: Districts Container -->
                                        <div class="p-3 bg-white">
                                            <?php if (empty($dept['districts'])): ?>
                                                <div class="text-center text-gray-400 text-xs py-2">
                                                    Sin distritos registrados. 
                                                    <button onclick="openModalFor('district', <?= $dept['id'] ?>)" class="text-purple-600 font-bold hover:underline ml-1">
                                                        + Añadir distrito
                                                    </button>
                                                </div>
                                            <?php else: ?>
                                                <div id="sortable-districts-<?= $dept['id'] ?>" class="sortable-districts space-y-1.5">
                                                    <?php foreach ($dept['districts'] as $district): ?>
                                                        <div data-id="<?= $district['id'] ?>" class="district-row bg-gray-50/70 hover:bg-purple-50/40 rounded-lg border border-gray-200/80 p-2.5 flex items-center justify-between transition-all">
                                                            <div class="flex items-center gap-2.5">
                                                                <button title="Arrastrar para reordenar distritos" class="drag-handle-district cursor-move text-gray-300 hover:text-purple-600 transition-colors p-0.5">
                                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                                                </button>
                                                                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                                                <span class="text-xs font-bold text-gray-800"><?= htmlspecialchars($district['name']) ?></span>
                                                                <span class="text-[9px] bg-purple-50 text-purple-700 border border-purple-200 px-2 py-0.2 rounded-full font-semibold">Distrito</span>
                                                            </div>

                                                            <div class="flex items-center gap-2">
                                                                <button onclick="toggleStatus(<?= $district['id'] ?>)" 
                                                                        class="px-2 py-0.5 rounded-full text-[10px] font-bold transition-all <?= $district['is_active'] ? 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' : 'bg-gray-200 text-gray-400 hover:bg-gray-300' ?>">
                                                                    <?= $district['is_active'] ? 'Activo' : 'Inactivo' ?>
                                                                </button>

                                                                <button type="button" 
                                                                        data-id="<?= $district['id'] ?>"
                                                                        data-name="<?= htmlspecialchars($district['name'], ENT_QUOTES) ?>"
                                                                        data-parent="<?= $dept['id'] ?>"
                                                                        data-type="district"
                                                                        data-active="<?= $district['is_active'] ?>"
                                                                        onclick="openEditLocation(this)" 
                                                                        class="text-blue-600 hover:bg-blue-50 px-2 py-0.5 rounded text-[11px] font-bold transition-colors">
                                                                    Editar
                                                                </button>

                                                                <form action="<?= url('admin/lugares/delete') ?>" method="POST" class="inline-block" onsubmit="return confirm('¿Seguro que deseas eliminar este distrito?');">
                                                                    <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
                                                                    <input type="hidden" name="id" value="<?= $district['id'] ?>">
                                                                    <button type="submit" class="text-red-500 hover:bg-red-50 px-2 py-0.5 rounded text-[11px] font-bold transition-colors">
                                                                        Eliminar
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Form -->
<div id="location-modal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
    <div id="location-modal-container" onclick="event.stopPropagation()" class="bg-white rounded-2xl shadow-2xl border border-gray-200 w-full max-w-md overflow-hidden transform transition-all">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h4 id="modal-title" class="text-lg font-extrabold text-gray-800">Añadir Nuevo Lugar</h4>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <form id="location-form" action="<?= url('admin/lugares/save') ?>" method="POST" onsubmit="return validateForm()" class="p-6 space-y-4">
            <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
            <input type="hidden" name="id" id="form-id" value="">
            
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">Tipo de Lugar *</label>
                <select name="type" id="form-type" onchange="onTypeChange()" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-3 border bg-white text-sm font-semibold transition-all">
                    <option value="country">País (Nivel 1)</option>
                    <option value="department">Departamento / Ciudad (Nivel 2)</option>
                    <option value="district">Distrito (Nivel 3)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">Nombre del Lugar *</label>
                <input type="text" name="name" id="form-name" required class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-3 border text-sm transition-all" placeholder="Ej: Perú, Lima, Miraflores...">
            </div>
            
            <!-- Parent Country Selector (Shown for Department) -->
            <div id="wrapper-country-parent" class="hidden">
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">País Perteneciente *</label>
                <select name="parent_country" id="form-parent-country" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-3 border bg-white text-sm transition-all">
                    <option value="">-- Selecciona un País --</option>
                    <?php foreach ($countries as $c): ?>
                        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Parent Department Selector (Shown for District) -->
            <div id="wrapper-dept-parent" class="hidden">
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">Departamento Perteneciente *</label>
                <select name="parent_dept" id="form-parent-dept" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-secondary/20 focus:border-secondary p-3 border bg-white text-sm transition-all">
                    <option value="">-- Selecciona un Departamento --</option>
                    <?php foreach ($departments as $d): ?>
                        <option value="<?= $d['id'] ?>">
                            <?= htmlspecialchars($d['name']) ?> <?= !empty($d['country_name']) ? '(' . htmlspecialchars($d['country_name']) . ')' : '' ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Hidden generic parent_id sent to backend -->
            <input type="hidden" name="parent_id" id="form-parent-id" value="">

            <div class="flex items-center gap-3 pt-2">
                <input type="checkbox" name="is_active" id="form-active" value="1" checked class="w-5 h-5 text-secondary border-gray-300 rounded focus:ring-secondary">
                <label for="form-active" class="text-sm font-semibold text-gray-700 cursor-pointer">Lugar Activo</label>
            </div>

            <div class="flex gap-3 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeModal()" class="flex-1 px-4 py-3 bg-gray-100 text-gray-600 rounded-xl font-bold text-sm hover:bg-gray-200 transition-colors">
                    Cancelar
                </button>
                <button type="submit" id="form-btn" class="flex-1 bg-secondary text-white px-6 py-3 rounded-xl font-bold text-sm hover:bg-blue-600 transition-all shadow-lg shadow-blue-500/20">
                    Guardar Lugar
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
const modal = document.getElementById('location-modal');

function onTypeChange() {
    const type = document.getElementById('form-type').value;
    const countryWrapper = document.getElementById('wrapper-country-parent');
    const deptWrapper = document.getElementById('wrapper-dept-parent');

    countryWrapper.classList.add('hidden');
    deptWrapper.classList.add('hidden');

    if (type === 'department') {
        countryWrapper.classList.remove('hidden');
    } else if (type === 'district') {
        deptWrapper.classList.remove('hidden');
    }
}

function openModalFor(targetType = 'country', parentId = null) {
    resetForm();
    document.getElementById('form-type').value = targetType;
    onTypeChange();

    if (targetType === 'country') {
        document.getElementById('modal-title').innerText = 'Añadir Nuevo País';
        document.getElementById('form-btn').innerText = 'Guardar País';
    } else if (targetType === 'department') {
        document.getElementById('modal-title').innerText = 'Añadir Nuevo Departamento';
        document.getElementById('form-btn').innerText = 'Guardar Departamento';
        if (parentId) {
            document.getElementById('form-parent-country').value = parentId;
        }
    } else if (targetType === 'district') {
        document.getElementById('modal-title').innerText = 'Añadir Nuevo Distrito';
        document.getElementById('form-btn').innerText = 'Guardar Distrito';
        if (parentId) {
            document.getElementById('form-parent-dept').value = parentId;
        }
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
    resetForm();
}

function resetForm() {
    document.getElementById('form-id').value = '';
    document.getElementById('form-name').value = '';
    document.getElementById('form-type').value = 'country';
    document.getElementById('form-parent-country').value = '';
    document.getElementById('form-parent-dept').value = '';
    document.getElementById('form-parent-id').value = '';
    document.getElementById('form-active').checked = true;
    onTypeChange();
    
    document.getElementById('modal-title').innerText = 'Añadir Nuevo Lugar';
    document.getElementById('form-btn').innerText = 'Guardar Lugar';
}

function editLocation(id, name, parentId, type, isActive) {
    resetForm();
    document.getElementById('form-id').value = id;
    document.getElementById('form-name').value = name;
    document.getElementById('form-type').value = type || 'country';
    document.getElementById('form-active').checked = (parseInt(isActive) === 1);
    
    onTypeChange();

    if (type === 'department' && parentId) {
        document.getElementById('form-parent-country').value = parentId;
    } else if (type === 'district' && parentId) {
        document.getElementById('form-parent-dept').value = parentId;
    }

    document.getElementById('modal-title').innerText = 'Editar Lugar';
    document.getElementById('form-btn').innerText = 'Actualizar Lugar';
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function openEditLocation(btn) {
    const id = btn.getAttribute('data-id');
    const name = btn.getAttribute('data-name') || '';
    const parentId = btn.getAttribute('data-parent') || '';
    const type = btn.getAttribute('data-type') || 'country';
    const active = btn.getAttribute('data-active') || '1';
    editLocation(id, name, parentId, type, active);
}

function validateForm() {
    const nameVal = document.getElementById('form-name').value.trim();
    const typeVal = document.getElementById('form-type').value;

    if (!nameVal) {
        alert('Por favor, ingresa el nombre del lugar.');
        return false;
    }

    if (typeVal === 'department') {
        const countryId = document.getElementById('form-parent-country').value;
        if (!countryId) {
            alert('Por favor, selecciona el País al que pertenece el departamento.');
            return false;
        }
        document.getElementById('form-parent-id').value = countryId;
    } else if (typeVal === 'district') {
        const deptId = document.getElementById('form-parent-dept').value;
        if (!deptId) {
            alert('Por favor, selecciona el Departamento al que pertenece el distrito.');
            return false;
        }
        document.getElementById('form-parent-id').value = deptId;
    } else {
        document.getElementById('form-parent-id').value = '';
    }

    return true;
}

function toggleStatus(id) {
    fetch('<?= url('admin/lugares/toggle') ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: id })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('No se pudo cambiar el estado.');
        }
    })
    .catch(() => alert('Error en la comunicación con el servidor.'));
}

function sendReorderRequest(orderIds) {
    if (!orderIds || orderIds.length === 0) return;
    fetch('<?= url('admin/lugares/reorder') ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ order: orderIds })
    })
    .then(response => response.json())
    .then(data => {
        if(!data.success) alert('Hubo un error al actualizar el orden.');
    })
    .catch((error) => console.error('Error:', error));
}

document.addEventListener('DOMContentLoaded', function () {
    // 1. Reordering Countries
    var countriesEl = document.getElementById('sortable-countries');
    if (countriesEl) {
        Sortable.create(countriesEl, {
            handle: '.drag-handle-country',
            animation: 150,
            ghostClass: 'opacity-50',
            onEnd: function () {
                var cards = countriesEl.querySelectorAll('.country-card[data-id]');
                var orderIds = [];
                cards.forEach(function(card) {
                    var id = card.getAttribute('data-id');
                    if(id) orderIds.push(id);
                });
                sendReorderRequest(orderIds);
            }
        });
    }

    // 2. Reordering Departments per Country
    var deptLists = document.querySelectorAll('.sortable-departments');
    deptLists.forEach(function(deptList) {
        Sortable.create(deptList, {
            handle: '.drag-handle-department',
            animation: 150,
            ghostClass: 'bg-blue-50',
            onEnd: function () {
                var cards = deptList.querySelectorAll('.department-card[data-id]');
                var orderIds = [];
                cards.forEach(function(card) {
                    var id = card.getAttribute('data-id');
                    if(id) orderIds.push(id);
                });
                sendReorderRequest(orderIds);
            }
        });
    });

    // 3. Reordering Districts per Department
    var distLists = document.querySelectorAll('.sortable-districts');
    distLists.forEach(function(distList) {
        Sortable.create(distList, {
            handle: '.drag-handle-district',
            animation: 150,
            ghostClass: 'bg-purple-50',
            onEnd: function () {
                var rows = distList.querySelectorAll('.district-row[data-id]');
                var orderIds = [];
                rows.forEach(function(row) {
                    var id = row.getAttribute('data-id');
                    if(id) orderIds.push(id);
                });
                sendReorderRequest(orderIds);
            }
        });
    });

    // Modal backdrop click safety handling
    let isMouseDownOnModalBackdrop = false;
    modal.addEventListener('mousedown', function(e) {
        isMouseDownOnModalBackdrop = (e.target === modal);
    });
    modal.addEventListener('mouseup', function(e) {
        if (isMouseDownOnModalBackdrop && e.target === modal) {
            closeModal();
        }
        isMouseDownOnModalBackdrop = false;
    });
});
</script>
