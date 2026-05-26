<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'Success Stories (CMS)';
$adminCurrent = 'cms-stories';

require __DIR__ . '/includes/head.php';

$db = sathi_db();
$result = $db->query('SELECT id, groom_name, bride_name, status, created_at FROM success_stories ORDER BY id DESC LIMIT 50');
$rows = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>

<section class="admin-page-placeholder">
  <div class="admin-glass-card admin-page-hero admin-page-hero-top">
    <span class="admin-page-icon" aria-hidden="true"><i class="fas fa-heart"></i></span>
    <h2>Success stories</h2>
    <p class="lead">MySQL `success_stories`.</p>
  </div>

  <div class="admin-glass-card" style="margin-bottom: 20px;">
    <div style="display:flex; justify-content:space-between; align-items:center;">
      <h2 style="margin:0;" id="formTitle">Add Success Story</h2>
      <button type="button" class="admin-btn admin-btn-outline" onclick="resetForm()"
        style="padding: 6px 12px; font-size: 12px; display:none;" id="btnCancelEdit">Cancel Edit</button>
    </div>
    <div class="admin-form-grid" style="margin-top: 15px;">
      <input type="hidden" id="story_id" value="">
      <div class="admin-form-field">
        <span>Groom Name</span>
        <input type="text" id="groom_name" placeholder="Groom's name...">
      </div>
      <div class="admin-form-field">
        <span>Bride Name</span>
        <input type="text" id="bride_name" placeholder="Bride's name...">
      </div>
      <div class="admin-form-field">
        <span>Couple Image</span>
        <input type="file" id="story_image" accept="image/*">
      </div>
      <div class="admin-form-field">
        <span>Status</span>
        <select id="story_status">
          <option value="1">Published / On</option>
          <option value="0">Draft / Off</option>
        </select>
      </div>
      <div class="admin-form-field" style="grid-column: 1/-1;">
        <span>Story Content</span>
        <textarea id="story_content" rows="4" placeholder="Write their success story..."></textarea>
      </div>
      <div class="admin-form-actions" style="grid-column: 1/-1; display:flex; gap:10px; align-items:center;">
        <button type="button" class="admin-btn admin-btn-primary" onclick="saveStory()">Save Story</button>
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
            <th>Couple</th>
            <th>Status</th>
            <th>Created</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($rows) === 0): ?>
            <tr>
              <td colspan="5" style="text-align:center;">No stories.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($rows as $s): ?>
              <tr>
                <td>
                  <?php if (!empty($s['image'])): ?>
                    <img src="../<?php echo htmlspecialchars($s['image'], ENT_QUOTES, 'UTF-8'); ?>" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                  <?php else: ?>
                    <span style="color:#ccc;">No img</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php echo htmlspecialchars(trim(($s['groom_name'] ?? '') . ' & ' . ($s['bride_name'] ?? '')), ENT_QUOTES, 'UTF-8'); ?>
                </td>
                <td><span
                    class="admin-badge <?php echo ((int) ($s['status'] ?? 0)) === 1 ? 'ok' : 'pending'; ?>"><?php echo ((int) ($s['status'] ?? 0)) === 1 ? 'On' : 'Off'; ?></span>
                </td>
                <td><?php echo htmlspecialchars(substr((string) ($s['created_at'] ?? ''), 0, 10), ENT_QUOTES, 'UTF-8'); ?>
                </td>
                <td>
                  <div class="admin-actions-inline">
                    <button type="button" class="admin-btn-ghost admin-btn-sm"
                      onclick="editStory(<?php echo $s['id']; ?>, '<?php echo htmlspecialchars(addslashes((string) $s['groom_name']), ENT_QUOTES, 'UTF-8'); ?>', '<?php echo htmlspecialchars(addslashes((string) $s['bride_name']), ENT_QUOTES, 'UTF-8'); ?>', <?php echo (int) ($s['status'] ?? 0); ?>, '<?php echo htmlspecialchars(addslashes((string) ($s['story'] ?? '')), ENT_QUOTES, 'UTF-8'); ?>')"
                      title="Edit"><i class="fas fa-pen"></i></button>
                    <button type="button" class="admin-btn-ghost admin-btn-sm"
                      onclick="deleteStory(<?php echo $s['id']; ?>)" title="Delete"
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
    document.getElementById('story_id').value = '';
    document.getElementById('groom_name').value = '';
    document.getElementById('bride_name').value = '';
    document.getElementById('story_image').value = '';
    document.getElementById('story_content').value = '';
    document.getElementById('story_status').value = '1';
    document.getElementById('formTitle').innerText = 'Add Success Story';
    document.getElementById('btnCancelEdit').style.display = 'none';
  }

  function editStory(id, groom, bride, status, storyContent) {
    document.getElementById('story_id').value = id;
    document.getElementById('groom_name').value = groom;
    document.getElementById('bride_name').value = bride;
    document.getElementById('story_image').value = '';
    document.getElementById('story_content').value = storyContent || '';
    document.getElementById('story_status').value = status;
    document.getElementById('formTitle').innerText = 'Edit Story (ID: ' + id + ')';
    document.getElementById('btnCancelEdit').style.display = 'inline-block';
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function saveStory() {
    const id = document.getElementById('story_id').value;
    const groom = document.getElementById('groom_name').value.trim();
    const bride = document.getElementById('bride_name').value.trim();
    const storyContent = document.getElementById('story_content').value.trim();
    const status = document.getElementById('story_status').value;
    const imageInput = document.getElementById('story_image');
    const saveLabel = document.getElementById('saveStatus');

    if (!groom || !bride) {
      saveLabel.innerText = 'Both names are required.';
      saveLabel.style.color = 'red';
      return;
    }

    saveLabel.innerText = 'Saving...';
    saveLabel.style.color = '#666';

    const formData = new FormData();
    formData.append('type', 'story');
    formData.append('action', id ? 'edit' : 'add');
    if (id) formData.append('id', id);
    formData.append('groom_name', groom);
    formData.append('bride_name', bride);
    formData.append('story', storyContent);
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

  function deleteStory(id) {
    Swal.fire({
      title: 'Are you sure?',
      text: "Are you sure you want to delete this story?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#e94e77',
      cancelButtonColor: '#6b7280',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        const formData = new FormData();
        formData.append('type', 'story');
        formData.append('action', 'delete');
        formData.append('id', id);

        fetch('cms-action.php', { method: 'POST', body: formData })
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