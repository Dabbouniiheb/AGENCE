<?php
// ============================================
// api.php — API AJAX (GET/POST/DELETE)
// ============================================
require_once 'db.php';
require_once 'auth.php';

header('Content-Type: application/json; charset=utf-8');

if (!isLoggedIn()) {
    echo json_encode(['error' => 'Non authentifié']);
    exit;
}

$action = $_GET['action'] ?? $_POST['action'] ?? '';

// ─── HELPER ────────────────────────────────────────
function respond(array $data): void {
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

// ─── DASHBOARD STATS ───────────────────────────────
if ($action === 'stats') {
    global $pdo;

    $today = date('Y-m-d');

    $res_today = $pdo->query("SELECT COUNT(*) FROM reservations WHERE DATE(date_reservation) = '$today'")->fetchColumn();
    $total_voyages = $pdo->query("SELECT COUNT(*) FROM voyages")->fetchColumn();
    $total_hotels  = $pdo->query("SELECT COUNT(*) FROM hotels")->fetchColumn();
    $total_users   = $pdo->query("SELECT COUNT(*) FROM utilisateurs")->fetchColumn();

    // Réservations des 6 derniers mois pour le graphique
    $chart_data = $pdo->query("
        SELECT DATE_FORMAT(date_reservation,'%b %Y') as mois,
               COUNT(*) as total
        FROM reservations
        WHERE date_reservation >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
        GROUP BY YEAR(date_reservation), MONTH(date_reservation)
        ORDER BY date_reservation ASC
    ")->fetchAll();

    // Répartition des statuts pour le camembert
    $statuts = $pdo->query("
        SELECT statut, COUNT(*) as total
        FROM reservations
        GROUP BY statut
    ")->fetchAll();

    respond([
        'reservations_today' => (int)$res_today,
        'total_voyages'      => (int)$total_voyages,
        'total_hotels'       => (int)$total_hotels,
        'total_utilisateurs' => (int)$total_users,
        'chart_data'         => $chart_data,
        'statuts'            => $statuts,
    ]);
}

// ─── VOYAGES ───────────────────────────────────────
if ($action === 'get_voyages') {
    respond(['data' => $pdo->query("SELECT * FROM voyages ORDER BY created_at DESC")->fetchAll()]);
}

if ($action === 'add_voyage' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO voyages (nom, destination, date_depart, prix, nb_personnes, description) VALUES (?,?,?,?,?,?)");
    $stmt->execute([
        trim($_POST['nom']), trim($_POST['destination']),
        $_POST['date_depart'], (float)$_POST['prix'],
        (int)$_POST['nb_personnes'], trim($_POST['description'] ?? '')
    ]);
    respond(['success' => true, 'id' => $pdo->lastInsertId()]);
}

if ($action === 'edit_voyage' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE voyages SET nom=?, destination=?, date_depart=?, prix=?, nb_personnes=?, description=? WHERE id=?");
    $stmt->execute([
        trim($_POST['nom']), trim($_POST['destination']),
        $_POST['date_depart'], (float)$_POST['prix'],
        (int)$_POST['nb_personnes'], trim($_POST['description'] ?? ''),
        (int)$_POST['id']
    ]);
    respond(['success' => true]);
}

if ($action === 'delete_voyage' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo->prepare("DELETE FROM voyages WHERE id=?")->execute([(int)$_POST['id']]);
    respond(['success' => true]);
}

// ─── HÔTELS ────────────────────────────────────────
if ($action === 'get_hotels') {
    respond(['data' => $pdo->query("SELECT * FROM hotels ORDER BY created_at DESC")->fetchAll()]);
}

if ($action === 'add_hotel' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO hotels (nom, ville, etoiles, prix_nuit, nb_chambres, description) VALUES (?,?,?,?,?,?)");
    $stmt->execute([
        trim($_POST['nom']), trim($_POST['ville']),
        (int)$_POST['etoiles'], (float)$_POST['prix_nuit'],
        (int)$_POST['nb_chambres'], trim($_POST['description'] ?? '')
    ]);
    respond(['success' => true, 'id' => $pdo->lastInsertId()]);
}

if ($action === 'edit_hotel' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE hotels SET nom=?, ville=?, etoiles=?, prix_nuit=?, nb_chambres=?, description=? WHERE id=?");
    $stmt->execute([
        trim($_POST['nom']), trim($_POST['ville']),
        (int)$_POST['etoiles'], (float)$_POST['prix_nuit'],
        (int)$_POST['nb_chambres'], trim($_POST['description'] ?? ''),
        (int)$_POST['id']
    ]);
    respond(['success' => true]);
}

if ($action === 'delete_hotel' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo->prepare("DELETE FROM hotels WHERE id=?")->execute([(int)$_POST['id']]);
    respond(['success' => true]);
}

// ─── RÉSERVATIONS ──────────────────────────────────
if ($action === 'get_reservations') {
    $data = $pdo->query("
        SELECT r.*, v.nom AS voyage_nom, h.nom AS hotel_nom
        FROM reservations r
        LEFT JOIN voyages v ON r.voyage_id = v.id
        LEFT JOIN hotels  h ON r.hotel_id  = h.id
        ORDER BY r.date_reservation DESC
    ")->fetchAll();
    respond(['data' => $data]);
}

if ($action === 'add_reservation' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO reservations (client_nom, utilisateur_id, voyage_id, hotel_id, nb_personnes, statut) VALUES (?,?,?,?,?,?)");
    $stmt->execute([
        trim($_POST['client_nom']),
        (int)$_POST['utilisateur_id'] ?: null,
        (int)$_POST['voyage_id'],
        (int)$_POST['hotel_id'],
        (int)$_POST['nb_personnes'],
        $_POST['statut'] ?? 'En attente'
    ]);
    respond(['success' => true, 'id' => $pdo->lastInsertId()]);
}

if ($action === 'edit_reservation' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE reservations SET client_nom=?, voyage_id=?, hotel_id=?, nb_personnes=?, statut=? WHERE id=?");
    $stmt->execute([
        trim($_POST['client_nom']),
        (int)$_POST['voyage_id'],
        (int)$_POST['hotel_id'],
        (int)$_POST['nb_personnes'],
        $_POST['statut'],
        (int)$_POST['id']
    ]);
    respond(['success' => true]);
}

if ($action === 'delete_reservation' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo->prepare("DELETE FROM reservations WHERE id=?")->execute([(int)$_POST['id']]);
    respond(['success' => true]);
}

// ─── UTILISATEURS ──────────────────────────────────
if ($action === 'get_utilisateurs') {
    respond(['data' => $pdo->query("SELECT id,nom,email,role,date_inscription FROM utilisateurs ORDER BY created_at DESC")->fetchAll()]);
}

if ($action === 'add_utilisateur' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $hash = $_POST['mot_de_passe'];
    $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe, role, date_inscription) VALUES (?,?,?,?,?)");
    $stmt->execute([
        trim($_POST['nom']), trim($_POST['email']),
        $hash, $_POST['role'] ?? 'Client', date('Y-m-d')
    ]);
    respond(['success' => true, 'id' => $pdo->lastInsertId()]);
}

if ($action === 'edit_utilisateur' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['mot_de_passe'])) {
        $hash = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE utilisateurs SET nom=?, email=?, mot_de_passe=?, role=? WHERE id=?");
        $stmt->execute([trim($_POST['nom']), trim($_POST['email']), $hash, $_POST['role'], (int)$_POST['id']]);
    } else {
        $stmt = $pdo->prepare("UPDATE utilisateurs SET nom=?, email=?, role=? WHERE id=?");
        $stmt->execute([trim($_POST['nom']), trim($_POST['email']), $_POST['role'], (int)$_POST['id']]);
    }
    respond(['success' => true]);
}

if ($action === 'delete_utilisateur' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo->prepare("DELETE FROM utilisateurs WHERE id=?")->execute([(int)$_POST['id']]);
    respond(['success' => true]);
}

// ─── PARAMÈTRES ────────────────────────────────────
if ($action === 'get_parametres') {
    $rows = $pdo->query("SELECT cle, valeur FROM parametres")->fetchAll();
    $params = [];
    foreach ($rows as $r) $params[$r['cle']] = $r['valeur'];
    respond(['data' => $params]);
}

if ($action === 'save_parametres' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $keys = ['site_name','langue','devise','fuseau_horaire','deux_facteurs','alertes_connexion',
             'duree_session','email_nouvelle_reservation','email_nouvel_utilisateur',
             'rapport_quotidien','email_notification'];
    $stmt = $pdo->prepare("INSERT INTO parametres (cle, valeur) VALUES (?,?) ON DUPLICATE KEY UPDATE valeur=VALUES(valeur)");
    foreach ($keys as $key) {
        if (isset($_POST[$key])) {
            $stmt->execute([$key, $_POST[$key]]);
        }
    }
    respond(['success' => true]);
}

// ─── SELECT LISTS (for reservation modal) ──────────
if ($action === 'lists') {
    $voyages = $pdo->query("SELECT id, nom FROM voyages ORDER BY nom")->fetchAll();
    $hotels  = $pdo->query("SELECT id, nom FROM hotels ORDER BY nom")->fetchAll();
    $users   = $pdo->query("SELECT id, nom FROM utilisateurs ORDER BY nom")->fetchAll();
    respond(['voyages' => $voyages, 'hotels' => $hotels, 'utilisateurs' => $users]);
}

respond(['error' => 'Action inconnue : ' . $action]);
