-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2021 at 09:00 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `code`
--

CREATE TABLE `code` (
  `id_code` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `code` varchar(6) NOT NULL,
  `created_at` datetime NOT NULL,
  `expiration` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `code`
--

INSERT INTO `code` (`id_code`, `user_id`, `code`, `created_at`, `expiration`) VALUES
(1, 5, '084153', '2021-04-26 22:42:34', '2021-04-26 22:43:34'),
(2, 6, '943071', '2021-04-26 22:43:35', '2021-04-26 22:44:35'),
(3, 5, '360157', '2021-04-26 22:51:01', '2021-04-26 22:52:01'),
(4, 5, '260785', '2021-04-26 22:55:38', '2021-04-26 22:56:38'),
(5, 6, '635497', '2021-04-26 23:03:10', '2021-04-26 23:04:10'),
(6, 6, '945678', '2021-04-26 23:05:35', '2021-04-26 23:06:35'),
(7, 5, '063954', '2021-04-26 23:07:43', '2021-04-26 23:08:43'),
(8, 6, '527194', '2021-04-26 23:16:33', '2021-04-26 23:17:33'),
(9, 6, '591632', '2021-04-26 23:17:56', '2021-04-26 23:18:56'),
(10, 5, '846725', '2021-04-26 23:18:16', '2021-04-26 23:19:16'),
(11, 7, '254673', '2021-04-26 23:28:26', '2021-04-26 23:29:26');

-- --------------------------------------------------------

--
-- Table structure for table `event_log`
--

CREATE TABLE `event_log` (
  `eID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `Activity` varchar(50) NOT NULL,
  `date_time` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_log`
--

INSERT INTO `event_log` (`eID`, `userID`, `Activity`, `date_time`) VALUES
(173, 6, 'Login', '2021-04-26 23:16:33.000000'),
(174, 6, 'Authentication', '2021-04-26 23:16:40.000000'),
(175, 6, 'Logout', '2021-04-26 23:16:48.000000'),
(176, 6, 'Login', '2021-04-26 23:17:56.000000'),
(177, 6, 'Authentication', '2021-04-26 23:18:02.000000'),
(178, 6, 'Logout', '2021-04-26 23:18:08.000000'),
(179, 5, 'Login', '2021-04-26 23:18:16.000000'),
(180, 5, 'Authentication', '2021-04-26 23:18:22.000000'),
(181, 5, 'Logout', '2021-04-26 23:18:27.000000'),
(182, 7, 'Create Account', '2021-04-26 23:26:52.000000'),
(183, 7, 'Login', '2021-04-26 23:28:26.000000'),
(184, 7, 'Authentication', '2021-04-26 23:28:33.000000'),
(185, 7, 'Logout', '2021-04-27 00:03:23.000000'),
(186, 5, 'Forget Password', '2021-04-27 00:03:33.000000');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(3, 'ADMIN', '$2y$10$9qsxwkPAshS90rfq7PDdT.JeTkDFbkvqy3PvX2/ycKu4pFiAIlARu', 'adminto@gmail.com', '2021-03-02 16:49:59'),
(5, 'jang', '$2y$10$9qsxwkPAshS90rfq7PDdT.JeTkDFbkvqy3PvX2/ycKu4pFiAIlARu', 'jang@gmail.com', '2021-04-24 21:26:08'),
(6, 'jiza', '$2y$10$9qsxwkPAshS90rfq7PDdT.JeTkDFbkvqy3PvX2/ycKu4pFiAIlARu', 'jizatua21@gmail.com', '2021-04-25 19:38:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `code`
--
ALTER TABLE `code`
  ADD PRIMARY KEY (`id_code`);

--
-- Indexes for table `event_log`
--
ALTER TABLE `event_log`
  ADD PRIMARY KEY (`eID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `code`
--
ALTER TABLE `code`
  MODIFY `id_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `event_log`
--
ALTER TABLE `event_log`
  MODIFY `eID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
