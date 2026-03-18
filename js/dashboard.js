// Sample data
        let voyages = [
            { id: 1, nom: "Omra Ramadan", destination: "La Mecque", date: "2026-03-20", prix: "1200", personnes: 45 },
            { id: 2, nom: "Hajj", destination: "La Mecque", date: "2026-06-25", prix: "3500", personnes: 100 },
            { id: 3, nom: "Visite Médine", destination: "Médine", date: "2026-04-10", prix: "800", personnes: 30 }
        ];

        let hotels = [
            { id: 1, nom: "Hilton", ville: "La Mecque", etoiles: 5, prix: "150", chambres: 120 },
            { id: 2, nom: "Ajyad", ville: "La Mecque", etoiles: 4, prix: "90", chambres: 200 },
            { id: 3, nom: "Pullman", ville: "Médine", etoiles: 5, prix: "130", chambres: 150 }
        ];

        let utilisateurs = [
            { id: 1, nom: "Ali", email: "ali@email.com", role: "Client", date: "2026-01-01" },
            { id: 2, nom: "Sami", email: "sami@email.com", role: "Client", date: "2026-02-12" },
            { id: 3, nom: "Fatima", email: "fatima@email.com", role: "Admin", date: "2026-02-20" }
        ];

        let reservations = [
            { id: 1, client: "Ali", voyage: "Omra Ramadan", hotel: "Hilton", personnes: 2, statut: "En attente" },
            { id: 2, client: "Sami", voyage: "Hajj", hotel: "Ajyad", personnes: 4, statut: "Annulé" },
            { id: 3, client: "Sami", voyage: "Visite", hotel: "Hilton", personnes: 4, statut: "Confirmé" }
        ];

        // Current page
        let currentPage = 'dashboard';
        let currentItemType = '';

        // DOM Elements
        const sidebarItems = document.querySelectorAll('.sidebar ul li');
        const cardsContainer = document.getElementById('cards-container');
        const dynamicContent = document.getElementById('dynamic-content');
        const modal = document.getElementById('modal');
        const modalTitle = document.getElementById('modal-title');
        const modalFields = document.getElementById('modal-fields');
        const modalForm = document.getElementById('modal-form');

        // Event listeners for sidebar
        sidebarItems.forEach(item => {
            item.addEventListener('click', function() {
                // Remove active class from all
                sidebarItems.forEach(i => i.classList.remove('active'));
                // Add active class to clicked
                this.classList.add('active');
                
                // Get page
                const page = this.getAttribute('data-page');
                currentPage = page;
                
                // Update content
                updateContent(page);
            });
        });

        // Update content based on page
        function updateContent(page) {
            // Hide cards if not dashboard
            if (page === 'dashboard') {
                cardsContainer.style.display = 'grid';
                showDashboard();
            } else {
                cardsContainer.style.display = 'none';
                
                // Show appropriate content
                switch(page) {
                    case 'voyages':
                        showVoyages();
                        break;
                    case 'hotels':
                        showHotels();
                        break;
                    case 'utilisateurs':
                        showUtilisateurs();
                        break;
                    case 'reservations':
                        showReservations();
                        break;
                    case 'parametres':
                        showParametres();
                        break;
                    case 'deconnexion':
                        // Handle logout
                        alert('Déconnexion...');
                        break;
                }
            }
        }

        // Show dashboard
        function showDashboard() {
            let html = `
                <div class="table-section">
                    <h2>Dernières réservations</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Voyage</th>
                                <th>Hôtel</th>
                                <th>Personnes</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
            `;
            
            reservations.forEach(res => {
                let statusClass = '';
                if (res.statut === 'En attente') statusClass = 'pending';
                else if (res.statut === 'Annulé') statusClass = 'cancel';
                else if (res.statut === 'Confirmé') statusClass = 'confirm';
                
                html += `
                    <tr>
                        <td>${res.client}</td>
                        <td>${res.voyage}</td>
                        <td>${res.hotel}</td>
                        <td>${res.personnes}</td>
                        <td><span class="${statusClass}">${res.statut}</span></td>
                    </tr>
                `;
            });
            
            html += `
                        </tbody>
                    </table>
                </div>
            `;
            
            dynamicContent.innerHTML = html;
        }

        // Show voyages
        function showVoyages() {
            let html = `
                <div class="content-section">
                    <div class="section-header">
                        <h2>Gestion des Voyages</h2>
                        <button class="btn-add" onclick="openModal('voyage')">
                            <i class="bi bi-plus-circle"></i> Ajouter un voyage
                        </button>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Destination</th>
                                <th>Date départ</th>
                                <th>Prix (€)</th>
                                <th>Participants</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
            `;
            
            voyages.forEach(v => {
                html += `
                    <tr>
                        <td>${v.id}</td>
                        <td>${v.nom}</td>
                        <td>${v.destination}</td>
                        <td>${v.date}</td>
                        <td>${v.prix} €</td>
                        <td>${v.personnes}</td>
                        <td class="action-icons">
                            <i class="bi bi-pencil-square" onclick="editItem('voyage', ${v.id})"></i>
                            <i class="bi bi-trash3 delete" onclick="deleteItem('voyage', ${v.id})"></i>
                        </td>
                    </tr>
                `;
            });
            
            html += `
                        </tbody>
                    </table>
                </div>
            `;
            
            dynamicContent.innerHTML = html;
        }

        // Show hotels
        function showHotels() {
            let html = `
                <div class="content-section">
                    <div class="section-header">
                        <h2>Gestion des Hôtels</h2>
                        <button class="btn-add" onclick="openModal('hotel')">
                            <i class="bi bi-plus-circle"></i> Ajouter un hôtel
                        </button>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Ville</th>
                                <th>Étoiles</th>
                                <th>Prix/nuit (€)</th>
                                <th>Chambres</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
            `;
            
            hotels.forEach(h => {
                let stars = '';
                for(let i = 0; i < h.etoiles; i++) {
                    stars += '⭐';
                }
                
                html += `
                    <tr>
                        <td>${h.id}</td>
                        <td>${h.nom}</td>
                        <td>${h.ville}</td>
                        <td>${stars}</td>
                        <td>${h.prix} €</td>
                        <td>${h.chambres}</td>
                        <td class="action-icons">
                            <i class="bi bi-pencil-square" onclick="editItem('hotel', ${h.id})"></i>
                            <i class="bi bi-trash3 delete" onclick="deleteItem('hotel', ${h.id})"></i>
                        </td>
                    </tr>
                `;
            });
            
            html += `
                        </tbody>
                    </table>
                </div>
            `;
            
            dynamicContent.innerHTML = html;
        }

        // Show utilisateurs
        function showUtilisateurs() {
            let html = `
                <div class="content-section">
                    <div class="section-header">
                        <h2>Gestion des Utilisateurs</h2>
                        <button class="btn-add" onclick="openModal('utilisateur')">
                            <i class="bi bi-plus-circle"></i> Ajouter un utilisateur
                        </button>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Rôle</th>
                                <th>Inscrit le</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
            `;
            
            utilisateurs.forEach(u => {
                html += `
                    <tr>
                        <td>${u.id}</td>
                        <td>${u.nom}</td>
                        <td>${u.email}</td>
                        <td><span class="${u.role === 'Admin' ? 'confirm' : 'pending'}">${u.role}</span></td>
                        <td>${u.date}</td>
                        <td class="action-icons">
                            <i class="bi bi-pencil-square" onclick="editItem('utilisateur', ${u.id})"></i>
                            <i class="bi bi-trash3 delete" onclick="deleteItem('utilisateur', ${u.id})"></i>
                        </td>
                    </tr>
                `;
            });
            
            html += `
                        </tbody>
                    </table>
                </div>
            `;
            
            dynamicContent.innerHTML = html;
        }

        // Show reservations
        function showReservations() {
            let html = `
                <div class="content-section">
                    <div class="section-header">
                        <h2>Gestion des Réservations</h2>
                        <button class="btn-add" onclick="openModal('reservation')">
                            <i class="bi bi-plus-circle"></i> Ajouter une réservation
                        </button>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Client</th>
                                <th>Voyage</th>
                                <th>Hôtel</th>
                                <th>Personnes</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
            `;
            
            reservations.forEach(r => {
                let statusClass = '';
                if (r.statut === 'En attente') statusClass = 'pending';
                else if (r.statut === 'Annulé') statusClass = 'cancel';
                else if (r.statut === 'Confirmé') statusClass = 'confirm';
                
                html += `
                    <tr>
                        <td>${r.id}</td>
                        <td>${r.client}</td>
                        <td>${r.voyage}</td>
                        <td>${r.hotel}</td>
                        <td>${r.personnes}</td>
                        <td><span class="${statusClass}">${r.statut}</span></td>
                        <td class="action-icons">
                            <i class="bi bi-pencil-square" onclick="editItem('reservation', ${r.id})"></i>
                            <i class="bi bi-trash3 delete" onclick="deleteItem('reservation', ${r.id})"></i>
                        </td>
                    </tr>
                `;
            });
            
            html += `
                        </tbody>
                    </table>
                </div>
            `;
            
            dynamicContent.innerHTML = html;
        }


        
        // Show parametres
        function showParametres() {
            let html = `
                <div class="content-section">
                    <h2>Paramètres</h2>
                    <p>Page des paramètres en cours de construction...</p>
                </div>
            `;
            
            dynamicContent.innerHTML = html;
        }

        // Open modal for adding
        function openModal(type) {
            currentItemType = type;
            modal.classList.add('active');
            
            let title = '';
            let fields = '';
            
            switch(type) {
                case 'voyage':
                    title = 'Ajouter un voyage';
                    fields = `
                        <div class="form-group">
                            <label>Nom du voyage</label>
                            <input type="text" id="nom" required>
                        </div>
                        <div class="form-group">
                            <label>Destination</label>
                            <input type="text" id="destination" required>
                        </div>
                        <div class="form-group">
                            <label>Date de départ</label>
                            <input type="date" id="date" required>
                        </div>
                        <div class="form-group">
                            <label>Prix (€)</label>
                            <input type="number" id="prix" required>
                        </div>
                        <div class="form-group">
                            <label>Nombre de participants max</label>
                            <input type="number" id="personnes" required>
                        </div>
                    `;
                    break;
                    
                case 'hotel':
                    title = 'Ajouter un hôtel';
                    fields = `
                        <div class="form-group">
                            <label>Nom de l'hôtel</label>
                            <input type="text" id="nom" required>
                        </div>
                        <div class="form-group">
                            <label>Ville</label>
                            <input type="text" id="ville" required>
                        </div>
                        <div class="form-group">
                            <label>Nombre d'étoiles</label>
                            <select id="etoiles" required>
                                <option value="1">1 ⭐</option>
                                <option value="2">2 ⭐⭐</option>
                                <option value="3">3 ⭐⭐⭐</option>
                                <option value="4">4 ⭐⭐⭐⭐</option>
                                <option value="5">5 ⭐⭐⭐⭐⭐</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Prix par nuit (€)</label>
                            <input type="number" id="prix" required>
                        </div>
                        <div class="form-group">
                            <label>Nombre de chambres</label>
                            <input type="number" id="chambres" required>
                        </div>
                    `;
                    break;
                    
                case 'utilisateur':
                    title = 'Ajouter un utilisateur';
                    fields = `
                        <div class="form-group">
                            <label>Nom complet</label>
                            <input type="text" id="nom" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" id="email" required>
                        </div>
                        <div class="form-group">
                            <label>Rôle</label>
                            <select id="role" required>
                                <option value="Client">Client</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Mot de passe</label>
                            <input type="password" id="password" required>
                        </div>
                    `;
                    break;
                    
                case 'reservation':
                    title = 'Ajouter une réservation';
                    
                    // Create options for voyages and hotels
                    let voyageOptions = '';
                    voyages.forEach(v => {
                        voyageOptions += `<option value="${v.nom}">${v.nom}</option>`;
                    });
                    
                    let hotelOptions = '';
                    hotels.forEach(h => {
                        hotelOptions += `<option value="${h.nom}">${h.nom}</option>`;
                    });
                    
                    fields = `
                        <div class="form-group">
                            <label>Client</label>
                            <input type="text" id="client" required>
                        </div>
                        <div class="form-group">
                            <label>Voyage</label>
                            <select id="voyage" required>
                                ${voyageOptions}
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Hôtel</label>
                            <select id="hotel" required>
                                ${hotelOptions}
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nombre de personnes</label>
                            <input type="number" id="personnes" required>
                        </div>
                        <div class="form-group">
                            <label>Statut</label>
                            <select id="statut" required>
                                <option value="En attente">En attente</option>
                                <option value="Confirmé">Confirmé</option>
                                <option value="Annulé">Annulé</option>
                            </select>
                        </div>
                    `;
                    break;
            }
            
            modalTitle.textContent = title;
            modalFields.innerHTML = fields;
        }

        // Close modal
        function closeModal() {
            modal.classList.remove('active');
        }

        // Handle form submit
        modalForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data based on type
            if (currentItemType === 'voyage') {
                const newVoyage = {
                    id: voyages.length + 1,
                    nom: document.getElementById('nom').value,
                    destination: document.getElementById('destination').value,
                    date: document.getElementById('date').value,
                    prix: document.getElementById('prix').value,
                    personnes: document.getElementById('personnes').value
                };
                voyages.push(newVoyage);
            }
            else if (currentItemType === 'hotel') {
                const newHotel = {
                    id: hotels.length + 1,
                    nom: document.getElementById('nom').value,
                    ville: document.getElementById('ville').value,
                    etoiles: parseInt(document.getElementById('etoiles').value),
                    prix: document.getElementById('prix').value,
                    chambres: document.getElementById('chambres').value
                };
                hotels.push(newHotel);
            }
            else if (currentItemType === 'utilisateur') {
                const newUser = {
                    id: utilisateurs.length + 1,
                    nom: document.getElementById('nom').value,
                    email: document.getElementById('email').value,
                    role: document.getElementById('role').value,
                    date: new Date().toISOString().split('T')[0]
                };
                utilisateurs.push(newUser);
            }
            else if (currentItemType === 'reservation') {
                const newRes = {
                    id: reservations.length + 1,
                    client: document.getElementById('client').value,
                    voyage: document.getElementById('voyage').value,
                    hotel: document.getElementById('hotel').value,
                    personnes: document.getElementById('personnes').value,
                    statut: document.getElementById('statut').value
                };
                reservations.push(newRes);
            }
            
            // Close modal and refresh content
            closeModal();
            updateContent(currentPage);
        });

        // Delete item
        function deleteItem(type, id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) {
                if (type === 'voyage') {
                    voyages = voyages.filter(v => v.id !== id);
                } else if (type === 'hotel') {
                    hotels = hotels.filter(h => h.id !== id);
                } else if (type === 'utilisateur') {
                    utilisateurs = utilisateurs.filter(u => u.id !== id);
                } else if (type === 'reservation') {
                    reservations = reservations.filter(r => r.id !== id);
                }
                
                updateContent(currentPage);
            }
        }

        // Edit item (simplified - just show alert for now)
        function editItem(type, id) {
            alert(`Modification de ${type} ID: ${id} (à implémenter avec un formulaire pré-rempli)`);
        }



        // ... (tout le code avant) ...

// Show reservations
function showReservations() {
    // ... code existant ...
}

// ===============================================
// REMPLACEZ L'ANCIENNE FONCTION showParametres PAR CELLE-CI
// ===============================================

//Show parametres 
function showParametres() {
    let html = `
        <div class="content-section">
            <h2>Paramètres</h2>
            
            <div style="margin-bottom: 30px;">
                <h3 style="color: #1e293b; margin-bottom: 15px;">👤 Profil administrateur</h3>
                <div style="background-color: #f8fafc; padding: 20px; border-radius: 10px;">
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                        <div class="form-group">
                            <label>Nom complet</label>
                            <input type="text" value="Admin Principal" style="background-color: white;" readonly>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" value="admin@example.com" style="background-color: white;" readonly>
                        </div>
                        <div class="form-group">
                            <label>Rôle</label>
                            <input type="text" value="Super Admin" style="background-color: white;" readonly>
                        </div>
                        <div class="form-group">
                            <label>Dernière connexion</label>
                            <input type="text" value="18/03/2026 14:30" style="background-color: white;" readonly>
                        </div>
                    </div>
                    <button class="btn-add" style="margin-top: 15px;" onclick="alert('Fonction de modification du profil à venir')">
                        <i class="bi bi-pencil-square"></i> Modifier le profil
                    </button>
                </div>
            </div>

            <div style="margin-bottom: 30px;">
                <h3 style="color: #1e293b; margin-bottom: 15px;">⚙️ Configuration générale</h3>
                <div style="background-color: #f8fafc; padding: 20px; border-radius: 10px;">
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                        <div class="form-group">
                            <label>Nom du site</label>
                            <input type="text" value="Agence de Voyages" id="siteName">
                        </div>
                        <div class="form-group">
                            <label>Langue par défaut</label>
                            <select id="defaultLanguage">
                                <option value="fr" selected>Français</option>
                                <option value="ar">Arabe</option>
                                <option value="en">Anglais</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Devise</label>
                            <select id="currency">
                                <option value="EUR" selected>Euro (€)</option>
                                <option value="USD">Dollar ($)</option>
                                <option value="MAD">Dirham (MAD)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Fuseau horaire</label>
                            <select id="timezone">
                                <option value="UTC+1" selected>UTC+1 (Paris)</option>
                                <option value="UTC+0">UTC+0 (Londres)</option>
                                <option value="UTC+3">UTC+3 (La Mecque)</option>
                            </select>
                        </div>
                    </div>
                    <button class="btn-add" style="margin-top: 15px;" onclick="saveGeneralSettings()">
                        <i class="bi bi-save"></i> Enregistrer
                    </button>
                </div>
            </div>

            <div style="margin-bottom: 30px;">
                <h3 style="color: #1e293b; margin-bottom: 15px;">🔐 Sécurité</h3>
                <div style="background-color: #f8fafc; padding: 20px; border-radius: 10px;">
                    <div style="margin-bottom: 15px;">
                        <label style="display: flex; align-items: center; gap: 10px;">
                            <input type="checkbox" checked id="twoFactor"> 
                            Activer l'authentification à deux facteurs
                        </label>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: flex; align-items: center; gap: 10px;">
                            <input type="checkbox" checked id="loginAlerts"> 
                            Notifications de connexion
                        </label>
                    </div>
                    <div class="form-group">
                        <label>Durée de session (minutes)</label>
                        <input type="number" value="30" id="sessionTimeout" min="5" max="120">
                    </div>
                    <button class="btn-add" style="margin-top: 15px;" onclick="saveSecuritySettings()">
                        <i class="bi bi-shield-lock"></i> Mettre à jour
                    </button>
                </div>
            </div>

            <div style="margin-bottom: 30px;">
                <h3 style="color: #1e293b; margin-bottom: 15px;">📧 Notifications</h3>
                <div style="background-color: #f8fafc; padding: 20px; border-radius: 10px;">
                    <div style="margin-bottom: 15px;">
                        <label style="display: flex; align-items: center; gap: 10px;">
                            <input type="checkbox" checked id="emailNewReservation"> 
                            Email pour nouvelle réservation
                        </label>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: flex; align-items: center; gap: 10px;">
                            <input type="checkbox" checked id="emailNewUser"> 
                            Email pour nouvel utilisateur
                        </label>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: flex; align-items: center; gap: 10px;">
                            <input type="checkbox" id="emailDailyReport"> 
                            Rapport quotidien par email
                        </label>
                    </div>
                    <div class="form-group">
                        <label>Email de notification supplémentaire</label>
                        <input type="email" value="notifications@example.com" id="additionalEmail">
                    </div>
                    <button class="btn-add" style="margin-top: 15px;" onclick="saveNotificationSettings()">
                        <i class="bi bi-bell"></i> Enregistrer
                    </button>
                </div>
            </div>

            <div style="margin-bottom: 30px;">
                <h3 style="color: #1e293b; margin-bottom: 15px;">💾 Sauvegarde</h3>
                <div style="background-color: #f8fafc; padding: 20px; border-radius: 10px;">
                    <p style="margin-bottom: 15px; color: #64748b;">Dernière sauvegarde : 18/03/2026 à 03:00</p>
                    <div style="display: flex; gap: 10px;">
                        <button class="btn-add" onclick="alert('Sauvegarde manuelle lancée')">
                            <i class="bi bi-cloud-upload"></i> Sauvegarder maintenant
                        </button>
                        <button class="btn-add" style="background-color: #10b981;" onclick="alert('Sauvegarde restaurée')">
                            <i class="bi bi-cloud-download"></i> Restaurer
                        </button>
                    </div>
                </div>
            </div>

            <div>
                <h3 style="color: #1e293b; margin-bottom: 15px;">ℹ️ Informations système</h3>
                <div style="background-color: #f8fafc; padding: 20px; border-radius: 10px;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="padding: 10px 0; color: #64748b;">Version</td>
                            <td style="padding: 10px 0;"><strong>1.0.0</strong></td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 0; color: #64748b;">Dernière mise à jour</td>
                            <td style="padding: 10px 0;"><strong>18/03/2026</strong></td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 0; color: #64748b;">Base de données</td>
                            <td style="padding: 10px 0;"><strong>MySQL 8.0</strong></td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 0; color: #64748b;">Espace utilisé</td>
                            <td style="padding: 10px 0;"><strong>245 MB / 1 GB</strong></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    `;
    
    dynamicContent.innerHTML = html;
}

// Fonctions de sauvegarde pour les paramètres
function saveGeneralSettings() {
    const siteName = document.getElementById('siteName').value;
    const language = document.getElementById('defaultLanguage').value;
    const currency = document.getElementById('currency').value;
    const timezone = document.getElementById('timezone').value;
    
    // Ici vous feriez normalement un appel API
    console.log('Paramètres généraux sauvegardés:', { siteName, language, currency, timezone });
    alert('Paramètres généraux enregistrés avec succès !');
}

function saveSecuritySettings() {
    const twoFactor = document.getElementById('twoFactor').checked;
    const loginAlerts = document.getElementById('loginAlerts').checked;
    const sessionTimeout = document.getElementById('sessionTimeout').value;
    
    console.log('Paramètres de sécurité:', { twoFactor, loginAlerts, sessionTimeout });
    alert('Paramètres de sécurité mis à jour !');
}

function saveNotificationSettings() {
    const newReservation = document.getElementById('emailNewReservation').checked;
    const newUser = document.getElementById('emailNewUser').checked;
    const dailyReport = document.getElementById('emailDailyReport').checked;
    const additionalEmail = document.getElementById('additionalEmail').value;
    
    console.log('Paramètres de notification:', { newReservation, newUser, dailyReport, additionalEmail });
    alert('Paramètres de notification enregistrés !');
}

// ===============================================
// CONTINUEZ AVEC LE RESTE DU CODE
// ===============================================

// Open modal for adding
function openModal(type) {
    // ... code existant ...
}

// ... (reste du code) ...