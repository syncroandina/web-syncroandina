<?php $this->component('header', ['title' => $title ?? 'Login']); ?>
<?php $this->component('navbar'); ?>

<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Decoración de fondo premium -->
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1557683316-973673baf926?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80')] bg-cover bg-center opacity-5"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-gray-100"></div>
    </div>

    <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10 animate-fade-in-up">
        <div class="flex justify-center mb-6">
            <a href="/" class="text-3xl font-black tracking-tight text-primary flex items-center gap-2 hover:scale-105 transition-transform">
                <div class="w-12 h-12 bg-secondary rounded-xl flex items-center justify-center shadow-lg shadow-secondary/30">
                    <span class="text-white text-3xl font-bold">S</span>
                </div>
                Syncro Andina
            </a>
        </div>
        <h2 class="mt-8 text-center text-3xl font-extrabold text-gray-900">
            Portal de Acceso
        </h2>
        <p class="mt-3 text-center text-sm text-gray-600">
            Ingresa a tu entorno corporativo o panel de administración
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md relative z-10 animate-fade-in-up" style="animation-delay: 100ms;">
        <div class="bg-white/80 backdrop-blur-xl py-10 px-4 shadow-2xl sm:rounded-3xl sm:px-10 border border-white">
            <form class="space-y-6" action="/login" method="POST">
                <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">
                
                <?php if(isset($_GET['error'])): ?>
                    <div class="bg-red-50 text-red-500 p-3 rounded-xl text-sm font-semibold border border-red-100">
                        Credenciales incorrectas. Intenta nuevamente (admin@syncroandina.com / admin123).
                    </div>
                <?php endif; ?>
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700">
                        Correo Corporativo
                    </label>
                    <div class="mt-2 relative rounded-xl shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                        </div>
                        <input id="email" name="email" type="email" autocomplete="email" required class="focus:ring-2 focus:ring-secondary focus:border-transparent block w-full pl-11 sm:text-sm border border-gray-200 rounded-xl py-3.5 bg-gray-50 hover:bg-white transition-colors" placeholder="admin@syncroandina.com">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700">
                        Contraseña de Seguridad
                    </label>
                    <div class="mt-2 relative rounded-xl shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <input id="password" name="password" type="password" autocomplete="current-password" required class="focus:ring-2 focus:ring-secondary focus:border-transparent block w-full pl-11 sm:text-sm border border-gray-200 rounded-xl py-3.5 bg-gray-50 hover:bg-white transition-colors" placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-secondary focus:ring-secondary border-gray-300 rounded">
                        <label for="remember-me" class="ml-2 block text-sm text-gray-700 font-medium">
                            Recordar mis datos
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-bold text-secondary hover:text-primary transition-colors">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-lg shadow-primary/20 text-sm font-extrabold text-white bg-primary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary transition-colors duration-300">
                        Ingresar de Forma Segura
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->component('footer'); ?>
