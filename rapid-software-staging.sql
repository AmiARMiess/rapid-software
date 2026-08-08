-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table rapid-software.attendances
CREATE TABLE IF NOT EXISTS `attendances` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rapid-software.attendances: ~0 rows (approximately)

-- Dumping structure for table rapid-software.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rapid-software.cache: ~2 rows (approximately)
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
	('laravel-cache-fddfdsfsd@fdfgd.com|127.0.0.1', 'i:1;', 1785383315),
	('laravel-cache-fddfdsfsd@fdfgd.com|127.0.0.1:timer', 'i:1785383315;', 1785383315);

-- Dumping structure for table rapid-software.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rapid-software.cache_locks: ~0 rows (approximately)

-- Dumping structure for table rapid-software.claims
CREATE TABLE IF NOT EXISTS `claims` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rapid-software.claims: ~0 rows (approximately)

-- Dumping structure for table rapid-software.company_details
CREATE TABLE IF NOT EXISTS `company_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rapid-software.company_details: ~0 rows (approximately)

-- Dumping structure for table rapid-software.departments
CREATE TABLE IF NOT EXISTS `departments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` bigint unsigned DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rapid-software.departments: ~4 rows (approximately)
INSERT INTO `departments` (`id`, `user_id`, `name`, `status`, `description`, `created_at`, `updated_at`) VALUES
	(2, 1, 'Department', 2, 'dsfdsddzz', '2026-08-06 03:56:53', '2026-08-05 20:02:12'),
	(4, 1, 'Technology', NULL, 'fdgdfgdf', '2026-08-05 03:58:03', '2026-08-05 17:40:12'),
	(10, 1, 'Timbalan Perdana Menteri', 1, 'fdsfdsc', '2026-08-05 19:47:57', '2026-08-05 19:48:04'),
	(11, 1, 'www', 2, 'gfdgfdgf', '2026-08-05 20:35:28', '2026-08-05 20:35:28');

-- Dumping structure for table rapid-software.department_responsibles
CREATE TABLE IF NOT EXISTS `department_responsibles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `department_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rapid-software.department_responsibles: ~12 rows (approximately)
INSERT INTO `department_responsibles` (`id`, `department_id`, `name`) VALUES
	(35, 7, 'csdczzz'),
	(36, 7, 'fdcxxxx'),
	(40, 4, 'fgfdggdf'),
	(41, 4, 'fgdfgd'),
	(43, 9, 'fgfdg'),
	(44, 9, 'fdgfdgcc'),
	(48, 10, 'dfdsfsdfds'),
	(49, 10, 'csdczzz'),
	(50, 10, 'Coach junior engineers and support onboarding'),
	(55, 2, 'gdfdgfdfg'),
	(56, 2, 'gfdgdfcvc'),
	(62, 11, 'gfdgfdcc'),
	(63, 11, 'bnhgnhgghn');

-- Dumping structure for table rapid-software.employees
CREATE TABLE IF NOT EXISTS `employees` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `full_name` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ic_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passport_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_number` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` bigint unsigned NOT NULL,
  `gender` bigint NOT NULL DEFAULT (0),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rapid-software.employees: ~4 rows (approximately)
INSERT INTO `employees` (`id`, `user_id`, `full_name`, `ic_number`, `passport_number`, `employee_number`, `position`, `gender`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Amirul', '999999', NULL, '2112', 17, 1, '2026-08-02 06:05:25', '2026-08-02 06:05:26'),
	(2, 2, 'Ali', NULL, NULL, '4233', 17, 1, '2026-08-02 06:05:25', '2026-08-02 06:05:26'),
	(3, 1, 'Siti', '777777', NULL, '6546', 17, 2, '2026-08-02 06:05:25', '2026-08-02 06:05:26'),
	(4, 2, 'Amir', NULL, '4564353', '2456', 17, 1, '2026-08-02 06:05:25', '2026-08-02 06:05:26');

-- Dumping structure for table rapid-software.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rapid-software.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table rapid-software.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rapid-software.jobs: ~0 rows (approximately)

-- Dumping structure for table rapid-software.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rapid-software.job_batches: ~0 rows (approximately)

-- Dumping structure for table rapid-software.leaves
CREATE TABLE IF NOT EXISTS `leaves` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rapid-software.leaves: ~0 rows (approximately)

-- Dumping structure for table rapid-software.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rapid-software.migrations: ~0 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1);

-- Dumping structure for table rapid-software.option_bank_names
CREATE TABLE IF NOT EXISTS `option_bank_names` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rapid-software.option_bank_names: ~0 rows (approximately)

-- Dumping structure for table rapid-software.option_employment_types
CREATE TABLE IF NOT EXISTS `option_employment_types` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `employment_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rapid-software.option_employment_types: ~0 rows (approximately)

-- Dumping structure for table rapid-software.option_genders
CREATE TABLE IF NOT EXISTS `option_genders` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `gender` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rapid-software.option_genders: ~2 rows (approximately)
INSERT INTO `option_genders` (`id`, `gender`) VALUES
	(1, 'Male'),
	(2, 'Female');

-- Dumping structure for table rapid-software.option_levels
CREATE TABLE IF NOT EXISTS `option_levels` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rapid-software.option_levels: ~4 rows (approximately)
INSERT INTO `option_levels` (`id`, `name`) VALUES
	(1, 'L1'),
	(2, 'L2'),
	(3, 'L3'),
	(4, 'L4');

-- Dumping structure for table rapid-software.option_marital_statuses
CREATE TABLE IF NOT EXISTS `option_marital_statuses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `marital_status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rapid-software.option_marital_statuses: ~0 rows (approximately)

-- Dumping structure for table rapid-software.option_religions
CREATE TABLE IF NOT EXISTS `option_religions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `religion` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rapid-software.option_religions: ~0 rows (approximately)

-- Dumping structure for table rapid-software.option_statuses
CREATE TABLE IF NOT EXISTS `option_statuses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rapid-software.option_statuses: ~3 rows (approximately)
INSERT INTO `option_statuses` (`id`, `name`) VALUES
	(1, 'Active'),
	(2, 'Inactive'),
	(3, 'Pending');

-- Dumping structure for table rapid-software.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rapid-software.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table rapid-software.positions
CREATE TABLE IF NOT EXISTS `positions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` bigint unsigned DEFAULT '0',
  `level` bigint unsigned DEFAULT '0',
  `department` bigint unsigned DEFAULT '0',
  `reporting_to` bigint unsigned DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rapid-software.positions: ~5 rows (approximately)
INSERT INTO `positions` (`id`, `user_id`, `name`, `status`, `level`, `department`, `reporting_to`, `description`, `created_at`, `updated_at`) VALUES
	(2, 2, 'Manager', 2, 3, 1, NULL, NULL, NULL, '2026-08-03 18:02:04'),
	(14, 1, 'Prime Minister', 1, 2, 4, 13, 'helllooo worldd!....', '2026-08-03 20:52:27', '2026-08-03 20:54:10'),
	(15, 1, 'Senior Developer', 2, 4, 11, 14, 'Leads software delivery, coordinates technical planning, and ensures best practices are followed across the engineering team.', '2026-08-03 21:21:57', '2026-08-05 03:24:04'),
	(17, 1, 'DevOps', 2, 3, 2, 13, 'fdsfsdf', '2026-08-04 19:04:55', '2026-08-04 19:04:55'),
	(18, 1, 'Timbalan Perdana Menteri', 2, 2, 10, 15, 'lorem', '2026-08-05 03:25:31', '2026-08-05 03:25:31');

-- Dumping structure for table rapid-software.position_responsibles
CREATE TABLE IF NOT EXISTS `position_responsibles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `position_id` bigint unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rapid-software.position_responsibles: ~13 rows (approximately)
INSERT INTO `position_responsibles` (`id`, `position_id`, `name`) VALUES
	(20, 14, 'fggfdgdfgdf...'),
	(33, 1, 'bnhgnhgghn'),
	(34, 1, 'dsadsad'),
	(35, 1, 'lorem dolor sit amet...'),
	(66, 17, 'dsfsdfsd'),
	(67, 17, 'dsfsdf'),
	(76, 15, 'Guide technical roadmap and sprint execution'),
	(77, 15, 'Review architecture decisions and code quality'),
	(78, 15, 'Coach junior engineers and support onboarding'),
	(79, 15, 'Ensure delivery timelines and standards are met'),
	(81, 13, 'gfdxxxx'),
	(82, 18, 'fdgdg'),
	(83, 18, 'gfdcc'),
	(84, 18, 'fgdfvv');

-- Dumping structure for table rapid-software.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rapid-software.sessions: ~1 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('NsS82Bu1nRlBgyFwf8E2wuZ3CUyNvs7ujYzMVKmM', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:153.0) Gecko/20100101 Firefox/153.0', 'eyJfdG9rZW4iOiJMQlFYTldSTGtRU1dxVUs5WlRja3hXWml6NEtGUkpCUDB5ZFc3NjI2IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC9yYXBpZC1zb2Z0d2FyZS50ZXN0XC9hZG1pblwvZGVwYXJ0bWVudHNcL2RhdGF0YWJsZT9pdGVtc1BlclBhZ2U9OCZwYWdlPTEmc2VhcmNoPSZzb3J0Qnk9JTVCJTVEIiwicm91dGUiOiJhZG1pbi5kYXRhdGFibGUuZGVwYXJ0bWVudCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxfQ==', 1786091630);

-- Dumping structure for table rapid-software.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rapid-software.users: ~2 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Admin', 'admin@mail.com', '2026-07-27 01:03:24', '$2y$12$.yR6JpG5TuULeVqdxSSWYuHitVZWbBOXGaGsWY//DdvttcZHDIeue', 'admin', NULL, NULL, '2026-07-27 19:34:59'),
	(2, 'Employee', 'employee@mail.com', '2026-07-27 01:42:57', '$2y$12$vBbyAVN7/SqIqyZQtc24keZ69X.pV5B5KaXGSD0Zbgg5wZPcofDpC', 'employee', NULL, NULL, '2026-07-27 01:42:57');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
