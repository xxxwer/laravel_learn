# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.18-0ubuntu0.16.04.1)
# Database: infinite_link
# Generation Time: 2017-06-14 05:23:23 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table content
# ------------------------------------------------------------

DROP TABLE IF EXISTS `content`;

CREATE TABLE `content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` text,
  `updated_at` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table garbage_info_filter
# ------------------------------------------------------------

DROP TABLE IF EXISTS `garbage_info_filter`;

CREATE TABLE `garbage_info_filter` (
  `word` varchar(150) NOT NULL DEFAULT '',
  `useful_count` bigint(20) NOT NULL DEFAULT '0',
  `garbage_count` bigint(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`word`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table garbage_info_param
# ------------------------------------------------------------

DROP TABLE IF EXISTS `garbage_info_param`;

CREATE TABLE `garbage_info_param` (
  `param_type` varchar(30) NOT NULL DEFAULT '',
  `param_value` varchar(30) NOT NULL DEFAULT '0',
  PRIMARY KEY (`param_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table keyword
# ------------------------------------------------------------

DROP TABLE IF EXISTS `keyword`;

CREATE TABLE `keyword` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(200) NOT NULL,
  `click_number` bigint(18) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table keyword_link_content
# ------------------------------------------------------------

DROP TABLE IF EXISTS `keyword_link_content`;

CREATE TABLE `keyword_link_content` (
  `id_keyword` int(11) NOT NULL,
  `id_content` int(11) NOT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_keyword`,`id_content`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table keyword_link_keyword
# ------------------------------------------------------------

DROP TABLE IF EXISTS `keyword_link_keyword`;

CREATE TABLE `keyword_link_keyword` (
  `id_keyword_parent` int(11) NOT NULL,
  `id_keyword` int(11) NOT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_keyword_parent`,`id_keyword`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sph_counter
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sph_counter`;

CREATE TABLE `sph_counter` (
  `counter_id` int(11) NOT NULL,
  `max_doc_id` int(11) NOT NULL,
  PRIMARY KEY (`counter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
