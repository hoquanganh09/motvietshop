-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.33 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for doan_banquanao
CREATE DATABASE IF NOT EXISTS `doan_banquanao` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `doan_banquanao`;

-- Dumping structure for table doan_banquanao.banners
CREATE TABLE IF NOT EXISTS `banners` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan_banquanao.banners: ~2 rows (approximately)
/*!40000 ALTER TABLE `banners` DISABLE KEYS */;
INSERT INTO `banners` (`id`, `title`, `content`, `image`, `created_at`, `updated_at`) VALUES
	(1, 'Test title', 'Nội dung', NULL, '2024-08-20 12:29:55', '2024-08-20 13:01:29'),
	(2, 'Yeah yeah', 'Nhập mã \'THUDONG2024\' để giảm ngay 10% tối đa 100.000 đ', 'app_models_banner/1724782680_AHnQe2VABo.jpg', '2024-08-20 12:38:52', '2024-08-27 18:18:00'),
	(4, 'title', 'nội dung', NULL, '2024-08-20 13:00:21', '2024-08-20 13:01:38');
/*!40000 ALTER TABLE `banners` ENABLE KEYS */;

-- Dumping structure for table doan_banquanao.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan_banquanao.cache: ~0 rows (approximately)
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;

-- Dumping structure for table doan_banquanao.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan_banquanao.cache_locks: ~0 rows (approximately)
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;

-- Dumping structure for table doan_banquanao.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan_banquanao.categories: ~3 rows (approximately)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id`, `name`, `image`, `created_at`, `updated_at`) VALUES
	(1, 'Cho nam', 'app_models_category/1724155401_mM4iF9M9w8.png', '2024-08-18 08:22:48', '2024-08-20 12:03:21'),
	(2, 'Cho nữ', 'app_models_category/1724155394_twymkNzOQV.png', '2024-08-18 08:22:53', '2024-08-20 12:03:14'),
	(4, 'Phụ kiện', 'app_models_category/1724155388_NSeLlR6hVD.png', '2024-08-20 12:03:08', '2024-08-20 12:03:08'),
	(5, 'test', NULL, '2024-08-20 12:04:11', '2024-08-20 12:04:11');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

-- Dumping structure for table doan_banquanao.colors
CREATE TABLE IF NOT EXISTS `colors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan_banquanao.colors: ~4 rows (approximately)
/*!40000 ALTER TABLE `colors` DISABLE KEYS */;
INSERT INTO `colors` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES
	(1, 'red', 'Đỏ', '2024-08-18 08:23:19', '2024-08-18 08:23:19'),
	(2, 'black', 'Đen', '2024-08-18 17:30:22', '2024-08-18 17:30:22'),
	(3, 'blue', 'Xanh da trời', '2024-08-18 17:30:34', '2024-08-18 17:30:34'),
	(4, '#00712D', 'Xanh lá cây', '2024-08-18 17:30:59', '2024-08-18 17:30:59');
/*!40000 ALTER TABLE `colors` ENABLE KEYS */;

-- Dumping structure for table doan_banquanao.coupons
CREATE TABLE IF NOT EXISTS `coupons` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `discount` double NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `max_price` double NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `expiration_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan_banquanao.coupons: ~3 rows (approximately)
/*!40000 ALTER TABLE `coupons` DISABLE KEYS */;
INSERT INTO `coupons` (`id`, `discount`, `code`, `amount`, `max_price`, `is_active`, `expiration_date`, `created_at`, `updated_at`) VALUES
	(1, 95, 'ADMIN', 6, 1000000, 1, '2024-09-07', '2024-08-27 18:07:53', '2024-08-27 18:24:22'),
	(2, 10, 'THUDONG2024', 50, 50000, 1, '2024-12-01', '2024-08-27 18:14:38', '2024-08-27 18:24:06'),
	(3, 99, 'TEST', 4, 1000000, 1, '2024-09-15', '2024-09-07 16:22:59', '2024-09-08 16:21:23');
/*!40000 ALTER TABLE `coupons` ENABLE KEYS */;

-- Dumping structure for table doan_banquanao.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan_banquanao.failed_jobs: ~0 rows (approximately)
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Dumping structure for table doan_banquanao.features
CREATE TABLE IF NOT EXISTS `features` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan_banquanao.features: ~0 rows (approximately)
/*!40000 ALTER TABLE `features` DISABLE KEYS */;
/*!40000 ALTER TABLE `features` ENABLE KEYS */;

-- Dumping structure for table doan_banquanao.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan_banquanao.jobs: ~0 rows (approximately)
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;

-- Dumping structure for table doan_banquanao.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan_banquanao.job_batches: ~0 rows (approximately)
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;

-- Dumping structure for table doan_banquanao.kinds
CREATE TABLE IF NOT EXISTS `kinds` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kinds_category_id_foreign` (`category_id`),
  CONSTRAINT `kinds_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan_banquanao.kinds: ~6 rows (approximately)
/*!40000 ALTER TABLE `kinds` DISABLE KEYS */;
INSERT INTO `kinds` (`id`, `name`, `category_id`, `created_at`, `updated_at`) VALUES
	(1, 'Polo', 1, '2024-08-18 08:23:11', '2024-08-18 08:23:11'),
	(2, 'Túi xách', 2, '2024-08-18 17:16:54', '2024-08-18 17:16:54'),
	(4, 'Quần âu', 1, '2024-08-18 17:17:10', '2024-08-18 17:17:10'),
	(5, '1', 1, '2024-08-20 11:56:56', '2024-08-20 11:56:56'),
	(6, '2', 1, '2024-08-20 11:56:58', '2024-08-20 11:56:58'),
	(7, '333', 1, '2024-08-20 11:57:00', '2024-08-20 11:57:00');
/*!40000 ALTER TABLE `kinds` ENABLE KEYS */;

-- Dumping structure for table doan_banquanao.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan_banquanao.migrations: ~21 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2024_08_07_163929_create_permissions_table', 1),
	(5, '2024_08_07_171935_create_permission_details_table', 1),
	(6, '2024_08_14_143452_create_categories_table', 1),
	(7, '2024_08_14_143511_create_kinds_table', 1),
	(8, '2024_08_14_143951_create_products_table', 1),
	(9, '2024_08_14_145053_create_product_images_table', 1),
	(10, '2024_08_14_154456_create_colors_table', 1),
	(11, '2024_08_14_154503_create_product_colors_table', 1),
	(12, '2024_08_14_154509_create_sizes_table', 1),
	(13, '2024_08_14_154517_create_product_sizes_table', 1),
	(14, '2024_08_20_120631_create_banners_table', 2),
	(15, '2024_08_27_173120_create_coupons_table', 3),
	(16, '2024_08_28_091310_alter_users_table', 4),
	(17, '2024_08_28_095827_create_wishlists_table', 5),
	(18, '2024_09_04_190255_create_shipping_addresses_table', 6),
	(20, '2024_09_04_193149_alter_shipping_addresses_table', 7),
	(21, '2024_09_07_041302_alter_users_table', 8),
	(22, '2024_09_07_101425_create_orders_table', 8),
	(23, '2024_09_07_102126_create_order_details_table', 8);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table doan_banquanao.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT '0',
  `total` double NOT NULL,
  `discount` double DEFAULT NULL,
  `discount_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_code_unique` (`code`),
  KEY `orders_user_id_foreign` (`user_id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan_banquanao.orders: ~3 rows (approximately)
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` (`id`, `user_id`, `code`, `address`, `fullname`, `phone_number`, `payment_method`, `status`, `is_paid`, `total`, `discount`, `discount_code`, `note`, `created_at`, `updated_at`) VALUES
	(2, 7, 'QJKIPLXWU1', '123123', 'ho quang anh', '0372238783', 'cod', 2, 0, 951111, 60000, 'TEST', 'test', '2024-09-07 16:25:28', '2024-09-07 16:25:28'),
	(13, 7, 'OQJRVMHRJU', '123123', 'ho quang anh', '0372238783', 'online', 2, 0, 123123, NULL, NULL, NULL, '2024-09-07 17:40:50', '2024-09-07 17:40:50'),
	(14, 7, 'QJFJOJYATX', '123123', 'ho quang anh', '0372238783', 'online', 2, 0, 111111, NULL, NULL, '6', '2024-09-08 12:25:15', '2024-09-08 12:25:15'),
	(15, 7, 'II2GM4RHLY', '123123', 'ho quang anh', '0372238783', 'online', 2, 0, 3000, 297000, 'TEST', NULL, '2024-09-08 13:00:25', '2024-09-08 13:00:25'),
	(16, 7, '67TAUXY0RT', '123123', 'ho quang anh', '0372238783', 'online', 2, 1, 3000, 297000, 'TEST', NULL, '2024-09-08 13:16:19', '2024-09-08 13:25:07'),
	(17, 7, 'IP3YVGS2IT', '123123', 'ho quang anh', '0372238783', 'online', 2, 0, 1111.11, 109999.89, 'TEST', NULL, '2024-09-08 16:12:39', '2024-09-08 16:12:39'),
	(18, 7, 'Q8VQ91ZPPC', '123123', 'ho quang anh', '0372238783', 'cod', 2, 0, 111111, NULL, NULL, 'thanh toan khi nhan hang', '2024-09-08 16:18:38', '2024-09-08 16:18:38'),
	(19, 7, '2A0AVBLXII', '123123', 'ho quang anh', '0372238783', 'online', 2, 0, 1111.11, 109999.89, 'TEST', 'thanh toan online', '2024-09-08 16:19:22', '2024-09-08 16:19:22'),
	(20, 7, 'OV8FARZ7GH', '123123', 'ho quang anh', '0372238783', 'online', 2, 0, 0, 0, 'TEST', 'thanh toan online', '2024-09-08 16:20:03', '2024-09-08 16:20:03'),
	(21, 7, 'SW5OGTZBME', '123123', 'ho quang anh', '0372238783', 'online', 2, 0, 1111.11, 109999.89, 'TEST', NULL, '2024-09-08 16:21:23', '2024-09-08 16:21:23'),
	(22, 7, 'VWKBHSKBNN', '123123', 'ho quang anh', '0372238783', 'online', 2, 0, 111111, NULL, NULL, NULL, '2024-09-08 16:26:10', '2024-09-08 16:26:10');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

-- Dumping structure for table doan_banquanao.order_details
CREATE TABLE IF NOT EXISTS `order_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `color_id` bigint(20) unsigned NOT NULL,
  `size_id` bigint(20) unsigned NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_details_order_id_foreign` (`order_id`),
  KEY `order_details_product_id_foreign` (`product_id`),
  KEY `order_details_color_id_foreign` (`color_id`),
  KEY `order_details_size_id_foreign` (`size_id`),
  CONSTRAINT `order_details_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `order_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `order_details_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan_banquanao.order_details: ~5 rows (approximately)
/*!40000 ALTER TABLE `order_details` DISABLE KEYS */;
INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `color_id`, `size_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
	(1, 2, 7, 4, 4, 1, 300000, '2024-09-07 16:25:28', '2024-09-07 16:25:28'),
	(2, 2, 7, 4, 5, 2, 300000, '2024-09-07 16:25:28', '2024-09-07 16:25:28'),
	(3, 2, 4, 1, 2, 1, 111111, '2024-09-07 16:25:28', '2024-09-07 16:25:28'),
	(5, 13, 8, 1, 1, 1, 123123, '2024-09-07 17:40:50', '2024-09-07 17:40:50'),
	(6, 14, 4, 1, 2, 1, 111111, '2024-09-08 12:25:15', '2024-09-08 12:25:15'),
	(7, 15, 7, 3, 4, 1, 300000, '2024-09-08 13:00:25', '2024-09-08 13:00:25'),
	(8, 16, 7, 3, 4, 1, 300000, '2024-09-08 13:16:19', '2024-09-08 13:16:19'),
	(9, 17, 4, 1, 2, 1, 111111, '2024-09-08 16:12:39', '2024-09-08 16:12:39'),
	(10, 18, 4, 1, 2, 1, 111111, '2024-09-08 16:18:38', '2024-09-08 16:18:38'),
	(11, 19, 4, 1, 2, 1, 111111, '2024-09-08 16:19:22', '2024-09-08 16:19:22'),
	(12, 21, 4, 1, 2, 1, 111111, '2024-09-08 16:21:23', '2024-09-08 16:21:23'),
	(13, 22, 4, 1, 2, 1, 111111, '2024-09-08 16:26:10', '2024-09-08 16:26:10');
/*!40000 ALTER TABLE `order_details` ENABLE KEYS */;

-- Dumping structure for table doan_banquanao.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan_banquanao.password_reset_tokens: ~0 rows (approximately)
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;

-- Dumping structure for table doan_banquanao.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan_banquanao.permissions: ~0 rows (approximately)
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;

-- Dumping structure for table doan_banquanao.permission_details
CREATE TABLE IF NOT EXISTS `permission_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permission_details_permission_id_foreign` (`permission_id`),
  CONSTRAINT `permission_details_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan_banquanao.permission_details: ~0 rows (approximately)
/*!40000 ALTER TABLE `permission_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `permission_details` ENABLE KEYS */;

-- Dumping structure for table doan_banquanao.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `old_price` double DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `washing_instructions` text COLLATE utf8mb4_unicode_ci,
  `kind_id` bigint(20) unsigned NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `stock` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_kind_id_foreign` (`kind_id`),
  CONSTRAINT `products_kind_id_foreign` FOREIGN KEY (`kind_id`) REFERENCES `kinds` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan_banquanao.products: ~5 rows (approximately)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `name`, `price`, `old_price`, `description`, `washing_instructions`, `kind_id`, `is_active`, `stock`, `created_at`, `updated_at`) VALUES
	(3, '1997', 123, NULL, NULL, NULL, 1, 1, 1, '2024-08-19 17:06:31', '2024-09-07 17:11:18'),
	(4, 'test_update123', 111111, 123123, '<h1>123123123</h1>', '<p><u>123123123</u></p>', 4, 1, 7772, '2024-08-19 17:07:19', '2024-09-08 16:26:10'),
	(5, '1997', 12312321311, NULL, NULL, '<p><br></p>', 1, 1, 10, '2024-08-19 17:08:11', '2024-08-19 17:08:11'),
	(7, 'Sản phẩm FULL all', 300000, 1000000, '<p>mo ta</p>', '<p><br></p>', 2, 1, 6, '2024-08-19 18:05:29', '2024-09-08 13:16:19'),
	(8, '123123123', 123123, NULL, NULL, NULL, 1, 1, 0, '2024-08-19 19:21:50', '2024-09-07 17:40:50'),
	(9, 'san pham khong co size', 1000, 1000, NULL, NULL, 1, 1, 10, '2024-08-26 16:59:53', '2024-08-26 16:59:53');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- Dumping structure for table doan_banquanao.product_colors
CREATE TABLE IF NOT EXISTS `product_colors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `color_id` bigint(20) unsigned NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_colors_product_id_foreign` (`product_id`),
  KEY `product_colors_color_id_foreign` (`color_id`),
  CONSTRAINT `product_colors_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `product_colors_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan_banquanao.product_colors: ~20 rows (approximately)
/*!40000 ALTER TABLE `product_colors` DISABLE KEYS */;
INSERT INTO `product_colors` (`id`, `product_id`, `color_id`, `is_active`, `created_at`, `updated_at`) VALUES
	(9, 3, 1, 1, NULL, NULL),
	(10, 3, 2, 1, NULL, NULL),
	(11, 3, 3, 1, NULL, NULL),
	(12, 3, 4, 1, NULL, NULL),
	(17, 5, 1, 1, NULL, NULL),
	(18, 5, 2, 1, NULL, NULL),
	(19, 5, 3, 1, NULL, NULL),
	(20, 5, 4, 1, NULL, NULL),
	(89, 8, 1, 1, NULL, NULL),
	(90, 8, 2, 1, NULL, NULL),
	(91, 8, 3, 1, NULL, NULL),
	(92, 8, 4, 1, NULL, NULL),
	(97, 4, 1, 1, NULL, NULL),
	(98, 4, 3, 1, NULL, NULL),
	(101, 7, 3, 1, NULL, NULL),
	(102, 7, 4, 1, NULL, NULL),
	(103, 9, 1, 1, NULL, NULL),
	(104, 9, 2, 1, NULL, NULL),
	(105, 9, 3, 1, NULL, NULL),
	(106, 9, 4, 1, NULL, NULL);
/*!40000 ALTER TABLE `product_colors` ENABLE KEYS */;

-- Dumping structure for table doan_banquanao.product_images
CREATE TABLE IF NOT EXISTS `product_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_on_top` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_images_product_id_foreign` (`product_id`),
  CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan_banquanao.product_images: ~13 rows (approximately)
/*!40000 ALTER TABLE `product_images` DISABLE KEYS */;
INSERT INTO `product_images` (`id`, `product_id`, `image`, `is_on_top`, `created_at`, `updated_at`) VALUES
	(2, 5, 'app_models_productimage/1724087291_FjOR5WAXf6.jpg', 0, NULL, NULL),
	(3, 5, 'app_models_productimage/1724087291_xCeRKuUaOR.jpg', 0, NULL, NULL),
	(4, 5, 'app_models_productimage/1724087291_yjuzR6Vujp.png', 0, NULL, NULL),
	(5, 5, 'app_models_productimage/1724087291_Vbo5HyZEQs.jpg', 0, NULL, NULL),
	(6, 5, 'app_models_productimage/1724087291_bJ4qbhfVvR.jpg', 0, NULL, NULL),
	(10, 7, 'app_models_productimage/1724090729_LFq6KKZbHv.jpg', 1, NULL, NULL),
	(18, 4, 'app_models_productimage/1724094942_H8NdNPc1ly.jpg', 0, NULL, NULL),
	(19, 4, 'app_models_productimage/1724094942_iy8vsm1TFX.jpg', 0, NULL, NULL),
	(27, 8, 'app_models_productimage/1724095310_GQkpv16JF6.jpg', 0, NULL, NULL),
	(28, 8, 'app_models_productimage/1724095310_mxpPJumUJD.jpg', 0, NULL, NULL),
	(29, 8, 'app_models_productimage/1724095310_e06DUjq9br.png', 0, NULL, NULL),
	(30, 4, 'app_models_productimage/1724161019_mx1DYgaAiJ.png', 1, NULL, NULL),
	(31, 7, 'app_models_productimage/1724175969_Ui4UwCQuAa.png', 0, NULL, NULL),
	(32, 7, 'app_models_productimage/1724175969_YGVOfUhW6w.png', 0, NULL, NULL),
	(33, 7, 'app_models_productimage/1724175969_AsHuuVjCFk.png', 0, NULL, NULL);
/*!40000 ALTER TABLE `product_images` ENABLE KEYS */;

-- Dumping structure for table doan_banquanao.product_sizes
CREATE TABLE IF NOT EXISTS `product_sizes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `size_id` bigint(20) unsigned NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_sizes_product_id_foreign` (`product_id`),
  KEY `product_sizes_size_id_foreign` (`size_id`),
  CONSTRAINT `product_sizes_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `product_sizes_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan_banquanao.product_sizes: ~12 rows (approximately)
/*!40000 ALTER TABLE `product_sizes` DISABLE KEYS */;
INSERT INTO `product_sizes` (`id`, `product_id`, `size_id`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 3, 1, 1, NULL, NULL),
	(2, 3, 2, 1, NULL, NULL),
	(5, 5, 1, 1, NULL, NULL),
	(6, 5, 2, 1, NULL, NULL),
	(42, 8, 1, 1, NULL, NULL),
	(43, 8, 2, 1, NULL, NULL),
	(54, 4, 2, 1, NULL, NULL),
	(60, 7, 1, 1, NULL, NULL),
	(61, 7, 2, 1, NULL, NULL),
	(62, 7, 3, 1, NULL, NULL),
	(63, 7, 4, 1, NULL, NULL),
	(64, 7, 5, 1, NULL, NULL);
/*!40000 ALTER TABLE `product_sizes` ENABLE KEYS */;

-- Dumping structure for table doan_banquanao.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `level` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan_banquanao.roles: ~4 rows (approximately)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `level`, `name`, `created_at`, `updated_at`) VALUES
	(1, 0, 'ROOT', '2024-08-18 08:21:14', '2024-08-18 08:21:14'),
	(2, 1, 'Super Admin', '2024-08-18 08:21:14', '2024-08-18 08:21:14'),
	(3, 2, 'Admin', '2024-08-18 08:21:14', '2024-08-18 08:21:14'),
	(4, 3, 'User', '2024-08-18 08:21:14', '2024-08-18 08:21:14');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- Dumping structure for table doan_banquanao.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan_banquanao.sessions: ~4 rows (approximately)
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('GqB89gfxaabiJYP1cHB8q74Eik0CLsbEzkKxasxk', 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoiOTV0eGlKaTF4ejdYZHNxWWxzeEZiVEFmYlNxOThiR282WWRoZVA4NCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MTM6InByb2R1Y3RWaWV3ZWQiO2E6MTp7aTowO2k6NDt9czo0OiJjYXJ0IjthOjA6e31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo3O3M6ODoiZGlzY291bnQiO047czoxMDoiZmluYWxfY2FydCI7YTowOnt9fQ==', 1725818543);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;

-- Dumping structure for table doan_banquanao.shipping_addresses
CREATE TABLE IF NOT EXISTS `shipping_addresses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shipping_addresses_user_id_foreign` (`user_id`),
  CONSTRAINT `shipping_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan_banquanao.shipping_addresses: ~2 rows (approximately)
/*!40000 ALTER TABLE `shipping_addresses` DISABLE KEYS */;
INSERT INTO `shipping_addresses` (`id`, `user_id`, `address`, `name`, `fullname`, `phone_number`, `is_default`, `created_at`, `updated_at`) VALUES
	(11, 7, '123123', 'nhà', 'ho quang anh', '0372238783', 1, '2024-09-07 05:58:49', '2024-09-07 05:59:02'),
	(12, 7, '12312123123', 'cty', 'ho quang anh', '0372238783', 0, '2024-09-07 06:13:18', '2024-09-07 06:13:18');
/*!40000 ALTER TABLE `shipping_addresses` ENABLE KEYS */;

-- Dumping structure for table doan_banquanao.sizes
CREATE TABLE IF NOT EXISTS `sizes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan_banquanao.sizes: ~6 rows (approximately)
/*!40000 ALTER TABLE `sizes` DISABLE KEYS */;
INSERT INTO `sizes` (`id`, `name`, `number`, `created_at`, `updated_at`) VALUES
	(1, 'XS', '6-8', '2024-08-18 08:23:27', '2024-08-20 16:50:42'),
	(2, 'S', '8-10', '2024-08-18 17:35:43', '2024-08-18 17:35:43'),
	(3, 'M', '10-12', '2024-08-20 13:21:36', '2024-08-20 13:21:36'),
	(4, 'L', '12-14', '2024-08-20 13:21:44', '2024-08-20 13:21:44'),
	(5, 'XL', '14-16', '2024-08-20 13:21:50', '2024-08-20 13:21:50'),
	(6, 'XXL', '16-18', '2024-08-20 16:51:42', '2024-08-20 16:51:42');
/*!40000 ALTER TABLE `sizes` ENABLE KEYS */;

-- Dumping structure for table doan_banquanao.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `phone_number` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `has_send_email_shipping` tinyint(1) NOT NULL DEFAULT '1',
  `has_send_email_order` tinyint(1) NOT NULL DEFAULT '1',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` bigint(20) unsigned NOT NULL DEFAULT '4',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_foreign` (`role`),
  CONSTRAINT `users_role_foreign` FOREIGN KEY (`role`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan_banquanao.users: ~7 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `fullname`, `date_of_birth`, `phone_number`, `email`, `email_verified_at`, `has_send_email_shipping`, `has_send_email_order`, `password`, `provider`, `social_id`, `role`, `is_admin`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Ho Quang Anh', NULL, NULL, 'root@admin.com', NULL, 1, 1, '$2y$12$wk574LollFfI7WAjDLWZ5u.h.WxCX3I0P.kKfvBz1YN.yeDu7PlvO', NULL, NULL, 1, 1, 1, 'kI0VHMUATBYLZ7iZHzxhJTt45KZoI6FvXoLJGwYz8V3OQQeDYyieH9nj5GJL', '2024-08-18 08:21:14', '2024-08-18 08:21:14'),
	(2, 'Ho Quang Anh', NULL, NULL, 'superadmin@admin.com', NULL, 1, 1, '$2y$12$V8EKY.wvnO/s7QaZMTDii.YMdwoeAUWrHo3hjD.bZl3HgNTo73NPm', NULL, NULL, 2, 0, 1, NULL, '2024-08-18 08:21:14', '2024-08-18 08:21:14'),
	(3, 'Ho Quang Anh', NULL, NULL, 'admin@admin.com', NULL, 1, 1, '$2y$12$63XBoh2MXb6SI9mm461o0uirOfc3F/yElvW.O5MmuvexrLVC11m/.', NULL, NULL, 3, 0, 1, '0Ztdz6AqN0QhyQ4HXFpORclkH5WehR3Lz8wx1BmPJ4r37rTQqIqdp2THg2mt', '2024-08-18 08:21:15', '2024-08-18 08:21:15'),
	(4, 'Ho Quang Anh', NULL, NULL, 'user@admin.com', NULL, 1, 1, '$2y$12$KmxTomFAAtCBGZG8hU4SJOTFY82lGVjty.dKPGVtO/BpSaRctJhUC', NULL, NULL, 4, 0, 1, NULL, '2024-08-18 08:21:15', '2024-08-18 08:21:15'),
	(5, 'trinh xuan son', NULL, NULL, 'son123@gmail.com', NULL, 1, 1, '$2y$12$dCVHK9qUkW9tyL/MNnxioOAWtcWUlgm3Iytz32e9DED3Li4EY7zka', NULL, NULL, 4, 0, 1, NULL, '2024-08-28 09:09:45', '2024-08-28 09:09:45'),
	(6, 'Sơn Trịnh', NULL, NULL, 'sonit7122@gmail.com', NULL, 1, 1, '$2y$12$uToj/emWVTQP5Rxkzh5wjuxJMbXI6Du352LvbFWxbgKcBuXuVQwci', 'google', '101571965691342130603', 4, 0, 1, NULL, '2024-08-28 09:33:51', '2024-09-03 17:35:36'),
	(7, 'ho quang anh', '2002-07-01', '0372238783', 'acczints001@gmail.com', '2024-09-04 16:59:55', 1, 1, '$2y$12$l1PJ1q8vj7/HRBLEtOiro.IEXQC5sgaig1ZFnqmM/f4l9SJl33wcS', 'google', '115460625758742207518', 4, 0, 1, NULL, '2024-09-03 13:58:47', '2024-09-04 17:21:46');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table doan_banquanao.wishlists
CREATE TABLE IF NOT EXISTS `wishlists` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wishlists_product_id_foreign` (`product_id`),
  KEY `wishlists_user_id_foreign` (`user_id`),
  CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan_banquanao.wishlists: ~3 rows (approximately)
/*!40000 ALTER TABLE `wishlists` DISABLE KEYS */;
INSERT INTO `wishlists` (`id`, `product_id`, `user_id`, `created_at`, `updated_at`) VALUES
	(11, 4, 7, '2024-09-03 15:00:53', '2024-09-03 15:00:53'),
	(12, 3, 7, '2024-09-03 15:00:54', '2024-09-03 15:00:54'),
	(13, 5, 7, '2024-09-03 15:00:56', '2024-09-03 15:00:56'),
	(14, 9, 7, '2024-09-04 17:28:12', '2024-09-04 17:28:12');
/*!40000 ALTER TABLE `wishlists` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
