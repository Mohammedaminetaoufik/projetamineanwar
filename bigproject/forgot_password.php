
<?php
session_start();
include("php/config.php");

$message = "";

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $checkEmailQuery = mysqli_prepare($conn, "SELECT * FROM users WHERE Email = ?");
    mysqli_stmt_bind_param($checkEmailQuery, "s", $email);
    mysqli_stmt_execute($checkEmailQuery);
    $result = mysqli_stmt_get_result($checkEmailQuery);

    if (mysqli_num_rows($result) != 0) {
        $token = bin2hex(random_bytes(32));

        $updateQuery = mysqli_prepare($conn, "UPDATE users SET reset_token = ? WHERE Email = ?");
        mysqli_stmt_bind_param($updateQuery, "ss", $token, $email);
        mysqli_stmt_execute($updateQuery);

        $resetLink = "http://yourdomain.com/reset_password.php?token=$token";
        $subject = "Demande de réinitialisation de mot de passe";
        $message = "Un lien de réinitialisation de mot de passe a été envoyé à votre adresse e-mail.";

        mail($email, $subject, $message);
    } else {
        $message = "Adresse e-mail introuvable. Veuillez vérifier l'adresse e-mail.";
    }

  
    mysqli_stmt_close($checkEmailQuery);
    mysqli_stmt_close($updateQuery);
}


mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié | LWEM</title>
    <style>
                 @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&family=Playfair+Display:wght@400;700&display=swap');

        body {
    font-family: 'Poppins', sans-serif;
    background: #fbc291;
    margin: 0;
    padding: 0;
}

.container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.box {
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 300px;
    padding: 20px;
    text-align: center;
}

.form-box {
    margin-top: 50px;
}

header {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
}

.field {
    margin-bottom: 15px;
}

.input {
    text-align: left;
}

.label {
    display: block;
    font-size: 14px;
    margin-bottom: 5px;
}

input {
    width: 100%;
    padding: 10px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
}

.btn {
    height: 30px;
    margin-left: ;
    background: rgb(69, 200, 300);
    border: 0;
    border-radius: 5px;
    color: #ffffff;
    font-size: 15px;
    cursor: pointer;
    transition: all .3s;
    width: 100%;
    padding: 0px 10px;
}

.btn:hover {
    background-color: white;
    color: rgb(69, 200, 300);;
}

.links {
    margin-top: 15px;
    font-size: 14px;
}

.links a {
    color: #007bff;
    text-decoration: none;
}

.links a:hover {
    text-decoration: underline;
}

    </style>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Mot de passe oublié</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="email" class="label">Adresse e-mail</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Réinitialiser le mot de passe" required>
                </div>

                <div class="message">
                    <?php echo $message; ?>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
