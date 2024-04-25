<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Produk</h1>
        <a href="?page=produk_tambah" class="btn btn-primary">+ Tambah Data</a>
    </div>
    
    <!-- Search input -->
    <input type="text" id="searchInput" class="form-control" placeholder="Cari produk...">
    <br>
    
    <table class="table table-bordered">
        <tr>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Stock</th>
            <th>Aksi</th>
        </tr>
        <?php
        $query = mysqli_query($koneksi,"SELECT * FROM produk"); 
        while($data = mysqli_fetch_array($query)){
            ?>
            <tr class="productRow">
                <td><?php echo $data['nama_produk']?></td>
                <td><?php echo "Rp " . number_format($data['harga'], 0, ',', '.');?></td>
                <td><?php echo $data['stock']?></td>
                <td>
                    <a href="?page=produk_ubah&&id=<?php echo $data['id_produk'];?>" class="btn btn-secondary">Ubah</a>
                    <a href="?page=produk_hapus&&id=<?php echo $data['id_produk'];?>" class="btn btn-danger">Hapus</a>
                </td>
            </tr>
            <?php 
        }
        ?>
    </table>
</div>

<script>
    // Function to filter products
    document.getElementById("searchInput").addEventListener("input", function() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.querySelector(".table");
        tr = table.getElementsByClassName("productRow");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0]; // Change index if the column position changes
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
