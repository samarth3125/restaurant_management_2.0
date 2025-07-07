<?php
include 'db_connect.php';

// Get the order ID from the URL
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : 0;

// Fetch the order details from the database
$query = "SELECT * FROM orders WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_result = $stmt->get_result();
$order = $order_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receipt - Order #<?php echo $order_id; ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .receipt-container { width: 350px; margin: auto; border: 1px solid #333; padding: 20px; border-radius: 8px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 24px; }
        .order-details, .total { margin: 15px 0; }
        .total { text-align: right; font-weight: bold; margin-top: 15px; }
        .footer { text-align: center; margin-top: 20px; font-size: 14px; }
        .print-btn { margin-top: 15px; text-align: center; }
        @media print {
            .print-btn { display: none; }
        }
    </style>
    <script>
        function printReceipt() {
            window.print();
        }
    </script>
</head>
<body>
    <div class="receipt-container">
        <div class="header">
            <h2>The Table Receipt</h2>
            <p>Thank you for dining with us!</p>
        </div>

        <div class="order-details">
            
            <p><strong>Table Number:</strong> <?php echo $order['table_no']; ?></p>
            <p><strong>Items:</strong> <?php echo $order['items']; ?></p>
            <p><strong>Total Price:</strong> ₹<?php echo number_format($order['total_price'], 2); ?></p>
            <p><strong>Order Date:</strong> <?php echo $order['order_date']; ?></p>
        </div>

        <div class="total">
            <p>Subtotal: ₹<?php echo number_format($order['total_price'], 2); ?></p>
            <p>Taxes (5%): ₹<?php echo number_format($order['total_price'] * 0.05, 2); ?></p>
            <p>Total: ₹<?php echo number_format($order['total_price'] * 1.05, 2); ?></p>
            <p>Payment Method: Cash</p>
        </div>

        <div class="footer">
            <p>Visit Again! | Contact: 123-456-7890</p>
        </div>

        <div class="print-btn">
            <button onclick="printReceipt()">Print Receipt</button>
        </div>
    </div>
</body>
</html>