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
                <!-- Data de ejemplo simulando AJAX render -->
                <tr class="hover:bg-blue-50/30 transition-colors group">
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gray-200 overflow-hidden shadow-sm">
                                <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <span class="block font-extrabold text-gray-900 group-hover:text-secondary transition-colors">Plataforma Bancaria NextGen</span>
                                <span class="block text-xs text-gray-500 mt-0.5">Slug: plataforma-bancaria</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5 font-medium text-gray-600">Banco Nacional</td>
                    <td class="px-8 py-5">
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold border border-green-200">Publicado</span>
                    </td>
                    <td class="px-8 py-5 font-medium text-gray-500">10 Abr, 2026</td>
                    <td class="px-8 py-5 text-right">
                        <div class="flex justify-end gap-2">
                            <button class="w-8 h-8 rounded-lg bg-gray-100 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-colors shadow-sm" title="Editar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                            <button class="w-8 h-8 rounded-lg bg-gray-100 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center transition-colors shadow-sm" title="Eliminar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>

                <tr class="hover:bg-blue-50/30 transition-colors group">
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gray-200 overflow-hidden shadow-sm">
                                <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <span class="block font-extrabold text-gray-900 group-hover:text-secondary transition-colors">Dashboard Logístico AI</span>
                                <span class="block text-xs text-gray-500 mt-0.5">Slug: dashboard-logistico</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5 font-medium text-gray-600">Global Transport</td>
                    <td class="px-8 py-5">
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-xs font-bold border border-yellow-200">Borrador</span>
                    </td>
                    <td class="px-8 py-5 font-medium text-gray-500">22 Mar, 2026</td>
                    <td class="px-8 py-5 text-right">
                        <div class="flex justify-end gap-2">
                            <button class="w-8 h-8 rounded-lg bg-gray-100 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-colors shadow-sm" title="Editar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                            <button class="w-8 h-8 rounded-lg bg-gray-100 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center transition-colors shadow-sm" title="Eliminar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>
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
