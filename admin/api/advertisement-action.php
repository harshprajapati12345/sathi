<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/includes/bootstrap.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';
$id = (int)($_POST['id'] ?? 0);

if (!in_array($action, ['add', 'edit', 'delete'])) {
    echo json_encode(['ok' => false, 'error' => 'Invalid action']);
    exit;
}

$db = sathi_db();

if ($action === 'delete') {
    if (!$id) {
        echo json_encode(['ok' => false, 'error' => 'ID required']);
        exit;
    }
    // Fetch image path to delete
    $res = $db->query("SELECT image FROM advertisements WHERE id = $id");
    $row = $res->fetch_assoc();
    if ($row && !empty($row['image']) && file_exists(dirname(dirname(__DIR__)) . '/' . $row['image'])) {
        @unlink(dirname(dirname(__DIR__)) . '/' . $row['image']);
    }
    
    $stmt = $db->prepare("DELETE FROM advertisements WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo json_encode(['ok' => true]);
    } else {
        echo json_encode(['ok' => false, 'error' => $stmt->error]);
    }
    exit;
}

if ($action === 'add' || $action === 'edit') {
    $title = trim($_POST['title'] ?? '');
    $position = trim($_POST['position'] ?? 'top');
    $link = trim($_POST['link'] ?? '');
    $status = (int)($_POST['status'] ?? 1);
    
    if (empty($title)) {
        echo json_encode(['ok' => false, 'error' => 'Title is required']);
        exit;
    }

    $imagePath = '';
    
    // File upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $tmp = $_FILES['image']['tmp_name'];
        $name = basename($_FILES['image']['name']);
        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            $newName = uniqid('ad_') . '.' . $ext;
            $uploadDir = dirname(dirname(__DIR__)) . '/uploads/ads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            if (move_uploaded_file($tmp, $uploadDir . $newName)) {
                $imagePath = 'uploads/ads/' . $newName;
            }
        }
    }

    if ($action === 'add') {
        if (empty($imagePath)) {
            echo json_encode(['ok' => false, 'error' => 'Image is required for new ad']);
            exit;
        }
        $stmt = $db->prepare("INSERT INTO advertisements (title, image, position, link, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $title, $imagePath, $position, $link, $status);
        if ($stmt->execute()) {
            echo json_encode(['ok' => true]);
        } else {
            echo json_encode(['ok' => false, 'error' => $stmt->error]);
        }
    } else {
        // Edit
        if (!empty($imagePath)) {
            // Delete old
            $res = $db->query("SELECT image FROM advertisements WHERE id = $id");
            $row = $res->fetch_assoc();
            if ($row && !empty($row['image']) && file_exists(dirname(dirname(__DIR__)) . '/' . $row['image'])) {
                @unlink(dirname(dirname(__DIR__)) . '/' . $row['image']);
            }
            
            $stmt = $db->prepare("UPDATE advertisements SET title=?, image=?, position=?, link=?, status=? WHERE id=?");
            $stmt->bind_param("ssssii", $title, $imagePath, $position, $link, $status, $id);
        } else {
            $stmt = $db->prepare("UPDATE advertisements SET title=?, position=?, link=?, status=? WHERE id=?");
            $stmt->bind_param("sssii", $title, $position, $link, $status, $id);
        }
        if ($stmt->execute()) {
            echo json_encode(['ok' => true]);
        } else {
            echo json_encode(['ok' => false, 'error' => $stmt->error]);
        }
    }
}
