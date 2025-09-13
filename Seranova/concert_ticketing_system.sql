-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2025 at 08:25 PM
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
-- Database: `concert_ticketing_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `concert`
--

CREATE TABLE `concert` (
  `artist_id` int(4) NOT NULL,
  `artistname` text NOT NULL,
  `venue` text NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `concert`
--

INSERT INTO `concert` (`artist_id`, `artistname`, `venue`, `date`, `time`, `image`) VALUES
(1, 'Blackpink', 'Axiata Arena', '2026-06-21', '17:00:00', 'images/blackpink.jpg'),
(2, 'Lana Del Rey', 'Bukit Jalil National Stadium', '2026-04-25', '20:00:00', 'images/LDR.jpg'),
(3, 'G-Dragon', 'Axiata Arena', '2026-04-11', '20:00:00', 'images/GD.jpeg'),
(4, 'Chase Atlantic', 'Bukit Jalil National Stadium', '2026-05-10', '19:30:00', 'images/chase.jpg'),
(5, 'Mitski', 'Axiata Arena', '2026-06-13', '20:00:00', 'images/mitski.jpg'),
(6, 'The Weeknd', 'Bukit Jalil National Stadium', '2026-06-20', '19:30:00', 'images/theweeknd.jpg'),
(7, 'ZAYN', 'Axiata Arena', '2026-04-11', '19:30:00', 'images/zayn.jpg'),
(8, 'Arctic Monkeys', 'Bukit Jalil National Stadium', '2026-09-19', '19:30:00', 'images/arcticmonkeys.jpg'),
(9, 'The Neighborhood', 'Axiata Arena', '2026-06-27', '19:30:00', 'images/theneighborhood.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `receipt`
--

CREATE TABLE `receipt` (
  `receipt_id` int(4) NOT NULL,
  `user_id` int(4) NOT NULL,
  `seat_id` int(4) NOT NULL,
  `artist_id` int(4) NOT NULL,
  `venue` text NOT NULL,
  `purchase_date` date NOT NULL,
  `paymentmethod` text NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receipt`
--

INSERT INTO `receipt` (`receipt_id`, `user_id`, `seat_id`, `artist_id`, `venue`, `purchase_date`, `paymentmethod`, `status`) VALUES
(1, 1, 1, 2, 'Bukit Jalil National Stadium', '2025-05-31', 'Card', 'Purchased');

-- --------------------------------------------------------

--
-- Table structure for table `seat`
--

CREATE TABLE `seat` (
  `seat_id` int(4) NOT NULL,
  `category` text NOT NULL,
  `section` varchar(10) NOT NULL,
  `seat_number` varchar(10) NOT NULL,
  `price` int(100) NOT NULL,
  `availability` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seat`
--

INSERT INTO `seat` (`seat_id`, `category`, `section`, `seat_number`, `price`, `availability`) VALUES
(1, 'Star Club', '-', 'A1', 1588, 1),
(2, 'Star Club', '-', 'A2', 1588, 1),
(3, 'Star Club', '-', 'B1', 1588, 1),
(4, 'Star Club', '-', 'B2', 1588, 1),
(5, 'Star Club', '-', 'C1', 1588, 1),
(6, 'Star Club', '-', 'C2', 1588, 1),
(7, 'Early Entry', '-', 'A1', 878, 1),
(8, 'Early Entry', '-', 'A2', 878, 1),
(9, 'Early Entry', '-', 'B1', 878, 1),
(10, 'Early Entry', '-', 'B2', 878, 1),
(11, 'Early Entry', '-', 'C1', 878, 1),
(12, 'Early Entry', '-', 'C2', 878, 1),
(13, 'The Blur', '-', 'A1', 788, 1),
(14, 'The Blur', '-', 'A2', 788, 1),
(15, 'The Blur', '-', 'B1', 788, 1),
(16, 'The Blur', '-', 'B2', 788, 1),
(17, 'The Blur', '-', 'C1', 788, 1),
(18, 'The Blur', '-', 'C2', 788, 1),
(19, 'CAT 1', '-', 'A1', 598, 1),
(20, 'CAT 1', '-', 'A2', 598, 1),
(21, 'CAT 1', '-', 'B1', 598, 1),
(22, 'CAT 1', '-', 'B2', 598, 1),
(23, 'CAT 1', '-', 'C1', 598, 1),
(24, 'CAT 1', '-', 'C2', 598, 1),
(25, 'CAT 2', '305', 'A1', 688, 1),
(26, 'CAT 2', '305', 'A2', 688, 1),
(27, 'CAT 2', '305', 'B1', 688, 1),
(28, 'CAT 2', '305', 'B2', 688, 1),
(29, 'CAT 2', '305', 'C1', 688, 1),
(30, 'CAT 2', '305', 'C2', 688, 1),
(31, 'CAT 2', '306', 'A1', 688, 1),
(32, 'CAT 2', '306', 'A2', 688, 1),
(33, 'CAT 2', '306', 'B1', 688, 1),
(34, 'CAT 2', '306', 'B2', 688, 1),
(35, 'CAT 2', '306', 'C1', 688, 1),
(36, 'CAT 2', '306', 'C2', 688, 1),
(37, 'CAT 2', '307', 'A1', 688, 1),
(38, 'CAT 2', '307', 'A2', 688, 1),
(39, 'CAT 2', '307', 'B1', 688, 1),
(40, 'CAT 2', '307', 'B2', 688, 1),
(41, 'CAT 2', '307', 'C1', 688, 1),
(42, 'CAT 2', '307', 'C2', 688, 1),
(43, 'CAT 2', '308', 'A1', 688, 1),
(44, 'CAT 2', '308', 'A2', 688, 1),
(45, 'CAT 2', '308', 'B1', 688, 1),
(46, 'CAT 2', '308', 'B2', 688, 1),
(47, 'CAT 2', '308', 'C1', 688, 1),
(48, 'CAT 2', '308', 'C2', 688, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(4) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `firstname`, `lastname`) VALUES
(1, 'admin', '2222', 'yasmin', 'mohd'),
(2, 'wd', '22', 'yasmin', 'Doe'),
(3, 'ww', 'ww', 'ww', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `concert`
--
ALTER TABLE `concert`
  ADD PRIMARY KEY (`artist_id`);

--
-- Indexes for table `receipt`
--
ALTER TABLE `receipt`
  ADD PRIMARY KEY (`receipt_id`),
  ADD KEY `artist_id` (`artist_id`),
  ADD KEY `seat_id` (`seat_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `seat`
--
ALTER TABLE `seat`
  ADD PRIMARY KEY (`seat_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`) USING HASH;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `concert`
--
ALTER TABLE `concert`
  MODIFY `artist_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `receipt`
--
ALTER TABLE `receipt`
  MODIFY `receipt_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `seat`
--
ALTER TABLE `seat`
  MODIFY `seat_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `receipt`
--
ALTER TABLE `receipt`
  ADD CONSTRAINT `receipt_ibfk_1` FOREIGN KEY (`artist_id`) REFERENCES `concert` (`artist_id`),
  ADD CONSTRAINT `receipt_ibfk_2` FOREIGN KEY (`seat_id`) REFERENCES `seat` (`seat_id`),
  ADD CONSTRAINT `receipt_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
