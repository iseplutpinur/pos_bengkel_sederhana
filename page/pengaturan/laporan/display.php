<?php

if (isset($_POST['simpan'])) {
    $id_pengaturan = $_settingDetail['laporan']['id_pengaturan'];
    $nilai = $_POST['perusahaan'] . '$' . $_POST['alamat'] . '$' . $_POST['jabatan'] . '$' . $_POST['pejabat'];

    $sql  = $koneksi->query("UPDATE `tb_pengaturan` SET `pengaturan_nilai` = '$nilai' WHERE `tb_pengaturan`.`id_pengaturan` = '$id_pengaturan'");
    if ($sql) {
        setAlert('Berhasil..! ', 'Data berhasil diubah..', 'success');
        echo '<script type = "text/javascript">window.location.href = "' . $_baseurl . '";</script>';
    } else {
        setAlert('Gagal..! ', 'Data gagal diubah..', 'success');
        echo '<script type = "text/javascript">window.location.href = "' . $_baseurl . '";</script>';
    }
}
?>

<div class="container-fluid">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title"><?php echo $menuactive['menu'] . " " . $menuactive['submenu']; ?></h3>
        </div> <!-- /.card-body -->
        <div class="card-body">
            <form method="POST" method="post">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nama Perusahaan</label>
                            <input class="form-control" name="perusahaan" id="perusahaan" value="<?php echo $print['header']['judul']; ?>" required="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nama Jabatan</label>
                            <input class="form-control" name="jabatan" id="jabatan" value="<?php echo $print['footer']['jabatan']; ?>" required="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nama Pejabat</label>
                            <input class="form-control" name="pejabat" id="pejabat" value="<?php echo $print['footer']['nama']; ?>" required="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Alamat Perusahaan</label>
                            <textarea class="form-control" type="text" name="alamat" id="alamat" rows="4" required=""><?php echo $print['header']['alamat']; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <p><?php echo $_settingDetail['laporan']['pengaturan_deskripsi']; ?></p>
                        </div>
                    </div>
                </div>
                <div>
                    <input type="submit" name="simpan" value="Ubah" class="btn btn-primary">
                </div>
            </form>
        </div><!-- /.card-body -->
    </div>
</div>

<?php

if (isset($_POST['simpan'])) {
    $qperusahan = true;
    if ($_POST['perusahaan'] != $_settingDetail['nama_perusahaan']['pengaturan_nilai']) {
        $nilai = $_POST['perusahaan'];
        $id_pengaturan = $_settingDetail['nama_perusahaan']['id_pengaturan'];
        $qperusahan = $koneksi->query("UPDATE `tb_pengaturan` SET `pengaturan_nilai` = '$nilai' WHERE `tb_pengaturan`.`id_pengaturan` = '$id_pengaturan'");
    }

    $qurl = true;
    if ($_POST['url'] != $_settingDetail['default_home']['pengaturan_nilai']) {
        $nilai = $_POST['url'];
        $id_pengaturan = $_settingDetail['default_home']['id_pengaturan'];
        $qurl = $koneksi->query("UPDATE `tb_pengaturan` SET `pengaturan_nilai` = '$nilai' WHERE `tb_pengaturan`.`id_pengaturan` = '$id_pengaturan'");
    }

    $qcpr = true;
    if ($_POST['copyright'] != $_settingDetail['tahuncopyright']['pengaturan_nilai']) {
        $nilai = $_POST['copyright'];
        $id_pengaturan = $_settingDetail['tahuncopyright']['id_pengaturan'];
        $qcpr = $koneksi->query("UPDATE `tb_pengaturan` SET `pengaturan_nilai` = '$nilai' WHERE `tb_pengaturan`.`id_pengaturan` = '$id_pengaturan'");
    }

    $dev = true;
    if (isset($_POST['pengembangan'])) {
        $id_pengaturan = $_settingDetail['pengembangan']['id_pengaturan'];
        $dev = $koneksi->query("UPDATE `tb_pengaturan` SET `pengaturan_nilai` = '1' WHERE `tb_pengaturan`.`id_pengaturan` = '$id_pengaturan'");
    } else {
        $id_pengaturan = $_settingDetail['pengembangan']['id_pengaturan'];
        $dev = $koneksi->query("UPDATE `tb_pengaturan` SET `pengaturan_nilai` = '0' WHERE `tb_pengaturan`.`id_pengaturan` = '$id_pengaturan'");
    }

    $gambar = true;

    if ($_FILES['gambar']['tmp_name']) {
        if (file_exists("images/background/bg.jpg")) {
            unlink("images/background/bg.jpg");
        }
        $lokasi = $_FILES['gambar']['tmp_name'];
        $gambar = move_uploaded_file($lokasi, "images/background/bg.jpg");
    }

    $sql = $qperusahan && $qurl && $qcpr && $dev && $gambar;
    if ($sql) {
        setAlert('Berhasil..! ', 'Data berhasil diubah..', 'success');
        echo '<script type = "text/javascript">window.location.href = "' . $_baseurl . '";</script>';
    } else {
        setAlert('Gagal..! ', 'Data gagal diubah..', 'success');
        echo '<script type = "text/javascript">window.location.href = "' . $_baseurl . '";</script>';
    }
}
?>