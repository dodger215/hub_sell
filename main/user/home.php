<?php 

$select_1 = "select";
$select_2 = "non";
?>

<?php  

require('../include/node/function.php');
require('../include/node/config.php');


if(!isset($_SESSION['auth'])){
	redirect("../signin.php", "Try again");
}

$intro = $_SESSION['status'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('header/header.php') ?>

    <style>
        .main-nav .select {
            color: rgb(20, 21, 170);
        }
        @media (max-width: 576px) { /* Mobile screens */
            .orders_page {
                padding: 15px;
            }

            .card {
                max-width: 100%; /* Full width for mobile */
            }

            .img-fluid {
                height: auto;
                max-height: 250px; /* Slightly smaller images on mobile */
            }

            .btn {
                font-size: 14px; /* Adjust button size for mobile */
            }
        }

        #popupContainer {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
            justify-content: center;
            align-items: center;
        }

        /* Pop-up content */
        #popupContent {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            text-align: center;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }

        /* Buttons */
        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            margin: 10px 5px;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
    </style>
</head>
<body>

<?php require('header/nav.php')?>

<div class="wrapper">
    <section class="orders_page mb-4" style="max-width: 100%; height: auto;">
        <div class="d-flex justify-content-between align-items-center main">
            <!-- Add order icon -->
            <i class="fas fa-box-open fa-2x"></i> <!-- Example icon for order -->
            <h5 class="mb-0">Orders</h5>
        </div>

        <form>
            <ul class="list-unstyled" id="product-list"></ul>
        </form>

    </section>
    <div class="dialog-box"><?= $_SESSION['status']?></div>
</div>

<?php 
$query = mysqli_query($conn, "SELECT * FROM register WHERE unique_id = '{$_SESSION['auth']}'");

$place = mysqli_fetch_array($query);

?>

<div id="popupContainer">
    <div id="popupContent">
        <!-- Product Description -->
        <p id="productDescription"></p>

        <!-- Buttons: Back and Order -->
        <button class="btn btn-secondary" onclick="closePopup()">Back</button>

        <!-- Order Form -->
        <form method="POST" action="api/order_product.php">
            <label>Your place or change location:</label>
            <input type="hidden" name="product_id" id="popupProductId">
            <input class="form-control" type="text" name="loc" value="<?= $place['location'] ?> ">
            <textarea class="form-control mt-2" placeholder="Commit..." name="commit"></textarea>
            <button type="submit" class="btn btn-primary">Order</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>

    async function fetchProducts() {
        try {
            const response = await fetch('../admin/api/products_data.json'); 
            const products = await response.json(); 

            const productList = document.getElementById('product-list');

            products.forEach(product => {
                const productCard = `
                    <li>
                        <div class="card mb-3" style="width: 100%; height: auto;">
                            <div class="card-body">

                                <!-- User and options -->
                                <div class="view d-flex justify-content-between">
        
                                    <span class="name">Product name: ${product.title}</span>
                                    <i class="fas fa-ellipsis-h"></i> <!-- Option menu icon -->
                                </div>
                                
                                <!-- Media content like Facebook post -->
                                <div class="sub d-flex align-items-center mt-2 view">
                                    <!-- Image with responsive dimensions for mobile -->
                                    <img src="../admin/api/${product.image}" class="img-fluid rounded" style="width: 50%; max-height: 300px; object-fit: cover;">
                                </div>

                                <!-- Order button and details -->
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="text-muted">Price: GH&#x20B5;${product.price}</span>
                                    <form method="POST">
                                        <button type="button" class="btn btn-primary btn-sm" onclick="openPopup('${product.description}', '${product.product_id}')">
                                            <i class="fas fa-box"></i> Order Now
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                `;

                productList.innerHTML += productCard;
            });
        } catch (error) {
            console.error('Error fetching the products:', error);
        }
    }

    function openPopup(description, productId) {
        document.getElementById('productDescription').innerText = `Product description: ${description}`;
        document.getElementById('popupProductId').value = productId;
        document.getElementById('popupContainer').style.display = 'flex';
    }

    function closePopup() {
        document.getElementById('popupContainer').style.display = 'none';
    }

    // Fetch products on page load
    fetchProducts();


</script>
</body>
</html>

<?php


?>





