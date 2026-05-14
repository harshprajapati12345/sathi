<?php
/**
 * JSON Response Helper
 */
function json_response($success, $message, $data = [])
{
    header('Content-Type: application/json');

    echo json_encode([
        'ok'      => $success,
        'success' => $success,
        'error'   => $success ? null : $message,
        'message' => $message,
        'data'    => $data
    ]);

    exit;
}
