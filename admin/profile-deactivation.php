<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'Profile Deactivation';
$adminCurrent = 'members-deactivation';

require __DIR__ . '/includes/head.php';
?>

<section class="admin-page-placeholder">
  <div class="admin-glass-card admin-page-hero admin-page-hero-top">
    <span class="admin-page-icon" aria-hidden="true"><i class="fas fa-user-slash"></i></span>
    <h2>Profile deactivation requests</h2>
    <p class="lead">Approve or reject member-initiated deactivation.</p>
  </div>

  <div class="admin-glass-card">
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Member</th>
            <th>Reason</th>
            <th>Requested</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Pooja Mehta</td>
            <td>Privacy concerns</td>
            <td>2026-05-10</td>
            <td>
              <div class="admin-actions-inline">
                <button type="button" class="admin-btn admin-btn-primary admin-btn-sm" data-static-alert>Approve</button>
                <button type="button" class="admin-btn admin-btn-secondary admin-btn-sm" data-static-alert>Reject</button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
