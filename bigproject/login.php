<?php 
   session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <link rel="icon" type="image/x-icon" href="uploads/logo.png">
    <title>Login</title>
    <style>
        .lg{
            margin-top: 50px;
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
    <div class="container" style="min-height: 64vh;">
        
        <div class="box form-box">
            <?php 
                include("php/config.php");
                
                if(isset($_POST['submit'])){
                    $email = mysqli_real_escape_string($conn,$_POST['email']);
                    $password = mysqli_real_escape_string($conn,$_POST['password']);

                    $result = mysqli_query($conn,"SELECT * FROM users WHERE Email='$email' AND Password='$password' ") or die("Select Error");
                    $row = mysqli_fetch_assoc($result);

                    if(is_array($row) && !empty($row)){
                        $_SESSION['valid'] = $row['Email'];
                        $_SESSION['username'] = $row['Username'];
                        $_SESSION['age'] = $row['Age'];
                        $_SESSION['tele'] = $row['Tele'];
                        $_SESSION['id'] = $row['Id'];

                        // for admin
                        if ($email === 'admin@gmail.com' && $password === 'admin') {
                            header("Location: adminepage.php");
                            exit(); 
                        } else {
                            header("Location: clientpage.php");
                        }
                    } else {
                        echo "<div class='message'>
                                <p>nom ou mot de passe incorrect</p>
                              </div> <br>";
                        echo "<a href='login.php'><button class='btn'>revenir</button>";
                    }
                } else {
            ?>
            <header>Login</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="email" class="label">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password" class="label">mot de passe</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Login" required>
                </div>

                <div class="links">
                    Vous etes pas un membre ? <a href="register.php">Sign Up Ici</a>
                </div>
            </form>
            <?php } ?>
        </div>
    </div>
</body>
</html>
