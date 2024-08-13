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
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate input
    if (empty($email) || empty($password)) {
        echo "Please fill in all fields.";
        exit;
    }

    // Check if email exists
    $query = "SELECT * FROM customer_register WHERE email = '$email'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
        $stored_password = $user_data['password'];

        // Verify password
        if ($password == $stored_password) {
            // Password is correct, log in the user
            $_SESSION['logged_in'] = true;
            $_SESSION['email'] = $email;
            header("Location: product_page.php");
            exit;
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Email does not exist.";
    }
}

$conn->close();
?>
