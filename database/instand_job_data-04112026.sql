-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 04, 2026 at 11:16 AM
-- Server version: 8.3.0
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `instand_job_data`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

DROP TABLE IF EXISTS `districts`;
CREATE TABLE IF NOT EXISTS `districts` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `division_id` bigint UNSIGNED NOT NULL,
  `name_en` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_bn` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `sort_order` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `districts_code_unique` (`code`),
  KEY `districts_division_id_status_index` (`division_id`,`status`),
  KEY `districts_status_index` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `division_id`, `name_en`, `name_bn`, `code`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'Dhaka', 'ঢাকা', 'DHAKA-DIST', 1, 1, '2026-09-23 03:12:20', '2026-09-23 03:12:20'),
(2, 2, 'Chattogram', 'চট্টগ্রাম', 'CHATTOGRAM-DIST', 1, 1, '2026-09-23 03:12:20', '2026-09-23 03:12:20');

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

DROP TABLE IF EXISTS `divisions`;
CREATE TABLE IF NOT EXISTS `divisions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_en` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_bn` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `sort_order` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `divisions_code_unique` (`code`),
  KEY `divisions_name_en_index` (`name_en`),
  KEY `divisions_status_index` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`id`, `name_en`, `name_bn`, `code`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Dhaka', 'ঢাকা', 'DHAKA', 1, 1, '2026-09-23 03:12:20', '2026-09-23 03:12:20'),
(2, 'Chattogram', 'চট্টগ্রাম', 'CHATTOGRAM', 1, 2, '2026-09-23 03:12:20', '2026-09-23 03:12:20');

-- --------------------------------------------------------

--
-- Table structure for table `employer_profiles`
--

DROP TABLE IF EXISTS `employer_profiles`;
CREATE TABLE IF NOT EXISTS `employer_profiles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `employer_type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'individual',
  `business_name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_description` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employer_profiles_user_id_unique` (`user_id`),
  KEY `employer_profiles_employer_type_index` (`employer_type`),
  KEY `employer_profiles_status_index` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employer_profiles`
--

INSERT INTO `employer_profiles` (`id`, `user_id`, `employer_type`, `business_name`, `business_type`, `business_description`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'business', 'Ekhon Job Services', 'Service Company', 'We hire skilled workers through the Ekhon Job platform.', 1, '2026-10-02 23:51:28', '2026-10-03 00:21:50'),
(2, 4, 'individual', NULL, NULL, NULL, 1, '2026-10-18 03:53:05', '2026-10-18 03:53:05');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_categories`
--

DROP TABLE IF EXISTS `job_categories`;
CREATE TABLE IF NOT EXISTS `job_categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `sort_order` int UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `job_categories_slug_unique` (`slug`),
  KEY `job_categories_status_index` (`status`),
  KEY `job_categories_sort_order_index` (`sort_order`),
  KEY `job_categories_parent_id_index` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_categories`
--

INSERT INTO `job_categories` (`id`, `name`, `slug`, `description`, `icon`, `parent_id`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Plumbing', 'plumbing', 'Plumbing and pipe fitting services.', NULL, NULL, 1, 1, '2026-10-01 00:53:35', '2026-10-01 00:53:35'),
(2, 'Electrical', 'electrical', 'Electrical installation and repair services.', NULL, NULL, 2, 1, '2026-10-01 00:53:35', '2026-10-01 00:53:35'),
(3, 'AC Service', 'ac-service', 'Air conditioner installation, servicing and repair.', NULL, NULL, 3, 1, '2026-10-01 00:53:35', '2026-10-01 00:53:35'),
(4, 'Cleaning', 'cleaning', 'Home, office and general cleaning services.', NULL, NULL, 4, 1, '2026-10-01 00:53:35', '2026-10-01 00:53:35'),
(5, 'Painting', 'painting', 'Home, office and building painting services.', NULL, NULL, 5, 1, '2026-10-01 00:53:35', '2026-10-01 00:53:35'),
(6, 'Carpentry', 'carpentry', 'Furniture and carpentry services.', NULL, NULL, 6, 1, '2026-10-01 00:53:35', '2026-10-01 00:53:35'),
(7, 'Driver', 'driver', 'Personal, company and temporary driving services.', NULL, NULL, 7, 1, '2026-10-01 00:53:35', '2026-10-01 00:53:35'),
(8, 'Waiter', 'waiter', 'Restaurant, event and temporary waiter services.', NULL, NULL, 8, 1, '2026-10-01 00:53:35', '2026-10-01 00:53:35'),
(9, 'Helper', 'helper', 'General helper and support services.', NULL, NULL, 9, 1, '2026-10-01 00:53:35', '2026-10-01 00:53:35'),
(10, 'Construction Worker', 'construction-worker', 'Construction and general building work.', NULL, NULL, 10, 1, '2026-10-01 00:53:35', '2026-10-01 00:53:35');

-- --------------------------------------------------------

--
-- Table structure for table `job_seeker_profiles`
--

DROP TABLE IF EXISTS `job_seeker_profiles`;
CREATE TABLE IF NOT EXISTS `job_seeker_profiles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `professional_title` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about` text COLLATE utf8mb4_unicode_ci,
  `experience_years` int UNSIGNED NOT NULL DEFAULT '0',
  `hourly_rate` decimal(12,2) DEFAULT NULL,
  `daily_rate` decimal(12,2) DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `job_seeker_profiles_user_id_unique` (`user_id`),
  KEY `job_seeker_profiles_is_available_index` (`is_available`),
  KEY `job_seeker_profiles_status_index` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_seeker_profiles`
--

INSERT INTO `job_seeker_profiles` (`id`, `user_id`, `professional_title`, `about`, `experience_years`, `hourly_rate`, `daily_rate`, `is_available`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 'Plumber, Electrician & AC Technician', 'Experienced in plumbing, electrical work and AC servicing.', 5, 300.00, 1500.00, 1, 1, '2026-10-01 04:18:43', '2026-10-05 05:17:07'),
(2, 4, NULL, NULL, 2, NULL, NULL, 1, 1, '2026-10-18 03:50:27', '2026-10-18 03:50:27');

-- --------------------------------------------------------

--
-- Table structure for table `marketplace_jobs`
--

DROP TABLE IF EXISTS `marketplace_jobs`;
CREATE TABLE IF NOT EXISTS `marketplace_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `hirer_id` bigint UNSIGNED NOT NULL,
  `job_category_id` bigint UNSIGNED NOT NULL,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `job_type` enum('instant','scheduled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'instant',
  `rate_type` enum('hourly','daily','fixed') COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate_amount` decimal(12,2) NOT NULL,
  `workers_required` smallint UNSIGNED NOT NULL DEFAULT '1',
  `hire_mode` enum('manual','auto') COLLATE utf8mb4_unicode_ci NOT NULL,
  `search_mode` enum('current','manual') COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `search_radius_km` decimal(6,2) NOT NULL DEFAULT '5.00',
  `location_address` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scheduled_at` datetime DEFAULT NULL,
  `status` enum('open','assigned','in_progress','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `started_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `worked_minutes` int UNSIGNED NOT NULL DEFAULT '0',
  `cancelled_at` datetime DEFAULT NULL,
  `cancellation_reason` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `marketplace_jobs_job_category_id_status_index` (`job_category_id`,`status`),
  KEY `marketplace_jobs_latitude_longitude_index` (`latitude`,`longitude`),
  KEY `marketplace_jobs_hirer_id_status_index` (`hirer_id`,`status`),
  KEY `marketplace_jobs_scheduled_at_index` (`scheduled_at`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `marketplace_jobs`
--

INSERT INTO `marketplace_jobs` (`id`, `hirer_id`, `job_category_id`, `title`, `description`, `job_type`, `rate_type`, `rate_amount`, `workers_required`, `hire_mode`, `search_mode`, `latitude`, `longitude`, `search_radius_km`, `location_address`, `scheduled_at`, `status`, `started_at`, `completed_at`, `worked_minutes`, `cancelled_at`, `cancellation_reason`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'Need an Electrician', 'Need an electrician for home electrical repair.', 'instant', 'hourly', 500.00, 1, 'manual', 'current', 23.8150000, 90.4200000, 5.00, 'Dhaka, Bangladesh', NULL, 'open', NULL, NULL, 0, NULL, NULL, '2026-10-07 05:44:24', '2026-10-07 05:44:24'),
(2, 4, 1, 'Need an Electrician', 'Need an electrician for home electrical repair.', 'instant', 'hourly', 500.00, 1, 'manual', 'current', 23.8150000, 90.4200000, 5.00, 'Dhaka, Bangladesh', NULL, 'open', NULL, NULL, 0, NULL, NULL, '2026-11-03 05:44:45', '2026-11-03 05:44:45'),
(3, 4, 1, 'Need an Electrician', 'Need an electrician for home electrical repair.', 'instant', 'hourly', 500.00, 1, 'manual', 'current', 23.8150000, 90.4200000, 5.00, 'Dhaka, Bangladesh', NULL, 'open', NULL, NULL, 0, NULL, NULL, '2026-11-04 03:40:22', '2026-11-04 03:40:22');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_09_20_062106_create_personal_access_tokens_table', 1),
(5, '2026_09_20_095708_create_mobile_otps_table', 1),
(6, '2026_09_20_100544_create_user_profiles_table', 1),
(7, '2026_09_20_100654_create_password_reset_tokens_table', 1),
(8, '2026_09_23_084817_create_divisions_table', 2),
(9, '2026_09_23_090526_create_districts_table', 2),
(10, '2026_09_23_090647_create_upazilas_table', 2),
(11, '2026_09_23_094830_add_location_fields_to_user_profiles_table', 3),
(14, '2026_09_24_100356_change_gender_column_in_user_profiles_table', 4),
(15, '2026_09_27_101556_create_user_verifications_table', 5),
(16, '2026_09_27_114245_add_verification_method_to_user_verifications_table', 6),
(17, '2026_09_29_055604_add_user_type_to_users_table', 7),
(18, '2026_10_01_063344_create_job_categories_table', 8),
(19, '2026_10_01_083002_create_job_seeker_profiles_table', 9),
(20, '2026_10_01_083810_create_worker_categories_table', 10),
(21, '2026_10_01_102517_create_skills_table', 11),
(22, '2026_10_01_105408_create_worker_skills_table', 12),
(23, '2026_10_03_034500_create_employer_profiles_table', 13),
(24, '2026_10_04_065427_create_user_locations_table', 14),
(25, '2026_10_04_103006_create_user_presences_table', 15),
(26, '2026_10_07_112510_create_marketplace_jobs_table', 16);

-- --------------------------------------------------------

--
-- Table structure for table `mobile_otps`
--

DROP TABLE IF EXISTS `mobile_otps`;
CREATE TABLE IF NOT EXISTS `mobile_otps` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `mobile` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp_hash` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purpose` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` timestamp NOT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `attempt_count` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `last_attempt_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mobile_otps_mobile_purpose_index` (`mobile`,`purpose`),
  KEY `mobile_otps_mobile_index` (`mobile`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mobile_otps`
--

INSERT INTO `mobile_otps` (`id`, `mobile`, `otp_hash`, `purpose`, `expires_at`, `verified_at`, `attempt_count`, `last_attempt_at`, `created_at`, `updated_at`) VALUES
(3, '01516125589', '$2y$12$ytrNJXYlqQb114LFsHICpuJqX39PAt2z6Baw6nBIYItQkbb0LQJzy', 'forgot_password', '2026-09-23 02:47:18', '2026-09-23 02:44:30', 1, '2026-09-23 02:44:30', '2026-09-23 02:42:18', '2026-09-23 02:44:30'),
(4, '01516125589', '$2y$12$/FN.Dktgdh33PUACiZKWMuYjvbXlflCYXx3Bbf8Lk728t8uQqhym.', 'forgot_password', '2026-09-24 02:51:44', '2026-09-24 02:48:40', 1, '2026-09-24 02:48:39', '2026-09-24 02:46:44', '2026-09-24 02:48:40'),
(5, '01516125589', '$2y$12$1ucpXtxvuw83P8/u73oU0eZqsaJxnfqtMwz2hHG31wwoo8XGad6kK', 'forgot_password', '2026-09-24 03:02:24', '2026-09-24 02:59:02', 1, '2026-09-24 02:59:02', '2026-09-24 02:57:24', '2026-09-24 02:59:02'),
(9, '01516125589', '$2y$12$/QFiN7nxQjL8e56uze44Tu4Jwl4nOlV2RCMquWL7uKSwR0cjoazF2', 'forgot_password', '2026-10-18 22:42:47', '2026-10-18 22:38:29', 1, '2026-10-18 22:38:28', '2026-10-18 22:37:47', '2026-10-18 22:38:29'),
(10, '01306713853', '$2y$12$vm3BNsBg6fgwuDQJvGKtiOvS7mGLpJG7WFRNOGYb268lurLJOB2SO', 'forgot_password', '2026-11-04 03:17:56', '2026-11-04 03:14:57', 1, '2026-11-04 03:14:57', '2026-11-04 03:12:56', '2026-11-04 03:14:57');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `mobile` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token_hash` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` timestamp NOT NULL,
  `used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `password_reset_tokens_mobile_expires_at_index` (`mobile`,`expires_at`),
  KEY `password_reset_tokens_mobile_index` (`mobile`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`id`, `mobile`, `token_hash`, `expires_at`, `used_at`, `created_at`, `updated_at`) VALUES
(3, '01516125589', '$2y$12$lKoRJ9.o0JUU/Sy7ndZlAOQIw05Ix5PHen0E3PXxJMo7tiABnuUx.', '2026-09-24 03:14:02', '2026-09-24 03:00:34', '2026-09-24 02:59:02', '2026-09-24 03:00:34'),
(4, '01516125589', '$2y$12$D37hronYOBKrGjPnZSHbwe.yVMODZZtraWvX12O66tFAkmJVY6yv6', '2026-10-18 22:53:29', '2026-10-18 22:47:39', '2026-10-18 22:38:29', '2026-10-18 22:47:39'),
(5, '01306713853', '$2y$12$FssK/fpvXZjxq2iO2MPRj.aPctBCg4uEYAwCqQCWtlMcB/Vzrw0Wi', '2026-11-04 03:29:58', '2026-11-04 03:22:09', '2026-11-04 03:14:58', '2026-11-04 03:22:09');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(19, 'App\\Models\\User', 1, 'auth-token', 'a3175c45a82f742a3e4691806a001725d25b20a8a67e0857f110f90ef0bdad49', '[\"*\"]', NULL, NULL, '2026-10-14 05:39:15', '2026-10-14 05:39:15'),
(26, 'App\\Models\\User', 2, 'auth-token', '68cb24711b901c115ed72f518c8485228186160ff341901e0af1ec6fba62e6a3', '[\"*\"]', '2026-11-04 02:50:52', NULL, '2026-11-04 02:29:23', '2026-11-04 02:50:52'),
(18, 'App\\Models\\User', 3, 'auth-token', 'f85b9cabfd2da0c1b4ed61f17f4cf492428f3c6ba44612b1dd9d7ea9118c74a2', '[\"*\"]', NULL, NULL, '2026-10-07 05:45:37', '2026-10-07 05:45:37'),
(27, 'App\\Models\\User', 4, 'auth-token', 'e925b516fc91cf54d4d10125b281b945234b022fe7c4629000a469a3627e37b1', '[\"*\"]', '2026-11-04 03:40:22', NULL, '2026-11-04 03:23:13', '2026-11-04 03:40:22');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('CzWefVk6SvH6msRcusSjQgPKe4T1t4SXCYOT8JlJ', NULL, '127.0.0.1', 'PostmanRuntime/7.56.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUDRhbDlKSnNFRWFHRVJnMkVHb25vNDZ6dmhYUGRRcDZZZlV0bEFMNSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1790684084),
('HrvqmoDFqEMEmGFNHabmxkT7njNU2wUXLCDCVI2S', NULL, '127.0.0.1', 'PostmanRuntime/7.56.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNWtpTkVyMzlFYk16UHhEM1N4QkpHcUxicklXbVpjUUhqeEQ1cTFkUSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1790847855),
('XvM1RnA73WIRHws12eYZu7JbM4akpM3b3VYgo8wQ', NULL, '127.0.0.1', 'PostmanRuntime/7.56.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidTdvVVNRdWJrTEgxeGdpcDN4Y3NmNHhwYUNZQ21OV2JBVlNDOU5VVyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1790835587),
('E0inWH65IlhLeNF3yFFXCb3IPoQj3SBzvPTpXKv5', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:157.0) Gecko/20100101 Firefox/157.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOE8yMU15S09EYkt2aDdZQUxBYmVOQUlBcXJ3cGdVRHc5MU1hdGRQTSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1790998625),
('d1fVFCpHdsYt0smmvFABflHU6RB1bNP2m3G06q2k', NULL, '127.0.0.1', 'PostmanRuntime/7.56.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRVlzM0hra2M2SzgySkkxelUwVlR4NUthRkhOMWk1S1JPc2tpR2FDeCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1791006641),
('5yLLfFdKSOeCaIk9opKJLQIkKoWRgNTq8a1SV4m2', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:157.0) Gecko/20100101 Firefox/157.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY2RQSnhYWkxOWkl3MDdPVzRGY0Q2cG5ka0VsVG1LSGpJampVVE5ETCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1791094597),
('UQuk9xYwMUw3kj3FtYmGVZGf6fc3KnjCiJCWnD2I', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:157.0) Gecko/20100101 Firefox/157.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTld4SGI1ZDdLWk1RQm83OUdlMHVFYWxxbzc2Sm5RR2ZtMnhYUjNKTSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1790837400),
('6ZZCzLZ4ovNt7C5IH6Pm0XLCgog9fLeX2w7zY2QP', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:157.0) Gecko/20100101 Firefox/157.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZUZOTG9LQkVPclBrRTh0Q0U2OTdMVHhTa09BZTVoZFd5Z3ZkR2VDNiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1791109741),
('8eWxOxEvlO6P4MFq0hCUv34ytm5jTjeaUdnoscUP', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:157.0) Gecko/20100101 Firefox/157.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib2JqZ0dzQ2pQUEhvYXFFMDA5bEp2aWVPRm5GenRsakVhQjhWbjIyeiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1791194199),
('UXpgLk9BZ58mMsieY70ifj5dpJFg9YiOqdFv2ZVY', NULL, '127.0.0.1', 'PostmanRuntime/2.11.2', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVTZxVjF6bmlXTTNsYzdXZHN0b2tiZ2lCMHhtUDZBSVhERVhsaUl4byI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1791979412),
('0hyIfOe4ehnWsJ4CGYoLQwh0y6awOMqqctmehCcf', NULL, '127.0.0.1', 'PostmanRuntime/2.11.2', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZXJCMnBsSGNuMFhheXNPc0J2eDZUY25EdTJiNUlKNnV1bmxmZFVWUyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792311687),
('p5vWIziUOrcF58ZURG80IUJOKhTltrRehayDwpU9', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:158.0) Gecko/20100101 Firefox/158.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNG00Zk1FNU1oanVTUGN3OGRrejdydjJLSWJoR1djZk9VQUpyNjR4WiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792314697),
('q3rNPTLGu1hDl8SDAAWYnEXWsdffpttnwpS3fUJd', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:158.0) Gecko/20100101 Firefox/158.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTFBrckJya3dGRXo3U2xTUjZ3cWVnZ3daaDNuVXc2UnBMUWkyRXhEViI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792383856),
('p09d5PcX1oeYfgt9v8QLMpAVHPokelyzofpDp9P9', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:159.0) Gecko/20100101 Firefox/159.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ1Jla2s0YUlrak4wVFM5VmlsV3BUcVR6WElNSzR2MURoTmJnWVRaMCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1793685774),
('pCtam1nKgF8KYY3yB8xspXVsHEGhFcQ5jEm8CujR', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:159.0) Gecko/20100101 Firefox/159.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTDBGMk93NVNHQkF0Z25VUFRCNW1pMDdxQzN4MnBiUmNsQ2lNQm5ZSSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1793779996),
('vTjXexiMXmHUkQbsqZ9mNks2OxN4KQyVAVlwjIcx', NULL, '127.0.0.1', 'PostmanRuntime/2.14.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNGJaRndvamZmMmtlRVBtUGRIVVFrREgxU1VtTnFJcHJ5ZVQ0NzhuRyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1793785008);

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

DROP TABLE IF EXISTS `skills`;
CREATE TABLE IF NOT EXISTS `skills` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `skills_slug_unique` (`slug`),
  KEY `skills_status_index` (`status`),
  KEY `skills_sort_order_index` (`sort_order`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `name`, `slug`, `description`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Pipe Fitting', 'pipe-fitting', 'Pipe fitting and installation work.', 1, 1, '2026-10-01 05:02:17', '2026-10-01 05:02:17'),
(2, 'Leak Repair', 'leak-repair', 'Water pipe and plumbing leak repair.', 1, 2, '2026-10-01 05:02:17', '2026-10-01 05:02:17'),
(3, 'Sanitary Installation', 'sanitary-installation', 'Sanitary fittings and installation.', 1, 3, '2026-10-01 05:02:17', '2026-10-01 05:02:17'),
(4, 'House Wiring', 'house-wiring', 'Residential electrical wiring.', 1, 4, '2026-10-01 05:02:17', '2026-10-01 05:02:17'),
(5, 'Switch Installation', 'switch-installation', 'Electrical switch and socket installation.', 1, 5, '2026-10-01 05:02:17', '2026-10-01 05:02:17'),
(6, 'Electrical Troubleshooting', 'electrical-troubleshooting', 'Electrical fault detection and repair.', 1, 6, '2026-10-01 05:02:17', '2026-10-01 05:02:17'),
(7, 'AC Installation', 'ac-installation', 'Air conditioner installation.', 1, 7, '2026-10-01 05:02:17', '2026-10-01 05:02:17'),
(8, 'AC Servicing', 'ac-servicing', 'Air conditioner servicing and maintenance.', 1, 8, '2026-10-01 05:02:17', '2026-10-01 05:02:17'),
(9, 'AC Repair', 'ac-repair', 'Air conditioner fault diagnosis and repair.', 1, 9, '2026-10-01 05:02:17', '2026-10-01 05:02:17'),
(10, 'Home Cleaning', 'home-cleaning', 'Residential home cleaning.', 1, 10, '2026-10-01 05:02:17', '2026-10-01 05:02:17'),
(11, 'Office Cleaning', 'office-cleaning', 'Office and commercial cleaning.', 1, 11, '2026-10-01 05:02:17', '2026-10-01 05:02:17'),
(12, 'Wall Painting', 'wall-painting', 'Interior and exterior wall painting.', 1, 12, '2026-10-01 05:02:17', '2026-10-01 05:02:17'),
(13, 'Color Mixing', 'color-mixing', 'Paint color preparation and mixing.', 1, 13, '2026-10-01 05:02:17', '2026-10-01 05:02:17'),
(14, 'Furniture Making', 'furniture-making', 'Furniture construction and finishing.', 1, 14, '2026-10-01 05:02:17', '2026-10-01 05:02:17'),
(15, 'Furniture Repair', 'furniture-repair', 'Furniture maintenance and repair.', 1, 15, '2026-10-01 05:02:17', '2026-10-01 05:02:17'),
(16, 'Car Driving', 'car-driving', 'Private and company car driving.', 1, 16, '2026-10-01 05:02:17', '2026-10-01 05:02:17'),
(17, 'Commercial Driving', 'commercial-driving', 'Commercial vehicle driving.', 1, 17, '2026-10-01 05:02:17', '2026-10-01 05:02:17'),
(18, 'Food Serving', 'food-serving', 'Restaurant and event food serving.', 1, 18, '2026-10-01 05:02:17', '2026-10-01 05:02:17'),
(19, 'Table Service', 'table-service', 'Restaurant table service.', 1, 19, '2026-10-01 05:02:17', '2026-10-01 05:02:17'),
(20, 'Construction Assistance', 'construction-assistance', 'General construction support work.', 1, 20, '2026-10-01 05:02:17', '2026-10-01 05:02:17'),
(21, 'Material Handling', 'material-handling', 'Loading, unloading and material handling.', 1, 21, '2026-10-01 05:02:17', '2026-10-01 05:02:17');

-- --------------------------------------------------------

--
-- Table structure for table `upazilas`
--

DROP TABLE IF EXISTS `upazilas`;
CREATE TABLE IF NOT EXISTS `upazilas` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `district_id` bigint UNSIGNED NOT NULL,
  `name_en` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_bn` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'upazila',
  `code` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `sort_order` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `upazilas_code_unique` (`code`),
  KEY `upazilas_district_id_status_index` (`district_id`,`status`),
  KEY `upazilas_district_id_type_index` (`district_id`,`type`),
  KEY `upazilas_status_index` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `upazilas`
--

INSERT INTO `upazilas` (`id`, `district_id`, `name_en`, `name_bn`, `type`, `code`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'Mirpur', 'মিরপুর', 'thana', 'MIRPUR', 1, 1, '2026-09-23 03:12:20', '2026-09-23 03:12:20'),
(2, 1, 'Uttara', 'উত্তরা', 'thana', 'UTTARA', 1, 2, '2026-09-23 03:12:20', '2026-09-23 03:12:20'),
(3, 2, 'Patiya', 'পটিয়া', 'upazila', 'PATIYA', 1, 1, '2026-09-23 03:12:20', '2026-09-23 03:12:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `mobile` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_verified_at` timestamp NULL DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `user_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_mobile_unique` (`mobile`),
  KEY `users_user_type_index` (`user_type`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `mobile`, `password`, `mobile_verified_at`, `status`, `user_type`, `last_login_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '01712345678', '$2y$12$OUOVaBW2waEB2nEpWAG0l.kc2/5KjrMHyyzUnTFgzxKsqEaqohcG2', NULL, 1, 'admin', '2026-10-14 05:39:14', NULL, '2026-09-20 22:55:42', '2026-10-14 05:39:14'),
(2, '01516125589', '$2y$12$NqI23o2MaHJWanOc6.fD5ehhGexYLHMTnQZqsrAHkwLehbyXSskJ6', NULL, 1, 'user', '2026-11-04 02:29:23', NULL, '2026-09-20 23:18:01', '2026-11-04 02:29:23'),
(3, '01752961131', '$2y$12$xBxZi49vHh95hVus5iAAlOC0Nl6SPYr6dsUC2OE//zF746ABsLpLC', NULL, 1, 'user', '2026-10-07 05:45:37', NULL, '2026-09-20 23:24:04', '2026-10-07 05:45:37'),
(4, '01306713853', '$2y$12$HBKeWgQOFN0hn5xGSozwyeAOQnBrMd4PZ0pmYt0pznAkhQQY1sola', NULL, 1, 'user', '2026-11-04 03:23:13', NULL, '2026-10-18 02:23:55', '2026-11-04 03:23:13');

-- --------------------------------------------------------

--
-- Table structure for table `user_locations`
--

DROP TABLE IF EXISTS `user_locations`;
CREATE TABLE IF NOT EXISTS `user_locations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `accuracy` decimal(10,2) DEFAULT NULL,
  `location_updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_locations_user_id_unique` (`user_id`),
  KEY `user_locations_latitude_longitude_index` (`latitude`,`longitude`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_locations`
--

INSERT INTO `user_locations` (`id`, `user_id`, `latitude`, `longitude`, `accuracy`, `location_updated_at`, `created_at`, `updated_at`) VALUES
(1, 2, 23.8150000, 90.4200000, 8.25, '2026-10-04 04:30:48', '2026-10-04 02:08:52', '2026-10-04 04:30:48');

-- --------------------------------------------------------

--
-- Table structure for table `user_presences`
--

DROP TABLE IF EXISTS `user_presences`;
CREATE TABLE IF NOT EXISTS `user_presences` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `is_online` tinyint(1) NOT NULL DEFAULT '0',
  `last_seen_at` timestamp NULL DEFAULT NULL,
  `last_activity_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_presences_user_id_unique` (`user_id`),
  KEY `user_presences_is_online_index` (`is_online`),
  KEY `user_presences_last_seen_at_index` (`last_seen_at`),
  KEY `user_presences_last_activity_at_index` (`last_activity_at`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_presences`
--

INSERT INTO `user_presences` (`id`, `user_id`, `is_online`, `last_seen_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES
(1, 2, 0, '2026-10-04 05:23:51', '2026-10-04 05:23:51', '2026-10-04 05:18:15', '2026-10-04 05:23:51');

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

DROP TABLE IF EXISTS `user_profiles`;
CREATE TABLE IF NOT EXISTS `user_profiles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `full_name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `division_id` bigint UNSIGNED DEFAULT NULL,
  `district_id` bigint UNSIGNED DEFAULT NULL,
  `upazila_id` bigint UNSIGNED DEFAULT NULL,
  `present_address` text COLLATE utf8mb4_unicode_ci,
  `permanent_address` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_profiles_user_id_unique` (`user_id`),
  KEY `user_profiles_division_id_foreign` (`division_id`),
  KEY `user_profiles_district_id_foreign` (`district_id`),
  KEY `user_profiles_upazila_id_foreign` (`upazila_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `full_name`, `profile_photo`, `date_of_birth`, `gender`, `division_id`, `district_id`, `upazila_id`, `present_address`, `permanent_address`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-20 22:55:42', '2026-09-20 22:55:42'),
(2, 2, 'Rahim Ahmed', 'profile-photos/2/TeL6lfMqikswQ1pvla6lIzxoYNJPpmwrfq9C3m1S.jpg', '1995-05-10', 'male', 1, 1, 1, 'Mirpur, Dhaka', 'Dhaka, Bangladesh', '2026-09-20 23:18:01', '2026-09-27 03:59:38'),
(3, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-20 23:24:04', '2026-09-20 23:24:04'),
(4, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-18 02:23:55', '2026-10-18 02:23:55');

-- --------------------------------------------------------

--
-- Table structure for table `user_verifications`
--

DROP TABLE IF EXISTS `user_verifications`;
CREATE TABLE IF NOT EXISTS `user_verifications` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `nid_number` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nid_front_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nid_back_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verification_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `verification_method` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user_submission',
  `rejection_reason` text COLLATE utf8mb4_unicode_ci,
  `verified_by` bigint UNSIGNED DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_verifications_user_id_unique` (`user_id`),
  KEY `user_verifications_verified_by_foreign` (`verified_by`),
  KEY `user_verifications_verification_status_index` (`verification_status`),
  KEY `user_verifications_nid_number_index` (`nid_number`),
  KEY `user_verifications_verification_method_index` (`verification_method`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_verifications`
--

INSERT INTO `user_verifications` (`id`, `user_id`, `nid_number`, `nid_front_path`, `nid_back_path`, `verification_status`, `verification_method`, `rejection_reason`, `verified_by`, `verified_at`, `created_at`, `updated_at`) VALUES
(1, 2, '4652077480', 'kyc/2/TwyKeh9S1ebLgJ5adFkKKOAfWJR3pLxutmOO4Wib.jpg', 'kyc/2/oYHwefOL94Jmae5ertKy8JdLjjvj0IC8kgkNCBwG.jpg', 'verified', 'user_submission', NULL, 1, '2026-09-29 05:11:45', '2026-09-27 06:22:50', '2026-09-29 05:11:45'),
(2, 1, '646545345453134', 'kyc/1/0nA17TtOJxp8RVqEOYWd28IT9NyOObapHhrbv4Sw.jpg', 'kyc/1/7g6BW5CMfr0cNK5bJDm3srwAgmdcZtI8hcYckwKy.jpg', 'pending', 'user_submission', NULL, NULL, NULL, '2026-09-29 05:34:58', '2026-09-29 05:34:58'),
(3, 3, '646545345453134', 'kyc/3/iaFVeMsPDk9B4XjtqAqJ1p83NjeLOyGjoQK6xYAk.jpg', 'kyc/3/Fo6s1oqHUkIQjdikF1ZXGWvyuFlXcJPIGdPcCquu.jpg', 'pending', 'user_submission', NULL, NULL, NULL, '2026-09-29 06:16:11', '2026-09-29 06:16:11');

-- --------------------------------------------------------

--
-- Table structure for table `worker_categories`
--

DROP TABLE IF EXISTS `worker_categories`;
CREATE TABLE IF NOT EXISTS `worker_categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `job_seeker_profile_id` bigint UNSIGNED NOT NULL,
  `job_category_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `worker_category_unique` (`job_seeker_profile_id`,`job_category_id`),
  KEY `worker_categories_job_category_id_index` (`job_category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `worker_categories`
--

INSERT INTO `worker_categories` (`id`, `job_seeker_profile_id`, `job_category_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2026-10-01 04:18:43', '2026-10-01 04:18:43'),
(2, 1, 2, '2026-10-01 04:18:43', '2026-10-01 04:18:43'),
(3, 1, 3, '2026-10-01 04:18:43', '2026-10-01 04:18:43'),
(4, 2, 1, '2026-10-18 03:50:27', '2026-10-18 03:50:27');

-- --------------------------------------------------------

--
-- Table structure for table `worker_skills`
--

DROP TABLE IF EXISTS `worker_skills`;
CREATE TABLE IF NOT EXISTS `worker_skills` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `job_seeker_profile_id` bigint UNSIGNED NOT NULL,
  `skill_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `worker_skill_unique` (`job_seeker_profile_id`,`skill_id`),
  KEY `worker_skills_skill_id_index` (`skill_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `worker_skills`
--

INSERT INTO `worker_skills` (`id`, `job_seeker_profile_id`, `skill_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2026-10-01 05:22:35', '2026-10-01 05:22:35'),
(2, 1, 2, '2026-10-01 05:22:35', '2026-10-01 05:22:35'),
(3, 1, 4, '2026-10-01 05:22:35', '2026-10-01 05:22:35'),
(4, 1, 7, '2026-10-01 05:22:35', '2026-10-01 05:22:35'),
(5, 1, 8, '2026-10-01 05:22:35', '2026-10-01 05:22:35'),
(6, 1, 9, '2026-10-01 05:22:35', '2026-10-01 05:22:35'),
(7, 2, 1, '2026-10-18 03:50:27', '2026-10-18 03:50:27'),
(8, 2, 2, '2026-10-18 03:50:27', '2026-10-18 03:50:27');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
