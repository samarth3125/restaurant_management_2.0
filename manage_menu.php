<?php
session_start();
include("db_connect.php");

// Handle Delete Request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM menu WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    header("Location: manage_menu.php");
    exit();
}

// Handle Add Request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_item'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];

    $query = "INSERT INTO menu (name, price) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sd", $name, $price);
    mysqli_stmt_execute($stmt);
}

// Fetch all menu items
$query = "SELECT * FROM menu";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Menu</title>
    <style>
        table { width: 80%; margin: auto; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid black; text-align: center; }
        .delete-btn { background-color: red; color: white; padding: 5px; text-decoration: none; }
    </style>
</head>
<body>
<a href="admin.php">admin page</a>
    <h2 style="text-align:center;">Manage Menu</h2>
    <form action="" method="POST" style="text-align:center;">
        <input type="text" name="name" placeholder="Item Name" required>
        <input type="number" name="price" placeholder="Price (₹)" required step="0.01">
        <button type="submit" name="add_item">Add Item</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Item Name</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td>₹<?php echo $row['price']; ?></td>
                <td><a class="delete-btn" href="?delete=<?php echo $row['id']; ?>">Delete</a></td>
            </tr>
        <?php } ?>
    </table>

</body>
</html>