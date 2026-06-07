<?php
// Memanggil file bagian koneksi dan blueprint class pasien
require_once 'koneksi.php';
require_once 'data_pasien.php';

$daftarPasienObjek = [];

// Fetch Pasien BPJS
$sqlBPJS = "SELECT p.*, b.nomor_pbi, b.faskes_asal, b.kelas_kamar FROM pasien p INNER JOIN pasien_bpjs b ON p.id_pasien = b.id_pasien";
$stmt = $pdo->query($sqlBPJS);
while ($row = $stmt->fetch()) {
    $daftarPasienObjek[] = new PasienBPJS($row['id_pasien'], $row['nama'], $row['usia'], $row['lama_rawat'], $row['biaya_per_hari'], $row['nomor_pbi'], $row['faskes_asal'], $row['kelas_kamar']);
}

// Fetch Pasien Asuransi
$sqlAsuransi = "SELECT p.*, a.nama_provider, a.nomor_polis, a.limit_cover FROM pasien p INNER JOIN pasien_asuransi_swasta a ON p.id_pasien = a.id_pasien";
$stmt = $pdo->query($sqlAsuransi);
while ($row = $stmt->fetch()) {
    $daftarPasienObjek[] = new PasienAsuransiSwasta($row['id_pasien'], $row['nama'], $row['usia'], $row['lama_rawat'], $row['biaya_per_hari'], $row['nama_provider'], $row['nomor_polis'], $row['limit_cover']);
}

// Fetch Pasien Umum
$sqlUmum = "SELECT p.*, u.nik, u.metode_pembayaran FROM pasien p INNER JOIN pasien_umum u ON p.id_pasien = u.id_pasien";
$stmt = $pdo->query($sqlUmum);
while ($row = $stmt->fetch()) {
    $daftarPasienObjek[] = new PasienUmum($row['id_pasien'], $row['nama'], $row['usia'], $row['lama_rawat'], $row['biaya_per_hari'], $row['nik'], $row['metode_pembayaran']);
}

// Urutkan data berdasarkan ID Pasien
usort($daftarPasienObjek, function($a, $b) { return $a->idPasien <=> $b->idPasien; });
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Layanan Medis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body bg-dark text-white rounded-top p-4">
            <h2 class="m-0 fs-4 fw-bold">🏥 Sistem Backend Manajemen Klaim Biaya Rawat Inap</h2>
            <p class="m-0 text-white-50 mt-1">Struktur Kode Terpisah (Modular) dengan Database Relasional</p>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle m-0">
                    <thead class="table-secondary text-uppercase fs-7">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Nama Pasien / Usia</th>
                            <th>Durasi Rawat</th>
                            <th>Tarif Kamar / Hari</th>
                            <th>Klaster Penjamin</th>
                            <th>Detail Jaminan</th>
                            <th class="pe-4 text-end">Total Biaya Mandiri</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($daftarPasienObjek as $pasien): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-secondary">#<?= $pasien->idPasien ?></td>
                                <td>
                                    <span class="fw-semibold d-block text-dark"><?= htmlspecialchars($pasien->nama) ?></span>
                                    <small class="text-muted"><?= $pasien->usia ?> Tahun</small>
                                </td>
                                <td><span class="badge bg-light text-dark border"><?= $pasien->lamaRawat ?> Hari</span></td>
                                <td>Rp <?= number_format($pasien->biayaPerHari, 0, ',', '.') ?></td>
                                <td><?= $pasien->getJenisPenjamin() ?></td>
                                <td><?= $pasien->getDetailPenjamin() ?></td>
                                <td class="pe-4 text-end fw-bold text-primary fs-5">
                                    Rp <?= number_format($pasien->hitungTotalBiaya(), 0, ',', '.') ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>