<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pembelian</title>
    <link rel="stylesheet" href="printout.css"> <!-- Tautan ke file CSS untuk halaman cetak -->
</head>
<body>
<?php
$searchInput = isset($_GET['searchInput']) ? $_GET['searchInput'] : '';
// Proses pengambilan data penjualan berdasarkan $searchInput
// Misalnya, jika menggunakan $penjualan yang telah Anda definisikan sebelumnya:
$searchData = [];
foreach ($penjualan as $data) {
    if (strpos(strtoupper($data['tanggal_penjualan']), strtoupper($searchInput)) !== false) {
        $searchData[] = $data;
    }
}
?>

    <h1>Data Pembelian</h1>
    <table border='1'>
        <tr>
            <th>Tanggal Pembelian</th>
            <th>Pelanggan</th>
            <th>Total Harga</th>
        </tr>
        <?php foreach ($searchData as $data): ?>
            <tr>
                <td><?php echo $data['tanggal_penjualan']; ?></td>
                <td><?php echo $data['nama_pelanggan']; ?></td>
                <td><?php echo "Rp " . number_format($data['total_harga'], 0, ',', '.'); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <script>
        // Mencetak halaman setelah isi halaman dimuat
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
