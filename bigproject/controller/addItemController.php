<?php
include("../php/config.php");

if (isset($_POST['upload'])) {
    $ProductName = mysqli_real_escape_string($conn, $_POST['p_name']);
    $desc = mysqli_real_escape_string($conn, $_POST['p_desc']);
    $price = mysqli_real_escape_string($conn, $_POST['p_price']);
    $quantity = mysqli_real_escape_string($conn, $_POST['p_quantity']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    $name = $_FILES['file']['name'];
    $temp = $_FILES['file']['tmp_name'];

    $location = "./uploads/";
    $image = $location . $name;

    $target_dir = "../uploads/";
    $finalImage = $target_dir . $name;

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    chmod($finalImage, 0644);

    move_uploaded_file($temp, $finalImage);

    $insert = mysqli_query($conn, "INSERT INTO product
        (product_name, product_image, price, product_desc, quantity, category_id) 
        VALUES ('$ProductName', '$image', $price, '$desc', '$quantity', '$category')");

    if (!$insert) {
        echo mysqli_error($conn);
    } else {
        echo "Records added successfully.";
    }
}
?>
