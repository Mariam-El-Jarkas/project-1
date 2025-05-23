<?php
session_start();
require_once '../php/connection.php';

// Check admin status
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Get statistics
$total_orders = 0;
$total_products = 0;
$pending_orders = 0;

// Total Orders
$result = mysqli_query($con, "SELECT COUNT(*) AS total FROM orders");
if ($result && $row = mysqli_fetch_assoc($result)) {
    $total_orders = $row['total'];
}

// Total Products in Stock
$result = mysqli_query($con, "SELECT SUM(inventory_count) AS total FROM products");
if ($result && $row = mysqli_fetch_assoc($result)) {
    $total_products = $row['total'] ?? 0;
}

// Pending Orders
$result = mysqli_query($con, "SELECT COUNT(*) AS total FROM orders WHERE status = 'pending'");
if ($result && $row = mysqli_fetch_assoc($result)) {
    $pending_orders = $row['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="CSS/admin.css">
</head>
<body>
    <div class="admin-container">
        <?php include 'sidebar.php'; ?>
        
        <div class="main-content">
            <h1>Dashboard Overview</h1>
            
            <div class="summary-cards">
                <div class="card">
                    <h3>Total Orders</h3>
                    <p><?= number_format($total_orders) ?></p>
                </div>
                
                <div class="card">
                    <h3>Products in Stock</h3>
                    <p><?= number_format($total_products) ?></p>
                </div>
                
                <div class="card">
                    <h3>Pending Orders</h3>
                    <p><?= number_format($pending_orders) ?></p>
                </div>
            </div>
        </div>
    </div>
    <script src="JavaScript/admin-sidebar.js"></script>
</body>
</html>