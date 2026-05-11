<?php include('db_config.php'); 




// 1. Connexion à la base de données XAMPP
$host = 'localhost';
$dbname = 'agence_voyage';
$username = 'root';
$password = ''; // Par défaut vide sur XAMPP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// 2. Récupération des forfaits
$query = $pdo->query("SELECT * FROM packages");
$forfaits = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Voyages Tunisie - Dynamique</title>
    <link rel="stylesheet" href="css/style1.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </head>
<body>

  <header>
    <div id="menu-bar" class="fas fa-bars"></div>
    <a href="index.html" class="logo"><span>V</span>oyages</a>
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
  </header>

  
  <!-- HERO BANNER -->
  <section class="hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
      <h1>TUNISIE</h1>
      <h2>Découvrez le Sud Tunisien</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
    </div>
  </section>

  <!-- MAIN CONTENT -->
  <main class="main-container">
    <!-- SIDEBAR FILTERS -->
    <aside class="filters">
      <h3 class="filters-title">FILTERS</h3>

      <!-- Prix -->
      <div class="filter-group">
        <label class="filter-label">Prix</label>
        <span class="filter-sublabel">Price Range</span>
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

      <!-- Wilayet -->
      <div class="filter-group">
        <label class="filter-label">Wilayet</label>
        <div class="select-wrapper">
          <select class="filter-select" id="locationSelect">
            <option value="">Select Locations</option>
            <option value="tunis">Tunis</option>
            <option value="sousse">Sousse</option>
            <option value="djerba">Djerba</option>
            <option value="tozeur">Tozeur</option>
            <option value="jendouba">Jendouba</option>
            <option value="sfax">Sfax</option>
            <option value="monastir">Monastir</option>
            <option value="nabeul">Nabeul</option>
            <option value="gabes">Gabès</option>
            <option value="kairouan">Kairouan</option>
          </select>
        </div>
        <div class="checkbox-group">
          <label class="checkbox-item">
            <input type="checkbox" id="wilayaAll" checked /> All
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="tunis" /> Tunis
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="sousse" /> Sousse
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="tozeur" /> Tozeur
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="jendouba" /> Jendouba
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="sfax" /> Sfax
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="monastir" /> Monastir
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="nabeul" /> Nabeul
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="djerba" /> Djerba
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="gabes" /> Gabès
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="kairouan" /> Kairouan
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="other" /> Other...
          </label>
        </div>
      </div>

      <!-- Etoiles -->
      <div class="filter-group">
        <label class="filter-label">Etoiles</label>
        <div class="checkbox-group">
          <label class="checkbox-item">
            <input type="checkbox" id="starsAll" checked /> All
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="stars3" /> 3 Stars
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="stars4" /> 4 Stars
          </label>
          <label class="checkbox-item">
            <input type="checkbox" id="stars5" /> 5 Stars
          </label>
        </div>
      </div>
    </aside>


    <section class="packages">
      <div class="packages-header">
        <h3 class="packages-title">NOS FORFAITS DYNAMIQUES</h3>
      </div>

      <div class="packages-grid">
        <?php foreach ($forfaits as $f): ?>
            <div class="package-card" data-wilaya="<?php echo htmlspecialchars($f['location']); ?>">
                <div class="card-image-wrapper">
                    <?php if ($f['badge']): ?>
                        <span class="card-badge"><?php echo htmlspecialchars($f['badge']); ?></span>
                    <?php endif; ?>
                    <img src="<?php echo htmlspecialchars($f['image_principale']); ?>" alt="Voyage" class="card-image" />
                </div>

                <div class="card-body">
                    <h4 class="card-title"><?php echo htmlspecialchars($f['titre']); ?></h4>
                    <p class="card-location">📍 <?php echo ucfirst(htmlspecialchars($f['location'])); ?></p>
                    
                    <div class="card-meta">
                        <span class="card-duration">🗓 <?php echo htmlspecialchars($f['duree']); ?></span>
                        <span class="card-price"><?php echo htmlspecialchars($f['prix']); ?> DT</span>
                    </div>

                    <div class="card-stars">
                        <span class="stars filled">
                            <?php echo str_repeat('★', $f['etoiles']); ?>
                        </span>
                        <span class="stars empty">
                            <?php echo str_repeat('★', 5 - $f['etoiles']); ?>
                        </span>
                    </div>

                    <button class="btn-reserver">Réserver Maintenant</button>
                </div>
            </div>
        <?php endforeach; ?>
      </div>
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
        <a href="index.html#accueil">Accueil</a>
          <a href="index.html#forfait">Forfait</a>
          <a href="index.html#service">Service</a>
          <a href="index.html#galerie">Galerie</a>
          <a href="index.html#avis">Avis</a>
          <a href="index.html#reserver">Réserver</a>
          <a href="index.html#contact">Contact</a>
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
</body>
</html>