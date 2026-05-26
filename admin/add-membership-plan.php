<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim((string) ($_POST['plan_name'] ?? ''));
    $price = (float) ($_POST['price'] ?? 0);
    $days = 365; // Fixed for yearly only
    $feat = trim((string) ($_POST['features'] ?? ''));
    if ($name !== '' && $price >= 0) {
        $pdo = sathi_db();
        $pv = 100;
        $cv = 20;
        $feat = str_replace(["\r\n", "\r"], "\n", $feat);
        $pdo->prepare('INSERT INTO membership_plans (name, price, duration_days, profile_views, contact_views, featured_profile, status) VALUES (?,?,?,?,?,?,1)')
            ->execute([$name, $price, $days, $pv, $cv, 0]);
        header('Location: membership-plans.php', true, 302);
        exit;
    }
}

$pageTitle = 'Add Membership Plan';
$adminCurrent = 'plans-add';

require __DIR__ . '/includes/head.php';
?>

<section class="admin-page-placeholder">
  <div class="admin-glass-card admin-page-hero admin-page-hero-top">
    <span class="admin-page-icon" aria-hidden="true"><i class="fas fa-plus-circle"></i></span>
    <h2>Add membership plan</h2>
    <p class="lead">Creates a row in `membership_plans`.</p>
  </div>

  <div class="admin-glass-card">
    <form class="admin-form-grid" action="add-membership-plan.php" method="post">
      <div class="admin-form-field">
        <span>Plan name</span>
        <input type="text" name="plan_name" required placeholder="e.g. Gold">
      </div>
      <div class="admin-form-field">
        <span>Price (₹)</span>
        <input type="number" name="price" step="0.01" min="1" required placeholder="1999">
      </div>
      <div class="admin-form-field">
        <span>Duration (days)</span>
        <input type="number" name="duration_days" value="365" readonly style="background: #f1f5f9; cursor: not-allowed; color: #64748b;">
        <span style="font-size: 11px; color: #6b7280; font-weight: normal; margin-top: 4px;">Plans are fixed for yearly only.</span>
      </div>
      <div class="admin-form-field" style="grid-column:1/-1;">
        <span>Features (notes)</span>
        <textarea name="features" rows="5" placeholder="Stored as text for future use"></textarea>
      </div>
      <div class="admin-form-actions" style="grid-column:1/-1;">
        <button type="submit" class="admin-btn admin-btn-primary">Save plan</button>
        <a href="membership-plans.php" class="admin-btn admin-btn-secondary">Back to plans</a>
      </div>
    </form>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
