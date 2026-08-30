-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2026 at 08:07 PM
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
-- Table structure for table `vams`
--

CREATE TABLE `vams` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'شناسه یکتا وام',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `hesab_id` int(10) UNSIGNED NOT NULL COMMENT 'شناسه حساب وام در جدول hesabha',
  `title` varchar(255) NOT NULL COMMENT 'عنوان وام',
  `loan_amount` varchar(255) NOT NULL DEFAULT '0' COMMENT 'مبلغ اصل وام',
  `received_date` int(11) NOT NULL COMMENT 'تاریخ دریافت وام به فرمت جلالی YYYYMMDD',
  `term_count` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'تعداد کل اقساط',
  `installment_amount` varchar(255) NOT NULL DEFAULT '0' COMMENT 'مبلغ معمول هر قسط',
  `interest_amount` varchar(255) NOT NULL DEFAULT '0' COMMENT 'مجموع سود وام',
  `total_payable` varchar(255) NOT NULL DEFAULT '0' COMMENT 'مجموع مبلغ قابل پرداخت',
  `first_due_date` int(11) NOT NULL COMMENT 'تاریخ سررسید اولین قسط به فرمت جلالی YYYYMMDD',
  `due_day` tinyint(3) UNSIGNED DEFAULT NULL COMMENT 'روز معمول سررسید ماهانه',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT 'وضعیت وام: 1 فعال، 0 تسویه شده',
  `description` text DEFAULT NULL COMMENT 'توضیحات وام',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'تاریخ ایجاد رکورد',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'تاریخ آخرین ویرایش رکورد'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='اطلاعات اصلی وام‌ها';

--
-- Dumping data for table `vams`
--

INSERT INTO `vams` (`id`, `sort_order`, `hesab_id`, `title`, `loan_amount`, `received_date`, `term_count`, `installment_amount`, `interest_amount`, `total_payable`, `first_due_date`, `due_day`, `status`, `description`, `created_at`, `updated_at`) VALUES
(1, 30, 112, 'وام 60 مسکن', '800000000', 14000818, 60, '20112000', '406720000', '1206720000', 14000918, 18, 1, 'وام 60 ماهه مسکن', '2026-08-28 10:22:10', '2026-08-30 17:03:23'),
(2, 10, 97, 'وام ازدواج رفاه همسر', '1400000000', 14000622, 120, '13168000', '0', '0', 14000722, 22, 1, 'وام ازدواج 120 ماهه بانک رفاه همسر ', '2026-08-28 11:55:42', '2026-08-30 16:58:00'),
(3, 40, 110, 'وام 144 مسکن', '1600000000', 14000818, 144, '26676000', '0', '0', 14000918, 18, 1, 'وام 144 ماهه مسکن با سود 18 درصد.', '2026-08-28 12:14:23', '2026-08-30 17:03:30'),
(4, 20, 122, 'وام فرزندآوری احسان', '450000000', 14011206, 55, '12000000', '0', '660000000', 14020106, 7, 1, 'وام فرزندآوری احسان - 55 ماهه - مبلغ هر قسط 12000000 ریال ', '2026-08-28 12:30:05', '2026-08-30 16:58:05'),
(5, 50, 125, 'وام گل خطمی بانک ملت', '710000000', 14010929, 120, '10909000', '0', '0', 14011127, 27, 1, 'وام 120 ماهه بانک ملت گل خطمی', '2026-08-28 12:45:42', '2026-08-30 17:04:18'),
(6, 60, 126, 'وام ازدواج مهدی صانعی', '340000000', 14011004, 120, '4545000', '205400000', '545400000', 14011126, 26, 1, 'وام ازدواج 120 ماهه مهدی صانعی', '2026-08-28 12:57:49', '2026-08-30 17:03:50'),
(7, 70, 127, 'وام ازدواج فیروزآبادی', '340000000', 14011014, 120, '4545000', '0', '545400000', 14011104, 4, 1, 'وام ازدواج 120 ماهه فیروزآبادی', '2026-08-28 13:56:17', '2026-08-30 17:03:52'),
(8, 50, 128, 'وام بابایی ملت', '1050000000', 14011013, 120, '13636000', '0', '1636320000', 14011013, 13, 1, 'وام 120 ماهه بابایی بانک ملت', '2026-08-28 14:11:32', '2026-08-30 17:04:01'),
(9, 80, 143, 'وام ازدواج کوهجانی', '1360000000', 14020528, 120, '20647000', '0', '2477640000', 14020607, 7, 1, 'وام ازدواج کوهجانی - 120 ماهه', '2026-08-28 14:22:30', '2026-08-30 17:04:14'),
(10, 5, 100, 'وام تجارت', '700000000', 14000630, 120, '6364000', '0', '763680000', 14000730, 30, 1, 'وام ازدواج تجارت 120 ماهه', '2026-08-28 14:35:13', '2026-08-30 17:04:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vams`
--
ALTER TABLE `vams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_vams_hesab_id` (`hesab_id`),
  ADD KEY `idx_vams_status` (`status`),
  ADD KEY `idx_vams_received_date` (`received_date`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vams`
--
ALTER TABLE `vams`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'شناسه یکتا وام', AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
