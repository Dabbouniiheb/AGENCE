<?php
// ============================================
// includes/db.php — Connexion à la base de données

// ============================================

define('DB_HOST', 'localhost');
define('DB_USER', 'root');        // Utilisateur XAMPP par défaut
define('DB_PASS', '');            // Mot de passe XAMPP par défaut (vide)
define('DB_NAME', 'agence_voyagess');

////Utilisation de PDO (PHP Data Objects) : C'est la méthode moderne et sécurisée pour interagir avec MySQL.
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //ERRMODE_EXCEPTION:Force PHP à générer une erreur claire si une requête SQL échoue.
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //ATTR_DEFAULT_FETCH_MODE : Configure les résultats pour qu'ils soient retournés sous forme de tableaux associatifs (ex: $row['nom']).
            PDO::ATTR_EMULATE_PREPARES   => false, //ATTR_EMULATE_PREPARES : Désactivé pour utiliser les vraies requêtes préparées de MySQL, ce qui protège contre les injections SQL.
        ]
    );
} catch (PDOException $e) {
    die(json_encode(['error' => 'Connexion base de données échouée : ' . $e->getMessage()]));
}