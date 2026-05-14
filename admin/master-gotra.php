<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/master-storage.php';

$pageTitle = 'Gotra';
$adminCurrent = 'master-gotra';

require __DIR__ . '/includes/head.php';

$pmDbSlug = 'master-gotra';
$pmDbRows = sathi_master_storage_get($pmDbSlug);

$db = sathi_db();
$religionsRes = $db->query("SELECT id, name FROM religions WHERE status = 1 ORDER BY name");
$religions = [];
if ($religionsRes) {
    while($r = $religionsRes->fetch_assoc()) $religions[] = $r;
}

$pmHeroTitle = 'Gotra / Caste';
$pmHeroLead = 'Manage gotras and their parent religions.';
$pmHeroIcon = 'fas fa-om';
?>
<section class="admin-page-placeholder">
  <div class="admin-glass-card admin-page-hero admin-page-hero-top">
    <span class="admin-page-icon" aria-hidden="true"><i class="fas fa-om"></i></span>
    <h2>Gotra Management</h2>
    <p class="lead"><?php echo htmlspecialchars($pmHeroLead); ?></p>
  </div>

  <div class="admin-static-toolbar">
    <button type="button" class="admin-btn admin-btn-primary" onclick="showAddGotraModal()">Add Gotra</button>
    <input type="search" class="admin-input-search" placeholder="Search gotras..." style="max-width:320px;" oninput="filterGotraTable(this.value)">
  </div>

  <div class="admin-glass-card">
    <div class="admin-table-wrap">
      <table class="admin-table" id="gotraTable">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Religion ID</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($pmDbRows as $i => $row): ?>
          <tr>
            <td><?php echo $i + 1; ?></td>
            <td><strong><?php echo htmlspecialchars($row['name']); ?></strong></td>
            <td><?php echo (int)($row['religion_id'] ?? 0); ?></td>
            <td><span class="admin-badge <?php echo $row['status'] === 'Active' ? 'ok' : 'pending'; ?>"><?php echo $row['status']; ?></span></td>
            <td>
               <button class="admin-btn admin-btn-secondary admin-btn-sm" onclick="editGotra(<?php echo htmlspecialchars(json_encode($row)); ?>)">Edit</button>
               <button class="admin-btn admin-btn-secondary admin-btn-sm" onclick="deleteMaster('master-gotra', '<?php echo $row['id']; ?>')">Delete</button>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<div id="gotraModal" class="admin-modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
  <div class="admin-glass-card" style="width:100%; max-width:400px; padding:24px;">
    <h3 id="modalTitle">Add Gotra</h3>
    <div class="admin-form-field" style="margin-bottom:16px;">
      <label>Name</label>
      <input type="text" id="gotraName" class="admin-input" style="width:100%;">
    </div>
    <div class="admin-form-field" style="margin-bottom:16px;">
      <label>Religion</label>
      <select id="gotraReligionId" class="admin-input" style="width:100%;">
        <?php foreach ($religions as $rel): ?>
        <option value="<?php echo $rel['id']; ?>"><?php echo htmlspecialchars($rel['name']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div style="display:flex; gap:12px; margin-top:24px;">
      <button type="button" class="admin-btn admin-btn-primary" onclick="saveGotra()">Save</button>
      <button type="button" class="admin-btn admin-btn-secondary" onclick="closeGotraModal()">Cancel</button>
    </div>
    <input type="hidden" id="gotraId">
  </div>
</div>

<script>
let currentGotraAction = 'add';
function showAddGotraModal() {
    currentGotraAction = 'add';
    document.getElementById('modalTitle').textContent = 'Add Gotra';
    document.getElementById('gotraName').value = '';
    document.getElementById('gotraId').value = '';
    document.getElementById('gotraModal').style.display = 'flex';
}
function editGotra(row) {
    currentGotraAction = 'edit';
    document.getElementById('modalTitle').textContent = 'Edit Gotra';
    document.getElementById('gotraName').value = row.name;
    document.getElementById('gotraId').value = row.id;
    document.getElementById('gotraReligionId').value = row.religion_id;
    document.getElementById('gotraModal').style.display = 'flex';
}
function closeGotraModal() {
    document.getElementById('gotraModal').style.display = 'none';
}
function saveGotra() {
    const name = document.getElementById('gotraName').value;
    const rel_id = document.getElementById('gotraReligionId').value;
    const id = document.getElementById('gotraId').value;
    if(!name) return alert('Enter name');
    const body = new URLSearchParams({
        slug: 'master-gotra',
        action: currentGotraAction,
        id: id,
        name: name,
        religion_id: rel_id,
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
    if(!confirm('Deactivate this row?')) return;
    const body = new URLSearchParams({ slug, action: 'delete', id, name: '-' });
    fetch('master-action.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: body.toString()
    }).then(r => r.json()).then(d => { if(d.ok) window.location.reload(); });
}
function filterGotraTable(val) {
    const q = val.toLowerCase();
    const rows = document.querySelectorAll('#gotraTable tbody tr');
    rows.forEach(r => {
        const text = r.innerText.toLowerCase();
        r.style.display = text.includes(q) ? '' : 'none';
    });
}
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>
