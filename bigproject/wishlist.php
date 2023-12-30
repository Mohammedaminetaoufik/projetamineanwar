<?php
session_start();
include("php/config.php");

if (!isset($_SESSION['valid'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_quantity'])) {
        $wishId = $_POST['wish_id'];
        $quantity = $_POST['quantity'];

        if ($quantity >= 1) {
            $updateQuantitySql = "UPDATE wishlist SET quantity = $quantity WHERE wish_id = $wishId AND user_id = $userId";
            $conn->query($updateQuantitySql);
        }
    } elseif (isset($_POST['remove'])) {
        $wishId = $_POST['wish_id'];

        $deleteSql = "DELETE FROM wishlist WHERE user_id = $userId AND wish_id = $wishId";
        $deleteResult = $conn->query($deleteSql);
    }
    header("Location: wishlist.php");
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['product_id']) && isset($_GET['product_name'])) {
    $productId = $_GET['product_id'];
    $productName = urldecode($_GET['product_name']);
    $userId = $_SESSION['id'];

    $checkSql = "SELECT * FROM wishlist WHERE user_id = $userId AND product_id = $productId";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows == 0) {
        $insertSql = "INSERT INTO wishlist (user_id, product_id, quantity) VALUES ($userId, $productId, 1)";
        $insertResult = $conn->query($insertSql);
    }
    header("Location: wishlist.php");
    exit();
}

$wishlistSql = "SELECT w.wish_id, p.product_name, p.product_desc, p.price, p.product_image, w.quantity
                FROM wishlist w
                INNER JOIN product p ON w.product_id = p.product_id
                WHERE w.user_id = $userId";
$wishlistResult = $conn->query($wishlistSql);







?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Panier | LWEM</title>
    <link rel="icon" type="image/x-icon" href="uploads/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <style>
         @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&family=Playfair+Display:wght@400;700&display=swap');
         body {
            font-family: 'Arial';
            margin: 0;
            padding: 0;
            box-sizing: border-box;

    }

        header {
    background-color: #ffffff;
    text-align: center;
    position: relative;
    padding: 7px;
    display: flex; 
    justify-content: space-between; 
    align-items: center; 
    
}

header h1 {
    margin-left: 20px;
    font-family: serif;
    color: rgb(0, 174, 255);
    text-decoration: underline;
    
}

header h1 span {
    color: rgb(255, 157, 0);
    font-size: 23px;
    font-family: system-ui;
}

header a {
    margin-right: 20px;
    font-size:60px;
    color:rgb(255, 157, 0);
}

.logodiv{
    display: flex;
    flex-wrap:nowrap;
    margin-left:20px;
}
button#mobile-menu-button {
        display: none; 
    }
button{
    border: none;
    background-color: transparent;
    color: #ff9500;
    margin-left:30px;
}
button i{
    font-size: 30px;
    cursor: pointer;
}

nav {
            overflow: hidden;
            background-color: rgb(255, 255, 255);
            padding: 20px;
            font-family: 'Poppins',sans-serif;
            transition: padding 0.3s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        nav a {
            float: left;
            display: block;
            color: rgb(255, 157, 0);
            text-align: center;
            padding: 14px 16px;
            text-decoration: overline;
            font-weight: 600;
            font-size: large;
            font-family: 'Poppins',sans-serif;
        }

        nav a:hover {
            background-color: rgb(255, 187, 0);
            color: #ffffff;
            transition: 0.2s ease-in-out;
            text-decoration: underline;
            
        }

        #wishlist {
            font-family: 'Poppins', sans-serif;
            background-color:#FBFBFB;
            
        }
        #wishlist h2{
            font-size:40px;
            margin-left:30px;
            margin-top:20PX;
        }
        .msgpanier{
            font-size:30px;
            margin-left:30px;
            margin-top:20PX;
            text-align:center;
        }

        .wishlist-items {
            margin: 20px;        
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.wishlist-item {
    border: 1px solid #ddd;
    border-radius: 15px; 
    padding: 0.5rem;
    width: 70%;
    height:100%; 
    position: relative;
    margin-right: 2rem;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-wrap:nowrap;
}

.wishlist-item h3 {
    font-size: 1.5rem;
    font-weight: bold; 
    margin-bottom: 0.5rem;
}

.wishlist-item p {
    font-size: 1rem; 
    color: #555;
     
}

.wishlist-item table {
    width: 50%;
}

.wishlist-item td {
    vertical-align: top;
}

.wishlist-item img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 70%;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

        .quantity-selector {
        width: 50px;
        padding: 8px;
        font-size: 14px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .quantity-selector:focus {
        outline: none;
        border-color: #007bff; 
    }
    .btntrash {
    background-color: white;
    border: none;
    color: #f44336;
    margin:35PX;
    text-align: center;
    text-decoration: none;
    font-size: 20px;
   
    cursor: pointer;
    border-radius: 50%;
}
.updatebtn{
    font-size:15px;
    border: none;
    background-color: rgb(0, 174, 255);
    color:white;
    cursor: pointer;
    border-radius: 10%;
    font-family: 'Poppins', sans-serif;
    margin:20PX;

}
#services{
    background-color:white;
    padding:20PX;
    font-family: 'Poppins', sans-serif;

    
    
}

#services ul{
    display: flex;
    flex-wrap: wrap;
    margin:10px;
    text-align: center;
   justify-content:center;
   justify-content: space-between;
   
}
#services ul li{
   list-style:none;
   font-size:30PX;
}
#services ul li i{
    display: flex;
    flex-wrap: wrap;
    text-align: center;
   justify-content:center;
   font-size:50PX;
}

footer {
            overflow: hidden;
            justify-content: space-between;
            display: flex;
            background-color: #ff9d14;
            color: #ffffff;
            text-align: left;
            padding: 50px;
            position: relative;
            font-family: 'Poppins', sans-serif;
        }

        footer ul {
            font-weight: 600;
            font-size: larger;
            padding: 14px 16px;
        }

        footer ul li {
            line-height: 1.8;
        }

        footer ul li a {
            color: #ffffff;
        }

        footer ul li a:hover {
            color: rgb(0, 0, 0);
        }

        footer ul h1 {
            font-size: 25px;
        }

        footer p {
            position:absolute;
            text-align: left;
            padding-top:170PX ;

        }
        footer i{
            font-size: 20px;
        }

        .cop {
            background-color: #ff9d14;
            color: #ffffff;
            padding: 4px;
        }

        .fixedButton{
            position: fixed;
            bottom: 10px;
            right: 5px; 
            padding: 20px;z-index: 1000;
        }
        .roundedFixedBtn{
          font-family: 'Poppins', sans-serif;  
          height: 70px;
          line-height: 70px;  
          width: 190px;  
          font-size: 1em;
          font-weight:600;
          border-radius: 30%;
          background-color:rgb(0, 174, 255) ;
          color: white;
          text-align: center;
          cursor: pointer;
          box-shadow: 0 5px 5px rgba(0, 0, 0, 0.1);
          
        }

        .roundedFixedBtn:hover{
            background-color: white;
            color:#ff9d14;
            transition: 0.2s ease-in-out;
        }

::-webkit-scrollbar {
    width: 12px;
}
::-webkit-scrollbar-track {
  background: white; 
}
::-webkit-scrollbar-thumb {
  background: #ff9d14; 
  border-radius: 6px;
}
::-webkit-scrollbar-thumb:hover {
  background: #ff9d14; 
}

@media screen and (max-width: 600px) {


    header {
        position: relative;
    padding: 5px;
    display: flex; 
    justify-content: space-between; 
    align-items: center; 
        
    }


    header a {
        margin-right: 0;
        font-size: 30px;
    }

    header p {
        width: 200px;
        margin-right: 20px;
        margin-top: 10px;
        text-align: center;
        font-size:14px;
    }

    header p span a {
        right: 16px;
        font-size:12px;
        top:52px;
    }

    button#mobile-menu-button {
        display: block; 
        margin-left:20px;;
    }
         nav {
        overflow: hidden;
    display: flex;
    flex-direction: column;
    top: 60px;
    background-color: rgb(255, 255, 255);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    opacity: 0;
    max-height: 0;
    transition: opacity 0.3s ease-out, max-height 0.3s ease-out;
      }
      
   nav.show {
    opacity: 1;
    max-height: 330px; 
     }

    #wishlist h2{
        font-size:30px;
        margin-right: 10px;
    }
    .msgpanier{
        font-size:20px;
        margin-right: 10px;
    }
    .wishlist-item {
        width: 100%;
        margin-right: 0;
    }
    .wishlist-item h3 {
    font-size: 1rem;
}

.wishlist-item p {
    font-size: 0.8rem; 
}

    .wishlist-item table {
        width: 1000px;
    }
    .wishlist-item td {
    vertical-align: top;
}

  .wishlist-item img {
    width: 180px;
    height: 80px;
}
.quantity-selector {
        width: 44px;
        padding: 2px;
        font-size: 10px;
    }

    .quantity-selector:focus {
        outline: none;
        border-color: #007bff; 
    }

    .updatebtn{
        font-size:10px;
        margin:10px;
        margin-top:10px;
    }
    .btntrash{
        font-size:5px;
        margin:10px;
    }

   #services{
    display:none;
   }

    footer {
        flex-direction: row; 
        justify-content: space-between;
        flex-direction: column; 
        align-items: flex-start; 
    }

    footer ul {
        margin-bottom: 0; 
        font-size: 14PX;
        padding: 14px 1px;
    }
    footer ul h1 {
            font-size: 20px;
        }

    footer ul h1 {
        margin-bottom: 0; 
    }
    .logodiv{
    height:80px; 
    width: 40px;   
}
#prix {
        margin: 15px;
        padding: 15px;
    }

    .dropdown {
        margin-right: 0;
    }

    .dropdown a {
        
    text-decoration: none;
    padding: 5px 13px;
    background-color: red;
    color: #fff;
    border-radius: 8px;
    display: inline-block;
    transition: background-color 0.3s ease;
    font-size: 0.9em;
}
    .dropdown-content {
    display: none;
    position: absolute;
    background-color: #fff;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    z-index: 1;
    border-radius: 8px;
    width: 100px;
    text-align: center;
    right: 0; 
}


}


#prix {
    font-family: 'poppins', sans-serif;
    margin: 29px;
    background-color: #FFC14E;
    border: 1px solid #eaeaea;
    border-radius: 37px;
    padding: 26px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    flex-direction: column;
    align-items: center;
}


#prix strong {
    color: #333;
    font-size: 1.8em;
    margin-top: 20px;
}

.dropdown {
    margin-right:71%;
    
    
}

.dropdown a {
    text-decoration: none;
    padding: 15px 30px;
    background-color: red;
    color: #fff;
    border-radius: 8px;
    display: inline-block;
    transition: background-color 0.3s ease;
    font-size: 1.2em;
}

.dropdown a:hover {
    background-color: #fff;
    color:red;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #fff;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    z-index: 1;
    border-radius: 8px;
    width: 160px;
    text-align: center;
    right: 0; 
}
.dropdown-content .oui {
    background:white;
    color: #0CC000;
    padding: 15px;
    transition: color 0.3s ease;
}
.dropdown-content .non {
    background:white;
    color: red;
    padding: 15px;
    transition: color 0.3s ease;
}
.dropdown-content a:hover {
    color: #555;
}

.dropdown:hover .dropdown-content {
    display: block;
}


    </style>
</head>
<body>

<header>
<div class="logodiv">
      <a href="clientpage.php"><img src="uploads/logo.png" style="width: 100px;" alt=""></a>
</div>
    <?php
    $totalPrice = 0;

    if ($wishlistResult->num_rows > 0) {
        while ($wishlistItem = $wishlistResult->fetch_assoc()) {
            $totalPrice += $wishlistItem['price'] * $wishlistItem['quantity'];
        }
        $_SESSION['totalPrice'] = $totalPrice;
    }
    ?>


</header>

<button id="mobile-menu-button"> <i class="fa fa-bars"></i></button>
<nav id="navbar">
<a href="productpage.php">Continuez vos achats</a>
<a href="#contact">Contactez Nous</a>
<a href="php/logout.php">Log Out</a>

</nav>


<div id="prix">
<p>Total (TVA incluse): <strong><?= $totalPrice ?>.00 DH</strong></p>
        <div class="dropdown">
            <a href="#">Commander Votre Panier</a>
            <div class="dropdown-content">
                <a href="place_order.php" class="oui">Je Confirme</a>
                <a href="" class="non">Pas encore</a>
            </div>
        </div>

</div>

<div id="wishlist">
    <h2>Mon Panier</h2>

    <?php if ($wishlistResult->num_rows > 0): ?>
        <div class="wishlist-items">
    <?php
    
    $wishlistResult->data_seek(0);

    while ($wishlistItem = $wishlistResult->fetch_assoc()): ?>
        <div class="wishlist-item">
            <table>
                <tr>
                    <td><img src="<?= $wishlistItem['product_image'] ?>" alt="<?= $wishlistItem['product_name'] ?>" class="img-fluid"></td>
                    <td>
                        <h3><?= $wishlistItem['product_name'] ?></h3>
                        <p><?= $wishlistItem['product_desc'] ?></p>
                        <p id="price<?= $wishlistItem['wish_id'] ?>">Price: <?= $wishlistItem['price'] * $wishlistItem['quantity'] ?> DH</p>
                    </td>
                </tr>
            </table>
            <form method="post" action="wishlist.php">
                <label for="quantity<?= $wishlistItem['wish_id'] ?>">Quantity:</label>
                <input type="number" name="quantity" value="<?= $wishlistItem['quantity'] ?>" min="1"
                       id="quantity<?= $wishlistItem['wish_id'] ?>" class="quantity-selector">
                <input type="hidden" name="wish_id" value="<?= $wishlistItem['wish_id'] ?>">
                <button type="submit" name="update_quantity" class="updatebtn">Mettre à jour la quantité</button>
            </form>

            <form method="post" action="wishlist.php">
                <input type="hidden" name="wish_id" value="<?= $wishlistItem['wish_id'] ?>">
                <button type="submit" name="remove" class="btntrash"><i class="fa fa-trash"></i></button>
            </form>
        </div>
    <?php endwhile; ?>
</div>
    <?php else: ?>
        <p class="msgpanier">Votre panier est vide .</p>
    <?php endif; ?>
</div>



<a class="fixedButton" href="productpage.php">
         <div class="roundedFixedBtn"><p>continuer vos achat</p></div>
</a>

<div id="services">
    <ul>
        <li><i class="fa fa-truck"></i> Livraison et instalation</li>
        <li><i class="fa fa-award"></i> Garantie produit</li>
        <li><i class="fa fa-shopping-bag"></i> click et collect</li>
        <li><i class="fa fa-wrench"></i> service apres vente</li>
    </ul>    

</div>


<footer>
     <ul>
        <li><a href="clientpage.php">Qui nous</a></li>
        <li><a href="productpage.php">Nos produit</a></li>
        <li><a href="clientpage.php">Nos service</a></li>
        <li><a href="">Contactez nous</a></li>
     </ul>
      <ul>
        <h1>Contacts :</h1>
        <li>numero telephone : 0678789054 </li>
        <li>email : lwemequipments@gmail.com</li>
     </ul>
     <ul>
        <h1>Localisation :</h1>
        <li><a href="https://www.google.com/maps/place/31%C2%B035'35.3%22N+8%C2%B003'22.0%22W/@31.5931429,-8.0586916,17z/data=!3m1!4b1!4m4!3m3!8m2!3d31.5931429!4d-8.0561167?hl=fr&entry=ttu">voir localisation dans google maps</a></li>
     </ul>
     <ul>
        <h1>Suivez Nous :</h1>
         <li><a href=""><i class="fab fa-facebook"></i></a></li>
         <li><a href=""><i class="fab fa-instagram"></i></a></li>
     </ul>
     </footer>
     <div class="cop">
     <p>&copy; 2023 - Lwemequipments | Tous les droits sont réservés.</p>
        
     </div>


     
     <script>
        
        document.addEventListener('DOMContentLoaded', function () {
            var mobileMenuButton = document.getElementById('mobile-menu-button');
            var navbar = document.getElementById('navbar');

            mobileMenuButton.addEventListener('click', function () {
                navbar.classList.toggle('show');
            });
        });
    
     </script>


</body>
</html>
