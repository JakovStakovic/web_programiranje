<?php
// Database connection function
function getDbConnection() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "weather";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// User registration function
function registerUser($first_name, $last_name, $username, $email, $password) {
    // Get the database connection
    $conn = getDbConnection();

    // Prepare the SQL query using placeholders to prevent SQL injection
    $sql = "INSERT INTO user (first_name, last_name, username, email, password) 
            VALUES (?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        return "Error preparing statement: " . $conn->error;
    }

    // Bind parameters to the statement
    $stmt->bind_param("sssss", $first_name, $last_name, $username, $email, $password);

    // Execute the statement
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return "Registration successful!";
    } else {
        $stmt->close();
        $conn->close();
        return "Error: " . $stmt->error;
    }
}
?>
