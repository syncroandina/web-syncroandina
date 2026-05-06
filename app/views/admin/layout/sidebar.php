        <!-- Sidebar -->
        <aside class="flex-shrink-0 w-64 bg-primary text-white transition-all duration-300 shadow-2xl relative z-20" :class="{'w-64': sidebarOpen, 'w-20': !sidebarOpen, 'hidden md:block': !sidebarOpen}">
            <div class="h-16 flex items-center justify-center border-b border-white/10 bg-black/20">
                <span class="text-2xl font-black tracking-tight" x-show="sidebarOpen">SYNCRO</span>
                <span class="text-2xl font-black tracking-tight text-secondary" x-show="!sidebarOpen">S</span>
            </div>
            
            <nav class="p-4 space-y-1 overflow-y-auto h-[calc(100vh-4rem)] custom-scrollbar">
                <a href="/admin/escritorio" class="flex items-center gap-3 px-3 py-3 bg-secondary rounded-xl text-white mb-4 shadow-lg shadow-secondary/20 transition-all hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span x-show="sidebarOpen" class="font-bold text-sm">Dashboard</span>
                </a>
                
                <div class="text-[10px] uppercase text-gray-400 font-bold mt-6 mb-2 pl-3 tracking-wider" x-show="sidebarOpen">Gestión de Contenido</div>
                <a href="/admin/sliders" class="flex items-center gap-3 px-3 py-2.5 text-gray-300 hover:bg-white/10 hover:text-white rounded-xl transition-colors">
                    <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Sliders</span>
                </a>
                <a href="/admin/cta" class="flex items-center gap-3 px-3 py-2.5 text-gray-300 hover:bg-white/10 hover:text-white rounded-xl transition-colors">
                    <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
                    <span x-show="sidebarOpen" class="text-sm font-medium">CTA</span>
                </a>
                <a href="/admin/nosotros" class="flex items-center gap-3 px-3 py-2.5 text-gray-300 hover:bg-white/10 hover:text-white rounded-xl transition-colors">
                    <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Nosotros</span>
                </a>
                <a href="/admin/servicios" class="flex items-center gap-3 px-3 py-2.5 text-gray-300 hover:bg-white/10 hover:text-white rounded-xl transition-colors">
                    <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Servicios</span>
                </a>
                <a href="/admin/proyectos" class="flex items-center gap-3 px-3 py-2.5 text-gray-300 hover:bg-white/10 hover:text-white rounded-xl transition-colors">
                    <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Proyectos</span>
                </a>
                <a href="/admin/galeria" class="flex items-center gap-3 px-3 py-2.5 text-gray-300 hover:bg-white/10 hover:text-white rounded-xl transition-colors">
                    <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Galería</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-gray-300 hover:bg-white/10 hover:text-white rounded-xl transition-colors">
                    <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path></svg>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Blog</span>
                </a>
                <a href="/admin/contacto" class="flex items-center gap-3 px-3 py-2.5 text-gray-300 hover:bg-white/10 hover:text-white rounded-xl transition-colors">
                    <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Contacto</span>
                </a>

                <div class="text-[10px] uppercase text-gray-400 font-bold mt-8 mb-2 pl-3 tracking-wider" x-show="sidebarOpen">CRM & Comercial</div>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-gray-300 hover:bg-white/10 hover:text-white rounded-xl transition-colors">
                    <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Contactos (Leads)</span>
                </a>
                
                <div class="text-[10px] uppercase text-gray-400 font-bold mt-8 mb-2 pl-3 tracking-wider" x-show="sidebarOpen">Configuración Sistema</div>
                <a href="/admin/identidad" class="flex items-center gap-3 px-3 py-2.5 text-gray-300 hover:bg-white/10 hover:text-white rounded-xl transition-colors">
                    <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a2 2 0 01-2-2m0 0V5a2 2 0 012-2h10a2 2 0 012 2v14a2 2 0 01-2 2M5 20h14a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v13a2 2 0 002 2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m-6 4h6m-6 4h6"></path></svg>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Identidad</span>
                </a>
                 <a href="/admin/cabecera" class="flex items-center gap-3 px-3 py-2.5 text-gray-300 hover:bg-white/10 hover:text-white rounded-xl transition-colors">
                    <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Menú Principal</span>
                </a>
                <a href="/admin/pie-pagina" class="flex items-center gap-3 px-3 py-2.5 text-gray-300 hover:bg-white/10 hover:text-white rounded-xl transition-colors">
                    <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Pie de Página</span>
                </a>
            </nav>
        </aside>
