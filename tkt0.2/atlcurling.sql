-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 30, 2011 at 07:33 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `atlcurling`
--

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `eventix` int(11) NOT NULL AUTO_INCREMENT,
  `eventnm` varchar(64) NOT NULL COMMENT 'Title of event',
  `description` varchar(256) NOT NULL COMMENT 'Description of event',
  `eventdt` date NOT NULL COMMENT 'Date of event',
  `calltm` time NOT NULL COMMENT 'Volunteer call time',
  `advstarttm` time NOT NULL COMMENT 'Advertised start time',
  `icetm` time NOT NULL COMMENT 'Time ice is reserved for',
  `teardowntm` time NOT NULL COMMENT 'Time to tear down rink to leave ice',
  `capacity` int(11) NOT NULL COMMENT 'Maximum number of attendees',
  `mbrprice` decimal(8,2) NOT NULL,
  `guestprice` decimal(8,2) NOT NULL,
  PRIMARY KEY (`eventix`),
  UNIQUE KEY `eventnm` (`eventnm`,`eventdt`,`advstarttm`),
  UNIQUE KEY `unique_eventnm` (`eventnm`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='One row for each event' AUTO_INCREMENT=9 ;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`eventix`, `eventnm`, `description`, `eventdt`, `calltm`, `advstarttm`, `icetm`, `teardowntm`, `capacity`, `mbrprice`, `guestprice`) VALUES
(1, 'Monday Night Curling A1', 'Monday Night Curling - Series A, Session 1 - Jan 9, 2011 Reserved Curling', '2012-01-09', '18:00:00', '19:30:00', '19:30:00', '21:30:00', 24, 15.00, 30.00),
(2, 'Monday Night Curling A2', 'Monday Night Curling - Series A, Session 2 - Jan 23, 2011', '2012-01-23', '18:00:00', '19:30:00', '19:30:00', '21:30:00', 24, 15.00, 30.00),
(3, 'Monday Night Curling A3', 'Monday Night Curling - Series A, Session 3 - Feb 6, 2011', '2012-02-06', '18:00:00', '19:30:00', '19:30:00', '21:30:00', 24, 15.00, 30.00),
(4, 'Monday Night Curling A4', 'Monday Night Curling - Series A, Session 4 - Feb 27, 2011', '2012-02-27', '18:00:00', '19:30:00', '19:30:00', '21:30:00', 24, 15.00, 30.00),
(5, 'Monday Night Curling A5', 'Monday Night Curling - Series A, Session 5 - Mar 12, 2011', '2012-03-12', '18:00:00', '19:30:00', '19:30:00', '21:30:00', 24, 15.00, 30.00),
(8, 'Monday Night Curling A6', 'Monday Night Curling - Series A, Session 6 - Mar 26, 2011', '2012-03-26', '18:00:00', '19:30:00', '19:30:00', '21:30:00', 24, 15.00, 30.00);

-- --------------------------------------------------------

--
-- Table structure for table `orderdtl`
--

CREATE TABLE IF NOT EXISTS `orderdtl` (
  `orderix` int(11) NOT NULL COMMENT 'Order number this detail belongs to',
  `orderdtlix` int(11) NOT NULL COMMENT 'Index (line no) of order',
  `itemix` int(11) NOT NULL,
  `eventix` int(11) NOT NULL,
  `action` char(1) NOT NULL,
  `qty` int(11) NOT NULL,
  `extamt` decimal(8,2) NOT NULL COMMENT 'Extended amount charged for this order detail',
  PRIMARY KEY (`orderix`,`orderdtlix`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='One row for each line of the order';

-- --------------------------------------------------------

--
-- Table structure for table `orderhdr`
--

CREATE TABLE IF NOT EXISTS `orderhdr` (
  `orderix` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Order number',
  `crtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Time order was placed',
  `pmtaprtime` timestamp NULL DEFAULT NULL COMMENT 'Time payment was approved by user',
  `pmtrejtime` timestamp NULL DEFAULT NULL COMMENT 'Time payment was rejected',
  `pmtrecvtime` timestamp NULL DEFAULT NULL COMMENT 'Time payment was received',
  `userix` int(11) NOT NULL COMMENT 'User who placed the order',
  `totalamt` decimal(8,2) NOT NULL COMMENT 'Total amount that was charged for the order',
  PRIMARY KEY (`orderix`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='One row for each order' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE IF NOT EXISTS `registration` (
  `eventix` int(11) NOT NULL COMMENT 'Event index',
  `userix` int(11) NOT NULL COMMENT 'User index',
  `addorderix` int(11) DEFAULT NULL COMMENT 'Order number that created this reservation',
  `releaseorderix` int(11) DEFAULT NULL COMMENT 'Order number that released this reservation',
  `position` int(11) NOT NULL COMMENT 'Position within event',
  `waiting` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indicates if this is just a place on the waiting list',
  `ordertime` timestamp NULL DEFAULT NULL COMMENT 'Time this reservation was orderered',
  `releasetime` timestamp NULL DEFAULT NULL COMMENT 'Time this reservation was released'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='One row for each reservation for each event';

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userix` int(11) NOT NULL AUTO_INCREMENT COMMENT 'User index',
  `usernm` varchar(64) NOT NULL COMMENT 'User name, usually e-mail address',
  `passwd` varchar(64) NOT NULL COMMENT 'User password, encrypted',
  `firstnm` varchar(32) NOT NULL COMMENT 'User first name',
  `lastnm` varchar(40) NOT NULL COMMENT 'User last name',
  `phonenbr` varchar(16) NOT NULL COMMENT 'User phone number',
  `member` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indicates if this user is a member.',
  PRIMARY KEY (`userix`),
  UNIQUE KEY `usernm` (`usernm`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='One row for each login user' AUTO_INCREMENT=14 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userix`, `usernm`, `passwd`, `firstnm`, `lastnm`, `phonenbr`, `member`) VALUES
(1, 'atl.jd.williams@gmail.com', '*26B2DECB27126D05F97D118A183460B06E5ED1C4', 'Jeff', 'Williams', '678.907.9740', 1),
(2, 'anna.karrenena@gmail.com', '*3B32CFE69A1AF6BC9FB7B13BF156D20B461531F5', '', '', '', 0),
(3, 'paco.pullman@gmail.com', '*1B7531128C0E36F41EE76DF850B49D1B46D895BF', 'Paco', 'Pullman', '555.1212', 0),
(4, 'a@aa.com', '*A02AA727CF2E8C5E6F07A382910C4028D65A053A', 'Alfred', 'Alfresco', '555.1212', 0),
(5, 'b@bb.com', '*8BE34F24D29E7B61EE00E4D5AADAE5CBC713D120', 'Barney', 'Bernard', '555.1212', 1),
(6, 'c@cc.com', '*106317C687A95D8C2703D21A14A09F03C7F25F4B', 'Carl', 'Catastrophe', '555.1212', 0),
(7, 'd@dd.com', '*A96141DC1E8E55BD1FC2EA76E401E2A1E6F7BD90', 'Dan', 'Doogood', '555.1212', 1),
(8, 'e@ee.com', '*A94008217C2DF00A75EF5950AA2A145CE7C6B1E1', 'Elmer', 'Eggeberdink', '555.1212', 0),
(10, 'f@ff.com', '*882A23BFB19768E55D14628898FCE79082047ABA', 'Fred', 'Farkle', '555.1212', 1),
(11, 'g@gg.com', '*8749134B85F4154A83D8747ABC58101F12833473', 'Greg', 'Gregory', '555.1212', 0),
(13, 'h@hh.com', '*ADCB3111F8CE421E27114A63697CE697887F430F', 'Harry', 'Horatio', '555.1212', 1);

-- --------------------------------------------------------

--
-- Table structure for table `xactlog`
--

CREATE TABLE IF NOT EXISTS `xactlog` (
  `xacttime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Timestamp of transaction',
  `xactix` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Transaction index',
  `userix` int(11) DEFAULT NULL COMMENT 'User who placed transaction',
  `orderix` int(11) DEFAULT NULL COMMENT 'Order this log entry pertains to',
  `eventix` int(11) DEFAULT NULL COMMENT 'Event transaction pertains to',
  `xacttype` varchar(64) NOT NULL COMMENT 'Transaction type',
  `description` varchar(256) DEFAULT NULL COMMENT 'Detailed description of transaction',
  `detail` text COMMENT 'Extended transaction detail data, if necessary',
  PRIMARY KEY (`xactix`),
  KEY `xacttime` (`xacttime`),
  KEY `userix` (`userix`),
  KEY `eventix` (`eventix`),
  KEY `xacttype` (`xacttype`),
  KEY `orderix` (`orderix`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='High level log of all transactions in the system' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
