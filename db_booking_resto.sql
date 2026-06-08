-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 07, 2026 at 05:00 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_booking_resto`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `subject_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ai_chat_logs`
--

CREATE TABLE `ai_chat_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ai_response` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ai_chat_logs`
--

INSERT INTO `ai_chat_logs` (`id`, `user_message`, `ai_response`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, 'halo kak selamat malam', 'Halo Kak! Selamat malam juga! 😊 Apa yang bisa aku bantu hari ini di Booking Resto? Mau cari tempat makan yang lezat atau informasi tentang menu dan meja?', '127.0.0.1', '2026-06-06 16:17:10', '2026-06-06 16:17:10'),
(2, 'list ada minuman apa saja coy ?', 'Kak, di Booking Resto, ada beberapa minuman yang tersedia di Waroeng Jamboel. Berikut adalah list minuman:\n\n1. **Teh Panas/Es** - Rp 3.000  -> Status: Tersedia\n2. **Jeruk Panas/Es** - Rp 5.000  -> Status: Tersedia\n3. **Es Teller** - Rp 13.000  -> Status: Tersedia\n4. **Jus Alpukat** - Rp 10.000  -> Status: Tersedia\n5. **Jus Melon** - Rp 7.000  -> Status: Tersedia\n6. **Jus Jambu** - Rp 7.000  -> Status: Tersedia\n7. **Jus Tomat** - Rp 7.000  -> Status: Tersedia\n8. **Jus Wortel** - Rp 7.000  -> Status: Tersedia\n9. **Milo** - Rp 8.000  -> Status: Tersedia', '127.0.0.1', '2026-06-06 16:18:57', '2026-06-06 16:18:57'),
(3, 'pagi saya mau makan enaknya apa?', 'Halo Kak! 😊 Saya senang membantu kamu mencari makanan enak di Booking Resto!\n\nKamu bisa memilih salah satu dari beberapa pilihan restoran yang ada, seperti Waroeng Jamboel atau Lombok Barbar. Keduanya memiliki menu yang lezat dan unik.\n\nApakah kamu ingin mencoba menu di Waroeng Jamboel atau Lombok Barbar, Kak?', '127.0.0.1', '2026-06-07 00:14:14', '2026-06-07 00:14:14'),
(4, 'menunya ada apa saja kalau saya suka ayam', 'Kak! Kalau kamu suka ayam, ada beberapa menu yang bisa kamu coba di Waroeng Jamboel. Berikut beberapa opsi:\n\n* [Paket Ayam] Kremes/Goreng (Nasi+Teh/Es+Sambal Lalapan) - Rp 18.000 \n * Hidangan ini menawarkan ayam kremes atau goreng dengan nasi, teh atau es, dan sambal lalapan. Rasanya gurih dan lezat, cocok untuk kamu yang suka ayam.\n* [Paket Ayam] Geprek (Nasi+Teh/Es+Lalapan) - Rp 19.000\n * Menu ini menawarkan ayam geprek dengan nasi, teh atau es, dan lalapan. Ayam geprek memiliki rasa yang lebih berani dan cocok untuk kamu yang suka pedas.\n* [Ayam Kampung] Goreng - Rp 19.000\n * Hidangan ini menawarkan ayam kampung goreng yang lezat dan gurih. Cocok untuk kamu yang suka ayam goreng.\n* [Ayam Kampung] Bakar - Rp 20.000\n * Menu ini menawarkan ayam kampung bakar yang memiliki rasa yang lebih kompleks. Cocok untuk kamu yang suka ayam bakar.\n* [Ayam Kampung] Utuh Goreng - Rp 70.000\n * Hidangan ini menawarkan ayam kampung utuh goreng yang sangat lezat. Cocok untuk kamu yang suka ayam goreng dan ingin mencoba sesuatu yang lebih spesial.\n* [Ayam Kampung] Utuh Bakar - Rp 75.000\n * Menu ini menawarkan ayam kampung utuh bakar yang memiliki rasa yang sangat kompleks. Cocok untuk kamu yang suka ayam bakar dan ingin mencoba sesuatu yang lebih spesial.\n\nSemoga informasi ini membantu, Kak!', '127.0.0.1', '2026-06-07 00:14:57', '2026-06-07 00:14:57'),
(5, 'hallo selamat pagii coyy', 'Selamat pagi Kak! 😊 Senang sekali bisa membantu kamu hari ini! Apa yang bisa saya bantu? Mau tahu rekomendasi tempat makan atau meja yang tersedia?', '127.0.0.1', '2026-06-07 00:27:47', '2026-06-07 00:27:47'),
(6, 'untuk meja bagaimana kak ? pada resto jambul', 'Kak, saya cek ketersediaan meja di Waroeng Jamboel. 😊\n\nUntuk meja, kak, saya temukan beberapa opsi yang tersedia:\n\n- Meja 6 | Kapasitas: 4 orang | Area: Lantai 1 | Status: available\n- Meja 16 | Kapasitas: 4 orang | Area: Lantai 1 | Status: available\n- Meja 14 | Kapasitas: 4 orang | Area: Lantai 1 | Status: available\n- Meja 15 | Kapasitas: 4 orang | Area: Lantai 1 | Status: available\n- Meja 17 | Kapasitas: 4 orang | Area: Lantai 2 | Status: available\n- Meja 18 | Kapasitas: 4 orang | Area: Lantai 2 | Status: available\n- Meja 19 | Kapasitas: 4 orang | Area: Lantai 2 | Status: available\n- Meja 20 | Kapasitas: 4 orang | Area: Lantai 2 | Status: available\n- Meja 21 | Kapasitas: 4 orang | Area: Lantai 2 | Status: available\n- Meja 22 | Kapasitas: 4 orang | Area: Lantai 2 | Status: available\n- Meja 23 | Kapasitas: 4 orang | Area: Lantai 2 | Status: available\n- Meja 24 | Kapasitas: 4 orang | Area: Lantai 2 | Status: available\n- Meja Baru | Kapasitas: 4 orang | Area: Lantai 1 | Status: available\n- Joglo | Kapasitas: 0 orang | Area: Lantai 1 | Status: available\n- Meja 5 | Kapasitas: 4 orang | Area: Lantai 1 | Status: available\n- Meja 7 | Kapasitas: 4 orang | Area: Lantai 1 | Status: available\n- Meja 2 | Kapasitas: 4 orang | Area: Lantai 1 | Status: available\n- Meja 4 | Kapasitas: 4 orang | Area: Lantai 1 | Status: available\n- Meja 3 | Kapasitas: 4 orang | Area: Lantai 1 | Status: available\n- Meja 8 | Kapasitas: 6 orang | Area: Lantai 1 | Status: available\n- Meja 10 | Kapasitas: 6 orang | Area: Lantai 1 | Status: available\n- Meja 11 | Kapasitas: 6 orang | Area: Lantai 1 | Status: available\n- Meja 12 | Kapasitas: 6 orang | Area: Lantai 1 | Status: available\n- Meja 9 | Kapasitas: 6 orang | Area: Lantai 1 | Status: available', '127.0.0.1', '2026-06-07 00:28:11', '2026-06-07 00:28:11'),
(7, 'hallo bos siang begini enak makanan apa yang membuat kenyang', 'Hai Kak! 🌞 Makanan yang membuat kenyang biasanya memiliki karbohidrat, protein, dan lemak yang cukup untuk memenuhi kebutuhan energi tubuh. Berikut beberapa pilihan makanan yang dapat membuat kenyang di Waroeng Jamboel:\n\n1. **Paket Ayam**:\n * Ayam Goreng (Nasi+Teh/Es+Sambal Lalapan) - Rp 19.000 (Status: Tersedia)\n * Ayam Bakar (Nasi+Teh/Es+Sambal Lalapan) - Rp 20.000 (Status: Tersedia)\n2. **Paket Kakap**:\n * Kakap Goreng (Nasi+Teh/Es+Sambal Lalapan) - Rp 20.000 (Status: Tersedia)\n * Kakap Bakar (Nasi+Teh/Es+Sambal Lalapan) - Rp 20.000 (Status: Tersedia)\n3. **Paket Rombongan**:\n * Paket Ber 4 (Nasi 1 Bakul, Kakap Asam Manis, Ca Kangkung, Kepala/Ati Goreng, Teh) - Rp 100.000 (Status: Tersedia)\n4. **Bebek Utuh**:\n * Bebek Goreng - Rp 90.000 (Status: Tersedia)\n * Bebek Bakar - Rp 90.000 (Status: Tersedia)\n5. **Iga**:\n * Iga + Nasi - Rp 35.000 (Status: Tersedia)\n\nSemua makanan di atas dapat menjadi pilihan yang baik untuk membuat kenyang. Namun, jika Anda ingin yang lebih berat, saya sarankan untuk memilih **Paket Rombongan** atau **Bebek Utuh**.', '127.0.0.1', '2026-06-07 02:48:20', '2026-06-07 02:48:20'),
(8, 'hallo selamat siang', 'Halo Kak! 😊 Senang bisa membantu kamu hari ini! Apa yang ingin kamu tahu tentang restoran di Booking Resto? 🤔', '127.0.0.1', '2026-06-07 04:01:44', '2026-06-07 04:01:44'),
(9, 'aku meh tekon oleh raa ?', 'Maaf yach Kak, aku cuma bisa bantu soal makanan dan restoran di Booking Resto ya! Kalau ada pertanyaan tentang itu, aku siap bantu kok! 😊', '127.0.0.1', '2026-06-07 04:01:53', '2026-06-07 04:01:53'),
(10, 'aku meh tekon oleh raa?', 'Aku mlebu, Kak! 😊\n\nAku siap membantu kamu cari rekomendasi tempat makan yang lezat di sini. Apa yang kamu cari, Kak? Makanan apa yang kamu suka? Hayo, tanyalah aku! 🤗', '127.0.0.1', '2026-06-07 04:16:58', '2026-06-07 04:16:58');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba', 'i:1;', 1780805877),
('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba:timer', 'i:1780805877;', 1780805877);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint UNSIGNED NOT NULL,
  `restaurant_id` bigint UNSIGNED NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_menu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `harga` int NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `gambar_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `restaurant_id`, `kategori`, `nama_menu`, `deskripsi`, `harga`, `is_available`, `gambar_url`, `created_at`, `updated_at`) VALUES
(1, 1, 'Paket Ayam', 'Kremes/Goreng (Nasi+Teh/Es+Sambal Lalapan).', NULL, 18000, 1, '/menu/paket-ayam-kremes.jpg', '2026-05-15 22:45:41', '2026-05-22 05:34:25'),
(2, 1, 'Paket Ayam', 'Geprek (Nasi+Teh/Es+Lalapan)', NULL, 19000, 1, '/storage/menu_images/FypUt0a6EQ64sggp1EVZ22GBMvgmiWrNzulIKaaz.jpg', '2026-05-15 22:45:41', '2026-05-22 05:30:09'),
(3, 1, 'Paket Kakap', 'Bakar/Goreng (Nasi+Teh/Es+Sambal Lalapan)', NULL, 20000, 1, '/menu/paket-kakap-bakar.jpg', '2026-05-15 22:45:41', '2026-05-22 05:27:47'),
(4, 1, 'Paket Kakap Masak', 'Asam Manis/Mentega/Lada Hitam', NULL, 22000, 1, '/menu/paket-kakap-masak.jpg', '2026-05-15 22:45:41', '2026-05-15 22:45:41'),
(5, 1, 'Paket Rombongan', 'Paket Ber 4 (Nasi 1 Bakul, Kakap Asam Manis, Ca Kangkung, Kepala/Ati Goreng, Teh)', NULL, 100000, 1, '/menu/paket-ber-4.jpg', '2026-05-15 22:45:41', '2026-05-15 22:45:41'),
(6, 1, 'Gurame', 'Gurame Goreng', NULL, 28000, 1, '/menu/gurame-goreng.jpg', '2026-05-15 22:45:41', '2026-05-15 22:45:41'),
(7, 1, 'Gurame', 'Gurame Bakar', NULL, 32000, 1, '/storage/menu_images/GXUtOwcXrLdn6dh72ytZl2XtrS36Myq6lSGhdUou.jpg', '2026-05-15 22:45:41', '2026-05-24 16:35:05'),
(8, 1, 'Gurame', 'Gurame Telur Asin/Asam Manis', NULL, 39000, 1, '/storage/menu_images/S1bFyOraY63SAZA9n08DvZJLAvHfS3rrIx6xPubz.jpg', '2026-05-15 22:45:41', '2026-05-24 16:32:59'),
(9, 1, 'Cumi / Udang', 'Goreng Tepung', NULL, 20000, 1, '/menu/cumi-udang-tepung.jpg', '2026-05-15 22:45:41', '2026-05-15 22:45:41'),
(10, 1, 'Cumi / Udang', 'Masak (Asam Manis/Mentega/Lada Hitam)', NULL, 23000, 1, '/menu/cumi-udang-masak.jpg', '2026-05-15 22:45:41', '2026-05-15 22:45:41'),
(11, 1, 'Ayam Kampung', 'Goreng', NULL, 19000, 1, '/menu/ayam-kampung-goreng.jpg', '2026-05-15 22:45:41', '2026-05-15 22:45:41'),
(12, 1, 'Ayam Kampung', 'Bakar', NULL, 20000, 1, '/menu/ayam-kampung-bakar.jpg', '2026-05-15 22:45:41', '2026-05-15 22:45:41'),
(13, 1, 'Ayam Kampung', 'Utuh Goreng', NULL, 70000, 1, '/menu/ayam-kampung-utuh-goreng.jpg', '2026-05-15 22:45:41', '2026-05-15 22:45:41'),
(14, 1, 'Ayam Kampung', 'Utuh Bakar', NULL, 75000, 1, '/menu/ayam-kampung-utuh-bakar.jpg', '2026-05-15 22:45:41', '2026-05-15 22:45:41'),
(15, 1, 'Bebek Utuh', 'Goreng', NULL, 90000, 1, '/storage/menu_images/ZOqXNtbpsPC08tfHGs9o6UZpGqfuRSwk2roZs5Pp.jpg', '2026-05-15 22:45:41', '2026-05-24 16:29:41'),
(16, 1, 'Bebek Utuh', 'Bakar', NULL, 90000, 1, '/menu/bebek-utuh-bakar.jpg', '2026-05-15 22:45:41', '2026-05-15 22:45:41'),
(17, 1, 'Steak', 'Steak Ayam', NULL, 17000, 1, '/menu/steak-ayam.jpg', '2026-05-15 22:45:41', '2026-05-15 22:45:41'),
(18, 1, 'Steak', 'Steak Sapi', NULL, 20000, 1, '/storage/menu_images/XFSf4Lv06wYaLFfVTdck7WYMrCsEPtmgp3fI4wnZ.jpg', '2026-05-15 22:45:41', '2026-05-24 16:31:05'),
(19, 1, 'Steak', 'Steak Sapi Lada Hitam/Bistik', NULL, 24000, 1, '/menu/steak-sapi-lada-hitam.jpg', '2026-05-15 22:45:41', '2026-05-15 22:45:41'),
(20, 1, 'Sup', 'Sup Ikan', NULL, 17000, 1, '/menu/sup-ikan.jpg', '2026-05-15 22:45:41', '2026-05-21 05:17:02'),
(21, 1, 'Sup', 'Sup Ayam', NULL, 12000, 1, '/menu/sup-ayam.jpg', '2026-05-15 22:45:41', '2026-05-15 22:45:41'),
(22, 1, 'Iga', 'Iga + Nasi', NULL, 35000, 1, '/menu/iga-nasi.jpg', '2026-05-15 22:45:41', '2026-05-15 22:45:41'),
(23, 1, 'Lain-Lain', 'Jamur Crispy', NULL, 8000, 1, '/storage/menu_images/MfAMaZe2P3QOknObwxUMvmbfBzm3yTUmCmPaGFAk.jpg', '2026-05-15 22:45:41', '2026-05-24 16:31:42'),
(24, 1, 'Lain-Lain', 'Tahu Tempe', NULL, 3000, 1, '/menu/tahu-tempe.jpg', '2026-05-15 22:45:41', '2026-05-15 22:45:41'),
(25, 1, 'Lain-Lain', 'French Fries', NULL, 10000, 1, '/menu/french-fries.jpg', '2026-05-15 22:45:41', '2026-05-15 22:45:41'),
(26, 1, 'Lain-Lain', 'Sosis Goreng', NULL, 11000, 1, '/menu/sosis-goreng.jpg', '2026-05-15 22:45:41', '2026-05-15 22:45:41'),
(27, 1, 'Sayur', 'Ca Kangkung', NULL, 11000, 1, '/menu/ca-kangkung.jpg', '2026-05-15 22:45:41', '2026-05-15 22:45:41'),
(28, 1, 'Sayur', 'Capcay Kuah/Goreng', NULL, 14000, 1, '/menu/capcay.jpg', '2026-05-15 22:45:41', '2026-05-15 22:45:41'),
(29, 1, 'Sayur', 'Brokoli', NULL, 12000, 1, '/menu/brokoli.jpg', '2026-05-15 22:45:41', '2026-05-15 22:45:41'),
(30, 1, 'Minuman', 'Teh Panas/Es', NULL, 3000, 1, '/storage/menu_images/HCarvxb364qmH5DAloBMeEshsEYIdDoZD3WZ5aGO.jpg', '2026-05-15 22:45:41', '2026-05-24 16:33:26'),
(31, 1, 'Minuman', 'Jeruk Panas/Es', NULL, 5000, 1, '/menu/jeruk-es.jpg', '2026-05-15 22:45:41', '2026-05-15 22:45:41'),
(32, 1, 'Minuman', 'Es Teller', NULL, 13000, 1, '/menu/es-teller.jpg', '2026-05-15 22:45:41', '2026-05-15 22:45:41'),
(33, 1, 'Minuman', 'Jus Alpukat', NULL, 10000, 1, '/storage/menu_images/Pe2PELdbshz8MY9FkyuG9RU3FQThCULubpI6Gdq0.jpg', '2026-05-15 22:45:41', '2026-05-24 16:33:45'),
(34, 1, 'Minuman', 'Jus Melon', NULL, 7000, 1, '/storage/menu_images/WiuIBItfDNKUKfQwMmaFpVhOKCHD6tBFv8a5TRdw.jpg', '2026-05-15 22:45:41', '2026-05-24 16:34:23'),
(35, 1, 'Minuman', 'Jus Jambu', NULL, 7000, 1, '/storage/menu_images/Ih0wafMGAjoSL811YCuvCfR9pQ3QzCwLOzJE7v6r.jpg', '2026-05-15 22:45:41', '2026-05-24 16:34:03'),
(36, 1, 'Minuman', 'Jus Tomat', NULL, 7000, 1, '/menu/jus-tomat.jpg', '2026-05-15 22:45:41', '2026-05-15 22:45:41'),
(37, 1, 'Minuman', 'Jus Wortel', NULL, 7000, 1, '/menu/jus-wortel.jpg', '2026-05-15 22:45:41', '2026-05-15 22:45:41'),
(38, 1, 'Minuman', 'Milo', NULL, 8000, 1, '/menu/milo.jpg', '2026-05-15 22:45:41', '2026-05-15 22:45:41');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(10, '0001_01_01_000000_create_users_table', 1),
(11, '0001_01_01_000001_create_cache_table', 1),
(12, '0001_01_01_000002_create_jobs_table', 1),
(13, '2026_05_04_154553_create_personal_access_tokens_table', 1),
(14, '2026_05_05_000000_create_restaurants_table', 1),
(15, '2026_05_05_000001_create_tables_table', 1),
(16, '2026_05_06_150340_create_menus_table', 1),
(17, '2026_05_06_150346_create_reservations_table', 1),
(18, '2026_05_08_041054_create_reservation_items_table', 1),
(19, '2026_05_16_133549_add_user_id_to_restaurants_table', 2),
(20, '2026_05_16_154840_add_area_to_tables_table', 3),
(21, '2026_05_16_161359_upgrade_tables_for_visual_layout', 4),
(22, '2026_05_17_024427_add_details_to_menus_table', 5),
(23, '2026_05_21_134010_create_restaurant_galleries_table', 6),
(24, '2026_05_21_141957_add_operational_hours_to_restaurants_table', 7),
(25, '2026_05_21_144854_create_user_favorites_table', 8),
(26, '2026_05_23_113713_add_snap_token_to_reservations_table', 9),
(27, '2026_05_24_101421_add_phone_to_users_table', 10),
(28, '2026_05_24_150936_add_avatar_url_to_users_table', 11),
(29, '2026_05_25_122800_add_user_id_to_reservations_table', 12),
(30, '2026_05_25_194041_create_activity_logs_table', 13),
(31, '2026_05_26_110125_add_last_login_at_to_users_table', 14),
(32, '2026_05_27_202549_create_transactions_table', 15),
(33, '2026_05_27_203556_add_payment_method_to_reservations_table', 16),
(34, '2026_05_31_214600_create_settings_table', 17),
(35, '2026_06_06_231429_create_ai_chat_logs_table', 18),
(36, '2026_06_07_104324_add_is_served_to_reservation_items_table', 19);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 3, 'auth_token', 'cf7547ea7b048b218a1a22f8d00071b7e0d17992edefaae7cd53ec6e2a9e20df', '[\"*\"]', NULL, NULL, '2026-05-16 05:06:02', '2026-05-16 05:06:02'),
(2, 'App\\Models\\User', 2, 'auth_token', 'e0b448569a29b5df6dcb92048d16cfe552190139966c225faf2af0832464b9ec', '[\"*\"]', NULL, NULL, '2026-05-16 05:41:49', '2026-05-16 05:41:49'),
(3, 'App\\Models\\User', 2, 'auth_token', '7c531afd3933a2e3dc28716d49c942d4dd4da0bf85ddd07b4c6016f275964f25', '[\"*\"]', NULL, NULL, '2026-05-16 05:48:58', '2026-05-16 05:48:58'),
(4, 'App\\Models\\User', 2, 'auth_token', '9afa4c8556203b0f0f8b81b77b8b1933662e3cfc84610b0444e52684477a192e', '[\"*\"]', '2026-05-16 06:54:33', NULL, '2026-05-16 05:51:10', '2026-05-16 06:54:33'),
(6, 'App\\Models\\User', 2, 'auth_token', 'ea3584dae27fb2bfb35adcfb58c0930b8ae87255f39f1cb82279b63e7843c85a', '[\"*\"]', '2026-05-16 22:11:18', NULL, '2026-05-16 07:13:02', '2026-05-16 22:11:18'),
(8, 'App\\Models\\User', 3, 'auth_token', '6b17bc0d9a526e27adbb18a6c9fd17c9a1874a5405484a202527bf35a566a60d', '[\"*\"]', '2026-05-17 22:31:53', NULL, '2026-05-17 09:18:59', '2026-05-17 22:31:53'),
(9, 'App\\Models\\User', 2, 'auth_token', '6d9819f2aaa87804adf389b32b7d1da1a407c63f4fcc30702ee2004df640d051', '[\"*\"]', '2026-05-17 22:37:26', NULL, '2026-05-17 22:36:55', '2026-05-17 22:37:26'),
(10, 'App\\Models\\User', 3, 'auth_token', '9512b2a636cea2f93470b48c221ff628414fdc71417453e4ab8bc7dd991ff8ed', '[\"*\"]', '2026-05-17 22:38:30', NULL, '2026-05-17 22:37:50', '2026-05-17 22:38:30'),
(12, 'App\\Models\\User', 3, 'auth_token', '57e54aa518f67016514aa654909442f1444b9f72f61173beaf9929f2914277d9', '[\"*\"]', '2026-05-17 23:11:55', NULL, '2026-05-17 23:09:25', '2026-05-17 23:11:55'),
(13, 'App\\Models\\User', 2, 'auth_token', '15925d56442c214b9bd3fb8d6863b7111800018b3cfe0bccfdf66002981d55d0', '[\"*\"]', '2026-05-17 23:18:07', NULL, '2026-05-17 23:12:21', '2026-05-17 23:18:07'),
(14, 'App\\Models\\User', 3, 'auth_token', '2c7fa0323b9ce3c838e496fad75b76c74ac6d38face8df16ab228994dde1fd10', '[\"*\"]', '2026-05-24 02:58:11', NULL, '2026-05-21 05:14:10', '2026-05-24 02:58:11'),
(17, 'App\\Models\\User', 3, 'auth_token', 'c7550ec09a1697e360da31b7f8a9714a35c3984f7ac291ff3fe63f7e0c97f7e4', '[\"*\"]', '2026-05-24 05:32:11', NULL, '2026-05-24 03:30:31', '2026-05-24 05:32:11'),
(18, 'App\\Models\\User', 4, 'auth_token', '495978e483d569026c7f72588d795347ab122a80ae17adf980b75b2cb9e441e0', '[\"*\"]', '2026-05-24 05:43:25', NULL, '2026-05-24 05:42:50', '2026-05-24 05:43:25'),
(19, 'App\\Models\\User', 3, 'auth_token', 'c748856ca936294d9aa7469cf901531f0fcc6e9962eeb6d5e8e942a9722e132d', '[\"*\"]', '2026-05-24 05:46:04', NULL, '2026-05-24 05:43:45', '2026-05-24 05:46:04'),
(20, 'App\\Models\\User', 4, 'auth_token', 'ac71f3e904b8c8a7b3cf371d828a0917e6ac6650d887c8f612557fde1a44930f', '[\"*\"]', '2026-05-25 05:29:41', NULL, '2026-05-24 05:46:22', '2026-05-25 05:29:41'),
(21, 'App\\Models\\User', 2, 'auth_token', 'c1756ac11e0bed4f50f117cf3b38d5038873733732a3c944a3f034219c36f779', '[\"*\"]', '2026-05-24 08:44:10', NULL, '2026-05-24 08:37:22', '2026-05-24 08:44:10'),
(22, 'App\\Models\\User', 7, 'auth_token', '26566459f4b3f81a4891680df4509affa2ce2987471e1d59292e74cdda661f29', '[\"*\"]', '2026-05-24 08:47:15', NULL, '2026-05-24 08:44:43', '2026-05-24 08:47:15'),
(23, 'App\\Models\\User', 2, 'auth_token', 'f05f091e12a3bc9bcfef1843bb9c335e8d7ac566e5691f5df188692f894aad44', '[\"*\"]', '2026-05-25 05:34:22', NULL, '2026-05-24 08:47:21', '2026-05-25 05:34:22'),
(24, 'App\\Models\\User', 8, 'auth_token', 'e943cc1cb062ebfa43c550c21106b34b0ee377d49718197f400adf5bbaab100a', '[\"*\"]', '2026-05-24 08:53:47', NULL, '2026-05-24 08:49:49', '2026-05-24 08:53:47'),
(25, 'App\\Models\\User', 3, 'auth_token', 'a8bdda948d7d3656dd5564e5b1fa80e08b13fa691e553514628021fbc94607d0', '[\"*\"]', '2026-05-30 08:42:46', NULL, '2026-05-25 05:29:54', '2026-05-30 08:42:46'),
(26, 'App\\Models\\User', 2, 'auth_token', 'e9859202b8ed6d52566b50cde909d7c13f75c59a719ceaca8bd5d3957e55b3f4', '[\"*\"]', '2026-05-25 12:25:28', NULL, '2026-05-25 05:34:36', '2026-05-25 12:25:28'),
(27, 'App\\Models\\User', 9, 'auth_token', '52b4857ec2c11f3704fd1538a581f002c507490b3905f817d973fb309f115bf1', '[\"*\"]', NULL, NULL, '2026-05-25 12:25:56', '2026-05-25 12:25:56'),
(28, 'App\\Models\\User', 9, 'auth_token', '5031aed57e4bcb54521c8f6043c2dd78ad15b8ba90d690d3d401b36c834530a7', '[\"*\"]', '2026-05-25 12:55:57', NULL, '2026-05-25 12:30:28', '2026-05-25 12:55:57'),
(29, 'App\\Models\\User', 9, 'auth_token', '9440c0582dd2c6043432f586efa4f556f13a1365db1e6b7e324dd26eb1456edd', '[\"*\"]', '2026-05-25 14:33:08', NULL, '2026-05-25 12:56:01', '2026-05-25 14:33:08'),
(31, 'App\\Models\\User', 9, 'auth_token', 'e78412f62f0b12017e217a154cfb51800f9a99754ae4298ec7e3ff1ba56701a4', '[\"*\"]', '2026-05-26 03:06:33', NULL, '2026-05-25 14:36:06', '2026-05-26 03:06:33'),
(33, 'App\\Models\\User', 9, 'auth_token', '8a220c64fe259cd4297af662d1cfe30b8ec8142d1813657c7c6a6e2984b5cebf', '[\"*\"]', '2026-05-26 03:34:37', NULL, '2026-05-26 03:30:08', '2026-05-26 03:34:37'),
(35, 'App\\Models\\User', 9, 'auth_token', '31cf4d7311e6afc63bd34d8ea830dd9f0a98a6913b5707f3565fe7c051455af2', '[\"*\"]', '2026-05-26 04:18:27', NULL, '2026-05-26 03:38:35', '2026-05-26 04:18:27'),
(36, 'App\\Models\\User', 9, 'auth_token', 'ee206b8ec39727d561827f80636661c097d0a969507e3af04e932cc3db0c9f62', '[\"*\"]', '2026-05-26 04:20:47', NULL, '2026-05-26 04:19:09', '2026-05-26 04:20:47'),
(37, 'App\\Models\\User', 9, 'auth_token', '00accac50baac3dc0016fb4a53bcb899dbe807a0ccf6676ba7335b09a9351f94', '[\"*\"]', '2026-05-26 06:46:09', NULL, '2026-05-26 04:21:33', '2026-05-26 06:46:09'),
(38, 'App\\Models\\User', 9, 'auth_token', 'b5359d8556546b9cc145027472a8553f2bfbc688ead59d350321ce1910a1de78', '[\"*\"]', '2026-05-27 12:59:35', NULL, '2026-05-26 06:46:22', '2026-05-27 12:59:35'),
(39, 'App\\Models\\User', 9, 'auth_token', '9c2c03743638412bd2c0d7f75b0396425ce94978d9fa4f10c6e5934ef3263ea9', '[\"*\"]', '2026-05-27 14:33:01', NULL, '2026-05-27 12:59:42', '2026-05-27 14:33:01'),
(40, 'App\\Models\\User', 9, 'auth_token', '2f3fc997022b2ea855c85b8c4fbb7676b5fa022724e89cbb9f881e8fa3610283', '[\"*\"]', '2026-05-30 08:53:35', NULL, '2026-05-27 14:33:06', '2026-05-30 08:53:35'),
(41, 'App\\Models\\User', 3, 'auth_token', '89824c6e964ca771dcfa1631b83d5939727978ae08297f81ff2c34c391574ef4', '[\"*\"]', '2026-06-03 12:03:42', NULL, '2026-05-30 08:45:20', '2026-06-03 12:03:42'),
(43, 'App\\Models\\User', 9, 'auth_token', '893c4808da08085b34e7181d20150fcd223bf7c19d6b8567053c3e2713193f05', '[\"*\"]', '2026-05-31 02:18:02', NULL, '2026-05-30 09:11:32', '2026-05-31 02:18:02'),
(44, 'App\\Models\\User', 9, 'auth_token', '4ef6903a1a009052a51bdffa28bd2c18960041c5caa4baa9fbb3a8615b60a1d9', '[\"*\"]', '2026-05-31 11:52:29', NULL, '2026-05-31 02:19:13', '2026-05-31 11:52:29'),
(45, 'App\\Models\\User', 9, 'auth_token', 'f107d7c1c09e0e9a7abae81c19f91a633cc2f7d4e4f09fa6e81a3c942309c71c', '[\"*\"]', '2026-06-03 05:10:22', NULL, '2026-05-31 11:52:34', '2026-06-03 05:10:22'),
(46, 'App\\Models\\User', 9, 'auth_token', 'a53b7cb9ee8cdb5a8430b0e4446d728ee448a8ae854d56370be66cb9f2227a0b', '[\"*\"]', '2026-06-03 12:43:03', NULL, '2026-06-03 05:14:17', '2026-06-03 12:43:03'),
(47, 'App\\Models\\User', 3, 'auth_token', '607ea8ba08627664a19bbb1ab893604af791859d73d4cc531c9a4cf6841d0006', '[\"*\"]', '2026-06-07 00:27:15', NULL, '2026-06-03 12:05:00', '2026-06-07 00:27:15'),
(49, 'App\\Models\\User', 9, 'auth_token', 'f6e73994857241a8f60291f92890cd2bc9d802a9c1dd89b3a3c3b2f800dcf914', '[\"*\"]', '2026-06-03 12:50:54', NULL, '2026-06-03 12:43:06', '2026-06-03 12:50:54'),
(50, 'App\\Models\\User', 9, 'auth_token', '491e48aa6d5b1f29a62bf6bd68dbc01b0160385fd3fc2a372086687bb6888028', '[\"*\"]', '2026-06-04 13:16:00', NULL, '2026-06-03 13:01:57', '2026-06-04 13:16:00'),
(51, 'App\\Models\\User', 2, 'auth_token', '262d7877e69c6bf31cf5b354b7e8890f8a81b453220b3d2481926fcccb0d74d2', '[\"*\"]', '2026-06-03 13:02:28', NULL, '2026-06-03 13:02:23', '2026-06-03 13:02:28'),
(52, 'App\\Models\\User', 9, 'auth_token', 'cc8fdeeb9226a4bcd6f6719078d16df63aa02eb3f3a3ee1da294b38866817b81', '[\"*\"]', '2026-06-06 04:05:56', NULL, '2026-06-04 13:17:42', '2026-06-06 04:05:56'),
(53, 'App\\Models\\User', 9, 'auth_token', 'a39c7479660006472a0c71ac500de6b37e238555db9e0d2b008303aa76008982', '[\"*\"]', '2026-06-06 05:13:30', NULL, '2026-06-06 04:07:33', '2026-06-06 05:13:30'),
(54, 'App\\Models\\User', 2, 'auth_token', '3999036507bbc0d65e1f46327c6dc3d414249eb6a222bd1f5caca6f58645c103', '[\"*\"]', '2026-06-07 04:44:55', NULL, '2026-06-06 05:13:41', '2026-06-07 04:44:55'),
(55, 'App\\Models\\User', 3, 'auth_token', 'c264031f6964ed018a87811bd7daf26c9fa688893825751c919492137e4efc1c', '[\"*\"]', '2026-06-07 04:48:41', NULL, '2026-06-07 00:27:29', '2026-06-07 04:48:41');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `restaurant_id` bigint UNSIGNED NOT NULL,
  `table_id` bigint UNSIGNED DEFAULT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reservation_date` date NOT NULL,
  `reservation_time` time NOT NULL,
  `guests` int NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `subtotal` int NOT NULL DEFAULT '0',
  `tax` int NOT NULL DEFAULT '0',
  `service_charge` int NOT NULL DEFAULT '0',
  `total_price` int NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `restaurant_id`, `table_id`, `customer_name`, `customer_email`, `customer_phone`, `reservation_date`, `reservation_time`, `guests`, `notes`, `subtotal`, `tax`, `service_charge`, `total_price`, `status`, `payment_method`, `payment_url`, `snap_token`, `created_at`, `updated_at`) VALUES
(51, 3, 1, 33, 'Ahmad Saboli', NULL, '087822916072', '2026-06-06', '19:00:00', 2, NULL, 36000, 3960, 1800, 41760, 'completed', 'Bank Transfer', NULL, '1832ff56-ea10-4a03-a0f6-483f1ed6f2ca', '2026-06-06 03:36:33', '2026-06-07 02:25:58'),
(52, 3, 1, 24, 'Ahmad Saboli2', NULL, '0878123192838', '2026-06-07', '11:00:00', 4, 'jangan pedas-pedas', 38000, 4180, 1900, 44080, 'completed', 'Bank Transfer', NULL, 'de633a56-a581-44ff-8c69-bf010efff3d9', '2026-06-07 02:50:54', '2026-06-07 02:56:22'),
(53, 3, 1, 27, 'Fikri', NULL, '082342342352', '2026-06-07', '19:00:00', 2, NULL, 38000, 4180, 1900, 44080, 'dine_in', 'Bank Transfer', NULL, 'f2db6770-9629-411c-a306-2e92b3509356', '2026-06-07 03:22:34', '2026-06-07 03:28:58');

-- --------------------------------------------------------

--
-- Table structure for table `reservation_items`
--

CREATE TABLE `reservation_items` (
  `id` bigint UNSIGNED NOT NULL,
  `reservation_id` bigint UNSIGNED NOT NULL,
  `menu_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int NOT NULL,
  `quantity` int NOT NULL,
  `is_served` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservation_items`
--

INSERT INTO `reservation_items` (`id`, `reservation_id`, `menu_name`, `price`, `quantity`, `is_served`, `created_at`, `updated_at`) VALUES
(63, 51, 'Kremes/Goreng (Nasi+Teh/Es+Sambal Lalapan).', 18000, 2, 0, '2026-06-06 03:36:33', '2026-06-06 03:36:33'),
(64, 52, 'Geprek (Nasi+Teh/Es+Lalapan)', 19000, 2, 0, '2026-06-07 02:50:54', '2026-06-07 02:50:54'),
(65, 53, 'Geprek (Nasi+Teh/Es+Lalapan)', 19000, 2, 1, '2026-06-07 03:22:34', '2026-06-07 03:22:34');

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_range` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` double NOT NULL DEFAULT '0',
  `reviews_count` int NOT NULL DEFAULT '0',
  `address` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `open_time` time DEFAULT NULL,
  `close_time` time DEFAULT NULL,
  `time_interval` int NOT NULL DEFAULT '60',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`id`, `user_id`, `name`, `slug`, `category`, `price_range`, `rating`, `reviews_count`, `address`, `image`, `description`, `open_time`, `close_time`, `time_interval`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'Waroeng Jamboel', 'waroeng-jamboel', 'Restorant', '$', 4.8, 124, 'Jl. Solo-Purwodadi Km 20, Gemolong, Sragen, Jawa tengah', 'restaurants/covers/IBRUAviaQqKJghsfkQhcJye3wEuN0cJUCBXeplFr.jpg', 'Menyajikan kekayaan rasa Nusantara dengan sentuhan modern yang elegan. Waroeng Jamboel menawarkan pengalaman bersantap eksklusif di mana setiap hidangan menceritakan kisah tradisi yang dipadukan dengan teknik memasak kontemporer. Nikmati suasana yang hangat dan mewah, cocok untuk makan malam romantis, pertemuan bisnis, atau perayaan istimewa.', '09:00:00', '21:00:00', 60, 'open', '2026-05-12 08:16:05', '2026-06-03 08:55:01'),
(3, 8, 'Lombok Barbar', 'lombok-barbar', 'Vegetarian', '$$', 4.8, 120, 'Solo, Jawa Tengah', 'restaurants/covers/cMKIZojGADmaZmich8uW8jNraQUMZC71RLx1NHEn.jpg', 'Restoran dengan sambal super pedas khas Kalijambe.', '09:00:00', '22:00:00', 60, 'open', '2026-05-24 08:48:14', '2026-06-03 08:54:22'),
(5, 10, 'Sambel Obong', 'sambel-obong', 'Cafe & Coffee Shop', '$', 0, 0, 'Lorem Ipsum', NULL, 'Lorem Ipsum', '09:00:00', '22:00:00', 60, 'open', '2026-06-03 08:56:53', '2026-06-03 12:14:17');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_galleries`
--

CREATE TABLE `restaurant_galleries` (
  `id` bigint UNSIGNED NOT NULL,
  `restaurant_id` bigint UNSIGNED NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `restaurant_galleries`
--

INSERT INTO `restaurant_galleries` (`id`, `restaurant_id`, `image_url`, `created_at`, `updated_at`) VALUES
(4, 1, 'restaurants/galleries/Nqk6XQCYIzkamyoxIladjaB0ZgDJCD62sbZC4G3r.jpg', '2026-05-24 04:07:21', '2026-05-24 04:07:21'),
(6, 1, 'restaurants/galleries/F1FmH2Bel906OexdSugoQWda9DwfXCeA0j7K9zOJ.jpg', '2026-05-24 04:08:55', '2026-05-24 04:08:55'),
(7, 1, 'restaurants/galleries/k6WmHfZUnBjH8uwP59wEmQeNRHIESIJMewj6HqeV.jpg', '2026-05-24 04:09:09', '2026-05-24 04:09:09'),
(8, 1, 'restaurants/galleries/ai5RTALt2VD58GlvhPV0lGgXu8QJj98avDprFcek.jpg', '2026-05-24 04:09:19', '2026-05-24 04:09:19'),
(9, 1, 'restaurants/galleries/ecnExqVQ9snAKkWxVX8G28PH9kgO4MZnw0cyGnII.jpg', '2026-05-24 04:17:16', '2026-05-24 04:17:16'),
(10, 1, 'restaurants/galleries/7BJvixb6B2EmQVbPYrPgGXADrHzxgyWiubycxDL1.jpg', '2026-05-24 04:17:25', '2026-05-24 04:17:25');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `platform_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'BookingResto Admin',
  `contact_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin@bookingresto.com',
  `whatsapp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '+62 812-3456-7890',
  `tax_rate` decimal(5,2) NOT NULL DEFAULT '10.00',
  `is_maintenance` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `service_rate` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `platform_name`, `contact_email`, `whatsapp`, `tax_rate`, `is_maintenance`, `created_at`, `updated_at`, `service_rate`) VALUES
(1, 'Booking Resto', 'admin@bookingresto.com', '+62 812-3456-7890', 11.00, 0, '2026-05-31 14:55:41', '2026-06-04 14:19:15', 5);

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `id` bigint UNSIGNED NOT NULL,
  `restaurant_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `area` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Lantai 1',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `pos_x` double NOT NULL DEFAULT '0',
  `pos_y` double NOT NULL DEFAULT '0',
  `width` int NOT NULL DEFAULT '100',
  `height` int NOT NULL DEFAULT '100',
  `shape` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'rectangle',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`id`, `restaurant_id`, `name`, `capacity`, `area`, `status`, `pos_x`, `pos_y`, `width`, `height`, `shape`, `created_at`, `updated_at`) VALUES
(1, 1, 'Meja 6', '4', 'Lantai 1', 'available', 10.066893021842, 55.235576923077, 67, 66, 'rectangle', NULL, '2026-06-03 12:12:37'),
(3, 1, 'Meja 16', '4', 'Lantai 1', 'available', 42.955900493421, 86.100961538462, 91, 54, 'rectangle', NULL, '2026-06-03 12:12:37'),
(4, 1, 'Meja 14', '4', 'Lantai 1', 'available', 79.435649671053, 85.860576923077, 86, 53, 'rectangle', NULL, '2026-06-03 12:12:37'),
(5, 1, 'Meja 15', '4', 'Lantai 1', 'available', 61.114823190789, 85.807692307692, 92, 55, 'rectangle', NULL, '2026-06-03 12:12:37'),
(21, 1, 'Meja 17', '4', 'Lantai 2', 'available', 6.9622128920721, 10.456730769231, 56, 95, 'rectangle', '2026-05-17 09:03:03', '2026-06-03 12:12:37'),
(22, 1, 'Meja 18', '4', 'Lantai 2', 'available', 19.627068411954, 10.699519230769, 50, 92, 'rectangle', '2026-05-17 09:03:49', '2026-06-03 12:12:37'),
(23, 1, 'Meja 19', '4', 'Lantai 2', 'available', 31.662138799704, 10.682692307692, 53, 94, 'rectangle', '2026-05-17 09:04:39', '2026-06-03 12:12:37'),
(24, 1, 'Meja 20', '4', 'Lantai 2', 'available', 43.75154359101, 10.314903846154, 59, 97, 'rectangle', '2026-05-17 09:05:54', '2026-06-07 02:50:54'),
(25, 1, 'Meja 21', '4', 'Lantai 2', 'available', 56.764633242776, 32.632211538462, 59, 112, 'rectangle', '2026-05-17 09:08:56', '2026-06-03 12:12:37'),
(26, 1, 'Meja 22', '4', 'Lantai 2', 'available', 70.577920474191, 32.78125, 58, 105, 'rectangle', '2026-05-17 09:09:16', '2026-06-03 12:12:37'),
(27, 1, 'Meja 23', '4', 'Lantai 2', 'occupied', 64.934551741171, 55.326923076923, 61, 106, 'rectangle', '2026-05-17 09:09:36', '2026-06-07 03:22:34'),
(28, 1, 'Meja 24', '4', 'Lantai 2', 'available', 65.208693504569, 78.40625, 61, 105, 'rectangle', '2026-05-17 09:10:23', '2026-06-03 12:12:37'),
(29, 1, 'Meja Baru', '4', 'Lantai 1', 'available', 79.250616776316, 72.740384615385, 81, 56, 'rectangle', '2026-05-17 09:12:18', '2026-06-03 12:12:37'),
(30, 1, 'Joglo', '0', 'Lantai 1', 'available', 24.048828125, 34.276442307692, 406, 317, 'zone', '2026-05-22 00:38:02', '2026-06-03 12:12:37'),
(31, 1, 'Meja 5', '4', 'Lantai 1', 'available', 9.5423909187655, 70.09375, 72, 65, 'rectangle', '2026-05-22 00:39:00', '2026-06-03 12:12:37'),
(32, 1, 'Meja 7', '4', 'Lantai 1', 'available', 10.39122282471, 40.545673076923, 70, 66, 'rectangle', '2026-05-22 00:45:15', '2026-06-03 12:12:37'),
(33, 1, 'Meja 1', '4', 'Lantai 1', 'available', 10.173313738408, 20.641826923077, 61, 63, 'rectangle', '2026-05-22 00:45:40', '2026-06-06 03:36:33'),
(34, 1, 'Meja 2', '4', 'Lantai 1', 'available', 10.414027263974, 6.6802884615385, 64, 64, 'rectangle', '2026-05-22 00:46:40', '2026-06-03 12:12:37'),
(35, 1, 'Meja 4', '4', 'Lantai 1', 'available', 26.255511072822, 7.1682692307692, 64, 62, 'rectangle', '2026-05-22 00:47:47', '2026-06-03 12:12:37'),
(36, 1, 'Meja 3', '4', 'Lantai 1', 'available', 26.255511072822, 21.132211538462, 63, 63, 'rectangle', '2026-05-22 00:48:09', '2026-06-03 12:12:37'),
(37, 1, 'Meja 8', '6', 'Lantai 1', 'available', 30.066386256525, 49.064903846154, 50, 199, 'rectangle', '2026-05-22 00:48:44', '2026-06-03 12:12:37'),
(38, 1, 'Meja 10', '6', 'Lantai 1', 'available', 42.003243298029, 52.079326923077, 50, 180, 'rectangle', '2026-05-22 00:49:08', '2026-06-03 12:12:37'),
(39, 1, 'Meja 11', '6', 'Lantai 1', 'available', 53.585364617646, 51.668269230769, 50, 180, 'rectangle', '2026-05-22 00:49:42', '2026-06-03 12:12:37'),
(41, 1, 'Meja 12', '6', 'Lantai 1', 'available', 64.782344296356, 48.637019230769, 50, 204, 'rectangle', '2026-05-22 00:51:21', '2026-06-03 12:12:37'),
(42, 1, 'Meja 9', '6', 'Lantai 1', 'available', 42.593624892312, 41.295673076923, 113, 50, 'rectangle', '2026-05-22 00:52:07', '2026-06-03 12:12:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `role` enum('superadmin','adminresto','customer') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `avatar_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `status`, `last_login_at`, `role`, `image`, `remember_token`, `created_at`, `updated_at`, `avatar_url`) VALUES
(1, 'Super Admin Boli', 'superadmin@gmail.com', NULL, NULL, '$2y$12$ntFoU6PwauPl11qU2LSKL.OawGEnrXDqbhclZnrE7KFM7l3CZK8J.', 'suspend', NULL, 'superadmin', NULL, NULL, '2026-05-16 05:05:56', '2026-05-26 04:48:05', NULL),
(2, 'Admin Resto Waroeng ', 'admin.waroengjamboel@gmail.com', NULL, NULL, '$2y$12$yeKWnZ3jaMEBSjGU/6QL1eaSnLJmOh.p.GAsZLaXABVYegaw/RAdG', 'active', '2026-06-06 05:13:41', 'adminresto', NULL, NULL, '2026-05-16 05:05:56', '2026-06-06 05:13:41', NULL),
(3, 'Customer Setia', 'customer@gmail.com', NULL, NULL, '$2y$12$HyLufoEOrm/VIIJ63/I4D.p5VXiXrX5B.8OVnYYLrXbmyRgrxOcpG', 'active', '2026-06-07 00:27:29', 'customer', NULL, NULL, '2026-05-16 05:05:57', '2026-06-07 00:27:29', NULL),
(4, 'Ahmad Saboli', 'ahmadsaboli@gmail.com', '087822916072', NULL, '$2y$12$nVS7GMeghCp.XEOtxP8pXO6OBNFKyBSkyR8VW09ydMe2G/kR7bBYO', 'active', NULL, 'customer', NULL, NULL, '2026-05-24 05:42:50', '2026-05-24 08:10:37', '/storage/avatars/M98uGj2K9qDR0MBMd1QMd2FHGJAbtHHU7oDkZ2nI.jpg'),
(8, 'Pemilik Lombok Barbar', 'admin.lombokbarbar@gmail.com', '081234567890', NULL, '$2y$12$ZtMBas.ua9IuIhUN/cre7OLuyjWAjxJyzdEYUAj27vIcuMQhqtK1q', 'active', NULL, 'adminresto', NULL, NULL, '2026-05-24 08:48:14', '2026-05-24 08:48:14', NULL),
(9, 'Super Admin Bookingresto', 'superadminbookingresto@gmail.com', '080000000000', NULL, '$2y$12$Zq784FNFnxU/RAa5pT8LxubQGmANGODvCURcPgZSqJDq8.5p2kryi', 'active', '2026-06-06 04:07:33', 'superadmin', NULL, NULL, '2026-05-25 12:24:13', '2026-06-06 04:07:33', NULL),
(10, 'Admin Sambel Obong', 'adminsambelobong@gmail.com', NULL, NULL, '$2y$12$sTSKK.V4Gw1PFV5xbmLdtuDYtu2UFkEdAjrj7hVk8GXvbZX3LcmP.', 'active', NULL, 'adminresto', NULL, NULL, '2026-06-03 06:00:37', '2026-06-03 08:57:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_favorites`
--

CREATE TABLE `user_favorites` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `restaurant_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_favorites`
--

INSERT INTO `user_favorites` (`id`, `user_id`, `restaurant_id`, `created_at`, `updated_at`) VALUES
(9, 3, 1, '2026-05-24 04:18:23', '2026-05-24 04:18:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ai_chat_logs`
--
ALTER TABLE `ai_chat_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menus_restaurant_id_foreign` (`restaurant_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservations_restaurant_id_foreign` (`restaurant_id`),
  ADD KEY `reservations_table_id_foreign` (`table_id`),
  ADD KEY `reservations_user_id_foreign` (`user_id`);

--
-- Indexes for table `reservation_items`
--
ALTER TABLE `reservation_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservation_items_reservation_id_foreign` (`reservation_id`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `restaurants_slug_unique` (`slug`),
  ADD KEY `restaurants_user_id_foreign` (`user_id`);

--
-- Indexes for table `restaurant_galleries`
--
ALTER TABLE `restaurant_galleries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restaurant_galleries_restaurant_id_foreign` (`restaurant_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tables_restaurant_id_foreign` (`restaurant_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_favorites`
--
ALTER TABLE `user_favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_favorites_user_id_restaurant_id_unique` (`user_id`,`restaurant_id`),
  ADD KEY `user_favorites_restaurant_id_foreign` (`restaurant_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ai_chat_logs`
--
ALTER TABLE `ai_chat_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `reservation_items`
--
ALTER TABLE `reservation_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `restaurant_galleries`
--
ALTER TABLE `restaurant_galleries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_favorites`
--
ALTER TABLE `user_favorites`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_restaurant_id_foreign` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_restaurant_id_foreign` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_table_id_foreign` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reservations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `reservation_items`
--
ALTER TABLE `reservation_items`
  ADD CONSTRAINT `reservation_items_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD CONSTRAINT `restaurants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `restaurant_galleries`
--
ALTER TABLE `restaurant_galleries`
  ADD CONSTRAINT `restaurant_galleries_restaurant_id_foreign` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tables`
--
ALTER TABLE `tables`
  ADD CONSTRAINT `tables_restaurant_id_foreign` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_favorites`
--
ALTER TABLE `user_favorites`
  ADD CONSTRAINT `user_favorites_restaurant_id_foreign` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
