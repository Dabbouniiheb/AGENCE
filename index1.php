<?php
// ============================================
// index.php — Tableau de bord Admin (PHP + MySQL)
// ============================================
require_once 'db.php';
require_once 'auth.php';
requireLogin();

$admin = getCurrentAdmin();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel — Agence de Voyages</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Inter','Segoe UI',Tahoma,Geneva,Verdana,sans-serif}
        .container{display:flex;min-height:100vh}
        /* Sidebar */
        .sidebar{width:250px;background:#1e293b;color:white;padding:20px;flex-shrink:0}
        .sidebar h2{margin-bottom:30px;font-size:20px;display:flex;align-items:center;gap:10px}
        .sidebar ul{list-style:none}
        .sidebar ul li{padding:12px 15px;margin-bottom:5px;border-radius:8px;cursor:pointer;
            display:flex;align-items:center;gap:10px;transition:.3s;font-size:14px}
        .sidebar ul li:hover{background:#334155}
        .sidebar ul li.active{background:#3b82f6}
        .sidebar ul li a{color:white;text-decoration:none}
        /* Main */
        .main{flex:1;background:#f1f5f9;padding:20px;overflow-y:auto}
        /* Topbar */
        .topbar{display:flex;justify-content:space-between;align-items:center;background:white;
            padding:15px 20px;border-radius:10px;margin-bottom:20px;box-shadow:0 2px 4px rgba(0,0,0,.1)}
        .topbar-title{font-size:18px;font-weight:700;color:#1e293b}
        .topbar-user{display:flex;align-items:center;gap:10px;color:#64748b;font-size:14px}
        /* Cards */
        .cards{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-bottom:30px}
        .card{background:white;padding:24px;border-radius:14px;box-shadow:0 4px 20px rgba(0,0,0,.06);
            border-left:4px solid #3b82f6;transition:transform .25s,box-shadow .25s;position:relative;overflow:hidden}
        .card:hover{transform:translateY(-6px) scale(1.02);box-shadow:0 12px 32px rgba(0,0,0,.12)}
        .card--blue{border-left-color:#3b82f6}.card--green{border-left-color:#10b981}
        .card--amber{border-left-color:#f59e0b}.card--purple{border-left-color:#8b5cf6}
        .card .icon-wrapper{width:48px;height:48px;border-radius:12px;display:flex;align-items:center;
            justify-content:center;margin-bottom:14px;font-size:22px}
        .card--blue  .icon-wrapper{background:rgba(59,130,246,.12);color:#3b82f6}
        .card--green .icon-wrapper{background:rgba(16,185,129,.12);color:#10b981}
        .card--amber .icon-wrapper{background:rgba(245,158,11,.12);color:#f59e0b}
        .card--purple .icon-wrapper{background:rgba(139,92,246,.12);color:#8b5cf6}
        .card p.card-label{color:#94a3b8;margin-bottom:4px;font-size:13px;font-weight:500;
            text-transform:uppercase;letter-spacing:.5px}
        .card h2.card-value{color:#0f172a;font-size:32px;font-weight:800;line-height:1}
        .card-trend{display:inline-flex;align-items:center;gap:4px;margin-top:10px;font-size:12px;
            font-weight:600;padding:3px 10px;border-radius:20px}
        .card-trend--up{background:rgba(16,185,129,.12);color:#059669}
        .card-trend--down{background:rgba(239,68,68,.12);color:#dc2626}
        /* Analytics */
        .analytics-section{display:grid;grid-template-columns:repeat(2,1fr);gap:24px;margin-bottom:30px}
        .analytics-card{background:white;border-radius:14px;padding:28px;box-shadow:0 4px 20px rgba(0,0,0,.06)}
        .analytics-card h3{color:#0f172a;font-size:18px;font-weight:700;margin-bottom:6px}
        .analytics-subtitle{color:#94a3b8;font-size:13px;margin-bottom:20px}
        .chart-container{position:relative;width:100%;max-height:300px}
        /* Table section */
        .table-section{background:white;padding:20px;border-radius:10px;box-shadow:0 2px 4px rgba(0,0,0,.1)}
        .section-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px}
        .section-header h2,.section-header h3{color:#1e293b;font-size:18px}
        table{width:100%;border-collapse:collapse}
        th{text-align:left;padding:12px;background:#f8fafc;color:#64748b;font-weight:600;font-size:14px}
        td{padding:12px;border-bottom:1px solid #e2e8f0;font-size:14px}
        /* Badges statut */
        .badge{padding:5px 10px;border-radius:20px;font-size:12px;font-weight:600;white-space:nowrap}
        .badge-pending{background:#fef3c7;color:#92400e}
        .badge-cancel{background:#fee2e2;color:#b91c1c}
        .badge-confirm{background:#dcfce7;color:#166534}
        /* Boutons */
        .btn-add{background:#3b82f6;color:white;border:none;padding:10px 20px;border-radius:8px;
            cursor:pointer;display:inline-flex;align-items:center;gap:8px;font-size:14px;font-weight:600;transition:.3s}
        .btn-add:hover{background:#2563eb}
        .btn-danger{background:#ef4444;color:white;border:none;padding:6px 12px;border-radius:6px;
            cursor:pointer;font-size:12px;font-weight:600;transition:.3s}
        .btn-danger:hover{background:#dc2626}
        .btn-edit{background:#f59e0b;color:white;border:none;padding:6px 12px;border-radius:6px;
            cursor:pointer;font-size:12px;font-weight:600;transition:.3s}
        .btn-edit:hover{background:#d97706}
        /* Modal */
        .modal{display:none;position:fixed;top:0;left:0;width:100%;height:100%;
            background:rgba(0,0,0,.5);justify-content:center;align-items:center;z-index:1000}
        .modal.active{display:flex}
        .modal-content{background:white;padding:30px;border-radius:10px;width:500px;max-width:90%;
            max-height:90vh;overflow-y:auto}
        .modal-content h3{margin-bottom:20px;color:#1e293b;font-size:18px}
        .form-group{margin-bottom:15px}
        .form-group label{display:block;margin-bottom:5px;color:#64748b;font-size:14px;font-weight:600}
        .form-group input,.form-group select,.form-group textarea{width:100%;padding:10px;
            border:1.5px solid #e2e8f0;border-radius:6px;font-size:14px;transition:.2s}
        .form-group input:focus,.form-group select:focus,.form-group textarea:focus{
            outline:none;border-color:#3b82f6}
        .form-group textarea{height:80px;resize:vertical}
        .modal-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:20px}
        .btn-cancel{background:#e2e8f0;color:#64748b;border:none;padding:10px 20px;
            border-radius:6px;cursor:pointer;font-weight:600}
        .btn-save{background:#3b82f6;color:white;border:none;padding:10px 20px;
            border-radius:6px;cursor:pointer;font-weight:600}
        /* Etoiles */
        .stars{color:#f59e0b}
        /* Paramètres */
        .param-section{background:white;padding:20px;border-radius:10px;
            box-shadow:0 2px 4px rgba(0,0,0,.1);margin-bottom:20px}
        .param-section h3{color:#1e293b;margin-bottom:15px;display:flex;align-items:center;gap:10px;font-size:16px}
        .param-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:15px}
        /* Toast */
        .toast{position:fixed;bottom:24px;right:24px;background:#1e293b;color:white;
            padding:14px 22px;border-radius:10px;font-size:14px;font-weight:600;
            box-shadow:0 8px 24px rgba(0,0,0,.2);opacity:0;transition:.4s;z-index:9999;
            display:flex;align-items:center;gap:10px}
        .toast.show{opacity:1}
        .toast.success{background:#059669}
        .toast.error{background:#dc2626}
        /* Loader */
        .loader{text-align:center;padding:40px;color:#94a3b8}
        /* Responsive */
        @media(max-width:1024px){.cards{grid-template-columns:repeat(2,1fr)}.analytics-section{grid-template-columns:1fr}}
        @media(max-width:640px){.cards{grid-template-columns:1fr}.sidebar{width:200px}}
    </style>
</head>
<body>
<div class="container">

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>✈️ Admin Panel</h2>
        <ul id="sidebar-menu">
            <li class="active" data-page="dashboard"><i class="bi bi-speedometer2"></i> Tableau de bord</li>
            <li data-page="voyages"><i class="bi bi-airplane"></i> Voyages</li>
            <li data-page="hotels"><i class="bi bi-building"></i> Hôtels</li>
            <li data-page="reservations"><i class="bi bi-calendar-check"></i> Réservations</li>
            <li data-page="utilisateurs"><i class="bi bi-people"></i> Utilisateurs</li>
            <li data-page="parametres"><i class="bi bi-gear"></i> Paramètres</li>
            <li><i class="bi bi-box-arrow-right"></i><a href="logout.php">Déconnexion</a></li>
        </ul>
    </div>

    <!-- Main -->
    <div class="main">

        <!-- Topbar -->
        <div class="topbar">
            <span class="topbar-title" id="page-title">Tableau de bord</span>
            <div class="topbar-user">
                <i class="bi bi-person-circle" style="font-size:24px"></i>
                <span><?= htmlspecialchars($admin['nom']) ?> — <?= htmlspecialchars($admin['role']) ?></span>
            </div>
        </div>

        <!-- Stats Cards (dashboard seulement) -->
        <div id="cards-container" class="cards">
            <div class="card card--blue">
                <div class="icon-wrapper"><i class="bi bi-calendar-check"></i></div>
                <p class="card-label">Réservations aujourd'hui</p>
                <h2 class="card-value" id="stat-reservations">…</h2>
                <span class="card-trend card-trend--up"><i class="bi bi-arrow-up-short"></i> chargement…</span>
            </div>
            <div class="card card--green">
                <div class="icon-wrapper"><i class="bi bi-airplane"></i></div>
                <p class="card-label">Total voyages</p>
                <h2 class="card-value" id="stat-voyages">…</h2>
                <span class="card-trend card-trend--up"><i class="bi bi-arrow-up-short"></i> actifs</span>
            </div>
            <div class="card card--amber">
                <div class="icon-wrapper"><i class="bi bi-building"></i></div>
                <p class="card-label">Nombre d'hôtels</p>
                <h2 class="card-value" id="stat-hotels">…</h2>
                <span class="card-trend card-trend--up"><i class="bi bi-arrow-up-short"></i> partenaires</span>
            </div>
            <div class="card card--purple">
                <div class="icon-wrapper"><i class="bi bi-person-circle"></i></div>
                <p class="card-label">Utilisateurs</p>
                <h2 class="card-value" id="stat-users">…</h2>
                <span class="card-trend card-trend--up"><i class="bi bi-arrow-up-short"></i> inscrits</span>
            </div>
        </div>

        <!-- Contenu dynamique -->
        <div id="dynamic-content">
            <div class="loader"><i class="bi bi-arrow-repeat"></i> Chargement…</div>
        </div>

    </div>
</div>

<!-- Modal générique -->
<div id="modal" class="modal">
    <div class="modal-content">
        <h3 id="modal-title">Ajouter</h3>
        <div id="modal-fields"></div>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal()">Annuler</button>
            <button class="btn-save" onclick="submitModal()">Enregistrer</button>
        </div>
    </div>
</div>

<!-- Toast notification -->
<div id="toast" class="toast"></div>

<script>
// ─── STATE ────────────────────────────────────────
let currentPage = 'dashboard';
let modalAction = '';
let modalId = null;
let chartLine = null;
let chartDoughnut = null;
let listsCache = null;

// ─── UTILS ────────────────────────────────────────
function api(params, method = 'GET') {
    if (method === 'GET') {
        const qs = new URLSearchParams(params).toString();
        return fetch('api.php?' + qs).then(r => r.json());
    } else {
        const fd = new FormData();
        for (const [k, v] of Object.entries(params)) fd.append(k, v);
        return fetch('api.php', { method: 'POST', body: fd }).then(r => r.json());
    }
}

function toast(msg, type = 'success') {
    const el = document.getElementById('toast');
    el.textContent = (type === 'success' ? '✅ ' : '❌ ') + msg;
    el.className = 'toast show ' + type;
    setTimeout(() => el.className = 'toast', 3000);
}

function stars(n) {
    return '★'.repeat(n) + '☆'.repeat(5 - n);
}

function badgeStatut(s) {
    const map = { 'En attente': 'badge-pending', 'Annulé': 'badge-cancel', 'Confirmé': 'badge-confirm' };
    return `<span class="badge ${map[s] || ''}">${s}</span>`;
}

function closeModal() {
    document.getElementById('modal').classList.remove('active');
}

// ─── NAVIGATION ───────────────────────────────────
document.getElementById('sidebar-menu').addEventListener('click', e => {
    const li = e.target.closest('li[data-page]');
    if (!li) return;
    document.querySelectorAll('.sidebar ul li').forEach(x => x.classList.remove('active'));
    li.classList.add('active');
    navigate(li.dataset.page);
});

function navigate(page) {
    currentPage = page;
    document.getElementById('page-title').textContent = {
        dashboard: 'Tableau de bord', voyages: 'Voyages', hotels: 'Hôtels',
        reservations: 'Réservations', utilisateurs: 'Utilisateurs', parametres: 'Paramètres'
    }[page] || page;

    const cardsContainer = document.getElementById('cards-container');
    cardsContainer.style.display = page === 'dashboard' ? 'grid' : 'none';

    const pages = {
        dashboard: loadDashboard,
        voyages: loadVoyages,
        hotels: loadHotels,
        reservations: loadReservations,
        utilisateurs: loadUtilisateurs,
        parametres: loadParametres
    };
    if (pages[page]) pages[page]();
}

// ─── DASHBOARD ────────────────────────────────────
function loadDashboard() {
    const dc = document.getElementById('dynamic-content');
    dc.innerHTML = `
        <div class="analytics-section">
            <div class="analytics-card">
                <h3>Réservations mensuelles</h3>
                <p class="analytics-subtitle">6 derniers mois</p>
                <div class="chart-container"><canvas id="lineChart"></canvas></div>
            </div>
            <div class="analytics-card">
                <h3>Répartition des statuts</h3>
                <p class="analytics-subtitle">Toutes réservations</p>
                <div class="chart-container"><canvas id="doughnutChart"></canvas></div>
            </div>
        </div>
        <div class="table-section">
            <h2 style="margin-bottom:16px">Dernières réservations</h2>
            <div id="dash-reservations"><div class="loader">Chargement…</div></div>
        </div>`;

    api({ action: 'stats' }).then(data => {
        document.getElementById('stat-reservations').textContent = data.reservations_today;
        document.getElementById('stat-voyages').textContent = data.total_voyages;
        document.getElementById('stat-hotels').textContent = data.total_hotels;
        document.getElementById('stat-users').textContent = data.total_utilisateurs;

        // Line chart
        const labels = data.chart_data.map(d => d.mois);
        const values = data.chart_data.map(d => parseInt(d.total));
        if (chartLine) chartLine.destroy();
        chartLine = new Chart(document.getElementById('lineChart'), {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    label: 'Réservations', data: values,
                    borderColor: '#3b82f6', backgroundColor: 'rgba(59,130,246,.12)',
                    tension: .4, fill: true, pointRadius: 5
                }]
            },
            options: { responsive: true, plugins: { legend: { display: false } } }
        });

        // Doughnut chart
        const statuts = data.statuts;
        const sLabels = statuts.map(s => s.statut);
        const sValues = statuts.map(s => parseInt(s.total));
        if (chartDoughnut) chartDoughnut.destroy();
        chartDoughnut = new Chart(document.getElementById('doughnutChart'), {
            type: 'doughnut',
            data: {
                labels: sLabels,
                datasets: [{
                    data: sValues,
                    backgroundColor: ['#f59e0b', '#ef4444', '#10b981']
                }]
            },
            options: { responsive: true, cutout: '65%' }
        });
    });

    // Dernières réservations
    api({ action: 'get_reservations' }).then(d => {
        const rows = d.data.slice(0, 5).map(r => `
            <tr>
                <td>${r.client_nom}</td>
                <td>${r.voyage_nom || '-'}</td>
                <td>${r.hotel_nom || '-'}</td>
                <td>${r.nb_personnes}</td>
                <td>${badgeStatut(r.statut)}</td>
            </tr>`).join('');
        document.getElementById('dash-reservations').innerHTML = `
            <table>
                <thead><tr><th>Client</th><th>Voyage</th><th>Hôtel</th><th>Personnes</th><th>Statut</th></tr></thead>
                <tbody>${rows}</tbody>
            </table>`;
    });
}

// ─── VOYAGES ──────────────────────────────────────
function loadVoyages() {
    const dc = document.getElementById('dynamic-content');
    dc.innerHTML = `<div class="table-section">
        <div class="section-header">
            <h2>Voyages</h2>
            <button class="btn-add" onclick="openModalVoyage()"><i class="bi bi-plus-lg"></i> Ajouter</button>
        </div>
        <div id="voyages-table"><div class="loader">Chargement…</div></div>
    </div>`;
    refreshVoyages();
}

function refreshVoyages() {
    api({ action: 'get_voyages' }).then(d => {
        const rows = d.data.map(v => `
            <tr>
                <td>${v.id}</td>
                <td><strong>${v.nom}</strong></td>
                <td>${v.destination}</td>
                <td>${v.date_depart}</td>
                <td>${parseFloat(v.prix).toFixed(2)} €</td>
                <td>${v.nb_personnes}</td>
                <td>
                    <button class="btn-edit" onclick='openModalVoyage(${JSON.stringify(v)})'>✏️ Modifier</button>
                    <button class="btn-danger" onclick="deleteItem('voyage',${v.id})">🗑️ Supprimer</button>
                </td>
            </tr>`).join('');
        document.getElementById('voyages-table').innerHTML = `
            <table>
                <thead><tr><th>#</th><th>Nom</th><th>Destination</th><th>Date</th><th>Prix</th><th>Personnes</th><th>Actions</th></tr></thead>
                <tbody>${rows || '<tr><td colspan="7" style="text-align:center;color:#94a3b8">Aucun voyage</td></tr>'}</tbody>
            </table>`;
    });
}

function openModalVoyage(v = null) {
    modalAction = v ? 'edit_voyage' : 'add_voyage';
    modalId = v ? v.id : null;
    document.getElementById('modal-title').textContent = v ? 'Modifier le voyage' : 'Ajouter un voyage';
    document.getElementById('modal-fields').innerHTML = `
        <div class="form-group"><label>Nom</label><input id="f-nom" value="${v?.nom || ''}"></div>
        <div class="form-group"><label>Destination</label><input id="f-destination" value="${v?.destination || ''}"></div>
        <div class="form-group"><label>Date de départ</label><input type="date" id="f-date" value="${v?.date_depart || ''}"></div>
        <div class="form-group"><label>Prix (€)</label><input type="number" id="f-prix" value="${v?.prix || ''}"></div>
        <div class="form-group"><label>Nombre de personnes</label><input type="number" id="f-personnes" value="${v?.nb_personnes || ''}"></div>
        <div class="form-group"><label>Description</label><textarea id="f-desc">${v?.description || ''}</textarea></div>`;
    document.getElementById('modal').classList.add('active');
}

// ─── HÔTELS ───────────────────────────────────────
function loadHotels() {
    const dc = document.getElementById('dynamic-content');
    dc.innerHTML = `<div class="table-section">
        <div class="section-header">
            <h2>Hôtels</h2>
            <button class="btn-add" onclick="openModalHotel()"><i class="bi bi-plus-lg"></i> Ajouter</button>
        </div>
        <div id="hotels-table"><div class="loader">Chargement…</div></div>
    </div>`;
    refreshHotels();
}

function refreshHotels() {
    api({ action: 'get_hotels' }).then(d => {
        const rows = d.data.map(h => `
            <tr>
                <td>${h.id}</td>
                <td><strong>${h.nom}</strong></td>
                <td>${h.ville}</td>
                <td><span class="stars">${stars(parseInt(h.etoiles))}</span></td>
                <td>${parseFloat(h.prix_nuit).toFixed(2)} €/nuit</td>
                <td>${h.nb_chambres}</td>
                <td>
                    <button class="btn-edit" onclick='openModalHotel(${JSON.stringify(h)})'>✏️ Modifier</button>
                    <button class="btn-danger" onclick="deleteItem('hotel',${h.id})">🗑️ Supprimer</button>
                </td>
            </tr>`).join('');
        document.getElementById('hotels-table').innerHTML = `
            <table>
                <thead><tr><th>#</th><th>Nom</th><th>Ville</th><th>Étoiles</th><th>Prix/nuit</th><th>Chambres</th><th>Actions</th></tr></thead>
                <tbody>${rows || '<tr><td colspan="7" style="text-align:center;color:#94a3b8">Aucun hôtel</td></tr>'}</tbody>
            </table>`;
    });
}

function openModalHotel(h = null) {
    modalAction = h ? 'edit_hotel' : 'add_hotel';
    modalId = h ? h.id : null;
    document.getElementById('modal-title').textContent = h ? 'Modifier l\'hôtel' : 'Ajouter un hôtel';
    document.getElementById('modal-fields').innerHTML = `
        <div class="form-group"><label>Nom</label><input id="f-nom" value="${h?.nom || ''}"></div>
        <div class="form-group"><label>Ville</label><input id="f-ville" value="${h?.ville || ''}"></div>
        <div class="form-group"><label>Étoiles</label>
            <select id="f-etoiles">
                ${[1,2,3,4,5].map(n=>`<option value="${n}" ${parseInt(h?.etoiles)===n?'selected':''}>${n} ★</option>`).join('')}
            </select>
        </div>
        <div class="form-group"><label>Prix par nuit (€)</label><input type="number" id="f-prix" value="${h?.prix_nuit || ''}"></div>
        <div class="form-group"><label>Nombre de chambres</label><input type="number" id="f-chambres" value="${h?.nb_chambres || ''}"></div>
        <div class="form-group"><label>Description</label><textarea id="f-desc">${h?.description || ''}</textarea></div>`;
    document.getElementById('modal').classList.add('active');
}

// ─── RÉSERVATIONS ─────────────────────────────────
function loadReservations() {
    const dc = document.getElementById('dynamic-content');
    dc.innerHTML = `<div class="table-section">
        <div class="section-header">
            <h2>Réservations</h2>
            <button class="btn-add" onclick="openModalReservation()"><i class="bi bi-plus-lg"></i> Ajouter</button>
        </div>
        <div id="reservations-table"><div class="loader">Chargement…</div></div>
    </div>`;
    refreshReservations();
}

function refreshReservations() {
    api({ action: 'get_reservations' }).then(d => {
        const rows = d.data.map(r => `
            <tr>
                <td>${r.id}</td>
                <td>${r.client_nom}</td>
                <td>${r.voyage_nom || '-'}</td>
                <td>${r.hotel_nom || '-'}</td>
                <td>${r.nb_personnes}</td>
                <td>${badgeStatut(r.statut)}</td>
                <td>${r.date_reservation?.substring(0,10) || '-'}</td>
                <td>
                    <button class="btn-edit" onclick='openModalReservation(${JSON.stringify(r)})'>✏️ Modifier</button>
                    <button class="btn-danger" onclick="deleteItem('reservation',${r.id})">🗑️ Supprimer</button>
                </td>
            </tr>`).join('');
        document.getElementById('reservations-table').innerHTML = `
            <table>
                <thead><tr><th>#</th><th>Client</th><th>Voyage</th><th>Hôtel</th><th>Pers.</th><th>Statut</th><th>Date</th><th>Actions</th></tr></thead>
                <tbody>${rows || '<tr><td colspan="8" style="text-align:center;color:#94a3b8">Aucune réservation</td></tr>'}</tbody>
            </table>`;
    });
}

async function openModalReservation(r = null) {
    modalAction = r ? 'edit_reservation' : 'add_reservation';
    modalId = r ? r.id : null;
    document.getElementById('modal-title').textContent = r ? 'Modifier la réservation' : 'Ajouter une réservation';

    if (!listsCache) listsCache = await api({ action: 'lists' });
    const { voyages, hotels, utilisateurs } = listsCache;

    const voyOpts = voyages.map(v => `<option value="${v.id}" ${r?.voyage_id==v.id?'selected':''}>${v.nom}</option>`).join('');
    const hotOpts = hotels.map(h => `<option value="${h.id}" ${r?.hotel_id==h.id?'selected':''}>${h.nom}</option>`).join('');
    const usrOpts = `<option value="">— aucun —</option>` + utilisateurs.map(u => `<option value="${u.id}" ${r?.utilisateur_id==u.id?'selected':''}>${u.nom}</option>`).join('');
    const statuts = ['En attente','Confirmé','Annulé'].map(s=>`<option ${r?.statut===s?'selected':''}>${s}</option>`).join('');

    document.getElementById('modal-fields').innerHTML = `
        <div class="form-group"><label>Nom du client</label><input id="f-client" value="${r?.client_nom || ''}"></div>
        <div class="form-group"><label>Utilisateur lié</label><select id="f-user">${usrOpts}</select></div>
        <div class="form-group"><label>Voyage</label><select id="f-voyage">${voyOpts}</select></div>
        <div class="form-group"><label>Hôtel</label><select id="f-hotel">${hotOpts}</select></div>
        <div class="form-group"><label>Nombre de personnes</label><input type="number" id="f-personnes" value="${r?.nb_personnes || 1}"></div>
        <div class="form-group"><label>Statut</label><select id="f-statut">${statuts}</select></div>`;
    document.getElementById('modal').classList.add('active');
}

// ─── UTILISATEURS ─────────────────────────────────
function loadUtilisateurs() {
    const dc = document.getElementById('dynamic-content');
    dc.innerHTML = `<div class="table-section">
        <div class="section-header">
            <h2>Utilisateurs</h2>
            <button class="btn-add" onclick="openModalUser()"><i class="bi bi-plus-lg"></i> Ajouter</button>
        </div>
        <div id="users-table"><div class="loader">Chargement…</div></div>
    </div>`;
    refreshUsers();
}

function refreshUsers() {
    api({ action: 'get_utilisateurs' }).then(d => {
        const rows = d.data.map(u => `
            <tr>
                <td>${u.id}</td>
                <td><strong>${u.nom}</strong></td>
                <td>${u.email}</td>
                <td>${u.role}</td>
                <td>${u.date_inscription}</td>
                <td>
                    <button class="btn-edit" onclick='openModalUser(${JSON.stringify(u)})'>✏️ Modifier</button>
                    <button class="btn-danger" onclick="deleteItem('utilisateur',${u.id})">🗑️ Supprimer</button>
                </td>
            </tr>`).join('');
        document.getElementById('users-table').innerHTML = `
            <table>
                <thead><tr><th>#</th><th>Nom</th><th>Email</th><th>Rôle</th><th>Inscription</th><th>Actions</th></tr></thead>
                <tbody>${rows || '<tr><td colspan="6" style="text-align:center;color:#94a3b8">Aucun utilisateur</td></tr>'}</tbody>
            </table>`;
    });
}

function openModalUser(u = null) {
    modalAction = u ? 'edit_utilisateur' : 'add_utilisateur';
    modalId = u ? u.id : null;
    document.getElementById('modal-title').textContent = u ? 'Modifier l\'utilisateur' : 'Ajouter un utilisateur';
    document.getElementById('modal-fields').innerHTML = `
        <div class="form-group"><label>Nom</label><input id="f-nom" value="${u?.nom || ''}"></div>
        <div class="form-group"><label>Email</label><input type="email" id="f-email" value="${u?.email || ''}"></div>
        <div class="form-group"><label>Mot de passe ${u?'(laisser vide = inchangé)':''}</label>
            <input type="password" id="f-mdp" placeholder="••••••••"></div>
        <div class="form-group"><label>Rôle</label>
            <select id="f-role">
                <option ${u?.role==='Client'?'selected':''}>Client</option>
                <option ${u?.role==='Admin'?'selected':''}>Admin</option>
            </select>
        </div>`;
    document.getElementById('modal').classList.add('active');
}

// ─── PARAMÈTRES ───────────────────────────────────
function loadParametres() {
    const dc = document.getElementById('dynamic-content');
    dc.innerHTML = `<div class="loader">Chargement…</div>`;

    api({ action: 'get_parametres' }).then(p => {
        dc.innerHTML = `
        <div class="param-section">
            <h3><i class="bi bi-gear" style="color:#3b82f6"></i> Configuration générale</h3>
            <div class="param-grid">
                <div class="form-group"><label>Nom du site</label><input id="p-site" value="${p.site_name || ''}"></div>
                <div class="form-group"><label>Langue</label>
                    <select id="p-langue">
                        <option value="fr" ${p.langue==='fr'?'selected':''}>Français</option>
                        <option value="ar" ${p.langue==='ar'?'selected':''}>Arabe</option>
                        <option value="en" ${p.langue==='en'?'selected':''}>Anglais</option>
                    </select>
                </div>
                <div class="form-group"><label>Devise</label>
                    <select id="p-devise">
                        <option value="EUR" ${p.devise==='EUR'?'selected':''}>Euro (€)</option>
                        <option value="USD" ${p.devise==='USD'?'selected':''}>Dollar ($)</option>
                        <option value="TND" ${p.devise==='TND'?'selected':''}>Dinar (TND)</option>
                    </select>
                </div>
                <div class="form-group"><label>Fuseau horaire</label>
                    <select id="p-tz">
                        <option value="UTC+1" ${p.fuseau_horaire==='UTC+1'?'selected':''}>UTC+1 (Paris)</option>
                        <option value="UTC+0" ${p.fuseau_horaire==='UTC+0'?'selected':''}>UTC+0 (Londres)</option>
                        <option value="UTC+3" ${p.fuseau_horaire==='UTC+3'?'selected':''}>UTC+3 (La Mecque)</option>
                    </select>
                </div>
            </div>
            <button class="btn-add" style="margin-top:15px" onclick="saveParams()"><i class="bi bi-save"></i> Enregistrer</button>
        </div>

        <div class="param-section">
            <h3><i class="bi bi-shield-lock" style="color:#3b82f6"></i> Sécurité</h3>
            <div style="margin-bottom:12px">
                <label style="display:flex;align-items:center;gap:10px;cursor:pointer">
                    <input type="checkbox" id="p-2fa" ${p.deux_facteurs==='1'?'checked':''}> Authentification à deux facteurs
                </label>
            </div>
            <div style="margin-bottom:12px">
                <label style="display:flex;align-items:center;gap:10px;cursor:pointer">
                    <input type="checkbox" id="p-alerts" ${p.alertes_connexion==='1'?'checked':''}> Notifications de connexion
                </label>
            </div>
            <div class="form-group"><label>Durée de session (minutes)</label>
                <input type="number" id="p-session" value="${p.duree_session || 30}" min="5" max="120" style="max-width:120px">
            </div>
            <button class="btn-add" style="margin-top:10px" onclick="saveParams()"><i class="bi bi-shield-lock"></i> Mettre à jour</button>
        </div>

        <div class="param-section">
            <h3><i class="bi bi-bell" style="color:#3b82f6"></i> Notifications</h3>
            <div style="margin-bottom:12px">
                <label style="display:flex;align-items:center;gap:10px;cursor:pointer">
                    <input type="checkbox" id="p-notif-res" ${p.email_nouvelle_reservation==='1'?'checked':''}> Email pour nouvelle réservation
                </label>
            </div>
            <div style="margin-bottom:12px">
                <label style="display:flex;align-items:center;gap:10px;cursor:pointer">
                    <input type="checkbox" id="p-notif-usr" ${p.email_nouvel_utilisateur==='1'?'checked':''}> Email pour nouvel utilisateur
                </label>
            </div>
            <div style="margin-bottom:12px">
                <label style="display:flex;align-items:center;gap:10px;cursor:pointer">
                    <input type="checkbox" id="p-notif-daily" ${p.rapport_quotidien==='1'?'checked':''}> Rapport quotidien par email
                </label>
            </div>
            <div class="form-group"><label>Email de notification</label>
                <input type="email" id="p-email-notif" value="${p.email_notification || ''}">
            </div>
            <button class="btn-add" style="margin-top:10px" onclick="saveParams()"><i class="bi bi-bell"></i> Enregistrer</button>
        </div>`;
    });
}

function saveParams() {
    const v = id => document.getElementById(id);
    const chk = id => { const el = v(id); return el ? (el.checked ? '1' : '0') : '0'; };
    const val = id => { const el = v(id); return el ? el.value : ''; };

    api({
        action: 'save_parametres',
        site_name: val('p-site'), langue: val('p-langue'), devise: val('p-devise'),
        fuseau_horaire: val('p-tz'), deux_facteurs: chk('p-2fa'),
        alertes_connexion: chk('p-alerts'), duree_session: val('p-session'),
        email_nouvelle_reservation: chk('p-notif-res'),
        email_nouvel_utilisateur: chk('p-notif-usr'),
        rapport_quotidien: chk('p-notif-daily'), email_notification: val('p-email-notif')
    }, 'POST').then(d => {
        if (d.success) toast('Paramètres enregistrés !');
        else toast('Erreur : ' + (d.error || '?'), 'error');
    });
}

// ─── SUBMIT MODAL ─────────────────────────────────
function submitModal() {
    const get = id => { const el = document.getElementById(id); return el ? el.value : ''; };

    let params = { action: modalAction };
    if (modalId) params.id = modalId;

    if (modalAction.includes('voyage')) {
        params = { ...params, nom: get('f-nom'), destination: get('f-destination'),
            date_depart: get('f-date'), prix: get('f-prix'), nb_personnes: get('f-personnes'),
            description: get('f-desc') };
    } else if (modalAction.includes('hotel')) {
        params = { ...params, nom: get('f-nom'), ville: get('f-ville'), etoiles: get('f-etoiles'),
            prix_nuit: get('f-prix'), nb_chambres: get('f-chambres'), description: get('f-desc') };
    } else if (modalAction.includes('reservation')) {
        params = { ...params, client_nom: get('f-client'), utilisateur_id: get('f-user'),
            voyage_id: get('f-voyage'), hotel_id: get('f-hotel'),
            nb_personnes: get('f-personnes'), statut: get('f-statut') };
    } else if (modalAction.includes('utilisateur')) {
        params = { ...params, nom: get('f-nom'), email: get('f-email'),
            mot_de_passe: get('f-mdp'), role: get('f-role') };
    }

    api(params, 'POST').then(d => {
        if (d.success) {
            closeModal();
            toast('Opération réussie !');
            listsCache = null; // refresh cache
            navigate(currentPage);
        } else {
            toast('Erreur : ' + (d.error || 'Inconnue'), 'error');
        }
    });
}

// ─── DELETE ───────────────────────────────────────
function deleteItem(type, id) {
    if (!confirm(`Supprimer cet élément ? Cette action est irréversible.`)) return;
    const actionMap = { voyage: 'delete_voyage', hotel: 'delete_hotel',
        reservation: 'delete_reservation', utilisateur: 'delete_utilisateur' };
    api({ action: actionMap[type], id }, 'POST').then(d => {
        if (d.success) { toast('Supprimé avec succès.'); navigate(currentPage); }
        else toast('Erreur suppression.', 'error');
    });
}

// ─── INIT ─────────────────────────────────────────
navigate('dashboard');
</script>
</body>
</html>
