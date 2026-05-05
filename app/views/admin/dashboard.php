<div class="mb-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Dashboard General</h1>
        <p class="text-gray-500 text-sm mt-1">Resumen en tiempo real de tu plataforma corporativa.</p>
    </div>
    <div class="text-sm text-gray-500 font-medium">
        Última actualización: <span class="text-gray-900"><?= date('d M Y, H:i') ?></span>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <!-- Stat 1 -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out z-0"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-400 mb-1">Visitas del Mes</p>
                <h3 class="text-4xl font-black text-gray-900">12,450</h3>
                <p class="text-xs font-bold text-green-500 mt-2 flex items-center gap-1 bg-green-50 w-max px-2 py-1 rounded-md">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    +14.5%
                </p>
            </div>
            <div class="w-14 h-14 bg-white shadow-sm border border-gray-50 text-secondary rounded-2xl flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Stat 2 -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-green-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out z-0"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-400 mb-1">Contactos (Leads)</p>
                <h3 class="text-4xl font-black text-gray-900">48</h3>
                <p class="text-xs font-bold text-green-500 mt-2 flex items-center gap-1 bg-green-50 w-max px-2 py-1 rounded-md">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    +5.2%
                </p>
            </div>
            <div class="w-14 h-14 bg-white shadow-sm border border-gray-50 text-green-500 rounded-2xl flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Stat 3 -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-purple-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out z-0"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-400 mb-1">Proyectos Activos</p>
                <h3 class="text-4xl font-black text-gray-900">12</h3>
                <p class="text-xs font-bold text-gray-500 mt-2 bg-gray-100 w-max px-2 py-1 rounded-md">Portafolio</p>
            </div>
            <div class="w-14 h-14 bg-white shadow-sm border border-gray-50 text-purple-500 rounded-2xl flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Stat 4 -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-orange-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out z-0"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-400 mb-1">Artículos Blog</p>
                <h3 class="text-4xl font-black text-gray-900">34</h3>
                <p class="text-xs font-bold text-gray-500 mt-2 bg-gray-100 w-max px-2 py-1 rounded-md">Publicados</p>
            </div>
            <div class="w-14 h-14 bg-white shadow-sm border border-gray-50 text-orange-500 rounded-2xl flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path></svg>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity & Quick Actions -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Messages -->
    <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="text-lg font-bold text-gray-900">Últimos Mensajes Recibidos</h3>
            <a href="#" class="text-sm font-bold text-secondary hover:text-blue-800 transition-colors">Ver todos</a>
        </div>
        <div class="p-0">
            <div class="divide-y divide-gray-100">
                <!-- Message row -->
                <div class="p-8 hover:bg-blue-50/50 transition-colors flex items-start gap-5">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-100 to-blue-200 text-secondary flex items-center justify-center font-bold text-lg flex-shrink-0 shadow-inner">
                        JD
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <h4 class="text-sm font-bold text-gray-900">John Doe <span class="bg-secondary text-white text-[10px] px-2 py-0.5 rounded ml-2 uppercase font-bold">Nuevo</span></h4>
                            <span class="text-xs font-semibold text-gray-400">Hace 2 horas</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-2 leading-relaxed">Interesado en consultoría de transformación digital para mi empresa de logística. Tenemos operaciones en 3 países y necesitamos centralizar los datos...</p>
                        <div class="mt-4 flex gap-3">
                            <button class="text-xs font-bold text-white hover:bg-blue-700 bg-secondary px-4 py-2 rounded-lg transition-colors">Responder</button>
                            <button class="text-xs font-bold text-gray-600 hover:bg-gray-200 bg-gray-100 px-4 py-2 rounded-lg transition-colors">Marcar Leído</button>
                        </div>
                    </div>
                </div>
                <!-- Message 2 -->
                <div class="p-8 hover:bg-blue-50/50 transition-colors flex items-start gap-5 opacity-70">
                    <div class="w-12 h-12 rounded-2xl bg-gray-100 text-gray-500 flex items-center justify-center font-bold text-lg flex-shrink-0">
                        MR
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <h4 class="text-sm font-bold text-gray-900">María Rodríguez</h4>
                            <span class="text-xs font-semibold text-gray-400">Ayer</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-2 leading-relaxed">Solicitud de información sobre desarrollo de aplicación móvil nativa.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
        <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-lg font-bold text-gray-900">Acciones Rápidas</h3>
        </div>
        <div class="p-8 space-y-4 flex-1">
            <a href="/admin/projects/create" class="flex items-center justify-between w-full p-4 rounded-2xl border border-gray-100 hover:border-secondary hover:bg-blue-50 transition-all group shadow-sm hover:shadow">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 text-secondary rounded-xl flex items-center justify-center group-hover:bg-secondary group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <span class="font-bold text-sm text-gray-800 group-hover:text-secondary transition-colors">Nuevo Proyecto</span>
                </div>
            </a>
            <a href="/admin/blog/create" class="flex items-center justify-between w-full p-4 rounded-2xl border border-gray-100 hover:border-secondary hover:bg-blue-50 transition-all group shadow-sm hover:shadow">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-orange-100 text-orange-500 rounded-xl flex items-center justify-center group-hover:bg-orange-500 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <span class="font-bold text-sm text-gray-800 group-hover:text-orange-500 transition-colors">Escribir Artículo</span>
                </div>
            </a>
            <a href="/admin/settings" class="flex items-center justify-between w-full p-4 rounded-2xl border border-gray-100 hover:border-secondary hover:bg-blue-50 transition-all group shadow-sm hover:shadow">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gray-100 text-gray-600 rounded-xl flex items-center justify-center group-hover:bg-gray-800 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                    </div>
                    <span class="font-bold text-sm text-gray-800 group-hover:text-gray-900 transition-colors">Ajustes Globales</span>
                </div>
            </a>
        </div>
    </div>
</div>
