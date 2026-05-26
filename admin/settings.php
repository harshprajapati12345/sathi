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
    <h2 style="margin-top:0;font-size:1.05rem;">Registration</h2>
    <div class="admin-form-grid">
      <div class="admin-form-field">
        <span>Enable Payment on Registration</span>
        <label class="admin-switch" style="margin-top: 8px;">
          <input type="checkbox" id="set_payment_enabled" <?php echo (($settings['payment_enabled'] ?? '0') === '1') ? 'checked' : ''; ?>>
          <span class="admin-switch-slider"></span>
        </label>
        <p style="font-size: 11px; color: #6b7280; margin-top: 6px;">If disabled, new users can register for free
          without seeing the payment step.</p>
      </div>
    </div>
    <div style="margin-top:24px; display:flex; gap:12px; align-items:center;">
      <button type="button" class="admin-btn admin-btn-primary" id="saveSiteSettings">Save all settings</button>
      <span id="saveStatus" style="font-size:0.9rem; color:#666;"></span>
    </div>
  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const btnSave = document.getElementById('saveSiteSettings');
    const status = document.getElementById('saveStatus');

    btnSave.addEventListener('click', function () {
      btnSave.disabled = true;

      const settings = {
        payment_enabled: document.getElementById('set_payment_enabled').checked ? '1' : '0'
      };

      fetch('site-settings-action.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ settings: settings })
      })
        .then(r => r.json())
        .then(data => {
          if (data.ok) {
            Swal.fire({icon: 'success', title: 'Saved!', text: 'Settings saved successfully!', confirmButtonColor: '#e94e77'});
          } else {
            throw new Error(data.error || 'Unknown error');
          }
        })
        .catch(err => {
          Swal.fire({icon: 'error', text: 'Error: ' + err.message, confirmButtonColor: '#e94e77'});
        })
        .finally(() => {
          btnSave.disabled = false;
        });
    });
  });
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>