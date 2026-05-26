<?php
declare(strict_types=1);
$pageTitle = 'Admin Login';
$err = isset($_GET['err']) ? (string) $_GET['err'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?> · Shadikibaat</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="css/admin.css">
  <link rel="stylesheet" href="assets/css/admin-style.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="admin-login-body">
  <div class="admin-login-panel">
    <div class="admin-login-logo" aria-hidden="true">💍</div>
    <h1>Shadikibaat Admin</h1>
    <p class="lead">Sign in with your admin account.</p>
    <?php if ($err !== ''): ?>
    <p style="color:#b91c1c;font-size:14px;margin-bottom:12px;">Could not sign in. Check email and password.</p>
    <?php endif; ?>
    <form action="auth-login.php" method="post" autocomplete="on">
      <label for="adm_email">Email</label>
      <input id="adm_email" type="email" name="email" required autocomplete="username" placeholder="admin@shadikibaat.local">

      <label for="adm_pw" style="margin-top:14px;display:block;">Password</label>
      <input id="adm_pw" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">

      <button type="submit" class="admin-btn admin-btn-primary" style="margin-top:18px;">
        Sign in
      </button>
    </form>
    <p style="margin-top:20px;font-size:13px;color:#9ca3af;text-align:center;">
      <a href="../index.php" style="color:#e94e77;font-weight:600;">← Back to website</a>
    </p>
  </div>
  <script src="assets/js/admin-script.js" defer></script>
</body>
</html>
