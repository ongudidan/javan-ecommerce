<?php
session_start();
require('../admin/modelClass.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        header("Location: ../signup.php?error=password_mismatch");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $database->query('SELECT * FROM users WHERE email = :email');
    $database->bind(':email', $email);
    $existing_user = $database->single();

    if ($existing_user) {
        header("Location: ../signup.php?error=email_taken");
        exit();
    }

    $database->query('INSERT INTO users (first_name, last_name, email, pass) VALUES (:first_name, :last_name, :email, :pass)');
    $database->bind(':first_name', $first_name);
    $database->bind(':last_name', $last_name);
    $database->bind(':email', $email);
    $database->bind(':pass', $hashed_password);

    try {
        $database->execute();
        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $database->lastInsertId();
        header("Location: ../login.php");
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
