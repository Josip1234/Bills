-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2024 at 08:20 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bills`
--

-- --------------------------------------------------------

--
-- Table structure for table `shop`
--

CREATE TABLE `shop` (
  `id` int(11) NOT NULL,
  `shop_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `shop`
--

INSERT INTO `shop` (`id`, `shop_name`) VALUES
(1, 'KONZUM plus d.o.o.');

-- --------------------------------------------------------

--
-- Table structure for table `shop_detail`
--

CREATE TABLE `shop_detail` (
  `id` int(11) NOT NULL,
  `shop_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `ssn` varchar(11) NOT NULL,
  `shop number` varchar(255) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `fax` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `hq_address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `shop_detail`
--

INSERT INTO `shop_detail` (`id`, `shop_name`, `address`, `ssn`, `shop number`, `telephone`, `fax`, `email`, `hq_address`) VALUES
(1, 'KONZUM plus d.o.o.', 'ZAGREB, NOVA VES 17', '62226620908', '3205', '0800 400 000', '', '', 'Zagreb, Ulica Marijana Čavića 1A');

-- --------------------------------------------------------

--
-- Table structure for table `type_off_bill`
--

CREATE TABLE `type_off_bill` (
  `id` int(11) NOT NULL,
  `type_id` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `type_off_bill`
--

INSERT INTO `type_off_bill` (`id`, `type_id`, `type`) VALUES
(1, '1939029', 'Shopping bill');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shop_name` (`shop_name`);

--
-- Indexes for table `shop_detail`
--
ALTER TABLE `shop_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shopind` (`shop_name`);

--
-- Indexes for table `type_off_bill`
--
ALTER TABLE `type_off_bill`
  ADD PRIMARY KEY (`id`,`type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `shop`
--
ALTER TABLE `shop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shop_detail`
--
ALTER TABLE `shop_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `type_off_bill`
--
ALTER TABLE `type_off_bill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `shop_detail`
--
ALTER TABLE `shop_detail`
  ADD CONSTRAINT `shop_name` FOREIGN KEY (`shop_name`) REFERENCES `shop` (`shop_name`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
