<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/dashboard-stats.php';

$pageTitle = 'Profession Statistics';
$adminCurrent = 'profession-stats';

$db = sathi_db();

// Fetch profession stats
$professionStats = [];
$totalCandidates = 0;
$res = $db->query("
    SELECT o.id, o.name AS profession_name, COUNT(u.id) AS candidate_count
    FROM occupations o
    LEFT JOIN users u ON u.occupation_id = o.id
    GROUP BY o.id, o.name
    ORDER BY candidate_count DESC
");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $professionStats[] = [
            'id'    => (int)$row['id'],
            'name'  => $row['profession_name'],
            'count' => (int)$row['candidate_count'],
        ];
        $totalCandidates += (int)$row['candidate_count'];
    }
}

// Gender breakdown per profession
$genderBreakdown = [];
$res2 = $db->query("
    SELECT o.name AS profession_name, u.gender, COUNT(u.id) AS cnt
    FROM occupations o
    LEFT JOIN users u ON u.occupation_id = o.id
    GROUP BY o.name, u.gender
    ORDER BY o.name
");
if ($res2) {
    while ($row = $res2->fetch_assoc()) {
        $genderBreakdown[$row['profession_name']][$row['gender'] ?? 'unknown'] = (int)$row['cnt'];
    }
}

require __DIR__ . '/includes/head.php';
?>

<style>
  .prof-stats-hero {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 28px;
  }
  .prof-stats-hero .icon-wrap {
    width: 56px; height: 56px;
    border-radius: 16px;
    background: linear-gradient(135deg, #e94e77, #c026d3);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 22px;
    box-shadow: 0 6px 20px rgba(233,78,119,0.3);
  }
  .prof-stats-hero h2 { margin: 0; font-size: 1.5rem; }
  .prof-stats-hero p { margin: 2px 0 0; color: #888; font-size: 0.88rem; }

  .prof-summary-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 18px;
    margin-bottom: 28px;
  }
  .prof-summary-card {
    background: #fff;
    border-radius: 16px;
    padding: 20px 22px;
    border: 1px solid #f1f5f9;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    transition: transform 0.2s, box-shadow 0.2s;
  }
  .prof-summary-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(233,78,119,0.12);
  }
  .prof-summary-card .label {
    font-size: 0.72rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.5px; color: #999; margin: 0 0 6px;
  }
  .prof-summary-card .value {
    font-size: 1.8rem; font-weight: 800; color: #1a1a2e; margin: 0;
    line-height: 1.1;
  }
  .prof-summary-card .meta {
    font-size: 0.78rem; color: #aaa; margin: 4px 0 0;
  }

  .prof-charts-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    margin-bottom: 28px;
  }
  @media (max-width: 900px) {
    .prof-charts-row { grid-template-columns: 1fr; }
  }

  .prof-search-wrap {
    display: flex;
    gap: 12px;
    margin-bottom: 18px;
    align-items: center;
  }
  .prof-search-input {
    flex: 1;
    max-width: 360px;
    padding: 10px 16px;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    font-size: 0.9rem;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
  }
  .prof-search-input:focus {
    border-color: #e94e77;
    box-shadow: 0 0 0 3px rgba(233,78,119,0.1);
  }

  #profFullTable tbody tr {
    transition: background 0.15s;
  }
  #profFullTable tbody tr:hover {
    background: #fdf2f8;
  }
  .gender-pills {
    display: flex; gap: 6px;
  }
  .gender-pill {
    font-size: 0.7rem; font-weight: 700; padding: 2px 10px;
    border-radius: 20px; letter-spacing: 0.3px;
  }
  .gender-pill--male { background: #dbeafe; color: #1d4ed8; }
  .gender-pill--female { background: #fce7f3; color: #be185d; }
</style>

<section class="admin-page-placeholder">

  <!-- Hero -->
  <div class="prof-stats-hero">
    <div class="icon-wrap"><i class="fas fa-briefcase"></i></div>
    <div>
      <h2>Profession Statistics</h2>
      <p>Comprehensive breakdown of candidates by occupation / profession</p>
    </div>
  </div>

  <!-- Summary Cards -->
  <div class="prof-summary-cards">
    <div class="prof-summary-card">
      <p class="label">Total Candidates</p>
      <p class="value"><?php echo number_format($totalCandidates); ?></p>
      <p class="meta">Across all professions</p>
    </div>
    <div class="prof-summary-card">
      <p class="label">Professions</p>
      <p class="value"><?php echo count($professionStats); ?></p>
      <p class="meta">Distinct categories</p>
    </div>
    <div class="prof-summary-card">
      <p class="label">Top Profession</p>
      <p class="value"><?php echo htmlspecialchars($professionStats[0]['name'] ?? '—'); ?></p>
      <p class="meta"><?php echo number_format($professionStats[0]['count'] ?? 0); ?> candidates</p>
    </div>
    <div class="prof-summary-card">
      <p class="label">Avg per Profession</p>
      <p class="value"><?php echo count($professionStats) > 0 ? number_format(round($totalCandidates / count($professionStats))) : 0; ?></p>
      <p class="meta">Mean distribution</p>
    </div>
  </div>

  <!-- Charts Row -->
  <div class="prof-charts-row">
    <div class="admin-glass-card">
      <h2 style="margin: 0 0 16px;"><i class="fas fa-chart-bar" style="color: #e94e77; margin-right: 8px;"></i>Bar Chart</h2>
      <div style="height: 350px;">
        <canvas id="profBarChart"></canvas>
      </div>
    </div>
    <div class="admin-glass-card">
      <h2 style="margin: 0 0 16px;"><i class="fas fa-chart-pie" style="color: #7c3aed; margin-right: 8px;"></i>Distribution</h2>
      <div style="height: 350px; display: flex; align-items: center; justify-content: center;">
        <canvas id="profPieChart" style="max-height: 320px;"></canvas>
      </div>
    </div>
  </div>

  <!-- Full Data Table -->
  <div class="admin-glass-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
      <h2 style="margin: 0;"><i class="fas fa-table" style="color: #06b6d4; margin-right: 8px;"></i>Detailed Breakdown</h2>
      <div class="prof-search-wrap" style="margin-bottom: 0;">
        <input type="text" class="prof-search-input" id="profTableSearch" placeholder="Search profession...">
      </div>
    </div>
    <div class="admin-table-wrap">
      <table class="admin-table" id="profFullTable">
        <thead>
          <tr>
            <th style="width: 45px; cursor: pointer;" onclick="sortFullTable('rank')"># <i class="fas fa-sort" style="font-size:10px;color:#ccc;"></i></th>
            <th style="cursor: pointer;" onclick="sortFullTable('name')">Profession <i class="fas fa-sort" style="font-size:10px;color:#ccc;"></i></th>
            <th style="text-align:right; cursor: pointer;" onclick="sortFullTable('count')">Candidates <i class="fas fa-sort" style="font-size:10px;color:#ccc;"></i></th>
            <th style="text-align:right; width: 90px;">Share %</th>
            <th>Gender Split</th>
            <th style="width: 180px;">Distribution</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $rank = 0;
            $profColors = ['#e94e77','#7c3aed','#f59e0b','#06b6d4','#10b981','#ec4899','#8b5cf6','#f97316','#14b8a6','#6366f1','#84cc16','#ef4444','#0ea5e9','#a855f7','#94a3b8'];
            foreach ($professionStats as $ps):
                $rank++;
                $pct = $totalCandidates > 0 ? round(($ps['count'] / $totalCandidates) * 100, 1) : 0;
                $barColor = $profColors[($rank - 1) % count($profColors)];
                $maleCount = $genderBreakdown[$ps['name']]['male'] ?? 0;
                $femaleCount = $genderBreakdown[$ps['name']]['female'] ?? 0;
          ?>
          <tr data-name="<?php echo htmlspecialchars(strtolower($ps['name'])); ?>">
            <td style="font-weight:700; color:#999; font-size:0.8rem;"><?php echo $rank; ?></td>
            <td>
              <div style="display:flex;align-items:center;gap:8px;">
                <div style="width:10px;height:10px;border-radius:50%;background:<?php echo $barColor; ?>;flex-shrink:0;"></div>
                <span style="font-weight:600;"><?php echo htmlspecialchars($ps['name']); ?></span>
              </div>
            </td>
            <td style="text-align:right;font-weight:700;font-size:1rem;"><?php echo number_format($ps['count']); ?></td>
            <td style="text-align:right;color:#666;font-size:0.85rem;"><?php echo $pct; ?>%</td>
            <td>
              <div class="gender-pills">
                <?php if ($maleCount > 0): ?>
                  <span class="gender-pill gender-pill--male"><i class="fas fa-mars" style="margin-right:3px;"></i><?php echo $maleCount; ?></span>
                <?php endif; ?>
                <?php if ($femaleCount > 0): ?>
                  <span class="gender-pill gender-pill--female"><i class="fas fa-venus" style="margin-right:3px;"></i><?php echo $femaleCount; ?></span>
                <?php endif; ?>
              </div>
            </td>
            <td>
              <div style="background:#f1f5f9;border-radius:6px;height:10px;overflow:hidden;">
                <div style="height:100%;width:<?php echo $pct; ?>%;background:<?php echo $barColor; ?>;border-radius:6px;transition:width 0.6s ease;"></div>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const profData = <?php echo json_encode($professionStats); ?>;
  const profColors = [
    '#e94e77','#7c3aed','#f59e0b','#06b6d4','#10b981',
    '#ec4899','#8b5cf6','#f97316','#14b8a6','#6366f1',
    '#84cc16','#ef4444','#0ea5e9','#a855f7','#94a3b8'
  ];

  // Bar Chart
  const barCtx = document.getElementById('profBarChart');
  if (barCtx && typeof Chart !== 'undefined') {
    new Chart(barCtx, {
      type: 'bar',
      data: {
        labels: profData.map(p => p.name),
        datasets: [{
          label: 'Candidates',
          data: profData.map(p => p.count),
          backgroundColor: profData.map((_, i) => profColors[i % profColors.length]),
          borderRadius: 6,
          barPercentage: 0.7,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        indexAxis: 'y',
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: 'rgba(30,20,40,0.92)',
            titleFont: { family: 'Poppins', size: 13, weight: '600' },
            bodyFont: { family: 'Poppins', size: 12 },
            padding: 12, cornerRadius: 10
          }
        },
        scales: {
          x: {
            beginAtZero: true,
            grid: { color: '#f1f5f9' },
            ticks: { font: { family: 'Poppins', size: 11 } }
          },
          y: {
            grid: { display: false },
            ticks: { font: { family: 'Poppins', size: 11, weight: '600' } }
          }
        }
      }
    });
  }

  // Doughnut Chart
  const pieCtx = document.getElementById('profPieChart');
  if (pieCtx && typeof Chart !== 'undefined') {
    new Chart(pieCtx, {
      type: 'doughnut',
      data: {
        labels: profData.map(p => p.name),
        datasets: [{
          data: profData.map(p => p.count),
          backgroundColor: profData.map((_, i) => profColors[i % profColors.length]),
          borderWidth: 2, borderColor: '#fff', hoverOffset: 8
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        cutout: '58%',
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              padding: 10, usePointStyle: true, pointStyle: 'circle',
              font: { size: 11, family: 'Poppins' }
            }
          },
          tooltip: {
            backgroundColor: 'rgba(30,20,40,0.92)',
            padding: 12, cornerRadius: 10,
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

  // Table search
  const searchInput = document.getElementById('profTableSearch');
  if (searchInput) {
    searchInput.addEventListener('input', function() {
      const q = this.value.trim().toLowerCase();
      const rows = document.querySelectorAll('#profFullTable tbody tr');
      rows.forEach(row => {
        const name = row.getAttribute('data-name') || '';
        row.style.display = name.includes(q) ? '' : 'none';
      });
    });
  }
});

// Full table sort
let fullSortDir = { rank: 'asc', name: 'asc', count: 'desc' };
function sortFullTable(col) {
  const table = document.getElementById('profFullTable');
  if (!table) return;
  const tbody = table.querySelector('tbody');
  const rows = Array.from(tbody.querySelectorAll('tr'));
  const dir = fullSortDir[col] === 'asc' ? 'desc' : 'asc';
  fullSortDir[col] = dir;

  rows.sort((a, b) => {
    if (col === 'name') {
      const aV = a.cells[1].textContent.trim().toLowerCase();
      const bV = b.cells[1].textContent.trim().toLowerCase();
      return dir === 'asc' ? aV.localeCompare(bV) : bV.localeCompare(aV);
    } else if (col === 'count') {
      const aV = parseInt(a.cells[2].textContent.replace(/,/g, '')) || 0;
      const bV = parseInt(b.cells[2].textContent.replace(/,/g, '')) || 0;
      return dir === 'asc' ? aV - bV : bV - aV;
    } else {
      const aV = parseInt(a.cells[0].textContent) || 0;
      const bV = parseInt(b.cells[0].textContent) || 0;
      return dir === 'asc' ? aV - bV : bV - aV;
    }
  });

  rows.forEach((row, i) => {
    row.cells[0].textContent = i + 1;
    tbody.appendChild(row);
  });
}
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>
