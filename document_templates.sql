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
-- Table structure for table `document_templates`
--

CREATE TABLE `document_templates` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `operation_type` varchar(50) NOT NULL,
  `hesab_bed` int(11) DEFAULT NULL,
  `hesab_bes` int(11) DEFAULT NULL,
  `sharh` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `document_templates`
--

INSERT INTO `document_templates` (`id`, `name`, `operation_type`, `hesab_bed`, `hesab_bes`, `sharh`, `active`, `created_at`, `updated_at`) VALUES
(1, 'کرایه اسنپ رفاه', 'cost', 54, 178, 'شارژ اسنپ', 1, '2026-08-14 06:51:31', '2026-08-14 06:51:31'),
(2, 'لقلقلق', 'cost', 65, 75, 'لبلثقل', 1, '2026-08-14 07:50:55', '2026-08-14 07:50:55'),
(3, 'درآمدی', 'income', 75, 56, 'حق فنی', 1, '2026-08-14 10:04:58', '2026-08-14 10:04:58'),
(4, 'sddgdgd', 'transfer', 75, 6, 'cbcb', 1, '2026-08-14 10:08:27', '2026-08-14 10:08:27'),
(5, 'حقوق ماهیانه', 'income', 98, 58, 'حقوق ماه ___', 1, '2026-08-14 12:03:09', '2026-08-14 12:03:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `document_templates`
--
ALTER TABLE `document_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_operation_type` (`operation_type`),
  ADD KEY `idx_active` (`active`),
  ADD KEY `idx_hesab_bed` (`hesab_bed`),
  ADD KEY `idx_hesab_bes` (`hesab_bes`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `document_templates`
--
ALTER TABLE `document_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `document_templates`
--
ALTER TABLE `document_templates`
  ADD CONSTRAINT `document_templates_fk_bed` FOREIGN KEY (`hesab_bed`) REFERENCES `hesabha` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `document_templates_fk_bes` FOREIGN KEY (`hesab_bes`) REFERENCES `hesabha` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
