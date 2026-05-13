<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'Dashboard';
$adminCurrent = 'dashboard';

require __DIR__ . '/includes/head.php';
?>

<section class="admin-dashboard">
  <div class="admin-stats-grid">
    <div class="admin-stat-card">
      <p class="label">Total members</p>
      <p class="value">2,847</p>
      <p class="meta">↑ 12% vs last month</p>
    </div>
    <div class="admin-stat-card">
      <p class="label">Pending approvals</p>
      <p class="value">38</p>
      <p class="meta down">3 profiles overdue</p>
    </div>
    <div class="admin-stat-card">
      <p class="label">Active paid plans</p>
      <p class="value">412</p>
      <p class="meta">↑ 4% renewal rate</p>
    </div>
    <div class="admin-stat-card">
      <p class="label">Success stories</p>
      <p class="value">156</p>
      <p class="meta">8 pending review</p>
    </div>
  </div>

  <div class="admin-dashboard-row">
    <div class="admin-glass-card">
      <h2>Registrations overview</h2>
      <div class="admin-chart-placeholder" role="img" aria-label="Sample chart">
        <?php foreach ([40, 65, 45, 80, 55, 90, 70, 95, 75, 88, 92, 100] as $h): ?>
          <div class="admin-chart-bar" style="height: <?php echo (int) $h; ?>%;"></div>
        <?php endforeach; ?>
      </div>
      <p class="admin-chart-legend">Illustrative bars — connect your analytics API when backend is ready.</p>
    </div>
    <div class="admin-glass-card">
      <h2>Quick snapshot</h2>
      <div class="admin-mini-list">
        <div class="admin-mini-item">
          <strong>New today</strong>
          <span>14 profiles</span>
        </div>
        <div class="admin-mini-item">
          <strong>Photos in queue</strong>
          <span>22 items</span>
        </div>
        <div class="admin-mini-item">
          <strong>Horoscope uploads</strong>
          <span>7 pending</span>
        </div>
        <div class="admin-mini-item">
          <strong>Payments (7d)</strong>
          <span>₹ 4.2L</span>
        </div>
      </div>
    </div>
  </div>

  <div class="admin-glass-card">
    <h2>Recent members</h2>
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Profile</th>
            <th>City</th>
            <th>Plan</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Priya Sharma</td>
            <td>Mumbai</td>
            <td><span class="admin-badge paid">Gold</span></td>
            <td><span class="admin-badge ok">Approved</span></td>
          </tr>
          <tr>
            <td>Rahul Verma</td>
            <td>Delhi</td>
            <td><span class="admin-badge pending">—</span></td>
            <td><span class="admin-badge pending">Review</span></td>
          </tr>
          <tr>
            <td>Ananya Iyer</td>
            <td>Bangalore</td>
            <td><span class="admin-badge paid">Premium</span></td>
            <td><span class="admin-badge ok">Approved</span></td>
          </tr>
          <tr>
            <td>Karan Mehta</td>
            <td>Pune</td>
            <td><span class="admin-badge pending">—</span></td>
            <td><span class="admin-badge pending">Docs</span></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
