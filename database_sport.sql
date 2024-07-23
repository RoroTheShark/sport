-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 23 juil. 2024 à 07:51
-- Version du serveur : 8.0.31
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `romain-dvlp.fr`
--

-- --------------------------------------------------------

--
-- Structure de la table `s_ce`
--

DROP TABLE IF EXISTS `s_ce`;
CREATE TABLE IF NOT EXISTS `s_ce` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_NOM` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='Compétition / entrainement';

--
-- Déchargement des données de la table `s_ce`
--

INSERT INTO `s_ce` (`id`, `nom`) VALUES
(2, 'Compétition'),
(3, 'Échauffement/récup compétition'),
(1, 'Entraînement');

-- --------------------------------------------------------

--
-- Structure de la table `s_environnements`
--

DROP TABLE IF EXISTS `s_environnements`;
CREATE TABLE IF NOT EXISTS `s_environnements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_sport` int NOT NULL,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_TYPES_SPORTS` (`id_sport`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `s_environnements`
--

INSERT INTO `s_environnements` (`id`, `id_sport`, `nom`) VALUES
(1, 1, '25m'),
(2, 1, '50m'),
(3, 2, 'Route'),
(4, 3, 'Route'),
(5, 3, 'Chemin'),
(6, 4, 'Salle'),
(7, 1, 'Lac'),
(8, 5, 'Maison'),
(9, 5, 'Piscine'),
(10, 5, 'Herbe'),
(11, 5, 'Extérieur'),
(12, 7, 'Salle'),
(13, 6, 'Synthétique'),
(14, 8, 'Salle'),
(15, 3, 'Chemin+sable'),
(16, 5, 'Domyos'),
(17, 9, 'Domyos'),
(18, 3, 'Domyos'),
(19, 2, 'Domyos'),
(20, 1, 'Rivière'),
(21, 1, 'Mer'),
(22, 1, '20m'),
(23, 2, 'VTT'),
(24, 9, 'Piscine'),
(25, 3, 'Route+chemin'),
(26, 3, 'Piste'),
(27, 10, 'Campagne'),
(28, 1, '37,5m'),
(29, 3, 'Cross'),
(30, 3, 'Route+piste'),
(31, 1, '33m'),
(32, 3, 'Route+herbe'),
(33, 11, 'Route'),
(34, 3, 'Tapis'),
(35, 2, 'Home traineur'),
(36, 11, 'Route+chemin'),
(37, 11, 'Chemin'),
(38, 9, 'Smartfit - Villahermosa');

-- --------------------------------------------------------

--
-- Structure de la table `s_evenements`
--

DROP TABLE IF EXISTS `s_evenements`;
CREATE TABLE IF NOT EXISTS `s_evenements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `s_intensites`
--

DROP TABLE IF EXISTS `s_intensites`;
CREATE TABLE IF NOT EXISTS `s_intensites` (
  `id` int NOT NULL AUTO_INCREMENT,
  `valeur` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_VALEUR` (`valeur`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `s_intensites`
--

INSERT INTO `s_intensites` (`id`, `valeur`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6);

-- --------------------------------------------------------

--
-- Structure de la table `s_jours`
--

DROP TABLE IF EXISTS `s_jours`;
CREATE TABLE IF NOT EXISTS `s_jours` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `nom_anglais` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `s_jours`
--

INSERT INTO `s_jours` (`id`, `nom`, `nom_anglais`) VALUES
(1, 'Lundi', 'Monday'),
(2, 'Mardi', 'Tuesday'),
(3, 'Mercredi', 'Wednesday'),
(4, 'Jeudi', 'Thursday'),
(5, 'Vendredi', 'Friday'),
(6, 'Samedi', 'Saturday'),
(7, 'Dimanche', 'Sunday');

-- --------------------------------------------------------

--
-- Structure de la table `s_marques`
--

DROP TABLE IF EXISTS `s_marques`;
CREATE TABLE IF NOT EXISTS `s_marques` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_NOM` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `s_materiels`
--

DROP TABLE IF EXISTS `s_materiels`;
CREATE TABLE IF NOT EXISTS `s_materiels` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_sous_type` int NOT NULL,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_marque` int NOT NULL,
  `defaut` tinyint(1) NOT NULL DEFAULT '0',
  `valeur` float(10,2) NOT NULL,
  `date_achat` date DEFAULT NULL,
  `lien` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `commentaire` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `utilise` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id_sous_type` (`id_sous_type`),
  KEY `FK_MATERIEL_MARQUE` (`id_marque`)
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `s_materiels_sous_types`
--

DROP TABLE IF EXISTS `s_materiels_sous_types`;
CREATE TABLE IF NOT EXISTS `s_materiels_sous_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_type` int NOT NULL,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_type` (`id_type`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `s_materiels_sous_types`
--

INSERT INTO `s_materiels_sous_types` (`id`, `id_type`, `nom`) VALUES
(1, 1, 'Tête / Cou'),
(2, 1, 'Haut'),
(3, 1, 'Bras / Mains'),
(4, 1, 'Milieu / Jambes'),
(5, 1, 'Pieds'),
(6, 1, 'Complet : haut / milieu / bas'),
(7, 2, 'Natation'),
(8, 2, 'Vélo'),
(9, 2, 'Course à pieds'),
(10, 2, 'Tout');

-- --------------------------------------------------------

--
-- Structure de la table `s_materiels_sports`
--

DROP TABLE IF EXISTS `s_materiels_sports`;
CREATE TABLE IF NOT EXISTS `s_materiels_sports` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_materiel` int NOT NULL,
  `id_sport` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_MATERIEL_SPORTS_SPORT` (`id_sport`),
  KEY `FK_MATERIEL_SPORTS_MATERIEL` (`id_materiel`)
) ENGINE=InnoDB AUTO_INCREMENT=534 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `s_materiels_types`
--

DROP TABLE IF EXISTS `s_materiels_types`;
CREATE TABLE IF NOT EXISTS `s_materiels_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `s_materiels_types`
--

INSERT INTO `s_materiels_types` (`id`, `nom`) VALUES
(1, 'Habit'),
(2, 'Matériel');

-- --------------------------------------------------------

--
-- Structure de la table `s_mois`
--

DROP TABLE IF EXISTS `s_mois`;
CREATE TABLE IF NOT EXISTS `s_mois` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `nom_anglais` varchar(50) NOT NULL,
  `ordre_saison` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `s_mois`
--

INSERT INTO `s_mois` (`id`, `nom`, `nom_anglais`, `ordre_saison`) VALUES
(1, 'Janvier', 'January', 5),
(2, 'F&eacute;vrier', 'February', 6),
(3, 'Mars', 'March', 7),
(4, 'Avril', 'April', 8),
(5, 'Mai', 'May', 9),
(6, 'Juin', 'June', 10),
(7, 'Juillet', 'July', 11),
(8, 'Ao&ucirc;t', 'August', 12),
(9, 'Septembre', 'September', 1),
(10, 'Octobre', 'October', 2),
(11, 'Novembre', 'November', 3),
(12, 'D&eacute;cembre', 'December', 4);

-- --------------------------------------------------------

--
-- Structure de la table `s_moments`
--

DROP TABLE IF EXISTS `s_moments`;
CREATE TABLE IF NOT EXISTS `s_moments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `s_moments`
--

INSERT INTO `s_moments` (`id`, `nom`) VALUES
(1, 'Journée'),
(2, 'Matin'),
(3, 'Midi'),
(4, 'Aprem'),
(5, 'Soir');

-- --------------------------------------------------------

--
-- Structure de la table `s_monts`
--

DROP TABLE IF EXISTS `s_monts`;
CREATE TABLE IF NOT EXISTS `s_monts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pays` int NOT NULL,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pays` (`id_pays`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `s_partenaires`
--

DROP TABLE IF EXISTS `s_partenaires`;
CREATE TABLE IF NOT EXISTS `s_partenaires` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_NOM` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `s_pays`
--

DROP TABLE IF EXISTS `s_pays`;
CREATE TABLE IF NOT EXISTS `s_pays` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_NOM` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `s_piscines`
--

DROP TABLE IF EXISTS `s_piscines`;
CREATE TABLE IF NOT EXISTS `s_piscines` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_ville` int NOT NULL,
  `nom` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_PISCINE` (`id_ville`,`nom`),
  KEY `FK_PISCINES_VILLES` (`id_ville`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `s_routes`
--

DROP TABLE IF EXISTS `s_routes`;
CREATE TABLE IF NOT EXISTS `s_routes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_mont` int NOT NULL,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_mont` (`id_mont`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `s_saisons`
--

DROP TABLE IF EXISTS `s_saisons`;
CREATE TABLE IF NOT EXISTS `s_saisons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `annee_debut` int NOT NULL,
  `annee_fin` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `s_saisons`
--

INSERT INTO `s_saisons` (`id`, `annee_debut`, `annee_fin`) VALUES
(1, 2016, 2017),
(2, 2015, 2016),
(3, 2017, 2018),
(5, 2008, 2009),
(6, 2007, 2008),
(7, 2009, 2010),
(8, 2010, 2011),
(9, 2011, 2012),
(10, 2018, 2019),
(11, 2019, 2020),
(12, 2020, 2021),
(13, 2021, 2022),
(14, 2022, 2023),
(15, 2023, 2024);

-- --------------------------------------------------------

--
-- Structure de la table `s_seances`
--

DROP TABLE IF EXISTS `s_seances`;
CREATE TABLE IF NOT EXISTS `s_seances` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_environnement` int NOT NULL,
  `id_ce` int NOT NULL,
  `date_seance` date NOT NULL,
  `id_mois` int NOT NULL,
  `id_jour` int NOT NULL,
  `id_moment` int NOT NULL,
  `id_saison` int NOT NULL,
  `distance` int NOT NULL,
  `denivele` int NOT NULL DEFAULT '0',
  `temps` int NOT NULL,
  `id_intensite` int NOT NULL,
  `id_strava` bigint DEFAULT NULL,
  `id_decathlon` varchar(255) DEFAULT NULL,
  `commentaire` text,
  `entrainement` text,
  `id_piscine` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_SEANCES_TYPE` (`id_environnement`),
  KEY `FK_SEANCES_CS` (`id_ce`),
  KEY `FK_SEANCES_PISCINE` (`id_piscine`),
  KEY `FK_SEANCES_JOUR` (`id_jour`),
  KEY `FK_SEANCES_INTENSITE` (`id_intensite`),
  KEY `FK_SEANCES_SAISON` (`id_saison`),
  KEY `FK_SEANCES_MOMENT` (`id_moment`),
  KEY `FK_SEANCES_MOIS` (`id_mois`)
) ENGINE=InnoDB AUTO_INCREMENT=3308 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `s_seances_materiels`
--

DROP TABLE IF EXISTS `s_seances_materiels`;
CREATE TABLE IF NOT EXISTS `s_seances_materiels` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_seance` int NOT NULL,
  `id_materiel` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_SEANCESMATERIELS_MATERIEL` (`id_materiel`),
  KEY `FK_SEANCESMATERIELS_SEANCE` (`id_seance`)
) ENGINE=InnoDB AUTO_INCREMENT=4787 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `s_seances_partenaires`
--

DROP TABLE IF EXISTS `s_seances_partenaires`;
CREATE TABLE IF NOT EXISTS `s_seances_partenaires` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_seance` int NOT NULL,
  `id_partenaire` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_SEANCESPARTENAIRES_PARTENAIRE` (`id_partenaire`),
  KEY `FK_SEANCESPARTENAIRES_SEANCE` (`id_seance`)
) ENGINE=InnoDB AUTO_INCREMENT=1110 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `s_seances_routes`
--

DROP TABLE IF EXISTS `s_seances_routes`;
CREATE TABLE IF NOT EXISTS `s_seances_routes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_seance` int NOT NULL,
  `id_route` int NOT NULL,
  `nombre` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_seance` (`id_seance`),
  KEY `id_mont_route` (`id_route`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `s_sports`
--

DROP TABLE IF EXISTS `s_sports`;
CREATE TABLE IF NOT EXISTS `s_sports` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `nom_recherche` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `s_sports`
--

INSERT INTO `s_sports` (`id`, `nom`, `nom_recherche`) VALUES
(1, 'Natation', 'Natation'),
(2, 'V&eacute;lo', 'Vélo'),
(3, 'Course &agrave; pieds', 'Course à pieds'),
(4, 'Padel', 'Padel'),
(5, 'PPG', 'PPG'),
(6, 'Foot', 'Foot'),
(7, 'Escalade', 'Escalade'),
(8, 'Badminton', 'Badminton'),
(9, 'Muscu', 'Muscu'),
(10, 'B&R', 'B&R'),
(11, 'Marche', 'Marche');

-- --------------------------------------------------------

--
-- Structure de la table `s_villes`
--

DROP TABLE IF EXISTS `s_villes`;
CREATE TABLE IF NOT EXISTS `s_villes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pays` int NOT NULL,
  `nom` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_VILLE` (`id_pays`,`nom`),
  KEY `FK_VILLES_PAYS` (`id_pays`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `s_environnements`
--
ALTER TABLE `s_environnements`
  ADD CONSTRAINT `FK_EVENEMENTS_SPORT` FOREIGN KEY (`id_sport`) REFERENCES `s_sports` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `s_materiels`
--
ALTER TABLE `s_materiels`
  ADD CONSTRAINT `FK_MATERIEL_MARQUE` FOREIGN KEY (`id_marque`) REFERENCES `s_marques` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_MATERIEL_MATERIEL_SOUS_TYPE` FOREIGN KEY (`id_sous_type`) REFERENCES `s_materiels_sous_types` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `s_materiels_sous_types`
--
ALTER TABLE `s_materiels_sous_types`
  ADD CONSTRAINT `FK_MATERIEL_SOUS_TYPE_MATERIEL_TYPE` FOREIGN KEY (`id_type`) REFERENCES `s_materiels_types` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `s_materiels_sports`
--
ALTER TABLE `s_materiels_sports`
  ADD CONSTRAINT `FK_MATERIEL_SPORTS_MATERIEL` FOREIGN KEY (`id_materiel`) REFERENCES `s_materiels` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_MATERIEL_SPORTS_SPORT` FOREIGN KEY (`id_sport`) REFERENCES `s_sports` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `s_monts`
--
ALTER TABLE `s_monts`
  ADD CONSTRAINT `FK_SMONTS_SPAYS` FOREIGN KEY (`id_pays`) REFERENCES `s_pays` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `s_piscines`
--
ALTER TABLE `s_piscines`
  ADD CONSTRAINT `FK_PISCINE_VILLES` FOREIGN KEY (`id_ville`) REFERENCES `s_villes` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `s_routes`
--
ALTER TABLE `s_routes`
  ADD CONSTRAINT `FK_SROUTESMONTS_SMONT` FOREIGN KEY (`id_mont`) REFERENCES `s_monts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `s_seances`
--
ALTER TABLE `s_seances`
  ADD CONSTRAINT `FK_SEANCES_CE` FOREIGN KEY (`id_ce`) REFERENCES `s_ce` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_SEANCES_ENVIRONNEMENT` FOREIGN KEY (`id_environnement`) REFERENCES `s_environnements` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_SEANCES_INTENSITE` FOREIGN KEY (`id_intensite`) REFERENCES `s_intensites` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_SEANCES_JOUR` FOREIGN KEY (`id_jour`) REFERENCES `s_jours` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_SEANCES_MOIS` FOREIGN KEY (`id_mois`) REFERENCES `s_mois` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_SEANCES_MOMENT` FOREIGN KEY (`id_moment`) REFERENCES `s_moments` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_SEANCES_PISCINE` FOREIGN KEY (`id_piscine`) REFERENCES `s_piscines` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_SEANCES_SAISON` FOREIGN KEY (`id_saison`) REFERENCES `s_saisons` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `s_seances_materiels`
--
ALTER TABLE `s_seances_materiels`
  ADD CONSTRAINT `FK_SEANCESMATERIELS_MATERIEL` FOREIGN KEY (`id_materiel`) REFERENCES `s_materiels` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_SEANCESMATERIELS_SEANCE` FOREIGN KEY (`id_seance`) REFERENCES `s_seances` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `s_seances_partenaires`
--
ALTER TABLE `s_seances_partenaires`
  ADD CONSTRAINT `FK_SEANCESPARTENAIRES_PARTENAIRE` FOREIGN KEY (`id_partenaire`) REFERENCES `s_partenaires` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_SEANCESPARTENAIRES_SEANCE` FOREIGN KEY (`id_seance`) REFERENCES `s_seances` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `s_seances_routes`
--
ALTER TABLE `s_seances_routes`
  ADD CONSTRAINT `FK_SEANCESROUTES_ROUTE` FOREIGN KEY (`id_route`) REFERENCES `s_routes` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_SEANCESROUTES_SEANCE` FOREIGN KEY (`id_seance`) REFERENCES `s_seances` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `s_villes`
--
ALTER TABLE `s_villes`
  ADD CONSTRAINT `FK_VILLE_PAYS` FOREIGN KEY (`id_pays`) REFERENCES `s_pays` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
