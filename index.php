<?php
session_start();
require_once 'mysql_db.php';

$db = new MySQLDatabase();

if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        if ($db->login($username, $password)) {
            $_SESSION['user'] = $username;
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    } elseif (isset($_POST['signup'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        if ($db->signup($username, $password)) {
            $success = "Signup successful! You can now login.";
        } else {
            $error = "Username already exists.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Signup</title>
</head>
<body>
    <?php
    if (isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
    if (isset($success)) {
        echo "<p style='color: green;'>$success</p>";
    }
    ?>

    <h2>Login</h2>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="submit" name="login" value="Login">
    </form>

    <h2>Signup</h2>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="submit" name="signup" value="Signup">
    </form>
</body>
</html>
