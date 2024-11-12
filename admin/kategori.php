<?php
session_start();
include '../koneksi.php'; // Koneksi ke database

// Cek apakah user sudah login dan apakah dia admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php"); // Redirect ke halaman login jika tidak berhak
    exit();
}

// Mengambil data kategori dari database
$sql = "SELECT * FROM kategori";
$queryKategori = $conn->query($sql); // Jalankan query dan simpan hasilnya di $queryKategori

// Cek jika query berhasil dijalankan
if ($queryKategori) {
    $jumlahKategori = mysqli_num_rows($queryKategori);
} else {
    $jumlahKategori = 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMzC/cWtp3ekph4YI1p6lyjUWFZnN05e9li0st" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Menghubungkan file CSS -->
    <title>Admin Dashboard - Manage Produk</title>
</head>
<body>
<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
        <div class="sidebar-heading text-center">
            <img src="../alkes/care.png" alt="Logo" class="logo-sidebar"> <!-- Ganti dengan logo Anda -->
        </div>
        <div class="list-group list-group-flush">
            <a href="#" class="list-group-item list-group-item-action bg-light">Dashboard</a>
            <a href="manage_user.php" class="list-group-item list-group-item-action bg-light">Manage Users</a>
            <a href="#" class="list-group-item list-group-item-action bg-light">Manage Kategori</a>
        </div>
    </div>

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="logo_profile.png" class="profile-logo" alt="Logo" width="30" height="30">
                        <img src="profile.jpg" class="rounded-circle" alt="Profile" width="40" height="40">
                        <?php echo $_SESSION['username']; ?> <!-- Menampilkan username yang sedang login -->
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
                        <a class="dropdown-item" href="#">Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php">Log Out</a>
                    </div>
                </li>
            </ul>
        </nav>

        <div class="my-5 col-12 col-md-6">
            <h3>Tambah Kategori</h3>

            <form action="" method="post">
                <div>
                    <label for="kategori">Kategori</label>
                    <input type="text" id="kategori" name="kategori" placeholder="input nama kategori" class="form-control">
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary" type="submit" name="simpan_kategori">Simpan</button>
                </div>
            </form>

            <?php
                if(isset($_POST['simpan_kategori'])){
                    $kategori = htmlspecialchars($_POST['kategori']); // Tambahkan titik koma di akhir

                    $queryExist = mysqli_query($conn, "SELECT nama FROM kategori WHERE nama='$kategori'");
                    $jumlahDataKategoriBaru = mysqli_num_rows($queryExist);

                    if($jumlahDataKategoriBaru > 0){
                        ?>
                        <div class="alert alert-primary mt-3" role="alert">
                           Kategori Sudah Ada!
                        </div>
                        <?php
                    }
                    else{
                        $querySimpan = mysqli_query($conn, "INSERT INTO kategori (nama) VALUES ('$kategori')");

                        if($querySimpan){
                            ?>
                            <div class="alert alert-success mt-3" role="alert">
                                Kategori Berhasil Tersimpan
                            </div>

                            <meta http-equiv="refresh" content="2; url=kategori.php" >
                            <?php

                        }
                        else{
                            echo mysqli_error($conn);
                        }
                    }
                }
            ?>
        </div>

        <div class="container-fluid">
            <h2>Manage Users</h2>
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $number = 1;
                    while($data = mysqli_fetch_array($queryKategori)){
                    ?>
                    <tr>
                        <td><?php echo $number; ?></td>
                        <td><?php echo $data['nama']; ?></td>
                        <td>
                            <a href="kategori_detail.php?p=<?php echo $data['id_kategori'];?>" class="btn btn-info"><i class="fa-solid fa-magnifying-glass"></i></a>
                        </td>
                    </tr>
                    <?php
                    $number++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
