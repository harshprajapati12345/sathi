<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/master-storage.php';
require_once __DIR__ . '/includes/auth.php';

shadikibaat_admin_require_auth();

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

$item = ['id' => $id, 'name' => $name, 'status' => $status];
$religionId = isset($_POST['religion_id']) ? trim((string) $_POST['religion_id']) : '';
$countryId = isset($_POST['country_id']) ? trim((string) $_POST['country_id']) : '';
$stateId = isset($_POST['state_id']) ? trim((string) $_POST['state_id']) : '';
if ($religionId !== '') {
    $item['religion_id'] = $religionId;
}
if ($countryId !== '') {
    $item['country_id'] = $countryId;
}
if ($stateId !== '') {
    $item['state_id'] = $stateId;
}

$result = false;
if ($action === 'delete') {
    $result = sathi_master_storage_delete($slug, $id);
} else {
    $result = sathi_master_storage_upsert($slug, $item);
}

header('Content-Type: application/json; charset=UTF-8');
if ($result) {
    echo json_encode(['ok' => true, 'action' => $action, 'id' => $id]);
    return;
}

http_response_code(500);
echo json_encode(['ok' => false, 'error' => 'save_failed']);
