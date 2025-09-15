<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $conn->real_escape_string(trim($_POST['id']));
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if ($password === $user['password']) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['user_type'] = $user['user_type'];

            if ($user['user_type'] == "Admin") {
                header("Location: admin_home.php");
            } else {
                header("Location: user_home.php");
            }
            exit;
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "Invalid ID!";
    }
}
?>

<h2>Login</h2>
<form method="post">
    User Id:<br><input type="text" name="id" required><br>
    Password:<br><input type="password" name="password" required><br><br>
    <input type="submit" value="Login">
</form>

<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

<p><a href="register.php">Register</a></p>
