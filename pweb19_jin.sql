-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 20 Novembre 2019 à 17:23
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `pweb19_jin`
--

-- --------------------------------------------------------

--
-- Structure de la table `bilan`
--

CREATE TABLE IF NOT EXISTS `bilan` (
  `id_bilan` int(11) NOT NULL AUTO_INCREMENT,
  `id_test` int(11) NOT NULL,
  `id_etu` int(11) NOT NULL,
  `note_test` int(11) NOT NULL,
  `date_bilan` date NOT NULL,
  PRIMARY KEY (`id_bilan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

CREATE TABLE IF NOT EXISTS `etudiant` (
  `id_etu` int(11) NOT NULL AUTO_INCREMENT,
  `genre` text COLLATE utf8_bin NOT NULL,
  `nom` text COLLATE utf8_bin NOT NULL,
  `prenom` text COLLATE utf8_bin NOT NULL,
  `email` text COLLATE utf8_bin NOT NULL,
  `login_etu` text COLLATE utf8_bin NOT NULL,
  `pass_etu` text COLLATE utf8_bin NOT NULL,
  `matricule` text COLLATE utf8_bin NOT NULL,
  `num_grpe` text COLLATE utf8_bin NOT NULL,
  `date_etu` date NOT NULL,
  `bConnect` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_etu`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

--
-- Contenu de la table `etudiant`
--

INSERT INTO `etudiant` (`id_etu`, `genre`, `nom`, `prenom`, `email`, `login_etu`, `pass_etu`, `matricule`, `num_grpe`, `date_etu`, `bConnect`) VALUES
(1, 'M.', 'Tor', 'Michaël', 'michael.tor@etu.parisdescartes.fr', 'tor', 'tor', '22701007', '203', '2017-09-01', 1),
(2, 'M.', 'Moustache', 'Félix', 'felix.moustache@etu.parisdescartes.fr', 'moustach', '', '22701011', '207', '2017-09-01', 0),
(3, 'M.', 'Nguyen', 'Rémi', 'paule.nguyen@etuparisdescartes.fr', 'n', '2', '22701012', '203', '2017-09-01', 0),
(4, 'Melle.', 'Nguyen', 'Paule', 'paule.nguyen@etuparisdescartes.fr', 'nguyen2', 'r', '22701027', '204', '2017-09-01', 0);

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

CREATE TABLE IF NOT EXISTS `groupe` (
  `id_grpe` int(11) NOT NULL,
  `num_grpe` int(11) NOT NULL,
  PRIMARY KEY (`id_grpe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `groupe`
--

INSERT INTO `groupe` (`id_grpe`, `num_grpe`) VALUES
(0, 201),
(1, 202),
(2, 203),
(3, 204),
(4, 205),
(5, 206),
(6, 207);

-- --------------------------------------------------------

--
-- Structure de la table `grpetudiants`
--

CREATE TABLE IF NOT EXISTS `grpetudiants` (
  `id_grpe` int(11) NOT NULL,
  `id_etu` int(11) NOT NULL,
  PRIMARY KEY (`id_grpe`,`id_etu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `grpetudiants`
--

INSERT INTO `grpetudiants` (`id_grpe`, `id_etu`) VALUES
(0, 0),
(1, 1),
(2, 2),
(3, 3),
(4, 0),
(4, 1),
(5, 2),
(5, 3),
(6, 0),
(6, 1),
(6, 2),
(6, 3);

-- --------------------------------------------------------

--
-- Structure de la table `professeur`
--

CREATE TABLE IF NOT EXISTS `professeur` (
  `id_prof` int(11) NOT NULL AUTO_INCREMENT,
  `nom` text COLLATE utf8_bin NOT NULL,
  `prenom` text COLLATE utf8_bin NOT NULL,
  `email` text COLLATE utf8_bin NOT NULL,
  `login_prof` text COLLATE utf8_bin NOT NULL,
  `pass_prof` text COLLATE utf8_bin NOT NULL,
  `date_prof` date NOT NULL,
  `bConnect` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_prof`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

--
-- Contenu de la table `professeur`
--

INSERT INTO `professeur` (`id_prof`, `nom`, `prenom`, `email`, `login_prof`, `pass_prof`, `date_prof`, `bConnect`) VALUES
(1, 'Prof', 'Esseur', 'professeur@parisdescartes.fr', 'professeur', 'professeur', '2017-10-01', 0),
(2, 'pavy', 'antoine', '', 'pavy', 'pavy', '0000-00-00', 0),
(3, 'Sylvain', 'Durif', 'merlinlhommevert@orianna.world', 'pro', 'pro', '0000-00-00', 1);

-- --------------------------------------------------------

--
-- Structure de la table `qcm`
--

CREATE TABLE IF NOT EXISTS `qcm` (
  `id_qcm` int(11) NOT NULL,
  `id_test` int(11) NOT NULL,
  `id_quest` int(11) NOT NULL,
  `bAutorise` tinyint(1) NOT NULL,
  `bBloque` tinyint(1) NOT NULL,
  `bAnnule` int(11) NOT NULL,
  PRIMARY KEY (`id_qcm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `qcm`
--

INSERT INTO `qcm` (`id_qcm`, `id_test`, `id_quest`, `bAutorise`, `bBloque`, `bAnnule`) VALUES
(1, 38, 11, 0, 1, 0),
(2, 38, 12, 0, 1, 0),
(3, 39, 15, 0, 1, 0),
(4, 39, 16, 0, 1, 0),
(5, 40, 11, 0, 1, 0),
(6, 40, 12, 0, 1, 0),
(7, 41, 1, 1, 0, 0),
(8, 41, 9, 1, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `id_quest` int(11) NOT NULL AUTO_INCREMENT,
  `id_theme` int(11) NOT NULL,
  `titre` text COLLATE utf8_bin NOT NULL,
  `texte` text COLLATE utf8_bin NOT NULL,
  `bmultiple` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_quest`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=17 ;

--
-- Contenu de la table `question`
--

INSERT INTO `question` (`id_quest`, `id_theme`, `titre`, `texte`, `bmultiple`) VALUES
(1, 1, 'MVC', 'Que veut dire MVC ?', 0),
(9, 2, 'AAV', 'Quel language?', 0),
(11, 3, 'Expression', 'Avez-vous de la chance ?', 0),
(12, 3, 'Expression', 'Etes-vous intelligent ?', 0),
(15, 4, 'Mathématiques', '2*2 =', 1),
(16, 4, 'Mathématiques', '1+1', 0);

-- --------------------------------------------------------

--
-- Structure de la table `reponse`
--

CREATE TABLE IF NOT EXISTS `reponse` (
  `id_rep` int(11) NOT NULL AUTO_INCREMENT,
  `id_quest` int(11) NOT NULL,
  `texte_rep` text COLLATE utf8_bin NOT NULL,
  `bvalide` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_rep`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=34 ;

--
-- Contenu de la table `reponse`
--

INSERT INTO `reponse` (`id_rep`, `id_quest`, `texte_rep`, `bvalide`) VALUES
(1, 1, 'Modèle Contrôle Vue', 1),
(2, 1, 'Modélisation Conception Vue', 0),
(3, 1, 'Modélisation Contrôle Vérification', 0),
(4, 9, 'c++', 0),
(5, 9, 'html', 0),
(6, 9, 'java', 1),
(7, 9, 'tg', 0),
(8, 8, 'hello it''s me', 1),
(9, 2, 'non toujours', 0),
(10, 2, 'bibis', 0),
(11, 2, 'bff', 1),
(12, 3, 'c''est moi', 1),
(13, 3, 'toujours', 0),
(14, 10, 'sfssfsf', 0),
(15, 10, 'ssfsf', 0),
(16, 10, 'ssfsf', 0),
(17, 10, 'qss', 1),
(18, 11, 'réponse1', 0),
(19, 11, 'réponse2', 1),
(20, 12, 'oui', 0),
(21, 12, 'non', 1),
(22, 13, '5', 0),
(26, 14, '0.1', 1),
(27, 15, '1', 0),
(28, 15, '2', 0),
(29, 15, '2+2', 1),
(30, 15, '4', 1),
(31, 16, '1', 0),
(32, 16, '2', 1),
(33, 16, '3', 0);

-- --------------------------------------------------------

--
-- Structure de la table `resultat`
--

CREATE TABLE IF NOT EXISTS `resultat` (
  `id_res` int(11) NOT NULL AUTO_INCREMENT,
  `id_test` int(11) NOT NULL,
  `id_etu` int(11) NOT NULL,
  `id_quest` int(11) NOT NULL,
  `date_res` date NOT NULL,
  `id_rep` int(11) NOT NULL,
  PRIMARY KEY (`id_res`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=50 ;

--
-- Contenu de la table `resultat`
--

INSERT INTO `resultat` (`id_res`, `id_test`, `id_etu`, `id_quest`, `date_res`, `id_rep`) VALUES
(1, 39, 1, 15, '2019-11-20', 28),
(2, 40, 1, 11, '2019-11-20', 19),
(3, 40, 1, 12, '2019-11-20', 21),
(4, 40, 3, 11, '2019-11-20', 18),
(5, 40, 3, 12, '2019-11-20', 21),
(6, 41, 3, 1, '2019-11-20', 1),
(7, 41, 1, 1, '2019-11-20', 2),
(8, 41, 1, 9, '2019-11-20', 6);

-- --------------------------------------------------------

--
-- Structure de la table `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `id_test` int(11) NOT NULL AUTO_INCREMENT,
  `id_prof` int(11) NOT NULL,
  `num_grpe` text COLLATE utf8_bin NOT NULL,
  `titre_test` text COLLATE utf8_bin NOT NULL,
  `date_test` date NOT NULL,
  `bActif` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_test`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=42 ;

--
-- Contenu de la table `test`
--

INSERT INTO `test` (`id_test`, `id_prof`, `num_grpe`, `titre_test`, `date_test`, `bActif`) VALUES
(39, 1, '203', 'TestMaths', '2019-11-20', 0),
(40, 1, '203', 'TestExpression', '2019-11-20', 0),
(41, 1, '203', 'TestProg', '2019-11-20', 1);

-- --------------------------------------------------------

--
-- Structure de la table `theme`
--

CREATE TABLE IF NOT EXISTS `theme` (
  `id_theme` int(11) NOT NULL AUTO_INCREMENT,
  `titre_theme` text COLLATE utf8_bin NOT NULL,
  `desc_theme` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id_theme`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=6 ;

--
-- Contenu de la table `theme`
--

INSERT INTO `theme` (`id_theme`, `titre_theme`, `desc_theme`) VALUES
(1, 'PWEB', 'Connaissance du cours'),
(2, 'Programmation en Java', 'Connaissance théorique '),
(3, 'Expression', 'blablabla'),
(4, 'Maths', 'des calculs');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
