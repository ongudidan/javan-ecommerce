<?php 
require('admin/modelClass.php');

if (isset($_GET['id'])) {

    $id = $_GET['id'];
    $database->query('SELECT * FROM products WHERE id = :id;');
    $database->bind(':id', $id);
    $database->execute();
    $row = $database->single();

}

?>

<?php include('components/head.php') ?>
    <!-- Navbar -->
<?php include('components/navbar.php') ?>

    <!-- Single Product View -->
    <div class="container">
        <div class="product-detail">
            <!-- Product Image -->
            <div class="col-md-6">
                    <img src="admin/uploads/<?= $row['thumbnail'] ?>" alt="Product 1">
            </div>

            <!-- Product Description -->
            <div class="col-md-6 product-description">
                <div class="product-name"><?= $row['name'] ?></div>
                <div class="product-price">Ksh. <?= number_format($row['price']) ?></div>
                <div class="product-stock">In Stock: <?= $row['stock'] ?></div>
                <div class="product-description-text">
                    <p><?= $row['description'] ?></p>
                </div>
                <a href="controllers/cartController.php?id=<?= $row['id'] ?>">
                <button class="add-to-cart-btn">Add to Cart</button>

                </a>
            </div>
        </div>
    </div>
<?php include('components/footer.php') ?>