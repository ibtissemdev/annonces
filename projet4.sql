-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mar. 12 avr. 2022 à 07:03
-- Version du serveur : 5.7.33
-- Version de PHP : 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet4`
--

-- --------------------------------------------------------

--
-- Structure de la table `annonces`
--

CREATE TABLE `annonces` (
  `id` int(10) UNSIGNED NOT NULL,
  `categorie` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `prix` int(10) UNSIGNED NOT NULL,
  `ville` varchar(255) NOT NULL,
  `photo1` varchar(250) DEFAULT NULL,
  `photo2` varchar(250) CHARACTER SET utf8mb4 DEFAULT NULL,
  `photo3` varchar(250) DEFAULT NULL,
  `photo4` varchar(250) DEFAULT NULL,
  `photo5` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `annonces`
--

INSERT INTO `annonces` (`id`, `categorie`, `nom`, `description`, `prix`, `ville`, `photo1`, `photo2`, `photo3`, `photo4`, `photo5`) VALUES
(51, 'loisirs', 'Eric Martin', 'fbdfchbdhb', 23, 'Grenoble', '', NULL, NULL, NULL, NULL),
(52, 'loisirs', 'Eric Martin', 'fbdfchbdhb', 23, 'Grenoble', '', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(10) UNSIGNED NOT NULL,
  `mail` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `mail`) VALUES
(100, 'semsem73@hotmail.fr'),
(101, 'semsem73@hotmail.fr'),
(102, 'semsem73@hotmail.fr'),
(103, 'semsem73@hotmail.fr'),
(104, 'semsem73@hotmail.fr'),
(105, 'semsem73@hotmail.fr'),
(106, 'semsem73@hotmail.fr'),
(107, 'semsem73@hotmail.fr'),
(108, 'semsem73@hotmail.fr'),
(109, 'semsem73@hotmail.fr'),
(110, 'test@test.fr'),
(111, 'test@test.fr'),
(112, 'mail@gmail.fr'),
(113, 'mail@gmail.fr'),
(114, 'mail@gmail.fr'),
(115, 'mail@gmail.fr'),
(116, 'mail@gmail.fr'),
(117, 'mail@gmail.fr'),
(118, 'mail@gmail.fr'),
(119, 'gesgsg.simplon@gmail.com'),
(120, 'semsem@hotmail.fr'),
(121, 'semsem@hotmail.fr'),
(122, 'geg@gmail.com'),
(123, 'geg@gmail.com'),
(124, 'ibtissemkhiri.simplon@gmail.com'),
(125, 'ibtissemkhiri.simplon@gmail.com'),
(126, 'ibtissemkhiri.simplon@gmail.com'),
(127, 'ibtissemkhiri.simplon@gmail.com'),
(128, 'ibtissemkhiri.simplon@gmail.com'),
(129, 'ibtissemkhiri.simplon@gmail.com'),
(130, 'ibtissemkhiri.simplon@gmail.com'),
(131, 'ibtissemkhiri.simplon@gmail.com'),
(132, 'semsem73@hotmail.fr'),
(133, 'semsem73@hotmail.fr'),
(134, 'semsem73@hotmail.fr'),
(135, 'gsdg@gmail.com'),
(136, 'gsdg@gmail.com'),
(137, 'vfsf@geg.gt'),
(138, 'vfsf@geg.gt'),
(139, 'vfsf@geg.gt'),
(140, 'vfsf@geg.gt'),
(141, 'vfsf@geg.gt'),
(142, 'vfsf@geg.gt'),
(143, 'semsem73@hotmail.fr'),
(144, 'semsem73@hotmail.fr'),
(145, 'ibtissemkhiri.simplon@gmail.com'),
(146, 'semsem73@hotmail.fr'),
(147, 'semsem73@hotmail.fr'),
(148, 'ibtissemkhiri.simplon@gmail.com'),
(149, 'semsem73@hotmail.fr'),
(150, 'mail@gmail.com'),
(151, 'semsem73@hotmail.fr'),
(152, 'semsem73@hotmail.fr'),
(153, 'semsem73@hotmail.fr'),
(154, 'semsem73@hotmail.fr'),
(155, 'semsem73@hotmail.fr'),
(156, 'mail@gmail.com'),
(157, 'semsem73@hotmail.fr'),
(158, 'mail@gmail.com'),
(159, 'mail@gmail.com');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `annonces`
--
ALTER TABLE `annonces`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `annonces`
--
ALTER TABLE `annonces`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
