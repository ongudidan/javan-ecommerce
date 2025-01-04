<?php
include './connection.php';

include './components/header.php';

if(isset($_POST['submit'])){
    // print_r($_POST);

    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];

    if(isset($product_name) && isset($price) && isset($stock) && isset($description)) {
    
        // Use prepared statements to protect against SQL injection
        $stmt = $conn->prepare("INSERT INTO products (ProductName, Price, Stock, Description) VALUES (?, ?, ?, ?)");
    
        // Bind parameters to the prepared statement (s for string, d for double/decimal)
        $stmt->bind_param("ssss", $product_name, $price, $stock, $description);
    
        // Execute the query
        if($stmt->execute()) {
            echo 'Product saved successfully';
        } else {
            echo 'Error on save: ' . $stmt->error;
        }
    
        // Close the statement
        $stmt->close();
    
    } else {
        echo 'Fill all the inputs';

    }  
}
?>

<form method="POST" action="./admin.php" class="container mt-4 p-4 border rounded bg-light shadow-sm">
    <div class="mb-3">
        <label for="product_name" class="form-label">Product Name</label>
        <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter product name">
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="text" class="form-control" id="price" name="price" placeholder="Enter price">
    </div>
    <div class="mb-3">
        <label for="stock" class="form-label">Stock</label>
        <input type="text" class="form-control" id="stock" name="stock" placeholder="Enter stock">
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <input type="text" class="form-control" id="description" name="description" placeholder="Enter description">
    </div>
    <button name="submit" type="submit" class="btn btn-primary w-100">Submit</button>
</form>

<?php
include './components/footer.php';
?>