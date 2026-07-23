-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 23, 2026 at 07:22 AM
-- Server version: 11.8.8-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u362702936_skconstruction`
--

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` int(11) NOT NULL,
  `entry_date` date DEFAULT NULL,
  `bank_name` varchar(100) NOT NULL,
  `bank_branch` varchar(100) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` enum('active','inactive','deleted') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cc_account`
--

CREATE TABLE `cc_account` (
  `id` int(11) NOT NULL,
  `entry_date` date DEFAULT NULL,
  `bank_id` int(11) NOT NULL,
  `loan_amount` varchar(100) NOT NULL,
  `interest` varchar(100) NOT NULL,
  `total_amount` varchar(100) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` enum('active','inactive','deleted') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `common_expenses`
--

CREATE TABLE `common_expenses` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `expense_type` enum('income','expense') NOT NULL,
  `table_name` varchar(100) NOT NULL,
  `fields_crud` text NOT NULL,
  `status` enum('active','inactive','deleted') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `common_expenses`
--

INSERT INTO `common_expenses` (`id`, `title`, `expense_type`, `table_name`, `fields_crud`, `status`) VALUES
(1, 'Market Loans EMI', 'expense', '', '', 'active'),
(2, 'Market Loans EMI', 'expense', '', '', 'active'),
(3, 'Vehicle Expense', 'expense', '', '', 'active'),
(4, 'Purchase', 'expense', '', '', 'active'),
(5, 'GST Bill', 'expense', '', '', 'active'),
(6, 'FDR', 'expense', '', '', 'active'),
(7, 'CC Account EMI', 'expense', '', '', 'active'),
(8, 'Office Expense', 'expense', '', '', 'active'),
(9, 'Staff Loan', 'expense', '', '', 'active'),
(10, 'Expense Types', 'expense', '', '', 'active'),
(11, 'Market Loans', 'income', 'market_loans', '', 'active'),
(12, 'GST Bill', 'income', '', '', 'active'),
(13, 'FDR', 'income', '', '', 'active'),
(14, 'CC Account', 'income', '', '', 'active'),
(15, 'Staff Loan', 'income', '', '', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `daily_entry`
--

CREATE TABLE `daily_entry` (
  `id` int(11) NOT NULL,
  `reference_id` int(11) NOT NULL,
  `reference_no` varchar(150) DEFAULT NULL COMMENT 'for direct expenses and emis',
  `payment_of_id` int(11) NOT NULL DEFAULT 0,
  `entry_date` date DEFAULT current_timestamp(),
  `site` int(11) NOT NULL,
  `expense_type` enum('income','expense') NOT NULL,
  `expense_id` int(11) NOT NULL DEFAULT 0,
  `expense_id_type` int(11) NOT NULL DEFAULT 1 COMMENT '1=any expense, 2=expense from expense types table',
  `amount` varchar(100) NOT NULL,
  `expense_date` date NOT NULL,
  `remarks` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` enum('active','inactive','deleted','delete_pending') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daily_entry`
--

INSERT INTO `daily_entry` (`id`, `reference_id`, `reference_no`, `payment_of_id`, `entry_date`, `site`, `expense_type`, `expense_id`, `expense_id_type`, `amount`, `expense_date`, `remarks`, `created_at`, `updated_at`, `status`) VALUES
(1, 0, '', 0, '2025-02-19', 1, 'expense', 1, 1, '100000', '2025-02-19', 'R.K ELECTRICAL', '2024-08-12 09:04:11', '2025-02-19 12:21:45', 'active'),
(2, 0, '', 0, '2025-06-09', 2, 'expense', 2, 1, '69800', '2025-06-09', 'LUCKY TRADERS', '2024-08-12 09:10:04', '2025-06-09 20:17:51', 'active'),
(3, 0, '', 0, '2025-02-19', 3, 'expense', 3, 1, '30200', '2025-02-19', 'LUCKY TRADERS', '2024-08-12 09:18:00', '2025-02-19 12:19:29', 'active'),
(4, 0, '', 0, '2024-09-12', 4, 'expense', 1, 1, '14080', '2024-09-12', 'GITTI', '2024-09-12 06:21:10', '2024-09-12 06:21:28', 'active'),
(5, 0, '', 0, '2025-02-19', 5, 'expense', 1, 1, '24090', '2025-02-19', 'GITTI', '2024-09-12 06:27:49', '2025-02-19 12:17:19', 'active'),
(6, 0, '', 0, '2024-09-12', 6, 'expense', 1, 1, '55800', '2024-09-12', 'GITTI', '2024-09-12 06:28:33', '2024-09-12 06:54:20', 'active'),
(7, 0, '', 0, '2025-02-19', 7, 'expense', 1, 1, '37000', '2025-02-19', 'janta colour', '2025-02-19 12:08:31', '2025-02-19 12:09:32', 'active'),
(8, 0, 'ABCD', 0, '2025-06-10', 1, 'expense', 2, 1, '10000', '2025-06-10', 'asdfasdf asd fasdfasd fsdaf', '2025-06-10 05:45:43', '2025-06-10 07:04:41', 'inactive'),
(9, 0, 'asdfdsf', 0, '2025-06-10', 1, 'expense', 2, 1, '5000', '2025-06-10', 'asdfadsf asd', '2025-06-10 06:27:24', '2025-06-10 07:03:48', 'inactive'),
(10, 0, '1', 0, '2025-07-03', 1, 'expense', 2, 1, '10', '2025-07-03', '', '2025-07-03 13:46:52', '2025-07-04 09:51:54', 'active'),
(11, 0, '2', 0, '2025-07-03', 2, 'expense', 2, 1, '10', '2025-07-03', '', '2025-07-03 13:47:21', '2025-07-04 09:51:54', 'active'),
(12, 0, '3', 0, '2025-07-03', 3, 'expense', 2, 1, '10', '2025-07-03', '', '2025-07-03 13:47:53', '2025-07-04 09:51:54', 'active'),
(13, 0, '1', 0, '2025-07-04', 1, 'expense', 2, 1, '10', '2025-07-04', '', '2025-07-04 09:54:28', '2025-07-04 09:55:54', 'active'),
(14, 0, '1', 0, '2025-07-04', 2, 'expense', 2, 1, '10', '2025-07-04', '', '2025-07-04 09:54:52', '2025-07-04 09:55:54', 'active'),
(15, 0, '', 0, '2025-07-04', 3, 'expense', 2, 1, '', '2025-07-04', '', '2025-07-04 09:55:19', '2025-07-04 09:55:54', 'active'),
(16, 0, '1', 0, '2025-07-04', 1, 'expense', 2, 1, '10', '2025-07-04', 'just for testing', '2025-07-04 12:52:37', '0000-00-00 00:00:00', 'inactive'),
(17, 0, '1', 0, '2025-07-04', 7, 'expense', 2, 1, '10', '2025-07-04', '', '2025-07-04 13:13:00', '0000-00-00 00:00:00', 'inactive'),
(18, 0, '1', 0, '2025-07-04', 11, 'expense', 2, 1, '100', '2025-07-04', '', '2025-07-04 13:54:04', '0000-00-00 00:00:00', 'inactive'),
(19, 0, '1', 0, '2025-07-05', 15, 'expense', 2, 1, '100', '2025-07-05', '', '2025-07-05 09:58:38', '2025-07-05 09:59:49', 'active'),
(20, 0, '2', 0, '2025-07-05', 14, 'expense', 2, 1, '50', '2025-07-05', '', '2025-07-05 09:58:53', '2025-07-05 09:59:49', 'active'),
(21, 0, '1', 0, '2025-07-05', 13, 'expense', 2, 1, '1000', '2025-07-05', '', '2025-07-05 09:59:13', '2025-07-05 09:59:49', 'active'),
(22, 0, '1', 0, '2025-07-05', 15, 'expense', 2, 1, '150', '2025-07-05', '', '2025-07-05 10:05:33', '2025-07-05 10:08:26', 'active'),
(23, 0, '1', 0, '2025-07-05', 14, 'expense', 2, 1, '2000', '2025-07-05', 'RAO CSPTCL RAIPUR(FDR)', '2025-07-05 10:17:08', '0000-00-00 00:00:00', 'inactive'),
(24, 0, '1', 0, '2025-10-07', 1, 'expense', 2, 1, '250', '2025-10-07', '', '2025-10-07 04:57:14', '2025-10-07 05:01:33', 'active'),
(25, 0, '1', 0, '2025-10-07', 1, 'income', 6, 1, '500', '2025-10-07', '', '2025-10-07 04:58:23', '2025-10-07 05:01:33', 'active'),
(26, 0, 'BORE', 0, '2025-10-07', 10, 'expense', 4, 1, '1500', '2025-10-07', '', '2025-10-07 04:59:01', '2025-10-07 05:01:33', 'active'),
(27, 0, '1', 0, '2025-04-28', 8, 'expense', 2, 1, '20000', '2025-04-28', 'OHT ', '2025-10-07 05:26:52', '2025-10-07 05:43:26', 'inactive'),
(28, 0, '1', 0, '2025-04-28', 8, 'expense', 2, 1, '740', '2025-04-28', 'GST', '2025-10-07 05:27:41', '2025-10-07 05:43:09', 'inactive'),
(29, 0, '2', 0, '2025-04-28', 10, 'expense', 2, 1, '43948', '2025-04-28', 'OFFICE COMMSION', '2025-10-07 05:40:27', '2025-10-07 05:42:41', 'inactive'),
(30, 0, '2', 0, '2025-04-28', 10, 'expense', 2, 1, '1626', '2025-04-28', '', '2025-10-07 05:45:04', '0000-00-00 00:00:00', 'inactive'),
(31, 0, '3', 0, '2025-04-28', 15, 'expense', 2, 1, '30920', '2025-04-28', 'OFFICE COMMISION', '2025-10-07 05:49:57', '0000-00-00 00:00:00', 'inactive'),
(32, 0, '3', 0, '2025-04-28', 15, 'expense', 2, 1, '1144', '2025-04-28', 'GST', '2025-10-07 05:50:34', '0000-00-00 00:00:00', 'inactive'),
(33, 0, '4', 0, '2025-04-28', 8, 'expense', 2, 1, '25259', '2025-04-28', 'OFFICE COMMISION', '2025-10-07 06:04:15', '0000-00-00 00:00:00', 'inactive'),
(34, 0, '4', 0, '2025-10-07', 8, 'expense', 2, 1, '934', '2025-10-07', 'GST', '2025-10-07 06:05:02', '2025-10-07 07:38:37', 'inactive'),
(35, 0, '23123', 0, '2025-10-14', 1, 'expense', 11, 1, '5000', '2025-10-14', '', '2025-10-14 06:02:48', '0000-00-00 00:00:00', 'deleted'),
(36, 0, 'sds', 0, '2025-10-14', 4, 'income', 20, 1, '100000', '2025-10-14', '', '2025-10-14 06:07:50', '2025-10-14 09:44:34', 'deleted'),
(37, 0, '', 0, '2025-10-14', 8, 'expense', 2, 1, '10000', '2025-10-14', '', '2025-10-14 09:46:45', '0000-00-00 00:00:00', 'deleted'),
(38, 0, '', 0, '2025-10-14', 8, 'expense', 2, 1, '10000', '2025-10-14', '', '2025-10-14 09:52:50', '2025-10-14 09:58:27', 'active'),
(39, 0, '', 0, '2025-10-14', 8, 'expense', 2, 1, '20000', '2025-10-14', '', '2025-10-14 09:53:43', '2025-10-14 09:58:27', 'active'),
(40, 0, '', 0, '2025-10-14', 8, 'expense', 2, 1, '2400', '2025-10-14', '', '2025-10-14 09:54:26', '2025-10-14 09:58:27', 'active'),
(41, 0, '', 0, '2025-10-14', 8, 'income', 5, 1, '50000', '2025-10-14', '', '2025-10-14 09:56:18', '2025-10-14 09:58:27', 'active'),
(42, 0, '123', 0, '2025-10-15', 1, 'expense', 2, 1, '5000', '2025-10-15', 'Rakesh', '2025-10-15 07:55:06', '0000-00-00 00:00:00', 'active'),
(43, 0, '343141', 0, '2025-10-15', 2, 'income', 9, 1, '111', '2025-10-15', 'test', '2025-10-15 20:33:50', '2025-10-15 20:50:25', ''),
(44, 0, '', 0, '2025-10-24', 8, 'expense', 2, 1, '1500000', '2025-10-24', '', '2025-10-24 08:49:42', '2025-10-24 08:55:18', 'active'),
(45, 0, '', 0, '2025-10-24', 8, 'income', 22, 1, '1500000', '2025-10-24', '', '2025-10-24 08:51:02', '2025-10-24 08:52:32', 'delete_pending'),
(46, 0, '', 0, '2026-01-31', 8, 'expense', 2, 1, '50000', '2026-01-31', 'DILLIP', '2026-01-31 06:30:53', '0000-00-00 00:00:00', 'inactive'),
(47, 0, '', 0, '2026-01-31', 8, 'expense', 2, 1, '2100', '2026-01-31', 'PAINTER', '2026-01-31 06:31:36', '0000-00-00 00:00:00', 'inactive'),
(48, 0, '', 0, '2026-01-31', 8, 'income', 5, 1, '50000', '2026-01-31', 'PAYMENT THROUGH PHE', '2026-01-31 06:32:14', '0000-00-00 00:00:00', 'inactive'),
(49, 0, '', 0, '2026-02-02', 8, 'expense', 2, 1, '12000', '2026-02-02', 'dilip', '2026-02-02 07:55:30', '2026-02-02 07:58:24', 'active'),
(50, 0, '', 0, '2026-02-02', 8, 'expense', 2, 1, '25000', '2026-02-02', 'manoj', '2026-02-02 07:55:56', '2026-02-02 07:58:24', 'active'),
(51, 0, '', 0, '2026-02-02', 8, 'income', 22, 1, '50000', '2026-02-02', 'payment recived in 3637', '2026-02-02 07:57:20', '2026-02-02 07:58:24', 'active'),
(52, 0, '0009', 0, '2026-04-14', 1, 'income', 24, 1, '20000', '2026-04-14', 'TEST', '2026-04-14 08:12:24', '0000-00-00 00:00:00', 'active'),
(53, 0, '0909', 0, '2026-04-14', 2, 'expense', 25, 1, '5000', '2026-04-14', 'gfjhgfjhg', '2026-04-14 08:14:59', '0000-00-00 00:00:00', 'active'),
(54, 0, '', 0, '2026-04-18', 8, 'income', 22, 1, '50000', '2026-04-18', '', '2026-04-18 10:36:18', '0000-00-00 00:00:00', 'delete_pending'),
(55, 0, '', 0, '2026-04-18', 11, 'expense', 2, 1, '9600', '2026-04-18', '', '2026-04-18 11:00:06', '2026-04-18 11:02:09', 'active'),
(56, 0, '', 0, '2026-04-18', 11, 'expense', 2, 1, '355', '2026-04-18', 'GST', '2026-04-18 11:00:46', '2026-04-18 11:02:09', 'active'),
(57, 0, '1', 0, '2026-04-23', 21, 'income', 28, 1, '500', '2026-04-23', 'LOAN', '2026-04-23 07:41:38', '2026-04-23 07:44:55', 'active'),
(58, 0, '02', 0, '2026-04-23', 22, 'income', 30, 1, '10000', '2026-04-23', 'LOAN ', '2026-04-23 07:48:46', '2026-04-23 07:49:08', ''),
(59, 0, '03', 0, '2026-04-23', 22, 'income', 30, 1, '15000', '2026-04-23', 'LOAN', '2026-04-23 07:49:46', '2026-04-23 07:49:56', 'active'),
(60, 0, '02', 0, '2026-04-23', 23, 'expense', 31, 1, '10000', '2026-04-23', 'LOAN', '2026-04-23 10:26:52', '2026-04-23 10:27:17', 'active'),
(61, 0, '', 0, '2026-04-28', 10, 'expense', 2, 1, '5000', '2026-04-28', 'ramesh', '2026-04-28 10:13:22', '0000-00-00 00:00:00', 'inactive');

-- --------------------------------------------------------

--
-- Table structure for table `expense_main_types`
--

CREATE TABLE `expense_main_types` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expense_main_types`
--

INSERT INTO `expense_main_types` (`id`, `title`, `status`) VALUES
(1, 'expense', 'active'),
(2, 'income', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `expense_type`
--

CREATE TABLE `expense_type` (
  `id` int(11) NOT NULL,
  `entry_date` date DEFAULT NULL,
  `expense_type` varchar(200) NOT NULL,
  `expense` enum('income','expense') NOT NULL DEFAULT 'expense',
  `remarks` text NOT NULL,
  `is_show` int(11) NOT NULL DEFAULT 0,
  `table_name` varchar(100) DEFAULT NULL,
  `with_reference` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` enum('active','inactive','deleted') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expense_type`
--

INSERT INTO `expense_type` (`id`, `entry_date`, `expense_type`, `expense`, `remarks`, `is_show`, `table_name`, `with_reference`, `created_at`, `updated_at`, `status`) VALUES
(1, '2020-01-01', 'materials', 'expense', 'R.K ELECTRICAL', 2, NULL, 0, '2024-08-12 09:03:20', '2025-02-19 12:24:15', 'inactive'),
(2, '2024-08-12', 'LABOUR PAYMENT', 'expense', 'S.P LABOUR', 2, NULL, 0, '2024-08-12 09:09:00', NULL, 'active'),
(3, '2020-01-01', 'commission', 'expense', '', 2, NULL, 0, '2024-08-12 09:16:56', '2025-02-19 12:25:13', 'inactive'),
(4, '2025-07-19', 'Payment', 'expense', '', 2, NULL, 0, '2025-07-19 05:50:37', NULL, 'active'),
(5, '2025-08-28', 'Repay test', 'income', 'test', 2, NULL, 0, '2025-08-28 08:16:54', '2025-08-28 08:31:29', 'active'),
(6, '2025-08-28', 'wqewq', 'income', 'ewqe', 2, NULL, 0, '2025-08-28 08:19:34', NULL, 'active'),
(7, '2025-10-14', 'gfdg', '', '', 1, NULL, 0, '2025-10-14 05:50:41', NULL, 'active'),
(8, '2025-10-14', 'dsf', '', '', 1, NULL, 0, '2025-10-14 05:58:41', NULL, 'active'),
(9, '2025-10-14', 'sfdsf', 'income', '', 1, NULL, 0, '2025-10-14 06:00:06', NULL, 'active'),
(10, '2025-10-14', 'dasdsad', 'expense', '', 1, NULL, 0, '2025-10-14 06:02:37', NULL, 'active'),
(11, '2025-10-14', 'dasdsad', '', '', 1, NULL, 0, '2025-10-14 06:02:48', NULL, 'active'),
(12, '2025-10-14', 'fdsfdsf', 'income', '', 1, NULL, 0, '2025-10-14 06:06:15', NULL, 'active'),
(13, '2025-10-14', '', 'income', '', 1, NULL, 0, '2025-10-14 06:08:40', NULL, 'active'),
(14, '2025-10-14', 'dsadsadfdsfds', 'income', '', 1, NULL, 0, '2025-10-14 06:08:45', NULL, 'active'),
(15, '2025-10-14', '', 'income', '', 1, NULL, 0, '2025-10-14 06:12:20', NULL, 'active'),
(16, '2025-10-14', 'dsds', 'income', '', 1, NULL, 0, '2025-10-14 06:12:23', NULL, 'active'),
(17, '2025-10-14', 'uytyu', 'income', '', 1, NULL, 0, '2025-10-14 06:14:08', NULL, 'active'),
(18, '2025-10-14', 'uytyu', '', '', 1, NULL, 0, '2025-10-14 06:14:16', NULL, 'active'),
(19, '2025-10-14', '0', '', '', 1, NULL, 0, '2025-10-14 06:15:38', NULL, 'active'),
(20, '2025-10-14', 'poiuy', 'income', '', 1, NULL, 0, '2025-10-14 06:17:20', NULL, 'active'),
(21, '2025-10-14', '', 'income', '', 1, NULL, 0, '2025-10-14 09:57:02', NULL, 'active'),
(22, '2025-10-24', 'PAYMENT THROUGH JJM JDP', 'income', '', 1, NULL, 0, '2025-10-24 08:50:42', NULL, 'active'),
(23, '2026-04-14', 'vehicle expenses', 'income', '', 1, NULL, 0, '2026-04-14 08:11:40', NULL, 'active'),
(24, '2026-04-14', 'Vehicle', 'income', '', 1, NULL, 0, '2026-04-14 08:11:58', NULL, 'active'),
(25, '2026-04-14', 'vehicle', 'expense', '', 1, NULL, 0, '2026-04-14 08:14:48', NULL, 'active'),
(26, '2026-04-14', '', 'income', '', 1, NULL, 0, '2026-04-14 08:19:21', NULL, 'active'),
(27, '2026-04-18', '', 'income', '', 1, NULL, 0, '2026-04-18 10:35:17', NULL, 'active'),
(28, '2026-04-23', 'PAYMENT THROUGH RAJ NARAYAN', 'income', '', 1, NULL, 0, '2026-04-23 07:40:18', NULL, 'active'),
(29, '2026-04-23', '', 'income', '', 1, NULL, 0, '2026-04-23 07:41:22', NULL, 'active'),
(30, '2026-04-23', 'PAYMENT THROUGH KISHAN HARDWARE', 'income', '', 1, NULL, 0, '2026-04-23 07:48:35', NULL, 'active'),
(31, '2026-04-23', 'INTEREST', 'expense', '', 1, NULL, 0, '2026-04-23 10:26:40', NULL, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `fdr`
--

CREATE TABLE `fdr` (
  `id` int(11) NOT NULL,
  `entry_date` date NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `amount` varchar(100) NOT NULL,
  `released_amount` varchar(100) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` enum('active','inactive','deleted') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fdr`
--

INSERT INTO `fdr` (`id`, `entry_date`, `name`, `description`, `amount`, `released_amount`, `remarks`, `created_at`, `updated_at`, `status`) VALUES
(1, '2025-07-05', 'RAO CSPTCL RAIPUR', 'TENDER FEE', '2000', '2000', 'NOT RELEASED', '2025-07-05 10:15:57', NULL, 'inactive');

-- --------------------------------------------------------

--
-- Table structure for table `gst_bill`
--

CREATE TABLE `gst_bill` (
  `id` int(11) NOT NULL,
  `entry_date` date DEFAULT NULL,
  `supplier_id` int(11) NOT NULL,
  `particular` varchar(255) NOT NULL,
  `quantity` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `gst` varchar(100) NOT NULL,
  `total_amount` varchar(100) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` enum('active','inactive','deleted') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gst_bill`
--

INSERT INTO `gst_bill` (`id`, `entry_date`, `supplier_id`, `particular`, `quantity`, `amount`, `gst`, `total_amount`, `remarks`, `created_at`, `updated_at`, `status`) VALUES
(1, '2025-12-12', 1, 'paper', '100', '5', '6', '530', '', '2025-12-12 17:46:59', NULL, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `loan_party`
--

CREATE TABLE `loan_party` (
  `id` int(11) NOT NULL,
  `entry_date` date DEFAULT NULL,
  `party_name` varchar(200) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` enum('active','inactive','deleted') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loan_party`
--

INSERT INTO `loan_party` (`id`, `entry_date`, `party_name`, `phone`, `address`, `remarks`, `created_at`, `updated_at`, `status`) VALUES
(1, '2026-04-23', 'SONI BHAIYA', '9550346035', 'JAGDALPUR', '', '2026-04-23 07:55:47', '2026-04-23 10:17:23', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `market_loans`
--

CREATE TABLE `market_loans` (
  `id` int(11) NOT NULL,
  `entry_date` date DEFAULT NULL,
  `party_id` int(11) NOT NULL,
  `loan_amount` varchar(100) NOT NULL,
  `interest` varchar(100) NOT NULL,
  `total_installments` int(11) NOT NULL,
  `total_amount` varchar(100) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` enum('active','inactive','deleted') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `market_loans`
--

INSERT INTO `market_loans` (`id`, `entry_date`, `party_id`, `loan_amount`, `interest`, `total_installments`, `total_amount`, `remarks`, `created_at`, `updated_at`, `status`) VALUES
(1, '2026-04-23', 1, '500000', '2%', 2, 'NaN', 'LOAN', '2026-04-23 07:56:59', '2026-04-23 08:02:34', 'active'),
(2, '2026-04-23', 1, '500000', '2%', 10000, 'NaN', 'LOAN', '2026-04-23 10:18:39', '2026-04-23 10:19:13', 'active'),
(3, '2026-04-23', 1, '100000', '2%', 100000, 'NaN', 'LOAN', '2026-04-23 10:21:51', NULL, 'inactive');

-- --------------------------------------------------------

--
-- Table structure for table `office_expenses`
--

CREATE TABLE `office_expenses` (
  `id` int(11) NOT NULL,
  `entry_date` date DEFAULT NULL,
  `expense_type_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` enum('active','inactive','deleted') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `office_expenses`
--

INSERT INTO `office_expenses` (`id`, `entry_date`, `expense_type_id`, `staff_id`, `amount`, `remarks`, `created_at`, `updated_at`, `status`) VALUES
(1, '2025-10-07', 2, 1, '1234', '', '2025-10-06 07:22:35', '2025-10-07 04:56:44', 'inactive');

-- --------------------------------------------------------

--
-- Table structure for table `office_staffs`
--

CREATE TABLE `office_staffs` (
  `id` int(11) NOT NULL,
  `entry_date` date DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `phone_number` varchar(100) NOT NULL,
  `email_address` varchar(150) NOT NULL,
  `position` enum('admin','operator','manager','lead_manager') NOT NULL,
  `joining_date` date NOT NULL,
  `id_proof` varchar(255) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` enum('active','inactive','deleted') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `office_staffs`
--

INSERT INTO `office_staffs` (`id`, `entry_date`, `name`, `phone_number`, `email_address`, `position`, `joining_date`, `id_proof`, `remarks`, `created_at`, `updated_at`, `status`) VALUES
(1, '2025-10-06', 'ewq', '456345654', 'sdfd@fdgdfdsfds.dsf', 'lead_manager', '2025-10-07', 'codeigniter-logo-png-transparent.png', '', '2025-10-06 07:25:28', NULL, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `id` int(11) NOT NULL,
  `entry_date` date DEFAULT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone_number` varchar(100) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `id_proof` varchar(200) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` enum('active','inactive','deleted') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pay_partner`
--

CREATE TABLE `pay_partner` (
  `id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `pay_for` text NOT NULL,
  `pay_type` enum('debit','credit') NOT NULL DEFAULT 'debit',
  `remarks` text DEFAULT NULL,
  `entry_date` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` enum('active','inactive','deleted') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `status` enum('active','inactive','deleted') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `created_at`, `status`) VALUES
(1, 'daily-entry-list', '2024-03-07 02:48:16', 'active'),
(2, 'daily-entry-add', '2024-03-07 02:48:16', 'active'),
(3, 'daily-entry-edit', '2024-03-07 02:48:16', 'active'),
(4, 'daily-entry-view', '2024-03-07 02:48:16', 'active'),
(5, 'daily-entry-delete', '2024-03-07 02:48:16', 'active'),
(6, 'site-expenses', '2024-03-07 02:48:16', 'active'),
(7, 'pay-partner-list', '2024-03-07 02:48:16', 'active'),
(8, 'pay-partner-add', '2024-03-07 02:48:16', 'active'),
(9, 'pay-partner-edit', '2024-03-07 02:48:16', 'active'),
(10, 'pay-partner-view', '2024-03-07 02:48:16', 'active'),
(11, 'pay-partner-delete', '2024-03-07 02:48:16', 'active'),
(12, 'market-loans-list', '2024-03-07 02:48:16', 'active'),
(13, 'market-loans-add', '2024-03-07 02:48:16', 'active'),
(14, 'market-loans-edit', '2024-03-07 02:48:16', 'active'),
(15, 'market-loans-view', '2024-03-07 02:48:16', 'active'),
(16, 'market-loans-delete', '2024-03-07 02:48:16', 'active'),
(17, 'vehicles-expenses-list', '2024-03-07 02:48:16', 'active'),
(18, 'vehicles-expense-add', '2024-03-07 02:48:16', 'active'),
(19, 'vehicles-expense-edit', '2024-03-07 02:48:16', 'active'),
(20, 'vehicles-expense-view', '2024-03-07 02:48:16', 'active'),
(21, 'vehicles-expense-delete', '2024-03-07 02:48:16', 'active'),
(22, 'vehicles-running-list', '2024-03-07 02:48:16', 'active'),
(23, 'vehicles-running-add', '2024-03-07 02:48:16', 'active'),
(24, 'vehicles-running-edit', '2024-03-07 02:48:16', 'active'),
(25, 'vehicles-running-view', '2024-03-07 02:48:16', 'active'),
(26, 'vehicles-running-delete', '2024-03-07 02:48:16', 'active'),
(27, 'purchase-list', '2024-03-07 02:48:16', 'active'),
(28, 'purchase-add', '2024-03-07 02:48:16', 'active'),
(29, 'purchase-edit', '2024-03-07 02:48:16', 'active'),
(30, 'purchase-view', '2024-03-07 02:48:16', 'active'),
(31, 'purchase-delete', '2024-03-07 02:48:16', 'active'),
(32, 'gst-bill-list', '2024-03-07 02:48:16', 'active'),
(33, 'gst-bill-add', '2024-03-07 02:48:16', 'active'),
(34, 'gst-bill-edit', '2024-03-07 02:48:16', 'active'),
(35, 'gst-bill-view', '2024-03-07 02:48:16', 'active'),
(36, 'gst-bill-delete', '2024-03-07 02:48:16', 'active'),
(37, 'fdr-list', '2024-03-07 02:48:16', 'active'),
(38, 'fdr-add', '2024-03-07 02:48:16', 'active'),
(39, 'fdr-edit', '2024-03-07 02:48:16', 'active'),
(40, 'fdr-view', '2024-03-07 02:48:16', 'active'),
(41, 'fdr-delete', '2024-03-07 02:48:16', 'active'),
(42, 'cc-account-list', '2024-03-07 02:48:16', 'active'),
(43, 'cc-account-add', '2024-03-07 02:48:16', 'active'),
(44, 'cc-account-edit', '2024-03-07 02:48:16', 'active'),
(45, 'cc-account-view', '2024-03-07 02:48:16', 'active'),
(46, 'cc-account-delete', '2024-03-07 02:48:16', 'active'),
(47, 'products-list', '2024-03-07 02:48:16', 'active'),
(48, 'product-add', '2024-03-07 02:48:16', 'active'),
(49, 'product-edit', '2024-03-07 02:48:16', 'active'),
(50, 'product-view', '2024-03-07 02:48:16', 'active'),
(51, 'product-delete', '2024-03-07 02:48:16', 'active'),
(52, 'office-expense-list', '2024-03-07 02:48:16', 'active'),
(53, 'office-expense-add', '2024-03-07 02:48:16', 'active'),
(54, 'office-expense-edit', '2024-03-07 02:48:16', 'active'),
(55, 'office-expense-view', '2024-03-07 02:48:16', 'active'),
(56, 'office-expense-delete', '2024-03-07 02:48:16', 'active'),
(57, 'staff-loans-list', '2024-03-07 02:48:16', 'active'),
(58, 'staff-loan-add', '2024-03-07 02:48:16', 'active'),
(59, 'staff-loan-edit', '2024-03-07 02:48:16', 'active'),
(60, 'staff-loan-view', '2024-03-07 02:48:16', 'active'),
(61, 'staff-loan-delete', '2024-03-07 02:48:16', 'active'),
(62, 'reports-daily', '2024-03-07 02:48:16', 'active'),
(63, 'reports-monthly', '2024-03-07 02:48:16', 'active'),
(64, 'reports', '2024-03-07 02:48:16', 'active'),
(65, 'sites-list', '2024-03-07 02:48:16', 'active'),
(66, 'site-add', '2024-03-07 02:48:16', 'active'),
(67, 'site-edit', '2024-03-07 02:48:16', 'active'),
(68, 'site-view', '2024-03-07 02:48:16', 'active'),
(69, 'site-delete', '2024-03-07 02:48:16', 'active'),
(70, 'partners-list', '2024-03-07 02:48:16', 'active'),
(71, 'partner-add', '2024-03-07 02:48:16', 'active'),
(72, 'partner-edit', '2024-03-07 02:48:16', 'active'),
(73, 'partner-view', '2024-03-07 02:48:16', 'active'),
(74, 'partner-delete', '2024-03-07 02:48:16', 'active'),
(75, 'vehicles-list', '2024-03-07 02:48:16', 'active'),
(76, 'vehicle-add', '2024-03-07 02:48:16', 'active'),
(77, 'vehicle-edit', '2024-03-07 02:48:16', 'active'),
(78, 'vehicle-view', '2024-03-07 02:48:16', 'active'),
(79, 'vehicle-delete', '2024-03-07 02:48:16', 'active'),
(80, 'office-staff-list', '2024-03-07 02:48:16', 'active'),
(81, 'office-staff-add', '2024-03-07 02:48:16', 'active'),
(82, 'office-staff-edit', '2024-03-07 02:48:16', 'active'),
(83, 'office-staff-view', '2024-03-07 02:48:16', 'active'),
(84, 'office-staff-delete', '2024-03-07 02:48:16', 'active'),
(85, 'loan-party-list', '2024-03-07 02:48:16', 'active'),
(86, 'loan-party-add', '2024-03-07 02:48:16', 'active'),
(87, 'loan-party-edit', '2024-03-07 02:48:16', 'active'),
(88, 'loan-party-view', '2024-03-07 02:48:16', 'active'),
(89, 'loan-party-delete', '2024-03-07 02:48:16', 'active'),
(90, 'expense-type-list', '2024-03-07 02:48:16', 'active'),
(91, 'expense-type-add', '2024-03-07 02:48:16', 'active'),
(92, 'expense-type-edit', '2024-03-07 02:48:16', 'active'),
(93, 'expense-type-view', '2024-03-07 02:48:16', 'active'),
(94, 'expense-type-delete', '2024-03-07 02:48:16', 'active'),
(95, 'suppliers-list', '2024-03-07 02:48:16', 'active'),
(96, 'supplier-add', '2024-03-07 02:48:16', 'active'),
(97, 'supplier-edit', '2024-03-07 02:48:16', 'active'),
(98, 'supplier-view', '2024-03-07 02:48:16', 'active'),
(99, 'supplier-delete', '2024-03-07 02:48:16', 'active'),
(100, 'banks-list', '2024-03-07 02:48:16', 'active'),
(101, 'bank-add', '2024-03-07 02:48:16', 'active'),
(102, 'bank-edit', '2024-03-07 02:48:16', 'active'),
(103, 'bank-view', '2024-03-07 02:48:16', 'active'),
(104, 'bank-delete', '2024-03-07 02:48:16', 'active'),
(105, 'users-list', '2024-03-07 02:48:16', 'active'),
(106, 'user-add', '2024-03-07 02:48:16', 'active'),
(107, 'user-edit', '2024-03-07 02:48:16', 'active'),
(108, 'user-view', '2024-03-07 02:48:16', 'active'),
(109, 'user-delete', '2024-03-07 02:48:16', 'active'),
(110, 'user-role-list', '2024-03-07 02:48:16', 'active'),
(111, 'user-role-add', '2024-03-07 02:48:16', 'active'),
(112, 'user-role-edit', '2024-03-07 02:48:16', 'active'),
(113, 'user-role-view', '2024-03-07 02:48:16', 'active'),
(114, 'user-role-delete', '2024-03-07 02:48:16', 'active'),
(115, 'cashflow-reports', '2025-10-06 12:35:13', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `entry_date` date DEFAULT NULL,
  `product_name` varchar(200) NOT NULL,
  `hsn_sac` varchar(100) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` enum('active','inactive','deleted') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `id` int(11) NOT NULL,
  `entry_date` date DEFAULT NULL,
  `reference_no` varchar(100) NOT NULL,
  `purchase_date` date NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `total_amount` varchar(100) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` enum('active','inactive','deleted') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`id`, `entry_date`, `reference_no`, `purchase_date`, `supplier_id`, `total_amount`, `remarks`, `created_at`, `updated_at`, `status`) VALUES
(1, '2025-12-11', '00001', '2025-12-11', 1, '133725.00', '', '2025-12-12 17:44:23', '0000-00-00 00:00:00', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_details`
--

CREATE TABLE `purchase_details` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `particular` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `subtotal` varchar(100) NOT NULL,
  `gst` varchar(100) NOT NULL,
  `gst_amount` varchar(100) NOT NULL,
  `total` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` enum('active','inactive','deleted') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_details`
--

INSERT INTO `purchase_details` (`id`, `purchase_id`, `particular`, `quantity`, `amount`, `subtotal`, `gst`, `gst_amount`, `total`, `created_at`, `updated_at`, `status`) VALUES
(1, 1, 'cement', 100, '1200', '120000.00', '5', '6000.00', '126000.00', '2025-12-12 17:44:23', NULL, 'active'),
(2, 1, 'coir', 50, '150', '7500.00', '3', '225.00', '7725.00', '2025-12-12 17:44:23', NULL, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `entry_date` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` enum('active','inactive','deleted') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `entry_date`, `created_at`, `updated_at`, `status`) VALUES
(1, 'Admin', 'admin', '2024-03-07 00:00:00', '2024-03-07 02:35:13', '2024-03-06 23:06:55', 'active'),
(2, 'Operator', 'operator', '2024-03-07 00:00:00', '2024-03-07 02:35:13', '2024-11-30 09:05:17', 'active'),
(3, 'Manager', 'manager', '2024-03-07 00:00:00', '2024-03-07 02:35:13', '2025-07-04 13:35:30', 'active'),
(4, 'Lead Manager', 'lead-manager', '2024-03-07 00:00:00', '2024-03-07 02:35:13', '2025-07-04 13:35:25', 'active'),
(5, 'OPRATIOR', '', '2020-01-12 00:00:00', '2024-09-12 07:02:08', '2025-07-04 13:35:01', 'active'),
(6, 'Data Operator', '', '2024-12-13 00:00:00', '2024-12-13 06:13:05', NULL, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`role_id`, `permission_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(5, 1),
(6, 1),
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(1, 3),
(2, 3),
(3, 3),
(5, 3),
(6, 3),
(1, 4),
(2, 4),
(3, 4),
(4, 4),
(5, 4),
(6, 4),
(1, 5),
(2, 5),
(3, 5),
(4, 5),
(5, 5),
(6, 5),
(1, 6),
(2, 6),
(3, 6),
(4, 6),
(5, 6),
(6, 6),
(1, 7),
(2, 7),
(3, 7),
(4, 7),
(5, 7),
(6, 7),
(1, 8),
(2, 8),
(3, 8),
(4, 8),
(5, 8),
(6, 8),
(1, 9),
(2, 9),
(3, 9),
(4, 9),
(5, 9),
(6, 9),
(1, 10),
(2, 10),
(3, 10),
(4, 10),
(5, 10),
(6, 10),
(1, 11),
(2, 11),
(3, 11),
(4, 11),
(5, 11),
(6, 11),
(1, 12),
(2, 12),
(3, 12),
(4, 12),
(5, 12),
(6, 12),
(1, 13),
(2, 13),
(3, 13),
(4, 13),
(5, 13),
(6, 13),
(1, 14),
(2, 14),
(3, 14),
(4, 14),
(5, 14),
(6, 14),
(1, 15),
(2, 15),
(3, 15),
(4, 15),
(5, 15),
(6, 15),
(1, 16),
(2, 16),
(3, 16),
(4, 16),
(5, 16),
(6, 16),
(1, 17),
(2, 17),
(3, 17),
(4, 17),
(5, 17),
(6, 17),
(1, 18),
(2, 18),
(3, 18),
(4, 18),
(5, 18),
(6, 18),
(1, 19),
(2, 19),
(3, 19),
(4, 19),
(5, 19),
(6, 19),
(1, 20),
(2, 20),
(3, 20),
(4, 20),
(5, 20),
(6, 20),
(1, 21),
(2, 21),
(3, 21),
(4, 21),
(5, 21),
(6, 21),
(1, 22),
(2, 22),
(3, 22),
(4, 22),
(5, 22),
(6, 22),
(1, 23),
(2, 23),
(3, 23),
(4, 23),
(5, 23),
(6, 23),
(1, 24),
(2, 24),
(3, 24),
(4, 24),
(5, 24),
(6, 24),
(1, 25),
(2, 25),
(3, 25),
(4, 25),
(5, 25),
(6, 25),
(1, 26),
(2, 26),
(3, 26),
(4, 26),
(5, 26),
(6, 26),
(1, 27),
(2, 27),
(3, 27),
(4, 27),
(5, 27),
(6, 27),
(1, 28),
(2, 28),
(3, 28),
(4, 28),
(5, 28),
(6, 28),
(1, 29),
(2, 29),
(3, 29),
(4, 29),
(5, 29),
(6, 29),
(1, 30),
(2, 30),
(3, 30),
(4, 30),
(5, 30),
(6, 30),
(1, 31),
(2, 31),
(3, 31),
(4, 31),
(5, 31),
(6, 31),
(1, 32),
(2, 32),
(3, 32),
(4, 32),
(5, 32),
(6, 32),
(1, 33),
(2, 33),
(3, 33),
(4, 33),
(5, 33),
(6, 33),
(1, 34),
(2, 34),
(3, 34),
(4, 34),
(5, 34),
(6, 34),
(1, 35),
(2, 35),
(3, 35),
(4, 35),
(5, 35),
(6, 35),
(1, 36),
(2, 36),
(3, 36),
(4, 36),
(5, 36),
(6, 36),
(1, 37),
(2, 37),
(3, 37),
(4, 37),
(5, 37),
(6, 37),
(1, 38),
(2, 38),
(3, 38),
(4, 38),
(5, 38),
(6, 38),
(1, 39),
(2, 39),
(3, 39),
(4, 39),
(5, 39),
(6, 39),
(1, 40),
(2, 40),
(3, 40),
(4, 40),
(5, 40),
(6, 40),
(1, 41),
(2, 41),
(3, 41),
(4, 41),
(5, 41),
(6, 41),
(1, 42),
(2, 42),
(3, 42),
(4, 42),
(5, 42),
(6, 42),
(1, 43),
(2, 43),
(3, 43),
(4, 43),
(5, 43),
(6, 43),
(1, 44),
(2, 44),
(3, 44),
(4, 44),
(5, 44),
(6, 44),
(1, 45),
(2, 45),
(3, 45),
(4, 45),
(5, 45),
(6, 45),
(1, 46),
(2, 46),
(3, 46),
(4, 46),
(5, 46),
(6, 46),
(1, 47),
(2, 47),
(3, 47),
(4, 47),
(5, 47),
(6, 47),
(1, 48),
(2, 48),
(3, 48),
(4, 48),
(5, 48),
(6, 48),
(1, 49),
(2, 49),
(3, 49),
(4, 49),
(5, 49),
(6, 49),
(1, 50),
(2, 50),
(3, 50),
(4, 50),
(5, 50),
(6, 50),
(1, 51),
(2, 51),
(3, 51),
(4, 51),
(5, 51),
(6, 51),
(1, 52),
(2, 52),
(3, 52),
(4, 52),
(5, 52),
(6, 52),
(1, 53),
(2, 53),
(3, 53),
(4, 53),
(5, 53),
(6, 53),
(1, 54),
(2, 54),
(3, 54),
(4, 54),
(5, 54),
(6, 54),
(1, 55),
(2, 55),
(3, 55),
(4, 55),
(5, 55),
(6, 55),
(1, 56),
(2, 56),
(3, 56),
(4, 56),
(5, 56),
(6, 56),
(1, 57),
(2, 57),
(3, 57),
(4, 57),
(5, 57),
(6, 57),
(1, 58),
(2, 58),
(3, 58),
(4, 58),
(5, 58),
(6, 58),
(1, 59),
(2, 59),
(3, 59),
(4, 59),
(5, 59),
(6, 59),
(1, 60),
(2, 60),
(3, 60),
(4, 60),
(5, 60),
(6, 60),
(1, 61),
(2, 61),
(3, 61),
(4, 61),
(5, 61),
(6, 61),
(1, 62),
(2, 62),
(3, 62),
(4, 62),
(5, 62),
(6, 62),
(1, 63),
(2, 63),
(3, 63),
(4, 63),
(5, 63),
(6, 63),
(1, 64),
(2, 64),
(3, 64),
(4, 64),
(5, 64),
(6, 64),
(1, 65),
(2, 65),
(3, 65),
(4, 65),
(5, 65),
(6, 65),
(1, 66),
(2, 66),
(3, 66),
(4, 66),
(5, 66),
(6, 66),
(1, 67),
(2, 67),
(3, 67),
(4, 67),
(5, 67),
(6, 67),
(1, 68),
(2, 68),
(3, 68),
(4, 68),
(5, 68),
(6, 68),
(1, 69),
(2, 69),
(3, 69),
(4, 69),
(5, 69),
(6, 69),
(1, 70),
(2, 70),
(3, 70),
(4, 70),
(5, 70),
(6, 70),
(1, 71),
(2, 71),
(3, 71),
(4, 71),
(5, 71),
(6, 71),
(1, 72),
(2, 72),
(3, 72),
(4, 72),
(5, 72),
(6, 72),
(1, 73),
(2, 73),
(3, 73),
(4, 73),
(5, 73),
(6, 73),
(1, 74),
(2, 74),
(3, 74),
(4, 74),
(5, 74),
(6, 74),
(1, 75),
(2, 75),
(3, 75),
(4, 75),
(5, 75),
(6, 75),
(1, 76),
(2, 76),
(3, 76),
(4, 76),
(5, 76),
(6, 76),
(1, 77),
(2, 77),
(3, 77),
(4, 77),
(5, 77),
(6, 77),
(1, 78),
(2, 78),
(3, 78),
(4, 78),
(5, 78),
(6, 78),
(1, 79),
(2, 79),
(3, 79),
(4, 79),
(5, 79),
(6, 79),
(1, 80),
(2, 80),
(3, 80),
(4, 80),
(5, 80),
(6, 80),
(1, 81),
(2, 81),
(3, 81),
(4, 81),
(5, 81),
(6, 81),
(1, 82),
(2, 82),
(3, 82),
(4, 82),
(5, 82),
(6, 82),
(1, 83),
(2, 83),
(3, 83),
(4, 83),
(5, 83),
(6, 83),
(1, 84),
(2, 84),
(3, 84),
(4, 84),
(5, 84),
(6, 84),
(1, 85),
(2, 85),
(3, 85),
(4, 85),
(5, 85),
(6, 85),
(1, 86),
(2, 86),
(3, 86),
(4, 86),
(5, 86),
(6, 86),
(1, 87),
(2, 87),
(3, 87),
(4, 87),
(5, 87),
(6, 87),
(1, 88),
(2, 88),
(3, 88),
(4, 88),
(5, 88),
(6, 88),
(1, 89),
(2, 89),
(3, 89),
(4, 89),
(5, 89),
(6, 89),
(1, 90),
(2, 90),
(3, 90),
(4, 90),
(5, 90),
(6, 90),
(1, 91),
(2, 91),
(3, 91),
(4, 91),
(5, 91),
(6, 91),
(1, 92),
(2, 92),
(3, 92),
(4, 92),
(5, 92),
(6, 92),
(1, 93),
(2, 93),
(3, 93),
(4, 93),
(5, 93),
(6, 93),
(1, 94),
(2, 94),
(3, 94),
(4, 94),
(5, 94),
(6, 94),
(1, 95),
(2, 95),
(3, 95),
(4, 95),
(5, 95),
(6, 95),
(1, 96),
(2, 96),
(3, 96),
(4, 96),
(5, 96),
(6, 96),
(1, 97),
(2, 97),
(3, 97),
(4, 97),
(5, 97),
(6, 97),
(1, 98),
(2, 98),
(3, 98),
(4, 98),
(5, 98),
(6, 98),
(1, 99),
(2, 99),
(3, 99),
(4, 99),
(5, 99),
(6, 99),
(1, 100),
(2, 100),
(3, 100),
(4, 100),
(5, 100),
(6, 100),
(1, 101),
(2, 101),
(3, 101),
(4, 101),
(5, 101),
(1, 102),
(2, 102),
(3, 102),
(4, 102),
(5, 102),
(1, 103),
(2, 103),
(3, 103),
(4, 103),
(5, 103),
(1, 104),
(2, 104),
(3, 104),
(4, 104),
(5, 104),
(1, 105),
(3, 105),
(4, 105),
(5, 105),
(1, 106),
(3, 106),
(4, 106),
(5, 106),
(1, 107),
(3, 107),
(4, 107),
(5, 107),
(1, 108),
(3, 108),
(4, 108),
(5, 108),
(1, 109),
(3, 109),
(4, 109),
(5, 109),
(1, 110),
(3, 110),
(4, 110),
(5, 110),
(1, 111),
(3, 111),
(4, 111),
(5, 111),
(1, 112),
(3, 112),
(4, 112),
(5, 112),
(1, 113),
(3, 113),
(4, 113),
(5, 113),
(1, 114),
(3, 114),
(4, 114),
(5, 114),
(1, 115);

-- --------------------------------------------------------

--
-- Table structure for table `sites`
--

CREATE TABLE `sites` (
  `id` int(11) NOT NULL,
  `entry_date` date DEFAULT NULL,
  `site_name` varchar(200) NOT NULL,
  `site_address` text NOT NULL,
  `remarks` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` enum('active','inactive','deleted') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sites`
--

INSERT INTO `sites` (`id`, `entry_date`, `site_name`, `site_address`, `remarks`, `created_at`, `updated_at`, `status`) VALUES
(1, '2020-01-01', 'SP JDP BODHGHAT', ' BHODHGHAT', 'ANKUR SINGH', '2024-08-12 08:56:33', '2024-08-12 09:00:26', 'active'),
(2, '2020-01-01', 'CSEB KANKER', 'KANKER', 'DURGESH CHAND', '2024-08-12 09:07:34', '2026-04-23 07:34:45', 'active'),
(3, '2020-01-01', 'S.P KONDAGAON VISHRAMPURI', 'VISHRAMPURI', 'ROSHAN ', '2024-08-12 09:14:49', '2025-07-04 13:38:00', 'active'),
(4, '2020-01-01', 'S.P JDP REHAVE', 'JAGDALPUR', 'ANKUR', '2024-09-12 06:18:34', '2025-07-04 13:38:07', 'active'),
(5, '2020-01-01', 'C.G.M.S.C KUTRU', 'BIZAPUR', 'DINANATH', '2024-09-12 06:23:35', NULL, 'active'),
(6, '2020-01-01', 'SACIVE BHAIYA', 'karanpur', 'SACHIVE BHAIYA', '2024-09-12 06:24:34', '2026-04-23 10:09:32', 'active'),
(7, '2025-02-19', 's.p jdp nia', 'jagdalpur', 'harsh', '2025-02-19 12:01:35', '2025-07-04 13:28:02', 'active'),
(8, '2025-07-03', 'MUNGA', 'DARBHA', 'MANOJ KUMAR', '2025-07-03 13:17:29', '2025-07-04 13:37:38', 'active'),
(9, '2025-07-03', 'MAWALIPADAR', 'DARBHA', 'MANOJ KUMAR', '2025-07-03 13:17:52', '2025-07-04 13:37:54', 'active'),
(10, '2025-07-03', 'KUTHAR', 'LOHANDIGUDA', 'PRINCE', '2025-07-03 13:18:11', '2025-07-04 13:37:49', 'active'),
(11, '2025-07-04', 'CSEB PAKHANJUR', 'KANKER', 'NITISH TIWARI', '2025-07-04 12:54:07', '2025-07-04 13:51:30', 'active'),
(12, '2025-07-04', 'CSEB MATHURABAZAR', 'PAKHANJUR', 'NITISH TIWARI', '2025-07-04 12:55:01', '2025-07-04 13:51:38', 'active'),
(13, '2025-07-04', 'PHE RUPNAGAR', 'KOYLIBEDA', 'NITISH TIWARI', '2025-07-04 13:02:42', '2025-07-04 13:51:51', 'active'),
(14, '2025-07-04', 'CSEB NARAYANPUR', 'NARAYANPUR', 'CHOTE ROSHAN', '2025-07-04 13:37:14', '2026-04-23 10:09:46', 'active'),
(15, '2025-07-05', 'MUTANPAL 2', 'BASTANAR', 'HARSH', '2025-07-05 09:56:51', '2025-07-05 09:57:48', 'active'),
(16, '2025-10-07', 'SP KANKER', 'KANKER', 'ROSHAN', '2025-10-07 05:29:38', '2026-06-15 10:36:51', 'active'),
(17, '2025-10-07', 'PHE HIROLI', '', 'BANTI', '2025-10-07 06:06:21', '2025-10-07 06:08:45', 'inactive'),
(18, '2025-10-07', 'H.NO. 28', '', '', '2025-10-07 06:09:33', '2026-04-24 10:25:15', 'active'),
(19, '2025-10-07', 'CSEB KONDAGAON', '', 'ROSHAN', '2025-10-07 06:10:40', '2026-04-23 10:09:10', 'active'),
(20, '2025-10-07', 'PHE MUTANPAL', '', '', '2025-10-07 07:29:53', '2026-04-23 07:36:11', 'active'),
(21, '2026-04-18', 'SHRI SAI TRADERS', 'JAGDALPUR', '', '2026-04-18 10:46:33', '2026-04-23 07:46:26', 'inactive'),
(22, '2026-04-23', 'KISHAN HARDWARE', 'JAGDALPUR\r\n', '', '2026-04-23 07:46:23', '2026-04-23 07:47:58', 'active'),
(23, '2026-04-23', 'SONI BHAIYA 1', 'JAGDALPUR', 'LOAN', '2026-04-23 10:23:08', '2026-04-23 10:24:58', 'active'),
(24, '2026-06-15', 'LOAN BY PAPPU', 'JDP', '', '2026-06-15 10:36:26', NULL, 'active'),
(25, '2026-06-15', 'LOAN BY PRINCE', 'JDP', '', '2026-06-15 10:52:46', NULL, 'inactive'),
(26, '2026-06-15', 'NMDC TEMPLE', 'NAGARNAR JAGDALPUR', '', '2026-06-15 10:58:54', NULL, 'inactive');

-- --------------------------------------------------------

--
-- Table structure for table `staff_loans`
--

CREATE TABLE `staff_loans` (
  `id` int(11) NOT NULL,
  `entry_date` date DEFAULT NULL,
  `employee_id` int(11) NOT NULL,
  `loan_amount` varchar(150) NOT NULL,
  `loan_tenure` varchar(150) NOT NULL,
  `loan_last_date` date NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` enum('active','inactive','deleted') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `entry_date` date DEFAULT NULL,
  `firm_name` varchar(100) NOT NULL,
  `contact_person` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `phone_number` varchar(100) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` enum('active','inactive','deleted') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `entry_date`, `firm_name`, `contact_person`, `address`, `phone_number`, `email_address`, `remarks`, `created_at`, `updated_at`, `status`) VALUES
(1, '2025-12-11', 'test', 'testt', '', '9087654321', 'testta@gmail.com', '', '2025-12-11 08:56:11', NULL, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `entry_date` date DEFAULT NULL,
  `company_id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `cpassword` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `last_logged_in` varchar(100) DEFAULT NULL,
  `last_ip` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('active','inactive','deleted') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `entry_date`, `company_id`, `username`, `first_name`, `last_name`, `email`, `phone`, `email_verified_at`, `password`, `cpassword`, `address`, `city`, `state`, `profile_pic`, `remarks`, `remember_token`, `last_logged_in`, `last_ip`, `created_at`, `updated_at`, `status`) VALUES
(1, '2023-05-02', 1, 'admin', 'admin', 'am', 'admin@gmail.com', '965754654', NULL, 'e10adc3949ba59abbe56e057f20f883e', NULL, 'cvxdfs', 'dfsdf', 'dsfsdf', 'Screenshot_(4).png', NULL, NULL, '2026-06-15 11:08:38', '2405:201:3024:388c:5169:b2cf:ef53:6d62', '2022-12-29 14:35:19', '2025-07-04 13:38:39', 'active'),
(16, '2026-06-15', 0, 'dataoperator@gmail.com', 'Data', 'Operator', 'dataoperator@gmail.com', '9701900209', NULL, 'e10adc3949ba59abbe56e057f20f883e', 'e10adc3949ba59abbe56e057f20f883e', '', 'Jagdalpur', 'Chhattisgarh', NULL, NULL, NULL, '2026-06-15 10:51:46', '2405:201:301e:300c:3037:225e:478b:84d8', '2026-06-15 10:50:56', NULL, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 2),
(3, 1),
(4, 3),
(5, 4),
(9, 2),
(10, 5),
(11, 2),
(12, 5),
(13, 2),
(14, 6),
(15, 6),
(16, 6);

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `entry_date` date DEFAULT NULL,
  `vehicle_name` varchar(200) NOT NULL,
  `vehicle_no` varchar(100) NOT NULL,
  `vehicle_purchase_by` varchar(100) NOT NULL,
  `vehicle_emi` varchar(100) NOT NULL,
  `down_payment_amount` varchar(100) NOT NULL,
  `down_payment_by` varchar(100) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` enum('active','inactive','deleted') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `entry_date`, `vehicle_name`, `vehicle_no`, `vehicle_purchase_by`, `vehicle_emi`, `down_payment_amount`, `down_payment_by`, `remarks`, `created_at`, `updated_at`, `status`) VALUES
(1, '2024-08-12', 'TIPPER', 'JK5807', 'loan', '30000', '500000', 'S.K', 'GITTI', '2024-08-12 09:34:17', '2024-09-12 06:22:23', 'active'),
(2, '2024-09-12', 'AUTO', '..........', 'loan', '5500', '000', '0000000', '', '2024-09-12 06:26:02', NULL, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_expenses`
--

CREATE TABLE `vehicle_expenses` (
  `id` int(11) NOT NULL,
  `entry_date` date DEFAULT NULL,
  `vehicle_id` int(11) NOT NULL,
  `vehicle_no` varchar(100) NOT NULL,
  `particular` varchar(255) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `income` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` enum('active','inactive','deleted') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle_expenses`
--

INSERT INTO `vehicle_expenses` (`id`, `entry_date`, `vehicle_id`, `vehicle_no`, `particular`, `amount`, `income`, `remarks`, `created_at`, `updated_at`, `status`) VALUES
(1, '2025-12-11', 1, 'JK5807', 'yyyxxxx', '1', NULL, 'test', '2025-11-08 11:42:35', '2025-12-11 08:11:43', 'active'),
(2, '2025-12-11', 1, 'JK5807', 'test', '1200', NULL, '', '2025-12-11 08:08:19', NULL, 'active'),
(3, '2026-04-14', 1, 'JK5807', 'Diseal', '20000', NULL, '', '2026-04-14 08:08:57', NULL, 'active'),
(4, '2026-04-14', 1, 'JK5807', 'April EMI', '25000', NULL, 'hg kjg jkhg hj', '2026-04-14 08:28:30', NULL, 'active'),
(5, '2026-04-16', 1, 'JK5807', 'wew', '555', 667, '', '2026-04-16 05:33:51', '2026-04-16 05:37:12', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_running_km`
--

CREATE TABLE `vehicle_running_km` (
  `id` int(11) NOT NULL,
  `entry_date` date NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `vehicle_no` varchar(100) NOT NULL,
  `party_name` varchar(255) NOT NULL,
  `start_km` float NOT NULL DEFAULT 0,
  `end_km` float NOT NULL DEFAULT 0,
  `total_km` float NOT NULL DEFAULT 0,
  `amount` double NOT NULL DEFAULT 0,
  `diesel_amount` double NOT NULL DEFAULT 0,
  `particular` varchar(255) NOT NULL,
  `income` varchar(200) DEFAULT NULL,
  `balance` double NOT NULL DEFAULT 0,
  `remarks` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` enum('active','inactive','deleted') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle_running_km`
--

INSERT INTO `vehicle_running_km` (`id`, `entry_date`, `vehicle_id`, `vehicle_no`, `party_name`, `start_km`, `end_km`, `total_km`, `amount`, `diesel_amount`, `particular`, `income`, `balance`, `remarks`, `created_at`, `updated_at`, `status`) VALUES
(1, '2025-12-11', 1, 'JK5807', 'test', 5, 133, 128, 2000, 500, 'test', '1000', 1000, '', '2025-12-11 08:33:44', '2025-12-11 08:43:58', 'active'),
(2, '2026-04-14', 1, 'JK5807', 'Chandra Narayan', 0, 100, 100, 5000, 2500, 'Test', '1500', 1000, 'test', '2026-04-14 08:00:23', NULL, 'active'),
(3, '2026-04-14', 1, 'JK5807', 'Test', 0, 200, 200, 50000, 2000, 'Apr to Sep', '0', 0, '', '2026-04-14 08:07:20', NULL, 'active'),
(4, '2026-04-14', 1, 'JK5807', 'Ankit Bijapur', 0, 100, 100, 3000, 1000, 'April', '8000', 2000, 'h jkhg kjh gjhkg kjh gjhk', '2026-04-14 08:24:47', NULL, 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cc_account`
--
ALTER TABLE `cc_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `common_expenses`
--
ALTER TABLE `common_expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_entry`
--
ALTER TABLE `daily_entry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_main_types`
--
ALTER TABLE `expense_main_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_type`
--
ALTER TABLE `expense_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fdr`
--
ALTER TABLE `fdr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gst_bill`
--
ALTER TABLE `gst_bill`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_party`
--
ALTER TABLE `loan_party`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `market_loans`
--
ALTER TABLE `market_loans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `office_expenses`
--
ALTER TABLE `office_expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `office_staffs`
--
ALTER TABLE `office_staffs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pay_partner`
--
ALTER TABLE `pay_partner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `sites`
--
ALTER TABLE `sites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_loans`
--
ALTER TABLE `staff_loans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_expenses`
--
ALTER TABLE `vehicle_expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_running_km`
--
ALTER TABLE `vehicle_running_km`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cc_account`
--
ALTER TABLE `cc_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `common_expenses`
--
ALTER TABLE `common_expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `daily_entry`
--
ALTER TABLE `daily_entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `expense_main_types`
--
ALTER TABLE `expense_main_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `expense_type`
--
ALTER TABLE `expense_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `fdr`
--
ALTER TABLE `fdr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gst_bill`
--
ALTER TABLE `gst_bill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `loan_party`
--
ALTER TABLE `loan_party`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `market_loans`
--
ALTER TABLE `market_loans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `office_expenses`
--
ALTER TABLE `office_expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `office_staffs`
--
ALTER TABLE `office_staffs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pay_partner`
--
ALTER TABLE `pay_partner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sites`
--
ALTER TABLE `sites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `staff_loans`
--
ALTER TABLE `staff_loans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vehicle_expenses`
--
ALTER TABLE `vehicle_expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vehicle_running_km`
--
ALTER TABLE `vehicle_running_km`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
