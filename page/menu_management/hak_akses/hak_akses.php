<?php
$temporary = [];
$id_level = 0;
if (isset($_GET['id'])) {
    $id_level = $_GET['id'];

    // mengambil judul level
    $temporary['level'] = query("SELECT `level_title` FROM `tb_user_level` WHERE `id_level` = '$id_level'");

    // mengambil data untuk hak akses menu
    $temporary['menu'] = query("SELECT * FROM `tb_user_menu`");

    // mengambil data untuk hak akses sub menu
    if ($temporary['menu']) {
        for ($i = 0; $i < count($temporary['menu']); $i++) {
            $id_menu = $temporary['menu'][$i]['id_menu'];

            // mencari hak akses menu
            $querybuilder = "SELECT `id_menu` FROM `tb_user_menu_access` WHERE `tb_user_menu_access`.`id_menu` = '$id_menu' AND `tb_user_menu_access`.`id_level` = '$id_level'";
            $temporary['menu'][$i]['access'] = (query($querybuilder)) ? true : false;

            // memasukan sub menu
            $querybuilder = "SELECT `id_submenu`, `submenu_title` FROM `tb_user_sub_menu` WHERE `id_menu`= '$id_menu'";
            $temporary['menu'][$i]['submenu'] = query($querybuilder);

            // mencari hak akses sub menu
            if ($temporary['menu'][$i]['submenu']) {
                for ($j = 0; $j < count($temporary['menu'][$i]['submenu']); $j++) {
                    $id_submenu = $temporary['menu'][$i]['submenu'][$j]['id_submenu'];
                    $querybuilder = "SELECT `id_submenu` FROM `tb_user_sub_menu_access` WHERE `tb_user_sub_menu_access`.`id_submenu` = '$id_submenu' AND `tb_user_sub_menu_access`.`id_level` = '$id_level'";
                    $temporary['menu'][$i]['submenu'][$j]['access'] = (query($querybuilder)) ? true : false;
                }
            }
        }
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
        <h3 class="card-title">Hak Akses Level <b><?= $temporary['level'][0]['level_title']; ?></b></h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-lg">
                <div class="container-fluid">
                    <form action="<?= $_baseurl; ?>&aksi=gantiakses" method="post">
                        <?php foreach ($temporary['menu'] as $_menu) : ?>
                            <div class="card card-primary card-outline d-flex justify-content-betwen">
                                <div class="card-header">
                                    <div class="m-0 p-0 flex-fill bd-highlight">
                                        <h3 class="card-title pt-1">Menu <b><?= $_menu['menu_title']; ?></b></h3>
                                    </div>
                                    <div class="m-0 p-0 flex-fill bd-highlight text-right">
                                        <label class="switch">
                                            <?php if ($_menu['access']) : ?>
                                                <input type="checkbox" class="primary" onchange="changeMenu<?php echo $_menu['id_menu'] ?>(this)" id="menu_<?php echo $_menu['id_menu']; ?>" checked="">
                                            <?php else : ?>
                                                <input type="checkbox" class="primary" onchange="changeMenu<?php echo $_menu['id_menu'] ?>(this)" id="menu_<?php echo $_menu['id_menu']; ?>">
                                            <?php endif; ?>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <input type="text" name="menu_<?php echo $_menu['id_menu']; ?>" hidden="">
                                </div> <!-- /.card-body -->
                                <?php if ($_menu['submenu']) { ?>
                                    <div class="card-body">
                                        <table class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="text-align:center;" width="25px">No</th>
                                                    <th style="text-align:center;">Nama Submenu</th>
                                                    <th style="text-align:center;" width="120px;">Hak Akses</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $nomor = 0;
                                                foreach ($_menu['submenu'] as $_submenu) { ?>
                                                    <tr>
                                                        <td style="text-align:center;">
                                                            <?php echo ++$nomor; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $_submenu['submenu_title']; ?>
                                                            <input type="text" name="submenu_<?php echo $_submenu['id_submenu']; ?>" hidden="">
                                                        </td>
                                                        <td>
                                                            <label class="switch">
                                                                <?php if ($_submenu['access']) : ?>
                                                                    <input type="checkbox" class="primary" id="submenu_<?php echo $_submenu['id_submenu']; ?>" onchange="changeSubMenu<?php echo $_submenu['id_submenu'] ?>(this)" checked="">
                                                                <?php else : ?>
                                                                    <input type="checkbox" class="primary" id="submenu_<?php echo $_submenu['id_submenu']; ?>" onchange="changeSubMenu<?php echo $_submenu['id_submenu'] ?>(this)">
                                                                <?php endif; ?>
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div><!-- /.card-body -->
                                <?php } ?>
                            </div>
                        <?php endforeach; ?>
                        <div class="row">
                            <div class="col-lg">
                                <button type="submit" name="simpan" class="btn btn-primary">Simpan Hak Akses</button>
                                <a href="<?php echo $_baseurl; ?>" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
</div>

<script>
    const menuaccess = {
        <?php if ($temporary['menu']) : ?>
            <?php foreach ($temporary['menu'] as $_menu) : ?>
                <?php echo $_menu['id_menu'] ?>: {
                    access: <?php echo ($_menu['access']) ? "true" : "false"; ?>,
                    submenu: {
                        <?php if ($_menu['submenu']) : ?>
                            <?php foreach ($_menu['submenu'] as $_submenu) : ?>
                                <?php echo $_submenu['id_submenu'] ?>: <?php echo ($_submenu['access']) ? "true" : "false"; ?>,
                            <?php endforeach; ?>
                        <?php endif; ?>
                    }
                },
            <?php endforeach; ?>
        <?php endif; ?>
    };

    <?php if ($temporary['menu']) {
        foreach ($temporary['menu'] as $_menu) { ?>

            function changeMenu<?php echo $_menu['id_menu'] ?>(data) {
                let input = document.querySelector("input[name=menu_<?php echo $_menu['id_menu']; ?>]");
                const data_asal = menuaccess["<?php echo $_menu['id_menu']; ?>"].access;
                if (data.checked == data_asal) {
                    input.value = "";
                } else {
                    const id_level = '<?php echo $id_level; ?>';
                    const id_menu = '<?php echo $_menu["id_menu"]; ?>';
                    const status = (data.checked) ? '1' : '0';
                    input.value = `${id_level}_${id_menu}_${status}`;
                }
            }

            <?php if ($_menu['submenu']) {
                foreach ($_menu['submenu'] as $_submenu) { ?>

                    function changeSubMenu<?php echo $_submenu['id_submenu'] ?>(data) {
                        let input = document.querySelector("input[name=submenu_<?php echo $_submenu['id_submenu']; ?>]");
                        const data_asal = menuaccess["<?php echo $_menu['id_menu']; ?>"].submenu["<?php echo $_submenu['id_submenu']; ?>"];

                        if (data.checked == data_asal) {
                            input.value = "";
                        } else {
                            const id_level = '<?php echo $id_level; ?>';
                            const id_submenu = '<?php echo $_submenu["id_submenu"]; ?>';
                            const status = (data.checked) ? '1' : '0';
                            input.value = `${id_level}_${id_submenu}_${status}`;
                        }
                    }

            <?php }
            } ?>

    <?php }
    } ?>
</script>