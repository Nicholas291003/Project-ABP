-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Bulan Mei 2026 pada 08.15
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `travelgo_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_17_071028_create_transportations_table', 1),
(5, '2026_05_17_071503_create_routes_table', 1),
(6, '2026_05_17_071645_create_schedules_table', 1),
(7, '2026_05_17_071934_create_orders_table', 1),
(8, '2026_05_18_061031_create_seat_bookings_table', 1),
(9, '2026_05_19_210413_create_personal_access_tokens_table', 1),
(10, '2026_05_19_224234_create_transit_points_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `schedule_id` bigint(20) UNSIGNED NOT NULL,
  `order_code` varchar(255) NOT NULL,
  `total_passengers` int(11) NOT NULL DEFAULT 1,
  `total_price` int(11) NOT NULL,
  `status` enum('pending','lunas','dibatalkan') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `schedule_id`, `order_code`, `total_passengers`, `total_price`, `status`, `created_at`, `updated_at`) VALUES
(1, 11, 22, 'TKT-QT132Y', 4, 6390320, 'lunas', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(2, 11, 35, 'TKT-LC672T', 1, 381318, 'pending', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(3, 7, 13, 'TKT-CR758A', 4, 934284, 'lunas', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(4, 2, 23, 'TKT-XU009F', 3, 5129346, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(5, 5, 12, 'TKT-XA557G', 4, 1047856, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(6, 9, 48, 'TKT-XR508C', 2, 215840, 'pending', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(7, 5, 43, 'TKT-OW137R', 2, 204418, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(8, 4, 35, 'TKT-YH435T', 2, 762636, 'lunas', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(9, 2, 6, 'TKT-DG882E', 1, 327804, 'pending', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(10, 5, 35, 'TKT-YO317L', 4, 1525272, 'lunas', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(11, 2, 39, 'TKT-NV439S', 1, 257019, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(12, 3, 40, 'TKT-AD945W', 3, 273477, 'lunas', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(13, 7, 34, 'TKT-JC491V', 2, 2063358, 'pending', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(14, 5, 24, 'TKT-IM280U', 3, 497991, 'lunas', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(15, 4, 27, 'TKT-HY155H', 3, 1126683, 'pending', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(16, 6, 42, 'TKT-BX492B', 3, 238419, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(17, 4, 38, 'TKT-YW336S', 4, 902196, 'pending', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(18, 5, 28, 'TKT-VJ706B', 1, 1041992, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(19, 5, 32, 'TKT-YT177I', 4, 1058164, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(20, 7, 47, 'TKT-XC495I', 3, 1712085, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(21, 6, 14, 'TKT-VA808F', 1, 348088, 'pending', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(22, 11, 38, 'TKT-ZP752X', 1, 225549, 'lunas', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(23, 10, 1, 'TKT-RH322I', 2, 171814, 'pending', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(24, 11, 5, 'TKT-NY426R', 2, 477332, 'pending', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(25, 8, 47, 'TKT-VG551F', 4, 2282780, 'pending', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(26, 11, 42, 'TKT-SK726G', 4, 317892, 'lunas', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(27, 3, 44, 'TKT-EV483R', 1, 6014286, 'pending', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(28, 5, 32, 'TKT-PC416X', 1, 264541, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(29, 3, 14, 'TKT-ZN314L', 2, 696176, 'pending', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(30, 2, 31, 'TKT-TH457Z', 4, 601640, 'pending', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(31, 11, 47, 'TKT-UX806R', 3, 1712085, 'lunas', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(32, 7, 46, 'TKT-RX004L', 2, 1870426, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(33, 5, 13, 'TKT-DA597Z', 1, 233571, 'lunas', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(34, 9, 45, 'TKT-PP605X', 2, 153782, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(35, 9, 36, 'TKT-TT931B', 3, 18115146, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(36, 8, 8, 'TKT-MK292I', 4, 546456, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(37, 5, 18, 'TKT-YK143C', 2, 3151258, 'pending', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(38, 7, 37, 'TKT-CE929E', 1, 517451, 'pending', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(39, 11, 19, 'TKT-PN266H', 2, 510924, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(40, 5, 34, 'TKT-HA537D', 2, 2063358, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(41, 11, 20, 'TKT-XV607U', 1, 154188, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(42, 4, 32, 'TKT-EK726Z', 3, 793623, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(43, 9, 28, 'TKT-TB077D', 3, 3125976, 'lunas', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(44, 10, 48, 'TKT-LU888A', 1, 107920, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(45, 10, 25, 'TKT-AD377N', 2, 246200, 'pending', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(46, 9, 44, 'TKT-MH926K', 4, 24057144, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(47, 9, 3, 'TKT-VK759I', 4, 412708, 'pending', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(48, 6, 40, 'TKT-VT663W', 1, 91159, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(49, 7, 29, 'TKT-GN535N', 1, 84264, 'lunas', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(50, 4, 13, 'TKT-BL620G', 2, 467142, 'pending', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(51, 11, 22, 'TKT-YQ691D', 3, 4792740, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(52, 6, 45, 'TKT-VB213J', 2, 153782, 'lunas', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(53, 4, 44, 'TKT-IO199F', 4, 24057144, 'lunas', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(54, 9, 39, 'TKT-VD859R', 2, 514038, 'lunas', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(55, 11, 1, 'TKT-GL269G', 2, 171814, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(56, 5, 26, 'TKT-QD670S', 2, 539454, 'lunas', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(57, 5, 37, 'TKT-RM709B', 1, 517451, 'pending', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(58, 3, 30, 'TKT-JG412G', 3, 10894605, 'pending', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(59, 9, 36, 'TKT-DW858Q', 4, 24153528, 'lunas', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(60, 8, 21, 'TKT-CX927T', 2, 1024972, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(61, 2, 35, 'TKT-AP824Q', 1, 381318, 'pending', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(62, 11, 4, 'TKT-TY812X', 4, 622060, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(63, 11, 6, 'TKT-JA738Q', 2, 655608, 'pending', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(64, 6, 5, 'TKT-CR107A', 2, 477332, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(65, 7, 35, 'TKT-DI536F', 3, 1143954, 'lunas', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(66, 10, 20, 'TKT-DK088V', 3, 462564, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(67, 6, 28, 'TKT-YH418I', 2, 2083984, 'pending', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(68, 9, 14, 'TKT-BU849V', 2, 696176, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(69, 9, 9, 'TKT-FO805X', 4, 2225168, 'lunas', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(70, 6, 22, 'TKT-JR258T', 1, 1597580, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(71, 5, 24, 'TKT-YX321L', 1, 165997, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(72, 7, 43, 'TKT-RH838K', 2, 204418, 'lunas', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(73, 7, 47, 'TKT-OT395E', 4, 2282780, 'pending', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(74, 6, 5, 'TKT-XF652O', 4, 954664, 'pending', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(75, 7, 47, 'TKT-WH238R', 4, 2282780, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(76, 3, 7, 'TKT-PL686H', 4, 1012288, 'lunas', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(77, 7, 33, 'TKT-YA124C', 2, 522838, 'lunas', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(78, 4, 21, 'TKT-MO553P', 2, 1024972, 'pending', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(79, 6, 25, 'TKT-PG442A', 2, 246200, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(80, 8, 20, 'TKT-NS646P', 3, 462564, 'lunas', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(81, 11, 15, 'TKT-AZ789L', 1, 159373, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(82, 3, 40, 'TKT-BY997W', 2, 182318, 'lunas', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(83, 7, 13, 'TKT-NM261U', 1, 233571, 'pending', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(84, 2, 30, 'TKT-VT788G', 4, 14526140, 'pending', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(85, 8, 33, 'TKT-FQ646X', 1, 261419, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(86, 9, 43, 'TKT-DQ897F', 1, 102209, 'pending', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(87, 9, 20, 'TKT-MU713M', 2, 308376, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(88, 6, 33, 'TKT-KA588M', 1, 261419, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(89, 7, 10, 'TKT-RI550W', 4, 518832, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(90, 4, 10, 'TKT-ZE190A', 4, 518832, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(91, 9, 24, 'TKT-ZP154V', 4, 663988, 'pending', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(92, 9, 31, 'TKT-BI537T', 2, 300820, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(93, 2, 2, 'TKT-ZQ915R', 4, 1908016, 'pending', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(94, 10, 1, 'TKT-NS415R', 4, 343628, 'lunas', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(95, 6, 9, 'TKT-JJ907J', 1, 556292, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(96, 5, 22, 'TKT-ET359W', 1, 1597580, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(97, 9, 26, 'TKT-GD035S', 2, 539454, 'pending', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(98, 10, 14, 'TKT-BY457U', 3, 1044264, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(99, 9, 15, 'TKT-JS140H', 1, 159373, 'dibatalkan', '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(100, 11, 11, 'TKT-SI062T', 1, 341751, 'lunas', '2026-05-29 22:38:21', '2026-05-29 22:38:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `routes`
--

CREATE TABLE `routes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_rute` varchar(255) NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `kota_asal` varchar(255) NOT NULL,
  `simpul_asal` varchar(255) NOT NULL,
  `kota_tujuan` varchar(255) NOT NULL,
  `simpul_tujuan` varchar(255) NOT NULL,
  `jarak` int(11) NOT NULL,
  `estimasi_jam` int(11) NOT NULL,
  `estimasi_menit` int(11) NOT NULL,
  `tarif_dasar` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `routes`
--

INSERT INTO `routes` (`id`, `kode_rute`, `jenis`, `kota_asal`, `simpul_asal`, `kota_tujuan`, `simpul_tujuan`, `jarak`, `estimasi_jam`, `estimasi_menit`, `tarif_dasar`, `created_at`, `updated_at`) VALUES
(1, 'R-TRN-01', 'kereta', 'Yogyakarta', 'Stasiun Tugu (YK)', 'Surabaya', 'Stasiun Gubeng (SGU)', 320, 5, 0, 220000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(2, 'R-TRN-02', 'kereta', 'Yogyakarta', 'Stasiun Lempuyangan (LPN)', 'Banyuwangi', 'Stasiun Ketapang (KTG)', 580, 13, 35, 94000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(3, 'R-TRN-03', 'kereta', 'Yogyakarta', 'Stasiun Lempuyangan (LPN)', 'Jakarta', 'Stasiun Pasar Senen (PSE)', 510, 8, 34, 190000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(4, 'R-TRN-04', 'kereta', 'Yogyakarta', 'Stasiun Tugu (YK)', 'Jakarta', 'Stasiun Gambir (GMR)', 520, 7, 42, 450000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(5, 'R-TRN-05', 'kereta', 'Yogyakarta', 'Stasiun Tugu (YK)', 'Jakarta', 'Stasiun Pasar Senen (PSE)', 515, 8, 11, 280000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(6, 'R-TRN-06', 'kereta', 'Yogyakarta', 'Stasiun Tugu (YK)', 'Malang', 'Stasiun Malang (ML)', 340, 8, 1, 210000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(7, 'R-TRN-07', 'kereta', 'Yogyakarta', 'Stasiun Tugu (YK)', 'Jakarta', 'Stasiun Pasar Senen (PSE)', 515, 7, 56, 290000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(8, 'R-TRN-08', 'kereta', 'Yogyakarta', 'Stasiun Tugu (YK)', 'Solo', 'Stasiun Balapan (SLO)', 60, 0, 57, 40000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(9, 'R-TRN-09', 'kereta', 'Surabaya', 'Stasiun Gubeng (SGU)', 'Banyuwangi', 'Stasiun Ketapang (KTG)', 290, 7, 30, 60000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(10, 'R-TRN-10', 'kereta', 'Surabaya', 'Stasiun Gubeng (SGU)', 'Bandung', 'Stasiun Kiaracondong (KAC)', 690, 14, 10, 95000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(11, 'R-TRN-11', 'kereta', 'Surabaya', 'Stasiun Gubeng (SGU)', 'Malang', 'Stasiun Malang Kotabaru (ML)', 95, 2, 19, 40000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(12, 'R-TRN-12', 'kereta', 'Surabaya', 'Stasiun Gubeng (SGU)', 'Jakarta', 'Stasiun Gambir (GMR)', 780, 16, 15, 600000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(13, 'R-TRN-13', 'kereta', 'Surabaya', 'Stasiun Gubeng (SGU)', 'Jakarta', 'Stasiun Pasar Senen (PSE)', 775, 14, 21, 340000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(14, 'R-TRN-14', 'kereta', 'Surabaya', 'Stasiun Gubeng (SGU)', 'Jakarta', 'Stasiun Jakarta Kota (JAKK)', 790, 13, 38, 310000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(15, 'R-TRN-15', 'kereta', 'Surabaya', 'Stasiun Gubeng (SGU)', 'Jakarta', 'Stasiun Gambir (GMR)', 780, 12, 53, 480000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(16, 'R-TRN-16', 'kereta', 'Surabaya', 'Stasiun Gubeng (SGU)', 'Jakarta', 'Stasiun Gambir (GMR)', 780, 16, 49, 530000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(17, 'R-TRN-17', 'kereta', 'Surabaya', 'Stasiun Gubeng (SGU)', 'Banyuwangi', 'Stasiun Ketapang (KTG)', 290, 6, 20, 200000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(18, 'R-TRN-18', 'kereta', 'Bandung', 'Stasiun Bandung (BD)', 'Jakarta', 'Stasiun Gambir (GMR)', 150, 3, 47, 150000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(19, 'R-TRN-19', 'kereta', 'Bandung', 'Stasiun Bandung (BD)', 'Solo', 'Stasiun Balapan (SLO)', 450, 9, 2, 320000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(20, 'R-TRN-20', 'kereta', 'Bandung', 'Stasiun Bandung (BD)', 'Semarang', 'Stasiun Tawang (SMT)', 380, 7, 43, 280000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(21, 'R-FLT-01', 'pesawat', 'Jakarta', 'Bandara Soekarno-Hatta (CGK)', 'Makassar', 'Bandara Sultan Hasanuddin (UPG)', 1400, 2, 30, 1200000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(22, 'R-FLT-02', 'pesawat', 'Jakarta', 'Bandara Soekarno-Hatta (CGK)', 'Denpasar', 'Bandara Ngurah Rai (DPS)', 960, 1, 50, 900000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(23, 'R-FLT-03', 'pesawat', 'Jakarta', 'Bandara Soekarno-Hatta (CGK)', 'Surabaya', 'Bandara Juanda (SUB)', 690, 1, 30, 750000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(24, 'R-FLT-04', 'pesawat', 'Jakarta', 'Bandara Soekarno-Hatta (CGK)', 'Medan', 'Bandara Kualanamu (KNO)', 1420, 2, 15, 1350000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(25, 'R-FLT-05', 'pesawat', 'Surabaya', 'Bandara Juanda (SUB)', 'Makassar', 'Bandara Sultan Hasanuddin (UPG)', 840, 1, 40, 850000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(26, 'R-FLT-06', 'pesawat', 'Jakarta', 'Bandara Soekarno-Hatta (CGK)', 'Singapore', 'Changi Airport (SIN)', 890, 1, 45, 1500000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(27, 'R-FLT-07', 'pesawat', 'Jakarta', 'Bandara Soekarno-Hatta (CGK)', 'Kuala Lumpur', 'Kuala Lumpur Int. Airport (KUL)', 1100, 2, 0, 1100000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(28, 'R-FLT-08', 'pesawat', 'Jakarta', 'Bandara Soekarno-Hatta (CGK)', 'Hong Kong', 'Hong Kong Int. Airport (HKG)', 3260, 4, 50, 3500000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(29, 'R-FLT-09', 'pesawat', 'Jakarta', 'Bandara Soekarno-Hatta (CGK)', 'Tokyo', 'Narita International Airport (NRT)', 5780, 7, 15, 6200000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(30, 'R-FLT-10', 'pesawat', 'Jakarta', 'Bandara Soekarno-Hatta (CGK)', 'Sydney', 'Kingsford Smith Airport (SYD)', 5500, 7, 30, 5900000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(31, 'R-BUS-01', 'bus', 'Jakarta', 'Terminal Pulo Gebang', 'Bandung', 'Terminal Leuwipanjang', 150, 3, 30, 110000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(32, 'R-BUS-02', 'bus', 'Jakarta', 'Terminal Kampung Rambutan', 'Semarang', 'Terminal Terboyo', 440, 6, 30, 210000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(33, 'R-BUS-03', 'bus', 'Jakarta', 'Terminal Kalideres', 'Yogyakarta', 'Terminal Giwangan', 530, 8, 30, 240000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(34, 'R-BUS-04', 'bus', 'Yogyakarta', 'Terminal Jombor', 'Semarang', 'Terminal Mangkang', 120, 3, 30, 85000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(35, 'R-BUS-05', 'bus', 'Surabaya', 'Terminal Purabaya', 'Malang', 'Terminal Arjosari', 90, 2, 0, 50000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(36, 'R-BUS-06', 'bus', 'Surabaya', 'Terminal Purabaya', 'Banyuwangi', 'Terminal Sritanjung', 290, 7, 30, 140000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(37, 'R-BUS-07', 'bus', 'Denpasar (Bali)', 'Terminal Ubung', 'Ubud', 'Puri Ubud Shuttle Point', 30, 1, 15, 75000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(38, 'R-BUS-08', 'bus', 'Medan', 'Terminal Amplas', 'Pematang Siantar', 'Terminal Tanjung Pinggir', 125, 3, 0, 60000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(39, 'R-BUS-09', 'bus', 'Bandung', 'Terminal Cicaheum', 'Tasikmalaya', 'Terminal Indihiang', 105, 3, 0, 65000, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(40, 'R-BUS-10', 'bus', 'Jakarta', 'Terminal Pulo Gebang', 'Lampung', 'Terminal Rajabasa', 230, 8, 30, 220000, '2026-05-29 22:38:20', '2026-05-29 22:38:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `schedules`
--

CREATE TABLE `schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `route_id` bigint(20) UNSIGNED NOT NULL,
  `transportation_id` bigint(20) UNSIGNED NOT NULL,
  `departure_date` date NOT NULL,
  `departure_time` time NOT NULL,
  `arrival_time` time NOT NULL,
  `price` int(11) NOT NULL,
  `total_seats` int(11) NOT NULL,
  `remaining_seats` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `schedules`
--

INSERT INTO `schedules` (`id`, `route_id`, `transportation_id`, `departure_date`, `departure_time`, `arrival_time`, `price`, `total_seats`, `remaining_seats`, `created_at`, `updated_at`) VALUES
(1, 8, 18, '2026-06-09', '08:00:00', '15:30:00', 85907, 80, 8, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(2, 4, 17, '2026-06-07', '08:00:00', '13:00:00', 477004, 80, 69, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(3, 11, 15, '2026-06-13', '21:30:00', '05:30:00', 103177, 50, 26, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(4, 10, 2, '2026-06-12', '19:00:00', '07:00:00', 155515, 106, 35, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(5, 32, 32, '2026-06-02', '14:00:00', '13:00:00', 238666, 10, 5, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(6, 7, 11, '2026-06-29', '19:00:00', '05:30:00', 327804, 80, 39, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(7, 33, 35, '2026-06-20', '08:00:00', '05:30:00', 253072, 22, 19, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(8, 31, 35, '2026-06-23', '08:00:00', '15:30:00', 136614, 22, 7, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(9, 16, 4, '2026-06-03', '14:00:00', '05:30:00', 556292, 40, 7, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(10, 31, 33, '2026-06-16', '19:00:00', '07:00:00', 129708, 12, 9, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(11, 7, 20, '2026-06-27', '19:00:00', '13:00:00', 341751, 80, 56, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(12, 6, 14, '2026-06-26', '19:00:00', '07:00:00', 261964, 80, 77, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(13, 32, 37, '2026-06-21', '14:00:00', '07:00:00', 233571, 38, 25, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(14, 20, 10, '2026-06-02', '10:30:00', '05:30:00', 348088, 106, 11, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(15, 36, 40, '2026-05-31', '19:00:00', '07:00:00', 159373, 28, 17, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(16, 17, 2, '2026-06-29', '08:00:00', '07:00:00', 223092, 106, 34, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(17, 29, 23, '2026-06-21', '21:30:00', '07:00:00', 6450497, 180, 70, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(18, 24, 21, '2026-06-21', '14:00:00', '18:00:00', 1575629, 150, 124, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(19, 33, 34, '2026-06-03', '14:00:00', '18:00:00', 255462, 34, 10, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(20, 36, 35, '2026-06-20', '10:30:00', '15:30:00', 154188, 22, 5, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(21, 15, 1, '2026-06-15', '21:30:00', '15:30:00', 512486, 80, 70, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(22, 24, 28, '2026-06-28', '10:30:00', '13:00:00', 1597580, 180, 44, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(23, 26, 21, '2026-06-14', '21:30:00', '15:30:00', 1709782, 150, 96, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(24, 36, 33, '2026-06-05', '21:30:00', '13:00:00', 165997, 12, 7, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(25, 2, 14, '2026-06-13', '19:00:00', '18:00:00', 123100, 80, 14, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(26, 6, 4, '2026-05-31', '21:30:00', '05:30:00', 269727, 40, 6, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(27, 14, 12, '2026-06-22', '08:00:00', '15:30:00', 375561, 50, 50, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(28, 25, 22, '2026-06-17', '10:30:00', '07:00:00', 1041992, 180, 150, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(29, 38, 37, '2026-06-25', '14:00:00', '18:00:00', 84264, 38, 38, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(30, 28, 26, '2026-06-04', '10:30:00', '18:00:00', 3631535, 180, 83, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(31, 10, 7, '2026-06-20', '14:00:00', '07:00:00', 150410, 80, 80, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(32, 6, 13, '2026-06-15', '10:30:00', '05:30:00', 264541, 80, 7, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(33, 1, 13, '2026-06-15', '10:30:00', '07:00:00', 261419, 80, 55, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(34, 22, 22, '2026-06-21', '14:00:00', '07:00:00', 1031679, 180, 83, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(35, 13, 5, '2026-06-14', '14:00:00', '05:30:00', 381318, 80, 34, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(36, 30, 26, '2026-06-01', '08:00:00', '07:00:00', 6038382, 180, 17, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(37, 15, 2, '2026-06-28', '14:00:00', '07:00:00', 517451, 106, 7, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(38, 17, 4, '2026-06-16', '19:00:00', '15:30:00', 225549, 40, 24, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(39, 33, 31, '2026-06-28', '19:00:00', '15:30:00', 257019, 40, 20, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(40, 37, 39, '2026-05-31', '21:30:00', '07:00:00', 91159, 43, 21, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(41, 18, 2, '2026-06-13', '19:00:00', '13:00:00', 191531, 106, 59, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(42, 38, 38, '2026-06-13', '21:30:00', '13:00:00', 79473, 40, 26, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(43, 9, 15, '2026-06-09', '14:00:00', '18:00:00', 102209, 50, 34, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(44, 30, 21, '2026-06-14', '10:30:00', '05:30:00', 6014286, 150, 66, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(45, 35, 32, '2026-06-02', '08:00:00', '13:00:00', 76891, 10, 10, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(46, 23, 23, '2026-06-04', '21:30:00', '05:30:00', 935213, 180, 27, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(47, 16, 12, '2026-05-31', '08:00:00', '18:00:00', 570695, 50, 5, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(48, 34, 39, '2026-06-10', '19:00:00', '05:30:00', 107920, 43, 8, '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(49, 14, 8, '2026-06-22', '08:00:00', '18:00:00', 349552, 80, 49, '2026-05-29 22:38:21', '2026-05-29 22:38:21'),
(50, 28, 27, '2026-06-02', '19:00:00', '18:00:00', 3789586, 160, 13, '2026-05-29 22:38:21', '2026-05-29 22:38:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `seat_bookings`
--

CREATE TABLE `seat_bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `schedule_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `coach_name` varchar(255) NOT NULL,
  `seat_number` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `transit_points`
--

CREATE TABLE `transit_points` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `route_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `stop_order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `transportations`
--

CREATE TABLE `transportations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jenis` enum('kereta','bus','pesawat') NOT NULL,
  `kelas` varchar(255) NOT NULL,
  `jumlah_kursi` int(11) NOT NULL,
  `status` enum('aktif','maintenance','nonaktif') NOT NULL DEFAULT 'aktif',
  `fasilitas` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transportations`
--

INSERT INTO `transportations` (`id`, `kode`, `nama`, `jenis`, `kelas`, `jumlah_kursi`, `status`, `fasilitas`, `created_at`, `updated_at`) VALUES
(1, 'KA-SNC', 'Sancaka', 'kereta', 'Eksekutif & Ekonomi Premium', 80, 'aktif', 'AC, Reclining Seat, Colokan Listrik, Toilet', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(2, 'KA-STJ', 'Sri Tanjung', 'kereta', 'Ekonomi', 106, 'aktif', 'AC Sentral, Stop Kontak, Toilet Bersih', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(3, 'KA-PRG', 'Progo', 'kereta', 'Ekonomi', 106, 'aktif', 'AC, Stop Kontak, Layanan Restorasi', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(4, 'KA-TKS', 'Taksaka', 'kereta', 'Eksekutif & Luxury', 40, 'aktif', 'Sleeper Seat, Wi-Fi, Personal TV, Minibar', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(5, 'KA-FJY', 'Fajar Utama YK', 'kereta', 'Eksekutif & Ekonomi Premium', 80, 'aktif', 'AC, Reclining Seat, Meja Lipat', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(6, 'KA-MBE', 'Malioboro Ekspres', 'kereta', 'Eksekutif & Ekonomi Plus', 80, 'aktif', 'AC, Gorden, Colokan Listrik, Bagasi Atas', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(7, 'KA-SJY', 'Senja Utama YK', 'kereta', 'Eksekutif & Ekonomi Premium', 80, 'aktif', 'AC, Bantal (Sewa), Lampu Baca, Toilet', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(8, 'KA-JSK', 'Joglosemarkerto', 'kereta', 'Ekonomi Plus', 80, 'aktif', 'AC, Charger Port, Kursi Hadap Depan', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(9, 'KA-PBW', 'Probowangi', 'kereta', 'Ekonomi', 106, 'aktif', 'AC Sentral, Gantungan Baju, Toilet', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(10, 'KA-PSD', 'Pasundan', 'kereta', 'Ekonomi', 106, 'aktif', 'AC, Stop Kontak per Kursi', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(11, 'KA-SGR', 'Songgoriti', 'kereta', 'Ekonomi Premium', 80, 'aktif', 'AC, Reclining Seat, Desain Modern', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(12, 'KA-AWL', 'Argo Wilis', 'kereta', 'Eksekutif & Priority', 50, 'aktif', 'Lounge Seat, Audio Video on Demand, Wi-Fi', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(13, 'KA-GBM', 'Gaya Baru Malam Selatan', 'kereta', 'Eksekutif & Ekonomi Plus', 80, 'aktif', 'AC, Kursi 2-2 Modifikasi, Toilet', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(14, 'KA-JKT', 'Jayakarta', 'kereta', 'Ekonomi Premium', 80, 'aktif', 'AC Sentral, Arm Rest, Port Charger', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(15, 'KA-BKT', 'Bangunkarta', 'kereta', 'Eksekutif & Priority', 50, 'aktif', 'AC, LCD TV, Snack & Minum, Selimut', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(16, 'KA-TRG', 'Turangga', 'kereta', 'Eksekutif', 50, 'aktif', 'AC, Reclining Seat Premium, Selimut, Bantal', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(17, 'KA-MTM', 'Mutiara Timur', 'kereta', 'Eksekutif & Ekonomi Premium', 80, 'aktif', 'AC, Kursi Nyaman, Restorasi Kuliner', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(18, 'KA-LDY', 'Lodaya', 'kereta', 'Eksekutif & Ekonomi Premium', 80, 'aktif', 'AC Sentral, Colokan Listrik, Gorden', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(19, 'KA-CRM', 'Ciremai', 'kereta', 'Eksekutif & Bisnis', 64, 'aktif', 'AC, Kursi Bisa Diputar (Bisnis), Toilet', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(20, 'KA-HRN', 'Harina', 'kereta', 'Eksekutif & Ekonomi Premium', 80, 'aktif', 'AC, Reclining Seat, Bagasi Luas', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(21, 'PW-GIA', 'Garuda Indonesia', 'pesawat', 'Ekonomi Premium', 150, 'aktif', 'In-flight Meals, Bagasi 20kg, Entertainment Screen, Selimut', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(22, 'PW-LNI', 'Lion Air', 'pesawat', 'Ekonomi', 180, 'aktif', 'Bagasi Kabin 7kg, Standard Ergonomic Seat', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(23, 'PW-CTV', 'Citilink', 'pesawat', 'Ekonomi', 180, 'aktif', 'Bagasi Kabin 7kg, Free Mineral Water, Air-conditioned Cabin', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(24, 'PW-BTK', 'Batik Air', 'pesawat', 'Bisnis', 120, 'aktif', 'Ruang Kaki Luas, Makanan Berat, USB Port, Prioritas Boarding', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(25, 'PW-SIA', 'Singapore Airlines', 'pesawat', 'Eksekutif Internasional', 200, 'aktif', 'Premium Dining, Wi-Fi Onboard, Layar Sentuh HD, International Plug', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(26, 'PW-SCO', 'Scoot', 'pesawat', 'Ekonomi Low Cost', 180, 'aktif', 'Baggage Purchase Option, Pre-book Meals, Clean Cabin', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(27, 'PW-MAS', 'Malaysia Airlines', 'pesawat', 'Ekonomi Premium', 160, 'aktif', 'In-flight Snack, Bagasi 20kg, Selimut, Bantal', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(28, 'PW-AXA', 'AirAsia', 'pesawat', 'Ekonomi Hot Seat', 180, 'aktif', 'Extra Legroom Option, Combo Meals Available, Cabin Baggage 7kg', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(29, 'PW-CPA', 'Cathay Pacific', 'pesawat', 'Bisnis Premium', 220, 'aktif', 'Flat-bed Seat, Luxury Dining, Noise-cancelling Headphones, Lounge Access', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(30, 'PW-ANA', 'All Nippon Airways (ANA)', 'pesawat', 'Eksekutif Luxury', 250, 'aktif', 'Japanese Hospitality, Five-star Dining, Premium Amenity Kit, Full Wi-Fi', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(31, 'BS-PMJ', 'Primajasa', 'bus', 'Eksekutif AC', 40, 'aktif', 'Full AC, Reclining Seat 2-2, Toilet, Smoking Area', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(32, 'BS-XTR', 'XTrans Travel', 'bus', 'Point-to-Point Shuttle', 10, 'aktif', 'AC, Captain Seat, Jalur Tol Bebas Hambatan', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(33, 'BS-CTT', 'Cititrans', 'bus', 'Executive Shuttle', 12, 'aktif', 'Premium Ergonomic Chair, USB Charger Port, Air Mineral', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(34, 'BS-NST', 'PO Nusantara', 'bus', 'VIP Class', 34, 'aktif', 'Full AC, Toilet, Leg Rest, Snack Box', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(35, 'BS-SJR', 'Sinar Jaya', 'bus', 'Suite Class Sleeper', 22, 'aktif', 'Full Sleeper Cabin, Personal TV, Bantal & Selimut, USB Port', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(36, 'BS-RSL', 'Rosalia Indah', 'bus', 'Super Top Double Decker', 30, 'aktif', 'Leg Rest, Sandaran Tangan, Service Makan Prasmanan, Toilet', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(37, 'BS-HDY', 'Handoyo', 'bus', 'Executive', 38, 'aktif', 'AC, Toilet, Reclining Seat 2-2, Selimut Malam', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(38, 'BS-EKA', 'EKA Cepat', 'bus', 'Executive AC', 40, 'aktif', 'Full AC, TV LCD, Makan Malam Gratis, Toilet', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(39, 'BS-SGH', 'Sugeng Rahayu', 'bus', 'Cepat Tarif Biasa', 43, 'aktif', 'AC Sentral, Audio Musik, Konfigurasi Seat 2-2', '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(40, 'BS-DMR', 'Damri', 'bus', 'Royal Class', 28, 'aktif', 'Kursi Mewah Lebar, Wi-Fi, Coffee Maker, Toilet, Leg Rest', '2026-05-29 22:38:20', '2026-05-29 22:38:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','penumpang') NOT NULL DEFAULT 'penumpang',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin Travelgo', 'admin@travelgo.com', NULL, '$2y$12$iP.dtDeDdTWUYC6iLRNK2eMEnF80zi83GVx4C2eD/noHHrskwJzCW', 'admin', NULL, '2026-05-29 22:38:18', '2026-05-29 22:38:18'),
(2, 'Budi Santoso', 'penumpang1@email.com', NULL, '$2y$12$KtQFUoHfW1duZRuWeVWvXem4rsBR9JlgHs8UwQj9gAzKA0fdSCwnG', 'penumpang', NULL, '2026-05-29 22:38:18', '2026-05-29 22:38:18'),
(3, 'Siti Aminah', 'penumpang2@email.com', NULL, '$2y$12$MnVtiRS.8skQUa7GWHYB6e.kIR84bV.6e5dcFLOh8qPqiRvsHbCTe', 'penumpang', NULL, '2026-05-29 22:38:19', '2026-05-29 22:38:19'),
(4, 'Ahmad Fauzi', 'penumpang3@email.com', NULL, '$2y$12$SmSs6ILnWIUE1G28b0zOlO9o3Z32gi/lVt3SlU/PkjVGqrTxCaoE6', 'penumpang', NULL, '2026-05-29 22:38:19', '2026-05-29 22:38:19'),
(5, 'Dewi Lestari', 'penumpang4@email.com', NULL, '$2y$12$u3wio/A4.fFR.5pMs8/9EeY.ylovFMBe1bM3TzfagIVav6OPv8fHy', 'penumpang', NULL, '2026-05-29 22:38:19', '2026-05-29 22:38:19'),
(6, 'Rian Hidayat', 'penumpang5@email.com', NULL, '$2y$12$2688ShA4Eq2S4ke5B.wVn.CcRgt4wb7Ov8in4p7yrKJeVhmNMYeSe', 'penumpang', NULL, '2026-05-29 22:38:19', '2026-05-29 22:38:19'),
(7, 'Mega Utami', 'penumpang6@email.com', NULL, '$2y$12$8dF5u4UHRbM8PJB7w4ZdTuE5DwtOshpBkIoEEE/7jF.5TjPm1PvPe', 'penumpang', NULL, '2026-05-29 22:38:19', '2026-05-29 22:38:19'),
(8, 'Eko Prasetyo', 'penumpang7@email.com', NULL, '$2y$12$tlXcXwEXowNaoBdrWy0JueYGKYR3NyS1CkJoFkzIPoubRyHtIhTvW', 'penumpang', NULL, '2026-05-29 22:38:19', '2026-05-29 22:38:19'),
(9, 'Anisa Putri', 'penumpang8@email.com', NULL, '$2y$12$Sh/w3wahJGLSeNH1PoOSK.yFfjAw9jwWKM2qX7hQxt0EVWD4nOpQi', 'penumpang', NULL, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(10, 'Rizky Ramadhan', 'penumpang9@email.com', NULL, '$2y$12$Z16NjoBnhirCzMAiZ7An9O9/QjkNcVCwNsgJKo8a6LsbO2ATraTae', 'penumpang', NULL, '2026-05-29 22:38:20', '2026-05-29 22:38:20'),
(11, 'Fitriani', 'penumpang10@email.com', NULL, '$2y$12$BkmquY//dGjzKgsMdA/jQ.Y.6qhpzQQtA9gKeONaT9YVZyb2sB24O', 'penumpang', NULL, '2026-05-29 22:38:20', '2026-05-29 22:38:20');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_code_unique` (`order_code`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_schedule_id_foreign` (`schedule_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indeks untuk tabel `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `routes_kode_rute_unique` (`kode_rute`);

--
-- Indeks untuk tabel `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedules_route_id_foreign` (`route_id`),
  ADD KEY `schedules_transportation_id_foreign` (`transportation_id`);

--
-- Indeks untuk tabel `seat_bookings`
--
ALTER TABLE `seat_bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seat_bookings_schedule_id_foreign` (`schedule_id`),
  ADD KEY `seat_bookings_order_id_foreign` (`order_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `transit_points`
--
ALTER TABLE `transit_points`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transit_points_route_id_foreign` (`route_id`);

--
-- Indeks untuk tabel `transportations`
--
ALTER TABLE `transportations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transportations_kode_unique` (`kode`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `routes`
--
ALTER TABLE `routes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `seat_bookings`
--
ALTER TABLE `seat_bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `transit_points`
--
ALTER TABLE `transit_points`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `transportations`
--
ALTER TABLE `transportations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_schedule_id_foreign` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_route_id_foreign` FOREIGN KEY (`route_id`) REFERENCES `routes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `schedules_transportation_id_foreign` FOREIGN KEY (`transportation_id`) REFERENCES `transportations` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `seat_bookings`
--
ALTER TABLE `seat_bookings`
  ADD CONSTRAINT `seat_bookings_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `seat_bookings_schedule_id_foreign` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transit_points`
--
ALTER TABLE `transit_points`
  ADD CONSTRAINT `transit_points_route_id_foreign` FOREIGN KEY (`route_id`) REFERENCES `routes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
