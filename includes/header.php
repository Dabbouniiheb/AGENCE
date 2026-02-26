<?php
if (!isset($current_page)) $current_page = 'index';
$nav_base = ($current_page === 'tunisie') ? 'index.php' : '';
?>
    <!--debut de la section d'en-tete-->
    <header>
        <div id="menu-bar" class="fas fa-bars"></div>

        <a href="<?php echo $nav_base ? $nav_base : '#'; ?>" class="logo"><span>V</span>oyages</a>
        <nav class="navbar">
            <a href="<?php echo $nav_base ? $nav_base . '#accueil' : '#accueil'; ?>">accueil</a>
            <a href="<?php echo $nav_base ? $nav_base . '#forfait' : '#forfait'; ?>">forfait</a>
            <a href="<?php echo $nav_base ? $nav_base . '#service' : '#service'; ?>">service</a>
            <a href="<?php echo $nav_base ? $nav_base . '#galerie' : '#galerie'; ?>">galerie</a>
            <a href="<?php echo $nav_base ? $nav_base . '#avis' : '#avis'; ?>">avis</a>
            <a href="<?php echo $nav_base ? $nav_base . '#reserver' : '#reserver'; ?>">reserver</a>
            <a href="<?php echo $nav_base ? $nav_base . '#contact' : '#contact'; ?>">contact</a>
        </nav>
        <div class="icons">
            <i class="fas fa-search" id="search-btn"></i>
            <a href="lindex_login.html">
                <i class="fas fa-user" id="login-btn"></i>
            </a>
        </div>
        <form action="" class="search-bar-container">
            <input type="search" id="search-bar" placeholder="racherche ici...">
            <label for="search-bar" class="fas fa-search"></label>
        </form>
    </header>
    <!--login form container-->
    <div class="login-form-container">

        <i class="fas fa-times" id="form-close"></i>
        <form action="">
            <h3>login</h3>
            <input type="email" class="box" placeholder="entrer votre email">
            <input type="password" class="box" placeholder="entrer votre mode passe">
            <input type="submit" value="login mantenant" class="btn">
            <input type="checkbox" id="remember">
            <label for="remember">remember me</label>
            <p>forget password? <a href="#">click here</a></p>
            <p>don't have and account? <a href="#">register now</a></p>
        </form>
    </div>
