-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 11 nov. 2018 à 21:24
-- Version du serveur :  5.7.23
-- Version de PHP :  5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `lafleur`
--

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `cart`
--

INSERT INTO `cart` (`id`) VALUES
(11);

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_64C19C16DE44026` (`description`),
  UNIQUE KEY `UNIQ_64C19C177153098` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `description`, `code`) VALUES
(1, 'Plantes', 'pla'),
(2, 'Composition', 'com'),
(3, 'Fleurs', 'fle');

-- --------------------------------------------------------

--
-- Structure de la table `indent`
--

DROP TABLE IF EXISTS `indent`;
CREATE TABLE IF NOT EXISTS `indent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cart_id` int(11) DEFAULT NULL,
  `firstname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `number_delivery` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `street_delivery` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zip_code` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `town_delivery` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_EE75AC8E1AD5CDBF` (`cart_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `indent`
--

INSERT INTO `indent` (`id`, `cart_id`, `firstname`, `lastname`, `number_delivery`, `street_delivery`, `zip_code`, `town_delivery`) VALUES
(3, 11, 'Ruben', 'Vidot', '6', 'Rue De Paris', '97419', 'La Possession');

-- --------------------------------------------------------

--
-- Structure de la table `login`
--

DROP TABLE IF EXISTS `login`;
CREATE TABLE IF NOT EXISTS `login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_AA08CB10AA08CB10` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `login`
--

INSERT INTO `login` (`id`, `login`, `password`) VALUES
(1, 'toto', 'toto');

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `picture` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_D34A04AD8947610D` (`designation`),
  UNIQUE KEY `UNIQ_D34A04AD16DB4F89` (`picture`),
  KEY `IDX_D34A04AD12469DE2` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `category_id`, `designation`, `price`, `picture`) VALUES
(1, 2, 'Panier de fleurs variées', '53.00', '/products/com_aniwa.gif'),
(2, 2, 'Coup de charme jaune', '38.00', '/products/com_kos.gif'),
(3, 2, 'Bel arrangement de fleurs de saison', '68.00', '/products/com_loth.gif'),
(4, 2, 'Coup de charme vert', '41.00', '/products/com_luzon.gif'),
(5, 2, 'Panier de fleurs précieuses', '98.00', '/products/com_makin.gif'),
(6, 2, 'Assemblage de fleurs précieuses', '68.00', '/products/com_mosso.gif'),
(7, 2, 'Présentation prestigieuse', '128.00', '/products/com_rawaki.gif'),
(8, 3, 'Bouquet de roses multicolores', '57.00', '/products/fle_comores.gif'),
(9, 3, 'Bouquet de roses rouges', '50.00', '/products/fle_grenadines.gif\r\n'),
(10, 3, 'Bouquet de roses jaunes', '78.00', '/products/fle_mariejaune.gif'),
(11, 3, 'Bouquet de petites roses jaunes', '48.00', '/products/fle_mayotte.gif'),
(12, 3, 'Fuseau de roses multicolores', '63.00', '/products/fle_philippines.gif'),
(13, 3, 'Petit bouquet de roses roses', '43.00', '/products/fle_pakopoka.gif'),
(18, 3, 'Panier de roses multicolores', '78.00', '/products/fle_seychelles.gif'),
(19, 1, 'Plante fleurie', '43.00', '/products/pla_antharium.gif'),
(20, 1, 'Pot de phalaonopsis', '58.00', '/products/pla_galante.gif'),
(21, 1, 'Assemblage paysagé', '103.00', '/products/pla_lifou.gif'),
(22, 1, 'Belle coupe de plantes blanches', '128.00', '/products/pla_losloque.gif'),
(23, 1, 'Pot de mitonia mauve', '83.00', '/products/pla_papouasi.gif'),
(24, 1, 'Pot de phalaonopsis blanc', '58.00', '/products/pla_pionosa.gif'),
(25, 1, 'Pot de phalaonopsis rose mauve', '58.00', '/products/pla_sabana.gif'),
(26, 1, 'Test', '12.00', 'C:\\wamp64\\tmp\\php22A5.tmp');

-- --------------------------------------------------------

--
-- Structure de la table `row`
--

DROP TABLE IF EXISTS `row`;
CREATE TABLE IF NOT EXISTS `row` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8430F6DB4584665A` (`product_id`,`cart_id`) USING BTREE,
  KEY `IDX_8430F6DB1AD5CDBF` (`cart_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `row`
--

INSERT INTO `row` (`id`, `product_id`, `cart_id`, `quantity`) VALUES
(35, 19, 11, 3),
(37, 6, 11, 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `indent`
--
ALTER TABLE `indent`
  ADD CONSTRAINT `FK_EE75AC8E1AD5CDBF` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`);

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_D34A04AD12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Contraintes pour la table `row`
--
ALTER TABLE `row`
  ADD CONSTRAINT `FK_8430F6DB1AD5CDBF` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`),
  ADD CONSTRAINT `FK_8430F6DB4584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
