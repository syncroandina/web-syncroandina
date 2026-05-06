<div class="mb-8 flex flex-col sm:flex-row justify-between items-center gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-gray-900">Proyectos</h1>
        <p class="text-gray-500 text-sm mt-1">Gestiona los casos de éxito, asigna imágenes y publicalos en el portal.</p>
    </div>
    <button class="bg-primary hover:bg-secondary text-white px-6 py-3 rounded-xl text-sm font-bold transition-colors flex items-center gap-2 shadow-lg shadow-primary/30">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Crear Proyecto
    </button>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
        <div class="relative w-full max-w-md">
            <input type="text" placeholder="Buscar proyecto por título o cliente..." class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-sm font-medium transition-shadow">
            <svg class="w-5 h-5 text-gray-400 absolute left-4 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        <!-- Filtros adicionales podrían ir aquí -->
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white text-gray-400 text-[11px] font-bold uppercase tracking-widest border-b border-gray-100">
                    <th class="px-8 py-5">Proyecto</th>
                    <th class="px-8 py-5">Cliente</th>
                    <th class="px-8 py-5">Estado</th>
                    <th class="px-8 py-5">Fecha</th>
                    <th class="px-8 py-5 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-sm">
                <?php if(!empty($projects)): ?>
                    <?php foreach($projects as $project): ?>
                    <tr class="hover:bg-blue-50/30 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-gray-200 overflow-hidden shadow-sm">
                                    <?php if(!empty($project['main_image'])): ?>
                                        <img src="<?= asset($project['main_image']) ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <span class="block font-extrabold text-gray-900 group-hover:text-secondary transition-colors"><?= htmlspecialchars($project['title']) ?></span>
                                    <span class="block text-xs text-gray-400 mt-0.5">Slug: <?= htmlspecialchars($project['slug']) ?></span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5 font-medium text-gray-600"><?= htmlspecialchars($project['client'] ?? 'N/A') ?></td>
                        <td class="px-8 py-5">
                            <?php if($project['is_active']): ?>
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold border border-green-200">Publicado</span>
                            <?php else: ?>
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-xs font-bold border border-yellow-200">Borrador</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-8 py-5 font-medium text-gray-500">
                            <?= $project['completion_date'] ? date('d M, Y', strtotime($project['completion_date'])) : 'Pendiente' ?>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex justify-end gap-2">
                                <button class="w-8 h-8 rounded-lg bg-gray-100 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-colors shadow-sm" title="Editar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <form action="<?= url('admin/proyectos/delete') ?>" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este proyecto? Se borrará permanentemente la imagen asociada.');" class="inline-block">
                                    <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
                                    <input type="hidden" name="id" value="<?= $project['id'] ?>">
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-gray-100 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center transition-colors shadow-sm" title="Eliminar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="px-8 py-10 text-center text-gray-400 italic">No se encontraron proyectos activos.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <div class="px-8 py-5 border-t border-gray-100 flex justify-between items-center text-sm text-gray-500 font-medium">
        <span>Mostrando 1 a 2 de 12 proyectos</span>
        <div class="flex gap-2">
            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded-lg hover:bg-gray-50 disabled:opacity-50 transition-colors text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button class="w-8 h-8 flex items-center justify-center border border-secondary bg-secondary text-white rounded-lg font-bold shadow-sm">1</button>
            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded-lg hover:bg-gray-50 text-gray-700 font-bold transition-colors">2</button>
            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors text-gray-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>
        </div>
    </div>
</div>
