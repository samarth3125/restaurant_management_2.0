<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}
?>
<link rel="stylesheet" href="admin_dashboard.css">
<script src="admin_dashboard.js" defer></script>

<div class="dashboard-container">
    <a href="index.html" class="dashboard-btn back-btn">← Back</a>
    <h2>Admin Dashboard</h2>
    <a href="manage_menu.php" class="dashboard-btn">Manage Menu</a>
    <a href="manage_tables.php" class="dashboard-btn">Manage Tables</a>
    <a href="revenue.php" class="dashboard-btn">View Revenue</a>
    <a href="index.php" class="dashboard-btn logout-btn">Logout</a>
</div>