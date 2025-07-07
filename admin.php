<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}
?>
<a href="index.html">back</a>
<h2>Admin Dashboard</h2>
<a href="manage_menu.php">Manage Menu</a><br><br>
<a href="manage_tables.php">Manage Tables</a><br><br>
<a href="revenue.php">View Revenue</a><br><br>
<a href="index.php">Logout</a><br>