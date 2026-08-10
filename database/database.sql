-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2025 at 11:36 PM
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
-- Database: `mkr_database`
--

CREATE DATABASE IF NOT EXISTS `mkr_database`;
USE `mkr_database`;

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_id` int(11) NOT NULL,
  `licence_plate` varchar(20) DEFAULT NULL,
  `make` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `year` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `fuel_type` varchar(30) DEFAULT NULL,
  `status` enum('new','pre-owned') NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `licence_plate`, `make`, `model`, `year`, `price`, `fuel_type`, `status`, `description`, `image`) VALUES
(1, '251D101', 'Toyota', 'Corolla Hybrid', 2025, 29950.00, 'Hybrid', 'new', 'Brand-new 2025 Toyota Corolla Hybrid with updated safety suite.', 'corolla.jpg'),
(2, '251C224', 'Tesla', 'Model 3 Highland', 2025, 42990.00, 'Electric', 'new', '2025 Tesla Model 3 Highland with next-gen battery and upgraded interior.', 'model3_251C224.webp'),
(3, '251G552', 'BMW', '320e', 2025, 48900.00, 'Hybrid', 'new', '2025 BMW 320e plug-in hybrid with enhanced efficiency and tech.', 'bmw320e_251G552.png'),
(4, '251LH883', 'Toyota', 'RAV4 Hybrid', 2025, 37950.00, 'Hybrid', 'new', 'Brand-new 2025 Toyota RAV4 Hybrid with improved fuel economy.', 'rav4_251LH883.png'),
(5, '251W334', 'Tesla', 'Model Y Long Range', 2025, 56990.00, 'Electric', 'new', '2025 Tesla Model Y Long Range with performance and comfort upgrades.', 'modely_251W334.avif'),
(6, '251MO77', 'BMW', 'i4 M50', 2025, 68900.00, 'Electric', 'new', 'High-performance 2025 BMW i4 M50 with dual-motor AWD.', 'i4m50_251MO77.webp'),
(7, '251KK455', 'Toyota', 'Camry Hybrid', 2025, 34950.00, 'Hybrid', 'new', '2025 Toyota Camry Hybrid featuring refined design and smooth performance.', 'camry_251KK455.jpg'),
(8, '251D912', 'Toyota', 'Yaris', 2025, 21950.00, 'Petrol', 'new', '2025 Toyota Yaris petrol model with excellent fuel efficiency.', 'yaris_251D912.jpg'),
(9, '251SO321', 'BMW', '118i', 2025, 34900.00, 'Petrol', 'new', '2025 BMW 118i petrol hatchback with sporty handling and premium interior.', 'bmw118i_251SO321.webp'),
(10, '151-L-18432', 'BMW', '118i', 2015, 14500.00, 'Petrol', 'pre-owned', '2015 BMW 118i in excellent condition. Smooth drive, well maintained, perfect city car.', 'used_118i_2015.jpg'),
(11, '161-D-45216', 'BMW', '320d', 2016, 18900.00, 'Diesel', 'pre-owned', 'Powerful and efficient BMW 320d with full service history. Great motorway comfort.', 'used_320d_2016.jpg'),
(12, '191-C-9832', 'Toyota', 'Corolla', 2019, 17500.00, 'Petrol', 'pre-owned', 'Reliable 2019 Toyota Corolla with low mileage and excellent fuel efficiency.', 'used_corolla_2019.jpg'),
(13, '181-D-55721', 'Tesla', 'Model 3', 2018, 28900.00, 'Electric', 'pre-owned', '2018 Tesla Model 3 with Autopilot. Fully electric, fast charging, premium interior.', 'used_model3_2018.jpg'),
(14, '201-L-34125', 'Toyota', 'RAV4', 2020, 31500.00, 'Hybrid', 'pre-owned', 'Spacious and efficient 2020 Toyota RAV4 Hybrid. Ideal family SUV with great economy.', 'used_rav4_2020.jpg'),
(15, '171-G-22412', 'Toyota', 'Yaris', 2017, 12500.00, 'Petrol', 'pre-owned', 'Compact Toyota Yaris, perfect for city driving. Low running costs and reliable performance.', 'used_yaris_2017.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `name`, `email`, `phone`) VALUES
(1, '', 'ho@yahoo.com', '243');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sale_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `sold_by` int(11) NOT NULL,
  `sale_date` date NOT NULL,
  `sale_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `test_drives`
--

CREATE TABLE `test_drives` (
  `drive_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `full_name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `preferred_date` date NOT NULL,
  `preferred_time` time NOT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test_drives`
--

INSERT INTO `test_drives` (`drive_id`, `car_id`, `full_name`, `email`, `phone`, `preferred_date`, `preferred_time`, `message`, `created_at`) VALUES
(8, 9, 'John', 'john@yahoo.com', '123456789', '2025-11-28', '09:20:00', 'Excited!', '2025-11-27 14:39:26');

-- --------------------------------------------------------

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sale_id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `sold_by` (`sold_by`);

--
-- Indexes for table `test_drives`
--
ALTER TABLE `test_drives`
  ADD PRIMARY KEY (`drive_id`),
  ADD KEY `car_id` (`car_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test_drives`
--
ALTER TABLE `test_drives`
  MODIFY `drive_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`),
  ADD CONSTRAINT `sales_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  ADD CONSTRAINT `sales_ibfk_3` FOREIGN KEY (`sold_by`) REFERENCES `employees` (`employee_id`);

--
-- Constraints for table `test_drives`
--
ALTER TABLE `test_drives`
  ADD CONSTRAINT `test_drives_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@OLD_CHARACTER_SET_CLIENT */;
