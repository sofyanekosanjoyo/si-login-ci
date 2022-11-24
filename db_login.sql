-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2022 at 03:49 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_login`
--

-- --------------------------------------------------------

--
-- Table structure for table `level_user`
--

CREATE TABLE `level_user` (
  `id` int(11) NOT NULL,
  `level` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `level_user`
--

INSERT INTO `level_user` (`id`, `level`) VALUES
(1, 'Administrator'),
(2, 'Member');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `foto` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `id_level` int(11) NOT NULL,
  `status_aktifasi` varchar(16) NOT NULL,
  `tanggal_dibuat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `email`, `foto`, `password`, `id_level`, `status_aktifasi`, `tanggal_dibuat`) VALUES
(5, 'Sofyan Eko Sanjoyo', 'sofyanekosanjoyo@pu.go.id', 'WIN_20221108_08_32_36_Pro.jpg', '$2y$10$5c3vqFFMK2BCNHXtuuV1KeUhW7HmGns0LybHcCfC3XzIuTN6VdhL.', 1, 'Aktif', 1668931180),
(6, 'Lisna Agustina Paramitha', 'lisnaagustinaparamitha@gmail.com', 'lisna.jpg', '$2y$10$jrweTJFsAhrM8Y69MIVQ2.7LNeLUD.L7kWTKj4Dsr3GsFB.wU6Wb6', 2, 'Aktif', 1668932230),
(7, 'Yurike Mitha Sari', 'mitha@gmail.com', 'default.jpg', '$2y$10$fsgkjUuCB/r3jbQAS.iz6OXlUXKk5zQ8zj.93gQOwxMPA8C4CP/z6', 2, 'Tidak Aktif', 1669196840),
(19, 'CPNS Ditjen SDA 2021', 'cpnsdditjensdapupr2021@gmail.com', 'default.jpg', '$2y$10$mXOncjlg4DsFhnM//O7xJOES9n/J9b.aYKEVP9bIpQG1KS3J9zfaq', 2, 'Tidak Aktif', 1669220153),
(20, 'Sofyan Gmail Com', 'sofyanekosanjoyo@gmail.com', 'default.jpg', '$2y$10$aWQ72gI8aW4I65sS5ZTRvuG87aoARUuB/yAg4duKlJpUZqer0TQ0a', 2, 'Aktif', 1669253108);

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `id_level` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `id_level`, `id_menu`) VALUES
(1, 1, 1),
(3, 2, 2),
(57, 1, 2),
(58, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(1, 'Admin'),
(2, 'User'),
(3, 'Menu');

-- --------------------------------------------------------

--
-- Table structure for table `user_submenu`
--

CREATE TABLE `user_submenu` (
  `id` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `judul` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `status_aktifasi` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_submenu`
--

INSERT INTO `user_submenu` (`id`, `id_menu`, `judul`, `url`, `icon`, `status_aktifasi`) VALUES
(1, 1, 'Dashboard', 'admin', 'fas fa-fw fa-tachometer-alt', 'Aktif'),
(2, 2, 'Profil User', 'user', 'fas fa-fw fa-user', 'Aktif'),
(3, 2, 'Edit Profil', 'user/editprofil', 'fas fa-fw fa-user-edit', 'Aktif'),
(4, 3, 'Manajemen Menu', 'menu', 'fas fa-fw fa-folder', 'Aktif'),
(5, 3, 'Manajemen Submenu', 'menu/submenu', 'fas fa-fw fa-folder-open', 'Aktif'),
(7, 1, 'Akses Menu', 'admin/akses_menu', 'fa fa-fw fa-users', 'Aktif'),
(8, 2, 'Ubah Password', 'user/ubahpassword', 'fas fa-fw fa-key', 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `email` varchar(64) NOT NULL,
  `token` varchar(128) NOT NULL,
  `tanggal_dibuat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_token`
--

INSERT INTO `user_token` (`id`, `email`, `token`, `tanggal_dibuat`) VALUES
(3, 'cpnsditjensdapupr2021@gmail.com', 'WWe/e2bmLusTTZKjSRcgPZABkH8uRpGumojkdxU0Iew=', 1669203607),
(10, 'sofyanekosanjoyo@outlook.com', 'SbjSEd+9LdxjZklp2vO9O9+QrQ/MENLrEkERKqC3fIA=', 1669219467),
(11, 'sofyanekosanjoyo@outlook.com', 'CAaFEgGuOzuhUgckslxENryrkXYZOlQgHXC5o30v+64=', 1669219557),
(12, 'cpnsdditjensdapupr2021@gmail.com', 's9L9y5UisY/4TEn/yMoCm4fZsSNnwPSTnJLjVp7ILd8=', 1669220153),
(19, 'sofyanekosanjoyo@pu.go.id', 'C5O/rWb7u0aPHDro8NBwQqWyKJ2R6dZSkJOWMvoOAAg=', 1669257389),
(20, 'sofyanekosanjoyo@pu.go.id', 'mI8v/DnxbZ0gLDRhZcsRndjPEjGM3wqFdFlAoDzgi40=', 1669257963);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `level_user`
--
ALTER TABLE `level_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_submenu`
--
ALTER TABLE `user_submenu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `level_user`
--
ALTER TABLE `level_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_submenu`
--
ALTER TABLE `user_submenu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
