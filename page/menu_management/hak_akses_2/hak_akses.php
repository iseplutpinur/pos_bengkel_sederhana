<?php
$id_level = 0;
$level_title = "";
if (isset($_GET['id'])) {
    $id_level = $_GET['id'];

    // mengambil judul level
    $level_title = query("SELECT `level_title` FROM `tb_user_level` WHERE `id_level` = '$id_level'");

    // mengambil data untuk hak akses menu
    $menu_akses = query("SELECT * FROM `tb_user_menu`");

    // mengambil data untuk hak akses sub menu
    $sub_menu_akses = [];

    for ($i = 0; $i < count($menu_akses); $i++) {
        $id_menu = $menu_akses[$i]['id_menu'];
        $result = query("SELECT `id_menu` FROM `tb_user_menu_access` WHERE `tb_user_menu_access`.`id_menu` = '$id_menu' AND `tb_user_menu_access`.`id_level` = '$id_level'");
        if ($result) {
            $menu_akses[$i]['akses'] = true;
            $temp['hakakses'] = query("SELECT * FROM `tb_user_sub_menu`
            INNER JOIN `tb_user_menu`
            ON `tb_user_sub_menu`.`id_menu` = `tb_user_menu`.`id_menu`
            WHERE `tb_user_sub_menu`.`id_menu`='$id_menu'");
            if ($temp['hakakses']) {
                foreach ($temp['hakakses'] as $t) {
                    $sub_menu_akses[] = $t;
                }
            }
        } else $menu_akses[$i]['akses'] = false;
    }

    // mencari hak akses sub menu
    for ($i = 0; $i < count($sub_menu_akses); $i++) {
        $id_submenu = $sub_menu_akses[$i]['id_submenu'];
        $result = query("SELECT `id_submenu` FROM `tb_user_sub_menu_access` WHERE `tb_user_sub_menu_access`.`id_submenu` = '$id_submenu' AND `tb_user_sub_menu_access`.`id_level` = '$id_level'");
        if ($result) $sub_menu_akses[$i]['akses'] = true;
        else $sub_menu_akses[$i]['akses'] = false;
    }
} else {
    setAlert('Galat..! ', 'Tidak ada id yang dikirimkan..', 'danger');
    echo '
    <script type = "text/javascript">
        window.location.href = "' . $_baseurl . '";
    </script>
    ';
}

?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?php echo $menuactive['menu'] . " " . $menuactive['submenu']; ?></h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="container-fluid">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Hak Akses Menu level <b><?= $level_title[0]['level_title']; ?></b></h3>
                        </div> <!-- /.card-body -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="table2">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;" width="25px">No</th>
                                            <th style="text-align:center;">Menu</th>
                                            <th style="text-align:center;" width="50px">Hak Akses</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $nomor = 0;
                                        foreach ($menu_akses as $menu) : ?>
                                            <tr>
                                                <td style="text-align:center;"><?= ++$nomor; ?></td>
                                                <td><?= $menu['menu_title']; ?></td>
                                                <td style="text-align:center;">
                                                    <label class="switch">
                                                        <?php if ($menu['akses']) : ?>
                                                            <input type="checkbox" class="primary" checked="" onchange="gantiHakAksesMenu(<?= $menu['id_menu']; ?>, <?= $id_level; ?>, 1)">
                                                        <?php else : ?>
                                                            <input type="checkbox" class="primary" onchange="gantiHakAksesMenu(<?= $menu['id_menu']; ?>, <?= $id_level; ?>, 0)">
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
            </div>
            <div class="col-md-6">
                <div class="container-fluid">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Hak Akses SubMenu level <b><?= $level_title[0]['level_title']; ?></b></h3>
                        </div> <!-- /.card-body -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="table1">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;" width="25px">No</th>
                                            <th style="text-align:center;">Menu</th>
                                            <th style="text-align:center;">SubMenu</th>
                                            <th style="text-align:center;" width="50px">Hak Akses</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $nomor = 0;
                                        foreach ($sub_menu_akses as $sub_menu) : ?>
                                            <tr>
                                                <td style="text-align:center;">
                                                    <?php echo ++$nomor; ?>
                                                </td>
                                                <td>
                                                    <?php echo $sub_menu['menu_title']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $sub_menu['submenu_title']; ?>
                                                </td>
                                                <td style="text-align:center;">
                                                    <label class="switch">
                                                        <?php if ($sub_menu['akses']) : ?>
                                                            <input type="checkbox" class="primary" checked="" onchange="gantiHakAksesSubMenu(<?= $sub_menu['id_submenu']; ?>, <?= $id_level; ?>, 1)">
                                                        <?php else : ?>
                                                            <input type="checkbox" class="primary" onchange="gantiHakAksesSubMenu(<?= $sub_menu['id_submenu']; ?>, <?= $id_level; ?>, 0)">
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
            </div>
        </div>
    </div>
    <!-- /.card-body -->
</div>

<script>
    function gantiHakAksesMenu(id_menu, id_level, status) {
        window.location.href = `<?= $_baseurl; ?>&aksi=gantiakses&id_level=${id_level}&id_menu=${id_menu}&status=${status}&menu=menu`;
    }

    function gantiHakAksesSubMenu(id_menu, id_level, status) {
        window.location.href = `<?= $_baseurl; ?>&aksi=gantiakses&id_level=${id_level}&id_menu=${id_menu}&status=${status}&menu=submenu`;
    }

    $(document).ready(function() {
        $('#table2').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
        });
    });
</script>