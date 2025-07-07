<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if required data is present
    if (!isset($_POST['table_no'], $_POST['items'], $_POST['quantities'], $_POST['prices'])) {
        die("Error: Missing required data.");
    }

    $table_no = intval($_POST['table_no']);
    $items = $_POST['items'];
    $quantities = $_POST['quantities'];
    $prices = $_POST['prices'];

    // Initialize order details
    $order_items = [];
    $total_price = 0;

    // Process each item
    foreach ($items as $item_id => $item_name) {
        $quantity = intval($quantities[$item_id]);
        $price = floatval($prices[$item_id]);

        if ($quantity > 0) {
            $order_items[] = "$item_name x $quantity";
            $total_price += $quantity * $price;
        }
    }

    // Ensure at least one item is ordered
    if (empty($order_items)) {
        die("Error: No items selected.");
    }

    // Convert order items to string
    $items_string = implode(", ", $order_items);

    // Insert order into database
    $stmt = $conn->prepare("INSERT INTO orders (table_no, items, total_price) VALUES (?, ?, ?)");
    $stmt->bind_param("isd", $table_no, $items_string, $total_price);

    if ($stmt->execute()) {
        echo "<script>alert('Order placed successfully!'); window.location.href='order_success.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>