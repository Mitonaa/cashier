<?php
if(isset($_POST['nama_pelanggan'])) {
    $nama = $_POST [ 'nama_pelanggan' ];
    $alamat = $_POST ['alamat'];
    $no_telpon = $_POST ['no_telpon'];
    
    $query = mysqli_query($koneksi, "INSERT INTO pelanggan(nama_pelanggan,alamat,no_telpon) values ('$nama','$alamat','$no_telpon')");
    if($query) {
        echo '<script>alert("Tambah data berhasil"); location.href="?page=pelanggan"</script>';
    }else{
        echo '<script>alert("Tambah data gagal")</script>';
    }
}
?>
<div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Pelanggan</h1>
                        
                    <a href="?page=pelanggan" class="btn btn-danger">Kembali</a>
                    </div>

                    <form method="post">
                        <table class="table table-bordered">
                            <tr>
                                <td width="200">Nama Pelanggan</td>
                                <td width="1">:</td>
                                <td><input class= "form_control "type="text" name="nama_pelanggan"></td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>:</td>
                                <td>
                                    <textarea name="alamat" rows="5" class="form-control"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>No telepon </td>
                                <td>:</td>
                                <td><input class= "form_control "type="number" step="0" name="no_telpon"></td>
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
                    