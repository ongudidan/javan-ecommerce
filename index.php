
<?php include('components/head.php') ?>

<?php
require('admin/modelClass.php');
// session_start();


$database->query('SELECT * FROM products');
$database->execute();
$data = $database->resultset();
?>

<!-- Navbar -->
<?php include('components/navbar.php') ?>

<!-- Product Section -->
<div class="container py-5">
    <div class="row">
        <!-- Product 1 -->
        <?php foreach ($data as $row) { ?>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="product-card">
                    <span class="stock-badge"><?= $row['stock'] ?></span>
                    <a href="product-details.php?id=<?= $row['id'] ?>">
                        <!-- Added Bootstrap class 'img-fluid' and custom styling for consistent size -->
                        <img src="admin/uploads/<?= $row['thumbnail'] ?>" alt="Product 1" class="img-fluid" style="height: 200px; object-fit: cover;">
                    </a>
                    <div class="p-3">
                        <div class="product-name"><?= $row['name'] ?></div>
                        <div class="product-price">Ksh. <?= number_format($row['price']) ?></div>

                        <a href="controllers/cartController.php?id=<?= $row['id'] ?>">
                            <button class="add-to-cart-btn">Add to Cart</button>
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <?= $_SESSION['user_id'] ?>
</div>
<?php include('components/footer.php') ?>