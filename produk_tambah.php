<?php
if(isset($_POST['nama_produk'])) {
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stock = $_POST['stock'];
    
    // Menghilangkan karakter non-digit (seperti titik dan koma) dari harga sebelum menyimpan ke database
    $harga = preg_replace("/[^0-9]/", "", $harga);

    // Validasi harga minimal dan stok minimal
    if($harga < 500) {
        echo '<script>alert("Harga minimal adalah Rp. 500");</script>';
    } elseif($stock < 1) {
        echo '<script>alert("Stok minimal adalah 1");</script>';
    } else {
        $query = mysqli_query($koneksi, "INSERT INTO produk(nama_produk, harga, stock) values ('$nama_produk', '$harga', '$stock')");
        if($query) {
            echo '<script>alert("Tambah data berhasil");location.href="?page=produk";</script>';
        } else {
            echo '<script>alert("Tambah data gagal")</script>';
        }
    }
}
?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Produk</h1>
        <a href="?page=produk" class="btn btn-danger">Kembali</a>
    </div>

    <form method="post">
        <table class="table table-bordered">
            <tr>
                <td width="200">Nama produk</td>
                <td width="1">:</td>
                <td><input class="form-control" type="text" name="nama_produk"></td>
            </tr>
            <tr>
                <td>Harga </td>
                <td>:</td>
                <!-- Tampilkan input harga dalam format Rupiah -->
                <td><input class="form-control" type="text" name="harga" placeholder="Rp"></td>
            </tr>
            <tr>
                <td>Stock </td>
                <td>:</td>
                <td><input class="form-control" type="number" step="1" name="stock" ></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-danger">Reset</button>
                </td>
            </tr>
        </table>
    </form>
</div>
