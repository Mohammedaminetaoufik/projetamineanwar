<?php
include("../php/config.php");

$product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
$p_name = mysqli_real_escape_string($conn, $_POST['p_name']);
$p_desc = mysqli_real_escape_string($conn, $_POST['p_desc']);
$p_price = mysqli_real_escape_string($conn, $_POST['p_price']);
$p_quantity = mysqli_real_escape_string($conn, $_POST['p_quantity']);
$category = mysqli_real_escape_string($conn, $_POST['category']);

if (isset($_FILES['newImage'])) {
    $location = "./uploads/";
    $img = $_FILES['newImage']['name'];
    $tmp = $_FILES['newImage']['tmp_name'];
    $dir = '../uploads/';
    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'webp');

    if (in_array($ext, $valid_extensions)) {
        $image = uniqid() . "." . $ext; 
        $final_image = $location . $image;
        $path = $dir . $image;
        move_uploaded_file($tmp, $path);
    } else {
       
        echo "Invalid file extension";
        exit;
    }
} else {
    $final_image = $_POST['existingImage'];
}


$updateItem = mysqli_prepare($conn, "UPDATE product SET 
    product_name=?, 
    product_desc=?, 
    price=?,
    quantity=?,
    category_id=?,
    product_image=? 
    WHERE product_id=?");

mysqli_stmt_bind_param($updateItem, 'ssddisi', $p_name, $p_desc, $p_price, $p_quantity, $category, $final_image, $product_id);
mysqli_stmt_execute($updateItem);

if (mysqli_stmt_affected_rows($updateItem) > 0) {
    echo "true";
} else {
    echo "Update failed: " . mysqli_error($conn);
}

mysqli_stmt_close($updateItem);
mysqli_close($conn);
?>
