<?php
include 'db_connect.php';

// Add Table (WITH DUPLICATE CHECK)
if (isset($_POST['add_table'])) {
    $table_number = $_POST['table_number'];
    $password = $_POST['password']; // Store password as plain text

    // Check if the table already exists
    $check_query = "SELECT * FROM tables WHERE table_number = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("i", $table_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Table number already exists!'); window.location.href='manage_tables.php';</script>";
    } else {
        // Insert new table if it doesn't exist
        $query = "INSERT INTO tables (table_number, password) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("is", $table_number, $password);
        if ($stmt->execute()) {
            echo "<script>alert('Table added successfully!'); window.location.href='manage_tables.php';</script>";
        } else {
            echo "<script>alert('Error adding table!');</script>";
        }
    }
}

// Update Table Password (WITHOUT HASHING)
if (isset($_POST['update_table'])) {
    $table_id = $_POST['table_id'];
    $new_password = $_POST['new_password']; // Store password as plain text

    $query = "UPDATE tables SET password = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $new_password, $table_id);
    if ($stmt->execute()) {
        echo "<script>alert('Table code updated!'); window.location.href='manage_tables.php';</script>";
    } else {
        echo "<script>alert('Error updating table code!');</script>";
    }
}

// Delete Table
if (isset($_GET['delete_table'])) {
    $table_id = $_GET['delete_table'];

    $query = "DELETE FROM tables WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $table_id);
    if ($stmt->execute()) {
        echo "<script>alert('Table deleted!'); window.location.href='manage_tables.php';</script>";
    } else {
        echo "<script>alert('Error deleting table!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Tables</title>
    <link rel="stylesheet" href="styles.css">
	<a href="admin.php">admin page</a>
</head>
<body>

<h2>Manage Tables</h2>

<!-- Add Table Form -->
<form method="POST">
    <input type="number" name="table_number" placeholder="Table Number" required>
    <input type="text" name="password" placeholder="Table Code" required>
    <button type="submit" name="add_table">Add Table</button>
</form>

<!-- Table List -->
<table>
    <tr>
        <th>ID</th>
        <th>Table Number</th>
        <th>Table Code</th>
        <th>Actions</th>
    </tr>
    <?php
    $result = $conn->query("SELECT * FROM tables");
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['table_number']}</td>
            <td>{$row['password']}</td>
            <td>
                <form method='POST' style='display:inline;'>
                    <input type='hidden' name='table_id' value='{$row['id']}'>
                    <input type='text' name='new_password' placeholder='new code' required>
                    <button type='submit' name='update_table'>Update</button>
                </form>
                <a href='manage_tables.php?delete_table={$row['id']}' onclick='return confirm(\"Delete table?\");'>Delete</a>
            </td>
        </tr>";
    }
    ?>
</table>

</body>
</html>