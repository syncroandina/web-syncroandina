import os

filepath = 'e:/CLIENTES/SYNCRO ANDINA/web-syncroandina/app/controllers/AdminController.php'
with open(filepath, 'r', encoding='utf-8') as f:
    content = f.read()

methods = """
    // --- Productos / Repuestos ---
    public function adminProducts() {
        $productModel = new \\App\\Models\\Product();
        $settingModel = new \\App\\Models\\Setting();
        $products = $productModel->all('sort_order ASC, created_at DESC');
        $settings = $settingModel->getAll();
        
        // Cargar galería para cada producto
        $galleryModel = new \\App\\Models\\ProductGallery();
        foreach ($products as &$product) {
            $product['gallery'] = $galleryModel->getByProduct($product['id']);
        }
        
        return $this->adminView('products/index', [
            'title' => 'Gestión de Repuestos',
            'products' => $products,
            'settings' => $settings
        ]);
    }

    public function saveProductSettings() {
        if (!\\Core\\Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            die('Invalid CSRF token');
        }

        $settingModel = new \\App\\Models\\Setting();
        $keys = ['products_label', 'products_title', 'products_description', 'page_products_title', 'page_products_description'];

        foreach ($keys as $key) {
            $value = \\Core\\Security::sanitizeInput($_POST[$key] ?? '');
            $settingModel->updateSetting($key, $value);
        }

        header('Location: /admin/repuestos?success=settings_saved');
        exit;
    }

    public function saveProduct() {
        if (!\\Core\\Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            die('Invalid CSRF token');
        }

        $id = $_POST['id'] ?? null;
        $productModel = new \\App\\Models\\Product();
        $oldProduct = $id ? $productModel->find($id) : null;

        $data = [
            'title' => \\Core\\Security::sanitizeInput($_POST['title'] ?? ''),
            'slug' => \\Core\\Security::sanitizeInput($_POST['slug'] ?? ''),
            'description' => \\Core\\Security::sanitizeHTML($_POST['description'] ?? ''),
            'technical_details' => \\Core\\Security::sanitizeHTML($_POST['technical_details'] ?? ''),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'image_alt' => \\Core\\Security::sanitizeInput($_POST['image_alt'] ?? '')
        ];

        if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] === UPLOAD_ERR_OK) {
            $newPath = \\Core\\FileHelper::upload($_FILES['main_image'], 'assets/images/products/', ['webp', 'jpg', 'jpeg', 'png']);
            if ($newPath) {
                if ($oldProduct && !empty($oldProduct['main_image'])) {
                    \\Core\\FileHelper::delete($oldProduct['main_image']);
                }
                $data['main_image'] = $newPath;
            }
        }

        if ($id) $data['id'] = $id;
        $productId = $productModel->save($data);
        if (!$productId) $productId = $id;

        // Guardar Galería (Imágenes nuevas)
        $galleryModel = new \\App\\Models\\ProductGallery();
        if (isset($_FILES['gallery_images'])) {
            $files = $_FILES['gallery_images'];
            for ($i = 0; $i < count($files['name']); $i++) {
                if ($files['error'][$i] === UPLOAD_ERR_OK) {
                    $file = [
                        'name' => $files['name'][$i],
                        'type' => $files['type'][$i],
                        'tmp_name' => $files['tmp_name'][$i],
                        'error' => $files['error'][$i],
                        'size' => $files['size'][$i]
                    ];
                    $path = \\Core\\FileHelper::upload($file, 'assets/images/products/gallery/', ['webp', 'jpg', 'jpeg', 'png']);
                    if ($path) {
                        $galleryModel->save([
                            'product_id' => $productId,
                            'image_path' => $path,
                            'order_index' => 99
                        ]);
                    }
                }
            }
        }

        // Actualizar ALT de imágenes existentes en Galería
        if (isset($_POST['product_gallery_alts']) && is_array($_POST['product_gallery_alts'])) {
            foreach ($_POST['product_gallery_alts'] as $galleryImgId => $altText) {
                $galleryModel->save([
                    'id' => (int)$galleryImgId,
                    'image_alt' => \\Core\\Security::sanitizeInput($altText)
                ]);
            }
        }

        header('Location: /admin/repuestos?success=product_saved');
        exit;
    }

    public function deleteProduct() {
        if (!\\Core\\Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            die('Invalid CSRF token');
        }

        $id = $_POST['id'] ?? null;
        if ($id) {
            $productModel = new \\App\\Models\\Product();
            $product = $productModel->find($id);
            if ($product) {
                if (!empty($product['main_image'])) {
                    \\Core\\FileHelper::delete($product['main_image']);
                }
                $productModel->delete($id);
            }
        }

        header('Location: /admin/repuestos?success=product_deleted');
        exit;
    }

    public function duplicateProduct() {
        if (!\\Core\\Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            die('Invalid CSRF token');
        }

        $id = $_POST['id'] ?? null;
        if ($id) {
            $productModel = new \\App\\Models\\Product();
            $product = $productModel->getFullDetails($id);
            if ($product) {
                $newImagePath = null;
                if (!empty($product['main_image'])) {
                    $cleanPath = explode('?', $product['main_image'])[0];
                    $sourceFile = __DIR__ . '/../public' . $cleanPath;
                    if (file_exists($sourceFile) && is_file($sourceFile)) {
                        $extension = strtolower(pathinfo($cleanPath, PATHINFO_EXTENSION));
                        $folder = 'assets/images/products/';
                        $uploadDir = __DIR__ . '/../public/' . $folder;
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0755, true);
                        }
                        $newFileName = bin2hex(random_bytes(8)) . '.' . $extension;
                        $destFile = $uploadDir . $newFileName;
                        if (copy($sourceFile, $destFile)) {
                            $newImagePath = '/' . $folder . $newFileName;
                        }
                    }
                }

                $newSlug = $product['slug'] . '-copia-' . bin2hex(random_bytes(2));

                $productData = [
                    'title' => $product['title'] . ' (Copia)',
                    'slug' => $newSlug,
                    'description' => $product['description'],
                    'technical_details' => $product['technical_details'],
                    'main_image' => $newImagePath ?: $product['main_image'],
                    'is_active' => 0,
                    'image_alt' => $product['image_alt'] ?? null
                ];

                $newProductId = $productModel->save($productData);

                if ($newProductId) {
                    if (!empty($product['gallery'])) {
                        $galleryModel = new \\App\\Models\\ProductGallery();
                        foreach ($product['gallery'] as $galleryItem) {
                            $newGalleryPath = null;
                            if (!empty($galleryItem['image_path'])) {
                                $cleanGalPath = explode('?', $galleryItem['image_path'])[0];
                                $sourceGalFile = __DIR__ . '/../public' . $cleanGalPath;
                                if (file_exists($sourceGalFile) && is_file($sourceGalFile)) {
                                    $extension = strtolower(pathinfo($cleanGalPath, PATHINFO_EXTENSION));
                                    $folder = 'assets/images/products/gallery/';
                                    $uploadDir = __DIR__ . '/../public/' . $folder;
                                    if (!is_dir($uploadDir)) {
                                        mkdir($uploadDir, 0755, true);
                                    }
                                    $newFileName = bin2hex(random_bytes(8)) . '.' . $extension;
                                    $destFile = $uploadDir . $newFileName;
                                    if (copy($sourceGalFile, $destFile)) {
                                        $newGalleryPath = '/' . $folder . $newFileName;
                                    }
                                }
                            }

                            $galleryModel->save([
                                'product_id' => $newProductId,
                                'image_path' => $newGalleryPath ?: $galleryItem['image_path'],
                                'order_index' => $galleryItem['order_index']
                            ]);
                        }
                    }
                }
            }
        }

        header('Location: /admin/repuestos?success=product_duplicated');
        exit;
    }

    public function toggleProductStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $id = $data['id'] ?? null;
            $status = $data['status'] ?? 0;

            if ($id) {
                $productModel = new \\App\\Models\\Product();
                $productModel->save(['id' => $id, 'is_active' => $status]);
                echo json_encode(['success' => true]);
                exit;
            }
        }
        http_response_code(400);
        echo json_encode(['success' => false]);
        exit;
    }

    public function reorderProducts() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            if(isset($data['order']) && is_array($data['order'])) {
                $productModel = new \\App\\Models\\Product();
                foreach($data['order'] as $index => $id) {
                    $productModel->save(['id' => $id, 'sort_order' => $index + 1]);
                }
                echo json_encode(['success' => true]);
                exit;
            }
        }
        http_response_code(400);
        echo json_encode(['success' => false]);
        exit;
    }

    public function deleteProductGalleryImage() {
        if (!\\Core\\Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            die('Invalid CSRF token');
        }

        $id = $_POST['id'] ?? null;
        if ($id) {
            $galleryModel = new \\App\\Models\\ProductGallery();
            $image = $galleryModel->find($id);
            if ($image) {
                \\Core\\FileHelper::delete($image['image_path']);
                $galleryModel->delete($id);
            }
        }

        echo json_encode(['success' => true]);
        exit;
    }
}
"""

content = content.replace("    }\n}\n", "    }\n" + methods)

with open(filepath, 'w', encoding='utf-8') as f:
    f.write(content)

print("Done")
