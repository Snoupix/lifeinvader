-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 03, 2020 at 01:06 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lifeinvader`
--

-- --------------------------------------------------------

--
-- Table structure for table `stalking`
--

CREATE TABLE `stalking` (
  `usernameFK` varchar(150) NOT NULL,
  `stalked` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stalking`
--

INSERT INTO `stalking` (`usernameFK`, `stalked`) VALUES
('Bob-Lee', 'bob'),
('Bob-Lee', 'admin'),
('admin', 'bob'),
('bob', 'Andy');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `avatar` varchar(50) NOT NULL,
  `type` varchar(50) DEFAULT 'Type of account',
  `description` varchar(150) DEFAULT 'Description'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `avatar`, `type`, `description`) VALUES
('admin', '$2y$10$hKkKSsW2eJL9FhRdgejHYeB8O9RrQqz2foJY97T6TuEPBwvP1WkQi', './assets/usersAvatar/default.png', NULL, NULL),
('Andy', '$2y$10$1T9R6ryf3g9wvQ.WPhhJmOCuC6WjeasnHHq8bldGJTLKQvXzKEWXS', './assets/usersAvatar/Andy.jpeg', 'PDG', 'Concess SUD, mec à Rachou'),
('bob', '$2y$10$fD.817Ws1DMoqmtHrHbIlePmF6fMKbMCyafOkSIirabZQhw9yY9OG', './assets/usersAvatar/bob.jpeg', NULL, NULL),
('Bob-Lee', '$2y$10$QoVWKZZI39yOI5HkNlow2e.RA00S.ancZ9JCNQqyI.orKEFXXOPo.', './assets/usersAvatar/Bob-Lee.jpeg', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wall`
--

CREATE TABLE `wall` (
  `usernameFK` varchar(50) NOT NULL,
  `message` varchar(500) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `like` json NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `stalking`
--
ALTER TABLE `stalking`
  ADD KEY `usernameFK` (`usernameFK`) USING HASH;

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`) USING BTREE;

--
-- Indexes for table `wall`
--
ALTER TABLE `wall`
  ADD KEY `usernameWall` (`usernameFK`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `wall`
--
ALTER TABLE `wall`
  ADD CONSTRAINT `usernameWall` FOREIGN KEY (`usernameFK`) REFERENCES `user` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
