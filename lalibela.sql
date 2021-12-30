-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2021 at 03:12 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lalibela`
--

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `res_id` int(11) NOT NULL,
  `res_room_number` int(11) NOT NULL,
  `res_bedtype` varchar(255) NOT NULL,
  `res_firstname` varchar(255) NOT NULL,
  `res_lastname` varchar(255) NOT NULL,
  `res_phone` varchar(255) NOT NULL,
  `res_email` varchar(255) NOT NULL,
  `res_guest` int(11) NOT NULL,
  `res_checkin` date NOT NULL,
  `res_checkout` date NOT NULL,
  `res_price` varchar(255) NOT NULL,
  `res_location` varchar(255) NOT NULL,
  `res_remark` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `room_occupancy` varchar(255) NOT NULL,
  `room_acc` varchar(255) NOT NULL,
  `room_bed` varchar(255) NOT NULL,
  `room_price` varchar(255) NOT NULL,
  `room_image` varchar(255) NOT NULL,
  `room_number` int(255) NOT NULL,
  `room_status` varchar(255) NOT NULL DEFAULT 'Not_booked',
  `room_location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_occupancy`, `room_acc`, `room_bed`, `room_price`, `room_image`, `room_number`, `room_status`, `room_location`) VALUES
(10, '4', '2', 'single', '150', 'Kuriftu_Room_1.png', 0, 'Not_booked', 'Adama'),
(11, '23', '4', 'single', '150', 'Entoto_Signage.png', 0, 'Not_booked', 'Adama'),
(12, '4', '5', 'King', '150', 'Customer Services_2.png', 12, 'Not_booked', 'Bishoftu'),
(13, '1', '4', 'King', '200', 'Kuriftu_Bishoftu_Exerior.png', 432, 'Not_booked', 'Bishoftu');

-- --------------------------------------------------------

--
-- Table structure for table `room_type`
--

CREATE TABLE `room_type` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(255) NOT NULL,
  `type_location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room_type`
--

INSERT INTO `room_type` (`type_id`, `type_name`, `type_location`) VALUES
(2, 'Deluxe', ''),
(3, 'king', ''),
(4, 'lake front', ''),
(5, 'Presidential Suite', ''),
(7, 'Standard', ''),
(8, 'Standard', ''),
(9, 'Standard', ''),
(10, 'king', 'Adama'),
(11, 'Deluxe', 'Entoto');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_firstName` varchar(255) NOT NULL,
  `user_lastName` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_pwd` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_firstName`, `user_lastName`, `user_name`, `user_pwd`, `user_email`, `user_role`) VALUES
(1, 'samuel', 'addisu', 'sam', 'sam123', 'sam@sam.com', 'admin'),
(2, 'micky', 'tesfaye', 'adama', 'adama123', 'nardi@nardi.com', 'Adama'),
(5, 'betty', 'gebres', 'bishoftu', 'bishoftu123', 'bemni@bemni.com', 'Bishoftu'),
(6, 'bemnt', 'seyoum', 'entoto', 'entoto123', 'gb@gb.com', 'Entoto'),
(7, 'tsion', 'tesfaye', 'tana', 'tana123', 'bemni@bemni.com', 'Lake_Tana'),
(8, 'nolawe', 'gebre', 'awash', 'awash123', 'bemni@bemni.com', 'Awash'),
(9, 'peter', 'tsegaye', 'boston', 'boston123', 'bemni@bemni.com', 'Boston');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`res_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `room_type`
--
ALTER TABLE `room_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `res_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `room_type`
--
ALTER TABLE `room_type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
