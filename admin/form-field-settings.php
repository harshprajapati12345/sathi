<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';
require_once dirname(__DIR__) . '/includes/registration-config.php';

$pageTitle = 'Registration Field Visibility';
$adminCurrent = 'form-field-settings';

$fieldLabels = sathi_registration_field_labels();
$fieldSettings = sathi_registration_field_settings();

require __DIR__ . '/includes/head.php';
?>

<section class="admin-page-placeholder">
  <div class="admin-glass-card admin-page-hero admin-page-hero-top">
    <span class="admin-page-icon" aria-hidden="true"><i class="fas fa-sliders"></i></span>
    <h2>Registration field visibility &amp; required</h2>
    <p class="lead">Manage which fields appear on the registration wizard and which are mandatory.</p>
  </div>

  <div class="admin-glass-card">
    <div class="admin-table-wrap">
      <table class="admin-table admin-field-matrix" id="fieldMatrix">
        <thead>
          <tr>
            <th>Field</th>
            <th style="width:120px;text-align:center;">Visible</th>
            <th style="width:120px;text-align:center;">Required</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($fieldLabels as $key => $label):
              $cfg = $fieldSettings[$key] ?? ['visible' => true, 'required' => false];
              $vis = !empty($cfg['visible']);
              $req = !empty($cfg['required']);
          ?>
          <tr data-key="<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); ?>">
            <td><strong><?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?></strong><br><span class="admin-field-key"><?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); ?></span></td>
            <td style="text-align:center;">
              <label class="admin-switch admin-switch--table" title="Visible">
                <input type="checkbox" class="vis-toggle" <?php echo $vis ? 'checked' : ''; ?> aria-label="Visible: <?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>">
                <span class="admin-switch-slider"></span>
              </label>
            </td>
            <td style="text-align:center;">
              <label class="admin-switch admin-switch--table" title="Required">
                <input type="checkbox" class="req-toggle" <?php echo $req ? 'checked' : ''; ?> aria-label="Required: <?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>">
                <span class="admin-switch-slider"></span>
              </label>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <div style="margin-top:24px; display:flex; gap:12px; align-items:center;">
      <button type="button" class="admin-btn admin-btn-primary" id="saveFieldRules">Save changes</button>
      <span id="saveStatus" style="font-size:0.9rem; color:#666;"></span>
    </div>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnSave = document.getElementById('saveFieldRules');
    const status = document.getElementById('saveStatus');
    
    btnSave.addEventListener('click', function() {
        btnSave.disabled = true;
        status.textContent = 'Saving…';
        
        const fields = {};
        document.querySelectorAll('#fieldMatrix tbody tr').forEach(tr => {
            const key = tr.dataset.key;
            fields[key] = {
                visible: tr.querySelector('.vis-toggle').checked,
                required: tr.querySelector('.req-toggle').checked
            };
        });
        
        fetch('registration-settings-action.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ fields: fields })
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
