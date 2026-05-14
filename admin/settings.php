<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'Settings';
$adminCurrent = 'settings';

require __DIR__ . '/includes/head.php';
?>

<?php
$settings = sathi_site_settings_all();
?>
<section class="admin-page-placeholder">
  <div class="admin-glass-card admin-page-hero admin-page-hero-top">
    <span class="admin-page-icon" aria-hidden="true"><i class="fas fa-gear"></i></span>
    <h2>Settings</h2>
    <p class="lead">Site-wide configuration — update your bureau branding and defaults.</p>
  </div>

  <div class="admin-glass-card">
    <h2 style="margin-top:0;font-size:1.05rem;">General</h2>
    <div class="admin-form-grid">
      <div class="admin-form-field">
        <span>Site name</span>
        <input type="text" id="set_site_name" value="<?php echo htmlspecialchars($settings['site_name'] ?? 'Shadikibaat'); ?>">
      </div>
      <div class="admin-form-field">
        <span>Support email</span>
        <input type="email" id="set_support_email" value="<?php echo htmlspecialchars($settings['support_email'] ?? 'support@shadikibaat.com'); ?>">
      </div>
    </div>
  </div>

  <div class="admin-glass-card">
    <h2 style="margin-top:0;font-size:1.05rem;">Payment defaults</h2>
    <div class="admin-form-grid">
      <div class="admin-form-field">
        <span>Currency</span>
        <input type="text" id="set_currency" value="<?php echo htmlspecialchars($settings['currency'] ?? 'INR'); ?>">
      </div>
      <div class="admin-form-field">
        <span>Tax label</span>
        <input type="text" id="set_tax_label" value="<?php echo htmlspecialchars($settings['tax_label'] ?? 'GST'); ?>">
      </div>
    </div>
  </div>

  <div class="admin-glass-card">
    <h2 style="margin-top:0;font-size:1.05rem;">SEO</h2>
    <div class="admin-form-grid">
      <div class="admin-form-field" style="grid-column:1/-1;">
        <span>Meta title</span>
        <input type="text" id="set_meta_title" value="<?php echo htmlspecialchars($settings['meta_title'] ?? 'Shadikibaat — Matrimonial'); ?>">
      </div>
      <div class="admin-form-field" style="grid-column:1/-1;">
        <span>Meta description</span>
        <textarea id="set_meta_description" rows="3"><?php echo htmlspecialchars($settings['meta_description'] ?? ''); ?></textarea>
      </div>
    </div>
    <div style="margin-top:24px; display:flex; gap:12px; align-items:center;">
        <button type="button" class="admin-btn admin-btn-primary" id="saveSiteSettings">Save all settings</button>
        <span id="saveStatus" style="font-size:0.9rem; color:#666;"></span>
    </div>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnSave = document.getElementById('saveSiteSettings');
    const status = document.getElementById('saveStatus');
    
    btnSave.addEventListener('click', function() {
        btnSave.disabled = true;
        status.textContent = 'Saving…';
        status.style.color = '#666';
        
        const settings = {
            site_name: document.getElementById('set_site_name').value,
            support_email: document.getElementById('set_support_email').value,
            currency: document.getElementById('set_currency').value,
            tax_label: document.getElementById('set_tax_label').value,
            meta_title: document.getElementById('set_meta_title').value,
            meta_description: document.getElementById('set_meta_description').value
        };
        
        fetch('site-settings-action.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ settings: settings })
        })
        .then(r => r.json())
        .then(data => {
            if (data.ok) {
                status.textContent = 'Settings saved successfully!';
                status.style.color = 'green';
                setTimeout(() => { status.textContent = ''; }, 3000);
            } else {
                throw new Error(data.error || 'Unknown error');
            }
        })
        .catch(err => {
            status.textContent = 'Error: ' + err.message;
            status.style.color = 'red';
        })
        .finally(() => {
            btnSave.disabled = false;
        });
    });
});
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>
