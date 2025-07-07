<?php
session_start();
include 'db_connect.php';

// Ensure user is logged in
if (!isset($_SESSION['table_no'])) {
    header("Location: user_login.php");
    exit();
}

$table_no = $_SESSION['table_no'];

// Fetch menu items from database
$menu_items = [];
$sql = "SELECT * FROM menu";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $menu_items[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<a href="index.html">back</a>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Your Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 50%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        h2 {
            text-align: center;
        }
        .menu-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        input[type="number"] {
            width: 50px;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            background: green;
            color: white;
            border: none;
            cursor: pointer;
        }
        .btn:hover {
            background: darkgreen;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Place Your Order (Table <?php echo htmlspecialchars($table_no); ?>)</h2>
    
    <form action="process_order.php" method="POST">
        <input type="hidden" name="table_no" value="<?php echo htmlspecialchars($table_no); ?>">
        
        <?php foreach ($menu_items as $item) : ?>
            <div class="menu-item">
                <span><?php echo htmlspecialchars($item['name']) . " (₹" . $item['price'] . " each)"; ?></span>
                <input type="number" name="quantities[<?php echo $item['id']; ?>]" min="0" value="0">
                <input type="hidden" name="items[<?php echo $item['id']; ?>]" value="<?php echo htmlspecialchars($item['name']); ?>">
                <input type="hidden" name="prices[<?php echo $item['id']; ?>]" value="<?php echo $item['price']; ?>">
            </div>
        <?php endforeach; ?>

        <button type="submit" class="btn">Place Order</button>
    </form>
</div>

</body>
</html>