# Shadikibaat — User & Admin flow documentation

This document describes how public pages and admin pages connect in the current PHP implementation. It lists the key frontend file relationships, session behavior, registration/login flow, and admin panel features.

---

## Architecture overview

| Layer | Role |
|-------|------|
| **`session_init.php`** | Starts the PHP session and, if `sathi_user_email` exists, reloads the user record from `admin/includes/user-storage.php` to refresh approval status and display name in `$_SESSION`. |
| **`header.php`** | Includes `session_init.php`, renders the global navbar and mobile menu, and controls auth link states for every public page. |
| **`footer.php`** | Renders the site footer shared by public pages. |
| **`style.css`** | Global styling for landing and inner pages. |
| **`register-wizard.css`** | Styling for the registration wizard and login UI. |
| **`includes/registration-config.php`** | Master registration dropdown values and per-field visibility/required settings. |

---

## User session variables

These are managed by **`complete-registration.php`** and **`login-session.php`**, and refreshed by **`session_init.php`**:

| Session key | Meaning |
|-------------|---------|
| `sathi_registration_complete` | Marks the session as an authenticated/registered user. |
| `sathi_user_email` | Email key used to fetch the current user from storage. |
| `sathi_user_name` | Display name shown in the navbar. |
| `sathi_registration_status` | User approval state: `pending`, `approved`, or `rejected`. |

Navbar labels in `header.php` map these statuses to readable text.

---

## Public page map and connections

| File | Purpose | Connected files / notes |
|------|---------|-----------------------|
| `index.php` | Gated homepage. Shows a full homepage only for approved users; otherwise displays pending/rejected messaging. | Includes `header.php`, `footer.php`. |
| `about.php` | About page content. | Includes `header.php`, `footer.php`. |
| `membership.php` | Membership plans page. | Includes `header.php`, `footer.php`. |
| `success-stories.php` | Static success stories page. | Includes `header.php`, `footer.php`. |
| `blog.php` | Blog topics page. | Includes `header.php`, `footer.php`. |
| `contact.php` | Contact page with form. | Includes `header.php`, `footer.php`. |
| `register.php` | Multi-step registration wizard. | Uses `register-wizard.css`, `includes/registration-config.php`, posts to `complete-registration.php`. |
| `login.php` | Login form UI. | Uses `register-wizard.css`, posts to `login-session.php`. |
| `complete-registration.php` | Saves registration data and creates session state. | Updates storage through `admin/includes/user-storage.php`, then redirects to `index.php`. |
| `login-session.php` | Creates or loads session from email login. | Updates storage through `admin/includes/user-storage.php`, then redirects to `index.php`. |
| `session_init.php` | Refreshes user session state on page load. | Called by `header.php`; reads from `admin/includes/user-storage.php`. |
| `header.php` | Global site header and auth logic. | Requires `session_init.php`. |
| `footer.php` | Global footer content. | Used by all public pages. |
| `includes/registration-config.php` | Registration master data and field settings. | Used by `register.php` and related admin master pages. |

---

## Home access flow

1. If `sathi_registration_complete` is absent, `index.php` redirects to `register.php`.
2. If `sathi_registration_status` is `pending` or `rejected`, `index.php` shows approval status messaging instead of the full homepage.
3. If `sathi_registration_status` is `approved`, `index.php` renders the full landing/home content.

This means the public marketing pages are accessible, but `index.php` is gated behind registration and approval.

---

## Registration flow

1. User opens `register.php`.
2. The wizard uses `includes/registration-config.php` for dropdown options and field display logic.
3. Submission sends data to `complete-registration.php`.
4. `complete-registration.php` writes or updates the user record with `status: pending`, sets session variables, and redirects to `index.php`.
5. The user then sees pending approval messaging until an admin changes their status to `approved`.

> Note: The current backend persists only core info such as email, display name, and status. Additional registration details appear in the UI but are not necessarily stored in the current implementation.

---

## Login flow

1. User opens `login.php`.
2. The form sends only the `email` field to `login-session.php`.
3. If the email is new, `login-session.php` creates a user record with `pending` status. If the email exists, it loads the user and status.
4. Session values are set and the user is redirected to `index.php`.

> Important: The password field in `login.php` is currently not validated. This is a placeholder login flow.

---

## How files connect

- `header.php` calls `session_init.php` and determines whether to show auth links or the logged-in user state.
- `register.php` and `login.php` depend on `register-wizard.css` for styling.
- `complete-registration.php` and `login-session.php` both use `admin/includes/user-storage.php` to persist or read user records.
- `session_init.php` refreshes session data from storage after admin changes.
- `includes/registration-config.php` is the shared source for registration options and master data labels.

---

## Admin panel overview

The admin panel is located under `admin/` and uses sidebar navigation configured in `admin/includes/nav-config.php`.

### Admin primary sections

#### Dashboard
- `admin/dashboard.php` — Admin home page.

#### Members management
- `admin/members.php` — All members.
- `admin/member-approvals.php` — Pending member approvals.
- `admin/approved-members.php` — Approved profiles.
- `admin/rejected-members.php` — Rejected profiles.
- `admin/paid-members.php` — Paid members.
- `admin/featured-members.php` — Featured member management.
- `admin/profile-deactivation.php` — Deactivation requests.

#### Membership plan management
- `admin/add-membership-plan.php` — Add plan.
- `admin/membership-plans.php` — List plans.

#### Profile master data management
These pages manage the values used in registration dropdowns and profile fields:
- `admin/master-religion.php`
- `admin/master-gotra.php`
- `admin/master-occupation.php`
- `admin/master-education.php`
- `admin/master-income.php`
- `admin/master-country.php`
- `admin/master-state.php`
- `admin/master-city.php`
- `admin/master-mother-tongue.php`
- `admin/master-marital-status.php`
- `admin/master-star.php`
- `admin/master-rasi.php`
- `admin/master-dosh.php`

These master pages are conceptually linked with `includes/registration-config.php`, which defines the same registration master lists.

#### Registration form controls
- `admin/form-field-settings.php` — Controls visibility and required status of registration fields.

#### Payment management
- `admin/payments.php` — Payment history.
- `admin/manual-payments.php` — Manual payments.
- `admin/payment-methods.php` — Payment methods.

#### CMS and content management
- `admin/cms.php` — CMS overview.
- `admin/blogs.php` — Manage blogs.
- `admin/success-stories.php` — Manage success stories.
- `admin/homepage-banner.php` — Manage homepage banner.

#### Reports and settings
- `admin/reports.php` — Reports page.
- `admin/settings.php` — Site settings.

---

## Admin-public connection summary

- Admin pages manage user approval state that affects what `index.php` displays.
- Admin master data pages drive registration dropdowns and profile metadata.
- `admin/form-field-settings.php` controls which registration fields are visible or required.
- The public UI depends on admin-managed data for registration and content display.

---

## Quick reference

| Role | Files |
|------|-------|
| Auth/session | `session_init.php`, `header.php`, `login.php`, `login-session.php`, `complete-registration.php` |
| Public pages | `index.php`, `about.php`, `membership.php`, `success-stories.php`, `blog.php`, `contact.php` |
| Registration config | `includes/registration-config.php`, `register.php`, `register-wizard.css` |
| Admin dashboard | `admin/dashboard.php`, `admin/includes/nav-config.php` |
| Member admin | `admin/members.php`, `admin/member-approvals.php`, `admin/approved-members.php`, `admin/rejected-members.php`, `admin/paid-members.php`, `admin/featured-members.php`, `admin/profile-deactivation.php` |
| Admin master data | `admin/master-*.php` pages |
| Admin CMS | `admin/cms.php`, `admin/blogs.php`, `admin/success-stories.php`, `admin/homepage-banner.php` |
| Admin payments | `admin/payments.php`, `admin/manual-payments.php`, `admin/payment-methods.php` |
| Admin reports/settings | `admin/reports.php`, `admin/settings.php` |

---

## Notes

- The current flow is designed around registration plus admin approval.
- `login-session.php` does not validate passwords; treat the existing login screen as a demo flow.
- User broader profile data is collected in the registration UI, but full persistence depends on storage implementation beyond the core signup flow.
