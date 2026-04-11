-- ============================================================
--  AGENCE DE VOYAGES - Base de données MySQL
--  Compatible XAMPP / MySQL 8.0
-- ============================================================

CREATE DATABASE IF NOT EXISTS agence_voyages CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE agence_voyages;

-- ============================================================
-- TABLE : voyages
-- ============================================================
CREATE TABLE IF NOT EXISTS voyages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    destination VARCHAR(100) NOT NULL,
    date_depart DATE NOT NULL,
    prix DECIMAL(10,2) NOT NULL DEFAULT 0,
    nb_personnes INT NOT NULL DEFAULT 1,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================================
-- TABLE : hotels
-- ============================================================
CREATE TABLE IF NOT EXISTS hotels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    ville VARCHAR(100) NOT NULL,
    etoiles TINYINT NOT NULL DEFAULT 3,
    prix_nuit DECIMAL(10,2) NOT NULL DEFAULT 0,
    nb_chambres INT NOT NULL DEFAULT 1,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================================
-- TABLE : utilisateurs
-- ============================================================
CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    role ENUM('Admin','Client') NOT NULL DEFAULT 'Client',
    date_inscription DATE NOT NULL DEFAULT (CURDATE()),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================================
-- TABLE : reservations
-- ============================================================
CREATE TABLE IF NOT EXISTS reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_nom VARCHAR(100) NOT NULL,
    utilisateur_id INT,
    voyage_id INT,
    hotel_id INT,
    nb_personnes INT NOT NULL DEFAULT 1,
    statut ENUM('En attente','Confirmé','Annulé') NOT NULL DEFAULT 'En attente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE SET NULL,
    FOREIGN KEY (voyage_id) REFERENCES voyages(id) ON DELETE SET NULL,
    FOREIGN KEY (hotel_id) REFERENCES hotels(id) ON DELETE SET NULL
);

-- ============================================================
-- TABLE : parametres
-- ============================================================
CREATE TABLE IF NOT EXISTS parametres (
    cle VARCHAR(100) PRIMARY KEY,
    valeur TEXT NOT NULL
);

-- ============================================================
-- DONNÉES DE DÉMONSTRATION
-- ============================================================

-- Admin par défaut (mot de passe : admin123)
INSERT INTO utilisateurs (nom, email, mot_de_passe, role, date_inscription) VALUES
('Admin Principal', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin', CURDATE());

-- Voyages
INSERT INTO voyages (nom, destination, date_depart, prix, nb_personnes, description) VALUES
('Omra Ramadan',  'La Mecque', '2026-03-20', 1200.00, 45, 'Voyage spirituel Omra pendant le Ramadan'),
('Hajj',          'La Mecque', '2026-06-25', 3500.00, 100, 'Pèlerinage du Hajj annuel'),
('Visite Médine', 'Médine',    '2026-04-10', 800.00,  30,  'Visite de la ville du Prophète');

-- Hôtels
INSERT INTO hotels (nom, ville, etoiles, prix_nuit, nb_chambres, description) VALUES
('Hilton',  'La Mecque', 5, 150.00, 120, 'Hôtel 5 étoiles face à la Kaâba'),
('Ajyad',   'La Mecque', 4, 90.00,  200, 'Hôtel 4 étoiles en centre ville'),
('Pullman', 'Médine',    5, 130.00, 150, 'Hôtel luxueux proche de la Mosquée');

-- Utilisateurs clients
INSERT INTO utilisateurs (nom, email, mot_de_passe, role, date_inscription) VALUES
('Ali',    'ali@email.com',    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Client', '2026-01-01'),
('Sami',   'sami@email.com',   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Client', '2026-02-12'),
('Fatima', 'fatima@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin',  '2026-02-20');

-- Réservations
INSERT INTO reservations (client_nom, utilisateur_id, voyage_id, hotel_id, nb_personnes, statut) VALUES
('Ali',  2, 1, 1, 2, 'En attente'),
('Sami', 3, 2, 2, 4, 'Annulé'),
('Sami', 3, 3, 1, 4, 'Confirmé');

-- Paramètres généraux
INSERT INTO parametres (cle, valeur) VALUES
('site_nom',          'Agence de Voyages'),
('langue',            'fr'),
('devise',            'EUR'),
('fuseau',            'UTC+1'),
('two_factor',        '1'),
('login_alerts',      '1'),
('session_timeout',   '30'),
('email_reservation', '1'),
('email_new_user',    '1'),
('email_rapport',     '0'),
('email_notif',       'notifications@example.com');
