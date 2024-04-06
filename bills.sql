-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2024 at 02:30 PM
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
(1, '8n54KcUA', 'VODA IZV JANA MEN LI', 1.46, 10.99, 7.5345),
(3, '20002', 'MAJICA', 12.9, NULL, NULL);

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
(1, '26691/3205/60', '2022-07-14 14:57:07', '61190da357423eb32fe0a6b39ae19111', '8a0bd979-8948-4668-8030-3685a45aa06f', '83/2320560208', 'Kupujte i online na www.konzum.hr\r\n', '', '62226620908'),
(2, '3033/PP4/1', '2024-04-06 10:24:26', '6867931bd51a0836a61a495a37ec5314', 'fe2cade0-e86a-4188-958a-ec4580d98a09', '0.15522042769493574', 'ozn. operatera: OPERATER 48\nNaćin plaćanja: gotovina\nHvala na kupnji! Zamjena robe moguća je u roku od 10 dana od danje kupnje uz predočenje računa. Odjeća i galenterija mora sadržavati pripadajuće deklaracije, a obuća originalnu ambalažu. Obuća, odjeća i galenterija ne smije biti nošena u slučaju zamjene. U slučaju zamjene robe povrat novca nije moguć', 'C:\\Users\\Korisnik\\Desktop\\xmp\\htdocs\\Bills\\WIN_20230224_19_01_22_Pro.jpg', '39314924844');

-- --------------------------------------------------------

--
-- Table structure for table `bill_item`
--

CREATE TABLE `bill_item` (
  `id` int(11) NOT NULL,
  `bill_number` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `article_name` varchar(255) NOT NULL,
  `shop_ssn` varchar(255) NOT NULL,
  `amount` int(11) DEFAULT NULL,
  `amount_in_kg` double DEFAULT NULL,
  `amount_in_grams` int(11) DEFAULT NULL,
  `amount_in_liters` double DEFAULT NULL,
  `other_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`other_details`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `bill_item`
--

INSERT INTO `bill_item` (`id`, `bill_number`, `type`, `article_name`, `shop_ssn`, `amount`, `amount_in_kg`, `amount_in_grams`, `amount_in_liters`, `other_details`) VALUES
(2, '26691/3205/60', 'Shopping bill', 'VODA IZV JANA MEN LI', '62226620908', 1, NULL, NULL, NULL, NULL),
(3, '3033/PP4/1', 'Shopping bill', 'MAJICA', '39314924844', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `other_shop_or_bill_details`
--

CREATE TABLE `other_shop_or_bill_details` (
  `id` int(11) NOT NULL,
  `bill_number` varchar(255) DEFAULT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`details`)),
  `shop_ssn` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `other_shop_or_bill_details`
--

INSERT INTO `other_shop_or_bill_details` (`id`, `bill_number`, `details`, `shop_ssn`) VALUES
(2, '26691/3205/60', '{\"Details\":{\r\n      \"Blagajna\":60,\r\n      \"Blagajnik\":\"KE\"\r\n}\r\n}', '62226620908'),
(3, '3033/PP4/1', '{\r\n   \"Details\":{\r\n      \"Oznaka operatera\":\"OPERATER 48\",\r\n      \"Način plaćanja\":\"Gotovina\"\r\n   }\r\n}', '39314924844');

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
(1, 'KONZUM plus d.o.o.'),
(2, 'T.O. Koala Vl. M.Jelic');

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
  `hq_address` varchar(255) DEFAULT NULL,
  `web_page` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `shop_detail`
--

INSERT INTO `shop_detail` (`id`, `shop_name`, `address`, `ssn`, `shop number`, `telephone`, `fax`, `email`, `hq_address`, `web_page`) VALUES
(1, 'KONZUM plus d.o.o.', 'ZAGREB, NOVA VES 17', '62226620908', '3205', '0800 400 000', '', '', 'Zagreb, Ulica Marijana Čavića 1A', 'https://www.konzum.hr/'),
(2, 'T.O. Koala Vl. M.Jelic', 'Matice Hrvatske 4, Požega', '39314924844', 'Izdv. Pogon 4', '034 / 275 – 990', NULL, NULL, 'Sl.Graničara 29, Nova Gradiška', 'https://koala-shop.hr/');

-- --------------------------------------------------------

--
-- Table structure for table `shop_logo`
--

CREATE TABLE `shop_logo` (
  `id` int(11) NOT NULL,
  `shop_name` varchar(255) NOT NULL,
  `logo1_url` varchar(255) NOT NULL,
  `logo2_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `shop_logo`
--

INSERT INTO `shop_logo` (`id`, `shop_name`, `logo1_url`, `logo2_url`) VALUES
(1, 'KONZUM plus d.o.o.', 'C:\\Users\\Korisnik\\Desktop\\xmp\\htdocs\\Bills\\konzum_logo.png', ''),
(2, 'T.O. Koala Vl. M.Jelic', 'C:\\Users\\Korisnik\\Desktop\\xmp\\htdocs\\Bills\\koala_logo.png', '');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `bill_number` varchar(255) NOT NULL,
  `shop_ssn` varchar(255) NOT NULL,
  `serial_num` varchar(255) NOT NULL,
  `sum_eur` double NOT NULL,
  `sum_hrk` double DEFAULT NULL,
  `tax_mark` char(6) DEFAULT NULL,
  `tax_base` double DEFAULT NULL,
  `tax_amount` double DEFAULT NULL,
  `in_total` double NOT NULL,
  `refunds` double DEFAULT NULL,
  `refund_amount` int(11) DEFAULT NULL,
  `refunnd_value_one` double DEFAULT NULL,
  `refund_value_two` double DEFAULT NULL,
  `other_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`other_details`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `bill_number`, `shop_ssn`, `serial_num`, `sum_eur`, `sum_hrk`, `tax_mark`, `tax_base`, `tax_amount`, `in_total`, `refunds`, `refund_amount`, `refunnd_value_one`, `refund_value_two`, `other_details`) VALUES
(2, '26691/3205/60', '62226620908', '8n54KcUA', 1.46, 10.99, 'A', 8.39, 2.1, 10.49, 0.5, 1, 0.5, 0.07, '{\"Details\":{\r\n\"Plaćeno\":\"Kartica\",\r\n\"Iznos\":\"1,46 EUR 10,99\"\r\n}\r\n}'),
(3, '3033/PP4/1', '39314924844', '20002', 12.9, NULL, NULL, 10.32, 2.58, 12.9, NULL, NULL, NULL, NULL, '{\r\n   \"Details\":{\r\n      \"Oznaka operatera\":\"OPERATER 48\",\r\n      \"Način plaćanja\":\"Gotovina\"\r\n   }\r\n}');

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
  ADD KEY `shop_name` (`shop_ssn`);

--
-- Indexes for table `other_shop_or_bill_details`
--
ALTER TABLE `other_shop_or_bill_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bill_number` (`bill_number`),
  ADD KEY `shop_ssn` (`shop_ssn`);

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
-- Indexes for table `shop_logo`
--
ALTER TABLE `shop_logo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shop_name` (`shop_name`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bill_number` (`bill_number`),
  ADD KEY `shop_name` (`shop_ssn`),
  ADD KEY `serial_num` (`serial_num`),
  ADD KEY `shop_name_2` (`shop_ssn`),
  ADD KEY `shop_ssn` (`shop_ssn`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bill_footer`
--
ALTER TABLE `bill_footer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bill_item`
--
ALTER TABLE `bill_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `other_shop_or_bill_details`
--
ALTER TABLE `other_shop_or_bill_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shop`
--
ALTER TABLE `shop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `shop_detail`
--
ALTER TABLE `shop_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `shop_logo`
--
ALTER TABLE `shop_logo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  ADD CONSTRAINT `shop_ssn_fk` FOREIGN KEY (`shop_ssn`) REFERENCES `shop_detail` (`ssn`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `other_shop_or_bill_details`
--
ALTER TABLE `other_shop_or_bill_details`
  ADD CONSTRAINT `bill_number` FOREIGN KEY (`bill_number`) REFERENCES `bill_footer` (`bill_number`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `shp_ssn_fk` FOREIGN KEY (`shop_ssn`) REFERENCES `shop_detail` (`ssn`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shop_detail`
--
ALTER TABLE `shop_detail`
  ADD CONSTRAINT `shop_name` FOREIGN KEY (`shop_name`) REFERENCES `shop` (`shop_name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shop_logo`
--
ALTER TABLE `shop_logo`
  ADD CONSTRAINT `shop_name_fk` FOREIGN KEY (`shop_name`) REFERENCES `shop` (`shop_name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `bill_no` FOREIGN KEY (`bill_number`) REFERENCES `bill_footer` (`bill_number`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `serial_num` FOREIGN KEY (`serial_num`) REFERENCES `articles` (`serial_num`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sh_ssn_fk` FOREIGN KEY (`shop_ssn`) REFERENCES `shop_detail` (`ssn`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
