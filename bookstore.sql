-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 12/12/2011 às 02h54min
-- Versão do Servidor: 5.1.58
-- Versão do PHP: 5.3.6-13ubuntu3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `bookstore`
--
-- CREATE DATABASE `bookstore` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `rfloriano_book`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `author`
--

CREATE TABLE IF NOT EXISTS `author` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `born` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=87 ;

--
-- Extraindo dados da tabela `author`
--

INSERT INTO `author` (`id`, `name`, `born`) VALUES
(2, 'test2', '2011-12-08');

-- --------------------------------------------------------

--
-- Estrutura da tabela `book`
--

CREATE TABLE IF NOT EXISTS `book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `year` date NOT NULL,
  `edition` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cover` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `book`
--

INSERT INTO `book` (`id`, `name`, `description`, `year`, `edition`, `cover`, `price`) VALUES
(1, 'book-1', 'A description of this book', '2011-12-10', '1', 'images/books/steve_jobs_book_cover.jpg', 0.1),
(2, 'book-2', 'test-2', '2011-12-11', NULL, 'images/books/capa-2.jpg', 0.3),
(3, 'livro-3', 'descricao', '2011-12-01', '1', 'images/books/200px-TheSecretLogo.jpg', 0),
(4, 'Andando na chuva', 'mais um livro', '2009-09-10', '2', 'images/books/Mulher_na_Chuva.gif', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `bookauthor`
--

CREATE TABLE IF NOT EXISTS `bookauthor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `book_id` (`book_id`,`author_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `bookauthor`
--

INSERT INTO `bookauthor` (`id`, `book_id`, `author_id`) VALUES
(1, 1, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `bookcategorie`
--

CREATE TABLE IF NOT EXISTS `bookcategorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) NOT NULL,
  `categorie_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `book_id` (`book_id`,`categorie_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `bookcategorie`
--

INSERT INTO `bookcategorie` (`id`, `book_id`, `categorie_id`) VALUES
(1, 1, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `is_paid` smallint(1) NOT NULL DEFAULT '0',
  `session_hash` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

--
-- Extraindo dados da tabela `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `is_paid`, `session_hash`) VALUES
(15, 1, 0, 'a199pt82llauiei75vc7nosdj2'),
(16, 2, 0, 'a199pt82llauiei75vc7nosdj2'),
(17, 3, 0, 'a199pt82llauiei75vc7nosdj2');

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `categorie`
--

INSERT INTO `categorie` (`id`, `name`) VALUES
(2, 'cat-1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cart_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=170 ;

--
-- Extraindo dados da tabela `item`
--

INSERT INTO `item` (`id`, `cart_id`, `book_id`, `quantity`) VALUES
(122, 15, 1, 1),
(164, 16, 1, 1),
(168, 17, 1, 1),
(169, 17, 4, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `admin` tinyint(4) NOT NULL DEFAULT '0',
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cep` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `password`, `admin`, `city`, `address`, `cep`) VALUES
(2, 'Rafael Floriano da Silva', 'test', 'test', 0, 'Joinville', 'Porto Alegre, 750', '89207-680'),
(3, 'Admin', 'admin', 'test', 1, 'Joinville', 'Porto Alegre, 75', '89207-680'),
(6, 'mytest', 'mytest', 'test', 0, '', '', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
