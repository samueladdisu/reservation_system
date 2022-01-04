-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2022 at 03:10 PM
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
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `location_id` int(11) NOT NULL,
  `location_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`location_id`, `location_name`) VALUES
(2, 'Bishoftu'),
(3, 'Adama'),
(4, 'Awash');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `res_id` int(11) NOT NULL,
  `res_firstname` varchar(255) NOT NULL,
  `res_lastname` varchar(255) NOT NULL,
  `res_phone` varchar(255) NOT NULL,
  `res_email` varchar(255) NOT NULL,
  `res_checkin` date NOT NULL,
  `res_checkout` date NOT NULL,
  `res_country` varchar(255) NOT NULL,
  `res_address` varchar(255) NOT NULL,
  `res_city` varchar(255) NOT NULL,
  `res_zipcode` varchar(255) NOT NULL,
  `res_paymentMethod` varchar(255) NOT NULL,
  `res_roomIDs` varchar(255) NOT NULL,
  `res_price` varchar(255) NOT NULL,
  `res_location` varchar(255) NOT NULL,
  `res_confirmID` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`res_id`, `res_firstname`, `res_lastname`, `res_phone`, `res_email`, `res_checkin`, `res_checkout`, `res_country`, `res_address`, `res_city`, `res_zipcode`, `res_paymentMethod`, `res_roomIDs`, `res_price`, `res_location`, `res_confirmID`) VALUES
(18, 'samuel', 'addisu', '+251944064546', 'samueladdisu9@gmail.com', '2022-01-19', '2022-01-20', 'Ethiopia', 'AddisAbaba', 'AddisAbaba', '1000', 'paypal', '[\"12\",\"13\",\"15\"]', '572', 'Bishoftu', ''),
(19, 'samuel', 'addisu', '+251944064546', 'samueladdisu9@gmail.com', '2022-01-05', '2022-01-06', 'Ethiopia', 'AddisAbaba', 'AddisAbaba', '1000', 'paypal', '[\"12\",\"13\"]', '350', 'Bishoftu', ''),
(20, 'samuel', 'addisu', '+251944064546', 'samueladdisu9@gmail.com', '2022-01-04', '2022-01-05', 'Ethiopia', 'AddisAbaba', 'AddisAbaba', '1000', 'paypal', '[\"12\",\"13\"]', '350', 'Bishoftu', ''),
(21, 'samuel', 'addisu', '+251944064546', 'samueladdisu9@gmail.com', '2022-01-04', '2022-01-05', 'Ethiopia', 'AddisAbaba', 'AddisAbaba', '1000', 'amole', '[\"12\",\"13\"]', '350', 'Bishoftu', '941908946'),
(22, 'samuel', 'addisu', '+251944064546', 'samueladdisu9@gmail.com', '2022-01-04', '2022-01-05', 'Ethiopia', 'AddisAbaba', 'AddisAbaba', '1000', 'paypal', '[\"12\",\"13\"]', '350', 'Bishoftu', '1030094722'),
(23, 'samuel', 'addisu', '+251944064546', 'samueladdisu9@gmail.com', '2022-01-04', '2022-01-05', 'Ethiopia', 'AddisAbaba', 'AddisAbaba', '1000', 'paypal', '[\"12\",\"13\"]', '350', 'Bishoftu', '2M4Dr0o9'),
(24, 'samuel', 'addisu', '+251944064546', 'samueladdisu9@gmail.com', '2022-01-04', '2022-01-05', 'Ethiopia', 'AddisAbaba', 'AddisAbaba', '1000', 'paypal', '[\"12\",\"13\"]', '350', 'Bishoftu', '8jgjpUaw');

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
(13, '1', '4', 'King', '200', 'Kuriftu_Bishoftu_Exerior.png', 432, 'Not_booked', 'Bishoftu'),
(14, '4', '', 'single', '150', 'KURIFTU Afar-0728-min.jpg', 432, 'Not_booked', 'Awash'),
(15, '2', '10', 'new bed', '222', 'kuriftu resort logo afar white copy-min.png', 3, 'Not_booked', 'Bishoftu');

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
(10, 'king', 'Adama'),
(11, 'Deluxe', 'Entoto'),
(12, 'Deluxe', 'Bishoftu'),
(13, 'Deluxe', 'Bishoftu'),
(14, 'Standard', 'Adama'),
(15, 'Standard', 'Adama'),
(16, 'king', 'Bishoftu');

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
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`location_id`);

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
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `res_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `room_type`
--
ALTER TABLE `room_type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
