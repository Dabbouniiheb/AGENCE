<?php 
session_start();
include 'omra_config.php'; 
$error = "";
$success = "";
?>
<!DOCTYPE html>
<html lang="fr">
<head>

  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>OMRA - Séjours </title>
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
        <a href="#accueil">accueil</a>
        <a href="#forfait">forfaits camping</a>
        <a href="#service">services</a>
        <a href="#galerie">galerie</a>
        <a href="#avis">avis</a>
        <a href="#reserver">reserver</a>
        <a href="#contact">contact</a>
    </nav>
    <div class="icons">
        <i class="fas fa-search" id="search-btn"></i>
        <a href="login.html">
          <i class="fas fa-user" id="login-btn"></i>
        </a>
    </div>
    <form action="" class="search-bar-container">
        <input type="search" id="search-bar" placeholder="rechercher un séjour camping..." />
        <label for="search-bar" class="fas fa-search"></label>
    </form>
  </header>

  <!-- Login form -->
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
  </div>

  <!-- HERO BANNER -->
  <section class="hero" style="background: url('image/omra/page_principale.jpg') center center / cover no-repeat;">
    <div class="hero-overlay"></div>
    <div class="hero-content">
      <h1>OMRA</h1>
      <h2>Séjours Camping & Aventures en Pleine Nature</h2>
      <p>Des nuits sous les étoiles, des forêts verdoyantes et des paysages sauvages : découvrez nos séjours omra organisés avec encadrement professionnel.</p>
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

      <!-- Types de séjours -->
      <div class="filter-group">
        <label class="filter-label">Type de séjour</label>
        <div class="select-wrapper">
          <select class="filter-select" id="locationSelect">
            <option value="">Tous les types</option>
            <option value="tunis">Économique</option>
            <option value="sousse">Confort</option>
            <option value="djerba">Luxe VIP</option>
            <option value="tozeur">Famille</option>
            <option value="jendouba">Groupe</option>
            <option value="sfax">Express</option>
            <option value="monastir">Spécial Ramadan</option>
          </select>
        </div>
        <div class="checkbox-group">
          <label class="checkbox-item">
            <input type="checkbox" id="wilayaAll" checked /> Tous
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="tunis" /> Économique
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="sousse" /> Confort
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="tozeur" /> Luxe VIP
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="jendouba" /> Famille
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="sfax" /> Groupe
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="monastir" />Express
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="nabeul" /> Spécial Ramadan
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="other" /> Autres...
          </label>
        </div>
      </div>

      <!-- Confort (étoiles) -->
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
    <h3 class="packages-title">NOS OFFRES OMRA</h3>
    <button class="packages-all-btn" id="showAllPackagesBtn">
      <i class="fas fa-layer-group"></i>
      <span>Tous</span>
    </button>
  </div>

  <div class="packages-grid">
  <?php
  $query = $pdo->query("SELECT * FROM forfaits");
  while ($row = $query->fetch(PDO::FETCH_ASSOC)):
      $inclus_items = explode(',', $row['inclus']);
  ?>

  <div class="package-card" data-wilaya="<?php echo htmlspecialchars($row['wilaya']); ?>">
    
    <div class="card-image-wrapper">
      <span class="card-badge <?php echo $row['badge_class']; ?>">
        <?php echo htmlspecialchars($row['badge_texte']); ?>
      </span>
      <img src="<?php echo $row['image_path']; ?>" alt="Image" class="card-image" />
    </div>

    <div class="card-body">
      <h4 class="card-title"><?php echo htmlspecialchars($row['titre']); ?></h4>
      <p class="card-location">📍 <?php echo htmlspecialchars($row['location']); ?></p>

      <div class="card-meta">
        <span class="card-duration">🗓 <?php echo htmlspecialchars($row['duree']); ?></span>
        <span class="card-price">
          <?php echo number_format($row['prix'], 0, '.', ' '); ?> <?php echo $row['unite_prix']; ?>
        </span>
      </div>

      <div class="card-stars">
        <span class="stars filled"><?php echo str_repeat('★', $row['etoiles']); ?></span>
        <span class="stars empty"><?php echo str_repeat('★', 5 - $row['etoiles']); ?></span>
      </div>

      <div class="card-included">
        <strong>Inclus</strong>
        <ul>
          <?php foreach ($inclus_items as $item): ?>
            <li>✔ <?php echo trim($item); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <button class="btn-reserver">Réserver Maintenant</button>
    </div>

  </div>

  <?php endwhile; ?>
</div> </div> </section>
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
          <a href="#accueil">accueil</a>
          <a href="#forfait">forfaits camping</a>
          <a href="#service">services</a>
          <a href="#galerie">galerie</a>
          <a href="#avis">avis</a>
          <a href="#reserver">reserver</a>
          <a href="#contact">contact</a>
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