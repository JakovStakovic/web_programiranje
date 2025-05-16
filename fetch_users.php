<?php
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "weather";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    echo json_encode([]);
    exit();
}

// Fetch users
$sql = "SELECT id, first_name, last_name, username, email FROM user";
$result = $conn->query($sql);

$users = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

$conn->close();

// Output as JSON
echo json_encode($users);
?>
