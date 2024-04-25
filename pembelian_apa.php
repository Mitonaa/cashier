<?php
// Pastikan koneksi ke database telah dibuat sebelumnya
// Jika belum, Anda perlu membuat koneksi terlebih dahulu
// Contoh: $koneksi = mysqli_connect("localhost", "username", "password", "nama_database");
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Memeriksa apakah parameter tanggal mulai dan selesai dikirimkan melalui URL
if(isset($_GET['start_date']) && isset($_GET['end_date'])) {
    // Mengambil tanggal mulai dan selesai dari URL
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];
    
    // Mengonversi format tanggal menjadi format MySQL (Y-m-d)
    $start_date_mysql = date('Y-m-d', strtotime($start_date));
    $end_date_mysql = date('Y-m-d', strtotime($end_date));
    
    // Membuat query untuk mengambil data penjualan dalam rentang waktu yang disorting
    $query = mysqli_query($koneksi, "SELECT * FROM penjualan LEFT JOIN pelanggan ON pelanggan.id_pelanggan = penjualan.id_pelanggan WHERE tanggal_penjualan BETWEEN '$start_date_mysql' AND '$end_date_mysql'");
    // Periksa apakah query dieksekusi dengan sukses
    if(!$query) {
        die("Error: " . mysqli_error($koneksi));
    }
} else {
    // Jika tidak ada parameter tanggal, ambil semua data penjualan
    $query = mysqli_query($koneksi, "SELECT * FROM penjualan LEFT JOIN pelanggan ON pelanggan.id_pelanggan = penjualan.id_pelanggan");
    // Periksa apakah query dieksekusi dengan sukses
    if(!$query) {
        die("Error: " . mysqli_error($koneksi));
    }
}

// Mengambil data penjualan
$penjualan = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Pembelian</h1>
        <a href="?page=pembelian" class="btn btn-danger">Kembali</a>
    </div>
    
    <!-- Form untuk memilih rentang waktu sorting -->
    <form id="filterForm">
        <div class="form-row align-items-center">
            <div class="col-auto">
                <label for="start_date">Tanggal Mulai:</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="<?php echo isset($start_date) ? $start_date : ''; ?>">
            </div>
            <div class="col-auto">
                <label for="end_date">Tanggal Selesai:</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="<?php echo isset($end_date) ? $end_date : ''; ?>">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>
    
    <!-- Tabel hasil penjualan -->
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID Penjualan</th>
                <th>Tanggal Penjualan</th>
                <th>Nama Pelanggan</th>
                <th>Total Harga</th>
                <th>Detail Pembelian</th> <!-- Kolom baru untuk menampilkan detail pembelian -->
            </tr>
        </thead>
        <tbody>
            <?php foreach($penjualan as $data): ?>
            <tr>
                <td><?php echo $data['id_penjualan']; ?></td>
                <td><?php echo $data['tanggal_penjualan']; ?></td>
                <td><?php echo $data['nama_pelanggan']; ?></td>
                <td><?php echo 'Rp ' . number_format($data['total_harga'], 0, ',', '.'); ?></td>
                <td><a href="?page=detail_penjualan&id=<?php echo $data['id_penjualan']; ?>" class="btn btn-primary">Lihat Detail</a></td> <!-- Tambah link untuk melihat detail pembelian -->
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    document.getElementById('filterForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Mencegah tindakan form default
        var start_date = document.getElementById('start_date').value;
        var end_date = document.getElementById('end_date').value;
        var url = '?start_date=' + start_date + '&end_date=' + end_date;
        window.location.href = url; // Mengarahkan ke URL dengan parameter tanggal yang dipilih
    });
</script>