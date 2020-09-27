<?php
$id_sub_menu = 0;
if (isset($_GET['id'])) {
    $id_sub_menu = $_GET['id'];
    // mengambil data untuk judul
    $menu_title = query("SELECT `submenu_title` FROM `tb_user_sub_menu` WHERE `id_submenu`='$id_sub_menu'");

    // mengambil data untuk hak akses
    $user_level = query("SELECT * FROM `tb_user_level`");
    for ($i = 0; $i < count($user_level); $i++) {
        $user_level_id = $user_level[$i]['id_level'];
        $result        = query("SELECT * FROM `tb_user_sub_menu_access` WHERE `tb_user_sub_menu_access`.`id_submenu` = '$id_sub_menu' AND `tb_user_sub_menu_access`.`id_level` = '$user_level_id'");

        if ($result) $user_level[$i]['akses'] = true;
        else $user_level[$i]['akses']         = false;;
    }
} else {
    setAlert('Gagal..! ', 'Data gagal ditampilkan..', 'danger');
    echo '
    <script type = "text/javascript">
        window.location.href = "' . $_baseurl . '";
    </script>
    ';
}

?>
<div class="container-fluid">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Hak Akses SubMenu <b><?= $menu_title[0]['submenu_title']; ?></b></h3>
        </div> <!-- /.card-body -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="table1">
                    <thead>
                        <tr>
                            <th style="text-align:center;" width="25px">No</th>
                            <th style="text-align:center;">Level</th>
                            <th style="text-align:center;" width="100px">Hak Akses</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $nomor = 0;
                        foreach ($user_level as $menu) : ?>
                            <tr>
                                <td style="text-align:center;"><?= ++$nomor; ?></td>
                                <td><?= $menu['level_title']; ?></td>
                                <td style="text-align:center;">
                                    <label class="switch">
                                        <?php if ($menu['akses']) : ?>
                                            <input type="checkbox" class="primary" checked="" onchange="gantiHakAkses('<?= $menu['id_level']; ?>', '<?= $id_sub_menu; ?>', 1)">
                                        <?php else : ?>
                                            <input type="checkbox" class="primary" onchange="gantiHakAkses('<?= $menu['id_level']; ?>', '<?= $id_sub_menu; ?>', 0)">
                                        <?php endif; ?>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div><!-- /.card-body -->
    </div>
</div>


<script>
    function gantiHakAkses(id_level, id_menu, status) {
        window.location.href = `<?= $_baseurl; ?>&aksi=gantiakses&id_level=${id_level}&id_menu=${id_menu}&status=${status}`;
    }
</script>