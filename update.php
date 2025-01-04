<?php
include './connection.php';
include './components/header.php';

// Check if id is set and is a valid number
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Use prepared statements for the SELECT query
    $stmt = $conn->prepare("SELECT * FROM Products WHERE ProductID = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
} else {
    echo 'Invalid Product ID';
    exit;
}

// Check if the form was submitted
if (isset($_POST['submit'])) {
    $product_name = trim($_POST['product_name']);
    $price = trim($_POST['price']);
    $stock = trim($_POST['stock']);
    $description = trim($_POST['description']);

    // Check if all fields are filled
    if (!empty($product_name) && !empty($price) && !empty($stock) && !empty($description)) {
        // Use prepared statements for the UPDATE query
        $stmt = $conn->prepare("UPDATE Products SET ProductName = ?, Price = ?, Stock = ?, Description = ? WHERE ProductID = ?");

        // Bind parameters to the prepared statement
        $stmt->bind_param("ssssi", $product_name, $price, $stock, $description, $id);

        // Execute the query
        if ($stmt->execute()) {
            header("Location: ./products.php");
            exit();
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

<form method="POST" action="./update.php?id=<?php echo $id; ?>" class="container mt-4 p-4 border rounded bg-light shadow-sm">
    <div class="mb-3">
        <label for="product_name" class="form-label">Product Name</label>
        <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['ProductName']); ?>" id="product_name" name="product_name" placeholder="Enter product name">
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['Price']); ?>" id="price" name="price" placeholder="Enter price">
    </div>
    <div class="mb-3">
        <label for="stock" class="form-label">Stock</label>
        <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['Stock']); ?>" id="stock" name="stock" placeholder="Enter stock">
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['Description']); ?>" id="description" name="description" placeholder="Enter description">
    </div>
    <button name="submit" type="submit" class="btn btn-primary w-100">Submit</button>
</form>

<?php
include './components/footer.php';
?>