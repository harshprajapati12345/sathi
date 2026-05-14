<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'Manual Payments';
$adminCurrent = 'payments-manual';

require __DIR__ . '/includes/head.php';
?>

<section class="admin-page-placeholder">
  <div class="admin-glass-card admin-page-hero admin-page-hero-top">
    <span class="admin-page-icon" aria-hidden="true"><i class="fas fa-hand-holding-dollar"></i></span>
    <h2>Manual payments</h2>
    <p class="lead">Record cash / bank transfers entered by staff.</p>
  </div>

  <div class="admin-static-toolbar">
    <button type="button" class="admin-btn admin-btn-primary" data-static-alert>Record payment</button>
  </div>

  <div class="admin-glass-card">
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Member</th>
            <th>Amount</th>
            <th>Reference</th>
            <th>Entered by</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Karan Mehta</td>
            <td>₹1,999</td>
            <td>NEFT · HDFC ref 99123</td>
            <td>Admin</td>
            <td>2026-05-07</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
