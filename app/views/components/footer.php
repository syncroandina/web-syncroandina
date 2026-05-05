    <footer class="bg-primary text-gray-300 py-12 mt-20 border-t border-gray-800">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div class="col-span-1 md:col-span-2">
                    <h2 class="text-2xl font-bold text-white mb-4">Syncro Andina</h2>
                    <p class="max-w-md text-gray-400">Transformando negocios con soluciones tecnológicas innovadoras. Llevamos tu corporación al siguiente nivel de eficiencia y seguridad.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Enlaces Rápidos</h3>
                    <ul class="space-y-2">
                        <li><a href="/" class="hover:text-secondary transition-colors">Inicio</a></li>
                        <li><a href="/about" class="hover:text-secondary transition-colors">La Empresa</a></li>
                        <li><a href="/services" class="hover:text-secondary transition-colors">Servicios</a></li>
                        <li><a href="/contact" class="hover:text-secondary transition-colors">Contacto</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Contacto</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li>contacto@syncroandina.com</li>
                        <li>+57 300 123 4567</li>
                        <li>Bogotá, Colombia</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">
                <p>&copy; <?= date('Y') ?> Syncro Andina. Todos los derechos reservados.</p>
                <a href="/login" class="mt-4 md:mt-0 text-gray-700 hover:text-gray-400 transition-colors opacity-50 hover:opacity-100 flex items-center gap-1" title="Acceso Interno">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    <span>Webmaster</span>
                </a>
            </div>
        </div>
    </footer>
    <script>
        // Forzar scroll al inicio al cargar o actualizar la página
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }
        window.scrollTo(0, 0);
    </script>
</body>
</html>
