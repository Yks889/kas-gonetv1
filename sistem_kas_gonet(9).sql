-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 21, 2025 at 02:51 AM
-- Server version: 8.0.43-0ubuntu0.22.04.2
-- PHP Version: 8.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistem_kas_gonet`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `activity` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `ip_address` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_general_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `role`, `activity`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES
(283, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '2025-09-25 03:34:09'),
(284, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '2025-09-25 04:59:29'),
(285, 9, 'admin', 'menambah kas masuk', 'Menambahkan kas masuk Rp 100000000 (keterangan: tes)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '2025-09-25 05:45:50'),
(286, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '2025-09-26 03:02:59'),
(287, 9, 'admin', 'pengajuan', 'Membuat pengajuan baru dengan nominal Rp 1,000,000', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '2025-09-26 03:04:52'),
(288, 9, 'admin', 'kas_keluar', 'Menggunakan uang sendiri untuk pengajuan Rp 1,000,000', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '2025-09-26 03:04:52'),
(289, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 48', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '2025-09-26 03:04:58'),
(290, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan uang sendiri ID 48', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '2025-09-26 03:05:06'),
(291, 9, 'admin', 'update_kas_keluar', 'Mengubah kas keluar & pengajuan ID 48 dari Rp 1000000.00 menjadi Rp 10000000, status: , deadline: 2025-09-26, keterangan: .', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '2025-09-26 03:06:44'),
(292, 9, 'admin', 'menambah kas masuk', 'Menambahkan kas masuk Rp 20000000 (keterangan: .)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '2025-09-26 04:04:25'),
(293, 9, 'admin', 'menambah kas masuk', 'Menambahkan kas masuk Rp 1000000000 (keterangan: .)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '2025-09-26 04:04:50'),
(294, 9, 'admin', 'menghapus kas masuk', 'Menghapus kas masuk ID 21 (nominal: Rp 1000000000.00, keterangan: .)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '2025-09-26 04:18:52'),
(295, 9, 'admin', 'menghapus kas masuk', 'Menghapus kas masuk ID 20 (nominal: Rp 20000000.00, keterangan: .)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '2025-09-26 06:27:37'),
(296, 9, 'admin', 'delete_kas_keluar', 'Menghapus kas keluar & pengajuan ID 48 (nominal: Rp 10000000.00, status: selesai, keterangan: .)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '2025-09-26 07:17:55'),
(297, 9, 'admin', 'pengajuan', 'Membuat pengajuan baru dengan nominal Rp 1,000,000', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '2025-09-26 07:23:51'),
(298, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 49', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '2025-09-26 07:24:07'),
(299, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan minta_uang ID 49 dengan upload nota', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '2025-09-26 07:24:23'),
(300, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 02:42:04'),
(301, 9, 'admin', 'delete_kas_keluar', 'Menghapus kas keluar & pengajuan ID 49 (nominal: Rp 1000000.00, status: selesai, keterangan: tes)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 02:42:25'),
(304, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 02:50:51'),
(307, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 02:52:31'),
(309, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 03:03:53'),
(311, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 03:08:11'),
(313, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 03:31:41'),
(314, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 04:10:09'),
(316, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 04:20:30'),
(322, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 04:25:06'),
(323, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 51', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 04:25:11'),
(324, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan uang sendiri ID 51', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 04:25:13'),
(325, 9, 'admin', 'menambah kas masuk', 'Menambahkan kas masuk Rp 5000000000 (keterangan: halo\r\n)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 04:26:26'),
(326, 9, 'admin', 'update_kas_masuk', 'Mengubah kas masuk ID 22 dari Rp 5000000000.00 menjadi Rp 50000000 (keterangan: halo\r\n)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 06:36:37'),
(327, 9, 'admin', 'menghapus kas masuk', 'Menghapus kas masuk ID 19 (nominal: Rp 100000000.00, keterangan: tes)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 06:37:08'),
(328, 9, 'admin', 'menambah kas masuk', 'Menambahkan kas masuk Rp 500000000 (keterangan: halo)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 06:37:45'),
(329, 9, 'admin', 'delete_kas_keluar', 'Menghapus kas keluar & pengajuan ID 51 (nominal: Rp 200000000.00, status: selesai, keterangan: tes)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 06:39:35'),
(330, 9, 'admin', 'menghapus kas masuk', 'Menghapus kas masuk ID 23 (nominal: Rp 500000000.00, keterangan: halo)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 06:39:49'),
(331, 9, 'admin', 'menambah kas masuk', 'Menambahkan kas masuk Rp 300000000 (keterangan: halo\r\n)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 06:41:58'),
(333, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 06:46:48'),
(334, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 50', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 06:46:53'),
(335, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan minta_uang ID 50 dengan upload nota', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 06:47:05'),
(337, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 07:15:41'),
(338, 9, 'admin', 'pengajuan', 'Membuat pengajuan baru dengan nominal Rp 1,000,000,000', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 07:17:45'),
(339, 9, 'admin', 'kas_keluar', 'Menggunakan uang sendiri untuk pengajuan Rp 1,000,000,000', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 07:17:45'),
(343, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 07:18:34'),
(344, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 53', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 07:19:01'),
(345, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan uang sendiri ID 53', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 07:19:09'),
(350, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 07:24:41'),
(351, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 54', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 07:24:47'),
(352, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan uang sendiri ID 54', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 07:24:51'),
(353, 9, 'admin', 'pengajuan ditolak', 'Menolak pengajuan ID 52', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 08:10:24'),
(354, 9, 'admin', 'delete_kas_keluar', 'Menghapus kas keluar & pengajuan ID 52 (nominal: Rp 1000000000.00, status: ditolak, keterangan: tes)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 08:10:32'),
(355, 9, 'admin', 'delete_kas_keluar', 'Menghapus kas keluar & pengajuan ID 50 (nominal: Rp 1000000.00, status: selesai, keterangan: res)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 08:11:24'),
(356, 9, 'admin', 'delete_kas_keluar', 'Menghapus kas keluar & pengajuan ID 53 (nominal: Rp 3000000.00, status: selesai, keterangan: tes)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 08:11:26'),
(357, 9, 'admin', 'delete_kas_keluar', 'Menghapus kas keluar & pengajuan ID 54 (nominal: Rp 300000000.00, status: selesai, keterangan: tes)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 08:11:35'),
(358, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 08:32:15'),
(359, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 08:32:38'),
(360, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 08:32:47'),
(364, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-09-30 08:35:55'),
(365, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-01 04:30:26'),
(366, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-01 04:30:39'),
(369, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-01 04:30:53'),
(370, 9, 'admin', 'menambah kas masuk', 'Menambahkan kas masuk Rp 20000000 (keterangan: tes)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-01 04:52:49'),
(371, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 55', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-01 04:57:39'),
(372, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan minta_uang ID 55 dengan upload nota', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-01 04:57:51'),
(373, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-01 05:25:30'),
(374, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-01 05:25:35'),
(375, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-01 07:29:01'),
(376, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-01 07:42:02'),
(379, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-01 07:47:53'),
(380, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-01 08:15:58'),
(385, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-01 08:16:28'),
(386, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 56', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-01 08:16:30'),
(387, 9, 'admin', 'menambah kas masuk', 'Menambahkan kas masuk Rp 123123213 (keterangan: asdsadas)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-01 08:16:44'),
(388, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan uang sendiri ID 56', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-01 08:16:54'),
(389, 9, 'admin', 'menghapus kas masuk', 'Menghapus kas masuk ID 26 (nominal: Rp 123123213.00, keterangan: asdsadas)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-01 08:17:09'),
(390, 9, 'admin', 'menghapus kas masuk', 'Menghapus kas masuk ID 25 (nominal: Rp 20000000.00, keterangan: tes)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-01 08:17:22'),
(391, 9, 'admin', 'menambah kas masuk', 'Menambahkan kas masuk Rp 20000000 (keterangan: tes)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-01 08:19:52'),
(392, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-02 02:59:06'),
(395, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 57', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-02 02:59:41'),
(396, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-02 03:09:55'),
(397, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan minta_uang ID 57 dengan upload nota', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-02 03:10:08'),
(398, 9, 'admin', 'delete_kas_keluar', 'Menghapus kas keluar & pengajuan ID 55 (nominal: Rp 1000000.00, status: selesai, keterangan: .)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-02 03:10:26'),
(399, 9, 'admin', 'delete_kas_keluar', 'Menghapus kas keluar & pengajuan ID 56 (nominal: Rp 1000000.00, status: selesai, keterangan: sadasd)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-02 03:10:34'),
(400, 9, 'admin', 'delete_kas_keluar', 'Menghapus kas keluar & pengajuan ID 57 (nominal: Rp 1000000.00, status: selesai, keterangan: tes)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-02 03:10:45'),
(401, 9, 'admin', 'menghapus kas masuk', 'Menghapus kas masuk ID 27 (nominal: Rp 20000000.00, keterangan: tes)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-02 03:11:01'),
(402, 9, 'admin', 'menambah kas masuk', 'Menambahkan kas masuk Rp 100000 (keterangan: tes)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-02 04:47:18'),
(406, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-02 05:35:40'),
(407, 9, 'admin', 'update_kas_masuk', 'Mengubah kas masuk ID 28 dari Rp 100000.00 menjadi Rp 100000 (keterangan: tes)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-02 06:09:02'),
(408, 9, 'admin', 'update_kas_masuk', 'Mengubah kas masuk ID 28 dari Rp 100000.00 menjadi Rp 10000000 (keterangan: tes)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-02 06:09:28'),
(409, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 58', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-02 06:10:08'),
(410, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan uang sendiri ID 58', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-02 06:10:13'),
(411, 9, 'admin', 'menambah kas masuk', 'Menambahkan kas masuk Rp 10000000 (keterangan: tes)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-02 06:10:51'),
(412, 9, 'admin', 'update_kas_masuk', 'Mengubah kas masuk ID 29 dari Rp 10000000.00 menjadi Rp 10000000 (keterangan: tes22)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-02 06:16:09'),
(413, 9, 'admin', 'update_kas_keluar', 'Mengubah kas keluar & pengajuan ID 58 dari Rp 10000.00 menjadi Rp 1000000, status: , deadline: 2025-10-02, keterangan: rwsd', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-02 06:21:44'),
(414, 9, 'admin', 'update_kas_keluar', 'Mengubah kas keluar & pengajuan ID 58 dari Rp 1000000.00 menjadi Rp 1000000, status: , deadline: 2025-10-01, keterangan: rwsd', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-02 06:22:35'),
(415, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-03 07:24:22'),
(416, 9, 'admin', 'delete_kas_keluar', 'Menghapus kas keluar & pengajuan ID 58 (nominal: Rp 1000000.00, status: selesai, keterangan: rwsd)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-03 07:36:05'),
(417, 9, 'admin', 'menghapus kas masuk', 'Menghapus kas masuk ID 29 (nominal: Rp 10000000.00, keterangan: tes22)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-03 07:36:10'),
(418, 9, 'admin', 'menghapus kas masuk', 'Menghapus kas masuk ID 28 (nominal: Rp 10000000.00, keterangan: tes)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-03 07:36:12'),
(419, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-03 07:36:17'),
(424, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-03 07:38:00'),
(425, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 59', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-03 07:38:05'),
(426, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan uang sendiri ID 59', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-03 07:38:14'),
(427, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 02:38:26'),
(428, 9, 'admin', 'menambah kas masuk', 'Menambahkan kas masuk Rp 200000000 (keterangan: tes)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 02:38:50'),
(429, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 02:39:47'),
(432, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 02:48:12'),
(433, 9, 'admin', 'menghapus kas masuk', 'Menghapus kas masuk ID 30 (nominal: Rp 200000000.00, keterangan: tes)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 02:48:19'),
(434, 9, 'admin', 'delete_kas_keluar', 'Menghapus kas keluar & pengajuan ID 59 (nominal: Rp 100000000.00, status: selesai, keterangan: halo)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 02:48:24'),
(435, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 02:49:08'),
(441, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 02:58:21'),
(442, 9, 'admin', 'pengajuan ditolak', 'Menolak pengajuan ID 62', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 02:59:11'),
(443, 9, 'admin', 'pengajuan ditolak', 'Menolak pengajuan ID 61', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 02:59:13'),
(444, 9, 'admin', 'pengajuan ditolak', 'Menolak pengajuan ID 60', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 02:59:15'),
(445, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 02:59:24'),
(448, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 03:11:14'),
(449, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 03:13:00'),
(450, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 03:13:06'),
(451, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 03:13:10'),
(457, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 03:49:19'),
(458, 9, 'admin', 'menambah kas masuk', 'Menambahkan kas masuk Rp 200000000 (keterangan: yes)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 03:49:43'),
(459, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 03:49:44'),
(464, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 03:51:39'),
(465, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 63', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 04:08:09'),
(466, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan uang sendiri ID 63', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 04:08:19'),
(467, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 04:12:42'),
(470, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 04:17:14'),
(471, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 04:17:55'),
(474, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 04:18:21'),
(475, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 04:40:44'),
(478, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 04:41:57'),
(479, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 05:53:29'),
(482, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 05:55:29'),
(483, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 06:27:10'),
(488, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 06:29:47'),
(489, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 06:35:52'),
(494, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 06:36:38'),
(495, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 66', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 06:36:46'),
(496, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan uang sendiri ID 66', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 06:36:48'),
(497, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 65', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 06:48:06'),
(498, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan minta_uang ID 65 dengan upload nota', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-06 06:48:19'),
(499, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-07 02:58:53'),
(500, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-07 05:17:52'),
(503, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-07 05:18:58'),
(504, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-07 06:34:13'),
(507, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-07 08:23:33'),
(508, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-10 02:42:10'),
(509, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-10 02:55:55'),
(510, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-10 03:10:33'),
(513, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-10 03:16:39'),
(514, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-10 03:26:44'),
(518, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-10 03:27:42'),
(519, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 67', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-10 03:28:13'),
(520, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan minta_uang ID 67 dengan upload nota', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-10 03:28:31'),
(524, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-10 03:43:36'),
(525, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 68', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-10 03:43:47'),
(526, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan minta_uang ID 68 dengan upload nota', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-10 04:21:21'),
(527, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-10 05:16:06'),
(529, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-13 02:44:46'),
(530, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-13 02:46:19'),
(533, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-13 03:12:08'),
(534, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-13 05:18:01'),
(539, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-13 05:18:54'),
(540, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 69', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-13 05:19:06'),
(541, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan uang sendiri ID 69', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-13 05:19:45'),
(542, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-13 05:20:03'),
(546, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-13 05:20:44'),
(547, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 70', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-13 05:20:49'),
(548, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan minta_uang ID 70 dengan upload nota', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-13 05:21:19'),
(549, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-13 05:21:57'),
(555, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-13 05:22:42'),
(556, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 71', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-13 05:23:10'),
(557, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan uang sendiri ID 71', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-13 05:23:41'),
(558, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-13 05:25:23'),
(559, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-15 02:28:17'),
(560, 9, 'admin', 'delete_kas_keluar', 'Menghapus kas keluar & pengajuan ID 65 (nominal: Rp 20000000.00, status: selesai, keterangan: dshfsdferf)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-15 04:58:36'),
(561, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 72', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-15 05:16:12'),
(562, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan minta_uang ID 72 dengan upload nota', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-15 05:16:26'),
(563, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-15 06:09:32'),
(564, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-16 03:19:05'),
(565, 9, 'admin', 'menambah kas masuk', 'Menambahkan kas masuk Rp 100000000 (keterangan: aku salam)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-16 03:35:26'),
(566, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 64', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-16 03:35:37'),
(567, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan minta_uang ID 64 dengan upload nota', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-16 03:35:54'),
(568, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-20 02:13:45'),
(569, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-20 08:07:30'),
(570, 9, 'admin', 'update_kas_keluar', 'Mengubah kas keluar & pengajuan ID 64 dari Rp 160000000.00 menjadi Rp 160000000, status: , deadline: 2025-10-05, keterangan: wrwerwer', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-20 08:14:04'),
(571, 9, 'admin', 'menghapus kas masuk', 'Menghapus kas masuk ID 32 (nominal: Rp 100000000.00, keterangan: aku salam)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-20 08:35:19'),
(572, 9, 'admin', 'menghapus kas masuk', 'Menghapus kas masuk ID 31 (nominal: Rp 200000000.00, keterangan: yes)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-20 08:35:21'),
(573, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-20 08:40:08'),
(576, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-20 08:41:02'),
(577, 9, 'admin', 'menambah kas masuk', 'Menambahkan kas masuk Rp 20000000 (keterangan: tes)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-20 08:41:19'),
(578, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-20 08:41:25'),
(587, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-20 08:46:24'),
(588, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 75', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-20 08:48:47'),
(589, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan uang sendiri ID 75', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-20 09:02:57'),
(590, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 74', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-20 09:11:45'),
(591, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan uang sendiri ID 74', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-20 09:11:50'),
(592, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 73', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-20 09:16:14'),
(593, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan uang sendiri ID 73', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-20 09:16:19'),
(594, 9, 'admin', 'menambah kas masuk', 'Menambahkan kas masuk Rp 100000000000 (keterangan: untuk jen)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-20 09:24:23'),
(595, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-22 02:54:16'),
(596, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-22 02:57:07'),
(597, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-22 02:57:11'),
(598, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-22 02:59:56'),
(599, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-22 03:00:04'),
(600, 9, 'admin', 'menghapus kas masuk', 'Menghapus kas masuk ID 34 (nominal: Rp 100000000000.00, keterangan: untuk jen)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-22 03:00:12'),
(601, 9, 'admin', 'update_kas_keluar', 'Mengubah kas keluar & pengajuan ID 74 dari Rp 1000000.00 menjadi Rp 1000000, status: , deadline: , keterangan: tes2', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-22 03:09:58'),
(602, 9, 'admin', 'update_kas_keluar', 'Mengubah kas keluar & pengajuan ID 74 dari Rp 1000000.00 menjadi Rp 1000000, status: , deadline: , keterangan: tes', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-22 03:10:04'),
(603, 9, 'admin', 'update_kas_keluar', 'Mengubah kas keluar & pengajuan ID 74 dari Rp 1000000.00 menjadi Rp 1000000, status: , deadline: , keterangan: tes1213123', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-22 03:10:10'),
(604, 9, 'admin', 'update_kas_keluar', 'Mengubah kas keluar & pengajuan ID 74 dari Rp 1000000.00 menjadi Rp 10000000, status: , deadline: , keterangan: tes1213123', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0', '2025-10-22 03:10:19'),
(605, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-10-22 07:36:46'),
(606, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-10-22 07:54:04'),
(611, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-10-22 07:54:40'),
(612, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 76', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-10-22 07:54:53'),
(613, 9, 'admin', 'pengajuan dibatalkan', 'Membatalkan pengajuan ID 76', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-10-22 08:24:31'),
(614, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-10-23 02:28:39'),
(615, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-10-23 02:29:16'),
(620, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-10-23 02:30:01'),
(621, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-10-24 02:53:21'),
(622, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 77', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-10-24 02:54:50'),
(623, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-11 02:43:58'),
(624, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 02:36:32'),
(625, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 03:35:02'),
(626, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 05:21:18'),
(627, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan uang sendiri ID 77', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 08:01:42'),
(628, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 08:02:23'),
(632, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 08:05:02'),
(633, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 78', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 08:05:12'),
(634, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan minta_uang ID 78 dengan upload nota', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 08:05:47'),
(635, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 08:09:29'),
(638, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 08:10:02'),
(639, 9, 'admin', 'update_photo', 'User mengubah foto profil', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 08:24:35'),
(640, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 08:25:09'),
(644, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 08:25:44'),
(645, 9, 'admin', 'change_password', 'User mengubah password', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 08:27:51'),
(646, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 08:27:55'),
(647, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 08:28:06'),
(648, 9, 'admin', 'update_profile', 'User memperbarui profil', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 08:30:27'),
(649, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 08:30:36'),
(650, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 08:30:47'),
(651, 9, 'admin', 'update_profile', 'User memperbarui profil', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 08:30:57'),
(652, 9, 'admin', 'update_profile', 'User memperbarui profil', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 08:31:37'),
(653, 9, 'admin', 'update_profile', 'User memperbarui profil', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 08:32:53'),
(654, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 08:40:31'),
(655, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 08:42:08'),
(656, 9, 'admin', 'change_password', 'User mengubah password', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 08:42:27'),
(657, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 08:42:33'),
(658, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 08:42:38'),
(659, 9, 'admin', 'remove_photo', 'User menghapus foto profil', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 08:42:59'),
(660, 9, 'admin', 'update_photo', 'User mengubah foto profil', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 08:51:21'),
(661, 9, 'admin', 'update_profile', 'User memperbarui profil', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 08:57:32'),
(662, 9, 'admin', 'change_password', 'User mengubah password', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 08:57:59'),
(663, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 08:58:02'),
(664, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 08:58:30'),
(665, 9, 'admin', 'change_password', 'User mengubah password', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 08:58:55'),
(666, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 08:58:58'),
(667, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 08:59:21'),
(668, 9, 'admin', 'update_profile', 'User memperbarui profil', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 09:00:39'),
(669, 9, 'admin', 'change_password', 'User mengubah password', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 09:01:01'),
(670, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 09:01:04'),
(671, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 09:01:25'),
(672, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-14 09:09:57'),
(673, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-17 02:52:45'),
(674, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-17 02:54:17'),
(675, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-17 03:50:04'),
(676, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-17 04:11:47'),
(677, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-17 04:11:59'),
(678, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-17 07:27:16'),
(681, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-17 07:27:43'),
(682, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 02:51:04'),
(683, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 03:07:31'),
(684, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 03:07:36'),
(685, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 03:07:38'),
(689, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 03:08:25'),
(690, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 79', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 03:08:31'),
(691, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan minta_uang ID 79 dengan upload nota', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 03:08:56'),
(692, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 03:09:24'),
(697, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 03:09:57'),
(698, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 80', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 03:10:04'),
(699, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 03:11:23'),
(702, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 03:12:04'),
(703, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 03:28:23');
INSERT INTO `activity_logs` (`id`, `user_id`, `role`, `activity`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES
(707, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 03:28:50'),
(708, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 81', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 03:29:00'),
(709, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan minta_uang ID 81 dengan upload nota', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 03:29:14'),
(710, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 03:29:29'),
(714, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 03:30:06'),
(715, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 82', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 03:30:11'),
(716, 9, 'admin', 'pengajuan dibatalkan', 'Membatalkan pengajuan ID 82 (Tipe: minta_uang)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 03:30:13'),
(717, 9, 'admin', 'pengajuan dibatalkan', 'Membatalkan pengajuan ID 80 (Tipe: uang_sendiri)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 03:30:21'),
(718, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 03:34:18'),
(724, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 03:34:55'),
(725, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 84', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 03:35:01'),
(726, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 83', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 03:35:04'),
(727, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan minta_uang ID 84 dengan upload nota', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 03:36:10'),
(728, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 03:38:22'),
(733, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 03:42:09'),
(734, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 03:43:13'),
(735, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 03:44:34'),
(736, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 03:45:09'),
(737, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 03:46:09'),
(738, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 03:48:18'),
(739, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 04:07:31'),
(740, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 04:08:19'),
(743, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 04:09:17'),
(744, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 04:09:45'),
(745, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 04:12:33'),
(746, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 04:20:51'),
(749, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 04:25:53'),
(750, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 04:25:55'),
(755, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 04:34:59'),
(756, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 04:36:53'),
(759, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 04:45:49'),
(760, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 04:45:51'),
(845, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 05:40:42'),
(846, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 06:58:45'),
(847, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 06:58:49'),
(848, 9, 'admin', 'menghapus kas masuk', 'Menghapus kas masuk ID 33 (nominal: Rp 20000000.00, keterangan: tes)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 07:33:15'),
(849, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 07:47:34'),
(854, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 07:48:44'),
(855, 9, 'admin', 'menambah kas masuk', 'Menambahkan kas masuk Rp 20000000 (keterangan: tes)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 07:49:01'),
(856, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 07:49:06'),
(865, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 07:50:19'),
(866, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 88', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 07:50:29'),
(867, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan minta_uang ID 88 dengan upload nota', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 07:50:39'),
(868, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 87', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 07:51:36'),
(869, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan minta_uang ID 87 dengan upload nota', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 07:51:53'),
(870, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 07:52:19'),
(871, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 07:53:16'),
(872, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 08:10:37'),
(877, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 08:11:08'),
(878, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 89', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 08:11:16'),
(879, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan uang sendiri ID 89', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 08:11:24'),
(880, 9, 'admin', 'menghapus kas masuk', 'Menghapus kas masuk ID 35 (nominal: Rp 20000000.00, keterangan: tes)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 08:25:53'),
(881, 9, 'admin', 'menambah kas masuk', 'Menambahkan kas masuk Rp 20000000 (keterangan: tes)', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 08:26:06'),
(882, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 08:26:10'),
(883, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 08:27:15'),
(884, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 08:27:27'),
(889, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 08:28:06'),
(890, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 91', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 08:28:14'),
(891, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan minta_uang ID 91 dengan upload nota', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-18 08:28:23'),
(892, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-19 03:07:41'),
(893, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-19 03:10:46'),
(896, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-19 03:11:19'),
(897, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-19 03:11:35'),
(902, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-19 03:12:24'),
(903, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-19 04:52:36'),
(907, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-19 04:56:55'),
(908, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 92', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-19 04:57:11'),
(909, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan minta_uang ID 92 dengan upload nota', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-19 04:57:22'),
(910, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-19 06:35:45'),
(915, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-19 06:36:23'),
(916, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 93', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-19 06:36:34'),
(917, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan uang sendiri ID 93', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-19 06:36:37'),
(918, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-19 07:51:42'),
(919, 26, 'user', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-19 07:51:45'),
(920, 26, 'user', 'pengajuan', 'Membuat pengajuan baru sebesar Rp 31.231', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-19 07:52:10'),
(921, 26, 'user', 'kas_keluar', 'Menggunakan uang sendiri untuk pengajuan sebesar Rp 31.231', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-19 07:52:10'),
(922, 26, 'user', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-19 07:52:12'),
(923, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-19 07:52:18'),
(924, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 94', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-19 07:52:42'),
(925, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan uang sendiri ID 94', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-19 07:52:45'),
(926, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-19 07:54:44'),
(927, 26, 'user', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-19 07:54:48'),
(928, 26, 'user', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-19 07:58:48'),
(929, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-19 07:58:53'),
(930, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-19 08:17:22'),
(931, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-19 08:23:08'),
(932, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-19 08:27:15'),
(933, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-19 09:05:33'),
(934, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-20 03:06:35'),
(935, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-20 03:24:21'),
(936, 27, 'user', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-20 03:24:28'),
(937, 27, 'user', 'pengajuan', 'Membuat pengajuan baru sebesar Rp 123.123', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-20 03:25:09'),
(938, 27, 'user', 'kas_keluar', 'Menggunakan uang sendiri untuk pengajuan sebesar Rp 123.123', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-20 03:25:09'),
(939, 27, 'user', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-20 03:25:10'),
(940, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-20 03:25:15'),
(941, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 95', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-20 03:25:40'),
(942, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan uang sendiri ID 95', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-20 03:25:42'),
(943, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-20 04:33:08'),
(944, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-20 04:33:14'),
(945, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-20 04:34:11'),
(946, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-20 04:35:10'),
(947, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-20 05:10:02'),
(948, 34, 'user', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-20 05:10:06'),
(949, 34, 'user', 'pengajuan', 'Membuat pengajuan baru sebesar Rp 324.234', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-20 05:10:34'),
(950, 34, 'user', 'kas_keluar', 'Menggunakan uang sendiri untuk pengajuan sebesar Rp 324.234', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-20 05:10:34'),
(951, 34, 'user', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-20 05:10:35'),
(952, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-20 05:10:55'),
(953, 9, 'admin', 'pengajuan diterima', 'Menyetujui pengajuan ID 96', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-20 05:14:52'),
(954, 9, 'admin', 'pengajuan diproses', 'Memproses pengajuan uang sendiri ID 96', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-20 05:14:54'),
(955, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-20 05:15:29'),
(956, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-20 05:16:01'),
(957, 9, 'admin', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-20 05:16:23'),
(958, 35, 'user', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-20 05:16:27'),
(959, 35, 'user', 'logout', 'User logout dari sistem', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-20 05:19:12'),
(960, 9, 'admin', 'login', 'User berhasil login', '::1', 'Mozilla/5.0 (X11; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', '2025-11-20 05:19:17');

-- --------------------------------------------------------

--
-- Table structure for table `kas_keluar`
--

CREATE TABLE `kas_keluar` (
  `id` int NOT NULL,
  `pengajuan_id` int DEFAULT NULL,
  `nominal` decimal(15,2) NOT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci,
  `file_nota` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kas_keluar`
--

INSERT INTO `kas_keluar` (`id`, `pengajuan_id`, `nominal`, `keterangan`, `file_nota`, `created_at`, `updated_at`, `deleted_at`) VALUES
(82, 94, '31231.00', 'sadasd', '1763538730_c6a96be112d994dde940.jpeg', '2025-11-19 07:52:10', '2025-11-19 07:52:10', NULL),
(83, 95, '123123.00', 'hasdasd', '1763609109_4f3f3f0732a96a037283.jpeg', '2025-11-20 03:25:09', '2025-11-20 03:25:09', NULL),
(84, 96, '324234.00', 'dasdad', '1763615434_4a4c8ebaf4385261b9b1.jpeg', '2025-11-20 05:10:34', '2025-11-20 05:10:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kas_masuk`
--

CREATE TABLE `kas_masuk` (
  `id` int NOT NULL,
  `nominal` decimal(15,2) NOT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kas_masuk`
--

INSERT INTO `kas_masuk` (`id`, `nominal`, `keterangan`, `created_at`, `updated_at`) VALUES
(36, '20000000.00', 'tes', '2025-11-18 08:26:06', '2025-11-18 08:26:06');

-- --------------------------------------------------------

--
-- Table structure for table `kas_saldo`
--

CREATE TABLE `kas_saldo` (
  `id` int NOT NULL,
  `saldo_akhir` decimal(15,2) DEFAULT '0.00',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kas_saldo`
--

INSERT INTO `kas_saldo` (`id`, `saldo_akhir`, `updated_at`) VALUES
(9, '19363845.00', '2025-11-20 12:14:54');

-- --------------------------------------------------------

--
-- Table structure for table `kas_saldo_log`
--

CREATE TABLE `kas_saldo_log` (
  `id` int NOT NULL,
  `kas_masuk_id` int DEFAULT NULL,
  `kas_keluar_id` int DEFAULT NULL,
  `nominal` decimal(15,2) NOT NULL,
  `tipe` enum('masuk','keluar') COLLATE utf8mb4_general_ci NOT NULL,
  `saldo_sebelum` decimal(15,2) NOT NULL,
  `saldo_sesudah` decimal(15,2) NOT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(44, 9, 'Pengajuan kas Anda telah disetujui.', 0, '2025-09-23 08:29:21', '2025-09-23 08:29:21'),
(45, 9, 'Pengajuan kas Anda telah disetujui.', 0, '2025-09-23 08:30:27', '2025-09-23 08:30:27'),
(46, 9, 'Pengajuan kas Anda telah disetujui.', 0, '2025-09-23 08:33:36', '2025-09-23 08:33:36'),
(47, 9, 'Pengajuan kas Anda telah disetujui.', 0, '2025-09-23 08:45:50', '2025-09-23 08:45:50'),
(48, 9, 'Pengajuan kas Anda telah disetujui.', 0, '2025-09-23 08:47:15', '2025-09-23 08:47:15'),
(49, 9, 'Pengajuan kas Anda telah disetujui.', 0, '2025-09-23 08:49:18', '2025-09-23 08:49:18'),
(50, 9, 'Pengajuan kas Anda telah disetujui.', 0, '2025-09-23 08:50:12', '2025-09-23 08:50:12'),
(51, 9, 'Pengajuan kas Anda telah disetujui.', 0, '2025-09-23 08:50:35', '2025-09-23 08:50:35'),
(52, 9, 'Pengajuan kas Anda telah disetujui.', 0, '2025-09-24 02:59:38', '2025-09-24 02:59:38'),
(53, 9, 'Pengajuan kas Anda telah disetujui.', 0, '2025-09-24 03:00:05', '2025-09-24 03:00:05'),
(54, 9, 'Pengajuan kas Anda telah disetujui.', 0, '2025-09-24 03:06:06', '2025-09-24 03:06:06'),
(55, 9, 'Pengajuan kas Anda telah disetujui.', 0, '2025-09-24 03:07:31', '2025-09-24 03:07:31'),
(56, 9, 'Pengajuan kas Anda telah disetujui.', 0, '2025-09-26 03:04:58', '2025-09-26 03:04:58'),
(57, 9, 'Pengajuan kas Anda telah disetujui.', 0, '2025-09-26 07:24:07', '2025-09-26 07:24:07'),
(62, 9, 'Pengajuan kas Anda ditolak.', 0, '2025-09-30 08:10:24', '2025-09-30 08:10:24');

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan`
--

CREATE TABLE `pengajuan` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `nominal` decimal(15,2) NOT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci,
  `tipe` enum('uang_sendiri','minta_uang') COLLATE utf8mb4_general_ci DEFAULT 'minta_uang',
  `status` enum('pending','selesai','diterima','ditolak','dibatalkan') COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `confirm_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengajuan`
--

INSERT INTO `pengajuan` (`id`, `user_id`, `nominal`, `keterangan`, `tipe`, `status`, `confirm_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(94, 26, '31231.00', 'sadasd', 'uang_sendiri', 'selesai', '2025-11-19 07:52:45', '2025-11-19 07:52:10', '2025-11-19 07:52:45', NULL),
(95, 27, '123123.00', 'hasdasd', 'uang_sendiri', 'selesai', '2025-11-20 03:25:42', '2025-11-20 03:25:09', '2025-11-20 03:25:53', '2025-11-20 03:25:53'),
(96, 34, '324234.00', 'dasdad', 'uang_sendiri', 'selesai', '2025-11-20 05:14:54', '2025-11-20 05:10:34', '2025-11-20 05:15:20', '2025-11-20 05:15:20');

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_files`
--

CREATE TABLE `pengajuan_files` (
  `id` int NOT NULL,
  `pengajuan_id` int NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `file_path` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
  `file_type` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `realisasi_pengajuan`
--

CREATE TABLE `realisasi_pengajuan` (
  `id` int NOT NULL,
  `pengajuan_id` int NOT NULL,
  `kas_keluar_id` int NOT NULL,
  `metode_pembayaran` enum('uang_sendiri','minta_uang') COLLATE utf8mb4_general_ci NOT NULL,
  `status_realisasi` enum('proses','selesai') COLLATE utf8mb4_general_ci DEFAULT 'proses',
  `tanggal_realisasi` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'user',
  `photo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `full_name`, `password`, `role`, `photo`, `created_at`, `updated_at`, `deleted_at`, `is_active`) VALUES
(9, 'Mas Kadimas', NULL, '$2y$10$Rr6rP1VrbRQKp6kMA5pXSOdALEiP4wmNR9JwO0vkqPKNslzqCqFti', 'admin', '1763110281_f82033e92e9a42a49a5a.jpeg', '2025-09-09 03:25:50', '2025-11-18 11:07:24', NULL, 1),
(26, 'aku1', NULL, '$2y$12$4e5c33R6/JB8mbjubDMRpuBuT0CtWcNBUf5t/kf63ZrtfVJ2lEJcm', 'user', NULL, '2025-11-19 07:51:02', '2025-11-19 07:52:57', '2025-11-19 07:52:57', 1),
(27, 'halo', NULL, '$2y$12$DtXbvj3BWrC28AXu13lRx.X2aOrn/0xM/4T.pSpnbV/D7CdNiMmlC', 'user', NULL, '2025-11-19 07:51:08', '2025-11-20 03:25:53', '2025-11-20 03:25:53', 0),
(28, 'rafi', NULL, '$2y$12$g5iaB/pjqDZ0uAj3fviGY.nQ//g5i/zgZw.r11B.0Cor2U95gMxHi', 'user', NULL, '2025-11-19 07:51:14', '2025-11-20 11:33:34', '2025-11-20 04:33:34', 0),
(29, 'syahdan', NULL, '$2y$12$U0a.heL0E7ewoJKJTzq7Me/uup498poprTESF3E/ffJmt2FRMzKOq', 'user', NULL, '2025-11-19 07:51:24', '2025-11-19 07:51:24', NULL, 1),
(30, 'user1', NULL, '$2y$12$tFGtYdWuPJG/uIcWZ4uGte1tE0VR1rthM0wlZDJ1QDaAIeNbknAqm', 'user', NULL, '2025-11-19 07:51:32', '2025-11-19 07:51:32', NULL, 1),
(31, 'tester21', NULL, '$2y$12$tcEKVHLkdjsegJB2fGhKcOVf9gW4rQ5IOPV.8LQC5EjcawB0dFtJW', 'user', NULL, '2025-11-19 07:51:39', '2025-11-20 11:33:34', '2025-11-20 04:33:34', 0),
(32, 'admin', NULL, '$2y$12$y.PhhhFN4WQNtAh3Wvg7WeLhTkZCSQhMHPXbznpp6VvvX0Jj6Bk8q', 'user', NULL, '2025-11-20 04:34:25', '2025-11-20 12:16:17', NULL, 1),
(33, 'qwerty', NULL, '$2y$12$.tI8fvT5xGSmuIrItLGOfuL1MQHsWtJF8Ovl/0qy/I4Rmw8FIEl7a', 'user', NULL, '2025-11-20 04:34:40', '2025-11-20 12:08:59', NULL, 1),
(34, 'aku77', NULL, '$2y$12$nWdC7K0gAL51Rf6Rqp3nhOTCoXK6s7x3ymW42vXH5mSDaQpSnZGgO', 'user', NULL, '2025-11-20 04:35:05', '2025-11-20 05:15:20', '2025-11-20 05:15:20', 0),
(35, 'salimnur', NULL, '$2y$12$wqyW2Ml78TuDw6CT0e1bJ.Dm94bkKEn8FdokzdIhYgfCzdFPPXi1G', 'user', NULL, '2025-11-20 05:15:47', '2025-11-20 12:16:17', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_activity_user` (`user_id`);

--
-- Indexes for table `kas_keluar`
--
ALTER TABLE `kas_keluar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengajuan_id` (`pengajuan_id`);

--
-- Indexes for table `kas_masuk`
--
ALTER TABLE `kas_masuk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kas_saldo`
--
ALTER TABLE `kas_saldo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kas_saldo_log`
--
ALTER TABLE `kas_saldo_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kas_masuk_id` (`kas_masuk_id`),
  ADD KEY `kas_keluar_id` (`kas_keluar_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pengajuan_files`
--
ALTER TABLE `pengajuan_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengajuan_id` (`pengajuan_id`);

--
-- Indexes for table `realisasi_pengajuan`
--
ALTER TABLE `realisasi_pengajuan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengajuan_id` (`pengajuan_id`),
  ADD KEY `kas_keluar_id` (`kas_keluar_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=961;

--
-- AUTO_INCREMENT for table `kas_keluar`
--
ALTER TABLE `kas_keluar`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `kas_masuk`
--
ALTER TABLE `kas_masuk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `kas_saldo`
--
ALTER TABLE `kas_saldo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kas_saldo_log`
--
ALTER TABLE `kas_saldo_log`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `pengajuan`
--
ALTER TABLE `pengajuan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `pengajuan_files`
--
ALTER TABLE `pengajuan_files`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `realisasi_pengajuan`
--
ALTER TABLE `realisasi_pengajuan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `fk_activity_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kas_keluar`
--
ALTER TABLE `kas_keluar`
  ADD CONSTRAINT `kas_keluar_ibfk_1` FOREIGN KEY (`pengajuan_id`) REFERENCES `pengajuan` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `kas_saldo_log`
--
ALTER TABLE `kas_saldo_log`
  ADD CONSTRAINT `kas_saldo_log_ibfk_1` FOREIGN KEY (`kas_masuk_id`) REFERENCES `kas_masuk` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `kas_saldo_log_ibfk_2` FOREIGN KEY (`kas_keluar_id`) REFERENCES `kas_keluar` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD CONSTRAINT `pengajuan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengajuan_files`
--
ALTER TABLE `pengajuan_files`
  ADD CONSTRAINT `pengajuan_files_ibfk_1` FOREIGN KEY (`pengajuan_id`) REFERENCES `pengajuan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `realisasi_pengajuan`
--
ALTER TABLE `realisasi_pengajuan`
  ADD CONSTRAINT `realisasi_pengajuan_ibfk_1` FOREIGN KEY (`pengajuan_id`) REFERENCES `pengajuan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `realisasi_pengajuan_ibfk_2` FOREIGN KEY (`kas_keluar_id`) REFERENCES `kas_keluar` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
