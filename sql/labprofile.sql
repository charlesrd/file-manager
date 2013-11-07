-- phpMyAdmin SQL Dump
-- version 3.3.9.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 07, 2013 at 01:10 PM
-- Server version: 5.1.68
-- PHP Version: 5.4.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dentallabprofile`
--

-- --------------------------------------------------------

--
-- Table structure for table `labprofile`
--

CREATE TABLE IF NOT EXISTS `labprofile` (
  `labID` int(12) NOT NULL AUTO_INCREMENT,
  `labLogin` varchar(128) NOT NULL,
  `labPassword` varchar(12) NOT NULL DEFAULT '',
  `labName` varchar(255) NOT NULL,
  `labContact` varchar(255) NOT NULL DEFAULT '',
  `labStatus` varchar(100) NOT NULL DEFAULT '',
  `labPhone` varchar(32) NOT NULL,
  `labFax` varchar(32) NOT NULL,
  `labAddress` text NOT NULL,
  `labCity` varchar(128) NOT NULL,
  `labState` varchar(64) NOT NULL,
  `labZip` varchar(15) NOT NULL DEFAULT '',
  `labCounty` varchar(128) NOT NULL,
  `labEmail` varchar(255) NOT NULL DEFAULT '',
  `secondaryEmail` varchar(255) NOT NULL,
  `labURL` varchar(255) NOT NULL,
  `labYears` varchar(64) NOT NULL,
  `labTechs` varchar(64) NOT NULL,
  `labStatement` text NOT NULL,
  `enabled` char(1) NOT NULL DEFAULT '',
  `directconnect` int(1) NOT NULL DEFAULT '0',
  `salesperson` varchar(64) NOT NULL,
  `signup_date` int(24) NOT NULL DEFAULT '0',
  `expiration` int(25) NOT NULL DEFAULT '0',
  `cancel_date` int(24) NOT NULL DEFAULT '0',
  `sponsor` char(1) NOT NULL DEFAULT '',
  `labSpecial` text NOT NULL,
  `labSponsor` int(12) NOT NULL DEFAULT '0',
  `labSponsor2` int(12) NOT NULL DEFAULT '0',
  `homepage` smallint(6) NOT NULL DEFAULT '0',
  `ftp` smallint(6) NOT NULL DEFAULT '0',
  `url` text NOT NULL,
  `rxuser` text NOT NULL,
  `rxpass` text NOT NULL,
  `template` smallint(6) NOT NULL DEFAULT '0',
  `new_admin_template` tinyint(1) NOT NULL DEFAULT '0',
  `month` int(11) NOT NULL DEFAULT '0',
  `year` int(11) NOT NULL DEFAULT '0',
  `managed` smallint(6) NOT NULL DEFAULT '0',
  `sgroup` tinyint(1) NOT NULL DEFAULT '0',
  `giftcode` varchar(8) NOT NULL,
  `gr75` tinyint(1) NOT NULL DEFAULT '0',
  `grexp` int(11) NOT NULL DEFAULT '0',
  `micro1` varchar(128) NOT NULL,
  `micro2` varchar(128) NOT NULL,
  `micro3` varchar(128) NOT NULL,
  `micro4` varchar(128) NOT NULL,
  `micro5` varchar(128) NOT NULL,
  `micro6` varchar(128) NOT NULL,
  `micro7` varchar(128) NOT NULL,
  `micro8` varchar(128) NOT NULL,
  `micro9` varchar(128) NOT NULL,
  `micro10` varchar(128) NOT NULL,
  `sgiftcode` varchar(8) NOT NULL DEFAULT '',
  `survey` tinyint(1) NOT NULL DEFAULT '0',
  `survey_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `warranty` int(11) NOT NULL,
  `msg` int(1) NOT NULL DEFAULT '0',
  `drate` varchar(255) NOT NULL,
  `gusername` varchar(255) NOT NULL,
  `gpassword` varchar(255) NOT NULL,
  `outsource` varchar(1) NOT NULL DEFAULT '0',
  `ams_tech_customer` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`labID`),
  KEY `giftcode` (`giftcode`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10328 ;

--
-- Dumping data for table `labprofile`
--

INSERT INTO `labprofile` (`labID`, `labLogin`, `labPassword`, `labName`, `labContact`, `labStatus`, `labPhone`, `labFax`, `labAddress`, `labCity`, `labState`, `labZip`, `labCounty`, `labEmail`, `secondaryEmail`, `labURL`, `labYears`, `labTechs`, `labStatement`, `enabled`, `directconnect`, `salesperson`, `signup_date`, `expiration`, `cancel_date`, `sponsor`, `labSpecial`, `labSponsor`, `labSponsor2`, `homepage`, `ftp`, `url`, `rxuser`, `rxpass`, `template`, `new_admin_template`, `month`, `year`, `managed`, `sgroup`, `giftcode`, `gr75`, `grexp`, `micro1`, `micro2`, `micro3`, `micro4`, `micro5`, `micro6`, `micro7`, `micro8`, `micro9`, `micro10`, `sgiftcode`, `survey`, `survey_enabled`, `warranty`, `msg`, `drate`, `gusername`, `gpassword`, `outsource`, `ams_tech_customer`) VALUES
(0, 'YourLabNameHere', '$feFWs1&2(]z', 'YourLabNameHere', '', '', '', '', '', 'Crete', 'Illinois', '60417', '', '', '', '', 'Over 15 Years', '1-5 Technicians', 'No statement provided.', 'N', 0, '', 0, 0, 0, 'N', 'No special provided.', 0, 0, 0, 0, '', '', '', 0, 0, 0, 0, 0, 0, 'tst-2007', 0, -64800, '', '', '', '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', '', '0', 0),
(1, 'smilemgr', 'dentistry', 'United Dental Resources', '', '', '708 351-6014', '', '', 'Crete', 'Illinois', '60417', 'Will', '', '', '', '1-5 Years', '1-5 Technicians', 'No statement provided.', 'Y', 0, '', 0, 2102821200, 0, 'Y', 'No special provided.', 13, 0, 1, 0, 'subdentallab.com', 'Casey', '106812', 3, 0, 0, 2005, 0, 0, 'adm-0001', 1, 2110428000, '', '', '', '', '', '', '', '', '', '', '', 1, 1, 10, 0, '65', '', '', '0', 0),
(2, 'xxxxxxxxxxxxxx', '$feFWs1&2(]z', 'ACDLA - The American Cosmetic Dental Lab Association', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Y', 0, '', 0, 1282280400, 0, '', '', 0, 0, 0, 0, '', '', '', 0, 0, 0, 0, 0, 0, 'tst-2007', 0, 0, '', '', '', '', '', '', '', '', '', '', '', 1, 1, 0, 1, '65', '', '', '0', 0),
(3, 'casey', '60423', 'Casey Ceramic Arts', 'Kevin Schmitt', 'free', '708 502-3411', '', '26521 Greenwood Ave', 'Crete', 'Illinois', '60417', '', 'keith@AmericaSmiles.com', 'eric@americasmiles.com', 'http://www.americasmiles.com', '1-5 Years', '1-5 Technicians', 'First Case 20 percent off.', 'Y', 0, 'Colin-Hoernig', 0, 1597899600, 0, 'Y', 'No special provided.', 13, 0, 1, 0, 'subdentallab.com', 'Casey', '106812', 1, 0, 0, 2005, 0, 0, 'cas-6014', 1, 2110428000, '', '', '', '', '', '', '', '', '', '', '', 1, 1, 10, 1, '65', '', '', '0', 1),
(4, 'Seiter', '84003', 'Alpine Dental Lab', 'Rich', 'failed renewal', '800 884-5047', '', '122 North Center Street', 'American Fork', 'Utah', '84003', 'Utah', 'emailus@alpinedental.com', '', 'alpinedental.com', 'Over 15 Years', 'Over 15 Technicians', 'The foundation of our sucess is built on methods that allow us to control the basic elements of fit, color, and function in our restorations. Doing the basics extreemly well provides a level of consistancy that makes our service especially valuable to your practice. Cases will arrive early and go right in, and our porcelain veneers are far superior to any other!', 'N', 0, '', 0, 1117512000, 0, 'Y', 'When you request a "new doctor" packet we will also provide 5 ($20) vouchers good twords any work requested. Five cases will help us profile your specific preferences so you''ll get exactly what you expect every time!', 2, 0, 0, 0, '', '', '', 1, 0, 0, 0, 0, 0, 'alp-5047', 0, 0, '', '', '', '', '', '', '', '', '', '', '', 0, 0, 0, 0, '65', '', '', '0', 0),
(5, 'skornik', '85032', 'Artistic Dental Design, Inc.', 'Paul Skornik', 'ams active', '602 971-9544', '602-867-3665', '12251 N. 32nd Street   Ste #3', 'Phoenix', 'Arizona', '85032', 'Maricopa', 'paul@Artistic-Dental.com', 'Crystal@Artistic-dental.com', 'Artistic-Dental.com', '6-15 Years', '6-15 Technicians', 'The dentists that use Artistic Dental Design do so because they know that we are as concerned with each restoration as they are. We take the dentists'' desires and their practice as seriously as they do.\r\n\r\nIn addition to exceptional provisional temps, PFMs and Full Gold, IPS Empress, E.Max, and other systems, we offer the full selection of removables. We also offer Cadent-iTero digital service, milled Titanium copings. AND, we offer many options for Zirconia restorations including Nobel Biocare''s Procera and Straumann''s Zirion - copings with porcelain or full-contour, so we have Zirconia restorations to meet most dental offices'' price needs.\r\n\r\nAnd, to better serve our doctors, we accept Visa, MasterCard and American Express.', 'Y', 0, '', 0, 1590037200, 0, 'Y', 'If Artistic Dental Design provides lab work for your practice, your practice can be listed on both FindaCosmeticDentist.Com & AmericaSmiles.com at no cost to you.', 2, 0, 0, 0, '', '', '', 0, 0, 0, 0, 2, 0, 'art-9544', 1, 1590037200, 'PhoenixSmiles.net', 'ScottsdaleSmiles.net', '', '', '', '', '', '', '', '', '', 0, 1, 0, 0, '65', '', '', '0', 0);
