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
    <span class="admin-badge-soft"><i class="fas fa-layer-group" aria-hidden="true"></i> Static preview</span>
    <a href="../index.php" class="admin-link-site" title="View website"><i class="fas fa-arrow-up-right-from-square"></i> View site</a>
  </div>
</header>
