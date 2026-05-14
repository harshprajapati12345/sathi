<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/user-storage.php';

$pageTitle = 'View Member';
$adminCurrent = 'members-all';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$member = $id > 0 ? sathi_user_repo_find_by_id($id) : null;

require __DIR__ . '/includes/head.php';
?>

<section class="admin-page-placeholder">
  <div class="admin-glass-card admin-page-hero admin-page-hero-top">
    <span class="admin-page-icon" aria-hidden="true"><i class="fas fa-id-card"></i></span>
    <h2>Member profile</h2>
    <p class="lead"><?php echo $member ? htmlspecialchars($member['email'], ENT_QUOTES, 'UTF-8') : 'Not found'; ?></p>
  </div>

  <?php if (!$member): ?>
    <div class="admin-glass-card">
      <p>Invalid member id.</p><a href="members.php" class="admin-btn admin-btn-secondary">Back</a>
    </div>
  <?php else: ?>
    <div class="admin-dashboard-row">
      <div class="admin-glass-card">
        <h2 style="margin-top:0;font-size:1rem;">Photo</h2>
        <?php if (!empty($member['profile_photo'])): ?>
          <img
            src="../uploads/profiles/<?php echo htmlspecialchars((string) $member['profile_photo'], ENT_QUOTES, 'UTF-8'); ?>"
            alt="" style="max-width:200px;height:auto;display:block;margin:0 auto;border-radius:10px;">
        <?php else: ?>
          <div class="admin-thumb" style="width:120px;height:120px;font-size:3rem;margin:0 auto;">👤</div>
        <?php endif; ?>
        <p style="text-align:center;margin:12px 0 0;color:var(--admin-muted);font-size:13px;">
          <?php echo htmlspecialchars((string) $member['name'], ENT_QUOTES, 'UTF-8'); ?></p>
      </div>
      <div class="admin-glass-card">
        <h2 style="margin-top:0;font-size:1rem;">Quick facts</h2>
        <ul style="margin:0;padding-left:1.1rem;line-height:1.8;font-size:14px;color:var(--admin-text);">
          <li><strong>ID:</strong> <?php echo (int) $member['id']; ?></li>
          <li><strong>Profile ID:</strong>
            <?php echo htmlspecialchars((string) ($member['profile_id'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></li>
          <li><strong>Gender:</strong>
            <?php echo htmlspecialchars((string) ($member['gender'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></li>
          <li><strong>Mobile:</strong>
            <?php echo htmlspecialchars((string) ($member['mobile'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></li>
          <li><strong>WhatsApp:</strong>
            <?php echo htmlspecialchars((string) ($member['whatsapp'] ?? 'N/A'), ENT_QUOTES, 'UTF-8'); ?></li>
          <li><strong>Membership:</strong>
            <?php echo htmlspecialchars((string) ($member['membership_status'] ?? 'Free'), ENT_QUOTES, 'UTF-8'); ?></li>
          <li><strong>Status:</strong>
            <?php echo htmlspecialchars((string) ($member['status'] ?? 'Pending'), ENT_QUOTES, 'UTF-8'); ?></li>
          <li><strong>Joined:</strong>
            <?php echo htmlspecialchars((string) ($member['created_at'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></li>
          <li><strong>Payment ID:</strong>
            <code style="background:rgba(0,0,0,0.2);padding:2px 6px;border-radius:4px;"><?php echo htmlspecialchars((string) ($member['razorpay_payment_id'] ?? 'N/A'), ENT_QUOTES, 'UTF-8'); ?></code></li>
        </ul>
        <div style="margin-top:20px;display:flex;gap:10px;flex-wrap:wrap;">
          <?php if (strtolower((string)$member['status']) !== 'approved' && strtolower((string)$member['status']) !== 'active'): ?>
            <button onclick="updateMemberStatus(<?php echo (int)$member['id']; ?>, 'approved')" class="admin-btn" style="background:#28a745;border:none;">Approve member</button>
          <?php endif; ?>
          <?php if (strtolower((string)$member['status']) !== 'rejected'): ?>
            <button onclick="updateMemberStatus(<?php echo (int)$member['id']; ?>, 'rejected')" class="admin-btn" style="background:#dc3545;border:none;">Reject member</button>
          <?php endif; ?>
          <a href="member-edit.php?id=<?php echo (int) $member['id']; ?>" class="admin-btn admin-btn-primary">Edit
            profile</a>
          <a href="members.php" class="admin-btn admin-btn-secondary">Back</a>
        </div>

        <script>
        function updateMemberStatus(id, status) {
            if(!confirm('Are you sure you want to set this member to ' + status + '?')) return;
            
            const fd = new FormData();
            fd.append('id', id);
            fd.append('status', status);
            
            fetch('api/update-member-status.php', {
                method: 'POST',
                body: fd
            })
            .then(r => r.json())
            .then(data => {
                if(data.ok) {
                    alert('Status updated successfully');
                    location.reload();
                } else {
                    alert('Error: ' + data.error);
                }
            })
            .catch(err => {
                console.error(err);
                alert('Connection error');
            });
        }
        </script>
      </div>
    </div>

    <div class="admin-dashboard-row" style="margin-top:24px;">
      <!-- Personal & Religion -->
      <div class="admin-glass-card">
        <h2 style="margin-top:0;font-size:1rem;"><i class="fas fa-pray"></i> Religious & Personal</h2>
        <table class="admin-table-info">
          <tr>
            <td>Digamber Jain:</td>
            <td><?php echo strtoupper((string) ($member['digamber_jain'] ?? 'no')); ?></td>
          </tr>
          <tr>
            <td>Religion:</td>
            <td><?php echo htmlspecialchars((string) ($member['religion'] ?? 'N/A'), ENT_QUOTES, 'UTF-8'); ?></td>
          </tr>
          <tr>
            <td>Mother Tongue:</td>
            <td><?php echo htmlspecialchars((string) ($member['mother_tongue_val'] ?? 'N/A'), ENT_QUOTES, 'UTF-8'); ?></td>
          </tr>
          <tr>
            <td>Marital Status:</td>
            <td><?php echo htmlspecialchars((string) ($member['marital_status_val'] ?? 'N/A'), ENT_QUOTES, 'UTF-8'); ?>
            </td>
          </tr>
          <tr>
            <td>Which Temple:</td>
            <td><?php echo htmlspecialchars((string) ($member['which_temple'] ?? 'N/A'), ENT_QUOTES, 'UTF-8'); ?></td>
          </tr>
          <tr>
            <td>Gotra:</td>
            <td><?php echo htmlspecialchars((string) ($member['gotra'] ?? 'N/A'), ENT_QUOTES, 'UTF-8'); ?></td>
          </tr>
        </table>
      </div>

      <!-- Birth & Horoscope -->
      <div class="admin-glass-card">
        <h2 style="margin-top:0;font-size:1rem;"><i class="fas fa-star"></i> Birth & Horoscope</h2>
        <table class="admin-table-info">
          <tr>
            <td>Birth Date:</td>
            <td><?php echo htmlspecialchars((string) ($member['dob'] ?? 'N/A'), ENT_QUOTES, 'UTF-8'); ?></td>
          </tr>
          <tr>
            <td>Birth Time:</td>
            <td><?php echo htmlspecialchars((string) ($member['birth_time'] ?? 'N/A'), ENT_QUOTES, 'UTF-8'); ?></td>
          </tr>
          <tr>
            <td>Birth Place:</td>
            <td><?php echo htmlspecialchars((string) ($member['birth_place'] ?? 'N/A'), ENT_QUOTES, 'UTF-8'); ?></td>
          </tr>
          <tr>
            <td>Star (Nakshatra):</td>
            <td><?php echo htmlspecialchars((string) ($member['star'] ?? 'N/A'), ENT_QUOTES, 'UTF-8'); ?></td>
          </tr>
          <tr>
            <td>Rasi (Moon Sign):</td>
            <td><?php echo htmlspecialchars((string) ($member['rasi'] ?? 'N/A'), ENT_QUOTES, 'UTF-8'); ?></td>
          </tr>
          <tr>
            <td>Dosh:</td>
            <td><?php echo htmlspecialchars((string) ($member['dosh'] ?? 'N/A'), ENT_QUOTES, 'UTF-8'); ?></td>
          </tr>
        </table>
      </div>
    </div>

    <div class="admin-dashboard-row" style="margin-top:24px;">
      <!-- Location -->
      <div class="admin-glass-card">
        <h2 style="margin-top:0;font-size:1rem;"><i class="fas fa-map-marker-alt"></i> Location Details</h2>
        <h3 style="font-size:13px;color:var(--admin-brand);">Birth Location</h3>
        <p style="font-size:13px;margin:5px 0 15px;">
          <?php echo htmlspecialchars((string) ($member['birth_city'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>,
          <?php echo htmlspecialchars((string) ($member['birth_state'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>,
          <?php echo htmlspecialchars((string) ($member['birth_country'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></p>

        <h3 style="font-size:13px;color:var(--admin-brand);">Native Location</h3>
        <p style="font-size:13px;margin:5px 0 0;">
          <?php echo htmlspecialchars((string) ($member['native_locality'] ?? ''), ENT_QUOTES, 'UTF-8'); ?><br>
          <?php echo htmlspecialchars((string) ($member['native_city'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>,
          <?php echo htmlspecialchars((string) ($member['native_state'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>,
          <?php echo htmlspecialchars((string) ($member['native_country'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></p>
      </div>

      <!-- Family Details -->
      <div class="admin-glass-card">
        <h2 style="margin-top:0;font-size:1rem;"><i class="fas fa-users"></i> Family Details</h2>
        <table class="admin-table-info">
          <tr>
            <td>Father:</td>
            <td><?php echo htmlspecialchars((string) ($member['father_name'] ?? 'N/A'), ENT_QUOTES, 'UTF-8'); ?></td>
          </tr>
          <tr>
            <td>Father Mobile:</td>
            <td><?php echo htmlspecialchars((string) ($member['father_mobile'] ?? 'N/A'), ENT_QUOTES, 'UTF-8'); ?></td>
          </tr>
          <tr>
            <td>Father Income:</td>
            <td><?php echo htmlspecialchars((string) ($member['father_income'] ?? 'N/A'), ENT_QUOTES, 'UTF-8'); ?></td>
          </tr>
          <tr>
            <td>Mother:</td>
            <td><?php echo htmlspecialchars((string) ($member['mother_name'] ?? 'N/A'), ENT_QUOTES, 'UTF-8'); ?></td>
          </tr>
          <tr>
            <td>Brothers:</td>
            <td><?php echo (int) ($member['bro_total'] ?? 0); ?> (Married:
              <?php echo (int) ($member['bro_married'] ?? 0); ?>)</td>
          </tr>
          <tr>
            <td>Sisters:</td>
            <td><?php echo (int) ($member['sis_total'] ?? 0); ?> (Married:
              <?php echo (int) ($member['sis_married'] ?? 0); ?>)</td>
          </tr>
        </table>
      </div>
    </div>

    <div class="admin-glass-card" style="margin-top:24px;">
      <h2 style="margin-top:0;font-size:1rem;">Additional Information & Relative Details</h2>
      <div
        style="font-size:13px;line-height:1.6;color:var(--admin-text);background:rgba(255,255,255,0.05);padding:15px;border-radius:10px;">
        <strong>About:</strong>
        <?php echo nl2br(htmlspecialchars((string) ($member['about_me'] ?? 'N/A'), ENT_QUOTES, 'UTF-8')); ?><br><br>
        <strong>Relatives:</strong>
        <?php echo nl2br(htmlspecialchars((string) ($member['relative_details'] ?? 'N/A'), ENT_QUOTES, 'UTF-8')); ?>
      </div>
    </div>

    <style>
      .admin-table-info {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
      }

      .admin-table-info td {
        padding: 8px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        color: var(--admin-text);
      }

      .admin-table-info td:first-child {
        font-weight: 600;
        color: var(--admin-muted);
        width: 40%;
      }
    </style>

  <?php endif; ?>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>