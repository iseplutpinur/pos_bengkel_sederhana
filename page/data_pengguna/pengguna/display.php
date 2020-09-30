<?php
$password_asal    = "iseplutpi1008"; // password default
$default_password = password_hash($password_asal, PASSWORD_DEFAULT);

include 'tambah.php';
include 'ubah.php';
include 'hapus.php';

if (isset($_GET['aksi']) && isset($_GET['id_user'])) {
    $id_user = $_GET['id_user'];
    if ($_GET['aksi'] == 'ganti_active' && isset($_GET['status'])) {
        // Admin tidak boleh dinonaktifkan
        if ($id_user != 2) {
            if ($_GET['status']) $sql  = $koneksi->query("UPDATE `tb_user` SET `user_active` = '0' WHERE `tb_user`.`id_user` = '$id_user'");
            else  $sql  = $koneksi->query("UPDATE `tb_user` SET `user_active` = '1' WHERE `tb_user`.`id_user` = '$id_user'");

            if ($sql) {
                echo '<script type = "text/javascript">setAlert("Berhasil..! ", "Data berhasil diubah..", "success");</script>';
            } else {
                echo '<script type = "text/javascript">setAlert("Gagal..! ", "Data gagal diubah..", "danger");</script>';
            }
        } else echo '<script type = "text/javascript">setAlert("Gagal..! ", "Admin tidak boleh dinonaktifkan", "danger");</script>';
    } elseif ($_GET['aksi'] == 'reset_password') {
        $sql  = $koneksi->query("UPDATE `tb_user` SET `user_password` = '$default_password' WHERE `tb_user`.`id_user` = '$id_user'");

        if ($sql) {
            echo '<script type = "text/javascript">setAlert("Berhasil..! ", "Password berhasil reset menjadi <b>' . $password_asal . '</b> ..", "success");</script>';
        } else {
            echo '<script type = "text/javascript">setAlert("Gagal..! ", "Password gagal reset ..", "danger");</script>';
        }
    }
}



//  ambil data untuk display
$querybuilder = "SELECT * FROM tb_user 
            INNER JOIN tb_user_level 
            ON tb_user.id_level = tb_user_level.id_level 
            ORDER BY tb_user.id_level DESC";
$data = query($querybuilder);
?>
<div class="card">
    <div class="card-header d-flex justify-content-betwen">
        <div class="p-2 flex-fill bd-highlight">
            <h3 class="card-title"><?php echo $menuactive['menu'] . " " . $menuactive['submenu']; ?></h3>
        </div>
        <div class="p-1 flex-fill bd-highlight text-right">
            <?php if ($_settingDetail['pengembangan']['pengaturan_nilai']) : ?>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-tambah"><i class="fa fa-plus"></i> Tambah Data</button>
            <?php endif; ?>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="table1">
                <thead>
                    <tr>
                        <th style="text-align:center;" width="25px;">No</th>
                        <th style="text-align:center;">Nama Lengkap</th>
                        <th style="text-align:center;">Email</th>
                        <th style="text-align:center;">No Telepon</th>
                        <th style="text-align:center;">Username</th>
                        <th style="text-align:center;">Level</th>
                        <th style="text-align:center;">Active</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $nomor = 0;
                    if ($data) :
                        foreach ($data as $d) : ?>
                            <tr>
                                <td></td>
                                <td><?php echo $d['user_nama']; ?></td>
                                <td><?php echo $d['user_email']; ?></td>
                                <td><?php echo $d['user_no_telepon']; ?></td>
                                <td><?php echo $d['user_username']; ?></td>
                                <td><?php echo $d['level_title']; ?></td>
                                <td style="text-align:center;">
                                    <label class="switch">
                                        <?php if ($d['user_active']) : ?>
                                            <input type="checkbox" class="primary" checked="" onchange="switchActive('<?= $d['id_user']; ?>', 1)">
                                        <?php else : ?>
                                            <input type="checkbox" class="primary" onchange="switchActive('<?= $d['id_user']; ?>', 0)">
                                        <?php endif; ?>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td style="white-space:nowrap;">
                                    <a href="<?= $_baseurl; ?>&aksi=detail&id_user=<?php echo $d['id_user']; ?>" class="btn btn-sm btn-primary"><i class="fa fa-info-circle"></i> Detail</a>
                                    <a href="<?= $_baseurl; ?>&aksi=reset_password&id_user=<?php echo $d['id_user']; ?>" class="btn btn-sm btn-secondary"><i class="fa fa-key"></i> Reset Password</a>
                                    <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal-ubah" data-id_user="<?php echo $d['id_user']; ?>" data-id_level="<?php echo $d['id_level']; ?>" data-user_username="<?php echo $d['user_username']; ?>" data-user_email="<?php echo $d['user_email']; ?>" data-user_nama="<?php echo $d['user_nama']; ?>" data-user_alamat="<?php echo $d['user_alamat']; ?>" data-user_gender="<?php echo $d['user_gender']; ?>" data-user_tanggal_lahir="<?php echo $d['user_tanggal_lahir']; ?>" data-user_nik="<?php echo $d['user_nik']; ?>" data-user_no_telepon="<?php echo $d['user_no_telepon']; ?>" data-user_tanggal_daftar="<?php echo $d['user_tanggal_daftar']; ?>" data-user_foto_asal="<?php echo $d['user_foto']; ?>" onclick="ubahData(this)"><i class="fa fa-edit"></i> Ubah</button>

                                    <bottom class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-hapus" data-id_user="<?= $d['id_user']; ?>" data-user_nama="<?= $d['user_nama']; ?>" data-user_foto="<?= $d['user_foto']; ?>" onclick="hapusData(this)"><i class="fa fa-trash"></i> Hapus</bottom>
                                </td>
                            </tr>
                    <?php endforeach;
                    endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.card-body -->
</div>

<script>
    function switchActive(id_user, status) {
        window.location.href = `<?= $_baseurl; ?>&aksi=ganti_active&id_user=${id_user}&status=${status}`;
    }
</script>