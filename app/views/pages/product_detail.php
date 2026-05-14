<?php $this->component('header', ['title' => $title ?? 'Detalle del Repuesto']); ?>
<?php $this->component('navbar'); ?>

<main class="min-h-screen bg-white pt-28 md:pt-32 pb-20">
    <div class="container mx-auto px-4">
        <!-- Breadcrumbs -->
        <nav class="mb-10 animate-fade-in-up">
            <a href="/repuestos" class="text-sm font-bold text-gray-400 hover:text-secondary transition-colors">Catálogo de Repuestos</a>
            <span class="mx-3 text-gray-300">/</span>
            <span class="text-sm font-bold text-gray-900"><?= htmlspecialchars($product['title']) ?></span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20 items-start">
            
            <!-- Columna Izquierda: Imágenes (6 columnas en Desktop) -->
            <div class="lg:col-span-6 space-y-6 animate-fade-in-up" style="animation-delay: 100ms;">
                <div class="bg-gray-100 rounded-[2rem] border border-gray-100 flex items-center justify-center aspect-square shadow-sm relative group overflow-hidden">
                    <img id="main-product-image" src="<?= asset($product['main_image']) ?>" alt="<?= htmlspecialchars($product['image_alt'] ?: $product['title']) ?>" class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-105">
                </div>
                
                <?php if(!empty($gallery)): ?>
                <div class="grid grid-cols-4 sm:grid-cols-5 gap-4">
                    <!-- Thumbnail de la principal -->
                    <div class="bg-gray-100 rounded-2xl border-2 border-secondary cursor-pointer aspect-square flex items-center justify-center thumbnail-trigger transition-all overflow-hidden" data-src="<?= asset($product['main_image']) ?>" onclick="updateMainImage(this)">
                        <img src="<?= asset($product['main_image']) ?>" class="w-full h-full object-cover">
                    </div>
                    <!-- Thumbnails de la galería -->
                    <?php foreach($gallery as $img): 
                        if ($img['image_path'] === $product['main_image']) continue;
                    ?>
                    <div class="bg-gray-100 rounded-2xl border-2 border-transparent hover:border-gray-200 cursor-pointer aspect-square flex items-center justify-center thumbnail-trigger transition-all overflow-hidden" data-src="<?= asset($img['image_path']) ?>" onclick="updateMainImage(this)">
                        <img src="<?= asset($img['image_path']) ?>" class="w-full h-full object-cover">
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Columna Derecha: Información (6 columnas en Desktop) -->
            <div class="lg:col-span-6 lg:sticky lg:top-32 animate-fade-in-up" style="animation-delay: 200ms;">
                
                <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-6 leading-[1.1]">
                    <?= htmlspecialchars($product['title']) ?>
                </h1>
                
                <div class="prose prose-lg text-gray-500 mb-10 leading-relaxed">
                    <?= nl2br(htmlspecialchars($product['description'])) ?>
                </div>

                <?php if(!empty($product['technical_details'])): ?>
                <div class="mb-10 bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <h3 class="text-sm font-extrabold text-gray-900 uppercase tracking-widest mb-4">Especificaciones Técnicas</h3>
                    <ul class="space-y-3">
                        <?php 
                        $techDetails = explode("\n", trim($product['technical_details']));
                        foreach($techDetails as $detail): 
                            $detail = trim($detail);
                            if(!empty($detail)):
                        ?>
                        <li class="flex items-start gap-3 text-gray-600 text-sm">
                            <svg class="w-5 h-5 text-secondary flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span><?= htmlspecialchars($detail) ?></span>
                        </li>
                        <?php 
                            endif;
                        endforeach; 
                        ?>
                    </ul>
                </div>
                <?php endif; ?>

                <button onclick="openContactModal('Consulta sobre repuesto: <?= addslashes(htmlspecialchars($product['title'])) ?>')" class="w-full inline-flex items-center justify-center gap-2 px-8 py-4 bg-primary hover:bg-secondary text-white font-bold rounded-xl transition-all shadow-lg shadow-primary/20 hover:shadow-secondary/30 transform hover:-translate-y-0.5 mt-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    Contactar a un Asesor
                </button>
            </div>
        </div>
    </div>
</main>

<script>
function updateMainImage(element) {
    // Cambiar la imagen principal
    const src = element.getAttribute('data-src');
    const mainImg = document.getElementById('main-product-image');
    
    // Pequeño efecto de fade
    mainImg.style.opacity = '0.5';
    setTimeout(() => {
        mainImg.src = src;
        mainImg.style.opacity = '1';
    }, 150);
    
    // Actualizar bordes de los thumbnails
    document.querySelectorAll('.thumbnail-trigger').forEach(thumb => {
        thumb.classList.remove('border-secondary');
        thumb.classList.add('border-transparent');
    });
    
    // Marcar el activo
    element.classList.remove('border-transparent');
    element.classList.add('border-secondary');
}
</script>

<style>
/* Elimina el margen superior del footer para evitar huecos grises del body */
footer {
    margin-top: 0 !important;
}
/* Asegurar que el fondo del body sea blanco si no hay contenido suficiente */
body {
    background-color: #ffffff;
}
</style>

<?php $this->component('contact_modal'); ?>
<?php $this->component('footer'); ?>
