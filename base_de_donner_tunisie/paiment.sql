CREATE DATABASE travel_agency;

USE travel_agency;

CREATE TABLE paiements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(30) NOT NULL,
    card_number VARCHAR(30) NOT NULL,
    expiry VARCHAR(10),
    cvv VARCHAR(10),
    address VARCHAR(255),
    city VARCHAR(100),
    zip VARCHAR(20),
    promo_code VARCHAR(50),
    payment_method VARCHAR(50),
    total_price DECIMAL(10,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

