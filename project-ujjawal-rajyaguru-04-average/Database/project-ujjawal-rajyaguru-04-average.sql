-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2023 at 06:50 AM
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
-- Database: `project-nikunj-parmar-04-good`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `password` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `email`, `status`, `password`, `created_at`, `updated_at`) VALUES
(1, 'ujjawal', 'ujjawal@gmail.com', 1, 'ujju', '2023-03-30 08:30:11', NULL),
(2, 'ujju2', 'ujju2@gmail.com', 1, 'ujjawal', '2023-03-30 08:30:11', '2023-03-30 02:18:30'),
(10, 'vikram', 'vikram@gmail.com', 1, 'vikram', '2023-03-30 10:01:32', '2023-03-30 10:02:17'),
(11, 'vikram', 'viku@gmail.com', 2, 'viku', '2023-03-30 01:54:04', '2023-03-30 01:55:39');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `parent_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `path` varchar(50) NOT NULL,
  `status` enum('1','2') NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `parent_id`, `name`, `path`, `status`, `description`, `created_at`, `updated_at`) VALUES
(1, 0, 'Root', '1', '1', '', '2023-04-03 09:51:40', '0000-00-00 00:00:00'),
(2, 1, 'Bedrooms', '1=2', '1', '', '2023-04-03 09:51:55', '2023-04-03 09:56:35'),
(3, 1, 'Living Rooms', '1=3', '1', '', '2023-04-03 09:53:05', '0000-00-00 00:00:00'),
(4, 2, 'Beds', '1=2=4', '1', '', '2023-04-03 09:53:29', '0000-00-00 00:00:00'),
(5, 2, 'Dessers', '1=2=5', '2', '', '2023-04-03 09:53:43', '0000-00-00 00:00:00'),
(6, 4, 'Panel Beds', '1=2=4=6', '1', '', '2023-04-03 09:53:57', '2023-04-03 09:56:50'),
(7, 3, 'Sofas', '1=3=7', '1', '', '2023-04-03 09:54:10', '0000-00-00 00:00:00'),
(8, 3, 'Tables', '1=3=8', '1', '', '2023-04-03 09:54:34', '0000-00-00 00:00:00'),
(9, 3, 'Loveseats', '1=3=9', '1', '', '2023-04-03 09:54:51', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `mobile` bigint(20) NOT NULL,
  `status` enum('1','2') NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `first_name`, `last_name`, `email`, `gender`, `mobile`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Charmi', 'Rajyaguru', 'charmi@gmail.com', 'Female',7990, '1', '2023-02-13 08:53:38', '2023-03-27 02:42:47'),
(2, 'Ujaval', 'Rajguru', 'rajguru@gmail.com', 'Male', 929193, '1', '2023-02-13 08:53:38', '2023-02-13 08:53:38'),
(3, 'Admin', 'test', 'abcd@gmail.com', 'Female', 1234567890, '2', '2023-02-13 08:53:38', '2023-02-13 08:53:38'),
(4, 'test', 'test4', 'test4@gmail.com', 'Male', 2345678910, '2', '2023-02-14 11:36:32', '2023-03-27 02:43:04');

-- --------------------------------------------------------

--
-- Table structure for table `customer_address`
--

CREATE TABLE `customer_address` (
  `address_id` int(20) NOT NULL,
  `customer_id` int(20) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `zipcode` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_address`
--

INSERT INTO `customer_address` (`address_id`, `customer_id`, `address`, `city`, `state`, `country`, `zipcode`) VALUES
(1, 1, 'Gulista', 'Bhavnagar', 'guja', 'India', '987654'),
(2, 2, 'Gulista2', 'Bhavnagar', 'gujarat', 'India', '222222'),
(3, 3, 'Gulista3', 'Bhavnagar', 'gujarat', 'India', '333333'),
(4, 4, 'Gulista4', 'Bhavnagar', 'gujarat', 'India', '876');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('1','2') NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Ujju', '1', '2023-02-13 08:53:38', '2023-02-13 08:53:38'),
(2, 'Ujju2', '2', '2023-02-13 08:53:38', '2023-03-06 10:25:44'),
(3, 'Ujju', '1', '2023-02-13 08:53:38', '2023-02-13 08:53:38'),
(4, 'Ujju4', '1', '2023-02-13 08:53:38', '2023-02-13 08:53:38'),
(5, 'Ujju5', '2', '2023-02-13 08:53:38', '2023-03-25 05:46:29');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sku` varchar(20) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `status` enum('1','2') NOT NULL,
  `color` varchar(100) NOT NULL,
  `material` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `name`, `sku`, `cost`, `price`, `description`, `status`, `color`, `material`, `created_at`, `updated_at`) VALUES
(1, 'Nokia 1100', '100', '1100.00', '1100.00', 'Good Product', '1', 'grey', 'hgj', '2023-02-13 08:53:38', '2023-03-10 02:41:38'),
(2, 'Iphone', '50', '600.00', '1000.00', 'Abc', '1', 'black', 'good', '2023-02-16 12:38:14', '2023-03-10 09:28:43'),
(3, 'OnePlus', '999', '546.00', '789.00', 'Product', '1', 'black', 'sgd', '2023-02-17 10:04:14', '2023-03-30 08:07:26'),
(4, 'asa', '10', '1000.00', '1000.00', 'good', '1', 'lll', 'jfjh', '2023-02-25 12:11:22', '2023-04-02 05:37:44');

-- --------------------------------------------------------

--
-- Table structure for table `product_media`
--

CREATE TABLE `product_media` (
  `product_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `thumbnail` tinyint(4) DEFAULT NULL,
  `small` tinyint(4) DEFAULT NULL,
  `base` tinyint(4) DEFAULT NULL,
  `gallery` tinyint(4) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_media`
--

INSERT INTO `product_media` (`product_id`, `image_id`, `name`, `image`, `thumbnail`, `small`, `base`, `gallery`, `created_at`) VALUES
(1, 0, 'bed', '1.webp', 1, 1, 0, 1, '2023-04-01 04:10:20'),
(1, 2, 'table', '2.webp', 1, 0, 0, 1, '2023-03-16 01:45:47'),
(1, 3, 'chair', '3.png', 0, 1, 1, 1, '2023-03-16 01:45:47'),
(1, 4, 'test', '4.webp', 0, 0, 0, 0, '2023-03-14 10:23:03'),
(2, 5, 'bed', '5.webp', 0, 1, 0, 1, '2023-03-13 11:24:52'),
(2, 6, 'office', '6.webp', 1, 0, 0, 1, '2023-03-13 11:24:52'),
(2, 7, 'chair', '7.webp', 0, 0, 1, 1, '2023-03-13 11:24:52'),
(3, 8, 'niiii', '8.webp', 1, 0, 1, 1, '2023-03-08 06:55:59'),
(3, 9, 'asd', '9.webp', 0, 1, 0, 1, '2023-03-08 06:55:59'),
(4, 10, 'test2', '10.webp', 0, 0, 0, 0, '2023-04-01 08:22:22'),
(4, 11, 'dinning', '11.webp', 1, 1, 0, 1, '2023-04-03 09:39:51'),
(4, 12, 'drawwer', '12.webp', 0, 0, 1, 1, '2023-04-03 09:39:51'),
(4, 14, 'yfyfh', '14.png', 0, 0, 0, 0, '2023-03-28 02:48:09');

-- --------------------------------------------------------

--
-- Table structure for table `salesman`
--

CREATE TABLE `salesman` (
  `salesman_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `mobile` bigint(20) NOT NULL,
  `status` enum('1','2') NOT NULL,
  `company` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salesman`
--

INSERT INTO `salesman` (`salesman_id`, `first_name`, `last_name`, `email`, `gender`, `mobile`, `status`, `company`, `created_at`, `updated_at`) VALUES
(1, 'ujju', 'rajguru', 'ujj@gmail.com', 'Male', 898989898, '1', 'cybercom', '2023-02-13 08:53:38', '2023-03-14 10:22:19'),
(2, 'sales2', 'sales2', 'sale@gmail.com', 'Male', 2000000, '2', 'cybercom', '2023-02-13 08:53:38', '2023-03-01 11:20:54'),
(3, 'vik', 'parmar', 'viko@gmail.com', 'Male', 555555, '1', 'cybercom', '2023-02-17 02:14:38', NULL),
(4, 'viku', 'parmar', 'vikram@gm.com', 'Female', 987654321, '1', 'abcybercomc', '2023-02-21 03:38:16', '2023-03-07 10:30:13'),
(5, 'vikram', 'Parmar', 'vikram@gmail.com', 'Male', 88988898998, '1', 'cybercom', '2023-03-06 11:09:11', '2023-03-24 12:46:33');

-- --------------------------------------------------------

--
-- Table structure for table `salesman_address`
--

CREATE TABLE `salesman_address` (
  `salesman_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `zipcode` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salesman_address`
--

INSERT INTO `salesman_address` (`salesman_id`, `address_id`, `address`, `city`, `state`, `country`, `zipcode`) VALUES
(1, 1, 'test', 'testCity', 'testState', 'India', 22222),
(2, 2, 'test2', 'testCity2', 'test2State', 'India', 222222),
(3, 3, 'test3', 'testCity3', 'Gujarat', 'India', 333333),
(4, 4, 'test4', 'testCity6', 'Gujarat', 'India', 364710),
(5, 5, 'tets5', 'testCity5', 'Gujarat', 'India', 123456);

-- --------------------------------------------------------

--
-- Table structure for table `salesman_price`
--

CREATE TABLE `salesman_price` (
  `entity_id` int(11) NOT NULL,
  `salesman_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `salesman_price` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salesman_price`
--

INSERT INTO `salesman_price` (`entity_id`, `salesman_id`, `product_id`, `salesman_price`) VALUES
(1, 1, 1, 100),
(2, 1, 2, 200),
(3, 1, 3, 300),
(4, 1, 4, 400),
(5, 2, 1, 500),
(6, 2, 2, 600),
(7, 2, 3, 700),
(8, 2, 4, 800),
(9, 3, 1, 900),
(10, 3, 2, 150),
(11, 3, 3, 750),
(12, 3, 4, 999),
(13, 4, 1, 600),
(14, 4, 2, 800),
(15, 4, 3, 600),
(16, 4, 4, 790),
(17, 5, 1, 550),
(18, 5, 2, 650),
(19, 5, 3, 400),
(20, 5, 4, 3000);

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
--

CREATE TABLE `shipping` (
  `shipping_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` decimal(20,0) NOT NULL,
  `status` enum('1','2') NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shipping`
--

INSERT INTO `shipping` (`shipping_id`, `name`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 'test', '100', '1', '2023-03-27 05:35:13', NULL),
(2, 'test2', '1000', '1', '2023-03-27 05:35:26', NULL),
(3, 'test3', '2000', '1', '2023-03-27 05:35:37', NULL),
(5, 'test4', '3000', '1', '2023-03-27 06:06:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `vendor_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `mobile` bigint(20) NOT NULL,
  `status` enum('1','2') NOT NULL,
  `company` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`vendor_id`, `first_name`, `last_name`, `email`, `gender`, `mobile`, `status`, `company`, `created_at`, `updated_at`) VALUES
(1, 'test1', 'test12', 'test1@gmail.com', 'Male', 454465465, '1', 'test.co.in', '2023-02-13 08:53:38', '2023-02-13 08:53:38'),
(2, 'test2', 'test21', 'test2@gmail.com', 'Female', 2222222, '2', 'test2.co.in', '2023-02-14 10:39:23', '2023-02-14 10:58:01'),
(3, 'test3', 'test32', 'test3@test.in', 'Female', 123, '2', 'test3.co.n', '2023-02-13 08:53:38', '2023-03-14 10:09:49');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_address`
--

CREATE TABLE `vendor_address` (
  `address_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `zipcode` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendor_address`
--

INSERT INTO `vendor_address` (`address_id`, `vendor_id`, `address`, `city`, `state`, `country`, `zipcode`) VALUES
(1, 1, 'test', 'testCity', 'State', 'India', 121212),
(2, 2, 'test', 'testCity2', 'State2', 'testCountry2', 222222),
(3, 3, 'test', 'test', 'Gujarat', 'Indian', 77777);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `customer_address`
--
ALTER TABLE `customer_address`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `customer_address_ibfk_1` (`customer_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_media`
--
ALTER TABLE `product_media`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `product_media_ibfk_1` (`product_id`);

--
-- Indexes for table `salesman`
--
ALTER TABLE `salesman`
  ADD PRIMARY KEY (`salesman_id`);

--
-- Indexes for table `salesman_address`
--
ALTER TABLE `salesman_address`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `salesman_address_ibfk_1` (`salesman_id`);

--
-- Indexes for table `salesman_price`
--
ALTER TABLE `salesman_price`
  ADD PRIMARY KEY (`entity_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `salesman_price_ibfk_2` (`salesman_id`);

--
-- Indexes for table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`shipping_id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`vendor_id`);

--
-- Indexes for table `vendor_address`
--
ALTER TABLE `vendor_address`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `vendor_address_ibfk_1` (`vendor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `customer_address`
--
ALTER TABLE `customer_address`
  MODIFY `address_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `product_media`
--
ALTER TABLE `product_media`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `salesman`
--
ALTER TABLE `salesman`
  MODIFY `salesman_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `salesman_address`
--
ALTER TABLE `salesman_address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `salesman_price`
--
ALTER TABLE `salesman_price`
  MODIFY `entity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `shipping`
--
ALTER TABLE `shipping`
  MODIFY `shipping_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `vendor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `vendor_address`
--
ALTER TABLE `vendor_address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer_address`
--
ALTER TABLE `customer_address`
  ADD CONSTRAINT `customer_address_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_media`
--
ALTER TABLE `product_media`
  ADD CONSTRAINT `product_media_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `salesman_address`
--
ALTER TABLE `salesman_address`
  ADD CONSTRAINT `salesman_address_ibfk_1` FOREIGN KEY (`salesman_id`) REFERENCES `salesman` (`salesman_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `salesman_price`
--
ALTER TABLE `salesman_price`
  ADD CONSTRAINT `salesman_price_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `salesman_price_ibfk_2` FOREIGN KEY (`salesman_id`) REFERENCES `salesman` (`salesman_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vendor_address`
--
ALTER TABLE `vendor_address`
  ADD CONSTRAINT `vendor_address_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`vendor_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
