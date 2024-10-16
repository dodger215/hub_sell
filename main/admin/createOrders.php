<?php

session_start();

if(!isset($_SESSION['auth'])){
  redirect("../signin.php", "Try again");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require('header/header.php') ?>
  <style>
    body {
      padding-top: 20px;
      background-color: #f8f9fa;
    }
    .product-card {
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <?php require('header/nav.php')?>
  <div class="wrapper container">
    <h2 class="text-center mb-4">Upload Your Products</h2>
    <button type="button" class="btn btn-danger" onclick="back()">Back</button>
    <form id="productForm" enctype="multipart/form-data">
      <!-- Image Upload Section -->
      <div class="mb-3">
        <label for="productImages" class="form-label">Upload Images</label>
        <input class="form-control" type="file" name="images[]" id="productImages" multiple accept="image/*">
      </div>
      
      <!-- Dynamic Product Fields -->
      <div id="productFields">
        <div class="card product-card">
          <div class="card-body">
            <h5 class="card-title">Product 1</h5>
            <!-- Product Title -->
            <div class="mb-3">
              <label for="productTitle1" class="form-label">Product Title</label>
              <input type="text" name="product_titles[]" class="form-control" id="productTitle1" placeholder="Enter product title">
            </div>
            <!-- Product Description -->
            <div class="mb-3">
              <label for="productDescription1" class="form-label">Product Description</label>
              <textarea class="form-control" name="product_descriptions[]" id="productDescription1" rows="3" placeholder="Enter product description"></textarea>
            </div>
            <!-- Product Price -->
            <div class="mb-3">
              <label for="productPrice1" class="form-label">Price (GHS)</label>
              <input type="number" name="product_prices[]" class="form-control" id="productPrice1" placeholder="Enter price">
            </div>
          </div>
        </div>
      </div>

      <!-- Add Another Product Button -->
      <div class="d-grid gap-2 mb-3">
        <button type="button" class="btn btn-secondary" id="addProductBtn">Add Another Product</button>
      </div>

      <!-- Submit Button -->
      <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary">Submit Products</button>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function back() {
      window.location.href="home.php";
    }

    let productCount = 1;
    document.getElementById('addProductBtn').addEventListener('click', () => {
      productCount++;
      const productFields = document.getElementById('productFields');

      const newProductCard = `
        <div class="card product-card">
          <div class="card-body">
            <h5 class="card-title">Product ${productCount}</h5>
            <div class="mb-3">
              <label for="productTitle${productCount}" class="form-label">Product Title</label>
              <input type="text" class="form-control" id="productTitle${productCount}" placeholder="Enter product title">
            </div>
            <div class="mb-3">
              <label for="productDescription${productCount}" class="form-label">Product Description</label>
              <textarea class="form-control" id="productDescription${productCount}" rows="3" placeholder="Enter product description"></textarea>
            </div>
            <div class="mb-3">
              <label for="productPrice${productCount}" class="form-label">Price (USD)</label>
              <input type="number" class="form-control" id="productPrice${productCount}" placeholder="Enter price">
            </div>
          </div>
        </div>
      `;

      productFields.insertAdjacentHTML('beforeend', newProductCard);
    });

    document.getElementById('productForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch('api/upload_products.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Products uploaded successfully!');
            window.location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while uploading.');
    });
});



    
  </script>
</body>
</html>
