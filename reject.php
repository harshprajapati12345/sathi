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

// If pending, go to pending
if ($status === 'pending') {
    header('Location: pending.php');
    exit;
}

$bodyClass = 'reg-page reg-page-register';
$extraCss = 'register-wizard.css';
$pageTitle = 'Application Rejected - ShadikiBaat';
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

<main class="reg-bg reg-bg--photo" style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 100px 15px 40px; position: relative;">
    <div class="container" style="max-width: 600px; position: relative; z-index: 2; width: 100%;">
        <div class="reg-card reg-card-msg" style="border-top: 5px solid #ff4d4d;">
            <div style="font-size: 4rem; margin-bottom: 20px;">🚫</div>
            <h1 style="font-family: 'Playfair Display', serif; font-size: 2.5rem; color: #ff4d4d; margin-bottom: 15px;">Application Rejected</h1>
            <p style="font-size: 1.1rem; color: #666; line-height: 1.6; margin-bottom: 30px;">
                We regret to inform you that your registration application has been rejected by our administration team. 
                This may be due to incomplete information, unverified documents, or profiles that do not meet our community standards.
            </p>
            <div style="background: #fff5f5; padding: 20px; border-radius: 12px; margin-bottom: 30px; border: 1px solid #ffe6e6;">
                <p style="font-size: 0.95rem; color: #d32f2f; font-weight: 600; margin: 0;">
                    Status: Account Restricted
                </p>
            </div>
            <p style="font-size: 0.9rem; color: #888; margin-bottom: 25px;">
                If you believe this is a mistake or would like to provide additional information, please contact our support team.
            </p>
            <div class="reg-actions" style="justify-content: center; gap: 15px; margin-top: 30px; padding-top: 0; border-top: none;">
                <a href="mailto:support@shadikibaat.com" class="reg-btn reg-btn-primary" style="text-decoration: none; display: inline-block;">Contact Support</a>
                <a href="register.php" class="reg-btn reg-btn-secondary" style="text-decoration: none; display: inline-block;">Re-Register</a>
            </div>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
