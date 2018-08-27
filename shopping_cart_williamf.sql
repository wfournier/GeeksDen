-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: sql203.epizy.com
-- Generation Time: Aug 27, 2018 at 01:05 PM
-- Server version: 5.6.41-84.1
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `epiz_20957841_shopping_cart_williamf`
--

-- --------------------------------------------------------

--
-- Table structure for table `store_items`
--

CREATE TABLE IF NOT EXISTS `store_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `item_title` varchar(75) CHARACTER SET utf8 DEFAULT NULL,
  `item_price` float DEFAULT NULL,
  `item_desc` text CHARACTER SET utf8,
  `item_image` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `featured` enum('yes','no') CHARACTER SET utf8 NOT NULL,
  `stock` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `store_items`
--

INSERT INTO `store_items` (`id`, `cat_id`, `item_title`, `item_price`, `item_desc`, `item_image`, `featured`, `stock`) VALUES
(1, 1, 'Resident Evil VII: Biohazard', 69.99, 'One of the scariest games of 2017', 'resident_evil7.jpg', 'yes', 26),
(2, 1, 'The Witcher 3: Wild Hunt', 29.99, 'The most epic adventure awaits you!', 'witcher3.jpg', 'no', 25),
(3, 1, 'Dishonored 2', 49.99, 'Join Corvo and Emily on a quest for revenge', 'dishonored2.jpg', 'no', 26),
(4, 2, 'Seven Lions - Days to Come', 19.99, 'The most iconic album from famous DJ Seven Lions', 'days_to_come.jpg', 'yes', 25),
(5, 2, 'deadmau5 - W:/2016ALBUM/', 14.99, 'Latest album from world renowned producer deadmau5', 'w2016album.jpg', 'no', 26),
(6, 2, 'Porter Robinson - Worlds', 9.99, 'Most influencial album of young producer Porter Robinson', 'worlds.jpg', 'no', 26),
(7, 3, 'Interstellar', 24.99, 'Embark on an epic journey throughout the Cosmos to save humankind', 'interstellar.jpg', 'yes', 26),
(8, 3, 'Arrival', 34.99, 'Latest blockbuster from renowned director Denis Villeneuve', 'arrival.jpg', 'no', 25),
(9, 3, 'Doctor Strange', 14.99, 'Latest Entry in the Marvel cinematic universe', 'doctor_strange.jpg', 'no', 26),
(10, 4, 'Dishonored 2 (Corvo/Emily) Shirt', 19.99, 'Very comfortable cotton shirt for the game Dishonored 2', 'dishonored2_shirt.jpg', 'no', 18),
(11, 4, 'Resident Evil VII: Biohazard Shirt', 14.99, 'Very comfortable cotton shirt for the game Resident Evil VII: Biohazard', 'resident_evil7_shirt.jpg', 'no', 18),
(12, 4, 'The Witcher 3: Wild Hunt Shirt', 9.99, 'Very comfortable cotton shirt for the game The Witcher 3: Wild Hunt', 'witcher3_shirt.jpg', 'yes', 27);

-- --------------------------------------------------------

--
-- Table structure for table `store_item_color`
--

CREATE TABLE IF NOT EXISTS `store_item_color` (
  `item_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `item_color` varchar(25) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `store_item_color`
--

INSERT INTO `store_item_color` (`item_id`, `cat_id`, `item_color`) VALUES
(10, 4, 'Red'),
(10, 4, 'Black'),
(10, 4, 'Blue'),
(11, 4, 'Red'),
(11, 4, 'Black'),
(11, 4, 'Blue'),
(12, 4, 'Red'),
(12, 4, 'Black'),
(12, 4, 'Blue');

-- --------------------------------------------------------

--
-- Table structure for table `store_item_edition`
--

CREATE TABLE IF NOT EXISTS `store_item_edition` (
  `item_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `item_edition` varchar(25) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `store_item_edition`
--

INSERT INTO `store_item_edition` (`item_id`, `cat_id`, `item_edition`) VALUES
(1, 1, 'Standard Edition'),
(1, 1, 'Collector''s Edition'),
(2, 1, 'Standard Edition'),
(2, 1, 'Collector''s Edition'),
(3, 1, 'Standard Edition'),
(3, 1, 'Collector''s Edition'),
(4, 2, 'Extended Play'),
(4, 2, 'Remix Album'),
(5, 2, 'Extended Play'),
(5, 2, 'Remix Album'),
(6, 2, 'Extended Play'),
(6, 2, 'Remix Album'),
(7, 3, 'Standard Definition'),
(7, 3, 'Blu-Ray HD'),
(8, 3, 'Standard Definition'),
(8, 3, 'Blu-Ray HD'),
(9, 3, 'Standard Definition'),
(9, 3, 'Blu-Ray HD');

-- --------------------------------------------------------

--
-- Table structure for table `store_item_size`
--

CREATE TABLE IF NOT EXISTS `store_item_size` (
  `item_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `item_size` varchar(25) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `store_item_size`
--

INSERT INTO `store_item_size` (`item_id`, `cat_id`, `item_size`) VALUES
(10, 4, 'S'),
(10, 4, 'M'),
(10, 4, 'L'),
(10, 4, 'XL'),
(11, 4, 'S'),
(11, 4, 'M'),
(11, 4, 'L'),
(11, 4, 'XL'),
(12, 4, 'One Size Fits All');

-- --------------------------------------------------------

--
-- Table structure for table `store_item_type`
--

CREATE TABLE IF NOT EXISTS `store_item_type` (
  `item_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `item_type` varchar(25) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `store_item_type`
--

INSERT INTO `store_item_type` (`item_id`, `cat_id`, `item_type`) VALUES
(1, 1, 'Physical Disk'),
(1, 1, 'Digital Download'),
(2, 1, 'Physical Disk'),
(2, 1, 'Digital Download'),
(3, 1, 'Physical Disk'),
(3, 1, 'Digital Download'),
(4, 2, 'Physical Disk'),
(4, 2, 'Digital Download'),
(5, 2, 'Physical Disk'),
(5, 2, 'Digital Download'),
(6, 2, 'Physical Disk'),
(6, 2, 'Digital Download'),
(7, 3, 'Physical Disk'),
(7, 3, 'Digital Download'),
(8, 3, 'Physical Disk'),
(8, 3, 'Digital Download'),
(9, 3, 'Physical Disk'),
(9, 3, 'Digital Download');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
