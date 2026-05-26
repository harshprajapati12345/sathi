<?php
$pageTitle = 'Login – Shadikibaat';
$bodyClass = 'reg-page';
$extraCss = 'register-wizard.css';
include 'header.php';
?>

<main class="reg-bg">
    <div class="container reg-shell reg-shell--narrow">
        <header class="reg-intro">
            <p class="reg-badge"><span aria-hidden="true">🔐</span> Welcome back</p>
            <h1>Login</h1>
            <p>Sign in with your registered email and password.</p>
        </header>

        <div class="reg-card">
            <form id="loginForm" action="#" method="post" novalidate>
                <div class="reg-float">
                    <input type="email" id="login_email" name="email" placeholder=" " required autocomplete="email">
                    <label for="login_email">Email ID / ईमेल आईडी / ઇમેઇલ આઈડી</label>
                </div>
                <div class="reg-float" style="margin-top: 18px;">
                    <input type="password" id="login_password" name="password" placeholder=" " required autocomplete="current-password" minlength="6">
                    <label for="login_password">Password / पासवर्ड / પાસવર્ડ</label>
                </div>
                <div style="margin-top: 28px;">
                    <button type="submit" class="reg-btn reg-btn-primary" style="width: 100%; justify-content: center;">Login / लॉग इन / લૉગિન</button>
                </div>
                <p style="text-align: center; margin-top: 20px; font-size: 14px; color: #666;">
                    New here? <a href="register.php" style="color: var(--brand, #f45c93); font-weight: 600;">Create an account</a>
                </p>
            </form>
        </div>
    </div>
</main>

<script>
document.getElementById('loginForm').addEventListener('submit', function (e) {
    e.preventDefault();
    if (!this.checkValidity()) return;
    const btn = this.querySelector('button[type="submit"]');
    const email = document.getElementById('login_email').value.trim();
    btn.disabled = true;
    const body = new URLSearchParams();
    body.set('email', email);
    body.set('password', document.getElementById('login_password').value);
    fetch('login-session.php', {
        method: 'POST',
        credentials: 'same-origin',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: body.toString()
    })
        .then(function (r) {
            if (!r.ok) throw new Error('request_failed');
            return r.json();
        })
        .then(function (data) {
            if (!data || !data.ok) throw new Error('not_ok');
            window.location.href = 'index.php';
        })
        .catch(function () {
            btn.disabled = false;
            Swal.fire({icon: 'error', text: 'Could not sign in. Please try again.', confirmButtonColor: '#e94e77'});
        });
});
</script>

<?php include 'footer.php'; ?>
</body>
</html>
