-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2026 at 05:15 PM
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
-- Database: `taskmaster`
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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL DEFAULT '#6366f1',
  `icon` varchar(255) NOT NULL DEFAULT '?',
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `color`, `icon`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Pemrograman', '#6366f1', '💻', NULL, '2026-05-24 12:53:59', '2026-05-24 12:53:59'),
(2, 'Matematika', '#f59e0b', '📐', NULL, '2026-05-24 12:53:59', '2026-05-24 12:53:59'),
(3, 'Bahasa Inggris', '#10b981', '🌐', NULL, '2026-05-24 12:53:59', '2026-05-24 12:53:59'),
(4, 'Jaringan', '#3b82f6', '🔌', NULL, '2026-05-24 12:53:59', '2026-05-24 12:53:59'),
(5, 'Database', '#ef4444', '🗄️', NULL, '2026-05-24 12:53:59', '2026-05-24 12:53:59'),
(6, 'Proyek', '#8b5cf6', '🚀', NULL, '2026-05-24 12:53:59', '2026-05-24 12:53:59');

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
(4, '2024_01_01_000001_create_categories_table', 1),
(5, '2024_01_01_000002_create_tasks_table', 1),
(6, '2024_01_01_000003_create_task_comments_table', 1),
(7, '2026_05_24_182651_add_fields_to_users_table', 1);

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
('JfMPjlTAKI2A2VqQbqk6dk5qGqaoYW1t0zIyMgJz', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTWpDRlMwQTRYS3hDQ05kYmF6VlAyYWhwNDdUSlFmTE8zUmUyNDJyQyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90YXNrcz9zdGF0dXM9ZG9uZSI7czo1OiJyb3V0ZSI7czoxMToidGFza3MuaW5kZXgiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O30=', 1780549894),
('Vs0ph3OfCyJMlslDX5jfJ6FONoODPMGw0te5C39h', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.0 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY3RiVkFwYmJvUzlRczVadFRKU3BXVFZDVEgzdFZOTHZrS0ttbXRydyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1780549549);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `priority` enum('low','medium','high','urgent') NOT NULL DEFAULT 'medium',
  `status` enum('todo','in_progress','done','cancelled') NOT NULL DEFAULT 'todo',
  `due_date` date DEFAULT NULL,
  `due_time` time DEFAULT NULL,
  `mata_kuliah` varchar(255) DEFAULT NULL COMMENT 'Nama mata kuliah/pelajaran',
  `dosen` varchar(255) DEFAULT NULL COMMENT 'Nama dosen/guru',
  `progress` int(11) NOT NULL DEFAULT 0 COMMENT '0-100 percent',
  `is_pinned` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `category_id`, `title`, `description`, `priority`, `status`, `due_date`, `due_time`, `mata_kuliah`, `dosen`, `progress`, `is_pinned`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'Tugas Laravel CRUD', 'Membuat aplikasi manajemen tugas menggunakan Laravel dengan fitur CRUD lengkap.', 'urgent', 'in_progress', '2026-05-27', NULL, 'Pemrograman Web', 'Dr. Ahmad Fauzi', 60, 1, '2026-05-24 12:53:59', '2026-05-24 12:53:59'),
(2, 2, 2, 'UTS Kalkulus', 'Persiapan ujian tengah semester mata kuliah kalkulus lanjut.', 'high', 'todo', '2026-05-31', NULL, 'Kalkulus Lanjut', 'Prof. Budi Hartono', 0, 0, '2026-05-24 12:53:59', '2026-05-24 12:53:59'),
(3, 2, 3, 'Presentasi TOEFL', 'Presentasi preparation TOEFL untuk kelas Bahasa Inggris.', 'medium', 'done', '2026-05-22', NULL, 'Bahasa Inggris', 'Mrs. Sarah Johnson', 100, 0, '2026-05-24 12:53:59', '2026-05-24 12:53:59'),
(4, 2, 4, 'Laporan Jaringan Komputer', 'Laporan praktikum konfigurasi VLAN dan routing.', 'medium', 'in_progress', '2026-05-29', NULL, 'Jaringan Komputer', 'Dr. Wahyu Pratama', 40, 0, '2026-05-24 12:53:59', '2026-05-24 12:53:59'),
(5, 2, 5, 'ERD dan Implementasi Database', 'Membuat ERD dan mengimplementasikan database untuk studi kasus toko online.', 'high', 'todo', '2026-06-03', NULL, 'Basis Data', 'Ir. Dewi Kurnia', 10, 0, '2026-05-24 12:53:59', '2026-05-24 12:53:59'),
(6, 3, 6, 'Analisis Sistem Informasi', 'Membuat dokumen analisis kebutuhan sistem untuk proyek akhir.', 'urgent', 'in_progress', '2026-05-26', NULL, 'Analisis Sistem', 'Dr. Indra Kusuma', 75, 1, '2026-05-24 12:53:59', '2026-05-24 12:53:59'),
(7, 6, 6, 'Tugas', 'Buat tugas yang dikasi di slide di dabel folio', 'medium', 'in_progress', '2026-10-06', '11:59:00', 'Etika Teknologi Informasi', 'Pak Afdhal', 30, 0, '2026-06-03 09:45:45', '2026-06-03 09:45:45'),
(8, 4, 6, 'Project Prak PBW', 'Laravel', 'high', 'done', '2026-05-06', '11:59:00', 'Praktikum PBW', 'Aslab', 100, 0, '2026-06-03 22:08:11', '2026-06-03 22:08:11');

-- --------------------------------------------------------

--
-- Table structure for table `task_comments`
--

CREATE TABLE `task_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `role` enum('admin','student') NOT NULL DEFAULT 'student',
  `nim` varchar(255) DEFAULT NULL,
  `jurusan` varchar(255) DEFAULT NULL,
  `semester` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `nim`, `jurusan`, `semester`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@taskmaster.com', NULL, '$2y$12$xEVMljfySFKapS/oIxvtm.QTTGQuzd0ny0e6dbXc4SotcYAbcVRHa', 'admin', NULL, NULL, NULL, NULL, '2026-05-24 12:53:59', '2026-05-24 12:53:59'),
(2, 'Budi Santoso', 'budi@student.com', NULL, '$2y$12$iPnJF.mBoSVtdpAJhD.NyOHgbM1/nKRETyqJmaZtOfJCoB.l6TBLS', 'student', '2021001', 'Teknik Informatika', '6', NULL, '2026-05-24 12:53:59', '2026-05-24 12:53:59'),
(3, 'Siti Rahayu', 'siti@student.com', NULL, '$2y$12$3YQWU4U6iQlLHGScBcVgyuy22UbT57lV6LaSBVOUB8wB7KJ3XTbHq', 'student', '2021002', 'Sistem Informasi', '4', NULL, '2026-05-24 12:53:59', '2026-05-24 12:53:59'),
(4, 'Khalisha Ufairah', 'khalisha@gmail.com', NULL, '$2y$12$k80MB3kdwYC/UnQCLOf6e.jOrwr5D0hQmh//HDepC4troC/p1E0ou', 'student', '2408107010084', 'informatika', '4', NULL, '2026-06-03 03:32:51', '2026-06-03 03:32:51'),
(5, 'Arsha Alifa', 'arshaalifa@gmail.com', NULL, '$2y$12$X8XojVV.eoDbnpVvEFGP1.7ehGZR3e1ct3CGTwgYpvlHgjrUFpUJK', 'student', '2408107010095', 'Informatika', '3', NULL, '2026-06-03 09:39:14', '2026-06-03 09:39:14'),
(6, 'Andrea Widi', 'andrea@gmail.com', NULL, '$2y$12$hs6Zt7svUrrH.qnaQQNRb.CSh1HmC1/OsQCApFRia07T8JN8N2yvq', 'student', '2408107010083', 'Informatika', '3', NULL, '2026-06-03 09:42:36', '2026-06-03 09:42:36');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_user_id_foreign` (`user_id`),
  ADD KEY `tasks_category_id_foreign` (`category_id`);

--
-- Indexes for table `task_comments`
--
ALTER TABLE `task_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_comments_task_id_foreign` (`task_id`),
  ADD KEY `task_comments_user_id_foreign` (`user_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `task_comments`
--
ALTER TABLE `task_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tasks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `task_comments`
--
ALTER TABLE `task_comments`
  ADD CONSTRAINT `task_comments_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
