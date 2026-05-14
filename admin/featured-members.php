<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'Featured Members';
$adminCurrent = 'members-featured';

require __DIR__ . '/includes/head.php';
?>

<section class="admin-page-placeholder">
  <div class="admin-glass-card admin-page-hero admin-page-hero-top">
    <span class="admin-page-icon" aria-hidden="true"><i class="fas fa-star"></i></span>
    <h2>Featured members</h2>
    <p class="lead">Spotlight slots for premium visibility.</p>
  </div>

  <div class="admin-static-toolbar">
    <button type="button" class="admin-btn admin-btn-primary" data-static-alert>Add featured slot</button>
  </div>

  <div class="admin-glass-card">
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Slot</th>
            <th>Ends</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Neha Jain</td>
            <td>Homepage carousel</td>
            <td>2026-08-30</td>
            <td><button type="button" class="admin-btn admin-btn-secondary admin-btn-sm" data-static-alert>Remove</button></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
