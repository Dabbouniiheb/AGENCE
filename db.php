<?php
// ============================================
// includes/db.php — Connexion à la base de données
// ============================================

define('DB_HOST', 'localhost');
define('DB_USER', 'root');        // Utilisateur XAMPP par défaut
define('DB_PASS', '');            // Mot de passe XAMPP par défaut (vide)
define('DB_NAME', 'agence_voyagess');

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    die(json_encode(['error' => 'Connexion base de données échouée : ' . $e->getMessage()]));
}