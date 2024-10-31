<?php
include("../koneksi.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM users WHERE id = $id";
    mysqli_query($conn, $query);
    header("Location: manage_user.php");
}
?>
