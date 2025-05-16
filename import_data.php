<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "weather"; // Your DB name

// Connect to DB
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Open the CSV file
$csvFile = fopen("weather.csv", "r");
if (!$csvFile) {
    die("Could not open the file.");
}

// Skip the header
$header = fgetcsv($csvFile);

// Column index map
$map = array_flip($header); // Convert headers to keys like ['ID' => 0, ...]

while (($row = fgetcsv($csvFile)) !== FALSE) {
    $id = $conn->real_escape_string($row[$map['ID']]);
    $precip = $conn->real_escape_string($row[$map['Precipitation (%)']]);
    $location = $conn->real_escape_string($row[$map['Location']]);
    $season = $conn->real_escape_string($row[$map['Season']]);
    $weatherType = $conn->real_escape_string($row[$map['Weather Type']]);

    // Insert into the database
    $sql = "INSERT INTO weather_data (id, precipitation, location, season, weather_type)
            VALUES ('$id', '$precip', '$location', '$season', '$weatherType')";

    if (!$conn->query($sql)) {
        echo "Error inserting $id: " . $conn->error . "<br>";
    }
}

fclose($csvFile);
$conn->close();

echo "Selected CSV data imported successfully!";
?>
