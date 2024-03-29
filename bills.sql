-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2024 at 08:35 PM
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
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `serial_num` varchar(255) NOT NULL,
  `article_name` varchar(255) NOT NULL,
  `article_price` double NOT NULL,
  `kuna_price` double DEFAULT NULL,
  `current_rate_in_euro` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `serial_num`, `article_name`, `article_price`, `kuna_price`, `current_rate_in_euro`) VALUES
(1, '8n54KcUA', 'VODA IZV JANA MEN LI', 1.46, 10.99, 7.5345);

-- --------------------------------------------------------

--
-- Table structure for table `bill_footer`
--

CREATE TABLE `bill_footer` (
  `id` int(11) NOT NULL,
  `bill_number` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `ZKI` varchar(255) NOT NULL,
  `JIR` varchar(255) NOT NULL,
  `ref_number` varchar(50) NOT NULL,
  `other` text DEFAULT NULL,
  `barcode_image_url` varchar(255) DEFAULT NULL,
  `shop_ssn` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `bill_footer`
--

INSERT INTO `bill_footer` (`id`, `bill_number`, `date`, `ZKI`, `JIR`, `ref_number`, `other`, `barcode_image_url`, `shop_ssn`) VALUES
(1, '26691/3205/60', '2022-07-14 14:57:07', '61190da357423eb32fe0a6b39ae19111', '8a0bd979-8948-4668-8030-3685a45aa06f', '83/2320560208', 'Kupujte i online na www.konzum.hr\r\n', '', '62226620908');

-- --------------------------------------------------------

--
-- Table structure for table `bill_item`
--

CREATE TABLE `bill_item` (
  `id` int(11) NOT NULL,
  `bill_number` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `article_name` varchar(255) NOT NULL,
  `shop_name` varchar(255) NOT NULL,
  `amount` int(11) DEFAULT NULL,
  `amount_in_kg` double DEFAULT NULL,
  `amount_in_grams` int(11) DEFAULT NULL,
  `amount_in_liters` double DEFAULT NULL,
  `other_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`other_details`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `bill_item`
--

INSERT INTO `bill_item` (`id`, `bill_number`, `type`, `article_name`, `shop_name`, `amount`, `amount_in_kg`, `amount_in_grams`, `amount_in_liters`, `other_details`) VALUES
(1, '26691/3205/60', 'Shopping bill', 'VODA IZV JANA MEN LI', 'KONZUM plus d.o.o.', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `other_shop_or_bill_details`
--

CREATE TABLE `other_shop_or_bill_details` (
  `id` int(11) NOT NULL,
  `shop_name` varchar(255) DEFAULT NULL,
  `bill_number` varchar(255) DEFAULT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`details`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `other_shop_or_bill_details`
--

INSERT INTO `other_shop_or_bill_details` (`id`, `shop_name`, `bill_number`, `details`) VALUES
(1, 'KONZUM plus d.o.o.', '26691/3205/60', '{\"Details\":{\n      \"Blagajna\":60,\n      \"Blagajnik\":\"KE\"\n}\n}');

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
  `fax` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `hq_address` varchar(255) DEFAULT NULL
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
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `serial_num` (`serial_num`),
  ADD UNIQUE KEY `article_name` (`article_name`);

--
-- Indexes for table `bill_footer`
--
ALTER TABLE `bill_footer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bill_number` (`bill_number`),
  ADD UNIQUE KEY `ZKI` (`ZKI`),
  ADD UNIQUE KEY `JIR` (`JIR`),
  ADD KEY `shop_ssn` (`shop_ssn`);

--
-- Indexes for table `bill_item`
--
ALTER TABLE `bill_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bill_number` (`bill_number`),
  ADD KEY `type` (`type`),
  ADD KEY `serial_num` (`article_name`),
  ADD KEY `shop_name` (`shop_name`);

--
-- Indexes for table `other_shop_or_bill_details`
--
ALTER TABLE `other_shop_or_bill_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shop_name` (`shop_name`),
  ADD KEY `bill_number` (`bill_number`);

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
  ADD UNIQUE KEY `ssn` (`ssn`),
  ADD KEY `shopind` (`shop_name`);

--
-- Indexes for table `type_off_bill`
--
ALTER TABLE `type_off_bill`
  ADD PRIMARY KEY (`id`,`type_id`),
  ADD UNIQUE KEY `type` (`type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bill_footer`
--
ALTER TABLE `bill_footer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bill_item`
--
ALTER TABLE `bill_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `other_shop_or_bill_details`
--
ALTER TABLE `other_shop_or_bill_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- Constraints for table `bill_footer`
--
ALTER TABLE `bill_footer`
  ADD CONSTRAINT `shop_fk` FOREIGN KEY (`shop_ssn`) REFERENCES `shop_detail` (`ssn`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bill_item`
--
ALTER TABLE `bill_item`
  ADD CONSTRAINT `bill_item_ibfk_1` FOREIGN KEY (`type`) REFERENCES `type_off_bill` (`type`),
  ADD CONSTRAINT `bill_no_fk` FOREIGN KEY (`bill_number`) REFERENCES `bill_footer` (`bill_number`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `serial_art_fk` FOREIGN KEY (`article_name`) REFERENCES `articles` (`article_name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `shop_name_fk` FOREIGN KEY (`shop_name`) REFERENCES `shop` (`shop_name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `other_shop_or_bill_details`
--
ALTER TABLE `other_shop_or_bill_details`
  ADD CONSTRAINT `bill_number` FOREIGN KEY (`bill_number`) REFERENCES `bill_footer` (`bill_number`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `other_shop_or_bill_details_ibfk_1` FOREIGN KEY (`shop_name`) REFERENCES `shop` (`shop_name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shop_detail`
--
ALTER TABLE `shop_detail`
  ADD CONSTRAINT `shop_name` FOREIGN KEY (`shop_name`) REFERENCES `shop` (`shop_name`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
