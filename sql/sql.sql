-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Po��ta�: elianos.buk.cvut.cz
-- Vygenerov�no: �tvrtek 05. ledna 2012, 10:34
-- Verze MySQL: 5.5.15
-- Verze PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datab�ze: `cms`
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

--
-- Vypisuji data pro tabulku `action_detail`
--


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

--
-- Vypisuji data pro tabulku `action_pages`
--


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

--
-- Vypisuji data pro tabulku `cms_pages`
--


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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=4 ;

--
-- Vypisuji data pro tabulku `core_modules`
--

INSERT INTO `core_modules` (`id`, `module_name`, `presenter`, `action`) VALUES
(1, 'cms_pages', 'CmsPage', 'default'),
(2, 'action_pages', 'ActionPages', 'default'),
(3, 'gallery_pages', 'GalleryPages', 'default');

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

--
-- Vypisuji data pro tabulku `core_pages`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `core_users`
--

CREATE TABLE IF NOT EXISTS `core_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(20) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nickname_2` (`nickname`),
  KEY `nickname` (`nickname`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Vypisuji data pro tabulku `core_users`
--

INSERT INTO `core_users` (`nickname`, `password`, `admin`) VALUES
('admin', 'f1f04db029edf9a2f24bfa5960d8ff73', 1);

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

--
-- Vypisuji data pro tabulku `core_webs`
--

INSERT INTO `core_webs` (`id`, `url`, `name`, `template`) VALUES
(3, '', 'cms', 'new');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Vypisuji data pro tabulku `gallery_images`
--


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

--
-- Vypisuji data pro tabulku `gallery_pages`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `gallery_topics`
--

CREATE TABLE IF NOT EXISTS `gallery_topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `gallery_images_id` int(11) DEFAULT NULL,
  `key` varchar(10) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `date` int(11) NOT NULL,
  `gallery_pages_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `gallery_pages_id` (`gallery_pages_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Vypisuji data pro tabulku `gallery_topics`
--


--
-- Omezen� pro exportovan� tabulky
--

--
-- Omezen� pro tabulku `action_detail`
--
ALTER TABLE `action_detail`
  ADD CONSTRAINT `action_detail_ibfk_1` FOREIGN KEY (`action_pages_id`) REFERENCES `action_pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezen� pro tabulku `action_pages`
--
ALTER TABLE `action_pages`
  ADD CONSTRAINT `action_pages_ibfk_1` FOREIGN KEY (`id`) REFERENCES `core_pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezen� pro tabulku `cms_pages`
--
ALTER TABLE `cms_pages`
  ADD CONSTRAINT `cms_pages_ibfk_1` FOREIGN KEY (`id`) REFERENCES `core_pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezen� pro tabulku `core_pages`
--
ALTER TABLE `core_pages`
  ADD CONSTRAINT `core_pages_ibfk_1` FOREIGN KEY (`core_webs_id`) REFERENCES `core_webs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezen� pro tabulku `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD CONSTRAINT `gallery_images_ibfk_1` FOREIGN KEY (`gallery_topics_id`) REFERENCES `gallery_topics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezen� pro tabulku `gallery_pages`
--
ALTER TABLE `gallery_pages`
  ADD CONSTRAINT `gallery_pages_ibfk_1` FOREIGN KEY (`id`) REFERENCES `core_pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezen� pro tabulku `gallery_topics`
--
ALTER TABLE `gallery_topics`
  ADD CONSTRAINT `gallery_topics_ibfk_1` FOREIGN KEY (`gallery_pages_id`) REFERENCES `gallery_pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
