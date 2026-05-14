<?php
/**
 * Site Settings Action (MySQLi Aligned)
 */
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/auth.php';

shadikibaat_admin_require_auth();

header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'method_not_allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
if (!$data || !isset($data['settings']) || !is_array($data['settings'])) {
    echo json_encode(['ok' => false, 'error' => 'invalid_payload']);
    exit;
}

try {
    $db = sathi_db();
    $db->begin_transaction();
    
    $stmt = $db->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = ?");
    
    foreach ($data['settings'] as $key => $value) {
        $keyStr = (string)$key;
        $valStr = (string)$value;
        $stmt->bind_param("sss", $keyStr, $valStr, $valStr);
        $stmt->execute();
    }
    
    $db->commit();
    echo json_encode(['ok' => true]);
} catch (Throwable $e) {
    if (isset($db)) {
        $db->rollback();
    }
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}
