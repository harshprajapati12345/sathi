<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'Payment History';
$adminCurrent = 'payments-history';

require __DIR__ . '/includes/head.php';

$db = sathi_db();
$result = $db->query('SELECT p.*, u.email, u.first_name, u.last_name FROM payments p JOIN users u ON u.id = p.user_id ORDER BY p.created_at DESC LIMIT 200');
$rows = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>

<section class="admin-page-placeholder">
  <div class="admin-glass-card admin-page-hero admin-page-hero-top">
    <span class="admin-page-icon" aria-hidden="true"><i class="fas fa-receipt"></i></span>
    <h2>Payment history</h2>
    <p class="lead">From MySQL `payments`.</p>
  </div>

  <div class="admin-glass-card">
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Member</th>
            <th>Amount</th>
            <th>Method</th>
            <th>Status</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($rows) === 0): ?>
          <tr><td colspan="6">No payments.</td></tr>
          <?php else: ?>
          <?php foreach ($rows as $p): ?>
          <tr>
            <td><?php echo (int) ($p['id'] ?? 0); ?></td>
            <td><?php echo htmlspecialchars(trim(($p['first_name'] ?? '') . ' ' . ($p['last_name'] ?? '')), ENT_QUOTES, 'UTF-8'); ?><br><small><?php echo htmlspecialchars((string) ($p['email'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></small></td>
            <td>₹<?php echo htmlspecialchars(number_format((float) ($p['amount'] ?? 0), 2), ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars((string) ($p['payment_method'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
            <td><span class="admin-badge <?php echo ($p['status'] ?? '') === 'success' ? 'ok' : 'pending'; ?>"><?php echo htmlspecialchars((string) ($p['status'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></span></td>
            <td><?php echo htmlspecialchars(substr((string) ($p['created_at'] ?? ''), 0, 16), ENT_QUOTES, 'UTF-8'); ?></td>
          </tr>
          <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
