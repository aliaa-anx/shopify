<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize variables
$counter = 0;
$userName = 'Guest';
$userId = null;

try {
    require_once __DIR__ . '/../../Controllers/Middleware.php';
    require_once __DIR__ . '/../../Models/Cart.php';
    
    // Use your Middleware to authenticate
    $user = \Controllers\Middleware::authenticate();
    
    // Get user data from JWT
    $userId = $user['id'];
    $userName = htmlspecialchars($user['name']);
    
    // Get cart count
    $cart = new Cart();
    $counter = $cart->showNumOfItems($userId);

} catch (Exception $e) {
    // Log error but continue rendering header
    error_log("Header error: " . $e->getMessage());
    // User will be shown as "Guest"
}
?>
<!-- Start Header -->
<header>
    <div class="container">
        <div class="logo">
            <img src="../assets/images/woman.png" alt="">Fashonista
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="reviews.php">Reviews</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact us</a></li>
                <li><a href="search.php"><i class="fa-solid fa-search"></i></a></li>
                <li><a href="products.php"><i class="fa-solid fa-shirt"></i></a></li>
                <li>
                    <a href="cart.php">
                        <i class="fa-solid fa-cart-shopping">
                            <?php if ($counter > 0): ?>
                                <span class="counter"><?= $counter ?></span>
                            <?php endif; ?>
                        </i>
                    </a>
                </li>
                <li>
                    <a href="userProfile.php" class="user" title="Check Your Profile">
                        <i class="fa fa-user"></i>
                        <span><?= $userName ?></span>
                    </a>
                </li> 
                <li>
                    <a href="../Auth/logout.php" title="Logout?">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>
<!-- End Header -->