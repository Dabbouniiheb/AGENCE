// =====================
// CAROUSEL LOGIC
// =====================
const carouselOffsets = {};

function getVisibleCount(trackId) {
  const track = document.getElementById(trackId);
  if (!track) return 3;
  const trackWidth = track.parentElement.offsetWidth - 60;
  const imgWidth = 72 + 5;
  return Math.max(1, Math.floor(trackWidth / imgWidth));
}

function nextSlide(trackId) {
  const track = document.getElementById(trackId);
  const imgs = track.querySelectorAll('img');
  const total = imgs.length;
  const visible = getVisibleCount(trackId);
  const max = total - visible;

  if (!carouselOffsets[trackId]) carouselOffsets[trackId] = 0;
  carouselOffsets[trackId] = Math.min(carouselOffsets[trackId] + 1, max);
  updateCarousel(trackId);
}

function prevSlide(trackId) {
  const track = document.getElementById(trackId);
  if (!carouselOffsets[trackId]) carouselOffsets[trackId] = 0;
  carouselOffsets[trackId] = Math.max(carouselOffsets[trackId] - 1, 0);
  updateCarousel(trackId);
}

function updateCarousel(trackId) {
  const track = document.getElementById(trackId);
  const offset = carouselOffsets[trackId] || 0;
  const imgWidth = 72 + 5;
  track.style.transform = `translateX(-${offset * imgWidth}px)`;
}

// =====================
// PRICE RANGE SLIDER
// =====================
const priceRange = document.getElementById('priceRange');
if (priceRange) {
  const minLabel = priceRange.parentElement.querySelector('.range-labels span:first-child');
  const maxLabel = priceRange.parentElement.querySelector('.range-labels span:last-child');
  const currentLabel = priceRange.parentElement.querySelector('.range-current');

  const minValue = priceRange.min || '1500';
  const maxValue = priceRange.max || '12000';

  function updatePriceLabels() {
    if (minLabel) minLabel.textContent = `${minValue} DT`;
    if (maxLabel) maxLabel.textContent = `${maxValue} DT`;
    if (currentLabel) currentLabel.textContent = `≤ ${priceRange.value} DT`;
  }

  updatePriceLabels();

  priceRange.addEventListener('input', () => {
    updatePriceLabels();
    applyAllFilters();
  });
}

// =====================
// QUARTIER IDs (for filters) - CORRESPONDANCE AVEC data-quartier
// =====================
const quartierCheckboxIds = [
  'wilayaAll', 'ajyad', 'aziziyah', 'jabel', 'misfalah', 
  'shisha', 'jarwal', 'raoudha', 'zahra'
];

// =====================
// LOCATION SELECT SYNC
// =====================
const locationSelect = document.getElementById('locationSelect');
if (locationSelect) {
  locationSelect.addEventListener('change', () => {
    const selected = locationSelect.value;
    quartierCheckboxIds.forEach(id => {
      const cb = document.getElementById(id);
      if (cb) cb.checked = (cb.id === selected);
    });
    // Si on a sélectionné un quartier, décocher "Tous"
    if (selected) {
      const allCb = document.getElementById('wilayaAll');
      if (allCb) allCb.checked = false;
    }
    applyAllFilters();
  });
}

// =====================
// CHECKBOX FILTER
// =====================
const quartierCheckboxes = quartierCheckboxIds.map(id => document.getElementById(id)).filter(Boolean);

// Quartier: single select - khi yclick 3la wa7da lo5ra, elli 9balha tethat
quartierCheckboxes.forEach(cb => {
  cb.addEventListener('change', (e) => {
    const clickedId = e.target.id;

    if (clickedId === 'wilayaAll') {
      // All quartiers: khalli kol card yodhher
      if (e.target.checked) {
        quartierCheckboxes.forEach(other => {
          if (other.id !== 'wilayaAll') other.checked = false;
        });
        if (locationSelect) locationSelect.value = '';
      }
    } else if (e.target.checked) {
      // Quartier spécifique: activeha bark, w hat All off
      quartierCheckboxes.forEach(other => {
        if (other !== e.target) other.checked = false;
      });
      const allCb = document.getElementById('wilayaAll');
      if (allCb) allCb.checked = false;

      if (locationSelect) locationSelect.value = e.target.id;
    }

    applyAllFilters();
  });
});

// Etoiles: single select - khi yclick 3la etoile jdida, elli 9balha tethat
const starCheckboxes = document.querySelectorAll('#starsAll, #stars3, #stars4, #stars5');
starCheckboxes.forEach(cb => {
  cb.addEventListener('change', (e) => {
    if (e.target.checked) {
      starCheckboxes.forEach(other => {
        if (other !== e.target) other.checked = false;
      });
    }
    applyAllFilters();
  });
});

// Search term (header search bar)
let currentSearchTerm = '';

// Apply quartier + stars + price + text search
function applyAllFilters() {
  const cards = document.querySelectorAll('.package-card');

  // 1. Quartier filter
  const quartierCheckboxes = document.querySelectorAll(
    '#ajyad, #aziziyah, #jabel, #misfalah, #shisha, #jarwal, #raoudha, #zahra'
  );
  const checkedQuartiers = Array.from(quartierCheckboxes)
    .filter(cb => cb.checked)
    .map(cb => cb.id.toLowerCase());

  // 2. Stars filter (single select) - starsAll = afficher kol l hotels
  const checkedStar = Array.from(starCheckboxes).find(cb => cb.checked);
  const starValue = checkedStar && checkedStar.id !== 'starsAll' 
    ? parseInt(checkedStar.id.replace('stars', '')) 
    : null;

  // 3. Price filter
  const maxPrice = priceRange ? parseInt(priceRange.value) || 12000 : 12000;

  cards.forEach(card => {
    let show = true;

    // Quartier
    if (checkedQuartiers.length > 0) {
      const quartier = (card.getAttribute('data-quartier') || '').toLowerCase();
      show = show && checkedQuartiers.includes(quartier);
    }

    // Stars
    if (starValue !== null) {
      const filledStars = card.querySelector('.stars.filled');
      const cardStars = filledStars ? filledStars.textContent.length : 0;
      show = show && (cardStars === starValue);
    }

    // Price
    const priceEl = card.querySelector('.card-price');
    if (priceEl) {
      const price = parseInt(priceEl.textContent.replace(/[^0-9]/g, ''));
      show = show && (price <= maxPrice);
    }

    // Text search (hotel name only)
    if (currentSearchTerm) {
      const titleEl = card.querySelector('.card-title');
      const name = titleEl ? titleEl.textContent : '';
      show = show && name.toLowerCase().includes(currentSearchTerm);
    }

    card.style.display = show ? '' : 'none';
  });
}

// Initial apply (page load)
document.addEventListener('DOMContentLoaded', function() {
  applyAllFilters();
});

// =====================
// HEADER SEARCH BAR → LIVE FILTER
// =====================
const headerSearchInput = document.getElementById('search-bar');
if (headerSearchInput) {
  headerSearchInput.addEventListener('input', () => {
    currentSearchTerm = headerSearchInput.value.trim().toLowerCase();
    applyAllFilters();
  });
}

// =====================
// SHOW ALL PACKAGES BUTTON
// =====================
const showAllBtn = document.getElementById('showAllPackagesBtn');
if (showAllBtn) {
  showAllBtn.addEventListener('click', () => {
    // reset quartier checkboxes
    quartierCheckboxIds.forEach(id => {
      const cb = document.getElementById(id);
      if (!cb) return;
      cb.checked = (id === 'wilayaAll');
    });

    // reset select quartier
    if (locationSelect) locationSelect.value = '';

    // reset stars → All
    const starsAll = document.getElementById('starsAll');
    if (starsAll) {
      starsAll.checked = true;
      document.querySelectorAll('#stars3, #stars4, #stars5').forEach(cb => {
        cb.checked = false;
      });
    }

    // reset price slider to max
    if (priceRange) {
      priceRange.value = priceRange.max || 12000;
      updatePriceLabels();
    }

    // reset search
    if (headerSearchInput) {
      headerSearchInput.value = '';
      currentSearchTerm = '';
    }

    applyAllFilters();
  });
}

// =====================
// CAROUSEL THUMBNAIL CLICK → MAIN IMAGE
// =====================
document.querySelectorAll('.card-carousel').forEach(carousel => {
  const imgs = carousel.querySelectorAll('.carousel-track img');
  const card = carousel.closest('.package-card');
  const mainImg = card.querySelector('.card-image');

  imgs.forEach(img => {
    img.addEventListener('click', () => {
      const largeSrc = img.src.replace('w=80&h=60', 'w=600');
      mainImg.src = largeSrc;
    });
  });
});

// =====================
// RESERVE BUTTON FEEDBACK
// =====================
document.querySelectorAll('.btn-reserver').forEach(btn => {
  btn.addEventListener('click', (e) => {
    e.preventDefault();
    // infos package
    const card = btn.closest('.package-card');
    const title = card.querySelector('.card-title').textContent;
    const price = card.querySelector('.card-price').textContent;

    const original = btn.textContent;
    btn.textContent = '✔ Réservation en cours...';
    btn.style.background = '#27ae60';

    setTimeout(() => {
      window.location.href = '#reserver';
    }, 1500);

    console.log(`Réservation: ${title} - ${price}`);
  });
});

// =====================
// MENU MOBILE
// =====================
document.addEventListener('DOMContentLoaded', function() {
  const menu = document.querySelector('#menu-bar');
  const navbar = document.querySelector('.navbar');
  const searchBtn = document.querySelector('#search-btn');
  const searchBar = document.querySelector('.search-bar-container');
  const formBtn = document.querySelector('#login-btn');
  const formClose = document.querySelector('#form-close');
  const loginForm = document.querySelector('.login-form-container');

  if (menu) {
    menu.addEventListener('click', () => {
      menu.classList.toggle('fa-times');
      navbar.classList.toggle('active');
    });
  }

  if (searchBtn) {
    searchBtn.addEventListener('click', () => {
      searchBtn.classList.toggle('fa-times');
      searchBar.classList.toggle('active');
    });
  }

  if (formBtn) {
    formBtn.addEventListener('click', () => {
      loginForm.classList.add('active');
    });
  }

  if (formClose) {
    formClose.addEventListener('click', () => {
      loginForm.classList.remove('active');
    });
  }

  // Fermer la recherche si on clique ailleurs
  window.addEventListener('click', (e) => {
    if (searchBar && searchBar.classList.contains('active')) {
      if (!searchBtn.contains(e.target) && !searchBar.contains(e.target)) {
        searchBtn.classList.remove('fa-times');
        searchBar.classList.remove('active');
      }
    }
  });
});