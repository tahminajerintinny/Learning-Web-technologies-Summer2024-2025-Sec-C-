<?php
session_start();
include 'config.php';  


if (!isset($_SESSION['id']) || $_SESSION['user_type'] !== 'User') {
    
    header("Location: login.php");
    exit;
}
?>

<h1>Welcome <?php echo htmlspecialchars($_SESSION['name']); ?>!</h1>

<p>
    <a href="profile.php">Profile</a><br>
    <a href="change_password.php">Change Password</a><br>
    <a href="logout.php">Logout</a>
</p>
