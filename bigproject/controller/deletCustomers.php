<?php

    include("../php/config.php");
    
    $id=$_POST['record'];
    $query="DELETE FROM users where Id=$id";

    $data=mysqli_query($conn,$query);

    if($data){
        echo"customer Deleted";
    }
    else{
        echo"Not able to delete";
    }
    
?>