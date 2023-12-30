<?php
include("../php/config.php");

if (isset($_POST["record"])) {
    $id = $_POST["record"];

    $sql = "SELECT active FROM users WHERE id='$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $newStatus = $row["active"] == 0 ? 0 : 1;

        $update = mysqli_query($conn, "UPDATE users SET active='$newStatus' WHERE id='$id'");
        if ($update) {
            echo "success";
        } else {
            echo "error";
        }
    } else {
        echo "error";
    }
} else {
    echo "error";
}
?>
