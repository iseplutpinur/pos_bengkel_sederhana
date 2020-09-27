<?php
if (isset($_SESSION['user']['id'])) {
    $id_user      = $_SESSION['user']['id'];
    $user         = query("SELECT * FROM tb_user INNER JOIN tb_user_level ON tb_user.id_level = tb_user_level.id_level WHERE tb_user.id_user='$id_user'");
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
                setAlert('Berhasil..! ', 'Data berhasil diubah..', 'success');
                echo '<script type = "text/javascript">window.location.href = "' . $_baseurl . '";</script>';
            } else {
                setAlert('Gagal..! ', 'Data gagal diubah..', 'success');
                echo '<script type = "text/javascript">window.location.href = "' . $_baseurl . '";</script>';
            }
        } else {
            $querybuilder = " UPDATE `tb_user` SET 
                    `user_nama`          = '$user_nama',
                    `user_alamat`        = '$user_alamat',
                    `user_gender`        = '$user_gender',
                    `user_tanggal_lahir` = '$user_tanggal_lahir',
                    `user_nik`           = '$user_nik',
                    `user_no_telepon`    = '$user_no_telepon',
                    `user_email`         = '$user_email',
              WHERE `tb_user`.`id_user`  = '$id_user'
            ";
            if ($koneksi->query($querybuilder)) {
                setAlert('Berhasil..! ', 'Data berhasil diubah..', 'success');
                echo '<script type = "text/javascript">window.location.href = "' . $_baseurl . '";</script>';
            } else {
                setAlert('Gagal..! ', 'Data gagal diubah..', 'success');
                echo '<script type = "text/javascript">window.location.href = "' . $_baseurl . '";</script>';
            }
        }
    }

    // { ["id_user"]=> string(1) "2" ["id_level"]=> string(1) "2" ["user_username"]=> string(5) "admin" ["user_password"]=> string(60) "$2y$10$BK4K1rN9bqeGcNvoCeJ1jO2IKJID95viYE.x8FgZDxM9F4crr.N2y" ["user_nama"]=> string(14) "Isep Lutpi Nur" ["user_alamat"]=> string(1) "0" ["user_gender"]=> string(9) "Laki-Laki" ["user_tanggal_lahir"]=> string(10) "0000-00-00" ["user_nik"]=> string(1) "0" ["user_no_telepon"]=> string(1) "0" ["user_foto"]=> string(23) "admin_5f65e86a67474.jpg" ["active"]=> string(1) "1" ["level_title"]=> string(5) "Admin" }
} else {
    die;
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
                    <li class="nav-item"><a class="nav-link active" href="#data-diri" data-toggle="tab">Data Diri</a></li>
                    <li class="nav-item"><a class="nav-link" href="#ubah-password" data-toggle="tab">Ubah Password</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="data-diri">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="user_nama">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="user_nama" name="user_nama" placeholder="Nama Lengkap" value="<?= $user['user_nama']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="user_no_telepon">Nomor Telepon</label>
                                        <input type="text" class="form-control" id="user_no_telepon" name="user_no_telepon" placeholder="Nomor Telepon" value="<?= $user['user_no_telepon']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="user_email">Email</label>
                                        <input type="text" class="form-control" id="user_email" name="user_email" placeholder="Email" value="<?= $user['user_email']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="user_nik">No NIK</label>
                                                <input type="number" class="form-control" id="user_nik" name="user_nik" placeholder="Nomor Induk Kependudukan" value="<?= $user['user_nik']; ?>">
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
                                    <div class="col-md-12 pl-3 pb-3 pt-1">
                                        <!-- pake button tidak bisa di submit -->
                                        <input class="btn btn-primary" type="submit" name="ubah-data" value="Ubah Data Diri"></input>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="ubah-password">
                        <!-- The timeline -->
                        <form role="form" id="quickForm">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                </div>
                                <div class="form-group mb-0">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="terms" class="custom-control-input" id="exampleCheck1">
                                        <label class="custom-control-label" for="exampleCheck1">I agree to the <a href="#">terms of service</a>.</label>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<script type="text/javascript">
    function labelFileFoto(data) {
        // manual soalnya labelnya gk berfungsi
        document.querySelector('#label-foto').innerText = data.files[0].name;
    }
    $(document).ready(function() {
        $.validator.setDefaults({
            submitHandler: function() {
                alert("Form successful submitted!");
            }
        });
        $('#quickForm').validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true,
                    minlength: 5
                },
                terms: {
                    required: true
                },
            },
            messages: {
                email: {
                    required: "Please enter a email address",
                    email: "Please enter a vaild email address"
                },
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long"
                },
                terms: "Please accept our terms"
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>