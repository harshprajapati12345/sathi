<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/user-storage.php';

$pageTitle = 'CSV Candidates';
$adminCurrent = 'members-approved';

require __DIR__ . '/includes/head.php';

// Fetch candidates from the new table
$rows = sathi_candidates_list_all(300);
?>

<section class="admin-page-placeholder">
  <div class="admin-glass-card admin-page-hero admin-page-hero-top">
    <span class="admin-page-icon" aria-hidden="true"><i class="fas fa-users"></i></span>
    <h2>CSV Candidates (Imported)</h2>
    <p class="lead">Viewing all records from the MALE.csv seeder with complete details.</p>
  </div>

  <div class="admin-glass-card">
    <div class="admin-table-wrap" style="overflow-x: auto;">
      <table class="admin-table" style="font-size: 13px;">
        <thead>
          <tr>
            <th>ID</th>
            <th>Photo</th>
            <th>Name</th>
            <th>Gender/Age</th>
            <th>Education/Income</th>
            <th>Occupation</th>
            <th>Native/Place</th>
            <th>Gotra/Horoscope</th>
            <th>Contact</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($rows) === 0): ?>
          <tr><td colspan="10">No records found. Please run setup.php to import CSV data.</td></tr>
          <?php else: ?>
          <?php foreach ($rows as $r): ?>
          <tr>
            <td><?php echo (int) ($r['id'] ?? 0); ?></td>
            <td>
              <?php if (!empty($r['candidate_photo'])): ?>
                <img src="<?php echo htmlspecialchars($r['candidate_photo']); ?>" alt="Photo" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #e94e77;">
              <?php else: ?>
                <div style="width: 40px; height: 40px; border-radius: 50%; background: #f3f4f6; display: flex; align-items: center; justify-content: center; color: #9ca3af;"><i class="fas fa-user"></i></div>
              <?php endif; ?>
            </td>
            <td>
              <div style="font-weight: 600; color: #111827;">
                <?php echo htmlspecialchars((string) ($r['candidate_full_name'] ?? '—'), ENT_QUOTES, 'UTF-8'); ?>
              </div>
              <div style="font-size: 11px; color: #6b7280;">
                <?php echo htmlspecialchars((string) ($r['email_address'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>
              </div>
            </td>
            <td>
              <div><?php echo htmlspecialchars((string) ($r['gender'] ?? '—'), ENT_QUOTES, 'UTF-8'); ?></div>
              <div style="font-size: 11px; color: #6b7280;"><?php echo htmlspecialchars((string) ($r['birth_date'] ?? '—'), ENT_QUOTES, 'UTF-8'); ?></div>
            </td>
            <td>
              <div style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?php echo htmlspecialchars((string) ($r['higher_education'] ?? '—')); ?>">
                <?php echo htmlspecialchars((string) ($r['higher_education'] ?? '—'), ENT_QUOTES, 'UTF-8'); ?>
              </div>
              <div style="font-weight: 600; color: #059669;">₹ <?php echo number_format((float)($r['candidate_annual_income'] ?? 0)); ?></div>
            </td>
            <td>
              <div><?php echo htmlspecialchars((string) ($r['candidate_occupation'] ?? '—'), ENT_QUOTES, 'UTF-8'); ?></div>
              <div style="font-size: 11px; color: #6b7280;"><?php echo htmlspecialchars((string) ($r['occupation_designation'] ?? '—'), ENT_QUOTES, 'UTF-8'); ?></div>
            </td>
            <td>
              <div><?php echo htmlspecialchars((string) ($r['native'] ?? '—'), ENT_QUOTES, 'UTF-8'); ?></div>
              <div style="font-size: 11px; color: #6b7280;"><?php echo htmlspecialchars((string) ($r['birth_place'] ?? '—'), ENT_QUOTES, 'UTF-8'); ?></div>
            </td>
            <td>
              <div><?php echo htmlspecialchars((string) ($r['gotra'] ?? '—'), ENT_QUOTES, 'UTF-8'); ?></div>
              <div style="font-size: 11px; color: #e11d48;"><?php echo htmlspecialchars((string) ($r['horoscope'] ?? '—'), ENT_QUOTES, 'UTF-8'); ?></div>
            </td>
            <td>
              <div style="white-space: nowrap;"><i class="fab fa-whatsapp" style="color: #25D366; margin-right: 4px;"></i><?php echo htmlspecialchars((string) ($r['mobile_number'] ?? '—'), ENT_QUOTES, 'UTF-8'); ?></div>
            </td>
            <td>
              <a class="admin-btn admin-btn-secondary admin-btn-sm" href="member-view.php?id=<?php echo (int) ($r['id'] ?? 0); ?>&source=csv">Details</a>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
