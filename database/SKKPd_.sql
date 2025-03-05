-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 05, 2025 at 08:12 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `SKKPd_RPL2`
--

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE `jurusan` (
  `Id_Jurusan` char(2) NOT NULL,
  `Jurusan` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jurusan`
--

INSERT INTO `jurusan` (`Id_Jurusan`, `Jurusan`) VALUES
('J1', 'RPL'),
('J2', 'TKJ'),
('J3', 'AN'),
('J4', 'DKV'),
('J5', 'BD');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `Id_Kategori` char(7) NOT NULL,
  `Kategori` enum('Wajib','Opsional') NOT NULL,
  `Sub_Kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`Id_Kategori`, `Kategori`, `Sub_Kategori`) VALUES
('KTG01', 'Wajib', 'Kurikulum Merdeka Project P5'),
('KTG02', 'Opsional', 'Perlombaan /Kejuaraan/ Kompetisi'),
('KTG03', 'Opsional', 'Komunitas Kreatif Siswa'),
('KTG04', 'Wajib', 'Ekstra Kurikuler'),
('KTG05', 'Opsional', 'TEFA (Teaching Factory)'),
('KTG06', 'Opsional', 'Penalaran / Karya Ilmiah / Akademik'),
('KTG07', 'Opsional', 'Lainnya'),
('KTG08', 'Opsional', 'Penalaran / Organisasi Sekolah');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `Id_Kegiatan` int(5) NOT NULL,
  `Jenis_Kegiatan` varchar(50) NOT NULL,
  `Angka_Kredit` int(2) NOT NULL,
  `Id_Kategori` char(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kegiatan`
--

INSERT INTO `kegiatan` (`Id_Kegiatan`, `Jenis_Kegiatan`, `Angka_Kredit`, `Id_Kategori`) VALUES
(1, 'Project Gaya Hidup Berkelajutan', 34, 'KTG01'),
(2, 'Project Kebekerjaan', 1, 'KTG01'),
(3, 'Project Bhineka Tunggal Ika', 1, 'KTG01'),
(4, 'Juara 1 Internasional', 7, 'KTG02'),
(5, 'Harapan 2 Nasional', 2, 'KTG02'),
(6, 'Juara 1 Internal Sekolah', 3, 'KTG02'),
(7, 'Wakil Ketua Rohis', 5, 'KTG03'),
(8, 'Sekretaris Osis', 7, 'KTG03'),
(10, 'Project Baru', 2, 'KTG01'),
(11, 'Ketua Rohis', 3, 'KTG03'),
(13, 'Project Bersama', 4, 'KTG01'),
(24, 'Bendahara Rohis', 3, 'KTG03'),
(25, 'Bendahara Sehati', 5, 'KTG08');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `Nama_Lengkap` varchar(50) NOT NULL,
  `Username` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`Nama_Lengkap`, `Username`) VALUES
('kadek arie', 'ariewira'),
('Putu Yenni Suryantari, S.Pd', 'yenny');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `Id_Pengguna` int(11) NOT NULL,
  `Username` varchar(20) DEFAULT NULL,
  `NIS` int(5) DEFAULT NULL,
  `Password` varchar(65) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`Id_Pengguna`, `Username`, `NIS`, `Password`) VALUES
(1, 'yenny', NULL, '$2y$10$OK2BhpKRsHihc3HUAdeeyO.RV5l/YvPZnFSUz/dnkRvO4AWMo3zxK'),
(2, NULL, 7024, '$2y$10$FUvorhWpoMbVjULHYw8XBu5RH843b69rtK38gvtbu2UUwWEUdInmG'),
(3, NULL, 7025, 'siswa5556'),
(4, NULL, 7026, 'siswa5557'),
(5, NULL, 7027, 'siswa5558'),
(6, NULL, 7028, 'siswa5559'),
(7, NULL, 7029, 'siswa5560'),
(8, NULL, 7030, 'siswa5561'),
(9, NULL, 7031, 'siswa5562'),
(10, NULL, 7032, 'siswa5563'),
(11, NULL, 7033, 'siswa5564'),
(14, 'ariewira', NULL, '$2y$10$URGp92DP6ZFZISd7yl5EQO3m1dIvN/LozA5l1Eios.VI/Oods3x1a');

-- --------------------------------------------------------

--
-- Table structure for table `sertifikat`
--

CREATE TABLE `sertifikat` (
  `Id_Sertifikat` int(11) NOT NULL,
  `Tanggal_Upload` date NOT NULL,
  `Catatan` varchar(100) DEFAULT NULL,
  `Sertifikat` varchar(150) NOT NULL,
  `Status` varchar(20) NOT NULL,
  `Tanggal_Status_Berubah` date DEFAULT NULL,
  `NIS` int(5) NOT NULL,
  `Id_Kegiatan` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sertifikat`
--

INSERT INTO `sertifikat` (`Id_Sertifikat`, `Tanggal_Upload`, `Catatan`, `Sertifikat`, `Status`, `Tanggal_Status_Berubah`, `NIS`, `Id_Kegiatan`) VALUES
(1, '2024-12-22', NULL, 'sertif1.pdf', 'Valid', '2025-01-11', 7024, 1),
(2, '2024-12-22', NULL, 'sertif2.pdf', 'Valid', '2025-01-11', 7024, 2),
(3, '2024-12-22', NULL, 'sertif3.pdf', 'Valid', '2025-01-11', 7024, 3),
(4, '2024-12-23', NULL, 'sertif4.pdf', 'Valid', '2025-01-12', 7025, 2),
(5, '2024-12-24', NULL, 'sertif5.pdf', 'Valid', '2025-01-13', 7025, 2),
(6, '2024-12-24', NULL, 'sertif6.pdf', 'Valid', '2025-01-13', 7026, 3),
(7, '2024-12-25', NULL, 'sertif7.pdf', 'Valid', '2025-01-14', 7027, 1),
(8, '2024-12-25', NULL, 'sertif8.pdf', 'Valid', '2025-01-14', 7027, 3),
(9, '2024-12-25', 'mnantap', 'sertif9.pdf', 'Tidak Valid', '2025-02-28', 7027, 2),
(10, '2024-12-26', NULL, 'sertif10.pdf', 'Valid', '2025-02-27', 7028, 2),
(11, '2024-12-27', 'salah file', 'sertif1.pdf', 'Tidak Valid', '2025-02-27', 7029, 1),
(12, '2024-12-25', NULL, 'sertif2.pdf', 'Menunggu Validasi', '2025-02-24', 7029, 2),
(13, '2024-12-27', NULL, 'sertif3.pdf', 'Valid', '2025-01-16', 7029, 4),
(14, '2024-12-28', NULL, 'sertif4.pdf', 'Valid', '2025-01-17', 7030, 5),
(15, '2024-12-29', 'Perbaiki dokumen', 'sertif5.pdf', 'Tidak Valid', '2025-01-18', 7031, 6),
(16, '2024-12-30', NULL, 'sertif6.pdf', 'Valid', '2025-01-19', 7032, 7),
(17, '2024-12-31', NULL, 'sertif7.pdf', 'Valid', '2025-01-20', 7033, 8),
(19, '2025-02-28', 'hmmm', '7024wi7jh.pdf', 'Menunggu Validasi', '2025-03-02', 7024, 4),
(20, '2025-03-01', 'salah lagii', 'vjtpz.pdf', 'Menunggu Validasi', '2025-03-02', 7024, 2),
(21, '2025-03-01', 'catat', '7024t1kiq.pdf', 'Menunggu Validasi', '2025-03-02', 7024, 1),
(22, '2025-03-01', 'test', '7024d9e7r.pdf', 'Menunggu Validasi', '2025-03-02', 7024, 1),
(23, '2025-03-02', 'asasadaskdas', '7024bquks.pdf', 'Menunggu Validasi', '2025-03-02', 7024, 13),
(24, '2025-03-02', NULL, '7024ymd93.pdf', 'Menunggu Validasi', NULL, 7024, 8);

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `NIS` int(5) NOT NULL,
  `No_Absen` int(2) NOT NULL,
  `Nama_Siswa` varchar(50) NOT NULL,
  `No_Telp` varchar(15) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Id_Jurusan` char(2) NOT NULL,
  `Kelas` int(3) NOT NULL,
  `Angkatan` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`NIS`, `No_Absen`, `Nama_Siswa`, `No_Telp`, `Email`, `Id_Jurusan`, `Kelas`, `Angkatan`) VALUES
(7024, 2, 'Agus Satya Pardede', '62-856-555-519', 'satya111@gmail.com', 'J1', 2, 2024),
(7025, 2, 'Pantai', '62-878-555-382', 'andin@gmail.com', 'J1', 1, 2024),
(7026, 3, 'Gede Ardi Dharma Putra', '62-878-555-383', 'ardida863@gmail.com', 'J1', 1, 2024),
(7027, 4, 'Gede Dhairya Aditama', '62-878-555-384', 'dhair08@gmail.com', 'J1', 1, 2024),
(7028, 5, 'Ghazy Maulana Pratama', '62-878-555-385', 'maulana@gmail.com', 'J1', 2, 2024),
(7029, 6, 'Gusti Ngurah Agung Setiawan', '62-878-555-386', 'agungsetiawa4@gmail.com', 'J2', 3, 2024),
(7030, 7, 'I Gusti Ngurah Andhika Diputra', '62-878-555-387', 'diputra@gmail.com', 'J2', 3, 2023),
(7031, 8, 'I Gusti Ngurah Arya Wiguna', '62-878-555-388', 'yogi33@gmail.com', 'J4', 5, 2023),
(7032, 9, 'I Kadek Abiyogi Mandala Satyaki', '62-878-555-389', 'manda24@gmail.com', 'J4', 2, 2023),
(7033, 10, 'I Kadek Bayu Wiradinata', '62-878-555-390', 'wiraw32@gmail.com', 'J4', 2, 2023);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`Id_Jurusan`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`Id_Kategori`);

--
-- Indexes for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`Id_Kegiatan`),
  ADD KEY `FK_kegiatan_kategori` (`Id_Kategori`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`Username`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`Id_Pengguna`),
  ADD KEY `FK_pengguna_pegawai` (`Username`),
  ADD KEY `FK_pengguna_siswa` (`NIS`);

--
-- Indexes for table `sertifikat`
--
ALTER TABLE `sertifikat`
  ADD PRIMARY KEY (`Id_Sertifikat`),
  ADD KEY `FK_sertifikat_siswa` (`NIS`),
  ADD KEY `FK_sertifikat_kegiatan` (`Id_Kegiatan`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`NIS`),
  ADD KEY `FK_siswa_jurusan` (`Id_Jurusan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `Id_Kegiatan` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `Id_Pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `sertifikat`
--
ALTER TABLE `sertifikat`
  MODIFY `Id_Sertifikat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD CONSTRAINT `FK_kegiatan_kategori` FOREIGN KEY (`Id_Kategori`) REFERENCES `kategori` (`Id_Kategori`);

--
-- Constraints for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD CONSTRAINT `FK_pengguna_pegawai` FOREIGN KEY (`Username`) REFERENCES `pegawai` (`Username`),
  ADD CONSTRAINT `FK_pengguna_siswa` FOREIGN KEY (`NIS`) REFERENCES `siswa` (`NIS`);

--
-- Constraints for table `sertifikat`
--
ALTER TABLE `sertifikat`
  ADD CONSTRAINT `FK_sertifikat_kegiatan` FOREIGN KEY (`Id_Kegiatan`) REFERENCES `kegiatan` (`Id_Kegiatan`),
  ADD CONSTRAINT `FK_sertifikat_siswa` FOREIGN KEY (`NIS`) REFERENCES `siswa` (`NIS`);

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `FK_siswa_jurusan` FOREIGN KEY (`Id_Jurusan`) REFERENCES `jurusan` (`Id_Jurusan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
