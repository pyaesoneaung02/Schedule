-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Jul 18, 2026 at 06:25 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `days`
--

CREATE TABLE `days` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `days`
--

INSERT INTO `days` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Monday', '2026-07-16 02:23:14', '2026-07-16 02:23:14'),
(2, 'Tuesday', '2026-07-16 10:31:50', '2026-07-16 10:31:50'),
(3, 'Wednesday', '2026-07-16 10:32:01', '2026-07-16 10:32:01'),
(4, 'Thursday', '2026-07-16 10:32:09', '2026-07-16 10:32:09'),
(5, 'Friday', '2026-07-16 10:32:19', '2026-07-16 10:32:19');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Computer Science', '2026-07-16 10:42:07', '2026-07-16 10:42:07'),
(2, 'Information Science', '2026-07-16 10:42:15', '2026-07-16 10:42:15'),
(3, 'Computer Technology', '2026-07-16 10:42:40', '2026-07-16 10:42:40'),
(4, 'Information Technology Supporting & Maintenance', '2026-07-16 10:47:22', '2026-07-16 10:47:22'),
(5, 'Computing', '2026-07-16 10:47:34', '2026-07-16 10:47:34'),
(6, 'Natural Science', '2026-07-16 10:48:00', '2026-07-16 10:48:00'),
(7, 'Language', '2026-07-16 10:48:16', '2026-07-16 10:48:16');

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
-- Table structure for table `majors`
--

CREATE TABLE `majors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `year_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `majors`
--

INSERT INTO `majors` (`id`, `name`, `year_id`, `created_at`, `updated_at`) VALUES
(1, 'Computer Science & Computer Technology', 1, '2026-07-16 10:33:28', '2026-07-16 10:33:28'),
(2, 'Computer Science', 2, '2026-07-16 10:33:45', '2026-07-16 10:33:45'),
(3, 'Computer Technology', 2, '2026-07-16 10:34:07', '2026-07-16 10:34:07'),
(4, 'Computer Science', 3, '2026-07-16 10:34:18', '2026-07-16 10:34:18'),
(5, 'Computer Technology', 3, '2026-07-16 10:34:28', '2026-07-16 10:34:28'),
(6, 'Computer Science', 4, '2026-07-16 10:34:38', '2026-07-16 10:34:38'),
(7, 'Computer Technology', 4, '2026-07-16 10:34:51', '2026-07-16 10:35:39'),
(8, 'Computer Science', 5, '2026-07-16 10:35:00', '2026-07-16 10:35:59'),
(9, 'Computer Technology', 5, '2026-07-16 10:36:12', '2026-07-16 10:36:12');

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
(4, '2026_06_22_154501_create_years_table', 1),
(5, '2026_06_27_145125_create_majors_table', 1),
(6, '2026_06_27_153247_create_rooms_table', 1),
(7, '2026_06_27_154323_create_departments_table', 1),
(8, '2026_06_27_154402_create_positions_table', 1),
(9, '2026_06_27_154443_create_teachers_table', 1),
(10, '2026_06_27_154841_create_subjects_table', 1),
(11, '2026_06_27_155305_create_times_table', 1),
(12, '2026_06_28_155341_create_teachings_table', 1),
(13, '2026_07_02_100221_create_days_table', 1),
(14, '2026_07_02_100242_create_schedules_table', 1);

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
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Professor', '2026-07-16 10:48:49', '2026-07-16 10:48:49'),
(2, 'Assistant - Professor', '2026-07-16 10:49:08', '2026-07-16 10:49:08'),
(3, 'Lecturer', '2026-07-16 10:49:17', '2026-07-16 10:49:17'),
(4, 'Assistant -  Lecturer', '2026-07-16 10:49:37', '2026-07-16 10:49:37'),
(5, 'Tutor', '2026-07-16 10:49:49', '2026-07-16 10:49:49');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `year_id` int(11) NOT NULL,
  `major_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `year_id`, `major_id`, `created_at`, `updated_at`) VALUES
(1, 'Section A', 1, 1, '2026-07-16 10:41:08', '2026-07-16 11:10:34'),
(2, 'Section B', 1, 1, '2026-07-16 11:10:56', '2026-07-16 11:10:56'),
(3, 'Section C', 1, 1, '2026-07-16 11:11:16', '2026-07-16 11:11:16'),
(4, 'Section D', 1, 1, '2026-07-16 11:11:31', '2026-07-16 11:11:31'),
(5, 'Section A', 2, 4, '2026-07-16 11:11:52', '2026-07-16 11:11:52'),
(6, 'Section B', 2, 2, '2026-07-16 11:12:20', '2026-07-16 11:12:20'),
(7, 'Section A', 2, 5, '2026-07-16 11:12:36', '2026-07-16 11:12:36'),
(8, 'Section A', 3, 2, '2026-07-16 11:13:01', '2026-07-16 11:13:01'),
(9, 'Section B', 3, 8, '2026-07-16 11:13:18', '2026-07-16 11:13:18'),
(10, 'Section A', 3, 3, '2026-07-16 11:13:34', '2026-07-16 11:13:34'),
(11, 'Section A', 4, 4, '2026-07-16 11:13:48', '2026-07-16 11:13:48'),
(12, 'Section B', 4, 4, '2026-07-16 11:14:00', '2026-07-16 11:14:00'),
(13, 'Section A', 4, 3, '2026-07-16 11:14:16', '2026-07-16 11:14:16'),
(14, 'Section A', 5, 8, '2026-07-16 11:15:10', '2026-07-16 11:15:10'),
(15, 'Section A', 5, 3, '2026-07-16 11:15:33', '2026-07-16 11:15:33');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `year_id` bigint(20) UNSIGNED NOT NULL,
  `major_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `day_id` bigint(20) UNSIGNED NOT NULL,
  `time_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `year_id`, `major_id`, `room_id`, `teacher_id`, `subject_id`, `day_id`, `time_id`, `created_at`, `updated_at`) VALUES
(2, 4, 6, 11, 4, 3, 1, 9, '2026-07-16 23:53:09', '2026-07-16 23:53:09'),
(3, 4, 6, 11, 1, 5, 1, 13, '2026-07-16 23:53:46', '2026-07-16 23:53:46'),
(4, 4, 6, 11, 6, 1, 1, 15, '2026-07-16 23:56:12', '2026-07-16 23:56:12'),
(5, 4, 6, 11, 14, 6, 1, 16, '2026-07-16 23:58:14', '2026-07-16 23:58:14');

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
('06czbuHrkmhenIlU4gXk2FUGn0SXTbZli3Eadhxe', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiTGdJcjhPRjlyUUpjZWNzRjd3aVROVFpGaGI0WXhZdUVEalczdGtZeiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9zY2hlZHVsZS9jcmVhdGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6NToiYWxlcnQiO2E6MDp7fX0=', 1784270635),
('0ofw7vGdUwEzFcyn09DEsb6DZGuyGtXzMwXZnK3T', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiWnR0M1J6NUdoeFhubGQyUnM3cDNSejdyeU1BeW9xWDB0RGpCRTcwViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo1OiJhbGVydCI7YTowOnt9fQ==', 1784269049),
('5moVnd7H7GFfIDBCtEtedWRaIzhYbWcTojCkGeVD', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieVpQVXRmQ0wyZjFxMG5MSGkyU3Z4aXFJaXdlWUcyNzlLV2IzOFl6biI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1784263819),
('hwGVISMVb9NjOJTcIgGTLm9cxWt6BJJQJkrITMkH', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTmx2VkV6blk1TGcybUp4eVlkdWRMRTdNdzdxN0kwZVRVa3I3a2JXZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9yb29tL2NyZWF0ZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1784348593),
('wkK5SRkGvRS5uisDJxN7QDoXNAKeVI6E1RkTOSQ2', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZVpaeHU0UjlFc1FISklkaGhpYVhNS2VVYTl1QmRLTEdVYjREdUlIQyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1784263818),
('xVO5Eh4IDYT7P740yJdrqYk6qb6RZMVgDZvKfLVP', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ3RjWkdLOEJidGV2NHVydmRXenNNRU9JZE9JcG12ZEdocmhzTmduRSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1784348493);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `long_name` varchar(255) NOT NULL,
  `short_name` varchar(255) NOT NULL,
  `year_id` int(11) NOT NULL,
  `major_id` int(11) NOT NULL,
  `time_number` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `long_name`, `short_name`, `year_id`, `major_id`, `time_number`, `created_at`, `updated_at`) VALUES
(1, 'Parallel and Distributed Computing', 'CST-4211', 4, 1, '6', '2026-07-16 11:23:09', '2026-07-16 23:54:59'),
(2, 'Modeling & Simulation', 'CST-4242', 4, 1, '6', '2026-07-16 11:24:55', '2026-07-16 11:24:55'),
(3, 'Object Oriented  Design & Development', 'CS-4223', 4, 6, '6', '2026-07-16 11:27:31', '2026-07-16 11:27:31'),
(4, 'Advanced AI', 'CS-4214', 4, 6, '6', '2026-07-16 11:29:02', '2026-07-16 11:29:02'),
(5, 'Advanced Database System', 'CS-4225', 4, 6, '6', '2026-07-16 11:30:43', '2026-07-16 11:30:43'),
(6, 'Digital Business & e-commerce Management', 'CST-4257', 4, 1, '6', '2026-07-16 11:32:00', '2026-07-16 11:32:00'),
(7, 'Cryptography & Network Secutirt', 'CT-4223', 4, 7, '6', '2026-07-16 22:25:46', '2026-07-16 22:25:46'),
(8, 'Embedded systems Integration IoT', 'CT-4234', 4, 7, '6', '2026-07-16 22:26:26', '2026-07-16 22:26:26'),
(9, 'Cyber Security & Ethical Hacking', 'CT-4236', 4, 7, '6', '2026-07-16 22:27:37', '2026-07-16 22:27:37');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `position_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `position_id`, `department_id`, `created_at`, `updated_at`) VALUES
(1, 'Dr Amy Aung', 1, 2, '2026-07-16 10:50:21', '2026-07-16 10:50:21'),
(2, 'Dr Zin Mar Myo', 1, 1, '2026-07-16 10:51:19', '2026-07-16 10:51:19'),
(3, 'Daw Sandar Pa Pa  Thein', 3, 5, '2026-07-16 10:51:51', '2026-07-16 10:51:51'),
(4, 'Daw Thet Su Hlaing', 3, 2, '2026-07-16 10:52:24', '2026-07-16 10:52:24'),
(5, 'Daw Chery Phyo Wai', 5, 1, '2026-07-16 10:53:21', '2026-07-16 10:53:21'),
(6, 'Daw Win Chery Ko', 3, 1, '2026-07-16 10:53:55', '2026-07-16 10:53:55'),
(7, 'Daw Nilar Mya Win', 3, 5, '2026-07-16 10:54:57', '2026-07-16 10:54:57'),
(8, 'Daw Aye Aye Maw', 3, 3, '2026-07-16 10:55:31', '2026-07-16 10:55:52'),
(9, 'Dr Moe Thuzar Htway', 1, 3, '2026-07-16 10:56:25', '2026-07-16 10:56:25'),
(10, 'U Win Htun', 3, 3, '2026-07-16 10:56:57', '2026-07-16 10:56:57'),
(11, 'Dr.Hla Hla Myint', 1, 4, '2026-07-16 10:57:32', '2026-07-16 10:57:32'),
(12, 'Daw Ei Ei Khaing', 3, 5, '2026-07-16 10:59:02', '2026-07-16 10:59:02'),
(13, 'Daw Nilar Phyo Wai', 3, 1, '2026-07-16 10:59:33', '2026-07-16 10:59:33'),
(14, 'Daw Aye Aye Bo', 3, 4, '2026-07-16 11:00:09', '2026-07-16 11:00:09');

-- --------------------------------------------------------

--
-- Table structure for table `teachings`
--

CREATE TABLE `teachings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `year_id` int(11) NOT NULL,
  `major_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachings`
--

INSERT INTO `teachings` (`id`, `name`, `year_id`, `major_id`, `room_id`, `subject_id`, `created_at`, `updated_at`) VALUES
(1, 'Daw Win Chery Ko', 4, 1, 11, 1, '2026-07-16 22:29:02', '2026-07-16 22:29:02'),
(2, 'Daw Ei Ei Khaing', 4, 8, 11, 2, '2026-07-16 22:29:35', '2026-07-16 22:38:17'),
(3, 'Daw Thet Su Hlaing', 4, 6, 11, 3, '2026-07-16 22:30:10', '2026-07-16 22:30:10'),
(4, 'Daw Nilar Phyo Wai', 4, 6, 11, 4, '2026-07-16 22:30:52', '2026-07-16 22:30:52'),
(5, 'Dr Amy Aung', 4, 6, 11, 5, '2026-07-16 22:31:23', '2026-07-16 22:31:23'),
(6, 'Daw Aye Aye Bo', 4, 2, 11, 6, '2026-07-16 22:31:52', '2026-07-16 22:38:48'),
(7, 'Dr Zin Mar Myo', 4, 6, 12, 1, '2026-07-16 22:33:42', '2026-07-16 22:39:07'),
(8, 'Daw Sandar Pa Pa  Thein', 4, 6, 12, 2, '2026-07-16 22:34:12', '2026-07-16 22:39:25'),
(9, 'Daw Thet Su Hlaing', 4, 2, 12, 3, '2026-07-16 22:34:35', '2026-07-16 22:34:35'),
(10, 'Daw Chery Phyo Wai', 4, 8, 12, 4, '2026-07-16 22:35:11', '2026-07-16 22:35:11'),
(11, 'Dr Amy Aung', 4, 6, 12, 5, '2026-07-16 22:36:03', '2026-07-16 22:36:03'),
(12, 'Daw Aye Aye Bo', 4, 6, 12, 6, '2026-07-16 22:36:46', '2026-07-16 22:38:31'),
(13, 'Daw Win Chery Ko', 4, 7, 13, 1, '2026-07-16 22:38:00', '2026-07-16 22:38:00'),
(14, 'Daw Nilar Mya Win', 4, 7, 13, 2, '2026-07-16 22:40:11', '2026-07-16 22:40:11'),
(15, 'Daw Aye Aye Maw', 4, 7, 13, 7, '2026-07-16 22:40:39', '2026-07-16 22:40:39'),
(16, 'Dr Moe Thuzar Htway', 4, 7, 13, 8, '2026-07-16 22:41:19', '2026-07-16 22:41:19'),
(17, 'U Win Htun', 4, 7, 13, 9, '2026-07-16 22:41:55', '2026-07-16 22:41:55'),
(18, 'Dr.Hla Hla Myint', 4, 7, 13, 6, '2026-07-16 22:42:28', '2026-07-16 22:42:28');

-- --------------------------------------------------------

--
-- Table structure for table `times`
--

CREATE TABLE `times` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `times`
--

INSERT INTO `times` (`id`, `name`, `created_at`, `updated_at`) VALUES
(9, '09 : 00 -10 : 30', '2026-07-16 23:48:52', '2026-07-16 23:48:52'),
(13, '10:30 - 12:00', '2026-07-16 23:50:00', '2026-07-16 23:50:00'),
(14, '12:00 - 01:00', '2026-07-16 23:50:19', '2026-07-16 23:50:19'),
(15, '01:00 - 02:30', '2026-07-16 23:50:49', '2026-07-16 23:51:35'),
(16, '02:30 - 04:00', '2026-07-16 23:51:17', '2026-07-16 23:51:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `profile` text DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `provider` varchar(255) DEFAULT NULL,
  `provider_id` varchar(255) DEFAULT NULL,
  `provider_token` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `nickname`, `email`, `email_verified_at`, `password`, `phone`, `address`, `profile`, `role`, `provider`, `provider_id`, `provider_token`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin Account', NULL, 'superadmin@gmail.com', NULL, '$2y$12$M5w0mQUAQIdMXijFubEl4OsTfT95tVrcwR1E/iTJsTzdzN5AUBkgy', NULL, NULL, NULL, 'superadmin', NULL, NULL, NULL, NULL, '2026-07-13 10:19:49', '2026-07-13 10:19:49'),
(2, 'Student Portal', NULL, 'student@gmail.com', NULL, '$2y$12$YzIAg8ySYdUVLwRNPI3Vo.CP5Vnv0y8yw5perRc81H4OBILfT56g6', NULL, NULL, NULL, 'user', NULL, NULL, NULL, NULL, '2026-07-13 10:19:49', '2026-07-13 10:19:49'),
(3, 'Dr Amy Aung', NULL, 'amiaung23@gmail.com', NULL, '$2y$12$E.XwxfckO01flVNK3JOKGeX4R.OsI1ArjdX3NTh4gXg.L.FFa/QJC', NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, '2026-07-16 02:22:52', '2026-07-16 02:22:52'),
(4, 'Han Hsu Yee', NULL, 'hsuyeehan923@gmail.com', NULL, '$2y$12$Ltx4A/7dVaYn.AsZVaYmvOnmXfprG7M6vLfwGkINri8MEyi7ol/b.', '097226656783', NULL, NULL, 'user', NULL, NULL, NULL, NULL, '2026-07-16 09:16:49', '2026-07-16 09:16:49');

-- --------------------------------------------------------

--
-- Table structure for table `years`
--

CREATE TABLE `years` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `years`
--

INSERT INTO `years` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'First Year', '2026-07-16 10:32:33', '2026-07-16 10:32:33'),
(2, 'Second Year', '2026-07-16 10:32:44', '2026-07-16 10:32:44'),
(3, 'Third Year', '2026-07-16 10:32:51', '2026-07-16 10:32:51'),
(4, 'Fourth Year', '2026-07-16 10:32:58', '2026-07-16 10:32:58'),
(5, 'Fifth Year', '2026-07-16 10:33:08', '2026-07-16 10:33:08');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `days`
--
ALTER TABLE `days`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `majors`
--
ALTER TABLE `majors`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachings`
--
ALTER TABLE `teachings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `times`
--
ALTER TABLE `times`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `years`
--
ALTER TABLE `years`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `days`
--
ALTER TABLE `days`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `majors`
--
ALTER TABLE `majors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `teachings`
--
ALTER TABLE `teachings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `times`
--
ALTER TABLE `times`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `years`
--
ALTER TABLE `years`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
