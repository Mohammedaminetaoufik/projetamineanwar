 <?php  
   session_start();

   $inactive_timeout = 100000000; 
  if(isset($_SESSION['last_activity'])) {
    
    $inactive_time = time() - $_SESSION['last_activity'];

    if($inactive_time >= $inactive_timeout) {
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }
}
   include("php/config.php");
   if(!isset($_SESSION['valid'])){
    header("Location: login.php");
   }
 ?> 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LWEM equipements</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="icon" type="image/x-icon" href="uploads/logo.png">


    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&family=Playfair+Display:wght@400;700&display=swap');

        body {
            font-family: 'Arial', sans-serif;
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

header p {
    margin-right: 20px;
    font-weight: 600;
    font-family: 'Poppins', sans-serif;
    color: black;
    margin-top: 2px;
    font-size: larger;
    text-decoration: underline;
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

        #about {
    padding: 170px;
    margin-top: 3px;
    background-color: #ffffff;
     
}

#about h1 {
    position: relative;
    margin-top: 3px;
    font-size: 50px;
    text-transform: uppercase;
    color: #222;
    letter-spacing: 1px;
    font-family: "Playfair Display", serif;
    font-weight: 400;
    color: rgb(0, 0, 0);
}

#about h1 span {
    font-size: 150px;
    display: grid;
    grid-template-columns: 1.4fr max-content 1fr;
    grid-template-rows: 19px;
}

#about h1 span:after,
#about h1 span:before {
    content: " ";
    display: block;
    border-bottom: 1px solid #ff9500;
    border-top: 1px solid #ff9500;
    height: 5px;
    background-color: #fcd9a9;
}

#about p {
    position: relative;
    font-size: 23px;
    color: #222;
    line-height: 1.5;
    font-family: "Playfair Display", serif;
    margin-top: 20px;
    margin-bottom: 20px;
    margin-right: 480px;
    font-weight: 400;
}

#about p span {
    color: #ff9500;
    font-weight: 600;
    text-decoration: underline;
    font-size: larger;
}

#about img {
    width: 400px;
    position: absolute; 
    right: 50PX; 
    margin-top: 20px; 

}
#about a{
    background-color: #ff9500;
    color: #ffffff;
    border: none;
    padding: 18px 18px;
    text-align: center;
    font-size: 25PX;
    font-family: 'Poppins',sans-serif;
    cursor:pointer;
    text-decoration: overline;
    position: relative;
    top: 25px;
    box-shadow: #222;
    box-shadow: 0 5px 5px rgba(0, 0, 0, 0.1);
    transition: 0.2s ease-in-out;
    }
#about a:hover{
    background-color: #874f00;
}

#service {
    padding: 170px;
    background-color: #ffffff;
     
}

#service h1 {
    position: relative;
    font-size: 50px;
    text-transform: uppercase;
    color: #222;
    letter-spacing: 1px;
    font-family: "Playfair Display", serif;
    font-weight: 400;
    color: rgb(0, 0, 0);
}

#service h1 span {
    font-size: 150px;
    display: grid;
    grid-template-columns: 1.4fr max-content 1fr;
    grid-template-rows: 19px;
}

#service h1 span:after,
#service h1 span:before {
    content: " ";
    display: block;
    border-bottom: 1px solid #ff9500;
    border-top: 1px solid #ff9500;
    height: 5px;
    background-color: #fcd9a9;
}

#service p {
    font-size: 25px;
    color: #222;
    line-height: 1.5;
    font-family: "Playfair Display", serif;
    margin-bottom: 20px;
    font-weight: 600;
    
}
#service p i{
    color:rgb(255, 170, 0);
    font-size: 50px;
    margin-right: 20px;
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



@media only screen and (max-width: 600px) {
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

    #about {
        padding: 70px;
        flex-wrap: wrap;
        flex-direction: column;
        position: relative; 
    }

    #about h1 {
        font-size: 30px;
         
    }

    #about h1 span {
        font-size: 60px; 
    }

    #about p {
        font-size: 16px;
        margin-right: 20px; 
    }

    #about img {
        width: 130px;
        height: auto;
        position: absolute; 
        top: 20px; 
        left: 220px;
        
       
    }
    #about a{
    background-color: #ff9500;
    color: #ffffff;
    border: none;
    padding: 10px 10px;
    text-align: center;
    font-size: 15PX;
    font-family: 'Poppins',sans-serif;
    cursor:pointer;
    text-decoration: overline;
   margin-top: 15PX;
    box-shadow: #222;
    box-shadow: 0 5px 5px rgba(0, 0, 0, 0.1);
    transition: 0.2s ease-in-out;
    }
    #service {
    padding: 50px; 
  }

  #service h1 {
    font-size: 30px;
  }

  #service h1 span {
    font-size: 80px; 
  }

  #service h1 span:after,
  #service h1 span:before {
    height: 3px; 
  }

  #service p {
    font-size: 13px; 
    margin-bottom: 10px; 
  }

  #service p i {
    font-size: 30px; 
    margin-right: 10px; 
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
    max-height: 340px; 
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
          <?php 
            
            $id = $_SESSION['id'];
            $query = mysqli_query($conn,"SELECT*FROM users WHERE Id=$id");

            while($result = mysqli_fetch_assoc($query)){
                $res_Uname = $result['Username'];
                $res_Email = $result['Email'];
                $res_Age = $result['Age'];
                $res_id = $result['Id'];
            }
        ?>

    <header>
        <div class="logodiv">

        <a href="clientpage.php"><img src="uploads/logo.png" style="width: 100px;" alt=""></a>
        </div>
        <p><i class="fa fa-user"></i><br><b><?php echo  $res_Uname ?></b></p>
    </header>
     <button id="mobile-menu-button"> <i class="fa fa-bars"></i></button>

    <nav id="navbar">
        <a href="#about">Qui Nous</a>
        <a href="#service">Nos Services</a>
        <a href="productpage.php">Nos Produits</a>
        <a href="#contact">Contactez Nous</a>
        <a href="php/logout.php">Log Out</a>
        <a href="edit.php">Changer de Profile</a>
    </nav>

   <div id="about">
         <img src="https://img.freepik.com/vecteurs-premium/toute-longueur-happy-reparateur-boite-outilsprofessional-mechanic-guy-expert-service-worker-flat-vector-cartoon-character-illustration_77116-2303.jpg" alt="">

           <h1>Qui Nous? <br><br><span></span></h1>
           <p>Bienvenue chez <span>LWEM Equipements</span>,</p>
           <p> votre partenaire de confiance pour les solutions électroniques innovantes et les équipements de pointe.</p>
           <p> Depuis notre création, nous nous sommes engagés à offrir à nos clients une expérience exceptionnelle en matière de technologie et d'équipement de qualité.</p>
           <br><a href="productpage.php">Nos Produit</a>
   </div>


   <div id="service">
   <h1>Nos Services? <br><br><span></span></h1>
   <p><i class="fa fa-clock"></i>   HORAIRES DE 9H À 22H</p>
   <p><i class="fa fa-award"></i>   GARANTIES PRODUITS</p>
   <p><i class="fa fa-money-bill"></i>   RETOURS ET REMBOURSEMENT</p>
   <p><i class="fa fa-truck"></i>   LIVRAISON ET INSTALLATION</p>

   </div>
    
   <footer>
     <ul>
        <li><a href="#about">Qui nous</a></li>
        <li><a href="productpage.php">Nos produit</a></li>
        <li><a href="#service">Nos service</a></li>
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
 
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

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
$(document).ready(function(){
  $("a").on('click', function(event) {
    if (this.hash !== "") {
      event.preventDefault();
      var hash = this.hash;
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 1200, function(){
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
  $('html, body').animate({scrollTop:0}, '1000');
});
</script>

</body>
</html>
