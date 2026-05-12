<?php
$callCenterModel = new \App\Models\CallCenter();
$settingModel = new \App\Models\Setting();

$ccSettings = $settingModel->getAll();
$ccContacts = $callCenterModel->getActive();

// Si está desactivado globalmente o no hay contactos, no renderizar nada.
if (($ccSettings['call_center_is_visible'] ?? '1') == '0' || empty($ccContacts)) {
    return;
}

$mainTitle = $ccSettings['call_center_main_title'] ?? 'Central de Atención';
$mainSubtitle = $ccSettings['call_center_main_subtitle'] ?? 'ESTAMOS LISTOS PARA AYUDARTE';
$footerText = $ccSettings['call_center_footer_text'] ?? '© Syncro Andina - Soluciones Industriales';
?>

<!-- Estilos Localizados del Widget de Call Center -->
<style>
    .cc-widget-container {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 9999;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }

    /* Burbuja Flotante */
    .cc-trigger {
        width: 60px;
        height: 60px;
        background: var(--secondary); /* Dinámico */
        border-radius: 50%;
        box-shadow: 0 10px 25px color-mix(in srgb, var(--secondary) 40%, transparent);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none;
        outline: none;
        padding: 0;
    }
    
    .cc-trigger:hover {
        transform: scale(1.1);
        box-shadow: 0 15px 35px color-mix(in srgb, var(--secondary) 50%, transparent);
    }
    
    .cc-trigger:active {
        transform: scale(0.9);
    }

    /* Punto de notificación verde */
    .cc-trigger::after {
        content: '';
        position: absolute;
        top: 2px;
        right: 5px;
        width: 14px;
        height: 14px;
        background: #10b981;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
        animation: cc-pulse 2s infinite;
    }

    @keyframes cc-pulse {
        0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
        100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }

    .cc-icon-main {
        width: 28px;
        height: 28px;
        color: #fff;
        transition: transform 0.3s ease;
    }
    
    .cc-icon-close {
        width: 26px;
        height: 26px;
        color: #fff;
        display: none;
        transition: transform 0.3s ease;
    }

    /* Estado Activo de la Burbuja (cambia icono) */
    .cc-trigger.active {
        background: var(--primary); /* Color Primario Dinámico al abrir */
        box-shadow: 0 10px 25px color-mix(in srgb, var(--primary) 30%, transparent);
    }
    .cc-trigger.active::after { display: none; }
    .cc-trigger.active .cc-icon-main { display: none; }
    .cc-trigger.active .cc-icon-close { display: block; transform: rotate(90deg); }

    /* La Ventana Emergente */
    .cc-popup {
        width: 340px;
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 15px 50px -12px rgba(0, 0, 0, 0.2);
        margin-bottom: 20px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        opacity: 0;
        visibility: hidden;
        transform: translateY(20px) scale(0.95);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        pointer-events: none;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .cc-popup.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0) scale(1);
        pointer-events: auto;
    }

    /* Cabecera del Popup */
    .cc-popup-header {
        background: var(--secondary);
        padding: 24px 20px;
        color: #fff;
        position: relative;
        background: linear-gradient(135deg, var(--secondary) 0%, var(--primary) 100%);
    }

    .cc-header-content {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .cc-header-icon-box {
        width: 36px;
        height: 36px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .cc-header-icon {
        width: 20px;
        height: 20px;
        color: #fff;
    }

    .cc-header-text {
        flex: 1;
    }

    .cc-header-title {
        font-size: 17px;
        font-weight: 800;
        margin: 0;
        line-height: 1.2;
        letter-spacing: -0.3px;
    }

    .cc-header-subtitle {
        font-size: 10px;
        font-weight: 700;
        opacity: 0.85;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 3px;
        display: block;
    }

    /* Cuerpo del Popup */
    .cc-popup-body {
        padding: 20px;
        background: #fff;
        display: flex;
        flex-direction: column;
        gap: 12px;
        max-height: 380px;
        overflow-y: auto;
    }

    /* Estilos de las Filas de Contacto */
    .cc-contact-link {
        display: flex;
        align-items: center;
        padding: 16px 16px;
        border-radius: 16px;
        text-decoration: none;
        transition: all 0.2s ease;
        position: relative;
        border: 1px solid transparent;
    }

    /* Versión WhatsApp */
    .cc-link-whatsapp {
        background: #f0fdf4; /* green-50 */
        color: #166534;
    }
    .cc-link-whatsapp:hover {
        background: #dcfce7;
        transform: translateX(-4px);
    }
    .cc-link-whatsapp .cc-link-icon-wrapper {
        background: #fff;
        color: #22c55e;
        box-shadow: 0 4px 12px rgba(34, 197, 94, 0.1);
    }

    /* Versión Phone */
    .cc-link-phone {
        background: color-mix(in srgb, var(--secondary) 8%, #ffffff); /* Tinte dinámico suave */
        color: color-mix(in srgb, var(--secondary) 80%, black);
    }
    .cc-link-phone:hover {
        background: color-mix(in srgb, var(--secondary) 15%, #ffffff);
        transform: translateX(-4px);
    }
    .cc-link-phone .cc-link-icon-wrapper {
        background: var(--secondary);
        color: #fff;
        box-shadow: 0 4px 12px color-mix(in srgb, var(--secondary) 20%, transparent);
    }

    .cc-link-icon-wrapper {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 14px;
        flex-shrink: 0;
        transition: transform 0.2s ease;
    }

    .cc-contact-link:hover .cc-link-icon-wrapper {
        transform: scale(1.05);
    }

    .cc-link-text-box {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .cc-link-label {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        opacity: 0.7;
        margin-bottom: 1px;
    }

    .cc-link-main-title {
        font-size: 16px;
        font-weight: 800;
        line-height: 1.2;
    }

    /* Pie del Popup */
    .cc-popup-footer {
        padding: 12px 20px;
        background: #f9fafb;
        border-top: 1px solid #f3f4f6;
        text-align: center;
    }

    .cc-footer-text {
        font-size: 9.5px;
        color: #9ca3af;
        font-weight: 600;
    }

    /* Responsive Mobile */
    @media (max-width: 480px) {
        .cc-widget-container {
            right: 20px;
            bottom: 20px;
        }
        .cc-popup {
            width: calc(100vw - 40px);
            bottom: 85px; /* Espacio para el trigger */
        }
    }
</style>

<div class="cc-widget-container" id="cc-widget">
    <!-- Ventana Emergente -->
    <div class="cc-popup" id="cc-popup-window">
        <!-- Cabecera -->
        <div class="cc-popup-header">
            <div class="cc-header-content">
                <div class="cc-header-icon-box">
                    <svg class="cc-header-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div class="cc-header-text">
                    <h4 class="cc-header-title"><?= htmlspecialchars($mainTitle) ?></h4>
                    <span class="cc-header-subtitle"><?= htmlspecialchars($mainSubtitle) ?></span>
                </div>
            </div>
        </div>

        <!-- Lista de Contactos -->
        <div class="cc-popup-body">
            <?php foreach($ccContacts as $contact): 
                $link = ($contact['type'] === 'whatsapp') 
                    ? 'https://api.whatsapp.com/send?phone=' . preg_replace('/[^0-9]/', '', $contact['phone_number']) 
                    : 'tel:' . preg_replace('/[^0-9+]/', '', $contact['phone_number']);
                
                $cssClass = ($contact['type'] === 'whatsapp') ? 'cc-link-whatsapp' : 'cc-link-phone';
                $labelText = !empty($contact['subtitle']) ? $contact['subtitle'] : (($contact['type'] === 'whatsapp') ? 'CONSULTAR POR' : 'CONSULTAR POR');
            ?>
                <a href="<?= $link ?>" target="_blank" class="cc-contact-link <?= $cssClass ?>">
                    <div class="cc-link-icon-wrapper">
                        <?php if($contact['type'] === 'whatsapp'): ?>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"></path></svg>
                        <?php else: ?>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <?php endif; ?>
                    </div>
                    <div class="cc-link-text-box">
                        <span class="cc-link-label"><?= htmlspecialchars($labelText) ?></span>
                        <span class="cc-link-main-title"><?= htmlspecialchars($contact['title']) ?></span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Footer Info -->
        <div class="cc-popup-footer">
            <span class="cc-footer-text"><?= htmlspecialchars($footerText) ?></span>
        </div>
    </div>

    <!-- Burbuja Activadora -->
    <button class="cc-trigger" id="cc-main-trigger" aria-label="Abrir Central de Ayuda">
        <!-- Icono Headset / Atención -->
        <svg class="cc-icon-main" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
        <!-- Icono de X para cerrar -->
        <svg class="cc-icon-close" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const trigger = document.getElementById('cc-main-trigger');
    const popup = document.getElementById('cc-popup-window');
    
    if(trigger && popup) {
        trigger.addEventListener('click', function(e) {
            e.stopPropagation();
            const isActive = trigger.classList.contains('active');
            
            if(isActive) {
                trigger.classList.remove('active');
                popup.classList.remove('show');
            } else {
                trigger.classList.add('active');
                popup.classList.add('show');
            }
        });
        
        // Cerrar al hacer click fuera del widget
        document.addEventListener('click', function(event) {
            const isClickInside = document.getElementById('cc-widget').contains(event.target);
            if (!isClickInside && popup.classList.contains('show')) {
                trigger.classList.remove('active');
                popup.classList.remove('show');
            }
        });
    }
});
</script>
