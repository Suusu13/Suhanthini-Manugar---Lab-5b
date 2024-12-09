<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <form method="POST" action="register.php">
        <label>Matric Number:</label>
        <input type="text" name="matric" required><br><br>

        <label>Name:</label>
        <input type="text" name="name" required><br><br>

        <label>Role:</label>
        <select name="accessLevel" required>
            <option value="" disabled selected>Please select</option>
            <option value="Lecturer">Lecturer</option>
            <option value="Student">Student</option>
        </select><br><br>

        <label>Password:</label>
        <input type="password" name="password" required><br><br>

        <button type="submit" name="submit">Register</button>
    </form>

    <!-- Add Login Button -->
    <form method="GET" action="login.php" style="margin-top: 20px;">
        <button type="submit">Go to Login</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $conn = new mysqli('localhost', 'root', '', 'Lab_5b'); // Connect to DB

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $matric = $_POST['matric'];
        $name = $_POST['name'];
        $accessLevel = $_POST['accessLevel'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (matric, name, accessLevel, password) VALUES ('$matric', '$name', '$accessLevel', '$password')";
        if ($conn->query($sql) === TRUE) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $conn->error;
        }

        $conn->close();
    }
    ?>
</body>
</html>
