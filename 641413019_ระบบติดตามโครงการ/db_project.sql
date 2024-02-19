-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 12, 2023 at 05:21 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` varchar(4) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `sub_district` varchar(50) DEFAULT NULL,
  `district` varchar(50) DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL,
  `postal_code` varchar(5) DEFAULT NULL,
  `phone_number` varchar(10) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `void` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `first_name`, `last_name`, `address`, `sub_district`, `district`, `province`, `postal_code`, `phone_number`, `email`, `void`) VALUES
('0001', 'กัญญาพัชญ์', 'อุดม', '555', 'กรุงเทพ', 'กรุงเทพ', 'กรุงเทพ', '57144', '145464645', 'AAA@gmail', 0);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `employee_id` varchar(4) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `sub_district` varchar(50) DEFAULT NULL,
  `district` varchar(50) DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL,
  `postal_code` varchar(5) NOT NULL,
  `phone_number` varchar(10) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `job_title` varchar(50) DEFAULT NULL,
  `void` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employee_id`, `first_name`, `last_name`, `address`, `sub_district`, `district`, `province`, `postal_code`, `phone_number`, `email`, `start_date`, `password`, `job_title`, `void`) VALUES
('0001', 'ณัฐดนัย', 'วงค์ษา', '282', 'แม่สรวย', 'แม่สรวย', 'เชียงราย', '57180', '096xxxxxxx', '641413019@crru.ac.th', '2023-10-12', 'b58c50e209762c24adb9f29daffe249c', 'CEO', 0);

-- --------------------------------------------------------

--
-- Table structure for table `projcost_desc`
--

CREATE TABLE `projcost_desc` (
  `doc_number` varchar(7) NOT NULL,
  `product_id` varchar(4) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price_per_unit` float(10,2) DEFAULT NULL,
  `Total_cost` float(10,2) DEFAULT NULL,
  `void` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projcost_desc`
--

INSERT INTO `projcost_desc` (`doc_number`, `product_id`, `quantity`, `price_per_unit`, `Total_cost`, `void`) VALUES
('2310001', '0001', 3, 10.00, 30.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `projcost_hd`
--

CREATE TABLE `projcost_hd` (
  `doc_number` varchar(7) NOT NULL,
  `record_date` date DEFAULT NULL,
  `receipt_number` int(11) DEFAULT NULL,
  `receipt_date` date DEFAULT NULL,
  `project_id` varchar(4) DEFAULT NULL,
  `Total_cost` float(10,2) DEFAULT NULL,
  `status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projcost_hd`
--

INSERT INTO `projcost_hd` (`doc_number`, `record_date`, `receipt_number`, `receipt_date`, `project_id`, `Total_cost`, `status`) VALUES
('2310001', '2023-10-12', 111111111, '2023-10-14', '0001', 30.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `project_id` varchar(4) NOT NULL,
  `project_name` varchar(100) DEFAULT NULL,
  `customer_id` varchar(4) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `project_value` decimal(12,2) DEFAULT NULL,
  `employee_id` varchar(4) NOT NULL,
  `project_status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`project_id`, `project_name`, `customer_id`, `start_date`, `end_date`, `project_value`, `employee_id`, `project_status`) VALUES
('0001', 'สร้างหุ่น', '0001', '2023-10-12', '2023-10-15', '200000.00', '0001', 2);

-- --------------------------------------------------------

--
-- Table structure for table `project_close`
--

CREATE TABLE `project_close` (
  `doc_number` varchar(7) NOT NULL,
  `closing_date` date DEFAULT NULL,
  `project_id` varchar(4) DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `expenses` decimal(10,2) DEFAULT NULL,
  `employee_id` varchar(4) DEFAULT NULL,
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_close`
--

INSERT INTO `project_close` (`doc_number`, `closing_date`, `project_id`, `cost`, `expenses`, `employee_id`, `comment`) VALUES
('2310001', '2023-10-12', '0001', '111111.00', '1111.00', '0001', 'ปิด');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `product_id` varchar(4) NOT NULL,
  `product_name` varchar(50) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `price_per_unit` float DEFAULT NULL,
  `void` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`product_id`, `product_name`, `unit`, `price_per_unit`, `void`) VALUES
('0001', 'ดินสอ', 'เล่ม', 10, 0),
('0002', 'ไม้บรรทัด', 'ชิ้น', 50, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `projcost_desc`
--
ALTER TABLE `projcost_desc`
  ADD PRIMARY KEY (`doc_number`);

--
-- Indexes for table `projcost_hd`
--
ALTER TABLE `projcost_hd`
  ADD PRIMARY KEY (`doc_number`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `project_close`
--
ALTER TABLE `project_close`
  ADD PRIMARY KEY (`doc_number`),
  ADD KEY `fk_employee_code` (`employee_id`),
  ADD KEY `project_code` (`project_id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`product_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `fk_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
  ADD CONSTRAINT `project_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
