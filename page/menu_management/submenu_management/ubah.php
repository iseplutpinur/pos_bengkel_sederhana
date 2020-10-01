<?php
if (isset($_POST['simpan-ubah'])) {
    $submenu_title = $_POST['submenu_title_ubah'];
    $file          = $_POST['submenu_file_ubah'];
    $url           = strtolower(str_replace(' ', '_', $_POST['submenu_url_ubah']));
    $id_menu       = $_POST['id_menu_ubah'];
    $id_submenu    = $_POST['id_submenu_ubah'];

    $sql = $koneksi->query("UPDATE `tb_user_sub_menu` SET 
              `id_menu`       = '$id_menu',
              `submenu_title` = '$submenu_title',
              `submenu_url`   = '$url',
              `submenu_file`  = '$file'
        WHERE `tb_user_sub_menu`.`id_submenu` = '$id_submenu'");

    if ($sql) {
        echo '<script type = "text/javascript">setAlert("Berhasil..! ", "Data berhasil diubah..", "success");</script>';
    } else {
        echo '<script type = "text/javascript">setAlert("Gagal..! ", "Data gagal diubah..", "danger");</script>';
    }
}
?>


<div class="modal fade" id="modal-ubah">
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
                                    <input class="form-control" name="submenu_title_ubah" type="text">
                                    <input name="id_submenu_ubah" type="text" hidden>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Menu</label>
                                    <select class="form-control" name="id_menu_ubah">
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
                                    <input class="form-control" name="submenu_url_ubah" type="text">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Lokasi File </label>
                                    <input class="form-control" name="submenu_file_ubah" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="submit" name="simpan-ubah" class="btn btn-primary">Ubah</button>
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
        document.querySelector('select[name=id_menu_ubah]').value = data.dataset.id_menu;
        document.querySelector('input[name=id_submenu_ubah]').value = data.dataset.id_submenu;
        document.querySelector('input[name=submenu_title_ubah]').value = data.dataset.submenu_title;
        document.querySelector('input[name=submenu_url_ubah]').value = data.dataset.submenu_url;
        document.querySelector('input[name=submenu_file_ubah]').value = data.dataset.submenu_file;
    }
</script>