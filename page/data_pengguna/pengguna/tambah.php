<?php
if (isset($_POST['simpan-tambah'])) {
    $id_level            = $_POST['id_level_tambah'];
    $user_username       = $_POST['user_username_tambah'];
    $user_email          = $_POST['user_email_tambah'];
    $user_nama           = $_POST['user_nama_tambah'];
    $user_alamat         = $_POST['user_alamat_tambah'];
    $user_gender         = $_POST['user_gender_tambah'];
    $user_tanggal_lahir  = $_POST['user_tanggal_lahir_tambah'];
    $user_nik            = $_POST['user_nik_tambah'];
    $user_no_telepon     = $_POST['user_no_telepon_tambah'];
    $user_tanggal_daftar = $_POST['user_tanggal_daftar_tambah'];

    $user_foto        = $_FILES['user_foto_tambah']['name'];
    $user_foto_lokasi = $_FILES['user_foto_tambah']['tmp_name'];

    // generate nama file
    $ekteksiGambar = explode('.', $user_foto);
    $ekteksiGambar = strtolower(end($ekteksiGambar));
    $namaFileBaru  = $user_username . "_" . uniqid() . '.' . $ekteksiGambar;

    $querybuilder = "INSERT INTO `tb_user`
    (`id_user`, `id_level`, `user_username`, `user_password`, `user_email`, `user_nama`, `user_alamat`, `user_gender`, `user_tanggal_lahir`, `user_nik`, `user_no_telepon`, `user_foto`, `user_active`)
     VALUES 
    (NULL,'$id_level','$user_username','$default_password','$user_email','$user_nama','$user_alamat','$user_gender','$user_tanggal_lahir','$user_nik','$user_no_telepon','$namaFileBaru','0')";

    $sql = $koneksi->query($querybuilder);
    if ($sql) {
        $upload = move_uploaded_file($user_foto_lokasi, "assets/images/user_profile/" . $namaFileBaru);
        if ($upload) echo '<script type = "text/javascript">setAlert("Berhasil..! ", "Data berhasil ditambahkan..", "success");</script>';
        else echo '<script type = "text/javascript">setAlert("Gagal..! ", "Data gagal ditambahkan.. Ada masalah saat mengupload foto", "danger");</script>';
    } else {
        if (mysqli_errno($koneksi) == 1062)  echo '<script type = "text/javascript">setAlert("Gagal..! ", "Data gagal ditambahkan.. NIK, Username, Email Atau Nomor Telepon Mungkin sudah pernah digunakan..!", "danger");</script>';
        else echo '<script type = "text/javascript">setAlert("Gagal..! ", "Data gagal ditambahkan..", "danger");</script>';
    }
}
?>

<div class="modal fade" id="modal-tambah">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Menu</h4>
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
                                    <label for="user_nik_tambah">NIK</label>
                                    <input type="number" class="form-control" name="user_nik_tambah" id="user_nik_tambah" placeholder="Nomor induk kependudukan" required="">
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label for="user_nama_tambah">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="user_nama_tambah" id="user_nama_tambah" placeholder="Nama Lengkap" required="">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="user_tanggal_lahir_tambah">Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="user_tanggal_lahir_tambah" id="user_tanggal_lahir_tambah" placeholder="Tanggal Lahir" required="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="user_username_tambah">Username</label>
                                    <input type="text" class="form-control" name="user_username_tambah" id="user_username_tambah" placeholder="Username" required="">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="user_email_tambah">Email</label>
                                    <input type="email" class="form-control" name="user_email_tambah" id="user_email_tambah" placeholder="Email" required="">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="user_no_telepon_tambah">No Telepon</label>
                                    <input type="text" class="form-control" name="user_no_telepon_tambah" id="user_no_telepon_tambah" placeholder="No Telepon" required="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="user_gender_tambah">Jenis Kelamin</label>
                                <select class="custom-select" name="user_gender_tambah" id="user_gender_tambah">
                                    <option value="Laki-Laki" selected="">Laki-Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label for="user_foto_tambah">Foto Profile</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="user_foto_tambah" name="user_foto_tambah" accept="image/*" onchange="labelFileFoto(this)">
                                    <label class="custom-file-label" for="user_foto_tambah" id="label_user_foto_tambah">Pilih Foto</label>
                                    <script>
                                        function labelFileFoto(data) {
                                            // manual soalnya labelnya gk berfungsi
                                            document.querySelector('#label_user_foto_tambah').innerText = data.files[0].name;
                                        }
                                    </script>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <label for="id_level_tambah">Level User</label>
                                <select class="form-control" name="id_level_tambah" id="id_level_tambah">
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
                                    <label for="user_tanggal_daftar_tambah">Tanggal Daftar</label>
                                    <input type="date" class="form-control" name="user_tanggal_daftar_tambah" id="user_tanggal_daftar_tambah" placeholder="Tanggal Lahir" readonly="" value="<?= date("yy-m-d"); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="user_alamat_tambah">Alamat Lengkap</label>
                                    <textarea class="form-control" rows="5" placeholder="Alamat Lengkap" id="user_alamat_tambah" name="user_alamat_tambah"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="submit" name="simpan-tambah" class="btn btn-primary">Tambah</button>
                </form>
                <button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>