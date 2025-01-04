<?php
include './connection.php';
 
include './components/header.php';
// Default SQL query
$sql = "SELECT * FROM Products";

// Apply price filters if form is submitted
if (isset($_POST['submit'])) {
    $conditions = [];
    if (!empty($_POST['min_price'])) $conditions[] = "price >= " . (float)$_POST['min_price'];
    if (!empty($_POST['max_price'])) $conditions[] = "price <= " . (float)$_POST['max_price'];
    if ($conditions) $sql .= " WHERE " . implode(' AND ', $conditions);
}

// Execute and display products
$result = $conn->query($sql);

?>


<form method="POST" action="./products.php" class="container mt-4">
    <div class="row mb-3">
        <label for="min_price" class="col-sm-2 col-form-label">Minimum Price:</label>
        <div class="col-sm-10">
            <input type="number" id="min_price" name="min_price" class="form-control" step="0.01" placeholder="0.00" min="0">
        </div>
    </div>
    <div class="row mb-3">
        <label for="max_price" class="col-sm-2 col-form-label">Maximum Price:</label>
        <div class="col-sm-10">
            <input type="number" id="max_price" name="max_price" class="form-control" step="0.01" placeholder="0.00" min="0">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 offset-sm-2">
            <button name="submit" type="submit" class="btn btn-primary">Filter</button>
        </div>
    </div>
</form>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Product Name</th>
            <th scope="col">Price</th>
            <th scope="col">Stock</th>
            <th scope="col">Description</th>
            <th scope="col">Update</th>
            <th scope="col">Delete</th>

        </tr>
    </thead>
    <tbody>
        <?php foreach ($result as $row) { ?>
            <tr>
                <th scope="row">1</th>
                <td><?php echo $row["ProductName"] ?></td>
                <td><?php echo $row["Price"] ?></td>
                <td><?php echo $row["Stock"] ?></td>
                <td><?php echo $row["Description"] ?></td>
                <td>
                    <a href="./update.php?id=<?php echo $row['ProductID'] ?>" class="btn btn-primary">Update</a>
                </td>
                <td>
                    <a href="./delete.php?id=<?php echo $row['ProductID'] ?>" class="btn btn-danger">Delete</a>
                </td>
            </tr>
        <?php } ?>

    </tbody>
</table>
<?php
include './components/footer.php';
?>