<?php
declare(strict_types=1);

function sathi_user_storage_path(): string
{
    return dirname(__DIR__, 2) . '/data/users.json';
}

function sathi_user_storage_load(): array
{
    $path = sathi_user_storage_path();
    if (!is_file($path)) {
        return [];
    }

    $content = file_get_contents($path);
    if ($content === false) {
        return [];
    }

    $data = json_decode($content, true);
    return is_array($data) ? $data : [];
}

function sathi_user_storage_save(array $users): bool
{
    $path = sathi_user_storage_path();
    $json = json_encode(array_values($users), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    if ($json === false) {
        return false;
    }

    return file_put_contents($path, $json) !== false;
}

function sathi_user_storage_find(string $email): ?array
{
    $email = strtolower(trim($email));
    if ($email === '') {
        return null;
    }

    foreach (sathi_user_storage_load() as $user) {
        if (isset($user['email']) && strtolower($user['email']) === $email) {
            return $user;
        }
    }

    return null;
}

function sathi_user_storage_find_index(string $email): ?int
{
    $email = strtolower(trim($email));
    if ($email === '') {
        return null;
    }

    $users = sathi_user_storage_load();
    foreach ($users as $index => $user) {
        if (isset($user['email']) && strtolower($user['email']) === $email) {
            return $index;
        }
    }

    return null;
}

function sathi_user_storage_upsert(array $user): bool
{
    $email = isset($user['email']) ? strtolower(trim((string) $user['email'])) : '';
    if ($email === '') {
        return false;
    }

    $users = sathi_user_storage_load();
    foreach ($users as $index => $existing) {
        if (isset($existing['email']) && strtolower($existing['email']) === $email) {
            $users[$index] = array_merge($existing, $user, ['email' => $email, 'updated_at' => date('c')]);
            return sathi_user_storage_save($users);
        }
    }

    $user['email'] = $email;
    $user['updated_at'] = date('c');
    $users[] = $user;
    return sathi_user_storage_save($users);
}

function sathi_user_storage_update_status(string $email, string $status): bool
{
    $email = strtolower(trim($email));
    $status = strtolower(trim($status));
    if ($email === '' || $status === '') {
        return false;
    }

    $users = sathi_user_storage_load();
    foreach ($users as $index => $user) {
        if (isset($user['email']) && strtolower($user['email']) === $email) {
            $users[$index]['status'] = $status;
            $users[$index]['updated_at'] = date('c');
            return sathi_user_storage_save($users);
        }
    }

    return false;
}
