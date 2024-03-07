-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2023 at 05:55 PM
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
-- Database: `blackash`
--

-- --------------------------------------------------------

--
-- Table structure for table `age_groups`
--

CREATE TABLE `age_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `age_groups`
--

INSERT INTO `age_groups` (`id`, `title`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '11-20', '2023-12-11 16:35:39', '2023-12-11 20:09:35', NULL),
(2, 'Dsjh Ds 2', '2023-12-11 18:43:57', '2023-12-11 20:08:55', '2023-12-11 20:08:55'),
(3, 'Heresd', '2023-12-11 18:47:14', '2023-12-11 20:09:12', '2023-12-11 20:09:12'),
(4, 'Bliub,k', '2023-12-11 19:05:37', '2023-12-11 20:08:52', '2023-12-11 20:08:52'),
(5, 'Hello World', '2023-12-11 19:09:56', '2023-12-11 20:09:16', '2023-12-11 20:09:16'),
(6, 'My World', '2023-12-11 19:10:08', '2023-12-11 20:09:02', '2023-12-11 20:09:02'),
(7, 'Still', '2023-12-11 19:11:09', '2023-12-11 20:08:59', '2023-12-11 20:08:59'),
(8, '21-30', '2023-12-11 19:25:55', '2023-12-11 20:09:28', NULL),
(9, 'Amin', '2023-12-11 19:47:09', '2023-12-11 20:08:49', '2023-12-11 20:08:49'),
(10, 'Mandem', '2023-12-11 20:08:00', '2023-12-11 20:09:05', '2023-12-11 20:09:05'),
(11, '1-10', '2023-12-11 20:09:50', '2023-12-11 20:09:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `title`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Branch 01', '2023-12-11 20:40:06', '2023-12-11 20:40:06', NULL),
(2, 'Branch 02', '2023-12-11 20:40:18', '2023-12-11 20:40:26', NULL),
(3, 'Brancvnlksdkd98', '2023-12-11 20:41:37', '2023-12-11 20:41:42', '2023-12-11 20:41:42');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `title`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Product 12', '2023-12-11 17:35:16', '2023-12-11 17:35:33', '2023-12-11 17:35:33'),
(2, 'Product 3', '2023-12-11 17:36:54', '2023-12-11 17:38:17', NULL),
(3, 'Product 4', '2023-12-11 17:37:21', '2023-12-11 17:40:06', NULL),
(4, 'Product 2', '2023-12-11 17:38:05', '2023-12-11 17:38:05', NULL),
(5, 'Product 1', '2023-12-11 17:42:00', '2023-12-11 17:42:00', NULL),
(6, 'Product 7', '2023-12-11 17:42:07', '2023-12-11 20:17:13', NULL),
(7, 'Product 5', '2023-12-11 17:49:35', '2023-12-11 17:50:01', NULL),
(8, 'Product 6', '2023-12-11 17:52:08', '2023-12-11 17:52:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `records`
--

CREATE TABLE `records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `age_group_id` int(11) NOT NULL,
  `product_category_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `remarks` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `records`
--

INSERT INTO `records` (`id`, `name`, `phone`, `location`, `age_group_id`, `product_category_id`, `branch_id`, `remarks`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Owusu Ansah Gerald', '0558114120', 'Madina', 8, 4, 1, 'Good', 1, '2023-12-11 22:13:33', '2023-12-12 07:09:41', NULL),
(2, 'Owusu James', '0558114121', 'Adenta', 8, 2, 2, 'Better', 1, '2023-12-12 07:12:48', '2023-12-12 07:12:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `is_admin`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Administrator', 'admin', 'admin@hms.com', '$2y$12$DT8neNdTYvIEZGzvyn8rE.OmmIzY.HIBA9wkP/H5eiBPACpEa590S', 1, '2023-12-10 21:00:18', NULL, '2023-12-10 21:00:18', '2023-12-12 08:50:09', NULL),
(3, 'User', 'user', 'user@hms.com', '$2y$12$DT8neNdTYvIEZGzvyn8rE.OmmIzY.HIBA9wkP/H5eiBPACpEa590S', 0, '2023-12-12 16:52:12', NULL, '2023-12-12 07:54:17', '2023-12-12 08:24:32', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `age_groups`
--
ALTER TABLE `age_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

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
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `records`
--
ALTER TABLE `records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `age_groups`
--
ALTER TABLE `age_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `records`
--
ALTER TABLE `records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
