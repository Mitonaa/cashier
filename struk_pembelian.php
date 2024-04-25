<?php
include 'koneksi.php'; 

if(isset($_GET['id_penjualan'])) {
    $id_penjualan = $_GET['id_penjualan'];

    // Query untuk mendapatkan informasi penjualan beserta nama pelanggan
    $query_penjualan = mysqli_query($koneksi, "SELECT penjualan.*, pelanggan.nama_pelanggan 
                                               FROM penjualan 
                                               INNER JOIN pelanggan ON penjualan.id_pelanggan = pelanggan.id_pelanggan 
                                               WHERE penjualan.id_penjualan='$id_penjualan'");
    $penjualan = mysqli_fetch_array($query_penjualan);
    
    // Query untuk mendapatkan detail penjualan
    $query_detail = mysqli_query($koneksi, "SELECT * FROM detail_penjualan WHERE id_penjualan='$id_penjualan'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembelian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .struk {
            border: 1px solid black;
            padding: 10px;
            width: 300px;
            margin: 0 auto;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            border: 1px solid black;
        }
        th {
            background-color: #f2f2f2;
        }
        .total {
            margin-top: 10px;
        }
        .btn-cancel {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="struk">
        <h3>Struk Pembelian</h3>
        <p><strong>Tanggal:</strong> <?php echo $penjualan['tanggal_penjualan']; ?></p>
        <p><strong>Nama Pelanggan:</strong> <?php echo $penjualan['nama_pelanggan']; ?></p>

        <table>
            <thead>
                <tr><th>Nama Produk</th><th>Jumlah</th><th>Subtotal</th></tr>
            </thead>
            <tbody>
                <?php
                $total_harga = 0;
                while ($detail = mysqli_fetch_array($query_detail)) {
                    if ($detail['jumlah_produk'] > 0) { // Cek kuantitas lebih besar dari 0
                        $id_produk = $detail['id_produk'];
                        $query_produk = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk='$id_produk'");
                        $produk = mysqli_fetch_array($query_produk);
                        $subtotal = $detail['sub_total'];
                        $total_harga += $subtotal; // Menambahkan subtotal ke total harga
                        echo "<tr><td>" . $produk['nama_produk'] . "</td><td>" . $detail['jumlah_produk'] . "</td><td>Rp " . number_format($subtotal, 0, ',', '.') . "</td></tr>";
                    }
                }
                ?>
            </tbody>
        </table>
        <p class="total"><strong>Total Harga:</strong> Rp <?php echo number_format($total_harga, 0, ',', '.'); ?></p>

        <!-- Cancel button -->
        <a class="btn-cancel" href="index.php?page=pembelian">Terima Kasih</a>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>

<?php
} else {
    echo "ID Penjualan tidak tersedia.";
}
?>
