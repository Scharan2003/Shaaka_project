<?php
session_start();

// Configuration
$dbhost = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "shaaka";

// Create connection
$conn = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate input
    if (empty($name) || empty($email) || empty($password)) {
        echo "Please fill in all fields.";
        exit;
    }

    // Check if email already exists
    $query = "SELECT * FROM customers WHERE email = '$email'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        echo "Email already exists.";
        exit;
    }

    // Insert into database
    $query = "INSERT INTO customers (name, email, password) VALUES ('$name', '$email', '$password')";
    if ($conn->query($query) === TRUE) {
        echo "Registration successful!";
        $_SESSION['registered'] = true;
        header("Location: customer_login.php");
        exit;
    } else {
        echo "Error: ". $query. "<br>". $conn->error;
    }
}

$conn->close();
?>