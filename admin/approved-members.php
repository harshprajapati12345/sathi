<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/user-storage.php';

$pageTitle = 'Approved Members';
$adminCurrent = 'members-approved';

$rows = sathi_users_list_by_status('approved', 300);

require __DIR__ . '/includes/head.php';
?>

<section class="admin-page-placeholder">
  <div class="admin-glass-card admin-page-hero admin-page-hero-top">
    <span class="admin-page-icon" aria-hidden="true"><i class="fas fa-user-check"></i></span>
    <h2>Approved Members</h2>
    <p class="lead">Users with status approved.</p>
  </div>

  <div class="admin-glass-card">
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Joined</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($rows) === 0): ?>
          <tr><td colspan="5">No approved members found.</td></tr>
          <?php else: ?>
          <?php foreach ($rows as $r): ?>
          <tr>
            <td><?php echo (int) ($r['id'] ?? 0); ?></td>
            <td><?php echo htmlspecialchars(trim(($r['first_name'] ?? '') . ' ' . ($r['last_name'] ?? '')), ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars((string) ($r['email'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars(substr((string) ($r['created_at'] ?? ''), 0, 10), ENT_QUOTES, 'UTF-8'); ?></td>
            <td>
              <a class="admin-btn admin-btn-secondary admin-btn-sm" href="member-view.php?id=<?php echo (int) ($r['id'] ?? 0); ?>">View</a>
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
