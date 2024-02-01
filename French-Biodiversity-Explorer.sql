-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 01 fév. 2024 à 07:10
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `test data import`
--
CREATE DATABASE IF NOT EXISTS `test data import` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `test data import`;

-- --------------------------------------------------------

--
-- Structure de la table `abonnement`
--

DROP TABLE IF EXISTS `abonnement`;
CREATE TABLE IF NOT EXISTS `abonnement` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_collection` int NOT NULL,
  `id_abonne` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_collection` (`id_collection`),
  KEY `id_abonne` (`id_abonne`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Déclencheurs `abonnement`
--
DROP TRIGGER IF EXISTS `after_abonnement_delete`;
DELIMITER $$
CREATE TRIGGER `after_abonnement_delete` AFTER DELETE ON `abonnement` FOR EACH ROW BEGIN
    INSERT INTO history_change (table_name, record_id, action, user_id)
    VALUES ('abonnement', OLD.id, 'DELETE', OLD.id_abonne);
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `after_abonnement_insert`;
DELIMITER $$
CREATE TRIGGER `after_abonnement_insert` AFTER INSERT ON `abonnement` FOR EACH ROW BEGIN
    INSERT INTO history_change (table_name, record_id, action, user_id)
    VALUES ('abonnement', NEW.id, 'ADD', NEW.id_abonne);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

DROP TABLE IF EXISTS `administrateur`;
CREATE TABLE IF NOT EXISTS `administrateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `ip` varchar(20) NOT NULL,
  `token` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `chat`
--

DROP TABLE IF EXISTS `chat`;
CREATE TABLE IF NOT EXISTS `chat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `message` varchar(250) NOT NULL,
  `id_envoi` int NOT NULL,
  `id_receveur` int NOT NULL,
  `date_envoi` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `favoris`
--

DROP TABLE IF EXISTS `favoris`;
CREATE TABLE IF NOT EXISTS `favoris` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `espece_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_favoris` (`user_id`,`espece_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déclencheurs `favoris`
--
DROP TRIGGER IF EXISTS `after_favoris_delete`;
DELIMITER $$
CREATE TRIGGER `after_favoris_delete` AFTER DELETE ON `favoris` FOR EACH ROW BEGIN
    INSERT INTO history_change (table_name, record_id, action, user_id)
    VALUES ('favoris', OLD.id, 'DELETE', OLD.user_id);
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `after_favoris_insert`;
DELIMITER $$
CREATE TRIGGER `after_favoris_insert` AFTER INSERT ON `favoris` FOR EACH ROW BEGIN
    INSERT INTO history_change (table_name, record_id, action, user_id)
    VALUES ('favoris', NEW.id, 'ADD', NEW.user_id);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `history_change`
--

DROP TABLE IF EXISTS `history_change`;
CREATE TABLE IF NOT EXISTS `history_change` (
  `id` int NOT NULL AUTO_INCREMENT,
  `table_name` varchar(255) DEFAULT NULL,
  `record_id` int DEFAULT NULL,
  `action` varchar(10) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `change_timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `photo_de_profil`
--

DROP TABLE IF EXISTS `photo_de_profil`;
CREATE TABLE IF NOT EXISTS `photo_de_profil` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int NOT NULL,
  `chemin_image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `utilisateur_id` (`utilisateur_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `signalement`
--

DROP TABLE IF EXISTS `signalement`;
CREATE TABLE IF NOT EXISTS `signalement` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_message` int NOT NULL,
  `id_envoi` int NOT NULL,
  `date_signalement` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reset_code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `ip` varchar(20) NOT NULL,
  `token` text NOT NULL,
  `date_inscription` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
