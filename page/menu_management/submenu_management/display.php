<?php
include 'tambah.php';
include 'ubah.php';
include 'hapus.php';
$querybuilder = "SELECT * FROM
                tb_user_sub_menu 
                INNER JOIN tb_user_menu 
                ON tb_user_sub_menu.id_menu = tb_user_menu.id_menu ORDER BY tb_user_sub_menu.id_submenu DESC";
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
                        <th style="text-align:center" width="25px">No</th>
                        <th style="text-align:center">Nama</th>
                        <th style="text-align:center">Menu</th>
                        <th style="text-align:center">Url</th>
                        <!-- <th style="text-align:center">file</th> -->
                        <th style="text-align:center" width="200px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $nomor = 0;
                    if ($data) :
                        foreach ($data as $d) : ?>
                            <tr>
                                <td><?= ++$nomor; ?></td>
                                <td style="white-space:nowrap"><?= $d['submenu_title']; ?></td>
                                <td style="white-space:nowrap"><?= $d['menu_title']; ?></td>
                                <td style="white-space:nowrap"><?= $d['submenu_url']; ?></td>
                                <!-- <td style="white-space:nowrap"><?= $d['submenu_file']; ?></td> -->
                                <td style="white-space:nowrap">
                                    <a href="<?= $_baseurl; ?>&aksi=hakakses&id=<?= $d['id_submenu']; ?>" class="btn btn-primary btn-sm"><i class="fa fa-folder"></i> Hak Akses</a>
                                    <?php if ($_settingDetail['pengembangan']['pengaturan_nilai']) : ?>
                                        <bottom class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-ubah" data-id_menu="<?= $d['id_menu']; ?>" data-submenu_title="<?= $d['submenu_title']; ?>" data-submenu_url="<?= $d['submenu_url']; ?>" data-id_submenu="<?= $d['id_submenu']; ?>" data-submenu_file="<?= $d['submenu_file']; ?>" onclick="ubahData(this)"><i class="fa fa-edit"></i> Ubah</bottom>
                                        <bottom class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-hapus" data-id_submenu="<?= $d['id_submenu']; ?>" data-submenu_title="<?= $d['submenu_title']; ?>" onclick="hapusData(this)"><i class="fa fa-trash"></i> Hapus</bottom>
                                    <?php endif; ?>
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