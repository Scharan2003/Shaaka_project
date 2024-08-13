<?php
// Configuration
$dbhost = "localhost";
$dbname = "shaaka";
$dbuser = "root";
$dbpass = "";

// Create connection
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}

// Retrieve login data from form
$email = $_POST['email'];
$password = $_POST['password'];

// Check if email and password match in employee_register table
$stmt = $conn->prepare("SELECT * FROM employee_register WHERE email =? AND password =?");
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows > 0) {
    // Start session
    session_start();

    // Redirect to food products page
    header("Location: food_products.html");
    exit;
} else {
    echo "Invalid email or password. Please try again.";
}

// Close connection
$conn->close();
?>