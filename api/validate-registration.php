<?php
/**
 * Real-time Validation API
 */
require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/helpers/response.php';
require_once dirname(__DIR__) . '/helpers/validator.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(false, 'Method Not Allowed');
}

$db = sathi_db();
$field = $_POST['field'] ?? '';
$value = $_POST['value'] ?? '';

if ($field === 'email') {
    if (!validate_email($value)) {
        json_response(false, 'Invalid Email Format');
    }
    
    $stmt = $db->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $value);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        json_response(false, 'Email already exists');
    }
    json_response(true, 'Email available');
}

if ($field === 'mobile') {
    if (!validate_mobile($value)) {
        json_response(false, 'Invalid Mobile (10 digits)');
    }
    json_response(true, 'Mobile valid');
}

json_response(false, 'Unknown field');
