-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2025 at 04:13 PM
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
-- Database: `toko`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_pemesanan`
--

DROP TABLE IF EXISTS `detail_pemesanan`;
CREATE TABLE `detail_pemesanan` (
  `id` int(11) NOT NULL,
  `id_pemesanan` int(11) DEFAULT NULL,
  `id_produk` varchar(50) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `sub_total` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


--
-- Dumping data for table `detail_pemesanan`
--

INSERT INTO `detail_pemesanan` (`id`, `id_pemesanan`, `id_produk`, `jumlah`, `sub_total`) VALUES
(1, 1, 'AKH11Z', 1, 175000),
(2, 2, 'AKH11Z', 1, 175000),
(3, 3, 'AKH11Z', 1, 175000),
(4, 4, 'AKH11Z', 1, 175000),
(5, 5, 'AKH11Z', 5, 875000),
(6, 5, 'AKP10X', 1, 150000);

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

DROP TABLE IF EXISTS `keranjang`;
CREATE TABLE `keranjang` (
  `id` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_produk` varchar(50) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

DROP TABLE IF EXISTS `pesanan`;
CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `metode_pembayaran` enum('cod','qris') DEFAULT NULL,
  `status` enum('menunggu','diproses','selesai','dikirim') DEFAULT 'menunggu',
  `total` decimal(10,2) DEFAULT NULL,
  `bukti_transfer` varchar(255) DEFAULT NULL,
  `waktu_upload` datetime DEFAULT NULL,
  `status_pembayaran` enum('belum_dibayar','menunggu_verifikasi','terverifikasi') DEFAULT 'belum_dibayar',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id`, `user_id`, `tanggal`, `metode_pembayaran`, `status`, `total`, `bukti_transfer`, `waktu_upload`, `status_pembayaran`) VALUES
(1, 2, '2025-07-08 02:43:30', 'cod', 'selesai', 175000.00, NULL, NULL, 'belum_dibayar'),
(2, 5, '2025-07-17 17:40:40', 'qris', 'menunggu', 175000.00, '', NULL, 'belum_dibayar'),
(3, 5, '2025-07-17 18:11:05', 'qris', 'menunggu', 175000.00, '', NULL, 'belum_dibayar'),
(4, 5, '2025-07-17 18:16:37', 'qris', 'menunggu', 175000.00, '', NULL, 'belum_dibayar'),
(5, 2, '2025-07-19 16:03:04', 'qris', 'selesai', 1025000.00, '1752917000_Screenshot 2025-07-19 160330.png', '2025-07-19 11:23:20', 'belum_dibayar');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

DROP TABLE IF EXISTS `produk`;
CREATE TABLE `produk` (
  `id` varchar(50) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  primary key (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `nama`, `deskripsi`, `harga`, `stok`, `gambar`) VALUES
('AKH11Z', 'Headset Wireless', 'Bluetooth v5.0, noise cancelling', 175000, 10, 'headset_wireless.jpeg'),
('AKP10X', 'Power Bank 10000mAh', 'Dual output USB, casing aluminium', 150000, 15, 'Power_Bank.jpeg'),
('AKS22Y', 'Speaker Bluetooth', 'Bass kuat, daya 10W, tahan air', 250000, 10, 'Cuplikan layar 2025-07-08 002326.png'),
('PCK01A', 'Keyboard Mechanical', 'RGB, switch biru, cocok gaming', 350000, 10, 'Keyboard_Mechanical.jpg'),
('PCM21B', 'Mouse Wireless', 'Desain ergonomis, sensor presisi', 120000, 12, 'Mouse_Wireless.jpg'),
('RTB07K', 'Blender Mini', 'Portable, cocok untuk jus buah', 200000, 10, 'Blender_Mini.jpg'),
('RTK09P', 'Kipas Angin', '3 tingkat kecepatan, hemat daya', 150000, 10, 'Kipas_Angin.jpg'),
('RTR18N', 'Rice Cooker', '1.8 liter, anti lengket', 300000, 10, 'Rice_Cooker.jpg'),
('RTS12M', 'Setrika Uap', 'Anti lengket, hemat listrik', 180000, 10, 'Setrika_Uap.jpg'),
('SP1A20', 'Smartphone A10', 'Layar 6.5 inci, kamera 50MP, RAM 4GB', 2200000, 10, 'smartphone_A10.jpg'),
('SP2B30', 'Smartphone B20', 'Baterai 5000mAh, penyimpanan 128GB', 2800000, 10, 'Smartphone_B20.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  primary key (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`) VALUES
(1, 'Admin', 'admin@gmail.com', 'admin123', 'admin'),
(2, 'User', 'user@gmail.com', 'user123', 'user'),
(5, 'kevin', 'kevin@gmail.com', '123', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_pemesanan`
--
ALTER TABLE `detail_pemesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
