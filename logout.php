<?php
session_start();
session_unset();  // Menghapus semua session
session_destroy();  // Menghancurkan session

// Redirect ke halaman login atau utama
header("Location: index.php");
exit;
?>
