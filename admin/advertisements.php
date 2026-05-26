<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'Advertisements';
$adminCurrent = 'cms-ads';

require __DIR__ . '/includes/head.php';

$db = sathi_db();
$result = $db->query("SELECT id, title, image, position, status, link, created_at FROM advertisements ORDER BY id DESC");
$rows = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>

<section class="admin-page-placeholder">
  <div class="admin-glass-card admin-page-hero admin-page-hero-top">
    <span class="admin-page-icon" aria-hidden="true"><i class="fas fa-ad"></i></span>
    <h2>Advertisements</h2>
    <p class="lead">Manage banner ads on the homepage.</p>
  </div>

  <div class="admin-glass-card" style="margin-bottom: 20px;">
    <div style="display:flex; justify-content:space-between; align-items:center;">
      <h2 style="margin:0;" id="formTitle">Add Advertisement</h2>
      <button type="button" class="admin-btn admin-btn-outline" onclick="resetForm()"
        style="padding: 6px 12px; font-size: 12px; display:none;" id="btnCancelEdit">Cancel Edit</button>
    </div>
    <div class="admin-form-grid" style="margin-top: 15px;">
      <input type="hidden" id="ad_id" value="">
      <div class="admin-form-field">
        <span>Title</span>
        <input type="text" id="ad_title" placeholder="Ad Title...">
      </div>
      <div class="admin-form-field">
        <span>Link URL</span>
        <input type="text" id="ad_link" placeholder="https://...">
      </div>
      <div class="admin-form-field">
        <span>Banner Image</span>
        <input type="file" id="ad_image" accept="image/*">
      </div>
      <div class="admin-form-field">
        <span>Position</span>
        <select id="ad_position">
          <option value="top">Top (Below Header)</option>
          <option value="bottom">Bottom (Above Footer)</option>
          <option value="left">Left (Floating Sidebar)</option>
          <option value="right">Right (Floating Sidebar)</option>
        </select>
      </div>
      <div class="admin-form-field">
        <span>Status</span>
        <select id="ad_status">
          <option value="1">Active / On</option>
          <option value="0">Draft / Off</option>
        </select>
      </div>
      <div class="admin-form-actions" style="grid-column: 1/-1; display:flex; gap:10px; align-items:center;">
        <button type="button" class="admin-btn admin-btn-primary" onclick="saveAd()">Save Ad</button>
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
            <th>Position</th>
            <th>Status</th>
            <th>Created</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($rows) === 0): ?>
            <tr>
              <td colspan="6" style="text-align:center;">No advertisements found.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($rows as $ad): ?>
              <tr>
                <td>
                  <?php if (!empty($ad['image'])): ?>
                    <img src="../<?php echo htmlspecialchars($ad['image'], ENT_QUOTES, 'UTF-8'); ?>" style="width: 50px; height: 30px; object-fit: cover; border-radius: 4px;">
                  <?php else: ?>
                    <span style="color:#ccc;">No img</span>
                  <?php endif; ?>
                </td>
                <td>
                    <?php echo htmlspecialchars((string) ($ad['title'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>
                    <?php if(!empty($ad['link'])): ?><br><small><a href="<?php echo htmlspecialchars($ad['link'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank" style="color:var(--pink);">Link</a></small><?php endif; ?>
                </td>
                <td><span style="text-transform: capitalize;"><?php echo htmlspecialchars((string) ($ad['position'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></span></td>
                <td><span
                    class="admin-badge <?php echo ((int) ($ad['status'] ?? 0)) === 1 ? 'ok' : 'pending'; ?>"><?php echo ((int) ($ad['status'] ?? 0)) === 1 ? 'Active' : 'Off'; ?></span>
                </td>
                <td><?php echo htmlspecialchars(substr((string) ($ad['created_at'] ?? ''), 0, 10), ENT_QUOTES, 'UTF-8'); ?>
                </td>
                <td>
                  <div class="admin-actions-inline">
                    <button type="button" class="admin-btn-ghost admin-btn-sm"
                      onclick="editAd(<?php echo $ad['id']; ?>, '<?php echo htmlspecialchars(addslashes((string) $ad['title']), ENT_QUOTES, 'UTF-8'); ?>', '<?php echo htmlspecialchars(addslashes((string) $ad['link']), ENT_QUOTES, 'UTF-8'); ?>', '<?php echo htmlspecialchars(addslashes((string) $ad['position']), ENT_QUOTES, 'UTF-8'); ?>', <?php echo (int) ($ad['status'] ?? 0); ?>)"
                      title="Edit"><i class="fas fa-pen"></i></button>
                    <button type="button" class="admin-btn-ghost admin-btn-sm"
                      onclick="deleteAd(<?php echo $ad['id']; ?>)" title="Delete"
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
    document.getElementById('ad_id').value = '';
    document.getElementById('ad_title').value = '';
    document.getElementById('ad_link').value = '';
    document.getElementById('ad_position').value = 'top';
    document.getElementById('ad_image').value = '';
    document.getElementById('ad_status').value = '1';
    document.getElementById('formTitle').innerText = 'Add Advertisement';
    document.getElementById('btnCancelEdit').style.display = 'none';
  }

  function editAd(id, title, link, position, status) {
    document.getElementById('ad_id').value = id;
    document.getElementById('ad_title').value = title;
    document.getElementById('ad_link').value = link;
    document.getElementById('ad_position').value = position;
    document.getElementById('ad_image').value = ''; 
    document.getElementById('ad_status').value = status;
    document.getElementById('formTitle').innerText = 'Edit Advertisement (ID: ' + id + ')';
    document.getElementById('btnCancelEdit').style.display = 'inline-block';
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function saveAd() {
    const id = document.getElementById('ad_id').value;
    const title = document.getElementById('ad_title').value.trim();
    const link = document.getElementById('ad_link').value.trim();
    const position = document.getElementById('ad_position').value;
    const status = document.getElementById('ad_status').value;
    const imageInput = document.getElementById('ad_image');
    const saveLabel = document.getElementById('saveStatus');

    if (!title) {
      saveLabel.innerText = 'Title is required.';
      saveLabel.style.color = 'red';
      return;
    }

    if (!id && imageInput.files.length === 0) {
      saveLabel.innerText = 'Image is required for new ad.';
      saveLabel.style.color = 'red';
      return;
    }

    saveLabel.innerText = 'Saving...';
    saveLabel.style.color = '#666';

    const formData = new FormData();
    formData.append('action', id ? 'edit' : 'add');
    if (id) formData.append('id', id);
    formData.append('title', title);
    formData.append('link', link);
    formData.append('position', position);
    formData.append('status', status);

    if (imageInput.files.length > 0) {
      formData.append('image', imageInput.files[0]);
    }

    fetch('api/advertisement-action.php', { method: 'POST', body: formData })
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

  function deleteAd(id) {
    Swal.fire({
      title: 'Are you sure?',
      text: "Are you sure you want to delete this advertisement?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#e94e77',
      cancelButtonColor: '#6b7280',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        const formData = new FormData();
        formData.append('action', 'delete');
        formData.append('id', id);

        fetch('api/advertisement-action.php', { method: 'POST', body: formData })
          .then(r => r.json())
          .then(res => {
            if (res.ok) window.location.reload();
            else Swal.fire({icon: 'error', text: 'Error: ' + (res.error || 'Failed'), confirmButtonColor: '#e94e77'});
          });
      }
    });
  }
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>
