-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 01, 2025 at 06:03 AM
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
(1, 'Appetizer', 'categories/appetizer.jpg', 'Makanan ringan untuk mengawali hidangan utama', '2025-04-18 03:52:22', '2025-04-18 03:52:22'),
(2, 'Main Course', 'categories/main-course.jpg', 'Hidangan utama dengan porsi yang mengenyangkan', '2025-04-18 03:52:22', '2025-04-18 03:52:22'),
(3, 'Snacks', 'categories/snacks.jpg', 'Makanan ringan untuk dikonsumsi di antara waktu makan', '2025-04-18 03:52:22', '2025-04-18 03:52:22'),
(4, 'Dessert', 'categories/dessert.jpg', 'Makanan penutup yang manis dan lezat', '2025-04-18 03:52:22', '2025-04-18 03:52:22'),
(5, 'Coffee', 'categories/coffee.jpg', 'Minuman kopi dengan berbagai variasi', '2025-04-18 03:52:22', '2025-04-18 03:52:22'),
(6, 'Non-Coffee', 'categories/non-coffee.jpg', 'Minuman non-kopi yang menyegarkan', '2025-04-18 03:52:22', '2025-04-18 03:52:22'),
(7, 'Healthy Juice', 'categories/healthy-juice.jpg', 'Jus buah dan sayuran segar yang menyehatkan', '2025-04-18 03:52:22', '2025-04-18 03:52:22');

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
(1, 'Nasi Merah dengan Ayam Panggang Kecap & Tumis Kangkung', 'Nikmati hidangan sehat dan lezat dengan Nasi Merah yang kaya serat, dipadukan dengan Ayam Panggang Kecap yang manis gurih dan Tumis Kangkung yang segar. Kombinasi sempurna untuk santapan yang mengenyangkan dan bergizi.', 'Kalori: 450 kkal\r\nProtein: 35 gram\r\nLemak: 20 gram\r\nKarbohidrat: 60 gram\r\nSerat: 7 gram', 35000.00, 'foods/nasi-merah-dengan-ayam-panggang-kecap-tumis-kangkung-1748745345.jpg', 2, 1, '2025-04-18 03:52:22', '2025-05-31 19:35:45'),
(2, 'Salad Bowl dengan Quinoa, Alpukat, dan Potongan Ayam Panggang', 'Salad sehat dan bergizi dengan Quinoa yang kaya protein, alpukat yang kaya akan lemak sehat, dan ayam panggang yang lezat. Disiram dengan saus vinaigrette lemon yang segar.', 'Kalori: 380 kkal\r\nProtein: 25 gram\r\nLemak: 22 gram\r\nKarbohidrat: 30 gram\r\nSerat: 9 gram', 40000.00, 'foods/salad-bowl-dengan-quinoa-alpukat-dan-potongan-ayam-panggang-1748745429.jpg', 1, 1, '2025-04-18 03:52:22', '2025-05-31 19:37:09'),
(3, 'Smoothie Bowl Buah Naga dan Pisang', 'Smoothie bowl segar dengan campuran buah naga, pisang, dan tambahan granola serta buah-buahan segar di atasnya. Sarapan sehat yang menyegarkan dan mengenyangkan.', 'Kalori: 320 kkal\r\nProtein: 8 gram\r\nLemak: 5 gram\r\nKarbohidrat: 65 gram\r\nSerat: 12 gram', 30000.00, 'foods/smoothie-bowl-buah-naga-dan-pisang-1748745575.jpg', 4, 1, '2025-04-18 03:52:22', '2025-05-31 19:39:35'),
(4, 'Green Detox Juice', 'Jus detox hijau dengan campuran apel, mentimun, bayam, dan lemon. Minuman sehat yang menyegarkan dan membantu membersihkan tubuh Anda.', 'Kalori: 120 kkal\r\nProtein: 2 gram\r\nLemak: 0 gram\r\nKarbohidrat: 28 gram\r\nSerat: 4 gram', 25000.00, 'foods/green-detox-juice-1748745583.jpg', 7, 1, '2025-04-18 03:52:22', '2025-05-31 19:39:43'),
(5, 'Kopi Hitam Organik', 'Kopi hitam organik dengan biji kopi pilihan yang digiling segar. Nikmati rasa kopi yang kaya dan aroma yang menggoda.', 'Kalori: 5 kkal\r\nProtein: 0 gram\r\nLemak: 0 gram\r\nKarbohidrat: 0 gram\r\nSerat: 0 gram', 20000.00, 'foods/kopi-hitam-organik-1748745597.jpg', 5, 1, '2025-04-18 03:52:22', '2025-05-31 19:39:57'),
(6, 'Chitato', 'ciki ringan', '120kkal\r\n2g protein', 5000.00, 'foods/chitato-1748745624.jpg', 3, 1, '2025-05-31 19:12:53', '2025-05-31 19:40:24');

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
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(13, '2025_06_01_013804_add_customization_fields_to_order_details_table', 3);

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
(1, NULL, 'ORD-7ngSduwd', 'dine_in', '1', 55000.00, 'processing', 'apa', '2025-04-29 00:46:25', '2025-04-29 00:46:32'),
(2, NULL, 'ORD-669BdZka', 'take_away', NULL, 75000.00, 'processing', 'ok', '2025-05-31 18:29:56', '2025-05-31 18:30:09'),
(3, NULL, 'ORD-zcqufIdG', 'dine_in', '12', 35000.00, 'processing', NULL, '2025-05-31 18:41:28', '2025-05-31 18:41:32'),
(4, NULL, 'ORD-nAk9xkB6', 'take_away', NULL, 40000.00, 'completed', NULL, '2025-05-31 18:47:04', '2025-05-31 18:54:28'),
(5, NULL, 'ORD-l9IEKAqN', 'dine_in', '1', 20000.00, 'completed', NULL, '2025-05-31 18:55:21', '2025-05-31 18:56:16'),
(6, NULL, 'ORD-zRiw8gcW', 'take_away', NULL, 75000.00, 'completed', 'tidak pedas', '2025-05-31 18:56:57', '2025-05-31 18:57:33'),
(7, NULL, 'ORD-guTJifYs', 'take_away', NULL, 5000.00, 'cancelled', NULL, '2025-05-31 19:51:08', '2025-05-31 19:51:34'),
(8, NULL, 'ORD-6MdWyqCn', 'dine_in', '7', 35000.00, 'processing', NULL, '2025-05-31 19:52:08', '2025-05-31 19:55:43');

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
(1, 1, 5, 1, 20000.00, 20000.00, NULL, NULL, NULL, NULL, '2025-04-29 00:46:25', '2025-04-29 00:46:25'),
(2, 1, 1, 1, 35000.00, 35000.00, NULL, NULL, NULL, NULL, '2025-04-29 00:46:25', '2025-04-29 00:46:25'),
(3, 2, 1, 1, 35000.00, 35000.00, NULL, NULL, NULL, NULL, '2025-05-31 18:29:56', '2025-05-31 18:29:56'),
(4, 2, 2, 1, 40000.00, 40000.00, NULL, NULL, NULL, NULL, '2025-05-31 18:29:56', '2025-05-31 18:29:56'),
(5, 3, 1, 1, 35000.00, 35000.00, NULL, 'Lokal', 'Kecil', 'dajal', '2025-05-31 18:41:28', '2025-05-31 18:41:28'),
(6, 4, 2, 1, 40000.00, 40000.00, NULL, NULL, NULL, NULL, '2025-05-31 18:47:04', '2025-05-31 18:47:04'),
(7, 5, 5, 1, 20000.00, 20000.00, NULL, NULL, NULL, NULL, '2025-05-31 18:55:21', '2025-05-31 18:55:21'),
(8, 6, 2, 1, 40000.00, 40000.00, NULL, NULL, NULL, NULL, '2025-05-31 18:56:57', '2025-05-31 18:56:57'),
(9, 6, 1, 1, 35000.00, 35000.00, NULL, NULL, NULL, 'bebek', '2025-05-31 18:56:57', '2025-05-31 18:56:57'),
(10, 7, 6, 1, 5000.00, 5000.00, NULL, NULL, NULL, NULL, '2025-05-31 19:51:08', '2025-05-31 19:51:08'),
(11, 8, 1, 1, 35000.00, 35000.00, NULL, NULL, NULL, NULL, '2025-05-31 19:52:08', '2025-05-31 19:52:08');

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
(1, 1, 3, 55000.00, 'TRX-IP9ZY9SS', 'completed', '2025-04-29 00:46:32', '2025-04-29 00:46:32'),
(2, 2, 3, 75000.00, 'TRX-80Asb2ve', 'completed', '2025-05-31 18:30:09', '2025-05-31 18:30:09'),
(3, 3, 6, 35000.00, 'TRX-6SYfFa7S', 'completed', '2025-05-31 18:41:32', '2025-05-31 18:41:32'),
(4, 4, 7, 40000.00, 'QRIS-K4DkevYe', 'completed', '2025-05-31 18:47:26', '2025-05-31 18:47:26'),
(5, 5, 7, 20000.00, 'QRIS-djrmJxDb', 'completed', '2025-05-31 18:55:25', '2025-05-31 18:55:25'),
(6, 6, 5, 75000.00, 'TRX-sOzIN1qI', 'completed', '2025-05-31 18:57:01', '2025-05-31 18:57:01'),
(7, 7, 5, 5000.00, 'TRX-H1vVWDDl', 'completed', '2025-05-31 19:51:17', '2025-05-31 19:51:17'),
(8, 8, 7, 35000.00, 'QRIS-cqSQFneP', 'completed', '2025-05-31 19:55:43', '2025-05-31 19:55:43');

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
(7, 'QRIS', 'Pembayaran digital menggunakan QRIS, scan dengan aplikasi e-wallet apa saja', 1, '2025-04-18 03:52:22', '2025-05-31 18:43:50');

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
('9QGiXp4mhISTWfziZi3zQyDVR7SJrmrWK4II5fMo', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZVlwRXRJbHREVU9zSnh2MHhEbzYzSEFMY3RVU014UWFiWUVGV0ZkRSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1748750582);

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
  ADD UNIQUE KEY `members_email_unique` (`email`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `foods`
--
ALTER TABLE `foods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
