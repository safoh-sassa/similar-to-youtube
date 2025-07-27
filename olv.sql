-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2016 at 02:49 PM
-- Server version: 5.7.9
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `olv`
--
CREATE DATABASE `olv` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `olv`;
-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `comment` varchar(500) NOT NULL,
  `video_id` int(16) NOT NULL,
  `user_id` int(16) NOT NULL,
  `date_sent` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `comment`, `video_id`, `user_id`, `date_sent`) VALUES
(21, 'useful', 42, 8, 1478088272),
(22, 'good', 44, 1, 1478088321),
(23, 'clear', 42, 1, 1478088387),
(24, 'interesting', 49, 1, 1478097197),
(25, 'nice video', 48, 1, 1478101998),
(26, 'thank you', 44, 8, 1478102207),
(27, 'awesome', 50, 9, 1478117752),
(28, 'very interesting', 53, 1, 1478615921),
(29, 'very useful', 47, 1, 1478616056),
(30, 'i prefer PHP', 54, 8, 1478616462),
(31, 'me too', 54, 1, 1478616506);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `module_name`) VALUES
(9, 'C++'),
(2, 'Network'),
(0, 'No category'),
(6, 'JavaScript'),
(7, 'PHP'),
(8, 'C#'),
(10, 'Windows Server 2012'),
(11, 'C');

-- --------------------------------------------------------

--
-- Table structure for table `rate`
--

DROP TABLE IF EXISTS `rate`;
CREATE TABLE IF NOT EXISTS `rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `video_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `like_bool` tinyint(1) NOT NULL,
  `dislike_bool` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rate`
--

INSERT INTO `rate` (`id`, `video_id`, `user_id`, `like_bool`, `dislike_bool`) VALUES
(7, 43, 8, 1, 0),
(8, 44, 8, 1, 0),
(9, 42, 8, 1, 0),
(10, 42, 1, 0, 1),
(11, 49, 1, 1, 0),
(12, 48, 1, 0, 1),
(13, 50, 9, 1, 0),
(14, 51, 10, 0, 1),
(15, 46, 10, 0, 1),
(16, 47, 10, 1, 0),
(17, 53, 1, 0, 1),
(18, 54, 8, 1, 0),
(19, 54, 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` varchar(255) NOT NULL,
  `group_id` int(11) NOT NULL DEFAULT '2',
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `auth_key` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `student_id`, `group_id`, `first_name`, `last_name`, `username`, `email`, `password`, `auth_key`) VALUES
(1, '', 1, 'Safoh', 'Sassa', 'ms79ms', 'ms79ms@gmail.com', '$2y$13$KsncH3TUHYRRhmm.QcXWcOx4YiubW2./knkehhh/vbx7dFSFaMcyi', ''),
(9, '54354378', 2, 'Maher', 'Masri', 'Mah', 'maher@yahoo.com', '$2y$13$.7qfOh17mv.x.HZD82f0/.WcRZmIGMu/4/98C2lroUmf7USPl5pqS', 'RExDXs1D_T7LqesXAMYGaroReHEE1VLT'),
(8, '44875541', 2, 'Rani', 'Rava', 'RR', 'rani@yahoo.com', '$2y$13$nmjGSfejhnT3H8JhFud5NuTLBNgPI10nHPMECYXijWgGMOoQE0le.', 'deks_OBrJ5ixDn_6SGisni-gOVNJQ7f-'),
(10, '24325475', 2, 'Marina', 'brown', 'MA.BR', 'Marin.b@hotmail.com', '$2y$13$DcPdZnP4i1RwsLk7OQyXVuwG0sjZ.PIrd573BKx2DPYFiRzf9zuBS', '8z3JE9cFqeVeroK0L-a_-RIYCFhBI80O');

-- --------------------------------------------------------

--
-- Table structure for table `user_group`
--

DROP TABLE IF EXISTS `user_group`;
CREATE TABLE IF NOT EXISTS `user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_slug` varchar(255) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `group_description` varchar(255) NOT NULL,
  `group_created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_group`
--

INSERT INTO `user_group` (`id`, `group_slug`, `group_name`, `group_description`, `group_created_at`) VALUES
(2, 'user', 'User', 'This is regular user', 1476889524),
(1, 'admin', 'Admin', 'This is administrator of the website. ', 1476889524);

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
CREATE TABLE IF NOT EXISTS `videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `module_id` int(16) DEFAULT NULL,
  `description` varchar(500) NOT NULL,
  `views_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `user_id`, `title`, `url`, `module_id`, `description`, `views_count`) VALUES
(41, 1, 'C++Tutorial for Beginners 1 - Introduction', 'https://www.youtube.com/watch?v=1MKhigIml3E&index=1&list=PLzi8dDyr-I0kTWRvdjZa_wpp9HopPKDE9', 9, 'The first of a series on how to program in C++', 2),
(42, 1, 'Buckys C++ Programming Tutorials - 5 -', 'https://www.youtube.com/watch?v=yjucJUsHSqg', 9, 'Creating a Basic Calculator', 11),
(43, 1, 'Windows 10 Vs OS X El Capitan: Which is best?', 'https://www.youtube.com/watch?v=jJBLmYhi0U8', 0, 'Which is best?', 11),
(44, 8, 'What are regular expressions & can we see some practical demonstrations?', 'https://www.youtube.com/watch?v=C2zm0roE-Uc', 8, 'Regex in C# language', 18),
(45, 9, 'PHP Tutorial #1 - Connecting to a MySQL Database & Displaying Records on a Web Page [MySQL Tutorial]', 'https://www.youtube.com/watch?v=og7TtjUdogA', 7, 'Connect to MySql', 0),
(46, 9, 'Fiber optic cables', 'https://www.youtube.com/watch?v=0MwMkBET_5I', 2, 'How they work', 9),
(47, 10, 'javascript callback functions tutorial', 'https://www.youtube.com/watch?v=pTbSfCT42_M', 6, 'callback functions', 6),
(48, 10, 'JAVASCRIPT SWITCH CASE STATEMENT', 'https://www.youtube.com/watch?v=JHnoUF0xzL0', 6, 'SWITCH CASE STATEMENT', 12),
(49, 1, 'Windows Server 2012 Group Policy Management (70-411)', 'https://www.youtube.com/watch?v=LQp7dHHkXJw', 10, 'Windows Server 2012', 15),
(50, 9, 'Parameter Passing in C', 'https://vimeo.com/84722110', 11, 'when a variable is passed to a function, the value of the variable is passed.', 13),
(51, 1, 'Object Oriented PHP', 'https://www.youtube.com/watch?v=5YaF8xTmxs4', 7, 'the meaning of Object Oriented in PHP', 15),
(53, 1, 'yii', 'https://www.youtube.com/watch?v=FJkF0l-G5HA', 7, 'learn', 11),
(54, 8, 'PHP VS ASP.NET', 'https://www.youtube.com/watch?v=E4sNJPb4qI4', 0, 'Which Language I Learn 2015 LATEST', 13);

-- --------------------------------------------------------

--
-- Table structure for table `video_favorites`
--

DROP TABLE IF EXISTS `video_favorites`;
CREATE TABLE IF NOT EXISTS `video_favorites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `video_favorites`
--

INSERT INTO `video_favorites` (`id`, `user_id`, `video_id`) VALUES
(47, 10, 51),
(57, 1, 47),
(58, 8, 54),
(22, 9, 47),
(55, 1, 46),
(29, 10, 52);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
