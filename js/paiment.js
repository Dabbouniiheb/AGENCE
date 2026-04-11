document.addEventListener("DOMContentLoaded", () => {
    // === Variables pour l'en-tête (Header) ===
    let menu = document.querySelector('#menu-bar');
    let navbar = document.querySelector('.navbar');
    let searchBtn = document.querySelector('#search-btn');
    let searchBar = document.querySelector('.search-bar-container');
    let formBtn = document.querySelector('#login-btn');
    let formClose = document.querySelector('#form-close');
    let loginForm = document.querySelector('.login-form-container');

    if(menu){
        menu.addEventListener('click', () =>{
            menu.classList.toggle('fa-times');
            navbar.classList.toggle('active');
        });
    }

    if(searchBtn){
        searchBtn.addEventListener('click', () =>{
            searchBtn.classList.toggle('fa-times');
            searchBar.classList.toggle('active');
        });
    }

    if(formBtn){
        formBtn.addEventListener('click', () =>{
            loginForm.classList.add('active');
        });
    }
    
    if(formClose){
        formClose.addEventListener('click', () =>{
            loginForm.classList.remove('active');
        });
    }

    // === Logique spécifique pour le paiement ===
    
    // Gestion des onglets de méthode de paiement (Tabs)
    const paymentTabs = document.querySelectorAll('.payment-tabs button');
    paymentTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Retirer 'active' de tous les onglets
            paymentTabs.forEach(t => t.classList.remove('active'));
            // Ajouter 'active' sur l'onglet cliqué
            tab.classList.add('active');
        });
    });

    // Formatage dynamique du numéro de carte bancaire (xxxx xxxx xxxx xxxx)
    const cardInput = document.querySelector('input[name="card_number"]');
    if (cardInput) {
        cardInput.addEventListener('input', (e) => {
            // Supprimer tous les espaces et les caractères non numériques
            let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
            let formattedValue = '';
            for (let i = 0; i < value.length; i++) {
                if (i > 0 && i % 4 === 0) {
                    formattedValue += ' ';
                }
                formattedValue += value[i];
            }
            // Limiter à 19 caractères max (16 chiffres + 3 espaces)
            e.target.value = formattedValue.substring(0, 19);
        });
    }

    // Formatage dynamique de la date d'expiration (MM / YY)
    const expiryInput = document.querySelector('input[name="expiry"]');
    if (expiryInput) {
        expiryInput.addEventListener('input', (e) => {
            let value = e.target.value.replace(/\D/g, ''); // Uniquement les chiffres
            
            // Format automatique avec le slash
            if (value.length >= 3) {
                value = value.substring(0, 2) + ' / ' + value.substring(2, 4);
            }
            e.target.value = value;
        });
    }
    
    // Limitation du CVV à 3 (ou 4) chiffres max
    const cvvInput = document.querySelector('input[name="cvv"]');
    if (cvvInput) {
        cvvInput.addEventListener('input', (e) => {
            e.target.value = e.target.value.replace(/\D/g, '').substring(0, 4);
        });
    }
});
