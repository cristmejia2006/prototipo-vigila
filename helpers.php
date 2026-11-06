<?php
define('DATA_FILE', __DIR__ . '/data/camaras.json');
define('UPLOAD_DIR', __DIR__ . '/uploads/');

function leer_camaras(): array {
    if (!file_exists(DATA_FILE)) {
        return [];
    }
    $json = file_get_contents(DATA_FILE);
    $data = json_decode($json, true);
    return is_array($data) ? $data : [];
}

function guardar_camaras(array $camaras): void {
    file_put_contents(DATA_FILE, json_encode($camaras, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function e(string $text): string {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}
