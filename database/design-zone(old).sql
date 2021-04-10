-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 16, 2021 at 06:28 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `design-zone`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin_role` varchar(255) NOT NULL DEFAULT 'ADMIN_MODERATOR'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `mail`, `password`, `admin_role`) VALUES
(1, 'NGC Admin', 'admin@admin.com', '$2y$10$oNTqpVmDm6nFtZW7T9On0.saQZ1Xuq4XHj3nW6/stfZ4gMD1RZGva', 'ADMIN_SUPER');

-- --------------------------------------------------------

--
-- Table structure for table `design_event`
--

CREATE TABLE `design_event` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `instructions` text NOT NULL,
  `prizes` text NOT NULL,
  `duration` varchar(255) NOT NULL,
  `start_time` varchar(255) NOT NULL,
  `end_time` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `registration` varchar(8) NOT NULL DEFAULT 'open',
  `registration_starts` varchar(255) NOT NULL,
  `registration_ends` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `design_event`
--

INSERT INTO `design_event` (`id`, `name`, `description`, `instructions`, `prizes`, `duration`, `start_time`, `end_time`, `image`, `registration`, `registration_starts`, `registration_ends`, `created_by`, `created_on`) VALUES
(1, 'Demo Event', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Earum repellat alias aperiam, tempora suscipit minus ipsam neque porro sequi atque quaerat quod deleniti tempore rem vitae. Est similique aliquam explicabo cumque illum, obcaecati eius. Quam, soluta recusandae. Animi porro corporis officia, repudiandae voluptates nam dolorum fugit aperiam nesciunt dolores, eos totam velit inventore dolorem voluptatem accusamus. At aspernatur culpa ut corporis, amet impedit consequuntur distinctio hic beatae ipsa reiciendis excepturi nesciunt ratione praesentium deserunt tenetur libero iure dolor mollitia? Harum fugiat, unde deleniti aperiam minima voluptatem officiis vel ullam excepturi non beatae asperiores quo, dicta in debitis laboriosam. Consequatur sapiente quis aliquid exercitationem. Sed velit, hic dolorem adipisci nostrum esse ipsam harum maxime nobis deserunt aut aliquid ut repudiandae quae totam suscipit excepturi laborum temporibus aperiam, nulla culpa facilis. Laudantium ea tenetur officia assumenda amet harum voluptas quis nulla quam similique libero eaque asperiores ullam non hic culpa, autem, sed quibusdam! Quae assumenda possimus magni ullam id! Magnam sequi ipsa illo reiciendis voluptate, sunt ipsum nostrum veniam soluta necessitatibus obcaecati minus iste delectus exercitationem provident ducimus omnis dolorem recusandae quo id beatae ab error? Vero quod sequi, assumenda voluptate, doloremque, eum ut laborum laudantium explicabo reprehenderit autem iure! Illo, sed.', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Commodi ut reprehenderit nihil facilis, nostrum magni doloribus vel eaque quos voluptatum officiis facere ipsa accusantium fugit, libero veniam dignissimos, accusamus omnis quo mollitia? Voluptatem, pariatur mollitia quisquam provident laborum, perspiciatis esse nulla quibusdam labore reiciendis dolorum sed eveniet ea. Fuga libero consequuntur omnis reprehenderit praesentium optio perspiciatis exercitationem! Nulla delectus odit eaque commodi distinctio alias obcaecati sed nobis corrupti nam consectetur qui, voluptas accusamus voluptatem id. Vel dolorum debitis aut repellat itaque. In aut provident soluta ut necessitatibus quam quidem eius id corrupti fuga ipsam alias mollitia sed, consectetur similique sint?', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Perferendis inventore iste laboriosam consequatur eum praesentium ullam possimus adipisci atque beatae aliquid qui, asperiores voluptate exercitationem commodi illum sequi sit quia ad at dolores impedit fugit aut odit? Corporis odio praesentium doloribus, rem exercitationem voluptas esse dolores enim veniam, quis nulla!', '3 Hours', '2021-03-16 22:00:00', '2021-03-17 03:00:00', 'https://appsmaventech.com/images/blog/The-Evolution-Of-Web-Development-Via-Machine-Learning.jpg', 'open', '2021-03-15 22:00:00', '2021-03-16 23:00:00', 1, '2021-03-15 20:07:44');

-- --------------------------------------------------------

--
-- Table structure for table `design_event_codes`
--

CREATE TABLE `design_event_codes` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `event_id` int(11) NOT NULL,
  `html_code` mediumtext NOT NULL,
  `css_code` mediumtext NOT NULL,
  `js_code` mediumtext NOT NULL,
  `saved_on` datetime NOT NULL DEFAULT current_timestamp(),
  `last_saved_on` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `output_placeholder` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `design_event_codes`
--

INSERT INTO `design_event_codes` (`id`, `user_id`, `event_id`, `html_code`, `css_code`, `js_code`, `saved_on`, `last_saved_on`, `output_placeholder`) VALUES
(1, 1, 1, '<h1 onclick=\'giveAlert()\'> Hello </h1> ', 'h1 {\n    color: red;\n}', 'document.getElementsByTagName(\"h1\")[0].style.backgroundColor = \"Blue\";', '2021-03-16 01:24:18', '2021-03-16 01:25:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `design_event_moderator`
--

CREATE TABLE `design_event_moderator` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `design_event_registration`
--

CREATE TABLE `design_event_registration` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `event_id` int(11) NOT NULL,
  `response` tinyint(1) NOT NULL DEFAULT 0,
  `moderator_id` int(11) NOT NULL DEFAULT -1,
  `response_on` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `requested_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `design_event_registration`
--

INSERT INTO `design_event_registration` (`id`, `user_id`, `event_id`, `response`, `moderator_id`, `response_on`, `requested_on`) VALUES
(4, 1, 1, 0, -1, NULL, '2021-03-16 22:29:21');

-- --------------------------------------------------------

--
-- Table structure for table `design_event_results`
--

CREATE TABLE `design_event_results` (
  `id` bigint(20) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `moderator_id` int(11) NOT NULL,
  `ui_points` tinyint(4) NOT NULL,
  `ux_points` tinyint(4) NOT NULL,
  `color_points` tinyint(4) NOT NULL,
  `code_points` tinyint(4) NOT NULL,
  `submitted_on` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_on` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `country` varchar(70) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `coins` int(11) NOT NULL DEFAULT 0,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `registered_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `mail`, `password`, `birth_date`, `gender`, `phone`, `country`, `image`, `coins`, `verified`, `registered_on`) VALUES
(1, 'Rajat Patil', 'patilrajat805@gmail.com', '$2y$10$oNTqpVmDm6nFtZW7T9On0.saQZ1Xuq4XHj3nW6/stfZ4gMD1RZGva', NULL, NULL, NULL, NULL, 'Pass -> 1234', 0, 0, '2021-03-15 19:28:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `design_event`
--
ALTER TABLE `design_event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `design_event_codes`
--
ALTER TABLE `design_event_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `design_event_moderator`
--
ALTER TABLE `design_event_moderator`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_moderator` (`event_id`);

--
-- Indexes for table `design_event_registration`
--
ALTER TABLE `design_event_registration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `design_event_results`
--
ALTER TABLE `design_event_results`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `design_event`
--
ALTER TABLE `design_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `design_event_codes`
--
ALTER TABLE `design_event_codes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `design_event_moderator`
--
ALTER TABLE `design_event_moderator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `design_event_registration`
--
ALTER TABLE `design_event_registration`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `design_event_results`
--
ALTER TABLE `design_event_results`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `design_event`
--
ALTER TABLE `design_event`
  ADD CONSTRAINT `design_event_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `admin` (`id`);

--
-- Constraints for table `design_event_codes`
--
ALTER TABLE `design_event_codes`
  ADD CONSTRAINT `design_event_codes_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `design_event` (`id`),
  ADD CONSTRAINT `design_event_codes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `design_event_moderator`
--
ALTER TABLE `design_event_moderator`
  ADD CONSTRAINT `event_moderator` FOREIGN KEY (`event_id`) REFERENCES `design_event` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
