<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validasi sederhana
    if (empty($email) || empty($password)) {
        echo "Email dan password harus diisi!";
        exit;
    }

    // Menggunakan prepared statement untuk keamanan
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah user ditemukan
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Cek password (di sini tanpa hashing, sesuaikan jika diperlukan hashing)
        if ($password === $user['password']) {
            // Menyimpan data ke session
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; // Simpan role di session

            echo "Login berhasil";

            // Redirect berdasarkan role
            if ($user['role'] === 'admin') {
                header("Location: admin/manage_user.php"); // Halaman untuk admin
            } else {
                header("Location: index.php"); // Halaman untuk user biasa
            }
            exit;
        } else {
            echo "Password salah!";
        }
    } else {
        echo "Email tidak ditemukan!";
    }

    // Menutup statement dan koneksi
    $stmt->close();
    $conn->close();
}
?>
