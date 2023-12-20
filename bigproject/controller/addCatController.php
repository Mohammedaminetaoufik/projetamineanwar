<?php
    include("../php/config.php");
    

    class CategoryHandler {
        private $conn;
    
        public function __construct($conn) {
            $this->conn = $conn;
        }
    
        public function addCategory($catname) {
            $catname = mysqli_real_escape_string($this->conn, $catname);
    
            $insert = mysqli_query($this->conn, "INSERT INTO category (category_name) VALUES ('$catname')");
    
            if (!$insert) {
                echo mysqli_error($this->conn);
                return false;
            } else {
                return true;
            }
        }
    }
    
    
    
    
    $conn = new mysqli($server, $user, $password, $db);
    
   
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
  
    $categoryHandler = new CategoryHandler($conn);
    
    
    if (isset($_POST['upload'])) {
       
        $catname = $_POST['c_name'];
    
        
        if ($categoryHandler->addCategory($catname)) {
           
            header("Location: ../adminepage.php?category=success");
        } else {
            
            header("Location: ../adminepage.php?category=error");
        }
    }
    
    
    $conn->close();
    ?>
    
        
