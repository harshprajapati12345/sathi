<?php
declare(strict_types=1);

function admin_escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function admin_render_status_cell(string $value): string
{
    $text = trim($value);
    $lower = strtolower($text);
    $ok = ['active', 'approved', 'paid', 'yes', 'completed', 'published'];
    $warn = ['pending', 'blocked', 'inactive', 'draft', 'rejected'];

    if (in_array($lower, $ok, true)) {
        return '<span class="admin-badge ok">' . admin_escape($text) . '</span>';
    }
    if (in_array($lower, $warn, true)) {
        return '<span class="admin-badge pending">' . admin_escape($text) . '</span>';
    }
    return admin_escape($text);
}

function admin_render_cell($value): string
{
    if (is_string($value)) {
        if (preg_match('/^(Active|Approved|Paid|Yes|Completed|Published)$/i', $value)) {
            return admin_render_status_cell($value);
        }
        if (preg_match('/^(Pending|Blocked|Inactive|Draft|Rejected)$/i', $value)) {
            return admin_render_status_cell($value);
        }

        if (strpos($value, '|') !== false) {
            $parts = array_map('trim', explode('|', $value));
            $links = [];
            foreach ($parts as $part) {
                $label = admin_escape($part);
                $links[] = '<a href="#" class="admin-link-action">' . $label . '</a>';
            }
            return implode(' | ', $links);
        }
    }

    return admin_escape((string) $value);
}

function admin_render_page_header(array $config): void
{
    $description = isset($config['description']) ? admin_escape((string) $config['description']) : '';
    echo '<div class="admin-glass-card admin-page-hero">';
    echo '<p class="admin-page-intro">' . $description . '</p>';
    echo '</div>';
}

function admin_render_table_page(array $config): void
{
    $columns = $config['columns'] ?? [];
    $rows = $config['rows'] ?? [];

    echo '<div class="admin-glass-card admin-page-section">';
    echo '<div class="admin-table-header">';
    echo '<div><input type="search" class="admin-input-search" placeholder="Search records..." aria-label="Search records"></div>';
    echo '<button type="button" class="admin-btn admin-btn-secondary">Add New</button>';
    echo '</div>';
    echo '<div class="admin-table-wrap">';
    echo '<table class="admin-table"><thead><tr>';
    foreach ($columns as $column) {
        echo '<th>' . admin_escape((string) $column) . '</th>';
    }
    echo '</tr></thead><tbody>';
    foreach ($rows as $row) {
        echo '<tr>';
        foreach ($row as $cell) {
            echo '<td>' . admin_render_cell($cell) . '</td>';
        }
        echo '</tr>';
    }
    if (count($rows) === 0) {
        echo '<tr><td colspan="' . count($columns) . '" class="admin-table-empty">No records available.</td></tr>';
    }
    echo '</tbody></table></div></div>';
}

function admin_render_form_page(array $config): void
{
    $fields = $config['fields'] ?? [];

    echo '<div class="admin-glass-card admin-page-section">';
    echo '<form class="admin-form-grid" method="post" enctype="multipart/form-data">';
    foreach ($fields as $field) {
        $label = $field['label'] ?? '';
        $name = $field['name'] ?? '';
        $type = $field['type'] ?? 'text';
        $placeholder = $field['placeholder'] ?? '';
        $options = $field['options'] ?? [];

        echo '<label class="admin-form-field">';
        echo '<span>' . admin_escape((string) $label) . '</span>';
        if ($type === 'textarea') {
            echo '<textarea name="' . admin_escape($name) . '" placeholder="' . admin_escape($placeholder) . '"></textarea>';
        } elseif ($type === 'select') {
            echo '<select name="' . admin_escape($name) . '">';
            foreach ($options as $option) {
                echo '<option value="' . admin_escape((string) $option) . '">' . admin_escape((string) $option) . '</option>';
            }
            echo '</select>';
        } else {
            echo '<input type="' . admin_escape($type) . '" name="' . admin_escape($name) . '" placeholder="' . admin_escape($placeholder) . '">';
        }
        echo '</label>';
    }
    echo '<div class="admin-form-actions">';
    echo '<button type="submit" class="admin-btn admin-btn-primary">Save Changes</button>';
    echo '</div>';
    echo '</form></div>';
}

function admin_render_master_data_page(array $config): void
{
    $slug = $config['slug'] ?? '';
    $items = sathi_master_storage_get($slug);
    $columns = $config['columns'] ?? [];
    $fields = $config['fields'] ?? [];
    $singular = $config['singular'] ?? 'Record';
    $addLabel = $config['add_label'] ?? 'Add New';

    echo '<div class="admin-glass-card admin-page-section">';
    echo '<div class="admin-table-header">';
    echo '<div><input type="search" class="admin-input-search admin-master-search" placeholder="Search records..." aria-label="Search records"></div>';
    echo '<button type="button" class="admin-btn admin-btn-secondary admin-master-add">' . admin_escape($addLabel) . '</button>';
    echo '</div>';
    echo '<div class="admin-table-wrap">';
    echo '<table class="admin-table"><thead><tr>';
    foreach ($columns as $column) {
        echo '<th>' . admin_escape((string) $column) . '</th>';
    }
    echo '</tr></thead><tbody>';

    if (count($items) === 0) {
        echo '<tr><td colspan="' . count($columns) . '" class="admin-table-empty">No records available.</td></tr>';
    }

    foreach ($items as $item) {
        $id = admin_escape((string) ($item['id'] ?? ''));
        $name = admin_escape((string) ($item['name'] ?? ''));
        $status = admin_escape((string) ($item['status'] ?? 'Inactive'));

        echo '<tr>';
        foreach ($columns as $column) {
            $key = strtolower(trim((string) $column));
            if ($key === 'id') {
                echo '<td>' . $id . '</td>';
            } elseif ($key === 'name') {
                echo '<td>' . $name . '</td>';
            } elseif ($key === 'status') {
                echo '<td>' . admin_render_status_cell($status) . '</td>';
            } elseif ($key === 'action') {
                echo '<td><button type="button" class="admin-btn admin-btn-secondary admin-master-edit" data-id="' . $id . '" data-name="' . $name . '" data-status="' . $status . '">Edit</button> <button type="button" class="admin-btn admin-btn-danger admin-master-delete" data-id="' . $id . '">Delete</button></td>';
            } else {
                echo '<td>' . admin_escape((string) ($item[$key] ?? '')) . '</td>';
            }
        }
        echo '</tr>';
    }

    echo '</tbody></table></div></div>';

    echo '<div class="admin-glass-card admin-page-section admin-master-form-panel" style="display:none;">';
    echo '<form class="admin-form-grid" id="adminMasterForm">';
    echo '<input type="hidden" name="id" value="">';
    foreach ($fields as $field) {
        $label = $field['label'] ?? '';
        $name = $field['name'] ?? '';
        $type = $field['type'] ?? 'text';
        $placeholder = $field['placeholder'] ?? '';
        $options = $field['options'] ?? [];

        echo '<label class="admin-form-field">';
        echo '<span>' . admin_escape((string) $label) . '</span>';
        if ($type === 'textarea') {
            echo '<textarea name="' . admin_escape($name) . '" placeholder="' . admin_escape($placeholder) . '"></textarea>';
        } elseif ($type === 'select') {
            echo '<select name="' . admin_escape($name) . '">';
            foreach ($options as $option) {
                echo '<option value="' . admin_escape((string) $option) . '">' . admin_escape((string) $option) . '</option>';
            }
            echo '</select>';
        } else {
            echo '<input type="' . admin_escape($type) . '" name="' . admin_escape($name) . '" placeholder="' . admin_escape($placeholder) . '">';
        }
        echo '</label>';
    }
    echo '<div class="admin-form-actions">';
    echo '<button type="submit" class="admin-btn admin-btn-primary">Save ' . admin_escape($singular) . '</button>';
    echo '<button type="button" class="admin-btn admin-btn-secondary admin-master-cancel">Cancel</button>';
    echo '</div>';
    echo '</form></div>';

    $script = <<<'SCRIPT'
<script>(function(){
    var slug = %s;
    var formPanel = document.querySelector(".admin-master-form-panel");
    var form = document.getElementById("adminMasterForm");
    var addButton = document.querySelector(".admin-master-add");
    var cancelButton = document.querySelector(".admin-master-cancel");
    var searchInput = document.querySelector(".admin-master-search");
    var mode = "add";

    function openForm(editItem) {
        mode = editItem ? "edit" : "add";
        form.reset();
        form.querySelector('[name="id"]').value = editItem ? editItem.id : "";
        var nameInput = form.querySelector('[name="name"]');
        var statusInput = form.querySelector('[name="status"]');
        if (nameInput) {
            nameInput.value = editItem ? editItem.name : "";
        }
        if (statusInput) {
            statusInput.value = editItem ? editItem.status : "Active";
        }
        formPanel.style.display = "block";
        if (nameInput) {
            nameInput.focus();
        }
    }

    function closeForm() {
        formPanel.style.display = "none";
        form.reset();
    }

    function postData(payload) {
        return fetch("master-action.php", {
            method: "POST",
            credentials: "same-origin",
            headers: {"Content-Type": "application/x-www-form-urlencoded"},
            body: new URLSearchParams(payload).toString()
        }).then(function(response) { return response.json(); });
    }

    addButton.addEventListener("click", function() {
        openForm(null);
    });

    cancelButton.addEventListener("click", function() {
        closeForm();
    });

    form.addEventListener("submit", function(event) {
        event.preventDefault();
        var formData = new FormData(form);
        var payload = {slug: slug, action: mode === "edit" ? "edit" : "add"};
        formData.forEach(function(value, key) {
            payload[key] = value;
        });
        postData(payload).then(function(data) {
            if (data && data.ok) {
                window.location.reload();
                return;
            }
            alert("Could not save record. Please try again.");
        }).catch(function() {
            alert("Could not save record. Please try again.");
        });
    });

    document.querySelectorAll(".admin-master-edit").forEach(function(button) {
        button.addEventListener("click", function() {
            var item = {
                id: this.dataset.id || "",
                name: this.dataset.name || "",
                status: this.dataset.status || "Active"
            };
            openForm(item);
        });
    });

    document.querySelectorAll(".admin-master-delete").forEach(function(button) {
        button.addEventListener("click", function() {
            var id = this.dataset.id;
            if (!id || !confirm("Are you sure you want to delete this record?")) {
                return;
            }
            postData({slug: slug, action: "delete", id: id}).then(function(data) {
                if (data && data.ok) {
                    window.location.reload();
                    return;
                }
                alert("Could not delete record.");
            }).catch(function() {
                alert("Could not delete record.");
            });
        });
    });

    if (searchInput) {
        searchInput.addEventListener("input", function() {
            var query = this.value.toLowerCase();
            document.querySelectorAll('.admin-table tbody tr').forEach(function(row) {
                var text = row.textContent.toLowerCase();
                row.style.display = text.indexOf(query) === -1 ? 'none' : '';
            });
        });
    }
})();</script>
SCRIPT;

    echo sprintf($script, json_encode($slug));
}

function admin_render_settings_page(array $config): void
{
    admin_render_form_page($config);
}

function admin_render_approval_page(array $config): void
{
    $columns = $config['columns'] ?? [];
    $rows = $config['rows'] ?? [];

    echo '<div class="admin-glass-card admin-page-section">';
    echo '<div class="admin-table-wrap">';
    echo '<table class="admin-table"><thead><tr>';
    foreach ($columns as $column) {
        echo '<th>' . admin_escape((string) $column) . '</th>';
    }
    echo '</tr></thead><tbody>';
    foreach ($rows as $row) {
        echo '<tr>';
        foreach ($row as $cell) {
            echo '<td>' . admin_render_cell($cell) . '</td>';
        }
        echo '</tr>';
    }
    if (count($rows) === 0) {
        echo '<tr><td colspan="' . count($columns) . '" class="admin-table-empty">No approval requests at the moment.</td></tr>';
    }
    echo '</tbody></table></div></div>';
}

function admin_render_members_approval_page(array $config): void
{
    $columns = $config['columns'] ?? [];
    $users = sathi_user_storage_load();

    echo '<div class="admin-glass-card admin-page-section">';
    echo '<div class="admin-table-wrap">';
    echo '<table class="admin-table"><thead><tr>';
    foreach ($columns as $column) {
        echo '<th>' . admin_escape((string) $column) . '</th>';
    }
    echo '</tr></thead><tbody>';

    if (count($users) === 0) {
        echo '<tr><td colspan="' . count($columns) . '" class="admin-table-empty">No members found.</td></tr>';
    }

    foreach ($users as $user) {
        $email = admin_escape((string) ($user['email'] ?? ''));
        $name = admin_escape((string) ($user['name'] ?? ''));
        $status = admin_escape((string) ($user['status'] ?? 'pending'));
        $registeredAt = admin_escape((string) ($user['registered_at'] ?? '—'));
        $statusCell = admin_render_status_cell($status);

        $actionButtons = '';
        if (strtolower($status) === 'pending') {
            $actionButtons = '<button type="button" class="admin-btn admin-btn-primary admin-approval-action" data-email="' . $email . '" data-action="approve">Approve</button> <button type="button" class="admin-btn admin-btn-secondary admin-approval-action" data-email="' . $email . '" data-action="reject">Reject</button>';
        } else {
            $actionButtons = '<span>' . admin_escape(ucfirst($status)) . '</span>';
        }

        echo '<tr>';
        echo '<td>' . $email . '</td>';
        echo '<td>' . $name . '</td>';
        echo '<td>' . $statusCell . '</td>';
        echo '<td>' . $registeredAt . '</td>';
        echo '<td>' . $actionButtons . '</td>';
        echo '</tr>';
    }

    echo '</tbody></table></div></div>';
    echo '<script>(function(){
        var buttons = document.querySelectorAll(".admin-approval-action");
        buttons.forEach(function(button){
            button.addEventListener("click", function(){
                var email = this.dataset.email;
                var action = this.dataset.action;
                if (!email || !action) return;
                this.disabled = true;
                fetch("approve-user.php", {
                    method: "POST",
                    credentials: "same-origin",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"},
                    body: new URLSearchParams({email: email, action: action}).toString()
                }).then(function(r){ return r.json(); }).then(function(data){
                    if (data && data.ok) {
                        window.location.reload();
                        return;
                    }
                    alert("Could not update user status.");
                    button.disabled = false;
                }).catch(function(){
                    alert("Could not update user status.");
                    button.disabled = false;
                });
            });
        });
    })();</script>';
}

function admin_render_action_page(array $config): void
{
    $buttons = $config['buttons'] ?? [];

    echo '<div class="admin-glass-card admin-page-section admin-action-page">';
    echo '<div class="admin-action-panel">';
    foreach ($buttons as $button) {
        $label = $button['label'] ?? 'Execute';
        $type = $button['type'] ?? 'primary';
        $class = $type === 'secondary' ? 'admin-btn-secondary' : 'admin-btn-primary';
        echo '<button type="button" class="admin-btn ' . $class . '">' . admin_escape((string) $label) . '</button>';
    }
    echo '</div></div>';
}

function admin_render_unknown_page(): void
{
    echo '<section class="admin-page-placeholder"><div class="admin-glass-card admin-page-hero">';
    echo '<h2>Page not configured</h2>';
    echo '<p class="lead">This admin page has not yet been wired to the reusable page renderer. Add it to <code>admin/includes/page-config.php</code>.</p>';
    echo '</div></section>';
}
