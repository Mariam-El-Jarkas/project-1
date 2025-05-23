<?php
session_start();
require '../php/connection.php';

// Check admin status
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Get selected category and gender
$category = $_GET['category'] ?? 'all';
$gender = $_GET['gender'] ?? 'all';

// Build query
$query = "SELECT p.*, c.name AS category_name 
          FROM products p
          JOIN categories c ON p.category_id = c.category_id
          WHERE 1=1";

if ($category !== 'all') {
    $query .= " AND c.name = '" . mysqli_real_escape_string($con, $category) . "'";
}

if ($gender !== 'all') {
    $query .= " AND p.gender = '" . mysqli_real_escape_string($con, $gender) . "'";
}

$result = mysqli_query($con, $query);

// Get categories for navigation
$categories = mysqli_query($con, "SELECT * FROM categories");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Products</title>
    <link rel="stylesheet" href="CSS/admin.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="admin-container">
        <?php include 'sidebar.php'; ?>
        
        <div class="main-content">
            <div class="filter-buttons">
                <h2><?= $category === 'all' ? 'All Products' : $category ?></h2>
                <div class="gender-filter">
                    <a href="?category=<?= $category ?>&gender=all" 
                       class="<?= $gender == 'all' ? 'active' : '' ?>">All</a>
                    <a href="?category=<?= $category ?>&gender=male" 
                       class="<?= $gender == 'male' ? 'active' : '' ?>">Male</a>
                    <a href="?category=<?= $category ?>&gender=female" 
                       class="<?= $gender == 'female' ? 'active' : '' ?>">Female</a>
                </div>
            </div>

            <div class="action-bar">
                <a href="add_product.php" class="btn">+ Add New Product</a>
            </div>
            
            <table class="product-table">
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Gender</th>
                    <th>Actions</th>
                </tr>
                <?php while ($product = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $product['name'] ?></td>
                    <td>$<?= number_format($product['price'], 2) ?></td>
                    <td><?= $product['inventory_count'] ?></td>
                    <td><?= ucfirst($product['gender']) ?></td>
                    <td>
                        <button class="edit-btn">Edit</button>
                        <button class="delete-btn">Delete</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
    <script src="JavaScript/admin-sidebar.js"></script>
    
</body>
</html>