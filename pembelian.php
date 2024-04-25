
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pembelian</h1>
        <a href="?page=pembelian_tambah" class="btn btn-primary">+ Tambah Pembelian</a>
        <!-- Tambahkan tombol Print -->
        <button onclick="printData()" class="btn btn-success">Print</button>
    </div>
    
    <!-- Tambahkan input untuk melakukan pencarian -->
    <input type="text" id="searchInput" class="form-control" placeholder="Cari pembelian...">
    
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Tanggal Pembelian</th>
                <th>Pelanggan</th>
                <th>Total Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = array(); // Simpan hasil pencarian dalam array
            $query = mysqli_query($koneksi, "SELECT * FROM penjualan LEFT JOIN pelanggan ON pelanggan.id_pelanggan = penjualan.id_pelanggan"); 
            while($data = mysqli_fetch_array($query)){
                $result[] = $data; // Tambahkan data ke array hasil pencarian
            ?>
            <tr>
                <td><?php echo $data['tanggal_penjualan']?></td>
                <td><?php echo $data['nama_pelanggan']?></td>
                <td><?php echo "Rp " . number_format($data['total_harga'], 0, ',', '.');?></td>
                <td>
                    <a href="?page=pembelian_detail&&id=<?php echo $data['id_penjualan'];?>" class="btn btn-secondary">Detail</a>
                    <a href="?page=pembelian_hapus&&id=<?php echo $data['id_penjualan'];?>" class="btn btn-danger">Hapus</a>
                </td>
            </tr>
            <?php 
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    function printData() {
        // Ambil input pencarian
        var filter = document.getElementById("searchInput").value.toUpperCase();
        // Buat array untuk menyimpan hasil pencarian berdasarkan tanggal
        var searchData = [];
        // Loop melalui semua data hasil pencarian
        <?php foreach($result as $data): ?>
            // Jika data cocok dengan kriteria pencarian, tambahkan ke array
            if ("<?php echo strtoupper($data['tanggal_penjualan']); ?>".indexOf(filter) > -1) {
                searchData.push(<?php echo json_encode($data); ?>);
            }
        <?php endforeach; ?>
        // Cetak data yang sesuai dengan kriteria pencarian
        // Anda dapat menyesuaikan format cetakan sesuai kebutuhan
        console.log(searchData);
        
        // Buat string HTML untuk mencetak data
        var printContent = "<h1>Data Pembelian</h1><table border='1'><tr><th>Tanggal Pembelian</th><th>Pelanggan</th><th>Total Harga</th></tr>";
        for (var i = 0; i < searchData.length; i++) {
            printContent += "<tr><td>" + searchData[i]['tanggal_penjualan'] + "</td><td>" + searchData[i]['nama_pelanggan'] + "</td><td>" + searchData[i]['total_harga'] + "</td></tr>";
        }
        printContent += "</table>";
        
        // Buat jendela baru untuk mencetak data
        var printWindow = window.open('', '_blank');
        printWindow.document.write(printContent);
        printWindow.document.close();
        printWindow.print();
    }
    // Tambahkan event listener untuk input pencarian
    document.getElementById("searchInput").addEventListener("input", function() {
        var input, filter, table, tr, td, i, txtValue;
        input = this;
        filter = input.value.toUpperCase();
        table = input.nextElementSibling; // Mendapatkan tabel berikutnya setelah input
        tr = table.getElementsByTagName("tr");

        // Loop melalui semua baris tabel, sembunyikan yang tidak sesuai dengan kriteria pencarian
        for (i = 0; i < tr.length; i++) {
            tdTanggal = tr[i].getElementsByTagName("td")[0]; // Kolom pertama untuk pencarian berdasarkan tanggal
            tdNama = tr[i].getElementsByTagName("td")[1]; // Kolom kedua untuk pencarian berdasarkan nama pelanggan
            if (tdTanggal && tdNama) {
                txtValueTanggal = tdTanggal.textContent || tdTanggal.innerText;
                txtValueNama = tdNama.textContent || tdNama.innerText;
                if (txtValueTanggal.toUpperCase().indexOf(filter) > -1 || txtValueNama.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = ""; // Tampilkan baris jika cocok dengan kriteria pencarian
                } else {
                    tr[i].style.display = "none"; // Sembunyikan baris jika tidak cocok dengan kriteria pencarian
                }
            }
        }
    });
</script>
