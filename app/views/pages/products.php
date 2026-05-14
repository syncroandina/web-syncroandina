<?php $this->component('header', ['title' => $title ?? 'Repuestos']); ?>
<?php $this->component('navbar'); ?>

<main class="min-h-screen bg-gray-50 pt-20 pb-32">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-3xl mx-auto mb-20 animate-fade-in-up">
            <h1 class="text-4xl md:text-5xl font-extrabold text-primary mb-6"><?= htmlspecialchars($settings['products_page_title'] ?? 'Nuestros Repuestos') ?></h1>
            <p class="text-xl text-gray-600"><?= htmlspecialchars($settings['products_page_subtitle'] ?? 'Encuentra componentes y repuestos de la más alta calidad para asegurar el rendimiento de tus equipos.') ?></p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if(!empty($products)): ?>
                <?php foreach($products as $index => $product): ?>
                <a href="/repuestos/<?= htmlspecialchars($product['slug']) ?>" class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl border border-gray-100 transition-all duration-300 animate-fade-in-up flex flex-col" style="animation-delay: <?= $index * 100 ?>ms;">
                    <div class="relative bg-gray-100 overflow-hidden border-b border-gray-100 aspect-w-4 aspect-h-3">
                        <img src="<?= htmlspecialchars($product['main_image']) ?>" alt="<?= htmlspecialchars($product['image_alt'] ?: $product['title']) ?>" loading="lazy" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <h2 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-primary transition-colors"><?= htmlspecialchars($product['title']) ?></h2>
                        <p class="text-gray-500 text-sm line-clamp-2 mb-4 flex-1"><?= htmlspecialchars($product['description']) ?></p>
                        <div class="flex items-center text-sm font-bold text-primary group-hover:text-secondary transition-colors mt-auto pt-4 border-t border-gray-100/50">
                            Ver detalles
                            <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full text-center py-20">
                    <p class="text-gray-500 text-lg">Próximamente publicaremos nuestro catálogo de repuestos.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php $this->component('footer'); ?>
