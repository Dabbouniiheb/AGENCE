<?php
// ============================================================
//  index.php — Tableau de bord principal (SPA PHP)
// ============================================================
require_once 'auth.php';
// requireLogin(); 
$adminNom = htmlspecialchars($_SESSION['admin_nom'] ?? 'Admin');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Panel — Agence de Voyages</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style>
/* ===================== RESET & BASE ===================== */
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif}
.container{display:flex;min-height:100vh}

/* ===================== SIDEBAR ===================== */
.sidebar{width:250px;background:#1e293b;color:white;padding:20px;flex-shrink:0}
.sidebar h2{margin-bottom:30px;font-size:20px;display:flex;align-items:center;gap:10px}
.sidebar ul{list-style:none}
.sidebar ul li{padding:12px 15px;margin-bottom:5px;border-radius:8px;cursor:pointer;display:flex;align-items:center;gap:10px;transition:.3s;font-size:14px}
.sidebar ul li:hover{background:#334155}
.sidebar ul li.active{background:#3b82f6}
.sidebar ul li a{color:white;text-decoration:none}

/* ===================== MAIN ===================== */
.main{flex:1;background:#f1f5f9;padding:20px;overflow-x:hidden}
.topbar{display:flex;justify-content:space-between;align-items:center;background:white;padding:15px 20px;border-radius:10px;margin-bottom:20px;box-shadow:0 2px 4px rgba(0,0,0,.1)}
.topbar .admin-info{display:flex;align-items:center;gap:10px;color:#475569;font-size:14px}
.topbar .admin-info i{font-size:24px}

/* ===================== CARDS ===================== */
.cards{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-bottom:30px}
.card{background:white;padding:20px;border-radius:10px;box-shadow:0 2px 4px rgba(0,0,0,.1)}
.card .icon{font-size:28px;color:#3b82f6;margin-bottom:10px}
.card p{color:#64748b;margin-bottom:5px;font-size:14px}
.card h2{color:#1e293b;font-size:30px;font-weight:700}

/* ===================== TABLES ===================== */
.table-section,.content-section{background:white;padding:20px;border-radius:10px;box-shadow:0 2px 4px rgba(0,0,0,.1)}
.table-section h2,.content-section .section-header h2{color:#1e293b;margin-bottom:20px}
table{width:100%;border-collapse:collapse}
th{text-align:left;padding:12px;background:#f8fafc;color:#64748b;font-weight:600;font-size:13px;border-bottom:2px solid #e2e8f0}
td{padding:12px;border-bottom:1px solid #e2e8f0;font-size:14px;color:#334155}
tr:last-child td{border-bottom:none}
tr:hover td{background:#f8fafc}

/* ===================== BADGES ===================== */
.pending{background:#fef3c7;color:#92400e;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600}
.cancel{background:#fee2e2;color:#b91c1c;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600}
.confirm{background:#dcfce7;color:#166534;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600}
.badge-admin{background:#ede9fe;color:#6d28d9;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600}
.badge-client{background:#e0f2fe;color:#0369a1;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600}

/* ===================== BUTTONS ===================== */
.section-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px}
.btn-add{background:#3b82f6;color:white;border:none;padding:10px 20px;border-radius:8px;cursor:pointer;display:inline-flex;align-items:center;gap:8px;font-size:14px;font-weight:600;transition:.3s;text-decoration:none}
.btn-add:hover{background:#2563eb}
.btn-edit{background:none;border:none;color:#64748b;cursor:pointer;font-size:16px;transition:.2s;padding:4px}
.btn-edit:hover{color:#3b82f6}
.btn-del{background:none;border:none;color:#64748b;cursor:pointer;font-size:16px;transition:.2s;padding:4px}
.btn-del:hover{color:#dc2626}
.action-icons{display:flex;gap:8px;align-items:center}

/* ===================== MODAL ===================== */
.modal{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:1000;align-items:center;justify-content:center}
.modal.active{display:flex}
.modal-content{background:white;padding:30px;border-radius:12px;width:520px;max-width:95%;max-height:90vh;overflow-y:auto}
.modal-content h3{margin-bottom:20px;color:#1e293b;font-size:18px}
.form-group{margin-bottom:15px}
.form-group label{display:block;margin-bottom:5px;color:#475569;font-size:13px;font-weight:600}
.form-group input,.form-group select,.form-group textarea{width:100%;padding:10px 12px;border:1px solid #e2e8f0;border-radius:7px;font-size:14px;outline:none;transition:.2s}
.form-group input:focus,.form-group select:focus,.form-group textarea:focus{border-color:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,.15)}
.form-group textarea{height:90px;resize:vertical}
.modal-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:20px}
.btn-cancel{background:#e2e8f0;color:#64748b;border:none;padding:10px 20px;border-radius:7px;cursor:pointer;font-weight:600}
.btn-save{background:#3b82f6;color:white;border:none;padding:10px 20px;border-radius:7px;cursor:pointer;font-weight:600}
.btn-save:hover{background:#2563eb}

/* ===================== TOAST ===================== */
#toast{position:fixed;bottom:24px;right:24px;background:#1e293b;color:white;padding:14px 22px;border-radius:10px;font-size:14px;z-index:9999;opacity:0;transition:opacity .3s;pointer-events:none;max-width:320px}
#toast.show{opacity:1}
#toast.success{background:#16a34a}
#toast.error{background:#dc2626}

/* ===================== LOADER ===================== */
.loader{text-align:center;padding:40px;color:#94a3b8;font-size:14px}
.spinner{display:inline-block;width:24px;height:24px;border:3px solid #e2e8f0;border-top-color:#3b82f6;border-radius:50%;animation:spin .8s linear infinite;margin-right:8px;vertical-align:middle}
@keyframes spin{to{transform:rotate(360deg)}}

/* ===================== SETTINGS ===================== */
.settings-block{background:white;padding:24px;border-radius:10px;box-shadow:0 2px 4px rgba(0,0,0,.1);margin-bottom:24px}
.settings-block h3{color:#1e293b;margin-bottom:18px;display:flex;align-items:center;gap:10px;font-size:16px}
.settings-block h3 i{color:#3b82f6}
.settings-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:18px}
.toggle-row{display:flex;align-items:center;gap:10px;margin-bottom:12px;cursor:pointer;font-size:14px;color:#475569}
.toggle-row input[type=checkbox]{width:16px;height:16px;cursor:pointer}
.sysinfo td{padding:10px 0;border:none;color:#64748b;font-size:14px}
.sysinfo td:last-child{color:#1e293b;font-weight:600}

/* ===================== STARS ===================== */
.stars{color:#f59e0b}

/* ===================== RESPONSIVE ===================== */
@media(max-width:900px){
  .cards{grid-template-columns:repeat(2,1fr)}
  .settings-grid{grid-template-columns:1fr}
}
@media(max-width:600px){
  .sidebar{width:60px;padding:10px}
  .sidebar h2 span,.sidebar ul li span{display:none}
  .cards{grid-template-columns:1fr}
}
</style>
</head>
<body>
<div class="container">

  <!-- ==================== SIDEBAR ==================== -->
  <div class="sidebar">
    <h2>✈️ <span>Admin Panel</span></h2>
    <ul>
      <li class="active" data-page="dashboard"><i class="bi bi-speedometer2"></i><span> Tableau de bord</span></li>
      <li data-page="voyages"><i class="bi bi-airplane"></i><span> Voyages</span></li>
      <li data-page="hotels"><i class="bi bi-building"></i><span> Hôtels</span></li>
      <li data-page="reservations"><i class="bi bi-calendar-check"></i><span> Réservations</span></li>
      <li data-page="utilisateurs"><i class="bi bi-people"></i><span> Utilisateurs</span></li>
      <li data-page="parametres"><i class="bi bi-gear"></i><span> Paramètres</span></li>
      <li onclick="window.location='Login.php'"><i class="bi bi-box-arrow-right"></i><span> Déconnexion</span></li>
    </ul>
  </div>

  <!-- ==================== MAIN ==================== -->
  <div class="main">
    <div class="topbar">
      <strong style="color:#1e293b;font-size:17px" id="page-title">Tableau de bord</strong>
      <div class="admin-info"><i class="bi bi-person-circle"></i> <?= $adminNom ?></div>
    </div>

    <!-- Stats cards (dashboard only) -->
    <div id="cards-container" class="cards">
      <div class="card"><div class="icon"><i class="bi bi-calendar-check"></i></div><p>Réservations aujourd'hui</p><h2 id="stat-res">…</h2></div>
      <div class="card"><div class="icon"><i class="bi bi-airplane"></i></div><p>Total voyages</p><h2 id="stat-voy">…</h2></div>
      <div class="card"><div class="icon"><i class="bi bi-building"></i></div><p>Nombre d'hôtels</p><h2 id="stat-hot">…</h2></div>
      <div class="card"><div class="icon"><i class="bi bi-people"></i></div><p>Utilisateurs</p><h2 id="stat-usr">…</h2></div>
    </div>

    <!-- Dynamic content area -->
    <div id="dynamic-content"></div>
  </div>
</div>

<!-- ==================== MODAL ==================== -->
<div id="modal" class="modal">
  <div class="modal-content">
    <h3 id="modal-title">Ajouter</h3>
    <div id="modal-fields"></div>
    <div class="modal-actions">
      <button class="btn-cancel" onclick="closeModal()">Annuler</button>
      <button class="btn-save" id="modal-submit-btn" onclick="submitModal()">Enregistrer</button>
    </div>
  </div>
</div>

<!-- Toast notification -->
<div id="toast"></div>

<script>
// ============================================================
//  UTILS
// ============================================================
const $ = id => document.getElementById(id);
let currentPage = 'dashboard';
let modalMode   = 'add';  // 'add' | 'edit'
let modalEntity = '';
let editId      = 0;

// Toast
function toast(msg, type='success'){
  const t = $('toast');
  t.textContent = msg;
  t.className   = 'show ' + type;
  clearTimeout(t._t);
  t._t = setTimeout(()=>{ t.className=''; }, 3500);
}

// Generic API call
async function api(entity, action, body=null){
  const url = `api.php?entity=${entity}&action=${action}`;
  const opts = body
    ? { method:'POST', body: new URLSearchParams(body) }
    : { method:'GET' };
  const res = await fetch(url, opts);
  return res.json();
}

// Loader
function loader(){ $('dynamic-content').innerHTML = '<div class="loader"><span class="spinner"></span>Chargement…</div>'; }

// Sidebar navigation
document.querySelectorAll('.sidebar ul li[data-page]').forEach(li => {
  li.addEventListener('click', function(){
    document.querySelectorAll('.sidebar ul li').forEach(x=>x.classList.remove('active'));
    this.classList.add('active');
    currentPage = this.dataset.page;
    $('page-title').textContent = this.textContent.trim();
    navigate(currentPage);
  });
});

function navigate(page){
  $('cards-container').style.display = page==='dashboard' ? 'grid' : 'none';
  switch(page){
    case 'dashboard':    loadDashboard();    break;
    case 'voyages':      loadVoyages();      break;
    case 'hotels':       loadHotels();       break;
    case 'reservations': loadReservations(); break;
    case 'utilisateurs': loadUtilisateurs(); break;
    case 'parametres':   loadParametres();   break;
  }
}

// ============================================================
//  DASHBOARD
// ============================================================
async function loadDashboard(){
  loader();
  const r = await api('stats','list');
  if(!r.success) return;
  const d = r.data;
  $('stat-res').textContent = d.reservations_auj;
  $('stat-voy').textContent = d.total_voyages;
  $('stat-hot').textContent = d.total_hotels;
  $('stat-usr').textContent = d.total_users;

  let rows = '';
  d.dern_reservations.forEach(x=>{
    const cls = x.statut==='En attente'?'pending': x.statut==='Annulé'?'cancel':'confirm';
    rows += `<tr>
      <td>${esc(x.client_nom)}</td>
      <td>${esc(x.voyage_nom||'—')}</td>
      <td>${esc(x.hotel_nom||'—')}</td>
      <td>${x.nb_personnes}</td>
      <td><span class="${cls}">${esc(x.statut)}</span></td>
    </tr>`;
  });

  $('dynamic-content').innerHTML = `
    <div class="table-section">
      <h2>Dernières réservations</h2>
      <table>
        <thead><tr><th>Client</th><th>Voyage</th><th>Hôtel</th><th>Personnes</th><th>Statut</th></tr></thead>
        <tbody>${rows||'<tr><td colspan="5" style="text-align:center;color:#94a3b8">Aucune réservation</td></tr>'}</tbody>
      </table>
    </div>`;
}

// ============================================================
//  VOYAGES
// ============================================================
async function loadVoyages(){
  loader();
  const r = await api('voyage','list');
  if(!r.success){ toast(r.message,'error'); return; }
  let rows = '';
  r.data.forEach(v=>{
    rows += `<tr>
      <td>${v.id}</td>
      <td>${esc(v.nom)}</td>
      <td>${esc(v.destination)}</td>
      <td>${v.date_depart}</td>
      <td>${parseFloat(v.prix).toFixed(2)} €</td>
      <td>${v.nb_personnes}</td>
      <td><div class="action-icons">
        <button class="btn-edit" title="Modifier" onclick="editVoyage(${v.id})"><i class="bi bi-pencil-square"></i></button>
        <button class="btn-del"  title="Supprimer" onclick="deleteItem('voyage',${v.id},'le voyage')"><i class="bi bi-trash3"></i></button>
      </div></td>
    </tr>`;
  });
  $('dynamic-content').innerHTML = `
    <div class="content-section">
      <div class="section-header">
        <h2>Gestion des Voyages</h2>
        <button class="btn-add" onclick="openAddModal('voyage')"><i class="bi bi-plus-circle"></i> Ajouter un voyage</button>
      </div>
      <table>
        <thead><tr><th>ID</th><th>Nom</th><th>Destination</th><th>Date départ</th><th>Prix</th><th>Participants</th><th>Actions</th></tr></thead>
        <tbody>${rows||'<tr><td colspan="7" style="text-align:center;color:#94a3b8">Aucun voyage</td></tr>'}</tbody>
      </table>
    </div>`;
}

// ============================================================
//  HOTELS
// ============================================================
async function loadHotels(){
  loader();
  const r = await api('hotel','list');
  if(!r.success){ toast(r.message,'error'); return; }
  let rows = '';
  r.data.forEach(h=>{
    const stars = '★'.repeat(h.etoiles)+'☆'.repeat(5-h.etoiles);
    rows += `<tr>
      <td>${h.id}</td>
      <td>${esc(h.nom)}</td>
      <td>${esc(h.ville)}</td>
      <td class="stars">${stars}</td>
      <td>${parseFloat(h.prix_nuit).toFixed(2)} €</td>
      <td>${h.nb_chambres}</td>
      <td><div class="action-icons">
        <button class="btn-edit" title="Modifier" onclick="editHotel(${h.id})"><i class="bi bi-pencil-square"></i></button>
        <button class="btn-del"  title="Supprimer" onclick="deleteItem('hotel',${h.id},'l\'hôtel')"><i class="bi bi-trash3"></i></button>
      </div></td>
    </tr>`;
  });
  $('dynamic-content').innerHTML = `
    <div class="content-section">
      <div class="section-header">
        <h2>Gestion des Hôtels</h2>
        <button class="btn-add" onclick="openAddModal('hotel')"><i class="bi bi-plus-circle"></i> Ajouter un hôtel</button>
      </div>
      <table>
        <thead><tr><th>ID</th><th>Nom</th><th>Ville</th><th>Étoiles</th><th>Prix/nuit</th><th>Chambres</th><th>Actions</th></tr></thead>
        <tbody>${rows||'<tr><td colspan="7" style="text-align:center;color:#94a3b8">Aucun hôtel</td></tr>'}</tbody>
      </table>
    </div>`;
}

// ============================================================
//  RESERVATIONS
// ============================================================
async function loadReservations(){
  loader();
  const [r, sel] = await Promise.all([
    api('reservation','list'),
    api('selects','list')
  ]);
  if(!r.success){ toast(r.message,'error'); return; }
  let rows = '';
  r.data.forEach(x=>{
    const cls = x.statut==='En attente'?'pending': x.statut==='Annulé'?'cancel':'confirm';
    rows += `<tr>
      <td>${x.id}</td>
      <td>${esc(x.client_nom)}</td>
      <td>${esc(x.utilisateur_nom||'—')}</td>
      <td>${esc(x.voyage_nom||'—')}</td>
      <td>${esc(x.hotel_nom||'—')}</td>
      <td>${x.nb_personnes}</td>
      <td><span class="${cls}">${esc(x.statut)}</span></td>
      <td><div class="action-icons">
        <button class="btn-edit" title="Modifier" onclick="editReservation(${x.id})"><i class="bi bi-pencil-square"></i></button>
        <button class="btn-del"  title="Supprimer" onclick="deleteItem('reservation',${x.id},'la réservation')"><i class="bi bi-trash3"></i></button>
      </div></td>
    </tr>`;
  });
  window._selects = sel.success ? sel.data : {voyages:[],hotels:[],utilisateurs:[]};

  $('dynamic-content').innerHTML = `
    <div class="content-section">
      <div class="section-header">
        <h2>Gestion des Réservations</h2>
        <button class="btn-add" onclick="openAddModal('reservation')"><i class="bi bi-plus-circle"></i> Ajouter une réservation</button>
      </div>
      <table>
        <thead><tr><th>ID</th><th>Client</th><th>Utilisateur</th><th>Voyage</th><th>Hôtel</th><th>Personnes</th><th>Statut</th><th>Actions</th></tr></thead>
        <tbody>${rows||'<tr><td colspan="8" style="text-align:center;color:#94a3b8">Aucune réservation</td></tr>'}</tbody>
      </table>
    </div>`;
}

// ============================================================
//  UTILISATEURS
// ============================================================
async function loadUtilisateurs(){
  loader();
  const r = await api('utilisateur','list');
  if(!r.success){ toast(r.message,'error'); return; }
  let rows = '';
  r.data.forEach(u=>{
    const badge = u.role==='Admin'
      ? '<span class="badge-admin">Admin</span>'
      : '<span class="badge-client">Client</span>';
    rows += `<tr>
      <td>${u.id}</td>
      <td>${esc(u.nom)}</td>
      <td>${esc(u.email)}</td>
      <td>${badge}</td>
      <td>${u.date_inscription}</td>
      <td><div class="action-icons">
        <button class="btn-edit" title="Modifier" onclick="editUtilisateur(${u.id})"><i class="bi bi-pencil-square"></i></button>
        <button class="btn-del"  title="Supprimer" onclick="deleteItem('utilisateur',${u.id},'l\'utilisateur')"><i class="bi bi-trash3"></i></button>
      </div></td>
    </tr>`;
  });
  $('dynamic-content').innerHTML = `
    <div class="content-section">
      <div class="section-header">
        <h2>Gestion des Utilisateurs</h2>
        <button class="btn-add" onclick="openAddModal('utilisateur')"><i class="bi bi-plus-circle"></i> Ajouter un utilisateur</button>
      </div>
      <table>
        <thead><tr><th>ID</th><th>Nom</th><th>Email</th><th>Rôle</th><th>Inscription</th><th>Actions</th></tr></thead>
        <tbody>${rows||'<tr><td colspan="6" style="text-align:center;color:#94a3b8">Aucun utilisateur</td></tr>'}</tbody>
      </table>
    </div>`;
}

// ============================================================
//  PARAMÈTRES
// ============================================================
async function loadParametres(){
  loader();
  const r = await api('parametres','get');
  const p = r.success ? r.data : {};

  $('dynamic-content').innerHTML = `
    <!-- Profil (lecture seule) -->
    <div class="settings-block">
      <h3><i class="bi bi-person-circle"></i> Profil Admin</h3>
      <div class="settings-grid">
        <div class="form-group"><label>Nom complet</label><input value="<?= $adminNom ?>" readonly style="background:#f8fafc"></div>
        <div class="form-group"><label>Email</label><input value="<?= htmlspecialchars($_SESSION['admin_email'] ?? 'admin@example.com') ?>" readonly style="background:#f8fafc"></div>
      </div>
    </div>

    <!-- Configuration générale -->
    <div class="settings-block">
      <h3><i class="bi bi-gear"></i> Configuration générale</h3>
      <div class="settings-grid">
        <div class="form-group"><label>Nom du site</label><input id="p_site_nom" value="${esc(p.site_nom||'Agence de Voyages')}"></div>
        <div class="form-group"><label>Langue</label>
          <select id="p_langue">
            <option value="fr" ${p.langue==='fr'?'selected':''}>Français</option>
            <option value="ar" ${p.langue==='ar'?'selected':''}>Arabe</option>
            <option value="en" ${p.langue==='en'?'selected':''}>Anglais</option>
          </select></div>
        <div class="form-group"><label>Devise</label>
          <select id="p_devise">
            <option value="EUR" ${p.devise==='EUR'?'selected':''}>Euro (€)</option>
            <option value="USD" ${p.devise==='USD'?'selected':''}>Dollar ($)</option>
            <option value="TND" ${p.devise==='TND'?'selected':''}>Dinar (TND)</option>
          </select></div>
        <div class="form-group"><label>Fuseau horaire</label>
          <select id="p_fuseau">
            <option value="UTC+1" ${p.fuseau==='UTC+1'?'selected':''}>UTC+1 (Paris/Tunis)</option>
            <option value="UTC+0" ${p.fuseau==='UTC+0'?'selected':''}>UTC+0 (Londres)</option>
            <option value="UTC+3" ${p.fuseau==='UTC+3'?'selected':''}>UTC+3 (La Mecque)</option>
          </select></div>
      </div>
      <button class="btn-add" style="margin-top:12px" onclick="saveGeneralSettings()"><i class="bi bi-save"></i> Enregistrer</button>
    </div>

    <!-- Sécurité -->
    <div class="settings-block">
      <h3><i class="bi bi-shield-lock"></i> Sécurité</h3>
      <label class="toggle-row"><input type="checkbox" id="p_two_factor" ${p.two_factor==='1'?'checked':''}> Authentification à deux facteurs</label>
      <label class="toggle-row"><input type="checkbox" id="p_login_alerts" ${p.login_alerts==='1'?'checked':''}> Notifications de connexion</label>
      <div class="form-group" style="max-width:220px;margin-top:8px"><label>Durée de session (min)</label>
        <input type="number" id="p_session_timeout" value="${esc(p.session_timeout||'30')}" min="5" max="120"></div>
      <button class="btn-add" style="margin-top:12px" onclick="saveSecuritySettings()"><i class="bi bi-shield-lock"></i> Mettre à jour</button>
    </div>

    <!-- Notifications -->
    <div class="settings-block">
      <h3><i class="bi bi-bell"></i> Notifications</h3>
      <label class="toggle-row"><input type="checkbox" id="p_email_reservation" ${p.email_reservation==='1'?'checked':''}> Email pour nouvelle réservation</label>
      <label class="toggle-row"><input type="checkbox" id="p_email_new_user" ${p.email_new_user==='1'?'checked':''}> Email pour nouvel utilisateur</label>
      <label class="toggle-row"><input type="checkbox" id="p_email_rapport" ${p.email_rapport==='1'?'checked':''}> Rapport quotidien par email</label>
      <div class="form-group" style="margin-top:8px"><label>Email supplémentaire</label>
        <input type="email" id="p_email_notif" value="${esc(p.email_notif||'')}"></div>
      <button class="btn-add" style="margin-top:12px" onclick="saveNotifSettings()"><i class="bi bi-bell"></i> Enregistrer</button>
    </div>

    <!-- Infos système -->
    <div class="settings-block">
      <h3><i class="bi bi-info-circle"></i> Informations système</h3>
      <table class="sysinfo">
        <tr><td>Version</td><td>1.0.0</td></tr>
        <tr><td>PHP</td><td><?= PHP_VERSION ?></td></tr>
        <tr><td>Base de données</td><td>MySQL 8.0</td></tr>
        <tr><td>Serveur</td><td>XAMPP / Apache</td></tr>
      </table>
    </div>`;
}

// ============================================================
//  MODALES — helpers pour construire les champs
// ============================================================
function fieldsVoyage(v={}){
  return `
    <div class="form-group"><label>Nom *</label><input id="f_nom" value="${esc(v.nom||'')}" placeholder="Ex : Omra Ramadan"></div>
    <div class="form-group"><label>Destination *</label><input id="f_destination" value="${esc(v.destination||'')}" placeholder="Ex : La Mecque"></div>
    <div class="form-group"><label>Date de départ *</label><input type="date" id="f_date_depart" value="${v.date_depart||''}"></div>
    <div class="form-group"><label>Prix (€)</label><input type="number" id="f_prix" value="${v.prix||0}" min="0" step="0.01"></div>
    <div class="form-group"><label>Nombre de participants</label><input type="number" id="f_nb_personnes" value="${v.nb_personnes||1}" min="1"></div>
    <div class="form-group"><label>Description</label><textarea id="f_description">${esc(v.description||'')}</textarea></div>`;
}

function fieldsHotel(h={}){
  return `
    <div class="form-group"><label>Nom *</label><input id="f_nom" value="${esc(h.nom||'')}" placeholder="Ex : Hilton"></div>
    <div class="form-group"><label>Ville *</label><input id="f_ville" value="${esc(h.ville||'')}" placeholder="Ex : La Mecque"></div>
    <div class="form-group"><label>Étoiles</label>
      <select id="f_etoiles">
        ${[1,2,3,4,5].map(n=>`<option value="${n}" ${(h.etoiles==n)?'selected':''}>${n} étoile${n>1?'s':''}</option>`).join('')}
      </select></div>
    <div class="form-group"><label>Prix par nuit (€)</label><input type="number" id="f_prix_nuit" value="${h.prix_nuit||0}" min="0" step="0.01"></div>
    <div class="form-group"><label>Nombre de chambres</label><input type="number" id="f_nb_chambres" value="${h.nb_chambres||1}" min="1"></div>
    <div class="form-group"><label>Description</label><textarea id="f_description">${esc(h.description||'')}</textarea></div>`;
}

function fieldsUtilisateur(u={}, isEdit=false){
  return `
    <div class="form-group"><label>Nom *</label><input id="f_nom" value="${esc(u.nom||'')}" placeholder="Nom complet"></div>
    <div class="form-group"><label>Email *</label><input type="email" id="f_email" value="${esc(u.email||'')}" placeholder="email@exemple.com"></div>
    <div class="form-group"><label>Rôle</label>
      <select id="f_role">
        <option value="Client" ${u.role==='Client'?'selected':''}>Client</option>
        <option value="Admin"  ${u.role==='Admin'?'selected':''}>Admin</option>
      </select></div>
    <div class="form-group"><label>${isEdit?'Nouveau mot de passe (laisser vide pour ne pas changer)':'Mot de passe *'}</label>
      <input type="password" id="f_mot_de_passe" placeholder="••••••••"></div>`;
}

function fieldsReservation(x={}){
  const sel = window._selects || {voyages:[],hotels:[],utilisateurs:[]};
  const vOpts = sel.voyages.map(v=>`<option value="${v.id}" ${x.voyage_id==v.id?'selected':''}>${esc(v.nom)}</option>`).join('');
  const hOpts = sel.hotels.map(h=>`<option value="${h.id}" ${x.hotel_id==h.id?'selected':''}>${esc(h.nom)}</option>`).join('');
  const uOpts = sel.utilisateurs.map(u=>`<option value="${u.id}" ${x.utilisateur_id==u.id?'selected':''}>${esc(u.nom)}</option>`).join('');
  return `
    <div class="form-group"><label>Nom du client *</label><input id="f_client_nom" value="${esc(x.client_nom||'')}" placeholder="Nom du client"></div>
    <div class="form-group"><label>Utilisateur</label>
      <select id="f_utilisateur_id"><option value="">— Sélectionner —</option>${uOpts}</select></div>
    <div class="form-group"><label>Voyage</label>
      <select id="f_voyage_id"><option value="">— Sélectionner —</option>${vOpts}</select></div>
    <div class="form-group"><label>Hôtel</label>
      <select id="f_hotel_id"><option value="">— Sélectionner —</option>${hOpts}</select></div>
    <div class="form-group"><label>Nombre de personnes</label>
      <input type="number" id="f_nb_personnes" value="${x.nb_personnes||1}" min="1"></div>
    <div class="form-group"><label>Statut</label>
      <select id="f_statut">
        <option value="En attente" ${x.statut==='En attente'?'selected':''}>En attente</option>
        <option value="Confirmé"   ${x.statut==='Confirmé'?'selected':''}>Confirmé</option>
        <option value="Annulé"     ${x.statut==='Annulé'?'selected':''}>Annulé</option>
      </select></div>`;
}

// ============================================================
//  OPEN / CLOSE MODAL
// ============================================================
function openAddModal(entity){
  modalMode   = 'add';
  modalEntity = entity;
  editId      = 0;
  const titles = {voyage:'Ajouter un voyage',hotel:'Ajouter un hôtel',utilisateur:'Ajouter un utilisateur',reservation:'Ajouter une réservation'};
  $('modal-title').textContent = titles[entity]||'Ajouter';
  $('modal-fields').innerHTML  = buildFields(entity);
  $('modal').classList.add('active');
}

function buildFields(entity, data={}){
  if(entity==='voyage')      return fieldsVoyage(data);
  if(entity==='hotel')       return fieldsHotel(data);
  if(entity==='utilisateur') return fieldsUtilisateur(data, modalMode==='edit');
  if(entity==='reservation') return fieldsReservation(data);
  return '';
}

function closeModal(){ $('modal').classList.remove('active'); }
window.addEventListener('click', e=>{ if(e.target===$('modal')) closeModal(); });

// ============================================================
//  EDIT HANDLERS
// ============================================================
async function editVoyage(id){
  const r = await fetch(`api.php?entity=voyage&action=get&id=${id}`).then(x=>x.json());
  if(!r.success){ toast(r.message,'error'); return; }
  modalMode='edit'; modalEntity='voyage'; editId=id;
  $('modal-title').textContent='Modifier le voyage';
  $('modal-fields').innerHTML=fieldsVoyage(r.data);
  $('modal').classList.add('active');
}

async function editHotel(id){
  const r = await fetch(`api.php?entity=hotel&action=get&id=${id}`).then(x=>x.json());
  if(!r.success){ toast(r.message,'error'); return; }
  modalMode='edit'; modalEntity='hotel'; editId=id;
  $('modal-title').textContent='Modifier l\'hôtel';
  $('modal-fields').innerHTML=fieldsHotel(r.data);
  $('modal').classList.add('active');
}

async function editUtilisateur(id){
  const r = await fetch(`api.php?entity=utilisateur&action=get&id=${id}`).then(x=>x.json());
  if(!r.success){ toast(r.message,'error'); return; }
  modalMode='edit'; modalEntity='utilisateur'; editId=id;
  $('modal-title').textContent='Modifier l\'utilisateur';
  $('modal-fields').innerHTML=fieldsUtilisateur(r.data, true);
  $('modal').classList.add('active');
}

async function editReservation(id){
  // Ensure selects loaded
  if(!window._selects){
    const sel = await api('selects','list');
    window._selects = sel.success ? sel.data : {voyages:[],hotels:[],utilisateurs:[]};
  }
  const r = await fetch(`api.php?entity=reservation&action=get&id=${id}`).then(x=>x.json());
  if(!r.success){ toast(r.message,'error'); return; }
  modalMode='edit'; modalEntity='reservation'; editId=id;
  $('modal-title').textContent='Modifier la réservation';
  $('modal-fields').innerHTML=fieldsReservation(r.data);
  $('modal').classList.add('active');
}

// ============================================================
//  SUBMIT MODAL
// ============================================================
async function submitModal(){
  const btn = $('modal-submit-btn');
  btn.disabled=true;

  let body = {};
  const action = modalMode; // 'add' | 'edit'

  if(modalEntity==='voyage'){
    body = {
      nom:          getVal('f_nom'),
      destination:  getVal('f_destination'),
      date_depart:  getVal('f_date_depart'),
      prix:         getVal('f_prix'),
      nb_personnes: getVal('f_nb_personnes'),
      description:  getVal('f_description'),
    };
    if(modalMode==='edit') body.id = editId;
  }

  if(modalEntity==='hotel'){
    body = {
      nom:         getVal('f_nom'),
      ville:       getVal('f_ville'),
      etoiles:     getVal('f_etoiles'),
      prix_nuit:   getVal('f_prix_nuit'),
      nb_chambres: getVal('f_nb_chambres'),
      description: getVal('f_description'),
    };
    if(modalMode==='edit') body.id = editId;
  }

  if(modalEntity==='utilisateur'){
    body = {
      nom:          getVal('f_nom'),
      email:        getVal('f_email'),
      role:         getVal('f_role'),
      mot_de_passe: getVal('f_mot_de_passe'),
    };
    if(modalMode==='edit') body.id = editId;
  }

  if(modalEntity==='reservation'){
    body = {
      client_nom:     getVal('f_client_nom'),
      utilisateur_id: getVal('f_utilisateur_id'),
      voyage_id:      getVal('f_voyage_id'),
      hotel_id:       getVal('f_hotel_id'),
      nb_personnes:   getVal('f_nb_personnes'),
      statut:         getVal('f_statut'),
    };
    if(modalMode==='edit') body.id = editId;
  }

  const r = await api(modalEntity, action, body);
  btn.disabled=false;
  if(r.success){
    toast(r.message,'success');
    closeModal();
    navigate(currentPage);
  } else {
    toast(r.message,'error');
  }
}

function getVal(id){ const el=document.getElementById(id); return el?el.value:''; }

// ============================================================
//  DELETE
// ============================================================
async function deleteItem(entity, id, label){
  if(!confirm(`Supprimer ${label} #${id} ? Cette action est irréversible.`)) return;
  try {
    const res = await fetch(`api.php?entity=${entity}&action=delete&id=${id}`, {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: `id=${id}`
    });
    const r = await res.json();
    if(r.success){
      toast(r.message, 'success');
      navigate(currentPage);
    } else {
      toast(r.message, 'error');
    }
  } catch(e) {
    toast('Erreur de connexion au serveur', 'error');
  }
}

// ============================================================
//  PARAMÈTRES — sauvegarde
// ============================================================
async function saveGeneralSettings(){
  const body = {
    site_nom: getVal('p_site_nom'),
    langue:   getVal('p_langue'),
    devise:   getVal('p_devise'),
    fuseau:   getVal('p_fuseau'),
  };
  const r = await api('parametres','save',body);
  toast(r.message, r.success?'success':'error');
}

async function saveSecuritySettings(){
  const body = {
    two_factor:      document.getElementById('p_two_factor')?.checked?'1':'0',
    login_alerts:    document.getElementById('p_login_alerts')?.checked?'1':'0',
    session_timeout: getVal('p_session_timeout'),
  };
  const r = await api('parametres','save',body);
  toast(r.message, r.success?'success':'error');
}

async function saveNotifSettings(){
  const body = {
    email_reservation: document.getElementById('p_email_reservation')?.checked?'1':'0',
    email_new_user:    document.getElementById('p_email_new_user')?.checked?'1':'0',
    email_rapport:     document.getElementById('p_email_rapport')?.checked?'1':'0',
    email_notif:       getVal('p_email_notif'),
  };
  const r = await api('parametres','save',body);
  toast(r.message, r.success?'success':'error');
}

// ============================================================
//  XSS escape helper
// ============================================================
function esc(str){
  if(str===null||str===undefined) return '';
  return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

// ============================================================
//  INIT
// ============================================================
loadDashboard();
</script>
</body>
</html>
