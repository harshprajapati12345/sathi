<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'Payment Methods';
$adminCurrent = 'payments-methods';

require __DIR__ . '/includes/head.php';
?>

<section class="admin-page-placeholder">
  <div class="admin-glass-card admin-page-hero admin-page-hero-top">
    <span class="admin-page-icon" aria-hidden="true"><i class="fas fa-credit-card"></i></span>
    <h2>Payment methods</h2>
    <p class="lead">Enable or disable gateways — UI only.</p>
  </div>

  <div class="admin-pay-grid">
    <?php
    $gates = [
        ['Razorpay', true],
        ['Stripe', false],
        ['PayPal', false],
        ['UPI', true],
        ['Cash payment', true],
    ];
    foreach ($gates as $g):
        $on = $g[1];
    ?>
    <div class="admin-pay-card<?php echo $on ? ' is-enabled' : ''; ?>">
      <h3><?php echo htmlspecialchars($g[0], ENT_QUOTES, 'UTF-8'); ?></h3>
      <label class="admin-switch" style="margin-left:auto;">
        <input type="checkbox" <?php echo $on ? 'checked' : ''; ?> aria-label="<?php echo htmlspecialchars($g[0], ENT_QUOTES, 'UTF-8'); ?>">
        <span class="admin-switch-slider"></span>
      </label>
      <p style="flex:1 1 100%;margin:0;font-size:12px;color:var(--admin-muted);">Static toggle — not saved.</p>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
