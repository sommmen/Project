-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Machine: localhost:3306
-- Gegenereerd op: 07 okt 2014 om 14:05
-- Serverversie: 5.5.34
-- PHP-versie: 5.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Databank: `mycmsdb`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `page`
--

CREATE TABLE `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `desc` text NOT NULL,
  `ceo_friendly` varchar(45) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Gegevens worden geëxporteerd voor tabel `page`
--

INSERT INTO `page` (`id`, `title`, `desc`, `ceo_friendly`, `content`) VALUES
(1, 'home', 'home page', 'home', 'dit is de homepagee'),
(2, 'about me', 'de over mij pagina', 'about_me', 'lalal dit ben ik :D'),
(3, '404 Error', 'Pagina niet gevonden', '404', 'De opgevraagde pagina bestaat niet(meer).');
