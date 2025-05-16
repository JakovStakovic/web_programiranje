<?php
// Include the functions file for database interaction
include('registerFunction.php');

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize the form data
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Call the registerUser function from registerFunctions.php
    $result = registerUser($first_name, $last_name, $username, $email, $hashed_password);

    // Display result message
    echo $result;
}
?>
