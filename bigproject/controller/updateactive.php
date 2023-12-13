<?php
include("../php/config.php");

$id = $_POST["record"];
$sql = "SELECT active FROM users WHERE id='$id'";
$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    if ($row["active"] == 1) {
        $update = mysqli_query($conn, "UPDATE users SET active=0 WHERE id='$id'");
    } else {
        $update = mysqli_query($conn, "UPDATE users SET active=1 WHERE id='$id'");
    }
}
?>>