<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('../admin/modelClass.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php"); // Replace login.php with your actual login page
    exit();
}

// Get the product ID from the URL (passed as a query parameter)
$product_id = $_GET['id'];
$quantity = 1; // Default quantity is 1

// Get the logged-in user's ID from session
$user_id = $_SESSION['user_id']; // Make sure this is set when the user logs in

// Check if the product already exists in the cart for the logged-in user
$database->query('SELECT quantity FROM cart WHERE product_id = :product_id AND user_id = :user_id');
$database->bind(':product_id', $product_id);
$database->bind(':user_id', $user_id);
$existingProduct = $database->single(); // Fetch the result

if ($existingProduct) {
    // If the product exists in the cart, increase the quantity by 1
    $new_quantity = $existingProduct['quantity'] + 1;

    // Update the cart with the new quantity
    $database->query('UPDATE cart SET quantity = :quantity WHERE product_id = :product_id AND user_id = :user_id');
    $database->bind(':quantity', $new_quantity);
    $database->bind(':product_id', $product_id);
    $database->bind(':user_id', $user_id);
    $database->execute();
    echo "Quantity updated successfully.";
} else {
    // If the product does not exist in the cart, insert a new record with the user_id
    $database->query('INSERT INTO cart (product_id, quantity, user_id) VALUES (:product_id, :quantity, :user_id)');
    $database->bind(':product_id', $product_id);
    $database->bind(':quantity', $quantity);
    $database->bind(':user_id', $user_id);
    $database->execute();
    echo "Product added to cart.";
}

// Redirect after operation
header('Location: ../index.php');
exit();
?>
