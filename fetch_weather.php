<?php
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "weather"; // Your database name

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed"]);
    exit();
}

// Pagination: get page number from query (default is 1)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1); // prevent page 0
$limit = 20;
$offset = ($page - 1) * $limit;

// Fetch data with limit
$sql = "SELECT id, precipitation, location, season, weather_type 
        FROM weather_data 
        LIMIT $limit OFFSET $offset";

$result = $conn->query($sql);
$weatherData = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $weatherData[] = $row;
    }
}

// Get total number of rows for pagination info
$totalQuery = $conn->query("SELECT COUNT(*) as total FROM weather_data");
$totalRows = $totalQuery->fetch_assoc()['total'];

$conn->close();

// Respond with data and pagination info
echo json_encode([
    "data" => $weatherData,
    "pagination" => [
        "current_page" => $page,
        "total_rows" => $totalRows,
        "total_pages" => ceil($totalRows / $limit)
    ]
]);
?>
