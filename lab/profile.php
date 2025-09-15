<?php
session_start();
include 'config.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['id'];
$sql = "SELECT id, name, user_type FROM users WHERE id='$id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
?>

<h2>Profile</h2>
<table border="1">
    <tr><td>ID</td><td><?php echo htmlspecialchars($user['id']); ?></td></tr>
    <tr><td>Name</td><td><?php echo htmlspecialchars($user['name']); ?></td></tr>
    <tr><td>User Type</td><td><?php echo htmlspecialchars($user['user_type']); ?></td></tr>
</table>

<p><a href="<?php echo ($_SESSION['user_type'] == 'Admin') ? 'admin_home.php' : 'user_home.php'; ?>">Go Home</a></p>
