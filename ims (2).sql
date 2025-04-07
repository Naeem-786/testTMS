-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2025 at 09:40 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ims`
--

-- --------------------------------------------------------

--
-- Table structure for table `addneworder`
--

CREATE TABLE `addneworder` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `client_name` varchar(100) NOT NULL,
  `cnic` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `stitching_type` varchar(10) NOT NULL,
  `delivery_date` date NOT NULL,
  `delivery_type` varchar(10) NOT NULL,
  `product` varchar(20) NOT NULL,
  `rate` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `sub_total` int(11) NOT NULL,
  `paid_amount` int(11) DEFAULT NULL,
  `due_amount` int(11) NOT NULL,
  `progress_suit` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addneworder`
--

INSERT INTO `addneworder` (`id`, `date`, `client_name`, `cnic`, `phone`, `stitching_type`, `delivery_date`, `delivery_type`, `product`, `rate`, `quantity`, `sub_total`, `paid_amount`, `due_amount`, `progress_suit`) VALUES
(11, '2025-03-23', '12', '', '03007273392', 'red', '1909-11-11', 'urgent', 'full_suit', 1, 1, 1, 1, 1, 'delivered'),
(12, '2025-03-23', '12', '', '03007273392', 'red', '1909-11-11', 'urgent', 'full_suit', 1, 1, 1, 1, 1, 'delivered'),
(14, '2025-03-24', 'test', '', '03007273392', 'design', '1111-11-21', 'urgent', 'only_shalwar', 1, 1, 1, 1, 1, 'delivered'),
(15, '2025-03-24', 'mosafa', '', '03007273392', 'design', '2025-03-25', 'urgent', 'full_suit', 1, 1, 100, 100, 100, 'delivered'),
(16, '2025-03-24', 'mosafa', '', '03007273392', 'design', '2025-03-25', 'urgent', 'full_suit', 1, 1, 100, 100, 100, 'delivered'),
(17, '2025-03-24', 'mosafa', '', '03007273392', 'design', '2025-03-25', 'urgent', 'full_suit', 1, 1, 100, 100, 100, 'delivered'),
(18, '2025-03-24', 'abc', '', '03217273392', 'design', '1133-11-11', 'urgent', 'full_suit', 1000, 1, 1000, 100, 900, 'delivered'),
(19, '2025-03-24', 'qwa', '', '03217273392', 'design', '1111-11-11', 'urgent', 'full_suit', 1, 11, 11, 11, 1, 'delivered'),
(20, '2025-03-24', 'qwa', '', '03217273392', 'design', '1111-11-11', 'urgent', 'full_suit', 1, 11, 11, 11, 1, 'delivered'),
(21, '2025-03-24', 'qwa', '', '03217273392', 'design', '1111-11-11', 'urgent', 'full_suit', 1, 11, 11, 11, 1, 'delivered'),
(22, '2025-03-24', 'qwa', '', '03217273392', 'design', '1111-11-11', 'urgent', 'full_suit', 1, 11, 11, 11, 1, 'delivered'),
(25, '2025-03-24', 'naeem ahmad', '', '03217273392', 'design', '1111-11-11', 'urgent', 'full_suit', 900, 900, 900, 90, 900, 'delivered'),
(26, '2025-03-24', 'ahmad', '3550102603059', '03217273392', 'simple', '2025-03-29', 'regular', 'full_suit', 1, 1, 1, 1, 1, 'delivered'),
(27, '2025-03-25', 'awais', '3550102603059', '03217273392', 'design', '1111-11-11', 'urgent', 'full_suit', 12, 12, 12, 12, 1, 'delivered'),
(28, '0000-00-00', 'hafiz', '3550102603059', '03217273392', 'design', '2025-03-26', 'urgent', 'only_shalwar', 1, 1, 1, 1, 1, 'delivered'),
(29, '0000-00-00', 'rai', '3550102603059', '03217273392', 'design', '0011-11-11', 'urgent', 'only_qameez', 1, 1, 1, 1, 1, 'delivered'),
(30, '2025-03-25', 'adfasdfasd', '3550102603059', '03217273392', 'simple', '2025-03-28', 'regular', 'full_suit', 1, 1, 1, 1, 1, 'delivered'),
(33, '2025-03-26', 'tayyaba', '3550102603059', '03217273392', 'design', '2025-03-28', 'urgent', 'only_qameez', 1000, 2, 2000, 500, 1500, 'delivered'),
(34, '2025-03-26', 'ali moaaz', '3550102603059', '03217273392', 'design', '2025-03-29', 'urgent', 'only_qameez', 1000, 1, 1000, 500, 500, 'delivered'),
(35, '2025-03-26', 'hamza', '3550102603059', '03217273392', 'design', '0000-00-00', 'regular', 'full_suit', 122, 1, 122, 12, 110, 'delivered'),
(38, '2025-03-26', 'adf', '3550102603059', '03217273392', 'simple', '2025-03-20', 'regular', 'Only Shalwar', 500, 1, 500, 12, 488, 'delivered'),
(39, '2025-03-26', 'xxxxx', '3550102603059', '03217273392', 'simple', '2025-03-28', 'regular', 'Only Shalwar', 500, 1, 500, 1, 499, 'delivered'),
(40, '2025-03-26', 'yyy', '3550102603059', '03217273392', 'simple', '2025-03-28', 'regular', 'full_uit', 123, 2, 246, 100, 146, 'delivered'),
(41, '2025-03-26', 'adf', '3550102603059', '03217273392', 'simple', '2025-03-29', 'regular', 'abc', 12, 1, 12, 1, 11, 'delivered'),
(42, '2025-03-26', 'adf', '3550102603059', '03217273392', 'simple', '2025-03-28', 'regular', 'full_uit', 123, 1, 123, 1, 122, 'delivered'),
(43, '2025-03-26', 'jaffer', '3550102603059', '03217273392', 'design', '2025-03-28', 'urgent', 'Only Shalwar', 500, 2, 1000, 500, 500, 'delivered'),
(44, '2025-03-26', 'new order', '3550102603059', '03217273392', 'simple', '2025-03-28', 'regular', 'pent', 500, 2, 1000, 500, 500, 'delivered'),
(45, '2025-03-26', 'jl', '3550102603059', '03217273392', 'simple', '1111-11-11', 'regular', 'abc', 12, 1, 12, 1, 11, 'delivered'),
(46, '2025-03-26', 'erw', '3550102603059', '03217273392', 'simple', '2025-03-28', 'regular', 'pent', 500, 2, 1000, 1, 999, 'delivered'),
(47, '2025-03-26', 'qqqqyy', '3550102603059', '03217273392', 'simple', '2025-04-03', 'regular', 'full_suit', 1000, 1, 10000, 1, 999, 'delivered'),
(49, '2025-03-27', 'ahmad', '3550102603059', '03217273392', 'simple', '2025-03-29', 'urgent', 'full_uit', 123, 1, 123, 1, 122, 'delivered'),
(50, '2025-03-27', 'test user', '3550102603059', '03217273392', 'simple', '2025-03-30', 'regular', 'pent', 500, 1, 500, 1, 499, 'delivered'),
(52, '2025-03-27', 'amad', '3550102603059', '03217273392', 'design', '2025-03-29', 'regular', 'full_uit', 123, 11, 1353, 1, 1352, 'delivered'),
(53, '2025-03-27', 'xyz', '3440102603059', '03007273392', 'simple', '2025-04-02', 'regular', 'only_qameez', 1000, 2, 2000, 100, 1900, 'delivered'),
(54, '2025-03-28', 'stich', '3550102603059', '03217273392', 'simple', '2025-03-29', 'regular', 'full_uit', 123, 1, 123, 1, 122, 'delivered'),
(55, '2025-04-01', 'aliiyyyyzzz', '3550102603050', '03217273392', 'simple', '2025-04-12', 'regular', 'full_suit', 500, 1, 500, 10, 490, 'delivered'),
(56, '2025-04-01', 'validate', '3550102603059', '03217273390', 'design', '2025-04-25', 'urgent', 'only_qameez', 1000, 10, 1000, 100, 900, 'delivered'),
(57, '2025-04-01', 'rehman', '3550102603059', '03217273392', 'design', '2025-04-04', 'regular', 'full_suit', 500, 2, 1000, 100, 900, 'delivered'),
(58, '2025-04-02', 'naeem', '3550102603059', '03217273392', 'design', '2025-04-03', 'regular', 'full_suit', 1000, 1, 1000, 100, 900, 'delivered'),
(60, '2025-04-02', 'xyc', '3550102603059', '03217273392', 'simple', '2025-04-04', 'regular', 'full_suit', 12, 1, 12, 1, 11, 'delivered'),
(63, '2025-04-05', 'last day', '3550102603059', '03217273392', 'simple', '2025-04-06', 'urgent', 'suits', 1200, 2, 2400, 0, 2400, 'delivered'),
(64, '2025-04-05', 'sadiq', '3550102603059', '03217273392', 'design', '2025-04-07', 'urgent', 'waistcoat', 200, 3, 600, 0, 600, 'delivered'),
(65, '2025-04-05', 'ali', '3550102603059', '03217273392', 'design', '2025-04-07', 'urgent', 'pent', 500, 2, 1000, 100, 900, 'delivered'),
(66, '2025-04-05', 'naeem', '3550102603059', '03217273392', 'simple', '2025-04-07', 'urgent', 'pent', 500, 3, 1500, 0, 1500, 'delivered'),
(67, '2025-04-05', 'moaaz', '3550102603059', '03217273392', 'simple', '2025-04-09', 'urgent', 'waistcoat', 200, 4, 800, 0, 800, 'delivered'),
(68, '2025-04-05', 'xyz', '3550102603050', '03217273390', 'design', '2025-04-06', 'urgent', 'Only Qameez', 1000, 2, 2000, 0, 2000, 'delivered'),
(69, '2025-04-05', 'test', '3550102603059', '03217273392', 'design', '2025-04-07', 'urgent', 'Coat', 2000, 2, 4000, 0, 4000, 'delivered'),
(70, '2025-04-05', 'rehan ', '3550102603059', '03217273392', 'design', '2025-04-07', 'urgent', 'Only Qameez', 1000, 2, 2000, 0, 2000, 'delivered'),
(71, '2025-04-05', 'zeeshan', '3550102603059', '03217273392', 'design', '2025-04-10', 'urgent', 'Coat', 2000, 1, 2000, 0, 2000, 'delivered'),
(72, '2025-04-06', 'shees', '3550102603059', '03217273392', 'simple', '2025-04-08', 'regular', 'Only Qameez', 1000, 2, 2000, 0, 2000, 'delivered'),
(73, '2025-04-06', 'tayyba', '3550102603059', '03217273392', 'design', '2025-04-08', 'urgent', 'Kurta', 1200, 2, 2400, 0, 2400, 'delivered'),
(74, '2025-04-06', 'shaihd', '3550102603059', '03217273392', 'simple', '2025-04-08', 'urgent', 'Only Shalwar', 1000, 1, 1000, 0, 1000, 'delivered'),
(75, '2025-04-06', 'hussain', '3550102603059', '03217273392', 'design', '2025-04-09', 'urgent', 'Only Qameez', 1000, 1, 1000, 0, 1000, 'delivered'),
(76, '2025-04-06', 'Hassan', '3550102603059', '03217273392', 'simple', '2026-03-09', 'regular', 'Kurta', 1200, 1, 1200, 0, 1200, 'delivered'),
(77, '2025-04-07', 'xyz', '3550102603059', '03217273392', 'simple', '2025-04-10', 'urgent', 'Kurta', 1200, 1, 1200, 1000, 200, 'delivered');

-- --------------------------------------------------------

--
-- Table structure for table `employeetbl`
--

CREATE TABLE `employeetbl` (
  `id` int(11) NOT NULL,
  `code` varchar(60) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employeetbl`
--

INSERT INTO `employeetbl` (`id`, `code`, `name`) VALUES
(40, '7', 'NUMAN'),
(43, '31', 'JUIL'),
(44, '32', 'shabaz'),
(46, '34', 'rzwan'),
(53, '35', 'Seam'),
(54, '11', ' Mansoor Ali'),
(55, '3', 'SULMAN'),
(56, '36', 'ALI AKBAR'),
(57, '37', 'JASHAYM'),
(58, '38', 'Asif'),
(59, '39', 'ALI'),
(60, '40', 'LEKHON MIR'),
(61, '41', 'Altaff'),
(62, '42', 'Liquait'),
(63, '43', 'IMTAIZ'),
(64, '100', 'test'),
(65, '1', 'ali'),
(66, '162', 'avc');

-- --------------------------------------------------------

--
-- Table structure for table `payment_tbl`
--

CREATE TABLE `payment_tbl` (
  `id` int(11) NOT NULL,
  `suit_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `discount` int(11) NOT NULL,
  `advance` int(20) NOT NULL,
  `grand_total` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_tbl`
--

INSERT INTO `payment_tbl` (`id`, `suit_id`, `date`, `discount`, `advance`, `grand_total`, `status`) VALUES
(114, 63, '2025-04-05 23:29:38', 0, 0, '2400.00', 'delivered'),
(115, 64, '2025-04-05 23:37:52', 0, 0, '600.00', 'delivered'),
(116, 64, '2025-04-05 23:38:11', 10, 0, '590.00', 'delivered'),
(117, 65, '2025-04-05 23:50:20', 9, 100, '891.00', 'delivered'),
(118, 66, '2025-04-06 08:12:33', 0, 0, '1500.00', 'delivered'),
(119, 66, '2025-04-06 08:12:49', 10, 0, '1490.00', 'delivered'),
(120, 70, '2025-04-06 08:13:30', 0, 0, '2000.00', 'delivered'),
(121, 70, '2025-04-06 08:13:53', 0, 0, '2000.00', 'delivered'),
(122, 67, '2025-04-06 08:14:35', 0, 0, '800.00', 'delivered'),
(123, 67, '2025-04-06 08:14:54', 0, 0, '800.00', 'delivered'),
(124, 68, '2025-04-06 11:12:10', 0, 0, '2000.00', 'delivered'),
(125, 69, '2025-04-06 18:15:12', 0, 0, '4000.00', 'delivered'),
(126, 52, '2025-04-06 18:22:23', 0, 1, '1352.00', 'delivered'),
(127, 53, '2025-04-06 21:38:28', 0, 100, '1900.00', 'delivered'),
(128, 72, '2025-04-06 21:47:52', 0, 0, '2000.00', 'delivered'),
(129, 74, '2025-04-06 22:09:54', 0, 0, '1000.00', 'delivered'),
(130, 75, '2025-04-06 22:39:25', 0, 0, '1000.00', 'delivered'),
(131, 73, '2025-04-06 22:59:18', 0, 0, '2400.00', 'delivered'),
(132, 76, '2026-03-06 23:08:25', 0, 0, '1200.00', 'delivered'),
(133, 77, '2025-04-07 08:21:52', 0, 1000, '200.00', 'delivered');

-- --------------------------------------------------------

--
-- Table structure for table `product_price`
--

CREATE TABLE `product_price` (
  `id` int(11) NOT NULL,
  `p_name` varchar(20) NOT NULL,
  `p_price` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_price`
--

INSERT INTO `product_price` (`id`, `p_name`, `p_price`) VALUES
(9, 'Coat', 2000),
(10, 'pent', 500),
(11, 'waistcoat', 200),
(12, 'Only Shalwar', 1000),
(13, 'Only Qameez', 1000),
(14, 'Kurta', 1200),
(15, 'suits', 1200),
(16, 'coats', 12);

-- --------------------------------------------------------

--
-- Table structure for table `signup`
--

CREATE TABLE `signup` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role_as` varchar(10) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `signup`
--

INSERT INTO `signup` (`id`, `user_name`, `password`, `created_at`, `role_as`) VALUES
(20, 'naeem', '$2y$10$qn.rthtXQUhoZuuhUT2QFOORcCoGGl3klqGrLMYigVnqirQ1nQuau', '2025-04-02 11:40:23', 'user'),
(25, 'test', '$2y$10$nq2BS0r7Vwpu38lJdHNvku8URFxpOpGOa.GbTxiNWOMkWkt2xGvuS', '2025-04-04 00:44:40', 'user'),
(26, 'admin', '$2y$10$c1iKn8BidKXViNbolBhj0OPSiCucdcJoOvT1D7cHx.DXYioJz588W', '2025-04-04 12:48:39', 'Admin'),
(27, 'abc', '$2y$10$rHopbq53XfL28FH8QQeC1.7/y7N9ipQtoBwq6AhR0cF1vmtwxUMQu', '2025-04-07 10:43:57', 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addneworder`
--
ALTER TABLE `addneworder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employeetbl`
--
ALTER TABLE `employeetbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_tbl`
--
ALTER TABLE `payment_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_price`
--
ALTER TABLE `product_price`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `signup`
--
ALTER TABLE `signup`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addneworder`
--
ALTER TABLE `addneworder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `employeetbl`
--
ALTER TABLE `employeetbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `payment_tbl`
--
ALTER TABLE `payment_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `product_price`
--
ALTER TABLE `product_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `signup`
--
ALTER TABLE `signup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
