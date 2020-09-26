<div class="card">
    <div class="card-header d-flex justify-content-betwen">
        <div class="p-1 flex-fill bd-highlight">
            <h3 class="card-title"><?php echo $menuactive['menu'] . " " . $menuactive['submenu']; ?></h3>
        </div>
        <div class="p-1 flex-fill bd-highlight text-right">
            <?php if ($_settingDetail['pengembangan']['pengaturan_nilai']) : ?>
                <a href="<?= $_baseurl; ?>&aksi=tambah" class="btn btn-success btn-sm m-0"><i class="fa fa-plus"></i> Tambah Data</a>
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
                    $data = query("SELECT * FROM tb_user_menu ORDER BY id_menu DESC");
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
                                        <a href="<?= $_baseurl; ?>&aksi=ubah&id=<?= $d['id_menu']; ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Ubah</a>
                                        <a onclick="return confirm('Anda yakin ingin menghapus?')" href="<?= $_baseurl; ?>&aksi=hapus&id=<?= $d['id_menu']; ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</a>
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