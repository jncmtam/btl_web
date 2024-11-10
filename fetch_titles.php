<?php
include 'db.php';

$type = $_GET['type'];

// Determine the correct table and fields based on the feedback type
if ($type === 'product') {
    $query = "SELECT id, name AS title FROM products";
} elseif ($type === 'news') {
    $query = "SELECT id, title FROM news";
}

$result = $conn->query($query);

$titles = [];
while ($row = $result->fetch_assoc()) {
    $titles[] = $row;
}

header('Content-Type: application/json');
echo json_encode($titles);
