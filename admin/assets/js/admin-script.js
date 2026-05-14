/**
 * Shadikibaat admin — UI helpers + master CRUD + member approval (fetch).
 */
(function () {
  'use strict';

  document.querySelectorAll('.admin-switch input[type="checkbox"]').forEach(function (input) {
    input.addEventListener('change', function () {
      var row = input.closest('.admin-toggle-row, .admin-pay-card');
      if (row) row.classList.toggle('is-enabled', input.checked);
    });
  });

  document.querySelectorAll('[data-static-alert]').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      var msg = btn.getAttribute('data-static-alert') || 'UI preview only — no data saved.';
      if (window.console && console.info) console.info('[admin static]', msg);
    });
  });

  function postForm(url, data) {
    return fetch(url, {
      method: 'POST',
      credentials: 'same-origin',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams(data).toString()
    }).then(function (r) { return r.json(); });
  }

  document.querySelectorAll('.admin-master-add').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var slug = btn.getAttribute('data-master-slug');
      if (!slug) return;
      var name = window.prompt('Name');
      if (!name || !name.trim()) return;
      postForm('master-action.php', { slug: slug, action: 'add', id: '', name: name.trim(), status: 'Active' })
        .then(function (d) {
          if (!d || !d.ok) throw new Error('fail');
          window.location.reload();
        })
        .catch(function () { alert('Could not save.'); });
    });
  });

  document.querySelectorAll('.admin-master-edit').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var slug = btn.getAttribute('data-master-slug');
      var id = btn.getAttribute('data-id');
      if (!slug || !id) return;
      var name = window.prompt('Name', btn.getAttribute('data-name') || '');
      if (!name || !name.trim()) return;
      var status = window.prompt('Status (Active or Inactive)', btn.getAttribute('data-status') || 'Active');
      if (status === null) return;
      postForm('master-action.php', { slug: slug, action: 'edit', id: id, name: name.trim(), status: status.trim() || 'Active' })
        .then(function (d) {
          if (!d || !d.ok) throw new Error('fail');
          window.location.reload();
        })
        .catch(function () { alert('Could not save.'); });
    });
  });

  document.querySelectorAll('.admin-master-delete').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var slug = btn.getAttribute('data-master-slug');
      var id = btn.getAttribute('data-id');
      if (!slug || !id) return;
      if (!window.confirm('Deactivate this row?')) return;
      postForm('master-action.php', { slug: slug, action: 'delete', id: id, name: '-' })
        .then(function (d) {
          if (!d || !d.ok) throw new Error('fail');
          window.location.reload();
        })
        .catch(function () { alert('Could not delete.'); });
    });
  });

  document.querySelectorAll('.admin-approve-user').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var id = btn.getAttribute('data-user-id');
      if (!id) return;
      postForm('approve-user.php', { user_id: id, action: 'approve' })
        .then(function (d) {
          if (!d || !d.ok) throw new Error('fail');
          window.location.reload();
        })
        .catch(function () { alert('Could not approve.'); });
    });
  });

  document.querySelectorAll('.admin-reject-user').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var id = btn.getAttribute('data-user-id');
      if (!id) return;
      var reason = window.prompt('Rejection reason (optional)') || '';
      postForm('approve-user.php', { user_id: id, action: 'reject', rejection_reason: reason })
        .then(function (d) {
          if (!d || !d.ok) throw new Error('fail');
          window.location.reload();
        })
        .catch(function () { alert('Could not reject.'); });
    });
  });
})();
