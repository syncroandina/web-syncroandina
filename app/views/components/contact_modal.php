<!-- Ventana Modal de Contacto Reutilizable -->
<div id="contact-form-modal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-md hidden z-[9999] items-center justify-center p-4 opacity-0 transition-opacity duration-300">
    <div id="contact-modal-container" class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 w-full max-w-lg overflow-hidden transform transition-all scale-95 opacity-0 duration-300 flex flex-col relative">
        
        <!-- Decoración Superior -->
        <div class="absolute -top-16 -right-16 w-36 h-36 bg-secondary/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -bottom-16 -left-16 w-36 h-36 bg-primary/5 rounded-full blur-2xl pointer-events-none"></div>

        <!-- Botón Cerrar -->
        <button onclick="closeContactModal()" class="absolute top-6 right-6 text-gray-400 hover:text-gray-600 transition-colors p-2 hover:bg-gray-50 rounded-xl z-20">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <div class="p-8 md:p-10 flex-1 relative z-10 flex flex-col">
            <!-- Encabezado del Formulario -->
            <div id="contact-modal-header" class="mb-8">
                <h3 class="text-3xl font-black text-gray-900 leading-tight">Solicitar Información</h3>
                <p class="text-sm text-gray-500 mt-2">Déjanos tus datos y un especialista se pondrá en contacto contigo a la brevedad.</p>
            </div>

            <!-- Formulario de Contacto -->
            <form id="contact-modal-form" class="space-y-5 flex-1">
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider pl-1">Nombre completo</label>
                    <input type="text" id="contact-modal-name" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-4 text-sm focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary focus:bg-white transition-all" placeholder="Ej. Juan Pérez">
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider pl-1">Correo Corporativo</label>
                    <input type="email" id="contact-modal-email" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-4 text-sm focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary focus:bg-white transition-all" placeholder="ejemplo@empresa.com">
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider pl-1">Asunto</label>
                    <input type="text" id="contact-modal-subject" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-4 text-sm focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary focus:bg-white transition-all" placeholder="¿En qué podemos ayudarte?">
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider pl-1">Mensaje</label>
                    <textarea id="contact-modal-message" rows="4" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-4 text-sm focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary focus:bg-white transition-all resize-none" placeholder="Cuéntanos más sobre tu proyecto..."></textarea>
                </div>

                <button type="submit" class="w-full bg-primary hover:bg-secondary text-white font-bold py-4 rounded-2xl transition-all duration-300 shadow-xl shadow-primary/10 hover:shadow-secondary/20 hover:scale-[1.02] active:scale-95 flex justify-center items-center gap-2 mt-4 group">
                    <span>Enviar Mensaje Seguro</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </form>

            <!-- Pantalla de Éxito Moderno (Oculto inicialmente) -->
            <div id="contact-modal-success" class="hidden flex-col items-center justify-center text-center py-12 flex-1">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center text-green-500 mb-6 animate-bounce">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h4 class="text-2xl font-extrabold text-gray-900 mb-2">¡Mensaje Enviado!</h4>
                <p class="text-gray-500 text-sm max-w-xs leading-relaxed">Tu solicitud ha sido recibida con éxito. Uno de nuestros ingenieros comerciales se pondrá en contacto contigo en unos minutos.</p>
            </div>
        </div>
    </div>
</div>

<script>
function openContactModal(subject = '') {
    const modal = document.getElementById('contact-form-modal');
    if (!modal) return;

    // Resetear vistas antes de abrir
    document.getElementById('contact-modal-header').classList.remove('hidden');
    document.getElementById('contact-modal-form').classList.remove('hidden');
    document.getElementById('contact-modal-success').classList.add('hidden');

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
    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();

            // Simulación de envío con animación premium
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Procesando envío...</span>
                `;
            }

            setTimeout(() => {
                // Ocultar formulario e info
                document.getElementById('contact-modal-header').classList.add('hidden');
                document.getElementById('contact-modal-form').classList.add('hidden');
                
                // Mostrar pantalla de éxito
                document.getElementById('contact-modal-success').classList.remove('hidden');
                document.getElementById('contact-modal-success').classList.add('flex');

                // Resetear botón y formulario
                form.reset();
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = `
                        <span>Enviar Mensaje Seguro</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    `;
                }

                // Auto-cerrar después de 3 segundos
                setTimeout(() => {
                    closeContactModal();
                }, 3000);

            }, 1500);
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
