<div class="space-y-6" x-data="leadsManager()">
    <!-- Encabezado de la Sección -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-3xl font-black text-gray-800 tracking-tight">Gestión de Leads (Contactos)</h2>
            <p class="text-sm text-gray-500 mt-1">Monitorea, filtra y gestiona las solicitudes de contacto y consultas comerciales entrantes.</p>
        </div>
        
        <!-- Indicadores Rápidos y Acciones -->
        <div class="flex flex-wrap items-center gap-3">
            <div class="bg-red-50 border border-red-100 rounded-2xl px-4 py-2.5 flex items-center gap-3 shadow-sm">
                <span class="w-3 h-3 rounded-full bg-red-500 animate-pulse"></span>
                <div>
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">No Leídos</p>
                    <p class="text-lg font-black text-red-600 leading-none mt-0.5" x-text="unreadCount"></p>
                </div>
            </div>
            <div class="bg-green-50 border border-green-100 rounded-2xl px-4 py-2.5 flex items-center gap-3 shadow-sm">
                <span class="w-3 h-3 rounded-full bg-green-500"></span>
                <div>
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Atendidos</p>
                    <p class="text-lg font-black text-green-600 leading-none mt-0.5" x-text="readCount"></p>
                </div>
            </div>
            
            <a href="/admin/contactos/exportar" class="px-5 py-3.5 bg-green-600 hover:bg-green-700 text-white text-xs font-extrabold rounded-2xl transition-all shadow-lg shadow-green-600/20 flex items-center gap-2 hover:-translate-y-0.5 group">
                <svg class="w-4 h-4 text-green-100 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Exportar Excel
            </a>
        </div>
    </div>

    <!-- Alertas -->
    <?php if(isset($_GET['success'])): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-2xl relative mb-6">
            <strong class="font-bold">¡Éxito!</strong>
            <span class="block sm:inline">
                <?= $_GET['success'] === 'lead_deleted' ? 'El lead ha sido eliminado correctamente.' : 'Operación completada con éxito.' ?>
            </span>
        </div>
    <?php endif; ?>

    <!-- Controles, Búsqueda y Tabs -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-col lg:flex-row justify-between items-stretch lg:items-center gap-4">
            <!-- Tabs de Filtrado -->
            <div class="flex p-1.5 bg-gray-50 rounded-2xl border border-gray-100 self-start">
                <button @click="activeTab = 'todos'" 
                    class="px-5 py-2.5 rounded-xl text-xs font-bold transition-all duration-300 flex items-center gap-2"
                    :class="activeTab === 'todos' ? 'bg-white text-gray-900 shadow-md shadow-gray-200/50' : 'text-gray-500 hover:text-gray-900'">
                    Todos
                    <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded-lg font-black" x-text="leads.length"></span>
                </button>
                <button @click="activeTab = 'unread'" 
                    class="px-5 py-2.5 rounded-xl text-xs font-bold transition-all duration-300 flex items-center gap-2"
                    :class="activeTab === 'unread' ? 'bg-red-500 text-white shadow-md shadow-red-200' : 'text-gray-500 hover:text-red-500'">
                    No Leídos
                    <span class="px-2 py-0.5 rounded-lg font-black" :class="activeTab === 'unread' ? 'bg-red-600 text-white' : 'bg-red-50 text-red-500'" x-text="unreadCount"></span>
                </button>
                <button @click="activeTab = 'read'" 
                    class="px-5 py-2.5 rounded-xl text-xs font-bold transition-all duration-300 flex items-center gap-2"
                    :class="activeTab === 'read' ? 'bg-green-500 text-white shadow-md shadow-green-200' : 'text-gray-500 hover:text-green-500'">
                    Leídos
                    <span class="px-2 py-0.5 rounded-lg font-black" :class="activeTab === 'read' ? 'bg-green-600 text-white' : 'bg-green-50 text-green-500'" x-text="readCount"></span>
                </button>
            </div>

            <!-- Buscador Dinámico -->
            <div class="relative max-w-md w-full">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" x-model="searchQuery" placeholder="Buscar por nombre, correo, RUC o asunto..." class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-100 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary focus:bg-white transition-all">
            </div>
        </div>

        <!-- Tabla de Leads -->
        <div class="mt-6 overflow-hidden border border-gray-100 rounded-2xl">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Lead</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tipo / RUC</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Asunto / Servicio</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Estado</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100" x-show="filteredLeads.length > 0">
                        <template x-for="lead in filteredLeads" :key="lead.id">
                            <tr class="hover:bg-gray-50/50 transition-colors" :class="lead.is_read == 0 ? 'bg-blue-50/10 font-medium' : ''">
                                <!-- Columna de Nombre e Info básica -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-xs"
                                            :class="lead.is_read == 0 ? 'bg-red-50 text-red-600 border border-red-100' : 'bg-gray-100 text-gray-600 border border-gray-200'">
                                            <span x-text="lead.name.split(' ').map(n => n[0]).join('').slice(0,2).toUpperCase()"></span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900" x-text="lead.name"></p>
                                            <p class="text-xs text-gray-500" x-text="lead.email"></p>
                                            <p class="text-[10px] text-gray-400 mt-0.5" x-text="lead.phone"></p>
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- Tipo de Persona / RUC -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold"
                                        :class="lead.client_type === 'empresa' ? 'bg-blue-50 text-secondary' : 'bg-purple-50 text-purple-600'">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                :d="lead.client_type === 'empresa' ? 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4' : 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'"></path>
                                        </svg>
                                        <span x-text="lead.client_type === 'empresa' ? 'Empresa' : 'Persona'"></span>
                                    </span>
                                    <p class="text-xs text-gray-400 mt-1 pl-1" x-text="lead.ruc ? 'RUC: ' + lead.ruc : 'N/A'"></p>
                                </td>

                                <!-- Servicio/Asunto -->
                                <td class="px-6 py-4">
                                    <div class="max-w-xs overflow-hidden text-ellipsis">
                                        <p class="text-sm font-bold text-gray-800 line-clamp-1" x-text="lead.subject || 'Sin Asunto'"></p>
                                        <span class="inline-block mt-1 text-[10px] font-extrabold uppercase tracking-wider px-2 py-0.5 rounded-lg"
                                            :class="lead.service_title ? 'bg-secondary/10 text-secondary' : 'bg-gray-100 text-gray-500'"
                                            x-text="lead.service_title || 'Pregunta libre'">
                                        </span>
                                    </div>
                                </td>

                                <!-- Fecha -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span x-text="new Date(lead.created_at).toLocaleDateString('es-ES', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' })"></span>
                                </td>

                                <!-- Estado -->
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <button @click="toggleReadStatus(lead)" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all duration-300 hover:scale-105"
                                        :class="lead.is_read == 1 ? 'bg-green-50 text-green-700 hover:bg-green-100' : 'bg-red-50 text-red-700 hover:bg-red-100'">
                                        <span class="w-1.5 h-1.5 rounded-full" :class="lead.is_read == 1 ? 'bg-green-500' : 'bg-red-500 animate-pulse'"></span>
                                        <span x-text="lead.is_read == 1 ? 'Atendido' : 'No Leído'"></span>
                                    </button>
                                </td>

                                <!-- Acciones -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <div class="flex justify-end gap-2">
                                        <button @click="selectedLead = lead; if(lead.is_read == 0) toggleReadStatus(lead)" class="p-2 bg-blue-50 hover:bg-blue-100 text-secondary rounded-xl transition-all hover:scale-105" title="Ver Detalles">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>
                                        <form action="/admin/contactos/delete" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este lead permanentemente? Esta acción es irreversible.');" class="inline">
                                            <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
                                            <input type="hidden" name="id" :value="lead.id">
                                            <button type="submit" class="p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl transition-all hover:scale-105" title="Eliminar Permanentemente">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Empty State -->
            <div class="text-center py-16" x-show="filteredLeads.length === 0">
                <div class="w-16 h-16 bg-gray-50 border border-gray-100 rounded-2xl flex items-center justify-center text-gray-400 mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0V9a2 2 0 00-2-2H6a2 2 0 00-2 2v4h14z"></path></svg>
                </div>
                <h4 class="text-base font-bold text-gray-800">No se encontraron leads</h4>
                <p class="text-xs text-gray-400 max-w-xs mx-auto mt-1">No hay solicitudes que coincidan con la búsqueda o la pestaña seleccionada.</p>
            </div>
        </div>
    </div>

    <!-- Modal Detalle del Lead (Inmersivo y Elegante) -->
    <div class="fixed inset-0 bg-gray-950/60 backdrop-blur-md z-[99999] flex items-center justify-center p-4 transition-all duration-300"
        x-show="selectedLead"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        style="display: none;">
        
        <div class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 w-full max-w-2xl overflow-hidden transform transition-all duration-300 relative flex flex-col max-h-[90vh]"
            @click.away="selectedLead = null"
            x-show="selectedLead"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="scale-95 opacity-0"
            x-transition:enter-end="scale-100 opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="scale-100 opacity-100"
            x-transition:leave-end="scale-95 opacity-0">
            
            <!-- Decoraciones de fondo -->
            <div class="absolute -top-16 -right-16 w-36 h-36 bg-secondary/10 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute -bottom-16 -left-16 w-36 h-36 bg-primary/5 rounded-full blur-2xl pointer-events-none"></div>

            <!-- Botón Cerrar -->
            <button @click="selectedLead = null" class="absolute top-6 right-6 text-gray-400 hover:text-gray-600 transition-colors p-2 hover:bg-gray-50 rounded-xl z-20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <!-- Contenedor con Scroll de Precisión -->
            <div class="pt-8 pb-8 pl-8 pr-5 md:pt-10 md:pb-10 md:pl-10 md:pr-7 flex-1 relative z-10 flex flex-col overflow-y-auto modal-scrollbar">
                <!-- Encabezado de Modal -->
                <div class="border-b border-gray-100 pb-5 mb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-secondary flex items-center justify-center font-black text-sm">
                            <span x-text="selectedLead ? selectedLead.name.split(' ').map(n => n[0]).join('').slice(0,2).toUpperCase() : ''"></span>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-gray-900 leading-tight" x-text="selectedLead?.name"></h3>
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-[10px] font-extrabold uppercase mt-1"
                                :class="selectedLead?.is_read == 1 ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700'">
                                <span class="w-1 h-1 rounded-full" :class="selectedLead?.is_read == 1 ? 'bg-green-500' : 'bg-red-500 animate-pulse'"></span>
                                <span x-text="selectedLead?.is_read == 1 ? 'Lead Atendido' : 'No Leído'"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Detalles e Información de Ficha Técnica -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50/50 rounded-3xl p-6 border border-gray-100">
                    <div class="space-y-1">
                        <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Correo Electrónico</span>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-gray-800" x-text="selectedLead?.email"></span>
                            <button @click="navigator.clipboard.writeText(selectedLead.email); alert('Correo copiado!')" class="p-1 hover:bg-gray-200 rounded text-gray-400 hover:text-gray-600 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m-5 5h5m-5 4h5"></path></svg>
                            </button>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Teléfono / WhatsApp</span>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-gray-800" x-text="selectedLead?.phone || 'No registrado'"></span>
                            <template x-if="selectedLead?.phone">
                                <a :href="'https://wa.me/' + selectedLead.phone.replace(/[^0-9]/g, '')" target="_blank" class="p-1 bg-green-50 hover:bg-green-100 rounded text-green-500 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.513 2.262 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.37 9.864-9.799.002-2.63-1.023-5.101-2.885-6.965C16.588 2.008 14.1 1.01 11.502 1.01 6.066 1.01 1.641 5.377 1.637 10.806c-.001 1.693.447 3.344 1.3 4.793l-.997 3.646 3.707-.991z"/></svg>
                                </a>
                            </template>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Tipo de Cliente / Persona</span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold mt-0.5"
                            :class="selectedLead?.client_type === 'empresa' ? 'bg-blue-50 text-secondary' : 'bg-purple-50 text-purple-600'">
                            <span x-text="selectedLead?.client_type === 'empresa' ? 'Empresa Jurídica' : 'Persona Natural'"></span>
                        </span>
                    </div>

                    <div class="space-y-1">
                        <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Número de RUC</span>
                        <span class="text-sm font-bold text-gray-800" x-text="selectedLead?.ruc || 'N/A'"></span>
                    </div>

                    <div class="space-y-1">
                        <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Servicio de Interés</span>
                        <span class="inline-block mt-0.5 text-xs font-extrabold uppercase tracking-wider px-2.5 py-1 rounded-xl bg-secondary/10 text-secondary"
                            x-text="selectedLead?.service_title || 'Pregunta libre / Consulta general'">
                        </span>
                    </div>

                    <div class="space-y-1">
                        <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Fecha de Ingreso</span>
                        <span class="text-sm font-bold text-gray-800" x-text="selectedLead ? new Date(selectedLead.created_at).toLocaleDateString('es-ES', { day: '2-digit', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : ''"></span>
                    </div>
                </div>

                <!-- Mensaje y Consulta -->
                <div class="mt-6 space-y-2">
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Asunto de la Consulta</span>
                    <h4 class="text-lg font-bold text-gray-800 bg-gray-50/20 px-4 py-2.5 border border-gray-100 rounded-2xl" x-text="selectedLead?.subject || 'Sin Asunto'"></h4>
                </div>

                <div class="mt-6 space-y-2 flex-1 flex flex-col">
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Mensaje Enviado</span>
                    <div class="bg-gray-50 border border-gray-100 rounded-3xl p-6 text-sm text-gray-700 leading-relaxed whitespace-pre-wrap flex-1"
                        x-text="selectedLead?.message || 'Sin mensaje adicional.'">
                    </div>
                </div>

                <!-- Botones Inferiores de Acción -->
                <div class="mt-8 flex justify-end gap-3 border-t border-gray-100 pt-5">
                    <button @click="toggleReadStatus(selectedLead)" class="px-5 py-3 rounded-2xl text-xs font-bold border transition-all flex items-center gap-2 hover:scale-[1.02]"
                        :class="selectedLead?.is_read == 1 ? 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50' : 'bg-green-500 text-white border-transparent hover:bg-green-600 shadow-md shadow-green-100'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span x-text="selectedLead?.is_read == 1 ? 'Marcar como No Atendido' : 'Marcar como Atendido'"></span>
                    </button>
                    <button @click="selectedLead = null" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-2xl text-xs font-bold transition-all hover:scale-[1.02]">
                        Cerrar Detalle
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function leadsManager() {
    return {
        activeTab: 'todos', 
        searchQuery: '', 
        selectedLead: null,
        leads: <?= json_encode($leads) ?>,
        get filteredLeads() {
            return this.leads.filter(lead => {
                const matchesTab = this.activeTab === 'todos' || 
                    (this.activeTab === 'unread' && lead.is_read == 0) || 
                    (this.activeTab === 'read' && lead.is_read == 1);
                    
                const matchesSearch = !this.searchQuery || 
                    lead.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    lead.email.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    (lead.phone && lead.phone.includes(this.searchQuery)) ||
                    (lead.ruc && lead.ruc.includes(this.searchQuery)) ||
                    (lead.subject && lead.subject.toLowerCase().includes(this.searchQuery.toLowerCase()));
                    
                return matchesTab && matchesSearch;
            });
        },
        get unreadCount() {
            return this.leads.filter(l => l.is_read == 0).length;
        },
        get readCount() {
            return this.leads.filter(l => l.is_read == 1).length;
        },
        toggleReadStatus(lead) {
            const formData = new FormData();
            formData.append('id', lead.id);
            formData.append('csrf_token', '<?= \Core\Security::generateCSRFToken() ?>');

            fetch('/admin/contactos/toggle-read', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    lead.is_read = data.is_read;
                    if (this.selectedLead && this.selectedLead.id === lead.id) {
                        this.selectedLead.is_read = data.is_read;
                    }
                }
            });
        }
    };
}
</script>
