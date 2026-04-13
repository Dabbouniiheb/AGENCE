CREATE DATABASE IF NOT EXISTS camping_db;
USE camping_db;

-- Table des forfaits
CREATE TABLE IF NOT EXISTS forfaits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    emplacement VARCHAR(255),
    type_sejour VARCHAR(50),
    duree VARCHAR(100),
    prix DECIMAL(10,2),
    etoiles INT,
    image_url VARCHAR(255),
    is_video BOOLEAN DEFAULT FALSE,
    badge VARCHAR(50)
);

-- Insertion de tes données
INSERT INTO forfaits (titre, emplacement, type_sejour, duree, prix, etoiles, image_url, is_video, badge) VALUES 
('Weekend Camping Montagne', 'Djebel Ressas', 'tunis', '2 jours / 1 nuit', 280, 3, 'image/3785221-hd_1920_1080_25fps.mp4', TRUE, 'TOP'),
('Camping Forêt d\'Aïn Draham', 'Aïn Draham', 'jendouba', '3 jours / 2 nuits', 420, 3, 'image/6922959-uhd_3840_2160_25fps.mp4', TRUE, 'Nature'),
('Nuit sous les étoiles', 'Douz', 'tozeur', '2 jours / 1 nuit', 350, 4, 'image/download (1).jpeg', FALSE, 'PROMO'),
('Camping Plage & Surf', 'Cap Bon', 'sousse', '3 jours / 2 nuits', 490, 4, 'image/download (2).jpeg', FALSE, 'PLAGE'),
('Glamping Luxe 5★', 'Oasis de charme', 'monastir', '3 jours / 2 nuits', 1150, 5, 'image/download.jpeg', FALSE, 'GLAMPING');