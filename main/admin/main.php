<?php 

$select_1 = "select";
$select_2 = "non";

require('../include/node/function.php');
require('../include/node/config.php');

// Check if the user is authenticated
if (!isset($_SESSION['auth'])) {
    redirect("../signin.php", "Try again");
}

// Handle form submission (Respond or Ignore)
if (isset($_POST['action'])) {
    $id = rand(10, 999);
    $adminId = $_SESSION['auth'];
    $user_name = $_POST['name'];
    $action = $_POST['action'];

    // Prepare data to save
    $notifyData = [
        'id' => $id,
        'admin_id' => $adminId,
        'user_name' => $user_name,
        'action' => $action,
        'timestamp' => date('Y-m-d H:i:s'),
    ];

    // Fetch existing notify responses
    $notifyJsonFile = "api/notify_response.json";
    $existingResponses = [];
    if (file_exists($notifyJsonFile)) {
        $existingResponses = json_decode(file_get_contents($notifyJsonFile), true);
    }

    // Append new response to the existing data
    $existingResponses[] = $notifyData;

    // Save the updated data back to the notify_response.json file
    file_put_contents($notifyJsonFile, json_encode($existingResponses));

    // Provide feedback
    echo "<script>alert('Action recorded: $action');</script>";
}

// Load product data
$productJsonFile = "api/orders_data.json";
if (!file_exists($productJsonFile)) {
    echo '<li>Product data not found</li>';
    exit;
}

$productData = json_decode(file_get_contents($productJsonFile), true);
$incoming = '';

// Verify product data is an array
if (!is_array($productData)) {
    echo '<li>Invalid product data</li>';
    exit;
}

// Generate the order list for the current admin
foreach ($productData as $product) {
    if ($product['admin_id'] == $_SESSION['auth']) {
        
        $query = mysqli_query($conn, "SELECT * FROM register WHERE full_name = '{$product['user_name']}'");
        $number = mysqli_fetch_assoc($query);

        $incoming .= '
            <li>
                <div class="detail d-flex justify-content-between align-items-center">
                    <span class="name">From: ' . htmlspecialchars($product['user_name']) . '
                    <br/>
                    Description: ' . htmlspecialchars($product['commit']) . '
                    </span>
                    <span class="amount">Order: ' . htmlspecialchars($product['product_title']) . '</span>
                </div>
                <div class="sub d-flex justify-content-between align-items-center mt-2">
                    <div class="btn-group">
                        <form method="POST">
                            <input type="hidden" name="name" value="' . htmlspecialchars($product['user_name']) . '">
                            <input type="hidden" class="id" value="' . htmlspecialchars($product['id']) . '">
                            <button type="submit" name="action" value="respond" class="btn btn-primary respond">Respond</button>
                            <button type="submit" name="action" value="ignore" class="btn btn-danger ignore">Ignore</button>
                        </form>
                    </div>
                    <p class="tel">Tel: ' . htmlspecialchars($number['number']) . ' 
                    <br/>
                    location: ' . htmlspecialchars($product['place']) . '
                    </p>
                    <span class="date">at ' . htmlspecialchars($product['timestamp']) . '</span>
                </div>
            </li>
        ';
    }
}

// If there are no matching orders
if (empty($incoming)) {
    $incoming = '<li>No orders found for you.</li>';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('header/header.php') ?>
    <style>
        .main-nav .select {
            color: rgb(20, 21, 170);
        }
        .tel {
            margin: 0 15px; /* Add some space around the telephone number */
            white-space: nowrap; /* Prevent text wrapping */
        }
        .sub {
            display: flex;
            justify-content: space-between; /* Space out elements evenly */
            align-items: center; /* Center align items vertically */
        }
    </style>
</head>
<body>

<?php require('header/nav.php') ?>

<!-- Content Area -->
<div class="wrapper">
    <section class="orders_page mb-4">
        <div class="d-flex justify-content-between align-items-center main">
            <h1>Customers' Orders</h1>
        </div>
        <ul class="list-unstyled mt-4">
            <?= $incoming ?>
        </ul>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.querySelector('.respond').addEventListener('click', function() {
    const id = document.querySelector('.id').value;

    let message = "Responded";
    sendRespond(id, message);
});

document.querySelector('.ignore').addEventListener('click', function() {
    const id = document.querySelector('.id').value;

    let message = "Ignored";
    sendRespond(id, message);
});

function sendRespond(id, message){

    const idToDelete = id;

        fetch('api/delete_product.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: idToDelete })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert(`${message} successfully!`);
            } else {
                alert('Error entry');
            }
        })
        .catch(error => console.error('Error:', error));
}
</script>

</body>
</html>
