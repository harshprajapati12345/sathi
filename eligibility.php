<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Handle OTP Verification AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'verify_otp') {
    header('Content-Type: application/json');
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $otp = $_POST['otp'] ?? '';
    
    // Default OTP is 1234 as per requirements
    if ($otp === '1234' && !empty($email)) {
        $_SESSION['verified_email'] = $email;
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid OTP. Please enter 1234.']);
    }
    exit;
}

$pageTitle = 'Eligibility - Shadikibaat';
$hideNavLinks = true;
include 'header.php';
?>
<main class="reg-bg reg-bg--photo" style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background-color: #fdf2f8;">
    <div class="container">
        <div class="reg-card" style="max-width: 500px; margin: 0 auto; text-align: center; padding: 40px 20px; background: #fff; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
            
            <!-- STEP 1: Digambar Jain Question -->
            <div id="step-1">
                <h2 style="font-size:22px; font-weight:800; color:#9d174d; margin-bottom:15px;">
                    Are You Digambar Jain ?
                </h2>
                <p style="font-size:16px; font-weight:600; color:#be185d; margin-bottom:30px;">
                    (परिचय सम्मेलन सिर्फ दिगम्बर जैन के लिये है) <span style="color:red;">*</span>
                </p>
                
                <div style="display:flex; gap:20px; justify-content: center; margin-bottom: 20px;">
                    <button id="btn-yes" style="padding: 12px 35px; font-size: 16px; font-weight: 700; background: var(--match-pink, #f45c93); color: #fff; border: none; border-radius: 25px; cursor: pointer; box-shadow: 0 4px 10px rgba(244, 92, 147, 0.3);">Yes / हाँ</button>
                    <button id="btn-no" style="padding: 12px 35px; font-size: 16px; font-weight: 700; background: transparent; color: #9d174d; border: 2px solid #9d174d; border-radius: 25px; cursor: pointer;">No / ना</button>
                </div>
                
                <div id="no-message" style="display: none; color: #e11d48; font-weight: 700; margin-top: 25px; font-size: 16px; padding: 15px; background: #ffe4e6; border-radius: 8px; border: 1px solid #fecdd3;">
                    This matrimony website is only for Digamber Jain
                </div>
            </div>

            <!-- STEP 2: Email Request -->
            <div id="step-2" style="display: none;">
                <h2 style="font-size:22px; font-weight:800; color:#9d174d; margin-bottom:15px;">
                    Enter Your Email
                </h2>
                <p style="font-size:15px; color:#666; margin-bottom:20px;">
                    Please enter your email address to receive an OTP.
                </p>
                <div style="margin-bottom: 20px; text-align: left;">
                    <input type="email" id="user-email" placeholder="Email Address" required style="width: 100%; padding: 12px 15px; border: 1px solid #ccc; border-radius: 8px; font-size: 16px; box-sizing: border-box;">
                    <div id="email-error" style="color: red; font-size: 13px; margin-top: 5px; display: none;">Please enter a valid email address.</div>
                </div>
                <button id="btn-send-otp" style="padding: 12px 35px; font-size: 16px; font-weight: 700; background: var(--match-pink, #f45c93); color: #fff; border: none; border-radius: 25px; cursor: pointer; width: 100%;">Send OTP</button>
            </div>

            <!-- STEP 3: OTP Verification -->
            <div id="step-3" style="display: none;">
                <h2 style="font-size:22px; font-weight:800; color:#9d174d; margin-bottom:15px;">
                    Verify OTP
                </h2>
                <p style="font-size:15px; color:#666; margin-bottom:20px;">
                    An OTP has been sent to <strong id="display-email"></strong>.<br>
                    (For testing, use default OTP: 1234)
                </p>
                <div style="margin-bottom: 20px; text-align: left;">
                    <input type="text" id="user-otp" placeholder="Enter OTP (e.g. 1234)" required style="width: 100%; padding: 12px 15px; border: 1px solid #ccc; border-radius: 8px; font-size: 16px; text-align: center; letter-spacing: 5px; box-sizing: border-box;">
                    <div id="otp-error" style="color: red; font-size: 13px; margin-top: 5px; display: none;"></div>
                </div>
                <button id="btn-verify-otp" style="padding: 12px 35px; font-size: 16px; font-weight: 700; background: #16a085; color: #fff; border: none; border-radius: 25px; cursor: pointer; width: 100%;">Verify & Continue</button>
            </div>

        </div>
    </div>
</main>
<script>
    const step1 = document.getElementById('step-1');
    const step2 = document.getElementById('step-2');
    const step3 = document.getElementById('step-3');

    // Step 1 logic
    document.getElementById('btn-yes').addEventListener('click', function() {
        step1.style.display = 'none';
        step2.style.display = 'block';
    });
    
    document.getElementById('btn-no').addEventListener('click', function() {
        document.getElementById('no-message').style.display = 'block';
    });

    // Step 2 logic
    document.getElementById('btn-send-otp').addEventListener('click', function() {
        const emailInput = document.getElementById('user-email').value.trim();
        const emailError = document.getElementById('email-error');
        
        // Basic email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(emailInput)) {
            emailError.style.display = 'block';
            return;
        }
        emailError.style.display = 'none';
        
        // In a real app, you would make an AJAX call here to send the email.
        // For now, we simulate success and move to step 3.
        document.getElementById('display-email').textContent = emailInput;
        step2.style.display = 'none';
        step3.style.display = 'block';
    });

    // Step 3 logic
    document.getElementById('btn-verify-otp').addEventListener('click', function() {
        const email = document.getElementById('user-email').value.trim();
        const otp = document.getElementById('user-otp').value.trim();
        const otpError = document.getElementById('otp-error');
        
        if (otp === '') {
            otpError.textContent = 'Please enter the OTP.';
            otpError.style.display = 'block';
            return;
        }

        const btn = this;
        btn.disabled = true;
        btn.textContent = 'Verifying...';

        // AJAX request to verify OTP
        const formData = new FormData();
        formData.append('action', 'verify_otp');
        formData.append('email', email);
        formData.append('otp', otp);

        fetch('eligibility.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = 'register.php';
            } else {
                otpError.textContent = data.message || 'Invalid OTP';
                otpError.style.display = 'block';
                btn.disabled = false;
                btn.textContent = 'Verify & Continue';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            otpError.textContent = 'An error occurred. Please try again.';
            otpError.style.display = 'block';
            btn.disabled = false;
            btn.textContent = 'Verify & Continue';
        });
    });
</script>
<?php include 'footer.php'; ?>
