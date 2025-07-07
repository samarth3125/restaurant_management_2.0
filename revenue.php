<?php
include 'db_connect.php';

$date_filter = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

$query = "SELECT * FROM orders WHERE DATE(order_date) = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $date_filter);
$stmt->execute();
$result = $stmt->get_result();

$total_revenue = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revenue Report</title>
    <link rel="stylesheet" href="styles.css">
	<a href="admin.php">admin page</a>
</head>
<body>
    <div class="container">
        <h2>Revenue Report</h2>

        <!-- Date Filter -->
        <form method="GET">
            <label for="date">Select Date:</label>
            <input type="date" name="date" value="<?= $date_filter; ?>" onchange="this.form.submit();">
        </form>

        <!-- Total Revenue -->
        <h3>Total Revenue: ₹
            <?php
            while ($row = $result->fetch_assoc()) {
                $total_revenue += $row['total_price'];
            }
            echo number_format($total_revenue, 2);
            ?>
        </h3>

        <!-- Order Table -->
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Table No</th>
                    <th>Items</th>
                    <th>Total Price</th>
                    <th>Order Date</th>
                    <th>Receipt</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result->data_seek(0); // Reset pointer
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['table_no']}</td>
                            <td>{$row['items']}</td>
                            <td>₹" . number_format($row['total_price'], 2) . "</td>
                            <td>{$row['order_date']}</td>
                            <td><a href='receipt.php?order_id={$row['id']}' class='btn-receipt'>Generate Receipt</a></td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>