<?php
session_start();
require '../php/connection.php';

// Check admin status
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// File upload configuration
$upload_dir = '../uploads/products/';
$allowed_types = ['jpg', 'jpeg', 'png', 'webp'];
$max_size = 5 * 1024 * 1024; // 5MB

// Create upload directory if not exists
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// Get categories and brands
$categories = [];
$brands = [];
$categories_result = mysqli_query($con, "SELECT * FROM categories");
$brands_result = mysqli_query($con, "SELECT * FROM brands");

while ($cat = mysqli_fetch_assoc($categories_result)) {
    $categories[] = $cat;
}
while ($brand = mysqli_fetch_assoc($brands_result)) {
    $brands[] = $brand;
}

// Handle form submission
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Product data
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $price = (float)$_POST['price'];
    $category = (int)$_POST['category'];
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $stock = (int)$_POST['stock'];
    $brand_id = null;
    $image_path = '';

    // Handle image upload
    if (!empty($_FILES['product_image']['name'])) {
        $file = $_FILES['product_image'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $new_name = uniqid('prod_', true) . '.' . $ext;
        $target_path = $upload_dir . $new_name;

        // Validate image
        if (!in_array($ext, $allowed_types)) {
            $error = 'Only JPG, JPEG, PNG & WEBP files are allowed';
        } elseif ($file['size'] > $max_size) {
            $error = 'File size must be less than 5MB';
        } elseif (!move_uploaded_file($file['tmp_name'], $target_path)) {
            $error = 'Error uploading file';
        } else {
            $image_path = 'uploads/products/' . $new_name;
        }
    } else {
        $error = 'Product image is required';
    }

    // Handle brand selection
    if (!$error) {
        if (!empty($_POST['new_brand'])) {
            // Insert new brand
            $new_brand = mysqli_real_escape_string($con, $_POST['new_brand']);
            $stmt = $con->prepare("INSERT INTO brands (name) VALUES (?)");
            $stmt->bind_param("s", $new_brand);
            if ($stmt->execute()) {
                $brand_id = $stmt->insert_id;
            } else {
                $error = "Error creating brand: " . $stmt->error;
            }
        } elseif (!empty($_POST['existing_brand'])) {
            $brand_id = (int)$_POST['existing_brand'];
        }

        // Validate remaining inputs
        if (!$error) {
            if ($price <= 0 || $stock < 0) {
                $error = "Invalid price or stock value";
            } elseif (!$brand_id) {
                $error = "Please select or enter a brand";
            } else {
                // Insert product
                $stmt = $con->prepare("INSERT INTO products 
                    (name, category_id, brand_id, price, gender, inventory_count, image) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("siidsis", $name, $category, $brand_id, $price, $gender, $stock, $image_path);
                
                if ($stmt->execute()) {
                    header("Location: products.php?category=all");
                    exit();
                } else {
                    $error = "Error adding product: " . $stmt->error;
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="CSS/admin.css">
    <style>
        .product-form {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 1.5rem;
        }
        .modern-input, .modern-select {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }
        input[type="file"] {
            padding: 15px;
            border: 2px dashed #ddd;
            background: #f8f9fa;
        }
        .brand-selector {
            display: flex;
            gap: 15px;
            margin: 20px 0;
        }
        .brand-option {
            flex: 1;
            position: relative;
        }
        .brand-option input[type="radio"] {
            position: absolute;
            opacity: 0;
        }
        .brand-option label {
            display: block;
            padding: 15px;
            background: #f8f9fa;
            border: 2px solid #ddd;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        .brand-option input:checked + label {
            background: #3498db;
            color: white;
            border-color: #3498db;
        }
        .error-message {
            color: #dc3545;
            padding: 15px;
            margin-bottom: 20px;
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <?php include 'sidebar.php'; ?>

        <div class="main-content">
            <h1>Add New Product</h1>
            
            <?php if ($error): ?>
                <div class="error-message"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST" class="product-form" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Product Name:</label>
                    <input type="text" name="name" class="modern-input" required>
                </div>

                <div class="form-group">
                    <label>Product Image:</label>
                    <input type="file" name="product_image" accept="image/*" required>
                    <small>Allowed formats: JPG, PNG, WEBP (Max 5MB)</small>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Category:</label>
                        <select name="category" class="modern-select" required>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['category_id'] ?>">
                                    <?= htmlspecialchars($cat['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Gender:</label>
                        <select name="gender" class="modern-select" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="unisex">Unisex</option>
                        </select>
                    </div>
                </div>

                <div class="brand-selection">
                    <div class="brand-selector">
                        <div class="brand-option">
                            <input type="radio" name="brand_type" id="existingBrand" 
                                   value="existing" checked class="brand-type">
                            <label for="existingBrand">Existing Brand</label>
                        </div>
                        <div class="brand-option">
                            <input type="radio" name="brand_type" id="newBrand" 
                                   value="new" class="brand-type">
                            <label for="newBrand">New Brand</label>
                        </div>
                    </div>

                    <div class="form-row">
                        <div id="existingBrandGroup" class="form-group">
                            <select name="existing_brand" class="modern-select">
                                <?php foreach ($brands as $brand): ?>
                                    <option value="<?= $brand['brand_id'] ?>">
                                        <?= htmlspecialchars($brand['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div id="newBrandGroup" class="form-group" style="display: none;">
                            <input type="text" name="new_brand" 
                                   class="modern-input" 
                                   placeholder="Enter new brand name">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Price ($):</label>
                        <input type="number" step="0.01" name="price" 
                               class="modern-input" required>
                    </div>
                    <div class="form-group">
                        <label>Stock Quantity:</label>
                        <input type="number" name="stock" min="0" 
                               class="modern-input" required>
                    </div>
                </div>

                <button type="submit" class="btn">Add Product</button>
            </form>
        </div>
    </div>

    <script>
        // Toggle brand input visibility
        document.addEventListener('DOMContentLoaded', function() {
            const brandRadios = document.querySelectorAll('input[name="brand_type"]');
            const existingGroup = document.getElementById('existingBrandGroup');
            const newGroup = document.getElementById('newBrandGroup');

            brandRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'new') {
                        existingGroup.style.display = 'none';
                        newGroup.style.display = 'block';
                    } else {
                        existingGroup.style.display = 'block';
                        newGroup.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>