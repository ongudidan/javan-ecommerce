
<?php include('components/head.php') ?>

<?php
// session_start();
require('admin/modelClass.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?error=not_logged_in");
    exit;
}

// Get the logged-in user's ID
$userId = $_SESSION['user_id'];

// Query to join cart and products table, group by product_id and sum quantities for the logged-in user
$database->query('SELECT cart.product_id, SUM(cart.quantity) AS total_quantity, products.name, products.price, products.thumbnail 
                  FROM cart 
                  INNER JOIN products ON cart.product_id = products.id 
                  WHERE cart.user_id = :user_id 
                  GROUP BY cart.product_id, products.name, products.price, products.thumbnail');
$database->bind(':user_id', $userId);
$database->execute();
$data = $database->resultset();
?>


<!-- Navbar -->
<?php include('components/navbar.php') ?>

<!-- Cart Page -->
<div class="container py-5">
    <h2>Your Shopping Cart</h2>

    <!-- Loop through each cart item -->
    <?php 
    if (!empty($data)) { // Only display if $data is not empty
        $total = 0; // Initialize total for the cart
        foreach ($data as $row) { 
            $itemTotal = $row['price'] * $row['total_quantity']; // Calculate total for each product
            $total += $itemTotal; // Add the item total to the overall cart total
    ?>
  <div class="cart-item d-flex align-items-center mb-4 pb-3 border-bottom">
    <!-- Display product image -->
    <img src="admin/uploads/<?= htmlspecialchars($row['thumbnail']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" class="img-fluid" style="max-width: 100px; margin-right: 20px;">

    <div class="cart-item-details flex-grow-1">
        <!-- Display product name -->
        <div class="cart-item-name h5"><?= htmlspecialchars($row['name']) ?></div>
        <!-- Display product price -->
        <div class="cart-item-price text-success">Ksh. <?= number_format($row['price']) ?></div>
        
        <!-- Quantity Controls -->
        <div class="cart-item-quantity mt-2">
            <form action="update_cart.php" method="POST" class="d-flex align-items-center">
                <button type="submit" name="action" value="decrease" class="btn btn-outline-secondary btn-sm me-2">-</button>
                <input type="number" name="quantity" value="<?= htmlspecialchars($row['total_quantity']) ?>" min="1" class="form-control form-control-sm text-center" style="width: 60px;" readonly>
                <button type="submit" name="action" value="increase" class="btn btn-outline-secondary btn-sm ms-2">+</button>
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($row['product_id']) ?>">
            </form>
        </div>
    </div>
    
    <!-- Remove Button (Form for deleting the product from the cart) -->
    <form action="remove_from_cart.php" method="POST">
        <button type="submit" name="remove" value="1" class="remove-btn btn btn-danger btn-sm ms-3">Remove</button>
        <input type="hidden" name="product_id" value="<?= htmlspecialchars($row['product_id']) ?>">
    </form>
</div>

    <?php 
        }
    } else {
        echo "Your cart is empty.";
    }
    ?>

    <!-- Cart Total -->
    <div class="cart-total mt-4 text-end">
        Total: Ksh. <?= number_format($total) ?>
    </div>

    <!-- Checkout Button -->
     <a href="checkout.php">
     <button class="checkout-btn btn btn-success mt-3">Proceed to Checkout</button>
     </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
