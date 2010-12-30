-- phpMyAdmin SQL Dump
-- version 3.3.7deb2build0.10.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 31, 2010 at 12:31 AM
-- Server version: 5.1.49
-- PHP Version: 5.3.3-1ubuntu9.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `raidtracker`
--
CREATE DATABASE `raidtracker` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `raidtracker`;

-- --------------------------------------------------------

--
-- Table structure for table `attendees`
--

CREATE TABLE IF NOT EXISTS `attendees` (
  `boss_id` int(8) NOT NULL,
  `player_name` varchar(32) NOT NULL,
  `raid_key` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendees`
--

INSERT INTO `attendees` (`boss_id`, `player_name`, `raid_key`) VALUES
(27, 'Aierus', '0000-00-00 00:00:00'),
(27, 'Caerus', '0000-00-00 00:00:00'),
(27, 'Gathios', '0000-00-00 00:00:00'),
(27, 'Krediet', '0000-00-00 00:00:00'),
(27, 'Lifeleecher', '0000-00-00 00:00:00'),
(27, 'Rogziel', '0000-00-00 00:00:00'),
(27, 'Shamyfruen', '0000-00-00 00:00:00'),
(27, 'Slnderous', '0000-00-00 00:00:00'),
(27, 'Soriana', '0000-00-00 00:00:00'),
(27, 'Thoorr', '0000-00-00 00:00:00'),
(28, 'Aierus', '0000-00-00 00:00:00'),
(28, 'Caerus', '0000-00-00 00:00:00'),
(28, 'Gathios', '0000-00-00 00:00:00'),
(28, 'Krediet', '0000-00-00 00:00:00'),
(28, 'Lifeleecher', '0000-00-00 00:00:00'),
(28, 'Rogziel', '0000-00-00 00:00:00'),
(28, 'Shamyfruen', '0000-00-00 00:00:00'),
(28, 'Slnderous', '0000-00-00 00:00:00'),
(28, 'Soriana', '0000-00-00 00:00:00'),
(28, 'Thoorr', '0000-00-00 00:00:00'),
(29, 'Aierus', '0000-00-00 00:00:00'),
(29, 'Caerus', '0000-00-00 00:00:00'),
(29, 'Gathios', '0000-00-00 00:00:00'),
(29, 'Krediet', '0000-00-00 00:00:00'),
(29, 'Lifeleecher', '0000-00-00 00:00:00'),
(29, 'Rogziel', '0000-00-00 00:00:00'),
(29, 'Shamyfruen', '0000-00-00 00:00:00'),
(29, 'Slnderous', '0000-00-00 00:00:00'),
(29, 'Soriana', '0000-00-00 00:00:00'),
(29, 'Thoorr', '0000-00-00 00:00:00'),
(30, 'Aierus', '0000-00-00 00:00:00'),
(30, 'Gathios', '0000-00-00 00:00:00'),
(30, 'Jarilo', '0000-00-00 00:00:00'),
(30, 'Krediet', '0000-00-00 00:00:00'),
(30, 'Lifeleecher', '0000-00-00 00:00:00'),
(30, 'Rogziel', '0000-00-00 00:00:00'),
(30, 'Shamyfruen', '0000-00-00 00:00:00'),
(30, 'Slnderous', '0000-00-00 00:00:00'),
(30, 'Soriana', '0000-00-00 00:00:00'),
(30, 'Thoorr', '0000-00-00 00:00:00'),
(31, 'Aierus', '0000-00-00 00:00:00'),
(31, 'Gathios', '0000-00-00 00:00:00'),
(31, 'Jarilo', '0000-00-00 00:00:00'),
(31, 'Krediet', '0000-00-00 00:00:00'),
(31, 'Lifeleecher', '0000-00-00 00:00:00'),
(31, 'Rogziel', '0000-00-00 00:00:00'),
(31, 'Shamyfruen', '0000-00-00 00:00:00'),
(31, 'Slnderous', '0000-00-00 00:00:00'),
(31, 'Soriana', '0000-00-00 00:00:00'),
(31, 'Thoorr', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `bosskil`
--

CREATE TABLE IF NOT EXISTS `bosskil` (
  `boss_id` int(8) NOT NULL AUTO_INCREMENT,
  `boss_name` varchar(64) NOT NULL,
  `boss_time` datetime NOT NULL,
  `raid_key` datetime NOT NULL,
  PRIMARY KEY (`boss_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `bosskil`
--

INSERT INTO `bosskil` (`boss_id`, `boss_name`, `boss_time`, `raid_key`) VALUES
(31, 'Rotface', '2010-03-17 16:39:56', '0000-00-00 00:00:00'),
(30, 'Festergut', '2010-03-17 15:53:52', '0000-00-00 00:00:00'),
(29, 'Deathbringer Saurfang', '2010-03-17 15:26:54', '0000-00-00 00:00:00'),
(28, 'Lady Deathwhisper', '2010-03-17 15:03:08', '0000-00-00 00:00:00'),
(27, 'Lord Marrowgar', '2010-03-17 14:51:24', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `join`
--

CREATE TABLE IF NOT EXISTS `join` (
  `player_name` varchar(32) NOT NULL,
  `join_time` datetime NOT NULL,
  `raid_key` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `join`
--


-- --------------------------------------------------------

--
-- Table structure for table `leave`
--

CREATE TABLE IF NOT EXISTS `leave` (
  `player_name` varchar(32) NOT NULL,
  `leave_time` datetime NOT NULL,
  `raid_key` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leave`
--


-- --------------------------------------------------------

--
-- Table structure for table `loot`
--

CREATE TABLE IF NOT EXISTS `loot` (
  `loot_id` int(8) NOT NULL AUTO_INCREMENT,
  `itemname` varchar(64) NOT NULL,
  `itemid` int(12) NOT NULL,
  `icon` varchar(64) NOT NULL,
  `class` varchar(32) NOT NULL,
  `subclass` varchar(32) NOT NULL,
  `color` varchar(8) NOT NULL,
  `zone` varchar(128) NOT NULL,
  `boss` varchar(128) NOT NULL,
  PRIMARY KEY (`loot_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `loot`
--


-- --------------------------------------------------------

--
-- Table structure for table `loot_receive`
--

CREATE TABLE IF NOT EXISTS `loot_receive` (
  `receive_id` int(8) NOT NULL AUTO_INCREMENT,
  `player_id` int(8) NOT NULL,
  `loot_id` int(8) NOT NULL,
  `costs` int(8) NOT NULL,
  `time` datetime NOT NULL,
  `raid_key` datetime NOT NULL,
  PRIMARY KEY (`receive_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `loot_receive`
--


-- --------------------------------------------------------

--
-- Table structure for table `playerinfo`
--

CREATE TABLE IF NOT EXISTS `playerinfo` (
  `player_id` int(8) NOT NULL AUTO_INCREMENT,
  `player_name` varchar(32) NOT NULL,
  `player_race` varchar(16) NOT NULL,
  `player_guild` varchar(64) NOT NULL,
  `player_sex` int(1) NOT NULL,
  `player_class` varchar(16) NOT NULL,
  `player_level` int(3) NOT NULL,
  PRIMARY KEY (`player_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `playerinfo`
--

