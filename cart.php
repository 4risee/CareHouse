<?php
session_start();
include 'koneksi.php';

// Cek apakah ada ID produk yang dikirim melalui URL
if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];
    $jumlah = isset($_GET['jumlah']) ? (int)$_GET['jumlah'] : 1;

    // Cek apakah keranjang belanja sudah ada di session
    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = [];
    }

    // Cek apakah produk sudah ada di keranjang
    if (isset($_SESSION['keranjang'][$id_produk])) {
        // Jika sudah ada, tambahkan jumlahnya
        $_SESSION['keranjang'][$id_produk] += $jumlah;
    } else {
        // Jika belum ada, tambahkan produk ke keranjang
        $_SESSION['keranjang'][$id_produk] = $jumlah;
    }

    echo "<script>alert('Produk telah ditambahkan ke keranjang');</script>";
    echo "<script>location='shop-grid.html';</script>";
}
?>
