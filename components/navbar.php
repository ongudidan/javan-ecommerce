<?php
// session_start();
// require('admin/modelClass.php'); // Include the model class to interact with the database

$totalQuantity = 0; // Default cart quantity

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Query to sum the quantity of all items in the cart for the logged-in user
    $database->query('SELECT SUM(quantity) AS total_quantity FROM cart WHERE user_id = :user_id');
    $database->bind(':user_id', $userId);
    $database->execute();

    // Fetch the result and set total quantity
    $result = $database->single();
    $totalQuantity = $result['total_quantity'] ?? 0;
} else {
    // Redirect to login if accessing a protected page
    if (basename($_SERVER['PHP_SELF']) == 'cart.php') {
        header("Location: ../login.php?error=not_logged_in");
        exit;
    }
}
?>

<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">My Shop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="shop.php">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-cart" href="cart.php">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-badge"><?= htmlspecialchars($totalQuantity) ?></span>
                    </a>
                </li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="account-settings.php">Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
