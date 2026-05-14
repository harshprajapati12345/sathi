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

    return $stats;
}
