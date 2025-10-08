-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2025 at 02:06 PM
-- Server version: 8.0.42
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shoecommerce2`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'India',
  `type` enum('home','work','other') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'home',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `customer_id`, `first_name`, `last_name`, `email`, `phone`, `address`, `city`, `state`, `postal_code`, `country`, `type`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 1, 'Test', 'Customer', 'test@example.com', '9876543210', '123 Test Building, Test Street', 'Delhi', 'Delhi', '110001', 'India', 'home', 1, '2025-10-06 11:57:42', '2025-10-06 11:57:42'),
(2, 2, 'mohammad', 'aslam', 'aslam.117y@gmail.com', '7396080293', '1-79,ibrahimpatnam,old busstop, ibrahimpatnam, jamma masjid', 'hyderabad', 'Telangana', '501505', 'India', 'home', 1, '2025-10-07 06:06:00', '2025-10-07 06:06:00');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba', 'i:1;', 1759834123),
('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba:timer', 'i:1759834123;', 1759834123);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `customer_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `product_id`, `quantity`, `created_at`, `updated_at`, `customer_id`) VALUES
(1, NULL, 1, 1, '2025-10-06 11:51:41', '2025-10-06 11:51:41', 1),
(3, NULL, 1, 1, '2025-10-07 06:11:58', '2025-10-07 06:11:58', 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Men\'s Shoes', 'mens-shoes', 'Casual, formal and sports shoes for men', '2025-10-06 11:41:25', '2025-10-06 11:41:25'),
(2, 'Women\'s Shoes', 'womens-shoes', 'Trendy and comfortable shoes for women', '2025-10-06 11:41:25', '2025-10-06 11:41:25'),
(3, 'Kids\' Shoes', 'kids-shoes', 'Colorful and durable shoes for kids', '2025-10-06 11:41:25', '2025-10-06 11:41:25'),
(4, 'Sports Shoes', 'sports-shoes', 'Performance sports shoes for all activities', '2025-10-06 11:41:25', '2025-10-06 11:41:25'),
(5, 'Formal Shoes', 'formal-shoes', 'Elegant formal footwear', '2025-10-06 11:41:25', '2025-10-06 11:41:25'),
(6, 'Test Shoes', 'test-shoes', 'Test category', '2025-10-06 11:42:17', '2025-10-06 11:42:17');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `password`, `otp_code`, `is_verified`, `created_at`, `updated_at`, `email_verified_at`, `remember_token`) VALUES
(1, 'Test Customer', 'test@example.com', '9876543210', '$2y$12$hl93qh3UD7yJqNJrLImheeO5YmCH.3fLHpV1AHzcUBs3Q0a7XpX6u', NULL, 1, '2025-10-06 11:42:17', '2025-10-06 11:42:46', '2025-10-06 11:42:17', NULL),
(2, 'mohammad aslam', 'aslam.117y@gmail.com', '7396080293', '$2y$12$0FlYCrk2/THGBN48.2Aai.d2gflGTY/WhqtcINsCJY7eZYrXdHa/2', NULL, 1, '2025-10-07 01:29:13', '2025-10-07 01:29:13', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `email_otps`
--

CREATE TABLE `email_otps` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` timestamp NOT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_otps`
--

INSERT INTO `email_otps` (`id`, `email`, `otp`, `expires_at`, `is_verified`, `created_at`, `updated_at`) VALUES
(1, 'aslam.117y@gmail.co', '867628', '2025-10-07 01:32:30', 0, '2025-10-07 01:27:30', '2025-10-07 01:27:30');

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
  `attempts` tinyint UNSIGNED NOT NULL,
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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(4, '0001_01_01_000002_create_jobs_table', 2),
(5, '2025_01_28_000000_create_email_otps_table', 3),
(6, '2025_08_16_185325_create_categories_table', 3),
(7, '2025_08_16_185500_create_products_table', 3),
(8, '2025_08_16_185706_create_orders_table', 3),
(9, '2025_08_16_185744_create_order_items_table', 3),
(10, '2025_08_16_185825_create_carts_table', 3),
(11, '2025_08_16_185859_create_reviews_table', 3),
(12, '2025_08_20_083731_create_product_images_table', 3),
(13, '2025_08_26_133749_add_slug_to_categories_table', 3),
(14, '2025_08_26_134217_make_slug_unique_in_categories_table', 3),
(15, '2025_08_27_044521_make_user_id_nullable_in_carts_table', 3),
(16, '2025_08_27_044958_add_image_to_products_table', 3),
(17, '2025_09_01_140824_create_customers_table', 3),
(18, '2025_09_01_191046_add_phone_to_customers_table', 3),
(19, '2025_09_15_141345_add_is_admin_to_users_table', 3),
(20, '2025_09_17_081107_add_is_main_to_product_images_table', 3),
(21, '2025_09_18_065555_add_email_to_customers_table', 3),
(22, '2025_09_19_145216_add_role_to_users_table', 3),
(23, '2025_09_20_161302_create_admins_table', 3),
(24, '2025_09_21_030243_add_customer_id_to_carts_table', 3),
(25, '2025_09_25_100405_create_customers_table', 3),
(26, '2025_09_25_101612_add_email_verified_at_to_customers_table', 3),
(27, '2025_09_25_101808_create_password_reset_tokens_table', 3),
(28, '2025_09_26_000000_create_addresses_table', 3),
(29, '2025_09_30_172214_create_sliders_table', 4),
(30, '2025_10_02_134619_create_payment_gateways_table', 4),
(31, '2025_10_03_074221_add_checkout_fields_to_orders_table', 4),
(32, '2025_10_03_074306_make_user_id_nullable_in_orders_table', 4),
(33, '2025_10_03_074505_make_shipping_address_nullable_in_orders_table', 4),
(34, '2025_10_03_075823_add_product_name_to_order_items_table', 4),
(35, '2025_10_03_092512_add_payment_session_id_to_orders_table', 4),
(36, '2025_10_03_121852_drop_foreign_key_from_orders_user_id', 4),
(37, '2025_10_03_122554_add_customer_id_to_orders_table', 4),
(38, '2025_10_04_052628_add_payment_fields_to_orders_table_final', 4);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'India',
  `address_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'home',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `total` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `shipping` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `shipping_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_session_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tracking_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `customer_id`, `customer_name`, `customer_email`, `customer_phone`, `address`, `city`, `state`, `postal_code`, `country`, `address_type`, `status`, `payment_status`, `total`, `subtotal`, `shipping`, `tax`, `shipping_address`, `payment_method`, `payment_session_id`, `payment_transaction_id`, `tracking_number`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 'Test Customer', 'test@example.com', '9876543210', '123 Test Building, Test Street', 'Delhi', 'Delhi', '110001', 'India', 'home', 'pending_payment', 'pending', 117.00, 100.00, 10.00, 7.00, NULL, 'cashfree', 'session_42p7jVeioE0jb0t2TeQZTtoOGWNUkA20juxxz8UwPQxfJ1W1KWcD_l46YqvSLJye5ANheH-B9i90jghzzvE75qNLtF1pAJEpTORD5U7pECh5lpBRIa88hH8E2tuFUgpayment', 'ORDER_1_1759771683', 'ORD-8PBEWVFE', '2025-10-06 11:58:01', '2025-10-06 11:58:03'),
(2, NULL, 2, 'mohammad aslam', 'aslam.117y@gmail.com', '7396080293', '1-79,ibrahimpatnam,old busstop, ibrahimpatnam, jamma masjid', 'hyderabad', 'Telangana', '501505', 'India', 'home', 'processing', 'paid', 10.00, 0.00, 10.00, 0.00, NULL, 'cashfree', 'session_L-OIHfPXN6bNIRdT8w1B3IjddDzCqmlJPr87W2faG67BE39mP7tDUFg3ViT486n4F7e3r19Xnjoif5clTGc2Drr7vbuuvlXn8TfE5z5jZZU33YifaHwX3dZzP-Hxfwpaymentpayment', 'ORDER_2_1759836967', 'ORD-1AQU3SBJ', '2025-10-07 06:06:06', '2025-10-07 07:56:34'),
(3, NULL, 1, 'Test Customer', 'test@example.com', '9876543210', '123 Test Street', 'Delhi', 'Delhi', '110001', 'India', 'home', 'processing', 'paid', 117.00, 100.00, 10.00, 7.00, NULL, 'cashfree', 'session_SHjVWfUZOayNUvN3TwwI4YFXrXHyBsz9mXTkmse2qbY-YeQIwbGyi5byRo9Z46axnB-YCjO3OMuG6TBUMJ25jCINiaU-zjHJnw92opf3nKRXjtvfJ7U0HVMh6SZ5-Qpaymentpayment', 'ORDER_3_1759843496', 'ORD-TEST-1759843489', '2025-10-07 07:54:49', '2025-10-07 08:53:57'),
(4, NULL, 2, 'mohammad aslam', 'aslam.117y@gmail.com', '7396080293', '1-79,ibrahimpatnam,old busstop, ibrahimpatnam, jamma masjid', 'hyderabad', 'Telangana', '501505', 'India', 'home', 'processing', 'paid', 10.00, 0.00, 10.00, 0.00, NULL, 'cashfree', 'session_YcfHuvlYOUpAvTy0ol72mpzOZGiGZVLEB5IR3KIQhpTwC6WG9AqBQOtfHncQ-n1rq22eCYvBj3eH0Jmb1e1GGVMVjCntX2nALOaU9XhY5r-xE47WIEUZQvA2KtayzApaymentpayment', 'ORDER_4_1759843832', 'ORD-FWF2MEDT', '2025-10-07 08:00:31', '2025-10-07 08:56:33'),
(5, NULL, 2, 'mohammad aslam', 'aslam.117y@gmail.com', '7396080293', '1-79,ibrahimpatnam,old busstop, ibrahimpatnam, jamma masjid', 'hyderabad', 'Telangana', '501505', 'India', 'home', 'pending_payment', 'pending', 10.00, 0.00, 10.00, 0.00, NULL, 'cashfree', 'session_99N_GDxWYDAhlgeEeHqUdvWrRF0l2NmIyL-P0nZIzMSRD0Yg5xfEJP2zMuDAQqRnZ7WIxnTPyPgwmhkJ1MA4gyrZ60gM3_M6C1bqz-60kyIfog78gOJdeQueD4ltkwpaymentpayment', 'ORDER_5_1759847224', 'ORD-SF1DP1MH', '2025-10-07 08:57:03', '2025-10-07 08:57:06');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `quantity`, `price`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Test Shoe Product', 1, 100.00, 100.00, '2025-10-06 11:58:01', '2025-10-06 11:58:01'),
(2, 2, 2, 'test', 1, 0.00, 0.00, '2025-10-07 06:06:06', '2025-10-07 06:06:06'),
(3, 3, 1, 'Test Shoe Product', 1, 100.00, 100.00, '2025-10-07 07:54:49', '2025-10-07 07:54:49'),
(4, 4, 2, 'test', 1, 0.00, 0.00, '2025-10-07 08:00:31', '2025-10-07 08:00:31'),
(5, 5, 2, 'test', 1, 0.00, 0.00, '2025-10-07 08:57:03', '2025-10-07 08:57:03');

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
-- Table structure for table `payment_gateways`
--

CREATE TABLE `payment_gateways` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `api_key` text COLLATE utf8mb4_unicode_ci,
  `api_secret` text COLLATE utf8mb4_unicode_ci,
  `merchant_id` text COLLATE utf8mb4_unicode_ci,
  `salt_key` text COLLATE utf8mb4_unicode_ci,
  `salt_index` text COLLATE utf8mb4_unicode_ci,
  `environment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'test',
  `webhook_secret` text COLLATE utf8mb4_unicode_ci,
  `additional_config` json DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `supports_upi` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_gateways`
--

INSERT INTO `payment_gateways` (`id`, `name`, `display_name`, `is_active`, `api_key`, `api_secret`, `merchant_id`, `salt_key`, `salt_index`, `environment`, `webhook_secret`, `additional_config`, `sort_order`, `supports_upi`, `created_at`, `updated_at`) VALUES
(1, 'cashfree', 'Cashfree', 1, NULL, NULL, NULL, NULL, NULL, 'test', NULL, NULL, 1, 1, '2025-10-06 11:42:17', '2025-10-06 11:42:17'),
(2, 'razorpay', 'Razorpay', 0, NULL, NULL, NULL, NULL, NULL, 'test', NULL, NULL, 2, 1, '2025-10-06 11:42:17', '2025-10-06 11:42:17'),
(3, 'phonepe', 'PhonePe', 0, NULL, NULL, NULL, NULL, NULL, 'test', NULL, NULL, 3, 1, '2025-10-06 11:42:17', '2025-10-06 11:42:17');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `category_id` bigint UNSIGNED NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `images` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `image`, `brand`, `price`, `stock`, `description`, `category_id`, `status`, `images`, `created_at`, `updated_at`) VALUES
(1, 'Test Shoe Product', NULL, NULL, 100.00, 50, 'A test product for Cashfree testing', 6, 'active', NULL, '2025-10-06 11:42:17', '2025-10-06 11:42:17'),
(2, 'test', NULL, NULL, 0.00, 110, 'buy fast', 1, 'active', NULL, '2025-10-07 05:17:21', '2025-10-07 05:17:21');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_main` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image`, `is_main`, `created_at`, `updated_at`) VALUES
(1, 2, 'products/D04jCxjuGTkcZRD2Fe81UDCuzGyxDcdKmsSw0BZy.jpg', 0, '2025-10-07 05:17:22', '2025-10-07 05:17:22'),
(2, 2, 'products/Qd2obtTF6KZzBnaU0pXzE3Fdx3082la7ftoUVMeu.jpg', 0, '2025-10-07 05:17:22', '2025-10-07 05:17:22'),
(3, 2, 'products/B3HTSzEIeSPPtWjraW3AVN7Bt3s2IhDljuwPaIvg.jpg', 0, '2025-10-07 05:17:22', '2025-10-07 05:17:22'),
(4, 2, 'products/gnARXJ0UPli4YlLOqjSD8TnyjaBpjYGtxOnif7dO.jpg', 0, '2025-10-07 05:17:22', '2025-10-07 05:17:22'),
(5, 2, 'products/4zRXYyG63IGFgmEQE0zDawQecaLLm2xKQI9twWud.jpg', 0, '2025-10-07 05:17:22', '2025-10-07 05:17:22');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `rating` tinyint UNSIGNED NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `button_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `role` enum('admin','customer') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `is_admin`, `role`, `remember_token`, `created_at`, `updated_at`, `phone`, `address`, `city`, `postal_code`) VALUES
(1, 'Admin', 'admin@example.com', NULL, '$2y$12$cEejToE0.NYATGooPNUsk.x63XvfCnoEKjjWaQaA56vUv/6McaQym', 0, 'customer', NULL, '2025-10-06 11:41:25', '2025-10-06 11:41:25', NULL, NULL, NULL, NULL),
(2, 'Admin', 'admin@shoecommerce.com', NULL, '$2y$12$OolKFO20paRHEiBXUhLd9.WyYWVWjbuovcan7Yoqgff24BCApbS0G', 0, 'admin', NULL, '2025-10-06 11:41:25', '2025-10-06 11:41:25', NULL, NULL, NULL, NULL),
(3, 'Arsalan', 'admin@gmail.com', NULL, '$2y$12$hvb.Zx0/Mwo3u6nLiYIP2uZTeHQSKB15esMjqwvf1bnEZIT1r/PfO', 1, 'admin', NULL, '2025-10-07 07:08:17', '2025-10-07 07:08:17', NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`),
  ADD KEY `carts_product_id_foreign` (`product_id`),
  ADD KEY `carts_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_phone_unique` (`phone`),
  ADD UNIQUE KEY `customers_email_unique` (`email`);

--
-- Indexes for table `email_otps`
--
ALTER TABLE `email_otps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_otps_expires_at_index` (`expires_at`),
  ADD KEY `email_otps_email_index` (`email`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `email_otps`
--
ALTER TABLE `email_otps`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
