<?php
$host     = 'localhost';
$db       = 'rumah_sakit';
$user     = 'root';
$password = ''; // Kosongkan jika menggunakan default Laragon
$charset  = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $password, $options);
     
    // Menguji jika file koneksi.php ini dijalankan atau diakses langsung di browser
    if (basename($_SERVER['SCRIPT_FILENAME']) == 'koneksi.php') {
        echo "<div style='padding: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px; font-family: sans-serif; margin: 20px;'>";
        echo "<strong>Sukses!</strong> Koneksi ke database <u>$db</u> berhasil terhubung.";
        echo "</div>";
    }

} catch (\PDOException $e) {
    // Jika gagal, akan memunculkan pesan error yang rapi
    echo "<div style='padding: 15px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; font-family: sans-serif; margin: 20px;'>";
    echo "<strong>Koneksi Gagal!</strong> " . htmlspecialchars($e->getMessage());
    echo "</div>";
    exit;
}