<?php
session_start();
include "db_connect.php"; // Ensure this connects to your database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $table_no = $_POST["table_no"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT password FROM tables WHERE table_number = ?");
    $stmt->bind_param("i", $table_no);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_password);
        $stmt->fetch();

        if ($password === $db_password) { 
            $_SESSION['table_no'] = $table_no;
            header("Location: order.php");
            exit();
        } else {
            echo "<script>alert('Invalid password!'); window.location.href='user_login.php';</script>";
        }
    } else {
        echo "<script>alert('Table number not found!'); window.location.href='user_login.php';</script>";
    }
}
?>
<a href="index.html">back</a>
<head><link rel="stylesheet" href="style5.css"></head>
<form action="user_login.php" method="POST">

    <label for="table_no">Table Number:</label>
    <input type="text" name="table_no" required><br><br>

    <label for="password">Password            :  </label>
    <input type="password" name="password" required>

    <button type="submit">Login</button>
</form>