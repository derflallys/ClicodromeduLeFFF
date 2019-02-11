-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  Dim 10 fév. 2019 à 17:05
-- Version du serveur :  10.1.28-MariaDB
-- Version de PHP :  5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `lefff`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `IdCat` int(10) NOT NULL,
  `ValueCat` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `grammnoun`
--

CREATE TABLE `grammnoun` (
  `IdN` int(255) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `number` varchar(10) NOT NULL,
  `IdWord` bigint(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `grammverb`
--

CREATE TABLE `grammverb` (
  `IdV` int(255) NOT NULL,
  `mode` varchar(20) NOT NULL,
  `group` varchar(20) NOT NULL,
  `irregular` tinyint(1) NOT NULL,
  `IdWord` bigint(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tag`
--

CREATE TABLE `tag` (
  `IdTag` bigint(255) NOT NULL,
  `valueTag` text NOT NULL,
  `objà` text NOT NULL,
  `objde` text NOT NULL,
  `obj` text NOT NULL,
  `obl` text NOT NULL,
  `IdWord` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `word`
--

CREATE TABLE `word` (
  `IdWord` bigint(255) NOT NULL,
  `ValueWord` varchar(50) NOT NULL,
  `IdCat` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`IdCat`);

--
-- Index pour la table `grammnoun`
--
ALTER TABLE `grammnoun`
  ADD PRIMARY KEY (`IdN`),
  ADD KEY `IdWord` (`IdWord`);

--
-- Index pour la table `grammverb`
--
ALTER TABLE `grammverb`
  ADD PRIMARY KEY (`IdV`),
  ADD KEY `IdWord` (`IdWord`);

--
-- Index pour la table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`IdTag`),
  ADD KEY `idWord_FK` (`IdWord`),
  ADD KEY `IdWord` (`IdWord`);

--
-- Index pour la table `word`
--
ALTER TABLE `word`
  ADD PRIMARY KEY (`IdWord`),
  ADD KEY `IdCat_FK` (`IdCat`) USING BTREE;

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `IdCat` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `grammnoun`
--
ALTER TABLE `grammnoun`
  MODIFY `IdN` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `grammverb`
--
ALTER TABLE `grammverb`
  MODIFY `IdV` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tag`
--
ALTER TABLE `tag`
  MODIFY `IdTag` bigint(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `word`
--
ALTER TABLE `word`
  MODIFY `IdWord` bigint(255) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `grammnoun`
--
ALTER TABLE `grammnoun`
  ADD CONSTRAINT `grammnoun_ibfk_1` FOREIGN KEY (`IdWord`) REFERENCES `word` (`IdWord`) ON DELETE CASCADE ON UPDATE CASCADE,
  

--
-- Contraintes pour la table `grammverb`
--
ALTER TABLE `grammverb`
  ADD CONSTRAINT `grammverb_ibfk_1` FOREIGN KEY (`IdWord`) REFERENCES `word` (`IdWord`) ON DELETE CASCADE ON UPDATE CASCADE,
 

--
-- Contraintes pour la table `tag`
--
ALTER TABLE `tag`
  ADD CONSTRAINT `tag_ibfk_1` FOREIGN KEY (`IdWord`) REFERENCES `word` (`IdWord`);

--
-- Contraintes pour la table `word`
--
ALTER TABLE `word`
  ADD CONSTRAINT `IdCat_ForeignKey` FOREIGN KEY (`IdCat`) REFERENCES `categorie` (`IdCat`) ON DELETE CASCADE ON UPDATE CASCADE,

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
