import os

src_projects = 'e:/CLIENTES/SYNCRO ANDINA/web-syncroandina/app/views/pages/projects.php'
dest_products = 'e:/CLIENTES/SYNCRO ANDINA/web-syncroandina/app/views/pages/products.php'

src_project_detail = 'e:/CLIENTES/SYNCRO ANDINA/web-syncroandina/app/views/pages/project_detail.php'
dest_product_detail = 'e:/CLIENTES/SYNCRO ANDINA/web-syncroandina/app/views/pages/product_detail.php'

# Create products.php
with open(src_projects, 'r', encoding='utf-8') as f:
    content = f.read()

content = content.replace('proyectos', 'repuestos')
content = content.replace('Proyectos', 'Repuestos')
content = content.replace('proyecto', 'repuesto')
content = content.replace('Proyecto', 'Repuesto')
content = content.replace('projects', 'products')
content = content.replace('project', 'product')
content = content.replace('Project', 'Product')
content = content.replace("['client']", "['technical_details']")

with open(dest_products, 'w', encoding='utf-8') as f:
    f.write(content)

# Create product_detail.php
with open(src_project_detail, 'r', encoding='utf-8') as f:
    content = f.read()

content = content.replace('proyectos', 'repuestos')
content = content.replace('Proyectos', 'Repuestos')
content = content.replace('proyecto', 'repuesto')
content = content.replace('Proyecto', 'Repuesto')
content = content.replace('projects', 'products')
content = content.replace('project', 'product')
content = content.replace('Project', 'Product')
content = content.replace('Reto', 'Especificaciones')
content = content.replace('Solución', 'Descripción')

# Clean up impact and other unnecessary fields
content = content.replace("""<?php if(!empty($product['client'])): ?>
                                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white text-sm font-semibold">
                                        <svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        <?= htmlspecialchars($product['client']) ?>
                                    </div>
                                <?php endif; ?>""", "")

content = content.replace("""<?php if(!empty($product['completion_date'])): ?>
                                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white text-sm font-semibold">
                                        <svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <?= date('M Y', strtotime($product['completion_date'])) ?>
                                    </div>
                                <?php endif; ?>""", "")

content = content.replace("""<div class="bg-gray-50 rounded-3xl p-8 lg:p-12 mb-16 animate-fade-in-up" style="animation-delay: 200ms;">
            <div class="grid md:grid-cols-2 gap-12 lg:gap-24">
                <?php if(!empty($product['challenge_desc'])): ?>
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-3">
                        <span class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </span>
                        <?= htmlspecialchars($product['challenge_title'] ?: 'Especificaciones') ?>
                    </h3>
                    <div class="prose max-w-none text-gray-600">
                        <?= nl2br(htmlspecialchars($product['challenge_desc'])) ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if(!empty($product['solution_desc'])): ?>
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-3">
                        <span class="w-10 h-10 rounded-xl bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </span>
                        <?= htmlspecialchars($product['solution_title'] ?: 'Descripción') ?>
                    </h3>
                    <div class="prose max-w-none text-gray-600">
                        <?= nl2br(htmlspecialchars($product['solution_desc'])) ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <?php if(!empty($product['impact_value'])): ?>
            <div class="mt-12 pt-12 border-t border-gray-200 text-center">
                <span class="block text-sm font-bold uppercase tracking-widest text-gray-400 mb-3"><?= htmlspecialchars($product['impact_label'] ?: 'Impacto Logrado') ?></span>
                <span class="text-4xl md:text-5xl font-black text-secondary"><?= htmlspecialchars($product['impact_value']) ?></span>
            </div>
            <?php endif; ?>
        </div>""", """
        <div class="bg-gray-50 rounded-3xl p-8 lg:p-12 mb-16 animate-fade-in-up" style="animation-delay: 200ms;">
            <div class="grid md:grid-cols-2 gap-12 lg:gap-24">
                <?php if(!empty($product['technical_details'])): ?>
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-3">
                        <span class="w-10 h-10 rounded-xl bg-blue-100 text-secondary flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                        </span>
                        Detalles Técnicos
                    </h3>
                    <div class="prose max-w-none text-gray-600">
                        <?= nl2br(htmlspecialchars($product['technical_details'])) ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if(!empty($product['description'])): ?>
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-3">
                        <span class="w-10 h-10 rounded-xl bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                        </span>
                        Descripción General
                    </h3>
                    <div class="prose max-w-none text-gray-600">
                        <?= nl2br(htmlspecialchars($product['description'])) ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
""")

with open(dest_product_detail, 'w', encoding='utf-8') as f:
    f.write(content)

print("Created products public views")
