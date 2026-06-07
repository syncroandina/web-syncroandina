<?php
namespace App\Models;

use Core\Model;

class Analytics extends Model {
    protected $table = 'page_views';

    public function logPageView($pageType, $entityId, $url, $ip, $userAgent) {
        if (isset($_SESSION['user'])) {
            return true;
        }
        $stmt = $this->db->prepare("INSERT INTO page_views (page_type, entity_id, url, ip_address, user_agent) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$pageType, $entityId, $url, $ip, $userAgent]);
    }

    public function logInteraction($type, $url, $ip) {
        if (isset($_SESSION['user'])) {
            return true;
        }
        $stmt = $this->db->prepare("INSERT INTO interactions (interaction_type, url, ip_address) VALUES (?, ?, ?)");
        return $stmt->execute([$type, $url, $ip]);
    }

    public function getMetricsSummary($startDate, $endDate) {
        $queryViews = "SELECT COUNT(*) as total FROM page_views WHERE created_at BETWEEN ? AND ?";
        $stmtViews = $this->db->prepare($queryViews);
        $stmtViews->execute([$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        $totalViews = $stmtViews->fetch()['total'];

        $queryBlogViews = "SELECT COUNT(*) as total FROM page_views WHERE page_type = 'blog' AND created_at BETWEEN ? AND ?";
        $stmtBlog = $this->db->prepare($queryBlogViews);
        $stmtBlog->execute([$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        $totalBlogViews = $stmtBlog->fetch()['total'];

        $queryWhatsapp = "SELECT COUNT(*) as total FROM interactions WHERE interaction_type = 'whatsapp' AND created_at BETWEEN ? AND ?";
        $stmtWhatsapp = $this->db->prepare($queryWhatsapp);
        $stmtWhatsapp->execute([$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        $totalWhatsapp = $stmtWhatsapp->fetch()['total'];

        $queryPhone = "SELECT COUNT(*) as total FROM interactions WHERE interaction_type = 'phone' AND created_at BETWEEN ? AND ?";
        $stmtPhone = $this->db->prepare($queryPhone);
        $stmtPhone->execute([$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        $totalPhone = $stmtPhone->fetch()['total'];

        $queryLeads = "SELECT COUNT(*) as total FROM contacts WHERE created_at BETWEEN ? AND ?";
        $stmtLeads = $this->db->prepare($queryLeads);
        $stmtLeads->execute([$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        $totalLeads = $stmtLeads->fetch()['total'];

        return [
            'views' => $totalViews,
            'blog_views' => $totalBlogViews,
            'whatsapp' => $totalWhatsapp,
            'phone' => $totalPhone,
            'leads' => $totalLeads
        ];
    }

    public function getDailyMetrics($startDate, $endDate) {
        $period = new \DatePeriod(
            new \DateTime($startDate),
            new \DateInterval('P1D'),
            (new \DateTime($endDate))->modify('+1 day')
        );

        $dailyData = [];
        foreach ($period as $value) {
            $dateStr = $value->format('Y-m-d');
            $dailyData[$dateStr] = [
                'date' => $dateStr,
                'views' => 0,
                'blog_views' => 0,
                'leads' => 0,
                'whatsapp' => 0,
                'phone' => 0
            ];
        }

        $qViews = "SELECT DATE(created_at) as date, COUNT(*) as total, SUM(CASE WHEN page_type = 'blog' THEN 1 ELSE 0 END) as blog_total FROM page_views WHERE created_at BETWEEN ? AND ? GROUP BY DATE(created_at)";
        $stmtViews = $this->db->prepare($qViews);
        $stmtViews->execute([$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        foreach ($stmtViews->fetchAll() as $row) {
            if (isset($dailyData[$row['date']])) {
                $dailyData[$row['date']]['views'] = (int)$row['total'];
                $dailyData[$row['date']]['blog_views'] = (int)$row['blog_total'];
            }
        }

        $qLeads = "SELECT DATE(created_at) as date, COUNT(*) as total FROM contacts WHERE created_at BETWEEN ? AND ? GROUP BY DATE(created_at)";
        $stmtLeads = $this->db->prepare($qLeads);
        $stmtLeads->execute([$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        foreach ($stmtLeads->fetchAll() as $row) {
            if (isset($dailyData[$row['date']])) {
                $dailyData[$row['date']]['leads'] = (int)$row['total'];
            }
        }

        $qInteractions = "SELECT DATE(created_at) as date, 
                                 SUM(CASE WHEN interaction_type = 'whatsapp' THEN 1 ELSE 0 END) as whatsapp_total,
                                 SUM(CASE WHEN interaction_type = 'phone' THEN 1 ELSE 0 END) as phone_total 
                          FROM interactions 
                          WHERE created_at BETWEEN ? AND ? 
                          GROUP BY DATE(created_at)";
        $stmtInteractions = $this->db->prepare($qInteractions);
        $stmtInteractions->execute([$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        foreach ($stmtInteractions->fetchAll() as $row) {
            if (isset($dailyData[$row['date']])) {
                $dailyData[$row['date']]['whatsapp'] = (int)$row['whatsapp_total'];
                $dailyData[$row['date']]['phone'] = (int)$row['phone_total'];
            }
        }

        return array_values($dailyData);
    }


    public function getTopServices($startDate, $endDate, $limit = 5) {
        $query = "SELECT s.title, s.slug, s.image, COUNT(p.id) as visits 
                  FROM page_views p 
                  JOIN services_pages s ON p.entity_id = s.id 
                  WHERE p.page_type = 'service' AND p.created_at BETWEEN ? AND ? 
                  GROUP BY p.entity_id 
                  ORDER BY visits DESC LIMIT ?";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, $startDate . ' 00:00:00');
        $stmt->bindValue(2, $endDate . ' 23:59:59');
        $stmt->bindValue(3, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getTopArticles($startDate, $endDate, $limit = 5) {
        $query = "SELECT b.title, b.slug, b.image, COUNT(p.id) as visits 
                  FROM page_views p 
                  JOIN blog_posts b ON p.entity_id = b.id 
                  WHERE p.page_type = 'blog' AND b.deleted_at IS NULL AND p.created_at BETWEEN ? AND ? 
                  GROUP BY p.entity_id 
                  ORDER BY visits DESC LIMIT ?";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, $startDate . ' 00:00:00');
        $stmt->bindValue(2, $endDate . ' 23:59:59');
        $stmt->bindValue(3, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
