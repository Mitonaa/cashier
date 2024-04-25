<?php
include "koneksi.php";

if(isset($_POST['username'])){
    $nama =  $_POST['nama'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $level = 'admin';

    // Periksa apakah nama atau username sudah ada dalam database
    $query_check_existence = mysqli_query($koneksi, "SELECT * FROM user WHERE nama='$nama' OR username='$username'");
    if(mysqli_num_rows($query_check_existence) > 0) {
        echo "Error: Nama atau Username sudah digunakan.";
        header("refresh:3;url=register.php"); // Pengalihan halaman setelah 3 detik
        exit(); // Berhenti eksekusi jika ada kesalahan
    }

    // Jika nama atau username belum ada dalam database, lakukan INSERT
    $insert = mysqli_query($koneksi,"INSERT INTO user(nama,username,password,level) VALUES('$nama','$username','$password','$level') ");

    if (!$insert) {
        // Menampilkan pesan error dan query yang salah
        echo "Error: " . mysqli_error($koneksi);
        echo "<br>Query: " . "INSERT INTO user(nama,username,password,level) VALUES('$nama','$username','$password','$level')";
        die(); // Menghentikan eksekusi skrip jika terjadi kesalahan
    } else {
        // Jika registrasi berhasil, tampilkan pesan sukses dan alihkan ke halaman login
        echo "Registrasi berhasil. Silakan login menggunakan akun yang telah dibuat.";
        echo "<br>";
        echo "Anda akan dialihkan ke halaman login dalam beberapa saat...";
        header("refresh:3;url=login.php"); // Pengalihan halaman setelah 3 detik
        exit(); // Pastikan untuk keluar dari skrip setelah melakukan pengalihan
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register Kasir</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-6 col-md-6">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Register Akun</h1>
                                    </div>
                                    <form class="user" method="POST">
                                        <div class="form-group">
                                            <input type="text" name="nama" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Masukkan Nama">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="username" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Masukkan Username">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Masukkan Password" minlength="6">
                                        </div>

                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Register
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="login.php">Sudah Punya Akun? Login!</a>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
