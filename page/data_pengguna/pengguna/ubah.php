<?php
if (isset($_POST['simpan-ubah'])) {
    $id_user             = $_POST['id_user_ubah'];
    $id_level            = $_POST['id_level_ubah'];
    $user_username       = strtolower(str_replace(' ', '_', $_POST['user_username_ubah']));
    $user_email          = $_POST['user_email_ubah'];
    $user_nama           = $_POST['user_nama_ubah'];
    $user_alamat         = $_POST['user_alamat_ubah'];
    $user_gender         = $_POST['user_gender_ubah'];
    $user_tanggal_lahir  = $_POST['user_tanggal_lahir_ubah'];
    $user_nik            = $_POST['user_nik_ubah'];
    $user_no_telepon     = $_POST['user_no_telepon_ubah'];
    $user_foto_asal      = $_POST['user_foto_asal_ubah'];

    $user_foto        = $_FILES['user_foto_ubah']['name'];
    $user_foto_lokasi = $_FILES['user_foto_ubah']['tmp_name'];

    if (!empty($user_foto_lokasi)) {
        // generate nama file
        $ekteksiGambar = explode('.', $user_foto);
        $ekteksiGambar = strtolower(end($ekteksiGambar));
        $namaFileBaru  = $user_username . "_" . uniqid() . '.' . $ekteksiGambar;

        $querybuilder = "UPDATE `tb_user` SET 
         `id_level`            = '$id_level',
         `user_username`       = '$user_username',
         `user_email`          = '$user_email',
         `user_nama`           = '$user_nama',
         `user_alamat`         = '$user_alamat',
         `user_gender`         = '$user_gender',
         `user_no_telepon`     = '$user_no_telepon',
         `user_foto`           = '$namaFileBaru'
         WHERE 
         `tb_user`.`id_user`   = '$id_user'";

        $sql = $koneksi->query($querybuilder);
        if ($sql) {
            // hapus file yang sudah ada
            if (file_exists("assetsimages/user_profile/$user_foto_asal")) {
                unlink("assetsimages/user_profile/$user_foto_asal");
            }
            $upload = move_uploaded_file($user_foto_lokasi, "assets/images/user_profile/" . $namaFileBaru);
            if ($upload) echo '<script type = "text/javascript">setAlert("Berhasil..! ", "Data berhasil diubahkan..", "success");</script>';
            else echo '<script type = "text/javascript">setAlert("Gagal..! ", "Data gagal diubahkan.. Ada masalah saat mengupload foto", "danger");</script>';
        } else {
            if (mysqli_errno($koneksi) == 1062)  echo '<script type = "text/javascript">setAlert("Gagal..! ", "Data gagal diubahkan.. NIK, Username, Email Atau Nomor Telepon Mungkin sudah pernah digunakan..!", "danger");</script>';
            else echo '<script type = "text/javascript">setAlert("Gagal..! ", "Data gagal diubahkan..", "danger");</script>';
        }
    } else {
        $querybuilder = "UPDATE `tb_user` SET 
         `id_level`            = '$id_level',
         `user_username`       = '$user_username',
         `user_email`          = '$user_email',
         `user_nama`           = '$user_nama',
         `user_alamat`         = '$user_alamat',
         `user_gender`         = '$user_gender',
         `user_no_telepon`     = '$user_no_telepon'
         WHERE 
         `tb_user`.`id_user`   = '$id_user'";

        $sql = $koneksi->query($querybuilder);
        if ($sql) {
            echo '<script type = "text/javascript">setAlert("Berhasil..! ", "Data berhasil diubahkan..", "success");</script>';
        } else {
            if (mysqli_errno($koneksi) == 1062)  echo '<script type = "text/javascript">setAlert("Gagal..! ", "Data gagal diubahkan.. NIK, Username, Email Atau Nomor Telepon Mungkin sudah pernah digunakan..!", "danger");</script>';
            else echo '<script type = "text/javascript">setAlert("Gagal..! ", "Data gagal diubahkan..", "danger");</script>';
        }
    }
}
?>

<div class="modal fade" id="modal-ubah">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ubah Pengguna</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="user_nik_ubah">NIK</label>
                                    <input type="number" class="form-control" name="user_nik_ubah" id="user_nik_ubah" placeholder="Nomor induk kependudukan" required="">
                                    <input type="text" value="" name="user_foto_asal_ubah" id="user_foto_asal_ubah" hidden="">
                                    <input type="text" value="" name="id_user_ubah" id="id_user_ubah" hidden="">
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label for="user_nama_ubah">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="user_nama_ubah" id="user_nama_ubah" placeholder="Nama Lengkap" required="">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="user_tanggal_lahir_ubah">Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="user_tanggal_lahir_ubah" id="user_tanggal_lahir_ubah" placeholder="Tanggal Lahir" required="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="user_username_ubah">Username</label>
                                    <input type="text" class="form-control" name="user_username_ubah" id="user_username_ubah" placeholder="Username" required="">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="user_email_ubah">Email</label>
                                    <input type="email" class="form-control" name="user_email_ubah" id="user_email_ubah" placeholder="Email" required="">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="user_no_telepon_ubah">No Telepon</label>
                                    <input type="text" class="form-control" name="user_no_telepon_ubah" id="user_no_telepon_ubah" placeholder="No Telepon" required="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="user_gender_ubah">Jenis Kelamin</label>
                                <select class="custom-select" name="user_gender_ubah" id="user_gender_ubah">
                                    <option value="Laki-Laki" selected="">Laki-Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label for="user_foto_ubah">Foto Profile</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="user_foto_ubah" name="user_foto_ubah" accept="image/*" onchange="labelFileFoto(this)">
                                    <label class="custom-file-label" for="user_foto_ubah" id="label_user_foto_ubah">Pilih Foto</label>
                                    <script>
                                        function labelFileFoto(data) {
                                            // manual soalnya labelnya gk berfungsi
                                            document.querySelector('#label_user_foto_ubah').innerText = data.files[0].name;
                                        }
                                    </script>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <label for="id_level_ubah">Level User</label>
                                <select class="form-control" name="id_level_ubah" id="id_level_ubah">
                                    <?php
                                    $datas = query("SELECT * FROM `tb_user_level`");
                                    if ($datas) {
                                        foreach ($datas as $level) {
                                            echo '<option value="' . $level['id_level'] . '">' . $level['level_title'] . '</option>';
                                        }
                                    } ?>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="user_tanggal_daftar_ubah">Tanggal Daftar</label>
                                    <input type="date" class="form-control" name="user_tanggal_daftar_ubah" id="user_tanggal_daftar_ubah" placeholder="Tanggal Lahir" readonly="" value="<?= date("yy-m-d"); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="user_alamat_ubah">Alamat Lengkap</label>
                                    <textarea class="form-control" rows="5" placeholder="Alamat Lengkap" id="user_alamat_ubah" name="user_alamat_ubah"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="submit" name="simpan-ubah" class="btn btn-primary">ubah</button>
                </form>
                <button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script type="text/javascript">
    function ubahData(data) {
        document.querySelector('input[name=id_user_ubah]').value = data.dataset.id_user;
        document.querySelector('select[name=id_level_ubah]').value = data.dataset.id_level;
        document.querySelector('input[name=user_username_ubah]').value = data.dataset.user_username;
        document.querySelector('input[name=user_email_ubah]').value = data.dataset.user_email;
        document.querySelector('input[name=user_nama_ubah]').value = data.dataset.user_nama;
        document.querySelector('textarea[name=user_alamat_ubah]').value = data.dataset.user_alamat;
        document.querySelector('select[name=user_gender_ubah]').value = data.dataset.user_gender;
        document.querySelector('input[name=user_tanggal_lahir_ubah]').value = data.dataset.user_tanggal_lahir;
        document.querySelector('input[name=user_nik_ubah]').value = data.dataset.user_nik;
        document.querySelector('input[name=user_no_telepon_ubah]').value = data.dataset.user_no_telepon;
        document.querySelector('input[name=user_tanggal_daftar_ubah]').value = data.dataset.user_tanggal_daftar;
        document.querySelector('input[name=user_foto_asal_ubah]').value = data.dataset.user_foto_asal;
    }
</script>