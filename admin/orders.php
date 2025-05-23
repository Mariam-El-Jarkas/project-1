<?php
session_start();
require '../php/connection.php';

// Check admin status
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$orders = mysqli_query($con, "
    SELECT o.id, u.username, o.order_datetime, o.status, SUM(od.quantity * p.price) AS total
    FROM orders o
    JOIN users u ON o.user_id = u.id
    JOIN order_details od ON o.id = od.order_id
    JOIN products p ON od.product_id = p.product_id
    GROUP BY o.id
    ORDER BY o.order_datetime DESC
");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Orders</title>
    <link rel="stylesheet" href="CSS/admin.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="admin-container">
        <?php include 'sidebar.php'; ?>

        <div class="main-content">
            <h1>Order Management</h1>

            <div class="order-filters">
                <div class="filter-group">
                    <label>Status:</label>
                    <select id="statusFilter">
                        <option value="all">All</option>
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                        <option value="shipped">Shipped</option>
                    </select>
                </div>
            </div>

            <table class="order-table">
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Order Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                <?php while ($order = mysqli_fetch_assoc($orders)): ?>
                    <tr>
                        <td>#<?= $order['id'] ?></td>
                        <td><?= $order['username'] ?></td>
                        <td><?= date('M d, Y', strtotime($order['order_datetime'])) ?></td>
                        <td>$<?= number_format($order['total'], 2) ?></td>
                        <td>
                            <span class="status-badge <?= $order['status'] ?>">
                                <?= ucfirst($order['status']) ?>
                            </span>
                        </td>
                        <td>
                            <button class="view-btn">View</button>
                            <button class="edit-btn">Update</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    <script src="JavaScript/admin-sidebar.js"></script>

        <!-- Add this script at the end -->
        <script>
            document.getElementById('statusFilter').addEventListener('change', function () {
                const status = this.value;
                window.location.href = `orders.php?status=${status}`;
            });
        </script>
</body>

</html>