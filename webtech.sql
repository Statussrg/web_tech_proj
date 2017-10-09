/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50535
Source Host           : localhost:3306
Source Database       : webtech

Target Server Type    : MYSQL
Target Server Version : 50535
File Encoding         : 65001

Date: 2017-10-09 12:30:31
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `t_users`
-- ----------------------------
DROP TABLE IF EXISTS `t_users`;
CREATE TABLE `t_users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `log` varchar(64) NOT NULL,
  `pass` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `regdt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_t_user_log` (`log`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_users
-- ----------------------------
INSERT INTO `t_users` VALUES ('3', 'wd', '3a760f3a7956c3f44bd23a79ca58ce4ac0af673b', 'a', 'da', '2017-10-06 14:15:35');
INSERT INTO `t_users` VALUES ('4', 'qqwe', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'dfbhzdrh', 'arh', '2017-10-06 14:15:51');
INSERT INTO `t_users` VALUES ('6', 'aaa', '7e240de74fb1ed08fa08d38063f6a6a91462a815', 'aaa', 'aaa', '2017-10-09 09:46:42');
INSERT INTO `t_users` VALUES ('7', 'bbb', '5cb138284d431abd6a053a56625ec088bfb88912', 'aaa', 'aaa', '2017-10-09 10:06:09');
INSERT INTO `t_users` VALUES ('8', 'ccc', 'f36b4825e5db2cf7dd2d2593b3f5c24c0311d8b2', 'ccc', 'ccc', '2017-10-09 10:13:12');
