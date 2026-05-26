<?php
/**
 * Simplified Dashboard Stats using MySQLi (Full Key Support)
 */
require_once dirname(__DIR__, 2) . '/config/database.php';

function sathi_admin_dashboard_stats()
{
    $db = sathi_db();
    
    $stats = [
        'total' => 0,
        'pending' => 0,
        'approved' => 0,
        'paid' => 0,
        'rejected' => 0,
        'revenue' => 0.0,
        'recent_regs' => 0,
        'recent_payments' => 0.0,
        'photos_queue' => 0,
        'horoscope_queue' => 0
    ];

    // Basic Counts
    $res = $db->query("SELECT status, COUNT(*) as cnt FROM users GROUP BY status");
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            if ($row['status'] === 'pending') $stats['pending'] = (int)$row['cnt'];
            if ($row['status'] === 'approved') $stats['approved'] = (int)$row['cnt'];
            if ($row['status'] === 'rejected') $stats['rejected'] = (int)$row['cnt'];
        }
    }
    
    $res = $db->query("SELECT COUNT(*) FROM users");
    $stats['total'] = (int)($res ? $res->fetch_row()[0] : 0);

    $res = $db->query("SELECT COUNT(*) FROM users WHERE paid_member = 1");
    $stats['paid'] = (int)($res ? $res->fetch_row()[0] : 0);

    // Revenue (using 'success' status from your schema)
    $res = $db->query("SELECT SUM(amount) FROM payments WHERE status = 'success'");
    $stats['revenue'] = (float)($res ? $res->fetch_row()[0] : 0.0);

    // Recent Regs (7 days)
    $res = $db->query("SELECT COUNT(*) FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
    $stats['recent_regs'] = (int)($res ? $res->fetch_row()[0] : 0);

    // Recent Payments (7 days)
    $res = $db->query("SELECT SUM(amount) FROM payments WHERE status = 'success' AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
    $stats['recent_payments'] = (float)($res ? $res->fetch_row()[0] : 0.0);

    // Photos Queue (Pending users with profile photos)
    $res = $db->query("SELECT COUNT(*) FROM users WHERE status = 'pending' AND profile_photo IS NOT NULL AND profile_photo != ''");
    $stats['photos_queue'] = (int)($res ? $res->fetch_row()[0] : 0);

    // Horoscope Queue (Approximated by pending payments)
    $res = $db->query("SELECT COUNT(*) FROM payments WHERE status = 'pending'");
    $stats['horoscope_queue'] = (int)($res ? $res->fetch_row()[0] : 0);

    // Chart Data for Registrations
    $chartData = [
        'weekly' => ['labels' => [], 'data' => []],
        'monthly' => ['labels' => [], 'data' => []],
        'yearly' => ['labels' => [], 'data' => []],
    ];

    // Weekly (Last 7 Days)
    $res = $db->query("SELECT DATE(created_at) as d, COUNT(*) as cnt FROM users WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 DAY) GROUP BY DATE(created_at) ORDER BY d");
    if ($res) {
        $days = [];
        for ($i = 6; $i >= 0; $i--) {
            $days[date('Y-m-d', strtotime("-$i days"))] = 0;
        }
        while ($row = $res->fetch_assoc()) {
            if (isset($days[$row['d']])) {
                $days[$row['d']] = (int)$row['cnt'];
            }
        }
        foreach ($days as $d => $c) {
            $chartData['weekly']['labels'][] = date('D', strtotime($d));
            $chartData['weekly']['data'][] = $c;
        }
    }

    // Monthly (Last 12 Months)
    $res = $db->query("SELECT DATE_FORMAT(created_at, '%Y-%m') as m, COUNT(*) as cnt FROM users WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 11 MONTH) GROUP BY m ORDER BY m");
    if ($res) {
        $months = [];
        for ($i = 11; $i >= 0; $i--) {
            $months[date('Y-m', strtotime("-$i months"))] = 0;
        }
        while ($row = $res->fetch_assoc()) {
            if (isset($months[$row['m']])) {
                $months[$row['m']] = (int)$row['cnt'];
            }
        }
        foreach ($months as $m => $c) {
            $chartData['monthly']['labels'][] = date('M', strtotime($m . '-01'));
            $chartData['monthly']['data'][] = $c;
        }
    }

    // Yearly (Last 5 Years)
    $res = $db->query("SELECT YEAR(created_at) as y, COUNT(*) as cnt FROM users GROUP BY y ORDER BY y DESC LIMIT 5");
    if ($res) {
        $years = [];
        while ($row = $res->fetch_assoc()) {
            $years[$row['y']] = (int)$row['cnt'];
        }
        $currentYear = (int)date('Y');
        $yearlyArr = [];
        for ($i = 4; $i >= 0; $i--) {
            $y = $currentYear - $i;
            $yearlyArr[$y] = $years[$y] ?? 0;
        }
        foreach ($yearlyArr as $y => $c) {
            $chartData['yearly']['labels'][] = (string)$y;
            $chartData['yearly']['data'][] = $c;
        }
    }

    $stats['chart_data'] = $chartData;

    // Profession / Occupation Statistics
    $professionStats = [];
    $res = $db->query("
        SELECT o.id, o.name AS profession_name, COUNT(u.id) AS candidate_count
        FROM occupations o
        LEFT JOIN users u ON u.occupation_id = o.id
        GROUP BY o.id, o.name
        ORDER BY candidate_count DESC
    ");
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $professionStats[] = [
                'id'    => (int)$row['id'],
                'name'  => $row['profession_name'],
                'count' => (int)$row['candidate_count'],
            ];
        }
    }
    $stats['profession_stats'] = $professionStats;

    return $stats;
}
