<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/user-storage.php';

$pageTitle = 'All Members';
$adminCurrent = 'members-all';

require __DIR__ . '/includes/head.php';

$rows = sathi_users_list_all(200);
?>

<section class="admin-page-placeholder">
  <div class="admin-glass-card admin-page-hero admin-page-hero-top">
    <span class="admin-page-icon" aria-hidden="true"><i class="fas fa-users"></i></span>
    <h2>All members</h2>
    <p class="lead">Recent users (newest first, limit 200).</p>
  </div>

  <div class="admin-glass-card">
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Status</th>
            <th>Joined</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($rows) === 0): ?>
          <tr><td colspan="9">No members yet.</td></tr>
          <?php else: ?>
          <?php foreach ($rows as $r): ?>
          <tr>
            <td><?php echo (int) ($r['id'] ?? 0); ?></td>
            <td><?php echo htmlspecialchars((string)($r['name'] ?? 'Member'), ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars((string) ($r['email'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars((string) ($r['gender'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars((string) ($r['status'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars(substr((string) ($r['created_at'] ?? ''), 0, 10), ENT_QUOTES, 'UTF-8'); ?></td>
            <td>
              <div class="admin-actions-inline">
                <a class="admin-btn admin-btn-secondary admin-btn-sm" href="member-view.php?id=<?php echo (int) ($r['id'] ?? 0); ?>">View</a>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
