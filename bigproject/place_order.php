<?php
session_start();
include("php/config.php");

// Check if the user is logged in
if (!isset($_SESSION['valid'])) {
    header("Location: login.php");
}

// Fetch wishlist items
$user_id = $_SESSION['user_id'];
$wishlistSql = "SELECT p.* FROM wishlist w JOIN product p ON w.product_id = p.product_id WHERE w.user_id = $user_id";
$wishlistResult = $conn->query($wishlistSql);
$wishlistData = [];

if ($wishlistResult->num_rows > 0) {
    while ($wishlistRow = $wishlistResult->fetch_assoc()) {
        $wishlistData[] = $wishlistRow;
    }
}

// Create an order in the orders table
$orderSql = "INSERT INTO orders (user_id, delivered_to, phone_no, deliver_address, pay_method, pay_status) 
             VALUES ($user_id, 'John Doe', '1234567890', '123 Main St', 'Cash on Delivery', 0)";
$conn->query($orderSql);
$order_id = $conn->insert_id;

// Add items to the order_details table
foreach ($wishlistData as $wishlistItem) {
    $variation_id = $wishlistItem['variation_id'];
    $quantity = 1; // You can modify this based on user input
    $price = $wishlistItem['price'];

    $orderDetailsSql = "INSERT INTO order_details (order_id, variation_id, quantity, price) 
                       VALUES ($order_id, $variation_id, $quantity, $price)";
    $conn->query($orderDetailsSql);
}

// Clear the wishlist after placing the order
$clearWishlistSql = "DELETE FROM wishlist WHERE user_id = $user_id";
$conn->query($clearWishlistSql);

// Redirect to a confirmation page or any other desired page
header("Location: order.php");
exit();
?>
