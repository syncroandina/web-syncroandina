<?php
$settingModel = new \App\Models\Setting();
$menuLinkModel = new \App\Models\MenuLink();

$logoUrl = $settingModel->get('logo_url', '/assets/images/logo.webp');
$contactPhone = $settingModel->get('contact_phone_value', '+57 300 123 4567');
$menuLinks = $menuLinkModel->getActive();
?>
<nav class="bg-white/95 backdrop-blur-md shadow-sm sticky top-0 z-50 transition-all duration-300 border-b border-gray-100">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
         <!-- Logo con Contenedor Moderno Sobresaliente -->
        <div class="relative z-50 flex items-center h-12 md:h-16">
            <div class="absolute left-0 top-[-16px]">
                <a href="<?= url() ?>" class="bg-white px-2.5 pb-3.5 pt-1.5 md:px-3 md:pb-4 md:pt-1.5 lg:px-4 lg:pb-5 lg:pt-2 rounded-b-[2rem] md:rounded-b-[2.5rem] lg:rounded-b-[2.75rem] shadow-[0_12px_40px_rgba(0,0,0,0.1)] border-x border-b border-gray-100 flex items-center justify-center transition-all duration-300 hover:scale-105 hover:shadow-[0_24px_48px_rgba(0,0,0,0.15)]">
                    <?php if(!empty($logoUrl)): ?>
                        <img src="<?= asset($logoUrl) ?>" alt="Syncro Andina Logo" class="h-28 md:h-32 lg:h-38 w-auto object-contain transition-transform">
                    <?php else: ?>
                        <div class="w-14 h-14 bg-secondary rounded-xl flex items-center justify-center">
                            <span class="text-white text-3xl font-bold">S</span>
                        </div>
                    <?php endif; ?>
                </a>
            </div>
            <!-- Espaciador para reservar el ancho del logo en el flexbox -->
            <div class="w-32 md:w-44 lg:w-48 h-1"></div>
        </div>

        <!-- Desktop Menu -->
        <div class="hidden lg:flex space-x-8">
            <?php foreach($menuLinks as $link): ?>
                <?php if(!empty($link['children'])): ?>
                    <div class="relative group">
                        <a href="<?= htmlspecialchars($link['url']) ?>" class="text-sm font-bold text-gray-700 hover:text-secondary transition-colors flex items-center gap-1 py-2">
                            <?= htmlspecialchars($link['title']) ?>
                            <svg class="w-4 h-4 text-gray-400 group-hover:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </a>
                        <div class="absolute left-0 mt-2 w-56 rounded-2xl shadow-xl bg-white ring-1 ring-black ring-opacity-5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 transform origin-top-left group-hover:translate-y-0 translate-y-4">
                            <div class="py-2 p-2" role="menu">
                                <?php foreach($link['children'] as $child): ?>
                                    <a href="<?= htmlspecialchars($child['url']) ?>" class="block px-4 py-3 text-sm text-gray-600 hover:bg-gray-50 hover:text-secondary rounded-xl transition-all" role="menuitem">
                                        <?= htmlspecialchars($child['title']) ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?= htmlspecialchars($link['url']) ?>" class="text-sm font-bold text-gray-700 hover:text-secondary transition-colors py-2"><?= htmlspecialchars($link['title']) ?></a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <!-- Desktop CTA -->
        <div class="hidden lg:block">
            <a href="tel:<?= htmlspecialchars($contactPhone) ?>" class="px-7 py-3 bg-primary text-white text-sm font-bold rounded-xl hover:bg-secondary transition-all shadow-lg shadow-primary/20 flex items-center gap-2 transform hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                Llamar Ahora
            </a>
        </div>

        <!-- Mobile/Tablet Hamburger -->
        <button id="mobile-menu-btn" class="lg:hidden p-2.5 text-gray-700 hover:bg-gray-100 rounded-xl transition-colors">
            <svg id="menu-icon" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
            <svg id="close-icon" class="w-7 h-7 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <!-- Mobile Menu Container -->
    <div id="mobile-menu" class="lg:hidden fixed inset-x-0 top-[81px] bg-white/95 backdrop-blur-xl border-t border-gray-100 shadow-2xl opacity-0 invisible -translate-y-4 transition-all duration-300 z-40 overflow-y-auto max-h-[80vh] rounded-b-[2rem]">
        <div class="px-6 pt-12 pb-6 space-y-4 text-center">
            <div class="flex flex-col space-y-1">
                <?php foreach($menuLinks as $link): ?>
                    <?php if(!empty($link['children'])): ?>
                        <div class="mobile-dropdown group">
                            <button class="w-full flex items-center justify-center gap-2 py-2.5 text-lg font-bold text-gray-800 transition-all dropdown-toggle">
                                <?= htmlspecialchars($link['title']) ?>
                                <svg class="w-4 h-4 text-gray-400 transition-transform duration-300 arrow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div class="dropdown-content hidden flex-col space-y-1 bg-gray-50/50 rounded-2xl mb-2 py-2">
                                <?php foreach($link['children'] as $child): ?>
                                    <a href="<?= htmlspecialchars($child['url']) ?>" class="block py-2 text-base font-semibold text-gray-600 hover:text-secondary transition-all">
                                        <?= htmlspecialchars($child['title']) ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?= htmlspecialchars($link['url']) ?>" class="block py-2.5 text-lg font-bold text-gray-800 hover:text-secondary transition-all">
                            <?= htmlspecialchars($link['title']) ?>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <!-- Mobile CTA (Inside Menu) -->
            <div class="pt-4 border-t border-gray-50">
                <a href="tel:<?= htmlspecialchars($contactPhone) ?>" class="w-full py-4 bg-primary text-white text-center font-bold rounded-2xl shadow-xl shadow-primary/20 flex items-center justify-center gap-3 active:scale-95 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    Llamar Ahora
                </a>
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');
    let isOpen = false;

    btn.addEventListener('click', () => {
        isOpen = !isOpen;
        if (isOpen) {
            menu.classList.remove('invisible', 'opacity-0', '-translate-y-4');
            menu.classList.add('visible', 'opacity-100', 'translate-y-0');
            menuIcon.classList.add('hidden');
            closeIcon.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        } else {
            menu.classList.remove('visible', 'opacity-100', 'translate-y-0');
            menu.classList.add('invisible', 'opacity-0', '-translate-y-4');
            menuIcon.classList.remove('hidden');
            closeIcon.classList.add('hidden');
            document.body.style.overflow = '';
        }
    });

    // Dropdowns móviles
    const toggles = menu.querySelectorAll('.dropdown-toggle');
    toggles.forEach(toggle => {
        toggle.addEventListener('click', (e) => {
            const content = toggle.nextElementSibling;
            const arrow = toggle.querySelector('.arrow-icon');
            const isHidden = content.classList.contains('hidden');
            
            // Cerrar otros dropdowns
            menu.querySelectorAll('.dropdown-content').forEach(c => c.classList.add('hidden'));
            menu.querySelectorAll('.arrow-icon').forEach(a => a.classList.remove('rotate-180'));

            if (isHidden) {
                content.classList.remove('hidden');
                content.classList.add('flex');
                arrow.classList.add('rotate-180');
            }
        });
    });

    // Close menu when clicking on a link
    const links = menu.querySelectorAll('a');
    links.forEach(link => {
        link.addEventListener('click', () => {
            isOpen = false;
            menu.classList.add('invisible', 'opacity-0', '-translate-y-4');
            menuIcon.classList.remove('hidden');
            closeIcon.classList.add('hidden');
            document.body.style.overflow = '';
        });
    });
});
</script>
