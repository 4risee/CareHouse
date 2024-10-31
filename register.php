<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validasi sederhana
    if (empty($username) || empty($email) || empty($password)) {
        echo "Semua field harus diisi!";
        exit;
    }

    // Menyimpan password tanpa hashing (tidak disarankan, tapi sesuai permintaan)
    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        // Redirect ke halaman login
        header("Location: nyoba.html");
        exit; // Pastikan menggunakan exit setelah header untuk menghentikan eksekusi
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
