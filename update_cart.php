<?php
require('admin/modelClass.php');

// Get the product ID and action (increase or decrease) from the form submission
$product_id = $_POST['product_id'];
$action = $_POST['action'];  // Either 'increase' or 'decrease'

// Fetch the current quantity from the cart for the specific product
$database->query('SELECT quantity FROM cart WHERE product_id = :product_id');
$database->bind(':product_id', $product_id);
$current_quantity = $database->single()['quantity'];

// Adjust the quantity based on the action
if ($action == 'increase') {
    $new_quantity = $current_quantity + 1;  // Increase the quantity by 1
} elseif ($action == 'decrease' && $current_quantity > 1) {
    $new_quantity = $current_quantity - 1;  // Decrease the quantity by 1
} else {
    $new_quantity = $current_quantity;  // If the quantity is 1, prevent it from going below 1
}

// Update the cart with the new quantity
$database->query('UPDATE cart SET quantity = :quantity WHERE product_id = :product_id');
$database->bind(':quantity', $new_quantity);
$database->bind(':product_id', $product_id);
$database->execute();

// Redirect back to the cart page
header('Location: cart.php');
exit();
?>
