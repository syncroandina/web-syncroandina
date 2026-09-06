<?php
namespace App\Models;

use Core\Model;
use PDO;

class Service extends Model {
    protected $table = 'services_pages';

    public function getActive($limit = null) {
        $order = 'sort_order ASC, id ASC';
        if ($limit) {
            $order .= " LIMIT " . (int)$limit;
        }
        return $this->where('is_active', 1, '=', $order);
    }

    public function getFullDetails($id) {
        try {
            $this->db->exec("ALTER TABLE services_pages ADD COLUMN heading_projects VARCHAR(255) DEFAULT 'Proyectos relacionados'");
        } catch (\PDOException $e) {}
        try {
            $this->db->exec("ALTER TABLE services_pages ADD COLUMN related_projects_json TEXT NULL");
        } catch (\PDOException $e) {}

        $service = $this->find($id);
        if ($service) {
            $itemModel = new ServiceItem();
            $galleryModel = new ServiceGallery();
            $service['items'] = $itemModel->getByService($id);
            $service['gallery'] = $galleryModel->getByService($id);

            // Decodificar campos JSON estructurados
            $service['types'] = !empty($service['types_json']) ? json_decode($service['types_json'], true) : [];
            $service['benefits'] = !empty($service['benefits_json']) ? json_decode($service['benefits_json'], true) : [];
            $service['process'] = !empty($service['process_json']) ? json_decode($service['process_json'], true) : [];
            $service['faqs'] = !empty($service['faqs_json']) ? json_decode($service['faqs_json'], true) : [];
            
            // Obtener servicios relacionados
            $relatedIds = !empty($service['related_services_json']) ? json_decode($service['related_services_json'], true) : [];
            $service['related_services'] = [];
            if (!empty($relatedIds) && is_array($relatedIds)) {
                $placeholders = implode(',', array_fill(0, count($relatedIds), '?'));
                $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id IN ($placeholders) AND is_active = 1");
                $stmt->execute($relatedIds);
                $fetched = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $indexed = [];
                foreach ($fetched as $s) { $indexed[$s['id']] = $s; }
                foreach ($relatedIds as $rId) {
                    if (isset($indexed[$rId])) { $service['related_services'][] = $indexed[$rId]; }
                }
            }

            // Obtener proyectos relacionados
            $relatedProjectIds = !empty($service['related_projects_json']) ? json_decode($service['related_projects_json'], true) : [];
            $service['related_projects'] = [];
            if (!empty($relatedProjectIds) && is_array($relatedProjectIds)) {
                $placeholders = implode(',', array_fill(0, count($relatedProjectIds), '?'));
                $stmt = $this->db->prepare("SELECT * FROM projects WHERE id IN ($placeholders) AND is_active = 1");
                $stmt->execute($relatedProjectIds);
                $fetchedP = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $indexedP = [];
                foreach ($fetchedP as $p) { $indexedP[$p['id']] = $p; }
                foreach ($relatedProjectIds as $pId) {
                    if (isset($indexedP[$pId])) { $service['related_projects'][] = $indexedP[$pId]; }
                }
            }
        }
        return $service;
    }
}
