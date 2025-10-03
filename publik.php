<?php
function bacaTransaksi() {
    $file = __DIR__ . '/data/transaksi.json';
    if (!file_exists($file)) return [];
    return json_decode(file_get_contents($file), true) ?: [];
}
function bacaAnggota() {
    $file = __DIR__ . '/data/anggota.json';
    if (!file_exists($file)) return [];
    return json_decode(file_get_contents($file), true) ?: [];
}

$transaksi = bacaTransaksi();
$pemasukan = array_sum(array_column(array_filter($transaksi, function($t) { return $t['jenis'] === 'pemasukan'; }), 'nominal'));
$pengeluaran = array_sum(array_column(array_filter($transaksi, function($t) { return $t['jenis'] === 'pengeluaran'; }), 'nominal'));
$saldo = $pemasukan - $pengeluaran;
$anggota = bacaAnggota();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transparansi Kas RT 13 RW 04</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background-color: #f8fdf8;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
            padding: 0;
        }
        .container-fluid {
            flex: 1;
            padding: 1rem;
        }
        .header {
            background: linear-gradient(to right, #2e7d32, #4caf50);
            color: white;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            text-align: center;
        }
        .saldo-box {
            background: white;
            padding: 0.75rem;
            border-radius: 8px;
            text-align: center;
            font-size: 1.1rem;
            color: #2e7d32;
            margin-bottom: 1rem;
        }
        .section-title {
            font-weight: 600;
            color: #2e7d32;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .table th,
        .table td {
            vertical-align: middle;
        }
        .badge-income {
            background-color: #c8e6c9;
            color: #2e7d32;
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
        }
        .badge-expense {
            background-color: #ffcdd2;
            color: #c62828;
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
        }
        .member-card {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .footer {
            text-align: center;
            padding: 1rem;
            font-size: 0.8rem;
            color: #666;
            background: #f8fdf8;
            border-top: 1px solid #dee2e6;
        }
        /* Responsive */
        @media (max-width: 576px) {
            .container-fluid {
                padding: 0.75rem;
            }
            .header h2 {
                font-size: 1.2rem;
            }
            .section-title {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>

<div class="container-fluid">

    <!-- Header -->
    <div class="header">
        <h2><i class="fas fa-file-invoice-dollar me-2"></i> Transparansi Kas RT 13 RW 04</h2>
        <small>Desa Pondokkaso Tonggoh, Kec. Cidahu</small>
    </div>

    <!-- Saldo -->
    <div class="saldo-box">
        <strong>Saldo Kas:</strong> Rp <?= number_format($saldo, 0, ',', '.') ?>
    </div>

    <!-- Riwayat Transaksi -->
    <div class="section-title">
        <i class="fas fa-history"></i> Riwayat Transaksi
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Nominal</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                usort($transaksi, function($a, $b) { return strtotime($b['tanggal']) - strtotime($a['tanggal']); });
                foreach ($transaksi as $t): ?>
                <tr>
                    <td><?= $t['tanggal'] ?></td>
                    <td>
                        <span class="badge <?= $t['jenis'] === 'pemasukan' ? 'badge-income' : 'badge-expense' ?>">
                            <?= ucfirst($t['jenis']) ?>
                        </span>
                    </td>
                    <td>Rp <?= number_format($t['nominal'], 0, ',', '.') ?></td>
                    <td><?= htmlspecialchars($t['keterangan']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Daftar Anggota -->
    <?php if (!empty($anggota)): ?>
    <div class="section-title">
        <i class="fas fa-users"></i> Daftar Anggota
    </div>
    <div class="row g-3">
        <?php foreach ($anggota as $a): ?>
        <div class="col-12 col-md-6">
            <div class="member-card">
                <h6 class="mb-1"><?= htmlspecialchars($a['nama']) ?></h6>
                <p class="mb-1">
                    <i class="fas fa-phone me-2"></i>
                    <?= htmlspecialchars($a['no_hp']) ?>
                </p>
                <?php if (!empty($a['alamat'])): ?>
                    <p class="text-muted mb-0 small"><?= htmlspecialchars($a['alamat']) ?></p>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

</div>

<!-- Footer -->
<div class="footer">
    © <?= date('Y') ?> - Sekretariat RT 13 RW 04
</div>

</body>
</html>