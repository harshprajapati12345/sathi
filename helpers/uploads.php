<?php
/**
 * File Upload Helper
 */
function upload_file($file, $folder)
{
    if (!$file || !isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    $allowed = ['jpg', 'jpeg', 'png', 'pdf'];

    $ext = strtolower(pathinfo(
        $file['name'],
        PATHINFO_EXTENSION
    ));

    if (!in_array($ext, $allowed)) {
        return false;
    }

    $filename = uniqid() . '.' . $ext;

    // Define base upload path relative to the root
    $basePath = dirname(__DIR__) . '/uploads/';
    $destDir = $basePath . $folder;

    if (!is_dir($destDir)) {
        mkdir($destDir, 0755, true);
    }

    $path = $destDir . '/' . $filename;

    if (move_uploaded_file($file['tmp_name'], $path)) {
        return $filename;
    }

    return false;
}
