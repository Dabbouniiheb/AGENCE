<?php
$current_page = 'paiment';
$message = "";

// Form Processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = htmlspecialchars($_POST['fullname'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $phone = htmlspecialchars($_POST['phone'] ?? '');
    $cardNumber = htmlspecialchars($_POST['card_number'] ?? '');
    
    if (!empty($fullName) && !empty($email) && !empty($cardNumber)) {
        // Here you would connect to a database or payment gateway
        $message = "<div style='color: #155724; padding: 10px; background: #d4edda; margin-bottom: 20px; border: 1px solid #c3e6cb; border-radius: 5px; font-size: 1.5rem;'>
            Payment for <strong>$fullName</strong> has been processed successfully!
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
