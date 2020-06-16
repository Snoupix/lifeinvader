-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 16, 2020 at 06:44 PM
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
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `usernameFK` varchar(50) NOT NULL,
  `message` varchar(500) NOT NULL,
  `image` varchar(50) DEFAULT 'NULL',
  `likes` int(2) NOT NULL DEFAULT '0',
  `date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`usernameFK`, `message`, `image`, `likes`, `date`) VALUES
('Bob-Lee', 'Some fool on the street is sweatin my Chakra. He about to learn the Chakra Attack. I move in and out like some kind of Navy Seal. But I ain’t stealing your ship. I ain’t a Somali pirate. I am Dr. Ray De Angelo Harris, and I am a tug boat captain, about to push your big dumb heavy ass into port so you can get firmly grounded. You dig this nautical trip? We tying knots in here. That’s deep right there.', './assets/postImages/Bob-Lee/20200524012811_1.jpg', 0, 'Lun 8 Juin 07:06'),
('Bob-Lee', 'I don\'t know what to say', 'NULL', 0, 'Lun 8 Juin 07:24'),
('Andy', 'Promotion sur toutes les supersportives', 'NULL', 0, 'Lun 8 Juin 17:35'),
('Bob-Lee', 'Hello', 'NULL', 0, 'Mer 10 Juin 05:06'),
('Bob-Lee', 'I will go to the beach tonight!', 'NULL', 0, 'Mer 10 Juin 06:06'),
('Bob-Lee', 'NULL', './assets/postImages/Bob-Lee/20200515034011_1.jpg', 0, 'Lun 15 Juin 18:06'),
('Andy', 'NULL', './assets/postImages/Andy/20200516184608_1.jpg', 0, 'Lun 15 Juin 19:06'),
('Bob-Lee', 'J\'adore ma moto !', './assets/postImages/Bob-Lee/20200609022105_1.jpg', 0, 'Lun 15 Juin 22:02');

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
('bob', 'Andy'),
('admin', 'Bob-Lee'),
('Andy', 'Bob-Lee'),
('Bob-Lee', 'Andy');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `avatar` varchar(150) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `description` varchar(150) DEFAULT NULL,
  `about` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `avatar`, `type`, `description`, `about`) VALUES
('admin', '$2y$10$hKkKSsW2eJL9FhRdgejHYeB8O9RrQqz2foJY97T6TuEPBwvP1WkQi', './assets/usersAvatar/default.png', NULL, NULL, ''),
('Andy', '$2y$10$1T9R6ryf3g9wvQ.WPhhJmOCuC6WjeasnHHq8bldGJTLKQvXzKEWXS', './assets/usersAvatar/Andy.jpeg', 'PDG Concess SUD', 'Mec à Rachou', ''),
('bob', '$2y$10$fD.817Ws1DMoqmtHrHbIlePmF6fMKbMCyafOkSIirabZQhw9yY9OG', './assets/usersAvatar/bob.jpeg', NULL, NULL, ''),
('Bob-Lee', '$2y$10$QoVWKZZI39yOI5HkNlow2e.RA00S.ancZ9JCNQqyI.orKEFXXOPo.', './assets/usersAvatar/Bob-Lee.jpeg', 'PDG Distillerie', 'Distillateur professionnel', 'I\'m legit, wola.'),
('Premium Deluxe Motorsport', '$2y$10$TAmRfLkuY0DJFL9ktdh1Suno4DvyH7xM7Njh1/PFJaXPmGu8FzMjS', './assets/usersAvatar/Premium Deluxe Motorsport.jpeg', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD KEY `usernameWall` (`usernameFK`);

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
