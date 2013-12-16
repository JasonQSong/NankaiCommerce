-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 12 月 16 日 16:27
-- 服务器版本: 5.6.12-log
-- PHP 版本: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `commerce`
--
CREATE DATABASE IF NOT EXISTS `commerce` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `commerce`;

-- --------------------------------------------------------

--
-- 表的结构 `think_actions`
--

CREATE TABLE IF NOT EXISTS `think_actions` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Act` varchar(20) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ItemID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `think_actions`
--

INSERT INTO `think_actions` (`ID`, `Act`, `UserID`, `ItemID`) VALUES
(1, '', 4, 8);

-- --------------------------------------------------------

--
-- 表的结构 `think_catagories`
--

CREATE TABLE IF NOT EXISTS `think_catagories` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Exist` int(11) NOT NULL DEFAULT '1',
  `CatagoryName` varchar(20) NOT NULL,
  `DisplayName` varchar(20) NOT NULL,
  `BelongTo` int(11) DEFAULT NULL,
  `AdminUserID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `CatagoryName` (`CatagoryName`),
  KEY `AdminUserID` (`AdminUserID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `think_catagories`
--

INSERT INTO `think_catagories` (`ID`, `Exist`, `CatagoryName`, `DisplayName`, `BelongTo`, `AdminUserID`) VALUES
(2, 1, 'Books', '图书、音像、数字商品', 0, 4),
(3, 1, 'DigitalBooks', '电子书', 2, 4),
(4, 1, 'FreeDigitalBooks', '免费', 3, 4),
(5, 1, 'Electric', '家用电器', 0, 4),
(6, 1, 'MobilePhones', '手机、数码', 0, 4),
(7, 1, 'Computers', '电脑、办公', 0, 4),
(8, 1, 'DigitalMusic', '数字音乐', 2, 4),
(9, 1, 'AudioVideo', '音像', 2, 4),
(10, 1, 'Novels', '小说', 3, 4),
(11, 1, 'ExcitationBooks', '励志与成功', 3, 4);

-- --------------------------------------------------------

--
-- 表的结构 `think_items`
--

CREATE TABLE IF NOT EXISTS `think_items` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Exist` int(11) DEFAULT '1',
  `ItemName` varchar(20) NOT NULL,
  `Price` double NOT NULL,
  `Description` text NOT NULL,
  `ImagePath` varchar(50) NOT NULL DEFAULT 'default.png',
  `BackgroundColor` varchar(20) NOT NULL DEFAULT '#0080ff',
  `CatagoryID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `CatagoryID` (`CatagoryID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `think_items`
--

INSERT INTO `think_items` (`ID`, `Exist`, `ItemName`, `Price`, `Description`, `ImagePath`, `BackgroundColor`, `CatagoryID`) VALUES
(7, 1, '物品名称', 100, 'ecdb257536a6c2f66aa3ee9dd11ac895c266baf7', 'default.png', '#0080ff', 2),
(8, 1, '物品名称', 100, 'ecdb257536a6c2f66aa3ee9dd11ac895c266baf7', 'default.png', '#0080ff', 3);

-- --------------------------------------------------------

--
-- 表的结构 `think_log_images`
--

CREATE TABLE IF NOT EXISTS `think_log_images` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ImagePath` varchar(50) NOT NULL,
  `UserID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `think_log_images`
--

INSERT INTO `think_log_images` (`ID`, `ImagePath`, `UserID`) VALUES
(1, '20131216/52aeeeff7e98c.jpg', 4);

-- --------------------------------------------------------

--
-- 表的结构 `think_users`
--

CREATE TABLE IF NOT EXISTS `think_users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Exist` int(11) NOT NULL DEFAULT '1',
  `UserName` varchar(20) NOT NULL,
  `Passwd` varchar(50) NOT NULL,
  `DisplayName` varchar(20) NOT NULL,
  `FullName` varchar(20) DEFAULT NULL,
  `Gender` int(11) NOT NULL,
  `Age` int(11) NOT NULL DEFAULT '0',
  `Email` varchar(20) DEFAULT NULL,
  `Telephone` varchar(20) DEFAULT NULL,
  `Address` text,
  `RegTime` datetime NOT NULL,
  `UserGroup` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `UserName` (`UserName`),
  UNIQUE KEY `DisplayName` (`DisplayName`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `think_users`
--

INSERT INTO `think_users` (`ID`, `Exist`, `UserName`, `Passwd`, `DisplayName`, `FullName`, `Gender`, `Age`, `Email`, `Telephone`, `Address`, `RegTime`, `UserGroup`) VALUES
(0, 1, '', '', '', NULL, 0, 0, NULL, NULL, NULL, '0000-00-00 00:00:00', 0),
(4, 1, 'UserName', '9fd1bd6cbc8fdc427a5a59fc996049732e029440', '昵称', '真实姓名', 0, 20, 'Email@example.com', '18817518909', '上海交通大学', '2013-12-14 03:01:42', 10);

--
-- 限制导出的表
--

--
-- 限制表 `think_catagories`
--
ALTER TABLE `think_catagories`
  ADD CONSTRAINT `think_catagories_ibfk_1` FOREIGN KEY (`AdminUserID`) REFERENCES `think_users` (`ID`);

--
-- 限制表 `think_items`
--
ALTER TABLE `think_items`
  ADD CONSTRAINT `think_items_ibfk_1` FOREIGN KEY (`CatagoryID`) REFERENCES `think_catagories` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
