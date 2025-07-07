<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Delete menu item
    $sql = "DELETE FROM menu WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Menu item deleted successfully!'); window.location='menu.php';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Invalid request!";
}
?>