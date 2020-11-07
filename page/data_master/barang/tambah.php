<?php
if (isset($_POST['simpan'])) {
    // meniapkan informasi untu disimpan
    $nama_barang = $_POST['nama_barang'];
    $kode_barang = $_POST['kode_barang'];
    $harga_beli  = $_POST['harga_beli'];
    $harga_jual  = $_POST['harga_jual'];
    $kategori    = $_POST['kategori'];
    $tgl_daftar  = $_POST['tgl_daftar'];

    // menyiapkan informasi gambar
    $foto          = $_FILES['gambar']['name'];
    $lokasi        = $_FILES['gambar']['tmp_name'];
    $ekteksiGambar = explode('.', $foto);
    $ekteksiGambar = strtolower(end($ekteksiGambar));
    $namaFileBaru  = $kode_barang . "_" . uniqid() . '.' . $ekteksiGambar;
    $upload        = move_uploaded_file($lokasi, "images/master_data_barang/" . $namaFileBaru);

    $querybuilder = "INSERT INTO `tb_barang_data` 
    (`id_barang_data`, `id_barang_kategori`, `barang_data_nama`, `barang_data_kode`, `barang_data_harga_beli`, `barang_data_harga_jual`, `barang_data_gambar`, `barang_data_tanggal`)
    VALUES 
    (NULL, '$kategori', '$nama_barang', '$kode_barang', '$harga_beli', '$harga_jual', '$namaFileBaru', '$tgl_daftar') ";

    $sql = $koneksi->query($querybuilder);
    if ($sql) {
        setAlert('Berhasil..! ', 'Data berhasil ditambahkan..', 'success');
        echo '<script type = "text/javascript">window.location.href = "' . $_baseurl . '";</script>';
    } else {
        setAlert('Gagal..! ', 'Data gagal ditambahkan..', 'success');
        echo '<script type = "text/javascript">window.location.href = "' . $_baseurl . '";</script>';
    }
}

// Menyiapkan data kategori
$kategori = query("SELECT * FROM tb_barang_kategori");
?>

<div class="card">
    <div class="card-header d-flex justify-content-betwen">
        <div class="p-2 flex-fill bd-highlight">
            <h3 class="card-title">Tambah <?php echo $menuactive['submenu']; ?></h3>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <form method="POST">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input class="form-control" name="nama_barang" id="nama_barang" required="">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Harga Beli</label>
                            <input class="form-control" name="harga_beli" id="harga_beli" required="" type="number">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Harga Jual</label>
                            <input class="form-control" name="harga_jual" id="harga_jual" required="" type="number">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Kategori</label>
                            <select class="form-control" name="kategori">
                                <?php if ($kategori) {
                                    foreach ($kategori as $k) {
                                        echo "<option value='$k[id_barang_kategori]'>$k[barang_kategori_nama]</option>";
                                    }
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input class="form-control" type="date" name="harga_beli" id="harga_beli" required="" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Stok</label>
                            <input class="form-control" name="stok" id="stok" required="" type="number">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Warna</label>
                            <input class="form-control" name="warna" id="warna" required="">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Diskon</label>
                            <input class="form-control" name="warna" id="warna" required="" type="number">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Kode</label>
                            <input class="form-control" name="kode" id="kode" required="" type="number">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
                        <a href="<?php echo $_baseurl; ?>" class="btn btn-success">Kembali</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>