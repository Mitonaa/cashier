<?php
// Pastikan file koneksi.php sudah disertakan di sini
include 'koneksi.php';

if(isset($_GET['id'])) {
    // Dapatkan ID yang akan dihapus
    $id_penjualan = $_GET['id'];

    // Lakukan proses penghapusan data berdasarkan ID
    $query = mysqli_query($koneksi, "DELETE FROM penjualan WHERE id_penjualan = $id_penjualan");
    $query = mysqli_query($koneksi, "DELETE FROM detail_penjualan WHERE id_penjualan = $id_penjualan");

    if($query) {
        // Jika penghapusan berhasil, alihkan kembali ke halaman penjualan atau halaman yang sesuai
        echo '<script>alert("Data berhasil dihapus"); location.href="?page=pembelian"</script>';
        exit();
    } else {
        echo '<script>alert("Gagal menghapus data penjualan")</script>';
    }
}
?>
