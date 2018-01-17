/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50717
Source Host           : localhost:3306
Source Database       : co_cms

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2017-12-06 17:30:37
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `category`
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `cateid` int(11) NOT NULL AUTO_INCREMENT,
  `catename` varchar(20) NOT NULL,
  PRIMARY KEY (`cateid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `custinfo`
-- ----------------------------
DROP TABLE IF EXISTS `custinfo`;
CREATE TABLE `custinfo` (
  `csname` text,
  `csid` int(11) NOT NULL AUTO_INCREMENT,
  `csmail` varchar(100) NOT NULL,
  `cscate` int(11) NOT NULL DEFAULT '1',
  `csflag` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`csid`),
  KEY `cscate` (`cscate`),
  CONSTRAINT `custinfo_ibfk_1` FOREIGN KEY (`cscate`) REFERENCES `category` (`cateid`) ON DELETE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `mailinfo`
-- ----------------------------
DROP TABLE IF EXISTS `mailinfo`;
CREATE TABLE `mailinfo` (
  `maid` int(11) NOT NULL AUTO_INCREMENT,
  `maaddr` varchar(50) NOT NULL,
  `mapwd` varchar(255) NOT NULL,
  PRIMARY KEY (`maid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for `userinfo`
-- ----------------------------
DROP TABLE IF EXISTS `userinfo`;
CREATE TABLE `userinfo` (
  `un` varchar(50) NOT NULL,
  `pwd` varchar(50) NOT NULL,
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `umid` int(11) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of userinfo
-- ----------------------------
INSERT INTO `userinfo` VALUES ('a', '0b4e7a0e5fe84ad35fb5f95b9ceeac79', '1', '1');
