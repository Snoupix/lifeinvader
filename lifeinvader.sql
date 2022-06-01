-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 04, 2020 at 03:09 PM
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
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `name` varchar(150) NOT NULL,
  `image` varchar(450) NOT NULL,
  `link` varchar(150) NOT NULL,
  `promo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`name`, `image`, `link`, `promo`) VALUES
('Premium Deluxe Motorsport', './assets/adImages/Premium Deluxe Motorsport.jpeg', 'index.php?username=Premium+Deluxe+Motorsport', '10% discount on your first purchase.'),
('Distillerie Jonhson', './assets/adImages/Distillerie.jpg', 'index.php?username=Distillerie+Jonhson', "Distributeurs d\'alcools depuis longtemps.");

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `idPost` int(255) UNSIGNED NOT NULL,
  `author` varchar(50) NOT NULL,
  `message` varchar(420) NOT NULL,
  `date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`idPost`, `author`, `message`, `date`) VALUES
(9, 'Andy', 'Miss that too', 'Ven 26 Juin 06:43'),
(11, 'admin', 'Nice one !', 'Sam 27 Juin 23:39'),
(9, 'Zola', 'So much', 'Dim 28 Juin 00:39'),
(5, 'Andy', 'Coming!', 'Dim 28 Juin 00:54'),
(13, 'Bob-Lee', "Je suis bien d\'accord !", 'Mar 30 Juin 6:30'),
(14, 'Premium Deluxe Motorsport', 'Not anymore !', 'Sam 04 Juillet 1:45'),
(15, 'Bob-Lee', 'Ouieuuh 23 euuh', 'Sam 04 Juillet 2:29');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(255) UNSIGNED NOT NULL,
  `userWhoLike` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `userWhoLike`) VALUES
(11, 'Andy'),
(8, 'bob'),
(8, 'admin'),
(6, 'Bob-Lee'),
(11, 'Bob-Lee'),
(7, 'Bob-Lee'),
(3, 'Bob-Lee'),
(13, 'Bob-Lee'),
(15, 'Bob-Lee');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(255) UNSIGNED NOT NULL,
  `usernameFK` varchar(50) NOT NULL,
  `message` varchar(420) NOT NULL,
  `image` varchar(450) DEFAULT NULL,
  `date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `usernameFK`, `message`, `image`, `date`) VALUES
(1, 'Bob-Lee', "Some fool on the street is sweatin my Chakra. He about to learn the Chakra Attack. I move in and out like some kind of Navy Seal. But I ain’t stealing your ship. I ain’t a Somali pirate. I am Dr. Ray De Angelo Harris, and I am a tug boat captain, about to push your big dumb heavy ass into port so you can get firmly grounded. You dig this nautical trip? We tying knots in here. That’s deep right there.", './assets/postImages/Bob-Lee/20200524012811_1.jpg', 'Lun 8 Juin 07:06'),
(2, 'Bob-Lee', 'I don\'t know what to say', 'NULL', 'Lun 8 Juin 07:24'),
(3, 'Andy', 'Promotion sur toutes les supersportives', 'NULL', 'Lun 8 Juin 17:35'),
(4, 'Bob-Lee', 'Hello', 'NULL', 'Mer 10 Juin 05:06'),
(5, 'Bob-Lee', 'I will go to the beach tonight!', 'NULL', 'Mer 10 Juin 06:06'),
(6, 'Bob-Lee', 'NULL', './assets/postImages/Bob-Lee/20200515034011_1.jpg', 'Lun 15 Juin 18:06'),
(7, 'Andy', 'NULL', './assets/postImages/Andy/20200516184608_1.jpg', 'Lun 15 Juin 19:06'),
(8, 'Bob-Lee', 'J\'adore ma moto !', './assets/postImages/Bob-Lee/20200609022105_1.jpg', 'Lun 15 Juin 22:02'),
(9, 'Bob-Lee', 'Good old vibes.. Miss you guys.', './assets/postImages/Bob-Lee/20200503041325_1.jpg', 'Sam 20 Juin 6:26'),
(11, 'Bob-Lee', 'NULL', './assets/postImages/Bob-Lee/20200614233444_1.jpg', 'Lun 22 Juin 4:14'),
(12, 'bob', 'Salut Los Santos !', 'NULL', 'Lun 22 Juin 4:15'),
(10, 'Andy', 'Qui sort ce soir ?', 'NULL', 'Mar 23 Juin 20:42'),
(13, 'Zola', 'Les plus beaux', './assets/postImages/Zola/20200604194858_1.jpg', 'Dim 28 Juin 0:35'),
(14, 'Premium Deluxe Motorsport', 'We\'re opened tonight !', 'NULL', 'Mer 01 Juillet 0:34'),
(15, 'Distillerie Jonhson', 'Nous aimons l\'alcool. (Et, accessoirement, nous en vendons !)', './assets/postImages/Distillerie/20200610000658_1.jpg', 'Sam 04 Juillet 2:19'),
(16, 'admin', 'Hello', 'NULL', 'Sam 04 Juillet 5:04');

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
('admin', 'bob'),
('bob', 'Andy'),
('admin', 'Bob-Lee'),
('Andy', 'Bob-Lee'),
('Bob-Lee', 'bob'),
('Bob-Lee', 'Premium Deluxe Motorsport'),
('Bob-Lee', 'Andy'),
('Andy', 'Premium Deluxe Motorsport'),
('Bob-Lee', 'Distillerie Jonhson'),
('Andy', 'Distillerie Jonhson'),
('Zola', 'Distillerie Jonhson');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `id` int(11) NOT NULL,
  `uuid` varchar(50) NOT NULL,
  `coowner` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`id`, `uuid`, `coowner`) VALUES
(31, '05b87586-ba68-11ea-b3de-0242ac130054', NULL),
(32, '05b87586-ba68-11ea-b3de-0242ac130054', '05b877ca-ba68-11ea-b3de-0242ac130004');

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
('Bob-Lee', '$2y$10$QoVWKZZI39yOI5HkNlow2e.RA00S.ancZ9JCNQqyI.orKEFXXOPo.', './assets/usersAvatar/Bob-Lee.jpeg', 'PDG Distillerie', 'Distillateur professionnel', 'Ancien Marine, sniper d\'élite.'),
('Distillerie Jonhson', '$2y$10$isqwxjEap3H7n16DYgy6e.rVGXOMCSLT9zo3hBdpbmyaCtL8IemzK', './assets/usersAvatar/Distillerie.jpeg', 'Entreprise', 'Distillateur de tout types d\'alcool.', 'Nous travaillons avec tout notre cœur pour vous proposer le meilleur alcool que vous avez jamais bu.'),
('Premium Deluxe Motorsport', '$2y$10$TAmRfLkuY0DJFL9ktdh1Suno4DvyH7xM7Njh1/PFJaXPmGu8FzMjS', './assets/usersAvatar/Premium Deluxe Motorsport.jpeg', NULL, NULL, NULL),
('Zola', '$2y$10$AXnQE07nlsF/1YnOPsVsge6VFD4B67mQLA8dM6/6W42GS62k4RSG2', './assets/usersAvatar/Zola.jpeg', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD KEY `idPost` (`idPost`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD KEY `postId` (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD KEY `usernameWall` (`usernameFK`),
  ADD KEY `id` (`id`) USING BTREE;

--
-- Indexes for table `stalking`
--
ALTER TABLE `stalking`
  ADD KEY `usernameFK` (`usernameFK`) USING HASH;

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD KEY `Index 1` (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `idPost` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `idPost` FOREIGN KEY (`idPost`) REFERENCES `post` (`id`);

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `postId` FOREIGN KEY (`id`) REFERENCES `post` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
