-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Počítač: elianos.buk.cvut.cz
-- Vygenerováno: Pondělí 30. července 2012, 18:53
-- Verze MySQL: 5.5.25
-- Verze PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `uspck`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `action_detail`
--

CREATE TABLE IF NOT EXISTS `action_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` int(11) NOT NULL,
  `name` varchar(60) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `text` text CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `key` varchar(20) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `action_pages_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `action_pages_id` (`action_pages_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=279 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `action_pages`
--

CREATE TABLE IF NOT EXISTS `action_pages` (
  `id` int(11) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `cms_pages`
--

CREATE TABLE IF NOT EXISTS `cms_pages` (
  `id` int(11) NOT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_czech_ci,
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `core_laws`
--

CREATE TABLE IF NOT EXISTS `core_laws` (
  `core_users_id` int(11) NOT NULL,
  `core_webs_id` int(11) NOT NULL,
  PRIMARY KEY (`core_users_id`,`core_webs_id`),
  KEY `core_webs_id` (`core_webs_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `core_modules`
--

CREATE TABLE IF NOT EXISTS `core_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `presenter` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `action` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `presenter` (`presenter`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `core_pages`
--

CREATE TABLE IF NOT EXISTS `core_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `core_modules_id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `metadata` varchar(40) COLLATE utf8_czech_ci NOT NULL,
  `rewrite` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `home` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `order` int(11) NOT NULL,
  `core_webs_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `core_webs_id` (`core_webs_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=69 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `core_pictures`
--

CREATE TABLE IF NOT EXISTS `core_pictures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `core_webs_id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `core_webs_id` (`core_webs_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `core_users`
--

CREATE TABLE IF NOT EXISTS `core_users` (
  `admin` tinyint(1) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(20) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nickname_2` (`nickname`),
  KEY `nickname` (`nickname`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `core_webs`
--

CREATE TABLE IF NOT EXISTS `core_webs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `name` varchar(40) CHARACTER SET utf32 COLLATE utf32_czech_ci NOT NULL,
  `template` varchar(50) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `download_detail`
--

CREATE TABLE IF NOT EXISTS `download_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `time` int(11) NOT NULL,
  `text` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `size` int(11) NOT NULL,
  `download_pages_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `download_pages_id` (`download_pages_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `download_pages`
--

CREATE TABLE IF NOT EXISTS `download_pages` (
  `id` int(11) NOT NULL,
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `gallery_images`
--

CREATE TABLE IF NOT EXISTS `gallery_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gallery_topics_id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `for_slimbox` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `gallery_topics_id` (`gallery_topics_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `gallery_pages`
--

CREATE TABLE IF NOT EXISTS `gallery_pages` (
  `id` int(11) NOT NULL,
  `name` varchar(40) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `gallery_topics`
--

CREATE TABLE IF NOT EXISTS `gallery_topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `gallery_images_id` int(11) DEFAULT NULL,
  `key` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `date` int(11) DEFAULT NULL,
  `gallery_pages_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `gallery_pages_id` (`gallery_pages_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `action_detail`
--
ALTER TABLE `action_detail`
  ADD CONSTRAINT `action_detail_ibfk_1` FOREIGN KEY (`action_pages_id`) REFERENCES `action_pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `action_pages`
--
ALTER TABLE `action_pages`
  ADD CONSTRAINT `action_pages_ibfk_1` FOREIGN KEY (`id`) REFERENCES `core_pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `cms_pages`
--
ALTER TABLE `cms_pages`
  ADD CONSTRAINT `cms_pages_ibfk_1` FOREIGN KEY (`id`) REFERENCES `core_pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `core_laws`
--
ALTER TABLE `core_laws`
  ADD CONSTRAINT `core_laws_ibfk_1` FOREIGN KEY (`core_users_id`) REFERENCES `core_webs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `core_laws_ibfk_2` FOREIGN KEY (`core_webs_id`) REFERENCES `core_webs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `core_pages`
--
ALTER TABLE `core_pages`
  ADD CONSTRAINT `core_pages_ibfk_1` FOREIGN KEY (`core_webs_id`) REFERENCES `core_webs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `core_pictures`
--
ALTER TABLE `core_pictures`
  ADD CONSTRAINT `core_pictures_ibfk_1` FOREIGN KEY (`core_webs_id`) REFERENCES `core_webs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `download_detail`
--
ALTER TABLE `download_detail`
  ADD CONSTRAINT `download_detail_ibfk_1` FOREIGN KEY (`download_pages_id`) REFERENCES `download_pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `download_pages`
--
ALTER TABLE `download_pages`
  ADD CONSTRAINT `download_pages_ibfk_1` FOREIGN KEY (`id`) REFERENCES `core_pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD CONSTRAINT `gallery_images_ibfk_1` FOREIGN KEY (`gallery_topics_id`) REFERENCES `gallery_topics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `gallery_pages`
--
ALTER TABLE `gallery_pages`
  ADD CONSTRAINT `gallery_pages_ibfk_1` FOREIGN KEY (`id`) REFERENCES `core_pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `gallery_topics`
--
ALTER TABLE `gallery_topics`
  ADD CONSTRAINT `gallery_topics_ibfk_1` FOREIGN KEY (`gallery_pages_id`) REFERENCES `gallery_pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
