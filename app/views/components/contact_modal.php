<!-- Ventana Modal de Contacto Reutilizable -->
<style>
/* Elegante Scrollbar Personalizado para el Modal Global */
.modal-scrollbar::-webkit-scrollbar {
    width: 8px;
}
.modal-scrollbar::-webkit-scrollbar-track {
    background: transparent;
    margin-top: 32px;
    margin-bottom: 32px;
}
.modal-scrollbar::-webkit-scrollbar-thumb {
    background-color: rgba(156, 163, 175, 0.25);
    border-radius: 9999px;
    border: 2px solid transparent;
    background-clip: padding-box;
}
.modal-scrollbar::-webkit-scrollbar-thumb:hover {
    background-color: rgba(156, 163, 175, 0.45);
}
</style>

<div id="contact-form-modal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-md hidden z-[9999] items-center justify-center p-4 opacity-0 transition-opacity duration-300">
    <div id="contact-modal-container" class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 w-full max-w-xl overflow-hidden transform transition-all scale-95 opacity-0 duration-300 flex flex-col relative max-h-[90vh]">
        
        <!-- Decoración Superior -->
        <div class="absolute -top-16 -right-16 w-36 h-36 bg-secondary/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -bottom-16 -left-16 w-36 h-36 bg-primary/5 rounded-full blur-2xl pointer-events-none"></div>

        <!-- Botón Cerrar -->
        <button onclick="closeContactModal()" class="absolute top-6 right-6 text-gray-400 hover:text-gray-600 transition-colors p-2 hover:bg-gray-50 rounded-xl z-20">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <div class="pt-8 pb-8 pl-8 pr-5 md:pt-10 md:pb-10 md:pl-10 md:pr-7 flex-1 relative z-10 flex flex-col overflow-y-auto modal-scrollbar">
            <!-- Encabezado del Formulario -->
            <div id="contact-modal-header" class="mb-6">
                <h3 class="text-3xl font-black text-gray-900 leading-tight">Solicitar Información</h3>
                <p class="text-sm text-gray-500 mt-2">Déjanos tus datos y un especialista se pondrá en contacto contigo a la brevedad.</p>
            </div>

            <!-- Pantalla de Éxito Moderno (Oculto inicialmente) -->
            <div id="contact-modal-success" class="hidden flex-col items-center justify-center text-center py-12 flex-1">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center text-green-500 mb-6 animate-bounce">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h4 class="text-2xl font-extrabold text-gray-900 mb-2">¡Mensaje Enviado!</h4>
                <p class="text-gray-500 text-sm max-w-xs leading-relaxed" id="contact-modal-success-msg">Tu solicitud ha sido recibida con éxito. Uno de nuestros ingenieros comerciales se pondrá en contacto contigo en unos minutos.</p>
            </div>

            <!-- Formulario de Contacto -->
            <form id="contact-modal-form" class="space-y-5 flex-1">
                <!-- CSRF Token -->
                <input type="hidden" name="csrf_token" value="<?= \Core\Security::generateCSRFToken() ?>">

                <!-- Alerta de Error -->
                <div id="contact-modal-alert-error" class="hidden bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-xl text-sm flex items-center gap-3">
                    <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <span id="contact-modal-error-msg"></span>
                </div>

                <!-- Nombre y Email -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold text-gray-700">Nombre completo <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="contact-modal-name" required class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent transition-all shadow-sm" placeholder="Ej. Juan Pérez">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold text-gray-700">Correo Corporativo <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="contact-modal-email" required class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent transition-all shadow-sm" placeholder="ejemplo@empresa.com">
                    </div>
                </div>

                <!-- Teléfono (Ancho Completo) -->
                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-gray-700">Teléfono / WhatsApp <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" id="contact-modal-phone" required class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent transition-all shadow-sm" placeholder="Ej. +51 000 000 000">
                </div>

                <!-- Tipo de Persona (Lógica Condicional) -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 block">Tipo de Persona <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <!-- Persona Natural -->
                        <label class="relative flex items-center justify-between p-3 bg-gray-50 border-2 border-gray-100 rounded-xl cursor-pointer hover:bg-white hover:border-secondary/30 transition-all shadow-sm group">
                            <span class="flex items-center gap-2">
                                <span class="p-2 bg-blue-50 text-secondary rounded-lg group-hover:bg-blue-100 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </span>
                                <span class="font-bold text-gray-800 text-xs">Persona Natural</span>
                            </span>
                            <span class="flex items-center h-4">
                                <input type="radio" name="client_type" value="persona" checked class="text-secondary focus:ring-secondary w-3.5 h-3.5 cursor-pointer m-0">
                            </span>
                        </label>
                        
                        <!-- Empresa -->
                        <label class="relative flex items-center justify-between p-3 bg-gray-50 border-2 border-gray-100 rounded-xl cursor-pointer hover:bg-white hover:border-secondary/30 transition-all shadow-sm group">
                            <span class="flex items-center gap-2">
                                <span class="p-2 bg-blue-50 text-secondary rounded-lg group-hover:bg-blue-100 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </span>
                                <span class="font-bold text-gray-800 text-xs">Empresa</span>
                            </span>
                            <span class="flex items-center h-4">
                                <input type="radio" name="client_type" value="empresa" class="text-secondary focus:ring-secondary w-3.5 h-3.5 cursor-pointer m-0">
                            </span>
                        </label>
                    </div>
                </div>

                <!-- RUC de la Empresa (Oculto Condicionalmente - Ancho Completo) -->
                <div class="space-y-1.5 hidden transform origin-top transition-all duration-300 scale-95 opacity-0" id="contact-modal-company-fields">
                    <label class="text-sm font-semibold text-gray-700">RUC de la Empresa <span class="text-red-500">*</span></label>
                    <input type="text" id="contact-modal-ruc-input" name="ruc" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent transition-all shadow-sm" placeholder="Ej. 00000000000">
                </div>

                <!-- Selección de Servicio de Interés -->
                <?php
                if (!isset($services)) {
                    $serviceModel = new \App\Models\Service();
                    $services = $serviceModel->getActive();
                }
                ?>
                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-gray-700">¿En qué servicio estás interesado?</label>
                    <div class="relative">
                        <select name="service_id" id="contact-modal-service-id" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent transition-all shadow-sm appearance-none cursor-pointer text-gray-700">
                            <option value="">Pregunta libre / Consulta general</option>
                            <?php if(!empty($services)): ?>
                                <?php foreach($services as $serv): ?>
                                    <option value="<?= $serv['id'] ?>"><?= htmlspecialchars($serv['title']) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Asunto -->
                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-gray-700">Asunto <span class="text-red-500">*</span></label>
                    <input type="text" name="subject" id="contact-modal-subject" required class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent transition-all shadow-sm" placeholder="¿En qué podemos ayudarte?">
                </div>

                <!-- Mensaje -->
                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-gray-700">Mensaje <span class="text-red-500">*</span></label>
                    <textarea name="message" id="contact-modal-message" rows="3" required class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent transition-all shadow-sm resize-none" placeholder="Cuéntanos más sobre tu proyecto o consulta..."></textarea>
                </div>

                <button type="submit" class="w-full bg-primary hover:bg-secondary text-white font-bold py-3.5 rounded-xl transition-all duration-300 shadow-xl shadow-primary/10 hover:shadow-secondary/20 hover:scale-[1.02] active:scale-95 flex justify-center items-center gap-2 mt-4 group">
                    <span>Enviar Mensaje Seguro</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function openContactModal(subject = '', serviceTitle = '') {
    const modal = document.getElementById('contact-form-modal');
    if (!modal) return;

    // Resetear vistas antes de abrir
    document.getElementById('contact-modal-header').classList.remove('hidden');
    document.getElementById('contact-modal-form').classList.remove('hidden');
    document.getElementById('contact-modal-success').classList.add('hidden');
    document.getElementById('contact-modal-alert-error').classList.add('hidden');

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    setTimeout(() => {
        modal.classList.remove('opacity-0');
        modal.classList.add('opacity-100');
        const container = document.getElementById('contact-modal-container');
        if (container) {
            container.classList.remove('scale-95', 'opacity-0');
            container.classList.add('scale-100', 'opacity-100');
        }
    }, 10);

    if (subject) {
        const subjectInput = document.getElementById('contact-modal-subject');
        if (subjectInput) {
            subjectInput.value = subject;
        }
    }

    if (serviceTitle) {
        const selectElement = document.getElementById('contact-modal-service-id');
        if (selectElement) {
            // Intentar seleccionar la opción por texto o título
            for (let option of selectElement.options) {
                if (option.text.toLowerCase().trim() === serviceTitle.toLowerCase().trim()) {
                    selectElement.value = option.value;
                    break;
                }
            }
        }
    }
    document.body.style.overflow = 'hidden';
}

function closeContactModal() {
    const modal = document.getElementById('contact-form-modal');
    if (!modal) return;

    const container = document.getElementById('contact-modal-container');
    if (container) {
        container.classList.remove('scale-100', 'opacity-100');
        container.classList.add('scale-95', 'opacity-0');
    }
    modal.classList.remove('opacity-100');
    modal.classList.add('opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
    document.body.style.overflow = '';
}

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('contact-modal-form');
    const successAlert = document.getElementById('contact-modal-success');
    const errorAlert = document.getElementById('contact-modal-alert-error');
    const companyFields = document.getElementById('contact-modal-company-fields');
    const rucInput = document.getElementById('contact-modal-ruc-input');
    const clientTypeRadios = document.querySelectorAll('#contact-modal-form input[name="client_type"]');

    // Condicional RUC en modal
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

    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            errorAlert.classList.add('hidden');

            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnContent = submitBtn.innerHTML;

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

                    form.reset();
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnContent;
                    }

                    // Auto-cerrar después de 3 segundos
                    setTimeout(() => {
                        closeContactModal();
                    }, 3000);
                } else {
                    document.getElementById('contact-modal-error-msg').textContent = result.message;
                    errorAlert.classList.remove('hidden');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnContent;
                }
            } catch (err) {
                console.error(err);
                document.getElementById('contact-modal-error-msg').textContent = 'Ocurrió un error inesperado. Por favor, inténtelo de nuevo.';
                errorAlert.classList.remove('hidden');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnContent;
            }
        });
    }

    // Cerrar al hacer clic en el fondo oscuro
    const modal = document.getElementById('contact-form-modal');
    if (modal) {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeContactModal();
            }
        });
    }

    // Cerrar con Escape
    document.addEventListener('keydown', (e) => {
        const modal = document.getElementById('contact-form-modal');
        if (modal && !modal.classList.contains('hidden') && e.key === 'Escape') {
            closeContactModal();
        }
    });
});
</script>
