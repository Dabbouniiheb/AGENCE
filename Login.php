<?php
// ============================================
// login.php — Page de connexion
// ============================================
session_start();

// Connexion dédiée à la base demandée (phpMyAdmin: voyage_db1)
$conn = mysqli_connect("localhost", "root", "", "voyage_db1");
if (!$conn) {
    die("Connexion échouée: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8mb4");

// Compatibilité: priorité à `utilisateur` (demandé), fallback `utilisateurs`
$table = "utilisateur";
$tableCheck = mysqli_query($conn, "SHOW TABLES LIKE 'utilisateur'");
if (!$tableCheck || mysqli_num_rows($tableCheck) === 0) {
    $table = "utilisateurs";
}

$success = "";
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (isset($_POST['register'])) {
        $nom = trim($_POST['nom'] ?? '');

        if ($nom && $email && $password) {
            $checkSql = "SELECT id FROM {$table} WHERE email = ? LIMIT 1";
            $check = mysqli_prepare($conn, $checkSql);
            mysqli_stmt_bind_param($check, "s", $email);
            mysqli_stmt_execute($check);
            $checkResult = mysqli_stmt_get_result($check);

            if ($checkResult && mysqli_fetch_assoc($checkResult)) {
                $error = "Email déjà utilisé.";
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);

                // Colonnes demandées: name/nom, email, password
                $insertSql = "INSERT INTO {$table} (nom, email, password) VALUES (?, ?, ?)";
                $stmt = mysqli_prepare($conn, $insertSql);
                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "sss", $nom, $email, $hash);
                    if (mysqli_stmt_execute($stmt)) {
                        $success = "Compte créé avec succès.";
                    } else {
                        $error = "Erreur lors de l'inscription.";
                    }
                } else {
                    // Fallback si la colonne s'appelle mot_de_passe au lieu de password
                    $insertSql = "INSERT INTO {$table} (nom, email, mot_de_passe) VALUES (?, ?, ?)";
                    $stmt = mysqli_prepare($conn, $insertSql);
                    if ($stmt) {
                        mysqli_stmt_bind_param($stmt, "sss", $nom, $email, $hash);
                        if (mysqli_stmt_execute($stmt)) {
                            $success = "Compte créé avec succès.";
                        } else {
                            $error = "Erreur lors de l'inscription.";
                        }
                    } else {
                        $error = "Structure de table incompatible (colonnes utilisateur).";
                    }
                }
            }
        } else {
            $error = "Veuillez remplir tous les champs.";
        }
    }

    if (isset($_POST['login']) && $email && $password) {
        // Recherche utilisateur par email
        $querySql = "SELECT * FROM {$table} WHERE email = ? LIMIT 1";
        $stmt = mysqli_prepare($conn, $querySql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = $result ? mysqli_fetch_assoc($result) : null;

        $storedHash = '';
        if ($user) {
            if (isset($user['password'])) {
                $storedHash = $user['password'];
            } elseif (isset($user['mot_de_passe'])) {
                $storedHash = $user['mot_de_passe'];
            }
        }

        if ($user && $storedHash && password_verify($password, $storedHash)) {

            // Session utilisateur
            $_SESSION['id'] = $user['id'] ?? null;
            $_SESSION['nom'] = $user['nom'] ?? '';
            $_SESSION['email'] = $user['email'] ?? '';
            $_SESSION['role'] = $user['role'] ?? 'client';

            $role = strtolower(trim((string)($_SESSION['role'] ?? 'client')));
            if ($role === 'admin') {
                $_SESSION['admin_id'] = $_SESSION['id'];
                $_SESSION['admin_nom'] = $_SESSION['nom'];
                $_SESSION['admin_role'] = $_SESSION['role'];
                header('Location: admin.php');
                exit;
            } else {
                $_SESSION['client_id'] = $_SESSION['id'];
                $_SESSION['client_nom'] = $_SESSION['nom'];
                $_SESSION['client_role'] = $_SESSION['role'];
                header('Location: index.html');
                exit;
            }
        } else {
            $error = "Email ou mot de passe incorrect.";
        }
    } elseif (isset($_POST['login'])) {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Agence de Voyage</title>
    <link rel="stylesheet" href="css/style1.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <header class="header">
        <nav class="navbar">
            <a href="#">accueil</a>
            <a href="#">forfait</a>
            <a href="#">service</a>
            <a href="#">galerie</a>
            <a href="#">avis</a>
            <a href="#">reserver</a>
            <a href="#">contact</a>
        </nav>
    </header>

    <div class="background"></div>
    <div class="container">
        <div class="content">
            <h2 class="logo"><i class='bx bxl-firebase'></i>Codehal</h2>
            <div class="text-sci">
                <h2>Welcome! <br><span>To Our New Website.</span></h2>
                <p>Gérez vos réservations de voyages en toute simplicité.</p>
                <div class="social-icons">
                    <a href="#"><i class='bx bxl-linkedin'></i></a>
                    <a href="#"><i class='bx bxl-facebook'></i></a>
                    <a href="#"><i class='bx bxl-instagram'></i></a>
                </div>
            </div>
        </div>
            
        <div class="logreg-box">
            <div class="form-box login">
                <form action="Login.php" method="POST">
                    <h2>Sign In</h2>
                    
                    <?php if($error != ""): ?>
                        <p style="color: #ff4d4d; margin-bottom: 10px; font-weight: bold;"><?php echo $error; ?></p>
                    <?php endif; ?>

                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-envelope'></i></span>
                        <input type="email" name="email" required>
                        <label>Email</label>
                    </div>

                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-lock-alt'></i></span>
                        <input type="password" name="password" required>
                        <label>Password</label>
                    </div>

                    <div class="remember-forgot">
                        <label><input type="checkbox">Remember me</label>
                        <a href="#">Forgot password?</a>
                    </div>

                    <button type="submit" name="login" class="btn">Sign In</button>

                    <div class="login-register">
                        <p>Don't have an account?<a href="#" class="register-link">Sign up</a></p>
                    </div>
                </form>
            </div>

            <div class="form-box register">
    <form action="Login.php" method="POST"> <h2>Sign Up</h2>
        
        <?php if($success != ""): ?>
            <p style="color: #2ecc71; margin-bottom: 10px;"><?php echo $success; ?></p>
        <?php endif; ?>

        <div class="input-box">
            <span class="icon"><i class='bx bxs-user'></i></span>
            <input type="text" name="nom" required> <label>Name</label>
        </div>

        <div class="input-box">
            <span class="icon"><i class='bx bxs-envelope'></i></span>
            <input type="email" name="email" required> <label>Email</label>
        </div>

        <div class="input-box">
            <span class="icon"><i class='bx bxs-lock-alt'></i></span>
            <input type="password" name="password" required> <label>Password</label>
        </div>

        <div class="remember-forgot">
            <label><input type="checkbox" required> Agree to the terms & conditions</label>
        </div>

        <button type="submit" name="register" class="btn">Sign Up</button> <div class="login-register">
            <p>Already have an account? <a href="#" class="login-link">Sign in</a></p>
        </div>
    </form>
</div>
        </div>
    </div>

    <script>
        const logreBox = document.querySelector('.logreg-box');
        const loginLink = document.querySelector('.login-link');
        const registerLink = document.querySelector('.register-link');

        registerLink.addEventListener('click', () => {
            logreBox.classList.add('active');
        });
        loginLink.addEventListener('click', () => {
            logreBox.classList.remove('active');
        });
    </script>
</body>
</html>