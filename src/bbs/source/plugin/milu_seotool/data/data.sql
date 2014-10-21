SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `pre_milu_seotool_included`
-- ----------------------------
DROP TABLE IF EXISTS `pre_milu_seotool_included`;
CREATE TABLE `pre_milu_seotool_included` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `baidu_included` int(10) unsigned NOT NULL DEFAULT '0',
  `baidu_ping` int(10) NOT NULL DEFAULT '0',
  `baidu_spider_last` int(10) unsigned NOT NULL DEFAULT '0',
  `baidu_spider_count` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `google_included` int(10) unsigned NOT NULL DEFAULT '0',
  `google_ping` int(10) NOT NULL DEFAULT '0',
  `google_spider_last` int(10) unsigned NOT NULL DEFAULT '0',
  `google_spider_count` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `baidu_modify_dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `google_modify_dateline` int(10) unsigned NOT NULL,
  `data_id` int(10) unsigned NOT NULL DEFAULT '0',
  `data_type` tinyint(1) unsigned zerofill NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1724 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_milu_seotool_included
-- ----------------------------

-- ----------------------------
-- Table structure for `pre_milu_seotool_keyword`
-- ----------------------------
DROP TABLE IF EXISTS `pre_milu_seotool_keyword`;
CREATE TABLE `pre_milu_seotool_keyword` (
  `kid` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`kid`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_milu_seotool_keyword
-- ----------------------------

-- ----------------------------
-- Table structure for `pre_milu_seotool_keyword_rank`
-- ----------------------------
DROP TABLE IF EXISTS `pre_milu_seotool_keyword_rank`;
CREATE TABLE `pre_milu_seotool_keyword_rank` (
  `rank` varchar(255) NOT NULL,
  `kid` mediumint(8) unsigned NOT NULL,
  `daytime` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_milu_seotool_keyword_rank
-- ----------------------------

-- ----------------------------
-- Table structure for `pre_milu_seotool_spider`
-- ----------------------------
DROP TABLE IF EXISTS `pre_milu_seotool_spider`;
CREATE TABLE `pre_milu_seotool_spider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `spider_type` tinyint(1) unsigned NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  `page_url` varchar(255) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `group_child_id` tinyint(1) unsigned NOT NULL,
  `group_parent_id` tinyint(1) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1134 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_milu_seotool_spider
-- ----------------------------
