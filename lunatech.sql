-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2025 at 02:54 PM
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
-- Database: `lunatech`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `branch_id` int(11) NOT NULL,
  `branch_code` varchar(60) NOT NULL,
  `branch_name` varchar(60) NOT NULL,
  `branch_address` text NOT NULL,
  `branch_manager_id` int(11) NOT NULL,
  `branch_status` int(11) NOT NULL DEFAULT 1 COMMENT '0=deleted,1=existing'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`branch_id`, `branch_code`, `branch_name`, `branch_address`, `branch_manager_id`, `branch_status`) VALUES
(15, 'fsef', 'trh', 'ftfhft', 10, 0),
(16, 'dsg', 'drgdr', 'fth', 6, 0),
(17, 'j', 'ljil', 'k;ok', 10, 0),
(18, 'M0001', 'marilao branch', 'sta.rosa 2 marilao bulacan', 10, 1),
(19, 'M0002', 'prenza branch', 'prenza 1 marilao bulacan', 6, 1),
(20, 'M0003', 'lambakin branch', 'lambakin marilao bulacan', 11, 0),
(21, 'awd', 'fsef', 'sefesf', 11, 0),
(22, 'sef', 'sefse', 'esf', 11, 0),
(23, 'M0003', 'lambakin branch', 'lambakin marilao bulacan', 11, 1),
(24, 'M004', 'Tondo Branch', 'tondo manila', 12, 0),
(25, 'cccc', 'rdgrd', 'esfesf', 12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pos_cart`
--

CREATE TABLE `pos_cart` (
  `cart_id` int(11) NOT NULL,
  `cart_prod_id` int(11) NOT NULL,
  `cart_qty` int(11) NOT NULL,
  `cart_sale_price` decimal(10,2) NOT NULL,
  `cart_branch_id` int(11) NOT NULL,
  `cart_stock_in_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `prod_id` int(11) NOT NULL,
  `prod_code` varchar(60) NOT NULL,
  `prod_name` varchar(60) NOT NULL,
  `prod_capital` decimal(10,2) NOT NULL,
  `prod_current_price` decimal(10,2) NOT NULL,
  `prod_added_by` int(11) NOT NULL,
  `prod_date_added` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `prod_status` int(11) NOT NULL DEFAULT 1 COMMENT '0=deleted, 1=existing'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`prod_id`, `prod_code`, `prod_name`, `prod_capital`, `prod_current_price`, `prod_added_by`, `prod_date_added`, `prod_status`) VALUES
(68, 'P76190', 'IP 11 128', 12301.00, 13501.00, 1, '2025-04-14 04:36:52', 1),
(69, 'P50538', 'IP 12 256', 2500.00, 2700.00, 1, '2025-04-14 04:36:53', 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_item`
--

CREATE TABLE `purchase_item` (
  `item_id` int(11) NOT NULL,
  `item_purchase_id` int(11) NOT NULL,
  `item_prod_id` int(11) NOT NULL,
  `item_qty` int(11) NOT NULL,
  `item_price_sold` decimal(10,2) NOT NULL,
  `item_price_capital` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_item`
--

INSERT INTO `purchase_item` (`item_id`, `item_purchase_id`, `item_prod_id`, `item_qty`, `item_price_sold`, `item_price_capital`) VALUES
(84, 61, 68, 1, 13501.00, 12301.00),
(85, 61, 69, 1, 2700.00, 2500.00),
(86, 62, 68, 1, 13501.00, 12301.00);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_record`
--

CREATE TABLE `purchase_record` (
  `purchase_id` int(11) NOT NULL,
  `purchase_invoice` varchar(60) NOT NULL,
  `purchase_mode_of_payment` varchar(60) NOT NULL,
  `purchase_total_payment` int(11) NOT NULL,
  `purchase_payment` decimal(10,2) NOT NULL,
  `purchased_change` decimal(10,2) DEFAULT NULL,
  `purchase_branch_id` int(11) NOT NULL,
  `purchase_user_id` int(11) NOT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `purchase_remarks` text NOT NULL,
  `purchase_display_status` int(11) NOT NULL DEFAULT 1 COMMENT '0=archived,1=exist'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_record`
--

INSERT INTO `purchase_record` (`purchase_id`, `purchase_invoice`, `purchase_mode_of_payment`, `purchase_total_payment`, `purchase_payment`, `purchased_change`, `purchase_branch_id`, `purchase_user_id`, `purchase_date`, `purchase_remarks`, `purchase_display_status`) VALUES
(61, 'INV-17460825106967', 'cash', 16201, 16500.00, 299.00, 19, 6, '2025-05-01 06:55:17', '', 0),
(62, 'INV-17461032245688', 'cash', 13501, 13501.00, 0.00, 23, 11, '2025-05-01 12:40:24', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `stock_in_id` int(11) NOT NULL,
  `stock_in_branch_id` int(11) NOT NULL,
  `stock_in_prod_id` int(11) NOT NULL,
  `stock_in_qty` int(11) NOT NULL,
  `stock_in_sold` int(11) NOT NULL,
  `stock_in_backjob` int(11) NOT NULL,
  `stock_in_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `stock_in_action_approval` varchar(60) DEFAULT NULL,
  `stock_in_request_changes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `stock_in_status` int(11) NOT NULL DEFAULT 1 COMMENT '0=deleted,1=exist'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`stock_in_id`, `stock_in_branch_id`, `stock_in_prod_id`, `stock_in_qty`, `stock_in_sold`, `stock_in_backjob`, `stock_in_date`, `stock_in_action_approval`, `stock_in_request_changes`, `stock_in_status`) VALUES
(91, 19, 68, 0, 0, 0, '2025-05-01 10:31:16', NULL, NULL, 1),
(92, 19, 68, 80, 2, 0, '2025-05-01 12:25:36', NULL, NULL, 1),
(93, 19, 69, 99, 1, 0, '2025-05-01 12:25:34', NULL, NULL, 1),
(94, 18, 68, 8, 0, 0, '2025-05-01 07:12:22', NULL, NULL, 1),
(95, 18, 68, 0, 3, 0, '2025-05-01 07:12:22', NULL, NULL, 1),
(96, 18, 69, 10, 0, 0, '2025-05-01 07:12:22', NULL, NULL, 1),
(97, 18, 69, 0, 1, 0, '2025-05-01 07:12:22', NULL, NULL, 1),
(98, 18, 68, 0, 1, 0, '2025-05-01 07:12:22', NULL, NULL, 1),
(99, 18, 69, 0, 2, 0, '2025-05-01 07:12:22', NULL, NULL, 1),
(100, 19, 68, 0, 1, 0, '2025-05-01 07:12:22', NULL, NULL, 1),
(101, 19, 68, 0, 2, 0, '2025-05-01 07:12:22', NULL, NULL, 1),
(102, 19, 69, 0, 1, 0, '2025-05-01 07:12:22', NULL, NULL, 1),
(103, 19, 69, 2, 0, 0, '2025-05-01 07:12:22', NULL, NULL, 1),
(104, 19, 69, 0, 5, 0, '2025-05-01 07:12:22', NULL, NULL, 1),
(105, 19, 68, 0, 0, 5, '2025-05-01 10:31:24', NULL, NULL, 1),
(106, 19, 68, 0, 1, 0, '2025-05-01 10:39:33', NULL, NULL, 1),
(107, 19, 69, 0, 1, 0, '2025-05-01 07:12:22', NULL, NULL, 1),
(114, 23, 68, 8, 0, 0, '2025-05-01 12:38:34', NULL, NULL, 1),
(116, 23, 68, 1, 0, 0, '2025-05-01 12:38:45', NULL, NULL, 1),
(117, 23, 68, 0, 1, 0, '2025-05-01 12:40:24', NULL, NULL, 1),
(118, 23, 68, 2, 0, 0, '2025-05-01 12:41:39', 'For Stock Deletion', '{\"stock_in_id\":\"118\",\"user_id\":11,\"branch_id \":23,\"date_request\":\"2025-05-01\"}', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `user_fullname` varchar(60) NOT NULL,
  `user_username` varchar(60) NOT NULL,
  `user_email` varchar(60) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_type` varchar(60) NOT NULL,
  `user_status` int(11) NOT NULL DEFAULT 1 COMMENT '0=deleted,1=existing'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_fullname`, `user_username`, `user_email`, `user_password`, `user_type`, `user_status`) VALUES
(1, 'rick sanches', 'admin', 'admin@gmail.com', '$2y$10$5PuRSpCt1g9Fq4LcxcCtQuICWO/LVUTMvb/1FwM4/kOFtg2M/XICC', 'Administrator', 1),
(2, 'joshua padilla', 'andersonandy046', 'andersonandy046@gmail.com', '$2y$10$qYtfNuDcs13sLrcAQ.ic0uOZ70TU03BuU64bTHUhG.clQz9gt5ypG', 'General Manager', 1),
(3, 'joshua padilla', 'andersonandy046', 'andersonandy046@gmail.com', '$2y$10$sG/04wrOKoY/0f50ocgSJuZSRZCw/ccmvhfc1Exa.vos5WGa4dZgm', 'General Manager', 0),
(4, 'test test', 'test', 'test@gmail.com', '$2y$10$TNMDFrM4cGrdr.dIzBLuB.C1UHlWFSMZMsS4wZ3qDlISR2oTlTaFW', 'Branch Manager', 0),
(5, 'diwata', 'diwata', 'diwata@gmail.com', '$2y$10$3.ca7tefWXpGeAu1jzTpRucMej/r/X1ciqf08OTUKquZ2BZM.E0O.', 'Branch Manager', 0),
(6, 'jame lebron', 'lebron', 'lebron_james@gmail.com', '$2y$10$rZO.K4i3yp3xxEYwyRGKB.nwq9OPlCtWf0kX20TufxY/tcxo70TNO', 'Branch Manager', 1),
(10, 'joshua padilla', 'master', 'joshuapadilla@gmail.com', '$2y$10$g23CGJpfn3dmpyM5WkeZK.rpIemYB9YO6uVDiDGUEMujcVx51jncu', 'Branch Manager', 1),
(11, 'april jane', 'apriljane', 'apriljane@gmail.com', '$2y$10$/0I/pdw7QaMrSmxuMQawO.3.2zSP9gM/.kb0/wpUUmPWLcS5O1xYe', 'Branch Manager', 1),
(12, 'mica delz cruz', 'mica', 'mica@gmail.com', '$2y$10$EKAMXfSXAOlgyW.ppW2B0OeW3x7stYfj6HMoQj91s/btQiS5Atwwm', 'Branch Manager', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`branch_id`),
  ADD KEY `branch_manager_id` (`branch_manager_id`);

--
-- Indexes for table `pos_cart`
--
ALTER TABLE `pos_cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `purchase_item`
--
ALTER TABLE `purchase_item`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `item_prod_id` (`item_prod_id`),
  ADD KEY `item_purchase_id` (`item_purchase_id`);

--
-- Indexes for table `purchase_record`
--
ALTER TABLE `purchase_record`
  ADD PRIMARY KEY (`purchase_id`),
  ADD KEY `purchase_user_id` (`purchase_user_id`),
  ADD KEY `purchase_branch_id` (`purchase_branch_id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`stock_in_id`),
  ADD KEY `stock_in_branch_id` (`stock_in_branch_id`),
  ADD KEY `stock_in_prod_id` (`stock_in_prod_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `pos_cart`
--
ALTER TABLE `pos_cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=255;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `purchase_item`
--
ALTER TABLE `purchase_item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `purchase_record`
--
ALTER TABLE `purchase_record`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `stock_in_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `branches`
--
ALTER TABLE `branches`
  ADD CONSTRAINT `branches_ibfk_1` FOREIGN KEY (`branch_manager_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_item`
--
ALTER TABLE `purchase_item`
  ADD CONSTRAINT `purchase_item_ibfk_1` FOREIGN KEY (`item_prod_id`) REFERENCES `products` (`prod_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchase_item_ibfk_2` FOREIGN KEY (`item_purchase_id`) REFERENCES `purchase_record` (`purchase_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_record`
--
ALTER TABLE `purchase_record`
  ADD CONSTRAINT `purchase_record_ibfk_1` FOREIGN KEY (`purchase_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchase_record_ibfk_2` FOREIGN KEY (`purchase_branch_id`) REFERENCES `branches` (`branch_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`stock_in_branch_id`) REFERENCES `branches` (`branch_id`),
  ADD CONSTRAINT `stock_ibfk_2` FOREIGN KEY (`stock_in_prod_id`) REFERENCES `products` (`prod_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
