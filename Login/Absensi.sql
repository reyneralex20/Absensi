-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 03, 2020 at 04:27 AM
-- Server version: 8.0.19
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Absensi`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time NOT NULL DEFAULT '06:45:00',
  `jam_pulang` time NOT NULL DEFAULT '15:00:00',
  `scan_masuk` time DEFAULT NULL,
  `scan_keluar` time DEFAULT NULL,
  `terlambat` varchar(255) DEFAULT NULL,
  `pulang_cepat` varchar(255) DEFAULT NULL,
  `lembur` time DEFAULT NULL,
  `jam_kerja` time DEFAULT NULL,
  `is_libur` int NOT NULL DEFAULT '0',
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `user_id`, `tanggal`, `jam_masuk`, `jam_pulang`, `scan_masuk`, `scan_keluar`, `terlambat`, `pulang_cepat`, `lembur`, `jam_kerja`, `is_libur`, `keterangan`) VALUES
(56, 69, '2020-09-23', '06:45:00', '15:00:00', '17:09:45', '17:11:26', NULL, NULL, NULL, NULL, 0, NULL),
(57, 69, '2020-09-01', '06:45:00', '15:00:00', '17:11:25', '17:11:26', NULL, NULL, NULL, NULL, 1, 'libur liburan'),
(73, 69, '2020-09-26', '06:45:00', '15:00:00', '16:02:51', '16:23:03', 'Ya', 'Tidak', '01:23:00', '09:37:00', 0, NULL),
(74, 69, '2020-09-26', '06:45:00', '15:00:00', '16:14:47', '16:23:03', 'Ya', 'Tidak', '01:23:00', '09:37:00', 0, NULL),
(75, 69, '2020-09-26', '06:45:00', '15:00:00', '16:18:40', '16:23:03', 'Ya', 'Tidak', '01:23:00', '09:37:00', 0, NULL),
(76, 69, '2020-09-26', '06:45:00', '15:00:00', '16:22:29', '16:23:03', 'Ya', 'Tidak', '01:23:00', '09:37:00', 0, NULL),
(77, 69, '2020-09-26', '06:45:00', '15:00:00', '16:23:02', '16:23:03', 'Ya', 'Tidak', '01:23:00', '09:37:00', 0, NULL),
(78, 69, '2020-09-26', '06:45:00', '15:00:00', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'asddsa'),
(79, 69, '2020-09-26', '06:45:00', '15:00:00', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'dsa');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `NIP` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `nama_lengkap`, `NIP`) VALUES
(69, 'ludovica_dewi', '$2y$10$9JT6aZkBXFacA.JzpmynEeWEXLVpijVvuKcJZbGoKDKN0WZMaf24a', 'LUDOVICA DEWI INDAH SETIAWATI, S.Pd', '19780616.200312.2.004');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
