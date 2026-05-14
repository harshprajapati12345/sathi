<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/auth.php';

shadikibaat_admin_require_auth();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Method not allowed']);
    exit;
}

$action = $_POST['action'] ?? '';
$type = $_POST['type'] ?? '';

if (!in_array($action, ['add', 'edit', 'delete'], true)) {
    echo json_encode(['ok' => false, 'error' => 'Invalid action']);
    exit;
}

if (!in_array($type, ['banner', 'blog', 'story'], true)) {
    echo json_encode(['ok' => false, 'error' => 'Invalid type']);
    exit;
}

$db = sathi_db();

function handle_image_upload($file_key) {
    if (isset($_FILES[$file_key]) && $_FILES[$file_key]['error'] === UPLOAD_ERR_OK) {
        $tmp = $_FILES[$file_key]['tmp_name'];
        $name = basename($_FILES[$file_key]['name']);
        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            $new_name = uniqid('cms_', true) . '.' . $ext;
            $dest = dirname(__DIR__) . '/uploads/' . $new_name;
            if (move_uploaded_file($tmp, $dest)) {
                return 'uploads/' . $new_name;
            }
        }
    }
    return null;
}

if ($action === 'delete') {
    $id = (int)($_POST['id'] ?? 0);
    if ($id <= 0) {
        echo json_encode(['ok' => false, 'error' => 'Invalid ID']);
        exit;
    }

    $table = '';
    if ($type === 'banner') $table = 'homepage_banners';
    if ($type === 'blog') $table = 'blogs';
    if ($type === 'story') $table = 'success_stories';

    $stmt = $db->prepare("DELETE FROM {$table} WHERE id = ?");
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        echo json_encode(['ok' => true]);
    } else {
        echo json_encode(['ok' => false, 'error' => 'Failed to delete']);
    }
    exit;
}

if ($type === 'banner') {
    $id = (int)($_POST['id'] ?? 0);
    $title = trim((string)($_POST['title'] ?? ''));
    $subtitle = trim((string)($_POST['subtitle'] ?? ''));
    $status = (int)($_POST['status'] ?? 0);
    
    $image_path = handle_image_upload('image');

    if (empty($title)) {
        echo json_encode(['ok' => false, 'error' => 'Title is required']);
        exit;
    }

    if ($action === 'add') {
        $stmt = $db->prepare('INSERT INTO homepage_banners (title, subtitle, status, image) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('ssis', $title, $subtitle, $status, $image_path);
    } else {
        if ($image_path) {
            $stmt = $db->prepare('UPDATE homepage_banners SET title = ?, subtitle = ?, status = ?, image = ? WHERE id = ?');
            $stmt->bind_param('ssisi', $title, $subtitle, $status, $image_path, $id);
        } else {
            $stmt = $db->prepare('UPDATE homepage_banners SET title = ?, subtitle = ?, status = ? WHERE id = ?');
            $stmt->bind_param('ssii', $title, $subtitle, $status, $id);
        }
    }

    if ($stmt->execute()) {
        echo json_encode(['ok' => true]);
    } else {
        echo json_encode(['ok' => false, 'error' => 'Database error']);
    }
    exit;
}

if ($type === 'blog') {
    $id = (int)($_POST['id'] ?? 0);
    $title = trim((string)($_POST['title'] ?? ''));
    $content = trim((string)($_POST['content'] ?? ''));
    $slug = strtolower(preg_replace('/[^a-zA-Z0-9\-]/', '-', $title));
    $status = trim((string)($_POST['status'] ?? 'pending'));

    $image_path = handle_image_upload('image');

    if (empty($title) || empty($content)) {
        echo json_encode(['ok' => false, 'error' => 'Title and Content are required']);
        exit;
    }

    if ($action === 'add') {
        $stmt = $db->prepare('INSERT INTO blogs (title, slug, content, status, image) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('sssss', $title, $slug, $content, $status, $image_path);
    } else {
        if ($image_path) {
            $stmt = $db->prepare('UPDATE blogs SET title = ?, slug = ?, content = ?, status = ?, image = ? WHERE id = ?');
            $stmt->bind_param('sssssi', $title, $slug, $content, $status, $image_path, $id);
        } else {
            $stmt = $db->prepare('UPDATE blogs SET title = ?, slug = ?, content = ?, status = ? WHERE id = ?');
            $stmt->bind_param('ssssi', $title, $slug, $content, $status, $id);
        }
    }

    if ($stmt->execute()) {
        echo json_encode(['ok' => true]);
    } else {
        echo json_encode(['ok' => false, 'error' => 'Database error']);
    }
    exit;
}

if ($type === 'story') {
    $id = (int)($_POST['id'] ?? 0);
    $groom_name = trim((string)($_POST['groom_name'] ?? ''));
    $bride_name = trim((string)($_POST['bride_name'] ?? ''));
    $story = trim((string)($_POST['story'] ?? ''));
    $status = (int)($_POST['status'] ?? 0);

    $image_path = handle_image_upload('image');

    if (empty($groom_name) || empty($bride_name)) {
        echo json_encode(['ok' => false, 'error' => 'Groom and Bride names are required']);
        exit;
    }

    if ($action === 'add') {
        $stmt = $db->prepare('INSERT INTO success_stories (groom_name, bride_name, story, status, image) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('sssis', $groom_name, $bride_name, $story, $status, $image_path);
    } else {
        if ($image_path) {
            $stmt = $db->prepare('UPDATE success_stories SET groom_name = ?, bride_name = ?, story = ?, status = ?, image = ? WHERE id = ?');
            $stmt->bind_param('sssisi', $groom_name, $bride_name, $story, $status, $image_path, $id);
        } else {
            $stmt = $db->prepare('UPDATE success_stories SET groom_name = ?, bride_name = ?, story = ?, status = ? WHERE id = ?');
            $stmt->bind_param('sssii', $groom_name, $bride_name, $story, $status, $id);
        }
    }

    if ($stmt->execute()) {
        echo json_encode(['ok' => true]);
    } else {
        echo json_encode(['ok' => false, 'error' => 'Database error']);
    }
    exit;
}

echo json_encode(['ok' => false, 'error' => 'Unhandled request']);
