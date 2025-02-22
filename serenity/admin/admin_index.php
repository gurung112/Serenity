<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: admin_dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serenity</title>
    <link rel="icon" type="image/jpg" href="../images/logo.jpg">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="home.css"> 
    <link rel="stylesheet" href="xyz.css"> 
    <link rel="stylesheet" href="a.css">
</head>
<body>
    <div class="navbar">
            <img src="../images/logo.jpg" style="width: 150px; height: 90px; border-radius: 10%;">
            <a href="../home.html">Home</a>
            <a href="../user/user_login.php">User Login</a>
            <a href="../user/user_signup.php">User SignUp</a>
            <a href="admin_index.php">Admin Login</a>
    </div>
    <div class="page">
        <div class="login">
            <form action="login.php" method="POST">
                <h2>Admin Login</h2>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
    