<?php
// ============================================
// includes/auth.php — Gestion de la session
// ============================================

session_start();

function isLoggedIn(): bool {
    return isset($_SESSION['admin_id']);
}

function requireLogin(): void {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

function getCurrentAdmin(): array {
    return [
        'id'   => $_SESSION['admin_id']   ?? null,
        'nom'  => $_SESSION['admin_nom']  ?? 'Admin',
        'role' => $_SESSION['admin_role'] ?? 'Admin',
    ];
}
