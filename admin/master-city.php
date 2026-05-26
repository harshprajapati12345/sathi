<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/master-storage.php';

$pageTitle = 'City';
$adminCurrent = 'master-city';

require __DIR__ . '/includes/head.php';

$pmDbSlug = 'master-city';
$pmDbRows = sathi_master_storage_get($pmDbSlug);

// Get states for the dropdown
$db = sathi_db();
$statesRes = $db->query("SELECT id, name FROM states WHERE status = 1 ORDER BY name");
$states = [];
if ($statesRes) {
    while($s = $statesRes->fetch_assoc()) $states[] = $s;
}

$pmHeroTitle = 'City';
$pmHeroLead = 'Manage cities and their parent states. Total: ' . count($pmDbRows);
$pmHeroIcon = 'fas fa-city';

?>
<section class="admin-page-placeholder">
  <div class="admin-glass-card admin-page-hero admin-page-hero-top">
    <span class="admin-page-icon" aria-hidden="true"><i class="fas fa-city"></i></span>
    <h2>City Management</h2>
    <p class="lead"><?php echo htmlspecialchars($pmHeroLead); ?></p>
  </div>

  <div class="admin-static-toolbar">
    <button type="button" class="admin-btn admin-btn-primary" onclick="showAddCityModal()">Add City</button>
    <input type="search" class="admin-input-search" placeholder="Search cities..." style="max-width:320px;" oninput="filterCityTable(this.value)">
  </div>

  <div class="admin-glass-card">
    <div class="admin-table-wrap">
      <table class="admin-table" id="cityTable">
        <thead>
          <tr>
            <th>#</th>
            <th>City Name</th>
            <th>State ID</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($pmDbRows as $i => $row): ?>
          <tr>
            <td><?php echo $i + 1; ?></td>
            <td><strong><?php echo htmlspecialchars($row['name']); ?></strong></td>
            <td><?php echo (int)($row['state_id'] ?? 0); ?></td>
            <td><span class="admin-badge <?php echo $row['status'] === 'Active' ? 'ok' : 'pending'; ?>"><?php echo $row['status']; ?></span></td>
            <td>
               <button class="admin-btn admin-btn-secondary admin-btn-sm" onclick="editCity(<?php echo htmlspecialchars(json_encode($row)); ?>)">Edit</button>
               <button class="admin-btn admin-btn-secondary admin-btn-sm" onclick="deleteMaster('master-city', '<?php echo $row['id']; ?>')">Delete</button>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<!-- Custom Modal for City (since it needs a state selector) -->
<div id="cityModal" class="admin-modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
  <div class="admin-glass-card" style="width:100%; max-width:400px; padding:24px;">
    <h3 id="modalTitle">Add City</h3>
    <div class="admin-form-field" style="margin-bottom:16px;">
      <label>City Name</label>
      <input type="text" id="cityName" class="admin-input" style="width:100%;">
    </div>
    <div class="admin-form-field" style="margin-bottom:16px;">
      <label>Parent State</label>
      <select id="cityStateId" class="admin-input" style="width:100%;">
        <?php foreach ($states as $st): ?>
        <option value="<?php echo $st['id']; ?>"><?php echo htmlspecialchars($st['name']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div style="display:flex; gap:12px; margin-top:24px;">
      <button type="button" class="admin-btn admin-btn-primary" onclick="saveCity()">Save</button>
      <button type="button" class="admin-btn admin-btn-secondary" onclick="closeCityModal()">Cancel</button>
    </div>
    <input type="hidden" id="cityId">
  </div>
</div>

<script>
let currentCityAction = 'add';

function showAddCityModal() {
    currentCityAction = 'add';
    document.getElementById('modalTitle').textContent = 'Add City';
    document.getElementById('cityName').value = '';
    document.getElementById('cityId').value = '';
    document.getElementById('cityModal').style.display = 'flex';
}

function editCity(row) {
    currentCityAction = 'edit';
    document.getElementById('modalTitle').textContent = 'Edit City';
    document.getElementById('cityName').value = row.name;
    document.getElementById('cityId').value = row.id;
    document.getElementById('cityStateId').value = row.state_id;
    document.getElementById('cityModal').style.display = 'flex';
}

function closeCityModal() {
    document.getElementById('cityModal').style.display = 'none';
}

function saveCity() {
    const name = document.getElementById('cityName').value;
    const state_id = document.getElementById('cityStateId').value;
    const id = document.getElementById('cityId').value;
    
    if(!name) return Swal.fire({icon: 'error', text: 'Enter city name', confirmButtonColor: '#e94e77'});
    
    const body = new URLSearchParams({
        slug: 'master-city',
        action: currentCityAction,
        id: id,
        name: name,
        state_id: state_id,
        status: 'Active'
    });
    
    fetch('master-action.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: body.toString()
    })
    .then(r => r.json())
    .then(d => {
        if(d.ok) window.location.reload();
        else Swal.fire({icon: 'error', text: 'Error: ' + (d.error || 'Unknown'), confirmButtonColor: '#e94e77'});
    });
}

function deleteMaster(slug, id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'Deactivate this city?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e94e77',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, deactivate it!'
    }).then((result) => {
        if (result.isConfirmed) {
            const body = new URLSearchParams({ slug, action: 'delete', id, name: '-' });
            fetch('master-action.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: body.toString()
            })
            .then(r => r.json())
            .then(d => {
                if(d.ok) window.location.reload();
            });
        }
    });
}

function filterCityTable(val) {
    const q = val.toLowerCase();
    const rows = document.querySelectorAll('#cityTable tbody tr');
    rows.forEach(r => {
        const text = r.innerText.toLowerCase();
        r.style.display = text.includes(q) ? '' : 'none';
    });
}
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>
