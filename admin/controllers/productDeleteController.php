<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('../modelClass.php');


        $id = $_GET['id'];

        // print_r($id);
        // exit();

        $database->query('DELETE FROM products WHERE id = :id;');
        $database->bind(':id', $id);
        $database->execute();
        header('location: ../products.php');