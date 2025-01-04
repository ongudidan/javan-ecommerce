<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('admin/modelClass.php');

// Check if the product ID is passed and the remove action is triggered
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Query to delete the product from the cart based on product_id
    $database->query('DELETE FROM cart WHERE product_id = :product_id');
    $database->bind(':product_id', $product_id);
    $database->execute();

    // Redirect back to the cart page
    header('Location: cart.php');
    exit();
} else {
    echo "Invalid request.";
}
?>
