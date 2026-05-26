<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';
require_once dirname(__DIR__) . '/config/database.php';

$pageTitle = 'Mandir';
$adminCurrent = 'master-mandir';

require __DIR__ . '/includes/head.php';

$db = sathi_db();
$mandirs = [];
$res = $db->query("SELECT id, name, status, created_at FROM mandirs ORDER BY name");
if ($res) {
    while($row = $res->fetch_assoc()) {
        $mandirs[] = $row;
    }
}

$pmHeroTitle = 'Mandir / Temple';
$pmHeroLead = 'Manage mandirs (Community-Based Identity Verification).';
$pmHeroIcon = 'fas fa-vihara';
?>
<section class="admin-page-placeholder">
  <div class="admin-glass-card admin-page-hero admin-page-hero-top">
    <span class="admin-page-icon" aria-hidden="true"><i class="fas fa-vihara"></i></span>
    <h2>Mandir Management</h2>
    <p class="lead"><?php echo htmlspecialchars($pmHeroLead); ?></p>
  </div>

  <div class="admin-static-toolbar">
    <button type="button" class="admin-btn admin-btn-primary" onclick="showAddModal()">Add Mandir</button>
    <input type="search" class="admin-input-search" placeholder="Search mandirs..." style="max-width:320px;" oninput="filterTable(this.value)">
  </div>

  <div class="admin-glass-card">
    <div class="admin-table-wrap">
      <table class="admin-table" id="dataTable">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($mandirs as $i => $row): ?>
          <tr>
            <td><?php echo $i + 1; ?></td>
            <td><strong><?php echo htmlspecialchars($row['name']); ?></strong></td>
            <td><span class="admin-badge <?php echo $row['status'] === 'Active' ? 'ok' : 'pending'; ?>"><?php echo $row['status']; ?></span></td>
            <td>
               <button class="admin-btn admin-btn-secondary admin-btn-sm" onclick="editModal(<?php echo htmlspecialchars(json_encode($row)); ?>)">Edit</button>
               <button class="admin-btn admin-btn-secondary admin-btn-sm" onclick="deleteRow(<?php echo $row['id']; ?>)">Delete</button>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<div id="dataModal" class="admin-modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
  <div class="admin-glass-card" style="width:100%; max-width:400px; padding:24px;">
    <h3 id="modalTitle">Add Mandir</h3>
    <div class="admin-form-field" style="margin-bottom:16px;">
      <label>Name</label>
      <input type="text" id="dataName" class="admin-input" style="width:100%;">
    </div>
    <div class="admin-form-field" style="margin-bottom:16px;">
      <label>Status</label>
      <select id="dataStatus" class="admin-input" style="width:100%;">
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
      </select>
    </div>
    <div style="display:flex; gap:12px; margin-top:24px;">
      <button type="button" class="admin-btn admin-btn-primary" onclick="saveData()">Save</button>
      <button type="button" class="admin-btn admin-btn-secondary" onclick="closeModal()">Cancel</button>
    </div>
    <input type="hidden" id="dataId">
  </div>
</div>

<script>
let currentAction = 'add';
function showAddModal() {
    currentAction = 'add';
    document.getElementById('modalTitle').textContent = 'Add Mandir';
    document.getElementById('dataName').value = '';
    document.getElementById('dataStatus').value = 'Active';
    document.getElementById('dataId').value = '';
    document.getElementById('dataModal').style.display = 'flex';
}
function editModal(row) {
    currentAction = 'edit';
    document.getElementById('modalTitle').textContent = 'Edit Mandir';
    document.getElementById('dataName').value = row.name;
    document.getElementById('dataStatus').value = row.status;
    document.getElementById('dataId').value = row.id;
    document.getElementById('dataModal').style.display = 'flex';
}
function closeModal() {
    document.getElementById('dataModal').style.display = 'none';
}
function saveData() {
    const name = document.getElementById('dataName').value;
    const status = document.getElementById('dataStatus').value;
    const id = document.getElementById('dataId').value;
    if(!name) return Swal.fire({icon: 'error', text: 'Enter name', confirmButtonColor: '#e94e77'});
    
    const body = new URLSearchParams({
        table: 'mandirs',
        action: currentAction,
        id: id,
        name: name,
        status: status
    });
    
    fetch('custom-master-action.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: body.toString()
    }).then(r => r.json()).then(d => {
        if(d.ok) window.location.reload();
        else Swal.fire({icon: 'error', text: 'Error: ' + (d.error || 'Unknown'), confirmButtonColor: '#e94e77'});
    });
}
function deleteRow(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'Are you sure you want to delete this row?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e94e77',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            const body = new URLSearchParams({ table: 'mandirs', action: 'delete', id: id });
            fetch('custom-master-action.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: body.toString()
            }).then(r => r.json()).then(d => { if(d.ok) window.location.reload(); });
        }
    });
}
function filterTable(val) {
    const q = val.toLowerCase();
    const rows = document.querySelectorAll('#dataTable tbody tr');
    rows.forEach(r => {
        const text = r.innerText.toLowerCase();
        r.style.display = text.includes(q) ? '' : 'none';
    });
}
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>
