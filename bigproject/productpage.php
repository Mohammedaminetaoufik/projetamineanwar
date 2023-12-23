<?php

session_start();
include("php/config.php");
if(!isset($_SESSION['valid'])){
    header("Location: login.php");
   }

   $userId = $_SESSION['id'];
$categorySql = "SELECT * FROM category";
$categoryResult = $conn->query($categorySql);

$categoryData = [];

if ($categoryResult->num_rows > 0) {
    while ($categoryRow = $categoryResult->fetch_assoc()) {
        $categoryId = $categoryRow['category_id'];

        $productSql = "SELECT * FROM product WHERE category_id = $categoryId";
        $productResult = $conn->query($productSql);

        $productData[$categoryId]['category_name'] = $categoryRow['category_name'];
        $productData[$categoryId]['products'] = [];

        if ($productResult->num_rows > 0) {
            while ($productRow = $productResult->fetch_assoc()) {
                $productData[$categoryId]['products'][] = $productRow;
            }
        }
    }
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Produit</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="uploads/logo.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

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
    top:10PX;
    margin-right: 20px;
    font-size:60px;
    color:rgb(255, 157, 0);
    position:relative;
}

header a span {
    position:absolute;
    right:-12px;
    top: 27px;
    font-size: 15px;
    background: #f6b60e;
    min-width: 15px;
    min-height: 15px;
    padding: 2px;
    line-height: 1.3;
    color: #fff;
    font-weight: 400;
    display: inline-block;
    text-align: center;
    max-width: 20px;
    max-height: 20px;
    display: block;
    width: 23px;
    height: 23px;
    border-radius: 100%;
    position: absolute;
    
    
}

header p {
    margin-right: 20px;
    font-weight: 600;
    font-family: 'Poppins', sans-serif;
    color: black;
    margin-top: 2px;
    font-size: 30px;
   
}
        header b{
            color: rgb(0, 204, 255);
            text-transform: uppercase;
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

    #produit {
        text-align:center;
        font-family: 'Poppins', sans-serif;
       
        box-sizing: border-box;
        
    }
    #produit h2 {
        
    font-size: 36px;
    font-weight: bold;
    font-family: 'Poppins', sans-serif;
    color: rgb(0, 174, 255);
    text-transform: uppercase;
    margin-top: 20px;
    margin-bottom: 40px;
}

        
        #produit h1 {
        margin-left:10px;
        text-align:left;
       }

       #produit a{
        background-color: #ff9500;
    color: #ffffff;
    border: none;
    text-align: center;
    font-family: 'Poppins',sans-serif;
    cursor:pointer;
    box-shadow: #222;
    transition: 0.2s ease-in-out;
       }

       #produit a:hover {
        background-color: #ffffff;
    color: #ff9500;
       }

    .card {
        width: 350px;
        margin-bottom: 20px;
        border: 1px solid #ced4da;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.2s;
        box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;    }

    .card:hover {
        transform: scale(1.05);
    }

    .card img {
        height: 200px;
        object-fit: cover;
    }

    .card-body {
        padding: 20px;
    }

    .card-title {
        font-size: 1rem;
        margin-bottom: 8px;
    }

    .card-text {
        font-size: 0.9rem;
        color: black;
        margin-bottom: 15px;
    }

    .card-text-2 {
        color: rgb(0, 174, 255);
        margin-bottom: 15px;
        font-size:20px;

    }

    

    .btn-primary {
        background-color: #ff9d00;
        border: none;
        
    }

    .btn-primary:hover {
        background-color: #1888ff;
      
        
    }
        .card {
            margin: 30px;
        }
        .category {
    position: relative;
    margin:20px;
   
}

.swiper-button-next,
.swiper-button-prev {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 40px;
    height: 40px;
    color: #ff9d00;

}

.swiper-button-next {
    right: 0;
}

.swiper-button-prev {
    left: 0;
}

.swiper-button-next:hover,
.swiper-button-prev:hover {
     color:#FFBD8C;
}

        .swiper-wrapper {
            display: flex;
        }

        .swiper-slide {
            width: 100%;
            flex-shrink: 0;
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
       #produit .ml14 {
   font-family: 'Poppins', sans-serif;
   color: rgb(0, 174, 255); 
   text-align:center;         
  font-weight: 200;
  font-size: 3.2em;
}

.ml14 .text-wrapper {
  position: relative;
  display: inline-block;
  padding-top: 0.1em;
  padding-right: 0.05em;
  padding-bottom: 0.15em;
}

.ml14 .line {
  opacity: 0;
  position: absolute;
  left: 0;
  height: 2px;
  width: 100%;
  background-color: #fff;
  transform-origin: 100% 100%;
  bottom: 0;
}

.ml14 .letter {
  display: inline-block;
  line-height: 1em;
}

    @media screen and (max-width: 600px) {
        header h1 {
        font-size: 20px;
        margin-left: 10px; 
    }

    header h1 span {
        font-size: 15px;
    }

    header p {
        font-size: 14px;
        margin-right: 10px; 
    }
            .swiper-slide {
                width: auto !important;
                margin-right: 10px;
            }

            .swiper-container {
                width: 100%;
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
     .card {
        width: 230px;
    }

    .card img {
        height: 100px; 
    }

    .card-title {
        font-size: 1rem;
    }

    .card-text {
        margin-bottom: 3px;
        font-size:0.8rem;
    }

    .card-text-2 {
        font-size: 15px; 
    }
    .btn-primary {
        background-color: #ff9d00;
        border: none;
        font-size:10px;
        
    }
    #produit .ml14 {
   font-family: 'Poppins', sans-serif;
   color: rgb(0, 174, 255); 
   text-align:center;         
  font-weight: 200;
  font-size: 1.5em;
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
    height:50px; 
    width: 50px;   
}
}
.logodiv{
    margin-left:27px;
    display: flex;
    flex-wrap:nowrap;
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
#up {
  display: inline-block;
  background-color: rgb(255, 157, 0);
  color:white;
  width: 50px;
  height: 50px;
  font-size:30px;
  text-align: center;
  border-radius: 40px;
  position: fixed;
  bottom: 30px;
  right: 30px;
  visibility: hidden;
  transition: background-color .3s, 
    opacity .5s, visibility .5s;
  opacity: 0;
  z-index: 100;
}

#up:hover {
  cursor: pointer;
  background-color: #00e1ff;
}
#up:active {
  background-color: #ffffff;
}
#up.show {
  opacity: 1;
  visibility: visible;
}

    </style>
</head>
<body>
<a id="up"><i class="fa fa-arrow-up"></i></a>

<header>
        <div class="logodiv">
             <a href="clientpage.php"><img src="uploads/logo.png" style="width: 100px;" alt=""></a>
        </div>
        <p>
    <a href="wishlist.php" >
        <i class="fa fa-shopping-bag"></i>
        <span >
        <?php
        $sql = "SELECT * from wishlist WHERE user_id = $userId";
        $result = $conn->query($sql);
        $count = 0;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $count = $count + 1;
            }
        }
        echo $count;
        ?>
    </span>
    </a><br>
    Votre panier
      </p>
    
</header>



    <button id="mobile-menu-button"> <i class="fa fa-bars"></i></button>
    <nav id="navbar">
        <a href="#produit"><i class="fa fa-bars"></i> Nos Category</a>
        <a href="#contact">Contactez Nous</a>
        <a href="clientpage.php">Qui Nous?</a>
    </nav>


<br>
<div id="produit">
<h1 class="ml14">
  <span class="text-wrapper">
    <span class="letters">Decouver Nos Dernier Produits!</span>
    <span class="line"></span>
  </span>
</h1><br><br>
    <?php foreach ($productData as $categoryId => $category): ?>
        <?php if (!empty($category['products'])): ?>
            <div class="category">
                <h1><i class="fa fa-check"></i> <?= $category['category_name'] ?></h1>
                
                <div class="swiper-about">
                    <div class="swiper-wrapper">
                        <?php foreach ($category['products'] as $product): ?>
                            <div class="swiper-slide">
                                <div class="card">
                                    <img src="<?= $product['product_image'] ?>" class="card-img-top"
                                         alt="<?= $product['product_name'] ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><strong><?= $product['product_name'] ?></strong></h5>
                                        <p class="card-text"><?= $product['product_desc'] ?></p>
                                        <p class="card-text-2"><strong><?= $product['price'] ?> DH</strong></p>
                                        <p class="card-text">stock :<strong><?= $product['quantity'] ?> unite</strong></p>
                                        <a href="wishlist.php?action=add&product_id=<?= $product['product_id'] ?>&product_name=<?= urlencode($product['product_name']) ?>" class="btn btn-secondary">ajouter au panier</a>
                                    </div>
                                  
                                </div>
                            </div>
                            
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

    <?php if (empty($productData)) : ?>
        <p>No products found.</p>
    <?php endif; ?>
</div>




<footer>
     <ul>
        <li><a href="clientpage.php">Qui nous</a></li>
        <li><a href="">Nos service</a></li>
        <li><a href="">Livraison</a></li>
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



<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


<script>
    $(document).ready(function () {
        var swiper = new Swiper('.swiper-about', {
            slidesPerView: 1,
            spaceBetween: 10,
            loop: true,
            grabCursor: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                600: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 40,
                },
            }
        });
    });
</script>
<script>
        
        document.addEventListener('DOMContentLoaded', function () {
            var mobileMenuButton = document.getElementById('mobile-menu-button');
            var navbar = document.getElementById('navbar');

            mobileMenuButton.addEventListener('click', function () {
                navbar.classList.toggle('show');
            });
        });
    
     </script>
<script>
var textWrapper = document.querySelector('.ml14 .letters');
textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

anime.timeline({loop: true})
  .add({
    targets: '.ml14 .line',
    scaleX: [0,1],
    opacity: [0.5,1],
    easing: "easeInOutExpo",
    duration: 900
  }).add({
    targets: '.ml14 .letter',
    opacity: [0,1],
    translateX: [40,0],
    translateZ: 0,
    scaleX: [0.3, 1],
    easing: "easeOutExpo",
    duration: 800,
    offset: '-=600',
    delay: (el, i) => 150 + 25 * i
  }).add({
    targets: '.ml14',
    opacity: 0,
    duration: 1000,
    easing: "easeOutExpo",
    delay: 1000
  });
</script>
<script>
$(document).ready(function(){
  $("a").on('click', function(event) {
    if (this.hash !== "") {
      event.preventDefault();
      var hash = this.hash;
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 800, function(){
        window.location.hash = hash;
      });
    } 
  });
});
</script>
<script>
  var btn = $('#up');

$(window).scroll(function() {
  if ($(window).scrollTop() > 100) {
    btn.addClass('show');
  } else {
    btn.removeClass('show');
  }
});
btn.on('click', function(e) {
  e.preventDefault();
  $('html, body').animate({scrollTop:0}, '300');
});
</script>

</body>
</html>
