<?php
session_start();
if (!isset($_SESSION['login'])) exit;

include 'functions.php';

// ========== TRANSAKSI ==========
if (isset($_POST['aksi'])) {
    $aksi = $_POST['aksi'];
    $id = $_POST['id'] ?? null;

    // --- SIMPAN TRANSAKSI BARU ---
    if ($aksi === 'simpan_transaksi') {
        $transaksi = bacaTransaksi();
        $transaksi[] = [
            'id' => time(),
            'tanggal' => $_POST['tanggal'],
            'jenis' => $_POST['jenis'],
            'nominal' => (int)$_POST['nominal'],
            'keterangan' => trim($_POST['keterangan'])
        ];
        simpanTransaksi($transaksi);
        header("Location: admin/transaksi.php");
        exit;
    }

    // --- UPDATE TRANSAKSI ---
    if ($aksi === 'update_transaksi' && $id) {
        $transaksi = bacaTransaksi();
        foreach ($transaksi as &$t) {
            if ($t['id'] == $id) {
                $t['tanggal'] = $_POST['tanggal'];
                $t['jenis'] = $_POST['jenis'];
                $t['nominal'] = (int)$_POST['nominal'];
                $t['keterangan'] = trim($_POST['keterangan']);
                break;
            }
        }
        simpanTransaksi($transaksi);
        header("Location: admin/transaksi.php");
        exit;
    }

    // --- HAPUS TRANSAKSI ---
    if ($aksi === 'hapus_transaksi' && $id) {
        $transaksi = bacaTransaksi();
        $transaksi = array_filter($transaksi, fn($t) => $t['id'] != $id);
        simpanTransaksi(array_values($transaksi));
        header("Location: admin/transaksi.php");
        exit;
    }

    // ========== ANGGOTA ==========
    // --- SIMPAN ANGGOTA BARU ---
    if ($aksi === 'simpan_anggota') {
        $anggota = bacaAnggota();
        $anggota[] = [
            'id' => time(),
            'nama' => trim($_POST['nama']),
            'no_hp' => trim($_POST['no_hp']),
            'alamat' => trim($_POST['alamat']),
            'keterangan' => trim($_POST['keterangan']),
            'tanggal_daftar' => date('Y-m-d H:i:s')
        ];
        simpanAnggota($anggota);
        header("Location: admin/anggota.php");
        exit;
    }

    // --- UPDATE ANGGOTA ---
    if ($aksi === 'update_anggota' && $id) {
        $anggota = bacaAnggota();
        foreach ($anggota as &$a) {
            if ($a['id'] == $id) {
                $a['nama'] = trim($_POST['nama']);
                $a['no_hp'] = trim($_POST['no_hp']);
                $a['alamat'] = trim($_POST['alamat']);
                $a['keterangan'] = trim($_POST['keterangan']);
                break;
            }
        }
        simpanAnggota($anggota);
        header("Location: admin/anggota.php");
        exit;
    }

    // --- HAPUS ANGGOTA ---
    if ($aksi === 'hapus_anggota' && $id) {
        $anggota = bacaAnggota();
        $anggota = array_filter($anggota, fn($a) => $a['id'] != $id);
        simpanAnggota(array_values($anggota));
        header("Location: admin/anggota.php");
        exit;
    }
}
?>