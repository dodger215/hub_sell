<?php
session_start();

if(!isset($_SESSION['auth'])){
  redirect("../../signin.php", "Try again");
}


$ran_id = rand(2000, 9999);

header('Content-Type: application/json');


// Directory to save uploaded images
$uploadDir = 'uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Path to JSON file where products will be stored
$jsonFilePath = 'products_data.json';

// Initialize response array
$response = [
    'status' => 'error',
    'message' => '',
    'products' => []
];

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Load existing products from the JSON file
    $existingProducts = [];
    if (file_exists($jsonFilePath)) {
        $jsonData = file_get_contents($jsonFilePath);
        $existingProducts = json_decode($jsonData, true);
        if (!is_array($existingProducts)) {
            $existingProducts = [];
        }
    }

    // Check if files are uploaded
    if (isset($_FILES['images'])) {
        $totalProducts = count($_POST['product_titles']);

        // Loop through each product
        for ($i = 0; $i < $totalProducts; $i++) {
            // Process each product
            $product = [
                'user_id' => $_SESSION['auth'],
                'product_id' => $ran_id,
                'title' => $_POST['product_titles'][$i],
                'description' => $_POST['product_descriptions'][$i],
                'price' => $_POST['product_prices'][$i],
                'image' => ''
            ];

            // Check if an image is uploaded for the product
            if (isset($_FILES['images']['tmp_name'][$i]) && is_uploaded_file($_FILES['images']['tmp_name'][$i])) {
                $imageName = basename($_FILES['images']['name'][$i]);
                $imagePath = $uploadDir . time() . "_" . $imageName;

                // Move the uploaded file to the designated directory
                if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $imagePath)) {
                    $product['image'] = $imagePath;
                } else {
                    $response['message'] = 'Error uploading image ' . $imageName;
                    echo json_encode($response);
                    exit;
                }
            } else {
                // Provide feedback if no image was uploaded for this product
                $response['message'] = 'No image uploaded for product: ' . $product['title'];
                echo json_encode($response);
                exit;
            }

            // Add product to the products array
            $existingProducts[] = $product;
        }

        // Save all products to the JSON file (overwriting it with updated data)
        file_put_contents($jsonFilePath, json_encode($existingProducts, JSON_PRETTY_PRINT));

        // Success response
        $response['status'] = 'success';
        $response['message'] = 'Products uploaded successfully!';
        $response['products'] = $existingProducts;
    } else {
        $response['message'] = 'No images were uploaded.';
    }

    echo json_encode($response);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
