# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.50-0ubuntu0.12.04.1)
# Database: archmap
# Generation Time: 2016-08-18 13:54:34 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table aliases
# ------------------------------------------------------------

CREATE TABLE `aliases` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entity_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_plural` varchar(255) DEFAULT NULL,
  `metaphone` varchar(255) DEFAULT NULL,
  `lang` char(3) NOT NULL DEFAULT 'en',
  `author_id` int(11) DEFAULT NULL,
  `createdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `name_index` (`name`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table attribute
# ------------------------------------------------------------

CREATE TABLE `attribute` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `datatype` int(11) DEFAULT '1' COMMENT 'bool [1] , int, float',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table attribute_sheet
# ------------------------------------------------------------

CREATE TABLE `attribute_sheet` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `author_id` int(11) DEFAULT NULL,
  `entity_id` int(11) DEFAULT NULL,
  `subtype` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table attribute_sheet_item
# ------------------------------------------------------------

CREATE TABLE `attribute_sheet_item` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sheet_id` int(11) DEFAULT NULL,
  `attr_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table attribute_value
# ------------------------------------------------------------

CREATE TABLE `attribute_value` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `entity_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `attr_id` int(11) DEFAULT NULL,
  `val` float DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `beg_year` smallint(6) DEFAULT NULL,
  `end_year` int(11) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table bibliographic_entry
# ------------------------------------------------------------

CREATE TABLE `bibliographic_entry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entity_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `publication_id` int(11) NOT NULL,
  `pages` varchar(15) NOT NULL,
  `notes` text NOT NULL,
  `author_id` int(11) NOT NULL,
  `createdate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table building
# ------------------------------------------------------------

CREATE TABLE `building` (
  `id` smallint(20) unsigned NOT NULL AUTO_INCREMENT,
  `entity_id` smallint(5) unsigned NOT NULL DEFAULT '40',
  `name` varchar(255) NOT NULL,
  `metaphone` varchar(255) DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `lng` double DEFAULT NULL,
  `lat2` double DEFAULT NULL,
  `lng2` double DEFAULT NULL,
  `radius` float DEFAULT NULL,
  `geo_precision` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `beg_year` mediumint(9) DEFAULT NULL,
  `end_year` mediumint(9) DEFAULT NULL,
  `date` varchar(64) DEFAULT NULL,
  `duration` smallint(6) DEFAULT NULL,
  `style` tinyint(3) unsigned DEFAULT '11',
  `functional_type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `formal_type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `building_key` varchar(6) DEFAULT NULL,
  `orient` text,
  `elev` text,
  `building_name` varchar(100) DEFAULT NULL,
  `town_id` smallint(6) DEFAULT NULL,
  `pages` varchar(50) DEFAULT NULL,
  `wikipedia` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `preservation` tinyint(4) NOT NULL DEFAULT '3',
  `height` float NOT NULL DEFAULT '0',
  `width` float NOT NULL DEFAULT '0',
  `length` float NOT NULL DEFAULT '0',
  `spring` float NOT NULL DEFAULT '0',
  `arcade_width` float DEFAULT NULL,
  `arcade_height` float DEFAULT NULL,
  `arcade_spring` float DEFAULT NULL,
  `aisle_height` float DEFAULT NULL,
  `aisle_width` float DEFAULT NULL,
  `aisle_spring` float DEFAULT NULL,
  `prec_thin` smallint(6) DEFAULT NULL,
  `prec_elong` smallint(6) DEFAULT NULL,
  `prec_windows` smallint(6) DEFAULT NULL,
  `prec_stories` int(11) DEFAULT NULL,
  `prec_levitation` smallint(6) DEFAULT NULL,
  `elev_min` text,
  `elev_max` text,
  `descript` text,
  `plan` text,
  `elevation` text,
  `history` text,
  `chronology` text,
  `significance` text,
  `bibliography` text,
  `sculpture` text,
  `pref_rating` tinyint(20) DEFAULT NULL,
  `building_type` varchar(50) DEFAULT 'church',
  `media_plan_exists` tinyint(4) NOT NULL DEFAULT '0',
  `media_genplan_exists` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `media_smartplan_exists` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `fla_gen_dwg` tinyint(4) DEFAULT '0',
  `fla_gen_ai` tinyint(4) NOT NULL DEFAULT '0',
  `fla_vw_pre_2005` tinyint(4) NOT NULL DEFAULT '0',
  `fla_totstat_dwg` tinyint(4) NOT NULL DEFAULT '0',
  `fla_cyrax_ai` tinyint(4) NOT NULL DEFAULT '0',
  `media_section_exists` tinyint(4) NOT NULL DEFAULT '0',
  `media_minimodel` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `media_qtvr_exists` tinyint(4) NOT NULL DEFAULT '0',
  `media_pier_exists` tinyint(4) NOT NULL DEFAULT '0',
  `media_elev_exists` tinyint(4) NOT NULL DEFAULT '0',
  `visited` tinytext NOT NULL,
  `internal_ref_num` smallint(5) unsigned DEFAULT NULL,
  `slideshow_id` smallint(5) unsigned DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `author_id` mediumint(8) unsigned DEFAULT NULL,
  `editdate` datetime DEFAULT NULL,
  `edit_author_id` mediumint(8) unsigned DEFAULT NULL,
  `poster_id` int(10) unsigned DEFAULT NULL,
  `plan_image_id` mediumint(8) unsigned DEFAULT NULL,
  `lat_section_image_id` mediumint(8) unsigned DEFAULT NULL,
  `long_section_image_id` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`) USING BTREE,
  KEY `style` (`style`) USING BTREE,
  FULLTEXT KEY `name_2` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table building_dims
# ------------------------------------------------------------

CREATE TABLE `building_dims` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `building_id` int(11) NOT NULL,
  `zone` tinyint(3) unsigned NOT NULL,
  `position` tinyint(3) unsigned NOT NULL,
  `dim` tinyint(3) unsigned NOT NULL,
  `value` float NOT NULL,
  `source` tinyint(3) unsigned DEFAULT NULL,
  `source_id` mediumint(8) unsigned DEFAULT NULL,
  `editor_id` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='The source is [0: "measured", 1:"image", 2:publication]\n\nif ';



# Dump of table building_models
# ------------------------------------------------------------

CREATE TABLE `building_models` (
  `modelid` int(11) NOT NULL AUTO_INCREMENT,
  `building_id` int(11) DEFAULT NULL,
  `building_key` char(6) NOT NULL DEFAULT '',
  `plan_cen_x` smallint(5) unsigned NOT NULL DEFAULT '0',
  `plan_cen_y` smallint(5) unsigned NOT NULL DEFAULT '0',
  `narthex_n2` tinyint(4) NOT NULL DEFAULT '0',
  `narthex_n1` tinyint(4) NOT NULL DEFAULT '0',
  `narthex` tinyint(4) NOT NULL DEFAULT '0',
  `narthex_s1` tinyint(4) NOT NULL DEFAULT '0',
  `narthex_s2` tinyint(4) NOT NULL DEFAULT '0',
  `nave_n2` tinyint(4) NOT NULL DEFAULT '0',
  `nave_n1` tinyint(4) NOT NULL DEFAULT '0',
  `nave` tinyint(4) NOT NULL DEFAULT '0',
  `nave_s1` tinyint(4) NOT NULL DEFAULT '0',
  `nave_s2` tinyint(4) NOT NULL DEFAULT '0',
  `crossing_n2` tinyint(4) NOT NULL DEFAULT '0',
  `crossing_n1` tinyint(4) NOT NULL DEFAULT '0',
  `crossing` tinyint(4) NOT NULL DEFAULT '0',
  `crossing_s1` tinyint(4) NOT NULL DEFAULT '0',
  `crossing_s2` tinyint(4) NOT NULL DEFAULT '0',
  `choir_n2` tinyint(4) NOT NULL DEFAULT '0',
  `choir_n1` tinyint(4) NOT NULL DEFAULT '0',
  `choir` tinyint(4) NOT NULL DEFAULT '0',
  `choir_s1` tinyint(4) NOT NULL DEFAULT '0',
  `choir_s2` tinyint(4) NOT NULL DEFAULT '0',
  `apse_n2` tinyint(4) NOT NULL DEFAULT '0',
  `apse_n1` tinyint(4) NOT NULL DEFAULT '0',
  `apse` tinyint(4) NOT NULL DEFAULT '0',
  `apse_s1` tinyint(4) NOT NULL DEFAULT '0',
  `apse_s2` tinyint(4) NOT NULL DEFAULT '0',
  `ambulatory_1` tinyint(4) NOT NULL DEFAULT '0',
  `ambulatory_2` tinyint(4) NOT NULL DEFAULT '0',
  `apse_r` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `tower` tinyint(4) NOT NULL DEFAULT '0',
  `narthex_l` smallint(5) unsigned NOT NULL DEFAULT '40',
  `nave_l` smallint(5) unsigned NOT NULL DEFAULT '200',
  `crossing_l` smallint(5) unsigned NOT NULL DEFAULT '100',
  `choir_l` smallint(5) unsigned NOT NULL DEFAULT '50',
  `apse_n2_1` smallint(5) unsigned NOT NULL DEFAULT '20',
  `apse_n1_l` smallint(5) unsigned NOT NULL DEFAULT '20',
  `apse_l` smallint(5) unsigned NOT NULL DEFAULT '50',
  `apse_s1_l` smallint(5) unsigned NOT NULL DEFAULT '20',
  `apse_s2_l` smallint(5) unsigned NOT NULL DEFAULT '20',
  `narthex_bays` tinyint(3) unsigned NOT NULL DEFAULT '10',
  `nave_bays` tinyint(3) unsigned NOT NULL DEFAULT '30',
  `crossing_bays` tinyint(3) unsigned NOT NULL DEFAULT '10',
  `choir_bays` tinyint(3) unsigned NOT NULL DEFAULT '10',
  `apse_bays` tinyint(3) unsigned NOT NULL DEFAULT '10',
  `narthex_n2_w` smallint(5) unsigned NOT NULL DEFAULT '40',
  `narthex_n1_w` smallint(5) unsigned NOT NULL DEFAULT '40',
  `narthex_w` smallint(5) unsigned NOT NULL DEFAULT '100',
  `narthex_s1_w` smallint(5) unsigned NOT NULL DEFAULT '40',
  `narthex_s2_w` smallint(5) unsigned NOT NULL DEFAULT '40',
  `nave_n2_w` smallint(5) unsigned NOT NULL DEFAULT '40',
  `nave_n1_w` smallint(5) unsigned NOT NULL DEFAULT '40',
  `nave_w` smallint(5) unsigned NOT NULL DEFAULT '100',
  `nave_s1_w` smallint(5) unsigned NOT NULL DEFAULT '40',
  `nave_s2_w` smallint(5) unsigned NOT NULL DEFAULT '40',
  `choir_n2_w` smallint(5) unsigned NOT NULL DEFAULT '40',
  `choir_n1_w` smallint(5) unsigned NOT NULL DEFAULT '40',
  `choir_w` smallint(5) unsigned NOT NULL DEFAULT '100',
  `choir_s1_w` smallint(5) unsigned NOT NULL DEFAULT '40',
  `choir_s2_w` smallint(5) unsigned NOT NULL DEFAULT '40',
  `crossing_n2_w` smallint(5) unsigned NOT NULL DEFAULT '60',
  `crossing_n1_w` smallint(5) unsigned NOT NULL DEFAULT '60',
  `crossing_w` smallint(5) unsigned NOT NULL DEFAULT '100',
  `crossing_s1_w` smallint(5) unsigned NOT NULL DEFAULT '60',
  `crossing_s2_w` smallint(5) unsigned NOT NULL DEFAULT '60',
  `apse_n2_w` smallint(5) unsigned NOT NULL DEFAULT '20',
  `apse_n1_w` smallint(5) unsigned NOT NULL DEFAULT '20',
  `apse_w` smallint(5) unsigned NOT NULL DEFAULT '50',
  `apse_s1_w` smallint(5) unsigned NOT NULL DEFAULT '20',
  `apse_s2_w` smallint(5) unsigned NOT NULL DEFAULT '20',
  `nave_n2_h` smallint(6) NOT NULL DEFAULT '60',
  `nave_n2_vh` smallint(6) NOT NULL DEFAULT '20',
  `nave_n1_h` smallint(6) NOT NULL DEFAULT '60',
  `nave_n1_vh` smallint(6) NOT NULL DEFAULT '20',
  `nave_h` smallint(6) DEFAULT NULL,
  `nave_vh` smallint(6) DEFAULT NULL,
  `nave_rrh` smallint(6) DEFAULT NULL,
  `nave_rch` smallint(6) DEFAULT NULL,
  `nave_s1_h` smallint(6) NOT NULL DEFAULT '60',
  `nave_s1_vh` smallint(6) NOT NULL DEFAULT '20',
  `nave_s2_h` smallint(6) NOT NULL DEFAULT '60',
  `nave_s2_vh` smallint(6) NOT NULL DEFAULT '20',
  `crossing_n2_h` smallint(6) NOT NULL DEFAULT '100',
  `crossing_n1_h` smallint(6) NOT NULL DEFAULT '100',
  `crossing_h` smallint(6) NOT NULL DEFAULT '120',
  `crossing_s1_h` smallint(6) NOT NULL DEFAULT '100',
  `crossing_s2_h` smallint(6) NOT NULL DEFAULT '100',
  `apse_n2_h` smallint(6) NOT NULL DEFAULT '50',
  `apse_n1_h` smallint(6) NOT NULL DEFAULT '50',
  `apse_h` smallint(6) NOT NULL DEFAULT '80',
  `apse_s1_h` smallint(6) NOT NULL DEFAULT '50',
  `apse_s2_h` smallint(6) NOT NULL DEFAULT '50',
  `choir_n2_h` smallint(6) NOT NULL DEFAULT '0',
  `choir_n1_h` smallint(6) NOT NULL DEFAULT '0',
  `choir_h` smallint(6) NOT NULL DEFAULT '0',
  `choir_s1_h` smallint(6) NOT NULL DEFAULT '0',
  `choir_s2_h` smallint(6) NOT NULL DEFAULT '0',
  `narthex_n2_h` smallint(6) NOT NULL DEFAULT '0',
  `narthex_n1_h` smallint(6) NOT NULL DEFAULT '0',
  `narthex_h` smallint(6) NOT NULL DEFAULT '0',
  `narthex_s1_h` smallint(6) NOT NULL DEFAULT '0',
  `narthex_s2_h` smallint(6) NOT NULL DEFAULT '0',
  `tower_rrh` smallint(6) DEFAULT NULL,
  `tower_rch` smallint(6) DEFAULT NULL,
  `aisle_rrh` smallint(6) DEFAULT NULL,
  `aisle_rch` smallint(6) DEFAULT NULL,
  `nave_n2_e_rh` smallint(6) NOT NULL DEFAULT '0',
  `nave_n2_e_ch` smallint(6) NOT NULL DEFAULT '0',
  `nave_n1_e_rh` smallint(6) NOT NULL DEFAULT '0',
  `nave_n1_e_ch` smallint(6) NOT NULL DEFAULT '0',
  `nave_e_rh` smallint(6) NOT NULL DEFAULT '0',
  `nave_e_ch` smallint(6) NOT NULL DEFAULT '0',
  `nave_s1_e_rh` smallint(6) NOT NULL DEFAULT '0',
  `nave_s1_e_ch` smallint(6) NOT NULL DEFAULT '0',
  `nave_s2_e_rh` smallint(6) NOT NULL DEFAULT '0',
  `nave_s2_e_ch` smallint(6) NOT NULL DEFAULT '0',
  `nave_thrust` float NOT NULL DEFAULT '1',
  `nave_s1_thrust` float NOT NULL DEFAULT '0.5',
  `nave_s2_thrust` float NOT NULL DEFAULT '0.5',
  `nave_n1_thrust` float NOT NULL DEFAULT '0.5',
  `nave_n2_thrust` float NOT NULL DEFAULT '0.5',
  `elev_church` smallint(6) DEFAULT NULL,
  `elev_low` smallint(6) DEFAULT NULL,
  `elev_high` smallint(6) DEFAULT NULL,
  `elev_town` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`modelid`),
  UNIQUE KEY `building_key` (`building_key`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table building_models_copy
# ------------------------------------------------------------

CREATE TABLE `building_models_copy` (
  `modelid` int(11) NOT NULL AUTO_INCREMENT,
  `building_key` char(6) NOT NULL DEFAULT '',
  `plan_cen_x` smallint(5) unsigned NOT NULL DEFAULT '0',
  `plan_cen_y` smallint(5) unsigned NOT NULL DEFAULT '0',
  `narthex_n2` tinyint(4) NOT NULL DEFAULT '0',
  `narthex_n1` tinyint(4) NOT NULL DEFAULT '0',
  `narthex` tinyint(4) NOT NULL DEFAULT '0',
  `narthex_s1` tinyint(4) NOT NULL DEFAULT '0',
  `narthex_s2` tinyint(4) NOT NULL DEFAULT '0',
  `nave_n2` tinyint(4) NOT NULL DEFAULT '0',
  `nave_n1` tinyint(4) NOT NULL DEFAULT '0',
  `nave` tinyint(4) NOT NULL DEFAULT '0',
  `nave_s1` tinyint(4) NOT NULL DEFAULT '0',
  `nave_s2` tinyint(4) NOT NULL DEFAULT '0',
  `crossing_n2` tinyint(4) NOT NULL DEFAULT '0',
  `crossing_n1` tinyint(4) NOT NULL DEFAULT '0',
  `crossing` tinyint(4) NOT NULL DEFAULT '0',
  `crossing_s1` tinyint(4) NOT NULL DEFAULT '0',
  `crossing_s2` tinyint(4) NOT NULL DEFAULT '0',
  `choir_n2` tinyint(4) NOT NULL DEFAULT '0',
  `choir_n1` tinyint(4) NOT NULL DEFAULT '0',
  `choir` tinyint(4) NOT NULL DEFAULT '0',
  `choir_s1` tinyint(4) NOT NULL DEFAULT '0',
  `choir_s2` tinyint(4) NOT NULL DEFAULT '0',
  `apse_n2` tinyint(4) NOT NULL DEFAULT '0',
  `apse_n1` tinyint(4) NOT NULL DEFAULT '0',
  `apse` tinyint(4) NOT NULL DEFAULT '0',
  `apse_s1` tinyint(4) NOT NULL DEFAULT '0',
  `apse_s2` tinyint(4) NOT NULL DEFAULT '0',
  `ambulatory_1` tinyint(4) NOT NULL DEFAULT '0',
  `ambulatory_2` tinyint(4) NOT NULL DEFAULT '0',
  `apse_r` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `tower` tinyint(4) NOT NULL DEFAULT '0',
  `narthex_l` smallint(5) unsigned NOT NULL DEFAULT '40',
  `nave_l` smallint(5) unsigned NOT NULL DEFAULT '200',
  `crossing_l` smallint(5) unsigned NOT NULL DEFAULT '100',
  `choir_l` smallint(5) unsigned NOT NULL DEFAULT '50',
  `apse_n2_1` smallint(5) unsigned NOT NULL DEFAULT '20',
  `apse_n1_l` smallint(5) unsigned NOT NULL DEFAULT '20',
  `apse_l` smallint(5) unsigned NOT NULL DEFAULT '50',
  `apse_s1_l` smallint(5) unsigned NOT NULL DEFAULT '20',
  `apse_s2_l` smallint(5) unsigned NOT NULL DEFAULT '20',
  `narthex_bays` tinyint(3) unsigned NOT NULL DEFAULT '10',
  `nave_bays` tinyint(3) unsigned NOT NULL DEFAULT '30',
  `crossing_bays` tinyint(3) unsigned NOT NULL DEFAULT '10',
  `choir_bays` tinyint(3) unsigned NOT NULL DEFAULT '10',
  `apse_bays` tinyint(3) unsigned NOT NULL DEFAULT '10',
  `narthex_n2_w` smallint(5) unsigned NOT NULL DEFAULT '40',
  `narthex_n1_w` smallint(5) unsigned NOT NULL DEFAULT '40',
  `narthex_w` smallint(5) unsigned NOT NULL DEFAULT '100',
  `narthex_s1_w` smallint(5) unsigned NOT NULL DEFAULT '40',
  `narthex_s2_w` smallint(5) unsigned NOT NULL DEFAULT '40',
  `nave_n2_w` smallint(5) unsigned NOT NULL DEFAULT '40',
  `nave_n1_w` smallint(5) unsigned NOT NULL DEFAULT '40',
  `nave_w` smallint(5) unsigned NOT NULL DEFAULT '100',
  `nave_s1_w` smallint(5) unsigned NOT NULL DEFAULT '40',
  `nave_s2_w` smallint(5) unsigned NOT NULL DEFAULT '40',
  `choir_n2_w` smallint(5) unsigned NOT NULL DEFAULT '40',
  `choir_n1_w` smallint(5) unsigned NOT NULL DEFAULT '40',
  `choir_w` smallint(5) unsigned NOT NULL DEFAULT '100',
  `choir_s1_w` smallint(5) unsigned NOT NULL DEFAULT '40',
  `choir_s2_w` smallint(5) unsigned NOT NULL DEFAULT '40',
  `crossing_n2_w` smallint(5) unsigned NOT NULL DEFAULT '60',
  `crossing_n1_w` smallint(5) unsigned NOT NULL DEFAULT '60',
  `crossing_w` smallint(5) unsigned NOT NULL DEFAULT '100',
  `crossing_s1_w` smallint(5) unsigned NOT NULL DEFAULT '60',
  `crossing_s2_w` smallint(5) unsigned NOT NULL DEFAULT '60',
  `apse_n2_w` smallint(5) unsigned NOT NULL DEFAULT '20',
  `apse_n1_w` smallint(5) unsigned NOT NULL DEFAULT '20',
  `apse_w` smallint(5) unsigned NOT NULL DEFAULT '50',
  `apse_s1_w` smallint(5) unsigned NOT NULL DEFAULT '20',
  `apse_s2_w` smallint(5) unsigned NOT NULL DEFAULT '20',
  `nave_n2_h` smallint(6) NOT NULL DEFAULT '60',
  `nave_n2_vh` smallint(6) NOT NULL DEFAULT '20',
  `nave_n1_h` smallint(6) NOT NULL DEFAULT '60',
  `nave_n1_vh` smallint(6) NOT NULL DEFAULT '20',
  `nave_h` smallint(6) DEFAULT NULL,
  `nave_vh` smallint(6) DEFAULT NULL,
  `nave_rrh` smallint(6) DEFAULT NULL,
  `nave_rch` smallint(6) DEFAULT NULL,
  `nave_s1_h` smallint(6) NOT NULL DEFAULT '60',
  `nave_s1_vh` smallint(6) NOT NULL DEFAULT '20',
  `nave_s2_h` smallint(6) NOT NULL DEFAULT '60',
  `nave_s2_vh` smallint(6) NOT NULL DEFAULT '20',
  `crossing_n2_h` smallint(6) NOT NULL DEFAULT '100',
  `crossing_n1_h` smallint(6) NOT NULL DEFAULT '100',
  `crossing_h` smallint(6) NOT NULL DEFAULT '120',
  `crossing_s1_h` smallint(6) NOT NULL DEFAULT '100',
  `crossing_s2_h` smallint(6) NOT NULL DEFAULT '100',
  `apse_n2_h` smallint(6) NOT NULL DEFAULT '50',
  `apse_n1_h` smallint(6) NOT NULL DEFAULT '50',
  `apse_h` smallint(6) NOT NULL DEFAULT '80',
  `apse_s1_h` smallint(6) NOT NULL DEFAULT '50',
  `apse_s2_h` smallint(6) NOT NULL DEFAULT '50',
  `choir_n2_h` smallint(6) NOT NULL DEFAULT '0',
  `choir_n1_h` smallint(6) NOT NULL DEFAULT '0',
  `choir_h` smallint(6) NOT NULL DEFAULT '0',
  `choir_s1_h` smallint(6) NOT NULL DEFAULT '0',
  `choir_s2_h` smallint(6) NOT NULL DEFAULT '0',
  `narthex_n2_h` smallint(6) NOT NULL DEFAULT '0',
  `narthex_n1_h` smallint(6) NOT NULL DEFAULT '0',
  `narthex_h` smallint(6) NOT NULL DEFAULT '0',
  `narthex_s1_h` smallint(6) NOT NULL DEFAULT '0',
  `narthex_s2_h` smallint(6) NOT NULL DEFAULT '0',
  `tower_rrh` smallint(6) DEFAULT NULL,
  `tower_rch` smallint(6) DEFAULT NULL,
  `aisle_rrh` smallint(6) DEFAULT NULL,
  `aisle_rch` smallint(6) DEFAULT NULL,
  `nave_n2_e_rh` smallint(6) NOT NULL DEFAULT '0',
  `nave_n2_e_ch` smallint(6) NOT NULL DEFAULT '0',
  `nave_n1_e_rh` smallint(6) NOT NULL DEFAULT '0',
  `nave_n1_e_ch` smallint(6) NOT NULL DEFAULT '0',
  `nave_e_rh` smallint(6) NOT NULL DEFAULT '0',
  `nave_e_ch` smallint(6) NOT NULL DEFAULT '0',
  `nave_s1_e_rh` smallint(6) NOT NULL DEFAULT '0',
  `nave_s1_e_ch` smallint(6) NOT NULL DEFAULT '0',
  `nave_s2_e_rh` smallint(6) NOT NULL DEFAULT '0',
  `nave_s2_e_ch` smallint(6) NOT NULL DEFAULT '0',
  `nave_thrust` float NOT NULL DEFAULT '1',
  `nave_s1_thrust` float NOT NULL DEFAULT '0.5',
  `nave_s2_thrust` float NOT NULL DEFAULT '0.5',
  `nave_n1_thrust` float NOT NULL DEFAULT '0.5',
  `nave_n2_thrust` float NOT NULL DEFAULT '0.5',
  `elev_church` smallint(6) DEFAULT NULL,
  `elev_low` smallint(6) DEFAULT NULL,
  `elev_high` smallint(6) DEFAULT NULL,
  `elev_town` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`modelid`),
  UNIQUE KEY `building_key` (`building_key`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table collection
# ------------------------------------------------------------

CREATE TABLE `collection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entity_id` smallint(5) unsigned NOT NULL DEFAULT '70',
  `name` varchar(255) DEFAULT NULL,
  `metaphone` varchar(75) DEFAULT NULL,
  `statictype` varchar(255) DEFAULT NULL,
  `inverse` varchar(255) DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `lat2` float DEFAULT NULL,
  `lng2` float DEFAULT NULL,
  `radius` float DEFAULT NULL,
  `beg_year` mediumint(9) DEFAULT NULL,
  `end_year` mediumint(9) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL COMMENT 'duration can also serve as a chronological blur. If no end_year is specified, it blurs on either side of the beg_year, else, it is a blur before beg_year and after_end year',
  `descript` text,
  `parent_entity_id` int(11) DEFAULT NULL,
  `parent_item_id` mediumint(9) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `author_id` mediumint(8) DEFAULT NULL,
  `private` tinyint(3) unsigned DEFAULT '0',
  `canonical` tinyint(3) DEFAULT '0',
  `type` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `is_social` tinyint(3) unsigned DEFAULT '0',
  `editdate` datetime DEFAULT NULL,
  `edit_author_id` mediumint(8) unsigned DEFAULT NULL,
  `render_style` smallint(5) unsigned DEFAULT NULL,
  `isUser` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `search_key` (`name`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table collection_item
# ------------------------------------------------------------

CREATE TABLE `collection_item` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `collection_id` mediumint(8) unsigned NOT NULL DEFAULT '1',
  `item_entity_id` smallint(5) unsigned NOT NULL,
  `item_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `sortval` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `color` varchar(255) DEFAULT NULL,
  `icon_shape` text,
  `beg_year` int(11) DEFAULT NULL,
  `end_year` int(11) DEFAULT NULL,
  `notes` text,
  `createdate` datetime NOT NULL DEFAULT '2009-02-17 17:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `list` (`collection_id`,`item_entity_id`,`item_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table element_type_alias
# ------------------------------------------------------------

CREATE TABLE `element_type_alias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `element_type_id` int(10) unsigned NOT NULL,
  `lang` char(3) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `alias_plural` varchar(255) DEFAULT NULL,
  `metaphone` varchar(255) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `author_id` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table entity_ids
# ------------------------------------------------------------

CREATE TABLE `entity_ids` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `classname` varchar(50) DEFAULT NULL,
  `table_name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table EO_PK_TABLE
# ------------------------------------------------------------

CREATE TABLE `EO_PK_TABLE` (
  `NAME` char(40) NOT NULL DEFAULT '',
  `PK` int(11) DEFAULT NULL,
  PRIMARY KEY (`NAME`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table essay
# ------------------------------------------------------------

CREATE TABLE `essay` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `entity_id` smallint(5) unsigned NOT NULL DEFAULT '150',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metaphone` varchar(75) CHARACTER SET latin1 DEFAULT NULL,
  `urlalias` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `lat2` float DEFAULT NULL,
  `lng2` float DEFAULT NULL,
  `radius` float DEFAULT NULL,
  `beg_year` mediumint(9) DEFAULT NULL,
  `end_year` mediumint(9) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL COMMENT 'duration can also serve as a chronological blur. If no end_year is specified, it blurs on either side of the beg_year, else, it is a blur before beg_year and after_end year',
  `descript` text CHARACTER SET latin1 COLLATE latin1_bin,
  `wikipedia` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `author_id` mediumint(8) unsigned DEFAULT NULL,
  `editdate` datetime NOT NULL,
  `edit_author_id` mediumint(8) unsigned DEFAULT NULL,
  `parent_entity_id` int(11) unsigned DEFAULT NULL,
  `parent_item_id` int(11) unsigned DEFAULT NULL,
  `public_status` int(10) unsigned NOT NULL DEFAULT '0',
  `project_type` varchar(64) DEFAULT NULL,
  `header_image` int(11) DEFAULT NULL,
  `subtype` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `isSite` tinyint(3) unsigned DEFAULT NULL,
  `siteCSS` text CHARACTER SET latin1,
  `maphue` varchar(11) DEFAULT 'e3c7b0',
  `landingimage_id` int(11) DEFAULT NULL,
  `mapimage_id` int(11) DEFAULT NULL,
  `turkish` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `testf` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `search_key` (`name`(250)) USING BTREE,
  KEY `metaphone_index` (`metaphone`) USING BTREE,
  KEY `name_index` (`name`(250)) USING BTREE,
  KEY `urlalias` (`urlalias`),
  FULLTEXT KEY `name_fulltext` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table essay_copy
# ------------------------------------------------------------

CREATE TABLE `essay_copy` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `entity_id` smallint(5) unsigned NOT NULL DEFAULT '150',
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `metaphone` varchar(75) CHARACTER SET latin1 DEFAULT NULL,
  `urlalias` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `lat2` float DEFAULT NULL,
  `lng2` float DEFAULT NULL,
  `radius` float DEFAULT NULL,
  `beg_year` mediumint(9) DEFAULT NULL,
  `end_year` mediumint(9) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL COMMENT 'duration can also serve as a chronological blur. If no end_year is specified, it blurs on either side of the beg_year, else, it is a blur before beg_year and after_end year',
  `descript` text CHARACTER SET latin1 COLLATE latin1_bin,
  `wikipedia` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `author_id` mediumint(8) unsigned DEFAULT NULL,
  `editdate` datetime NOT NULL,
  `edit_author_id` mediumint(8) unsigned DEFAULT NULL,
  `parent_entity_id` int(11) unsigned DEFAULT NULL,
  `parent_item_id` int(11) unsigned DEFAULT NULL,
  `public_status` int(10) unsigned NOT NULL DEFAULT '0',
  `project_type` varchar(64) DEFAULT NULL,
  `header_image` int(11) DEFAULT NULL,
  `subtype` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `isSite` tinyint(3) unsigned DEFAULT NULL,
  `siteCSS` text CHARACTER SET latin1,
  `landingimage_id` int(11) DEFAULT NULL,
  `mapimage_id` int(11) DEFAULT NULL,
  `turkish` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `testf` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `search_key` (`name`) USING BTREE,
  KEY `metaphone_index` (`metaphone`) USING BTREE,
  KEY `name_index` (`name`) USING BTREE,
  KEY `urlalias` (`urlalias`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table feature
# ------------------------------------------------------------

CREATE TABLE `feature` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `entity_id` int(11) unsigned NOT NULL DEFAULT '170',
  `subtype` varchar(128) CHARACTER SET latin1 DEFAULT NULL,
  `refnum` varchar(32) DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `metaphone` varchar(75) CHARACTER SET latin1 DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `lng` double DEFAULT NULL,
  `lat2` double DEFAULT NULL,
  `lng2` double DEFAULT NULL,
  `diameter` float DEFAULT NULL,
  `shape` text CHARACTER SET latin1,
  `length` float DEFAULT NULL,
  `width` float DEFAULT NULL,
  `height` float DEFAULT NULL,
  `date` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `beg_year` mediumint(9) DEFAULT NULL,
  `end_year` mediumint(9) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL COMMENT 'duration can also serve as a chronological blur. If no end_year is specified, it blurs on either side of the beg_year, else, it is a blur before beg_year and after_end year',
  `descript` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `material` varchar(128) DEFAULT NULL,
  `provenance` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `wikipedia` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `publication` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `current_location` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `current_location_catid` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `author_id` mediumint(8) unsigned DEFAULT NULL,
  `editdate` datetime NOT NULL,
  `edit_author_id` mediumint(8) unsigned DEFAULT NULL,
  `parent_entity_id` int(11) unsigned DEFAULT NULL,
  `parent_item_id` int(11) unsigned DEFAULT NULL,
  `public_status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `poster_id` int(11) DEFAULT NULL,
  `plan_image_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `search_key` (`name`(250)) USING BTREE,
  KEY `metaphone_index` (`metaphone`) USING BTREE,
  KEY `name_index` (`name`(250)) USING BTREE,
  FULLTEXT KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table feedback
# ------------------------------------------------------------

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `feedback` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table geo_country
# ------------------------------------------------------------

CREATE TABLE `geo_country` (
  `iso` char(2) NOT NULL DEFAULT '',
  `name` varchar(80) NOT NULL DEFAULT '',
  `printable_name` varchar(80) NOT NULL DEFAULT '',
  `iso3` char(3) DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`iso`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table geo_region
# ------------------------------------------------------------

CREATE TABLE `geo_region` (
  `id` int(11) NOT NULL DEFAULT '0',
  `country_code` char(3) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `descrip` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table historicalevent
# ------------------------------------------------------------

CREATE TABLE `historicalevent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entity_id` smallint(5) unsigned NOT NULL DEFAULT '20',
  `name` varchar(255) DEFAULT NULL,
  `metaphone` varchar(75) DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `lat2` float DEFAULT NULL,
  `lng2` float DEFAULT NULL,
  `radius` float DEFAULT NULL,
  `geo_precision` tinyint(3) unsigned DEFAULT NULL,
  `beg_year` mediumint(9) DEFAULT NULL,
  `end_year` mediumint(9) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL COMMENT 'duration can also serve as a chronological blur. If no end_year is specified, it blurs on either side of the beg_year, else, it is a blur before beg_year and after_end year',
  `descript` text,
  `pages` varchar(50) DEFAULT NULL,
  `wikipedia` varchar(255) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `author_id` mediumint(8) unsigned DEFAULT NULL,
  `editdate` datetime DEFAULT NULL,
  `edit_author_id` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `search_key` (`name`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table historicalobject
# ------------------------------------------------------------

CREATE TABLE `historicalobject` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `entity_id` smallint(5) unsigned NOT NULL DEFAULT '25',
  `name` varchar(255) DEFAULT NULL,
  `metaphone` varchar(75) DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `lng` double DEFAULT NULL,
  `lat2` double DEFAULT NULL,
  `lng2` double DEFAULT NULL,
  `radius` float DEFAULT NULL,
  `geo_precision` tinyint(3) unsigned DEFAULT NULL,
  `beg_year` mediumint(9) DEFAULT NULL,
  `end_year` mediumint(9) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL COMMENT 'duration can also serve as a chronological blur. If no end_year is specified, it blurs on either side of the beg_year, else, it is a blur before beg_year and after_end year',
  `descript` text,
  `pages` varchar(50) DEFAULT NULL,
  `wikipedia` varchar(255) DEFAULT NULL,
  `preservation` tinyint(4) NOT NULL DEFAULT '3',
  `createdate` datetime DEFAULT NULL,
  `author_id` mediumint(8) unsigned DEFAULT NULL,
  `editdate` datetime NOT NULL,
  `edit_author_id` mediumint(8) unsigned DEFAULT NULL,
  `parent_entity_id` int(11) unsigned DEFAULT NULL,
  `parent_item_id` int(11) unsigned DEFAULT NULL,
  `public_status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `search_key` (`name`) USING BTREE,
  KEY `metaphone_index` (`metaphone`) USING BTREE,
  KEY `name_index` (`name`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table image
# ------------------------------------------------------------

CREATE TABLE `image` (
  `id` int(9) NOT NULL DEFAULT '0',
  `entity_id` smallint(5) unsigned NOT NULL DEFAULT '110',
  `building_id` int(10) unsigned DEFAULT NULL,
  `filename` varchar(35) NOT NULL DEFAULT '',
  `orig_filename` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `filesystem` varchar(1) DEFAULT NULL,
  `filepath` varchar(64) DEFAULT NULL,
  `building_key` varchar(6) NOT NULL DEFAULT '',
  `mimetype` tinyint(3) unsigned DEFAULT NULL,
  `rating` tinyint(3) unsigned DEFAULT '0',
  `ext_int` char(3) NOT NULL DEFAULT '',
  `image_type` varchar(6) NOT NULL DEFAULT '0',
  `element_type` varchar(6) NOT NULL DEFAULT '',
  `itemid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `direction` char(3) NOT NULL DEFAULT '',
  `direction_id` tinyint(3) unsigned DEFAULT NULL,
  `width` smallint(5) unsigned DEFAULT NULL,
  `height` smallint(5) unsigned DEFAULT NULL,
  `size` decimal(10,0) unsigned DEFAULT NULL,
  `scale` float(10,6) unsigned DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `lng` double DEFAULT NULL,
  `lat2` double DEFAULT NULL,
  `lng2` double DEFAULT NULL,
  `longitude` float(10,6) DEFAULT NULL,
  `latitude` float(10,6) DEFAULT NULL,
  `altitude` mediumint(9) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `descript` text,
  `keywords` varchar(255) DEFAULT NULL,
  `author_id` mediumint(8) unsigned DEFAULT NULL,
  `author_status` varchar(50) DEFAULT NULL,
  `publication_id` int(10) unsigned DEFAULT NULL,
  `pages` varchar(20) DEFAULT NULL,
  `originaldate` datetime DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `editdate` datetime DEFAULT NULL,
  `edit_author_id` mediumint(8) unsigned DEFAULT NULL,
  `views` int(10) unsigned DEFAULT '0',
  `has_stereo` tinyint(1) NOT NULL DEFAULT '0',
  `has_sd_tiles` tinyint(1) DEFAULT NULL,
  `cen_x` float unsigned DEFAULT '0',
  `cen_y` float unsigned DEFAULT '0',
  `orien` float DEFAULT '0',
  `scale_pt1_x` float DEFAULT NULL,
  `scale_pt1_y` float DEFAULT NULL,
  `scale_pt2_x` float DEFAULT NULL,
  `scale_pt2_y` float DEFAULT NULL,
  `scale_real_length` float DEFAULT NULL,
  `scale_abs` double NOT NULL DEFAULT '10',
  `pan` float NOT NULL DEFAULT '0',
  `tilt` float NOT NULL DEFAULT '0',
  `fov` float NOT NULL DEFAULT '70',
  PRIMARY KEY (`id`),
  UNIQUE KEY `filename` (`filename`) USING BTREE,
  KEY `building_key` (`building_key`,`ext_int`) USING BTREE,
  KEY `building_id` (`building_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table image_image_type_values
# ------------------------------------------------------------

CREATE TABLE `image_image_type_values` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image_id` mediumint(8) unsigned NOT NULL,
  `image_type_id` smallint(5) unsigned NOT NULL,
  `weight` tinyint(1) unsigned DEFAULT '3',
  `confirmation` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `image_element` (`image_id`,`image_type_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table image_keyword_values
# ------------------------------------------------------------

CREATE TABLE `image_keyword_values` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image_id` mediumint(8) unsigned NOT NULL,
  `keyword_id` smallint(5) unsigned NOT NULL,
  `weight` tinyint(1) unsigned DEFAULT '3',
  `confirmation` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table image_laserscan_gigapixel
# ------------------------------------------------------------

CREATE TABLE `image_laserscan_gigapixel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `building_id` mediumint(8) unsigned NOT NULL,
  `laserscan_link` varchar(1024) DEFAULT NULL,
  `gigapixel_link` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table image_plot
# ------------------------------------------------------------

CREATE TABLE `image_plot` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image_id` int(11) NOT NULL,
  `media_type` tinyint(3) unsigned NOT NULL,
  `media_id` int(10) unsigned NOT NULL,
  `xloc` smallint(6) NOT NULL,
  `yloc` smallint(6) NOT NULL,
  `rotation` smallint(6) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `level` tinyint(3) DEFAULT NULL,
  `author_id` mediumint(8) unsigned DEFAULT NULL,
  `editdate` datetime DEFAULT NULL,
  `view_type` tinyint(3) unsigned NOT NULL,
  `pos_x` float DEFAULT NULL,
  `pos_y` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table image_types
# ------------------------------------------------------------

CREATE TABLE `image_types` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(75) NOT NULL,
  `oldcode` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table imageview
# ------------------------------------------------------------

CREATE TABLE `imageview` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `image_id` int(11) DEFAULT NULL,
  `entity_id` smallint(6) DEFAULT '120',
  `name` varchar(255) DEFAULT NULL,
  `descript` varchar(255) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `pan` float DEFAULT NULL,
  `tilt` float DEFAULT NULL,
  `fov` float DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `editdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table lexicon_entry
# ------------------------------------------------------------

CREATE TABLE `lexicon_entry` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `entity_id` smallint(5) unsigned NOT NULL DEFAULT '80',
  `name` varchar(60) NOT NULL,
  `metaphone` varchar(255) DEFAULT NULL,
  `typekey` varchar(10) NOT NULL DEFAULT '',
  `proper` varchar(60) NOT NULL DEFAULT '',
  `name_plural` varchar(100) DEFAULT NULL,
  `descript` text,
  `sortval` tinyint(4) NOT NULL DEFAULT '0',
  `isKeyword` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `isDetail` tinyint(1) unsigned DEFAULT '0',
  `createdate` datetime DEFAULT NULL,
  `author_id` mediumint(8) unsigned DEFAULT NULL,
  `editdate` datetime DEFAULT NULL,
  `edit_author_id` mediumint(8) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sortval` (`sortval`) USING BTREE,
  KEY `metaphone` (`metaphone`) USING BTREE,
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table map
# ------------------------------------------------------------

CREATE TABLE `map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entity_id` smallint(5) unsigned NOT NULL DEFAULT '100',
  `identifier` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `shortname` varchar(255) DEFAULT NULL,
  `descript` text,
  `beg_year` mediumint(9) DEFAULT NULL,
  `end_year` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table meta
# ------------------------------------------------------------

CREATE TABLE `meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model` varchar(255) NOT NULL,
  `field` varchar(255) NOT NULL,
  `auth_level` tinyint(3) unsigned DEFAULT '4',
  `shortlist` tinyint(3) unsigned DEFAULT '1',
  `editbox` tinyint(4) DEFAULT '1',
  `type` varchar(255) DEFAULT 'input',
  `rangetop` tinyint(4) DEFAULT NULL,
  `editable` tinyint(3) unsigned DEFAULT '1',
  `required` tinyint(3) unsigned DEFAULT '0',
  `suggest` tinyint(3) unsigned DEFAULT '0',
  `searchable` tinyint(3) unsigned DEFAULT '5',
  `descript` varchar(255) DEFAULT NULL,
  `sortval` tinyint(11) unsigned NOT NULL DEFAULT '0',
  `author_id` mediumint(8) unsigned DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `editdate` datetime DEFAULT NULL,
  `edit_author_id` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table model
# ------------------------------------------------------------

CREATE TABLE `model` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `entity_id` int(11) unsigned NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `metaphone` varchar(75) DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `lng` double DEFAULT NULL,
  `lat2` double DEFAULT NULL,
  `lng2` double DEFAULT NULL,
  `radius` float DEFAULT NULL,
  `beg_year` mediumint(9) DEFAULT NULL,
  `end_year` mediumint(9) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL COMMENT 'duration can also serve as a chronological blur. If no end_year is specified, it blurs on either side of the beg_year, else, it is a blur before beg_year and after_end year',
  `descript` text,
  `wikipedia` varchar(255) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `author_id` mediumint(8) unsigned DEFAULT NULL,
  `editdate` datetime NOT NULL,
  `edit_author_id` mediumint(8) unsigned DEFAULT NULL,
  `parent_entity_id` int(11) unsigned DEFAULT NULL,
  `parent_item_id` int(11) unsigned DEFAULT NULL,
  `public_status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `search_key` (`name`) USING BTREE,
  KEY `metaphone_index` (`metaphone`) USING BTREE,
  KEY `name_index` (`name`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table note
# ------------------------------------------------------------

CREATE TABLE `note` (
  `id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT 'Untitled',
  `metaphone` varchar(75) DEFAULT NULL,
  `descript` text,
  `author_id` int(11) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `editdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table notecard
# ------------------------------------------------------------

CREATE TABLE `notecard` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `entity_id` smallint(5) unsigned NOT NULL DEFAULT '140',
  `name` varchar(255) DEFAULT NULL,
  `metaphone` varchar(75) DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `lat2` float DEFAULT NULL,
  `lng2` float DEFAULT NULL,
  `radius` float DEFAULT NULL,
  `beg_year` mediumint(9) DEFAULT NULL,
  `end_year` mediumint(9) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL COMMENT 'duration can also serve as a chronological blur. If no end_year is specified, it blurs on either side of the beg_year, else, it is a blur before beg_year and after_end year',
  `descript` text,
  `pages` varchar(50) DEFAULT NULL,
  `wikipedia` varchar(255) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `author_id` mediumint(8) unsigned DEFAULT NULL,
  `editdate` datetime NOT NULL,
  `edit_author_id` mediumint(8) unsigned DEFAULT NULL,
  `parent_entity_id` int(11) unsigned DEFAULT NULL,
  `parent_item_id` int(11) unsigned DEFAULT NULL,
  `cardtype` tinyint(3) unsigned DEFAULT NULL,
  `public_status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `search_key` (`name`) USING BTREE,
  KEY `metaphone_index` (`metaphone`) USING BTREE,
  KEY `name_index` (`name`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table passage
# ------------------------------------------------------------

CREATE TABLE `passage` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `entity_id` smallint(5) unsigned NOT NULL DEFAULT '160',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `metaphone` varchar(75) CHARACTER SET latin1 DEFAULT NULL,
  `lexicon_entry` varchar(128) DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `lat2` float DEFAULT NULL,
  `lng2` float DEFAULT NULL,
  `radius` float DEFAULT NULL,
  `beg_year` mediumint(9) DEFAULT NULL,
  `end_year` mediumint(9) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL COMMENT 'duration can also serve as a chronological blur. If no end_year is specified, it blurs on either side of the beg_year, else, it is a blur before beg_year and after_end year',
  `descript` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `pages` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `wikipedia` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `author_id` mediumint(8) unsigned DEFAULT NULL,
  `editdate` datetime NOT NULL,
  `edit_author_id` mediumint(8) unsigned DEFAULT NULL,
  `parent_entity_id` int(11) unsigned DEFAULT NULL,
  `parent_item_id` int(11) unsigned DEFAULT NULL,
  `cardtype` tinyint(3) unsigned DEFAULT NULL,
  `public_status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `tags` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `search_key` (`name`) USING BTREE,
  KEY `metaphone_index` (`metaphone`) USING BTREE,
  KEY `name_index` (`name`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table periodical
# ------------------------------------------------------------

CREATE TABLE `periodical` (
  `id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ISSN` char(9) DEFAULT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `metaphone` varchar(125) DEFAULT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `call_number` varchar(50) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `createdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table person
# ------------------------------------------------------------

CREATE TABLE `person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entity_id` smallint(5) unsigned NOT NULL DEFAULT '50',
  `db_name` varchar(128) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `metaphone` varchar(75) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `change_key` varchar(255) DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '0',
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `lat2` float DEFAULT NULL,
  `lng2` float DEFAULT NULL,
  `radius` float DEFAULT NULL,
  `beg_year` mediumint(9) DEFAULT NULL,
  `end_year` mediumint(9) DEFAULT NULL,
  `duration` smallint(6) DEFAULT NULL,
  `descript` text,
  `firstmetaphone` varchar(50) DEFAULT NULL,
  `honorific` varchar(25) DEFAULT NULL,
  `firstname` varchar(150) NOT NULL DEFAULT '',
  `middlename` varchar(150) DEFAULT NULL,
  `lastname` varchar(150) DEFAULT NULL,
  `postname` varchar(150) DEFAULT NULL,
  `isUser` tinyint(1) NOT NULL DEFAULT '0',
  `isAuthor` tinyint(1) NOT NULL DEFAULT '0',
  `isDedicatory` tinyint(1) NOT NULL DEFAULT '0',
  `pword` varchar(55) NOT NULL DEFAULT '2f7573fdb117f4dc647585d7fd15fadabc5658a8',
  `notes` text,
  `wikipedia` varchar(255) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `isLoggedIn` tinyint(1) DEFAULT NULL,
  `session_id` varchar(50) DEFAULT NULL,
  `lastTickled` timestamp NULL DEFAULT NULL,
  `author_id` mediumint(8) unsigned DEFAULT NULL,
  `editdate` datetime DEFAULT NULL,
  `edit_author_id` mediumint(8) unsigned DEFAULT NULL,
  `LCCN` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lastname` (`lastname`) USING BTREE,
  KEY `search_key` (`name`) USING BTREE,
  KEY `firstmetaphone` (`firstmetaphone`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table place
# ------------------------------------------------------------

CREATE TABLE `place` (
  `id` int(11) NOT NULL DEFAULT '0',
  `entity_id` smallint(5) unsigned NOT NULL DEFAULT '30',
  `region_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `metaphone` varchar(80) DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `lng` double DEFAULT NULL,
  `lat2` double DEFAULT NULL,
  `lng2` double DEFAULT NULL,
  `shape` text,
  `radius` float DEFAULT NULL,
  `beg_year` mediumint(9) DEFAULT NULL,
  `end_year` mediumint(9) DEFAULT NULL,
  `duration` smallint(6) DEFAULT NULL,
  `parent_town` int(11) DEFAULT NULL,
  `descript` text,
  `wikipedia` varchar(255) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `author_id` mediumint(8) unsigned DEFAULT NULL,
  `editdate` datetime DEFAULT NULL,
  `edit_author_id` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `metaphone` (`metaphone`) USING BTREE,
  KEY `name` (`name`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table poster
# ------------------------------------------------------------

CREATE TABLE `poster` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `building_id` int(10) unsigned NOT NULL,
  `isImageType` tinyint(4) NOT NULL DEFAULT '1',
  `type_id` int(10) unsigned NOT NULL,
  `image_id` int(10) unsigned NOT NULL,
  `createdate` datetime DEFAULT NULL,
  `author_id` mediumint(8) DEFAULT NULL,
  `editdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `building_element_type` (`building_id`,`isImageType`,`type_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table publication
# ------------------------------------------------------------

CREATE TABLE `publication` (
  `id` int(10) unsigned NOT NULL,
  `entity_id` smallint(5) unsigned NOT NULL DEFAULT '60',
  `ISBN_ISSN` varchar(55) CHARACTER SET latin1 DEFAULT NULL,
  `LCCN` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `OCLC` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `WC_coverid` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `clio` bigint(30) DEFAULT NULL,
  `pubtype` smallint(4) unsigned NOT NULL DEFAULT '6',
  `type` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `metaphone` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `container_title` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `lng` double DEFAULT NULL,
  `lat2` double DEFAULT NULL,
  `lng2` double DEFAULT NULL,
  `radius` double DEFAULT NULL,
  `beg_year` mediumint(9) DEFAULT NULL,
  `end_year` mediumint(9) DEFAULT NULL,
  `duration` smallint(6) DEFAULT NULL,
  `descript` text CHARACTER SET latin1,
  `citation_text` text CHARACTER SET latin1,
  `authors` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `authors_json` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `contributors` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `contributors_metaphone` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `editors` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `keywords` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `date` varchar(15) CHARACTER SET latin1 DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `periodical_id` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `pages` varchar(12) CHARACTER SET latin1 DEFAULT NULL,
  `number` varchar(4) CHARACTER SET latin1 DEFAULT NULL,
  `location` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `publisher` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `url` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `volume` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `numvols` tinyint(3) unsigned DEFAULT NULL,
  `issue` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `callnumber` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `notes` mediumtext CHARACTER SET latin1,
  `abstract` text CHARACTER SET latin1,
  `dbase` varchar(75) CHARACTER SET latin1 DEFAULT NULL,
  `source_app` varchar(75) CHARACTER SET latin1 DEFAULT NULL,
  `rec_number` mediumint(8) unsigned DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `author_id` mediumint(8) unsigned DEFAULT NULL,
  `editdate` datetime DEFAULT NULL,
  `edit_author_id` mediumint(8) unsigned DEFAULT NULL,
  `isCatalog` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clioID` (`clio`) USING BTREE,
  KEY `year` (`year`) USING BTREE,
  FULLTEXT KEY `name` (`name`),
  FULLTEXT KEY `name_2` (`name`,`contributors`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table publication_authors
# ------------------------------------------------------------

CREATE TABLE `publication_authors` (
  `pub_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `person_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`pub_id`,`person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table publication_copy
# ------------------------------------------------------------

CREATE TABLE `publication_copy` (
  `id` int(10) unsigned NOT NULL,
  `entity_id` smallint(5) unsigned NOT NULL DEFAULT '60',
  `ISBN_ISSN` varchar(55) DEFAULT NULL,
  `LCCN` varchar(40) DEFAULT NULL,
  `OCLC` varchar(40) DEFAULT NULL,
  `WC_coverid` varchar(40) DEFAULT NULL,
  `clio` bigint(30) DEFAULT NULL,
  `pubtype` smallint(4) unsigned NOT NULL DEFAULT '6',
  `type` varchar(64) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `metaphone` varchar(150) DEFAULT NULL,
  `container_title` varchar(255) DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `lng` double DEFAULT NULL,
  `lat2` double DEFAULT NULL,
  `lng2` double DEFAULT NULL,
  `radius` double DEFAULT NULL,
  `beg_year` mediumint(9) DEFAULT NULL,
  `end_year` mediumint(9) DEFAULT NULL,
  `duration` smallint(6) DEFAULT NULL,
  `descript` text,
  `citation_text` text,
  `authors` varchar(255) DEFAULT NULL,
  `authors_json` varchar(255) DEFAULT NULL,
  `contributors` varchar(255) DEFAULT '',
  `contributors_metaphone` varchar(255) DEFAULT NULL,
  `editors` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `date` varchar(15) DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `periodical_id` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `pages` varchar(12) DEFAULT NULL,
  `number` varchar(4) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `volume` varchar(10) DEFAULT NULL,
  `numvols` tinyint(3) unsigned DEFAULT NULL,
  `issue` varchar(10) DEFAULT NULL,
  `callnumber` varchar(50) DEFAULT NULL,
  `notes` mediumtext,
  `abstract` text,
  `dbase` varchar(75) DEFAULT NULL,
  `source_app` varchar(75) DEFAULT NULL,
  `rec_number` mediumint(8) unsigned DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `author_id` mediumint(8) unsigned DEFAULT NULL,
  `editdate` datetime DEFAULT NULL,
  `edit_author_id` mediumint(8) unsigned DEFAULT NULL,
  `isCatalog` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clioID` (`clio`) USING BTREE,
  KEY `year` (`year`) USING BTREE,
  FULLTEXT KEY `name` (`name`),
  FULLTEXT KEY `name-contributors_FULL` (`name`,`contributors`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table publicationBak
# ------------------------------------------------------------

CREATE TABLE `publicationBak` (
  `id` int(10) unsigned NOT NULL,
  `ISBN_ISSN` varchar(15) DEFAULT NULL,
  `pubtype` smallint(4) unsigned NOT NULL DEFAULT '6',
  `name` varchar(255) NOT NULL,
  `metaphone` varchar(150) DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `lat2` float DEFAULT NULL,
  `lng2` float DEFAULT NULL,
  `radius` float DEFAULT NULL,
  `beg_year` mediumint(9) DEFAULT NULL,
  `end_year` mediumint(9) DEFAULT NULL,
  `duration` smallint(6) DEFAULT NULL,
  `descript` text,
  `contributors` varchar(255) NOT NULL DEFAULT '',
  `date` varchar(15) DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `periodical_id` varchar(255) DEFAULT NULL,
  `pages` varchar(12) DEFAULT NULL,
  `number` varchar(4) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `volume` varchar(10) DEFAULT NULL,
  `numvols` tinyint(3) unsigned DEFAULT NULL,
  `callnumber` varchar(20) DEFAULT NULL,
  `notes` mediumtext,
  `abstract` text,
  `dbase` varchar(75) DEFAULT NULL,
  `source_app` varchar(75) DEFAULT NULL,
  `rec_number` mediumint(8) unsigned DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `author_id` mediumint(8) unsigned DEFAULT NULL,
  `editdate` datetime DEFAULT NULL,
  `edit_author_id` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `internationalID` (`ISBN_ISSN`) USING BTREE,
  KEY `year` (`year`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table pubtype
# ------------------------------------------------------------

CREATE TABLE `pubtype` (
  `type` smallint(3) unsigned NOT NULL DEFAULT '0',
  `name` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table religious_order
# ------------------------------------------------------------

CREATE TABLE `religious_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table slide
# ------------------------------------------------------------

CREATE TABLE `slide` (
  `id` mediumint(8) unsigned NOT NULL,
  `slideshow_id` smallint(5) unsigned NOT NULL,
  `image_id` mediumint(8) unsigned NOT NULL,
  `sortval` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `caption` varchar(255) DEFAULT NULL,
  `benchmark` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `createdate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slideshow_id` (`slideshow_id`,`image_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table slideshow
# ------------------------------------------------------------

CREATE TABLE `slideshow` (
  `id` mediumint(9) NOT NULL,
  `name` varchar(255) NOT NULL,
  `metaphone` varchar(255) DEFAULT NULL,
  `person_id` mediumint(9) DEFAULT NULL,
  `createdate` datetime NOT NULL,
  `building_id` mediumint(8) unsigned DEFAULT NULL,
  `canonical` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `metaphone` (`metaphone`) USING BTREE,
  KEY `name` (`name`) USING BTREE,
  KEY `building_id` (`building_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table socialentity
# ------------------------------------------------------------

CREATE TABLE `socialentity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entity_id` smallint(5) unsigned DEFAULT '90',
  `name` varchar(255) DEFAULT NULL,
  `metaphone` varchar(75) DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `lat2` float DEFAULT NULL,
  `lng2` float DEFAULT NULL,
  `radius` float DEFAULT NULL,
  `beg_year` mediumint(9) DEFAULT NULL,
  `end_year` mediumint(9) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL COMMENT 'duration can also serve as a chronological blur. If no end_year is specified, it blurs on either side of the beg_year, else, it is a blur before beg_year and after_end year',
  `descript` text,
  `wikipedia` varchar(255) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `author_id` mediumint(8) unsigned DEFAULT NULL,
  `editdate` datetime NOT NULL,
  `edit_author_id` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `search_key` (`name`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table socialentity_item
# ------------------------------------------------------------

CREATE TABLE `socialentity_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `socialentity_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `beg_year` int(11) DEFAULT NULL,
  `end_year` int(11) DEFAULT NULL,
  `notes` text,
  `author_id` int(11) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table vers_building
# ------------------------------------------------------------

CREATE TABLE `vers_building` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id` smallint(20) unsigned NOT NULL,
  `entity_id` smallint(5) unsigned DEFAULT '40',
  `name` varchar(255) DEFAULT NULL,
  `metaphone` varchar(255) DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `lng` double DEFAULT NULL,
  `lat2` double DEFAULT NULL,
  `lng2` double DEFAULT NULL,
  `radius` float DEFAULT NULL,
  `geo_precision` tinyint(4) unsigned DEFAULT NULL,
  `beg_year` mediumint(9) DEFAULT NULL,
  `end_year` mediumint(9) DEFAULT NULL,
  `duration` smallint(6) DEFAULT NULL,
  `style` tinyint(3) unsigned DEFAULT NULL,
  `functional_type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `formal_type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `building_key` varchar(6) DEFAULT NULL,
  `orient` text,
  `elev` text,
  `building_name` varchar(100) DEFAULT NULL,
  `town_id` smallint(6) DEFAULT NULL,
  `pages` varchar(50) DEFAULT NULL,
  `wikipedia` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `preservation` tinyint(4) NOT NULL DEFAULT '3',
  `height` float NOT NULL DEFAULT '0',
  `width` float NOT NULL DEFAULT '0',
  `length` float NOT NULL DEFAULT '0',
  `spring` float NOT NULL DEFAULT '0',
  `arcade_width` float DEFAULT NULL,
  `arcade_height` float DEFAULT NULL,
  `arcade_spring` float DEFAULT NULL,
  `aisle_width` float DEFAULT NULL,
  `aisle_height` float DEFAULT NULL,
  `aisle_spring` float DEFAULT NULL,
  `elev_min` text,
  `elev_max` text,
  `descript` text,
  `plan` text,
  `elevation` text,
  `history` text,
  `chronology` text,
  `significance` text,
  `bibliography` text,
  `sculpture` text,
  `pref_rating` tinyint(20) DEFAULT NULL,
  `building_type` varchar(50) DEFAULT 'church',
  `media_plan_exists` tinyint(4) NOT NULL DEFAULT '0',
  `media_genplan_exists` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `media_smartplan_exists` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `fla_gen_dwg` tinyint(4) NOT NULL DEFAULT '0',
  `fla_gen_ai` tinyint(4) NOT NULL DEFAULT '0',
  `fla_vw_pre_2005` tinyint(4) NOT NULL DEFAULT '0',
  `fla_totstat_dwg` tinyint(4) NOT NULL DEFAULT '0',
  `fla_cyrax_ai` tinyint(4) NOT NULL DEFAULT '0',
  `media_section_exists` tinyint(4) NOT NULL DEFAULT '0',
  `media_minimodel` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `media_qtvr_exists` tinyint(4) NOT NULL DEFAULT '0',
  `media_pier_exists` tinyint(4) NOT NULL DEFAULT '0',
  `media_elev_exists` tinyint(4) NOT NULL DEFAULT '0',
  `visited` tinytext NOT NULL,
  `internal_ref_num` smallint(5) unsigned DEFAULT NULL,
  `slideshow_id` smallint(5) unsigned DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `author_id` mediumint(8) unsigned DEFAULT NULL,
  `editdate` datetime DEFAULT NULL,
  `edit_author_id` mediumint(8) unsigned DEFAULT NULL,
  `poster_id` int(10) unsigned DEFAULT NULL,
  `plan_image_id` mediumint(11) unsigned DEFAULT NULL,
  `lat_section_image_id` mediumint(11) unsigned DEFAULT NULL,
  `long_section_image_id` mediumint(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`pid`),
  KEY `id` (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table vers_collection
# ------------------------------------------------------------

CREATE TABLE `vers_collection` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `entity_id` smallint(5) unsigned NOT NULL DEFAULT '70',
  `name` varchar(255) DEFAULT NULL,
  `metaphone` varchar(75) DEFAULT NULL,
  `statictype` varchar(255) DEFAULT NULL,
  `inverse` varchar(255) DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `lat2` float DEFAULT NULL,
  `lng2` float DEFAULT NULL,
  `radius` float DEFAULT NULL,
  `beg_year` mediumint(9) DEFAULT NULL,
  `end_year` mediumint(9) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL COMMENT 'duration can also serve as a chronological blur. If no end_year is specified, it blurs on either side of the beg_year, else, it is a blur before beg_year and after_end year',
  `descript` text,
  `parent_entity_id` int(11) DEFAULT NULL,
  `parent_item_id` mediumint(9) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `author_id` mediumint(8) unsigned DEFAULT NULL,
  `private` tinyint(3) unsigned zerofill DEFAULT '000',
  `canonical` tinyint(4) DEFAULT '0',
  `type` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `is_social` tinyint(4) DEFAULT '0',
  `editdate` datetime DEFAULT NULL,
  `edit_author_id` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`pid`),
  KEY `id` (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table vers_essay
# ------------------------------------------------------------

CREATE TABLE `vers_essay` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `entity_id` smallint(5) unsigned NOT NULL DEFAULT '150',
  `name` varchar(255) DEFAULT NULL,
  `metaphone` varchar(75) DEFAULT NULL,
  `urlalias` varchar(64) DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `lat2` float DEFAULT NULL,
  `lng2` float DEFAULT NULL,
  `radius` float DEFAULT NULL,
  `beg_year` mediumint(9) DEFAULT NULL,
  `end_year` mediumint(9) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL COMMENT 'duration can also serve as a chronological blur. If no end_year is specified, it blurs on either side of the beg_year, else, it is a blur before beg_year and after_end year',
  `descript` text,
  `wikipedia` varchar(255) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `author_id` mediumint(8) unsigned DEFAULT NULL,
  `editdate` datetime DEFAULT NULL,
  `edit_author_id` mediumint(8) unsigned DEFAULT NULL,
  `parent_entity_id` int(11) DEFAULT NULL,
  `parent_item_id` int(11) DEFAULT NULL,
  `public_status` tinyint(3) unsigned DEFAULT NULL,
  `header_image` int(11) DEFAULT NULL,
  `subtype` varchar(20) DEFAULT NULL,
  `isSite` tinyint(3) unsigned DEFAULT NULL,
  `siteCSS` text,
  PRIMARY KEY (`pid`),
  KEY `id` (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table vers_historicalevent
# ------------------------------------------------------------

CREATE TABLE `vers_historicalevent` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `entity_id` smallint(5) unsigned NOT NULL DEFAULT '20',
  `name` varchar(255) DEFAULT NULL,
  `metaphone` varchar(75) DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `lat2` float DEFAULT NULL,
  `lng2` float DEFAULT NULL,
  `radius` float DEFAULT NULL,
  `geo_precision` tinyint(3) unsigned DEFAULT NULL,
  `beg_year` mediumint(9) DEFAULT NULL,
  `end_year` mediumint(9) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL COMMENT 'duration can also serve as a chronological blur. If no end_year is specified, it blurs on either side of the beg_year, else, it is a blur before beg_year and after_end year',
  `descript` text,
  `pages` varchar(50) DEFAULT NULL,
  `wikipedia` varchar(255) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `author_id` mediumint(8) unsigned DEFAULT NULL,
  `editdate` datetime DEFAULT NULL,
  `edit_author_id` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`pid`),
  KEY `id` (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table vers_historicalobject
# ------------------------------------------------------------

CREATE TABLE `vers_historicalobject` (
  `pid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id` int(10) unsigned DEFAULT NULL,
  `entity_id` smallint(5) unsigned NOT NULL DEFAULT '25',
  `name` varchar(255) DEFAULT NULL,
  `metaphone` varchar(75) DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `lng` double DEFAULT NULL,
  `lat2` double DEFAULT NULL,
  `lng2` double DEFAULT NULL,
  `radius` float DEFAULT NULL,
  `geo+precision` tinyint(3) unsigned DEFAULT NULL,
  `beg_year` mediumint(9) DEFAULT NULL,
  `end_year` mediumint(9) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL COMMENT 'duration can also serve as a chronological blur. If no end_year is specified, it blurs on either side of the beg_year, else, it is a blur before beg_year and after_end year',
  `descript` text,
  `pages` varchar(50) DEFAULT NULL,
  `wikipedia` varchar(255) DEFAULT NULL,
  `preservation` tinyint(4) NOT NULL DEFAULT '3',
  `createdate` datetime DEFAULT NULL,
  `author_id` mediumint(8) unsigned DEFAULT NULL,
  `editdate` datetime NOT NULL,
  `edit_author_id` mediumint(8) unsigned DEFAULT NULL,
  `parent_entity_id` int(11) unsigned DEFAULT NULL,
  `parent_item_id` int(11) unsigned DEFAULT NULL,
  `public_status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`pid`),
  KEY `search_key` (`name`) USING BTREE,
  KEY `metaphone_index` (`metaphone`) USING BTREE,
  KEY `name_index` (`name`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table vers_image
# ------------------------------------------------------------

CREATE TABLE `vers_image` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `entity_id` smallint(5) unsigned NOT NULL DEFAULT '110',
  `building_id` int(10) unsigned DEFAULT NULL,
  `filename` varchar(35) NOT NULL DEFAULT '',
  `orig_filename` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `filesystem` varchar(1) DEFAULT NULL,
  `building_key` varchar(6) NOT NULL DEFAULT '',
  `mimetype` tinyint(3) unsigned DEFAULT NULL,
  `rating` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ext_int` char(3) NOT NULL DEFAULT '',
  `image_type` varchar(6) NOT NULL DEFAULT '0',
  `element_type` varchar(6) NOT NULL DEFAULT '',
  `itemid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `direction` char(3) NOT NULL DEFAULT '',
  `direction_id` tinyint(3) unsigned DEFAULT NULL,
  `width` smallint(5) unsigned DEFAULT NULL,
  `height` smallint(5) unsigned DEFAULT NULL,
  `size` decimal(10,0) unsigned DEFAULT NULL,
  `scale` float(10,6) unsigned DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `lng` double DEFAULT NULL,
  `lat2` double DEFAULT NULL,
  `lng2` double DEFAULT NULL,
  `longitude` float(10,6) DEFAULT NULL,
  `latitude` float(10,6) DEFAULT NULL,
  `altitude` mediumint(9) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `descript` text,
  `keywords` varchar(255) DEFAULT NULL,
  `author_id` mediumint(8) unsigned DEFAULT NULL,
  `author_status` varchar(50) DEFAULT NULL,
  `publication_id` int(10) unsigned DEFAULT NULL,
  `pages` varchar(20) DEFAULT NULL,
  `originaldate` datetime DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `editdate` datetime DEFAULT NULL,
  `edit_author_id` mediumint(8) unsigned DEFAULT NULL,
  `views` int(10) unsigned DEFAULT '0',
  `has_stereo` tinyint(1) NOT NULL DEFAULT '0',
  `has_sd_tiles` tinyint(1) DEFAULT NULL,
  `cen_x` float unsigned DEFAULT NULL,
  `cen_y` float unsigned DEFAULT NULL,
  `orien` float DEFAULT NULL,
  `scale_pt1_x` float DEFAULT NULL,
  `scale_pt1_y` float DEFAULT NULL,
  `scale_pt2_x` float DEFAULT NULL,
  `scale_pt2_y` float DEFAULT NULL,
  `scale_real_length` float DEFAULT NULL,
  `scale_abs` float DEFAULT NULL,
  `pan` float NOT NULL DEFAULT '0',
  `tilt` float NOT NULL DEFAULT '0',
  `fov` float NOT NULL DEFAULT '70',
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table vers_notecard
# ------------------------------------------------------------

CREATE TABLE `vers_notecard` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `entity_id` smallint(5) unsigned NOT NULL DEFAULT '140',
  `name` varchar(255) DEFAULT NULL,
  `metaphone` varchar(75) DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `lat2` float DEFAULT NULL,
  `lng2` float DEFAULT NULL,
  `radius` float DEFAULT NULL,
  `beg_year` mediumint(9) DEFAULT NULL,
  `end_year` mediumint(9) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL COMMENT 'duration can also serve as a chronological blur. If no end_year is specified, it blurs on either side of the beg_year, else, it is a blur before beg_year and after_end year',
  `descript` text,
  `pages` varchar(50) DEFAULT NULL,
  `wikipedia` varchar(255) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `author_id` mediumint(8) unsigned DEFAULT NULL,
  `editdate` datetime DEFAULT NULL,
  `edit_author_id` mediumint(8) unsigned DEFAULT NULL,
  `parent_entity_id` int(11) DEFAULT NULL,
  `parent_item_id` int(11) DEFAULT NULL,
  `cardtype` tinyint(3) unsigned DEFAULT NULL,
  `public_status` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`pid`),
  KEY `id` (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table vers_person
# ------------------------------------------------------------

CREATE TABLE `vers_person` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `entity_id` smallint(5) unsigned NOT NULL DEFAULT '50',
  `db_name` varchar(128) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `metaphone` varchar(75) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `lat2` float DEFAULT NULL,
  `lng2` float DEFAULT NULL,
  `radius` float DEFAULT NULL,
  `beg_year` mediumint(9) DEFAULT NULL,
  `end_year` mediumint(9) DEFAULT NULL,
  `duration` smallint(6) DEFAULT NULL,
  `descript` text,
  `firstmetaphone` varchar(50) DEFAULT NULL,
  `honorific` varchar(25) DEFAULT NULL,
  `firstname` varchar(150) NOT NULL DEFAULT '',
  `middlename` varchar(150) DEFAULT NULL,
  `lastname` varchar(150) DEFAULT NULL,
  `postname` varchar(150) DEFAULT NULL,
  `isUser` tinyint(1) NOT NULL DEFAULT '0',
  `isAuthor` tinyint(1) NOT NULL DEFAULT '0',
  `isDedicatory` tinyint(1) NOT NULL DEFAULT '0',
  `pword` varchar(55) NOT NULL,
  `notes` text,
  `wikipedia` varchar(255) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `isLoggedIn` tinyint(1) DEFAULT NULL,
  `session_id` varchar(50) DEFAULT NULL,
  `lastTickled` timestamp NULL DEFAULT NULL,
  `author_id` mediumint(8) unsigned DEFAULT NULL,
  `editdate` datetime DEFAULT NULL,
  `edit_author_id` mediumint(8) unsigned DEFAULT NULL,
  `LCCN` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  KEY `id` (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table vers_place
# ------------------------------------------------------------

CREATE TABLE `vers_place` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL DEFAULT '0',
  `entity_id` smallint(5) unsigned NOT NULL DEFAULT '30',
  `region_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `metaphone` varchar(80) DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `lng` double DEFAULT NULL,
  `lat2` double DEFAULT NULL,
  `lng2` double DEFAULT NULL,
  `shape` text,
  `radius` float DEFAULT NULL,
  `beg_year` mediumint(9) DEFAULT NULL,
  `end_year` mediumint(9) DEFAULT NULL,
  `duration` smallint(6) DEFAULT NULL,
  `parent_town` int(11) DEFAULT NULL,
  `descript` text,
  `wikipedia` varchar(255) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `author_id` mediumint(8) unsigned DEFAULT NULL,
  `editdate` datetime DEFAULT NULL,
  `edit_author_id` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`pid`),
  KEY `id` (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table vers_publication
# ------------------------------------------------------------

CREATE TABLE `vers_publication` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id` int(10) unsigned NOT NULL,
  `entity_id` smallint(5) unsigned NOT NULL DEFAULT '60',
  `ISBN_ISSN` varchar(15) DEFAULT NULL,
  `LCCN` varchar(40) DEFAULT NULL,
  `OCLC` varchar(40) DEFAULT NULL,
  `WC_coverid` varchar(40) DEFAULT NULL,
  `clio` bigint(30) DEFAULT NULL,
  `pubtype` tinyint(4) NOT NULL DEFAULT '6',
  `name` varchar(255) NOT NULL,
  `metaphone` varchar(150) DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lng` double DEFAULT NULL,
  `lat2` double DEFAULT NULL,
  `lng2` double DEFAULT NULL,
  `radius` double DEFAULT NULL,
  `beg_year` mediumint(9) DEFAULT NULL,
  `end_year` mediumint(9) DEFAULT NULL,
  `duration` smallint(6) DEFAULT NULL,
  `descript` text,
  `citation_text` text,
  `contributors` varchar(255) DEFAULT '',
  `contributors_metaphone` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `date` varchar(15) DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `periodical_id` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `pages` varchar(12) DEFAULT NULL,
  `number` varchar(4) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `volume` varchar(10) DEFAULT NULL,
  `numvols` tinyint(3) unsigned DEFAULT NULL,
  `issue` varchar(10) DEFAULT NULL,
  `callnumber` varchar(50) DEFAULT NULL,
  `notes` mediumtext,
  `abstract` text,
  `dbase` varchar(75) DEFAULT NULL,
  `source_app` varchar(75) DEFAULT NULL,
  `rec_number` mediumint(8) unsigned DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `author_id` mediumint(8) unsigned DEFAULT NULL,
  `editdate` datetime DEFAULT NULL,
  `edit_author_id` mediumint(8) unsigned DEFAULT NULL,
  `isCatalog` int(11) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  KEY `id` (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table z_related_entities
# ------------------------------------------------------------

CREATE TABLE `z_related_entities` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `from_entity_id` int(11) unsigned NOT NULL,
  `from_id` int(11) unsigned NOT NULL,
  `to_entity_id` int(11) unsigned NOT NULL,
  `to_id` int(11) unsigned NOT NULL,
  `relationship` varchar(255) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `editor_id` int(11) DEFAULT NULL,
  `descript` varchar(255) DEFAULT NULL,
  `pages` varchar(50) DEFAULT NULL,
  `catnum` varchar(50) DEFAULT NULL,
  `pos_x` double NOT NULL DEFAULT '0',
  `pos_y` double NOT NULL DEFAULT '0',
  `pos_z` double NOT NULL DEFAULT '0',
  `axis` char(1) NOT NULL DEFAULT 'Y',
  `ang` double NOT NULL DEFAULT '0',
  `createdate` datetime DEFAULT NULL,
  `sortval` smallint(6) unsigned DEFAULT NULL,
  `rating` tinyint(3) unsigned NOT NULL DEFAULT '3',
  PRIMARY KEY (`id`),
  KEY `from_entity_id` (`from_entity_id`,`from_id`,`to_entity_id`,`to_id`,`relationship`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
