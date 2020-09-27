<?php
if (isset($_POST['simpan-tambah'])) {
    $nama = $_POST['menu_nama_tambah'];
    $icon = $_POST['menu_icon_tambah'];
    $url  = $_POST['menu_url_tambah'];

    $sql  = $koneksi->query("INSERT INTO `tb_user_menu` (`id_menu`, `menu_title`, `menu_icon`, `menu_url`) VALUES (NULL, '$nama', '$icon', '$url')");
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input class="form-control" name="menu_nama_tambah" type="text" required="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Url</label>
                                    <input class="form-control" name="menu_url_tambah" type="text" required="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Icon </label>
                                    <input class="form-control" name="menu_icon_tambah" type="text" required="">
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