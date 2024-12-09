<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>
    <form method="POST" action="login.php">
        <label>Matric Number:</label>
        <input type="text" name="matric" required><br><br>
        <label>Password:</label>
        <input type="password" name="password" required><br><br>
        <button type="submit" name="login">Login</button><br><br>
    </form>
    <!-- Link to the Registration Page -->
    <a href="register.php">Register</a> <label> if you have not</label>

    <?php
    session_start();

    if (isset($_POST['login'])) {
        // Connect to the database
        $conn = new mysqli('localhost', 'root', '', 'Lab_5b');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get the form data
        $matric = $_POST['matric'];
        $password = $_POST['password'];

        // Query the database
        $stmt = $conn->prepare("SELECT * FROM users WHERE matric = ?");
        $stmt->bind_param("s", $matric);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the user exists
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                header("Location: display.php"); // Redirect to the page
                exit;
            } else {
                echo "<p>Incorrect password !</p>";
            }
        } else {
            echo "<p>User not found!</p>";
        }

        // Close the database connection
        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>
