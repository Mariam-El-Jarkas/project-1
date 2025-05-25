<?php
require 'php/connection.php';

// Get featured products
$products = [];
$result = mysqli_query($con, "
    SELECT p.*, c.name AS category_name 
    FROM products p
    JOIN categories c ON p.category_id = c.category_id
    ORDER BY p.created_at DESC
    LIMIT 6
");

while ($row = mysqli_fetch_assoc($result)) {
  $products[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Shoo Sports </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="CSS/HomePage/Main.css">
    <link rel="stylesheet" href="CSS/HomePage/layout/_header.css">
    <link rel="stylesheet" href="CSS/HomePage/sections/_hero.css">

    

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
      <a href="Home.php" class="title">Shoo Store</a>
    
      <nav class="main-nav active" id="mainNav">
        <ul class="nav-links">
          <li><a href="Home.php" class="nav-link">Home</a></li>
          <li class="dropdown">
            <a href="#" class="nav-link has-dropdown"><span> Women </span>
              <i class="fas fa-chevron-down dropdown-arrow hidden"></i>
              <i class="fa-solid fa-arrow-right"></i>
            </a>
            <ul class="dropdown-menu">
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
              <li><a href="./categories/Shirts&Tops(M).php">Shirts & Tops</a></li>
              <li><a href="./categories/Bottoms(M).php">Bottoms</a></li>
              <li><a href="./categories/Footwear(M).php">Footwear</a></li>
              <li><a href="./categories/Accessories(M).php">Accessories</a></li>
            </ul>
          </li>
          <li><a href="ContactUs.html">Contact</a></li>
          <li><a href="policy.html">Policy</a></li>
          <li><a href="AboutUs.html">About us</a></li>
        </ul>
      </nav>
    
      <div class="header-actions">
        <div class="search-container">
          <input type="text" class="search-input" placeholder="Search..." />
          <a href="#" class="icon-link"><i class="fas fa-search"></i></a>
        </div>
        <a href="login.php" class="icon-link"><i class="far fa-user"></i></a>
        <div class="cart-icon-container">
          <a href="#" class="icon-link"><i class="fa-solid fa-bag-shopping"></i></a>
          <span class="cart-counter">0</span>
        </div>
      </div>
    </header>
    <!-- Hero Section (the backgound image is in _hero.css)-->
    <section class="hero">
      <div class="hero-content">
        <h2 class="hero-subtitle">SUMMER SALE</h2>
        <h1 class="hero-title">NEW COLLECTION</h1>
        <h3 class="seasonal-collection"> SUMMER COLLECTION </h3>
      </div>
    </section>

    <section class="fullwidth-categories">
           <!-- Men's Banner -->
           <div class="category-banner men">
        <img src="./Images/image2.jpg" alt="Men's collection" class="banner-image">
        <div class="banner-content">
          <div class="text-group">
            <span class="collection-tag">ESSENTIALS BY SHOO STORE</span>
            <h2>T-SHIRTS & POLOS</h2>
            <a href="./men.php" class="shop-now-btn">Shop Men →</a>
          </div>
        </div>
      </div>
      <!-- Women's Banner -->
      <div class="category-banner women">
        <img src="./Images/image1.jpg" class="banner-image">
        <div class="banner-content">
          <div class="text-group">
            <span class="collection-tag">BASICS BY SHOOSTORE</span>
            <h2>SHIRTS & TOPS</h2>
            <a href="./women.php" class="shop-now-btn">Shop Women →</a>
          </div>
        </div>
      </div>
      <!-- Men's Banner (copy and pasted, edit later)-->
      <div class="category-banner men">
        <img src="./Images//image3.jpg" alt="Men's collection" class="banner-image">
        <div class="banner-content">
          <div class="text-group">
            <span class="collection-tag">ESSENTIALS BY SHOO STORE</span>
            <h2>T-SHIRTS & POLOS</h2>
            <a href="./men.php" class="shop-now-btn">Shop Men →</a>
          </div>
        </div>
      </div>
    </section>

  
    <main>
    <section class="featured-products">
      <div class="product-carousel">
        <button class="carousel-btn prev-btn">‹</button>
        <div class="carousel-container">
          <div class="carousel-track">
            <?php foreach ($products as $product): ?>
              <div class="product-card">
                <div class="product-image">
                  <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                </div>
                <div class="product-info">
                  <h3 class="product-name"><?= $product['name'] ?></h3>
                  <p class="price">$<?= number_format($product['price'], 2) ?></p>
                  <a href="product_detail.php?id=<?= $product['product_id'] ?>" class="choose-options">
                    Choose options
                  </a>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        <button class="carousel-btn next-btn">›</button>
      </div>
      <center><a href="Allitems.php" class="view-all-btn">View New Collection</a></center>
      

    </section>
  </main>
    <!-- Imports Footer-->
    <div w3-include-html="footer.html"></div>
    <script src="https://www.w3schools.com/lib/w3.js"></script>
    <script>w3.includeHTML();</script>
    <script src = "JavaScript/HomePage/Buttons.js"></script>
  </body>
</html>
