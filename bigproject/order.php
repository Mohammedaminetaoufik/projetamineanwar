<?php

session_start();
include("php/config.php");


// Fetch wishlist items
$user_id = $_SESSION['Id']; // Assuming your user ID is stored in 'Id', update it accordingly
$wishlistSql = "SELECT p.* FROM wishlist w 
                JOIN product p ON w.product_id = p.product_id 
                WHERE w.user_id = $user_id";
$wishlistResult = $conn->query($wishlistSql);
$wishlistData = [];

if ($wishlistResult->num_rows > 0) {
    while ($wishlistRow = $wishlistResult->fetch_assoc()) {
        $wishlistData[] = $wishlistRow;
    }
}

// Check if the wishlist is not empty before creating an order
if (empty($wishlistData)) {
    // Redirect to a page indicating that the wishlist is empty
    header("Location: empty_wishlist.php");
    exit();
}

// Create an order in the orders table
$delivered_to = $conn->real_escape_string('John Doe'); // Escape user input
$phone_no = $conn->real_escape_string('1234567890'); // Escape user input
$deliver_address = $conn->real_escape_string('123 Main St'); // Escape user input
$pay_method = $conn->real_escape_string('Cash on Delivery'); // Escape user input

$orderSql = "INSERT INTO orders (user_id, delivered_to, phone_no, deliver_address, pay_method, pay_status) 
             VALUES ($user_id, '$delivered_to', '$phone_no', '$deliver_address', '$pay_method', 0)";
$conn->query($orderSql);

// Check if the order insertion was successful
if ($conn->affected_rows <= 0) {
    // Redirect to a page indicating an error in order creation
    header("Location: order_error.php");
    exit();
}

$order_id = $conn->insert_id;

// Add items to the order_details table
foreach ($wishlistData as $wishlistItem) {
    $product_id = $wishlistItem['product_id'];
    $quantity = 1; // You can modify this based on user input
    $price = $wishlistItem['price'];

    $orderDetailsSql = "INSERT INTO order_details (order_id, product_id, quantity, price) 
                       VALUES ($order_id, $product_id, $quantity, $price)";
    $conn->query($orderDetailsSql);
}

// Clear the wishlist after placing the order
$clearWishlistSql = "DELETE FROM wishlist WHERE user_id = $user_id";
$conn->query($clearWishlistSql);

// Redirect to a confirmation page or any other desired page
header("Location: order_confirmation.php");
exit();
?>
