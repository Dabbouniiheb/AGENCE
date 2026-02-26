<?php
if (!isset($current_page)) $current_page = 'index';
$nav_base = ($current_page === 'tunisie') ? 'index.php' : '';
?>
    <!--debut de la section footer-->
    <section class="footer">
        <div class="box-container">
            <div class="box">
                <h3>a propos de nous</h3>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quaerat 
                quisquam officia magni adipisci accusamus a excepturi quasi error quia cumque.</p> 
            </div>
            <div class="box">
                <h3>emplacement de la succursale</h3>
                <a href="#">india</a>
                <a href="#">USA</a>
                <a href="#">japan</a>
                <a href="#">france</a>
            </div>
            <div class="box">
            <h3>liens rapides </h3>
            <a href="<?php echo $nav_base ? $nav_base . '#accueil' : '#accueil'; ?>">accueil</a>
            <a href="<?php echo $nav_base ? $nav_base . '#forfait' : '#forfait'; ?>">forfait</a>
            <a href="<?php echo $nav_base ? $nav_base . '#service' : '#service'; ?>">service</a>
            <a href="<?php echo $nav_base ? $nav_base . '#galerie' : '#galerie'; ?>">galerie</a>
            <a href="<?php echo $nav_base ? $nav_base . '#avis' : '#avis'; ?>">avis</a>
            <a href="<?php echo $nav_base ? $nav_base . '#reserver' : '#reserver'; ?>">reserver</a>
            <a href="<?php echo $nav_base ? $nav_base . '#contact' : '#contact'; ?>">contact</a>
            </div>
            <div class="box">
                <h3>contact-nous</h3>
                
                <a href="https://www.facebook.com/voyage" target="_blank">
                <img src="image/facebook.png" alt="Facebook" width="20rem" height="20rem" /> Facebook
                </a>
                <a href="https://www.instagram.com/voyage" target="_blank">
                <img src="image/instagrame.avif" alt="Instagram" width="20rem" height="20rem" /> Instagram
                </a>
                <a href="https://x.com/voyage" target="_blank">
                <img src="image/twitter.avif" alt="twitter" width="20rem" height="20rem"/> twitter
                </a>
                <a href="https://www.linkedin.com/in/voyage" target="_blank">
                <img src="image/linkedin.webp" alt="LinkedIn" width="20rem" height="20rem" /> LinkedIn
                </a>
                <h5>Email : info@traveltourisme.com</h5>
                <h5>phone : +1234 567 890</h5>
                <h5>Adress : 123 Travel street,tourism city</h5>
            </div>
        </div>
        <h1 class="credit"> 2025/2026  créer par | <span>yassmine ben hmida</span> | </h1>
    </section>
    <!--fin de la section footer-->
