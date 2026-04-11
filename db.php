<?php
// ============================================================
//  db.php — Connexion PDO à la base de données
// ============================================================

define('DB_HOST', 'localhost');
define('DB_NAME', 'agence_voyagee');
define('DB_USER', 'root');       // ← changer si nécessaire
define('DB_PASS', '');           // ← changer si nécessaire
define('DB_CHARSET', 'utf8mb4');

function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            die(json_encode(['success' => false, 'message' => 'Connexion DB échouée : ' . $e->getMessage()]));
        }
    }
    return $pdo;
}