<?php
// Start session and check authentication
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'Lab_5b');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the 'matric' is provided in the query string
if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];

    // Perform the delete operation
    $sql = "DELETE FROM users WHERE matric = '$matric'";

    if ($conn->query($sql) === TRUE) {
        echo "User deleted successfully!";
        header("Location: display.php"); // Redirect back to display.php after deletion
        exit;
    } else {
        echo "Error deleting user: " . $conn->error;
    }
} else {
    echo "Invalid request!";
}

$conn->close();
?>
