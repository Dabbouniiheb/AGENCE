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

  priceRange.addEventListener('input', () => {
    const value = parseInt(priceRange.value);
    filterPackagesByPrice(value);
  });
}

function filterPackagesByPrice(maxPrice) {
  const cards = document.querySelectorAll('.package-card');
  cards.forEach(card => {
    const priceEl = card.querySelector('.card-price');
    if (!priceEl) return;
    const priceText = priceEl.textContent.replace(/[^0-9]/g, '');
    const price = parseInt(priceText);
    if (price <= maxPrice || maxPrice >= 5000) {
      card.style.display = '';
      card.style.opacity = '1';
    } else {
      card.style.opacity = '0.3';
      card.style.pointerEvents = 'none';
    }
  });
}

// =====================
// LOCATION SELECT SYNC
// =====================
const locationSelect = document.getElementById('locationSelect');
if (locationSelect) {
  locationSelect.addEventListener('change', () => {
    const selected = locationSelect.value;
    const checkboxes = document.querySelectorAll('.checkbox-group input[type="checkbox"]');
    checkboxes.forEach(cb => {
      if (selected && cb.id === selected) {
        cb.checked = true;
      }
    });
    filterPackagesByLocation();
  });
}

// =====================
// CHECKBOX FILTER
// =====================
const checkboxes = document.querySelectorAll('.filters input[type="checkbox"]');
checkboxes.forEach(cb => {
  cb.addEventListener('change', filterPackagesByLocation);
});

function filterPackagesByLocation() {
  const locationCheckboxes = document.querySelectorAll(
    '#tunis, #sousse, #tozeur, #other'
  );
  const checkedLocations = Array.from(locationCheckboxes)
    .filter(cb => cb.checked)
    .map(cb => cb.id.toLowerCase());

  const cards = document.querySelectorAll('.package-card');

  if (checkedLocations.length === 0) {
    cards.forEach(card => {
      card.style.display = '';
      card.style.opacity = '1';
      card.style.pointerEvents = '';
    });
    return;
  }

  cards.forEach(card => {
    const locationEl = card.querySelector('.card-location');
    if (!locationEl) return;
    const locationText = locationEl.textContent.toLowerCase();
    const matches = checkedLocations.some(loc =>
      locationText.includes(loc) || loc === 'other'
    );
    card.style.display = matches ? '' : 'none';
  });
}

// =====================
// STAR FILTER
// =====================
const starCheckboxes = document.querySelectorAll('#stars3, #stars4, #stars5');
starCheckboxes.forEach(cb => {
  cb.addEventListener('change', filterPackagesByStars);
});

function filterPackagesByStars() {
  const checked = Array.from(starCheckboxes).filter(cb => cb.checked).map(cb => {
    if (cb.id === 'stars3') return 3;
    if (cb.id === 'stars4') return 4;
    if (cb.id === 'stars5') return 5;
    return 0;
  });

  if (checked.length === 0) return;

  const cards = document.querySelectorAll('.package-card');
  cards.forEach(card => {
    const filledStars = card.querySelector('.stars.filled');
    if (!filledStars) return;
    const starCount = filledStars.textContent.length;
    const show = checked.some(s => starCount >= s);
    card.style.display = show ? '' : 'none';
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
    const card = btn.closest('.package-card');
    const title = card.querySelector('.card-title').textContent;
    const price = card.querySelector('.card-price').textContent;

    const original = btn.textContent;
    btn.textContent = '✔ Réservation en cours...';
    btn.style.background = '#27ae60';
    btn.style.borderColor = '#27ae60';
    btn.style.color = '#fff';

    setTimeout(() => {
      btn.textContent = original;
      btn.style.background = '';
      btn.style.borderColor = '';
      btn.style.color = '';
    }, 2000);

    console.log(`Réservation: ${title} - ${price}`);
  });
});
