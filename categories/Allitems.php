<?php
require('../php/connection.php');

// Define all categories and genders
$genders = ['male' => 'Men', 'female' => 'Women'];
$categories = ['Accessories', 'Footwear', 'Bottoms', 'Shirts & Tops'];

$allProducts = [];

foreach ($genders as $genderKey => $genderLabel) {
    foreach ($categories as $category) {
        $stmt = $con->prepare("
            SELECT p.*, c.name AS category_name 
            FROM products p
            JOIN categories c ON p.category_id = c.category_id
            WHERE c.name = ? AND p.gender = ?
        ");
        $stmt->bind_param("ss", $category, $genderKey);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $key = "$genderLabel - $category";
        $allProducts[$key] = $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Items</title>
    <link rel="stylesheet" href="CSS/ProductCategory.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../CSS/HomePage/layout/_header.css">
    <link rel="stylesheet" href="../CSS/HomePage/Main.css">
    <link rel="stylesheet" href="CSS/HomePage/layout/_allitems.css">
</head>
<body>

<!-- HEADER -->
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
            <a href="#" class="nav-link has-dropdown"><span> Women </span>
              <i class="fas fa-chevron-down dropdown-arrow hidden"></i>
              <i class="fa-solid fa-arrow-right"></i>
            </a>
            <ul class="dropdown-menu">
            <li><a href="../categories/women.php">View All</a></li>
              <li><a href="./categories/Shirts&Tops(W).php">Shirts & Tops</a></li>
              <li><a href="./categories/Bottoms(W).php">Bottoms</a></li>
              <li><a href="./categories/Footwear(W).php">Footwear</a></li>
              <li><a href="./categories/Accessories(W).php">Accessories</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#">
              <span>Men</span>
              <i class="fas fa-chevron-down dropdown-arrow hidden"></i>
              <i class="fa-solid fa-arrow-right"></i></a>
            <ul class="dropdown-menu">
            <li><a href="../categories/men.php">View All</a></li>
              <li><a href="./categories/Shirts&Tops(M).php">Shirts & Tops</a></li>
              <li><a href="./categories/Bottoms(M).php">Bottoms</a></li>
              <li><a href="./categories/Footwear(M).php">Footwear</a></li>
              <li><a href="./categories/Accessories(M).php">Accessories</a></li>
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
        <a href="login.php" class="icon-link"><i class="far fa-user"></i></a>
        <div class="cart-icon-container">
          <a href="#" class="icon-link" onclick="toggleCart()"><i class="fa-solid fa-bag-shopping"></i></a>
          <span class="cart-counter">0</span>
        </div>
      </div>
    </header>

<main class="product-listing">
    <h1>All Items</h1>

    <?php foreach ($allProducts as $sectionTitle => $products): ?>
        <section class="product-category-group">
            <h2><?= htmlspecialchars($sectionTitle) ?></h2>
            <div class="product-grid">
                <?php if (count($products) > 0): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="product-card">
                            <div class="product-image">
                                <img src="../<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                            </div>
                            <div class="product-info">
                                <h3><?= htmlspecialchars($product['name']) ?></h3>
                                <p class="price">$<?= number_format($product['price'], 2) ?></p>
                                <a href="product_detail.php?id=<?= $product['product_id'] ?>" class="cta-button">
                                    View Details
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No items found in this category.</p>
                <?php endif; ?>
            </div>
        </section>
    <?php endforeach; ?>
</main>

<!-- FOOTER -->
<div w3-include-html="../footer.html"></div>
    <script src="https://www.w3schools.com/lib/w3.js"></script>
    <script>
      w3.includeHTML();
    </script>
  </body>
  <script src="JavaScript/HomePage/Buttons.js"></script>

</body>
</html>
