-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2025 at 12:38 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `krs_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `nik` varchar(20) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `gelar` varchar(50) DEFAULT NULL,
  `lulusan` varchar(100) DEFAULT NULL,
  `telp` varchar(15) DEFAULT NULL,
  `user_input` varchar(50) DEFAULT NULL,
  `tanggal_input` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`nik`, `nama`, `gelar`, `lulusan`, `telp`, `user_input`, `tanggal_input`) VALUES
('D001', 'Samuel Hutagalung', 'S. Pertanian.', 'IPB', '081234128382', 'admin2', '2025-04-10 21:36:41'),
('D002', 'Nabila Husna', 'S.S', 'UMN', '0812712412412', 'admin', '2025-04-10 21:39:08'),
('D003', 'Wirawan Istiono', 'S. Kom., S. Gym.', 'Umbrella Corp.', '084912737123', 'admin2', '2025-04-10 21:39:36'),
('D004', 'Monica Pratiwi', 'S.R', 'ITB', '083812371238', 'admin', '2025-04-10 21:40:37'),
('D005', 'Bombardiro Crocodilo', 'Ph.D', 'BINUS', '081234562342', 'admin2', '2025-04-10 21:41:19'),
('D006', 'Khadafi WOW', 'S.T', 'UMN', '0821361241231', 'admin', '2025-04-10 21:42:11');

--
-- Triggers `dosen`
--
DELIMITER $$
CREATE TRIGGER `trg_insert_user_dosen` AFTER INSERT ON `dosen` FOR EACH ROW BEGIN
  DECLARE username VARCHAR(50);
  DECLARE password_raw VARCHAR(100);

  -- Set username: lowercase, no spaces, max 50 characters
  SET username = LEFT(LOWER(REPLACE(NEW.nama, ' ', '')), 50);

  -- Password: last 4 digits of no_telp
  SET password_raw = RIGHT(NEW.telp, 4);

  INSERT INTO `users` (username, password, role, nik)
  VALUES (username, password_raw, 'dosen', NEW.nik);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nim` varchar(20) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jurusan` varchar(50) NOT NULL,
  `tahun_masuk` int(11) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `telp` varchar(15) DEFAULT NULL,
  `user_input` varchar(50) DEFAULT NULL,
  `tanggal_input` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`nim`, `nama`, `jurusan`, `tahun_masuk`, `alamat`, `telp`, `user_input`, `tanggal_input`) VALUES
('M001', 'Deswandy Wong', 'Teknik Komputer', 2023, 'Tangerang', '081290949332', 'admin2', '2025-04-10 21:44:29'),
('M002', 'Frederick Theodore', 'Sistem Informasi', 2023, 'Tangerang', '081293849283', 'admin2', '2025-04-10 21:44:53'),
('M003', 'Vallerie Alexander Putra', 'Informatika', 2023, 'Jakarta', '082194957162', 'admin2', '2025-04-10 21:45:23'),
('M004', 'Christie Tjong', 'Teknik Fisika', 2023, 'Jakarta', '082374950284', 'admin2', '2025-04-10 21:46:02'),
('M005', 'Pargonda Maryun', 'Teknik Komputer', 2023, 'Situngkir', '081343602122', 'admin', '2025-04-10 21:54:01'),
('M006', 'Leony Fransisca', 'Management', 2023, 'Bekasi Selatan', '08146321781', 'admin', '2025-04-10 21:55:54'),
('M007', 'Jonathan Timothy', 'Sistem Informasi', 2023, 'Air Merapin', '081282146281', 'admin', '2025-04-10 21:56:38'),
('M008', 'Richie', 'Akuntansi', 2024, 'Air Ruay', '081273748484', 'admin', '2025-04-10 21:57:40'),
('M009', 'Carvelino', 'Informatika', 2024, 'Merawang', '089988776622', 'admin', '2025-04-10 21:58:06'),
('M010', 'Kevin Sanjaya', 'Informatika', 2023, 'Sungailiat', '082233441122', 'admin', '2025-04-10 21:59:06'),
('M011', 'Bambang Pamungkas', 'Teknik Komputer', 2020, 'Jakarta Pusat', '089127321973', 'admin', '2025-04-10 21:59:35'),
('M012', 'Lebron James', 'Informatika', 2023, 'Los Angles', '081234567812', 'admin', '2025-04-10 22:00:09'),
('M013', 'Tralalelo Tralala', 'Teknik Komputer', 2021, 'Tangerang', '081266677788', 'admin2', '2025-04-10 22:07:22'),
('M015', 'Nobel Joseph', 'Teknik Komputer', 2023, 'Jakarta', '083239475464', 'admin2', '2025-04-10 22:17:44'),
('M016', 'Chandra Kurnia Santoso', 'Teknik Komputer', 2023, 'Pekanbaru', '084674950284', 'admin2', '2025-04-10 22:19:11'),
('M017', 'Jessica', 'Teknik Komputer', 2023, 'Tangerang', '083291372143', 'admin', '2025-04-10 22:19:34'),
('M018', 'Christian', 'Teknik Komputer', 2023, 'Depook', '089284712973', 'admin', '2025-04-10 22:20:02'),
('M019', 'Christoper', 'Informatika', 2021, 'Kebon Jengkol', '082138126931', 'admin', '2025-04-10 22:20:35'),
('M020', 'Bryan', 'Management', 2022, 'Kelapa Kuning', '0872183216838', 'admin', '2025-04-10 22:21:13'),
('M021', 'Patrick', 'Management', 2023, 'Joglo', '082198361284', 'admin', '2025-04-10 22:21:42'),
('M022', 'Clark Kent', 'Informatika', 2022, 'Metropolis', '082185632847', 'admin2', '2025-04-10 22:21:43'),
('M023', 'Robert', 'Sistem Informasi', 2022, 'Bangka Beligung', '088216986312', 'admin', '2025-04-10 22:22:14'),
('M024', 'Bruce Wayne', 'Strategi Komunikasi', 2024, 'Gotham', '083294759748', 'admin2', '2025-04-10 22:22:16'),
('M025', 'Apung', 'Akuntansi', 2021, 'Bekasing', '0812712412411', 'admin', '2025-04-10 22:22:47'),
('M026', 'Tony Stark', 'Teknik Komputer', 2023, 'Afghanistan', '082395047273', 'admin2', '2025-04-10 22:22:53'),
('M027', 'Abun', 'Sistem Informasi', 2022, 'Kebon Singkong', '081343602123', 'admin', '2025-04-10 22:23:18'),
('M028', 'Steve Rogers', 'Manajemen', 2022, 'Amerika', '081492094832', 'admin2', '2025-04-10 22:23:32'),
('M029', 'Ketung Sahoor', 'Informatika', 2022, 'Kebon Jagung', '0812712412410', 'admin', '2025-04-10 22:23:54'),
('M030', 'Aliong', 'Informatika', 2023, 'Top Carwash', '081294728948', 'admin2', '2025-04-10 22:24:04'),
('M031', 'Flint Barton', 'Informatika', 2022, 'Jakarta', '082236475637', 'admin2', '2025-04-10 22:24:32'),
('M032', 'Petir Parkir', '082395840283', 2022, 'Los Angeles', '082395739574', 'admin2', '2025-04-10 22:25:01');

--
-- Triggers `mahasiswa`
--
DELIMITER $$
CREATE TRIGGER `trg_insert_user_mahasiswa` AFTER INSERT ON `mahasiswa` FOR EACH ROW BEGIN
  DECLARE username VARCHAR(50);
  DECLARE password_raw VARCHAR(100);

  -- Set username: lowercase, no spaces, max 50 characters
  SET username = LEFT(LOWER(REPLACE(NEW.nama, ' ', '')), 50);

  -- Password: first word (first name) + 0000
  SET password_raw = CONCAT(LOWER(SUBSTRING_INDEX(NEW.nama, ' ', 1)), NEW.tahun_masuk);

  INSERT INTO `users` (username, password, role, nim)
  VALUES (username, password_raw, 'mahasiswa', NEW.nim);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `matakuliah`
--

CREATE TABLE `matakuliah` (
  `kode_matkul` varchar(20) NOT NULL,
  `nama_matkul` varchar(100) DEFAULT NULL,
  `sks` int(11) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `user_input` varchar(50) DEFAULT NULL,
  `tanggal_input` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `matakuliah`
--

INSERT INTO `matakuliah` (`kode_matkul`, `nama_matkul`, `sks`, `semester`, `user_input`, `tanggal_input`) VALUES
('MK001', 'Pemrograman Web', 3, 4, 'admin', '2025-03-31 14:46:02'),
('MK002', 'Algoritma dan Struktur Data', 3, 2, 'admin', '2025-03-31 14:46:02'),
('MK003', 'Jaringan Komputer', 3, 5, 'admin', '2025-03-31 14:46:02'),
('MK004', 'Kecerdasan Buatan', 3, 6, 'admin', '2025-03-31 14:46:02'),
('MK005', 'Keamanan Informasi', 3, 7, 'admin', '2025-03-31 14:46:02'),
('MK006', 'Sistem Operasi', 3, 3, 'admin', '2025-03-31 14:46:02'),
('MK007', 'Analisis dan Perancangan Sistem', 3, 5, 'admin', '2025-03-31 14:46:02'),
('MK008', 'Manajemen Basis Data', 3, 4, 'admin', '2025-03-31 14:46:02'),
('MK009', 'Interaksi Manusia dan Komputer', 3, 4, 'admin', '2025-03-31 14:46:02'),
('MK010', 'Pemrograman Mobile', 3, 6, 'admin', '2025-03-31 14:46:02'),
('MK011', 'Arsitektur dan Organisasi Komputer', 3, 2, 'admin2', '2025-04-10 21:33:31'),
('MK012', 'Visual Graphic Branding Design', 3, 3, 'admin2', '2025-04-10 21:33:44'),
('MK013', 'Visualisasi Data', 3, 4, 'admin2', '2025-04-10 21:34:21'),
('MK014', 'Analisis Data', 3, 4, 'admin2', '2025-04-10 21:34:35'),
('MK015', 'Sistem Mikroprosesor', 3, 4, 'admin2', '2025-04-10 21:34:57');

-- --------------------------------------------------------

--
-- Table structure for table `trx_krs`
--

CREATE TABLE `trx_krs` (
  `id_trx_krs` int(11) NOT NULL,
  `id_trx_matkul` int(11) DEFAULT NULL,
  `nim` varchar(20) DEFAULT NULL,
  `user_input` varchar(50) DEFAULT NULL,
  `tanggal_input` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trx_krs`
--

INSERT INTO `trx_krs` (`id_trx_krs`, `id_trx_matkul`, `nim`, `user_input`, `tanggal_input`) VALUES
(20, 10, 'M001', 'admin2', '2025-04-11'),
(21, 10, 'M004', 'admin2', '2025-04-11'),
(22, 10, 'M005', 'admin2', '2025-04-11'),
(23, 10, 'M009', 'admin2', '2025-04-11'),
(24, 10, 'M015', 'admin2', '2025-04-11'),
(25, 19, 'M001', 'admin', '2025-04-11'),
(26, 10, 'M032', 'admin2', '2025-04-11'),
(27, 19, 'M003', 'admin', '2025-04-11'),
(28, 19, 'M010', 'admin', '2025-04-11'),
(29, 12, 'M001', 'admin2', '2025-04-11'),
(30, 10, 'M011', 'admin', '2025-04-11'),
(31, 12, 'M011', 'admin2', '2025-04-11'),
(32, 12, 'M007', 'admin2', '2025-04-11'),
(33, 18, 'M001', 'admin2', '2025-04-11'),
(34, 19, 'M002', 'admin2', '2025-04-11'),
(35, 16, 'M006', 'admin2', '2025-04-11'),
(36, 16, 'M005', 'admin2', '2025-04-11'),
(37, 13, 'M011', 'admin', '2025-04-11'),
(38, 15, 'M011', 'admin', '2025-04-11'),
(39, 18, 'M011', 'admin', '2025-04-11'),
(40, 19, 'M011', 'admin', '2025-04-11'),
(41, 16, 'M011', 'admin', '2025-04-11');

-- --------------------------------------------------------

--
-- Table structure for table `trx_matkul`
--

CREATE TABLE `trx_matkul` (
  `id_trx_matkul` int(11) NOT NULL,
  `kelas_matkul` varchar(3) NOT NULL,
  `hari_matkul` varchar(10) NOT NULL,
  `ruang_matkul` varchar(5) NOT NULL,
  `user_input` varchar(50) NOT NULL,
  `tanggal_input` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `nik` varchar(20) NOT NULL,
  `kode_matkul` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trx_matkul`
--

INSERT INTO `trx_matkul` (`id_trx_matkul`, `kelas_matkul`, `hari_matkul`, `ruang_matkul`, `user_input`, `tanggal_input`, `nik`, `kode_matkul`) VALUES
(10, 'B', 'Senin', 'B512', 'admin', '2025-04-10 22:25:32', 'D003', 'MK001'),
(11, 'A', 'Kamis', 'C802', 'admin2', '2025-04-10 22:25:56', 'D006', 'MK001'),
(12, 'A', 'Selasa', 'B519', 'admin', '2025-04-10 22:26:02', 'D005', 'MK004'),
(13, 'A', 'Jumat', 'B510', 'admin2', '2025-04-10 22:26:39', 'D003', 'MK002'),
(14, 'C', 'Rabu', 'C311', 'admin', '2025-04-10 22:26:52', 'D004', 'MK012'),
(15, 'A', 'Kamis', 'B502', 'admin2', '2025-04-10 22:27:00', 'D001', 'MK003'),
(16, 'D', 'Jumat', 'C307', 'admin', '2025-04-10 22:27:14', 'D002', 'MK008'),
(17, 'A', 'Sabtu', 'C504', 'admin2', '2025-04-10 22:30:03', 'D005', 'MK009'),
(18, 'B', 'Rabu', 'C504', 'admin2', '2025-04-10 22:30:43', 'D006', 'MK009'),
(19, 'A', 'Selasa', 'C503', 'admin2', '2025-04-10 22:31:40', 'D004', 'MK011');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','dosen','mahasiswa') NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `nim` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `nama`, `nik`, `nim`) VALUES
(1, 'admin', '$2y$10$8xB7chSk8viZKlheU1ToA.20UwChY.uronroZWUVUD01J.iwxRyLG', 'admin', 'Admin User', NULL, NULL),
(11, 'admin2', '$2y$10$TPJqX7E2ptKAZuzdNBs.wuR/S.ltxQqeWJN67x5njpyaISCpmK/uq', 'admin', '', NULL, NULL),
(13, 'samuelhutagalung', '$2y$10$Fx98YFk3dI.Jz13xgGQcBeBm9wbPvN4yk43KFLwlBVP3eI8C/xWDu', 'dosen', '', 'D001', NULL),
(14, 'nabilahusna', '$2y$10$uB2YRhqgYingBWIZ7DerrOxAiELYqxgtiPSZTIjDWBmSCslHRrglu', 'dosen', '', 'D002', NULL),
(15, 'wirawanistiono', '$2y$10$mQ/bvefHgNPDEC4sNBlqJ.0UEtvgE5TQ.k8p8wny.XwGa/bvjFh92', 'dosen', '', 'D003', NULL),
(16, 'monicapratiwi', '$2y$10$oYCRgJ39Bz48Rd8eweSk9Oy7LhmSKjfvUVtHGLI3nYwcyP7b3HgB2', 'dosen', '', 'D004', NULL),
(17, 'bombardirocrocodilo', '$2y$10$Tgm4pZCOTX4UZWtKsoJQNu2mr2gQiwuzHKujWGSEgAtfOuUVfxpce', 'dosen', '', 'D005', NULL),
(18, 'khadafiwow', '$2y$10$M9WEBZfkOw/z.XNrHNqzWedIMd.Vlw6jdJxkeUo4FLkkizZw0WL4S', 'dosen', '', 'D006', NULL),
(20, 'deswandywong', '$2y$10$jWNaK90tEd7ObvTDyAUYhuESvNqv6bo8Qc/OAw9xWdUAUAcq0nNwa', 'mahasiswa', '', NULL, 'M001'),
(21, 'fredericktheodore', '$2y$10$abGQ9tD1nxvxm0R0dhMQw.T5oZNPHo8nDtrs8FNBBe.UMIze2bWfK', 'mahasiswa', '', NULL, 'M002'),
(22, 'valleriealexanderputra', '$2y$10$9udl5wM8uhf01fqbNV56KOdO9Lvf5tbSe4ItPd/E6qk43cSH.3tj.', 'mahasiswa', '', NULL, 'M003'),
(23, 'christietjong', '$2y$10$9xz1KygZY/GbXA36I9Fbje63eGbkIW3Ii0uXB5nwd4UGKz5F1qzRq', 'mahasiswa', '', NULL, 'M004'),
(25, 'pargondamaryun', '$2y$10$wGB5UEcLeu2zbOcvZtLr8e.hD7V4dDyzNcicbANiGE5v9WYMBo8SS', 'mahasiswa', '', NULL, 'M005'),
(26, 'leonyfransisca', '$2y$10$F60mI0lsUcpBS2E1E6VwAeP0wPTzxM.jEYW21WT/KUSqnJB7.CU2.', 'mahasiswa', '', NULL, 'M006'),
(27, 'jonathantimothy', '$2y$10$ddWswkrp1U./6pTLvZEK9u0m5hv53bIGZcyauTSGentU2LX0.QGJm', 'mahasiswa', '', NULL, 'M007'),
(28, 'richie', '$2y$10$DHQ0PSbwSXBFZAX9jQVLI.YJq6lOLcoCW5X8fwv7pEF8N/N6d0cfi', 'mahasiswa', '', NULL, 'M008'),
(29, 'carvelino', '$2y$10$Ec17TSCU3A1Ln0FoVyAgJebr7RdW1AYnOOfUfmIIpcGdHqlNXkx3K', 'mahasiswa', '', NULL, 'M009'),
(30, 'kevinsanjaya', '$2y$10$2dstElcygX2blbpRnNPibe2g1M8uUo8vWJfZ7aq2YaWm4XM84TnUm', 'mahasiswa', '', NULL, 'M010'),
(31, 'bambangpamungkas', '$2y$10$12zMkoghFpdPKrS2ExgQV.mnaVSKAbrPeEYqKxAy.8Ier1WFMgK1K', 'mahasiswa', '', NULL, 'M011'),
(32, 'lebronjames', '$2y$10$y1b9iE7tTsYUITB35ul1Dup/yT.MpO3Ukibl.kWkvNB/WfPdiuVv.', 'mahasiswa', '', NULL, 'M012'),
(34, 'tralalelotralala', '$2y$10$/DaKrOY6Jj/k/YSZfWLup.J9TCr78dHEI9Y/THCJNoqPF6g8f1mO6', 'mahasiswa', '', NULL, 'M013'),
(36, 'nobeljoseph', '$2y$10$ojbCLaZoja0cyEYbdwBSG.Rjrt7dgulQBRg54LdPWgFEXasJdvfjq', 'mahasiswa', '', NULL, 'M015'),
(37, 'chandrakurniasantoso', '$2y$10$ZeLXiqRfsMvl/piLqEqyNuRS9EfFetEurndPP5Nhm.REtZX6nWcgW', 'mahasiswa', '', NULL, 'M016'),
(38, 'jessica', '$2y$10$wMJbcmOG9ZdYsLd0ZoxRIuNrhPzv/Jy1rn7Aa2PtIO3187FrYTCXO', 'mahasiswa', '', NULL, 'M017'),
(39, 'christian', '$2y$10$PknPOEJ1B8LHNDUnc9Qc7OFWb4jocGld7V59o2cXnnr6DBeoch.0G', 'mahasiswa', '', NULL, 'M018'),
(40, 'christoper', '$2y$10$JAM1c.qj6fI8yI6sdW/2MeoF13QVRdf3qxJz00Qof1zBEcS6A9BLy', 'mahasiswa', '', NULL, 'M019'),
(41, 'bryan', '$2y$10$QjJgoVfzN1QJLb8RkBgw0.iLgNTPInYSxebPM8bL4yvztteFDDP6u', 'mahasiswa', '', NULL, 'M020'),
(42, 'patrick', '$2y$10$7Jo43x3a66V/vcndDATG.eRzeiFKYNt/aL3R0tQ8BOMxJI2rdyti.', 'mahasiswa', '', NULL, 'M021'),
(43, 'clarkkent', '$2y$10$GsF/o7C1fuMVPITh3BZt2.gchnfQ8.v7HgTHOD3/fiEHwQDQPn64C', 'mahasiswa', '', NULL, 'M022'),
(44, 'robert', '$2y$10$Kos8nPtPC4U4s2W6ANE1XuvGGNVRi1k8pkOPiViEDMHM5muZU193m', 'mahasiswa', '', NULL, 'M023'),
(45, 'brucewayne', '$2y$10$zVadhoQIFMcn6ocpwGO67.aL0Fz/McRSc7ZjH0jLp8ZzrNJ3jv7NK', 'mahasiswa', '', NULL, 'M024'),
(46, 'apung', '$2y$10$2ntoLzAcgdIIz56GWIkRueuGy5w/BL00y/b1Sbd5W7Kpg0k1xkSkS', 'mahasiswa', '', NULL, 'M025'),
(47, 'tonystark', '$2y$10$ZKaE3.w6ACTPHg2woeqIfu6DF8RpW0QROpYlMcKpdrZLlIVm5jSBS', 'mahasiswa', '', NULL, 'M026'),
(48, 'abun', '$2y$10$UVxW1bibnBZcbmvo3ZiY.emSkmaItgUZd.VBajYFgXPNNtNiC8SeC', 'mahasiswa', '', NULL, 'M027'),
(49, 'steverogers', '$2y$10$QkoETsW4ibEa2xhASkrnk.l.HTw.H2NyOkeEvwQZWXvAln.ECbmr6', 'mahasiswa', '', NULL, 'M028'),
(50, 'ketungsahoor', '$2y$10$f.lt9Q8fhi8mD6UxiTK.weOv.4dzKuBh//F2GD4PDij4nqO1VOi/u', 'mahasiswa', '', NULL, 'M029'),
(51, 'aliong', '$2y$10$27AF0BUdbBGumEpff6RwZe5qx43MslfT11Z1JLYIsI2Omw6BlZw2S', 'mahasiswa', '', NULL, 'M030'),
(52, 'flintbarton', '$2y$10$Iry14aPrijPTllJC7rdNQOIZ2bOtof6kYneQ56mzd6C167BUGjCae', 'mahasiswa', '', NULL, 'M031'),
(53, 'petirparkir', '$2y$10$U02XucHNS7qnz35d.lyxV.vlXuF8N5NQ3Teph0M3JMiGvTPgS7sem', 'mahasiswa', '', NULL, 'M032');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`nik`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`nim`);

--
-- Indexes for table `matakuliah`
--
ALTER TABLE `matakuliah`
  ADD PRIMARY KEY (`kode_matkul`);

--
-- Indexes for table `trx_krs`
--
ALTER TABLE `trx_krs`
  ADD PRIMARY KEY (`id_trx_krs`),
  ADD KEY `trx_krs_ibfk_1` (`id_trx_matkul`),
  ADD KEY `trx_krs_ibfk_2` (`nim`);

--
-- Indexes for table `trx_matkul`
--
ALTER TABLE `trx_matkul`
  ADD PRIMARY KEY (`id_trx_matkul`),
  ADD KEY `fk_trx_dosen` (`nik`),
  ADD KEY `fk_trx_matakuliah` (`kode_matkul`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `fk_user_dosen` (`nik`),
  ADD KEY `fk_user_mahasiswa` (`nim`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `trx_krs`
--
ALTER TABLE `trx_krs`
  MODIFY `id_trx_krs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `trx_matkul`
--
ALTER TABLE `trx_matkul`
  MODIFY `id_trx_matkul` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `trx_krs`
--
ALTER TABLE `trx_krs`
  ADD CONSTRAINT `trx_krs_ibfk_1` FOREIGN KEY (`id_trx_matkul`) REFERENCES `trx_matkul` (`id_trx_matkul`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `trx_krs_ibfk_2` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `trx_matkul`
--
ALTER TABLE `trx_matkul`
  ADD CONSTRAINT `fk_trx_dosen` FOREIGN KEY (`nik`) REFERENCES `dosen` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_trx_matakuliah` FOREIGN KEY (`kode_matkul`) REFERENCES `matakuliah` (`kode_matkul`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_dosen` FOREIGN KEY (`nik`) REFERENCES `dosen` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_mahasiswa` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
