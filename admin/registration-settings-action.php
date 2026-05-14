<?php
/**
 * Registration Settings Action (MySQLi Aligned)
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
if (!$data || !isset($data['fields']) || !is_array($data['fields'])) {
    echo json_encode(['ok' => false, 'error' => 'invalid_payload']);
    exit;
}

try {
    $db = sathi_db();
    $db->begin_transaction();
    
    $stmt = $db->prepare("UPDATE registration_field_settings SET is_visible = ?, is_required = ? WHERE field_key = ?");
    
    foreach ($data['fields'] as $key => $cfg) {
        $vis = !empty($cfg['visible']) ? 1 : 0;
        $req = !empty($cfg['required']) ? 1 : 0;
        $keyStr = (string)$key;
        $stmt->bind_param("iis", $vis, $req, $keyStr);
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
