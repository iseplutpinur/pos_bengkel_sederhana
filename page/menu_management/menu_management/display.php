<?php
// modal
include 'tambah.php';
include 'ubah.php';
include 'hapus.php';
$data = query("SELECT * FROM tb_user_menu ORDER BY id_menu DESC");
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
                        <th width="25px">No</th>
                        <th>Nama</th>
                        <th>Url</th>
                        <th>Icon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $nomor = 0;
                    if ($data) :
                        foreach ($data as $d) : ?>
                            <tr>
                                <td style="white-space: nowrap;"><?= ++$nomor; ?></td>
                                <td style="white-space: nowrap;"><?= $d['menu_title']; ?></td>
                                <td style="white-space: nowrap;"><?= $d['menu_url']; ?></td>
                                <td style="white-space: nowrap;"><?= $d['menu_icon']; ?></td>
                                <td style="white-space: nowrap;">
                                    <a href="<?= $_baseurl; ?>&aksi=hakakses&id=<?= $d['id_menu']; ?>" class="btn btn-primary btn-sm"><i class="fa fa-folder"></i> Hak Akses</a>
                                    <?php if ($_settingDetail['pengembangan']['pengaturan_nilai']) : ?>
                                        <bottom class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-ubah" data-id_menu="<?= $d['id_menu']; ?>" data-menu_title="<?= $d['menu_title']; ?>" data-menu_url="<?= $d['menu_url']; ?>" data-menu_icon="<?= $d['menu_icon']; ?>" onclick="ubahData(this)"><i class="fa fa-edit"></i> Ubah</bottom>
                                        <bottom class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-hapus" data-id_menu="<?= $d['id_menu']; ?>" data-menu_title="<?= $d['menu_title']; ?>" onclick="hapusData(this)"><i class="fa fa-trash"></i> Hapus</bottom>
                                    <?php endif; ?>
                                </td>
                            </tr>
                    <?php endforeach;
                    endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>