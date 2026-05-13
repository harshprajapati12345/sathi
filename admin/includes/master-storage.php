<?php
declare(strict_types=1);

function sathi_master_storage_path(): string
{
    return dirname(__DIR__, 2) . '/data/master-data.json';
}

function sathi_master_storage_load(): array
{
    $path = sathi_master_storage_path();
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

function sathi_master_storage_save(array $data): bool
{
    $path = sathi_master_storage_path();
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    if ($json === false) {
        return false;
    }

    return file_put_contents($path, $json) !== false;
}

function sathi_master_storage_get(string $slug): array
{
    $slug = trim($slug);
    if ($slug === '') {
        return [];
    }

    $data = sathi_master_storage_load();
    if (!isset($data[$slug]) || !is_array($data[$slug])) {
        return [];
    }

    return $data[$slug];
}

function sathi_master_storage_find_index(string $slug, string $id): ?int
{
    $slug = trim($slug);
    $id = trim($id);
    if ($slug === '' || $id === '') {
        return null;
    }

    $items = sathi_master_storage_get($slug);
    foreach ($items as $index => $item) {
        if (isset($item['id']) && (string) $item['id'] === $id) {
            return $index;
        }
    }

    return null;
}

function sathi_master_storage_next_id(string $slug): string
{
    $items = sathi_master_storage_get($slug);
    $max = 0;
    foreach ($items as $item) {
        if (isset($item['id']) && is_numeric($item['id'])) {
            $value = (int) $item['id'];
            if ($value > $max) {
                $max = $value;
            }
        }
    }

    return (string) ($max + 1);
}

function sathi_master_storage_upsert(string $slug, array $item): bool
{
    $slug = trim($slug);
    if ($slug === '') {
        return false;
    }

    $items = sathi_master_storage_load();
    if (!isset($items[$slug]) || !is_array($items[$slug])) {
        $items[$slug] = [];
    }

    $id = trim((string) ($item['id'] ?? ''));
    $name = trim((string) ($item['name'] ?? ''));
    $status = trim((string) ($item['status'] ?? 'Active'));
    if ($name === '') {
        return false;
    }

    if ($id === '') {
        $id = sathi_master_storage_next_id($slug);
    }

    $itemRecord = [
        'id' => $id,
        'name' => $name,
        'status' => $status,
    ];

    $updated = false;
    foreach ($items[$slug] as $index => $existing) {
        if (isset($existing['id']) && (string) $existing['id'] === $id) {
            $items[$slug][$index] = $itemRecord;
            $updated = true;
            break;
        }
    }

    if (!$updated) {
        $items[$slug][] = $itemRecord;
    }

    return sathi_master_storage_save($items);
}

function sathi_master_storage_delete(string $slug, string $id): bool
{
    $slug = trim($slug);
    $id = trim($id);
    if ($slug === '' || $id === '') {
        return false;
    }

    $items = sathi_master_storage_load();
    if (!isset($items[$slug]) || !is_array($items[$slug])) {
        return false;
    }

    foreach ($items[$slug] as $index => $item) {
        if (isset($item['id']) && (string) $item['id'] === $id) {
            array_splice($items[$slug], $index, 1);
            return sathi_master_storage_save($items);
        }
    }

    return false;
}
