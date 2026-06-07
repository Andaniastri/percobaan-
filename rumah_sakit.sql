-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 07, 2026 at 03:15 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rumah_sakit`
--

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `id_pasien` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `usia` int NOT NULL,
  `lama_rawat` int NOT NULL,
  `biaya_per_hari` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`id_pasien`, `nama`, `usia`, `lama_rawat`, `biaya_per_hari`) VALUES
(1, 'Andi Saputra', 35, 4, 350000.00),
(2, 'Siti Aminah', 28, 3, 400000.00),
(3, 'Budi Santoso', 41, 5, 500000.00),
(4, 'Rina Marlina', 22, 2, 300000.00),
(5, 'Dewi Lestari', 37, 6, 450000.00),
(6, 'Fajar Nugroho', 50, 7, 550000.00),
(7, 'Nur Hidayah', 31, 3, 400000.00),
(8, 'Rizky Pratama', 29, 4, 600000.00),
(9, 'Maya Sari', 34, 5, 750000.00),
(10, 'Agus Setiawan', 45, 7, 800000.00),
(11, 'Linda Fitri', 39, 3, 700000.00),
(12, 'Yoga Prakoso', 27, 2, 650000.00),
(13, 'Nina Kurnia', 33, 8, 900000.00),
(14, 'Arif Rahman', 48, 6, 850000.00),
(15, 'Tono Wijaya', 40, 4, 500000.00),
(16, 'Wulan Sari', 26, 2, 450000.00),
(17, 'Hendra Gunawan', 55, 5, 600000.00),
(18, 'Putri Ayu', 24, 3, 400000.00),
(19, 'Bagas Mahendra', 30, 6, 550000.00),
(20, 'Citra Dewi', 38, 4, 650000.00);

-- --------------------------------------------------------

--
-- Table structure for table `pasien_asuransi_swasta`
--

CREATE TABLE `pasien_asuransi_swasta` (
  `id_pasien` int NOT NULL,
  `nama_provider` varchar(100) NOT NULL,
  `nomor_polis` varchar(50) NOT NULL,
  `limit_cover` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pasien_asuransi_swasta`
--

INSERT INTO `pasien_asuransi_swasta` (`id_pasien`, `nama_provider`, `nomor_polis`, `limit_cover`) VALUES
(8, 'Prudential', 'POL001', 3000000.00),
(9, 'Allianz', 'POL002', 2500000.00),
(10, 'AXA Mandiri', 'POL003', 4000000.00),
(11, 'Sinarmas MSIG', 'POL004', 3000000.00),
(12, 'Prudential', 'POL005', 2000000.00),
(13, 'Allianz', 'POL006', 5000000.00),
(14, 'AXA Mandiri', 'POL007', 3500000.00);

-- --------------------------------------------------------

--
-- Table structure for table `pasien_bpjs`
--

CREATE TABLE `pasien_bpjs` (
  `id_pasien` int NOT NULL,
  `nomor_pbi` varchar(30) NOT NULL,
  `faskes_asal` varchar(100) NOT NULL,
  `kelas_kamar` enum('I','II','III') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pasien_bpjs`
--

INSERT INTO `pasien_bpjs` (`id_pasien`, `nomor_pbi`, `faskes_asal`, `kelas_kamar`) VALUES
(1, 'PBI001', 'Puskesmas A', 'III'),
(2, 'PBI002', 'Puskesmas B', 'II'),
(3, 'PBI003', 'RSUD Kota', 'I'),
(4, 'PBI004', 'Puskesmas C', 'III'),
(5, 'PBI005', 'Puskesmas D', 'II'),
(6, 'PBI006', 'RSUD Kabupaten', 'I'),
(7, 'PBI007', 'Puskesmas E', 'II');

-- --------------------------------------------------------

--
-- Table structure for table `pasien_umum`
--

CREATE TABLE `pasien_umum` (
  `id_pasien` int NOT NULL,
  `nik` char(16) NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pasien_umum`
--

INSERT INTO `pasien_umum` (`id_pasien`, `nik`, `metode_pembayaran`) VALUES
(15, '3374010101010001', 'Tunai'),
(16, '3374010101010002', 'Debit'),
(17, '3374010101010003', 'Transfer'),
(18, '3374010101010004', 'QRIS'),
(19, '3374010101010005', 'Kartu Kredit'),
(20, '3374010101010006', 'Transfer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id_pasien`);

--
-- Indexes for table `pasien_asuransi_swasta`
--
ALTER TABLE `pasien_asuransi_swasta`
  ADD PRIMARY KEY (`id_pasien`);

--
-- Indexes for table `pasien_bpjs`
--
ALTER TABLE `pasien_bpjs`
  ADD PRIMARY KEY (`id_pasien`);

--
-- Indexes for table `pasien_umum`
--
ALTER TABLE `pasien_umum`
  ADD PRIMARY KEY (`id_pasien`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id_pasien` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pasien_bpjs`
--
ALTER TABLE `pasien_bpjs`
  ADD CONSTRAINT `pasien_bpjs_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `pasien_umum`
--
ALTER TABLE `pasien_umum`
  ADD CONSTRAINT `fk_umum_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
