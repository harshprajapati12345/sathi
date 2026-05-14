<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/user-storage.php';

$pageTitle = 'Member Approvals';
$adminCurrent = 'members-approval';

$pending = sathi_users_list_by_status('pending', 200);

require __DIR__ . '/includes/head.php';
?>

<section class="admin-page-placeholder">
  <div class="admin-glass-card admin-page-hero admin-page-hero-top">
    <span class="admin-page-icon" aria-hidden="true"><i class="fas fa-user-clock"></i></span>
    <h2>Member approvals</h2>
    <p class="lead">Review new registrations (users.status = pending).</p>
  </div>

  <div class="admin-static-toolbar">
    <input type="search" class="admin-input-search" placeholder="Search email / name…" aria-label="Search" readonly>
    <span class="admin-sort-hint"><?php echo count($pending); ?> pending</span>
  </div>

  <div class="admin-glass-card">
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Name</th>
            <th>Registered</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($pending) === 0): ?>
          <tr><td colspan="5">No pending members.</td></tr>
          <?php else: ?>
          <?php foreach ($pending as $row): ?>
          <tr>
            <td><?php echo (int) ($row['id'] ?? 0); ?></td>
            <td><?php echo htmlspecialchars((string) ($row['email'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars(trim((string) ($row['first_name'] ?? '') . ' ' . (string) ($row['last_name'] ?? '')), ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars(substr((string) ($row['created_at'] ?? ''), 0, 10), ENT_QUOTES, 'UTF-8'); ?></td>
            <td>
              <div class="admin-actions-inline">
                <a class="admin-btn admin-btn-secondary admin-btn-sm" href="member-view.php?id=<?php echo (int) ($row['id'] ?? 0); ?>">View</a>
                <button type="button" class="admin-btn admin-btn-primary admin-btn-sm admin-approve-user" data-user-id="<?php echo (int) ($row['id'] ?? 0); ?>">Approve</button>
                <button type="button" class="admin-btn admin-btn-secondary admin-btn-sm admin-reject-user" data-user-id="<?php echo (int) ($row['id'] ?? 0); ?>">Reject</button>
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
