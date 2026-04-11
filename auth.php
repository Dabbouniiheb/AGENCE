<?php
// ============================================================
//  auth.php — Gestion de session
// ============================================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn(): bool {
    return isset($_SESSION['admin_id']);
}

function requireLogin(): void {
    if (!isLoggedIn()) {
        header('Location: Login.php');
        exit;
    }
}

function logout(): void {
    session_destroy();
    header('Location: Login.php');
    exit;
}
