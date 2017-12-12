-- phpMyAdmin SQL Dump
-- version 3.3.7
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017 年 12 月 12 日 09:26
-- 服务器版本: 5.1.50
-- PHP 版本: 5.2.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `courseselection`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `adminid` int(50) NOT NULL,
  `adminpassword` int(50) NOT NULL,
  `studentinform` varchar(1000) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '学生选课子系统公告',
  `teacherinform` varchar(1000) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '教师管理子系统公告'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`adminid`, `adminpassword`, `studentinform`, `teacherinform`) VALUES
(123456, 123456, 'c3a8c2aec2a1c3a7c2aee28094c3a6c593c2bac3a7c2bde28098c3a7c2bbc593', 'c3a8c2aec2a1c3a7c2aee28094c3a6c593c2bac3a7c2bde28098c3a7c2bbc593');

-- --------------------------------------------------------

--
-- 表的结构 `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `courseid` int(50) NOT NULL AUTO_INCREMENT,
  `coursename` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `teaid` int(50) NOT NULL,
  `teaname` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '教师姓名',
  `selected` int(50) NOT NULL,
  `total` int(50) NOT NULL,
  `classtime` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `classroom` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `credit` int(50) NOT NULL,
  `shangketime` int(50) NOT NULL,
  `shiyantime` int(50) NOT NULL,
  PRIMARY KEY (`courseid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- 转存表中的数据 `course`
--

INSERT INTO `course` (`courseid`, `coursename`, `teaid`, `teaname`, `selected`, `total`, `classtime`, `classroom`, `credit`, `shangketime`, `shiyantime`) VALUES
(15, 'å•ç‰‡æœº', 10012, 'ä¸è€å¸ˆ', 1, 60, 'å‘¨å››56èŠ‚', 'å—', 2, 24, 12),
(14, 'æ•°æ®ç»“æž„', 10011, 'ç¥è€å¸ˆ', 1, 60, 'å‘¨ä¸€34èŠ‚', 'å—é˜¶406', 3, 36, 12);

-- --------------------------------------------------------

--
-- 表的结构 `stucourse`
--

CREATE TABLE IF NOT EXISTS `stucourse` (
  `stuid` int(50) NOT NULL,
  `stuname` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `collegename` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `major` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `class` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `teaid` int(50) NOT NULL,
  `teaname` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '教师姓名',
  `courseid` int(11) NOT NULL,
  `coursename` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '课程名称',
  `classtime` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`stuid`,`courseid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `stucourse`
--

INSERT INTO `stucourse` (`stuid`, `stuname`, `collegename`, `major`, `class`, `teaid`, `teaname`, `courseid`, `coursename`, `classtime`) VALUES
(11, 'çŽ‹äº”', 'ä¿¡æ¯ä¸ŽæŽ§åˆ¶å·¥ç¨‹å­¦é™¢', 'ç½‘ç»œå·¥ç¨‹', '1401ç­', 10012, 'ä¸è€å¸ˆ', 15, 'å•ç‰‡æœº', 'å‘¨å››56èŠ‚');

-- --------------------------------------------------------

--
-- 表的结构 `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `stuid` int(50) NOT NULL AUTO_INCREMENT,
  `stuname` varchar(50) COLLATE utf8_bin NOT NULL,
  `collegename` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '学院名称',
  `major` varchar(50) COLLATE utf8_bin NOT NULL,
  `sex` varchar(50) COLLATE utf8_bin NOT NULL,
  `class` varchar(50) COLLATE utf8_bin NOT NULL,
  `stupassword` int(50) NOT NULL,
  PRIMARY KEY (`stuid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `student`
--

INSERT INTO `student` (`stuid`, `stuname`, `collegename`, `major`, `sex`, `class`, `stupassword`) VALUES
(11, 'çŽ‹äº”', 'ä¿¡æ¯ä¸ŽæŽ§åˆ¶å·¥ç¨‹å­¦é™¢', 'ç½‘ç»œå·¥ç¨‹', 'å¥³', '1401ç­', 123456),
(13, 'æŽå››', 'ä¿¡æ¯ä¸ŽæŽ§åˆ¶å·¥ç¨‹å­¦é™¢', 'è®¡ç®—æœºç§‘å­¦ä¸ŽæŠ€æœ¯', 'ç”·', '1401ç­', 123456);

-- --------------------------------------------------------

--
-- 表的结构 `teacher`
--

CREATE TABLE IF NOT EXISTS `teacher` (
  `teaid` int(50) NOT NULL AUTO_INCREMENT,
  `teaname` varchar(50) COLLATE utf8_bin NOT NULL,
  `sex` varchar(50) COLLATE utf8_bin NOT NULL,
  `collegename` varchar(50) COLLATE utf8_bin NOT NULL,
  `introduction` varchar(50) COLLATE utf8_bin NOT NULL,
  `teapassword` int(50) NOT NULL,
  PRIMARY KEY (`teaid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=10014 ;

--
-- 转存表中的数据 `teacher`
--

INSERT INTO `teacher` (`teaid`, `teaname`, `sex`, `collegename`, `introduction`, `teapassword`) VALUES
(10012, 'ä¸è€å¸ˆ', 'å¥³', 'ä¿¡æ¯ä¸ŽæŽ§åˆ¶å·¥ç¨‹å­¦é™¢', 'å¥½è€å¸ˆï¼æ£’æ£’', 123456),
(10013, 'å¶è€å¸ˆ', 'å¥³', 'ä¿¡æ¯ä¸ŽæŽ§åˆ¶å·¥ç¨‹å­¦é™¢', 'è´Ÿè´£äººçˆ±å­¦ç”Ÿçš„å¥½è€å¸ˆï¼Œæ£’æ£’~', 123456);
