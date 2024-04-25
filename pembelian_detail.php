<?php
$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM penjualan LEFT JOIN pelanggan ON pelanggan.id_pelanggan = penjualan.id_pelanggan WHERE id_penjualan = $id"); 
$data = mysqli_fetch_array($query);

?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Pembelian</h1>
        <a href="?page=pembelian" class="btn btn-danger">Kembali</a>
    </div>
    
    <!-- Input field untuk pencarian -->
    <input type="text" id="searchInput" class="form-control" placeholder="Cari produk...">
    <br>

    <form method="post">
        <table class="table table-bordered">
            <tr>
                <td width="200">Nama Pelanggan</td>
                
                <td width="1">:</td>
                <td><?php echo $data['nama_pelanggan']?></td>
            </tr>
            <?php
            $pro = mysqli_query($koneksi, "SELECT * FROM detail_penjualan LEFT JOIN produk ON produk.id_produk = detail_penjualan.id_produk WHERE id_penjualan = $id");
            while ($produk = mysqli_fetch_array($pro)) {
                // Cek apakah jumlah produk lebih dari 0
                if ($produk['jumlah_produk'] > 0) {
                ?>
                <tr class="productRow">
                    <td><?php echo $produk['nama_produk'];?></td>
                    <td>:</td>
                    <td>
                        Harga Satu: Rp <?php echo number_format($produk['harga'], 0, ',', '.');?><br>
                        Jumlah: <?php echo $produk['jumlah_produk'];?><br>
                        Sub Total: Rp <?php echo number_format($produk['sub_total'], 0, ',', '.');?>
                    </td>
                </tr>
                <?php
                }
            }
            ?>
            <tr>
                <td>Total</td>
                <td>:</td>
                <td>Rp <?php echo number_format($data['total_harga'], 0, ',', '.');?></td>
            </tr>
        </table>
    </form>
</div>

<script>
    // Membuat fungsi filter untuk pencarian
    document.getElementById("searchInput").addEventListener("input", function() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.querySelector(".table");
        tr = table.getElementsByClassName("productRow");

        // Loop melalui semua baris tabel, sembunyikan yang tidak sesuai dengan kriteria pencarian
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    });
</script>
