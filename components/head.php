<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart & Product Display</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Navbar */
        .navbar-custom {
            background-color: #343a40;
            padding: 0.5rem 1rem;
        }

        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: #fff;
        }

        .navbar-custom .nav-link:hover {
            color: #ddd;
        }

        /* Cart Page Styles */
        .cart-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 15px;
        }

        .cart-item img {
            max-width: 100px;
            height: auto;
            margin-right: 15px;
        }

        .cart-item-details {
            flex-grow: 1;
        }

        .cart-item-name {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .cart-item-price {
            font-size: 1.1rem;
            color: #28a745;
        }

        .cart-item-quantity {
            font-size: 1rem;
        }

        .cart-total {
            font-size: 1.5rem;
            font-weight: bold;
            margin-top: 30px;
            text-align: right;
        }

        .checkout-btn {
            background-color: #28a745;
            color: white;
            font-size: 1.2rem;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .checkout-btn:hover {
            background-color: #218838;
        }

        .remove-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .remove-btn:hover {
            background-color: #c82333;
        }

        /* Product Display Styles */
        .product-card {
            position: relative;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            text-align: center;
            margin-bottom: 20px;
        }

        .product-card img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .product-name {
            font-weight: bold;
            margin: 10px 0 5px;
            font-size: 2rem;
        }

        .product-price {
            font-size: 1.1em;
            color: #28a745;
            margin-bottom: 10px;
        }

        .stock-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #dc3545;
            color: #fff;
            font-size: 0.9em;
            font-weight: bold;
            padding: 5px 12px;
            clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%);
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        }

        .nav-link-cart {
            position: relative;
        }

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -10px;
            background-color: #ff6f61;
            color: white;
            font-size: 0.8em;
            padding: 3px 6px;
            border-radius: 50%;
        }

        .product-detail {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-top: 30px;
        }

        .product-detail img {
            max-width: 100%;
            height: auto;
            object-fit: cover;
        }

        .product-description {
            max-width: 500px;
            margin-left: 20px;
        }

        .product-stock {
            font-size: 1.2rem;
            margin-bottom: 15px;
        }

        .add-to-cart-btn {
            background-color: #007bff;
            color: white;
            font-size: 1.2rem;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .add-to-cart-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
<!-- Your body content goes here -->
</body>

</html>
