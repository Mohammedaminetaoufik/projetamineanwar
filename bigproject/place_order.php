<?php
session_start();
include("php/config.php");

if (!isset($_SESSION['valid'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['id'];


$userInfoSql = "SELECT * FROM users WHERE id = ?";
$stmtUserInfo = $conn->prepare($userInfoSql);
$stmtUserInfo->bind_param("i", $userId);
$stmtUserInfo->execute();
$userInfoResult = $stmtUserInfo->get_result();

if ($userInfoResult->num_rows > 0) {
    $userInfo = $userInfoResult->fetch_assoc();
    $deliveredTo = $userInfo['Username']; 
    $phoneNo = $userInfo['tele']; 

    
    $wishlistSql = "SELECT * FROM wishlist WHERE user_id = ?";
    $stmtWishlist = $conn->prepare($wishlistSql);
    $stmtWishlist->bind_param("i", $userId);
    $stmtWishlist->execute();
    $wishlistResult = $stmtWishlist->get_result();

    if ($wishlistResult->num_rows > 0) {
        
        $insertOrderSql = "INSERT INTO orders (user_id, delivered_to, phone_no, pay_status) 
                          VALUES (?, ?, ?, ?)";

        $stmtOrder = $conn->prepare($insertOrderSql);
        $stmtOrder->bind_param("isss", $userId, $deliveredTo, $phoneNo, $payStatus);

        
        $payStatus = 0;

        $stmtOrder->execute();

        
        $orderId = $stmtOrder->insert_id;

        
        $wishlistResult->data_seek(0);

        while ($wishlistItem = $wishlistResult->fetch_assoc()) {
            $productId = $wishlistItem['product_id'];
            $quantity = $wishlistItem['quantity'];

           
            $checkProductSql = "SELECT COUNT(*) FROM product WHERE product_id = ?";
            $stmtCheckProduct = $conn->prepare($checkProductSql);
            $stmtCheckProduct->bind_param("i", $productId);
            $stmtCheckProduct->execute();
            $stmtCheckProduct->bind_result($productCount);
            $stmtCheckProduct->fetch();
            $stmtCheckProduct->close();

            if ($productCount > 0) {
                $price = isset($wishlistItem['price']) ? $wishlistItem['price'] : 0;

                $insertOrderDetailsSql = "INSERT INTO order_details (order_id, product_id, quantity, price) 
                                          VALUES (?, ?, ?, ?)";

                $stmtDetails = $conn->prepare($insertOrderDetailsSql);
                $stmtDetails->bind_param("iiid", $orderId, $productId, $quantity, $price);

                $stmtDetails->execute();
                $stmtDetails->close();
            } else {
                
            }
        }

        $successMessage1 = "Votre commande a été passée avec succès";
        $successMessage2 = "nous vous appellerons sur votre numero de telephone pour la confirmation";
        $successMessage3 = "MERCI";
    } else {
        $errorMessage = "Votre panier est vide. Ajoutez des articles à votre panier avant de passer une commande.";
    }
} else {
    $errorMessage = "Informations utilisateur non trouvées.";
}



if (isset($_SESSION['totalPrice'])) {
    $totalPrice = $_SESSION['totalPrice'];
} else {
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>confirmation order | LWEM</title>
    <link rel="icon" type="image/x-icon" href="uploads/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&family=Playfair+Display:wght@400;700&display=swap');
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #ff9d14;
            font-family: 'Poppins', sans-serif;
            align-items: center;
            justify-content: center;
        }

        .container {
            max-width: 600px;
            margin: 100px auto;
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

        }

        .success-message, .error-message {
            text-align: center;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .success-message p {
            color: #28a745;

        }

        .error-message p {
            color: #dc3545;
        }
        .checkmark__circle {
    stroke-dasharray: 166;
    stroke-dashoffset: 166;
    stroke-width: 2;
    stroke-miterlimit: 10;
    stroke: #7ac142;
    fill: none;
    animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
}

.checkmark {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    display: block;
    stroke-width: 2;
    stroke: #fff;
    stroke-miterlimit: 10;
    margin: 10% auto;
    box-shadow: inset 0px 0px 0px #7ac142;
    animation: checkmarkFill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
}

.checkmark__check {
    transform-origin: 50% 50%;
    stroke-dasharray: 48;
    stroke-dashoffset: 48;
    animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
}

@keyframes checkmarkFill {
    100% {
        box-shadow: inset 0px 0px 0px 30px #7ac142;
    }
}

.crossmark {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    display: block;
    stroke-width: 2;
    stroke: #fff;
    stroke-miterlimit: 10;
    box-shadow: inset 0px 0px 0px #7ac142;
    animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
}

.crossmark_circle {
    stroke-dasharray: 166;
    stroke-dashoffset: 166;
    stroke-width: 2;
    stroke-miterlimit: 10;
    stroke: red;
    fill: none;
    animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
}

.crossmark_check {
    transform-origin: 50% 50%;
    stroke-dasharray: 48;
    stroke-dashoffset: 48;
    animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
}

@keyframes stroke {
    100% {
        stroke-dashoffset: 0;
    }
}

@keyframes scale {
    0%, 100% {
        transform: none;
    }
    50% {
        transform: scale3d(1.1, 1.1, 1);
    }
}

@keyframes fill {
    100% {
        box-shadow: inset 0px 0px 0px 30px red;
    }
}

.error-message a{
    color: white;
    padding: 9px;
    font-size: 18px;
    background-color: red;
    border-radius: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
.error-message a:hover{
    background-color: white;
    color:red;
    transition: all 0.3s ease-in-out;
    text-decoration:none;
}


.success-message a{
   color: white;
   padding: 9px;
   font-size: 18px;
   background-color: green;
   border-radius: 20px;
   box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
.success-message a:hover{
    background-color: white;
    color:green;
    transition: all 0.3s ease-in-out;
    text-decoration:none;
}



    </style>
</head>
<body>

<div class="container">
    <?php
    if (isset($successMessage1,$successMessage2,$successMessage3)): ?>
        <div class="success-message">
        <div class="wrapper"> <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"> <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/> <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
</svg>
</div>
            <p>prix total est : <strong><?= $totalPrice ?>.00 DH</strong></p>
            <p><?= $successMessage1 ?></p>
            <p><?= $successMessage2 ?></p>
            <p><?= $successMessage3 ?></p>
            <a href="wishlist.php">retour</a>
        </div>
    <?php elseif (isset($errorMessage)): ?>
        <div class="error-message">
        <center><div class="wrapper">
<svg class="crossmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"><circle class="checkmark_circle" cx="26" cy="26" r="25" fill="none"/><path class="checkmark_check" fill="none" d="M14.1 14.1l23.8 23.8 m0,-23.8 l-23.8,23.8"/></svg>
</div></center><br>
            <p><?= $errorMessage ?></p>
            <a href="productpage.php">retour</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
