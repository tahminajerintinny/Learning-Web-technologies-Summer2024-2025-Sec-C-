<?php
session_start();
include 'config.php';

if (!isset($_SESSION['id']) || $_SESSION['user_type'] != 'Admin') {
    header("Location: login.php");
    exit;
}

$sql = "SELECT id, name, user_type FROM users";
$result = $conn->query($sql);
?>

<h2>Users</h2>
<table border="1">
    <tr>
        <th>ID</th><th>NAME</th><th>USER TYPE</th>
    </tr>
    <?php while($user = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo htmlspecialchars($user['id']); ?></td>
        <td><?php echo htmlspecialchars($user['name']); ?></td>
        <td><?php echo htmlspecialchars($user['user_type']); ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<p><a href="admin_home.php">Go Home</a></p>
