-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2026 at 08:08 PM
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
-- Database: `account_php`
--

-- --------------------------------------------------------

--
-- Table structure for table `document_template_items`
--

CREATE TABLE `document_template_items` (
  `id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 1,
  `title` varchar(255) NOT NULL,
  `operation_type` varchar(50) NOT NULL,
  `hesab_bed` int(11) NOT NULL,
  `hesab_bes` int(11) NOT NULL,
  `sharh` varchar(255) DEFAULT NULL,
  `default_amount` decimal(18,2) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `document_template_items`
--

INSERT INTO `document_template_items` (`id`, `template_id`, `sort_order`, `title`, `operation_type`, `hesab_bed`, `hesab_bes`, `sharh`, `default_amount`, `active`, `created_at`, `updated_at`) VALUES
(1, 5, 10, 'حقوق پایه', 'income', 98, 55, 'حقوق پایه ___ 1405', 450000000.00, 1, '2026-08-14 12:05:35', NULL),
(2, 5, 20, 'حق فنی حقوق', 'income', 56, 98, 'خق فتی حقوق _____ 1405', 350000000.00, 1, '2026-08-14 12:06:18', NULL),
(3, 5, 3, 'قسط 140505', 'loan_payment', 108, 178, 'قسط ____ 1405 وام کارخانه', 35000000.00, 1, '2026-08-14 12:07:09', NULL),
(4, 5, 40, 'اضافه کاری', 'income', 58, 178, 'اضافه کاری ____ 1405', 6500000.00, 1, '2026-08-14 12:07:49', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `document_template_items`
--
ALTER TABLE `document_template_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_template_id` (`template_id`),
  ADD KEY `idx_template_sort` (`template_id`,`sort_order`),
  ADD KEY `idx_template_active` (`template_id`,`active`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `document_template_items`
--
ALTER TABLE `document_template_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `document_template_items`
--
ALTER TABLE `document_template_items`
  ADD CONSTRAINT `fk_document_template_items_template` FOREIGN KEY (`template_id`) REFERENCES `document_templates` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
