<?php
 

if(isset($_POST['id_pelanggan'])) {
    $id_pelanggan = $_POST['id_pelanggan'];
    $produk = $_POST['produk'];
    $tanggal = date('Y-m-d'); 
    $total = 0;
    
    // Validasi pemilihan pelanggan
    if(empty($id_pelanggan)) {
        echo '<script>alert("Pilih pelanggan terlebih dahulu")</script>';
    } else {
        // Masukkan data pembelian ke tabel penjualan
        $query = mysqli_query($koneksi, "INSERT INTO penjualan(tanggal_penjualan, id_pelanggan) VALUES ('$tanggal','$id_pelanggan')");
        
        // Dapatkan ID penjualan terakhir
        $idTerahir = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM penjualan ORDER BY id_penjualan DESC"));
        $id_penjualan = $idTerahir['id_penjualan'];
        
        foreach ($produk as $key => $val) {
            $pr = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk=$key"));
            
            // Validasi jumlah pembelian tidak melebihi stok
            if($val <= $pr['stock']) {
                // Hitung subtotal
                $sub = $val * $pr['harga']; 
                $total += $sub;
    
                // Kurangi jumlah produk yang dibeli dari stok produk
                $sisa_stok = $pr['stock'] - $val;
    
                // Perbarui stok produk di database
                mysqli_query($koneksi, "UPDATE produk SET stock=$sisa_stok WHERE id_produk=$key");
    
                // Masukkan data ke tabel detail_penjualan
                mysqli_query($koneksi, "INSERT INTO detail_penjualan(id_penjualan, id_produk, jumlah_produk, sub_total) VALUES ('$id_penjualan', '$key', '$val', '$sub')");
            } else {
                echo '<script>alert("Jumlah pembelian untuk produk ' . $pr['nama_produk'] . ' melebihi stok yang tersedia")</script>';
            }
        }
        
        // Perbarui total harga pembelian di tabel penjualan
        mysqli_query($koneksi, "UPDATE penjualan SET total_harga=$total WHERE id_penjualan=$id_penjualan");
        
        if($query) {
            // Jika pembelian berhasil, alihkan ke halaman struk pembelian
            header("Location: struk_pembelian.php?id_penjualan=$id_penjualan");
            exit();
        } else {
            echo '<script>alert("Tambah data gagal")</script>';
        }
    }
}
?>

<form method="post">
    <div class="container-fluid">
        <!-- Heading Halaman -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Pembelian</h1>
            <a href="?page=pembelian" class="btn btn-danger">Kembali</a>
        </div>
        
        <div class="row">
            <!-- Tabel produk -->
            <div class="col-md-6">
                <!-- Input pencarian -->
                <input type="text" id="searchInput" class="form-control mb-3" placeholder="Cari produk...">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $pro = mysqli_query($koneksi, "SELECT * FROM produk");
                        while ($produk = mysqli_fetch_array($pro)) {
                            ?>
                            <tr class="productRow">
                                <td><?php echo $produk['nama_produk'] . ' (Stok '.$produk['stock'].')'?></td>
                                <td><?php echo 'Rp ' . number_format($produk['harga'], 0, ',', '.');?></td>
                                <td>
                                    <!-- Tombol "Tambah ke Keranjang" -->
                                    <button type="button" class="btn btn-success add-to-cart" data-id="<?php echo $produk['id_produk'];?>">Tambah ke Keranjang</button>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Tabel keranjang -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Keranjang</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <label for="id_pelanggan">Pilih Pelanggan:</label>
                            <select name="id_pelanggan" id="id_pelanggan" class="form-control mb-3">
                                <?php
                                // Ambil daftar pelanggan dari database
                                $pelanggan_query = mysqli_query($koneksi, "SELECT * FROM pelanggan");
                                while ($pelanggan = mysqli_fetch_array($pelanggan_query)) {
                                    echo '<option value="' . $pelanggan['id_pelanggan'] . '">' . $pelanggan['nama_pelanggan'] . '</option>';
                                }
                                ?>
                            </select>
                            <thead>
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Jumlah</th>
                                    <th style="display: none;">ID Produk</th> <!-- Kolom tersembunyi untuk ID produk -->
                                </tr>
                            </thead>
                            <tbody id="cartBody">
                                <!-- Daftar barang di keranjang akan ditampilkan di sini -->
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <!-- Tombol "Submit" untuk mengonfirmasi pembelian -->
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const addToCartButtons = document.querySelectorAll(".add-to-cart");
        const cartBody = document.getElementById("cartBody");

        addToCartButtons.forEach(button => {
            button.addEventListener("click", function() {
                const productId = this.getAttribute("data-id");
                const productName = this.parentNode.parentNode.querySelector("td").textContent;
                const existingProductRow = cartBody.querySelector(`tr[data-id="${productId}"]`);

                if (existingProductRow) {
                    // Produk sudah ada di keranjang, tambahkan jumlahnya
                    const quantityCell = existingProductRow.querySelector(".quantity");
                    let quantity = parseInt(quantityCell.textContent);
                    quantity++;
                    quantityCell.textContent = quantity;
                    updateHiddenInput(productId, quantity);
                } else {
                    // Produk belum ada di keranjang, tambahkan baris baru
                    const newRow = document.createElement("tr");
                    newRow.dataset.id = productId;
                    newRow.innerHTML = `
                        <td>${productName}</td>
                        <td class="quantity">1</td>
                        <td style="display: none;">
                            <input type="hidden" name="produk[${productId}]" value="1">
                            <button class="btn btn-sm btn-secondary btn-increase" data-id="${productId}">+</button>
                        </td>
                    `;
                    cartBody.appendChild(newRow);
                }
            });
        });

        // Event listener untuk tombol tambah di keranjang
        cartBody.addEventListener("click", function(event) {
            if (event.target.classList.contains("btn-increase")) {
                const productId = event.target.getAttribute("data-id");
                const quantityCell = event.target.parentNode.previousElementSibling;
                let quantity = parseInt(quantityCell.textContent);
                quantity++;
                quantityCell.textContent = quantity;
                updateHiddenInput(productId, quantity);
            }
        });

        // Fungsi untuk memperbarui nilai input tersembunyi
        function updateHiddenInput(productId, quantity) {
            const hiddenInput = cartBody.querySelector(`input[name="produk[${productId}]"]`);
            if (hiddenInput) {
                hiddenInput.value = quantity;
            }
        }
    });
</script>
