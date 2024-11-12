<?php
    session_start();
    include '../koneksi.php';

    $id = $_GET['p'];

    $query = mysqli_query($conn, "SELECT * FROM KATEGORI WHERE id_kategori='$id'");
    $data = mysqli_fetch_array($query);
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
            <h2>Detail Kategori</h2>
            <div>
                <form action="" method="post">
                    <div>
                        <label for="kategori">Kategori</label>
                        <input type="text" name="kategori" id="kategori" class="form-control" value="<?php echo $data['nama']; ?>">
                    </div>

                    <div class="mt-3 d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary" name="editBTN">Edit</button>
                        <button type="submit" class="btn btn-danger" name="deleteBTN">Delete</button>
                    </div>

                </form>
                <?php
                    if(isset($_POST['editBTN'])){
                        $kategori = htmlspecialchars($_POST['kategori']);

                        if($data['nama']==$kategori){
                            ?>
                            <meta http-equiv="refresh" content="0; url=kategori.php" />
                            <?php
                        }
                        else{
                            $query = mysqli_query($conn, "SELECT * FROM kategori WHERE nama='$kategori'");
                            $jumlahData = mysqli_num_rows($query);
                            
                            if($jumlahData > 0){
                                ?>
                                <div class="alert alert-primary mt-3" role="alert">
                                     Kategori Sudah Ada!
                                </div>
                                <?php
                            }
                            else{
                                $querySimpan = mysqli_query($conn, "UPDATE kategori SET nama='$kategori' WHERE id_kategori='$id'");
                                if($querySimpan){
                                    ?>
                                    <div class="alert alert-success mt-3" role="alert">
                                        Kategori Berhasil Terupdate
                                    </div>
        
                                    <meta http-equiv="refresh" content="2; url=kategori.php" >
                                    <?php
        
                                }
                                else{
                                    echo mysqli_error($conn);
                                }
                            }
                        }
                    }

                    if(isset($_POST['deleteBTN'])){
                        $queryCheck = mysqli_query($conn, "SELECT * FROM produk WHERE kategori_id='$id'");
                        $dataCount = mysqli_num_rows($queryCheck);

                        if($dataCount>0){
                            ?>
                             <div class="alert alert-primary mt-3" role="alert">
                                Kategori Tidak bisa dihapus karena sudah digunakan di Produk
                            </div>
                            <?php
                            die();
                        }
                        
                        $queryDelete = mysqli_query($conn, "DELETE FROM kategori WHERE id_kategori='$id'");

                        if($queryDelete){
                            ?>
                                <div class="alert alert-primary mt-3" role="alert">
                                        Kategori Berhasil Dihapus
                                </div>

                                <meta http-equiv="refresh" content="2; url=kategori.php" >
                            <?php
                        }
                        else{
                            echo mysqli_error($conn);
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>