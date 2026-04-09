<?php
session_start();
include('L_config.php');

$error = "";

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM utilisateurs WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['nom'] = $row['nom'];
        $_SESSION['role'] = $row['role'];

        if ($row['role'] === 'admin') {
            header("Location: dashboard.html");
        } else {
            header("Location: index.html");
        }
        exit();
    } else {
        $error = "Email ou mot de passe incorrect !";
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
                <form action="login.php" method="POST">
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
                <form action="#">
                    <h2>Sign Up</h2>
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-user'></i></span>
                        <input type="text" required>
                        <label>Name</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-envelope'></i></span>
                        <input type="email" required>
                        <label>Email</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-lock-alt'></i></span>
                        <input type="password" required>
                        <label>Password</label>
                    </div>
                    <button type="submit" class="btn">Sign Up</button>
                    <div class="login-register">
                        <p>Already have an account?<a href="#" class="login-link">Sign in</a></p>
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