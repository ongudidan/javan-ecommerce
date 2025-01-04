<?php 
include './connection.php';
$id  = $_GET['id'];
$sql = "DELETE FROM Products WHERE(ProductID = $id)";
$result = $conn->query($sql);
if($result){
    header('location: ./products.php');
    exit();
    // echo 'product deleted successfully';
} else echo 'error';
?>