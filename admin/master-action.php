<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/master-storage.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(['ok' => false, 'error' => 'method_not_allowed']);
    exit;
}

$slug = isset($_POST['slug']) ? trim((string) $_POST['slug']) : '';
$action = isset($_POST['action']) ? trim((string) $_POST['action']) : '';
$id = isset($_POST['id']) ? trim((string) $_POST['id']) : '';
$name = isset($_POST['name']) ? trim((string) $_POST['name']) : '';
$status = isset($_POST['status']) ? trim((string) $_POST['status']) : 'Active';

if ($slug === '') {
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(['ok' => false, 'error' => 'invalid_slug']);
    exit;
}

$action = strtolower($action);
if (!in_array($action, ['add', 'edit', 'delete'], true)) {
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(['ok' => false, 'error' => 'invalid_action']);
    exit;
}

if ($action !== 'delete' && $name === '') {
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(['ok' => false, 'error' => 'invalid_name']);
    exit;
}

if (($action === 'edit' || $action === 'delete') && $id === '') {
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(['ok' => false, 'error' => 'invalid_id']);
    exit;
}

$result = false;
if ($action === 'delete') {
    $result = sathi_master_storage_delete($slug, $id);
} else {
    $result = sathi_master_storage_upsert($slug, ['id' => $id, 'name' => $name, 'status' => $status]);
}

header('Content-Type: application/json; charset=UTF-8');
if ($result) {
    echo json_encode(['ok' => true, 'action' => $action, 'id' => $id]);
    return;
}

http_response_code(500);
echo json_encode(['ok' => false, 'error' => 'save_failed']);
