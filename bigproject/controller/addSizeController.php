<?php
    include("../php/config.php");
    
    if(isset($_POST['upload']))
    {
       
        $size = $_POST['size'];
       
         $insert = mysqli_query($conn,"INSERT INTO sizes
         (size_name)   VALUES ('$size')");
 
         if(!$insert)
         {
             echo mysqli_error($conn);
             header("Location: ../adminepage.php?size=error");
         }
         else
         {
             echo "Records added successfully.";
             header("Location: ../adminepage.php?size=success");
         }
     
    }
        
?>