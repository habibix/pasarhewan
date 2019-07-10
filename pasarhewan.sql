-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 10, 2019 at 03:16 PM
-- Server version: 5.7.26-0ubuntu0.18.04.1
-- PHP Version: 7.2.19-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pasarhewan`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(10) UNSIGNED NOT NULL,
  `kode` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `kode`, `category`, `created_at`, `updated_at`) VALUES
(1, '1', 'burung', '2019-04-30 17:00:00', '2019-04-30 17:00:00'),
(2, '2', 'ikan', '2019-05-18 17:00:00', '2019-05-18 17:00:00'),
(3, '3', 'kucing', '2019-05-18 17:00:00', '2019-05-18 17:00:00'),
(4, '4', 'ayam', '2019-06-25 17:00:00', '2019-06-25 17:00:00'),
(5, '5', 'kelinci', '2019-06-25 17:00:00', '2019-06-25 17:00:00'),
(6, '6', 'reptil', '2019-06-25 17:00:00', '2019-06-25 17:00:00'),
(7, '7', 'anjing', '2019-06-25 17:00:00', '2019-06-25 17:00:00'),
(8, '8', 'sugar glider', '2019-06-25 17:00:00', '2019-06-25 17:00:00'),
(9, '4', 'ayam', '2019-06-25 17:00:00', '2019-06-25 17:00:00'),
(10, '5', 'kelinci', '2019-06-25 17:00:00', '2019-06-25 17:00:00'),
(11, '6', 'reptil', '2019-06-25 17:00:00', '2019-06-25 17:00:00'),
(12, '7', 'anjing', '2019-06-25 17:00:00', '2019-06-25 17:00:00'),
(13, '8', 'Hewan lainnya', '2019-06-25 17:00:00', '2019-06-25 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `comment_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_status` tinyint(1) NOT NULL DEFAULT '0',
  `comment_type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `image` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`id`, `post_id`, `image`, `created_at`, `updated_at`) VALUES
(2, 9, '2019/06/1_1_1560150634_0.jpg', '2019-06-10 00:10:34', '2019-06-10 00:10:34'),
(3, 9, '2019/06/1_1_1560150634_1.jpg', '2019-06-10 00:10:35', '2019-06-10 00:10:35'),
(4, 9, '2019/06/1_1_1560150635_2.jpg', '2019-06-10 00:10:35', '2019-06-10 00:10:35'),
(5, 10, '2019/06/1_10_1560151582_0.jpg', '2019-06-10 00:26:23', '2019-06-10 00:26:23'),
(6, 10, '2019/06/1_10_1560151583_1.jpg', '2019-06-10 00:26:23', '2019-06-10 00:26:23'),
(7, 10, '2019/06/1_10_1560151583_2.jpg', '2019-06-10 00:26:24', '2019-06-10 00:26:24'),
(16, 16, '2019/06/1_16_1560433885_0.jpg', '2019-06-13 06:51:25', '2019-06-13 06:51:25'),
(17, 16, '2019/06/1_16_1560433885_1.jpg', '2019-06-13 06:51:26', '2019-06-13 06:51:26'),
(18, 16, '2019/06/1_16_1560433886_2.jpg', '2019-06-13 06:51:26', '2019-06-13 06:51:26');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_04_22_124908_create_post', 1),
(4, '2019_04_22_134333_create_comment', 1),
(5, '2019_04_22_134522_create_category', 1),
(6, '2019_04_22_134556_create_image', 1),
(7, '2019_04_23_135319_create_user_detail', 1),
(8, '2019_04_23_135728_create_post_like', 1),
(9, '2019_04_23_141009_create_report_post', 1),
(10, '2019_06_11_074745_create_rating', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `post_content` longtext COLLATE utf8mb4_unicode_ci,
  `post_sell_title` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_price` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'status',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `user_id`, `category_id`, `post_content`, `post_sell_title`, `post_price`, `post_type`, `created_at`, `updated_at`) VALUES
(3, 1, 1, '33333', NULL, '', 'status', '2019-06-07 20:15:11', '2019-06-07 20:15:11'),
(4, 1, 2, '444444', NULL, '', 'status', '2019-06-07 20:15:16', '2019-06-07 20:15:16'),
(9, 1, 1, 'Burung dua', NULL, '', 'status', '2019-06-10 00:10:34', '2019-06-10 00:10:34'),
(10, 1, 1, NULL, NULL, '', 'status', '2019-06-10 00:26:22', '2019-06-10 00:26:22'),
(16, 1, 1, 'Keterangan bro', 'Burung Lovebird Balibu', 'xxxx', 'sell', '2019-06-13 06:51:25', '2019-06-13 06:51:25');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(10) UNSIGNED NOT NULL,
  `seller_user_id` int(10) UNSIGNED NOT NULL,
  `buyer_user_id` int(10) UNSIGNED NOT NULL,
  `detail` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report_post`
--

CREATE TABLE `report_post` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `detail` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_second` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_profile` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `name_second`, `email`, `password`, `image_profile`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Rifqi', 'Habibieeeee', 'habibi.rifqi@gmail.com', '$2y$10$Zy2jCz/q8CXcRU00dWygw.UZLCLDWnrHBqQOPrNozAbzd0k0CXd5W', 'http://127.0.0.1:8000/images/profile/1_profile.png', 'MaNTZXqph7i5nYcT9xUMEC1Uc3HVd5OXi5qYNXGgcHMRovxIjOhp54jeqyba', '2019-05-09 22:59:10', '2019-06-10 02:02:28'),
(3, 'Febby', NULL, 'febby1@mail.com', '$2y$10$UASiQuqWbqnCVc9q916jLuTnpMjhFkonSSgMq4vCWJT0dZFQLv0aa', 'http://127.0.0.1:8000/images/profile/3_1558921594.jpg', '3MgCULJMz4LDAuohvrpsXphcl1BXOjGpEqaitLgoJ3W3NvhClRn6NsEFrMGS', '2019-05-09 23:15:53', '2019-05-26 18:46:34'),
(6, 'mul', '', 'mul@gmail.com', '$2y$10$QfcPLy4KCznIjnQ7kX7szeeOHE81KEJpYcF7f453aQmZb7Zh5J/XG', '', NULL, '2019-05-15 20:32:17', '2019-05-15 20:32:17'),
(7, 'Febby 2', 'oyeh', 'febby2@mail.com', '$2y$10$TSaQpjIe8d2NjYiHkjdBNuatHBbE3eyOyV85kr42qIUWCbA.vkKLy', '', 'YIsdvqzE9S71geAlZleHYXuUz5MW3ZQ8v6ByiPA8y2UmjyTxznzpAEH4lZyE', '2019-05-15 20:38:21', '2019-05-15 20:38:21'),
(8, 'hajar aswad', NULL, 'hajar@gmail.com', '$2y$10$fwykvjIc2ifxOdO1.0Hp2ubgjgcfeZSdTuIphp8eem36fbzsaDvHG', '', 'cuXiwBKiYolsvwOBtUnDlh9D6NeRH7WVXEcm661kmxQl8j9edRSxt6lTglGy', '2019-05-19 05:25:00', '2019-05-19 05:25:00'),
(9, 'jj', 'tomson', 'jjtomson@gmail.com', '$2y$10$NtFiIvhwLUCYAXsJo8r8JujMtSPmTaEIPyA7paXXv6.tpkEyiSsZG', '', 'MqbkT1ja3fsasBEeUK2VGjsKrW7POBFyXwNDvu2nnnNsimwaDPVarhEGNASO', '2019-05-19 05:33:32', '2019-05-19 05:36:43');

-- --------------------------------------------------------

--
-- Table structure for table `user_detail`
--

CREATE TABLE `user_detail` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `gender` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_birth` date DEFAULT NULL,
  `no_hp` varchar(13) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_wa` varchar(13) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provinsi` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kab_kota` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kecamatan` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desa` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_detail`
--

INSERT INTO `user_detail` (`id`, `user_id`, `gender`, `date_birth`, `no_hp`, `no_wa`, `about`, `provinsi`, `kab_kota`, `kecamatan`, `desa`, `created_at`, `updated_at`) VALUES
(1, 3, 'Perempuan', '2019-05-01', '089615441132', '089615441132', 'about', NULL, NULL, NULL, NULL, '2019-05-12 02:21:59', '2019-05-21 21:47:51'),
(2, 1, 'laki-laki', '1992-12-12', '089615441111', '089615441111', 'bio guee dong hahaha', NULL, NULL, NULL, NULL, '2019-05-15 00:43:17', '2019-05-22 01:56:16'),
(3, 6, '', '2019-05-01', '089615441134', '089615441134', 'bio dong', '', '', '', '', '2019-05-15 20:32:17', '2019-05-15 20:32:17'),
(4, 7, NULL, '2019-05-01', '089615441136', '089615441136', 'bio ajah', 'Jawa Barat', 'Cirebon', NULL, NULL, '2019-05-15 20:38:21', '2019-05-15 20:38:21'),
(5, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-05-19 05:25:00', '2019-05-19 05:25:00'),
(6, 9, 'laki-laki', NULL, '089615441155', '089615441155', NULL, NULL, NULL, NULL, NULL, '2019-05-19 05:33:32', '2019-05-19 05:37:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report_post`
--
ALTER TABLE `report_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_detail`
--
ALTER TABLE `user_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `report_post`
--
ALTER TABLE `report_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `user_detail`
--
ALTER TABLE `user_detail`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `image_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_detail`
--
ALTER TABLE `user_detail`
  ADD CONSTRAINT `user_detail_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
