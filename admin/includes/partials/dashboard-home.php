<?php
declare(strict_types=1);
/** @var array{total: int, pending: int, approved: int, paid: int, rejected: int, revenue: float, recent_regs: int, recent_payments: float, photos_queue: int, horoscope_queue: int} $dashStats */
/** @var array $recentUsers */
$dashStats = $dashStats ?? [
  'total' => 0,
  'pending' => 0,
  'approved' => 0,
  'paid' => 0,
  'rejected' => 0,
  'revenue' => 0.0,
  'recent_regs' => 0,
  'recent_payments' => 0.0,
  'photos_queue' => 0,
  'horoscope_queue' => 0
];
$recentUsers = $recentUsers ?? [];
?>
<section class="admin-dashboard">
  <div class="admin-stats-grid">
    <div class="admin-stat-card">
      <p class="label">Total members</p>
      <p class="value"><?php echo number_format((int) $dashStats['total']); ?></p>
      <p class="meta">Live from database</p>
    </div>
    <div class="admin-stat-card">
      <p class="label">Pending approvals</p>
      <p class="value"><?php echo number_format((int) $dashStats['pending']); ?></p>
      <p class="meta">Awaiting review</p>
    </div>
    <div class="admin-stat-card">
      <p class="label">Approved members</p>
      <p class="value"><?php echo number_format((int) $dashStats['approved']); ?></p>
      <p class="meta">Active profiles</p>
    </div>
    <div class="admin-stat-card">
      <p class="label">Paid members</p>
      <p class="value"><?php echo number_format((int) $dashStats['paid']); ?></p>
      <p class="meta">paid_member = 1</p>
    </div>
    <div class="admin-stat-card">
      <p class="label">Monthly revenue</p>
      <p class="value">₹ <?php echo number_format($dashStats['revenue'] / 1000, 1); ?>k</p>
      <p class="meta">Total completed</p>
    </div>
    <div class="admin-stat-card">
      <p class="label">Recent regs</p>
      <p class="value"><?php echo number_format($dashStats['recent_regs']); ?></p>
      <p class="meta">Last 7 days</p>
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
      <p class="admin-chart-legend">Connect analytics when backend is ready.</p>
    </div>
  </div>
  <div class="admin-glass-card">
    <h2>Quick Site Update</h2>
    <div id="quickSettingsForm">
      <div style="margin-bottom: 12px;">
        <label
          style="display:block; font-size: 11px; font-weight: 700; color: #999; text-transform: uppercase; margin-bottom: 4px;">Site
          Name</label>
        <input type="text" id="q_site_name"
          value="<?php echo htmlspecialchars(sathi_site_setting('site_name', 'Shadikibaat')); ?>"
          style="width: 100%; padding: 8px 12px; border: 1px solid #eee; border-radius: 8px; font-size: 14px;">
      </div>
      <div style="margin-bottom: 12px;">
        <label
          style="display:block; font-size: 11px; font-weight: 700; color: #999; text-transform: uppercase; margin-bottom: 4px;">Support
          Email</label>
        <input type="email" id="q_support_email"
          value="<?php echo htmlspecialchars(sathi_site_setting('support_email', 'support@shadikibaat.com')); ?>"
          style="width: 100%; padding: 8px 12px; border: 1px solid #eee; border-radius: 8px; font-size: 14px;">
      </div>
      <div style="display: flex; gap: 8px; align-items: center; margin-top: 15px;">
        <button type="button" class="admin-btn admin-btn-primary" id="btnQuickSave"
          style="padding: 0.5rem 1rem; font-size: 0.85rem;">Update site</button>
        <span id="quickSaveStatus" style="font-size: 0.8rem;"></span>
      </div>
    </div>
  </div>

  <div class="admin-glass-card">
    <h2>Quick Add Master</h2>
    <div id="quickMasterForm">
      <div style="margin-bottom: 12px;">
        <label
          style="display:block; font-size: 11px; font-weight: 700; color: #999; text-transform: uppercase; margin-bottom: 4px;">Type</label>
        <select id="q_master_slug"
          style="width: 100%; padding: 8px 12px; border: 1px solid #eee; border-radius: 8px; font-size: 14px;">
          <option value="religion">Religion</option>
          <option value="caste">Caste</option>
          <option value="mother_tongue">Mother Tongue</option>
          <option value="education">Education</option>
          <option value="occupation">Occupation</option>
        </select>
      </div>
      <div style="margin-bottom: 12px;">
        <label
          style="display:block; font-size: 11px; font-weight: 700; color: #999; text-transform: uppercase; margin-bottom: 4px;">Name
          / Value</label>
        <input type="text" id="q_master_name" placeholder="e.g. Jain, Engineer..."
          style="width: 100%; padding: 8px 12px; border: 1px solid #eee; border-radius: 8px; font-size: 14px;">
      </div>
      <div style="display: flex; gap: 8px; align-items: center; margin-top: 15px;">
        <button type="button" class="admin-btn admin-btn-secondary" id="btnQuickMasterSave"
          style="padding: 0.5rem 1rem; font-size: 0.85rem;">Add entry</button>
        <span id="quickMasterStatus" style="font-size: 0.8rem;"></span>
      </div>
    </div>
  </div>
  </div>

  <div class="admin-glass-card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
      <h2 style="margin-bottom:0;">Recent members</h2>
      <a href="users-list.php" class="admin-btn admin-btn-outline"
        style="padding: 0.4rem 0.8rem; font-size: 0.8rem;">View all</a>
    </div>
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Profile</th>
            <th>City</th>
            <th>Plan</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($recentUsers)): ?>
            <tr>
              <td colspan="4" style="text-align:center; padding: 2rem; color: #666;">No recent members found.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($recentUsers as $user): ?>
              <?php
              $u = sathi_user_normalize_row($user);
              $statusClass = $u['status'] === 'approved' ? 'ok' : ($u['status'] === 'pending' ? 'pending' : 'error');
              $planClass = $u['paid_member'] ? 'paid' : 'pending';
              $planLabel = $u['membership_status'] === 'free' ? 'Free' : ucfirst($u['membership_status']);
              ?>
              <tr>
                <td>
                  <div style="display:flex; align-items:center; gap:10px;">
                    <?php if (!empty($u['profile_photo'])): ?>
                      <img src="../uploads/profiles/<?php echo htmlspecialchars($u['profile_photo']); ?>"
                        alt="" style="width:32px; height:32px; border-radius:50%; object-fit:cover;">
                    <?php else: ?>
                      <div style="width:32px; height:32px; border-radius:50%; background:#ffe4e6; display:flex; align-items:center; justify-content:center; font-size:14px; color:#e11d48; font-weight:700;">
                        <?php echo htmlspecialchars(strtoupper(substr($u['name'], 0, 1))); ?>
                      </div>
                    <?php endif; ?>
                    <div>
                      <div style="font-weight:600;"><?php echo htmlspecialchars($u['name']); ?></div>
                      <div style="font-size:0.75rem; color:#666;"><?php echo htmlspecialchars($u['profile_id']); ?></div>
                    </div>
                  </div>
                </td>
                <td><?php echo htmlspecialchars($user['city_name'] ?? '—'); ?></td>
                <td><span class="admin-badge <?php echo $planClass; ?>"><?php echo htmlspecialchars($planLabel); ?></span>
                </td>
                <td><span
                    class="admin-badge <?php echo $statusClass; ?>"><?php echo htmlspecialchars(ucfirst($u['status'])); ?></span>
                </td>
                <td>
                  <div class="admin-actions-inline">
                    <a href="member-edit.php?id=<?php echo $u['id']; ?>" class="admin-btn-ghost admin-btn-sm"
                      title="Quick edit"><i class="fas fa-pen"></i></a>
                    <a href="member-view.php?id=<?php echo $u['id']; ?>" class="admin-btn-ghost admin-btn-sm"
                      title="View details"><i class="fas fa-eye"></i></a>
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

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const btnQuickSave = document.getElementById('btnQuickSave');
    const qStatus = document.getElementById('quickSaveStatus');

    if (btnQuickSave) {
      btnQuickSave.addEventListener('click', function () {
        btnQuickSave.disabled = true;
        qStatus.textContent = 'Updating…';
        qStatus.style.color = '#666';

        const payload = {
          settings: {
            site_name: document.getElementById('q_site_name').value,
            support_email: document.getElementById('q_support_email').value
          }
        };

        fetch('site-settings-action.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        })
          .then(r => r.json())
          .then(data => {
            if (data.ok) {
              qStatus.textContent = 'Updated!';
              qStatus.style.color = 'green';
              setTimeout(() => { qStatus.textContent = ''; }, 3000);
            } else {
              throw new Error(data.error || 'Failed');
            }
          })
          .catch(err => {
            qStatus.textContent = 'Err: ' + err.message;
            qStatus.style.color = 'red';
          })
          .finally(() => {
            btnQuickSave.disabled = false;
          });
      });
    }

    const btnQuickMasterSave = document.getElementById('btnQuickMasterSave');
    const qMasterStatus = document.getElementById('quickMasterStatus');

    if (btnQuickMasterSave) {
      btnQuickMasterSave.addEventListener('click', function () {
        const slug = document.getElementById('q_master_slug').value;
        const name = document.getElementById('q_master_name').value.trim();

        if (!name) {
          qMasterStatus.textContent = 'Please enter a name.';
          qMasterStatus.style.color = 'red';
          return;
        }

        btnQuickMasterSave.disabled = true;
        qMasterStatus.textContent = 'Adding...';
        qMasterStatus.style.color = '#666';

        const formData = new FormData();
        formData.append('action', 'add');
        formData.append('slug', slug);
        formData.append('name', name);
        formData.append('status', 'Active');

        fetch('master-action.php', {
          method: 'POST',
          body: formData
        })
          .then(r => r.json())
          .then(data => {
            if (data.ok) {
              qMasterStatus.textContent = 'Added successfully!';
              qMasterStatus.style.color = 'green';
              document.getElementById('q_master_name').value = '';
              setTimeout(() => { qMasterStatus.textContent = ''; }, 3000);
            } else {
              throw new Error(data.error || 'Failed to add');
            }
          })
          .catch(err => {
            qMasterStatus.textContent = 'Err: ' + err.message;
            qMasterStatus.style.color = 'red';
          })
          .finally(() => {
            btnQuickMasterSave.disabled = false;
          });
      });
    }
  });
</script>