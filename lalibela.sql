-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 11, 2022 at 03:14 PM
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
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `m_id` int(11) NOT NULL,
  `m_firstname` varchar(255) NOT NULL,
  `m_lastname` varchar(255) NOT NULL,
  `m_companyName` varchar(255) NOT NULL,
  `m_email` varchar(255) NOT NULL,
  `m_phone` varchar(255) NOT NULL,
  `m_dob` date NOT NULL,
  `m_regDate` date NOT NULL,
  `m_expDate` date NOT NULL,
  `m_type` varchar(255) NOT NULL,
  `m_username` varchar(255) NOT NULL,
  `m_pwd` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `promo`
--

CREATE TABLE `promo` (
  `promo_id` int(11) NOT NULL,
  `promo_code` varchar(255) NOT NULL,
  `promo_amount` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `res_guestNo` varchar(255) NOT NULL,
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

INSERT INTO `reservations` (`res_id`, `res_firstname`, `res_lastname`, `res_phone`, `res_email`, `res_guestNo`, `res_checkin`, `res_checkout`, `res_country`, `res_address`, `res_city`, `res_zipcode`, `res_paymentMethod`, `res_roomIDs`, `res_price`, `res_location`, `res_confirmID`) VALUES
(18, 'samuel', 'addisu', '+251944064546', 'samueladdisu9@gmail.com', '', '2022-01-19', '2022-01-20', 'Ethiopia', 'AddisAbaba', 'AddisAbaba', '1000', 'paypal', '[\"12\",\"13\",\"15\"]', '572', 'Bishoftu', ''),
(19, 'samuel', 'addisu', '+251944064546', 'samueladdisu9@gmail.com', '', '2022-01-05', '2022-01-06', 'Ethiopia', 'AddisAbaba', 'AddisAbaba', '1000', 'paypal', '[\"12\",\"13\"]', '350', 'Bishoftu', ''),
(20, 'samuel', 'addisu', '+251944064546', 'samueladdisu9@gmail.com', '', '2022-01-04', '2022-01-05', 'Ethiopia', 'AddisAbaba', 'AddisAbaba', '1000', 'paypal', '[\"12\",\"13\"]', '350', 'Bishoftu', ''),
(21, 'samuel', 'addisu', '+251944064546', 'samueladdisu9@gmail.com', '', '2022-01-04', '2022-01-05', 'Ethiopia', 'AddisAbaba', 'AddisAbaba', '1000', 'amole', '[\"12\",\"13\"]', '350', 'Bishoftu', '941908946'),
(22, 'samuel', 'addisu', '+251944064546', 'samueladdisu9@gmail.com', '', '2022-01-04', '2022-01-05', 'Ethiopia', 'AddisAbaba', 'AddisAbaba', '1000', 'paypal', '[\"12\",\"13\"]', '350', 'Bishoftu', '1030094722'),
(23, 'samuel', 'addisu', '+251944064546', 'samueladdisu9@gmail.com', '', '2022-01-04', '2022-01-05', 'Ethiopia', 'AddisAbaba', 'AddisAbaba', '1000', 'paypal', '[\"12\",\"13\"]', '350', 'Bishoftu', '2M4Dr0o9'),
(24, 'samuel', 'addisu', '+251944064546', 'samueladdisu9@gmail.com', '', '2022-01-04', '2022-01-05', 'Ethiopia', 'AddisAbaba', 'AddisAbaba', '1000', 'paypal', '[\"12\",\"13\"]', '350', 'Bishoftu', '8jgjpUaw'),
(25, 'samuel', 'addisu', '+251944064546', 'samueladdisu9@gmail.com', '', '2022-01-05', '2022-01-06', 'Ethiopia', 'AddisAbaba', 'AddisAbaba', '1000', 'paypal', '[\"12\",\"13\",\"15\"]', '572', 'Bishoftu', 'pZOfokIC'),
(26, 'samuel', 'addisu', '+251944064546', 'samueladdisu9@gmail.com', '', '2022-01-05', '2022-01-06', 'Ethiopia', 'AddisAbaba', 'AddisAbaba', '1000', 'paypal', '[\"10\"]', '150', '', 'yvPRL9ki'),
(27, 'samuel', 'addisu', '+251944064546', 'samueladdisu9@gmail.com', '', '2022-01-26', '2022-01-27', 'Ethiopia', 'AddisAbaba', 'AddisAbaba', '1000', 'paypal', '[\"12\",\"13\",\"15\"]', '572', 'Bishoftu', 'bGhJVgA7'),
(28, 'samuel', 'addisu', '+251944064546', 'samueladdisu9@gmail.com', '', '2022-01-05', '2022-01-06', 'Ethiopia', 'AddisAbaba', 'AddisAbaba', '1000', 'paypal', '[\"12\",\"13\",\"15\"]', '572', 'Bishoftu', 'zsOql2Xe'),
(29, '', '', '', '', '', '2022-01-05', '2022-01-06', '', '', '', '', 'amole', '[\"10\"]', '150', '', 'XAQZrKRh'),
(30, '', '', '', '', '', '2022-01-05', '2022-01-06', '', '', '', '', 'paypal', '[\"10\"]', '150', '', 'RAL1tjzL'),
(31, 'samuel', 'addisu', '+251944064546', 'samueladdisu9@gmail.com', '', '0000-00-00', '0000-00-00', 'Ethiopia', 'AddisAbaba', 'AddisAbaba', '1000', 'paypal', '[\"24\",\"25\"]', '484', '', 'yoBetOBY'),
(32, 'samuel', 'addisu', '+251944064546', 'samueladdisu9@gmail.com', '', '0000-00-00', '0000-00-00', 'Ethiopia', 'AddisAbaba', 'AddisAbaba', '1000', 'amole', '[\"24\",\"25\"]', '484', '', '7FUdaVVj'),
(33, 'samuel', 'addisu', '+251944064546', 'samueladdisu9@gmail.com', '', '0000-00-00', '0000-00-00', 'Ethiopia', 'AddisAbaba', 'AddisAbaba', '1000', 'paypal', '[\"24\",\"25\"]', '484', '', 'r3e5cos6'),
(34, 'samuel', 'addisu', '+251944064546', 'samueladdisu9@gmail.com', '', '0000-00-00', '0000-00-00', 'Ethiopia', 'AddisAbaba', 'AddisAbaba', '1000', 'paypal', '[\"24\",\"24\"]', '300', '', 'TmKmCByR'),
(35, 'samuel', 'addisu', '+251944064546', 'samueladdisu9@gmail.com', '', '0000-00-00', '0000-00-00', 'Ethiopia', 'AddisAbaba', 'AddisAbaba', '1000', 'paypal', '[\"24\",\"24\"]', '300', '', 'TaVu2x29'),
(36, 'samuel', 'addisu', '+251944064546', 'samueladdisu9@gmail.com', '', '0000-00-00', '0000-00-00', 'Ethiopia', 'AddisAbaba', 'AddisAbaba', '1000', 'paypal', '[\"24\",\"24\"]', '300', '', 'DAFId0l2');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `room_occupancy` varchar(255) NOT NULL,
  `room_acc` varchar(255) NOT NULL,
  `room_price` varchar(255) NOT NULL,
  `room_image` varchar(255) NOT NULL,
  `room_number` varchar(255) NOT NULL,
  `room_status` varchar(255) NOT NULL DEFAULT 'Not_booked',
  `room_location` varchar(255) NOT NULL,
  `room_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_occupancy`, `room_acc`, `room_price`, `room_image`, `room_number`, `room_status`, `room_location`, `room_desc`) VALUES
(24, '4', 'Deluxe Lake Front king size bed', '150', 'KURIFTU Afar-0728-min.jpg', '432', 'Not_booked', 'Bishoftu', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'),
(25, '4', 'Presidential Suite Family', '334', 'P3.5 Due Diligence.jpg', 'P1', 'Not_booked', 'Bishoftu', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'),
(26, '4', 'Presidential Suite Family', '150', 'code.jpg', '432', 'Not_booked', 'Bishoftu', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'),
(27, '4', 'Deluxe Lake Front king size bed', '334', 'Screenshot (1).png', '99', 'Not_booked', 'Bishoftu', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'),
(28, '4', '', '150', 'medical-250x250.jpg', 'P1', 'booked', 'Bishoftu', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.');

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
(14, 'Standard', 'Adama'),
(15, 'Standard', 'Adama'),
(18, 'Presidential Suite Family', 'Bishoftu'),
(19, 'Presidential Suite King Size Bed', 'Bishoftu'),
(20, 'Deluxe Lake Front king size bed', 'Bishoftu'),
(21, 'Deluxe Lake Front Twin Beds', 'Bishoftu'),
(22, 'Top Lake View King Size Bed', 'Bishoftu');

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
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`m_id`);

--
-- Indexes for table `promo`
--
ALTER TABLE `promo`
  ADD PRIMARY KEY (`promo_id`);

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
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promo`
--
ALTER TABLE `promo`
  MODIFY `promo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `res_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `room_type`
--
ALTER TABLE `room_type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
