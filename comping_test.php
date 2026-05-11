<?php include 'db_comping.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Camping - Séjours & Aventures</title>
  
  <link rel="stylesheet" href="css/style1.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azurG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>

  <!-- En-tête -->
  <header>
    <div id="menu-bar" class="fas fa-bars"></div>
    <a href="#" class="logo"><span>V</span>oyages</a>
    <nav class="navbar">
        <a href="index.html#accueil">accueil</a>
        <a href="index.html#forfait">forfaits camping</a>
        <a href="index.html#service">services</a>
        <a href="index.html#galerie">galerie</a>
        <a href="index.html#avis">avis</a>
        <a href="index.html#reserver">reserver</a>
        <a href="index.html#contact">contact</a>
    </nav>
    <div class="icons">
        <i class="fas fa-search" id="search-btn"></i>
        <a href="Login.php"><i class="fas fa-user" id="login-btn"></i></a>
    </div>
    <form action="" class="search-bar-container">
        <input type="search" id="search-bar" placeholder="rechercher un séjour camping..." />
        <label for="search-bar" class="fas fa-search"></label>
    </form>
  </header>

  <!---- Login form 
  <div class="login-form-container">
    <i class="fas fa-times" id="form-close"></i>
    <form action="">
        <h3>login</h3>
        <input type="email" class="box" placeholder="entrer votre email">
        <input type="password" class="box" placeholder="entrer votre mot de passe">
        <input type="submit" value="login maintenant" class="btn">
        <input type="checkbox" id="remember">
        <label for="remember">remember me</label>
        <p>forget password? <a href="#">click here</a></p>
        <p>don't have an account? <a href="#">register now</a></p>
    </form>
  </div>-->

  <!-- HERO BANNER -->
  <section class="hero" style="background: url('image/co.jpg') center center / cover no-repeat;">
    <div class="hero-overlay"></div>
    <div class="hero-content">
      <h1>CAMPING</h1>
      <h2>Séjours Camping & Aventures en Pleine Nature</h2>
      <p>Des nuits sous les étoiles, des forêts verdoyantes et des paysages sauvages : découvrez nos séjours camping organisés avec encadrement professionnel.</p>
    </div>
  </section>

  <!-- CONTENU PRINCIPAL -->
  <main class="main-container">

    <!-- FILTRES LATERAUX -->
    <aside class="filters">
      <h3 class="filters-title">FILTERS</h3>

      <!-- Prix -->
      <div class="filter-group">
        <label class="filter-label">Budget</label>
        <span class="filter-sublabel">Plage de prix</span>
        <input type="range" class="range-slider" id="priceRange" min="80" max="2500" value="2500" />
        <div class="range-labels">
          <span>80 DT</span>
          <span>2500 DT</span>
        </div>
        <div class="range-current" id="priceCurrent">≤ 2500 DT</div>
        <div class="range-steps">
          <span>80</span>
          <span>500</span>
          <span>1000</span>
          <span>1500</span>
          <span>2000</span>
          <span>2500</span>
        </div>
      </div>

      <!-- Types de séjours (réutilise la logique "wilaya") -->
      <div class="filter-group">
        <label class="filter-label">Type de séjour</label>
        <div class="select-wrapper">
          <select class="filter-select" id="locationSelect">
            <option value="">Tous les types</option>
            <option value="tunis">Montagne</option>
            <option value="sousse">Plage</option>
            <option value="djerba">Famille</option>
            <option value="tozeur">Désert</option>
            <option value="jendouba">Forêt</option>
            <option value="sfax">Aventure</option>
            <option value="monastir">Luxe</option>
            <option value="nabeul">Groupe</option>
            <option value="gabes">Jeunes</option>
            <option value="kairouan">Seniors</option>
          </select>
        </div>
        <div class="checkbox-group">
          <label class="checkbox-item">
            <input type="checkbox" id="wilayaAll" checked /> Tous
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="tunis" /> Montagne
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="sousse" /> Plage
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="tozeur" /> Désert
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="jendouba" /> Forêt
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="sfax" /> Aventure
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="monastir" /> Luxe
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="nabeul" /> Groupe
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="djerba" /> Famille
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="gabes" /> Jeunes
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="kairouan" /> Seniors
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="other" /> Autres...
          </label>
        </div>
      </div>

      <!-- Etoiles -->
      <div class="filter-group">
        <label class="filter-label">Confort du camp</label>
        <div class="checkbox-group">
          <label class="checkbox-item">
            <input type="checkbox" id="starsAll" checked /> Tous
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="stars3" /> Standard
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="stars4" /> Confort
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="stars5" /> Premium
          </label>
        </div>
      </div>
    </aside>

    <!-- FORFAITS CAMPING -->
    <section class="packages" id="forfait">
      <div class="packages-header">
        <h3 class="packages-title">NOS SÉJOURS CAMPING</h3>
        <button class="packages-all-btn" id="showAllPackagesBtn">
          <i class="fas fa-layer-group"></i>
          <span>Tous</span>
        </button>
      </div>

      <main class="main-container">
    <section class="packages" id="forfait">
      <h3 class="packages-title">NOS SÉJOURS DYNAMIQUES</h3>
      <div class="packages-grid">

        <?php
        // On récupère les données de la base
        $query = $conn->query("SELECT * FROM forfaits");
        while($row = $query->fetch(PDO::FETCH_ASSOC)):
        ?>
        <div class="package-card" data-wilaya="<?php echo $row['type_sejour']; ?>">
          <div class="card-image-wrapper">
            <?php if($row['badge']): ?>
                <span class="card-badge"><?php echo $row['badge']; ?></span>
            <?php endif; ?>
            
            <?php if($row['is_video']): ?>
                <video class="card-image" autoplay muted loop>
                    <source src="<?php echo $row['image_url']; ?>" type="video/mp4">
                </video>
            <?php else: ?>
                <img src="<?php echo $row['image_url']; ?>" class="card-image">
            <?php endif; ?>
          </div>

          <div class="card-body">
            <h4 class="card-title"><?php echo $row['titre']; ?></h4>
            <p class="card-location">📍 <?php echo $row['emplacement']; ?></p>
            <div class="card-meta">
              <span>🗓 <?php echo $row['duree']; ?></span>
              <span class="card-price"><?php echo $row['prix']; ?> DT</span>
            </div>
            <div class="card-stars">
                <?php for($i=1; $i<=5; $i++) echo ($i <= $row['etoiles']) ? '★' : '☆'; ?>
            </div>
            <button class="btn-reserver">Réserver</button>
          </div>
        </div>
        <?php endwhile; ?>

      </div>
    </section>
  </main>
    </section>
  </main>
    
  <script>
  let menu = document.querySelector('#menu-bar');
  let navbar = document.querySelector('.navbar');
  let searchBtn = document.querySelector('#search-btn');
  let searchBar = document.querySelector('.search-bar-container');
  let formBtn = document.querySelector('#login-btn');
  let formClose = document.querySelector('#form-close');
  let loginForm = document.querySelector('.login-form-container');

  menu.addEventListener('click', () =>{
      menu.classList.toggle('fa-times');
      navbar.classList.toggle('active');
  });

  searchBtn.addEventListener('click', () =>{
      searchBtn.classList.toggle('fa-times');
      searchBar.classList.toggle('active');
  });

  formBtn.addEventListener('click', () =>{
      loginForm.classList.add('active');
  });
  formClose.addEventListener('click', () =>{
      loginForm.classList.remove('active');
  });
  </script>

  <script src="js/tunisie.js"></script>

  <!-- Footer -->
  <section class="footer" id="contact">
    <div class="box-container">
        <div class="box">
            <h3>À propos de nous</h3>
            <p>Agence spécialisée dans l’organisation de séjours camping & aventures nature, au départ de différentes villes de Tunisie.</p>
        </div>
        <div class="box">
            <h3>nos agences</h3>
            <a href="#">Tunis</a>
            <a href="#">Sousse</a>
            <a href="#">Sfax</a>
            <a href="#">Gabès</a>
        </div>
        <div class="box">
          <h3>liens rapides </h3>
          <a href="index.html#accueil">Accueil</a>
          <a href="index.html#forfait">Forfait</a>
          <a href="index.html#service">Service</a>
          <a href="index.html#galerie">Galerie</a>
          <a href="index.html#avis">Avis</a>
          <a href="index.html#reserver">Réserver</a>
          <a href="index.html#contact">Contact</a>
        </div>
        <div class="box">
            <h3>contactez-nous</h3>
            
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
            <h5>Email : camping@traveltourisme.com</h5>
            <h5>phone : +216 71 000 001</h5>
            <h5>Adresse : 15, Avenue des Aventuriers, Tunis</h5>
        </div>
    </div>
    <h1 class="credit"> 2025/2026  créer par | <span>yassmine ben hmida</span> | </h1>
  </section>

</body>
</html>

