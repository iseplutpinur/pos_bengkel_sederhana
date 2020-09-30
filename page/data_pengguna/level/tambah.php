<?php
if (isset($_POST['simpan-tambah'])) {
    $level = $_POST['level'];
    $sql = $koneksi->query("INSERT INTO `tb_user_level` (`id_level`, `level_title`) VALUES (NULL, '$level')");
    if ($sql)  echo '<script type = "text/javascript"> setAlert("Berhasil..! ", "Data berhasil ditambahkan..", "success");</script>';
    else echo '<script type = "text/javascript">setAlert("Gagal..! ", "Data gagal ditambahkan..", "danger");</script>';
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
                        <div class="form-group">
                            <label>Nama Level</label>
                            <input class="form-control" name="level" id="level">
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