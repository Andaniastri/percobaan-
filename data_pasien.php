<?php
// Menyertakan koneksi agar file ini bisa mengambil data secara mandiri dari database
require_once 'koneksi.php';

// ==========================================
// PILAR ABSTRAKSI: Abstract Class Pasien
// ==========================================
abstract class Pasien {
    public int $idPasien;
    public string $nama;
    public int $usia;
    public int $lamaRawat;
    public float $biayaPerHari;

    public function __construct(int $idPasien, string $nama, int $usia, int $lamaRawat, float $biayaPerHari) {
        $this->idPasien = $idPasien;
        $this->nama = $nama;
        $this->usia = $usia;
        $this->lamaRawat = $lamaRawat;
        $this->biayaPerHari = $biayaPerHari;
    }

    abstract public function hitungTotalBiaya(): float;
    abstract public function getJenisPenjamin(): string;
    abstract public function getDetailPenjamin(): string;
}

// ==========================================
// PILAR PEWARISAN & POLIMORFISME
// ==========================================

// 1. Subclass BPJS
class PasienBPJS extends Pasien {
    private string $nomorPBI;
    private string $faskesAsal;
    private string $kelasKamar;

    public function __construct($idPasien, $nama, $usia, $lamaRawat, $biayaPerHari, string $nomorPBI, string $faskesAsal, string $kelasKamar) {
        parent::__construct($idPasien, $nama, $usia, $lamaRawat, $biayaPerHari);
        $this->nomorPBI = $nomorPBI;
        $this->faskesAsal = $faskesAsal;
        $this->kelasKamar = $kelasKamar;
    }

    public function hitungTotalBiaya(): float {
        return ($this->lamaRawat * $this->biayaPerHari) * 0.10; // Pasien bayar 10%
    }

    public function getJenisPenjamin(): string {
        return "BPJS Kesehatan";
    }

    public function getDetailPenjamin(): string {
        return "No PBI: {$this->nomorPBI} | Faskes Asal: {$this->faskesAsal} | Kelas Kamar: {$this->kelasKamar}";
    }
}

// 2. Subclass Asuransi Swasta
class PasienAsuransiSwasta extends Pasien {
    private string $namaProvider;
    private string $nomorPolis;
    private float $limitCover;

    public function __construct($idPasien, $nama, $usia, $lamaRawat, $biayaPerHari, string $namaProvider, string $nomorPolis, float $limitCover) {
        parent::__construct($idPasien, $nama, $usia, $lamaRawat, $biayaPerHari);
        $this->namaProvider = $namaProvider;
        $this->nomorPolis = $nomorPolis;
        $this->limitCover = $limitCover;
    }

    public function hitungTotalBiaya(): float {
        $totalTarif = $this->lamaRawat * $this->biayaPerHari;
        return ($totalTarif > $this->limitCover) ? ($totalTarif - $this->limitCover) : 0;
    }

    public function getJenisPenjamin(): string {
        return "Asuransi Swasta";
    }

    public function getDetailPenjamin(): string {
        return "Provider: {$this->namaProvider} | No. Polis: {$this->nomorPolis} | Limit Cover: Rp " . number_format($this->limitCover, 0, ',', '.');
    }
}

// 3. Subclass Umum
class PasienUmum extends Pasien {
    private string $nik;
    private string $metodePembayaran;
    private const BIAYA_ADMIN = 150000;

    public function __construct($idPasien, $nama, $usia, $lamaRawat, $biayaPerHari, string $nik, string $metodePembayaran) {
        parent::__construct($idPasien, $nama, $usia, $lamaRawat, $biayaPerHari);
        $this->nik = $nik;
        $this->metodePembayaran = $metodePembayaran;
    }

    public function hitungTotalBiaya(): float {
        return ($this->lamaRawat * $this->biayaPerHari) + self::BIAYA_ADMIN;
    }

    public function getJenisPenjamin(): string {
        return "Umum / Mandiri";
    }

    public function getDetailPenjamin(): string {
        return "NIK: {$this->nik} | Metode Pembayaran: {$this->metodePembayaran} (Termasuk Admin Rp 150.000)";
    }
}

// ==========================================
// PROSES EKSEKUSI DATA (KATEGORISASI DATA)
// ==========================================

$kategoriPasien = [
    'BPJS'     => [],
    'Asuransi' => [],
    'Umum'     => []
];

// 1. Fetch & Grouping Pasien BPJS
$sqlBPJS = "SELECT p.*, b.nomor_pbi, b.faskes_asal, b.kelas_kamar FROM pasien p INNER JOIN pasien_bpjs b ON p.id_pasien = b.id_pasien";
$stmt = $pdo->query($sqlBPJS);
while ($row = $stmt->fetch()) {
    $kategoriPasien['BPJS'][] = new PasienBPJS($row['id_pasien'], $row['nama'], $row['usia'], $row['lama_rawat'], $row['biaya_per_hari'], $row['nomor_pbi'], $row['faskes_asal'], $row['kelas_kamar']);
}

// 2. Fetch & Grouping Pasien Asuransi Swasta
$sqlAsuransi = "SELECT p.*, a.nama_provider, a.nomor_polis, a.limit_cover FROM pasien p INNER JOIN pasien_asuransi_swasta a ON p.id_pasien = a.id_pasien";
$stmt = $pdo->query($sqlAsuransi);
while ($row = $stmt->fetch()) {
    $kategoriPasien['Asuransi'][] = new PasienAsuransiSwasta($row['id_pasien'], $row['nama'], $row['usia'], $row['lama_rawat'], $row['biaya_per_hari'], $row['nama_provider'], $row['nomor_polis'], $row['limit_cover']);
}

// 3. Fetch & Grouping Pasien Umum
$sqlUmum = "SELECT p.*, u.nik, u.metode_pembayaran FROM pasien p INNER JOIN pasien_umum u ON p.id_pasien = u.id_pasien";
$stmt = $pdo->query($sqlUmum);
while ($row = $stmt->fetch()) {
    $kategoriPasien['Umum'][] = new PasienUmum($row['id_pasien'], $row['nama'], $row['usia'], $row['lama_rawat'], $row['biaya_per_hari'], $row['nik'], $row['metode_pembayaran']);
}


// ==========================================
// OUTPUT PRESENTATION (TAMPILAN WEB)
// ==========================================
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pasien Per Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-dark">📋 Daftar Data Medis Pasien Per Kategori</h2>
        <p class="text-muted">Pengelompokkan data rekam medis pasien rawat inap rumah sakit</p>
    </div>

    <?php foreach ($kategoriPasien as $namaKategori => $daftarPasien): ?>
        <div class="card shadow-sm border-0 mb-5">
            <div class="card-header <?php 
                echo $namaKategori === 'BPJS' ? 'bg-success text-white' : ($namaKategori === 'Asuransi' ? 'bg-primary text-white' : 'bg-secondary text-white');
            ?> py-3">
                <h3 class="card-title m-0 fs-5 fw-bold">Klaster Pasien <?= $namaKategori ?> (Total: <?= count($daftarPasien) ?> Pasien)</h3>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle m-0">
                        <thead class="table-light text-uppercase fs-7">
                            <tr>
                                <th class="ps-4">ID</th>
                                <th>Nama Pasien</th>
                                <th>Usia</th>
                                <th>Lama Rawat</th>
                                <th class="pe-4">Detail Jaminan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($daftarPasien)): ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Tidak ada data pasien untuk kategori ini.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($daftarPasien as $pasien): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold">#<?= $pasien->idPasien ?></td>
                                        <td class="fw-semibold text-dark"><?= htmlspecialchars($pasien->nama) ?></td>
                                        <td><?= $pasien->usia ?> Tahun</td>
                                        <td><span class="badge bg-light text-dark border"><?= $pasien->lamaRawat ?> Hari</span></td>
                                        <td class="pe-4 text-muted"><small><?= $pasien->getDetailPenjamin() ?></small></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>


