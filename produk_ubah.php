<?php
$id = $_GET['id'];

if(isset($_POST['nama_produk'])) {
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stock = $_POST['stock'];
    
    // Menghilangkan karakter non-digit (seperti titik dan koma) dari harga sebelum menyimpan ke database
    $harga = preg_replace("/[^0-9]/", "", $harga);
    
    // Validasi agar harga minimal adalah Rp. 500 dan stok minimal adalah 1
    if ($harga < 500) {
        echo '<script>alert("Harga minimal adalah Rp. 500")</script>';
    } elseif ($stock < 1) {
        echo '<script>alert("Stok minimal adalah 1")</script>';
    } else {
        $query = mysqli_query($koneksi, "UPDATE produk set nama_produk='$nama_produk', harga='$harga', stock='$stock' WHERE id_produk=$id");
        if($query) {
            echo '<script>alert("Ubah data berhasil");location.href= "?page=produk";</script>';
        } else {
            echo '<script>alert("Ubah data gagal")</script>';
        }
    }
}

$query = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk=$id");
$data = mysqli_fetch_array($query);
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
                <td width="200">Nama Produk</td>
                <td width="1">:</td>
                <td><input class="form-control" value="<?php echo $data['nama_produk'];?>" type="text" name="nama_produk"></td>
            </tr>
            <tr>
                <td>Harga</td>
                <td>:</td>
                <!-- Tampilkan harga dalam format Rupiah -->
                <td><input class="form-control" value="<?php echo number_format($data['harga'], 0, ',', '.');?>" type="text" name="harga"></td>
            </tr>
            <tr>
                <td>Stock</td>
                <td>:</td>
                <td><input class="form-control" value="<?php echo $data['stock'];?>" type="number" step="1" name="stock" min="0"></td>
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
