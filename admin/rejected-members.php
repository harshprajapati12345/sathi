<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/user-storage.php';

$pageTitle = 'Rejected Members';
$adminCurrent = 'members-rejected';

require __DIR__ . '/includes/head.php';

$rows = sathi_users_list_by_status('rejected', 200);
?>

<section class="admin-page-placeholder">
  <div class="admin-glass-card admin-page-hero admin-page-hero-top">
    <span class="admin-page-icon" aria-hidden="true"><i class="fas fa-user-slash"></i></span>
    <h2>Rejected members</h2>
    <p class="lead">Users with status rejected.</p>
  </div>

  <div class="admin-glass-card">
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Reason</th>
            <th>Joined</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($rows) === 0): ?>
          <tr><td colspan="5">No records.</td></tr>
          <?php else: ?>
          <?php foreach ($rows as $r): ?>
          <tr>
            <td><?php echo (int) ($r['id'] ?? 0); ?></td>
            <td><?php echo htmlspecialchars(trim(($r['first_name'] ?? '') . ' ' . ($r['last_name'] ?? '')), ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars((string) ($r['email'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars((string) ($r['rejection_reason'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars(substr((string) ($r['created_at'] ?? ''), 0, 10), ENT_QUOTES, 'UTF-8'); ?></td>
          </tr>
          <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
