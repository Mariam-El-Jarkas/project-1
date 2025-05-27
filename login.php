<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./CSS/HomePage/layout/_Login.css"> 
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
            <li><a href="categories/women.php">View All</a></li>
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
            <li><a href="categories/men.php">View All</a></li>
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
          <a href="#" class="icon-link" onclick="toggleCart()"><i class="fa-solid fa-bag-shopping"></i></a>
          <span class="cart-counter">0</span>
        </div>
      </div>
    </header>
<div class="body">
  <h2>Login</h2>
  <form action="php/login_action.php" method="post">
    <input type="email" name="email" id="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <?php if(isset($_GET['error'])) { ?>
      <div class="error">Invalid email or password!</div>
    <?php } ?>
    <a href="#" class="forgot-password">Forgot your password?</a>
    <button type="submit">Sign in</button>
    <a href="CreateAccount.html" class="forgot-password">Create account</a>
  </form>
</div>
<div w3-include-html="footer.html"></div>
<script src="https://www.w3schools.com/lib/w3.js"></script>
<script>
  w3.includeHTML();
</script>
</body>
</html>