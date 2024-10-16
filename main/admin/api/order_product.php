<?php
session_start();
header('Content-Type: application/json');

require('../../include/node/config.php');
require('../../include/node/function.php');

// Path to the orders and products JSON files
$orderJsonFile = 'orders_data.json';
$productJsonFile = 'products_data.json';

$response = ['status' => 'error', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    $location = $_POST['loc'];
    $commit = $_POST['commit'];

    // Check if user is logged in
    if (!isset($_SESSION['auth'])) {
        $response['message'] = 'User not logged in';
        echo json_encode($response);
        exit;
    }

    $userId = $_SESSION['auth'];

    // Fetch the user's full name from the session
    $query = mysqli_query($conn, "SELECT full_name FROM register WHERE unique_id = '$userId'");
    $user = mysqli_fetch_assoc($query);

    if (!$user) {
        $response['message'] = 'User not found';
        echo json_encode($response);
        exit;
    }

    // Load product data from JSON file
    if (!file_exists($productJsonFile)) {
        $response['message'] = 'Product data not found';
        echo json_encode($response);
        exit;
    }

    $productData = json_decode(file_get_contents($productJsonFile), true);
    
    // Search for the product by ID in the product JSON data
    $product = null;
    $admin_id = null;
    foreach ($productData as $item) {
        if ($item['product_id'] == $productId) {
            $product = $item;
        break;

        }

    }
    
    if (!$product) {
        $response['message'] = 'Product not found';
        echo json_encode($response);
        exit;
    }

    $id = rand(1000, 9999);
    // Create the order details
    $order = [
        'id' => $id,
        'user_name' => $user['full_name'],
        'admin_id' => $product['user_id'],
        'product_title' => $product['title'],
        'commit' => $commit,
        'place' => $location,
        'timestamp' => date('Y-m-d H:i:s')
    ];

    // Load existing orders from the JSON file
    $existingOrders = [];
    if (file_exists($orderJsonFile)) {
         $jsonData = file_get_contents($orderJsonFile);
         $existingOrders = json_decode($jsonData, true);
         if (!is_array($existingOrders)) {
             $existingOrders = [];
         }
    }

    // Add the new order to the existing orders
    $existingOrders[] = $order;

     // Save the updated orders back to the JSON file
     if (file_put_contents($orderJsonFile, json_encode($existingOrders, JSON_PRETTY_PRINT))) {
         $response['status'] = 'success';
         $response['message'] = "{$product['title']} is placed successfully";

         redirect("../home.php", $response['message']);

     } else {
         $response['message'] = 'Failed to save order';
     }

     echo json_encode($response);
} else {
     $response['message'] = 'Invalid request';
     echo json_encode($response);
}

