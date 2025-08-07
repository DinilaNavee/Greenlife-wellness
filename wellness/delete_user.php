<?php
include("db.php");

if (isset($_GET['id'])) {
    $uid = $_GET['id'];

   
    $query = "DELETE FROM users WHERE Uid = $uid";
    mysqli_query($conn, $query);
}

header("Location: admin_users.php");
exit();
?>
