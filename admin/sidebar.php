<?php
// Always include database connection
require_once '../php/connection.php';

// Fetch categories from database
$categories_result = mysqli_query($con, "SELECT * FROM categories");
if (!$categories_result) {
    die("Database error: " . mysqli_error($con));
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<button class="mobile-menu-toggle" id="mobileMenuToggle">
    <i class="fas fa-bars"></i>
</button>

<div class="sidebar">
    <h2>Admin Panel</h2>
    <ul>
        <li><a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle">
                <i class="fas fa-box"></i> Products 
                <i class="fas fa-chevron-down dropdown-arrow"></i>
            </a>
            <ul class="submenu">
                <li><a href="products.php?category=all">All Products</a></li>
                <?php 
                // Reset pointer and fetch again
                mysqli_data_seek($categories_result, 0);
                while ($cat = mysqli_fetch_assoc($categories_result)) : 
                ?>
                    <li>
                        <a href="products.php?category=<?= urlencode($cat['name']) ?>">
                            <?= htmlspecialchars($cat['name']) ?>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>
        </li>
        <li><a href="orders.php"><i class="fas fa-shopping-cart"></i> Orders</a></li>
        <li><a href="../php/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
</div>

<script>
// Mobile Menu Toggle
document.getElementById('mobileMenuToggle').addEventListener('click', function() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('active');
});
</script>