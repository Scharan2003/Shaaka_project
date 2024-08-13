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

// Retrieve registration data from form
$email = $_POST['email'];
$password = $_POST['password'];
$name = $_POST['name'];
$mobile_number = $_POST['mobile_number'];
$food_type = $_POST['food_type'];

// Insert data into employee_register table
$stmt = $conn->prepare("INSERT INTO employee_register (email, password, name, mobile_number, food_type) VALUES (?,?,?,?,?)");
$stmt->bind_param("sssss", $email, $password, $name, $mobile_number, $food_type);
$stmt->execute();

// Check if registration was successful
if ($stmt->affected_rows > 0) {
    // Get the last inserted ID (employee_id)
    $employee_id = $conn->insert_id;

    // Start session and store employee_id
    session_start();
    $_SESSION["employee_id"] = $employee_id;

    echo "You are successfully registered! Please login to continue.";
} else {
    echo "Registration failed. Please try again.";
}

// Close connection
$conn->close();
?>