<?php

class Database {
    private $conn;

    
    public function __construct($server, $user, $password, $db) {
        $this->conn = mysqli_connect($server, $user, $password, $db);

        
        if (!$this->conn) {
            die("Connection Failed: " . mysqli_connect_error());
        }
    }


    public function executeQuery($query) {
        return mysqli_query($this->conn, $query);
    }

    
    public function getConnection() {
        return $this->conn;
    }

    
    public function __destruct() {
        mysqli_close($this->conn);
    }
}


$server = "localhost";
$user = "root";
$password = "";
$db = "databaseLWEM";


$database = new Database($server, $user, $password, $db);


$conn = $database->getConnection();



?>



