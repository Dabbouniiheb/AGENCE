<!-- HERO BANNER -->
<section class="hero">
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

    <div class="packages-grid">

      <!-- Camping Montagne -->
      <div class="package-card" data-wilaya="tunis">
        <div class="card-image-wrapper">
          <span class="card-badge badge-top">TOP</span>
          <img
            src="https://images.unsplash.com/photo-1508261306211-45a1c5c2a5c5?w=600&q=80"
            alt="Camping montagne dans les pins"
            class="card-image"
          />
        </div>
        <div class="card-body">
          <h4 class="card-title">Weekend Camping Montagne</h4>
          <p class="card-location">📍 Djebel Ressas & hauteurs de Zaghouan</p>
          <div class="card-meta">
            <span class="card-duration">🗓 2 jours / 1 nuit</span>
            <span class="card-price">280 DT</span>
          </div>
          <div class="card-stars">
            <span class="stars filled">★★★</span>
            <span class="stars empty">★★</span>
          </div>
          <div class="card-included">
            <strong>Inclus</strong>
            <ul>
              <li>✔ Transport A/R en bus climatisé</li>
              <li>✔ Tentes partagées & matelas</li>
              <li>✔ Randonnée guidée & feu de camp</li>
            </ul>
          </div>
          <div class="card-excluded">
            <strong>Non inclus</strong>
            <ul>
              <li class="excluded-item">☑ Equipement personnel (sac de couchage)</li>
              <li class="excluded-item">☑ Dépenses personnelles</li>
            </ul>
          </div>
          <div class="card-carousel">
            <button class="carousel-btn" onclick="prevSlide('camp-carousel1')">&#8249;</button>
            <div class="carousel-track" id="camp-carousel1">
              <img src="https://images.unsplash.com/photo-1508261306211-45a1c5c2a5c5?w=80&h=60&q=70" alt="Campement montagne" />
              <img src="https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=80&h=60&q=70" alt="Feu de camp" />
              <img src="https://images.unsplash.com/photo-1500534314211-0a24cd03f2c0?w=80&h=60&q=70" alt="Randonnée en groupe" />
              <img src="https://images.unsplash.com/photo-1516567727245-6bc7f9a0f17c?w=80&h=60&q=70" alt="Vue panoramique montagne" />
              <img src="https://images.unsplash.com/photo-1517824806704-9040b037703b?w=80&h=60&q=70" alt="Tente au lever du soleil" />
            </div>
            <button class="carousel-btn" onclick="nextSlide('camp-carousel1')">&#8250;</button>
          </div>
          <button class="btn-reserver">Réserver Maintenant</button>
        </div>
      </div>

      <!-- Camping Forêt -->
      <div class="package-card" data-wilaya="jendouba">
        <div class="card-image-wrapper">
          <span class="card-badge badge-nature">Nature</span>
          <img
            src="https://images.unsplash.com/photo-1508261306213-0a5a36a9a7c2?w=600&q=80"
            alt="Camping forêt"
            class="card-image"
          />
        </div>
        <div class="card-body">
          <h4 class="card-title">Camping Forêt d'Aïn Draham</h4>
          <p class="card-location">📍 Aïn Draham & forêts du Nord-Ouest</p>
          <div class="card-meta">
            <span class="card-duration">🗓 3 jours / 2 nuits</span>
            <span class="card-price">420 DT</span>
          </div>
          <div class="card-stars">
            <span class="stars filled">★★★</span>
            <span class="stars empty">★★</span>
          </div>
          <div class="card-included">
            <strong>Inclus</strong>
            <ul>
              <li>✔ Campement aménagé en pleine forêt</li>
              <li>✔ Petit-déjeuner & dîner inclus</li>
              <li>✔ Encadrement par guides certifiés</li>
            </ul>
          </div>
          <div class="card-excluded">
            <strong>Non inclus</strong>
            <ul>
              <li class="excluded-item">☑ Déjeuner</li>
              <li class="excluded-item">☑ Assurance voyage</li>
            </ul>
          </div>
          <div class="card-carousel">
            <button class="carousel-btn" onclick="prevSlide('camp-carousel2')">&#8249;</button>
            <div class="carousel-track" id="camp-carousel2">
              <img src="https://images.unsplash.com/photo-1508261306213-0a5a36a9a7c2?w=80&h=60&q=70" alt="Tentes dans la forêt" />
              <img src="https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=80&h=60&q=70" alt="Feu de camp en forêt" />
              <img src="https://images.unsplash.com/photo-1476611338391-6f395a0ebc7b?w=80&h=60&q=70" alt="Sentier boisé" />
              <img src="https://images.unsplash.com/photo-1517824806704-9040b037703b?w=80&h=60&q=70" alt="Petit déjeuner au camp" />
              <img src="https://images.unsplash.com/photo-1516567727245-6bc7f9a0f17c?w=80&h=60&q=70" alt="Forêt brumeuse" />
            </div>
            <button class="carousel-btn" onclick="nextSlide('camp-carousel2')">&#8250;</button>
          </div>
          <button class="btn-reserver">Réserver Maintenant</button>
        </div>
      </div>

      <!-- Camping Désert -->
      <div class="package-card" data-wilaya="tozeur">
        <div class="card-image-wrapper">
          <span class="card-badge badge-promo">PROMO</span>
          <img
            src="https://images.unsplash.com/photo-1529927066849-66e1abc70a2e?w=600&q=80"
            alt="Camping désert"
            class="card-image"
          />
        </div>
        <div class="card-body">
          <h4 class="card-title">Nuit sous les étoiles à Douz</h4>
          <p class="card-location">📍 Dunes de Douz & Sahara tunisien</p>
          <div class="card-meta">
            <span class="card-duration">🗓 2 jours / 1 nuit</span>
            <span class="card-price">350 DT</span>
          </div>
          <div class="card-stars">
            <span class="stars filled">★★★★</span>
            <span class="stars empty">★</span>
          </div>
          <div class="card-included">
            <strong>Inclus</strong>
            <ul>
              <li>✔ Balade à dos de dromadaire</li>
              <li>✔ Dîner traditionnel autour du feu</li>
              <li>✔ Tentes bédouines confortables</li>
            </ul>
          </div>
          <div class="card-excluded">
            <strong>Non inclus</strong>
            <ul>
              <li class="excluded-item">☑ Transport depuis Tunis</li>
              <li class="excluded-item">☑ Boissons</li>
            </ul>
          </div>
          <div class="card-carousel">
            <button class="carousel-btn" onclick="prevSlide('camp-carousel3')">&#8249;</button>
            <div class="carousel-track" id="camp-carousel3">
              <img src="https://images.unsplash.com/photo-1529927066849-66e1abc70a2e?w=80&h=60&q=70" alt="Tentes dans le désert" />
              <img src="https://images.unsplash.com/photo-1544989164-31dc3c645987?w=80&h=60&q=70" alt="Campement saharien" />
              <img src="https://images.unsplash.com/photo-1476610182048-b716b8518aae?w=80&h=60&q=70" alt="Dunes de sable" />
              <img src="https://images.unsplash.com/photo-1433838552652-f9a46b332c40?w=80&h=60&q=70" alt="Ciel étoilé désert" />
              <img src="https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=80&h=60&q=70" alt="Feu de camp dans les dunes" />
            </div>
            <button class="carousel-btn" onclick="nextSlide('camp-carousel3')">&#8250;</button>
          </div>
          <button class="btn-reserver">Réserver Maintenant</button>
        </div>
      </div>

      <!-- Camping Plage -->
      <div class="package-card" data-wilaya="sousse">
        <div class="card-image-wrapper">
          <span class="card-badge badge-top">PLAGE</span>
          <img
            src="https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=600&q=80"
            alt="Camping plage"
            class="card-image"
          />
        </div>
        <div class="card-body">
          <h4 class="card-title">Camping Plage & Surf</h4>
          <p class="card-location">📍 Côtes de Nabeul & Cap Bon</p>
          <div class="card-meta">
            <span class="card-duration">🗓 3 jours / 2 nuits</span>
            <span class="card-price">490 DT</span>
          </div>
          <div class="card-stars">
            <span class="stars filled">★★★★</span>
            <span class="stars empty">★</span>
          </div>
          <div class="card-included">
            <strong>Inclus</strong>
            <ul>
              <li>✔ Emplacements tentes en bord de mer</li>
              <li>✔ Petit-déjeuner & un repas par jour</li>
              <li>✔ Initiation surf / kayak (selon météo)</li>
            </ul>
          </div>
          <div class="card-excluded">
            <strong>Non inclus</strong>
            <ul>
              <li class="excluded-item">☑ Location combinaison & matériel surf</li>
              <li class="excluded-item">☑ Assurance sports nautiques</li>
            </ul>
          </div>
          <div class="card-carousel">
            <button class="carousel-btn" onclick="prevSlide('camp-carousel4')">&#8249;</button>
            <div class="carousel-track" id="camp-carousel4">
              <img src="https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=80&h=60&q=70" alt="Feu de camp plage" />
              <img src="https://images.unsplash.com/photo-1476611338391-6f395a0ebc7b?w=80&h=60&q=70" alt="Tentes près de la mer" />
              <img src="https://images.unsplash.com/photo-1508261306211-45a1c5c2a5c5?w=80&h=60&q=70" alt="Ciel coloré en bord de mer" />
              <img src="https://images.unsplash.com/photo-1517824806704-9040b037703b?w=80&h=60&q=70" alt="Petit-déjeuner en bord de plage" />
              <img src="https://images.unsplash.com/photo-1500534314211-0a24cd03f2c0?w=80&h=60&q=70" alt="Activités nautiques" />
            </div>
            <button class="carousel-btn" onclick="nextSlide('camp-carousel4')">&#8250;</button>
          </div>
          <button class="btn-reserver">Réserver Maintenant</button>
        </div>
      </div>

      <!-- Camping Famille -->
      <div class="package-card" data-wilaya="djerba">
        <div class="card-image-wrapper">
          <span class="card-badge badge-nature">Famille</span>
          <img
            src="https://images.unsplash.com/photo-1476610182048-b716b8518aae?w=600&q=80"
            alt="Camping famille"
            class="card-image"
          />
        </div>
        <div class="card-body">
          <h4 class="card-title">Camping Famille & Découverte</h4>
          <p class="card-location">📍 Parcs naturels & lacs du Nord</p>
          <div class="card-meta">
            <span class="card-duration">🗓 3 jours / 2 nuits</span>
            <span class="card-price">520 DT</span>
          </div>
          <div class="card-stars">
            <span class="stars filled">★★★★</span>
            <span class="stars empty">★</span>
          </div>
          <div class="card-included">
            <strong>Inclus</strong>
            <ul>
              <li>✔ Tentes familiales & aire de jeux</li>
              <li>✔ Activités nature pour enfants</li>
              <li>✔ Pension complète</li>
            </ul>
          </div>
          <div class="card-excluded">
            <strong>Non inclus</strong>
            <ul>
              <li class="excluded-item">☑ Sièges auto enfant</li>
              <li class="excluded-item">☑ Boissons & snacks</li>
            </ul>
          </div>
          <div class="card-carousel">
            <button class="carousel-btn" onclick="prevSlide('camp-carousel5')">&#8249;</button>
            <div class="carousel-track" id="camp-carousel5">
              <img src="https://images.unsplash.com/photo-1476610182048-b716b8518aae?w=80&h=60&q=70" alt="Famille au camp" />
              <img src="https://images.unsplash.com/photo-1517824806704-9040b037703b?w=80&h=60&q=70" alt="Repas en famille" />
              <img src="https://images.unsplash.com/photo-1516567727245-6bc7f9a0f17c?w=80&h=60&q=70" alt="Jeux en plein air" />
              <img src="https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=80&h=60&q=70" alt="Soirée feu de camp" />
              <img src="https://images.unsplash.com/photo-1476611338391-6f395a0ebc7b?w=80&h=60&q=70" alt="Tentes familiales" />
            </div>
            <button class="carousel-btn" onclick="nextSlide('camp-carousel5')">&#8250;</button>
          </div>
          <button class="btn-reserver">Réserver Maintenant</button>
        </div>
      </div>

      <!-- Camping Aventure -->
      <div class="package-card" data-wilaya="sfax">
        <div class="card-image-wrapper">
          <span class="card-badge badge-top">AVENTURE</span>
          <img
            src="https://images.unsplash.com/photo-1476611338391-6f395a0ebc7b?w=600&q=80"
            alt="Camping aventure"
            class="card-image"
          />
        </div>
        <div class="card-body">
          <h4 class="card-title">Trek & Camping Aventure</h4>
          <p class="card-location">📍 Itinéraire variable selon saison (Atlas, gorges, oueds)</p>
          <div class="card-meta">
            <span class="card-duration">🗓 4 jours / 3 nuits</span>
            <span class="card-price">690 DT</span>
          </div>
          <div class="card-stars">
            <span class="stars filled">★★★★★</span>
            <span class="stars empty"></span>
          </div>
          <div class="card-included">
            <strong>Inclus</strong>
            <ul>
              <li>✔ Encadrement par guides de montagne</li>
              <li>✔ Matériel de camping collectif</li>
              <li>✔ Pension complète sur le camp</li>
            </ul>
          </div>
          <div class="card-excluded">
            <strong>Non inclus</strong>
            <ul>
              <li class="excluded-item">☑ Equipement technique individuel</li>
              <li class="excluded-item">☑ Assurance trekking</li>
            </ul>
          </div>
          <div class="card-carousel">
            <button class="carousel-btn" onclick="prevSlide('camp-carousel6')">&#8249;</button>
            <div class="carousel-track" id="camp-carousel6">
              <img src="https://images.unsplash.com/photo-1476611338391-6f395a0ebc7b?w=80&h=60&q=70" alt="Tentes hautes montagnes" />
              <img src="https://images.unsplash.com/photo-1508261306211-45a1c5c2a5c5?w=80&h=60&q=70" alt="Crêtes montagneuses" />
              <img src="https://images.unsplash.com/photo-1500534314211-0a24cd03f2c0?w=80&h=60&q=70" alt="Groupe en randonnée" />
              <img src="https://images.unsplash.com/photo-1516567727245-6bc7f9a0f17c?w=80&h=60&q=70" alt="Traversée d'un oued" />
              <img src="https://images.unsplash.com/photo-1517824806704-9040b037703b?w=80&h=60&q=70" alt="Repas sur le camp" />
            </div>
            <button class="carousel-btn" onclick="nextSlide('camp-carousel6')">&#8250;</button>
          </div>
          <button class="btn-reserver">Réserver Maintenant</button>
        </div>
      </div>

      <!-- Camping Luxe -->
      <div class="package-card" data-wilaya="monastir">
        <div class="card-image-wrapper">
          <span class="card-badge badge-promo">GLAMPING</span>
          <img
            src="https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=600&q=80"
            alt="Glamping luxe"
            class="card-image"
          />
        </div>
        <div class="card-body">
          <h4 class="card-title">Glamping Luxe 5★</h4>
          <p class="card-location">📍 Campement de charme, désert & oasis</p>
          <div class="card-meta">
            <span class="card-duration">🗓 3 jours / 2 nuits</span>
            <span class="card-price">1150 DT</span>
          </div>
          <div class="card-stars">
            <span class="stars filled">★★★★★</span>
            <span class="stars empty"></span>
          </div>
          <div class="card-included">
            <strong>Inclus</strong>
            <ul>
              <li>✔ Tentes suites équipées (lit, salle d'eau privée)</li>
              <li>✔ Dîners gastronomiques sous les étoiles</li>
              <li>✔ Transferts privés 4x4</li>
            </ul>
          </div>
          <div class="card-excluded">
            <strong>Non inclus</strong>
            <ul>
              <li class="excluded-item">☑ Soins spa & bien-être</li>
              <li class="excluded-item">☑ Vols internes éventuels</li>
            </ul>
          </div>
          <div class="card-carousel">
            <button class="carousel-btn" onclick="prevSlide('camp-carousel7')">&#8249;</button>
            <div class="carousel-track" id="camp-carousel7">
              <img src="https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=80&h=60&q=70" alt="Intérieur glamping" />
              <img src="https://images.unsplash.com/photo-1544989164-31dc3c645987?w=80&h=60&q=70" alt="Lobby tente luxe" />
              <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=80&h=60&q=70" alt="Dîner sous les étoiles" />
              <img src="https://images.unsplash.com/photo-1433838552652-f9a46b332c40?w=80&h=60&q=70" alt="Ciel nocturne désert" />
              <img src="https://images.unsplash.com/photo-1529927066849-66e1abc70a2e?w=80&h=60&q=70" alt="Campement luxe désert" />
            </div>
            <button class="carousel-btn" onclick="nextSlide('camp-carousel7')">&#8250;</button>
          </div>
          <button class="btn-reserver">Réserver Maintenant</button>
        </div>
      </div>       
    </div>
  </section>
</main>