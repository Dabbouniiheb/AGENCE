-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 06 avr. 2026 à 21:24
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `agence_voyage`
--

-- --------------------------------------------------------

--
-- Structure de la table `packages`
--

CREATE TABLE `packages` (
  `id` int(11) NOT NULL,
  `wilaya` varchar(50) NOT NULL,
  `badge` varchar(20) DEFAULT NULL,
  `badge_class` varchar(50) DEFAULT NULL,
  `image_principale` varchar(255) DEFAULT NULL,
  `titre` varchar(100) NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `duree` varchar(50) DEFAULT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  `etoiles` int(11) DEFAULT 5,
  `inclus` text DEFAULT NULL,
  `exclus` text DEFAULT NULL,
  `carousel_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `packages`
--

INSERT INTO `packages` (`id`, `wilaya`, `badge`, `badge_class`, `image_principale`, `titre`, `location`, `duree`, `prix`, `etoiles`, `inclus`, `exclus`, `carousel_id`) VALUES
(1, 'sfax', 'PROMO', 'badge-promo', 'image/ol1.jpg', 'Les Oliviers Palace', 'Sfax', '2 jours', 290.00, 4, 'Ferry, Hôtel, Repas poisson', 'Transport Sfax', 'carousel25'),
(2, 'sfax', 'Nature', 'badge-nature', 'image/z1.jpg', 'Borj Dhiafa Hotel', 'Sfax', '1 jour', 75.00, 4, 'Transport, Parasol', 'Repas', 'carousel26'),
(3, 'sfax', 'TOP', 'badge-top', 'image/pa1.jpg', 'Palais Royal Hotel', 'Sfax', '3 jours', 420.00, 5, 'Hôtel 4★, Pension complète', 'Transport', 'carousel27'),
(4, 'monastir', 'TOP', 'badge-top', 'image/w1.jpg', 'Monastir Plage 4 jours', 'Monastir', '4 jours', 520.00, 4, 'Hôtel 4★, Demi-pension', 'Vol', 'carousel28'),
(5, 'monastir', 'Nature', 'badge-nature', 'image/m1.jpg', 'Skanes - Golf & Mer', 'Monastir', '2 jours', 340.00, 4, 'Hôtel golf, Petit déj', 'Transport', 'carousel29'),
(6, 'monastir', 'PROMO', 'badge-promo', 'image/u1.jpg', 'Bourgiba - Mausolée', 'Monastir', '0.5 jour', 40.00, 5, 'Entrée, Guide', 'Transport', 'carousel30'),
(7, 'nabeul', 'Nature', 'badge-nature', 'image/kl1.jpg', 'Kelibia - Forteresse', 'Nabeul', '1 jour', 88.00, 4, 'Transport, Entrée forteresse', 'Repas', 'carousel31'),
(8, 'nabeul', 'PROMO', 'badge-promo', 'image/na1.jpg', 'Nabeul Médina & Poterie', 'Nabeul', '1 jour', 70.00, 5, 'Transport, Atelier poterie', 'Achats', 'carousel32'),
(9, 'djerba', 'TOP', 'badge-top', 'image/h1.jpg', 'Houmt Souk - Médina', 'Djerba', '1 jour', 95.00, 4, 'Transport, Guide', 'Hébergement', 'carousel33'),
(10, 'djerba', 'Nature', 'badge-nature', 'image/plage.avif', 'Midoun - Marché & Plages', 'Djerba', '2 jours', 340.00, 4, 'Hôtel 3★, Petit déj', 'Vol', 'carousel34'),
(11, 'djerba', 'PROMO', 'badge-promo', 'image/plage.avif', 'Djerba 7 jours All inclusive', 'Djerba', '7 jours', 1450.00, 5, 'Hôtel 5★, All inclusive, Spa', 'Vol', 'carousel35'),
(12, 'gabes', 'TOP', 'badge-top', 'https://images.unsplash.com/photo-1509316785289-025f5b846b35', 'Gabès - Oasis & Golfe', 'Gabès', '2 jours', 270.00, 4, 'Hôtel oasis, Visite palmeraie', 'Transport', 'carousel36'),
(13, 'gabes', 'Nature', 'badge-nature', 'https://images.unsplash.com/photo-1547234935-80c7145ec969', 'Chenini - Village troglodyte', 'Gabès', '1 jour', 120.00, 4, 'Transport, Guide', 'Repas', 'carousel37'),
(14, 'gabes', 'PROMO', 'badge-promo', 'https://images.unsplash.com/photo-1504214208698-ea1916a2195a', 'Zarzis - Plages & Thalasso', 'Gabès', '3 jours', 480.00, 5, 'Hôtel 4★, Spa thalasso', 'Vol', 'carousel38'),
(15, 'kairouan', 'TOP', 'badge-top', 'https://images.unsplash.com/photo-1478827387698-1527781a4887', 'Grande Mosquée Kairouan', 'Kairouan', '0.5 jour', 50.00, 4, 'Transport, Guide', 'Repas', 'carousel39'),
(16, 'kairouan', 'Nature', 'badge-nature', 'https://images.unsplash.com/photo-1445307806294-bff7f67ff225', 'Kairouan - Tapis & Médina', 'Kairouan', '1 jour', 130.00, 4, 'Transport, Atelier tapis', 'Achats', 'carousel40'),
(17, 'kairouan', 'PROMO', 'badge-promo', 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4', 'Kairouan 2 jours Complet', 'Kairouan', '2 jours', 220.00, 5, 'Hôtel, Tous sites, Repas', 'Transport', 'carousel41'),
(18, 'other', 'TOP', 'badge-top', 'https://images.unsplash.com/photo-1527631746610-bca00a040d60', 'Ksar Ouled Soltane', 'Tataouine', '1 jour', 140.00, 4, '4x4, Guide Star Wars', 'Hébergement', 'carousel42'),
(19, 'other', 'Nature', 'badge-nature', 'https://images.unsplash.com/photo-1547234935-80c7145ec969', 'Kebili - Douz & Chott', 'Kebili', '2 jours', 380.00, 4, 'Bivouac désert, Chameau', 'Transport Tunis', 'carousel43'),
(20, 'other', 'PROMO', 'badge-promo', 'https://images.unsplash.com/photo-1504214208698-ea1916a2195a', 'Médenine - Ksour & Marché', 'Médenine', '1 jour', 125.00, 5, 'Transport, Guide', 'Repas', 'carousel44'),

-- TUNIS (+3)
(21, 'tunis', 'TOP', 'badge-top', 'image/to1.jpg', 'Four Seasons Hotel Tunis', 'Tunis', '1 jour', 85.00, 4, 'Hôtel 4★, Transport, Plage privée, Déjeuner', 'Hébergement', 'carousel15'),
(22, 'tunis', 'Nature', 'badge-nature', 'image/f1.jpg', 'Sheraton Tunis Hotel', 'Tunis', '0.5 jour', 45.00, 4, 'Entrée musée, Guide', 'Transport', 'carousel16'),
(23, 'tunis', 'PROMO', 'badge-promo', 'image/mv11.jpg', 'Mövenpick Hotel Du Lac Tunis', 'Tunis', '1 soir', 65.00, 5, 'Guide, Dégustation', 'Dîner', 'carousel17'),

-- SOUSSE (+3)
(24, 'sousse', 'TOP', 'badge-top', 'image/q1.jpg', 'Marhaba Beach Hotel', 'Sousse', '2 jours', 380.00, 4, 'Hôtel 4★, Demi-pension, Marina', 'Vol', 'carousel18'),
(25, 'sousse', 'Nature', 'badge-nature', 'image/uo1.jpg', 'Riadh Palms Resort & Spa', 'Sousse', '0.5 jour', 55.00, 4, 'Entrées, Guide', 'Transport', 'carousel19'),
(26, 'sousse', 'PROMO', 'badge-promo', 'image/l1.jpg', 'JAZ Tour KHALEF', 'Sousse', '5 jours', 720.00, 5, 'Hôtel 5★, Pension complète', 'Vol', 'carousel20'),

-- TOZEUR (+2)
(27, 'tozeur', 'Nature', 'badge-nature', 'image/naf1.jpg', 'Nefta - Corbeille', 'Tozeur', '1 jour', 180.00, 4, 'Transport, Guide', 'Hébergement', 'carousel21'),
(28, 'tozeur', 'TOP', 'badge-top', 'image/chat1.jpg', 'Chott el Jerid', 'Tozeur', '1 jour', 150.00, 5, '4x4, Déjeuner', 'Hébergement', 'carousel22'),

-- JENDOUBA (+2)
(29, 'jendouba', 'Nature', 'badge-nature', 'image/c1.jpg', 'Bulla Regia', 'Jendouba', '1 jour', 95.00, 4, 'Transport, Entrée site', 'Repas', 'carousel23'),
(30, 'jendouba', 'TOP', 'badge-top', 'image/e1.jpg', 'Chemtou - Marbre antique', 'Jendouba', '1 jour', 110.00, 5, 'Transport, Guide', 'Repas', 'carousel24'),

-- DJERBA (+3)
(31, 'djerba', 'TOP', 'badge-top', 'image/h1.jpg', 'Houmt Souk - Médina', 'Djerba', '1 jour', 95.00, 4, 'Transport, Guide', 'Hébergement', 'carousel33'),
(32, 'djerba', 'Nature', 'badge-nature', 'image/plage.avif', 'Midoun - Marché & Plages', 'Djerba', '2 jours', 340.00, 4, 'Hôtel 3★, Petit déj', 'Vol', 'carousel34'),
(33, 'djerba', 'PROMO', 'badge-promo', 'image/plage.avif', 'Djerba 7 jours All inclusive', 'Djerba', '7 jours', 1450.00, 5, 'Hôtel 5★, All inclusive, Spa', 'Vol', 'carousel35');
--
-- Index pour les tables déchargées
--

--
-- Index pour la table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
