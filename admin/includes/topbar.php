<?php
declare(strict_types=1);
$tbTitle = isset($pageTitle) ? (string) $pageTitle : 'Admin';
?>
<header class="admin-topbar">
  <button type="button" class="admin-sidebar-toggle" id="adminSidebarToggle" aria-label="Toggle sidebar">
    <i class="fas fa-bars" aria-hidden="true"></i>
  </button>
  <div class="admin-topbar-title">
    <h1><?php echo htmlspecialchars($tbTitle, ENT_QUOTES, 'UTF-8'); ?></h1>
    <p class="admin-breadcrumb"><span>Matrimonial Admin</span><?php echo isset($breadcrumbExtra) ? ' · ' . htmlspecialchars((string) $breadcrumbExtra, ENT_QUOTES, 'UTF-8') : ''; ?></p>
  </div>
  <div class="admin-topbar-actions">
    <?php if (!empty($_SESSION['sathi_admin_name'])): ?>
    <span class="admin-badge-soft"><i class="fas fa-user" aria-hidden="true"></i> <?php echo htmlspecialchars((string) $_SESSION['sathi_admin_name'], ENT_QUOTES, 'UTF-8'); ?></span>
    <?php endif; ?>
    <a href="logout.php" class="admin-link-site" title="Sign out"><i class="fas fa-right-from-bracket"></i> Logout</a>
    <a href="../index.php" class="admin-link-site" title="View website"><i class="fas fa-arrow-up-right-from-square"></i> View site</a>
  </div>
</header>
