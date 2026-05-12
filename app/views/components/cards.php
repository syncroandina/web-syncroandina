<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    <?php if(!empty($services)): ?>
        <?php foreach($services as $index => $service): ?>
        <div class="group bg-white rounded-[2rem] shadow-sm hover:shadow-2xl transition-all duration-500 border border-gray-100 overflow-hidden flex flex-col h-full animate-fade-in-up" style="animation-delay: <?= $index * 100 ?>ms;">
            <!-- Imagen del Servicio -->
            <div class="relative h-64 overflow-hidden">
                <img src="<?= htmlspecialchars($service['image'] ?: asset('assets/img/service-placeholder.jpg')) ?>" 
                     alt="<?= htmlspecialchars($service['image_alt'] ?: $service['title']) ?>" 
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
            </div>

            <div class="p-8 flex flex-col flex-grow">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-primary transition-colors">
                    <?= htmlspecialchars($service['title']) ?>
                </h2>
                
                <p class="text-gray-600 mb-8 leading-relaxed line-clamp-3">
                    <?= htmlspecialchars(strip_tags($service['content'])) ?>
                </p>
                
                <div class="mt-auto">
                    <a href="/servicios/<?= $service['slug'] ?>" class="inline-flex items-center text-sm font-bold text-secondary hover:gap-3 transition-all duration-300">
                        Ver Detalles
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <!-- Fallback si no hay servicios en DB -->
        <div class="col-span-full text-center py-20 bg-gray-50 rounded-3xl border border-dashed border-gray-200">
            <p class="text-gray-400 font-medium">No hay servicios configurados aún.</p>
        </div>
    <?php endif; ?>
</div>
