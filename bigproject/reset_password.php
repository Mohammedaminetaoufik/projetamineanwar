<?php
session_start();



$token = isset($_GET['token']) ? $_GET['token'] : null;

if (!$token) {
   
    echo "Invalid or missing token. Please try the password reset process again.";
} else {
    
    include("php/config.php");

   
    function executePreparedStatement($query, $params) {
        $conn = new mysqli("localhost", "root", "", "databaseLWEM");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare($query);
        if (!$stmt) {
            die("Error in preparing statement: " . $conn->error);
        }

        
        if ($params) {
            $stmt->bind_param(str_repeat("s", count($params)), ...$params);
        }

       
        $stmt->execute();

       
        return $stmt->get_result();
    }

    
    $validateTokenQuery = executePreparedStatement("SELECT Email FROM users WHERE reset_token = ?", [$token]);

    if ($validateTokenQuery->num_rows == 0) {
        
        echo "Invalid or expired token. Please try the password reset process again.";
    } else {
        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | LWEM</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Reset Password</header>
            <form action="reset_password_process.php" method="post">
                <input type="hidden" name="token" value="<?php echo $token; ?>">
                
                <div class="field input">
                    <label for="new_password" class="label">New Password</label>
                    <input type="password" name="new_password" id="new_password" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="confirm_password" class="label">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Reset Password" required>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

<?php
    }
}
?>
