-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 05, 2017 at 08:03 AM
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
  `check_date` date NOT NULL,
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

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_name`, `address`, `contact_no`, `area_id`, `record_id`) VALUES
(3, 'Paolo', '89 Jasmine Street San Isidro Village City of San Fernando Pampanga', '09177043079', 5, 16);

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

--
-- Dumping data for table `customer_checks`
--

INSERT INTO `customer_checks` (`cc_id`, `check_no`, `bank_id`, `check_date`, `amount`, `status`) VALUES
(1, '12361236', 0, '0000-00-00', '420.00', 5),
(2, '156326666', 5, '0000-00-00', '420.00', 5);

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

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`expense_id`, `expense_date`, `payee`, `payee_address`, `account_title_id`, `amount`, `payment_method`, `amount_paid`, `due_date`, `cc_id`, `record_id`) VALUES
(1, '0000-00-00', 'Paolo', 'SIV', 1, '1000000.00', 1, '0.00', '0000-00-00', -1, 10),
(2, '0000-00-00', 'Paolo', 'SIV', 1, '99999999.99', 1, '0.00', '0000-00-00', -1, 11),
(3, '0000-00-00', 'Paolo', '1254125', 3, '9600.00', 1, '0.00', '0000-00-00', -1, 12),
(4, '2017-04-16', 'Paolo', '1523', 3, '11888.00', 1, '0.00', '2017-04-16', -1, 13),
(5, '0000-00-00', '', '', 1, '80.00', 1, '80.00', '0000-00-00', -1, 17),
(6, '2017-04-16', '', '', 1, '80.00', 1, '80.00', '2017-04-16', -1, 18),
(7, '2017-04-16', '', '', 1, '90.00', 1, '90.00', '2017-04-16', -1, 19),
(8, '2017-04-16', 'Paolo', '', 1, '1.00', 1, '1.00', '2017-04-16', -1, 22),
(9, '2017-04-16', 'Paolo', '89 Jasmine Street San Isidro Village City of San Fernando Pampanga', 1, '10.00', 1, '10.00', '2017-04-16', -1, 23),
(10, '2017-04-16', 'Naila Nucup', 'Mexico', 3, '800.00', 1, '0.00', '2017-04-16', -1, 25),
(11, '2017-04-16', 'Paolo', '89 Jasmine Street San Isidro Village City of San Fernando Pampanga', 1, '100.00', 1, '100.00', '2017-04-16', -1, 26);

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

--
-- Dumping data for table `expense_items`
--

INSERT INTO `expense_items` (`ei_id`, `expense_id`, `particulars`, `amount`) VALUES
(1, 0, 'System', '1000000.00'),
(2, 2, 'System', '99999999.99'),
(3, 3, 'Rainier', '5000.00'),
(4, 3, 'Paolo', '4600.00'),
(5, 4, 'R123', '5049.00'),
(6, 4, 'P321', '6839.00'),
(7, 10, 'Something', '500.00'),
(8, 10, 'Hi there', '300.00'),
(9, 11, 'Discount for Sale Number 14', '100.00');

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
(17, 1, 15000, '10.00', '2017-04-16', 14),
(18, 1, -50, '10.00', '2017-04-16', 17),
(19, 1, -50, '10.00', '2017-04-16', 18),
(20, 1, -50, '10.00', '2017-04-16', 19),
(21, 1, -3, '10.00', '2017-04-16', 20),
(22, 1, -4, '10.00', '2017-04-16', 21),
(23, 1, -1, '10.00', '2017-04-16', 22),
(24, 1, -16, '10.00', '2017-04-16', 23),
(25, 1, -80, '10.00', '2017-04-16', 26),
(26, 1, 2, '10.00', '2017-04-16', 27),
(27, 1, 4, '10.00', '2017-04-16', 28);

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
(1, 'Coca cola 237mL', '6.00', '10.00', '10.00', 1, 1),
(2, 'Sprite 1L x24', '205.00', '300.00', '300.00', 1, 31),
(3, 'Royal 1L x24', '205.00', '300.00', '300.00', 1, 32),
(4, 'Coca cola 1L x24', '200.00', '305.00', '305.00', 1, 33),
(5, 'Coca cola 1L x24', '200.00', '305.00', '305.00', 1, 34),
(6, 'Coca cola 1L x24', '200.00', '305.00', '305.00', 1, 35),
(7, 'Coca cola 1L x24', '200.00', '305.00', '305.00', 1, 36),
(8, 'asdf', '0.00', '0.00', '0.00', 1, 37),
(9, 'Coke', '12.00', '33.00', '33.00', 1, 38);

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

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `payment_method`, `amount`, `payment_date`, `cc_id`) VALUES
(1, 1, '6000.00', '2017-04-16', -1),
(2, 2, '150.00', '2017-04-16', -1),
(3, 3, '420.00', '2017-04-16', 12361236),
(4, 3, '420.00', '2017-04-16', 156326666);

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
  `discount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_orders`
--

INSERT INTO `purchase_orders` (`po_id`, `supplier_id`, `po_date`, `total_amount`, `amount_paid`, `terms`, `due_date`, `payment_method`, `status`, `cc_id`, `record_id`, `discount`) VALUES
('0492', 1, '2017-04-16', '147000.00', '6000.00', NULL, '2017-04-18', 1, 2, NULL, 14, '3000.00');

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
(1, 492, 1, 15000, '10.00');

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
(1, 1, '2017-04-16 13:01:00', 0),
(2, 1, '2017-04-16 13:04:17', 0),
(3, 1, '2017-04-16 13:04:18', 0),
(4, 1, '2017-04-16 13:04:18', 0),
(5, 1, '2017-04-16 13:04:18', 0),
(6, 1, '2017-04-16 13:04:19', 0),
(7, 1, '2017-04-16 13:04:19', 0),
(8, 1, '2017-04-16 13:04:19', 0),
(9, 1, '2017-04-16 13:04:48', 0),
(10, 1, '2017-04-16 13:05:07', 0),
(11, 1, '2017-04-16 13:05:40', 0),
(12, 1, '2017-04-16 13:23:18', 0),
(13, 1, '2017-04-16 13:24:22', 0),
(14, 1, '2017-04-16 14:14:22', 0),
(15, 1, '2017-04-16 14:14:41', 0),
(16, 1, '2017-04-16 14:15:20', 0),
(17, 1, '2017-04-16 14:15:42', 0),
(18, 1, '2017-04-16 14:18:58', 0),
(19, 1, '2017-04-16 14:19:41', 0),
(20, 1, '2017-04-16 14:20:16', 0),
(21, 1, '2017-04-16 14:21:24', 0),
(22, 1, '2017-04-16 14:23:04', 0),
(23, 1, '2017-04-16 14:23:44', 0),
(24, 1, '2017-04-16 14:23:53', 0),
(25, 1, '2017-04-16 15:12:17', 0),
(26, 1, '2017-04-16 15:14:00', 0),
(27, 1, '2017-04-16 15:17:10', 0),
(28, 1, '2017-04-16 15:34:04', 0),
(29, 1, '2017-04-16 15:44:42', 0),
(30, 1, '2017-04-16 15:45:21', 0),
(31, 1, '2017-04-19 02:05:38', 0),
(32, 1, '2017-04-19 02:07:33', 0),
(33, 0, '2017-04-19 02:52:03', 0),
(34, 0, '2017-04-19 02:54:35', 0),
(35, 0, '2017-04-19 02:56:29', 0),
(36, 0, '2017-04-19 02:57:05', 0),
(37, 0, '2017-04-19 02:57:31', 0),
(38, 2, '2017-04-19 03:07:58', 0);

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

--
-- Dumping data for table `returns`
--

INSERT INTO `returns` (`return_id`, `return_date`, `customer_id`, `total_amount`) VALUES
(1, '2017-04-16', 3, '20.00'),
(2, '2017-04-16', 3, '40.00');

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

--
-- Dumping data for table `return_items`
--

INSERT INTO `return_items` (`ri_id`, `return_id`, `item_id`, `quantity`, `cost`) VALUES
(2, 1, 1, 2, 10),
(3, 2, 1, 4, 10);

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

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sale_id`, `customer_id`, `sale_date`, `total_amount`, `amount_paid`, `terms`, `status`, `payment_method`, `due_date`, `cc_id`, `record_id`, `discount`) VALUES
(6, 3, '2017-04-16', '420.00', '420.00', NULL, 8, 3, '2017-04-16', 156326666, 17, '80.00'),
(7, 3, '2017-04-16', '420.00', '420.00', NULL, 8, 3, '2017-04-16', 12361236, 18, '80.00'),
(8, 3, '2017-04-16', '410.00', '0.00', NULL, 1, NULL, '2017-04-16', NULL, 19, '90.00'),
(9, 3, '2017-04-16', '30.00', '0.00', NULL, 1, NULL, '2017-04-16', NULL, 20, '0.00'),
(10, 3, '2017-04-16', '40.00', '0.00', NULL, 1, NULL, '2017-04-16', NULL, 21, '0.00'),
(11, 3, '2017-04-16', '9.00', '0.00', NULL, 1, NULL, '2017-04-16', NULL, 22, '1.00'),
(12, 3, '2017-04-16', '150.00', '150.00', NULL, 8, 2, '2017-04-16', NULL, 23, '10.00'),
(13, 3, '2017-04-16', '700.00', '0.00', NULL, 1, NULL, '2017-04-16', NULL, 26, '100.00');

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

--
-- Dumping data for table `sale_items`
--

INSERT INTO `sale_items` (`si_id`, `sale_id`, `item_id`, `quantity`, `amount`) VALUES
(7, 7, 1, 50, '10.00'),
(8, 7, 1, 50, '10.00'),
(9, 9, 1, 50, '10.00'),
(10, 10, 1, 3, '10.00'),
(11, 11, 1, 4, '10.00'),
(12, 12, 1, 1, '10.00'),
(13, 13, 1, 16, '10.00'),
(14, 14, 1, 80, '10.00');

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
  MODIFY `cf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `collections`
--
ALTER TABLE `collections`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `company_checks`
--
ALTER TABLE `company_checks`
  MODIFY `cc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `customer_checks`
--
ALTER TABLE `customer_checks`
  MODIFY `cc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `expense_items`
--
ALTER TABLE `expense_items`
  MODIFY `ei_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `purchase_order_items`
--
ALTER TABLE `purchase_order_items`
  MODIFY `po_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `recording`
--
ALTER TABLE `recording`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `return_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `return_items`
--
ALTER TABLE `return_items`
  MODIFY `ri_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `si_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
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
