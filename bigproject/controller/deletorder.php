<?php
include("../php/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["orderID"])) {
    $orderID = $_POST["orderID"];

    // Perform the deletion in order_details
    $deleteOrderDetailsSql = "DELETE FROM order_details WHERE order_id = ?";
    $stmtDeleteOrderDetails = $conn->prepare($deleteOrderDetailsSql);
    $stmtDeleteOrderDetails->bind_param("i", $orderID);

    if ($stmtDeleteOrderDetails->execute()) {
        // Now, delete the order in orders table
        $deleteOrderSql = "DELETE FROM orders WHERE order_id = ?";
        $stmtDeleteOrder = $conn->prepare($deleteOrderSql);
        $stmtDeleteOrder->bind_param("i", $orderID);

        if ($stmtDeleteOrder->execute()) {
            echo "Order and related details deleted successfully";
        } else {
            echo "Error deleting order: " . $stmtDeleteOrder->error; // Log the error
        }

        $stmtDeleteOrder->close();
    } else {
        echo "Error deleting order details: " . $stmtDeleteOrderDetails->error; // Log the error
    }

    $stmtDeleteOrderDetails->close();
} else {
    echo "Invalid request";
}
?>
