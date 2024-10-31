<?php
$servername = "localhost";
$username = "root";  // sesuaikan dengan user database Anda
$password = "";  // sesuaikan dengan password database Anda
$dbname = "caremart1";  // sesuaikan dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
