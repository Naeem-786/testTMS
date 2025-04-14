-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2025 at 03:17 PM
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
(101, '2025-04-14', 'test', '3550102603059', '03217273392', 'design', '2025-04-17', 'urgent', 'pent', 500, 3, 1500, 0, 1500, 'delivered');

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
(138, 101, '2025-04-14 18:14:56', 0, 0, '1500.00', 'delivered');

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
(26, 'admin', '$2y$10$c1iKn8BidKXViNbolBhj0OPSiCucdcJoOvT1D7cHx.DXYioJz588W', '2025-04-04 12:48:39', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addneworder`
--
ALTER TABLE `addneworder`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `payment_tbl`
--
ALTER TABLE `payment_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

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
