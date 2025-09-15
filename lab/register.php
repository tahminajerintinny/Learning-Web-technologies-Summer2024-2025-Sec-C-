<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $conn->real_escape_string(trim($_POST['id']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $name = $conn->real_escape_string(trim($_POST['name']));
    $user_type = $_POST['user_type'];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
       
        $sql = "SELECT id FROM users WHERE id='$id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $error = "User ID already exists!";
        } else {
           $sql = "INSERT INTO users (id, password, name, user_type) VALUES ('$id', '$password', '$name', '$user_type')";

            if ($conn->query($sql) === TRUE) {
                header("Location: login.php");
                exit;
            } else {
                $error = "Error: " . $conn->error;
            }
        }
    }
}
?>

<h2>Registration</h2>
<form method="post">
    Id:<br><input type="text" name="id" required><br>
    Password:<br><input type="password" name="password" required><br>
    Confirm Password:<br><input type="password" name="confirm_password" required><br>
    Name:<br><input type="text" name="name" required><br>
    User Type:<br>
    <input type="radio" name="user_type" value="User" checked> User
    <input type="radio" name="user_type" value="Admin"> Admin<br><br>
    <input type="submit" value="Sign Up">
</form>

<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

<p><a href="login.php">Sign In</a></p>
