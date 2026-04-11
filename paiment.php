<?php
// Inclusion de la configuration de base de données
require_once __DIR__ . '/db_paiment.php';

$current_page = 'paiment';
$message = "";

// Form Processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Récupération et nettoyage strict avec trim() et htmlspecialchars()
    $fullName = htmlspecialchars(trim($_POST['fullname'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    
    $cardNumber = htmlspecialchars(trim($_POST['card_number'] ?? ''));
    $expiry = htmlspecialchars(trim($_POST['expiry'] ?? ''));
    $cvv = htmlspecialchars(trim($_POST['cvv'] ?? ''));
    
    $address = htmlspecialchars(trim($_POST['address'] ?? ''));
    $city = htmlspecialchars(trim($_POST['city'] ?? ''));
    $zip = htmlspecialchars(trim($_POST['zip'] ?? ''));
    $promoCode = htmlspecialchars(trim($_POST['promo_code'] ?? ''));
    
    // Valeurs par défaut pour la démo
    $paymentMethod = "Credit Card"; // Fixé pour le moment
    $totalPrice = 7000.00; // Total affiché dans le HTML et non passé par form

    // 2. Vérification que les champs obligatoires ne sont pas vides
    if (!empty($fullName) && !empty($email) && !empty($phone) && !empty($cardNumber)) {
        
        // 3. (SÉCURITÉ) Ne JAMAIS sauvegarder la carte entière ni le CVV en DB. 
        // On stocke uniquement les 4 derniers chiffres
        $cardNumberCleaned = str_replace(' ', '', $cardNumber); // Retire les espaces
        $safeCardNumber = '**** **** **** ' . substr($cardNumberCleaned, -4);
        
        // 4. (SÉCURITÉ SQL) Utilisation des requêtes préparées via PDO (Empêche l'Injection SQL)
        try {
            $sql = "INSERT INTO paiements 
                    (fullname, email, phone, card_number, expiry, cvv, address, city, zip, promo_code, payment_method, total_price) 
                    VALUES 
                    (:fullname, :email, :phone, :card_number, :expiry, :cvv, :address, :city, :zip, :promo_code, :payment_method, :total_price)";
                    
            $stmt = $pdo->prepare($sql);
            
            // Liaison des valeurs avec sécurité
            $stmt->execute([
                ':fullname' => $fullName,
                ':email' => $email,
                ':phone' => $phone,
                ':card_number' => $safeCardNumber, 
                ':expiry' => $expiry, 
                ':cvv' => '***', // Ne pas stocker le CVV !
                ':address' => $address,
                ':city' => $city,
                ':zip' => $zip,
                ':promo_code' => $promoCode,
                ':payment_method' => $paymentMethod,
                ':total_price' => $totalPrice
            ]);
            
            // Message de succès avec couleur verte
            $message = "<div style='color: #155724; padding: 10px; background: #d4edda; margin-bottom: 20px; border: 1px solid #c3e6cb; border-radius: 5px; font-size: 1.5rem;'>
                Le paiement pour <strong>$fullName</strong> a été traité et sauvegardé avec succès dans la base de données !
            </div>";
            
        } catch (PDOException $e) {
            // Affichage de l'erreur DB
            $message = "<div style='color: #721c24; padding: 10px; background: #f8d7da; margin-bottom: 20px; border: 1px solid #f5c6cb; border-radius: 5px; font-size: 1.5rem;'>
                Erreur Base de données : " . $e->getMessage() . "
            </div>";
        }
        
    } else {
        $message = "<div style='color: #856404; padding: 10px; background: #fff3cd; margin-bottom: 20px; border: 1px solid #ffeeba; border-radius: 5px; font-size: 1.5rem;'>
            Veuillez remplir toutes les informations obligatoires (Nom, Email, Téléphone, Carte).
        </div>";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Agency - Paiement</title>
    <!-- Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    
    <!-- CSS -->
    <!-- We link paiment.css which now contains all the necessary design for header, footer and payment form -->
    <link rel="stylesheet" href="css/paiment.css">
</head>
<body>

    <!-- Inclusion propre de l'en-tête (Header) via PHP -->
    <?php include __DIR__ . "/includes/header.php"; ?>

    <div class="container">
        <!-- Message de succession -->
        <?php if (!empty($message)) echo $message; ?>
        
        <div class="progress">
            <div>Trip</div>
            <div>Details</div>
            <div class="active">Payment</div>
        </div>

        <div class="main">
            <!-- Left Form -->
            <div class="form-card">
                <h3>Customer Information</h3>
                
                <form action="paiment.php" method="POST">
                    <label>Full Name</label>
                    <input type="text" name="fullname" placeholder="John Doe" required>
                    
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="email@example.com" required>
                    
                    <label>Phone Number</label>
                    <input type="text" name="phone" placeholder="+216 XXX XXX XXX" required>

                    <h3>Payment Method</h3>
                    <div class="payment-tabs">
                        <button type="button" class="active">Credit Card</button>
                        <button type="button">PayPal</button>
                        <button type="button">Cash</button>
                    </div>
                    
                    <label>Card Number</label>
                    <input type="text" name="card_number" placeholder="1234 5678 9012 3456" required>
                    
                    <div class="billing">
                        <input type="text" name="expiry" placeholder="MM / YY" required>
                        <input type="text" name="cvv" placeholder="CVV" required>
                    </div>

                    <h3>Billing Address (Optional)</h3>
                    <input type="text" name="address" placeholder="Street Address">
                    <div class="billing">
                        <input type="text" name="city" placeholder="City">
                        <input type="text" name="zip" placeholder="ZIP Code">
                    </div>

                    <div class="checkbox">
                        <input type="checkbox" id="terms" required> I agree to the <a href="#">Terms & Conditions</a>
                    </div>

                    <button type="submit" class="btn">Pay Now</button>
                </form>
            </div>

            <!-- Right Summary -->
            <div class="summary-card">
                <h4>Trip Summary</h4>
                <p>Destination: Makkah</p>
                <p>Hotel: Hilton ⭐⭐⭐⭐⭐</p>
                <p>Dates: 12 Aug - 20 Aug</p>

                <h4>Price Details</h4>
                <p>Subtotal: 6500 TND</p>
                <p>Taxes: 500 TND</p>
                <p class="price">Total: 7000 TND</p>

                <div class="promo">
                    <form action="" method="POST">
                        <input type="text" name="promo_code" placeholder="Promo Code">
                        <button type="button">Apply</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Inclusion propre du pied de page (Footer) via PHP -->
    <?php include __DIR__ . "/includes/footer.php"; ?>

    <!-- Script contenant la logique spécifique du menu, bouton login et page de paiement -->
    <script src="js/paiment.js"></script>
</body>
</html>
