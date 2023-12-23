<?php 
   session_start();

   include("php/config.php");
   if(!isset($_SESSION['valid'])){
    header("Location: clientpage.php");
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="uploads/logo.png">
    <link rel="stylesheet" href="style/style.css">
    <title>Changer Profile</title>
</head>
<style>
    body{
        background-color:rgb(217, 217, 217);
    }
    .btnre {
    height: 30px;
    margin-left: ;
    background: rgb(69, 230, 255);
    border: 0;
    border-radius: 5px;
    color: #ffffff;
    font-size: 15px;
    cursor: pointer;
    transition: all .3s;
    width: 100%;
    padding: 0px 10px;

}
.btnre:hover {
    background: white;
    color: black;
    transition: all .3s;
}

</style>
<body>

    <div class="container">
        <div class="box form-box">
            <?php 
               class Userupdate {
                private $db;
            
                public function __construct(Database $db) {
                    $this->db = $db;
                }
            
                public function updateProfile($id, $username, $email, $age, $tele, $password) {
                    $edit_query = mysqli_query($this->db->getConnection(), "UPDATE users SET Username='$username', Email='$email', Age='$age', Tele='$tele', Password='$password' WHERE Id=$id") or die("Error occurred");
                    return $edit_query;
                }
            
                public function getUserInfo($id) {
                    $query = mysqli_query($this->db->getConnection(), "SELECT * FROM users WHERE Id=$id");
                    $result = mysqli_fetch_assoc($query);
                    return $result;
                }
            }
            $db = new Database($server, $user, $password, $db);
            
            $Userupdate = new Userupdate($db);
            
            if (isset($_POST['submit'])) {
                $id = $_SESSION['id'];
                $username = $_POST['username'];
                $email = $_POST['email'];
                $age = $_POST['age'];
                $tele = $_POST['tele'];
                $password = $_POST['password'];
            
                $editResult = $Userupdate->updateProfile($id, $username, $email, $age, $tele, $password);
            
                if ($editResult) {
                    echo "<div class='message'><p>Profile changer :)</p></div> <br>";
                    echo "<a href='clientpage.php'><button class='btn'>Revenir</button>";
                }
            } else {
                $id = $_SESSION['id'];
                $userInfo = $Userupdate->getUserInfo($id);
            
                $res_Uname = $userInfo['Username'];
                $res_Email = $userInfo['Email'];
                $res_Age = $userInfo['Age'];
                $res_Tele = $userInfo['tele'];
                $res_Password = $userInfo['Password'];
            

            ?>
            <header>Change Profile</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Nom et Prenom</label>
                    <input type="text" name="username" id="username" value="<?php echo $res_Uname; ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" value="<?php echo $res_Email; ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" value="<?php echo $res_Age; ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="tele">Numero telephone</label>
                    <input type="number" name="tele" id="tele" value="<?php echo $res_Tele; ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">mot de passe</label>
                    <input type="password" name="password" id="password" value="<?php echo $res_Password; ?>" autocomplete="off" required>
                </div>
                
                <div class="field">
                    
                    <input type="submit" class="btn" name="submit" value="Changer" required>
                </div>
                
            </form><a href="clientpage.php"> <button class="btnre">revenir</button> </a>
        </div>
        <?php } ?>
      </div>
</body>
</html>