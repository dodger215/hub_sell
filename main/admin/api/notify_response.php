<?php

header('Content-Type: application/json');
require('../../include/node/config.php');
require('../../include/node/function.php');
$notifyJsonFile = 'api/notify.json';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['admin_id'], $input['action'])) {
        echo json_encode(['status' => 'error', 'message' => 'Missing admin_id or action']);
        exit;
    }

    // $adminId = $input['admin_id'];
    // $action = $input['action'];

    // // Check if the admin is logged in
    // if (!isset($_SESSION['auth'])) {
    //     echo json_encode(['status' => 'error', 'message' => 'Admin not logged in']);
    //     exit;
    // }

    // $userId = $_SESSION['auth'];

    // // Load the notification data
    // $notifications = [];
    // if (file_exists($notifyJsonFile)) {
    //     $jsonData = file_get_contents($notifyJsonFile);
    //     $notifications = json_decode($jsonData, true);
    //     if (!is_array($notifications)) {
    //         $notifications = [];
    //     }
    // }

    // // Add new response (Respond/Ignore) with admin ID and action
    // $notifications[] = [
    //     'admin_id' => $adminId,
    //     'user_name' => $_SESSION['status'],
    //     'action' => $action,
    //     'timestamp' => date('Y-m-d H:i:s')
    // ];

    // // Save the updated notifications
    // if (file_put_contents($notifyJsonFile, json_encode($notifications, JSON_PRETTY_PRINT))) {
    //     echo json_encode(['status' => 'success', 'message' => 'Response saved']);
    // } else {
    //     echo json_encode(['status' => 'error', 'message' => 'Failed to save response']);
    // }
}
