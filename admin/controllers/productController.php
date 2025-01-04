<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('../modelClass.php');

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $thumbnail = $_FILES['thumbnail'];

    $thumbnailName = $thumbnail['name'];
    $thumbnailType = $thumbnail['type'];
    $thumbnailTmpName = $thumbnail['tmp_name'];
    $thumbnailError = $thumbnail['error'];
    $thumbnailSize = $thumbnail['size'];

    // Separate the file extension from the name
    $thumbnailExt = explode('.', $thumbnailName);
    $thumbnailActualExt = strtolower(end($thumbnailExt));

    // File extensions allowed
    $allowed = array('png', 'jpeg', 'jpg');


    // $id = $_GET['id'];


    // print_r($thumbnail);
    // exit();

    if ($thumbnailSize < 9000000) {

        $thumbnailNameNew = uniqid('', true) . '.' . $thumbnailActualExt;

        $thumbnailDestination = '../uploads/' . $thumbnailNameNew;

        move_uploaded_file($thumbnailTmpName, $thumbnailDestination);

        if (empty($name) || empty($description) || empty($price) || empty($stock)) {
            $_SESSION['product_error'] = "Fill all the fields";

            header("location: ../editProduct.php");
            exit();
        }

        $id = $_SESSION['id'];

        $database->query('SELECT * FROM products WHERE id = :id;');
        $database->bind(':id', $id);

        $database->execute();
        $row = $database->single();

        // print_r($row);
        // exit();

        if ($row > 0) {

            $database->query('UPDATE products
            SET 
            name = :name,
            description = :description,
            price = :price,
            stock = :stock,
            thumbnail = :thumbnail
             WHERE id = :id');
            $database->bind(':name', $name);
            $database->bind(':description', $description);
            $database->bind(':stock', $stock);
            $database->bind(':price', $price);
            $database->bind(':id', $id);
            $database->bind(':thumbnail', $thumbnailNameNew);

            $database->execute();
            echo "update successful";
            header('location: ../products.php');
        } else {

            $database->query('INSERT INTO products(name, description, price, stock) VALUES(:name, :description, :price, :stock)');
            $database->bind(':name', $name);
            $database->bind(':description', $description);
            $database->bind(':stock', $stock);
            $database->bind(':price', $price);

            $database->execute();
            echo "insert successful";
            header('location: ../products.php');
        }

        unset($_SESSION['id']);
    } else {
        echo "Your file is too big";
    }
}
