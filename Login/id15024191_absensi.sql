-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 03, 2020 at 02:56 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id15024191_absensi`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time NOT NULL DEFAULT '06:45:00',
  `jam_pulang` time NOT NULL DEFAULT '15:00:00',
  `scan_masuk` time DEFAULT NULL,
  `scan_keluar` time DEFAULT NULL,
  `terlambat` time DEFAULT NULL,
  `pulang_cepat` time DEFAULT NULL,
  `lembur` time DEFAULT NULL,
  `jam_kerja` time DEFAULT NULL,
  `jml_hadir` time DEFAULT NULL,
  `is_libur` int(11) NOT NULL DEFAULT 0,
  `keterangan` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `user_id`, `tanggal`, `jam_masuk`, `jam_pulang`, `scan_masuk`, `scan_keluar`, `terlambat`, `pulang_cepat`, `lembur`, `jam_kerja`, `jml_hadir`, `is_libur`, `keterangan`) VALUES
(1, 69, '2020-10-05', '06:45:00', '15:00:00', '06:14:31', '15:10:55', NULL, NULL, '00:10:55', '00:56:24', NULL, 0, NULL),
(2, 69, '2020-10-06', '06:45:00', '15:00:00', '06:24:35', '15:13:15', NULL, NULL, '00:13:15', '00:48:40', NULL, 0, NULL),
(3, 69, '2020-10-07', '06:45:00', '15:00:00', '06:22:10', '15:03:28', NULL, NULL, '00:03:28', '00:41:18', NULL, 0, NULL),
(4, 69, '2020-10-08', '06:45:00', '15:00:00', '06:06:27', '15:02:40', NULL, NULL, '00:02:40', '00:56:13', NULL, 0, NULL),
(5, 69, '2020-10-09', '06:45:00', '15:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Sakit'),
(6, 69, '2020-10-13', '06:45:00', '15:00:00', '06:15:57', '15:07:30', NULL, NULL, '00:07:30', '00:51:33', NULL, 0, NULL),
(7, 69, '2020-10-14', '06:45:00', '15:00:00', '06:06:17', '15:03:06', NULL, NULL, '00:03:06', '00:56:49', NULL, 0, NULL),
(8, 69, '2020-10-15', '06:45:00', '15:00:00', '06:21:25', '15:14:27', NULL, NULL, '00:14:27', '00:53:02', NULL, 0, NULL),
(9, 69, '2020-10-16', '06:45:00', '15:00:00', '06:10:09', '15:06:48', NULL, NULL, '00:06:48', '00:56:39', NULL, 0, NULL),
(10, 69, '2020-10-19', '06:45:00', '15:00:00', '06:27:29', '15:07:45', NULL, NULL, '00:07:45', '00:40:16', NULL, 0, NULL),
(11, 69, '2020-10-20', '06:45:00', '15:00:00', '06:30:40', '15:07:53', NULL, NULL, '00:07:53', '00:37:13', NULL, 0, NULL),
(12, 69, '2020-10-21', '06:45:00', '15:00:00', '06:28:19', '15:05:38', NULL, NULL, '00:05:38', '00:37:19', NULL, 0, NULL),
(13, 69, '2020-10-22', '06:45:00', '15:00:00', '06:15:55', '15:13:17', NULL, NULL, '00:13:17', '00:57:22', NULL, 0, NULL),
(14, 69, '2020-10-23', '06:45:00', '15:00:00', '06:17:41', '15:04:22', NULL, NULL, '00:04:22', '00:46:41', NULL, 0, NULL),
(15, 69, '2020-10-26', '06:45:00', '15:00:00', '06:23:49', '15:03:12', NULL, NULL, '00:03:12', '00:39:23', NULL, 0, NULL),
(16, 69, '2020-10-27', '06:45:00', '15:00:00', '06:17:15', '15:02:49', NULL, NULL, '00:02:49', '00:45:34', NULL, 0, NULL),
(17, 69, '2020-10-28', '06:45:00', '15:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Cuti Bersama Hari Raya Maulid Nabi'),
(18, 69, '2020-10-28', '06:45:00', '15:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Cuti Bersama Hari Raya Maulid Nabi'),
(19, 69, '2020-10-29', '06:45:00', '15:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Libur Hari Raya Maulid Nabi'),
(20, 69, '2020-10-30', '06:45:00', '15:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Cuti bersama libur hari raya Maulid Nabi'),
(21, 69, '2020-11-02', '06:45:00', '15:00:00', '06:10:40', '15:24:42', NULL, NULL, '00:24:42', '00:14:02', NULL, 0, NULL),
(22, 69, '2020-11-03', '06:45:00', '15:00:00', '06:21:08', '15:05:01', NULL, NULL, '00:05:01', '00:43:53', NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `NIP` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `nama_lengkap`, `NIP`) VALUES
(69, 'absensi', '$2y$10$9JT6aZkBXFacA.JzpmynEeWEXLVpijVvuKcJZbGoKDKN0WZMaf24a', 'LUDOVICA DEWI INDAH SETIAWATI, S.Pd', '19780616.200312.2.004');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

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
