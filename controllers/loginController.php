<?php
session_start();
require('../admin/modelClass.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate email and password inputs
    $database->query('SELECT * FROM users WHERE email = :email');
    $database->bind(':email', $email);
    $user = $database->single();

    if ($user && password_verify($password, $user['pass'])) {
        $_SESSION['user_id'] = $user['id'];  // Assuming 'id' is the user ID field
        $_SESSION['email'] = $user['email'];
        header("Location: ../index.php");  // Redirect to dashboard or desired page
    } else {
        $error = "Invalid email or password!";
        header("Location: ../login.php?error=" . urlencode($error));
    }
}
?>
