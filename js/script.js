/*let cart = [];
let total = 0;

// Ajouter au panier
function addToCart(voyage, price) {
    cart.push({ voyage, price });
    total += price;
    displayCart();
}

// Afficher panier
function displayCart() {
    let list = document.getElementById("cart-items");
    list.innerHTML = "";

    for (let i = 0; i < cart.length; i++) {
        list.innerHTML += `
            <li>
                ${cart[i].voyage} - ${cart[i].price} DT
                <button onclick="removeItem(${i})">❌</button>
            </li>
        `;
    }

    document.getElementById("total").innerText = total;
}

// Supprimer
function removeItem(index) {
    total -= cart[index].price;
    cart.splice(index, 1);
    displayCart();
}

// Confirmation
function confirmReservation() {
    let name = document.getElementById("name").value;
    let email = document.getElementById("email").value;

    if (cart.length === 0) {
        alert("Panier vide !");
        return;
    }

    if (name === "" || email === "") {
        alert("Remplir vos informations !");
        return;
    }

    alert("Réservation confirmée ✅\nTotal : " + total + " DT");

    cart = [];
    total = 0;
    displayCart();
}*/








/*let cart = [];

function addToCart(destination, price) {
    cart.push({destination, price});
    displayCart();
}

function displayCart() {
    const cartItems = document.getElementById('cart-items');
    cartItems.innerHTML = '';
    let total = 0;
    cart.forEach(item => {
        const li = document.createElement('li');
        li.textContent = `${item.destination} - ${item.price} DT`;
        cartItems.appendChild(li);
        total += item.price;
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
    alert(`Merci ${name}! Votre réservation de ${cart.length} voyages a été confirmée.`);
    cart = [];
    displayCart();
}*/








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
