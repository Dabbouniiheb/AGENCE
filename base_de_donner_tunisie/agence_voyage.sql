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





/*...................camping................*/


CREATE TABLE camping (
id INT AUTO_INCREMENT PRIMARY KEY,
title VARCHAR(255),
location VARCHAR(255),
duration VARCHAR(100),
price INT,
stars INT,
type VARCHAR(100),
image VARCHAR(255)
);




INSERT INTO camping (title,location,duration,price,stars,type,image) VALUES

('Weekend Camping Montagne','Djebel Ressas & Zaghouan','2 jours / 1 nuit',280,3,'montagne','3785221-hd_1920_1080_25fps.mp4'),

('Camping Foret Ain Draham','Ain Draham Nord Ouest','3 jours / 2 nuits',420,3,'foret','6922959-uhd_3840_2160_25fps.mp4'),

('Nuit sous les etoiles Douz','Dunes de Douz Sahara','2 jours / 1 nuit',350,4,'desert','desert.jpg'),

('Camping Plage Surf','Cap Bon Nabeul','3 jours / 2 nuits',490,4,'plage','plage.jpg'),

('Camping Famille Nature','Parcs naturels du Nord','3 jours / 2 nuits',520,4,'famille','famille.jpg'),

('Trek Camping Aventure','Atlas et gorges','4 jours / 3 nuits',690,5,'aventure','aventure.jpg'),

('Glamping Luxe 5 etoiles','Desert et oasis','3 jours / 2 nuits',1150,5,'luxe','luxe.jpg');




/*...................omra...............*/



CREATE DATABASE omra_db;
USE omra_db;

CREATE TABLE packages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    location VARCHAR(255),
    duration VARCHAR(100),
    price DECIMAL(10,2),
    type VARCHAR(50), -- tunis, sousse...
    stars INT,
    description TEXT,
    image VARCHAR(255)
);


CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    package_id INT,
    service TEXT,
    FOREIGN KEY (package_id) REFERENCES packages(id) ON DELETE CASCADE
);




INSERT INTO packages 
(title, location, duration, price, type, stars, description, image)
VALUES 
('Omra Économique', 'Mecque', '7 jours', 3200, 'tunis', 5, 
'Hotel de luxe, guide privé, pension complète', 
'image/omra/o1.lpg.jfif');


INSERT INTO services (package_id, service) VALUES
(1, 'Hotel de luxe'),
(1, 'Guide privé'),
(1, 'Pension complète');



/*.........dashboard Admin............*/


CREATE DATABASE omra_system;
USE omra_system;

-- TABLE VOYAGES
CREATE TABLE voyages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255),
    destination VARCHAR(255),
    date_depart DATE,
    prix DECIMAL(10,2),
    personnes INT
);

INSERT INTO voyages VALUES
(1,'Omra Ramadan','La Mecque','2026-03-20',1200,45),
(2,'Hajj','La Mecque','2026-06-25',3500,100),
(3,'Visite Médine','Médine','2026-04-10',800,30);

-- TABLE HOTELS
CREATE TABLE hotels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255),
    ville VARCHAR(255),
    etoiles INT,
    prix DECIMAL(10,2),
    chambres INT
);

INSERT INTO hotels VALUES
(1,'Hilton','La Mecque',5,150,120),
(2,'Ajyad','La Mecque',4,90,200),
(3,'Pullman','Médine',5,130,150);

-- TABLE UTILISATEURS
CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255),
    email VARCHAR(255),
    password VARCHAR(255),
    role VARCHAR(50),
    date_inscription DATE
);

INSERT INTO utilisateurs VALUES
(1,'Ali','ali@email.com','123456','Client','2026-01-01'),
(2,'Sami','sami@email.com','123456','Client','2026-02-12'),
(3,'Fatima','fatima@email.com','123456','Admin','2026-02-20');

-- TABLE RESERVATIONS
CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client VARCHAR(255),
    voyage_id INT,
    hotel_id INT,
    personnes INT,
    statut VARCHAR(50),
    FOREIGN KEY (voyage_id) REFERENCES voyages(id) ON DELETE CASCADE,
    FOREIGN KEY (hotel_id) REFERENCES hotels(id) ON DELETE CASCADE
);

INSERT INTO reservations VALUES
(1,'Ali',1,1,2,'En attente'),
(2,'Sami',2,2,4,'Annulé'),
(3,'Sami',3,1,4,'Confirmé');


--omra base de donner nouvelle 
CREATE TABLE IF NOT EXISTS forfaits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    location VARCHAR(255),
    wilaya VARCHAR(50),
    prix INT,
    duree VARCHAR(100),
    etoiles INT,
    badge_texte VARCHAR(50),
    badge_class VARCHAR(50),
    image_path VARCHAR(255),
    inclus TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
INSERT INTO forfaits (titre, location, wilaya, prix, duree, etoiles, badge_texte, badge_class, image_path, inclus) VALUES
-- PARTIE 1 : TUNIS & SOUSSE
('Omra Premium', 'Mecque & Médine', 'tunis', 5800, '15 jours', 5, 'PREMIUM 5★', 'badge-top', 'image/omra/o1.jpg', 'Vols directs, Hôtels 5★ luxe, Encadrement religieux'),
('Omra Confort', 'Haram', 'tunis', 4200, '14 jours', 4, '4★ CONFORT', 'badge-nature', 'image/omra/o2.jpg', 'Hôtel 4★ proche, Transferts inclus, Assistance 24/7'),
('Omra Économique', 'Médine', 'tunis', 3500, '12 jours', 3, '3★ STANDARD', 'badge-promo', 'image/omra/o3.jpg', 'Hôtel 3★, Petit-déjeuner, Guide local'),
('Omra Prestige', 'Mecque', 'sousse', 6500, '20 jours', 5, 'VIP 5★', 'badge-top', 'image/omra/o4.jpg', 'Hôtel vue Haram, Service VIP, Ziarates incluses'),

-- PARTIE 2 : JENDOUBA, SFAX, MONASTIR, NABEUL
('Séjour Omra Familial', 'Mecque', 'jendouba', 9680, '20 jours / 19 nuit', 5, 'PRESTIGE 5★', 'badge-top', 'image/omra/o15.jpg', 'Repas adaptés famille, Transferts confortables, Guide pour familles'),
('Omra Confort Famille', 'Haram', 'jendouba', 420, '15 jours', 4, '4★ CONFORT', 'badge-nature', 'image/omra/o16.jpg', 'Hôtel 4★, Chambres familiales, Assistance enfants'),
('Omra Family Pack', 'Madina', 'jendouba', 8280, '10 jours', 3, '3★ STANDARD', 'badge-promo', 'image/omra/o17.jpg', 'Hôtel 3★, Chambres familiales, Assistance enfants'),
('Omra Groupe', 'Madina', 'sfax', 5450, '15 jours', 5, 'EXPÉDITION 5★', 'badge-top', 'image/omra/o18.jpg', 'Hôtel 5★, Organisation complète, Encadrement collectif'),
('Omra en Groupe', 'Haram', 'sfax', 4820, '13 jours / 12 nuits', 5, 'AVENTURE 5★', 'badge-top', 'image/omra/o19.jpg', 'Hôtel 5★, Organisation complète, Encadrement collectif'),
('Omra Collective', 'Madina', 'sfax', 6900, '30 jours', 4, '4★ CONFORT', 'badge-nature', 'image/omra/o20.jpg', 'Hôtel 4★, Organisation complète, Encadrement collectif'),
('Omra Team Experience', 'Maka', 'sfax', 5390, '12 jours / 11 nuit', 3, '3★ STANDARD', 'badge-promo', 'image/omra/o21.jpg', 'Hôtel 3★, Organisation complète, Encadrement collectif'),
('Glamping Luxe', 'Désert & Oasis', 'monastir', 1150, '3 jours / 2 nuits', 5, 'GLAMPING 5★', 'badge-promo', 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=600&q=80', 'Tentes suites, Dîners gastronomiques, Transferts 4x4'),
('Glamping VIP', 'Monastir - Bord de mer', 'monastir', 1350, '3 jours / 2 nuits', 5, 'VIP 5★', 'badge-top', 'https://images.unsplash.com/photo-1528215747454-3d0e0902fff2?w=600&q=80', 'Tente avec jacuzzi privé, Chef personnel, Activités sur mesure'),
('Weekend Groupe entre Amis', 'Cap Bon', 'nabeul', 320, '2 jours / 1 nuit', 5, 'GROUPE', 'badge-nature', 'https://images.unsplash.com/photo-1516567727245-6bc7f9a0f17c?w=600&q=80', 'Tentes collectives, Soirée feu de camp, Barbecue'),

-- PARTIE 3 : DJERBA, GABES, KAIROUAN
('Camping Famille & Découverte', 'Parcs naturels', 'djerba', 520, '3 jours / 2 nuits', 5, 'Famille', 'badge-nature', 'https://images.unsplash.com/photo-1476610182048-b716b8518aae?w=600&q=80', 'Tentes familiales, Activités nature, Pension complète'),
('Family Resort Nature', 'Djerba Luxe', 'djerba', 1250, '4 jours / 3 nuits', 5, 'FAMILLE 5★', 'badge-top', 'https://images.unsplash.com/photo-1507652313519-d4e9174996dd?w=600&q=80', 'Bungalows confort, Club enfants, Piscine'),
('Camping Aventure Jeunes', 'Douz & Oasis', 'gabes', 390, '3 jours / 2 nuits', 5, 'JEUNES', 'badge-promo', 'https://images.unsplash.com/photo-1500534314211-0a24cd03f2c0?w=600&q=80', 'Bivouac nature, Dromadaire, Soirées guidées'),
('Adventure Camp', 'Matmata', 'gabes', 590, '3 jours / 2 nuits', 5, 'JEUNES 5★', 'badge-top', 'https://images.unsplash.com/photo-1522163182402-834f871fd851?w=600&q=80', 'Bivouac & sports, Guides spécialisés, Matériel escalade'),
('Camping Douceur Seniors', 'Nord-Ouest', 'kairouan', 650, '4 jours / 3 nuits', 5, 'SENIORS', 'badge-nature', 'https://images.unsplash.com/photo-1476611338391-6f395a0ebc7b?w=600&q=80', 'Tentes sur plots, Programme adapté, Accompagnateur dédié'),
('Douceur & Nature', 'Kairouan Charme', 'kairouan', 890, '4 jours / 3 nuits', 5, 'SENIORS 5★', 'badge-top', 'https://images.unsplash.com/photo-1507652313519-d4e9174996dd?w=600&q=80', 'Lodges avec chauffage, Visites culturelles, Accompagnateur');
ALTER TABLE forfaits ADD COLUMN unite_prix VARCHAR(20) DEFAULT 'DT' AFTER prix;