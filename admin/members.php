<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/user-storage.php';

$pageTitle = 'All Members';
$adminCurrent = 'members-all';

require __DIR__ . '/includes/head.php';

$perPage = 50;
$page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$offset = ($page - 1) * $perPage;

$filters = [
  'gender' => $_GET['gender'] ?? '',
  'digamber_jain' => $_GET['digamber_jain'] ?? '',
  'marital_status' => $_GET['marital_status'] ?? '',
  'gotra' => $_GET['gotra'] ?? '',
  'temple' => $_GET['temple'] ?? '',
  'location' => $_GET['location'] ?? '',
  'age_min' => $_GET['age_min'] ?? '',
  'age_max' => $_GET['age_max'] ?? ''
];

$sort = $_GET['sort'] ?? 'u.id ASC';

$totalCount = sathi_users_count_all($filters);
$rows = sathi_users_list_all($perPage, $offset, $filters, $sort);
$totalPages = ceil($totalCount / $perPage);

// Fetch marital statuses for dropdown
$db = sathi_db();
$msRes = $db->query("SELECT id, name FROM marital_statuses ORDER BY id ASC");
$maritalStatuses = [];
if ($msRes) {
  while ($row = $msRes->fetch_assoc())
    $maritalStatuses[] = $row;
}
?>

<section class="admin-page-placeholder">
  <div class="admin-glass-card admin-page-hero admin-page-hero-top">
    <div style="display: flex; justify-content: space-between; align-items: center;">
      <div>
        <span class="admin-page-icon" aria-hidden="true"><i class="fas fa-users"></i></span>
        <h2>All members</h2>
        <p class="lead">Viewing all records (Total: <?php echo $totalCount; ?> members).</p>
      </div>
      <div class="admin-badge-soft" style="font-size: 16px; padding: 12px 24px;">
        <?php echo $totalCount; ?> / 300
      </div>
    </div>
  </div>

  <!-- Filters Section -->
  <div class="admin-glass-card"
    style="margin-bottom: 30px; padding: 0; overflow: hidden; border: 1px solid rgba(233, 78, 119, 0.15);">
    <div
      style="background: linear-gradient(90deg, rgba(233, 78, 119, 0.05), transparent); padding: 15px 25px; border-bottom: 1px solid rgba(233, 78, 119, 0.1);">
      <h3
        style="margin: 0; font-size: 14px; font-weight: 700; color: var(--admin-rose-deep); display: flex; align-items: center; gap: 10px;">
        <i class="fas fa-filter"></i> Advanced Search & Filters
      </h3>
    </div>
    <form method="GET" action="members.php" id="filterForm" style="padding: 30px;">
      <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 28px;">

        <!-- Gender -->
        <div class="filter-group">
          <label
            style="display: flex; align-items: center; gap: 10px; font-size: 12px; font-weight: 700; color: #4b5563; margin-bottom: 12px;">
            <div
              style="width: 28px; height: 28px; border-radius: 8px; background: #fff1f2; display: flex; align-items: center; justify-content: center; color: #e11d48;">
              <i class="fas fa-venus-mars"></i>
            </div>
            GENDER
          </label>
          <select name="gender" class="admin-input"
            style="width: 100%; border: 1.5px solid #f1f5f9; background: #f8fafc; height: 46px; border-radius: 12px; font-size: 14px; font-weight: 500; padding: 0 15px; color: #1e293b; transition: all 0.2s;"
            onchange="this.form.submit()">
            <option value="">All Genders</option>
            <option value="male" <?php echo ($filters['gender'] === 'male' ? 'selected' : ''); ?>>Male</option>
            <option value="female" <?php echo ($filters['gender'] === 'female' ? 'selected' : ''); ?>>Female</option>
          </select>
        </div>

        <!-- Religion (Digamber Jain) -->
        <div class="filter-group">
          <label
            style="display: flex; align-items: center; gap: 10px; font-size: 12px; font-weight: 700; color: #4b5563; margin-bottom: 12px;">
            <div
              style="width: 28px; height: 28px; border-radius: 8px; background: #fff1f2; display: flex; align-items: center; justify-content: center; color: #e11d48;">
              <i class="fas fa-om"></i>
            </div>
            DIGAMBER JAIN
          </label>
          <select name="digamber_jain" class="admin-input"
            style="width: 100%; border: 1.5px solid #f1f5f9; background: #f8fafc; height: 46px; border-radius: 12px; font-size: 14px; font-weight: 500; padding: 0 15px; color: #1e293b; transition: all 0.2s;"
            onchange="this.form.submit()">
            <option value="">All</option>
            <option value="yes" <?php echo ($filters['digamber_jain'] === 'yes' ? 'selected' : ''); ?>>Yes</option>
            <option value="no" <?php echo ($filters['digamber_jain'] === 'no' ? 'selected' : ''); ?>>No</option>
          </select>
        </div>

        <!-- Marital Status -->
        <div class="filter-group">
          <label
            style="display: flex; align-items: center; gap: 10px; font-size: 12px; font-weight: 700; color: #4b5563; margin-bottom: 12px;">
            <div
              style="width: 28px; height: 28px; border-radius: 8px; background: #fff1f2; display: flex; align-items: center; justify-content: center; color: #e11d48;">
              <i class="fas fa-heart"></i>
            </div>
            MARITAL STATUS
          </label>
          <select name="marital_status" class="admin-input"
            style="width: 100%; border: 1.5px solid #f1f5f9; background: #f8fafc; height: 46px; border-radius: 12px; font-size: 14px; font-weight: 500; padding: 0 15px; color: #1e293b; transition: all 0.2s;"
            onchange="this.form.submit()">
            <option value="">All Statuses</option>
            <?php foreach ($maritalStatuses as $ms): ?>
              <option value="<?php echo $ms['id']; ?>" <?php echo ($filters['marital_status'] == $ms['id'] ? 'selected' : ''); ?>>
                <?php echo htmlspecialchars($ms['name']); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Age Filter -->
        <div class="filter-group">
          <label
            style="display: flex; align-items: center; gap: 10px; font-size: 12px; font-weight: 700; color: #4b5563; margin-bottom: 12px;">
            <div
              style="width: 28px; height: 28px; border-radius: 8px; background: #fff1f2; display: flex; align-items: center; justify-content: center; color: #e11d48;">
              <i class="fas fa-birthday-cake"></i>
            </div>
            AGE RANGE
          </label>
          <div style="display: flex; gap: 10px; align-items: center;">
            <input type="number" name="age_min" placeholder="Min" class="admin-input"
              style="width: 100%; border: 1.5px solid #f1f5f9; background: #f8fafc; height: 46px; border-radius: 12px; font-size: 14px; padding: 0 15px; color: #1e293b;"
              value="<?php echo htmlspecialchars((string) $filters['age_min']); ?>">
            <span style="color: #94a3b8; font-weight: 700;">—</span>
            <input type="number" name="age_max" placeholder="Max" class="admin-input"
              style="width: 100%; border: 1.5px solid #f1f5f9; background: #f8fafc; height: 46px; border-radius: 12px; font-size: 14px; padding: 0 15px; color: #1e293b;"
              value="<?php echo htmlspecialchars((string) $filters['age_max']); ?>">
          </div>
        </div>

        <!-- Location -->
        <div class="filter-group">
          <label
            style="display: flex; align-items: center; gap: 10px; font-size: 12px; font-weight: 700; color: #4b5563; margin-bottom: 12px;">
            <div
              style="width: 28px; height: 28px; border-radius: 8px; background: #fff1f2; display: flex; align-items: center; justify-content: center; color: #e11d48;">
              <i class="fas fa-map-marker-alt"></i>
            </div>
            LOCATION
          </label>
          <div style="position: relative;">
            <i class="fas fa-search"
              style="position: absolute; left: 15px; top: 16px; font-size: 14px; color: #94a3b8;"></i>
            <input type="text" name="location" placeholder="City or State..." class="admin-input"
              style="width: 100%; padding-left: 42px; border: 1.5px solid #f1f5f9; background: #f8fafc; height: 46px; border-radius: 12px; font-size: 14px;"
              value="<?php echo htmlspecialchars($filters['location']); ?>">
          </div>
        </div>

        <!-- Gotra -->
        <div class="filter-group">
          <label
            style="display: flex; align-items: center; gap: 10px; font-size: 12px; font-weight: 700; color: #4b5563; margin-bottom: 12px;">
            <div
              style="width: 28px; height: 28px; border-radius: 8px; background: #fff1f2; display: flex; align-items: center; justify-content: center; color: #e11d48;">
              <i class="fas fa-id-card"></i>
            </div>
            GOTRA
          </label>
          <input type="text" name="gotra" placeholder="Search gotra..." class="admin-input"
            style="width: 100%; border: 1.5px solid #f1f5f9; background: #f8fafc; height: 46px; border-radius: 12px; font-size: 14px; padding: 0 15px;"
            value="<?php echo htmlspecialchars($filters['gotra']); ?>">
        </div>

        <!-- Which Temple -->
        <div class="filter-group">
          <label
            style="display: flex; align-items: center; gap: 10px; font-size: 12px; font-weight: 700; color: #4b5563; margin-bottom: 12px;">
            <div
              style="width: 28px; height: 28px; border-radius: 8px; background: #fff1f2; display: flex; align-items: center; justify-content: center; color: #e11d48;">
              <i class="fas fa-gopuram"></i>
            </div>
            WHICH TEMPLE
          </label>
          <input type="text" name="temple" placeholder="Temple name..." class="admin-input"
            style="width: 100%; border: 1.5px solid #f1f5f9; background: #f8fafc; height: 46px; border-radius: 12px; font-size: 14px; padding: 0 15px;"
            value="<?php echo htmlspecialchars($filters['temple']); ?>">
        </div>

        <!-- Sequence / Sort -->
        <div class="filter-group">
          <label
            style="display: flex; align-items: center; gap: 10px; font-size: 12px; font-weight: 700; color: #4b5563; margin-bottom: 12px;">
            <div
              style="width: 28px; height: 28px; border-radius: 8px; background: #fff1f2; display: flex; align-items: center; justify-content: center; color: #e11d48;">
              <i class="fas fa-sort-amount-down"></i>
            </div>
            SORT SEQUENCE
          </label>
          <select name="sort" class="admin-input"
            style="width: 100%; border: 1.5px solid #f1f5f9; background: #f8fafc; height: 46px; border-radius: 12px; font-size: 14px; font-weight: 500; padding: 0 15px; color: #1e293b;"
            onchange="this.form.submit()">
            <option value="u.id ASC" <?php echo ($sort === 'u.id ASC' ? 'selected' : ''); ?>>ID (Oldest First)</option>
            <option value="u.id DESC" <?php echo ($sort === 'u.id DESC' ? 'selected' : ''); ?>>ID (Newest First)</option>
            <option value="u.created_at DESC" <?php echo ($sort === 'u.created_at DESC' ? 'selected' : ''); ?>>Join Date
              (Newest)</option>
            <option value="u.first_name ASC" <?php echo ($sort === 'u.first_name ASC' ? 'selected' : ''); ?>>Name (A-Z)
            </option>
          </select>
        </div>
      </div>

      <!-- Action Row -->
      <div
        style="margin-top: 35px; padding-top: 30px; border-top: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between;">
        <div style="color: #64748b; font-size: 13px; font-weight: 500;">
          <?php if ($totalCount > 0): ?>
            Showing <strong><?php echo count($rows); ?></strong> of <strong><?php echo $totalCount; ?></strong> matching
            members.
          <?php endif; ?>
        </div>
        <div style="display: flex; gap: 15px;">
          <a href="members.php" class="admin-btn"
            style="background: #fff; border: 1px solid #e2e8f0; color: #64748b; font-weight: 600; padding: 0 25px; border-radius: 12px; height: 48px; display: flex; align-items: center; gap: 8px; transition: all 0.2s;">
            <i class="fas fa-undo-alt"></i> Clear All
          </a>
          <button type="submit" class="admin-btn admin-btn-primary"
            style="padding: 0 45px; border-radius: 12px; height: 48px; background: linear-gradient(135deg, #e94e77, #d81b60); box-shadow: 0 10px 25px rgba(233, 78, 119, 0.3); font-weight: 700; border: none; color: #fff; cursor: pointer;">
            <i class="fas fa-check-circle" style="margin-right: 10px;"></i> Apply Filters
          </button>
        </div>
      </div>
    </form>


  </div>



  <div class="admin-glass-card" style="padding: 0; overflow: hidden;">
    <div class="admin-table-wrap" style="overflow-x: auto;">
      <table class="admin-table"
        style="font-size: 13px; min-width: 1200px; border-collapse: separate; border-spacing: 0;">
        <thead>
          <tr style="background: #f9fafb;">
            <th style="padding: 15px 20px; border-bottom: 2px solid #f3f4f6;">ID</th>
            <th style="padding: 15px 20px; border-bottom: 2px solid #f3f4f6;">Name / Email</th>
            <th style="padding: 15px 20px; border-bottom: 2px solid #f3f4f6;">Mobile</th>
            <th style="padding: 15px 20px; border-bottom: 2px solid #f3f4f6;">Birth Details</th>
            <th style="padding: 15px 20px; border-bottom: 2px solid #f3f4f6;">Education / Income</th>
            <th style="padding: 15px 20px; border-bottom: 2px solid #f3f4f6;">Occupation & Firm</th>
            <th style="padding: 15px 20px; border-bottom: 2px solid #f3f4f6;">Family & Native</th>
            <th style="padding: 15px 20px; border-bottom: 2px solid #f3f4f6;">Spiritual</th>
            <th style="padding: 15px 20px; border-bottom: 2px solid #f3f4f6;">Status</th>
            <th style="padding: 15px 20px; border-bottom: 2px solid #f3f4f6;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($rows) === 0): ?>
            <tr>
              <td colspan="10" style="padding: 40px; text-align: center; color: #9ca3af;">No members found matching your
                filters.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($rows as $r): ?>
              <tr class="admin-table-row-hover" style="transition: all 0.2s;">
                <td style="padding: 15px 20px; border-bottom: 1px solid #f3f4f6; font-weight: 700; color: #9ca3af;">
                  #<?php echo (int) ($r['id'] ?? 0); ?></td>
                <td style="padding: 15px 20px; border-bottom: 1px solid #f3f4f6;">
                  <div style="font-weight: 700; color: #111827; white-space: nowrap;">
                    <?php echo htmlspecialchars((string) ($r['name'] ?? 'Member'), ENT_QUOTES, 'UTF-8'); ?>
                  </div>
                  <div style="font-size: 11px; color: #6b7280;">
                    <?php echo htmlspecialchars((string) ($r['email'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>
                  </div>
                </td>
                <td style="padding: 15px 20px; border-bottom: 1px solid #f3f4f6;">
                  <div style="white-space: nowrap; display: flex; align-items: center; gap: 8px;">
                    <div
                      style="width: 24px; height: 24px; border-radius: 50%; background: #ecfdf5; display: flex; align-items: center; justify-content: center;">
                      <i class="fab fa-whatsapp" style="color: #059669; font-size: 12px;"></i>
                    </div>
                    <span
                      style="font-weight: 500;"><?php echo htmlspecialchars((string) ($r['mobile'] ?? '—'), ENT_QUOTES, 'UTF-8'); ?></span>
                  </div>
                </td>
                <td style="padding: 15px 20px; border-bottom: 1px solid #f3f4f6;">
                  <div style="font-size: 12px; font-weight: 600;">
                    <?php echo htmlspecialchars((string) ($r['dob'] ?? '—')); ?></div>
                  <div style="font-size: 11px; color: #6b7280; display: flex; align-items: center; gap: 4px;">
                    <i class="fas fa-map-marker-alt" style="font-size: 10px;"></i>
                    <?php echo htmlspecialchars((string) ($r['birth_place'] ?? '—')); ?>
                  </div>
                </td>
                <td style="padding: 15px 20px; border-bottom: 1px solid #f3f4f6;">
                  <div
                    style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; font-size: 12px;"
                    title="<?php echo htmlspecialchars((string) ($r['education_val'] ?? '—')); ?>">
                    <?php echo htmlspecialchars((string) ($r['education_val'] ?? '—'), ENT_QUOTES, 'UTF-8'); ?>
                  </div>
                  <div style="font-weight: 700; color: #059669; font-size: 12px;">
                    <?php echo htmlspecialchars((string) ($r['annual_income'] ?? 'N/A')); ?>
                  </div>
                </td>
                <td style="padding: 15px 20px; border-bottom: 1px solid #f3f4f6;">
                  <div style="font-weight: 600;">
                    <?php echo htmlspecialchars((string) ($r['occupation_val'] ?? '—'), ENT_QUOTES, 'UTF-8'); ?></div>
                  <div style="font-size: 11px; color: #6b7280;">
                    <i class="fas fa-building" style="font-size: 10px; margin-right: 2px;"></i>
                    <?php echo htmlspecialchars((string) ($r['occupation_firm'] ?? '—'), ENT_QUOTES, 'UTF-8'); ?>
                  </div>
                </td>
                <td style="padding: 15px 20px; border-bottom: 1px solid #f3f4f6;">
                  <div style="font-size: 12px; font-weight: 500;">F:
                    <?php echo htmlspecialchars((string) ($r['father_name'] ?? '—')); ?></div>
                  <div
                    style="font-size: 11px; color: #6b7280; max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    <i class="fas fa-home" style="font-size: 10px; margin-right: 2px;"></i>
                    <?php echo htmlspecialchars((string) ($r['permanent_address'] ?? '—')); ?>
                  </div>
                </td>
                <td style="padding: 15px 20px; border-bottom: 1px solid #f3f4f6;">
                  <div style="display: flex; flex-direction: column; gap: 2px;">
                    <span
                      style="font-size: 10px; padding: 2px 6px; background: #fef2f2; color: #ef4444; border-radius: 4px; width: fit-content; font-weight: 700;">DJ:
                      <?php echo strtoupper((string) ($r['digamber_jain'] ?? '—')); ?></span>
                    <div style="font-size: 11px; font-weight: 600;">G:
                      <?php echo htmlspecialchars((string) ($r['gotra'] ?? '—')); ?></div>
                    <div style="font-size: 11px; color: #6b7280; font-style: italic;">T:
                      <?php echo htmlspecialchars((string) ($r['which_temple'] ?? '—')); ?></div>
                  </div>
                </td>
                <td style="padding: 15px 20px; border-bottom: 1px solid #f3f4f6;">
                  <span
                    class="admin-badge admin-badge-<?php echo ($r['status'] === 'approved' ? 'success' : ($r['status'] === 'rejected' ? 'danger' : 'warning')); ?>"
                    style="font-size: 10px; padding: 4px 10px;">
                    <?php echo htmlspecialchars((string) ($r['status'] ?? 'pending'), ENT_QUOTES, 'UTF-8'); ?>
                  </span>
                </td>
                <td style="padding: 15px 20px; border-bottom: 1px solid #f3f4f6;">
                  <div style="display: flex; gap: 8px; flex-direction: column;">
                    <a class="admin-btn admin-btn-sm" href="member-view.php?id=<?php echo (int) ($r['id'] ?? 0); ?>"
                      style="background: #fff; border: 1px solid #e5e7eb; color: var(--admin-rose-deep); font-weight: 700; transition: all 0.2s; padding: 6px 12px; font-size: 12px; border-radius: 6px; text-align: center; display: inline-block;">
                      <i class="fas fa-eye" style="margin-right: 4px;"></i> View
                    </a>
                    <button type="button" class="admin-btn admin-btn-sm" onclick="deleteMember(<?php echo (int) ($r['id'] ?? 0); ?>)"
                      style="background: #fef2f2; border: 1px solid #fca5a5; color: #ef4444; font-weight: 700; transition: all 0.2s; padding: 6px 12px; font-size: 12px; border-radius: 6px; cursor: pointer; text-align: center;">
                      <i class="fas fa-trash" style="margin-right: 4px;"></i> Delete
                    </button>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <?php if ($totalPages > 1):

      $queryStr = $_GET;
      ?>
      <div style="margin-top: 20px; display: flex; justify-content: center; gap: 8px;">
        <?php if ($page > 1):
          $queryStr['page'] = $page - 1;
          ?>
          <a href="?<?php echo http_build_query($queryStr); ?>" class="admin-btn admin-btn-secondary admin-btn-sm">Prev</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++):
          $queryStr['page'] = $i;
          ?>
          <a href="?<?php echo http_build_query($queryStr); ?>"
            class="admin-btn <?php echo ($i === $page ? 'admin-btn-primary' : 'admin-btn-secondary'); ?> admin-btn-sm"
            style="min-width: 36px; text-align: center;">
            <?php echo $i; ?>
          </a>
        <?php endfor; ?>

        <?php if ($page < $totalPages):
          $queryStr['page'] = $page + 1;
          ?>
          <a href="?<?php echo http_build_query($queryStr); ?>" class="admin-btn admin-btn-secondary admin-btn-sm">Next</a>
        <?php endif; ?>
      </div>
    <?php endif; ?>

  </div>
</section>

<script>
function deleteMember(id) {
  Swal.fire({
    title: 'Are you sure?',
    text: "Are you sure you want to delete this member? This action cannot be undone.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#e94e77',
    cancelButtonColor: '#6b7280',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      const formData = new FormData();
      formData.append('id', id);

      fetch('api/delete-member.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.ok) {
          Swal.fire({icon: 'success', title: 'Deleted!', text: data.message, confirmButtonColor: '#e94e77'}).then(() => location.reload());
        } else {
          Swal.fire({icon: 'error', title: 'Error', text: data.error, confirmButtonColor: '#e94e77'});
        }
      })
      .catch(error => {
        console.error('Error:', error);
        Swal.fire({icon: 'error', title: 'Oops...', text: 'An error occurred while deleting the member.', confirmButtonColor: '#e94e77'});
      });
    }
  });
}
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>