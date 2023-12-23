<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="uploads/logo.png">
    <link rel="stylesheet" href="style/style.css">
    <title>Register</title>
    <style>
.lg{
            margin-top: 7px;
            display:flex;
            align-items:center;
            justify-content:center;

        }
    </style>
</head>
<body>
<div class="lg">

<img src="uploads/logo.png" style="width: 200px;" alt="">
</div>
      <div class="container"   style=" min-height: 72vh">
        <div class="box form-box">

        <?php 
         
         include("php/config.php");
         class User {
            private $db;
        
            public function __construct(Database $db) {
                $this->db = $db;
            }
        
            public function registerUser($username, $email, $age, $tele, $password) {
                if (!$this->isValidEmail($email)) {
                    return "Votre email doit être au format (name)@gmail.com!";
                }
        
                $verifyQuery = $this->db->executeQuery("SELECT Email FROM users WHERE Email='$email'");
        
                if (mysqli_num_rows($verifyQuery) != 0) {
                    return "Email déjà utilisé!";
                }
        
                $this->db->executeQuery("INSERT INTO users(Username, Email, Age, tele, Password) VALUES('$username', '$email', '$age', '$tele', '$password')");
        
                return "Inscription réussie!";
            }
        
            private function isValidEmail($email) {
                return preg_match('/^[a-zA-Z0-9._%+-]+@gmail\.com$/', $email);
            }
        }
        
        $db = new Database($server, $user, $password, $db);
        $user = new User($db);
        
        if (isset($_POST['submit'])) {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $age = $_POST['age'];
            $tele = $_POST['tele'];
            $password = $_POST['password'];
        
            $result = $user->registerUser($username, $email, $age, $tele, $password);
        
            echo "<div class='message'><p>$result</p></div> <br>";
            echo "<a href='login.php'><button class='btn'>Sign In</button>";
        } else {
         
        ?>

            <header>Sign Up </header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username" class="label">Nom et prenom</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="email" class="label">Email</label>
                    <input type="mail" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="age" class="label">Age</label>
                    <input type="number" name="age" id="age" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="tele" class="label">Numero Telephone</label>
                    <input type="tele" name="tele" id="tele" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password" class="label">mot de passe</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>


                <div class="field">
                    
                    <input type="submit" class="btn" name="submit" value="Registrer" required>
                </div>
                <div class="links">
                    Deja a membre? <a href="login.php">Sign In</a>
                </div>
            </form>
        </div>
        <?php } ?>
      </div>
</body>
</html>