<?php $this->component('header', [
    'title' => $title ?? 'Contacto',
    'description' => $description ?? null,
    'keywords' => $keywords ?? null
]); ?>
<?php $this->component('navbar'); ?>

<style>
  body {
    background-color: #f9fafb !important;
  }
  footer {
    margin-top: 0 !important;
  }
</style>

<main class="min-h-[80vh] bg-gray-50 relative overflow-hidden">
    <!-- Elementos decorativos (Glassmorphism blobs) -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10 opacity-40">
        <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full bg-blue-100 blur-3xl"></div>
        <div class="absolute top-40 -left-40 w-96 h-96 rounded-full bg-cyan-100 blur-3xl"></div>
    </div>

    <div class="container mx-auto px-4 py-20">
        <div class="max-w-6xl mx-auto bg-white/70 backdrop-blur-2xl rounded-3xl shadow-2xl border border-white/50 overflow-hidden flex flex-col md:flex-row animate-fade-in-up">
            
            <!-- Información de Contacto -->
            <div class="md:w-2/5 bg-primary p-12 lg:p-16 text-white flex flex-col justify-between relative overflow-hidden">
                <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-secondary/30 rounded-full blur-3xl"></div>
                <div class="relative z-10">
                    <h2 class="text-4xl font-extrabold mb-6">
                        <?= htmlspecialchars($settings['contact_heading'] ?? 'Hablemos de negocios') ?>
                    </h2>
                    <p class="text-gray-300 mb-12 leading-relaxed text-lg">
                        <?= htmlspecialchars($settings['contact_description'] ?? 'Ponte en contacto con nuestro equipo comercial para agendar una consultoría de evaluación y escalar la tecnología de tu empresa.') ?>
                    </p>
                    
                    <div class="space-y-8">
                        <div class="flex items-start">
                            <div class="bg-white/10 p-3 rounded-xl mr-5">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-lg text-white">
                                    <?= htmlspecialchars($settings['contact_address_label'] ?? 'Sede Central') ?>
                                </h4>
                                <p class="text-gray-400 mt-1">
                                    <?= nl2br(htmlspecialchars($settings['contact_address_value'] ?? "Torre Empresarial Andina, Piso 12\nBogotá, Colombia")) ?>
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-white/10 p-3 rounded-xl mr-5">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-lg text-white">
                                    <?= htmlspecialchars($settings['contact_email_label'] ?? 'Correo Corporativo') ?>
                                </h4>
                                <p class="text-gray-400 mt-1">
                                    <?= htmlspecialchars($settings['contact_email_value'] ?? 'contacto@syncroandina.com') ?>
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-white/10 p-3 rounded-xl mr-5">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-lg text-white">
                                    <?= htmlspecialchars($settings['contact_phone_label'] ?? 'Línea de Atención') ?>
                                </h4>
                                <p class="text-gray-400 mt-1">
                                    <?= htmlspecialchars($settings['contact_phone_value'] ?? '+57 300 123 4567') ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario -->
            <div class="md:w-3/5 p-12 lg:p-16">
                <h3 class="text-3xl font-extrabold text-gray-900 mb-8">
                    <?= htmlspecialchars($settings['contact_form_heading'] ?? 'Envíanos un mensaje') ?>
                </h3>
                <form class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700">Nombre completo</label>
                            <input type="text" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent transition-shadow shadow-sm" placeholder="Ej. Juan Pérez">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700">Correo Corporativo</label>
                            <input type="email" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent transition-shadow shadow-sm" placeholder="ejemplo@empresa.com">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700">Asunto</label>
                        <input type="text" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent transition-shadow shadow-sm" placeholder="¿En qué podemos ayudarte?">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700">Mensaje</label>
                        <textarea rows="5" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent transition-shadow shadow-sm resize-none" placeholder="Cuéntanos más sobre tu proyecto..."></textarea>
                    </div>
                    <button type="button" class="w-full bg-primary hover:bg-secondary text-white font-bold py-4 rounded-xl transition-colors duration-300 shadow-lg mt-4 flex justify-center items-center gap-2 group">
                        Enviar Mensaje Seguro
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php $this->component('footer'); ?>
