<?php
if (isset($_POST['simpan-tambah'])) {
    $submenu_title = $_POST['submenu_title'];
    $submenu_file  = $_POST['submenu_file'];
    $submenu_url   = $_POST['submenu_url'];
    $id_menu       = $_POST['id_menu'];

    $sql = $koneksi->query("INSERT INTO `tb_user_sub_menu` (`id_submenu`, `id_menu`, `submenu_title`, `submenu_url`, `submenu_file`) VALUES (NULL, '$id_menu', '$submenu_title', '$submenu_url', '$submenu_file')");
    if ($sql) {
        echo '<script type = "text/javascript">setAlert("Berhasil..! ", "Data berhasil ditambahkan..", "success");</script>';
    } else {
        echo '<script type = "text/javascript">setAlert("Gagal..! ", "Data gagal ditambahkan..", "danger");</script>';
    }
}
?>

<div class="modal fade" id="modal-tambah">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Menu</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input class="form-control" name="submenu_title" type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Menu</label>
                                    <select class="form-control" name="id_menu">
                                        <?php foreach (query("SELECT * FROM tb_user_menu") as $d) : ?>
                                            <option value='<?= $d['id_menu']; ?>'>
                                                <?= $d['menu_title']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Url</label>
                                    <input class="form-control" name="submenu_url" type="text">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Lokasi File </label>
                                    <input class="form-control" name="submenu_file" type="text">
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