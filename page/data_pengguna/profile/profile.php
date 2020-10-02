<?php
if (isset($_SESSION['user']['id_user'])) :
    $id_user       = $_SESSION['user']['id_user'];
    $passlama      = true;
    $passbaru      = true;
    $pass          = [];
    $pass['lama']  = (isset($_POST['user_password_lama'])) ? $_POST['user_password_lama'] : '';
    $pass['baru']  = (isset($_POST['user_password_baru'])) ? $_POST['user_password_baru'] : '';
    $pass['baru1'] = (isset($_POST['user_password_baru1'])) ? $_POST['user_password_baru1'] : '';
    $user          = query("SELECT * FROM tb_user INNER JOIN tb_user_level ON tb_user.id_level = tb_user_level.id_level WHERE tb_user.id_user='$id_user'");
    if ($user) $user = $user[0];

    if (isset($_POST['ubah-data'])) {
        $user_nama          = $_POST['user_nama'];
        $user_alamat        = $_POST['user_alamat'];
        $user_gender        = $_POST['user_gender'];
        $user_tanggal_lahir = $_POST['user_tanggal_lahir'];
        $user_nik           = $_POST['user_nik'];
        $user_no_telepon    = $_POST['user_no_telepon'];
        $user_email         = $_POST['user_email'];
        $fotoasal           = $_POST['fotoasal'];
        $foto               = $_FILES['user_foto']['name'];
        $lokasi             = $_FILES['user_foto']['tmp_name'];
        if (!empty($lokasi)) {
            // generate nama file
            $ekteksiGambar = explode('.', $foto);
            $ekteksiGambar = strtolower(end($ekteksiGambar));
            $namaFileBaru  = uniqid() . '.' . $ekteksiGambar;
            $upload        = move_uploaded_file($lokasi, "assets/images/user_profile/" . $namaFileBaru);

            // hapus file yang sudah ada
            if (file_exists("assets/images/user_profile/$fotoasal")) {
                unlink("assets/images/user_profile/$fotoasal");
            }

            $querybuilder = " UPDATE `tb_user` SET 
                    `user_nama`          = '$user_nama',
                    `user_alamat`        = '$user_alamat',
                    `user_gender`        = '$user_gender',
                    `user_tanggal_lahir` = '$user_tanggal_lahir',
                    `user_nik`           = '$user_nik',
                    `user_no_telepon`    = '$user_no_telepon',
                    `user_email`         = '$user_email',
                    `user_foto`          = '$namaFileBaru'
              WHERE `tb_user`.`id_user`  = '$id_user'
            ";
            if ($koneksi->query($querybuilder)) {

                echo '<script type = "text/javascript">setAlert("Berhasil..! ", "Data berhasil diubah..", "success");</script>';
            } else {

                echo '<script type = "text/javascript">setAlert("Gagal..! ", "Data gagal diubah..", "danger");</script>';
            }
        } else {
            $querybuilder = " UPDATE `tb_user` SET 
                    `user_nama`          = '$user_nama',
                    `user_alamat`        = '$user_alamat',
                    `user_gender`        = '$user_gender',
                    `user_tanggal_lahir` = '$user_tanggal_lahir',
                    `user_nik`           = '$user_nik',
                    `user_no_telepon`    = '$user_no_telepon',
                    `user_email`         = '$user_email'
              WHERE `tb_user`.`id_user`  = '$id_user'
            ";
            if ($koneksi->query($querybuilder)) echo '<script type = "text/javascript">setAlert("Berhasil..! ", "Data berhasil diubah..", "success");</script>';
            else echo '<script type = "text/javascript">setAlert("Gagal..! ", "Data gagal diubah..", "danger");</script>';
        }
    }

    if (isset($_POST['ubah-password'])) {
        // cek password lama
        if (password_verify($_POST['user_password_lama'], $user['user_password'])) {
            $user_password_baru  = $_POST['user_password_baru'];
            $user_password_baru1 = $_POST['user_password_baru1'];
            // cek password baru apakah sama atau tidak
            if ($user_password_baru == $user_password_baru1) {
                // acak dulu password sebelum dimasukan kedalam database
                $pw_hash = password_hash($user_password_baru, PASSWORD_DEFAULT);
                $querybuilder = "UPDATE `tb_user` SET  `user_password` = '$pw_hash' WHERE `tb_user`.`id_user`='$id_user'";

                // cek apakah berhasil diganti atau tidak
                if ($koneksi->query($querybuilder)) echo '<script type = "text/javascript">setAlert("Berhasil..! ", "Data berhasil diubah..", "success");</script>';
                else echo '<script type = "text/javascript">setAlert("Gagal..! ", mysqli_error($koneksi), "danger");</script>';
            } else $passbaru = false;
        } else $passlama = false;
    }
?>
    <div class="row">
        <div class="col-md-3">
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="assets/images/user_profile/<?= $user['user_foto']; ?>" alt="User profile picture">
                    </div>
                    <h3 class="profile-username text-center"><?= $user['user_nama']; ?></h3>
                    <p class="text-muted text-center"><?= $user['level_title']; ?></p>
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Username</b> <a class="float-right"><?= $user['user_username']; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Tgl Lahir</b> <a class="float-right"><?= $user['user_tanggal_lahir']; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Jenis Kelamin</b> <a class="float-right"><?= $user['user_gender']; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>No Telepon</b> <a class="float-right"><?= $user['user_no_telepon']; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Terdaftar Sejak</b> <a class="float-right"><?= $user['user_tanggal_daftar']; ?></a>
                        </li>
                    </ul>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>

        <!-- /.col -->
        <div class="col-md-9">
            <!-- About Me Box -->
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <?php if (!$passbaru || !$passlama) : ?>
                            <li class="nav-item"><a class="nav-link" href="#data-diri" data-toggle="tab">Data Diri</a></li>
                            <li class="nav-item"><a class="nav-link active" href="#ubah-password" data-toggle="tab">Ubah Password</a></li>
                        <?php else : ?>
                            <li class="nav-item"><a class="nav-link active" href="#data-diri" data-toggle="tab">Data Diri</a></li>
                            <li class="nav-item"><a class="nav-link" href="#ubah-password" data-toggle="tab">Ubah Password</a></li>
                        <?php endif; ?>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <?php if (!$passbaru || !$passlama) echo '<div class="tab-pane" id="data-diri">';
                        else echo '<div class="active tab-pane" id="data-diri">'; ?>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="user_nama">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="user_nama" name="user_nama" placeholder="Nama Lengkap" value="<?= $user['user_nama']; ?>" minlength="4">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="user_no_telepon">Nomor Telepon</label>
                                        <input type="text" class="form-control" id="user_no_telepon" name="user_no_telepon" placeholder="Nomor Telepon" value="<?= $user['user_no_telepon']; ?>" minlength="4">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="user_email">Email</label>
                                        <input type="email" class="form-control" id="user_email" name="user_email" placeholder="Email" value="<?= $user['user_email']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="user_nik">No NIK</label>
                                                <input type="number" class="form-control" id="user_nik" name="user_nik" placeholder="Nomor Induk Kependudukan" value="<?= $user['user_nik']; ?>" minlength="4">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="user_tanggal_lahir">Tanggal Lahir</label>
                                                <input type="date" class="form-control" id="user_tanggal_lahir" name="user_tanggal_lahir" placeholder="Tanggal Lahir" value="<?= $user['user_tanggal_lahir']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row pt-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="user_gender">Jenis Kelamin</label>
                                                <select class="custom-select" name="user_gender" id="user_gender">
                                                    <?php
                                                    if ($user['user_gender'] == "Laki-Laki") {
                                                        echo '                                                    
                                                        <option value = "Laki-Laki" selected = "">Laki-Laki</option>
                                                        <option value = "Perempuan">Perempuan</option>
                                                        ';
                                                    } else {
                                                        echo '                                                    
                                                        <option value = "Laki-Laki">Laki-Laki</option>
                                                        <option value = "Perempuan"  selected = "">Perempuan</option>
                                                        ';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="user_foto">Foto Profile</label>
                                                <div class="custom-file">
                                                    <input type="text" id="fotoasal" name="fotoasal" value="<?= $user['user_foto']; ?>">
                                                    <input type="file" class="custom-file-input" id="user_foto" name="user_foto" accept="image/*" onchange="labelFileFoto(this)">
                                                    <label class="custom-file-label" for="user_foto" id="label-foto">Pilih Foto</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="user_alamat">Alamat Lengkap</label>
                                        <textarea class="form-control" rows="5" placeholder="Alamat Lengkap" id="user_alamat" name="user_alamat"><?= $user['user_alamat']; ?></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 pl-3 pb-2">
                                        <!-- pake button tidak bisa di submit -->
                                        <input class="btn btn-primary" type="submit" name="ubah-data" value="Ubah Data Diri"></input>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                    <?php if (!$passbaru || !$passlama) echo '<div class="tab-pane active" id="ubah-password">';
                    else echo '<div class="tab-pane" id="ubah-password">'; ?>
                    <!-- The timeline -->
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="user_password_lama">Password Lama</label>
                                    <?php if ($passlama) : ?>
                                        <input type="password" class="form-control" id="user_password_lama" name="user_password_lama" placeholder="Password Lama" value="<?php echo $pass['lama']; ?>" required="" minlength="4">
                                    <?php else : ?>
                                        <input type="password" class="form-control is-invalid" id="user_password_lama" name="user_password_lama" placeholder="Password Lama" value="<?php echo $pass['lama']; ?>" required="" minlength="4">
                                        <span id="user_password_lama-error" class="error invalid-feedback">Password yang anda masukan salah..!</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="user_password_baru">Password Baru</label>
                                    <?php if ($passbaru) : ?>
                                        <input type="password" class="form-control" id="user_password_baru" name="user_password_baru" placeholder="Password Baru" value="<?php echo $pass['baru']; ?>" required="">
                                    <?php else : ?>
                                        <input type="text" class="form-control is-invalid" id="user_password_baru" name="user_password_baru" placeholder="Password Baru" value="<?php echo $pass['baru']; ?>" required="">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="user_password_baru1">Ualngi Password</label>
                                    <?php if ($passbaru) : ?>
                                        <input type="password" class="form-control" id="user_password_baru1" name="user_password_baru1" placeholder="Ualngi Password" value="<?php echo $pass['baru1']; ?>" required="">
                                    <?php else : ?>
                                        <input type="text" class="form-control is-invalid" id="user_password_baru1" name="user_password_baru1" placeholder="Ulangi Password Baru" value="<?php echo $pass['baru1']; ?>" required="">
                                        <span id="user_password_baru1-error" class="error invalid-feedback">Password yang anda masukan tidak sama denan password baru..!</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div class="col-md-12 my-2 pb-1">
                                    <!-- pake button tidak bisa di submit -->
                                    <input class="btn btn-primary" type="submit" name="ubah-password" value="Ubah Data Diri"></input>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <script type="text/javascript">
        function labelFileFoto(data) {
            // manual soalnya labelnya gk berfungsi
            document.querySelector('#label-foto').innerText = data.files[0].name;
        }
    </script>

<?php endif; ?>