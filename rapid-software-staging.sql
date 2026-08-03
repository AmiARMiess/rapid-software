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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rapid-software.departments: ~2 rows (approximately)
INSERT INTO `departments` (`id`, `user_id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Departments', NULL, NULL),
	(2, 1, 'Xepartments', NULL, NULL);

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

-- Dumping data for table rapid-software.employees: ~3 rows (approximately)
INSERT INTO `employees` (`id`, `user_id`, `full_name`, `ic_number`, `passport_number`, `employee_number`, `position`, `gender`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Amirul', '999999', NULL, '2112', 1, 1, '2026-08-02 06:05:25', '2026-08-02 06:05:26'),
	(2, 1, 'Ali', NULL, NULL, '4233', 1, 1, '2026-08-02 06:05:25', '2026-08-02 06:05:26'),
	(3, 2, 'Siti', '777777', NULL, '6546', 2, 2, '2026-08-02 06:05:25', '2026-08-02 06:05:26'),
	(4, 1, 'Amir', NULL, '4564353', '2456', 1, 1, '2026-08-02 06:05:25', '2026-08-02 06:05:26');

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

-- Dumping data for table rapid-software.option_levels: ~0 rows (approximately)
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

-- Dumping data for table rapid-software.option_statuses: ~2 rows (approximately)
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
  `status` bigint unsigned NOT NULL DEFAULT (0),
  `level` bigint unsigned NOT NULL DEFAULT '0',
  `department` bigint unsigned NOT NULL DEFAULT '0',
  `reporting_to` bigint unsigned NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rapid-software.positions: ~3 rows (approximately)
INSERT INTO `positions` (`id`, `user_id`, `name`, `status`, `level`, `department`, `reporting_to`, `description`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Senior Developer', 1, 1, 2, 1, 'lorem ipsum dolor sit amet', NULL, NULL),
	(2, 2, 'Aosition', 0, 0, 0, 0, NULL, NULL, NULL),
	(3, 1, 'Xosition', 0, 0, 0, 1, NULL, NULL, NULL);

-- Dumping structure for table rapid-software.position_responsibles
CREATE TABLE IF NOT EXISTS `position_responsibles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `position_id` bigint unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rapid-software.position_responsibles: ~0 rows (approximately)

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
	('3vduhltWzzcqAx95EuMqz15vnIs3gZCbRQMdtsBA', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:153.0) Gecko/20100101 Firefox/153.0', 'eyJfdG9rZW4iOiJtamZndzhralFGdUV5SG1zZG9iWXpHcHkySjBzZVl0UklQU29vZ1QxIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC9yYXBpZC1zb2Z0d2FyZS50ZXN0XC9hZG1pblwvcG9zaXRpb25zXC9lZGl0XC8xIiwicm91dGUiOiJhZG1pbi5lZGl0LnBvc2l0aW9uIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjF9', 1785739819);

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
