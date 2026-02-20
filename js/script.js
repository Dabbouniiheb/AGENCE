let cart = [];
function addToCart(destination, price) {
    // Vérifie si le voyage est déjà dans le panier
    let existing = cart.find(item => item.destination === destination);
    if (existing) {
        existing.quantity += 1; // Augmente la quantité
    } else {
        cart.push({destination, price, quantity: 1});
    }
    displayCart();
}

function removeFromCart(destination) {
    cart = cart.filter(item => item.destination !== destination);
    displayCart();
}

function displayCart() {
    const cartItems = document.getElementById('cart-items');
    cartItems.innerHTML = '';
    let total = 0;

    cart.forEach(item => {
        const li = document.createElement('li');
        li.innerHTML = `${item.destination} (${item.quantity}) - ${item.price*item.quantity} $ 
                        <button onclick="removeFromCart('${item.destination}')">Supprimer</button>`;
        cartItems.appendChild(li);
        total += item.price * item.quantity;
    });

    document.getElementById('total').textContent = total;
}

function confirmReservation() {
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    if (!name || !email || cart.length === 0) {
        alert('Veuillez remplir vos informations et ajouter au moins un voyage.');
        return;
    }
    let summary = cart.map(i => `${i.destination} x${i.quantity}`).join(', ');
    alert(`Merci ${name}!\nVotre réservation pour ${summary} est confirmée.\nTotal : ${document.getElementById('total').textContent} $`);
    cart = [];
    displayCart();
}

/*Explications :

cart : tableau qui contient les voyages ajoutes.

addToCart() : ajoute le voyage, incremente la quantite si deja present.

removeFromCart() : supprime le voyage du panier.

displayCart() : met a jour la liste du panier et le total.

confirmReservation() : verifie que les champs sont remplis, affiche un resume avec quantite et total, puis vide le panier.*/
