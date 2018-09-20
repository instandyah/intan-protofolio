-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Agu 2018 pada 22.49
-- Versi server: 10.1.31-MariaDB
-- Versi PHP: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_management`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'hahaha', 'haha@lala.com', '$2y$10$lNBoVLpbbgaUBw2fuPojjeKDa/nEyeXFqyXgbBy1tbiNRD7jtuz76', NULL, '2018-05-21 18:33:52', '2018-06-26 22:22:09'),
(2, 'coba', 'cobacoba@gmail.com', '$2y$10$gz.2XxV.ZV/iTFuJ8pIHe.JpBUyi2JcnN4toY7f/ys/1kMfZ.QkBi', NULL, '2018-05-23 08:43:04', '2018-05-23 08:43:04'),
(3, 'intandyah', 'intan@cth.com', '$2y$10$FlEFh7kc8r2aQLu2pvC32eGLu91/Y0YXRJZyog1WibwZH1icQZO6u', NULL, '2018-05-30 00:29:04', '2018-07-05 18:14:03'),
(4, 'intan', 'instan@gmail.com', '$2y$10$5efnfYynwQqEjmBYXcIkIuIvU7YQ8BGIVdlu02xBSj9vc4d5hZ5yG', NULL, '2018-06-07 01:03:02', '2018-06-07 01:03:02'),
(5, 'akuuu', 'aku@kamu.com', '$2y$10$EOJUQJhEC6iPr4nTuIDWXeLfWDFFlkBkurFEejAdyYYPwuqHHDAtO', NULL, '2018-06-13 08:23:06', '2018-06-13 08:23:06'),
(6, 'Arinaa', 'Arinrina@gmail.com', '$2y$10$MLHk2UUYh0yAPNr1KHwLO.W0u7aX5Ndaf4ypijrzan3jJBYegZtmm', NULL, '2018-06-25 18:25:11', '2018-07-05 03:54:51'),
(7, 'indina', 'indiana@gmail.com', '$2y$10$6OEaCZMfLE6ilM5RPc31YeUUDtXkr4HCklQJIEDwNSVcfDCqEFvlG', NULL, '2018-06-25 18:42:27', '2018-06-25 18:42:27'),
(8, 'Aan', 'aanfauzan@gmail.com', '$2y$10$Woelse.5JdLcdO/c9/GEhOKjTL3VzLcGL99/rk5in.A3lfaUwO.U6', NULL, '2018-07-11 23:14:33', '2018-07-11 23:14:33'),
(9, 'Agus', 'agusdiana@gmail.com', '$2y$10$ZQ15x0Qe0ud7FO4S36XeWeyn/Q64uOkZvUUGVNC5YmADpXp/3N.8K', NULL, '2018-07-11 23:44:29', '2018-07-11 23:44:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `aktivitas`
--

CREATE TABLE `aktivitas` (
  `id_aktivitas` int(10) UNSIGNED NOT NULL,
  `id_pembagian` int(10) UNSIGNED NOT NULL,
  `due_date` timestamp NULL DEFAULT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `postpone_start` timestamp NULL DEFAULT NULL,
  `postpone_end` timestamp NULL DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revisi_hit` int(10) DEFAULT NULL,
  `confirm` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `progress` int(10) DEFAULT NULL,
  `confirm_progress` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `aktivitas`
--

INSERT INTO `aktivitas` (`id_aktivitas`, `id_pembagian`, `due_date`, `start_date`, `end_date`, `postpone_start`, `postpone_end`, `status`, `keterangan`, `deskripsi`, `revisi_hit`, `confirm`, `progress`, `confirm_progress`, `updated_at`) VALUES
(15, 626, '2018-08-29 17:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 627, NULL, '2018-08-08 12:58:43', '2018-08-08 12:59:39', NULL, NULL, 'Selesai', NULL, NULL, NULL, 'Dikonfirmasi Aan', 100, 'Dikonfirmasi Aan', '2018-08-08 13:00:56'),
(17, 628, '2018-08-22 17:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 629, '2018-08-22 17:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 630, '2018-08-26 17:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 631, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 632, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 633, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 634, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 635, NULL, '2018-08-06 07:02:14', '2018-08-06 07:04:08', '2018-08-06 07:03:15', '2018-08-06 07:03:53', 'Selesai', NULL, NULL, NULL, 'Dikonfirmasi Aan', 100, 'Dikonfirmasi Aan', '2018-08-06 07:04:21'),
(25, 636, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 637, '2018-08-10 17:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 638, '2018-08-09 17:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 639, '2018-08-29 17:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 640, '2018-08-15 17:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 641, '2018-08-22 17:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 646, '2018-08-15 17:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 647, NULL, '2018-08-08 12:56:29', '2018-08-08 12:58:18', '2018-08-08 12:56:34', '2018-08-08 12:58:11', 'Selesai', NULL, NULL, NULL, 'Dikonfirmasi Aan', 100, 'Dikonfirmasi Aan', '2018-08-08 13:00:30'),
(39, 648, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 649, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` int(10) UNSIGNED NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `dibuat_oleh` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `username`, `password`, `remember_token`, `created_at`, `updated_at`, `dibuat_oleh`) VALUES
(243, 'alalmuhammad', '$2y$10$7Uio7dIssz.2oUXLcmXvgO5m81kcBJqK.gVvCgykmJGVOEsZ12qMe', 'SIpa6gkDmIXV0OA8F4McFsHZc3rVggwgxpf09pzmISsl5Ny1MatozbEbKh6n', '2018-07-11 23:48:45', '2018-08-08 12:57:48', 'Agus'),
(244, 'Desi.A', '$2y$10$bQ5D0Cl5tPB.OM2i33EDiuHcCraX.B7dXtcLeg1NMS.s1MD55tHiK', NULL, '2018-07-11 23:49:08', '2018-07-11 23:49:08', 'Agus'),
(245, 'Zakiyah', '$2y$10$tJvOQzrGwDGYlirUdn7T1emp6Indm8ysyu.nrQjnzShkGpEE1mqya', NULL, '2018-07-11 23:49:22', '2018-07-11 23:49:22', 'Agus'),
(246, 'B.sukma', '$2y$10$gHHn.WO/dRBEV8mkSJhHlOMDYfBJuVePt9DSHKpps2BDBVdof5mqu', NULL, '2018-07-11 23:49:48', '2018-07-11 23:49:48', 'Agus'),
(247, 'Bayu.A.P', '$2y$10$4gmIepDVVOHYbhSxWGM5U.kCoM0fSWFKfGAX9MydJig40Od.F873a', NULL, '2018-07-11 23:50:13', '2018-07-11 23:50:13', 'Agus'),
(248, 'P.Rahmatullah', '$2y$10$Bh5v4YhuT49nMh2sA3TGyOTsTnVRTjB3m3NP.2k9RW/jFJ0eKei1S', 'mFEJjz3goIfkX8TSkvDq8NtfTnOogmksl4LniyOL2X43oz5B6yxIIfhSvqeF', '2018-07-11 23:50:47', '2018-07-11 23:50:47', 'Agus'),
(249, 'Muhammad', '$2y$10$.ctNbbkNcuKGQbHfcVcHZ.dBY6fifiTtDP6FSySw/17A3xFRG8lJO', NULL, '2018-07-11 23:54:40', '2018-07-11 23:59:01', 'Agus');

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggota_project`
--

CREATE TABLE `anggota_project` (
  `id_anggota` int(10) UNSIGNED NOT NULL,
  `id_project` int(10) UNSIGNED NOT NULL,
  `dibawa_oleh` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penanggungjawab` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `anggota_project`
--

INSERT INTO `anggota_project` (`id_anggota`, `id_project`, `dibawa_oleh`, `penanggungjawab`, `created_at`, `updated_at`) VALUES
(249, 688, 'Agus', NULL, '2018-07-11 23:54:55', NULL),
(246, 687, 'Agus', 8, '2018-07-12 00:05:25', NULL),
(248, 687, 'Agus', 8, '2018-07-12 00:06:11', NULL),
(243, 686, 'Aan', NULL, '2018-07-12 00:09:42', NULL),
(247, 686, 'Aan', NULL, '2018-07-12 00:09:42', NULL),
(244, 686, 'Aan', NULL, '2018-07-12 00:09:42', NULL),
(245, 686, 'Aan', NULL, '2018-07-12 00:09:42', NULL),
(246, 686, 'Aan', NULL, '2018-07-12 03:42:47', NULL),
(244, 687, 'Aan', NULL, '2018-07-22 14:26:04', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2018_06_19_103808_create_notifications_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembagian_tugas`
--

CREATE TABLE `pembagian_tugas` (
  `id_pembagian` int(10) UNSIGNED NOT NULL,
  `id_subtugas` int(10) UNSIGNED DEFAULT NULL,
  `id_PJ1` int(10) UNSIGNED DEFAULT NULL,
  `id_PJ2` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pembagian_tugas`
--

INSERT INTO `pembagian_tugas` (`id_pembagian`, `id_subtugas`, `id_PJ1`, `id_PJ2`, `created_at`, `updated_at`) VALUES
(626, 287, 243, 246, NULL, '2018-08-08 12:54:35'),
(627, 288, 243, 243, NULL, NULL),
(628, 304, 248, 248, NULL, NULL),
(629, 305, 248, 248, NULL, NULL),
(630, 306, 248, 248, NULL, NULL),
(631, 308, 248, 248, NULL, NULL),
(632, 309, 248, 248, NULL, NULL),
(633, 310, 248, 248, NULL, NULL),
(634, 311, 248, 248, NULL, NULL),
(635, 312, 248, 248, NULL, NULL),
(636, 313, 248, 248, NULL, NULL),
(637, 322, 246, 246, NULL, NULL),
(638, 323, 246, 246, NULL, NULL),
(639, 289, 246, 246, NULL, NULL),
(640, 290, 246, 246, NULL, NULL),
(641, 291, 246, 246, NULL, NULL),
(646, 307, 246, 246, NULL, NULL),
(647, 286, 243, 243, NULL, NULL),
(648, 296, 243, 243, NULL, NULL),
(649, 297, 243, 243, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `project`
--

CREATE TABLE `project` (
  `id_project` int(10) UNSIGNED NOT NULL,
  `nama_project` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_penanggungjawab` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kode_project` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `project`
--

INSERT INTO `project` (`id_project`, `nama_project`, `nama_penanggungjawab`, `created_at`, `updated_at`, `kode_project`) VALUES
(686, 'Helfa Mobile', 'Aan', '2018-07-11 23:15:20', '2018-07-11 23:15:20', 'd63eWWf'),
(687, 'KIOS & Backend', 'Agus', '2018-07-11 23:44:54', '2018-07-11 23:46:58', 'kRzWf6T'),
(688, 'DBA', 'Agus', '2018-07-11 23:51:36', '2018-07-11 23:51:36', 'Gzgxho5'),
(689, 'proyek 1', 'Aan', '2018-07-12 03:37:13', '2018-07-12 03:37:13', 'NYdI8Ct');

-- --------------------------------------------------------

--
-- Struktur dari tabel `project_detail`
--

CREATE TABLE `project_detail` (
  `id_admin` int(10) UNSIGNED NOT NULL,
  `id_project` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `project_detail`
--

INSERT INTO `project_detail` (`id_admin`, `id_project`, `created_at`, `updated_at`) VALUES
(8, 686, '2018-07-11 23:15:20', NULL),
(9, 687, '2018-07-11 23:44:54', NULL),
(9, 688, '2018-07-11 23:51:36', NULL),
(8, 687, '2018-07-12 00:09:15', NULL),
(8, 689, '2018-07-12 03:37:13', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `status`
--

CREATE TABLE `status` (
  `id_status` int(10) UNSIGNED NOT NULL,
  `nilai_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `status`
--

INSERT INTO `status` (`id_status`, `nilai_status`) VALUES
(1, 'Tersedia'),
(2, 'Dikerjakan'),
(3, 'Selesai'),
(4, 'Ditunda');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sub_tugas`
--

CREATE TABLE `sub_tugas` (
  `id_subtugas` int(10) UNSIGNED NOT NULL,
  `nama_subtugas` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bobot` int(10) NOT NULL,
  `id_tugas` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sub_tugas`
--

INSERT INTO `sub_tugas` (`id_subtugas`, `nama_subtugas`, `created_at`, `updated_at`, `bobot`, `id_tugas`) VALUES
(279, 'Login By email and Pssword', '2018-07-11 23:30:37', '2018-07-11 23:32:04', 4, 468),
(280, 'Login By API Gmail', '2018-07-11 23:32:30', '2018-07-11 23:32:30', 2, 468),
(281, 'Direct Data from gmail to data account', '2018-07-11 23:32:59', '2018-07-11 23:32:59', 2, 468),
(283, 'Feature place picker maps set direct location member', '2018-07-11 23:34:51', '2018-07-11 23:34:51', 4, 469),
(284, 'Feature place picker maps set Hospital location', '2018-07-11 23:35:06', '2018-07-11 23:35:06', 2, 469),
(285, 'Pemesanan ambulance sampai ke rumah sakit beserta data kondisi pasien', '2018-07-11 23:35:31', '2018-08-06 00:16:08', 2, 469),
(286, 'Admin Data diri driver beserta spesifikasi ambulan', '2018-07-11 23:36:20', '2018-07-11 23:36:20', 4, 470),
(287, 'Menampilkan data diri driver', '2018-07-11 23:37:23', '2018-07-11 23:37:23', 3, 471),
(288, 'Pickup Pasien / member helfa', '2018-07-11 23:37:34', '2018-07-11 23:37:34', 2, 471),
(289, 'Develop application User Account about personal data', '2018-07-11 23:38:17', '2018-07-11 23:38:17', 5, 472),
(290, 'Make Assurance Profile data', '2018-07-11 23:38:35', '2018-07-11 23:38:35', 3, 472),
(291, 'Make Hospital Profile data', '2018-07-11 23:38:47', '2018-07-11 23:38:47', 2, 472),
(292, 'Develop Registration OutPatient Bridging With Medicom', '2018-07-11 23:39:31', '2018-07-11 23:39:31', 2, 473),
(293, 'Develop Registration OutPatient', '2018-07-11 23:39:41', '2018-07-11 23:39:41', 2, 473),
(294, 'Build Notification remind registration', '2018-07-11 23:39:50', '2018-07-11 23:39:50', 2, 473),
(295, 'membuat riwayat dan jadwal yang akan dihadiri', '2018-07-11 23:40:04', '2018-07-11 23:40:04', 2, 473),
(296, 'About Feature yankes (First Yastroki) Yayasan Stroke Indonesia', '2018-07-11 23:41:30', '2018-07-11 23:41:30', 5, 474),
(297, 'Build CMS Admin for Yastroki', '2018-07-11 23:41:39', '2018-07-11 23:41:39', 5, 474),
(298, 'membuat framework ui List Rumah Sakit', '2018-07-11 23:42:04', '2018-07-11 23:42:04', 3, 475),
(299, 'membuat framework Fasilitas List Rumah Sakit', '2018-07-11 23:42:13', '2018-07-11 23:42:13', 2, 475),
(300, 'membuat framework Jadwal Dokter', '2018-07-11 23:42:24', '2018-07-11 23:42:24', 3, 475),
(301, 'membuat framework informasi Rumah Sakit', '2018-07-11 23:42:39', '2018-07-11 23:42:39', 2, 475),
(302, 'Build Framework List Hospital and Registration Emergency', '2018-07-11 23:43:08', '2018-07-11 23:43:08', 5, 476),
(303, 'buat dashboard tampilan data pasien yang daftar igd ke rumah sakit', '2018-07-11 23:43:18', '2018-07-11 23:43:18', 5, 476),
(304, 'membuat dashboard management antrian poliklinik', '2018-07-11 23:45:37', '2018-07-11 23:45:37', 3, 477),
(305, 'membuat kios poliklinik kedatangan pasien', '2018-07-11 23:45:46', '2018-07-11 23:45:59', 3, 477),
(306, 'Membuat kios versi online (Link Helfa)', '2018-07-11 23:46:09', '2018-07-11 23:46:09', 4, 477),
(307, 'Buat Website Helfa Responsive mobil', '2018-07-11 23:46:31', '2018-07-11 23:46:31', 10, 478),
(308, 'Webservice Fitur Login & Data User', '2018-07-11 23:47:30', '2018-07-11 23:47:30', 3, 479),
(309, 'Webservice Fitur Rawat Jalan', '2018-07-11 23:47:41', '2018-07-11 23:47:41', 4, 479),
(310, 'Webservice Fitur Emergency Unit', '2018-07-11 23:47:48', '2018-07-11 23:47:48', 1, 479),
(311, 'Webservice Fitur Ambulance', '2018-07-11 23:47:55', '2018-07-11 23:47:55', 1, 479),
(312, 'Webservice Fitur Yankes/Stroke', '2018-07-11 23:48:02', '2018-07-11 23:48:02', 1, 479),
(313, 'Membuat kios versi Offline (on the spot)', '2018-07-11 23:48:21', '2018-07-11 23:48:21', 5, 477),
(314, 'User Login & Registration', '2018-07-11 23:52:20', '2018-07-11 23:52:20', 2, 480),
(315, 'User and Hospital Profile', '2018-07-11 23:52:30', '2018-07-11 23:52:30', 3, 480),
(316, 'Create Or Cancel Appointment From Mobile Apps And KIOS', '2018-07-11 23:52:41', '2018-07-11 23:52:41', 3, 480),
(317, 'Create Queueing Dashboard For Policlinic', '2018-07-11 23:52:52', '2018-07-11 23:52:52', 3, 480),
(318, 'Create Report Database Performance', '2018-07-11 23:53:46', '2018-07-11 23:53:46', 2, 481),
(319, 'Create Log For User Changed', '2018-07-11 23:53:58', '2018-07-11 23:53:58', 3, 481),
(320, 'Explain And Can Restructure Database', '2018-07-11 23:54:07', '2018-07-11 23:54:07', 2, 481),
(321, 'Control, Support and Maintenance', '2018-07-11 23:54:19', '2018-07-11 23:54:19', 3, 481),
(322, 'satu', '2018-08-08 12:43:51', '2018-08-08 12:43:51', 1, 482),
(323, 'dua', '2018-08-08 12:44:08', '2018-08-08 12:44:08', 6, 482);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tugas`
--

CREATE TABLE `tugas` (
  `id_tugas` int(10) UNSIGNED NOT NULL,
  `nama_tugas` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_project` int(10) UNSIGNED NOT NULL,
  `dibuat_oleh` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Pj` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tugas`
--

INSERT INTO `tugas` (`id_tugas`, `nama_tugas`, `created_at`, `updated_at`, `id_project`, `dibuat_oleh`, `Pj`) VALUES
(468, 'Build Autentikasi Helfa', '2018-07-11 23:16:37', '2018-07-11 23:17:03', 686, 'Aan', NULL),
(469, 'feature ambulance member', '2018-07-11 23:34:05', '2018-07-11 23:34:31', 686, 'Aan', NULL),
(470, 'Admin ambulance', '2018-07-11 23:36:01', '2018-07-11 23:36:01', 686, 'Aan', NULL),
(471, 'Ambulance Driver helfa', '2018-07-11 23:36:55', '2018-07-11 23:37:08', 686, 'Aan', NULL),
(472, 'User Account', '2018-07-11 23:37:54', '2018-07-11 23:37:54', 686, 'Aan', NULL),
(473, 'Outpatient Registration', '2018-07-11 23:39:09', '2018-07-11 23:39:18', 686, 'Aan', NULL),
(474, 'Fitur YanKes', '2018-07-11 23:41:07', '2018-07-11 23:41:07', 686, 'Aan', NULL),
(475, 'List Rumah Sakit', '2018-07-11 23:41:51', '2018-07-11 23:41:51', 686, 'Aan', NULL),
(476, 'Build Features Emergency', '2018-07-11 23:42:55', '2018-07-11 23:42:55', 686, 'Aan', NULL),
(477, 'KIOS-K', '2018-07-11 23:45:14', '2018-07-23 03:06:42', 687, 'Agus', NULL),
(478, 'WebSite Helfa', '2018-07-11 23:45:25', '2018-07-11 23:45:25', 687, 'Agus', 8),
(479, 'Build Web Service', '2018-07-11 23:47:19', '2018-07-11 23:47:19', 687, 'Agus', NULL),
(480, 'Database Structure', '2018-07-11 23:51:46', '2018-07-11 23:53:10', 688, 'Agus', NULL),
(481, 'Database Health', '2018-07-11 23:53:31', '2018-07-11 23:53:31', 688, 'Agus', NULL),
(482, 'cobacoba cobaaaaaaaaaaaaaaa', '2018-08-08 12:43:11', '2018-08-08 12:43:42', 686, 'Aan', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `admin_email_unique` (`email`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indeks untuk tabel `aktivitas`
--
ALTER TABLE `aktivitas`
  ADD PRIMARY KEY (`id_aktivitas`),
  ADD KEY `id_pembagian` (`id_pembagian`);

--
-- Indeks untuk tabel `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id_anggota`),
  ADD UNIQUE KEY `anggota_username_unique` (`username`),
  ADD KEY `updated_at` (`updated_at`);

--
-- Indeks untuk tabel `anggota_project`
--
ALTER TABLE `anggota_project`
  ADD KEY `id_anggota` (`id_anggota`),
  ADD KEY `id_project` (`id_project`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `pembagian_tugas`
--
ALTER TABLE `pembagian_tugas`
  ADD PRIMARY KEY (`id_pembagian`),
  ADD KEY `id_subtugas` (`id_subtugas`),
  ADD KEY `id_PJ1` (`id_PJ1`),
  ADD KEY `id_PJ2` (`id_PJ2`);

--
-- Indeks untuk tabel `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id_project`),
  ADD UNIQUE KEY `nama_project` (`nama_project`);

--
-- Indeks untuk tabel `project_detail`
--
ALTER TABLE `project_detail`
  ADD KEY `id_admin` (`id_admin`),
  ADD KEY `id_project` (`id_project`);

--
-- Indeks untuk tabel `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id_status`);

--
-- Indeks untuk tabel `sub_tugas`
--
ALTER TABLE `sub_tugas`
  ADD PRIMARY KEY (`id_subtugas`),
  ADD KEY `id_tugas` (`id_tugas`);

--
-- Indeks untuk tabel `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`id_tugas`),
  ADD KEY `id_proyek` (`id_project`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `aktivitas`
--
ALTER TABLE `aktivitas`
  MODIFY `id_aktivitas` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id_anggota` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=250;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pembagian_tugas`
--
ALTER TABLE `pembagian_tugas`
  MODIFY `id_pembagian` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=650;

--
-- AUTO_INCREMENT untuk tabel `project`
--
ALTER TABLE `project`
  MODIFY `id_project` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=690;

--
-- AUTO_INCREMENT untuk tabel `sub_tugas`
--
ALTER TABLE `sub_tugas`
  MODIFY `id_subtugas` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=325;

--
-- AUTO_INCREMENT untuk tabel `tugas`
--
ALTER TABLE `tugas`
  MODIFY `id_tugas` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=484;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `aktivitas`
--
ALTER TABLE `aktivitas`
  ADD CONSTRAINT `fk_pembagian` FOREIGN KEY (`id_pembagian`) REFERENCES `pembagian_tugas` (`id_pembagian`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `anggota_project`
--
ALTER TABLE `anggota_project`
  ADD CONSTRAINT `fkanggotaproject` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkproject` FOREIGN KEY (`id_project`) REFERENCES `project` (`id_project`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembagian_tugas`
--
ALTER TABLE `pembagian_tugas`
  ADD CONSTRAINT `fk_bagi_PJ1` FOREIGN KEY (`id_PJ1`) REFERENCES `anggota` (`id_anggota`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `fk_bagi_Pj2` FOREIGN KEY (`id_PJ2`) REFERENCES `anggota` (`id_anggota`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `fk_bagi_subtugas` FOREIGN KEY (`id_subtugas`) REFERENCES `sub_tugas` (`id_subtugas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `project_detail`
--
ALTER TABLE `project_detail`
  ADD CONSTRAINT `fk_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_project` FOREIGN KEY (`id_project`) REFERENCES `project` (`id_project`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sub_tugas`
--
ALTER TABLE `sub_tugas`
  ADD CONSTRAINT `fk_subtugas` FOREIGN KEY (`id_tugas`) REFERENCES `tugas` (`id_tugas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tugas`
--
ALTER TABLE `tugas`
  ADD CONSTRAINT `fk_tugas` FOREIGN KEY (`id_project`) REFERENCES `project` (`id_project`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
