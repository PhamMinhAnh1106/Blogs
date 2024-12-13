-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 13, 2024 at 08:30 AM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `description`) VALUES
(1, 'Food', 'This is food category'),
(2, 'Uncategorized', 'This is uncategorised section'),
(3, 'Gaming', 'this is gaming category'),
(4, 'Movies', 'Movies category'),
(5, 'Science &amp; Technology', 'This is Science &amp; Technology category'),
(6, 'Travel', 'this is travel category'),
(7, 'Music ', 'This is music category');

-- --------------------------------------------------------

--
-- Table structure for table `momopay`
--

DROP TABLE IF EXISTS `momopay`;
CREATE TABLE IF NOT EXISTS `momopay` (
  `id_momo` int NOT NULL AUTO_INCREMENT,
  `partner_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_order` int NOT NULL,
  `amount` varchar(50) NOT NULL,
  `order_info` varchar(100) NOT NULL,
  `order_type` varchar(50) NOT NULL,
  `id_trans` int NOT NULL,
  `pay_type` varchar(50) NOT NULL,
  PRIMARY KEY (`id_momo`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `momopay`
--

INSERT INTO `momopay` (`id_momo`, `partner_code`, `id_order`, `amount`, `order_info`, `order_type`, `id_trans`, `pay_type`) VALUES
(1, 'MOMOBKUN20180529', 1733117497, '100000', 'Thanh toán qua ATM MoMo', 'momo_wallet', 2147483647, 'napas'),
(2, 'MOMOBKUN20180529', 1733117497, '100000', 'Thanh toán qua ATM MoMo', 'momo_wallet', 2147483647, 'napas');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `thumbnail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category_id` int UNSIGNED DEFAULT NULL,
  `author_id` int UNSIGNED NOT NULL,
  `is_featured` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_blog_category` (`category_id`),
  KEY `FK_blog_author` (`author_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `full_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `full_name`, `username`, `email`, `password`, `avatar`, `is_admin`) VALUES
(1, 'Nguyen', 'Van Huy', '', 'vanhuy2706', 'vanhuy27062003@gmail.com', '$2y$10$Gex0yTRst75DGArv88pIDuacjN2jII.GCRFt0W3G6wrHN4bl8i1pS', '1734078435VH.jpg', 1),
(2, 'Pham', 'Minh Anh', '', 'MinhAnh1106', 'phamminhanh11623@gmail.com', '$2y$10$hEg0oGrPhNGjEk/Qx9h5yO4.qLyGxn5qShl/q8dQTpFK.WH5uhdQa', '1734078537MinhAnhimg.jpg', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `FK_blog_author` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_blog_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
