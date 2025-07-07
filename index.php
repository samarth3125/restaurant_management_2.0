<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']);  

    $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $_SESSION['admin'] = $username;
        header("Location: admin.php");
        exit();
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                const alertBox = document.getElementById('alertBox');
                alertBox.style.display = 'block';
                setTimeout(() => { alertBox.style.opacity = 0; }, 2000);
            });
        </script>";
    }
}
?>

<link rel="stylesheet" href="admin_login.css">
<script src="admin_login.js" defer></script>

<div class="login-container">
    <a href="index.html" class="back-btn">← Back</a>
    <h2>Admin Login</h2>
    <div id="alertBox" class="alert-box">Invalid credentials</div>
    <form method="post" id="loginForm">
        <input type="text" name="username" id="username" placeholder="Username" required autocomplete="off">
        <input type="password" name="password" id="password" placeholder="Password" required autocomplete="off">
        <button type="submit" class="login-btn">Login</button>
        <button type="button" class="show-btn" id="showPassBtn">Show Password</button>
    </form>
</div>