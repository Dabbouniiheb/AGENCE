<?php
// ============================================
// includes/auth.php — Gestion de la session
//Ce fichier gère la sécurité d'accès. Il vérifie si l'utilisateur est autorisé à voir les pages d'administration.
// ============================================
//session_start() : Initialise le système de session pour que le serveur "se souvienne" de l'utilisateur d'une page à l'autre.
session_start();

//isLoggedIn() : Renvoie true si la variable de session admin_id existe.
function isLoggedIn(): bool {  
    return isset($_SESSION['admin_id']);
}

//requireLogin() : Une fonction de redirection. Si l'utilisateur n'est pas connecté, 
//il est immédiatement renvoyé vers login.php.
function requireLogin(): void { //
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

//getCurrentAdmin() : Récupère les infos de l'administrateur actuel (nom, rôle) pour les afficher dans l'interface.
function getCurrentAdmin(): array {
    return [
        'id'   => $_SESSION['admin_id']   ?? null,
        'nom'  => $_SESSION['admin_nom']  ?? 'Admin',
        'role' => $_SESSION['admin_role'] ?? 'Admin',
    ];
}
