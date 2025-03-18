-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2025 at 02:30 AM
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
-- Table structure for table `pos_cart`
--

CREATE TABLE `pos_cart` (
  `cart_id` int(11) NOT NULL,
  `cart_prod_id` int(11) NOT NULL,
  `cart_qty` int(11) NOT NULL,
  `cart_branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pos_cart`
--

INSERT INTO `pos_cart` (`cart_id`, `cart_prod_id`, `cart_qty`, `cart_branch_id`) VALUES
(13, 42, 2, 18);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `prod_id` int(11) NOT NULL,
  `prod_code` varchar(60) NOT NULL,
  `prod_name` varchar(60) NOT NULL,
  `prod_price` decimal(19,4) NOT NULL,
  `prod_added_by` int(11) NOT NULL,
  `prod_date_added` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `prod_status` int(11) NOT NULL DEFAULT 1 COMMENT '0=deleted, 1=existing'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`prod_id`, `prod_code`, `prod_name`, `prod_price`, `prod_added_by`, `prod_date_added`, `prod_status`) VALUES
(42, 'P65190', 'IP 11 128 MINT GREEN', 14000.0000, 1, '2025-03-18 01:03:10', 1),
(43, 'P30338', 'IP 11 256 WHITE', 15500.0000, 1, '2025-03-18 01:04:23', 1),
(44, 'P28880', 'IP 11 PRO 256 WHITE', 17500.0000, 1, '2025-03-18 01:05:45', 1),
(45, 'P89924', 'IP 12 256 PINK', 19000.0000, 1, '2025-03-18 01:06:00', 1),
(46, 'P28235', 'IP 11 PRO 256', 17500.0000, 1, '2025-03-18 01:23:46', 1),
(47, 'P70948', 'IP 11 256 WHITE', 15500.0000, 1, '2025-03-18 01:24:02', 1);

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
(30, 18, 42, 7, 0, 0, '2025-03-18 01:13:49', 1);

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
-- AUTO_INCREMENT for table `pos_cart`
--
ALTER TABLE `pos_cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `stock_in_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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
