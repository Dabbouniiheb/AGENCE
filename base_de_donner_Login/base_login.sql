CREATE DATABASE IF NOT EXISTS agence_voyage;
USE agence_voyage;

CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'client') DEFAULT 'client'
);

-- Insertion de comptes tests
INSERT INTO utilisateurs (nom, email, password, role) VALUES 
('Admin Agence', 'admin@voyage.com', 'admin123', 'admin'),
('Client Voyageur', 'client@voyage.com', 'client123', 'client');