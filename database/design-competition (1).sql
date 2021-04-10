-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 10, 2021 at 11:54 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `design-competition`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin_role` varchar(255) NOT NULL DEFAULT 'ADMIN_MODERATOR'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `mail`, `password`, `admin_role`) VALUES
(1, 'NGC ADMIN', 'admin@admin.com', '$2y$10$rTzTbuZyHyP/UJfzOrOrCuwwi.goq5CckQoADEwgG.z.7Qv5ccFj.', 'ADMIN_SUPER'),
(6, 'Nikhil Kawadkar', 'nikhi@admin.com', '$2y$10$7.WCrUGrVN6/VRes269xy.XWUxSevqwQN4ChXa0DilQFIsSLLmiQu', 'ADMIN_MODERATOR');

-- --------------------------------------------------------

--
-- Table structure for table `codes`
--

CREATE TABLE `codes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `html` text NOT NULL,
  `css` text NOT NULL,
  `js` text NOT NULL,
  `snapshot` varchar(255) NOT NULL,
  `moderator_1` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `codes`
--

INSERT INTO `codes` (`id`, `user_id`, `html`, `css`, `js`, `snapshot`, `moderator_1`) VALUES
(1, 2, '<h1 onclick=\'giveAlert()\'> Hello users </h1>', 'h1 {\n    color: yellow;\n}', 'function giveAlert() {\n    alert(\'Alert Msg is Called\');\n}', 'https://colorlib.com/wp/wp-content/uploads/sites/2/featured_electrician-website-templates-800x560.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `evaluations`
--

CREATE TABLE `evaluations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `moderator_id` int(11) NOT NULL,
  `code_id` int(11) NOT NULL,
  `points` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `evaluations`
--

INSERT INTO `evaluations` (`id`, `user_id`, `moderator_id`, `code_id`, `points`) VALUES
(1, 2, 6, 1, 18);

-- --------------------------------------------------------

--
-- Table structure for table `moderators`
--

CREATE TABLE `moderators` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `moderators`
--

INSERT INTO `moderators` (`id`, `name`, `mail`, `password`) VALUES
(1, 'Nikhil Kawadkar', 'nikhi@admin.com', '$2y$10$54J/YQ0KLGc8fdvU2gh/7.xUnLHwd33yOKhxdqIS6XkxJQDLy/Aem');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `request` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `mail`, `password`, `request`) VALUES
(1, 'Rajat Patil', 'rajat@patil.com', '$2y$10$9J.O3eUHcXU7xfSEIRI/Q.kes0TruSRxykACuTVKlJ2cosDMsfH0.', 0),
(2, 'Akram Shaha', 'akram@akram.com', '$2y$10$TC9L05tWSJBQz9DBAZK9mer5XnXx/UoVlAEQmS.c/NjcACUMkGiDa', 1),
(3, 'Nirbhay Bangre', 'nibba@nibba.com', '$2y$10$/J0VRNnPv09h7sSqKr4zyu7RQqX569XSshoSW3023BHBm5tsYSq0i', 2),
(4, 'Mohit Ughemughe', 'mohit@mohit.com', '$2y$10$T9kX4LtlNQRnV2R.CBJuouXGsVOWSBbC9v24SauMUusa10qAGiNB.', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `codes`
--
ALTER TABLE `codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `evaluations`
--
ALTER TABLE `evaluations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `moderator_id` (`moderator_id`),
  ADD KEY `code_id` (`code_id`);

--
-- Indexes for table `moderators`
--
ALTER TABLE `moderators`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `codes`
--
ALTER TABLE `codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `evaluations`
--
ALTER TABLE `evaluations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `moderators`
--
ALTER TABLE `moderators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `codes`
--
ALTER TABLE `codes`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `evaluations`
--
ALTER TABLE `evaluations`
  ADD CONSTRAINT `evaluations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `evaluations_ibfk_2` FOREIGN KEY (`moderator_id`) REFERENCES `admin` (`id`),
  ADD CONSTRAINT `evaluations_ibfk_3` FOREIGN KEY (`code_id`) REFERENCES `codes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
