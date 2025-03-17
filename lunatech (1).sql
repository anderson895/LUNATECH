-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2025 at 05:49 PM
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
  `branch_started` date NOT NULL,
  `branch_manager_id` int(11) NOT NULL,
  `branch_status` int(11) NOT NULL DEFAULT 1 COMMENT '0=deleted,1=existing'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`branch_id`, `branch_code`, `branch_name`, `branch_address`, `branch_started`, `branch_manager_id`, `branch_status`) VALUES
(15, 'fsef', 'trh', 'ftfhft', '2025-03-18', 10, 0),
(16, 'dsg', 'drgdr', 'fth', '2025-03-18', 6, 0),
(17, 'j', 'ljil', 'k;ok', '2025-03-18', 10, 0),
(18, 'M0001', 'marilao branch', 'sta.rosa 2 marilao bulacan', '2025-03-18', 10, 1),
(19, 'M0002', 'prenza branch', 'prenza 1 marilao bulacan', '2025-03-18', 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `prod_id` int(11) NOT NULL,
  `prod_code` varchar(60) NOT NULL,
  `prod_name` varchar(60) NOT NULL,
  `prod_added_by` int(11) NOT NULL,
  `prod_date_added` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `prod_status` int(11) NOT NULL DEFAULT 1 COMMENT '0=deleted, 1=existing'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`prod_id`, `prod_code`, `prod_name`, `prod_added_by`, `prod_date_added`, `prod_status`) VALUES
(1, 'P29720', 'IP 11 128 MINT GREEN', 1, '2025-03-17 06:19:30', 1),
(2, 'P10494', 'product', 1, '2025-03-17 15:42:41', 1),
(10, 'P67372', '7p 128', 1, '2025-03-17 15:16:08', 1),
(11, 'P40542', 'x 64', 1, '2025-03-17 15:20:46', 1),
(12, 'P66303', 'x 256', 1, '2025-03-17 15:20:52', 1),
(13, 'P37997', 'xsm 256/512', 1, '2025-03-17 15:20:58', 1),
(14, 'P58578', 'xr 64', 1, '2025-03-17 15:42:41', 1),
(15, 'P85645', 'xr 128', 1, '2025-03-17 15:42:41', 1),
(16, 'P83412', 'xr 256', 1, '2025-03-17 15:42:41', 1),
(17, 'P15253', '11 256', 1, '2025-03-17 15:42:41', 1),
(18, 'P62417', '11 pro 256/512', 1, '2025-03-17 15:42:41', 1),
(19, 'P54043', '11 pm 256/512', 1, '2025-03-17 15:42:34', 1),
(20, 'P33029', '12 64', 1, '2025-03-17 15:42:41', 1),
(21, 'P80247', '12 128', 1, '2025-03-17 15:42:41', 1),
(22, 'P61830', '12 256', 1, '2025-03-17 15:42:41', 1),
(23, 'P50490', '15 mini', 1, '2025-03-17 15:43:11', 1),
(24, 'P78403', '12 pro 128', 1, '2025-03-17 15:42:41', 1),
(25, 'P90821', '12 pro 256', 1, '2025-03-17 15:42:41', 1),
(26, 'P36416', '12 PM 256', 1, '2025-03-17 15:42:41', 1),
(27, 'P58530', '12pm 512', 1, '2025-03-17 15:42:41', 1),
(28, 'P56808', '13 mini', 1, '2025-03-17 15:42:41', 1),
(29, 'P46828', '13 128', 1, '2025-03-17 15:42:41', 1),
(30, 'P58942', '13 256', 1, '2025-03-17 15:42:41', 1),
(31, 'P78499', '13 pro 128', 1, '2025-03-17 15:42:41', 1),
(32, 'P76090', '13pm 256', 1, '2025-03-17 15:42:41', 1),
(37, 'P93320', 'r', 1, '2025-03-17 15:42:41', 1);

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
(1, 6, 2, 5, 0, 0, '2025-03-17 09:43:04', 1),
(2, 6, 2, 0, 2, 0, '2025-03-17 09:43:35', 1),
(3, 6, 1, 5, 0, 0, '2025-03-17 09:44:20', 1),
(4, 6, 2, 0, 0, 2, '2025-03-17 09:44:41', 1),
(5, 6, 2, 2, 0, 0, '2025-03-17 09:55:24', 1),
(6, 6, 2, 1, 0, 0, '2025-03-17 09:55:36', 1),
(9, 0, 2, 0, 0, 0, '2025-03-17 14:41:16', 1),
(10, 0, 2, 0, 0, 0, '2025-03-17 14:41:18', 1),
(11, 0, 2, 5, 0, 0, '2025-03-17 14:41:21', 1),
(12, 0, 2, 5, 0, 0, '2025-03-17 14:41:21', 1),
(13, 0, 0, 0, 0, 0, '2025-03-17 14:41:24', 1),
(14, 0, 2, 5, 0, 0, '2025-03-17 14:41:48', 1),
(15, 6, 1, 0, 7, 0, '2025-03-17 14:42:32', 1),
(16, 6, 1, 0, 0, 1, '2025-03-17 14:52:03', 1);

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
(3, 'joshua padilla', 'andersonandy046', 'andersonandy046@gmail.com', '$2y$10$sG/04wrOKoY/0f50ocgSJuZSRZCw/ccmvhfc1Exa.vos5WGa4dZgm', 'General Manager', 1),
(4, 'test test', 'test', 'test@gmail.com', '$2y$10$TNMDFrM4cGrdr.dIzBLuB.C1UHlWFSMZMsS4wZ3qDlISR2oTlTaFW', 'Branch Manager', 0),
(5, 'diwata', 'diwata', 'diwata@gmail.com', '$2y$10$3.ca7tefWXpGeAu1jzTpRucMej/r/X1ciqf08OTUKquZ2BZM.E0O.', 'Branch Manager', 0),
(6, 'jame lebron', 'lebron', 'ako2@gmail.com', '$2y$10$rZO.K4i3yp3xxEYwyRGKB.nwq9OPlCtWf0kX20TufxY/tcxo70TNO', 'Branch Manager', 1),
(10, 'joshua padilla', 'master', 'joshuapadilla@gmail.com', '$2y$10$g23CGJpfn3dmpyM5WkeZK.rpIemYB9YO6uVDiDGUEMujcVx51jncu', 'Branch Manager', 1);

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
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`stock_in_id`);

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
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `stock_in_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `branches`
--
ALTER TABLE `branches`
  ADD CONSTRAINT `branches_ibfk_1` FOREIGN KEY (`branch_manager_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
