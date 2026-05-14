
function switchProductTab(tab) {
    // Esconder todos los contenidos
    document.querySelectorAll('.product-tab-content').forEach(el => el.classList.add('hidden'));
    // Desactivar todos los botones de pestaña
    document.querySelectorAll('.product-tab-btn').forEach(btn => {
        btn.classList.remove('border-secondary', 'text-secondary');
        btn.classList.add('border-transparent', 'text-gray-400');
    });
    
    // Activar el correspondiente
    document.getElementById('content-' + tab).classList.remove('hidden');
    document.getElementById('tab-btn-' + tab).classList.remove('border-transparent', 'text-gray-400');
    document.getElementById('tab-btn-' + tab).classList.add('border-secondary', 'text-secondary');
}

function openProductModal() {
    document.getElementById('modal-title').textContent = 'Crear Nuevo Repuesto';
    document.getElementById('product-id').value = '';
    document.getElementById('product-title').value = '';
    document.getElementById('product-slug').value = '';
    document.getElementById('product-technical-details').value = '';
    document.getElementById('product-description').value = '';
    document.getElementById('product-image-alt').value = '';
    
    document.getElementById('product-is-active').checked = true;
    
    // Resetear vista de galería
    document.getElementById('product-gallery-container').innerHTML = '<div class="col-span-full py-8 text-center text-xs text-gray-400 italic">No hay fotos en la galería de este producto.</div>';
    
    // Reset image preview
    document.getElementById('product-image-preview').classList.add('hidden');
    document.getElementById('product-image-placeholder').classList.remove('hidden');
    
    // Volver a pestaña general
    switchProductTab('general');
    
    const modal = document.getElementById('product-modal');
    const container = document.getElementById('product-modal-container');
    modal.classList.remove('pointer-events-none', 'opacity-0');
    container.classList.remove('scale-95');
}

function closeProductModal() {
    const modal = document.getElementById('product-modal');
    const container = document.getElementById('product-modal-container');
    modal.classList.add('pointer-events-none', 'opacity-0');
    container.classList.add('scale-95');
}

function openSettingsModal() {
    const modal = document.getElementById('settings-modal');
    const container = document.getElementById('settings-modal-container');
    modal.classList.remove('pointer-events-none', 'opacity-0');
    container.classList.remove('scale-95');
}

function closeSettingsModal() {
    const modal = document.getElementById('settings-modal');
    const container = document.getElementById('settings-modal-container');
    modal.classList.add('pointer-events-none', 'opacity-0');
    container.classList.add('scale-95');
}

function editProduct(product) {
    document.getElementById('modal-title').textContent = 'Editar Repuesto';
    document.getElementById('product-id').value = product.id;
    document.getElementById('product-technical-details').value = product.technical_details || '';
    document.getElementById('product-title').value = product.title;
    document.getElementById('product-slug').value = product.slug;
    document.getElementById('product-description').value = product.description || '';
    document.getElementById('product-image-alt').value = product.image_alt || '';
    
    document.getElementById('product-is-active').checked = parseInt(product.is_active) === 1;
    
    if (product.main_image) {
        document.getElementById('product-image-preview').src = '/' + product.main_image;
        document.getElementById('product-image-preview').classList.remove('hidden');
        document.getElementById('product-image-placeholder').classList.add('hidden');
    } else {
        document.getElementById('product-image-preview').classList.add('hidden');
        document.getElementById('product-image-placeholder').classList.remove('hidden');
    }
    
    // Cargar fotos de la galería
    const galleryContainer = document.getElementById('product-gallery-container');
    galleryContainer.innerHTML = '';
    
    if (product.gallery && product.gallery.length > 0) {
        product.gallery.forEach(img => {
            const div = document.createElement('div');
            div.className = 'relative group bg-white rounded-xl overflow-hidden border border-gray-200 shadow-sm flex flex-col';
            div.innerHTML = `
                <div class="relative h-24 overflow-hidden bg-gray-50">
                    <img src="/${img.image_path}" class="w-full h-full object-cover">
                    <button type="button" onclick="deleteProductGalleryImage(${img.id}, this)" class="absolute top-1 right-1 w-6 h-6 bg-red-600 hover:bg-red-700 text-white rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-sm" title="Borrar Foto">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
                <div class="p-2 bg-gray-50/50 border-t border-gray-100">
                    <input type="text" name="product_gallery_alts[${img.id}]" value="${img.image_alt || ''}" placeholder="SEO ALT" class="w-full px-1.5 py-1 text-[9px] border border-gray-200 rounded focus:outline-none focus:border-secondary" title="Texto descriptivo para SEO">
                </div>
            `;
            galleryContainer.appendChild(div);
        });
    } else {
        galleryContainer.innerHTML = '<div class="col-span-full py-8 text-center text-xs text-gray-400 italic">No hay fotos en la galería de este producto.</div>';
    }
    
    // Volver a pestaña general
    switchProductTab('general');
    
    const modal = document.getElementById('product-modal');
    const container = document.getElementById('product-modal-container');
    modal.classList.remove('pointer-events-none', 'opacity-0');
    container.classList.remove('scale-95');
}

function generateProductSlug() {
    const title = document.getElementById('product-title').value;
    const slug = title.toLowerCase()
        .replace(/[^a-z0-9 -]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');
    document.getElementById('product-slug').value = slug;
}

function previewProductImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('product-image-preview').src = e.target.result;
            document.getElementById('product-image-preview').classList.remove('hidden');
            document.getElementById('product-image-placeholder').classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }
}

function previewProductGallery(input) {
    const galleryContainer = document.getElementById('product-gallery-container');
    // Si sólo había el mensaje de "no hay fotos", lo removemos
    if (galleryContainer.querySelector('.col-span-full')) {
        galleryContainer.innerHTML = '';
    }
    
    if (input.files) {
        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative aspect-square bg-gray-100 rounded-xl overflow-hidden group border border-gray-100 shadow-sm opacity-70';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-full object-cover">
                    <span class="absolute bottom-1 left-1 bg-black/60 text-[9px] text-white px-1.5 py-0.5 rounded font-black uppercase">Nueva</span>
                `;
                galleryContainer.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }
}

async function deleteProductGalleryImage(id, btn) {
    if (!confirm('¿Seguro que deseas eliminar esta foto de la galería?')) return;
    
    try {
        const formData = new FormData();
        formData.append('id', id);
        formData.append('csrf_token', 'foo');
        
        const response = await fetch('foo', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        if (result.success) {
            const container = btn.closest('.relative');
            container.remove();
            
            // Si ya no quedan fotos, mostrar mensaje vacío
            const galleryContainer = document.getElementById('product-gallery-container');
            if (galleryContainer.children.length === 0) {
                galleryContainer.innerHTML = '<div class="col-span-full py-8 text-center text-xs text-gray-400 italic">No hay fotos en la galería de este producto.</div>';
            }
        } else {
            alert('Error al intentar eliminar la imagen.');
        }
    } catch(err) {
        console.error(err);
        alert('Ocurrió un error en el servidor.');
    }
}

function filterProducts() {
    const search = document.getElementById('search-products').value.toLowerCase();
    const rows = document.querySelectorAll('.product-row');
    rows.forEach(row => {
        const title = row.getAttribute('data-title');
        const client = row.getAttribute('data-client');
        if (title.includes(search) || client.includes(search)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
