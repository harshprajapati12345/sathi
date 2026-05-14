<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'Edit Member';
$adminCurrent = 'members-all';

require __DIR__ . '/includes/head.php';
?>

<section class="admin-page-placeholder">
  <div class="admin-glass-card admin-page-hero admin-page-hero-top">
    <span class="admin-page-icon" aria-hidden="true"><i class="fas fa-user-pen"></i></span>
    <h2>Edit member</h2>
    <p class="lead">Form layout only — does not save.</p>
  </div>

  <div class="admin-glass-card">
    <form class="admin-form-grid" action="#" method="post" onsubmit="return false;">
      <div class="admin-form-field">
        <span>Full name</span>
        <input type="text" value="Priya Sharma" readonly>
      </div>
      <div class="admin-form-field">
        <span>City</span>
        <input type="text" value="Mumbai" readonly>
      </div>
      <div class="admin-form-field">
        <span>Membership</span>
        <select disabled>
          <option selected>Gold</option>
          <option>Premium</option>
          <option>Standard</option>
        </select>
      </div>
      <div class="admin-form-field" style="grid-column:1/-1;">
        <span>Admin notes</span>
        <textarea rows="4" readonly placeholder="Internal notes…"></textarea>
      </div>
      <div class="admin-form-actions" style="grid-column:1/-1;">
        <button type="button" class="admin-btn admin-btn-primary" data-static-alert>Save changes</button>
        <a href="members.php" class="admin-btn admin-btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
