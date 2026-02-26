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

  const minValue = priceRange.min || '80';
  const maxValue = priceRange.max || '2500';

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
// WILAYA IDs (for filters)
// =====================
const wilayaCheckboxIds = ['wilayaAll', 'tunis', 'sousse', 'tozeur', 'jendouba', 'sfax', 'monastir', 'nabeul', 'djerba', 'gabes', 'kairouan', 'other'];

// =====================
// LOCATION SELECT SYNC
// =====================
const locationSelect = document.getElementById('locationSelect');
if (locationSelect) {
  locationSelect.addEventListener('change', () => {
    const selected = locationSelect.value;
    wilayaCheckboxIds.forEach(id => {
      const cb = document.getElementById(id);
      if (cb) cb.checked = (cb.id === selected);
    });
    applyAllFilters();
  });
}

// =====================
// CHECKBOX FILTER
// =====================
const wilayaCheckboxes = wilayaCheckboxIds.map(id => document.getElementById(id)).filter(Boolean);

// Wilaya: single select - khi yclick 3la wa7da lo5ra, elli 9balha tethat
wilayaCheckboxes.forEach(cb => {
  cb.addEventListener('change', (e) => {
    const clickedId = e.target.id;

    if (clickedId === 'wilayaAll') {
      // All wilayas: khalli kol card yodhher
      if (e.target.checked) {
        wilayaCheckboxes.forEach(other => {
          if (other.id !== 'wilayaAll') other.checked = false;
        });
        if (locationSelect) locationSelect.value = '';
      }
    } else if (e.target.checked) {
      // Wilaya spécifique: activeha bark, w hat All off
      wilayaCheckboxes.forEach(other => {
        if (other !== e.target) other.checked = false;
      });
      const allCb = document.getElementById('wilayaAll');
      if (allCb) allCb.checked = false;

      if (locationSelect) locationSelect.value = e.target.id === 'other' ? '' : e.target.id;
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

// Apply wilaya + stars + price + text search
function applyAllFilters() {
  const cards = document.querySelectorAll('.package-card');

  // 1. Wilaya filter
  const locationCheckboxes = document.querySelectorAll(
    '#tunis, #sousse, #tozeur, #jendouba, #sfax, #monastir, #nabeul, #djerba, #gabes, #kairouan, #other'
  );
  const checkedWilayet = Array.from(locationCheckboxes)
    .filter(cb => cb.checked)
    .map(cb => cb.id.toLowerCase());

  // 2. Stars filter (single select) - starsAll = afficher kol l hotels mta3 wilaya
  const checkedStar = Array.from(starCheckboxes).find(cb => cb.checked);
  const starValue = checkedStar && checkedStar.id !== 'starsAll' 
    ? parseInt(checkedStar.id.replace('stars', '')) 
    : null;

  // 3. Price filter
  const maxPrice = priceRange ? parseInt(priceRange.value) || 2500 : 2500;

  cards.forEach(card => {
    let show = true;

    // Wilaya
    if (checkedWilayet.length > 0) {
      const wilaya = (card.getAttribute('data-wilaya') || '').toLowerCase();
      show = show && checkedWilayet.includes(wilaya);
    }

    // Stars
    if (starValue !== null) {
      const filledStars = card.querySelector('.stars.filled');
      const cardStars = filledStars ? filledStars.textContent.length : 0;
      show = show && (cardStars === starValue);
    }

    // Price
    const priceEl = card.querySelector('.card-price');
    if (priceEl && maxPrice < 2500) {
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
    card.style.opacity = show ? '1' : '';
    card.style.pointerEvents = show ? '' : 'none';
  });
}

// Initial apply (page load)
applyAllFilters();

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
    // reset wilaya checkboxes
    wilayaCheckboxIds.forEach(id => {
      const cb = document.getElementById(id);
      if (!cb) return;
      cb.checked = (id === 'wilayaAll');
    });

    // reset select wilaya
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
      priceRange.value = priceRange.max || 5000;
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
  btn.addEventListener('click', () => {
    // infos package (yemken nesta3mlhom baad ken theb)
    const card = btn.closest('.package-card');
    const title = card.querySelector('.card-title').textContent;
    const price = card.querySelector('.card-price').textContent;

    const original = btn.textContent;
    btn.textContent = '✔ Réservation en cours...';
    btn.style.background = '#27ae60';
    btn.style.borderColor = '#27ae60';
    btn.style.color = '#fff';

    setTimeout(() => {
      window.location.href = 'index.html#reserver';
    }, 2000);

    console.log(`Réservation: ${title} - ${price}`);
  });
});
