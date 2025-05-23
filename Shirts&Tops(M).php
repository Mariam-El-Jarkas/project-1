<?php
require 'php/connection.php';

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Men's Shirts & Tops</title>
    <link rel="stylesheet" href="CSS/ProductCategory.css">
</head>

<body>
    <div w3-include-html="header.html"></div>

    <main class="product-listing">
        <h1>Men's Shirts & Tops</h1>

        <div class="product-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <div class="product-image">
                        <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                    </div>
                    <div class="product-info">
                        <h3><?= $product['name'] ?></h3>
                        <p class="price">$<?= number_format($product['price'], 2) ?></p>
                        <a href="product_detail.php?id=<?= $product['product_id'] ?>" class="cta-button">
                            View Details
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <div w3-include-html="footer.html"></div>
    <script src="https://www.w3schools.com/lib/w3.js"></script>
    <script>
        w3.includeHTML();
    </script>
</body>

</html>