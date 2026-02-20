/*let searchBtn = document.querySelector("#search-btn");
let searchBar = document.querySelector(".search-bar-container");
let formBtn = document.querySelector("#login-btn");
let loginForm = document.querySelector(".login-form-container");
let formClose = document.querySelector("#form-close");

window.onscroll = () =>{
    searchBtn.classlist.remove("fa-times");
    searchBtr.classlist.remove("active");
}
searchBtn.addEventListener("click",(),=>{
    searchBtn.classlist.toggle("fa-times");
    searchBtr.classlist.toggle("active");
});

formBtn.addEventListener("click",(),=>{
    
    searchBtr.classlist.add("active");
});

formClose.addEventListener("click",(),=>{
    
    searchBtr.classlist.remove("active");
});*/


var swiper = new Swiper(".review-slider", {
    spaceBetween:20,
    loop:true,
});

function clickReservation() {
    let reponse = confirm("Êtes-vous sûr de vouloir faire la réservation ?");
    
    if (reponse) {
        // Action si l'utilisateur clique sur "OK"
        console.log("Réservation confirmée");
    } else {
        // Action si utilisateur clique "Annuler"
        console.log("Réservation annulée");
    }
}





// Panier  (tableau normal)
let cart = [];
let total = 0;

// Ajouter voyage au panier
function addToCart(name, price) {
    cart.push({ name: name, price: price });
    total += price;
    alert("Voyage ajouté au panier !");
}

// Afficher panier
function displayCart() {
    let list = document.getElementById("cart-items");
    list.innerHTML = "";

    for (let i = 0; i < cart.length; i++) {
        list.innerHTML += `
            <li>
                ${cart[i].name} - ${cart[i].price} DT
                <button onclick="removeItem(${i})">❌</button>
            </li>
        `;
    }

    document.getElementById("total").innerText = total;
}

// Supprimer voyage
function removeItem(index) {
    total -= cart[index].price;
    cart.splice(index, 1);
    displayCart();
}

// Confirmation réservation
function confirmReservation() {
    let name = document.getElementById("name").value;
    let email = document.getElementById("email").value;

    if (cart.length === 0) {
        alert("Panier vide !");
        return;
    }

    if (name === "" || email === "") {
        alert("Remplir les informations !");
        return;
    }

    alert(
        "Réservation confirmée ✅\n" +
        "Client : " + name + "\n" +
        "Total : " + total + " DT"
    );

    // Reset
    cart = [];
    total = 0;
    displayCart();
}
