<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';
require_once dirname(__DIR__) . '/includes/registration-config.php';

$pageTitle = 'Profile Field Summary';
$adminCurrent = 'profile-summary';

$fieldLabels = sathi_registration_field_labels();
$fieldSettings = sathi_registration_field_settings();

// Filter only required fields
$requiredFields = [];
foreach ($fieldLabels as $key => $label) {
    $cfg = $fieldSettings[$key] ?? ['visible' => true, 'required' => false];
    if (!empty($cfg['required'])) {
        $requiredFields[$key] = $label;
    }
}

require __DIR__ . '/includes/head.php';
?>

<section class="admin-page-placeholder">
  <div class="admin-glass-card admin-page-hero admin-page-hero-top">
    <span class="admin-page-icon" aria-hidden="true"><i class="fas fa-list-check"></i></span>
    <h2>Required Profile Fields</h2>
    <p class="lead">A summary of all mandatory fields for registration. Total: <?php echo count($requiredFields); ?></p>
  </div>

  <div class="admin-glass-card">
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Field Label</th>
            <th>Field Key</th>
            <th>Status</th>
            <th style="text-align:right;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($requiredFields)): ?>
          <tr>
            <td colspan="4" style="text-align:center;padding:40px;color:#999;">No mandatory fields set.</td>
          </tr>
          <?php else: ?>
          <?php foreach ($requiredFields as $key => $label): ?>
          <tr>
            <td><strong><?php echo htmlspecialchars($label); ?></strong></td>
            <td><code><?php echo htmlspecialchars($key); ?></code></td>
            <td><span class="admin-badge ok">Required</span></td>
            <td style="text-align:right;">
               <a href="form-field-settings.php" class="admin-btn admin-btn-secondary admin-btn-sm">Change</a>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
  
  <div style="margin-top:20px;">
    <a href="form-field-settings.php" class="admin-btn admin-btn-primary">Manage all visibility settings</a>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
