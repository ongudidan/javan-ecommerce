
<?php include('components/head.php') ?>

<?php
require('admin/modelClass.php');

// Check if user_id exists in the session
if (!isset($_SESSION['user_id'])) {
    // If user is not logged in, redirect to the login page or show an error message
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id']; // Get the logged-in user ID

// Query to join cart and products table, filter by user_id, and sum quantities
$database->query('
    SELECT cart.product_id, SUM(cart.quantity) AS total_quantity, products.name, products.price, products.thumbnail
    FROM cart 
    INNER JOIN products ON cart.product_id = products.id
    WHERE cart.user_id = :user_id
    GROUP BY cart.product_id, products.name, products.price, products.thumbnail
');
$database->bind(':user_id', $userId); // Bind the user_id to the query
$database->execute();
$data = $database->resultset();

// Debugging: Check if $data is populated
if (empty($data)) {
    echo "No items found in your cart.";
    var_dump($data); // This will show what $data contains (or if it's empty)
}
?>
<!-- Navbar -->
<?php include('components/navbar.php') ?>


<!-- Checkout Page -->
<div class="container checkout-section">
    <h2>Checkout</h2>
    <div class="row">
        <!-- Checkout Form -->
        <div class="col-md-6">
            <form class="checkout-form">
                <h4>Billing Information</h4>

                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" required>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Shipping Address</label>
                    <input type="text" class="form-control" id="address" required>
                </div>

                <div class="mb-3">
                    <label for="city" class="form-label">City</label>
                    <input type="text" class="form-control" id="city" required>
                </div>

                <div class="mb-3">
                    <label for="country" class="form-label">Country</label>
                    <select class="form-select" id="country" required>
                        <option selected disabled>Choose your country</option>
                        <option value="USA">United States</option>
                        <option value="Canada">Canada</option>
                        <option value="UK">United Kingdom</option>
                        <!-- Add more countries as needed -->
                    </select>
                </div>

                <div class="mb-3">
                    <label for="payment" class="form-label">Payment Method</label>
                    <select class="form-select" id="payment" required>
                        <option selected disabled>Choose payment method</option>
                        <option value="Credit Card">Credit Card</option>
                        <option value="PayPal">PayPal</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                    </select>
                </div>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="col-md-6 checkout-summary">
            <h4>Order Summary</h4>
            <table class="table table-bordered order-summary-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($data)) { // Only display if $data is not empty
                        $total = 0; // Initialize total for the cart
                        foreach ($data as $row) {
                            $itemTotal = $row['price'] * $row['total_quantity']; // Calculate total for each product
                            $total += $itemTotal; // Add the item total to the overall cart total
                    ?>
                            <tr>
                                <td><?= $row['name'] ?></td>
                                <td><?= number_format($row['total_quantity']) ?></td>
                                <td>Ksh. <?= number_format($row['price']) ?></td>
                            </tr>

                    <?php }
                    } ?>
                </tbody>
            </table>
            <div class="total-price">
                Total: Ksh. <?= number_format($total) ?>
            </div>

            <button class="checkout-btn">Complete Order</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
