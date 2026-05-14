<?php
require_once __DIR__ . '/session_init.php';

// If not logged in, go to register
if (empty($_SESSION['sathi_user_id'])) {
    header('Location: register.php');
    exit;
}

$status = $_SESSION['sathi_registration_status'] ?? 'pending';

// If approved, go to index
if ($status === 'approved' || $status === 'active') {
    header('Location: index.php');
    exit;
}

// If rejected, go to reject
if ($status === 'rejected') {
    header('Location: reject.php');
    exit;
}

$bodyClass = 'reg-page reg-page-register';
$extraCss = 'register-wizard.css';
$pageTitle = 'Pending Approval - ShadikiBaat';
include 'header.php';
?>

<style>
    .reg-card-msg {
        text-align: center;
        padding: 60px 40px;
        opacity: 1;
        transform: none;
        position: relative;
        z-index: 3;
        display: block !important;
    }

    @media (max-width: 768px) {
        .reg-card-msg {
            padding: 40px 20px !important;
        }

        .reg-card-msg h1 {
            font-size: 1.8rem !important;
        }
    }
</style>

<main class="reg-bg reg-bg--photo"
    style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 100px 15px 40px; position: relative;">
    <div class="container" style="max-width: 600px; position: relative; z-index: 2; width: 100%;">
        <div class="reg-card reg-card-msg">
            <div style="font-size: 4rem; margin-bottom: 20px;">⏳</div>
            <h1
                style="font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--text); margin-bottom: 15px;">
                Application Under Review</h1>
            <p style="font-size: 1.1rem; color: #666; line-height: 1.6; margin-bottom: 30px;">
                Thank you for your interest in ShadikiBaat! <br>
                Your application has been successfully submitted and is now <strong>under review</strong> by our
                verification team.
            </p>
            <div
                style="background: var(--bg-soft); padding: 25px; border-radius: 12px; margin-bottom: 30px; text-align: left;">
                <h3 style="font-size: 1rem; color: var(--text); margin-bottom: 10px;">What happens next?</h3>
                <ul style="font-size: 0.9rem; color: #555; padding-left: 20px; line-height: 1.7;">
                    <li>Our team verifies your profile details and documents.</li>
                    <li>We confirm your Razorpay payment status.</li>
                    <li>Once approved, you will receive full access to find your match.</li>
                </ul>
            </div>
            <div class="reg-actions"
                style="justify-content: center; gap: 15px; margin-top: 30px; padding-top: 0; border-top: none;">
                <a href="index.php" class="reg-btn reg-btn-primary"
                    style="text-decoration: none; display: inline-block;">Check Status Again</a>
                <a href="logout.php" class="reg-btn reg-btn-secondary"
                    style="text-decoration: none; display: inline-block;">Logout</a>
            </div>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
</body>

</html>