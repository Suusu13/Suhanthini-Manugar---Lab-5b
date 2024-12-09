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

// Get the 'matric' from the query string
if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];

    // Fetch the user's existing details
    $result = $conn->query("SELECT * FROM users WHERE matric = '$matric'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "User not found!";
        exit;
    }
} else {
    echo "Invalid request!";
    exit;
}

// Update user details when the form is submitted
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $accessLevel = $_POST['accessLevel'];

    $sql = "UPDATE users SET name = '$name', accesslevel = '$accessLevel' WHERE matric = '$matric'";

    if ($conn->query($sql) === TRUE) {
        echo "User details updated successfully!";
        header("Location: display.php"); // Redirect to display page after update
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
</head>
<body>
    <h2>Update User Details</h2>
    <form method="POST" action="">
        <label>Matric Number:</label>
        <input type="text" name="matric" value="<?php echo $user['matric']; ?>" readonly><br><br>

        <label>Name:</label>
        <input type="text" name="name" value="<?php echo $user['name']; ?>" required><br><br>

        <label>Role:</label>
        <select name="accessLevel" required>
            <option value="Lecturer" <?php echo ($user['accesslevel'] == 'Lecturer') ? 'selected' : ''; ?>>Lecturer</option>
            <option value="Student" <?php echo ($user['accesslevel'] == 'Student') ? 'selected' : ''; ?>>Student</option>
        </select><br><br>

        <button type="submit" name="update">Update</button>
    </form>
</body>
</html>

<?php
$conn->close();
?>
