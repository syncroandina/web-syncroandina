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
                    <h1 class="text-4xl font-extrabold mb-6">
                        <?= htmlspecialchars($settings['contact_heading'] ?? 'Hablemos de negocios') ?>
                    </h1>
                    <p class="text-gray-300 mb-12 leading-relaxed text-lg">
                        <?= htmlspecialchars($settings['contact_description'] ?? 'Ponte en contacto con nuestro equipo comercial para agendar una consultoría de evaluación y escalar la tecnología de tu empresa.') ?>
                    </p>
                    
                    <div class="space-y-8">
                        <div class="flex items-start">
                            <div class="bg-white/10 p-3 rounded-xl mr-5">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <h2 class="font-semibold text-lg text-white">
                                    <?= htmlspecialchars($settings['contact_address_label'] ?? 'Sede Central') ?>
                                </h2>
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
                                <h2 class="font-semibold text-lg text-white">
                                    <?= htmlspecialchars($settings['contact_email_label'] ?? 'Correo Corporativo') ?>
                                </h2>
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
                                <h2 class="font-semibold text-lg text-white">
                                    <?= htmlspecialchars($settings['contact_phone_label'] ?? 'Línea de Atención') ?>
                                </h2>
                                <p class="text-gray-400 mt-1">
                                    <?= htmlspecialchars($settings['contact_phone_value'] ?? '+57 300 123 4567') ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario con Lógica Condicional Premium -->
            <div class="md:w-3/5 p-12 lg:p-16">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-8" id="form-title-heading">
                    <?= htmlspecialchars($settings['contact_form_heading'] ?? 'Envíanos un mensaje') ?>
                </h2>

                <!-- Contenedores de Estado de Envío -->
                <div id="contact-alert-success" class="hidden bg-green-50/50 backdrop-blur-md border border-green-200/50 text-green-800 p-8 rounded-3xl flex-col items-center text-center animate-fade-in-up shadow-lg">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center text-green-500 mb-5 animate-bounce">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h4 class="text-2xl font-black mb-2 text-gray-900">¡Mensaje Enviado!</h4>
                    <p class="text-sm text-gray-600 max-w-sm leading-relaxed" id="success-msg"></p>
                </div>

                <form id="contact-interactive-form" class="space-y-6">
                    <!-- CSRF Token -->
                    <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">

                    <!-- Alerta de Error -->
                    <div id="contact-alert-error" class="hidden bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-xl text-sm flex items-center gap-3">
                        <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <span id="error-msg"></span>
                    </div>

                    <!-- Nombre y Email -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700">Nombre completo <span class="text-red-500">*</span></label>
                            <input type="text" name="name" required class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent transition-all shadow-sm" placeholder="Ej. Juan Pérez">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700">Correo Corporativo <span class="text-red-500">*</span></label>
                            <input type="email" name="email" required class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent transition-all shadow-sm" placeholder="ejemplo@empresa.com">
                        </div>
                    </div>

                    <!-- Teléfono (Ancho Completo) -->
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700">Teléfono / WhatsApp <span class="text-red-500">*</span></label>
                        <input type="text" name="phone" required class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent transition-all shadow-sm" placeholder="Ej. +51 000 000 000">
                    </div>

                    <!-- Tipo de Persona (Lógica Condicional) -->
                    <div class="space-y-3">
                        <label class="text-sm font-semibold text-gray-700 block">Tipo de Persona <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Persona Natural -->
                            <label class="relative flex items-center justify-between p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl cursor-pointer hover:bg-white hover:border-secondary/30 transition-all shadow-sm group">
                                <span class="flex items-center gap-3">
                                    <span class="p-2.5 bg-blue-50 text-secondary rounded-xl group-hover:bg-blue-100 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </span>
                                    <span class="font-bold text-gray-800 text-sm">Persona Natural</span>
                                </span>
                                <span class="flex items-center h-5">
                                    <input type="radio" name="client_type" value="persona" checked class="text-secondary focus:ring-secondary w-4 h-4 cursor-pointer m-0">
                                </span>
                            </label>
                            
                            <!-- Empresa -->
                            <label class="relative flex items-center justify-between p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl cursor-pointer hover:bg-white hover:border-secondary/30 transition-all shadow-sm group">
                                <span class="flex items-center gap-3">
                                    <span class="p-2.5 bg-blue-50 text-secondary rounded-xl group-hover:bg-blue-100 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    </span>
                                    <span class="font-bold text-gray-800 text-sm">Empresa</span>
                                </span>
                                <span class="flex items-center h-5">
                                    <input type="radio" name="client_type" value="empresa" class="text-secondary focus:ring-secondary w-4 h-4 cursor-pointer m-0">
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- RUC de la Empresa (Oculto Condicionalmente - Ancho Completo) -->
                    <div class="space-y-2 hidden transform origin-top transition-all duration-300 scale-95 opacity-0" id="company-fields">
                        <label class="text-sm font-semibold text-gray-700">RUC de la Empresa <span class="text-red-500">*</span></label>
                        <input type="text" id="ruc-input" name="ruc" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent transition-all shadow-sm" placeholder="Ej. 00000000000">
                    </div>

                    <!-- Selección de Servicio de Interés -->
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700">¿En qué servicio estás interesado?</label>
                        <div class="relative">
                            <select name="service_id" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent transition-all shadow-sm appearance-none cursor-pointer text-gray-700">
                                <option value="">Pregunta libre / Consulta general</option>
                                <?php if(!empty($services)): ?>
                                    <?php foreach($services as $serv): ?>
                                        <option value="<?= $serv['id'] ?>"><?= htmlspecialchars($serv['title']) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Asunto -->
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700">Asunto <span class="text-red-500">*</span></label>
                        <input type="text" name="subject" required class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent transition-all shadow-sm" placeholder="¿En qué podemos ayudarte?">
                    </div>

                    <!-- Mensaje -->
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700">Mensaje <span class="text-red-500">*</span></label>
                        <textarea name="message" rows="4" required class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent transition-all shadow-sm resize-none" placeholder="Cuéntanos más sobre tu proyecto o consulta..."></textarea>
                    </div>

                    <button type="submit" class="w-full bg-primary hover:bg-secondary text-white font-bold py-4 rounded-xl transition-all duration-300 shadow-lg mt-4 flex justify-center items-center gap-2 group transform active:scale-95">
                        <span>Enviar Mensaje Seguro</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('contact-interactive-form');
    const successAlert = document.getElementById('contact-alert-success');
    const errorAlert = document.getElementById('contact-alert-error');
    const formTitle = document.getElementById('form-title-heading');
    
    // Condicional RUC
    const clientTypeRadios = document.querySelectorAll('input[name="client_type"]');
    const companyFields = document.getElementById('company-fields');
    const rucInput = document.getElementById('ruc-input');

    clientTypeRadios.forEach(radio => {
        radio.addEventListener('change', (e) => {
            if (e.target.value === 'empresa') {
                companyFields.classList.remove('hidden');
                setTimeout(() => {
                    companyFields.classList.remove('scale-95', 'opacity-0');
                    companyFields.classList.add('scale-100', 'opacity-100');
                }, 10);
                rucInput.setAttribute('required', 'true');
            } else {
                companyFields.classList.add('scale-95', 'opacity-0');
                companyFields.classList.remove('scale-100', 'opacity-100');
                setTimeout(() => {
                    companyFields.classList.add('hidden');
                }, 300);
                rucInput.removeAttribute('required');
                rucInput.value = '';
            }
        });
    });

    // Envío del Formulario vía AJAX
    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            // Ocultar alertas anteriores
            errorAlert.classList.add('hidden');

            const submitBtn = form.querySelector('button[type="submit"]');
            const submitBtnSpan = submitBtn.querySelector('span');
            const originalBtnContent = submitBtn.innerHTML;

            // Bloquear botón con Spinner premium
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Procesando envío...</span>
            `;

            try {
                const formData = new FormData(form);
                const response = await fetch('/contacto', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    window.location.href = '/gracias';
                } else {
                    // Mostrar error
                    document.getElementById('error-msg').textContent = result.message;
                    errorAlert.classList.remove('hidden');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnContent;
                }
            } catch (err) {
                console.error(err);
                document.getElementById('error-msg').textContent = 'Ocurrió un error inesperado al procesar la solicitud. Por favor, intente de nuevo.';
                errorAlert.classList.remove('hidden');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnContent;
            }
        });
    }
});
</script>

<?php $this->component('footer'); ?>
