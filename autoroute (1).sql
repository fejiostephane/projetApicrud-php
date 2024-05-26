-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 23 mai 2024 à 02:21
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `autoroute`
--

-- --------------------------------------------------------

--
-- Structure de la table `badge`
--

CREATE TABLE `badge` (
  `id` bigint(19) UNSIGNED NOT NULL,
  `badge` char(4) NOT NULL,
  `nom` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `badge`
--

INSERT INTO `badge` (`id`, `badge`, `nom`) VALUES
(4, '0001', 'Charles'),
(5, '0002', 'Hello'),
(13, '0145', 'Jason jj'),
(16, '0051', 'test'),
(19, '0432', 'holle'),
(20, '0123', 'test');

-- --------------------------------------------------------

--
-- Structure de la table `garepeage`
--

CREATE TABLE `garepeage` (
  `id` bigint(20) NOT NULL,
  `GarePeage` varchar(4) NOT NULL,
  `nomPeage` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `garepeage`
--

INSERT INTO `garepeage` (`id`, `GarePeage`, `nomPeage`) VALUES
(1, '0010', 'Montpellier'),
(2, '0020', 'Nime'),
(3, '0030', 'Lyon'),
(4, '0040', 'Nice');

-- --------------------------------------------------------

--
-- Structure de la table `portique`
--

CREATE TABLE `portique` (
  `id` bigint(20) NOT NULL,
  `isEntrer` tinyint(4) NOT NULL,
  `noPortique` tinyint(4) NOT NULL,
  `fkGarePeage` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `portique`
--

INSERT INTO `portique` (`id`, `isEntrer`, `noPortique`, `fkGarePeage`) VALUES
(5, 1, 1, 1),
(6, 1, 2, 1),
(7, 0, 3, 1),
(8, 0, 4, 1),
(15, 0, 1, 2),
(16, 1, 1, 2),
(17, 1, 1, 3),
(18, 0, 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `tarification`
--

CREATE TABLE `tarification` (
  `fkGarePeageSource` bigint(20) NOT NULL,
  `fkGarePeageDestination` bigint(20) NOT NULL,
  `tarif` decimal(10,2) NOT NULL,
  `distance` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `trajet`
--

CREATE TABLE `trajet` (
  `id` bigint(20) NOT NULL,
  `dateEntree` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `dateSortie` timestamp NULL DEFAULT NULL,
  `fkPortiqueEntree` bigint(20) NOT NULL,
  `fkPortiqueSortie` bigint(20) DEFAULT NULL,
  `fkBadge` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `trajet`
--

INSERT INTO `trajet` (`id`, `dateEntree`, `dateSortie`, `fkPortiqueEntree`, `fkPortiqueSortie`, `fkBadge`) VALUES
(4, '2024-05-22 01:10:18', NULL, 5, NULL, 4),
(5, '0000-00-00 00:00:00', NULL, 8, NULL, 19);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `badge`
--
ALTER TABLE `badge`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `badge_UNIQUE` (`badge`);

--
-- Index pour la table `garepeage`
--
ALTER TABLE `garepeage`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `GarePeage_UNIQUE` (`GarePeage`);

--
-- Index pour la table `portique`
--
ALTER TABLE `portique`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Portique_GarePeage_idx` (`fkGarePeage`);

--
-- Index pour la table `tarification`
--
ALTER TABLE `tarification`
  ADD PRIMARY KEY (`fkGarePeageSource`,`fkGarePeageDestination`),
  ADD KEY `fk_Tarification_GarePeage1_idx` (`fkGarePeageSource`),
  ADD KEY `fk_Tarification_GarePeage2_idx` (`fkGarePeageDestination`);

--
-- Index pour la table `trajet`
--
ALTER TABLE `trajet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Trajet_Portique1_idx` (`fkPortiqueEntree`),
  ADD KEY `fk_Trajet_Portique2_idx` (`fkPortiqueSortie`),
  ADD KEY `fk_Trajet_badge1_idx` (`fkBadge`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `badge`
--
ALTER TABLE `badge`
  MODIFY `id` bigint(19) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `garepeage`
--
ALTER TABLE `garepeage`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `portique`
--
ALTER TABLE `portique`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `trajet`
--
ALTER TABLE `trajet`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `portique`
--
ALTER TABLE `portique`
  ADD CONSTRAINT `fk_Portique_GarePeage` FOREIGN KEY (`fkGarePeage`) REFERENCES `garepeage` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `tarification`
--
ALTER TABLE `tarification`
  ADD CONSTRAINT `fk_Tarification_GarePeage1` FOREIGN KEY (`fkGarePeageSource`) REFERENCES `garepeage` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Tarification_GarePeage2` FOREIGN KEY (`fkGarePeageDestination`) REFERENCES `garepeage` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `trajet`
--
ALTER TABLE `trajet`
  ADD CONSTRAINT `fk_Trajet_Portique1` FOREIGN KEY (`fkPortiqueEntree`) REFERENCES `portique` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Trajet_Portique2` FOREIGN KEY (`fkPortiqueSortie`) REFERENCES `portique` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Trajet_badge1` FOREIGN KEY (`fkBadge`) REFERENCES `badge` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
