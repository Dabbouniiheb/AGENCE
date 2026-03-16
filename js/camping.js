// =====================
// CAROUSEL LOGIC
// =====================
let carouselOffsets = {};

function getVisibleCount(trackId) {
    const track = document.getElementById(trackId);
    if (!track) return 3;
    // 72px width + 5px margin = 77px
    const containerWidth = track.parentElement.offsetWidth;
    const imgWidth = 77; // 72 + 5 margin
    return Math.max(1, Math.floor(containerWidth / imgWidth));
}

function nextSlide(trackId) {
    const track = document.getElementById(trackId);
    if (!track) return;
    
    const imgs = track.querySelectorAll('img');
    const total = imgs.length;
    const visible = getVisibleCount(trackId);
    const maxOffset = total - visible;
    
    if (!carouselOffsets[trackId]) carouselOffsets[trackId] = 0;
    carouselOffsets[trackId] = Math.min(carouselOffsets[trackId] + 1, maxOffset);
    updateCarousel(trackId);
}

function prevSlide(trackId) {
    const track = document.getElementById(trackId);
    if (!track) return;
    
    if (!carouselOffsets[trackId]) carouselOffsets[trackId] = 0;
    carouselOffsets[trackId] = Math.max(carouselOffsets[trackId] - 1, 0);
    updateCarousel(trackId);
}

function updateCarousel(trackId) {
    const track = document.getElementById(trackId);
    if (!track) return;
    
    const offset = carouselOffsets[trackId] || 0;
    const imgWidth = 77; // 72px + 5px margin
    track.style.transform = `translateX(-${offset * imgWidth}px)`;
}

// Reset carousel on window resize
window.addEventListener('resize', function() {
    document.querySelectorAll('[id^="camp-carousel"]').forEach(track => {
        const trackId = track.id;
        if (carouselOffsets[trackId]) {
            // Recalculate max offset
            const imgs = track.querySelectorAll('img');
            const total = imgs.length;
            const visible = getVisibleCount(trackId);
            const maxOffset = total - visible;
            carouselOffsets[trackId] = Math.min(carouselOffsets[trackId], maxOffset);
            updateCarousel(trackId);
        }
    });
});

// =====================
// PRICE RANGE SLIDER
// =====================
const priceRange = document.getElementById('priceRange');
if (priceRange) {
    const currentLabel = document.getElementById('priceCurrent');
    
    function updatePriceLabel() {
        if (currentLabel) {
            currentLabel.textContent = '≤ ' + priceRange.value + ' DT';
        }
    }
    
    updatePriceLabel();
    
    priceRange.addEventListener('input', function() {
        updatePriceLabel();
        applyAllFilters();
    });
}

// =====================
// FILTER FUNCTIONS
// =====================
// Get all checkbox IDs
const locationCheckboxIds = [
    'wilayaAll', 'tunis', 'sousse', 'tozeur', 'jendouba', 
    'sfax', 'monastir', 'nabeul', 'djerba', 'gabes', 'kairouan', 'other'
];

const starCheckboxIds = ['starsAll', 'stars3', 'stars4', 'stars5'];

// Location select sync
const locationSelect = document.getElementById('locationSelect');
if (locationSelect) {
    locationSelect.addEventListener('change', function() {
        const selected = this.value;
        
        // Uncheck all location checkboxes first
        locationCheckboxIds.forEach(id => {
            const cb = document.getElementById(id);
            if (cb) cb.checked = false;
        });
        
        // Check the selected one if not empty
        if (selected) {
            const selectedCb = document.getElementById(selected);
            if (selectedCb) selectedCb.checked = true;
        } else {
            // If empty, check "Tous"
            const allCb = document.getElementById('wilayaAll');
            if (allCb) allCb.checked = true;
        }
        
        applyAllFilters();
    });
}

// Handle location checkbox changes
locationCheckboxIds.forEach(id => {
    const checkbox = document.getElementById(id);
    if (!checkbox) return;
    
    checkbox.addEventListener('change', function(e) {
        const clickedId = this.id;
        
        if (clickedId === 'wilayaAll') {
            // If "Tous" is checked, uncheck all others
            if (this.checked) {
                locationCheckboxIds.forEach(otherId => {
                    if (otherId !== 'wilayaAll') {
                        const otherCb = document.getElementById(otherId);
                        if (otherCb) otherCb.checked = false;
                    }
                });
                // Reset select
                if (locationSelect) locationSelect.value = '';
            }
        } else {
            // If any location is checked, uncheck "Tous"
            if (this.checked) {
                const allCb = document.getElementById('wilayaAll');
                if (allCb) allCb.checked = false;
                
                // Update select
                if (locationSelect) locationSelect.value = this.id;
                
                // Uncheck other locations (single selection)
                locationCheckboxIds.forEach(otherId => {
                    if (otherId !== 'wilayaAll' && otherId !== clickedId) {
                        const otherCb = document.getElementById(otherId);
                        if (otherCb) otherCb.checked = false;
                    }
                });
            } else {
                // If unchecked and no other checked, check "Tous"
                const anyChecked = locationCheckboxIds.some(id => {
                    if (id === 'wilayaAll') return false;
                    const cb = document.getElementById(id);
                    return cb && cb.checked;
                });
                
                if (!anyChecked) {
                    const allCb = document.getElementById('wilayaAll');
                    if (allCb) allCb.checked = true;
                    if (locationSelect) locationSelect.value = '';
                }
            }
        }
        
        applyAllFilters();
    });
});

// Handle star checkbox changes (single selection)
starCheckboxIds.forEach(id => {
    const checkbox = document.getElementById(id);
    if (!checkbox) return;
    
    checkbox.addEventListener('change', function(e) {
        if (this.checked) {
            // Uncheck all other stars
            starCheckboxIds.forEach(otherId => {
                if (otherId !== this.id) {
                    const otherCb = document.getElementById(otherId);
                    if (otherCb) otherCb.checked = false;
                }
            });
        } else {
            // If unchecked and nothing else checked, check "Tous"
            const anyChecked = starCheckboxIds.some(id => {
                const cb = document.getElementById(id);
                return cb && cb.checked;
            });
            
            if (!anyChecked) {
                const allCb = document.getElementById('starsAll');
                if (allCb) allCb.checked = true;
            }
        }
        
        applyAllFilters();
    });
});

// Search term
let currentSearchTerm = '';

// Header search
const headerSearch = document.getElementById('search-bar');
if (headerSearch) {
    headerSearch.addEventListener('input', function() {
        currentSearchTerm = this.value.trim().toLowerCase();
        applyAllFilters();
    });
}

// Main filter function
function applyAllFilters() {
    const cards = document.querySelectorAll('.package-card');
    
    // Get checked locations (excluding "Tous")
    const checkedLocations = [];
    locationCheckboxIds.forEach(id => {
        if (id === 'wilayaAll') return;
        const cb = document.getElementById(id);
        if (cb && cb.checked) checkedLocations.push(id);
    });
    
    // Get checked stars
    let starFilter = null;
    starCheckboxIds.forEach(id => {
        if (id === 'starsAll') return;
        const cb = document.getElementById(id);
        if (cb && cb.checked) {
            starFilter = parseInt(id.replace('stars', ''));
        }
    });
    
    // Get max price
    const maxPrice = priceRange ? parseInt(priceRange.value) : 2500;
    
    cards.forEach(card => {
        let show = true;
        
        // Filter by location
        if (checkedLocations.length > 0) {
            const cardLocation = card.getAttribute('data-wilaya') || '';
            show = show && checkedLocations.includes(cardLocation);
        }
        
        // Filter by stars if not "Tous"
        if (starFilter !== null) {
            const starsEl = card.querySelector('.stars.filled');
            const cardStars = starsEl ? starsEl.textContent.length : 0;
            show = show && (cardStars === starFilter);
        }
        
        // Filter by price
        if (maxPrice < 2500) {
            const priceEl = card.querySelector('.card-price');
            if (priceEl) {
                const price = parseInt(priceEl.textContent.replace(/[^0-9]/g, ''));
                show = show && (price <= maxPrice);
            }
        }
        
        // Filter by search term
        if (currentSearchTerm) {
            const titleEl = card.querySelector('.card-title');
            const title = titleEl ? titleEl.textContent.toLowerCase() : '';
            show = show && title.includes(currentSearchTerm);
        }
        
        // Apply visibility
        card.style.display = show ? '' : 'none';
    });
}

// Show all button
const showAllBtn = document.getElementById('showAllPackagesBtn');
if (showAllBtn) {
    showAllBtn.addEventListener('click', function() {
        // Reset locations
        locationCheckboxIds.forEach(id => {
            const cb = document.getElementById(id);
            if (cb) cb.checked = (id === 'wilayaAll');
        });
        
        // Reset stars
        starCheckboxIds.forEach(id => {
            const cb = document.getElementById(id);
            if (cb) cb.checked = (id === 'starsAll');
        });
        
        // Reset price
        if (priceRange) {
            priceRange.value = priceRange.max || 2500;
            const currentLabel = document.getElementById('priceCurrent');
            if (currentLabel) {
                currentLabel.textContent = '≤ ' + priceRange.value + ' DT';
            }
        }
        
        // Reset search
        if (headerSearch) {
            headerSearch.value = '';
            currentSearchTerm = '';
        }
        
        // Reset select
        if (locationSelect) locationSelect.value = '';
        
        applyAllFilters();
    });
}

// =====================
// CAROUSEL THUMBNAIL CLICK → UPDATE MAIN IMAGE
// =====================
document.querySelectorAll('.card-carousel .carousel-track img').forEach(thumb => {
    thumb.addEventListener('click', function() {
        const card = this.closest('.package-card');
        const mainImg = card.querySelector('.card-image');
        if (mainImg) {
            // Get high-res version
            const largeSrc = this.src.replace('w=80&h=60', 'w=600');
            mainImg.src = largeSrc;
        }
    });
});

// =====================
// RESERVE BUTTON
// =====================
document.querySelectorAll('.btn-reserver').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        
        const card = this.closest('.package-card');
        const title = card.querySelector('.card-title').textContent;
        const price = card.querySelector('.card-price').textContent;
        
        // Save to localStorage if needed
        localStorage.setItem('lastReservation', JSON.stringify({
            title: title,
            price: price,
            date: new Date().toISOString()
        }));
        
        // Visual feedback
        const originalText = this.textContent;
        const originalBg = this.style.background;
        
        this.textContent = '✔ Réservation en cours...';
        this.style.background = '#27ae60';
        this.disabled = true;
        
        // Redirect to reservation page
        setTimeout(() => {
            window.location.href = '#reserver';
        }, 1500);
        
        console.log(`Réservation: ${title} - ${price}`);
    });
});

// Apply filters on page load
document.addEventListener('DOMContentLoaded', function() {
    applyAllFilters();
    
    // Initialize carousels
    document.querySelectorAll('[id^="camp-carousel"]').forEach(track => {
        carouselOffsets[track.id] = 0;
        updateCarousel(track.id);
    });
});