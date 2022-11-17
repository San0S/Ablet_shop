-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 12 nov. 2022 à 19:30
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tpweb_devweb`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `refart` int(11) NOT NULL,
  `designation` text COLLATE utf8_bin NOT NULL,
  `pu` float(3,2) NOT NULL,
  `unitecond` text COLLATE utf8_bin NOT NULL,
  `remise` float NOT NULL,
  `imagelien` text COLLATE utf8_bin,
  PRIMARY KEY (`refart`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`refart`, `designation`, `pu`, `unitecond`, `remise`, `imagelien`) VALUES
(100250, 'orange Succulente', 1.00, '1kg', 6, 'img/orange.jpg'),
(368723, 'brioche Pakié', 6.50, '1kg', 0, 'img/brioche.jpg'),
(368724, 'yaourt nature VANONA', 1.60, '4x12cl', 0, 'img/yaourt-nature.jpg'),
(401543, 'dragées Frisklès', 4.90, '75g', 0, 'img/dragee.jpg'),
(445566, 'moutarde forte Maye', 3.30, '380gr', 10, 'img/moutarde.jpg'),
(778899, 'Essuie-tout prédécoupé/résistant TOPALAIN', 3.00, '3 rouleaux', 10, 'img/essuie-tout.jpg'),
(935647, 'torsades Paria', 2.20, '500gr', 0, 'img/torsades.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `caddie`
--

DROP TABLE IF EXISTS `caddie`;
CREATE TABLE IF NOT EXISTS `caddie` (
  `idutilisateur` int(11) NOT NULL,
  `refart` int(11) NOT NULL,
  `qte` float(3,2) NOT NULL,
  PRIMARY KEY (`idutilisateur`,`refart`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `caddie`
--

INSERT INTO `caddie` (`idutilisateur`, `refart`, `qte`) VALUES
(1, 100250, 1.45),
(1, 368723, 2.00),
(1, 368724, 3.00),
(1, 445566, 1.00),
(1, 935647, 1.00),
(2, 368723, 1.00),
(2, 401543, 1.00),
(2, 778899, 2.00),
(3, 368723, 3.00),
(3, 445566, 4.00),
(3, 778899, 1.00);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `idutilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `nom` text COLLATE utf8_bin NOT NULL,
  `prenom` text COLLATE utf8_bin NOT NULL,
  `civilite` text COLLATE utf8_bin NOT NULL,
  `mel` text COLLATE utf8_bin NOT NULL,
  `login` text COLLATE utf8_bin NOT NULL,
  `mdp` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idutilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`idutilisateur`, `nom`, `prenom`, `civilite`, `mel`, `login`, `mdp`) VALUES
(1, 'FARFADELLE', 'Christophe', 'M.', 'christophe.farfa@gmail.com', 'farfad2', 'FAR%10le'),
(2, 'KIRMANI', 'Jezabel', 'Mme', 'jeza.kirmini@gmx.fr', 'kirman1', 'JeZa8?'),
(3, 'MARTIN', 'François', 'M.', 'francois.martinF@gmail.com', 'martin47', '1234cmoi'),
(4, 'KAS', 'Martine', 'Mme', 'kas.martine@gmail.com', 'kas4', 'G1bonMo'),
(5, 'MATTEO', 'Vella', 'Monsieur', 'qsgqs@qsg.com', 'vell45', '1234'),
(6, 'VALJEAN', 'Jean', 'Mx.', 'qsgd@sdg.com', 'azqsgl', '1234'),
(7, 'WAYNE', 'Bruce', 'M.', 'batman@batmail.bat', 'batman', 'nikejoker'),
(8, 'VANDAME', 'Jean-Claude', 'M.', 'jvc@leboss.com', 'JvC', 'cbonlo');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
