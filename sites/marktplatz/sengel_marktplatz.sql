-- phpMyAdmin SQL Dump
-- version 2.11.9.3
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Erstellungszeit: 03. Dezember 2009 um 19:05
-- Server Version: 5.0.51
-- PHP-Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `sengel_marktplatz`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(255) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `count` int(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Daten für Tabelle `categories`
--

INSERT INTO `categories` (`id`, `name`, `count`) VALUES
(1, 'Möbel', 3),
(2, 'Autos', 24),
(3, 'Essen', 12),
(4, 'Gartengeräte', 17),
(5, 'Computer', 13),
(6, 'Notebooks', 67),
(7, 'Fahrräder', 23),
(8, 'Fahrradzubehör', 0),
(9, 'Autozubehör', 16),
(10, 'Schreibwaren', 0),
(11, 'Papier', 7),
(12, 'Geschirr', 4),
(13, 'Teppiche', 9),
(14, 'Holz', 0),
(15, 'Kohle', 0),
(16, 'Baustoffe', 22),
(17, 'Münzen', 45),
(18, 'Getränke', 15);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(255) NOT NULL auto_increment,
  `active` binary(1) NOT NULL,
  `mode` int(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `prename` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `firm` varchar(50) NOT NULL,
  `street` varchar(50) NOT NULL,
  `housenumber` int(5) NOT NULL,
  `plz` int(5) NOT NULL,
  `city` varchar(50) NOT NULL,
  `phone` int(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `url` varchar(50) NOT NULL,
  `paypal` varchar(50) NOT NULL,
  `reg_date` int(11) NOT NULL,
  `last_login_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `ver_code` varchar(150) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`,`mail`,`paypal`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `active`, `mode`, `username`, `password`, `prename`, `surname`, `firm`, `street`, `housenumber`, `plz`, `city`, `phone`, `mail`, `url`, `paypal`, `reg_date`, `last_login_date`, `ver_code`) VALUES
(54, '1', 1, 'Juuro', 'a6ab8687fb7f04e058e9b314087f2684c9ab4f7a', 'Sebastian', 'Engel', '', 'Argonnenstraße 6', 0, 72108, 'Rottenburg', 2147483647, 'mail@sebastian-engel.de', '', '', 1259327403, '2009-11-27 14:10:05', '48ca39103976a1c5757ef65719d4e5f6d0bfadf5');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
