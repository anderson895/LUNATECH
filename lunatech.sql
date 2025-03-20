-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2025 at 09:33 AM
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
  `branch_tel` varchar(16) NOT NULL,
  `branch_started` date NOT NULL,
  `branch_manager_id` int(11) NOT NULL,
  `branch_status` int(11) NOT NULL DEFAULT 1 COMMENT '0=deleted,1=existing'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`branch_id`, `branch_code`, `branch_name`, `branch_address`, `branch_tel`, `branch_started`, `branch_manager_id`, `branch_status`) VALUES
(15, 'fsef', 'trh', 'ftfhft', '', '2025-03-18', 10, 0),
(16, 'dsg', 'drgdr', 'fth', '', '2025-03-18', 6, 0),
(17, 'j', 'ljil', 'k;ok', '', '2025-03-18', 10, 0),
(18, 'M0001', 'marilao branch', 'sta.rosa 2 marilao bulacan', '(123) 456-7890', '2025-03-18', 10, 1),
(19, 'M0002', 'prenza branch', 'prenza 1 marilao bulacan', '(123) 456-7777', '2025-03-18', 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pos_cart`
--

CREATE TABLE `pos_cart` (
  `cart_id` int(11) NOT NULL,
  `cart_prod_id` int(11) NOT NULL,
  `cart_qty` int(11) NOT NULL,
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
  `prod_price` decimal(10,2) NOT NULL,
  `prod_added_by` int(11) NOT NULL,
  `prod_date_added` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `prod_status` int(11) NOT NULL DEFAULT 1 COMMENT '0=deleted, 1=existing'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`prod_id`, `prod_code`, `prod_name`, `prod_capital`, `prod_price`, `prod_added_by`, `prod_date_added`, `prod_status`) VALUES
(50, 'P94182', 'IP 11 128 MINT GREEN', 12300.00, 14000.00, 1, '2025-03-19 00:23:56', 1),
(51, 'P47305', 'IP 11 256 WHITE', 13700.00, 15500.00, 1, '2025-03-19 00:30:06', 0),
(52, 'P96523', 'IP 11 PRO 256 WHITE', 16000.00, 17500.00, 1, '2025-03-19 00:24:40', 1),
(53, 'P52781', 'IP 12 256 PINK', 16500.00, 19000.00, 1, '2025-03-19 00:25:02', 1),
(54, 'P64651', 'IP 11 PRO 256', 16000.00, 17500.00, 1, '2025-03-19 00:25:22', 1),
(55, 'P95223', 'IP 11 256 WHITE', 13700.00, 15500.00, 1, '2025-03-19 00:30:03', 0),
(56, 'P34058', 'IP 11 128 PURPLE', 12300.00, 14000.00, 1, '2025-03-19 00:25:52', 1),
(57, 'P29383', 'IP 11 256 MINT GREEN', 13700.00, 15500.00, 1, '2025-03-19 00:26:23', 1),
(58, 'P75973', 'IP 11 PM 256 MIDNIGHT GREEN', 18000.00, 19500.00, 1, '2025-03-19 00:28:55', 1),
(59, 'P85129', 'IP 11 256 WHITE', 13700.00, 15500.00, 1, '2025-03-19 02:51:22', 0),
(60, 'P34142', 'IP 12 PRO 128', 19300.00, 21500.00, 1, '2025-03-19 00:29:29', 1),
(61, 'P50175', 'IP 11 128 BLACK', 12300.00, 14000.00, 1, '2025-03-19 00:30:33', 1),
(62, 'P11395', 'IP XR 256 BLACK', 11000.00, 12500.00, 1, '2025-03-19 00:30:49', 1),
(63, 'P36428', 'IP 12 128 WHITE', 14600.00, 17000.00, 1, '2025-03-19 02:49:01', 1),
(64, 'P40677', 'IP XR 128 WHITE', 9500.00, 11000.00, 1, '2025-03-19 02:49:42', 1),
(65, 'P16846', 'IP 11 256 WHITE', 13200.00, 15000.00, 1, '2025-03-19 02:49:58', 1),
(66, 'P59510', 'IP 11 128 WHITE', 12300.00, 14000.00, 1, '2025-03-19 02:50:15', 1);

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
(62, 45, 63, 1, 17000.00, 14600.00),
(63, 45, 64, 1, 11000.00, 9500.00),
(64, 45, 65, 1, 15000.00, 13200.00),
(65, 45, 66, 1, 14000.00, 12300.00),
(66, 46, 63, 1, 17000.00, 14600.00),
(67, 47, 65, 1, 15000.00, 13200.00),
(68, 47, 66, 1, 14000.00, 12300.00),
(69, 48, 64, 2, 11000.00, 9500.00),
(70, 49, 57, 1, 15500.00, 13700.00);

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
  `purchase_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_record`
--

INSERT INTO `purchase_record` (`purchase_id`, `purchase_invoice`, `purchase_mode_of_payment`, `purchase_total_payment`, `purchase_payment`, `purchased_change`, `purchase_branch_id`, `purchase_user_id`, `purchase_date`) VALUES
(45, 'INV-17423527854661', 'cash', 57000, 57000.00, 0.00, 19, 6, '2025-01-18 02:53:05'),
(46, 'INV-17423684153784', 'cash', 17000, 17000.00, 0.00, 19, 6, '2025-02-19 07:13:35'),
(47, 'INV-17423684676897', 'cash', 29000, 30000.00, 1000.00, 19, 6, '2025-03-19 07:14:27'),
(48, 'INV-17424572811285', 'cash', 22000, 23000.00, 1000.00, 19, 6, '2025-03-20 07:54:41'),
(49, 'INV-17424590016788', 'cash', 15500, 15500.00, 0.00, 18, 10, '2025-03-20 08:23:21');

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
  `stock_in_status` int(11) NOT NULL DEFAULT 1 COMMENT '0=deleted,1=exist'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`stock_in_id`, `stock_in_branch_id`, `stock_in_prod_id`, `stock_in_qty`, `stock_in_sold`, `stock_in_backjob`, `stock_in_date`, `stock_in_status`) VALUES
(67, 19, 63, 9, 0, 0, '2025-03-19 12:31:59', 1),
(68, 19, 64, 7, 0, 0, '2025-03-20 07:54:36', 1),
(69, 19, 65, 8, 0, 0, '2025-03-19 07:14:20', 1),
(70, 19, 66, 8, 0, 0, '2025-03-20 07:54:29', 1),
(71, 19, 63, 0, 1, 0, '2025-03-19 09:15:46', 1),
(72, 19, 63, 0, 1, 0, '2025-03-19 09:15:58', 1),
(73, 19, 58, 90, 0, 0, '2025-03-20 07:54:04', 1),
(74, 19, 64, 6, 0, 0, '2025-03-19 09:18:08', 1),
(75, 19, 62, 12, 0, 0, '2025-03-19 09:18:14', 1),
(76, 19, 58, 1, 0, 0, '2025-03-19 09:47:07', 0),
(77, 19, 58, 1, 0, 0, '2025-03-19 12:30:16', 1),
(78, 19, 58, 1, 0, 0, '2025-03-19 12:30:19', 1),
(79, 19, 58, 1, 0, 0, '2025-03-19 12:30:56', 1),
(80, 19, 66, 2, 0, 0, '2025-03-19 12:34:37', 1),
(81, 19, 62, 1, 0, 0, '2025-03-19 12:34:59', 1),
(82, 18, 60, 10, 0, 0, '2025-03-20 08:22:36', 1),
(83, 18, 60, 10, 0, 0, '2025-03-20 08:22:38', 1),
(84, 18, 57, 9, 0, 0, '2025-03-20 08:23:00', 1);

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
(11, 'april jane', 'apriljane', 'apriljane@gmail.com', '$2y$10$/0I/pdw7QaMrSmxuMQawO.3.2zSP9gM/.kb0/wpUUmPWLcS5O1xYe', 'Branch Manager', 1);

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
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `pos_cart`
--
ALTER TABLE `pos_cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `purchase_item`
--
ALTER TABLE `purchase_item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `purchase_record`
--
ALTER TABLE `purchase_record`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `stock_in_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
