<?php
$pageTitle = 'Register – Shadikibaat | Marriage Bureau Onboarding';
$bodyClass = 'reg-page reg-page-register';
$extraCss = 'register-wizard.css';
include 'header.php';
?>

<main class="reg-bg reg-bg--photo">
    <div class="container reg-shell reg-shell--hero">
        <div class="reg-form-column">
        <div class="reg-card">
            <header class="reg-card-head">
                <p class="reg-badge"><span aria-hidden="true">💍</span> Trusted matrimonial bureau</p>
                <h1>Create your profile</h1>
                <p class="reg-card-lead">A secure onboarding — verified profiles for families serious about finding the right match.</p>
            </header>

            <div class="reg-stepper-wrap">
                <ol class="reg-stepper" role="list">
                    <li class="reg-step-item active" data-step="0"><span class="num">1</span><span>Basic Info</span></li>
                    <li class="reg-step-item" data-step="1"><span class="num">2</span><span>Contact</span></li>
                    <li class="reg-step-item" data-step="2"><span class="num">3</span><span>Career</span></li>
                    <li class="reg-step-item" data-step="3"><span class="num">4</span><span>Family</span></li>
                    <li class="reg-step-item" data-step="4"><span class="num">5</span><span>Upload</span></li>
                </ol>
            </div>

            <form id="regWizard" class="reg-form" action="#" method="post" novalidate>
                <!-- STEP 1 -->
                <div class="reg-panel active" data-panel="0">
                    <h2 class="reg-section-title">Basic information</h2>
                    <div class="reg-grid">
                        <div class="reg-float">
                            <input type="email" id="email" name="email" placeholder=" " required autocomplete="email">
                            <label for="email">Email address</label>
                            <span class="reg-error-msg">Enter a valid email</span>
                        </div>
                        <div class="reg-float reg-float-select">
                            <select id="digamber" name="digamber" required>
                                <option value="" disabled selected></option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                            <label for="digamber">Are you Digamber Jain?</label>
                        </div>
                        <div class="reg-float reg-grid-full">
                            <input type="text" id="full_name" name="full_name" placeholder=" " required autocomplete="name">
                            <label for="full_name">Full name</label>
                        </div>
                        <div class="reg-float reg-float-select">
                            <select id="gender" name="gender" required>
                                <option value="" disabled selected></option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                            <label for="gender">Gender</label>
                        </div>
                        <div class="reg-float">
                            <input type="date" id="birth_date" name="birth_date" placeholder=" " required>
                            <label for="birth_date">Birth date</label>
                        </div>
                        <div class="reg-float">
                            <input type="time" id="birth_time" name="birth_time" placeholder=" " required>
                            <label for="birth_time">Birth time</label>
                        </div>
                        <div class="reg-float">
                            <input type="text" id="birth_place" name="birth_place" placeholder=" " required>
                            <label for="birth_place">Birth place</label>
                        </div>
                        <div class="reg-float">
                            <input type="text" id="native_place" name="native_place" placeholder=" " required>
                            <label for="native_place">Native</label>
                        </div>
                        <div class="reg-float reg-float-select">
                            <select id="gotra" name="gotra" required>
                                <option value="" disabled selected></option>
                                <option value="kashyap">Kashyap</option>
                                <option value="bharadwaj">Bharadwaj</option>
                                <option value="vasishtha">Vasishtha</option>
                                <option value="other">Other</option>
                                <option value="prefer_not">Prefer not to say</option>
                            </select>
                            <label for="gotra">Gotra</label>
                        </div>
                        <div class="reg-float reg-float-select">
                            <select id="religion_status" name="religion_status" required>
                                <option value="" disabled selected></option>
                                <option value="hindu">Hindu</option>
                                <option value="jain">Jain</option>
                                <option value="other">Other</option>
                            </select>
                            <label for="religion_status">Religion</label>
                        </div>
                        <div class="reg-grid-full reg-upload-field">
                            <p class="reg-upload-heading">Horoscope (PDF / JPG / PNG)</p>
                            <label class="reg-upload" id="horoscopeZone">
                                <input type="file" id="horoscope" name="horoscope" accept=".pdf,.jpg,.jpeg,.png,application/pdf" required aria-label="Upload horoscope file">
                                <span class="reg-upload-body">
                                    <span class="reg-upload-icon" aria-hidden="true"><i class="fa-solid fa-file-lines"></i></span>
                                    <span class="reg-upload-title">Drag &amp; drop or click to upload</span>
                                    <span class="reg-upload-hint">Max 5 MB · PDF or image</span>
                                    <span id="horoscopeName" class="reg-file-name"></span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- STEP 2 -->
                <div class="reg-panel" data-panel="1">
                    <h2 class="reg-section-title">Contact &amp; address</h2>
                    <div class="reg-split">
                        <div class="reg-subcard">
                            <h3><i class="fa-solid fa-phone"></i> Contact</h3>
                            <div class="reg-phone-row">
                                <div class="reg-float reg-float-select reg-cc">
                                    <select id="country_code" name="country_code">
                                        <option value="+91" selected>+91</option>
                                        <option value="+1">+1</option>
                                        <option value="+44">+44</option>
                                    </select>
                                    <label for="country_code">Code</label>
                                </div>
                                <div class="reg-float" style="flex:1;">
                                    <input type="tel" id="mobile" name="mobile" placeholder=" " required maxlength="10" pattern="[0-9]{10}" inputmode="numeric">
                                    <label for="mobile">Mobile number</label>
                                    <span class="reg-error-msg">Enter 10-digit mobile number</span>
                                </div>
                            </div>
                            <p class="reg-wa-hint"><i class="fa-brands fa-whatsapp"></i> WhatsApp available on this number</p>
                            <p class="reg-otp-note"><i class="fa-solid fa-shield-halved"></i> OTP verification can be enabled before profile goes live.</p>
                        </div>
                        <div class="reg-subcard">
                            <h3><i class="fa-solid fa-location-dot"></i> Address</h3>
                            <div class="reg-float">
                                <textarea id="addr_perm" name="addr_perm" placeholder=" " required rows="3"></textarea>
                                <label for="addr_perm">Permanent address</label>
                            </div>
                            <label class="reg-checkbox-row">
                                <input type="checkbox" id="same_as_perm" name="same_as_perm">
                                <span>Same as permanent for current address</span>
                            </label>
                            <div class="reg-float" style="margin-top:14px;">
                                <textarea id="addr_curr" name="addr_curr" placeholder=" " required rows="3"></textarea>
                                <label for="addr_curr">Current address</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 3 -->
                <div class="reg-panel" data-panel="2">
                    <h2 class="reg-section-title">Education &amp; career</h2>
                    <div class="reg-grid">
                        <div class="reg-float reg-grid-full">
                            <input type="text" id="education" name="education" placeholder=" " required>
                            <label for="education">Higher education</label>
                        </div>
                        <div class="reg-grid-full">
                            <p style="font-size:13px;font-weight:600;color:#333;margin-bottom:10px;">Hobbies</p>
                            <div class="reg-chips">
                                <label class="reg-chip"><input type="checkbox" name="hobby[]" value="reading"><span>Reading</span></label>
                                <label class="reg-chip"><input type="checkbox" name="hobby[]" value="travelling"><span>Travelling</span></label>
                                <label class="reg-chip"><input type="checkbox" name="hobby[]" value="music"><span>Music</span></label>
                                <label class="reg-chip"><input type="checkbox" name="hobby[]" value="sports"><span>Sports</span></label>
                                <label class="reg-chip"><input type="checkbox" name="hobby[]" value="meditation"><span>Meditation</span></label>
                            </div>
                        </div>
                        <div class="reg-float reg-float-select">
                            <select id="occupation" name="occupation" required>
                                <option value="" disabled selected></option>
                                <option value="business">Business</option>
                                <option value="service">Service</option>
                                <option value="government">Government</option>
                                <option value="ca">CA</option>
                                <option value="doctor">Doctor</option>
                                <option value="engineer">Engineer</option>
                                <option value="advocate">Advocate</option>
                                <option value="entrepreneur">Entrepreneur</option>
                            </select>
                            <label for="occupation">Occupation</label>
                        </div>
                        <div class="reg-float">
                            <input type="text" id="firm_name" name="firm_name" placeholder=" " required>
                            <label for="firm_name">Firm / company name</label>
                        </div>
                        <div class="reg-float">
                            <input type="text" id="designation" name="designation" placeholder=" " required>
                            <label for="designation">Designation</label>
                        </div>
                        <div class="reg-float reg-income-wrap">
                            <span class="inr">₹</span>
                            <input type="text" id="annual_income" name="annual_income" placeholder=" " required inputmode="numeric" autocomplete="off">
                            <label for="annual_income">Annual income</label>
                            <span class="reg-error-msg">Numbers only</span>
                        </div>
                    </div>
                </div>

                <!-- STEP 4 -->
                <div class="reg-panel" data-panel="3">
                    <h2 class="reg-section-title">Family details</h2>
                    <div class="reg-split">
                        <div class="reg-subcard">
                            <h3><i class="fa-solid fa-user-tie"></i> Father</h3>
                            <div class="reg-float">
                                <input type="text" id="father_name" name="father_name" placeholder=" " required>
                                <label for="father_name">Father's name</label>
                            </div>
                            <div class="reg-float">
                                <input type="tel" id="father_mobile" name="father_mobile" placeholder=" " maxlength="10" pattern="[0-9]{10}">
                                <label for="father_mobile">Mobile</label>
                            </div>
                            <div class="reg-float">
                                <input type="text" id="father_income" name="father_income" placeholder=" " inputmode="numeric">
                                <label for="father_income">Annual income</label>
                            </div>
                            <div class="reg-float">
                                <input type="text" id="father_occ" name="father_occ" placeholder=" ">
                                <label for="father_occ">Occupation</label>
                            </div>
                        </div>
                        <div class="reg-subcard">
                            <h3><i class="fa-solid fa-user"></i> Mother</h3>
                            <div class="reg-float">
                                <input type="text" id="mother_name" name="mother_name" placeholder=" " required>
                                <label for="mother_name">Mother's name</label>
                            </div>
                            <div class="reg-float">
                                <input type="tel" id="mother_mobile" name="mother_mobile" placeholder=" " maxlength="10" pattern="[0-9]{10}">
                                <label for="mother_mobile">Mobile</label>
                            </div>
                            <div class="reg-float">
                                <input type="text" id="mother_income" name="mother_income" placeholder=" " inputmode="numeric">
                                <label for="mother_income">Annual income</label>
                            </div>
                            <div class="reg-float">
                                <input type="text" id="mother_occ" name="mother_occ" placeholder=" ">
                                <label for="mother_occ">Occupation</label>
                            </div>
                        </div>
                    </div>
                    <div class="reg-subcard" style="margin-top:20px;">
                        <h3><i class="fa-solid fa-people-roof"></i> Siblings</h3>
                        <p style="font-size:12px;color:#666;margin-bottom:14px;">Married + unmarried must equal total for brothers and sisters.</p>
                        <p style="font-size:13px;font-weight:600;margin-bottom:8px;">Brothers</p>
                        <div class="reg-sibling-grid">
                            <div class="reg-float">
                                <input type="number" id="bro_total" name="bro_total" placeholder=" " min="0" required value="0">
                                <label for="bro_total">Total</label>
                            </div>
                            <div class="reg-float">
                                <input type="number" id="bro_married" name="bro_married" placeholder=" " min="0" required value="0">
                                <label for="bro_married">Married</label>
                            </div>
                            <div class="reg-float">
                                <input type="number" id="bro_unmarried" name="bro_unmarried" placeholder=" " min="0" required value="0">
                                <label for="bro_unmarried">Unmarried</label>
                            </div>
                        </div>
                        <span id="broErr" class="reg-error-msg sib-err">Married + unmarried must equal total (brothers).</span>
                        <p style="font-size:13px;font-weight:600;margin:18px 0 8px;">Sisters</p>
                        <div class="reg-sibling-grid">
                            <div class="reg-float">
                                <input type="number" id="sis_total" name="sis_total" placeholder=" " min="0" required value="0">
                                <label for="sis_total">Total</label>
                            </div>
                            <div class="reg-float">
                                <input type="number" id="sis_married" name="sis_married" placeholder=" " min="0" required value="0">
                                <label for="sis_married">Married</label>
                            </div>
                            <div class="reg-float">
                                <input type="number" id="sis_unmarried" name="sis_unmarried" placeholder=" " min="0" required value="0">
                                <label for="sis_unmarried">Unmarried</label>
                            </div>
                        </div>
                        <span id="sisErr" class="reg-error-msg sib-err">Married + unmarried must equal total (sisters).</span>
                    </div>
                </div>

                <!-- STEP 5 -->
                <div class="reg-panel" data-panel="4">
                    <h2 class="reg-section-title">Photo &amp; verification</h2>
                    <label class="reg-upload reg-upload--photo" id="photoZone">
                        <input type="file" id="photo" name="photo" accept=".jpg,.jpeg,.png,image/jpeg,image/png" required aria-label="Upload profile photo">
                        <span class="reg-upload-body">
                            <span class="reg-upload-icon" aria-hidden="true"><i class="fa-solid fa-camera"></i></span>
                            <span class="reg-upload-title">Upload profile photograph</span>
                            <span class="reg-upload-hint">JPG or PNG · Max 5 MB · Clear face visible</span>
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

                <div class="reg-actions">
                    <button type="button" class="reg-btn reg-btn-secondary" id="regPrev" disabled>← Back</button>
                    <div style="display:flex;gap:12px;flex-wrap:wrap;">
                        <button type="button" class="reg-btn reg-btn-primary" id="regNext">Next step</button>
                        <button type="submit" class="reg-btn reg-btn-primary hidden" id="regSubmit">Submit registration</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="reg-trust-strip reg-trust-strip--hero">
            <span><i class="fa-solid fa-shield-heart"></i> Verified bureau process</span>
            <span><i class="fa-solid fa-eye-slash"></i> Privacy-first</span>
            <span><i class="fa-solid fa-certificate"></i> Profile badge after verification</span>
        </div>
        </div>
    </div>
</main>

<style>
    .hidden { display: none !important; }
</style>
<script>
(function () {
    const form = document.getElementById('regWizard');
    const panels = form.querySelectorAll('.reg-panel');
    const stepItems = document.querySelectorAll('.reg-step-item');
    const btnPrev = document.getElementById('regPrev');
    const btnNext = document.getElementById('regNext');
    const btnSubmit = document.getElementById('regSubmit');
    let step = 0;

    function showStep(i) {
        step = Math.max(0, Math.min(i, panels.length - 1));
        panels.forEach((p, idx) => p.classList.toggle('active', idx === step));
        stepItems.forEach((el, idx) => {
            el.classList.toggle('active', idx === step);
            el.classList.toggle('done', idx < step);
            const n = el.querySelector('.num');
            if (idx < step) n.innerHTML = '<i class="fa-solid fa-check"></i>';
            else n.textContent = String(idx + 1);
        });
        btnPrev.disabled = step === 0;
        btnNext.classList.toggle('hidden', step === panels.length - 1);
        btnSubmit.classList.toggle('hidden', step !== panels.length - 1);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function floatLabelEmail() {
        const el = document.getElementById('email');
        const wrap = el.closest('.reg-float');
        if (el.validity.typeMismatch || (el.value && !el.checkValidity())) wrap.classList.add('invalid');
        else wrap.classList.remove('invalid');
    }

        function validateSiblings() {
        const broErr = document.getElementById('broErr');
        const sisErr = document.getElementById('sisErr');
        let ok = true;
        function check(totalId, mId, uId, errEl) {
            const t = parseInt(document.getElementById(totalId).value, 10) || 0;
            const m = parseInt(document.getElementById(mId).value, 10) || 0;
            const u = parseInt(document.getElementById(uId).value, 10) || 0;
            const match = m + u === t;
            errEl.classList.toggle('visible', !match);
            if (!match) ok = false;
        }
        check('bro_total', 'bro_married', 'bro_unmarried', broErr);
        check('sis_total', 'sis_married', 'sis_unmarried', sisErr);
        return ok;
    }

    function validateStep(i) {
        const panel = panels[i];
        const fields = panel.querySelectorAll('input[required], select[required], textarea[required]');
        for (const f of fields) {
            if (f.type === 'file') {
                if (!f.files || !f.files.length) {
                    f.closest('label')?.classList.add('invalid');
                    return false;
                }
                f.closest('label')?.classList.remove('invalid');
                continue;
            }
            if (!f.checkValidity()) {
                f.reportValidity();
                return false;
            }
        }
        if (i === 0) {
            floatLabelEmail();
            const h = document.getElementById('horoscope');
            const f = h.files[0];
            if (f) {
                const nameOk = /\.(pdf|png|jpe?g)$/i.test(f.name);
                const typeOk = /^(image\/(jpeg|png)|application\/pdf)/i.test(f.type);
                if (!nameOk && !typeOk) {
                    alert('Horoscope must be a PDF or image (JPG/PNG).');
                    return false;
                }
                if (f.size > 5 * 1024 * 1024) {
                    alert('Horoscope must be under 5 MB.');
                    return false;
                }
            }
        }
        if (i === 2) {
            const inc = document.getElementById('annual_income');
            const raw = inc.value.replace(/,/g, '');
            const wrap = inc.closest('.reg-float');
            if (!raw || !/^\d+$/.test(raw)) {
                wrap.classList.add('invalid');
                inc.focus();
                return false;
            }
            wrap.classList.remove('invalid');
        }
        if (i === 3 && !validateSiblings()) return false;
        if (i === 4) {
            const ph = document.getElementById('photo');
            const file = ph.files[0];
            if (!file) return false;
            if (!/^image\/(jpeg|png)$/i.test(file.type)) {
                alert('Please upload JPG or PNG only.');
                return false;
            }
            if (file.size > 5 * 1024 * 1024) {
                alert('Photo must be under 5 MB.');
                return false;
            }
        }
        return true;
    }

    btnNext.addEventListener('click', function () {
        if (!validateStep(step)) return;
        showStep(step + 1);
    });
    btnPrev.addEventListener('click', function () {
        showStep(step - 1);
    });

    document.getElementById('same_as_perm').addEventListener('change', function () {
        const perm = document.getElementById('addr_perm').value;
        const curr = document.getElementById('addr_curr');
        if (this.checked) {
            curr.value = perm;
            curr.dispatchEvent(new Event('input'));
        }
    });
    document.getElementById('addr_perm').addEventListener('input', function () {
        if (document.getElementById('same_as_perm').checked) {
            document.getElementById('addr_curr').value = this.value;
        }
    });

    const incomeEl = document.getElementById('annual_income');
    incomeEl.addEventListener('input', function () {
        let raw = this.value.replace(/[^\d]/g, '');
        this.value = raw.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    });
    incomeEl.addEventListener('blur', function () {
        const wrap = this.closest('.reg-float');
        const num = this.value.replace(/,/g, '');
        if (num && !/^\d+$/.test(num)) wrap.classList.add('invalid');
        else wrap.classList.remove('invalid');
    });

    ['bro_total', 'bro_married', 'bro_unmarried', 'sis_total', 'sis_married', 'sis_unmarried'].forEach(function (id) {
        document.getElementById(id).addEventListener('input', validateSiblings);
    });

    function bindDrop(zoneId, inputId, onPick) {
        const zone = document.getElementById(zoneId);
        const input = document.getElementById(inputId);
        if (!zone || !input) return;
        ['dragover', 'dragenter'].forEach(function (ev) {
            zone.addEventListener(ev, function (e) {
                e.preventDefault();
                zone.classList.add('dragover');
            });
        });
        zone.addEventListener('dragleave', function () {
            zone.classList.remove('dragover');
        });
        zone.addEventListener('drop', function (e) {
            e.preventDefault();
            zone.classList.remove('dragover');
            if (e.dataTransfer.files.length) {
                input.files = e.dataTransfer.files;
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }
        });
    }
    bindDrop('horoscopeZone', 'horoscope');
    bindDrop('photoZone', 'photo');

    document.getElementById('horoscope').addEventListener('change', function () {
        const sp = document.getElementById('horoscopeName');
        if (this.files[0]) {
            sp.textContent = this.files[0].name;
            this.closest('label').classList.remove('invalid');
            if (this.files[0].size > 5 * 1024 * 1024) {
                alert('Horoscope file must be under 5 MB.');
                this.value = '';
                sp.textContent = '';
            }
        } else sp.textContent = '';
    });

    document.getElementById('photo').addEventListener('change', function () {
        const prev = document.getElementById('photoPreview');
        const bar = document.getElementById('photoProgress');
        const barIn = document.getElementById('photoProgressBar');
        const file = this.files[0];
        if (!file) {
            prev.classList.remove('visible');
            return;
        }
        if (!/^image\/(jpeg|png)$/i.test(file.type)) {
            alert('JPG or PNG only.');
            this.value = '';
            return;
        }
        const reader = new FileReader();
        bar.classList.add('visible');
        barIn.style.width = '0%';
        let p = 0;
        const t = setInterval(function () {
            p += 12;
            barIn.style.width = Math.min(p, 100) + '%';
            if (p >= 100) clearInterval(t);
        }, 40);
        reader.onload = function (e) {
            prev.src = e.target.result;
            prev.classList.add('visible');
        };
        reader.readAsDataURL(file);
    });

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        if (!validateStep(step)) return;
        btnSubmit.disabled = true;
        btnSubmit.textContent = 'Submitted · Redirecting…';
        const fullName = (document.getElementById('full_name').value || '').trim();
        const email = (document.getElementById('email').value || '').trim();
        const regBody = new URLSearchParams();
        regBody.set('complete', '1');
        regBody.set('full_name', fullName);
        regBody.set('email', email);
        fetch('complete-registration.php', {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: regBody.toString()
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
                btnSubmit.disabled = false;
                btnSubmit.textContent = 'Submit registration';
                alert('Could not complete signup. Please check your connection and try again.');
            });
    });

    document.getElementById('email').addEventListener('blur', floatLabelEmail);
    showStep(0);
})();
</script>

<?php include 'footer.php'; ?>
</body>
</html>
