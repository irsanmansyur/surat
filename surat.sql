-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2020 at 01:43 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `surat`
--

-- --------------------------------------------------------

--
-- Table structure for table `mst_divisi`
--

CREATE TABLE `mst_divisi` (
  `id_divisi` int(11) NOT NULL,
  `nama_divisi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_divisi`
--

INSERT INTO `mst_divisi` (`id_divisi`, `nama_divisi`) VALUES
(1, 'Marketing'),
(2, 'IT'),
(3, 'OB');

-- --------------------------------------------------------

--
-- Table structure for table `mst_jabatan`
--

CREATE TABLE `mst_jabatan` (
  `id_jabatan` int(11) NOT NULL,
  `nama_jabatan` text NOT NULL,
  `id_divisi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_jabatan`
--

INSERT INTO `mst_jabatan` (`id_jabatan`, `nama_jabatan`, `id_divisi`) VALUES
(1, 'Kepala Marketing', 1),
(2, 'Senior Programmer', 2),
(3, 'Kepala OB', 3);

-- --------------------------------------------------------

--
-- Table structure for table `mst_kat_surat`
--

CREATE TABLE `mst_kat_surat` (
  `id_kat_surat` int(11) NOT NULL,
  `kategori` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_kat_surat`
--

INSERT INTO `mst_kat_surat` (`id_kat_surat`, `kategori`) VALUES
(1, 'Surat Masuk'),
(2, 'Surat Keluar');

-- --------------------------------------------------------

--
-- Table structure for table `mst_surat`
--

CREATE TABLE `mst_surat` (
  `id_surat` int(11) NOT NULL,
  `kode_surat` text NOT NULL,
  `kategori_surat` text NOT NULL,
  `jenis_surat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_surat`
--

INSERT INTO `mst_surat` (`id_surat`, `kode_surat`, `kategori_surat`, `jenis_surat`) VALUES
(1, 'SUR-032020001', 'Surat Masuk', 'Dari instansi luar'),
(2, 'SUR-032020002', 'Surat Keluar', 'Untuk Internal'),
(3, 'SUR-032020003', 'Surat Keluar', 'Untuk External');

-- --------------------------------------------------------

--
-- Table structure for table `mst_user`
--

CREATE TABLE `mst_user` (
  `id` int(11) NOT NULL,
  `nama` text NOT NULL,
  `email` varchar(250) NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` text NOT NULL,
  `level` text NOT NULL,
  `image` varchar(250) NOT NULL,
  `date_created` date NOT NULL,
  `is_active` int(2) NOT NULL,
  `nip` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_user`
--

INSERT INTO `mst_user` (`id`, `nama`, `email`, `username`, `password`, `level`, `image`, `date_created`, `is_active`, `nip`) VALUES
(1, 'Indra', 'ata.adonia@gmail.com', 'admin', '$2y$10$Fu4wp6uWIOdEPOIpkSXxouzwI1syhygCmFMqedNI1baUxrPJ2LHRC', 'Admin', 'avatar55.png', '2019-08-06', 1, 0),
(6, 'agus marketing', 'marketing@agus.com', 'agusmar', '$2y$10$uB0tyenphV3ocy75GzKpYu1eu9edSaIT9WqwMJtUYw9glFtddpZry', 'User', 'avatar0431.png', '2020-03-03', 1, 11111),
(7, 'agus programer', 'agus@programer.com', 'aguspro', '$2y$10$ElxSSUHIrBZX5lEbCh2Eg..Frrlz.CGjspViIsp4BVt95DSjPobVm', 'User', 'avatar1.png', '2020-03-03', 1, 22222);

-- --------------------------------------------------------

--
-- Table structure for table `tb_berkas`
--

CREATE TABLE `tb_berkas` (
  `id_berkas` int(11) NOT NULL,
  `sess_id` int(11) NOT NULL,
  `kd_berkas` text NOT NULL,
  `tuj_berkas` text NOT NULL,
  `nama_berkas` text NOT NULL,
  `tgl_berkas` date NOT NULL,
  `pesan` text NOT NULL,
  `file_upload` varchar(250) NOT NULL,
  `status_berkas` int(1) NOT NULL,
  `jenis_surat` int(11) NOT NULL,
  `perihal` text NOT NULL,
  `tembusan` text DEFAULT NULL,
  `id_template` int(11) NOT NULL,
  `sifat` varchar(100) NOT NULL,
  `lampiran` varchar(100) NOT NULL,
  `nama_penerima` varchar(100) NOT NULL,
  `ttd` varchar(100) NOT NULL,
  `nip_penerima` int(11) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `pangkat` varchar(100) NOT NULL,
  `telpon` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_berkas`
--

INSERT INTO `tb_berkas` (`id_berkas`, `sess_id`, `kd_berkas`, `tuj_berkas`, `nama_berkas`, `tgl_berkas`, `pesan`, `file_upload`, `status_berkas`, `jenis_surat`, `perihal`, `tembusan`, `id_template`, `sifat`, `lampiran`, `nama_penerima`, `ttd`, `nip_penerima`, `jabatan`, `pangkat`, `telpon`) VALUES
(1, 6, 'FILES/03032020/001', '2', 'berkas masuk dari luar', '2020-03-03', '<p>wqeqwe</p>\r\n', '', 0, 1, 'kumaha aing', '', 2, 'tertutup', 'test lampiran', '', 'avatar2_(1)2.png', 0, 'senior programer', 'III X', ''),
(2, 6, 'FILES/03032020/002', '2', 'surat keluar internal', '2020-03-03', '<p><strong>test keluar internal</strong></p>\r\n', '', 0, 2, 'test surat keluar internal', '', 2, 'test keluar internal', 'terlampir', '', 'avatar3.png', 0, '', '', ''),
(3, 6, 'FILES/03032020/003', '2', 'surat keluar external', '2020-03-03', '<p>jalan jalan keluar yuk</p>\r\n', '', 0, 3, 'jalan jalan lah', '', 2, 'penting gak penting', 'cobalah jalan jalan', '', 'avatar042.png', 0, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_chat`
--

CREATE TABLE `tb_chat` (
  `id_chat` int(11) NOT NULL,
  `id_divisi` int(11) NOT NULL,
  `pesan` text NOT NULL,
  `hash` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_chat`
--

INSERT INTO `tb_chat` (`id_chat`, `id_divisi`, `pesan`, `hash`) VALUES
(1, 2, 'gus rapat', 58790083),
(2, 2, 'iyo mas', 58790083);

-- --------------------------------------------------------

--
-- Table structure for table `tb_notif`
--

CREATE TABLE `tb_notif` (
  `id_notif` int(11) NOT NULL,
  `pesan` varchar(100) NOT NULL,
  `id_divisi` int(11) NOT NULL,
  `waktu` datetime NOT NULL,
  `status_baca` int(11) NOT NULL,
  `id_berkas` int(11) NOT NULL,
  `id_chat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_notif`
--

INSERT INTO `tb_notif` (`id_notif`, `pesan`, `id_divisi`, `waktu`, `status_baca`, `id_berkas`, `id_chat`) VALUES
(1, 'Ada Berkas Baru Masuk', 2, '0000-00-00 00:00:00', 1, 1, 0),
(2, 'Ada Berkas Baru Masuk', 2, '0000-00-00 00:00:00', 1, 2, 0),
(3, 'Ada Berkas Baru Masuk', 2, '0000-00-00 00:00:00', 1, 4, 0),
(4, 'Ada Berkas Baru Masuk', 2, '0000-00-00 00:00:00', 1, 5, 0),
(5, 'Ada Berkas Baru Masuk', 2, '0000-00-00 00:00:00', 1, 1, 0),
(6, 'Ada Berkas Baru Masuk', 2, '0000-00-00 00:00:00', 1, 2, 0),
(7, 'Ada Berkas Baru Masuk', 2, '0000-00-00 00:00:00', 1, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_notif_chat`
--

CREATE TABLE `tb_notif_chat` (
  `id_nchat` int(11) NOT NULL,
  `hash` int(11) NOT NULL,
  `pesan` varchar(50) NOT NULL,
  `id_divisi` int(11) NOT NULL,
  `status_baca` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_notif_chat`
--

INSERT INTO `tb_notif_chat` (`id_nchat`, `hash`, `pesan`, `id_divisi`, `status_baca`) VALUES
(1, 58790083, 'gus rapat', 2, 1),
(2, 58790083, 'iyo mas', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_struktural`
--

CREATE TABLE `tb_struktural` (
  `id_struktur` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `kode_pegawai` text NOT NULL,
  `nama_pegawai` text NOT NULL,
  `jabatan_nm` text NOT NULL,
  `divisi_nm` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_struktural`
--

INSERT INTO `tb_struktural` (`id_struktur`, `user_id`, `kode_pegawai`, `nama_pegawai`, `jabatan_nm`, `divisi_nm`) VALUES
(1, 6, '0320200001', 'agus marketing', '1', '1'),
(2, 7, '0320200002', 'agus programer', '2', '2');

-- --------------------------------------------------------

--
-- Table structure for table `tb_surat`
--

CREATE TABLE `tb_surat` (
  `id_tb_surat` int(11) NOT NULL,
  `sess_id` int(11) NOT NULL,
  `jns_surat` text NOT NULL,
  `kd_surat` text NOT NULL,
  `no_surat` text NOT NULL,
  `tuj_surat` text NOT NULL,
  `tgl_surat` date NOT NULL,
  `isi_surat` text NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mst_divisi`
--
ALTER TABLE `mst_divisi`
  ADD PRIMARY KEY (`id_divisi`);

--
-- Indexes for table `mst_jabatan`
--
ALTER TABLE `mst_jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indexes for table `mst_kat_surat`
--
ALTER TABLE `mst_kat_surat`
  ADD PRIMARY KEY (`id_kat_surat`);

--
-- Indexes for table `mst_surat`
--
ALTER TABLE `mst_surat`
  ADD PRIMARY KEY (`id_surat`);

--
-- Indexes for table `mst_user`
--
ALTER TABLE `mst_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_berkas`
--
ALTER TABLE `tb_berkas`
  ADD PRIMARY KEY (`id_berkas`);

--
-- Indexes for table `tb_chat`
--
ALTER TABLE `tb_chat`
  ADD PRIMARY KEY (`id_chat`);

--
-- Indexes for table `tb_notif`
--
ALTER TABLE `tb_notif`
  ADD PRIMARY KEY (`id_notif`);

--
-- Indexes for table `tb_notif_chat`
--
ALTER TABLE `tb_notif_chat`
  ADD PRIMARY KEY (`id_nchat`);

--
-- Indexes for table `tb_struktural`
--
ALTER TABLE `tb_struktural`
  ADD PRIMARY KEY (`id_struktur`);

--
-- Indexes for table `tb_surat`
--
ALTER TABLE `tb_surat`
  ADD PRIMARY KEY (`id_tb_surat`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mst_divisi`
--
ALTER TABLE `mst_divisi`
  MODIFY `id_divisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mst_jabatan`
--
ALTER TABLE `mst_jabatan`
  MODIFY `id_jabatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mst_kat_surat`
--
ALTER TABLE `mst_kat_surat`
  MODIFY `id_kat_surat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mst_surat`
--
ALTER TABLE `mst_surat`
  MODIFY `id_surat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mst_user`
--
ALTER TABLE `mst_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_berkas`
--
ALTER TABLE `tb_berkas`
  MODIFY `id_berkas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_chat`
--
ALTER TABLE `tb_chat`
  MODIFY `id_chat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_notif`
--
ALTER TABLE `tb_notif`
  MODIFY `id_notif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_notif_chat`
--
ALTER TABLE `tb_notif_chat`
  MODIFY `id_nchat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_struktural`
--
ALTER TABLE `tb_struktural`
  MODIFY `id_struktur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_surat`
--
ALTER TABLE `tb_surat`
  MODIFY `id_tb_surat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
