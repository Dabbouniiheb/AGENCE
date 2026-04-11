<?php
// ============================================================
//  api.php — Endpoint AJAX (JSON) pour toutes les opérations CRUD
// ============================================================
require_once 'auth.php';
require_once 'db.php';

requireLogin();

header('Content-Type: application/json; charset=utf-8');

$action = $_REQUEST['action'] ?? '';
$entity = $_REQUEST['entity'] ?? '';

// Lire le body JSON si envoyé en application/json
$jsonBody = [];
$raw = file_get_contents('php://input');
if ($raw) {
    $decoded = json_decode($raw, true);
    if (is_array($decoded)) $jsonBody = $decoded;
}

// Fusionner POST + JSON body
$INPUT = array_merge($_POST, $_GET, $jsonBody);

$db = getDB();

// ---------- helper : réponse JSON ----------
function ok($data = [], string $msg = 'Succès'): void {
    echo json_encode(['success' => true, 'message' => $msg, 'data' => $data]);
    exit;
}
function fail(string $msg = 'Erreur'): void {
    echo json_encode(['success' => false, 'message' => $msg]);
    exit;
}
function sanitize(string $v): string { return htmlspecialchars(trim($v), ENT_QUOTES); }

// ============================================================
//  VOYAGES
// ============================================================
if ($entity === 'voyage') {

    if ($action === 'list') {
        $rows = $db->query("SELECT * FROM voyages ORDER BY id DESC")->fetchAll();
        ok($rows);
    }

    if ($action === 'add') {
        $nom    = sanitize($_POST['nom'] ?? '');
        $dest   = sanitize($_POST['destination'] ?? '');
        $date   = $_POST['date_depart'] ?? '';
        $prix   = floatval($_POST['prix'] ?? 0);
        $pers   = intval($_POST['nb_personnes'] ?? 1);
        $desc   = sanitize($_POST['description'] ?? '');

        if (!$nom || !$dest || !$date) fail('Champs obligatoires manquants.');

        $stmt = $db->prepare("INSERT INTO voyages (nom,destination,date_depart,prix,nb_personnes,description) VALUES (?,?,?,?,?,?)");
        $stmt->execute([$nom,$dest,$date,$prix,$pers,$desc]);
        ok(['id' => $db->lastInsertId()], 'Voyage ajouté avec succès.');
    }

    if ($action === 'get') {
        $id   = intval($_GET['id'] ?? 0);
        $stmt = $db->prepare("SELECT * FROM voyages WHERE id = ?");
        $stmt->execute([$id]);
        $row  = $stmt->fetch();
        if (!$row) fail('Voyage introuvable.');
        ok($row);
    }

    if ($action === 'edit') {
        $id   = intval($_POST['id'] ?? 0);
        $nom  = sanitize($_POST['nom'] ?? '');
        $dest = sanitize($_POST['destination'] ?? '');
        $date = $_POST['date_depart'] ?? '';
        $prix = floatval($_POST['prix'] ?? 0);
        $pers = intval($_POST['nb_personnes'] ?? 1);
        $desc = sanitize($_POST['description'] ?? '');

        if (!$id || !$nom || !$dest || !$date) fail('Champs obligatoires manquants.');

        $stmt = $db->prepare("UPDATE voyages SET nom=?,destination=?,date_depart=?,prix=?,nb_personnes=?,description=? WHERE id=?");
        $stmt->execute([$nom,$dest,$date,$prix,$pers,$desc,$id]);
        ok([], 'Voyage modifié avec succès.');
    }

    if ($action === 'delete') {
        $id = intval($INPUT['id'] ?? 0);
        if (!$id) fail('ID invalide.');
        $db->prepare("DELETE FROM voyages WHERE id=?")->execute([$id]);
        ok([], 'Voyage supprimé.');
    }
}

// ============================================================
//  HOTELS
// ============================================================
if ($entity === 'hotel') {

    if ($action === 'list') {
        $rows = $db->query("SELECT * FROM hotels ORDER BY id DESC")->fetchAll();
        ok($rows);
    }

    if ($action === 'add') {
        $nom    = sanitize($_POST['nom'] ?? '');
        $ville  = sanitize($_POST['ville'] ?? '');
        $etoil  = intval($_POST['etoiles'] ?? 3);
        $prix   = floatval($_POST['prix_nuit'] ?? 0);
        $chamb  = intval($_POST['nb_chambres'] ?? 1);
        $desc   = sanitize($_POST['description'] ?? '');

        if (!$nom || !$ville) fail('Champs obligatoires manquants.');

        $stmt = $db->prepare("INSERT INTO hotels (nom,ville,etoiles,prix_nuit,nb_chambres,description) VALUES (?,?,?,?,?,?)");
        $stmt->execute([$nom,$ville,$etoil,$prix,$chamb,$desc]);
        ok(['id' => $db->lastInsertId()], 'Hôtel ajouté avec succès.');
    }

    if ($action === 'get') {
        $id   = intval($_GET['id'] ?? 0);
        $stmt = $db->prepare("SELECT * FROM hotels WHERE id = ?");
        $stmt->execute([$id]);
        $row  = $stmt->fetch();
        if (!$row) fail('Hôtel introuvable.');
        ok($row);
    }

    if ($action === 'edit') {
        $id    = intval($_POST['id'] ?? 0);
        $nom   = sanitize($_POST['nom'] ?? '');
        $ville = sanitize($_POST['ville'] ?? '');
        $etoil = intval($_POST['etoiles'] ?? 3);
        $prix  = floatval($_POST['prix_nuit'] ?? 0);
        $chamb = intval($_POST['nb_chambres'] ?? 1);
        $desc  = sanitize($_POST['description'] ?? '');

        if (!$id || !$nom || !$ville) fail('Champs obligatoires manquants.');

        $stmt = $db->prepare("UPDATE hotels SET nom=?,ville=?,etoiles=?,prix_nuit=?,nb_chambres=?,description=? WHERE id=?");
        $stmt->execute([$nom,$ville,$etoil,$prix,$chamb,$desc,$id]);
        ok([], 'Hôtel modifié avec succès.');
    }

    if ($action === 'delete') {
        $id = intval($INPUT['id'] ?? 0);
        if (!$id) fail('ID invalide.');
        // Mettre hotel_id à NULL dans reservations avant suppression
        $db->prepare("UPDATE reservations SET hotel_id=NULL WHERE hotel_id=?")->execute([$id]);
        $db->prepare("DELETE FROM hotels WHERE id=?")->execute([$id]);
        ok([], 'Hôtel supprimé.');
    }
}

// ============================================================
//  UTILISATEURS
// ============================================================
if ($entity === 'utilisateur') {

    if ($action === 'list') {
        $rows = $db->query("SELECT id,nom,email,role,date_inscription FROM utilisateurs ORDER BY id DESC")->fetchAll();
        ok($rows);
    }

    if ($action === 'add') {
        $nom   = sanitize($_POST['nom'] ?? '');
        $email = sanitize($_POST['email'] ?? '');
        $role  = in_array($_POST['role'] ?? '', ['Admin','Client']) ? $_POST['role'] : 'Client';
        $pass  = $_POST['mot_de_passe'] ?? '';
        $date  = date('Y-m-d');

        if (!$nom || !$email || !$pass) fail('Champs obligatoires manquants.');

        // Vérifier doublon email
        $chk = $db->prepare("SELECT id FROM utilisateurs WHERE email=?");
        $chk->execute([$email]);
        if ($chk->fetch()) fail('Cet email est déjà utilisé.');

        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO utilisateurs (nom,email,mot_de_passe,role,date_inscription) VALUES (?,?,?,?,?)");
        $stmt->execute([$nom,$email,$hash,$role,$date]);
        ok(['id' => $db->lastInsertId()], 'Utilisateur ajouté.');
    }

    if ($action === 'get') {
        $id   = intval($_GET['id'] ?? 0);
        $stmt = $db->prepare("SELECT id,nom,email,role,date_inscription FROM utilisateurs WHERE id=?");
        $stmt->execute([$id]);
        $row  = $stmt->fetch();
        if (!$row) fail('Utilisateur introuvable.');
        ok($row);
    }

    if ($action === 'edit') {
        $id    = intval($_POST['id'] ?? 0);
        $nom   = sanitize($_POST['nom'] ?? '');
        $email = sanitize($_POST['email'] ?? '');
        $role  = in_array($_POST['role'] ?? '', ['Admin','Client']) ? $_POST['role'] : 'Client';
        $pass  = $_POST['mot_de_passe'] ?? '';

        if (!$id || !$nom || !$email) fail('Champs obligatoires manquants.');

        if ($pass) {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $stmt = $db->prepare("UPDATE utilisateurs SET nom=?,email=?,role=?,mot_de_passe=? WHERE id=?");
            $stmt->execute([$nom,$email,$role,$hash,$id]);
        } else {
            $stmt = $db->prepare("UPDATE utilisateurs SET nom=?,email=?,role=? WHERE id=?");
            $stmt->execute([$nom,$email,$role,$id]);
        }
        ok([], 'Utilisateur modifié.');
    }

    if ($action === 'delete') {
        $id = intval($INPUT['id'] ?? 0);
        if (!$id) fail('ID invalide.');
        if ($id === (int)$_SESSION['admin_id']) fail('Impossible de supprimer votre propre compte.');
        // Mettre utilisateur_id à NULL dans reservations avant suppression
        $db->prepare("UPDATE reservations SET utilisateur_id=NULL WHERE utilisateur_id=?")->execute([$id]);
        $db->prepare("DELETE FROM utilisateurs WHERE id=?")->execute([$id]);
        ok([], 'Utilisateur supprimé.');
    }
}

// ============================================================
//  RESERVATIONS
// ============================================================
if ($entity === 'reservation') {

    if ($action === 'list') {
        $sql = "SELECT r.id, r.client_nom, r.nb_personnes, r.statut, r.created_at,
                       v.nom AS voyage_nom, h.nom AS hotel_nom, u.nom AS utilisateur_nom
                FROM reservations r
                LEFT JOIN voyages v ON v.id = r.voyage_id
                LEFT JOIN hotels  h ON h.id = r.hotel_id
                LEFT JOIN utilisateurs u ON u.id = r.utilisateur_id
                ORDER BY r.id DESC";
        $rows = $db->query($sql)->fetchAll();
        ok($rows);
    }

    if ($action === 'add') {
        $client  = sanitize($_POST['client_nom'] ?? '');
        $uid     = intval($_POST['utilisateur_id'] ?? 0) ?: null;
        $vid     = intval($_POST['voyage_id'] ?? 0) ?: null;
        $hid     = intval($_POST['hotel_id'] ?? 0) ?: null;
        $pers    = intval($_POST['nb_personnes'] ?? 1);
        $statut  = in_array($_POST['statut'] ?? '', ['En attente','Confirmé','Annulé']) ? $_POST['statut'] : 'En attente';

        if (!$client) fail('Nom du client requis.');

        $stmt = $db->prepare("INSERT INTO reservations (client_nom,utilisateur_id,voyage_id,hotel_id,nb_personnes,statut) VALUES (?,?,?,?,?,?)");
        $stmt->execute([$client,$uid,$vid,$hid,$pers,$statut]);
        ok(['id' => $db->lastInsertId()], 'Réservation ajoutée.');
    }

    if ($action === 'get') {
        $id   = intval($_GET['id'] ?? 0);
        $stmt = $db->prepare("SELECT * FROM reservations WHERE id=?");
        $stmt->execute([$id]);
        $row  = $stmt->fetch();
        if (!$row) fail('Réservation introuvable.');
        ok($row);
    }

    if ($action === 'edit') {
        $id     = intval($_POST['id'] ?? 0);
        $client = sanitize($_POST['client_nom'] ?? '');
        $uid    = intval($_POST['utilisateur_id'] ?? 0) ?: null;
        $vid    = intval($_POST['voyage_id'] ?? 0) ?: null;
        $hid    = intval($_POST['hotel_id'] ?? 0) ?: null;
        $pers   = intval($_POST['nb_personnes'] ?? 1);
        $statut = in_array($_POST['statut'] ?? '', ['En attente','Confirmé','Annulé']) ? $_POST['statut'] : 'En attente';

        if (!$id || !$client) fail('Champs obligatoires manquants.');

        $stmt = $db->prepare("UPDATE reservations SET client_nom=?,utilisateur_id=?,voyage_id=?,hotel_id=?,nb_personnes=?,statut=? WHERE id=?");
        $stmt->execute([$client,$uid,$vid,$hid,$pers,$statut,$id]);
        ok([], 'Réservation modifiée.');
    }

    if ($action === 'delete') {
        $id = intval($INPUT['id'] ?? 0);
        if (!$id) fail('ID invalide.');
        $db->prepare("DELETE FROM reservations WHERE id=?")->execute([$id]);
        ok([], 'Réservation supprimée.');
    }
}

// ============================================================
//  DASHBOARD STATS
// ============================================================
if ($entity === 'stats') {
    $reservationsAuj = $db->query("SELECT COUNT(*) FROM reservations WHERE DATE(created_at)=CURDATE()")->fetchColumn();
    $totalVoyages    = $db->query("SELECT COUNT(*) FROM voyages")->fetchColumn();
    $totalHotels     = $db->query("SELECT COUNT(*) FROM hotels")->fetchColumn();
    $totalUsers      = $db->query("SELECT COUNT(*) FROM utilisateurs")->fetchColumn();

    $dernReservations = $db->query("
        SELECT r.client_nom, v.nom AS voyage_nom, h.nom AS hotel_nom, r.nb_personnes, r.statut
        FROM reservations r
        LEFT JOIN voyages v ON v.id = r.voyage_id
        LEFT JOIN hotels  h ON h.id = r.hotel_id
        ORDER BY r.id DESC LIMIT 10
    ")->fetchAll();

    ok([
        'reservations_auj'  => $reservationsAuj,
        'total_voyages'     => $totalVoyages,
        'total_hotels'      => $totalHotels,
        'total_users'       => $totalUsers,
        'dern_reservations' => $dernReservations,
    ]);
}

// ============================================================
//  PARAMETRES
// ============================================================
if ($entity === 'parametres') {
    if ($action === 'get') {
        $rows = $db->query("SELECT cle,valeur FROM parametres")->fetchAll();
        $params = [];
        foreach ($rows as $r) $params[$r['cle']] = $r['valeur'];
        ok($params);
    }

    if ($action === 'save') {
        $allowed = ['site_nom','langue','devise','fuseau','two_factor','login_alerts',
                    'session_timeout','email_reservation','email_new_user','email_rapport','email_notif'];
        foreach ($allowed as $cle) {
            if (isset($_POST[$cle])) {
                $val  = sanitize($_POST[$cle]);
                $stmt = $db->prepare("INSERT INTO parametres (cle,valeur) VALUES (?,?) ON DUPLICATE KEY UPDATE valeur=?");
                $stmt->execute([$cle,$val,$val]);
            }
        }
        ok([], 'Paramètres enregistrés.');
    }
}

// ============================================================
//  LISTES pour selects (voyages + hotels + utilisateurs)
// ============================================================
if ($entity === 'selects') {
    $voyages = $db->query("SELECT id,nom FROM voyages ORDER BY nom")->fetchAll();
    $hotels  = $db->query("SELECT id,nom FROM hotels ORDER BY nom")->fetchAll();
    $users   = $db->query("SELECT id,nom FROM utilisateurs ORDER BY nom")->fetchAll();
    ok(['voyages' => $voyages, 'hotels' => $hotels, 'utilisateurs' => $users]);
}

fail('Action ou entité inconnue.');
