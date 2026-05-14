<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/user-storage.php';

$pageTitle = 'Paid Members';
$adminCurrent = 'members-paid';

require __DIR__ . '/includes/head.php';

$rows = sathi_users_list_paid(200);
?>

<section class="admin-page-placeholder">
  <div class="admin-glass-card admin-page-hero admin-page-hero-top">
    <span class="admin-page-icon" aria-hidden="true"><i class="fas fa-indian-rupee-sign"></i></span>
    <h2>Paid members</h2>
    <p class="lead">Users where paid_member = 1.</p>
  </div>

  <div class="admin-glass-card">
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>City</th>
            <th>Membership</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($rows) === 0): ?>
          <tr><td colspan="5">No paid members.</td></tr>
          <?php else: ?>
          <?php foreach ($rows as $r): ?>
          <tr>
            <td><?php echo htmlspecialchars(trim(($r['first_name'] ?? '') . ' ' . ($r['last_name'] ?? '')), ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars((string) ($r['email'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars((string) ($r['city_name'] ?? '—'), ENT_QUOTES, 'UTF-8'); ?></td>
            <td><span class="admin-badge paid"><?php echo htmlspecialchars((string) ($r['membership_status'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></span></td>
            <td><a class="admin-btn admin-btn-secondary admin-btn-sm" href="member-edit.php?id=<?php echo (int) ($r['id'] ?? 0); ?>">Edit</a></td>
          </tr>
          <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
