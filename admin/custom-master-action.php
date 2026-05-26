<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';
require_once dirname(__DIR__) . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';

shadikibaat_admin_require_auth();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'method_not_allowed']);
    exit;
}

$table = isset($_POST['table']) ? trim((string) $_POST['table']) : '';
$action = isset($_POST['action']) ? trim((string) $_POST['action']) : '';
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$name = isset($_POST['name']) ? trim((string) $_POST['name']) : '';
$status = isset($_POST['status']) ? trim((string) $_POST['status']) : 'Active';

$allowed_tables = ['mandirs', 'subcasts', 'gotras'];

if (!in_array($table, $allowed_tables, true)) {
    echo json_encode(['ok' => false, 'error' => 'invalid_table']);
    exit;
}

$action = strtolower($action);
if (!in_array($action, ['add', 'edit', 'delete'], true)) {
    echo json_encode(['ok' => false, 'error' => 'invalid_action']);
    exit;
}

if ($action !== 'delete' && $name === '') {
    echo json_encode(['ok' => false, 'error' => 'invalid_name']);
    exit;
}

if (($action === 'edit' || $action === 'delete') && $id <= 0) {
    echo json_encode(['ok' => false, 'error' => 'invalid_id']);
    exit;
}

$db = sathi_db();
$result = false;

if ($action === 'add') {
    $stmt = $db->prepare("INSERT INTO `{$table}` (name, status) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $status);
    $result = $stmt->execute();
} elseif ($action === 'edit') {
    $stmt = $db->prepare("UPDATE `{$table}` SET name = ?, status = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $status, $id);
    $result = $stmt->execute();
} elseif ($action === 'delete') {
    $stmt = $db->prepare("DELETE FROM `{$table}` WHERE id = ?");
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();
}

header('Content-Type: application/json; charset=UTF-8');
if ($result) {
    echo json_encode(['ok' => true, 'action' => $action, 'id' => $id]);
} else {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'save_failed']);
}
