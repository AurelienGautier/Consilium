-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : sam. 01 avr. 2023 à 09:26
-- Version du serveur : 10.10.2-MariaDB
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `consilium`
--

-- --------------------------------------------------------

--
-- Structure de la table `fournisseur`
--

DROP TABLE IF EXISTS `fournisseur`;
CREATE TABLE IF NOT EXISTS `fournisseur` (
  `id_fournisseur` int(11) NOT NULL AUTO_INCREMENT,
  `nom_fournisseur` varchar(50) NOT NULL,
  PRIMARY KEY (`id_fournisseur`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `fournisseur`
--

INSERT INTO `fournisseur` (`id_fournisseur`, `nom_fournisseur`) VALUES
(1, 'fournisseur1'),
(2, 'fournisseur2'),
(3, 'fournisseur3');

-- --------------------------------------------------------

--
-- Structure de la table `ligneprod`
--

DROP TABLE IF EXISTS `ligneprod`;
CREATE TABLE IF NOT EXISTS `ligneprod` (
  `id_ligneProd` int(11) NOT NULL AUTO_INCREMENT,
  `nom_ligneProd` varchar(50) NOT NULL,
  `couleur_ligneProd` char(7) DEFAULT NULL,
  PRIMARY KEY (`id_ligneProd`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `ligneprod`
--

INSERT INTO `ligneprod` (`id_ligneProd`, `nom_ligneProd`, `couleur_ligneProd`) VALUES
(1, 'ligne1', '#1a8dc6'),
(2, 'ligne2', '#65dd57'),
(3, 'ligne3', '#dc5a5a');

-- --------------------------------------------------------

--
-- Structure de la table `machine`
--

DROP TABLE IF EXISTS `machine`;
CREATE TABLE IF NOT EXISTS `machine` (
  `id_machine` int(11) NOT NULL AUTO_INCREMENT,
  `nom_machine` varchar(50) NOT NULL,
  PRIMARY KEY (`id_machine`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `machine`
--

INSERT INTO `machine` (`id_machine`, `nom_machine`) VALUES
(1, 'machine1'),
(2, 'machine2'),
(3, 'machine3');

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `id_reservation` int(11) NOT NULL AUTO_INCREMENT,
  `dateDebut_reservation` date DEFAULT NULL,
  `dateFin_reservation` date DEFAULT NULL,
  `id_ligneProd` int(11) NOT NULL,
  PRIMARY KEY (`id_reservation`),
  KEY `reservation_ligneProd_FK` (`id_ligneProd`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`id_reservation`, `dateDebut_reservation`, `dateFin_reservation`, `id_ligneProd`) VALUES
(1, '2023-03-27', '2023-04-20', 1);

-- --------------------------------------------------------

--
-- Structure de la table `tache`
--

DROP TABLE IF EXISTS `tache`;
CREATE TABLE IF NOT EXISTS `tache` (
  `id_tache` int(11) NOT NULL AUTO_INCREMENT,
  `nom_tache` varchar(128) NOT NULL,
  `dateDebut_tache` date DEFAULT NULL,
  `dateFin_tache` date DEFAULT NULL,
  `id_reservation` int(11) NOT NULL,
  `id_fournisseur` int(11) DEFAULT NULL,
  `id_typeTache` int(11) NOT NULL,
  `description_tache` text DEFAULT NULL,
  `id_machine` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_tache`),
  KEY `tache_reservation_FK` (`id_reservation`),
  KEY `tache_fournisseur0_FK` (`id_fournisseur`),
  KEY `tache_typeTache1_FK` (`id_typeTache`),
  KEY `Fk_tache_machine` (`id_machine`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `tache`
--

INSERT INTO `tache` (`id_tache`, `nom_tache`, `dateDebut_tache`, `dateFin_tache`, `id_reservation`, `id_fournisseur`, `id_typeTache`, `description_tache`, `id_machine`) VALUES
(4, 'tache1', '2023-04-01', '2023-04-15', 1, NULL, 1, NULL, 1);

--
-- Déclencheurs `tache`
--
DROP TRIGGER IF EXISTS `tacheUniqueParMachine`;
DELIMITER $$
CREATE TRIGGER `tacheUniqueParMachine` BEFORE INSERT ON `tache` FOR EACH ROW BEGIN
    DECLARE laMachine INT;
    DECLARE laDateDebut DATE;
    DECLARE laDateFin DATE;
    DECLARE nbCol INT;
    
    SELECT NEW.id_machine INTO laMachine;
    SELECT NEW.dateDebut_tache INTO laDateDebut;
    SELECT NEW.dateFin_tache INTO laDateFin;
    
    SELECT COUNT(*)
    INTO nbCol
    FROM tache
    WHERE id_machine = laMachine
    AND (
        (dateDebut_tache <= laDateDebut AND laDateDebut <= dateFin_tache)
        OR (dateDebut_tache <= laDateFin AND laDateFin <= dateFin_tache)
        OR (dateDebut_tache >= laDateDebut AND dateFin_tache <= laDateFin)
    );
    
    IF nbCol > 0 THEN 
    	SIGNAL SQLSTATE '45000'
   		SET MESSAGE_TEXT = 'Une tâche a déjà été attribuée sur la machine durant cette période.';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `typetache`
--

DROP TABLE IF EXISTS `typetache`;
CREATE TABLE IF NOT EXISTS `typetache` (
  `id_typeTache` int(11) NOT NULL AUTO_INCREMENT,
  `nom_typeTache` varchar(128) NOT NULL,
  PRIMARY KEY (`id_typeTache`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `typetache`
--

INSERT INTO `typetache` (`id_typeTache`, `nom_typeTache`) VALUES
(1, 'Qualification'),
(2, 'Métrologie'),
(3, 'Maintenance');

-- --------------------------------------------------------

--
-- Structure de la table `utiliser`
--

DROP TABLE IF EXISTS `utiliser`;
CREATE TABLE IF NOT EXISTS `utiliser` (
  `id_machine` int(11) NOT NULL,
  `id_ligneProd` int(11) NOT NULL,
  PRIMARY KEY (`id_machine`,`id_ligneProd`),
  KEY `utiliser_ligneProd0_FK` (`id_ligneProd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `utiliser`
--

INSERT INTO `utiliser` (`id_machine`, `id_ligneProd`) VALUES
(1, 1),
(2, 2),
(3, 2),
(3, 3);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ligneProd_FK` FOREIGN KEY (`id_ligneProd`) REFERENCES `ligneprod` (`id_ligneProd`);

--
-- Contraintes pour la table `tache`
--
ALTER TABLE `tache`
  ADD CONSTRAINT `Fk_tache_machine` FOREIGN KEY (`id_machine`) REFERENCES `machine` (`id_machine`),
  ADD CONSTRAINT `tache_fournisseur0_FK` FOREIGN KEY (`id_fournisseur`) REFERENCES `fournisseur` (`id_fournisseur`),
  ADD CONSTRAINT `tache_reservation_FK` FOREIGN KEY (`id_reservation`) REFERENCES `reservation` (`id_reservation`),
  ADD CONSTRAINT `tache_typeTache1_FK` FOREIGN KEY (`id_typeTache`) REFERENCES `typetache` (`id_typeTache`);

--
-- Contraintes pour la table `utiliser`
--
ALTER TABLE `utiliser`
  ADD CONSTRAINT `utiliser_ligneProd0_FK` FOREIGN KEY (`id_ligneProd`) REFERENCES `ligneprod` (`id_ligneProd`),
  ADD CONSTRAINT `utiliser_machine_FK` FOREIGN KEY (`id_machine`) REFERENCES `machine` (`id_machine`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
