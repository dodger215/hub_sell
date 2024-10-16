<?php


require('../include/node/function.php');
require('../include/node/config.php');

if(!isset($_SESSION['auth'])){
    redirect("../signin.php", "Try again");
}

$notifyJsonFile = 'api/notify_response.json';
$msg = '';

if (!file_exists($notifyJsonFile)) {
    $msg = 'No notifications found.';
}

$notifications = json_decode(file_get_contents($notifyJsonFile), true);

if (empty($notifications)) {
    $msg = 'No notifications available.';
}


foreach ($notifications as $notification) {
    $id = htmlspecialchars($notification['admin_id']);
    
    $query = mysqli_query($conn, "SELECT * FROM register WHERE unique_id = '{$id}'");

    if ($query) {
        $name = mysqli_fetch_assoc($query);

        $msg .= '
            <li class="list-group-item">
                <strong>You</strong>
                <br/>Phone number: ' . htmlspecialchars($name['number']) . ' <br/>' . htmlspecialchars($notification['action']) . ' on ' . htmlspecialchars($notification['timestamp']) . '
            </li>
        ';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('header/header.php') ?>
    <style>
        li{
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body>
    <?php require('header/nav.php') ?>
    <div class="container mt-4 wrapper">
        <h1>Notifications</h1>
        <ul class="list-group">
            <?= $msg ?> <!-- Echo the $msg variable here -->
        </ul>
    </div>
</body>
</html>
