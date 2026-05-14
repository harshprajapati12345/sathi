<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'Membership Plans';
$adminCurrent = 'plans-all';

require __DIR__ . '/includes/head.php';

$db = sathi_db();
$result = $db->query('SELECT * FROM membership_plans ORDER BY id ASC');
$plans = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>

<section class="admin-page-placeholder">
  <div class="admin-glass-card admin-page-hero admin-page-hero-top">
    <span class="admin-page-icon" aria-hidden="true"><i class="fas fa-list-ul"></i></span>
    <h2>All membership plans</h2>
    <p class="lead">MySQL `membership_plans`.</p>
  </div>

  <div class="admin-static-toolbar">
    <a href="add-membership-plan.php" class="admin-btn admin-btn-primary">Add plan</a>
  </div>

  <div class="admin-plan-grid">
    <?php foreach ($plans as $pl): ?>
    <div class="admin-plan-card-ui">
      <h3><?php echo htmlspecialchars((string) ($pl['name'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></h3>
      <div class="admin-plan-price">₹<?php echo htmlspecialchars(number_format((float) ($pl['price'] ?? 0), 0), ENT_QUOTES, 'UTF-8'); ?></div>
      <p class="admin-plan-meta"><?php echo (int) ($pl['duration_days'] ?? 0); ?> days</p>
      <ul class="admin-plan-features">
        <li>Profile views: <?php echo (int) ($pl['profile_views'] ?? 0); ?></li>
        <li>Contact views: <?php echo (int) ($pl['contact_views'] ?? 0); ?></li>
        <li>Status: <?php echo ((int) ($pl['status'] ?? 0)) === 1 ? 'Active' : 'Inactive'; ?></li>
      </ul>
    </div>
    <?php endforeach; ?>
    <?php if (count($plans) === 0): ?>
    <p>No plans in database.</p>
    <?php endif; ?>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
