import os

src = 'e:/CLIENTES/SYNCRO ANDINA/web-syncroandina/app/views/admin/projects/index.php'
dest_dir = 'e:/CLIENTES/SYNCRO ANDINA/web-syncroandina/app/views/admin/products'
dest = dest_dir + '/index.php'

os.makedirs(dest_dir, exist_ok=True)

with open(src, 'r', encoding='utf-8') as f:
    content = f.read()

# Replacements
content = content.replace('proyectos', 'repuestos')
content = content.replace('Proyectos', 'Repuestos')
content = content.replace('proyecto', 'producto')
content = content.replace('Proyecto', 'Repuesto')
content = content.replace('projects', 'products')
content = content.replace('project', 'product')
content = content.replace('Project', 'Product')

# Fix specific fields
# Product model doesn't have completion_date or client. It has technical_details instead of challenge_desc, etc.
content = content.replace('project.client', '""')
content = content.replace('project.completion_date', '""')
content = content.replace('project.challenge_title', '""')
content = content.replace('project.challenge_desc', '""')
content = content.replace('project.solution_title', '""')
content = content.replace('project.solution_desc', '""')
content = content.replace('project.impact_label', '""')
content = content.replace('project.impact_value', '""')

content = content.replace("document.getElementById('product-client').value = ''", "")
content = content.replace("document.getElementById('product-completion-date').value = ''", "")
content = content.replace("document.getElementById('product-challenge-title').value = 'El Reto'", "")
content = content.replace("document.getElementById('product-challenge-desc').value = ''", "")
content = content.replace("document.getElementById('product-solution-title').value = 'La Solución'", "")
content = content.replace("document.getElementById('product-solution-desc').value = ''", "")
content = content.replace("document.getElementById('product-impact-label').value = 'Impacto Logrado'", "")
content = content.replace("document.getElementById('product-impact-value').value = '100% Optimizado'", "")

# Update HTML form fields
content = content.replace('id="product-client"', 'id="product-client" style="display:none;"')
content = content.replace('id="product-completion-date"', 'id="product-completion-date" style="display:none;"')

# Change "Reto & Solución" to "Detalles Técnicos"
content = content.replace('Reto & Solución', 'Detalles Técnicos')
# Replace the inputs inside content-custom with a single technical_details textarea
content = content.replace('id="product-challenge-title"', 'id="product-challenge-title" style="display:none;"')
content = content.replace('id="product-solution-title"', 'id="product-solution-title" style="display:none;"')
content = content.replace('id="product-challenge-desc"', 'id="product-challenge-desc" style="display:none;"')
content = content.replace('id="product-solution-desc"', 'id="product-solution-desc" style="display:none;"')
content = content.replace('id="product-impact-label"', 'id="product-impact-label" style="display:none;"')
content = content.replace('id="product-impact-value"', 'id="product-impact-value" style="display:none;"')

technical_html = """
                <div>
                    <label class="block text-xs font-extrabold uppercase tracking-widest text-gray-500 mb-2">Detalles Técnicos</label>
                    <textarea name="technical_details" id="product-technical-details" rows="6" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-sm font-medium transition-shadow resize-none" placeholder="Escribe los detalles técnicos del repuesto..."></textarea>
                </div>
"""
content = content.replace('<!-- Contenido Pestaña: Campos Personalizados (Reto y Solución) -->', '<!-- Contenido Pestaña: Detalles Técnicos -->')
content = content.replace('<div id="content-custom" class="product-tab-content hidden space-y-6">', '<div id="content-custom" class="product-tab-content hidden space-y-6">' + technical_html)

content = content.replace("document.getElementById('product-id').value = product.id;", "document.getElementById('product-id').value = product.id;\\n    document.getElementById('product-technical-details').value = product.technical_details || '';")
content = content.replace("document.getElementById('product-slug').value = '';", "document.getElementById('product-slug').value = '';\\n    document.getElementById('product-technical-details').value = '';")


with open(dest, 'w', encoding='utf-8') as f:
    f.write(content)

print("Created products/index.php")
