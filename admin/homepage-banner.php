<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'Homepage Banner';
$adminCurrent = 'cms-banner';

require __DIR__ . '/includes/head.php';

$db = sathi_db();
$result = $db->query('SELECT id, title, subtitle, status, created_at FROM homepage_banners ORDER BY id DESC LIMIT 20');
$rows = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>

<section class="admin-page-placeholder">
  <div class="admin-glass-card admin-page-hero admin-page-hero-top">
    <span class="admin-page-icon" aria-hidden="true"><i class="fas fa-image"></i></span>
    <h2>Homepage banner</h2>
    <p class="lead">Rows from `homepage_banners`.</p>
  </div>

  <div class="admin-glass-card" style="margin-bottom: 20px;">
    <div style="display:flex; justify-content:space-between; align-items:center;">
      <h2 style="margin:0;" id="formTitle">Add Homepage Banner</h2>
      <button type="button" class="admin-btn admin-btn-outline" onclick="resetForm()"
        style="padding: 6px 12px; font-size: 12px; display:none;" id="btnCancelEdit">Cancel Edit</button>
    </div>
    <div class="admin-form-grid" style="margin-top: 15px;">
      <input type="hidden" id="banner_id" value="">
      <div class="admin-form-field">
        <span>Title</span>
        <input type="text" id="banner_title" placeholder="Banner Title...">
      </div>
      <div class="admin-form-field">
        <span>Subtitle</span>
        <input type="text" id="banner_subtitle" placeholder="Banner Subtitle...">
      </div>
      <div class="admin-form-field">
        <span>Banner Image</span>
        <input type="file" id="banner_image" accept="image/*">
      </div>
      <div class="admin-form-field">
        <span>Status</span>
        <select id="banner_status">
          <option value="1">Active / On</option>
          <option value="0">Draft / Off</option>
        </select>
      </div>
      <div class="admin-form-actions" style="grid-column: 1/-1; display:flex; gap:10px; align-items:center;">
        <button type="button" class="admin-btn admin-btn-primary" onclick="saveBanner()">Save Banner</button>
        <span id="saveStatus" style="font-size: 0.85rem;"></span>
      </div>
    </div>
  </div>

  <div class="admin-glass-card">
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Image</th>
            <th>Title</th>
            <th>Subtitle</th>
            <th>Status</th>
            <th>Created</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($rows) === 0): ?>
            <tr>
              <td colspan="6" style="text-align:center;">No banners.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($rows as $b): ?>
              <tr>
                <td>
                  <?php if (!empty($b['image'])): ?>
                    <img src="../<?php echo htmlspecialchars($b['image'], ENT_QUOTES, 'UTF-8'); ?>" style="width: 50px; height: 30px; object-fit: cover; border-radius: 4px;">
                  <?php else: ?>
                    <span style="color:#ccc;">No img</span>
                  <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars((string) ($b['title'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars((string) ($b['subtitle'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                <td><span
                    class="admin-badge <?php echo ((int) ($b['status'] ?? 0)) === 1 ? 'ok' : 'pending'; ?>"><?php echo ((int) ($b['status'] ?? 0)) === 1 ? 'Active' : 'Off'; ?></span>
                </td>
                <td><?php echo htmlspecialchars(substr((string) ($b['created_at'] ?? ''), 0, 10), ENT_QUOTES, 'UTF-8'); ?>
                </td>
                <td>
                  <div class="admin-actions-inline">
                    <button type="button" class="admin-btn-ghost admin-btn-sm"
                      onclick="editBanner(<?php echo $b['id']; ?>, '<?php echo htmlspecialchars(addslashes((string) $b['title']), ENT_QUOTES, 'UTF-8'); ?>', '<?php echo htmlspecialchars(addslashes((string) $b['subtitle']), ENT_QUOTES, 'UTF-8'); ?>', <?php echo (int) ($b['status'] ?? 0); ?>)"
                      title="Edit"><i class="fas fa-pen"></i></button>
                    <button type="button" class="admin-btn-ghost admin-btn-sm"
                      onclick="deleteBanner(<?php echo $b['id']; ?>)" title="Delete"
                      style="color:red; border-color:rgba(255,0,0,0.2);"><i class="fas fa-trash"></i></button>
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
  function resetForm() {
    document.getElementById('banner_id').value = '';
    document.getElementById('banner_title').value = '';
    document.getElementById('banner_subtitle').value = '';
    document.getElementById('banner_image').value = '';
    document.getElementById('banner_status').value = '1';
    document.getElementById('formTitle').innerText = 'Add Homepage Banner';
    document.getElementById('btnCancelEdit').style.display = 'none';
  }

  function editBanner(id, title, subtitle, status) {
    document.getElementById('banner_id').value = id;
    document.getElementById('banner_title').value = title;
    document.getElementById('banner_subtitle').value = subtitle;
    document.getElementById('banner_image').value = ''; // Don't try to populate file input
    document.getElementById('banner_status').value = status;
    document.getElementById('formTitle').innerText = 'Edit Banner (ID: ' + id + ')';
    document.getElementById('btnCancelEdit').style.display = 'inline-block';
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function saveBanner() {
    const id = document.getElementById('banner_id').value;
    const title = document.getElementById('banner_title').value.trim();
    const subtitle = document.getElementById('banner_subtitle').value.trim();
    const status = document.getElementById('banner_status').value;
    const imageInput = document.getElementById('banner_image');
    const saveLabel = document.getElementById('saveStatus');

    if (!title) {
      saveLabel.innerText = 'Title is required.';
      saveLabel.style.color = 'red';
      return;
    }

    saveLabel.innerText = 'Saving...';
    saveLabel.style.color = '#666';

    const formData = new FormData();
    formData.append('type', 'banner');
    formData.append('action', id ? 'edit' : 'add');
    if (id) formData.append('id', id);
    formData.append('title', title);
    formData.append('subtitle', subtitle);
    formData.append('status', status);

    if (imageInput.files.length > 0) {
      formData.append('image', imageInput.files[0]);
    }

    fetch('cms-action.php', { method: 'POST', body: formData })
      .then(r => r.json())
      .then(res => {
        if (res.ok) window.location.reload();
        else throw new Error(res.error || 'Failed to save');
      })
      .catch(err => {
        saveLabel.innerText = 'Err: ' + err.message;
        saveLabel.style.color = 'red';
      });
  }

  function deleteBanner(id) {
    if (!confirm('Are you sure you want to delete this banner?')) return;
    const formData = new FormData();
    formData.append('type', 'banner');
    formData.append('action', 'delete');
    formData.append('id', id);

    fetch('cms-action.php', { method: 'POST', body: formData })
      .then(r => r.json())
      .then(res => {
        if (res.ok) window.location.reload();
        else alert('Error: ' + (res.error || 'Failed'));
      });
  }
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>