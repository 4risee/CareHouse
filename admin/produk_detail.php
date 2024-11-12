<?php
    session_start();
    include '../koneksi.php';

    $id = $_GET['p'];

    $query = mysqli_query($conn, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id_kategori WHERE a.id='$id'");
    $data = mysqli_fetch_array($query);

    $queryKategori = mysqli_query($conn, "SELECT * FROM kategori WHERE id_kategori!='$data[kategori_id]'");

    function generateRandomString($length = 10){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Menghubungkan file CSS -->
    <title>Document</title>
</head>
<style>
    form div{
        margin-bottom: 10px
    }

</style>
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
            <a href="kategori.php" class="list-group-item list-group-item-action bg-light">Manage Kategori</a>
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
        <div class="container mt-3">
            <h2>Detail Produk</h2>

            <div class="col-12 col-md-6 mb-5"></div>
                <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" value="<?php echo $data ['nama']; ?>" class="form-control" autocomplete=off required>
                </div>
                <div>
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control" required>
                        <option value="<?php echo $data['kategori_id']; ?>"><?php echo $data['nama_kategori']; ?></option>
                <?php
                        while($dataKategori=mysqli_fetch_array($queryKategori)){
                ?>
                        <option value="<?php echo $dataKategori['id_kategori']?>"><?php echo $dataKategori['nama']; ?></option>
                <?php  
                        }
                ?>
                    </select>
                </div>
                <div>
                    <label for="harga">Harga</label>
                    <input type="number" class="form-control" value="<?php echo $data['harga']; ?>" name="harga" required>
                </div>
                <div>
                    <label for="currentFoto">Foro Produk Sekarang</label>
                    <img src="../image/<?php echo $data['foto']; ?>" alt="" width="300px">
                </div>
                <div>
                    <label for="foto">foto</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>
                <div>
                    <label for="detail">Detail</label>
                    <textarea name="detail" id="detail" cols="30" rows="10" class="form-control">
                        <?php echo $data['detail']; ?>
                    </textarea>
                </div>
                <div>
                    <label for="ketersediaan_stok">Ketersediaan Stok</label>
                    <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control">
                        <option value="<?php echo $data['ketersediaan_stok']; ?>"><?php echo $data['ketersediaan_stok']; ?></option>
                        <?php
                            if($data['ketersediaan_stok']=='tersedia'){
                ?>
                            <option value="habis">Habis</option>
                <?php
                            }
                            else{
                ?>
                            <option value="tersedia">Tersedia</option>
                <?php
                            }
                ?>
                        
                    </select>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                    <button type="submit" class="btn btn-danger" name="hapus">Hapus</button>
                </div>
                </form>

                <?php
                if(isset($_POST['simpan'])){
                    $nama = htmlspecialchars($_POST['nama']);
                    $kategori = htmlspecialchars($_POST['kategori']);
                    $harga = htmlspecialchars($_POST['harga']);
                    $detail = htmlspecialchars($_POST['detail']);
                    $ketersediaan_stok = htmlspecialchars($_POST['ketersediaan_stok']);

                    $target_dir = "../image/";
                    $nama_file = basename($_FILES["foto"]["name"]);
                    $target_file = $target_dir . $nama_file;
                    $imagerFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    $image_size = $_FILES["foto"]["size"];
                    $random_name = generateRandomString(20);
                    $new_name = $random_name . "." . $imagerFileType;

                    if($nama=='' || $kategori=='' || $harga==''){
                ?>
                        <div class="alert alert-primary mt-3" role="alert">
                           Nama, Kategori dan Harga wajib diisi!
                        </div>
                <?php
                    }
                    else{
                        $queryUpdate = mysqli_query($conn, "UPDATE produk SET kategori_id='$kategori', nama='$nama', harga='$harga', detail='$detail', ketersediaan_stok='$ketersediaan_stok' WHERE id=$id");

                        if($nama_file!=''){
                            if($image_size > 500000000){
                ?>
                                <div class="alert alert-primary mt-3" role="alert">
                                     File tidak boleh dari 500kb!
                                </div>
                <?php
                            }
                            else{
                                if($imagerFileType != 'jpg' && $imagerFileType != 'png' && $imagerFileType != 'gif'){
                ?>
                                <div class="alert alert-primary mt-3" role="alert">
                                    File wajib bertipe jpg atau png atau gif!
                                </div>
                <?php
                                }
                                else{
                                    move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);

                                    $queryUpdate = mysqli_query($conn, "UPDATE produk SET foto='$new_name' WHERE id=$id");

                                    if($queryUpdate){
                ?>
                                    <div class="alert alert-success mt-3" role="alert">
                                        Produk Berhasil Diupdate
                                    </div>

                                    <meta http-equiv="refresh" content="2; url=produk.php" >
                <?php
                                    }
                                    else{mysqli_error($conn);
                                    }
                                }
                            }
                        }
                    }
                }
                if(isset($_POST['hapus'])){
                    $queryHapus = mysqli_query($conn, "DELETE FROM produk WHERE id='$id'");

                    if($queryHapus){
                ?>
                        <div class="alert alert-success mt-3" role="alert">
                            Produk Berhasil Dihapus
                        </div>

                        <meta http-equiv="refresh" content="2; url=produk.php" >
                <?php
                    }
                }
                ?>
        </div>
    </div>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>