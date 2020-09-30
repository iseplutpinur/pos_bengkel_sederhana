<?php
include 'tambah.php';
include 'ubah.php';
include 'hapus.php';
$user_level = query("SELECT * FROM `tb_user_level`");
?>
<div class="card">
    <div class="card-header">
        <div class="mt-3 flex-fill bd-highlight">
            <h3 class="card-title"><?php echo $menuactive['menu'] . " " . $menuactive['submenu']; ?></h3>
        </div>
        <div class="mb-3 flex-fill bd-highlight text-right">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-tambah"><i class="fa fa-plus"></i> Tambah Data</button>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="table1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th style="text-align:center;" width="25px">No</th>
                    <th style="text-align:center;">Nama Level</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $nomor = 0;
                foreach ($user_level as $u_level) : ?>
                    <tr>
                        <td style="text-align:center;">
                            <?php echo ++$nomor; ?>
                        </td>
                        <td>
                            <?php echo $u_level['level_title']; ?>
                        </td>
                        <td style="white-space:nowrap">
                            <bottom class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-ubah" data-level_title="<?= $u_level['level_title']; ?>" data-id_level="<?= $u_level['id_level']; ?>" onclick="ubahData(this)"><i class="fa fa-edit"></i> Ubah</bottom>
                            <bottom class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-hapus" data-id_level="<?= $u_level['id_level']; ?>" data-level_title="<?= $u_level['level_title']; ?>" onclick="hapusData(this)"><i class="fa fa-trash"></i> Hapus</bottom>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th style="text-align:center;" width="25px">No</th>
                    <th style="text-align:center;">Nama Level</th>
                    <th style="text-align:center;" width="120px;">Aksi</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <!-- /.card-body -->
</div>