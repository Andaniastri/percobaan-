-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 05, 2026 at 12:16 PM
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

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `cetakKlaimLayanan` (IN `p_id_pasien` INT)   BEGIN
    SELECT
        id_pasien,
        nama,
        usia,
        lamaRawat,
        biayaKamarPerHari,
        hitungTotalBiaya(lamaRawat, biayaKamarPerHari) AS total_biaya
    FROM BPJS
    WHERE id_pasien = p_id_pasien;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `hitungTotalBiaya` (`p_lamaRawat` INT, `p_biayaKamarPerHari` DECIMAL(12,2)) RETURNS DECIMAL(15,2) DETERMINISTIC BEGIN
    RETURN p_lamaRawat * p_biayaKamarPerHari;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `bpjs`
--

CREATE TABLE `bpjs` (
  `id_pasien` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `usia` int NOT NULL,
  `lamaRawat` int NOT NULL,
  `biayaKamarPerHari` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bpjs`
--

INSERT INTO `bpjs` (`id_pasien`, `nama`, `usia`, `lamaRawat`, `biayaKamarPerHari`) VALUES
(1, 'Andi Saputra', 35, 5, 250000.00),
(2, 'Siti Aminah', 28, 3, 300000.00),
(3, 'Budi Santoso', 42, 7, 275000.00),
(4, 'Rina Marlina', 30, 4, 325000.00),
(5, 'Dedi Kurniawan', 50, 10, 350000.00),
(6, 'Eka Putri', 22, 2, 200000.00),
(7, 'Fajar Nugroho', 45, 8, 280000.00),
(8, 'Gita Lestari', 31, 6, 310000.00),
(9, 'Hendra Wijaya', 38, 5, 290000.00),
(10, 'Indah Permata', 27, 3, 260000.00),
(11, 'Joko Prasetyo', 55, 12, 400000.00),
(12, 'Kartika Dewi', 24, 1, 225000.00),
(13, 'Lukman Hakim', 41, 9, 330000.00),
(14, 'Maya Sari', 33, 4, 295000.00),
(15, 'Nanda Putra', 29, 6, 270000.00),
(16, 'Olivia Cahyani', 26, 2, 240000.00),
(17, 'Pandu Setiawan', 47, 11, 375000.00),
(18, 'Qori Aulia', 21, 3, 215000.00),
(19, 'Rizky Maulana', 36, 7, 305000.00),
(20, 'Tika Rahmawati', 32, 5, 285000.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bpjs`
--
ALTER TABLE `bpjs`
  ADD PRIMARY KEY (`id_pasien`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bpjs`
--
ALTER TABLE `bpjs`
  MODIFY `id_pasien` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
