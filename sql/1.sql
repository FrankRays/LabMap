-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 25, 2013 at 10:22 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `labmapdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `building`
--

CREATE TABLE IF NOT EXISTS `building` (
  `buildingId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `building` varchar(255) NOT NULL,
  `x1` int(11) NOT NULL,
  `y1` int(11) NOT NULL,
  `x2` int(11) NOT NULL,
  `y2` int(11) NOT NULL,
  `mapId_fk` int(10) unsigned NOT NULL,
  PRIMARY KEY (`buildingId`),
  UNIQUE KEY `building` (`building`),
  KEY `mapId_fk` (`mapId_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Table structure for table `devicecapability`
--

CREATE TABLE IF NOT EXISTS `devicecapability` (
  `sysId_fk` int(10) unsigned NOT NULL,
  `capability` varchar(255) NOT NULL,
  KEY `sysId_fk` (`sysId_fk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `labsinbuildings`
--

CREATE TABLE IF NOT EXISTS `labsinbuildings` (
  `buildingId_fk` int(10) unsigned NOT NULL,
  `lab_mapId_fk` int(10) unsigned NOT NULL COMMENT 'lab''s map',
  UNIQUE KEY `lab_mapId_fk` (`lab_mapId_fk`),
  KEY `buildingId_fk` (`buildingId_fk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `map`
--

CREATE TABLE IF NOT EXISTS `map` (
  `mapId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mName` varchar(255) NOT NULL,
  `bgImage` varchar(255) NOT NULL,
  `mWidth` int(10) unsigned NOT NULL,
  `mHeight` int(10) unsigned NOT NULL,
  `isLive` tinyint(1) NOT NULL,
  `mType` tinyint(4) NOT NULL COMMENT 'campusmap / labmap',
  PRIMARY KEY (`mapId`),
  UNIQUE KEY `mName` (`mName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='stores the data about both the campus map and labmap.' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `system`
--

CREATE TABLE IF NOT EXISTS `system` (
  `sysId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sysName` varchar(255) NOT NULL,
  `lab_mapId_fk` int(10) unsigned DEFAULT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `status` smallint(6) NOT NULL COMMENT '0,1,2,3 : free, used, error, maintenance',
  `ninerNetUser` varchar(255) NOT NULL,
  `deviceType` int(11) NOT NULL,
  PRIMARY KEY (`sysId`),
  KEY `lab_mapId_fk` (`lab_mapId_fk`),
  KEY `lab_mapId_fk_2` (`lab_mapId_fk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userId_pk` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(255) NOT NULL,
  `utype` int(11) NOT NULL,
  `ltype` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `passwd` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`userId_pk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId_pk`, `uname`, `utype`, `ltype`, `active`, `passwd`) VALUES
(3, 'sjonnala', 1, 2, 1, 'e28ede6a389f162cf57a1985faa98364a89ab72b'),
(8, 'tester', 2, 1, 1, '1b90063efe6da2c90bdda5e3e5652302c6b6e80d'),
(9, 'admin', 1, 2, 1, 'f865b53623b121fd34ee5426c792e5c33af8c227');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `building`
--
ALTER TABLE `building`
  ADD CONSTRAINT `building_ibfk_1` FOREIGN KEY (`mapId_fk`) REFERENCES `map` (`mapId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `devicecapability`
--
ALTER TABLE `devicecapability`
  ADD CONSTRAINT `devicecapability_ibfk_1` FOREIGN KEY (`sysId_fk`) REFERENCES `system` (`sysId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `labsinbuildings`
--
ALTER TABLE `labsinbuildings`
  ADD CONSTRAINT `labsinbuildings_ibfk_1` FOREIGN KEY (`buildingId_fk`) REFERENCES `building` (`buildingId`),
  ADD CONSTRAINT `labsinbuildings_ibfk_2` FOREIGN KEY (`lab_mapId_fk`) REFERENCES `map` (`mapId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `system`
--
ALTER TABLE `system`
  ADD CONSTRAINT `system_ibfk_3` FOREIGN KEY (`lab_mapId_fk`) REFERENCES `map` (`mapId`) ON DELETE SET NULL ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
