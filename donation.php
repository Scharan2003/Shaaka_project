<?php
// Start session
session_start();

// Configuration
$servername = "localhost";
$username = "root";
$password = "";
$database_name = "food_donation_db";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database_name);

// Check connection
if (!$conn) {
    die("Connection Failed: ". mysqli_connect_error());
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $number = $_POST["number"];
    $address = $_POST["address"];
    $email = $_POST["email"];

    // Insert data into donations table
    $sql_query = "INSERT INTO donations (name, phone_number, address, email) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql_query);
    mysqli_stmt_bind_param($stmt, "ssss", $name, $number, $address, $email);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        // Set session variable to indicate successful submission
        $_SESSION["submission_success"] = true;
        header("Location: thank_you.php"); // Redirect to thank you page
        exit;
    } else {
        echo "Error: ". mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}

// Close connection
mysqli_close($conn);
?>