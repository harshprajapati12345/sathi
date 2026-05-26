<?php
declare(strict_types=1);

if (!isset($ADMIN_PUBLIC) || !$ADMIN_PUBLIC) {
    require_once __DIR__ . '/auth.php';
    shadikibaat_admin_require_auth();
}

$pageTitleSafe = isset($pageTitle) ? (string) $pageTitle : 'Admin';
if (!isset($adminCurrent)) {
    $adminCurrent = '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($pageTitleSafe, ENT_QUOTES, 'UTF-8'); ?> · Shadikibaat Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="css/admin.css">
  <link rel="stylesheet" href="assets/css/admin-style.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="admin-body">
  <div class="admin-layout">
    <?php require __DIR__ . '/sidebar.php'; ?>
    <div class="admin-main">
      <?php require __DIR__ . '/topbar.php'; ?>
      <div class="admin-content">
