# 🏥 Sistem Backend Manajemen Layanan Medis & BPJS Rumah Sakit

Projek ini merupakan aplikasi backend berbasis web menggunakan **PHP Native (OOP)** murni yang terintegrasi dengan basis data **MySQL** Sistem ini dirancang untuk mengelola data rekam medis pasien rawat inap serta melakukan kalkulasi otomatis terhadap total tagihan mandiri pasien berdasarkan karakteristik dari masing-masing klaster penjamin[cite: 15].

Projek ini disusun untuk memenuhi tugas besar kolaboratif pada mata kuliah Pemrograman Berorientasi Objek (PBO) — Semester 2.

---

## 👥 Anggota Kelompok 2 (TRPL-1A)

Berikut adalah daftar anggota kelompok beserta kolom peran dan tugas yang dapat disesuaikan:

| No | Nama Mahasiswa | NIM | Peran / Job Deskripsi | Tugas Spesifik |
|:---|:---|:---|:---|:---|
| 1 | **Ahmad Fakhri Abdullah** | 250215003 | | |
| 2 | **Astri Yuli Andani** | 250215007 | | |
| 3 | **Elang Panca Tunggal** | 250215013 | | |
| 4 | **Lutfi Mohammad Hafiz** | 250215021 | | |
| 5 | **Mukhamad Ferdiyanto** | 250115024 | | |

---

## 🛠️ Implementasi Pilar-Pilar OOP

Sistem ini merepresentasikan 4 pilar utama Pemrograman Berorientasi Objek secara konkrit di dalam berkas kode program:

### 1. Abstraction (Abstraksi)
Diterapkan dengan membuat `abstract class Pasien` yang tidak dapat diinstansiasi langsung. Kelas ini bertindak sebagai kerangka induk untuk mendeklarasikan metode abstrak `hitungTotalBiaya()` dan metode kontrak visual lainnya yang wajib diturunkan dan diimplementasikan secara spesifik oleh setiap sub-class[cite: 16].

### 2. Inheritance (Pewarisan)
Pilar pewarisan diimplementasikan menggunakan kata kunci `extends`, di mana kelas `PasienBPJS`, `PasienAsuransiSwasta`, dan `PasienUmum` mewarisi properti dasar (seperti `idPasien`, `nama`, `usia`, `lamaRawat`, `biayaPerHari`) yang dideklarasikan pada kelas induk `Pasien`[cite: 16, 17].

### 3. Encapsulation (Enkapsulasi)
Seluruh properti inti pada kelas induk diamankan menggunakan *access modifier* `protected` agar hanya dapat diakses secara internal oleh kelas anak. Atribut-atribut spesifik penjamin pada kelas anak (seperti `nomorPBI`, `nomorPolis`, atau `nik`) diisolasi secara ketat menggunakan dekorator `private` untuk mencegah manipulasi data dari luar kelas[cite: 17, 36].

### 4. Polymorphism (Polimorfisme)
Polimorfisme diwujudkan melalui mekanisme **Method Overriding**, di mana masing-masing sub-class mengimplementasikan aturan logika rumus perhitungan biaya mandiri yang berbeda saat runtime (*Dynamic Binding*)[cite: 27, 39]:
**Pasien BPJS**: Menanggung **10%** dari total tarif dasar kamar karena adanya subsidi sebesar 90%.
**Pasien Asuransi Swasta**: Hanya membayar sisa selisih biaya rawat inap apabila total tarif melebihi batas `limitCover` jaminan. Jika tidak melebihi limit, total biaya mandiri bernilai **Rp 0**[cite: 18, 19].
**Pasien Umum / Mandiri**: Menanggung tarif rawat inap secara penuh ditambah dengan **Biaya Administrasi Tambahan tetap sebesar Rp 150.000**.

---

## 📐 Class Diagram UML

*(Sematkan diagram kelas UML yang telah dirancang di bawah ini)*

![Class Diagram UML](assets/ujung_diagram_uml.png) ---

## 📊 Aturan Relasi Skema Basis Data (`rumah_sakit.sql`)

Struktur tabel di dalam database menggunakan pendekatan relasi **1:1 (Class Table Inheritance)** untuk memetakan objek warisan ke dalam tabel relasional:
Tabel `pasien` menyimpan data demografi dan rekam medis dasar dari seluruh entitas pasien.
Tabel `pasien_bpjs`, `pasien_asuransi_swasta`, dan `pasien_umum` menyimpan field-field atribut spesifik dan dihubungkan kembali ke tabel induk menggunakan batasan kunci tamu (*Foreign Key Constraints*) yang merujuk pada `id_pasien`[cite: 17, 31].

---

## 💻 Panduan Instalasi dan Pengujian Lokal

### Kebutuhan Sistem
* **Laragon** atau XAMPP
* PHP Versi 8.0 ke atas

### Langkah Eksekusi Proyek
1.  Unduh atau klon repositori ini dan letakkan ke dalam folder server lokal Anda:
    ```bash
    C:\laragon\www\sistem-manajemen-rs\
    ```
2.  Buku utilitas database penyedia Anda (HeidiSQL / phpMyAdmin), buat database baru bernama `rumah_sakit`, kemudian lakukan **Import** terhadap berkas database cadangan yang terletak di `database/rumah_sakit.sql`[cite: 32].
3.  Sesuaikan parameter akun kredensial akses basis data pada file `koneksi.php` dengan setelan server lokal Anda.
4.  Jalankan modul pengujian melalui penjelajah web Anda:
    * **Dashboard Utama (Kalkulasi Polimorfik):** `http://localhost/sistem-manajemen-rs/index.php`
    * **Laporan Kategorisasi Pasien:** `http://localhost/sistem-manajemen-rs/pasien.php`
    * **Validasi Status Koneksi Database:** `http://localhost/sistem-manajemen-rs/koneksi.php`

---

## 📅 Log Aktivitas Mingguan (Logbook Kelompok)

*Catatan histori aktivitas komit nyata yang terekam pada grafik kontribusi GitHub kelompok:*

| Minggu Ke- | Tanggal | Anggota GitHub | Aktivitas Kontribusi / Deskripsi Komit | Status |
|:---|:---|:---|:---|:---|
| | | | | |
| | | | | |
| | | | | |
| | | | | |
| | | | | |
