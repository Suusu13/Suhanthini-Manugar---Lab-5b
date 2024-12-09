<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>

<?php
$conn = new mysqli('localhost', 'root', '', 'Lab_5b');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM users");
?>

<table border="1">
    <tr>
        <th>Matric</th>
        <th>Name</th>
        <th>Access Level</th>
        <th>Action</th> <!-- New Action column -->
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['matric']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['accesslevel']; ?></td>
            <td>
                <!-- Links for Update and Delete -->
                <a href="update.php?matric=<?php echo $row['matric']; ?>">Update</a> |
                <a href="delete.php?matric=<?php echo $row['matric']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
            </td>
        </tr>
    <?php } ?>
</table>

<?php
$conn->close();
?>