<!-- ═══ FOOTER ═══ -->
<footer class="footer" id="contact">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <span class="logo-text">SHADIKI<span>BAAT</span></span>
        <p class="footer-desc">India's most trusted matrimonial platform. Find your perfect partner with verified
          profiles and AI-powered suggestions.</p>
        <div class="social-icons">
          <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
          <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
          <a href="#" aria-label="X"><i class="fa-brands fa-x-twitter"></i></a>
          <a href="#" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
          <a href="#" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
        </div>
      </div>
      <div class="footer-col">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="about.php">About Us</a></li>
          <li><a href="membership.php">Membership</a></li>
          <li><a href="success-stories.php">Success Stories</a></li>
          <li><a href="blog.php">Blog</a></li>
          <li><a href="contact.php">Partner with Us</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Help &amp; Support</h4>
        <ul>
          <li><a href="contact.php">Contact Us</a></li>
          <li><a href="#">FAQ</a></li>
          <li><a href="success-stories.php">Success Stories</a></li>
          <li><a href="#">Privacy Policy</a></li>
          <li><a href="#">Safety Tips</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Get in Touch</h4>
        <div class="footer-contact">
          <span>✉ support@shadikibaat.com</span>
          <span>📞 +91 98765 43210</span>
          <span>📍 Ahmedabad, Gujarat, India</span>
        </div>
        <div class="footer-store">
          <a href="#" class="footer-store-badge">🍎 App Store</a>
          <a href="#" class="footer-store-badge">▶️ Google Play</a>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© 2024 Shadikibaat.com • All rights reserved • Made with ❤ in India</p>
      <div class="footer-bottom-links">
        <a href="#">Sitemap</a>
        <a href="#">Accessibility</a>
        <a href="#">Cookie Policy</a>
      </div>
    </div>
  </div>
  </div>
</footer>

<!-- Global Action Modal -->
<div class="sathi-modal-overlay" id="actionModal" aria-hidden="true">
  <div class="sathi-modal">
    <button class="sathi-modal-close" aria-label="Close modal" onclick="closeActionModal()"><i
        class="fas fa-times"></i></button>
    <div id="modalContentDynamic">
      <!-- Dynamic Content Will Be Injected Here -->
    </div>
  </div>
</div>

<script>
  function openActionModal(actionType, dataEncoded) {
    const modal = document.getElementById('actionModal');
    const content = document.getElementById('modalContentDynamic');

    const data = JSON.parse(decodeURIComponent(dataEncoded));

    if (actionType === 'view') {
      content.innerHTML = `
        <div style="text-align:center; margin-bottom:25px; position:relative;">
          <img src="${data.img}" alt="${data.name}" style="width:140px; height:140px; border-radius:20px; object-fit:cover; margin-bottom:15px; border:5px solid #fff; box-shadow: 0 15px 35px rgba(244, 92, 147, 0.2);">
          <div style="position:absolute; top:110px; left:50%; transform:translateX(-50%); background:var(--match-pink); color:#fff; padding:4px 15px; border-radius:20px; font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:1px; box-shadow:0 4px 10px rgba(0,0,0,0.1);">${data.membership} Member</div>
          <h3 style="font-size:1.8rem; color:#222; margin-top:10px; margin-bottom:5px; font-weight:800;">${data.name} <i class="fas fa-check-circle" style="color:#2ecc71; font-size:1.1rem;"></i></h3>
          <p style="color:#666; font-size:1.1rem; font-weight:500;">${data.age_val} · ${data.marital_status}</p>
        </div>

        <div class="modal-detail-scroll" style="max-height:60vh; overflow-y:auto; padding:0 15px 20px; text-align:left;">
          
          <!-- Quick Facts -->
          <div style="background:#fff; border-radius:18px; padding:20px; margin-bottom:20px; border:1px solid #f0f0f0; box-shadow:0 5px 15px rgba(0,0,0,0.02);">
            <div style="display:grid; grid-template-columns: repeat(2, 1fr); gap:15px;">
              <div><small style="display:block; color:#aaa; text-transform:uppercase; font-size:0.7rem; font-weight:700; margin-bottom:3px;">Gender</small><span style="color:#333; font-weight:600;">${data.gender}</span></div>
              <div><small style="display:block; color:#aaa; text-transform:uppercase; font-size:0.7rem; font-weight:700; margin-bottom:3px;">Joined</small><span style="color:#333; font-weight:600;">${data.joined}</span></div>
              <div><small style="display:block; color:#aaa; text-transform:uppercase; font-size:0.7rem; font-weight:700; margin-bottom:3px;">Mobile</small><span style="color:#333; font-weight:600;">${data.mobile}</span></div>
              <div><small style="display:block; color:#aaa; text-transform:uppercase; font-size:0.7rem; font-weight:700; margin-bottom:3px;">WhatsApp</small><span style="color:#333; font-weight:600;">${data.whatsapp}</span></div>
            </div>
          </div>

          <!-- Religious & Personal -->
          <h4 style="font-size:1rem; color:#222; font-weight:800; margin:25px 0 15px; display:flex; align-items:center;"><i class="fas fa-pray" style="color:var(--match-pink); margin-right:10px;"></i> Religious & Personal</h4>
          <div style="background:#fff; border-radius:18px; padding:20px; border:1px solid #f0f0f0; box-shadow:0 5px 15px rgba(0,0,0,0.02);">
            <table style="width:100%; border-collapse:collapse;">
              <tr style="border-bottom:1px solid #f9f9f9;"><td style="padding:10px 0; color:#888; width:45%;">Digamber Jain</td><td style="padding:10px 0; color:#333; font-weight:600; text-align:right;">${data.digamber}</td></tr>
              <tr style="border-bottom:1px solid #f9f9f9;"><td style="padding:10px 0; color:#888;">Religion</td><td style="padding:10px 0; color:#333; font-weight:600; text-align:right;">${data.religion}</td></tr>
              <tr style="border-bottom:1px solid #f9f9f9;"><td style="padding:10px 0; color:#888;">Mother Tongue</td><td style="padding:10px 0; color:#333; font-weight:600; text-align:right;">${data.mother_tongue}</td></tr>
              <tr style="border-bottom:1px solid #f9f9f9;"><td style="padding:10px 0; color:#888;">Marital Status</td><td style="padding:10px 0; color:#333; font-weight:600; text-align:right;">${data.marital_status}</td></tr>
              <tr style="border-bottom:1px solid #f9f9f9;"><td style="padding:10px 0; color:#888;">Which Temple</td><td style="padding:10px 0; color:#333; font-weight:600; text-align:right;">${data.which_temple}</td></tr>
              <tr><td style="padding:10px 0; color:#888;">Gotra</td><td style="padding:10px 0; color:var(--match-pink); font-weight:700; text-align:right;">${data.gotra}</td></tr>
            </table>
          </div>

          <!-- Birth & Horoscope -->
          <h4 style="font-size:1rem; color:#222; font-weight:800; margin:25px 0 15px; display:flex; align-items:center;"><i class="fas fa-star" style="color:#3498db; margin-right:10px;"></i> Birth & Horoscope</h4>
          <div style="background:#fff; border-radius:18px; padding:20px; border:1px solid #f0f0f0; box-shadow:0 5px 15px rgba(0,0,0,0.02);">
            <div style="display:grid; grid-template-columns: repeat(2, 1fr); gap:15px;">
              <div style="grid-column: 1/-1;"><small style="display:block; color:#aaa; font-size:0.7rem; font-weight:700;">Birth Date</small><span style="color:#333; font-weight:600;">${data.dob}</span></div>
              <div><small style="display:block; color:#aaa; font-size:0.7rem; font-weight:700;">Birth Time</small><span style="color:#333; font-weight:600;">${data.birth_time}</span></div>
              <div><small style="display:block; color:#aaa; font-size:0.7rem; font-weight:700;">Birth Place</small><span style="color:#333; font-weight:600;">${data.birth_place}</span></div>
              <div><small style="display:block; color:#aaa; font-size:0.7rem; font-weight:700;">Star</small><span style="color:#333; font-weight:600;">${data.star}</span></div>
              <div><small style="display:block; color:#aaa; font-size:0.7rem; font-weight:700;">Rasi</small><span style="color:#333; font-weight:600;">${data.rasi}</span></div>
              <div style="grid-column: 1/-1;"><small style="display:block; color:#aaa; font-size:0.7rem; font-weight:700;">Dosh</small><span style="color:#333; font-weight:600;">${data.dosh}</span></div>
            </div>
          </div>

          <!-- Location Details -->
          <h4 style="font-size:1rem; color:#222; font-weight:800; margin:25px 0 15px; display:flex; align-items:center;"><i class="fas fa-map-marker-alt" style="color:#e74c3c; margin-right:10px;"></i> Location Details</h4>
          <div style="background:#fff; border-radius:18px; padding:20px; border:1px solid #f0f0f0; box-shadow:0 5px 15px rgba(0,0,0,0.02);">
            <div style="margin-bottom:15px;">
              <small style="display:block; color:#aaa; font-size:0.7rem; font-weight:700; margin-bottom:5px;">Birth Location</small>
              <span style="color:#333; font-weight:600;">${data.loc}</span>
            </div>
            <div>
              <small style="display:block; color:#aaa; font-size:0.7rem; font-weight:700; margin-bottom:5px;">Native Location</small>
              <span style="color:#333; font-weight:600;">${data.native_place}</span>
            </div>
          </div>

          <!-- Family Details -->
          <h4 style="font-size:1rem; color:#222; font-weight:800; margin:25px 0 15px; display:flex; align-items:center;"><i class="fas fa-users" style="color:#f39c12; margin-right:10px;"></i> Family Details</h4>
          <div style="background:#fff; border-radius:18px; padding:20px; border:1px solid #f0f0f0; box-shadow:0 5px 15px rgba(0,0,0,0.02);">
            <table style="width:100%; border-collapse:collapse;">
              <tr style="border-bottom:1px solid #f9f9f9;"><td style="padding:10px 0; color:#888;">Father's Name</td><td style="padding:10px 0; color:#333; font-weight:600; text-align:right;">${data.father_name}</td></tr>
              <tr style="border-bottom:1px solid #f9f9f9;"><td style="padding:10px 0; color:#888;">Father Mobile</td><td style="padding:10px 0; color:#333; font-weight:600; text-align:right;">${data.father_mobile}</td></tr>
              <tr style="border-bottom:1px solid #f9f9f9;"><td style="padding:10px 0; color:#888;">Father Income</td><td style="padding:10px 0; color:#333; font-weight:600; text-align:right;">${data.father_income}</td></tr>
              <tr style="border-bottom:1px solid #f9f9f9;"><td style="padding:10px 0; color:#888;">Mother's Name</td><td style="padding:10px 0; color:#333; font-weight:600; text-align:right;">${data.mother_name}</td></tr>
              <tr style="border-bottom:1px solid #f9f9f9;"><td style="padding:10px 0; color:#888;">Brothers</td><td style="padding:10px 0; color:#333; font-weight:600; text-align:right;">${data.bro_total} (Married: ${data.bro_married})</td></tr>
              <tr><td style="padding:10px 0; color:#888;">Sisters</td><td style="padding:10px 0; color:#333; font-weight:600; text-align:right;">${data.sis_total} (Married: ${data.sis_married})</td></tr>
            </table>
          </div>

          <!-- Additional Info -->
          <h4 style="font-size:1rem; color:#222; font-weight:800; margin:25px 0 15px; display:flex; align-items:center;"><i class="fas fa-info-circle" style="color:#9b59b6; margin-right:10px;"></i> Additional Information</h4>
          <div style="background:#f9f9f9; border-radius:18px; padding:20px; font-size:0.95rem; line-height:1.6; color:#555;">
             <div style="margin-bottom:15px;"><strong>About:</strong><br>${data.about_text}</div>
             <div><strong>Relatives:</strong><br>${data.relatives}</div>
          </div>

        </div>

        <div style="padding:20px; border-top:1px solid #f0f0f0; display:flex; gap:10px;">
          <button class="btn-action btn-interest-solid" style="flex:2; padding:15px; font-size:1.1rem; border-radius:12px;" onclick="closeActionModal(); openActionModal('interest', '${encodeURIComponent(JSON.stringify(data))}')">Send Interest</button>
          <button class="btn-action btn-view-outline" style="flex:1; padding:15px; font-size:1rem; border-radius:12px; border:1px solid #ddd; color:#666;" onclick="closeActionModal()">Close</button>
        </div>
      `;
    } else if (actionType === 'interest') {
      content.innerHTML = `
        <div style="color:#f45c93; background:#ffe4ee; width:70px; height:70px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:1.8rem; margin:0 auto 20px;">
          <i class="fas fa-heart"></i>
        </div>
        <h3 style="font-size:1.5rem; color:#222; margin-bottom:12px; font-weight:700;">Express Interest</h3>
        <p style="color:#666; font-size:1rem; line-height:1.5; margin-bottom:25px;">
          You are about to send an interest to <strong>${data.name}</strong>. We will notify them right away!
        </p>
        <button class="btn-action btn-interest-solid" style="width:100%; padding: 12px; font-size:1rem;" onclick="closeActionModal()">Send Interest Now</button>
      `;
    }

    modal.classList.add('active');
  }

  function closeActionModal() {
    const modal = document.getElementById('actionModal');
    modal.classList.remove('active');
  }
</script>

<!-- Generic Form Autosave -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Apply to forms except the registration wizard which has its own localStorage logic
    const forms = document.querySelectorAll('form:not(#regWizard):not([data-no-autosave])');
    forms.forEach(form => {
        const formId = form.id || form.name || window.location.pathname.replace(/[^a-z0-9]/gi, '_');
        if (!formId) return;
        const storageKey = 'sathi_autosave_' + formId;

        // Load data
        try {
            const raw = sessionStorage.getItem(storageKey);
            if (raw) {
                const data = JSON.parse(raw);
                Object.entries(data).forEach(([key, values]) => {
                    const el = form.elements[key];
                    if (!el) return;

                    if (el instanceof RadioNodeList || (el.length && !el.tagName)) {
                        const valArray = Array.isArray(values) ? values : [values];
                        Array.from(el).forEach(input => {
                            if (input.type === 'checkbox' || input.type === 'radio') {
                                input.checked = valArray.includes(input.value);
                            }
                        });
                    } else {
                        if (el.type === 'checkbox' || el.type === 'radio') {
                            el.checked = (el.value === values || (typeof values === 'boolean' && String(values) === 'true'));
                        } else if (el.type !== 'file' && el.type !== 'password' && el.type !== 'hidden') {
                            el.value = values;
                        }
                    }
                    
                    // Dispatch change event to trigger any dependent logic
                    el.dispatchEvent(new Event('change', { bubbles: true }));
                });
            }
        } catch (e) {
            console.error('Form autosave load error:', e);
        }

        // Save data on change
        let timeout;
        const save = () => {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                const fd = new FormData(form);
                const data = {};
                for (let [key, val] of fd.entries()) {
                    if (key.includes('password') || val instanceof File || key === 'csrf_token') continue;
                    if (data[key] !== undefined) {
                        if (!Array.isArray(data[key])) data[key] = [data[key]];
                        data[key].push(val);
                    } else {
                        data[key] = val;
                    }
                }
                sessionStorage.setItem(storageKey, JSON.stringify(data));
            }, 300);
        };

        form.addEventListener('input', save);
        form.addEventListener('change', save);
    });
});
</script>

<!-- Global Password Eye Toggle -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('input[type="password"]').forEach(input => {
        input.classList.add('no-caps');
        const parent = input.parentElement;
        if (window.getComputedStyle(parent).position === 'static') {
            parent.style.position = 'relative';
        }
        
        input.style.paddingRight = '45px';
        
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.innerHTML = '<i class="fas fa-eye-slash"></i>';
        btn.style.cssText = 'position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #999; cursor: pointer; padding: 5px; z-index: 10; outline: none; font-size: 16px; display: flex; align-items: center; justify-content: center;';
        
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            if (input.type === 'password') {
                input.type = 'text';
                btn.innerHTML = '<i class="fas fa-eye"></i>';
                btn.style.color = '#e94e77';
            } else {
                input.type = 'password';
                btn.innerHTML = '<i class="fas fa-eye-slash"></i>';
                btn.style.color = '#999';
            }
        });
        
        parent.appendChild(btn);
    });
});
</script>