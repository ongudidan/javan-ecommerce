<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('../modelClass.php');

if (isset($_POST['submit'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Ensure all fields are filled
    if (empty($first_name) || empty($last_name) || empty($email) || empty($role)) {
        $_SESSION['user_error'] = "Fill all the fields";
        header("location: ../editUser.php");
        exit();
    }

    // Check if session ID is set
    if (!isset($_SESSION['id'])) {
        $_SESSION['user_error'] = "User ID is not set";
        header("location: ../editUser.php");
        exit();
    }

    $id = $_SESSION['id'];

    $database->query('SELECT * FROM users WHERE id = :id;');
    $database->bind(':id', $id);
    $database->execute();
    $row = $database->single();

    if ($row) {
        // Update user if exists
        $database->query('UPDATE users
            SET 
            first_name = :first_name,
            last_name = :last_name,
            email = :email,
            role = :role
            WHERE id = :id');
        $database->bind(':first_name', $first_name);
        $database->bind(':last_name', $last_name);
        $database->bind(':email', $email);
        $database->bind(':role', $role);
        $database->bind(':id', $id);
        $database->execute();
        echo "Update successful";
    } else {
        // Insert new user
        $database->query('INSERT INTO users (first_name, last_name, email, role) VALUES (:first_name, :last_name, :email, :role)');
        $database->bind(':first_name', $first_name);
        $database->bind(':last_name', $last_name);
        $database->bind(':role', $role);
        $database->bind(':email', $email);
        $database->execute();
        echo "Insert successful";
    }

    // Redirect after operation
    header('location: ../users.php');
    unset($_SESSION['id']);
}
?>
