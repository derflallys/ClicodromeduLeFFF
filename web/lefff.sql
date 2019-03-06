-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 12 fév. 2019 à 17:11
-- Version du serveur :  5.7.19
-- Version de PHP :  7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `pdp-lefff`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `idCategory` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`idCategory`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `noun_type`
--

DROP TABLE IF EXISTS `noun_type`;
CREATE TABLE IF NOT EXISTS `noun_type` (
  `idNoun` int(11) NOT NULL AUTO_INCREMENT,
  `gender` tinyint(1) NOT NULL COMMENT '0=masculin ; 1=féminin',
  `number` tinyint(1) NOT NULL COMMENT '0=singulier; 1=pluriel',
  `idWord` int(11) NOT NULL,
  PRIMARY KEY (`idNoun`),
  KEY `Word_FK` (`idWord`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tag`
--

DROP TABLE IF EXISTS `tag`;
CREATE TABLE IF NOT EXISTS `tag` (
  `idTag` int(11) NOT NULL AUTO_INCREMENT,
  `obja` varchar(20) DEFAULT NULL,
  `objde` varchar(20) DEFAULT NULL,
  `obj` varchar(20) DEFAULT NULL,
  `obl` varchar(20) DEFAULT NULL,
  `idWord` int(11) NOT NULL,
  PRIMARY KEY (`idTag`),
  KEY `Word_Tag_FK` (`idWord`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `word`
--

DROP TABLE IF EXISTS `word`;
CREATE TABLE IF NOT EXISTS `word` (
  `idWord` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(50) NOT NULL,
  `idCategory` int(11) NOT NULL,
  PRIMARY KEY (`idWord`),
  KEY `Category_FK` (`idCategory`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `noun_type`
--
ALTER TABLE `noun_type`
  ADD CONSTRAINT `Word_FK` FOREIGN KEY (`idWord`) REFERENCES `word` (`idWord`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tag`
--
ALTER TABLE `tag`
  ADD CONSTRAINT `Word_Tag_FK` FOREIGN KEY (`idWord`) REFERENCES `word` (`idWord`);

--
-- Contraintes pour la table `word`
--
ALTER TABLE `word`
  ADD CONSTRAINT `Category_FK` FOREIGN KEY (`idCategory`) REFERENCES `category` (`idCategory`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
