-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 28, 2017 at 04:51 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mbvaldez`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_titles`
--

CREATE TABLE `account_titles` (
  `account_title_id` int(11) NOT NULL,
  `account_name` varchar(50) NOT NULL,
  `segment` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_titles`
--

INSERT INTO `account_titles` (`account_title_id`, `account_name`, `segment`) VALUES
(1, 'Discount Expenses', 3),
(2, 'Utilities', 3),
(3, 'Other Expenses', 3);

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `area_id` int(11) NOT NULL,
  `area_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`area_id`, `area_name`) VALUES
(1, 'Minalin'),
(2, 'Sto Tomas'),
(3, 'Bacolor'),
(4, 'Del Pilar'),
(5, 'San Nicolas'),
(6, 'San Jose'),
(7, 'Juliana Subdivision'),
(8, 'Palengke (Luma)'),
(9, 'Palengke (Bago)'),
(10, 'Dolores'),
(11, 'San Felipe'),
(12, 'Sto Nino'),
(13, 'San Juan'),
(14, 'Sta Lucia');

-- --------------------------------------------------------

--
-- Table structure for table `banklist`
--

CREATE TABLE `banklist` (
  `bank_id` int(11) NOT NULL,
  `bank_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banklist`
--

INSERT INTO `banklist` (`bank_id`, `bank_name`) VALUES
(1, 'Al Amanah Islamic Investment Bank of the Philippines'),
(2, 'Asia United Bank Corporation'),
(3, 'Bank of Commerce'),
(4, 'Bank of the Philippine Islands'),
(5, 'BDO Unibank, Inc.'),
(6, 'China Banking Corporation'),
(7, 'Development Bank of the Philippines'),
(8, 'East West Banking Corporation'),
(9, 'Land Bank of the Philippines'),
(10, 'Metropolitan Bank and Trust Company (Metrobank)'),
(11, 'Philippine Bank of Communication'),
(12, 'Philippine National Bank'),
(13, 'Philippine Trust Company'),
(14, 'Philippine Veterans Bank'),
(15, 'Rizal Commercial Banking Corporation'),
(16, 'Robinsons Bank Corporation'),
(17, 'Security Bank Corporation'),
(18, 'Union Bank of the Philippines'),
(19, 'United Coconut Planters Bank');

-- --------------------------------------------------------

--
-- Table structure for table `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `account_number` varchar(20) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `branch` varchar(30) NOT NULL,
  `initial_balance` decimal(10,2) NOT NULL,
  `current_balance` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cashflow`
--

CREATE TABLE `cashflow` (
  `cf_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `particulars` varchar(100) NOT NULL,
  `cf_date` date NOT NULL,
  `category` int(11) NOT NULL,
  `record_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `collections`
--

CREATE TABLE `collections` (
  `payment_id` int(11) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL,
  `cc_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `company_checks`
--

CREATE TABLE `company_checks` (
  `cc_id` int(11) NOT NULL,
  `check_no` varchar(15) NOT NULL,
  `bank_account_id` varchar(20) NOT NULL,
  `check_date` date DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `contact_no` varchar(15) DEFAULT NULL,
  `area_id` int(11) NOT NULL,
  `record_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer_checks`
--

CREATE TABLE `customer_checks` (
  `cc_id` int(11) NOT NULL,
  `check_no` varchar(20) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `check_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(15) NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `type` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `date_hired` date NOT NULL,
  `date_terminated` date DEFAULT NULL,
  `status` int(11) NOT NULL,
  `remarks` int(11) NOT NULL,
  `record_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `expense_id` int(11) NOT NULL,
  `expense_date` date NOT NULL,
  `payee` varchar(100) NOT NULL,
  `payee_address` varchar(100) DEFAULT NULL,
  `account_title_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `due_date` date NOT NULL,
  `cc_id` int(11) NOT NULL,
  `record_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `expense_items`
--

CREATE TABLE `expense_items` (
  `ei_id` int(11) NOT NULL,
  `expense_id` int(11) NOT NULL,
  `particulars` varchar(200) NOT NULL,
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `inv_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `trans_date` date NOT NULL,
  `record_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`inv_id`, `item_id`, `quantity`, `cost`, `trans_date`, `record_id`) VALUES
(10, 1, 1, '108.00', '2017-06-27', 87);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `item_description` varchar(200) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `record_srp` decimal(10,2) NOT NULL,
  `display_srp` decimal(10,2) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `record_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `item_description`, `cost`, `record_srp`, `display_srp`, `supplier_id`, `record_id`) VALUES
(1, 'COKE 300ml x12', '103.00', '108.00', '108.00', 1, 1),
(2, 'SPRITE MISMO x12', '103.00', '108.00', '108.00', 1, 2),
(3, 'SPRITE 300ml x12', '103.00', '108.00', '108.00', 1, 3),
(4, 'ROYAL MISMO x12', '103.00', '108.00', '108.00', 1, 4),
(5, 'SPARKLE MISMO x12', '100.00', '108.00', '108.00', 1, 5),
(6, 'SARSI MISMO x12', '108.00', '100.00', '100.00', 1, 6),
(7, 'REAL LEAF MISMO x12', '91.00', '96.00', '96.00', 1, 7),
(8, 'POWERADE MISMO x12', '91.00', '96.00', '96.00', 1, 8),
(9, 'MINUTE MAID MISMO x12', '103.00', '108.00', '108.00', 1, 9),
(10, 'COKE 237ml x24', '100.00', '112.00', '112.00', 1, 10),
(11, 'ROYAL 237ml x24', '132.00', '144.00', '144.00', 1, 11),
(12, 'SPRITE 237ml x24', '132.00', '144.00', '144.00', 1, 12),
(13, 'RAINBOW 237ml x24', '132.00', '144.00', '144.00', 1, 13),
(14, 'POP COLA 240ml x24', '96.00', '108.00', '108.00', 1, 14),
(15, 'SPARKLE 240ml x24', '104.00', '116.00', '116.00', 1, 15),
(16, 'COKE 355ml x24', '180.00', '192.00', '192.00', 1, 16),
(17, 'ROYAL 355ml x24', '180.00', '192.00', '192.00', 1, 17),
(18, 'SPRITE 355ml x24', '180.00', '192.00', '192.00', 1, 18),
(19, 'COKE 500ml x24', '513.00', '525.00', '525.00', 1, 19),
(20, 'ROYAL 500ml x24', '513.00', '525.00', '525.00', 1, 20),
(21, 'SPRITE 500ml x24', '513.00', '525.00', '525.00', 1, 21),
(22, 'COKE 750ml x12', '156.00', '168.00', '168.00', 1, 22),
(23, 'ROYAL 750ml x12', '156.00', '168.00', '168.00', 1, 23),
(24, 'SPRITE 750ml x12', '156.00', '168.00', '168.00', 1, 24),
(25, 'RAINBOW 750ml x12', '156.00', '168.00', '168.00', 1, 25),
(26, 'COKE 750ml REIN x12', '106.00', '118.00', '118.00', 1, 26),
(27, 'ROYAL 750ml REIN x12', '106.00', '118.00', '118.00', 1, 27),
(28, 'SPRITE 750ml REIN x12', '106.00', '118.00', '118.00', 1, 28),
(29, 'MINUTE MAID 800ml PET x12', '242.00', '252.00', '252.00', 1, 29),
(30, 'SPARKLE 800ml x12', '132.00', '144.00', '144.00', 1, 30),
(31, 'COKE 1L x12', '242.00', '254.00', '254.00', 1, 31),
(32, 'ROYAL 1L x12', '242.00', '254.00', '254.00', 1, 32),
(33, 'SPRITE 1L x12', '242.00', '254.00', '254.00', 1, 33),
(34, 'COKE 1L REIN x12', '192.00', '204.00', '204.00', 1, 34),
(35, 'ROYAL 1L REIN x12', '192.00', '204.00', '204.00', 1, 35),
(36, 'SPRITE 1L REIN x12', '192.00', '204.00', '204.00', 1, 36),
(37, 'COKE 1.5L PET x12', '510.00', '522.00', '522.00', 1, 37),
(38, 'COKE LIGHT 1.5L PET x12', '510.00', '522.00', '522.00', 1, 38),
(39, 'ROYAL 1.5L PET x12', '510.00', '522.00', '522.00', 1, 39),
(40, 'COKE ZERO 1.5L PET x12', '510.00', '522.00', '522.00', 1, 40),
(41, 'SPRITE 1.5L PET x12', '510.00', '522.00', '522.00', 1, 41),
(42, 'COKE 1.75L PET x12', '510.00', '522.00', '522.00', 1, 42),
(43, 'ROYAL 1.75L PET x12', '510.00', '522.00', '522.00', 1, 43),
(44, 'SPRITE 1.75L PET x12', '510.00', '522.00', '522.00', 1, 44),
(45, 'COKE 330ML CANS x24', '480.00', '492.00', '492.00', 1, 45),
(46, 'COKE LIGHT 330ML CANS x24', '498.00', '510.00', '510.00', 1, 46),
(47, 'ROYAL 330ML CANS x24', '480.00', '492.00', '492.00', 1, 47),
(48, 'COKE ZERO 330ML CANS x24', '480.00', '492.00', '492.00', 1, 48),
(49, 'SPRITE 330ML CANS x24', '480.00', '492.00', '492.00', 1, 49),
(50, 'REAL LEAF HONEY APPLE 480ML x24', '418.00', '430.00', '430.00', 1, 50),
(51, 'REAL LEAF HONEY LEMON 480ML x24', '418.00', '430.00', '430.00', 1, 51),
(52, 'REAL LEAF LEMON ICE 480ML x24', '418.00', '430.00', '430.00', 1, 52),
(53, 'REAL LEAF LYCHEE 480ML x24', '418.00', '430.00', '430.00', 1, 53),
(54, 'REAL LEAF CALAMANSI 480ML x24', '418.00', '430.00', '430.00', 1, 54),
(55, 'POWERADE MINT BLAST 500ML', '436.00', '448.00', '448.00', 1, 55),
(56, 'WILKINS 330ML x30', '228.00', '240.00', '240.00', 1, 56),
(57, 'WILKINS PURE 330ML x30', '198.00', '210.00', '210.00', 1, 57),
(58, 'WILKINS PURE 500ML x24', '238.00', '250.00', '250.00', 1, 58),
(59, 'WILKINS 500ML x24', '353.00', '365.00', '365.00', 1, 59),
(60, 'WILKINS PURE 1L x12', '228.00', '240.00', '240.00', 1, 60),
(61, 'WILKINS 1L x12', '268.00', '280.00', '280.00', 1, 61),
(62, 'WILKINS 4L x4', '221.00', '233.00', '233.00', 1, 62),
(63, 'WILKINS 6L x3', '218.00', '230.00', '230.00', 1, 63),
(64, ' WILKINS 5G ', '138.00', '150.00', '150.00', 1, 64),
(65, 'SPRITE 1.75L PET PROMO X6', '255.00', '261.00', '261.00', 1, 65),
(66, 'ROYAL 1.75L PET PROMO X6', '255.00', '261.00', '261.00', 1, 66),
(67, 'COKE 1.75L PET PROMO X6', '255.00', '261.00', '261.00', 1, 67),
(68, 'COKE 1.75L PET PROMO X4', '170.00', '174.00', '174.00', 1, 68),
(69, 'ROYAL 1.75L PET PROMO x4', '170.00', '174.00', '174.00', 1, 69),
(70, 'SPRITE 1.75L PET PROMO X4', '170.00', '174.00', '174.00', 1, 70),
(71, 'ROYAL 1.75L PET PROMO X2', '86.00', '87.00', '87.00', 1, 71),
(72, 'SPRITE 1.75L PET PROMO x2', '86.00', '87.00', '87.00', 1, 72),
(73, 'COKE 1.75L PET PROMO X2', '86.00', '87.00', '87.00', 1, 73),
(74, 'COKE 2L x8', '384.00', '396.00', '396.00', 1, 74),
(75, 'MINUTE MAID PULPY 330 PET x24', '506.00', '518.00', '518.00', 1, 75),
(76, 'EIGHT O CLOCK ORANGE30Gx12', '100.60', '101.80', '101.80', 1, 76),
(77, 'EIGHT O CLOCK PINEAPPLE30GX12', '100.60', '101.80', '101.80', 1, 77),
(78, 'WILKINS APPLE x12', '91.00', '96.00', '96.00', 1, 78),
(79, 'WILKINS ORANGE x12', '91.00', '96.00', '96.00', 1, 79),
(80, 'WILKINS POMELO x12', '91.00', '96.00', '96.00', 1, 80),
(81, 'WILKINS POMELO250x12 COKE300x48', '420.00', '432.00', '432.00', 1, 81),
(82, 'WILKINS ORANGE250x12 COKE300x48', '420.00', '432.00', '432.00', 1, 82),
(83, 'WILKINS APPLE250x12 COKE300x48', '420.00', '432.00', '432.00', 1, 83),
(84, 'WILKINS POMELO250x12 WILKINSPURE330x30', '198.00', '210.00', '210.00', 1, 84),
(85, 'WILKINS ORANGE250x12 WILKINSPURE330x30', '198.00', '210.00', '210.00', 1, 85),
(86, 'WILKINS APPLE250x12 WILKINSPURE330x30', '198.00', '210.00', '210.00', 1, 86);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL,
  `cc_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `position_id` int(11) NOT NULL,
  `position_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `po_id` varchar(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `po_date` date NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `terms` varchar(15) DEFAULT NULL,
  `due_date` date NOT NULL,
  `payment_method` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `cc_id` int(11) DEFAULT NULL,
  `record_id` int(11) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `shipment_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_orders`
--

INSERT INTO `purchase_orders` (`po_id`, `supplier_id`, `po_date`, `total_amount`, `amount_paid`, `terms`, `due_date`, `payment_method`, `status`, `cc_id`, `record_id`, `discount`, `shipment_no`) VALUES
('101', 1, '2017-06-27', '108.00', '0.00', NULL, '2017-06-29', NULL, 1, NULL, 87, '0.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_items`
--

CREATE TABLE `purchase_order_items` (
  `po_item_id` int(11) NOT NULL,
  `po_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `cost` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_order_items`
--

INSERT INTO `purchase_order_items` (`po_item_id`, `po_id`, `item_id`, `quantity`, `cost`) VALUES
(2, 101, 1, 1, '108.00');

-- --------------------------------------------------------

--
-- Table structure for table `recording`
--

CREATE TABLE `recording` (
  `record_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `record_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `device` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `recording`
--

INSERT INTO `recording` (`record_id`, `user_id`, `record_date`, `device`) VALUES
(1, 1, '2017-06-14 22:35:31', 0),
(2, 1, '2017-06-14 22:35:43', 0),
(3, 1, '2017-06-14 22:36:32', 0),
(4, 1, '2017-06-14 22:37:31', 0),
(5, 1, '2017-06-14 22:37:51', 0),
(6, 1, '2017-06-14 22:37:57', 0),
(7, 1, '2017-06-14 22:38:06', 0),
(8, 1, '2017-06-14 22:38:16', 0),
(9, 1, '2017-06-14 22:38:24', 0),
(10, 1, '2017-06-14 22:46:08', 0),
(11, 1, '2017-06-14 22:46:27', 0),
(12, 1, '2017-06-14 22:46:43', 0),
(13, 1, '2017-06-14 22:46:51', 0),
(14, 1, '2017-06-14 22:47:03', 0),
(15, 1, '2017-06-14 22:47:08', 0),
(16, 1, '2017-06-14 22:47:19', 0),
(17, 1, '2017-06-14 22:47:29', 0),
(18, 1, '2017-06-14 22:47:35', 0),
(19, 1, '2017-06-14 22:47:48', 0),
(20, 1, '2017-06-14 22:47:54', 0),
(21, 1, '2017-06-14 22:48:02', 0),
(22, 1, '2017-06-14 22:48:19', 0),
(23, 1, '2017-06-14 22:48:27', 0),
(24, 1, '2017-06-14 22:48:33', 0),
(25, 1, '2017-06-14 22:48:42', 0),
(26, 1, '2017-06-14 22:48:52', 0),
(27, 1, '2017-06-14 22:48:58', 0),
(28, 1, '2017-06-14 22:49:04', 0),
(29, 1, '2017-06-14 22:49:13', 0),
(30, 1, '2017-06-14 22:49:22', 0),
(31, 1, '2017-06-14 22:49:32', 0),
(32, 1, '2017-06-14 22:49:51', 0),
(33, 1, '2017-06-14 22:49:57', 0),
(34, 1, '2017-06-14 22:50:06', 0),
(35, 1, '2017-06-14 22:50:16', 0),
(36, 1, '2017-06-14 22:50:24', 0),
(37, 1, '2017-06-14 22:50:34', 0),
(38, 1, '2017-06-14 22:50:46', 0),
(39, 1, '2017-06-14 22:50:53', 0),
(40, 1, '2017-06-14 22:51:08', 0),
(41, 1, '2017-06-14 22:51:16', 0),
(42, 1, '2017-06-14 22:51:21', 0),
(43, 1, '2017-06-14 22:51:28', 0),
(44, 1, '2017-06-14 22:51:35', 0),
(45, 1, '2017-06-14 22:51:44', 0),
(46, 1, '2017-06-14 22:51:52', 0),
(47, 1, '2017-06-14 22:51:59', 0),
(48, 1, '2017-06-14 22:52:06', 0),
(49, 1, '2017-06-14 22:52:15', 0),
(50, 1, '2017-06-14 22:52:27', 0),
(51, 1, '2017-06-14 22:52:33', 0),
(52, 1, '2017-06-14 22:52:40', 0),
(53, 1, '2017-06-14 22:52:47', 0),
(54, 1, '2017-06-14 22:52:54', 0),
(55, 1, '2017-06-14 22:53:02', 0),
(56, 1, '2017-06-14 22:53:09', 0),
(57, 1, '2017-06-14 22:53:19', 0),
(58, 1, '2017-06-14 22:53:27', 0),
(59, 1, '2017-06-14 22:53:35', 0),
(60, 1, '2017-06-14 22:53:47', 0),
(61, 1, '2017-06-14 22:53:56', 0),
(62, 1, '2017-06-14 22:54:10', 0),
(63, 1, '2017-06-14 22:54:17', 0),
(64, 1, '2017-06-14 22:54:25', 0),
(65, 1, '2017-06-14 22:54:33', 0),
(66, 1, '2017-06-14 22:54:40', 0),
(67, 1, '2017-06-14 22:54:47', 0),
(68, 1, '2017-06-14 22:54:56', 0),
(69, 1, '2017-06-14 22:55:03', 0),
(70, 1, '2017-06-14 22:55:15', 0),
(71, 1, '2017-06-14 22:55:24', 0),
(72, 1, '2017-06-14 22:55:30', 0),
(73, 1, '2017-06-14 22:55:39', 0),
(74, 1, '2017-06-14 22:56:15', 0),
(75, 1, '2017-06-14 22:56:23', 0),
(76, 1, '2017-06-14 22:56:38', 0),
(77, 1, '2017-06-14 22:56:48', 0),
(78, 1, '2017-06-14 22:57:02', 0),
(79, 1, '2017-06-14 22:57:17', 0),
(80, 1, '2017-06-14 22:57:25', 0),
(81, 1, '2017-06-14 22:57:33', 0),
(82, 1, '2017-06-14 22:57:41', 0),
(83, 1, '2017-06-14 22:57:48', 0),
(84, 1, '2017-06-14 22:57:57', 0),
(85, 1, '2017-06-14 22:58:08', 0),
(86, 1, '2017-06-14 22:58:16', 0),
(87, 1, '2017-06-27 16:20:13', 0);

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `return_id` int(11) NOT NULL,
  `return_date` date NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `return_empty`
--

CREATE TABLE `return_empty` (
  `empty_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `num_bottle` int(11) NOT NULL,
  `num_case` int(11) NOT NULL,
  `return_date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `return_items`
--

CREATE TABLE `return_items` (
  `ri_id` int(11) NOT NULL,
  `return_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `cost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sale_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `sale_date` date NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL DEFAULT '0.00',
  `terms` varchar(40) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `payment_method` int(11) DEFAULT NULL,
  `due_date` date NOT NULL,
  `cc_id` int(11) DEFAULT NULL,
  `record_id` int(11) NOT NULL,
  `discount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `si_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `status_code` int(11) NOT NULL,
  `status_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`status_code`, `status_name`) VALUES
(1, 'Unpaid'),
(2, 'Partially Paid'),
(3, 'Fully Paid'),
(4, 'Cancelled'),
(5, 'Not yet encashed'),
(6, 'Encashed'),
(7, 'Uncollected'),
(8, 'Fully Collected'),
(9, 'Partially Collected');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(100) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `record_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`supplier_id`, `supplier_name`, `address`, `contact_number`, `record_id`) VALUES
(1, 'Coca Cola', 'San Fernando', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `last_login` date DEFAULT NULL,
  `access_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `last_login`, `access_level`) VALUES
(1, 'rpgpunzalan', 'rainierpaolo', NULL, 9),
(2, 'user', 'user', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_titles`
--
ALTER TABLE `account_titles`
  ADD PRIMARY KEY (`account_title_id`);

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`area_id`);

--
-- Indexes for table `banklist`
--
ALTER TABLE `banklist`
  ADD PRIMARY KEY (`bank_id`);

--
-- Indexes for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`account_number`);

--
-- Indexes for table `cashflow`
--
ALTER TABLE `cashflow`
  ADD PRIMARY KEY (`cf_id`);

--
-- Indexes for table `collections`
--
ALTER TABLE `collections`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `company_checks`
--
ALTER TABLE `company_checks`
  ADD PRIMARY KEY (`cc_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `customer_checks`
--
ALTER TABLE `customer_checks`
  ADD PRIMARY KEY (`cc_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expense_id`);

--
-- Indexes for table `expense_items`
--
ALTER TABLE `expense_items`
  ADD PRIMARY KEY (`ei_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`inv_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`position_id`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`po_id`);

--
-- Indexes for table `purchase_order_items`
--
ALTER TABLE `purchase_order_items`
  ADD PRIMARY KEY (`po_item_id`);

--
-- Indexes for table `recording`
--
ALTER TABLE `recording`
  ADD PRIMARY KEY (`record_id`);

--
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`return_id`);

--
-- Indexes for table `return_empty`
--
ALTER TABLE `return_empty`
  ADD PRIMARY KEY (`empty_id`);

--
-- Indexes for table `return_items`
--
ALTER TABLE `return_items`
  ADD PRIMARY KEY (`ri_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sale_id`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`si_id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`status_code`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_titles`
--
ALTER TABLE `account_titles`
  MODIFY `account_title_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `area_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `banklist`
--
ALTER TABLE `banklist`
  MODIFY `bank_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `cashflow`
--
ALTER TABLE `cashflow`
  MODIFY `cf_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `collections`
--
ALTER TABLE `collections`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `company_checks`
--
ALTER TABLE `company_checks`
  MODIFY `cc_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customer_checks`
--
ALTER TABLE `customer_checks`
  MODIFY `cc_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `expense_items`
--
ALTER TABLE `expense_items`
  MODIFY `ei_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;
--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `purchase_order_items`
--
ALTER TABLE `purchase_order_items`
  MODIFY `po_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `recording`
--
ALTER TABLE `recording`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;
--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `return_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `return_empty`
--
ALTER TABLE `return_empty`
  MODIFY `empty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `return_items`
--
ALTER TABLE `return_items`
  MODIFY `ri_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `si_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `status_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
