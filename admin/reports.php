<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'Reports';
$adminCurrent = 'reports';

require __DIR__ . '/includes/head.php';
?>

<section class="admin-page-placeholder">
  <div class="admin-glass-card admin-page-hero admin-page-hero-top">
    <span class="admin-page-icon" aria-hidden="true"><i class="fas fa-chart-column"></i></span>
    <h2>Reports</h2>
    <p class="lead">Export-ready summaries — illustrative charts only.</p>
  </div>

  <div class="admin-dashboard-row">
    <div class="admin-glass-card">
      <h2>Sign-ups (30 days)</h2>
      <div class="admin-chart-placeholder" role="img" aria-label="Sample chart">
        <?php foreach ([50, 72, 48, 90, 65, 88, 70] as $h): ?>
          <div class="admin-chart-bar" style="height: <?php echo (int) $h; ?>%;"></div>
        <?php endforeach; ?>
      </div>
      <p class="admin-chart-legend">Replace with real analytics.</p>
    </div>
    <div class="admin-glass-card">
      <h2>Revenue mix</h2>
      <div class="admin-mini-list">
        <div class="admin-mini-item">
          <strong>Gold</strong>
          <span>42%</span>
        </div>
        <div class="admin-mini-item">
          <strong>Premium</strong>
          <span>35%</span>
        </div>
        <div class="admin-mini-item">
          <strong>Standard</strong>
          <span>23%</span>
        </div>
      </div>
    </div>
  </div>

  <div class="admin-glass-card">
    <h2>Data Exports</h2>
    <p style="margin:0 0 16px;color:var(--admin-muted);font-size:14px;">Export member data.</p>
    <div style="display:flex;gap:10px;flex-wrap:wrap;">
      <a href="export-members.php?format=excel" class="admin-btn admin-btn-secondary"><i class="fas fa-file-excel" style="margin-right: 5px;"></i> Export Excel · Members</a>
      <a href="export-members.php?format=pdf" class="admin-btn admin-btn-secondary"><i class="fas fa-file-pdf" style="margin-right: 5px;"></i> Export PDF · Members</a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
