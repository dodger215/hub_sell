<?php
// api/delete_entry.php
header('Content-Type: application/json');

$jsonFile = 'orders_data.json'; // Path to your JSON file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    // Check if 'id' was provided
    if (!isset($input['id'])) {
        echo json_encode(['status' => 'error', 'message' => 'ID not provided']);
        exit;
    }

    $idToDelete = $input['id'];

    // Read and decode JSON file
    $jsonData = file_get_contents($jsonFile);
    $data = json_decode($jsonData, true);

    // Search for the entry and delete it
    foreach ($data as $key => $entry) {
        if ($entry['id'] == $idToDelete) {
            unset($data[$key]);
            break;
        }
    }

    // Re-index the array and write back to the JSON file
    $data = array_values($data); // Optional: Reindex the array
    file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT));

    echo json_encode(['status' => 'success', 'message' => 'Entry deleted']);
}
?>
