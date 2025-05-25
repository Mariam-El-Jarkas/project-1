<?php
require('../php/connection.php');

// Get Men's Shirts & Tops
$products = [];
$result = mysqli_query($con, "
    SELECT p.* 
    FROM products p
    JOIN categories c ON p.category_id = c.category_id
    WHERE c.name = 'Shirts & Tops'
    AND p.gender = 'male'
");

while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Men's Shirts & Tops</title>
    <link rel="stylesheet" href="CSS/ProductCategory.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="../CSS/HomePage/layout/_header.css" />
    <link rel="stylesheet" href="../CSS/HomePage/Main.css" />
</head>

<body>
    <!-- Links header -->
    <header class="header">
        <!-- Mobile Menu Toggle (far left) -->
        <div class="toggle" id="menuToggle">
            <i class="fa-solid fa-bars"></i>
            <i class="fa-solid fa-x hidden"></i>
        </div>

        <!-- Title (left) -->
        <a href="../Home.php" class="title">Shoo Store</a>

        <nav class="main-nav active" id="mainNav">
            <ul class="nav-links">
                <li><a href="../Home.php" class="nav-link">Home</a></li>
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown">
                        <span> Women </span>
                        <i class="fas fa-chevron-down dropdown-arrow hidden"></i>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="./Shirts&Tops(W).php">Shirts & Tops</a></li>
                        <li><a href="./Bottoms(W).php">Bottoms</a></li>
                        <li><a href="./Footwear(W).php">Footwear</a></li>
                        <li><a href="./Accessories(W).php">Accessories</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">
                        <span>Men</span>
                        <i class="fas fa-chevron-down dropdown-arrow hidden"></i>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="./Shirts&Tops(M).php">Shirts & Tops</a></li>
                        <li><a href="./Bottoms(M).php">Bottoms</a></li>
                        <li><a href="./Footwear(M).php">Footwear</a></li>
                        <li><a href="./Accessories(M).php">Accessories</a></li>
                    </ul>
                </li>
                <li><a href="../ContactUs.html">Contact</a></li>
                <li><a href="../policy.html">Policy</a></li>
                <li><a href="../AboutUs.html">About us</a></li>
            </ul>
        </nav>

        <div class="header-actions">
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Search..." />
                <a href="#" class="icon-link"><i class="fas fa-search"></i></a>
            </div>
            <a href="../login.php" class="icon-link"><i class="far fa-user"></i></a>
            <div class="cart-icon-container">
                <a href="#" class="icon-link">
                    <i class="fa-solid fa-bag-shopping"></i>
                </a>
                <span class="cart-counter">0</span>
            </div>
        </div>
    </header>

    <main class="product-listing">
        <h1>Men's Shirts & Tops</h1>

        <div class="product-grid">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <div class="product-image">
                            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" />
                        </div>
                        <div class="product-info">
                            <h3><?= htmlspecialchars($product['name']) ?></h3>
                            <p class="price">$<?= number_format($product['price'], 2) ?></p>
                            <a href="product_detail.php?id=<?= urlencode($product['product_id']) ?>" class="cta-button">
                                View Details
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No Shirts & Tops found for men.</p>
            <?php endif; ?>
        </div>
    </main>

    <footer class="footer">
        <div class="social-links">
            <a href="https://www.instagram.com/shoosports.lb/"><i class="fab fa-instagram"></i></a>
            <a href="https://www.tiktok.com/@shoosports.lb?_t=8ZXi2raRhKr&_r=1"><i class="fab fa-tiktok"></i></a>
            <a href="https://wa.me/+96170172689"><i class="fab fa-whatsapp"></i></a>
            <a href="https://www.google.com/maps/place/Shoosports/@33.5557082,35.3968174,17z/data=!3m1!4b1!4m6!3m5!1s0x151eef2c75d507a3:0xa00e0d07c0836fba!8m2!3d33.5557082!4d35.3968174!16s%2Fg%2F11jt2j209r?entry=ttu" aria-label="Google Maps location">
                <i class="fas fa-map-marker-alt"></i>
            </a>
        </div>
        <p>&copy; 2025 SHOO SPORTS. All rights reserved</p>
    </footer>
</body>

</html>
