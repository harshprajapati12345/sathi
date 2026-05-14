<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'Blogs';
$adminCurrent = 'cms-blogs';

require __DIR__ . '/includes/head.php';

$db = sathi_db();
$result = $db->query('SELECT id, title, status, created_at FROM blogs ORDER BY created_at DESC LIMIT 100');
$rows = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>

<section class="admin-page-placeholder">
  <div class="admin-glass-card admin-page-hero admin-page-hero-top">
    <span class="admin-page-icon" aria-hidden="true"><i class="fas fa-newspaper"></i></span>
    <h2>Blogs</h2>
    <p class="lead">MySQL `blogs`.</p>
  </div>

  <div class="admin-glass-card" style="margin-bottom: 20px;">
    <div style="display:flex; justify-content:space-between; align-items:center;">
      <h2 style="margin:0;" id="formTitle">Add New Blog</h2>
      <button type="button" class="admin-btn admin-btn-outline" onclick="resetForm()"
        style="padding: 6px 12px; font-size: 12px; display:none;" id="btnCancelEdit">Cancel Edit</button>
    </div>
    <div class="admin-form-grid" style="margin-top: 15px;">
      <input type="hidden" id="blog_id" value="">
      <div class="admin-form-field">
        <span>Title</span>
        <input type="text" id="blog_title" placeholder="Blog post title...">
      </div>
      <div class="admin-form-field">
        <span>Feature Image</span>
        <input type="file" id="blog_image" accept="image/*">
      </div>
      <div class="admin-form-field">
        <span>Status</span>
        <select id="blog_status">
          <option value="published">Published</option>
          <option value="pending">Pending</option>
        </select>
      </div>
      <div class="admin-form-field" style="grid-column: 1/-1;">
        <span>Content</span>
        <textarea id="blog_content" rows="6" placeholder="Write blog post content..."></textarea>
      </div>
      <div class="admin-form-actions" style="grid-column: 1/-1; display:flex; gap:10px; align-items:center;">
        <button type="button" class="admin-btn admin-btn-primary" onclick="saveBlog()">Save Blog</button>
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
            <th>Status</th>
            <th>Created</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($rows) === 0): ?>
            <tr>
              <td colspan="5" style="text-align:center;">No blog posts.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($rows as $b): ?>
              <tr>
                <td>
                  <?php if (!empty($b['image'])): ?>
                    <img src="../<?php echo htmlspecialchars($b['image'], ENT_QUOTES, 'UTF-8'); ?>"
                      style="width: 50px; height: 30px; object-fit: cover; border-radius: 4px;">
                  <?php else: ?>
                    <span style="color:#ccc;">No img</span>
                  <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars((string) ($b['title'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                <td><span
                    class="admin-badge <?php echo ($b['status'] ?? '') === 'published' ? 'ok' : 'pending'; ?>"><?php echo htmlspecialchars((string) ($b['status'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></span>
                </td>
                <td><?php echo htmlspecialchars(substr((string) ($b['created_at'] ?? ''), 0, 10), ENT_QUOTES, 'UTF-8'); ?>
                </td>
                <td>
                  <div class="admin-actions-inline">
                    <button type="button" class="admin-btn-ghost admin-btn-sm"
                      onclick="editBlog(<?php echo $b['id']; ?>, '<?php echo htmlspecialchars(addslashes((string) $b['title']), ENT_QUOTES, 'UTF-8'); ?>', '<?php echo htmlspecialchars(addslashes((string) $b['status']), ENT_QUOTES, 'UTF-8'); ?>')"
                      title="Edit"><i class="fas fa-pen"></i></button>
                    <button type="button" class="admin-btn-ghost admin-btn-sm" onclick="deleteBlog(<?php echo $b['id']; ?>)"
                      title="Delete" style="color:red; border-color:rgba(255,0,0,0.2);"><i
                        class="fas fa-trash"></i></button>
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
    document.getElementById('blog_id').value = '';
    document.getElementById('blog_title').value = '';
    document.getElementById('blog_image').value = '';
    document.getElementById('blog_content').value = '';
    document.getElementById('blog_status').value = 'published';
    document.getElementById('formTitle').innerText = 'Add New Blog';
    document.getElementById('btnCancelEdit').style.display = 'none';
  }

  function editBlog(id, title, status) {
    document.getElementById('blog_id').value = id;
    document.getElementById('blog_title').value = title;
    document.getElementById('blog_image').value = '';
    // Note: To fully populate content, we would need to fetch the content from the server via AJAX, 
    // or include it in a data attribute (which could be large). For now, editing overwrites content or requires re-entry if we don't fetch it.
    document.getElementById('blog_content').value = 'Please re-enter or fetch content to edit...';
    document.getElementById('blog_status').value = status;
    document.getElementById('formTitle').innerText = 'Edit Blog (ID: ' + id + ')';
    document.getElementById('btnCancelEdit').style.display = 'inline-block';
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function saveBlog() {
    const id = document.getElementById('blog_id').value;
    const title = document.getElementById('blog_title').value.trim();
    const content = document.getElementById('blog_content').value.trim();
    const status = document.getElementById('blog_status').value;
    const imageInput = document.getElementById('blog_image');
    const saveLabel = document.getElementById('saveStatus');

    if (!title || !content) {
      saveLabel.innerText = 'Title and Content are required.';
      saveLabel.style.color = 'red';
      return;
    }

    saveLabel.innerText = 'Saving...';
    saveLabel.style.color = '#666';

    const formData = new FormData();
    formData.append('type', 'blog');
    formData.append('action', id ? 'edit' : 'add');
    if (id) formData.append('id', id);
    formData.append('title', title);
    formData.append('content', content);
    formData.append('status', status);

    if (imageInput.files.length > 0) {
      formData.append('image', imageInput.files[0]);
    }

    fetch('cms-action.php', { method: 'POST', body: formData })
      .then(r => r.json())
      .then(res => {
        if (res.ok) {
          window.location.reload();
        } else {
          throw new Error(res.error || 'Failed to save');
        }
      })
      .catch(err => {
        saveLabel.innerText = 'Err: ' + err.message;
        saveLabel.style.color = 'red';
      });
  }

  function deleteBlog(id) {
    if (!confirm('Are you sure you want to delete this blog?')) return;
    const formData = new FormData();
    formData.append('type', 'blog');
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
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>