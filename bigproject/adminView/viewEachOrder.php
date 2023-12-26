<?php
include("../php/config.php");


if (isset($_GET['orderID']) && is_numeric($_GET['orderID'])) {
    $orderID = intval($_GET['orderID']);

    
    $stmt = $conn->prepare("SELECT od.quantity, p.price, p.product_name, p.product_image
                            FROM order_details od
                            JOIN product p ON od.product_id = p.product_id
                            WHERE od.order_id = ?");
    $stmt->bind_param("i", $orderID);
    $stmt->execute();

    
    if (!$stmt) {
        die("Error: " . $conn->error);
    }

    
    $stmt->bind_result($quantity, $price, $product_name, $product_image);

    
    if ($stmt->fetch()) {
        echo '<div class="container">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>S.N.</th>
                            <th>Product Name</th>
                            <th>Product Image</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                        </tr>
                    </thead>
                    <tbody>';

        $count = 1;
        do {
            echo '<tr>
                    <td>' . $count . '</td>
                    <td>' . $product_name . '</td>
                    <td><img src="' . $product_image . '" alt="' . $product_name . '" style="max-width: 100px;"></td>
                    <td>' . $quantity . '</td>
                    <td>' . $price . '</td>
                </tr>';
            $count++;
        } while ($stmt->fetch());

        echo '</tbody></table></div>';
    } else {
        echo "No records found for Order ID: " . $orderID;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Invalid Order ID";
}
?>
