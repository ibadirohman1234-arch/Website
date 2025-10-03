<?php
// Baca & simpan transaksi
function bacaTransaksi() {
    $file = __DIR__ . '/data/transaksi.json';
    if (!file_exists($file)) return [];
    return json_decode(file_get_contents($file), true) ?: [];
}
function simpanTransaksi($data) {
    file_put_contents(__DIR__ . '/data/transaksi.json', json_encode($data, JSON_PRETTY_PRINT));
}

// Baca & simpan anggota
function bacaAnggota() {
    $file = __DIR__ . '/data/anggota.json';
    if (!file_exists($file)) return [];
    return json_decode(file_get_contents($file), true) ?: [];
}
function simpanAnggota($data) {
    file_put_contents(__DIR__ . '/data/anggota.json', json_encode($data, JSON_PRETTY_PRINT));
}

// Cek password (plain text untuk kemudahan)
function cekPassword($input) {
    return $input === 'admin123';
}
?>