import re
import os

filepath = r'e:\CLIENTES\SYNCRO ANDINA\web-syncroandina\app\controllers\PageController.php'
with open(filepath, 'r', encoding='utf-8') as f:
    content = f.read()

# Add use App\Models\Analytics;
if 'use App\\Models\\Analytics;' not in content:
    content = content.replace('use Core\\Controller;', 'use Core\\Controller;\nuse App\\Models\\Analytics;')

# Map of methods to tracking info
tracking = {
    'about': "        (new Analytics())->logPageView('about', null, $_SERVER['REQUEST_URI'] ?? '/nosotros', $_SERVER['REMOTE_ADDR'] ?? '', $_SERVER['HTTP_USER_AGENT'] ?? '');\n",
    'services': "        (new Analytics())->logPageView('services', null, $_SERVER['REQUEST_URI'] ?? '/servicios', $_SERVER['REMOTE_ADDR'] ?? '', $_SERVER['HTTP_USER_AGENT'] ?? '');\n",
    'projects': "        (new Analytics())->logPageView('projects', null, $_SERVER['REQUEST_URI'] ?? '/proyectos', $_SERVER['REMOTE_ADDR'] ?? '', $_SERVER['HTTP_USER_AGENT'] ?? '');\n",
    'products': "        (new Analytics())->logPageView('products', null, $_SERVER['REQUEST_URI'] ?? '/repuestos', $_SERVER['REMOTE_ADDR'] ?? '', $_SERVER['HTTP_USER_AGENT'] ?? '');\n",
    'blog': "        (new Analytics())->logPageView('blog_index', null, $_SERVER['REQUEST_URI'] ?? '/blog', $_SERVER['REMOTE_ADDR'] ?? '', $_SERVER['HTTP_USER_AGENT'] ?? '');\n",
    'contact': "        (new Analytics())->logPageView('contact', null, $_SERVER['REQUEST_URI'] ?? '/contacto', $_SERVER['REMOTE_ADDR'] ?? '', $_SERVER['HTTP_USER_AGENT'] ?? '');\n",
}

for method, track_str in tracking.items():
    pattern = r'(public function ' + method + r'\(\)\s*\{)'
    content = re.sub(pattern, r'\1\n' + track_str, content)

# Detail pages
# serviceDetail
content = re.sub(
    r"(\$service = !empty\(\$results\) \? \$results\[0\] : null;\s*if \(!\$service\) \{.*?\}\s*)\$service = \$serviceModel->getFullDetails\(\$service\['id'\]\);",
    r"\1(new Analytics())->logPageView('service', $service['id'], $_SERVER['REQUEST_URI'] ?? '', $_SERVER['REMOTE_ADDR'] ?? '', $_SERVER['HTTP_USER_AGENT'] ?? '');\n        $service = $serviceModel->getFullDetails($service['id']);",
    content, flags=re.DOTALL
)

# projectDetail
content = re.sub(
    r"(if \(!\$project \|\| !\$project\['is_active'\]\) \{.*?\}\s*)\$settings = \$settingModel->getAll\(\);",
    r"\1(new Analytics())->logPageView('project', $project['id'], $_SERVER['REQUEST_URI'] ?? '', $_SERVER['REMOTE_ADDR'] ?? '', $_SERVER['HTTP_USER_AGENT'] ?? '');\n        $settings = $settingModel->getAll();",
    content, flags=re.DOTALL
)

# productDetail
content = re.sub(
    r"(if \(!\$product \|\| !\$product\['is_active'\]\) \{.*?\}\s*)\$settings = \$settingModel->getAll\(\);",
    r"\1(new Analytics())->logPageView('product', $product['id'], $_SERVER['REQUEST_URI'] ?? '', $_SERVER['REMOTE_ADDR'] ?? '', $_SERVER['HTTP_USER_AGENT'] ?? '');\n        $settings = $settingModel->getAll();",
    content, flags=re.DOTALL
)

# blogDetail
content = re.sub(
    r"(if \(!\$post \|\| \$post\['status'\] !== 'published' \|\| !empty\(\$post\['deleted_at'\]\)\) \{.*?\}\s*)// Obtener posts relacionados",
    r"\1(new Analytics())->logPageView('blog', $post['id'], $_SERVER['REQUEST_URI'] ?? '', $_SERVER['REMOTE_ADDR'] ?? '', $_SERVER['HTTP_USER_AGENT'] ?? '');\n\n        // Obtener posts relacionados",
    content, flags=re.DOTALL
)

with open(filepath, 'w', encoding='utf-8') as f:
    f.write(content)
print("Updated PageController.php")
