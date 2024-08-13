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

// Retrieve login credentials from form
$email = $_POST['email'];
$password = $_POST['password'];

// Retrieve email and password from farmer_register table
$stmt = $conn->prepare("SELECT email, password FROM farmer_register WHERE email =?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $stored_email = $row['email'];
    $stored_password = $row['password'];

    if ($email == $stored_email && $password == $stored_password) {
        // User exists, redirect to product.html
        header('Location:products.html');
        exit;
    } else {
        // User does not exist, display error message
        echo "Invalid email or password";
    }
} else {
    // User does not exist, display error message
    echo "Invalid email or password";
}

// Close connection
$conn->close();
?>