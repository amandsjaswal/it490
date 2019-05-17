-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 06, 2019 at 04:16 PM
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
-- Database: `spoonacular`
--

-- --------------------------------------------------------

--
-- Table structure for table `calories`
--

DROP TABLE IF EXISTS `calories`;
CREATE TABLE IF NOT EXISTS `calories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `calories` int(11) NOT NULL,
  `d_date` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favourites`
--

DROP TABLE IF EXISTS `favourites`;
CREATE TABLE IF NOT EXISTS `favourites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `food_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `favourites`
--

INSERT INTO `favourites` (`id`, `food_id`, `user_id`) VALUES
(1, 271426, 1);

-- --------------------------------------------------------

--
-- Table structure for table `food_plan`
--

DROP TABLE IF EXISTS `food_plan`;
CREATE TABLE IF NOT EXISTS `food_plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `food_id` varchar(500) NOT NULL,
  `d_date` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `food_plan`
--

INSERT INTO `food_plan` (`id`, `user_id`, `food_id`, `d_date`) VALUES
(5, 1, '337287,334022,', '06, May 2019');

-- --------------------------------------------------------

--
-- Table structure for table `paypal_transactions`
--

DROP TABLE IF EXISTS `paypal_transactions`;
CREATE TABLE IF NOT EXISTS `paypal_transactions` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(500) NOT NULL,
  `payment_id` varchar(500) NOT NULL,
  `hash` varchar(500) NOT NULL,
  `price` float NOT NULL,
  `complete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paypal_transactions`
--

INSERT INTO `paypal_transactions` (`id`, `user_id`, `payment_id`, `hash`, `price`, `complete`) VALUES
(1, '1', 'PAYID-LSOMTCI37621883EU659050J', 'b87b6e816c6534415faa02838d8c1bb0', 40, 0),
(2, '1', 'PAYID-LSONX4A8UM06906KH768013K', '1aeacfb971b9560ae6ac092b720ac066', 29, 0),
(3, '1', 'PAYID-LSOQREQ2X126533HP5149608', '8b7042b61df4a76b6917eaf86292dbe1', 29, 0),
(4, '1', 'PAYID-LSOQYVA52A19287L2257681F', '37c600cb4d44424aaadabf7ec8a9e867', 12, 1),
(5, '1', 'PAYID-LTIF26Q4Y796942G1075381X', '564ded9ebb0c6025bb6d6cc0da497d53', 29, 0);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

DROP TABLE IF EXISTS `purchases`;
CREATE TABLE IF NOT EXISTS `purchases` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `purchased_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `user_id`, `food_id`, `purchased_at`) VALUES
(1, 1, 397872, '2019-03-28 18:04:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(500) NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'user', 'user@gmail.com', 'e10adc3949ba59abbe56e057f20f883e'),
(2, 'usher', 'usher@gmail.com', 'e10adc3949ba59abbe56e057f20f883e'),
(3, 'davis', 'davis@gsolt.com', 'e10adc3949ba59abbe56e057f20f883e');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
