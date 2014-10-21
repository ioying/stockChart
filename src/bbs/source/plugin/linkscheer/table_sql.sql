-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 03 月 22 日 11:24
-- 服务器版本: 5.6.12-log
-- PHP 版本: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `ultrax`
--

-- --------------------------------------------------------

--
-- 表的结构 `pre_linkscheer_answer`
--

CREATE TABLE IF NOT EXISTS `pre_linkscheer_answer` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `qid` int(11) NOT NULL DEFAULT '0',
  `cid` int(11) NOT NULL DEFAULT '0',
  `rid` int(11) NOT NULL DEFAULT '0',
  `uid` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `content` longtext,
  `Score` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`aid`),
  KEY `qid` (`qid`),
  KEY `cid` (`cid`),
  KEY `rid` (`rid`),
  KEY `uid` (`uid`),
  KEY `time` (`time`)
) DEFAULT CHARSET=utf8 ;

--
-- 表的结构 `pre_linkscheer_question`
--

CREATE TABLE IF NOT EXISTS `pre_linkscheer_question` (
  `qid` int(11) NOT NULL AUTO_INCREMENT,
  `rid` int(11) NOT NULL DEFAULT '0',
  `uid` int(11) NOT NULL DEFAULT '0',
  `cid` int(11) NOT NULL DEFAULT '0',
  `lessonid` smallint(6) NOT NULL,
  `coin` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `title` varchar(200) DEFAULT NULL,
  `content` longtext,
  `aid` int(11) NOT NULL DEFAULT '0',
  `iscommand` int(1) NOT NULL DEFAULT '0',
  `answer` int(11) NOT NULL DEFAULT '0',
  `fid` mediumint(8) DEFAULT NULL,
  `tid` mediumint(8) DEFAULT NULL,
  `is_auth` varchar(1) DEFAULT NULL,
  `readpay` int(11) DEFAULT NULL,
  PRIMARY KEY (`qid`),
  KEY `rid` (`rid`),
  KEY `uid` (`uid`),
  KEY `cid` (`cid`),
  KEY `coin` (`coin`),
  KEY `status` (`status`),
  KEY `time` (`time`),
  KEY `aid` (`aid`),
  KEY `iscommand` (`iscommand`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- 表的结构 `pre_linkscheer_record`
--

CREATE TABLE IF NOT EXISTS `pre_linkscheer_record` (
  `rid` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('audio','video') NOT NULL DEFAULT 'audio',
  `name` varchar(80) DEFAULT NULL,
  `readme` text,
  `uid` int(11) NOT NULL DEFAULT '0',
  `sec` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `size` int(11) NOT NULL DEFAULT '0',
  `tid` int(11) NOT NULL DEFAULT '0',
  `pid` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `file` varchar(120) DEFAULT NULL,
  `token` varchar(20) NOT NULL,
  `isthread` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`rid`),
  KEY `uid` (`uid`),
  KEY `tid` (`tid`),
  KEY `status` (`status`),
  KEY `type` (`type`),
  KEY `token` (`token`),
  KEY `isthread` (`isthread`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

