<?php
session_start();
include('L_config.php');

$error = "";
$success = "";

// --- LOGIQUE DE CONNEXION (SIGN IN) ---
if (isset($_POST['login'])) {
    // Nettoyage de l'email
    $email = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password'];

    // Requête préparée pour éviter l'Injection SQL
    $stmt = mysqli_prepare($conn, "SELECT id, nom, password, role FROM utilisateurs WHERE email=?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Vérification du mot de passe (ATTENTION: ne marche qu'avec des mots de passe fraîchement inscrits et hashés)
        if (password_verify($password, $row['password']) || $password === $row['password'] /* fallback en attendant la migration totale */) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['nom'] = $row['nom'];
            $_SESSION['role'] = $row['role'];

            // Modification: on redirige vers index.php, pas index.html
            if ($row['role'] === 'admin' || $row['role'] === 'Admin') {
                header("Location: index1.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $error = "Mot de passe incorrect !";
        }
    } 
    else {
        $error = "Email introuvable !";
    }
    mysqli_stmt_close($stmt);
}

// --- LOGIQUE D'INSCRIPTION (SIGN UP) ---
if (isset($_POST['register'])) {
    // Nettoyage stricte
    $nom = htmlspecialchars(trim($_POST['nom']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password'];
    
    // Hachage ultra-sécurisé du mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Vérifier si l'email existe déjà avec requête préparée
    $stmtCheck = mysqli_prepare($conn, "SELECT email FROM utilisateurs WHERE email=?");
    mysqli_stmt_bind_param($stmtCheck, "s", $email);
    mysqli_stmt_execute($stmtCheck);
    mysqli_stmt_store_result($stmtCheck);
    
    if (mysqli_stmt_num_rows($stmtCheck) > 0) {
        $error = "Cet email est déjà utilisé !";
    } else {
        // Insertion sécurisée du nouvel utilisateur (empêche l'injection SQL)
        $stmtInsert = mysqli_prepare($conn, "INSERT INTO utilisateurs (nom, email, password, role) VALUES (?, ?, ?, 'client')");
        mysqli_stmt_bind_param($stmtInsert, "sss", $nom, $email, $hashed_password);
        
        if (mysqli_stmt_execute($stmtInsert)) {
            $success = "Compte créé avec succès ! Vous pouvez maintenant vous connecter.";
        } else {
            $error = "Erreur système lors de l'inscription.";
        }
        mysqli_stmt_close($stmtInsert);
    }
    mysqli_stmt_close($stmtCheck);
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