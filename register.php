<?php
require_once __DIR__ . '/session_init.php';
require_once __DIR__ . '/includes/registration-config.php';
require_once __DIR__ . '/includes/registration-masters-db.php';
$masters = sathi_registration_masters_from_db();
require_once __DIR__ . '/config/database.php';
$payment_enabled = sathi_site_setting('payment_enabled', '0') === '1';

$pageTitle = 'Register ÃƒÂ¢Ã¢â€šÂ¬Ã¢â‚¬Å“ Shadikibaat | Marriage Bureau Onboarding';
$bodyClass = 'reg-page reg-page-register';
$extraCss = 'register-wizard.css';
$hideNavLinks = true;
include 'header.php';
?>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<main class="reg-bg reg-bg--photo">
    <div class="container reg-shell reg-shell--hero">
        <div class="reg-form-column">
            <div class="reg-card">
                <header class="reg-card-head">
                    <p class="reg-badge"><span aria-hidden="true">ÃƒÂ°Ã…Â¸Ã¢â‚¬â„¢Ã‚Â</span> Trusted matrimonial bureau
                    </p>
                    <h1>Create your profile</h1>
                    <p class="reg-card-lead">A secure onboarding ÃƒÂ¢Ã¢â€šÂ¬Ã¢â‚¬Â verified profiles for families
                        serious about finding
                        the right match.</p>
                </header>

                <div class="reg-stepper-wrap">
                    <ol class="reg-stepper" role="list">
                        <li class="reg-step-item active" data-step="0"><span class="num">1</span><span>Basic Info</span>
                        </li>
                        <li class="reg-step-item" data-step="1"><span class="num">2</span><span>Contact</span></li>
                        <li class="reg-step-item" data-step="2"><span class="num">3</span><span>Career</span></li>
                        <li class="reg-step-item" data-step="3"><span class="num">4</span><span>Family</span></li>
                        <li class="reg-step-item" data-step="4"><span class="num">5</span><span>Upload</span></li>
                        <?php if ($payment_enabled): ?>
                            <li class="reg-step-item" data-step="5"><span class="num">6</span><span>Payment</span></li>
                        <?php endif; ?>
                    </ol>
                </div>

                <form id="regWizard" class="reg-form" action="#" method="post" enctype="multipart/form-data" novalidate>
                    <input type="hidden" name="csrf_token"
                        value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">

                    <!-- STEP 1: Basic Info -->
                    <div class="reg-panel active" data-panel="0">
                        <h2 class="reg-section-title">Basic Information</h2>
                        <div class="reg-grid">

                            <!-- 1. Are You Digambar Jain -->
                            <div<?php echo sathi_reg_field_wrap_attrs('digamber_jain', 'reg-grid-full'); ?>>
                                <div class="reg-grid-full" style="background: #fff0f5; padding: 15px; border-radius: 8px; border: 1px solid #fbcfe8;">
                                    <p style="font-size:15px; font-weight:700; color:#9d174d; margin-bottom:10px;">Are You Digambar Jain ? (परिचय सम्मेलन सिर्फ दिगम्बर जैन के लिये है) <span style="color:red;">*</span></p>
                                    <div style="display:flex; gap:20px;">
                                        <label style="font-weight:600; cursor:pointer;"><input type="radio" name="digamber" value="yes" checked style="margin-right:5px;"> Yes / हाँ</label>
                                        <label style="font-weight:600; cursor:pointer;"><input type="radio" name="digamber" id="digamber_no" value="no" style="margin-right:5px;"> No / ना</label>
                                    </div>
                                </div>
                            </div>

                            <script>
                                document.querySelectorAll('input[name="digamber"]').forEach(radio => {
                                    radio.addEventListener('change', function() {
                                        if (this.value === 'no') {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Registration Not Allowed',
                                                text: 'This matrimony is exclusively for Digambar Jains.',
                                                confirmButtonColor: '#e94e77',
                                                allowOutsideClick: false
                                            }).then(() => {
                                                window.location.href = 'index.php';
                                            });
                                        }
                                    });
                                });
                            </script>

                            <!-- Mandir Verification Details -->
                            <div class="reg-grid-full" style="background: #fdf2f8; padding: 15px; border-radius: 8px; border: 1px solid #fbcfe8; margin-bottom: 15px;">
                                <h3 style="font-size:16px; font-weight:700; color:#9d174d; margin-bottom:15px; border-bottom: 1px solid #fbcfe8; padding-bottom: 8px;">Mandir Verification Details</h3>
                                
                                <div class="reg-grid" style="margin-bottom: 15px;">
                                    <!-- Mandir -->
                                    <div class="reg-float reg-float-select">
                                        <select id="mandir" name="mandir" required>
                                            <?php sathi_reg_render_select_options($masters['mandir'] ?? []); ?>
                                        </select>
                                        <label for="mandir">Select Mandir / मंदिर चुनें / મંદિર પસંદ કરો <span style="color:red;">*</span></label>
                                    </div>
                                    <!-- Subcast -->
                                    <div class="reg-float reg-float-select">
                                        <select id="subcast" name="subcast" required>
                                            <?php sathi_reg_render_select_options($masters['subcast'] ?? []); ?>
                                        </select>
                                        <label for="subcast">Subcast / उपजाति / પેટા જાતિ <span style="color:red;">*</span></label>
                                    </div>
                                    <!-- Gotra -->
                                    <div class="reg-float reg-float-select">
                                        <select id="gotra" name="gotra" required>
                                            <?php sathi_reg_render_select_options($masters['gotra'] ?? []); ?>
                                        </select>
                                        <label for="gotra">Gotra / गोत्र / ગોત્ર <span style="color:red;">*</span></label>
                                    </div>
                                </div>

                                <h4 style="font-size:14px; font-weight:600; color:#831843; margin-bottom:10px;">Reference Persons (From same Mandir/Community)</h4>
                                <p style="font-size:12px; color:#be185d; margin-bottom:15px;">These details are collected only for community verification purposes.</p>

                                <div class="reg-split" style="gap: 15px; margin-bottom: 15px;">
                                    <div class="reg-subcard" style="padding: 12px; background: #fff; border: 1px solid #fce7f3; box-shadow: none;">
                                        <p style="font-weight: 600; font-size: 13px; margin-bottom: 10px;">Reference Person 1</p>
                                        <div class="reg-float" style="margin-bottom: 10px;">
                                            <input type="text" id="ref1_name" name="ref1_name" placeholder=" " required>
                                            <label for="ref1_name">Name / नाम / નામ <span style="color:red;">*</span></label>
                                        </div>
                                        <div class="reg-float" style="margin-bottom: 10px;">
                                            <input type="tel" id="ref1_mobile" name="ref1_mobile" placeholder=" " required maxlength="10" pattern="[0-9]{10}" inputmode="numeric">
                                            <label for="ref1_mobile">Mobile Number / मोबाइल नंबर / મોબાઇલ નંબર <span style="color:red;">*</span></label>
                                            <span class="reg-error-msg">Enter 10-digit mobile number / 10 अंकों का मोबाइल नंबर दर्ज करें / 10 અંકનો મોબાઇલ નંબર દાખલ કરો</span>
                                        </div>
                                        <div class="reg-float">
                                            <input type="text" id="ref1_relation" name="ref1_relation" placeholder=" ">
                                            <label for="ref1_relation">Relationship (Optional) / संबंध (वैकल्पिक) / સંબંધ (વૈકલ્પિક)</label>
                                        </div>
                                    </div>

                                    <div class="reg-subcard" style="padding: 12px; background: #fff; border: 1px solid #fce7f3; box-shadow: none;">
                                        <p style="font-weight: 600; font-size: 13px; margin-bottom: 10px;">Reference Person 2</p>
                                        <div class="reg-float" style="margin-bottom: 10px;">
                                            <input type="text" id="ref2_name" name="ref2_name" placeholder=" " required>
                                            <label for="ref2_name">Name / नाम / નામ <span style="color:red;">*</span></label>
                                        </div>
                                        <div class="reg-float" style="margin-bottom: 10px;">
                                            <input type="tel" id="ref2_mobile" name="ref2_mobile" placeholder=" " required maxlength="10" pattern="[0-9]{10}" inputmode="numeric">
                                            <label for="ref2_mobile">Mobile Number / मोबाइल नंबर / મોબાઇલ નંબર <span style="color:red;">*</span></label>
                                            <span class="reg-error-msg">Enter 10-digit mobile number / 10 अंकों का मोबाइल नंबर दर्ज करें / 10 અંકનો મોબાઇલ નંબર દાખલ કરો</span>
                                        </div>
                                        <div class="reg-float">
                                            <input type="text" id="ref2_relation" name="ref2_relation" placeholder=" ">
                                            <label for="ref2_relation">Relationship (Optional) / संबंध (वैकल्पिक) / સંબંધ (વૈકલ્પિક)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 14. Gender -->
                            <div<?php echo sathi_reg_field_wrap_attrs('gender'); ?>>
                                <div class="reg-float reg-float-select">
                                    <select id="gender" name="gender" <?php echo sathi_reg_field_required_attr('gender'); ?>>
                                        <option value="" disabled selected></option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                    <label for="gender">Gender / लिंग / જાતિ</label>
                                </div>
                            </div>

                            <!-- 2. Email -->
                            <div<?php echo sathi_reg_field_wrap_attrs('email'); ?>>
                                <div class="reg-float">
                                    <input type="email" id="email" name="email" placeholder=" " <?php echo sathi_reg_field_required_attr('email'); ?> autocomplete="email">
                                    <label for="email">Email / ईमेल / ઇમેઇલ</label>
                                    <span class="reg-error-msg">Enter a valid email / एक मान्य ईमेल दर्ज करें / માન્ય ઇમેઇલ દાખલ કરો</span>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="reg-float">
                                <input type="password" id="password" name="password" placeholder=" " required autocomplete="new-password" minlength="8">
                                <label for="password">Password / पासवर्ड / પાસવર્ડ (Minimum 8 Characters / न्यूनतम 8 अक्षर / ઓછામાં ઓછા 8 અક્ષર)</label>
                                <span class="reg-error-msg">Password must be at least 8 characters / पासवर्ड कम से कम 8 अक्षरों का होना चाहिए / પાસવર્ડ ઓછામાં ઓછા 8 અક્ષરનો હોવો જોઈએ</span>
                            </div>

                            <!-- Confirm Password -->
                            <div class="reg-float">
                                <input type="password" id="password_confirm" name="password_confirm" placeholder=" " required autocomplete="new-password" minlength="8">
                                <label for="password_confirm">Confirm Password / पासवर्ड की पुष्टि करें / પાસવર્ડની પુષ્ટિ કરો</label>
                                <span class="reg-error-msg">Confirm your password / अपने पासवर्ड की पुष्टि करें / તમારા પાસવર્ડની પુષ્ટિ કરો</span>
                            </div>

                            <!-- 3. Candidate First & Last Name -->
                            <div<?php echo sathi_reg_field_wrap_attrs('first_name'); ?>>
                                <div class="reg-float">
                                    <input type="text" id="first_name" name="first_name" placeholder=" " <?php echo sathi_reg_field_required_attr('first_name'); ?> autocomplete="given-name">
                                    <label for="first_name">First Name / प्रत्याशी का नाम / ઉમેદવારનું નામ</label>
                                </div>
                            </div>
                            <div<?php echo sathi_reg_field_wrap_attrs('last_name'); ?>>
                                <div class="reg-float">
                                    <input type="text" id="last_name" name="last_name" placeholder=" " <?php echo sathi_reg_field_required_attr('last_name'); ?> autocomplete="family-name">
                                    <label for="last_name">Last Name / उपनाम / અટક / Surname</label>
                                </div>
                            </div>

                            <!-- 4. Country Code + Mobile Number (WhatsApp) -->
                            <div<?php echo sathi_reg_field_wrap_attrs('mobile'); ?>>
                                <div class="reg-phone-row">
                                    <div class="reg-float reg-float-select reg-cc">
                                        <select id="country_code" name="country_code">
                                            <option value="+91" selected>+91</option>
                                            <option value="+1">+1</option>
                                            <option value="+44">+44</option>
                                        </select>
                                        <label for="country_code">Country Code / देश कोड / દેશ કોડ</label>
                                    </div>
                                    <div class="reg-float" style="flex:1;">
                                        <input type="tel" id="mobile" name="mobile" placeholder=" " <?php echo sathi_reg_field_required_attr('mobile'); ?> maxlength="10" pattern="[0-9]{10}" inputmode="numeric">
                                        <label for="mobile">Mobile Number (WhatsApp) / मोबाइल नंबर (व्हाट्सएप) / મોબાઇલ નંબર (વ્હોટ્સએપ)</label>
                                        <span class="reg-error-msg">Enter 10-digit mobile number / 10 अंकों का मोबाइल नंबर दर्ज करें / 10 અંકનો મોબાઇલ નંબર દાખલ કરો</span>
                                    </div>
                                </div>
                            </div>

                            <!-- 5. Birth Date -->
                            <div<?php echo sathi_reg_field_wrap_attrs('birth_date'); ?>>
                                <div class="reg-float">
                                    <input type="date" id="birth_date" name="birth_date" placeholder=" " <?php echo sathi_reg_field_required_attr('birth_date'); ?>>
                                    <label for="birth_date">Birth Date / जन्म दिनांक / જન્મ તારીખ (Day, month, year)</label>
                                </div>
                            </div>

                            <!-- 6. Birth Time -->
                            <div<?php echo sathi_reg_field_wrap_attrs('birth_time'); ?>>
                                <div class="reg-float">
                                    <input type="time" id="birth_time" name="birth_time" placeholder=" " <?php echo sathi_reg_field_required_attr('birth_time'); ?>>
                                    <label for="birth_time">Birth Time / जन्म समय / જન્મ સમય</label>
                                </div>
                            </div>

                            <!-- 7. Birth Place -->
                            <div<?php echo sathi_reg_field_wrap_attrs('birth_place'); ?>>
                                <div class="reg-float">
                                    <input type="text" id="birth_place" name="birth_place" placeholder=" " <?php echo sathi_reg_field_required_attr('birth_place'); ?>>
                                    <label for="birth_place">Birth Place / जन्म स्थान / જન્મ સ્થળ</label>
                                </div>
                            </div>

                            <!-- 8. Native -->
                            <div<?php echo sathi_reg_field_wrap_attrs('native_place'); ?>>
                                <div class="reg-float">
                                    <input type="text" id="native_place" name="native_place" placeholder=" " <?php echo sathi_reg_field_required_attr('native_place'); ?>>
                                    <label for="native_place">Native / परिवार का मूल स्थान / વતન / મૂળ સ્થાન</label>
                                </div>
                            </div>


                            <!-- 10. Mama Gotra -->
                            <div<?php echo sathi_reg_field_wrap_attrs('star'); ?>>
                                <div class="reg-float">
                                    <input type="text" id="star" name="star" placeholder=" " <?php echo sathi_reg_field_required_attr('star'); ?>>
                                    <label for="star">Mama Gotra / मामा का गोत्र / મામાનું ગોત્ર</label>
                                </div>
                            </div>

                            <!-- 11. Manglik -->
                            <div<?php echo sathi_reg_field_wrap_attrs('dosh'); ?>>
                                <div class="reg-float reg-float-select">
                                    <select id="dosh" name="dosh" <?php echo sathi_reg_field_required_attr('dosh'); ?>>
                                        <option value="" disabled selected></option>
                                        <option value="Yes / हाँ">Yes / हाँ</option>
                                        <option value="No / ना">No / ना</option>
                                    </select>
                                    <label for="dosh">Manglik / मांगलिक / માંગલિક</label>
                                </div>
                            </div>

                            <!-- 12. Height dropdown -->
                            <div<?php echo sathi_reg_field_wrap_attrs('height'); ?>>
                                <div class="reg-float reg-float-select">
                                    <select id="height" name="height" <?php echo sathi_reg_field_required_attr('height'); ?>>
                                        <option value="" disabled selected></option>
                                        <?php for($f=4; $f<=7; $f++): ?>
                                            <?php for($i=0; $i<=11; $i++): ?>
                                                <?php $val = $f . ' ft' . ($i > 0 ? ' ' . $i . ' inch' : ''); ?>
                                                <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                                            <?php endfor; ?>
                                        <?php endfor; ?>
                                    </select>
                                    <label for="height">Height / ऊंचाई / ઊંચાઈ</label>
                                </div>
                            </div>

                            <!-- 13. Weight dropdown -->
                            <div<?php echo sathi_reg_field_wrap_attrs('weight'); ?>>
                                <div class="reg-float reg-float-select">
                                    <select id="weight" name="weight" <?php echo sathi_reg_field_required_attr('weight'); ?>>
                                        <option value="" disabled selected></option>
                                        <?php for($w=35; $w<=150; $w++): ?>
                                            <option value="<?php echo $w; ?>"><?php echo $w; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <label for="weight">Weight / वज़न / વજન</label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- STEP 2: Contact & Address -->
                    <div class="reg-panel" data-panel="1">
                        <h2 class="reg-section-title">Contact &amp; Address</h2>
                        <div class="reg-grid">

                            <!-- 15. Permanent Full Address -->
                            <div<?php echo sathi_reg_field_wrap_attrs('addr_perm', 'reg-grid-full'); ?>>
                                <div class="reg-float reg-grid-full">
                                    <textarea id="addr_perm" name="addr_perm" placeholder=" " <?php echo sathi_reg_field_required_attr('addr_perm'); ?> rows="3"></textarea>
                                    <label for="addr_perm">Permanent Full Address / स्थायी पूरा पता / કાયમી સંપૂર્ણ સરનામું</label>
                                </div>
                            </div>

                            <!-- 16. Pin code of Permanent Address -->
                            <div<?php echo sathi_reg_field_wrap_attrs('complexion'); ?>>
                                <div class="reg-float">
                                    <input type="text" id="complexion" name="complexion" placeholder=" " <?php echo sathi_reg_field_required_attr('complexion'); ?> inputmode="numeric" pattern="[0-9]{6}" maxlength="6">
                                    <label for="complexion">Pin code of Permanent Address / स्थायी पते का पिन कोड / કાયમી સરનામાનો પિન કોડ</label>
                                </div>
                            </div>

                            <!-- 17. Candidate Current Address -->
                            <div<?php echo sathi_reg_field_wrap_attrs('addr_curr', 'reg-grid-full'); ?> style="margin-top:14px;">
                                <div class="reg-float reg-grid-full">
                                    <textarea id="addr_curr" name="addr_curr" placeholder=" " <?php echo sathi_reg_field_required_attr('addr_curr'); ?> rows="3"></textarea>
                                    <label for="addr_curr">Candidate Current Address / वर्तमान पता / ઉમેદવારનું વર્તમાન સરનામું</label>
                                </div>
                                <small style="display:block; margin-top:6px; font-size:11px; color:#777; line-height:1.3;">(If your permanent address is the same, you may Write Same as above / Not Applicable. / यदि आपका स्थायी पता वही है, तो ऊपर जैसा ही लिखें / જો તમારું કાયમી સરનામું સમાન હોય, તો ઉપર જેવું જ લખો)</small>
                            </div>

                        </div>
                    </div>

                    <!-- STEP 3: Education & Career -->
                    <div class="reg-panel" data-panel="2">
                        <h2 class="reg-section-title">Education &amp; Career</h2>
                        <div class="reg-grid">

                            <!-- 18. Higher Education -->
                            <div<?php echo sathi_reg_field_wrap_attrs('education', 'reg-grid-full'); ?>>
                                <div class="reg-float reg-float-select reg-grid-full">
                                    <select id="education" name="education" <?php echo sathi_reg_field_required_attr('education'); ?>>
                                        <?php sathi_reg_render_select_options($masters['education']); ?>
                                    </select>
                                    <label for="education">Higher Education / उच्च शिक्षा / ઉચ્ચ શિક્ષણ</label>
                                </div>
                            </div>

                            <!-- 19. Hobbies -->
                            <div<?php echo sathi_reg_field_wrap_attrs('hobbies', 'reg-grid-full'); ?>>
                                <div class="reg-grid-full">
                                    <p style="font-size:13px;font-weight:600;color:#333;margin-bottom:10px;">Hobbies / शौक / શોખ</p>
                                    <div class="reg-chips">
                                        <label class="reg-chip"><input type="checkbox" name="hobby[]" value="reading"><span>Reading</span></label>
                                        <label class="reg-chip"><input type="checkbox" name="hobby[]" value="travelling"><span>Travelling</span></label>
                                        <label class="reg-chip"><input type="checkbox" name="hobby[]" value="music"><span>Music</span></label>
                                        <label class="reg-chip"><input type="checkbox" name="hobby[]" value="sports"><span>Sports</span></label>
                                        <label class="reg-chip"><input type="checkbox" name="hobby[]" value="meditation"><span>Meditation</span></label>
                                    </div>
                                </div>
                            </div>

                            <!-- 20. Your Specific Preference for the Partner -->
                            <div<?php echo sathi_reg_field_wrap_attrs('relative_details', 'reg-grid-full'); ?>>
                                <div class="reg-float reg-grid-full">
                                    <textarea id="relative_details" name="relative_details" placeholder=" " <?php echo sathi_reg_field_required_attr('relative_details'); ?> rows="3"></textarea>
                                    <label for="relative_details">Your Specific Preference for the Partner / जीवनसाथी के लिए आपकी विशेष पसंद / જીવનસાથી માટે તમારી ખાસ પસંદગી</label>
                                </div>
                            </div>

                            <!-- 21. Candidate Monthly Income -->
                            <div<?php echo sathi_reg_field_wrap_attrs('annual_income'); ?>>
                                <div class="reg-float reg-float-select">
                                    <select id="annual_income" name="annual_income" <?php echo sathi_reg_field_required_attr('annual_income'); ?>>
                                        <option value="" disabled selected></option>
                                        <option value="Below 2 Lakhs">Below 2 Lakhs</option>
                                        <option value="2–5 Lakhs">2–5 Lakhs</option>
                                        <option value="5–10 Lakhs">5–10 Lakhs</option>
                                        <option value="10–20 Lakhs">10–20 Lakhs</option>
                                        <option value="20+ Lakhs">20+ Lakhs</option>
                                    </select>
                                    <label for="annual_income">Candidate Annual Income / प्रत्याशी की वार्षिक आय / ઉમેદવારની વાર્ષિક આવક</label>
                                </div>
                            </div>

                            <!-- 22. Widow / Divorce -->
                            <div<?php echo sathi_reg_field_wrap_attrs('marital_status'); ?>>
                                <div class="reg-float reg-float-select">
                                    <select id="marital_status" name="marital_status" <?php echo sathi_reg_field_required_attr('marital_status'); ?>>
                                        <option value="" disabled selected></option>
                                        <option value="Widow">Widow</option>
                                        <option value="Divorce">Divorce</option>
                                        <option value="Not Applicable">Not Applicable</option>
                                    </select>
                                    <label for="marital_status">Widow / Divorce / विधवा / तलाक / વિધવા / છૂટાછેડા</label>
                                </div>
                            </div>

                            <!-- 23. Handicapped / Physical Deficiency -->
                            <div<?php echo sathi_reg_field_wrap_attrs('blood_group'); ?>>
                                <div class="reg-float reg-float-select">
                                    <select id="blood_group" name="blood_group" <?php echo sathi_reg_field_required_attr('blood_group'); ?>>
                                        <option value="" disabled selected></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                    <label for="blood_group">Handicapped / Physical Deficiency / विकलांग / शारीरिक कमी / વિકલાંગ / શારીરિક ખામી</label>
                                </div>
                            </div>

                            <!-- 24. Language Known -->
                            <div class="reg-field-wrap" data-reg-field="languages_known" style="grid-column: 1 / -1;">
                                <div class="reg-grid-full">
                                    <p style="font-size:13px;font-weight:600;color:#333;margin-bottom:10px;">Languages Known / ज्ञात भाषाएँ / જાણીતી ભાષાઓ</p>
                                    <div class="reg-chips">
                                        <label class="reg-chip"><input type="checkbox" name="languages_known[]" value="English"><span>English</span></label>
                                        <label class="reg-chip"><input type="checkbox" name="languages_known[]" value="Hindi"><span>Hindi</span></label>
                                        <label class="reg-chip"><input type="checkbox" name="languages_known[]" value="Gujarati"><span>Gujarati</span></label>
                                    </div>
                                    <div class="reg-float" style="margin-top: 15px;">
                                        <input type="text" id="languages_known_other" name="languages_known_other" placeholder=" ">
                                        <label for="languages_known_other">Other Language(s) / अन्य भाषा(एँ) / અન્ય ભાષા(ઓ)</label>
                                    </div>
                                </div>
                            </div>

                            <!-- 25. Candidate Occupation -->
                            <div<?php echo sathi_reg_field_wrap_attrs('occupation'); ?>>
                                <div class="reg-float reg-float-select">
                                    <select id="occupation" name="occupation" <?php echo sathi_reg_field_required_attr('occupation'); ?>>
                                        <?php sathi_reg_render_select_options($masters['occupation']); ?>
                                    </select>
                                    <label for="occupation">Candidate Occupation / प्रत्याशी का व्यवसाय / ઉમેદવારનો વ્યવસાય</label>
                                </div>
                            </div>

                            <!-- 26. Candidate Occupation Company / Business Firm name -->
                            <div<?php echo sathi_reg_field_wrap_attrs('firm_name'); ?>>
                                <div class="reg-float">
                                    <input type="text" id="firm_name" name="firm_name" placeholder=" " <?php echo sathi_reg_field_required_attr('firm_name'); ?>>
                                    <label for="firm_name">Candidate Occupation Company / Business Firm name / प्रत्याशी की कंपनी/ फर्म का नाम / ઉમેદવારની કંપની / ફર્મનું નામ</label>
                                </div>
                            </div>

                            <!-- 27. Candidate Occupation Designation -->
                            <div<?php echo sathi_reg_field_wrap_attrs('designation'); ?>>
                                <div class="reg-float">
                                    <input type="text" id="designation" name="designation" placeholder=" " <?php echo sathi_reg_field_required_attr('designation'); ?>>
                                    <label for="designation">Candidate Occupation Designation / प्रत्याशी का पद / ઉમેદવારનો હોદ્દો</label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- STEP 4: Family -->
                    <div class="reg-panel" data-panel="3">
                        <h2 class="reg-section-title">Family Details</h2>
                        <div class="reg-split">

                            <!-- Father -->
                            <div class="reg-subcard">
                                <h3><i class="fa-solid fa-user-tie"></i> Father</h3>

                                <div<?php echo sathi_reg_field_wrap_attrs('father_name'); ?>>
                                    <div class="reg-float">
                                        <input type="text" id="father_name" name="father_name" placeholder=" " <?php echo sathi_reg_field_required_attr('father_name'); ?>>
                                        <label for="father_name">Father Name / पिता का नाम / પિતાનું નામ</label>
                                    </div>
                                </div>

                                <div<?php echo sathi_reg_field_wrap_attrs('father_mobile'); ?>>
                                    <div class="reg-float">
                                        <input type="tel" id="father_mobile" name="father_mobile" placeholder=" " maxlength="10" pattern="[0-9]{10}" <?php echo sathi_reg_field_required_attr('father_mobile'); ?>>
                                        <label for="father_mobile">Father Mobile Number / पिता का मोबाइल नंबर / પિતાનો મોબાઇલ નંબર</label>
                                    </div>
                                </div>

                                <div<?php echo sathi_reg_field_wrap_attrs('father_income'); ?>>
                                    <div class="reg-float">
                                        <input type="text" id="father_income" name="father_income" placeholder=" " inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '')" <?php echo sathi_reg_field_required_attr('father_income'); ?>>
                                        <label for="father_income">Father Monthly Income / पिता की मासिक आय / પિતાની માસિક આવક</label>
                                    </div>
                                    <small style="display:block; margin-top:6px; font-size:11px; color:#777; line-height:1.3;">(Only Amount In Number / केवल अंकों में राशि / માત્ર અંકમાં રકમ)</small>
                                </div>

                                <div<?php echo sathi_reg_field_wrap_attrs('father_occ'); ?>>
                                    <div class="reg-float reg-float-select">
                                        <select id="father_occ" name="father_occ" <?php echo sathi_reg_field_required_attr('father_occ'); ?>>
                                            <option value="" disabled selected></option>
                                            <option value="Job">Job</option>
                                            <option value="Business">Business</option>
                                            <option value="Retired">Retired</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        <label for="father_occ">Father Occupation / पिता का व्यवसाय / नौकरी / પિતાનો વ્યવસાય / નોકરી</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Mother -->
                            <div class="reg-subcard">
                                <h3><i class="fa-solid fa-user"></i> Mother</h3>

                                <div<?php echo sathi_reg_field_wrap_attrs('mother_name'); ?>>
                                    <div class="reg-float">
                                        <input type="text" id="mother_name" name="mother_name" placeholder=" " <?php echo sathi_reg_field_required_attr('mother_name'); ?>>
                                        <label for="mother_name">Mother Name / माता का नाम / માતાનું નામ</label>
                                    </div>
                                </div>

                                <div<?php echo sathi_reg_field_wrap_attrs('mother_mobile'); ?>>
                                    <div class="reg-float">
                                        <input type="tel" id="mother_mobile" name="mother_mobile" placeholder=" " maxlength="10" pattern="[0-9]{10}" <?php echo sathi_reg_field_required_attr('mother_mobile'); ?>>
                                        <label for="mother_mobile">Mother Mobile Number / माता का मोबाइल नंबर / માતાનો મોબાઇલ નંબર</label>
                                    </div>
                                </div>

                                <div<?php echo sathi_reg_field_wrap_attrs('mother_income'); ?>>
                                    <div class="reg-float">
                                        <input type="text" id="mother_income" name="mother_income" placeholder=" " inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '')" <?php echo sathi_reg_field_required_attr('mother_income'); ?>>
                                        <label for="mother_income">Mother Monthly Income / माता की मासिक आय / માતાની માસિક આવક</label>
                                    </div>
                                    <small style="display:block; margin-top:6px; font-size:11px; color:#777; line-height:1.3;">(Only Amount In Number / केवल अंकों में राशि / માત્ર અંકમાં રકમ)</small>
                                </div>

                                <div<?php echo sathi_reg_field_wrap_attrs('mother_occ'); ?>>
                                    <div class="reg-float reg-float-select">
                                        <select id="mother_occ" name="mother_occ" <?php echo sathi_reg_field_required_attr('mother_occ'); ?>>
                                            <option value="" disabled selected></option>
                                            <option value="Job">Job</option>
                                            <option value="Business">Business</option>
                                            <option value="Retired">Retired</option>
                                            <option value="Housewife">Housewife</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        <label for="mother_occ">Mother Occupation / माता का व्यवसाय / नौकरी / માતાનો વ્યવસાય / નોકરી</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Siblings -->
                        <div<?php echo sathi_reg_field_wrap_attrs('siblings'); ?> class="reg-subcard" style="margin-top:20px;">
                            <h3><i class="fa-solid fa-people-roof"></i> Siblings</h3>
                            <p style="font-size:12px;color:#666;margin-bottom:14px;">Married + unmarried must equal total for brothers and sisters.</p>

                            <p style="font-size:13px;font-weight:600;margin-bottom:8px;">Brothers / भाई / ભાઈ</p>
                            <div class="reg-sibling-grid">
                                <div class="reg-float">
                                    <input type="number" id="bro_total" name="bro_total" placeholder=" " min="0" value="0" <?php echo sathi_reg_field_required_attr('siblings'); ?>>
                                    <label for="bro_total">Total</label>
                                </div>
                                <div class="reg-float">
                                    <input type="number" id="bro_married" name="bro_married" placeholder=" " min="0" value="0" <?php echo sathi_reg_field_required_attr('siblings'); ?>>
                                    <label for="bro_married">Married</label>
                                </div>
                                <div class="reg-float">
                                    <input type="number" id="bro_unmarried" name="bro_unmarried" placeholder=" " min="0" value="0" <?php echo sathi_reg_field_required_attr('siblings'); ?>>
                                    <label for="bro_unmarried">Unmarried</label>
                                </div>
                            </div>
                            <span id="broErr" class="reg-error-msg sib-err">Married + unmarried must equal total (brothers).</span>

                            <p style="font-size:13px;font-weight:600;margin:18px 0 8px;">Sisters / बहन / બહેન</p>
                            <div class="reg-sibling-grid">
                                <div class="reg-float">
                                    <input type="number" id="sis_total" name="sis_total" placeholder=" " min="0" value="0" <?php echo sathi_reg_field_required_attr('siblings'); ?>>
                                    <label for="sis_total">Total</label>
                                </div>
                                <div class="reg-float">
                                    <input type="number" id="sis_married" name="sis_married" placeholder=" " min="0" value="0" <?php echo sathi_reg_field_required_attr('siblings'); ?>>
                                    <label for="sis_married">Married</label>
                                </div>
                                <div class="reg-float">
                                    <input type="number" id="sis_unmarried" name="sis_unmarried" placeholder=" " min="0" value="0" <?php echo sathi_reg_field_required_attr('siblings'); ?>>
                                    <label for="sis_unmarried">Unmarried</label>
                                </div>
                            </div>
                            <span id="sisErr" class="reg-error-msg sib-err">Married + unmarried must equal total (sisters).</span>
                        </div>
                    </div>

                    <!-- STEP 5: Photo -->
                    <div class="reg-panel" data-panel="4">
                        <h2 class="reg-section-title">Photo &amp; Verification</h2>
                        <div<?php echo sathi_reg_field_wrap_attrs('photo'); ?>>
                            <p class="reg-upload-heading">Candidate Photo (Pl Do Not Upload Selfie)<br>
                            <small>अपनी अच्छी केवल पासपोर्ट फोटो 10 MB से कम साईज की अपलोड करे फोटो परिचय पुस्तिका मे प्रिंट होगी</small></p>
                            <label class="reg-upload reg-upload--photo" id="photoZone">
                                <input type="file" id="photo" name="photo" accept=".jpg,.jpeg,.png,image/jpeg,image/png" <?php echo sathi_reg_field_required_attr('photo'); ?> aria-label="Upload profile photo">
                                <span class="reg-upload-body">
                                    <span class="reg-upload-icon" aria-hidden="true"><i class="fa-solid fa-camera"></i></span>
                                    <span class="reg-upload-title">Upload profile photograph</span>
                                    <span class="reg-upload-hint">JPG or PNG · Max 10 MB · Clear face visible</span>
                                    <span class="reg-progress" id="photoProgress"><span class="reg-progress-bar" id="photoProgressBar"></span></span>
                                    <img src="" alt="" class="reg-preview" id="photoPreview" width="200" height="200">
                                </span>
                            </label>
                            <div class="reg-guidelines">
                                <h4>Photo guidelines</h4>
                                <ul>
                                    <li class="ok">Passport-style preferred · Good lighting</li>
                                    <li class="ok">Clear face visible</li>
                                    <li class="bad">No selfies · No group photos · No heavy filters</li>
                                </ul>
                            </div>
                            <p class="reg-trust-strip" style="justify-content:flex-start;margin-top:16px;">
                                <span><i class="fa-solid fa-lock"></i> Secure upload</span>
                                <span><i class="fa-solid fa-user-check"></i> Admin review before profile is live</span>
                            </p>
                        </div>
                    </div>

                    <!-- STEP 6: Payment (conditional) -->
                    <?php if ($payment_enabled): ?>
                        <div class="reg-panel" data-panel="5">
                            <h2 class="reg-section-title">Membership payment</h2>
                            <p class="reg-payment-intro">Activate your profile listing with the bureau registration fee. Payment gateway integration can be connected later – select a method below to continue.</p>
                            <div class="reg-payment-card">
                                <div class="reg-payment-card-head">
                                    <div>
                                        <span class="reg-payment-badge">Registration</span>
                                        <h3 class="reg-payment-plan-name">Standard · 180 days</h3>
                                        <p class="reg-payment-plan-meta">Profile visibility · Basic match suggestions</p>
                                    </div>
                                    <p class="reg-payment-amount"><span class="reg-payment-currency">₹</span>999</p>
                                </div>
                                <ul class="reg-payment-features">
                                    <li><i class="fa-solid fa-check" aria-hidden="true"></i> Profile listed after admin verification</li>
                                    <li><i class="fa-solid fa-check" aria-hidden="true"></i> Secure document &amp; photo review</li>
                                    <li><i class="fa-solid fa-check" aria-hidden="true"></i> Upgrade anytime to Premium</li>
                                </ul>
                            </div>
                            <div<?php echo sathi_reg_field_wrap_attrs('pay_method'); ?>>
                                <fieldset class="reg-payment-fieldset">
                                    <legend class="reg-payment-legend">Choose payment method</legend>
                                    <label class="reg-pay-option">
                                        <input type="radio" name="pay_method" value="razorpay" checked>
                                        <span class="reg-pay-option-body">
                                            <span class="reg-pay-title"><i class="fa-solid fa-bolt" aria-hidden="true"></i> Razorpay</span>
                                            <span class="reg-pay-sub">Cards, UPI, netbanking</span>
                                        </span>
                                    </label>
                                </fieldset>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="reg-nav">
                        <button type="button" class="reg-btn reg-btn--prev" id="btnPrev">Back</button>
                        <button type="button" class="reg-btn reg-btn--next" id="btnNext">Continue</button>
                        <button type="submit" class="reg-btn reg-btn--primary" id="btnSubmit"><?php echo $payment_enabled ? 'Pay & submit registration' : 'Complete Registration'; ?></button>
                    </div>
                </form>
                                                                                                                                    </div>
                                                                                                                                    </div>
                                                                                                                                    </div>
                                                                                                                                    </div>
</main>

<script>
    (function () {
        const form = document.getElementById('regWizard');
        const panels = document.querySelectorAll('.reg-panel');
        const steps = document.querySelectorAll('.reg-step-item');
        const nav = document.querySelector('.reg-nav');
        const btnPrev = document.getElementById('btnPrev');
        const btnNext = document.getElementById('btnNext');
        const btnSubmit = document.getElementById('btnSubmit');
        const paymentEnabled = <?php echo $payment_enabled ? 'true' : 'false'; ?>;
        let step = 0;

        if (form && nav && nav.parentElement !== form) {
            form.appendChild(nav);
        }

        function showStep(n) {
            n = Math.max(0, Math.min(n, panels.length - 1));
            panels.forEach((p, i) => p.classList.toggle('active', i === n));
            steps.forEach((s, i) => s.classList.toggle('active', i === n));
            steps.forEach((s, i) => s.classList.toggle('completed', i < n));
            if (nav) nav.style.display = 'flex';
            btnPrev.style.display = n === 0 ? 'none' : 'inline-block';
            btnNext.style.display = n === panels.length - 1 ? 'none' : 'inline-block';
            btnSubmit.style.display = n === panels.length - 1 ? 'inline-block' : 'none';
            step = n;
            window.scrollTo({ top: 0, behavior: 'smooth' });
            saveDraft();
        }

        function validateStep(n) {
            const panel = panels[n];
            const required = panel.querySelectorAll('[required]');
            let valid = true;
            let firstInvalid = null;
            required.forEach(el => {
                if (el.offsetParent === null) return; // skip hidden
                if (!el.checkValidity() || (el.type === 'checkbox' && !el.checked)) {
                    el.closest('.reg-float')?.classList.add('invalid');
                    el.closest('.reg-upload')?.classList.add('invalid');
                    firstInvalid = firstInvalid || el;
                    valid = false;
                } else {
                    el.closest('.reg-float')?.classList.remove('invalid');
                    el.closest('.reg-upload')?.classList.remove('invalid');
                }
            });

            if (n === 3) { // Family step validation
                if (!validateSiblings()) valid = false;
            }

            if (!valid) {
                const target = firstInvalid?.closest('.reg-float, .reg-upload-field, .reg-upload') || firstInvalid;
                target?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                setTimeout(() => firstInvalid?.focus?.({ preventScroll: true }), 250);
                if (window.Swal) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Complete required fields',
                        text: 'Please fill the highlighted fields before continuing.',
                        confirmButtonColor: '#f45c93'
                    });
                }
            }

            return valid;
        }

        function validateSiblings() {
            const bt = parseInt(document.getElementById('bro_total').value) || 0;
            const bm = parseInt(document.getElementById('bro_married').value) || 0;
            const bu = parseInt(document.getElementById('bro_unmarried').value) || 0;
            const st = parseInt(document.getElementById('sis_total').value) || 0;
            const sm = parseInt(document.getElementById('sis_married').value) || 0;
            const su = parseInt(document.getElementById('sis_unmarried').value) || 0;

            let ok = true;
            if (bt !== (bm + bu)) {
                document.getElementById('broErr').classList.add('visible');
                ok = false;
            } else {
                document.getElementById('broErr').classList.remove('visible');
            }
            if (st !== (sm + su)) {
                document.getElementById('sisErr').classList.add('visible');
                ok = false;
            } else {
                document.getElementById('sisErr').classList.remove('visible');
            }
            return ok;
        }

        btnNext.addEventListener('click', (event) => {
            event.preventDefault();
            if (validateStep(step)) showStep(step + 1);
        });
        btnPrev.addEventListener('click', () => showStep(step - 1));

        // Stepper click logic (allow going back)
        document.querySelectorAll('.reg-step-item').forEach(item => {
            item.addEventListener('click', () => {
                const targetStep = parseInt(item.getAttribute('data-step'));
                if (targetStep < step) {
                    showStep(targetStep);
                }
            });
        });

        // Geo Cascade
        const geoData = <?php echo json_encode($masters['geo']); ?>;
        document.querySelectorAll('[data-geo-role="country"]').forEach(sel => {
            sel.addEventListener('change', function () {
                const prefix = this.getAttribute('data-geo-prefix');
                const stateSel = document.getElementById(prefix + 'state');
                const citySel = document.getElementById(prefix + 'city');
                if (!stateSel) return;
                stateSel.innerHTML = '<option value="" disabled selected>Select State</option>';
                if (citySel) citySel.innerHTML = '<option value="" disabled selected>Select City</option>';

                const states = geoData.states[this.value] || [];
                states.forEach(s => {
                    stateSel.innerHTML += `<option value="${s.value}">${s.label}</option>`;
                });
                stateSel.innerHTML += '<option value="other">Other (Custom)</option>';
                stateSel.dispatchEvent(new Event('change', { bubbles: true }));
            });
        });

        document.querySelectorAll('[data-geo-role="state"]').forEach(sel => {
            sel.addEventListener('change', function () {
                const prefix = this.getAttribute('data-geo-prefix');
                const citySel = document.getElementById(prefix + 'city');
                if (!citySel) return;
                citySel.innerHTML = '<option value="" disabled selected>Select City</option>';
                const cities = geoData.cities[this.value] || [];
                cities.forEach(c => {
                    citySel.innerHTML += `<option value="${c.value}">${c.label}</option>`;
                });
                citySel.innerHTML += '<option value="other">Other (Custom)</option>';
                citySel.dispatchEvent(new Event('change', { bubbles: true }));
            });
        });

        // Custom Dropdown Logic
        function handleCustomDropdown(sel) {
            const wrap = sel.closest('.reg-float-select');
            if (!wrap) return;
            let customInput = wrap.querySelector('.reg-custom-input');
            if (sel.value === 'other') {
                if (!customInput) {
                    customInput = document.createElement('input');
                    customInput.type = 'text';
                    customInput.className = 'reg-custom-input';
                    customInput.placeholder = 'Please specify...';
                    customInput.style.marginTop = '10px';
                    customInput.name = sel.name + '_custom';
                    wrap.appendChild(customInput);
                    customInput.focus();
                }
                customInput.style.display = 'block';
                customInput.required = true;
            } else {
                if (customInput) {
                    customInput.style.display = 'none';
                    customInput.required = false;
                }
            }
        }

        // Initial field setup for custom inputs
        document.querySelectorAll('select').forEach(sel => {
            // Add "Other" to all selects if not present
            if (!sel.querySelector('option[value="other"]')) {
                sel.innerHTML += '<option value="other">Other (Custom)</option>';
            }

            // Create custom input upfront
            const wrap = sel.closest('.reg-float-select');
            if (wrap && !wrap.querySelector('.reg-custom-input')) {
                const customInput = document.createElement('input');
                customInput.type = 'text';
                customInput.className = 'reg-custom-input';
                customInput.placeholder = 'Please specify...';
                customInput.name = sel.name + '_custom';
                wrap.appendChild(customInput);
            }

            sel.addEventListener('change', () => handleCustomDropdown(sel));
        });

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (!validateStep(step)) return;
            const pw = document.getElementById('password');
            const pwc = document.getElementById('password_confirm');
            if (pw && pwc && pw.value !== pwc.value) {
                Swal.fire({icon: 'error', text: 'Passwords do not match.', confirmButtonColor: '#e94e77'});
                return;
            }

            if (!paymentEnabled) {
                submitRegistration();
                return;
            }

            const options = {
                "key": "rzp_test_S7dlJIqMvrpcaj",
                "amount": 99900,
                "currency": "INR",
                "name": "ShadikiBaat",
                "description": "Registration Fee",
                "handler": function (response) {
                    submitRegistration(response.razorpay_payment_id);
                },
                "prefill": {
                    "name": ((document.getElementById('first_name')?.value || '') + ' ' + (document.getElementById('last_name')?.value || '')).trim(),
                    "email": document.getElementById('email')?.value || '',
                    "contact": document.getElementById('mobile')?.value || ''
                },
                "theme": { "color": "#e91e63" }
            };
            const rzp = new Razorpay(options);
            rzp.open();
        });

        function submitRegistration(paymentId = '') {
            btnSubmit.disabled = true;
            btnSubmit.textContent = 'Processing...';
            const fd = new FormData(form);
            if (paymentId) fd.append('razorpay_payment_id', paymentId);

            fetch('api/complete-registration.php', {
                method: 'POST',
                credentials: 'same-origin',
                body: fd
            })
                .then(r => r.json())
                .then(data => {
                    if (data.ok) {
                        localStorage.removeItem('sathi_reg_draft');
                        window.location.href = 'index.php';
                    } else {
                        Swal.fire({icon: 'error', text: data.error || 'Registration failed', confirmButtonColor: '#e94e77'});
                        btnSubmit.disabled = false;
                        btnSubmit.textContent = paymentEnabled ? 'Pay & submit registration' : 'Complete Registration';
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire({icon: 'error', text: 'Network error. Please try again.', confirmButtonColor: '#e94e77'});
                    btnSubmit.disabled = false;
                    btnSubmit.textContent = paymentEnabled ? 'Pay & submit registration' : 'Complete Registration';
                });
        }

        // Persistence logic
        let draftTimeout;
        function saveDraft() {
            clearTimeout(draftTimeout);
            draftTimeout = setTimeout(() => {
                const fd = new FormData(form);
                const data = {};
                for (let [key, val] of fd.entries()) {
                    if (key !== 'password' && key !== 'password_confirm' && !(val instanceof File)) {
                        if (data[key] !== undefined) {
                            if (!Array.isArray(data[key])) data[key] = [data[key]];
                            data[key].push(val);
                        } else {
                            data[key] = val;
                        }
                    }
                }
                data['_current_step'] = step;
                localStorage.setItem('sathi_reg_draft', JSON.stringify(data));
            }, 500);
        }

        async function loadDraft() {
            const raw = localStorage.getItem('sathi_reg_draft');
            if (!raw) {
                showStep(0);
                return;
            }
            try {
                const data = JSON.parse(raw);

                // Step 1: Set basic fields and trigger changes to populate dynamic selects
                const fields = Object.keys(data);

                // We need to set them in an order that respects dependencies
                // Or just do multiple passes.
                for (let pass = 0; pass < 3; pass++) {
                    for (const key of fields) {
                        const el = form.elements[key];
                        if (!el) continue;

                        if (el instanceof RadioNodeList || (el.length && !el.tagName)) {
                            // Multiple elements (checkboxes or radios)
                            const valArray = Array.isArray(data[key]) ? data[key] : [data[key]];
                            for (let i = 0; i < el.length; i++) {
                                if (el[i].type === 'checkbox' || el[i].type === 'radio') {
                                    el[i].checked = valArray.includes(el[i].value);
                                }
                            }
                        } else if (el.type === 'checkbox' || el.type === 'radio') {
                            el.checked = (el.value === data[key]);
                        } else {
                            el.value = data[key];
                        }

                        el.dispatchEvent(new Event('input', { bubbles: true }));
                        el.dispatchEvent(new Event('change', { bubbles: true }));

                        if (el.tagName === 'SELECT') handleCustomDropdown(el);
                    }
                    await new Promise(r => setTimeout(r, 100)); // Wait for any cascades
                }

                if (data['_current_step'] !== undefined) {
                    showStep(parseInt(data['_current_step']));
                } else {
                    showStep(0);
                }
            } catch (e) {
                console.error('Draft load error', e);
                showStep(0);
            }
        }

        form.addEventListener('input', saveDraft);
        form.addEventListener('change', saveDraft);
        window.addEventListener('load', loadDraft);

        // Initial field setup for custom inputs
        document.querySelectorAll('select').forEach(handleCustomDropdown);

    })();

    // File input labels
    ['kundli_image', 'horoscope', 'photo'].forEach(id => {
        const el = document.getElementById(id);
        if (!el) return;
        el.addEventListener('change', function () {
            const sp = document.getElementById(id.replace('_image', '') + 'Name');
            if (sp && this.files[0]) sp.textContent = this.files[0].name;
        });
    });

    // Sibling listeners
    ['bro_total', 'bro_married', 'bro_unmarried', 'sis_total', 'sis_married', 'sis_unmarried'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.addEventListener('input', () => {
            const bt = parseInt(document.getElementById('bro_total').value) || 0;
            const bm = parseInt(document.getElementById('bro_married').value) || 0;
            const bu = parseInt(document.getElementById('bro_unmarried').value) || 0;
            if (bt === (bm + bu)) document.getElementById('broErr').classList.remove('visible');
            const st = parseInt(document.getElementById('sis_total').value) || 0;
            const sm = parseInt(document.getElementById('sis_married').value) || 0;
            const su = parseInt(document.getElementById('sis_unmarried').value) || 0;
            if (st === (sm + su)) document.getElementById('sisErr').classList.remove('visible');
        });
    });

    // Digamber Jain validation
    const digamberSelect = document.getElementById('digamber');
    if (digamberSelect) {
        digamberSelect.addEventListener('change', function () {
            if (this.value === 'no') {
                Swal.fire({
                    icon: 'error',
                    title: 'Access Denied',
                    text: 'This website is only for Digambar Jain.',
                    confirmButtonColor: '#f45c93'
                }).then(() => {
                    this.value = 'yes'; // Reset to Yes
                    // Update custom dropdown span text if it exists
                    const wrapper = this.closest('.reg-float-select');
                    if (wrapper) {
                        const span = wrapper.querySelector('.select-selected');
                        if (span) span.textContent = 'Yes';
                    }
                });
            }
        });
    }
</script>

<?php include 'footer.php'; ?>
</body>

</html>
