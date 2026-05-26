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
    <div class="admin-glass-card" style="position: relative;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h2 style="margin: 0;">Registrations overview</h2>
        <select id="chartPeriodSelect" style="padding: 6px 12px; border-radius: 6px; border: 1px solid #e2e8f0; font-size: 14px; outline: none; cursor: pointer; background: #fff;">
          <option value="weekly">Weekly</option>
          <option value="monthly">Monthly</option>
          <option value="yearly">Yearly</option>
        </select>
      </div>
      <div style="height: 300px; width: 100%;">
        <canvas id="registrationsChart"></canvas>
      </div>
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

  <!-- PROFESSION / OCCUPATION STATISTICS -->
  <div class="admin-dashboard-row" style="margin-top: 24px;">
    <div class="admin-glass-card" style="position: relative;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h2 style="margin: 0;"><i class="fas fa-briefcase" style="color: #e94e77; margin-right: 8px;"></i>Candidates by Profession</h2>
        <span style="font-size: 0.78rem; color: #999; font-weight: 600;">
          <?php
            $totalProfCandidates = 0;
            foreach (($dashStats['profession_stats'] ?? []) as $ps) {
                $totalProfCandidates += $ps['count'];
            }
            echo number_format($totalProfCandidates) . ' total candidates';
          ?>
        </span>
      </div>
      <div style="display: grid; grid-template-columns: 300px 1fr; gap: 32px; align-items: start;">
        <!-- Doughnut Chart -->
        <div style="position: relative; width: 100%; max-width: 300px; margin: 0 auto;">
          <canvas id="professionDoughnutChart" style="max-height: 300px;"></canvas>
        </div>
        <!-- Data Table -->
        <div class="admin-table-wrap" style="max-height: 360px; overflow-y: auto;">
          <table class="admin-table" id="professionStatsTable">
            <thead style="position: sticky; top: 0; background: #fff; z-index: 2;">
              <tr>
                <th style="width: 40px;">#</th>
                <th style="cursor: pointer;" onclick="sortProfessionTable('name')">
                  Profession <i class="fas fa-sort" style="font-size: 10px; color: #ccc; margin-left: 4px;"></i>
                </th>
                <th style="text-align: right; cursor: pointer;" onclick="sortProfessionTable('count')">
                  Candidates <i class="fas fa-sort" style="font-size: 10px; color: #ccc; margin-left: 4px;"></i>
                </th>
                <th style="text-align: right; width: 90px;">Share %</th>
                <th style="width: 160px;">Distribution</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $profStats = $dashStats['profession_stats'] ?? [];
                $rank = 0;
                foreach ($profStats as $ps):
                    $rank++;
                    $pct = $totalProfCandidates > 0 ? round(($ps['count'] / $totalProfCandidates) * 100, 1) : 0;
                    $barColor = '#e94e77';
                    if ($rank === 1) $barColor = '#e94e77';
                    elseif ($rank === 2) $barColor = '#7c3aed';
                    elseif ($rank === 3) $barColor = '#f59e0b';
                    elseif ($rank <= 5) $barColor = '#06b6d4';
                    else $barColor = '#94a3b8';
              ?>
              <tr>
                <td style="font-weight: 700; color: #999; font-size: 0.8rem;"><?php echo $rank; ?></td>
                <td>
                  <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="width: 8px; height: 8px; border-radius: 50%; background: <?php echo $barColor; ?>; flex-shrink: 0;"></div>
                    <span style="font-weight: 600;"><?php echo htmlspecialchars($ps['name']); ?></span>
                  </div>
                </td>
                <td style="text-align: right; font-weight: 700; font-size: 1rem;"><?php echo number_format($ps['count']); ?></td>
                <td style="text-align: right; color: #666; font-size: 0.85rem;"><?php echo $pct; ?>%</td>
                <td>
                  <div style="background: #f1f5f9; border-radius: 6px; height: 8px; overflow: hidden;">
                    <div style="height: 100%; width: <?php echo $pct; ?>%; background: <?php echo $barColor; ?>; border-radius: 6px; transition: width 0.6s ease;"></div>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <style>
    @media (max-width: 768px) {
      .admin-dashboard-row .admin-glass-card > div[style*="grid-template-columns: 300px"] {
        grid-template-columns: 1fr !important;
      }
    }
    #professionStatsTable tbody tr {
      transition: background 0.15s ease;
    }
    #professionStatsTable tbody tr:hover {
      background: #fdf2f8;
    }
  </style>

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

    // Chart.js Initialization
    const chartDataRaw = <?php echo json_encode($dashStats['chart_data'] ?? ['weekly'=>['labels'=>[],'data'=>[]], 'monthly'=>['labels'=>[],'data'=>[]], 'yearly'=>['labels'=>[],'data'=>[]]]); ?>;
    
    const ctx = document.getElementById('registrationsChart');
    if (ctx && typeof Chart !== 'undefined') {
      let regChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: chartDataRaw['weekly'].labels,
          datasets: [{
            label: 'Registrations',
            data: chartDataRaw['weekly'].data,
            backgroundColor: '#e94e77', // Admin theme rose color
            hoverBackgroundColor: '#c73d62', // Admin theme deep rose
            borderRadius: 4,
            barPercentage: 0.6,
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                stepSize: 1
              },
              grid: {
                color: '#f1f5f9'
              }
            },
            x: {
              grid: {
                display: false
              }
            }
          }
        }
      });

      const periodSelect = document.getElementById('chartPeriodSelect');
      if (periodSelect) {
        periodSelect.addEventListener('change', function(e) {
          const period = e.target.value;
          if (chartDataRaw[period]) {
            regChart.data.labels = chartDataRaw[period].labels;
            regChart.data.datasets[0].data = chartDataRaw[period].data;
            regChart.update();
          }
        });
      }
    }

    // Profession Doughnut Chart
    const profData = <?php echo json_encode($dashStats['profession_stats'] ?? []); ?>;
    const profCtx = document.getElementById('professionDoughnutChart');
    if (profCtx && typeof Chart !== 'undefined' && profData.length > 0) {
      const profColors = [
        '#e94e77', '#7c3aed', '#f59e0b', '#06b6d4', '#10b981',
        '#ec4899', '#8b5cf6', '#f97316', '#14b8a6', '#6366f1',
        '#84cc16', '#ef4444', '#0ea5e9', '#a855f7', '#94a3b8'
      ];
      new Chart(profCtx, {
        type: 'doughnut',
        data: {
          labels: profData.map(p => p.name),
          datasets: [{
            data: profData.map(p => p.count),
            backgroundColor: profData.map((_, i) => profColors[i % profColors.length]),
            hoverBackgroundColor: profData.map((_, i) => profColors[i % profColors.length]),
            borderWidth: 2,
            borderColor: '#fff',
            hoverOffset: 6
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: true,
          cutout: '62%',
          plugins: {
            legend: {
              display: true,
              position: 'bottom',
              labels: {
                padding: 12,
                usePointStyle: true,
                pointStyle: 'circle',
                font: { size: 11, family: 'Poppins' }
              }
            },
            tooltip: {
              backgroundColor: 'rgba(30,20,40,0.92)',
              titleFont: { family: 'Poppins', size: 13, weight: '600' },
              bodyFont: { family: 'Poppins', size: 12 },
              padding: 12,
              cornerRadius: 10,
              callbacks: {
                label: function(ctx) {
                  const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                  const pct = total > 0 ? ((ctx.parsed / total) * 100).toFixed(1) : 0;
                  return ' ' + ctx.label + ': ' + ctx.parsed.toLocaleString() + ' (' + pct + '%)';
                }
              }
            }
          }
        }
      });
    }
  });

  // Profession table sort
  let profSortDir = { name: 'asc', count: 'desc' };
  function sortProfessionTable(col) {
    const table = document.getElementById('professionStatsTable');
    if (!table) return;
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    const dir = profSortDir[col] === 'asc' ? 'desc' : 'asc';
    profSortDir[col] = dir;

    rows.sort((a, b) => {
      let aVal, bVal;
      if (col === 'name') {
        aVal = a.cells[1].textContent.trim().toLowerCase();
        bVal = b.cells[1].textContent.trim().toLowerCase();
        return dir === 'asc' ? aVal.localeCompare(bVal) : bVal.localeCompare(aVal);
      } else {
        aVal = parseInt(a.cells[2].textContent.replace(/,/g, '')) || 0;
        bVal = parseInt(b.cells[2].textContent.replace(/,/g, '')) || 0;
        return dir === 'asc' ? aVal - bVal : bVal - aVal;
      }
    });

    rows.forEach((row, i) => {
      row.cells[0].textContent = i + 1;
      tbody.appendChild(row);
    });
  }
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>