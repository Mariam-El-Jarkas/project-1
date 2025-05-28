<?php
session_start();
require_once '../php/connection.php';

// Check admin status
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_category'])) {
        $name = mysqli_real_escape_string($con, $_POST['category_name']);
        $sql = "INSERT INTO categories (name) VALUES ('$name')";
        mysqli_query($con, $sql);
    }
    
    if (isset($_POST['add_subcategory'])) {
        $category_id = intval($_POST['category_id']);
        $name = mysqli_real_escape_string($con, $_POST['subcategory_name']);
        $sql = "INSERT INTO subcategories (category_id, name) VALUES ($category_id, '$name')";
        mysqli_query($con, $sql);
    }
}

// Get existing categories
$categories = [];
$result = mysqli_query($con, "SELECT * FROM categories");
while ($row = mysqli_fetch_assoc($result)) {
    $categories[$row['category_id']] = $row;
}

// Get subcategories
$subcategories = [];
$result = mysqli_query($con, "
    SELECT s.*, c.name AS category_name 
    FROM subcategories s
    JOIN categories c ON s.category_id = c.category_id
");
while ($row = mysqli_fetch_assoc($result)) {
    $subcategories[] = $row;
}
if (isset($_POST['delete_category'])) {
    $category_id = intval($_POST['category_id']);

    // Delete subcategories first (to maintain foreign key constraints)
    $sql = "DELETE FROM subcategories WHERE category_id = $category_id";
    mysqli_query($con, $sql);

    // Then delete the category
    $sql = "DELETE FROM categories WHERE category_id = $category_id";
    mysqli_query($con, $sql);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Categories</title>
    <link rel="stylesheet" href="CSS/admin.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="admin-container">
        <?php include 'sidebar.php'; ?>
        
        <div class="main-content">
            <h1>Manage Categories</h1>
            
            <!-- Add Category Form -->
            <div class="category-section">
                <h2>Add New Category</h2>
                <form method="POST">
                    <input type="text" name="category_name" placeholder="Category Name" required>
                    <button type="submit" name="add_category">Add Category</button>
                </form>
            </div>
            
            <!-- Add Subcategory Form -->
            <div class="subcategory-section">
                <h2>Add New Subcategory</h2>
                <form method="POST">
                    <select name="category_id" required>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['category_id'] ?>"><?= $cat['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" name="subcategory_name" placeholder="Subcategory Name" required>
                    <button type="submit" name="add_subcategory">Add Subcategory</button>
                </form>
            </div>
            
            <!-- Existing Categories -->
            <div class="existing-categories">
                <h2>Current Categories</h2>
                <table>
                    <tr>
                        <th>Category</th>
                        <th>Subcategories</th>
                        <th>Actions</th>
                    </tr>
                    <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td><?= $cat['name'] ?></td>
                        <td>
                            <?php 
                            $subs = array_filter($subcategories, function($sub) use ($cat) {
                                return $sub['category_id'] == $cat['category_id'];
                            });
                            echo implode(', ', array_column($subs, 'name'));
                            ?>
                        </td>
                        <td>
                            <button class="edit-btn">Edit</button>
                            <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this category?');">
    <input type="hidden" name="category_id" value="<?= $cat['category_id'] ?>">
    <button type="submit" name="delete_category" class="delete-btn">Delete</button>
</form>

                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
    <script src="JavaScript/admin-sidebar.js"></script>
</body>
</html>