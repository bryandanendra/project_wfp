-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 01, 2025 at 05:34 PM
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
-- Database: `project_wfp`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Appetizer', NULL, 'Makanan ringan untuk mengawali hidangan utama', '2025-04-18 03:52:22', '2025-04-18 03:52:22'),
(2, 'Main Course', NULL, 'Hidangan utama dengan porsi yang mengenyangkan', '2025-04-18 03:52:22', '2025-04-18 03:52:22'),
(3, 'Snacks', NULL, 'Makanan ringan untuk dikonsumsi di antara waktu makan', '2025-04-18 03:52:22', '2025-04-18 03:52:22'),
(4, 'Dessert', NULL, 'Makanan penutup yang manis dan lezat', '2025-04-18 03:52:22', '2025-04-18 03:52:22'),
(5, 'Coffee', NULL, 'Minuman kopi dengan berbagai variasi', '2025-04-18 03:52:22', '2025-04-18 03:52:22'),
(7, 'Healthy Juice', NULL, 'Jus buah dan sayuran segar yang menyehatkan', '2025-04-18 03:52:22', '2025-04-18 03:52:22'),
(8, 'Non-coffe', NULL, 'Minuman dingin dan hangat ', '2025-07-01 02:35:53', '2025-07-01 02:35:53');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `foods`
--

CREATE TABLE `foods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `nutrition_facts` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `foods`
--

INSERT INTO `foods` (`id`, `name`, `description`, `nutrition_facts`, `price`, `image`, `category_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Nasi Merah dengan Ayam Panggang Kecap & Tumis Kangkung', 'Nikmati hidangan sehat dan lezat dengan Nasi Merah yang kaya serat, dipadukan dengan Ayam Panggang Kecap yang manis gurih dan Tumis Kangkung yang segar. Kombinasi sempurna untuk santapan yang mengenyangkan dan bergizi.', 'Kalori: 450 kkal\r\nProtein: 35 gram\r\nLemak: 20 gram\r\nKarbohidrat: 60 gram\r\nSerat: 7 gram', 35000.00, 'foods/nasi-merah-dengan-ayam-panggang-kecap-tumis-kangkung-1748745345.jpg', 2, 1, '2025-04-18 03:52:22', '2025-07-01 02:08:41'),
(2, 'Salad Bowl dengan Quinoa, Alpukat, dan Potongan Ayam Panggang', 'Salad sehat dan bergizi dengan Quinoa yang kaya protein, alpukat yang kaya akan lemak sehat, dan ayam panggang yang lezat. Disiram dengan saus vinaigrette lemon yang segar.', 'Kalori: 380 kkal\r\nProtein: 25 gram\r\nLemak: 22 gram\r\nKarbohidrat: 30 gram\r\nSerat: 9 gram', 40000.00, 'foods/salad-bowl-dengan-quinoa-alpukat-dan-potongan-ayam-panggang-1748745429.jpg', 1, 1, '2025-04-18 03:52:22', '2025-05-31 19:37:09'),
(3, 'Smoothie Bowl Buah Naga dan Pisang', 'Smoothie bowl segar dengan campuran buah naga, pisang, dan tambahan granola serta buah-buahan segar di atasnya. Sarapan sehat yang menyegarkan dan mengenyangkan.', 'Kalori: 320 kkal\r\nProtein: 8 gram\r\nLemak: 5 gram\r\nKarbohidrat: 65 gram\r\nSerat: 12 gram', 30000.00, 'foods/smoothie-bowl-buah-naga-dan-pisang-1748745575.jpg', 4, 1, '2025-04-18 03:52:22', '2025-05-31 19:39:35'),
(4, 'Green Detox Juice', 'Jus detox hijau dengan campuran apel, mentimun, bayam, dan lemon. Minuman sehat yang menyegarkan dan membantu membersihkan tubuh Anda.', 'Kalori: 120 kkal\r\nProtein: 2 gram\r\nLemak: 0 gram\r\nKarbohidrat: 28 gram\r\nSerat: 4 gram', 25000.00, 'foods/green-detox-juice-1748745583.jpg', 7, 1, '2025-04-18 03:52:22', '2025-05-31 19:39:43'),
(5, 'Kopi Hitam Organik', 'Kopi hitam organik dengan biji kopi pilihan yang digiling segar. Nikmati rasa kopi yang kaya dan aroma yang menggoda.', 'Kalori: 5 kkal\r\nProtein: 0 gram\r\nLemak: 0 gram\r\nKarbohidrat: 0 gram\r\nSerat: 0 gram', 20000.00, 'foods/kopi-hitam-organik-1751347124.jpg', 5, 1, '2025-04-18 03:52:22', '2025-06-30 22:18:44'),
(6, 'Chitato', 'ciki ringan', '120kkal\r\n2g protein', 5000.00, 'foods/chitato-1748745624.jpg', 3, 1, '2025-05-31 19:12:53', '2025-05-31 19:40:24'),
(8, 'ayam bbumbukuning', 'ayam dengan bumbu kuning khas madura', 'sehat', 25000.00, 'foods/ayam-bbumbukuning-1751366304.png', 2, 1, '2025-07-01 03:38:24', '2025-07-01 03:38:31'),
(9, 'Es Jeruk', 'Es jeruk peras asli', '100kkal', 6000.00, 'foods/es-jeruk-1751379315.png', 8, 1, '2025-07-01 06:44:40', '2025-07-01 07:15:15'),
(10, 'Teh Panas', 'teh panas', '100kkal', 3000.00, 'foods/teh-panas-1751379330.png', 8, 1, '2025-07-01 06:46:01', '2025-07-01 07:15:30'),
(11, 'Crispy Spring Rolls', 'Spring rolls renyah dengan isian sayuran segar, disajikan dengan saus sambal manis dan pedas. Cocok untuk memulai hidangan utama Anda.', 'Kalori: 180 kcal, Protein: 5g, Lemak: 8g, Karbohidrat: 20g', 25000.00, 'foods/crispy-spring-rolls-1751379662.png', 1, 1, '2025-07-01 07:17:39', '2025-07-01 07:21:02');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
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
-- Table structure for table `job_batches`
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
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `name`, `email`, `phone`, `password`, `remember_token`, `email_verified_at`, `created_at`, `updated_at`) VALUES
(3, 'reni', NULL, NULL, NULL, NULL, NULL, '2025-07-01 07:25:44', '2025-07-01 07:25:44'),
(4, 'dika jamet', NULL, NULL, NULL, NULL, NULL, '2025-07-01 07:28:08', '2025-07-01 07:28:08'),
(5, 'emil', NULL, NULL, NULL, NULL, NULL, '2025-07-01 07:32:53', '2025-07-01 07:32:53'),
(6, 'mas rusdi', 'rusdi@gmail.com', '098124023', NULL, NULL, NULL, '2025-07-01 07:34:33', '2025-07-01 07:34:33'),
(7, 'juna', NULL, NULL, NULL, NULL, NULL, '2025-07-01 07:37:28', '2025-07-01 07:37:28'),
(8, 'emil', NULL, NULL, NULL, NULL, NULL, '2025-07-01 07:40:12', '2025-07-01 07:40:12'),
(9, 'robiy', NULL, NULL, NULL, NULL, NULL, '2025-07-01 08:18:39', '2025-07-01 08:18:39'),
(10, 'peter', NULL, NULL, NULL, NULL, NULL, '2025-07-01 08:19:48', '2025-07-01 08:19:48');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_04_18_104305_create_categories_table', 1),
(5, '2025_04_18_104310_create_foods_table', 1),
(6, '2025_04_18_104314_create_orders_table', 1),
(7, '2025_04_18_104317_create_order_details_table', 1),
(8, '2025_04_18_104322_create_payment_methods_table', 1),
(9, '2025_04_18_104326_create_payments_table', 1),
(10, '2025_04_18_104331_create_members_table', 1),
(11, '2025_04_18_104800_add_foreign_keys_to_tables', 1),
(12, '2025_04_18_120704_update_mysql_sql_mode', 2),
(13, '2025_06_01_013804_add_customization_fields_to_order_details_table', 3),
(14, '2025_07_01_100143_make_password_nullable_in_members_table', 4),
(15, '2025_07_01_100331_make_email_nullable_in_members_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_number` varchar(255) NOT NULL,
  `order_type` enum('dine_in','take_away') NOT NULL,
  `table_number` varchar(255) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','completed','cancelled') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `member_id`, `order_number`, `order_type`, `table_number`, `total_amount`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(18, 3, 'ORD-XJ1r8KLO', 'dine_in', '1', 65000.00, 'completed', NULL, '2025-07-01 07:25:44', '2025-07-01 07:27:06'),
(19, 4, 'ORD-iAxeRwN4', 'dine_in', '4', 96000.00, 'completed', NULL, '2025-07-01 07:28:08', '2025-07-01 07:29:02'),
(20, 5, 'ORD-MeiwBAcB', 'take_away', NULL, 20000.00, 'completed', 'less sugar', '2025-07-01 07:32:53', '2025-07-01 07:33:16'),
(21, 6, 'ORD-aVFfdU6M', 'dine_in', '6', 90000.00, 'completed', NULL, '2025-07-01 07:34:33', '2025-07-01 07:35:02'),
(22, 7, 'ORD-JNkDetwL', 'take_away', NULL, 215000.00, 'completed', NULL, '2025-07-01 07:37:28', '2025-07-01 07:39:05'),
(23, 8, 'ORD-tt5c0rFH', 'dine_in', '3', 11000.00, 'completed', NULL, '2025-07-01 07:40:12', '2025-07-01 07:40:37'),
(24, 7, 'ORD-gZAq6ez6', 'dine_in', '7', 40000.00, 'completed', NULL, '2025-07-01 08:16:45', '2025-07-01 08:16:56'),
(25, 9, 'ORD-6UrFpmG5', 'take_away', NULL, 5000.00, 'processing', NULL, '2025-07-01 08:18:39', '2025-07-01 08:18:49'),
(26, 10, 'ORD-8ZByQa4q', 'take_away', NULL, 30000.00, 'cancelled', NULL, '2025-07-01 08:19:48', '2025-07-01 08:20:06'),
(27, 7, 'ORD-cEdT52ru', 'dine_in', '4', 20000.00, 'completed', 'split sugar', '2025-07-01 08:23:49', '2025-07-01 08:24:00');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `food_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `special_instructions` text DEFAULT NULL,
  `customization_ingredients` varchar(255) DEFAULT NULL,
  `customization_portion_size` varchar(255) DEFAULT NULL,
  `customization_allergies` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `food_id`, `quantity`, `price`, `subtotal`, `special_instructions`, `customization_ingredients`, `customization_portion_size`, `customization_allergies`, `created_at`, `updated_at`) VALUES
(22, 18, 2, 1, 40000.00, 40000.00, NULL, NULL, NULL, NULL, '2025-07-01 07:25:44', '2025-07-01 07:25:44'),
(23, 18, 4, 1, 25000.00, 25000.00, NULL, NULL, NULL, NULL, '2025-07-01 07:25:44', '2025-07-01 07:25:44'),
(24, 19, 1, 2, 35000.00, 70000.00, NULL, NULL, NULL, NULL, '2025-07-01 07:28:08', '2025-07-01 07:28:08'),
(25, 19, 5, 1, 20000.00, 20000.00, NULL, NULL, NULL, NULL, '2025-07-01 07:28:08', '2025-07-01 07:28:08'),
(26, 19, 9, 1, 6000.00, 6000.00, NULL, NULL, NULL, NULL, '2025-07-01 07:28:08', '2025-07-01 07:28:08'),
(27, 20, 5, 1, 20000.00, 20000.00, NULL, NULL, 'Kecil', NULL, '2025-07-01 07:32:53', '2025-07-01 07:32:53'),
(28, 21, 4, 2, 25000.00, 50000.00, NULL, NULL, 'Besar', NULL, '2025-07-01 07:34:33', '2025-07-01 07:34:33'),
(29, 21, 2, 1, 40000.00, 40000.00, NULL, 'Impor', 'Kecil', 'kacang', '2025-07-01 07:34:33', '2025-07-01 07:34:33'),
(30, 22, 1, 2, 35000.00, 70000.00, NULL, NULL, NULL, NULL, '2025-07-01 07:37:28', '2025-07-01 07:37:28'),
(31, 22, 8, 2, 25000.00, 50000.00, NULL, NULL, NULL, NULL, '2025-07-01 07:37:28', '2025-07-01 07:37:28'),
(32, 22, 3, 1, 30000.00, 30000.00, NULL, NULL, NULL, NULL, '2025-07-01 07:37:28', '2025-07-01 07:37:28'),
(33, 22, 5, 2, 20000.00, 40000.00, NULL, NULL, NULL, NULL, '2025-07-01 07:37:28', '2025-07-01 07:37:28'),
(34, 22, 4, 1, 25000.00, 25000.00, NULL, NULL, NULL, NULL, '2025-07-01 07:37:28', '2025-07-01 07:37:28'),
(35, 23, 6, 1, 5000.00, 5000.00, NULL, NULL, NULL, NULL, '2025-07-01 07:40:12', '2025-07-01 07:40:12'),
(36, 23, 9, 1, 6000.00, 6000.00, NULL, NULL, NULL, NULL, '2025-07-01 07:40:12', '2025-07-01 07:40:12'),
(37, 24, 2, 1, 40000.00, 40000.00, NULL, NULL, NULL, NULL, '2025-07-01 08:16:45', '2025-07-01 08:16:45'),
(38, 25, 6, 1, 5000.00, 5000.00, NULL, NULL, NULL, NULL, '2025-07-01 08:18:39', '2025-07-01 08:18:39'),
(39, 26, 3, 1, 30000.00, 30000.00, NULL, NULL, NULL, NULL, '2025-07-01 08:19:48', '2025-07-01 08:19:48'),
(40, 27, 5, 1, 20000.00, 20000.00, NULL, NULL, NULL, NULL, '2025-07-01 08:23:49', '2025-07-01 08:23:49');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `status` enum('pending','completed','failed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `payment_method_id`, `amount`, `transaction_id`, `status`, `created_at`, `updated_at`) VALUES
(17, 18, 7, 65000.00, 'QRIS-SKjYUAbM', 'completed', '2025-07-01 07:26:39', '2025-07-01 07:26:39'),
(18, 19, 6, 96000.00, 'TRX-zU44xbJu', 'completed', '2025-07-01 07:28:11', '2025-07-01 07:28:11'),
(19, 20, 4, 20000.00, 'TRX-jwfpLdMb', 'completed', '2025-07-01 07:32:57', '2025-07-01 07:32:57'),
(20, 21, 2, 90000.00, 'TRX-aL4XvXdj', 'completed', '2025-07-01 07:34:38', '2025-07-01 07:34:38'),
(21, 22, 8, 215000.00, 'TRX-Lk0KQOEK', 'completed', '2025-07-01 07:38:47', '2025-07-01 07:38:47'),
(22, 23, 8, 11000.00, 'TRX-g58eSXtF', 'completed', '2025-07-01 07:40:15', '2025-07-01 07:40:15'),
(23, 23, 8, 11000.00, 'TRX-nMYOUrL7', 'completed', '2025-07-01 07:40:29', '2025-07-01 07:40:29'),
(24, 24, 8, 40000.00, 'TRX-H9UcLU7h', 'completed', '2025-07-01 08:16:47', '2025-07-01 08:16:47'),
(25, 25, 7, 5000.00, 'QRIS-43jWpYIM', 'completed', '2025-07-01 08:18:49', '2025-07-01 08:18:49'),
(26, 26, 6, 30000.00, 'TRX-54rdHA81', 'completed', '2025-07-01 08:19:52', '2025-07-01 08:19:52'),
(27, 27, 1, 20000.00, 'TRX-1LI555yn', 'completed', '2025-07-01 08:23:51', '2025-07-01 08:23:51');

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Kartu Kredit', 'Pembayaran menggunakan kartu kredit', 1, '2025-04-18 03:52:22', '2025-04-18 03:52:22'),
(2, 'Kartu Debit', 'Pembayaran menggunakan kartu debit', 1, '2025-04-18 03:52:22', '2025-04-18 03:52:22'),
(3, 'GoPay', 'Pembayaran menggunakan dompet digital GoPay', 1, '2025-04-18 03:52:22', '2025-04-18 03:52:22'),
(4, 'OVO', 'Pembayaran menggunakan dompet digital OVO', 1, '2025-04-18 03:52:22', '2025-04-18 03:52:22'),
(5, 'Dana', 'Pembayaran menggunakan dompet digital Dana', 1, '2025-04-18 03:52:22', '2025-04-18 03:52:22'),
(6, 'ShopeePay', 'Pembayaran menggunakan dompet digital ShopeePay', 1, '2025-04-18 03:52:22', '2025-04-18 03:52:22'),
(7, 'QRIS', 'Pembayaran digital menggunakan QRIS, scan dengan aplikasi e-wallet apa saja', 1, '2025-04-18 03:52:22', '2025-05-31 18:43:50'),
(8, 'Cash', 'pembayaran dengan uang tunai', 1, '2025-07-01 14:38:05', '2025-07-01 14:38:15');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('X2gtmChINxzABaTN1Inwn8UmM4kq3ISxXgIVEVzp', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUjJ0THFUT1hWTE1YVmI3UG9GSkhWdlZOT2U2MVczWm1mR2IwN0ZSWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1751383836);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `foods_category_id_foreign` (`category_id`);

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
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `members_email_unique_with_null` (`email`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_member_id_foreign` (`member_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_order_id_foreign` (`order_id`),
  ADD KEY `order_details_food_id_foreign` (`food_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_order_id_foreign` (`order_id`),
  ADD KEY `payments_payment_method_id_foreign` (`payment_method_id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `foods`
--
ALTER TABLE `foods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `foods`
--
ALTER TABLE `foods`
  ADD CONSTRAINT `foods_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_food_id_foreign` FOREIGN KEY (`food_id`) REFERENCES `foods` (`id`),
  ADD CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `payments_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
