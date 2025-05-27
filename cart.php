<?php
session_start();

$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    echo "<p>Your cart is empty.</p>";
} else {
    echo "<ul style='list-style: none; padding: 0;'>";
    foreach ($cart as $item) {
        echo "<li style='margin-bottom: 10px;'>
                <strong>{$item['name']}</strong><br>
                Quantity: {$item['qty']}<br>
                Price: \${$item['price']}
              </li>";
    }
    echo "</ul>";
}
?>
