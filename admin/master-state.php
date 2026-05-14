<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/master-storage.php';

$pageTitle = 'State';
$adminCurrent = 'master-state';

require __DIR__ . '/includes/head.php';

$pmDbSlug = 'master-state';
$pmDbRows = sathi_master_storage_get($pmDbSlug);

$db = sathi_db();
$countriesRes = $db->query("SELECT id, name FROM countries WHERE status = 1 ORDER BY name");
$countries = [];
if ($countriesRes) {
    while($c = $countriesRes->fetch_assoc()) $countries[] = $c;
}

$pmHeroTitle = 'State';
$pmHeroLead = 'Manage states and their parent countries.';
$pmHeroIcon = 'fas fa-map';
?>
<section class="admin-page-placeholder">
  <div class="admin-glass-card admin-page-hero admin-page-hero-top">
    <span class="admin-page-icon" aria-hidden="true"><i class="fas fa-map"></i></span>
    <h2>State Management</h2>
    <p class="lead"><?php echo htmlspecialchars($pmHeroLead); ?></p>
  </div>

  <div class="admin-static-toolbar">
    <button type="button" class="admin-btn admin-btn-primary" onclick="showAddStateModal()">Add State</button>
    <input type="search" class="admin-input-search" placeholder="Search states..." style="max-width:320px;" oninput="filterStateTable(this.value)">
  </div>

  <div class="admin-glass-card">
    <div class="admin-table-wrap">
      <table class="admin-table" id="stateTable">
        <thead>
          <tr>
            <th>#</th>
            <th>State Name</th>
            <th>Country ID</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($pmDbRows as $i => $row): ?>
          <tr>
            <td><?php echo $i + 1; ?></td>
            <td><strong><?php echo htmlspecialchars($row['name']); ?></strong></td>
            <td><?php echo (int)($row['country_id'] ?? 0); ?></td>
            <td><span class="admin-badge <?php echo $row['status'] === 'Active' ? 'ok' : 'pending'; ?>"><?php echo $row['status']; ?></span></td>
            <td>
               <button class="admin-btn admin-btn-secondary admin-btn-sm" onclick="editState(<?php echo htmlspecialchars(json_encode($row)); ?>)">Edit</button>
               <button class="admin-btn admin-btn-secondary admin-btn-sm" onclick="deleteMaster('master-state', '<?php echo $row['id']; ?>')">Delete</button>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<div id="stateModal" class="admin-modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
  <div class="admin-glass-card" style="width:100%; max-width:400px; padding:24px;">
    <h3 id="modalTitle">Add State</h3>
    <div class="admin-form-field" style="margin-bottom:16px;">
      <label>State Name</label>
      <input type="text" id="stateName" class="admin-input" style="width:100%;">
    </div>
    <div class="admin-form-field" style="margin-bottom:16px;">
      <label>Parent Country</label>
      <select id="stateCountryId" class="admin-input" style="width:100%;">
        <?php foreach ($countries as $ct): ?>
        <option value="<?php echo $ct['id']; ?>"><?php echo htmlspecialchars($ct['name']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div style="display:flex; gap:12px; margin-top:24px;">
      <button type="button" class="admin-btn admin-btn-primary" onclick="saveState()">Save</button>
      <button type="button" class="admin-btn admin-btn-secondary" onclick="closeStateModal()">Cancel</button>
    </div>
    <input type="hidden" id="stateId">
  </div>
</div>

<script>
let currentStateAction = 'add';
function showAddStateModal() {
    currentStateAction = 'add';
    document.getElementById('modalTitle').textContent = 'Add State';
    document.getElementById('stateName').value = '';
    document.getElementById('stateId').value = '';
    document.getElementById('stateModal').style.display = 'flex';
}
function editState(row) {
    currentStateAction = 'edit';
    document.getElementById('modalTitle').textContent = 'Edit State';
    document.getElementById('stateName').value = row.name;
    document.getElementById('stateId').value = row.id;
    document.getElementById('stateCountryId').value = row.country_id;
    document.getElementById('stateModal').style.display = 'flex';
}
function closeStateModal() {
    document.getElementById('stateModal').style.display = 'none';
}
function saveState() {
    const name = document.getElementById('stateName').value;
    const country_id = document.getElementById('stateCountryId').value;
    const id = document.getElementById('stateId').value;
    if(!name) return alert('Enter state name');
    const body = new URLSearchParams({
        slug: 'master-state',
        action: currentStateAction,
        id: id,
        name: name,
        country_id: country_id,
        status: 'Active'
    });
    fetch('master-action.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: body.toString()
    }).then(r => r.json()).then(d => {
        if(d.ok) window.location.reload();
        else alert('Error: ' + (d.error || 'Unknown'));
    });
}
function deleteMaster(slug, id) {
    if(!confirm('Deactivate this state?')) return;
    const body = new URLSearchParams({ slug, action: 'delete', id, name: '-' });
    fetch('master-action.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: body.toString()
    }).then(r => r.json()).then(d => { if(d.ok) window.location.reload(); });
}
function filterStateTable(val) {
    const q = val.toLowerCase();
    const rows = document.querySelectorAll('#stateTable tbody tr');
    rows.forEach(r => {
        const text = r.innerText.toLowerCase();
        r.style.display = text.includes(q) ? '' : 'none';
    });
}
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>
