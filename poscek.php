<?php
include 'config.php';
// query menu dan submenu
if (isset($_POST['simpan'])) {
    $_menu = query("SELECT `id_menu` FROM `tb_user_menu`");
    $_submenu = query("SELECT `id_submenu` FROM `tb_user_sub_menu`");

    $_switcher = [
        'menu' => ['delete' => [], 'insert' => []],
        'submenu' => ['delete' => [], 'insert' => []],
    ];

    // mengisi array menu
    if ($_menu) {
        foreach ($_menu as $_m) {
            if (isset($_POST['menu_' . $_m['id_menu']])) {
                if ($_POST['menu_' . $_m['id_menu']] != '') {
                    $hakakses_temp = explode('_', $_POST['menu_' . $_m['id_menu']]);
                    if ($hakakses_temp[2]) {
                        $_switcher['menu']['insert'][] = [
                            'id_level' => $hakakses_temp[0],
                            'id_menu' => $hakakses_temp[1],
                        ];
                    } else {
                        $_switcher['menu']['delete'][] = [
                            'id_level' => $hakakses_temp[0],
                            'id_menu' => $hakakses_temp[1],
                        ];
                    }
                }
            }
        }
    }

    // mengisi array submenu
    if ($_submenu) {
        foreach ($_submenu as $_m) {
            if (isset($_POST['submenu_' . $_m['id_submenu']])) {
                if ($_POST['submenu_' . $_m['id_submenu']] != '') {
                    $hakakses_temp = explode('_', $_POST['submenu_' . $_m['id_submenu']]);
                    if ($hakakses_temp[2]) {
                        $_switcher['submenu']['insert'][] = [
                            'id_level' => $hakakses_temp[0],
                            'id_submenu' => $hakakses_temp[1],
                        ];
                    } else {
                        $_switcher['submenu']['delete'][] = [
                            'id_level' => $hakakses_temp[0],
                            'id_submenu' => $hakakses_temp[1],
                        ];
                    }
                }
            }
        }
    }

    // tambah hak akses menu cuma 1;
    if (count($_switcher['menu']['insert']) == 1) {
        $id_level = $_switcher['menu']['insert'][0]['id_level'];
        $id_menu  = $_switcher['menu']['insert'][0]['id_menu'];

        $sql  = $koneksi->query("INSERT INTO `tb_user_menu_access` (`id_menu`, `id_level`) VALUES ('$id_menu', '$id_level')");
        if ($sql) {
            echo '
            <script type = "text/javascript">
                alert("berhasil");
            </script>
            ';
        } else {
            echo '
            <script type = "text/javascript">
                alert("gagal");
            </script>
            ';
        }
    }

    // hapus hak akses menu cuma 1;
    if (count($_switcher['menu']['delete']) == 1) {
        $id_level = $_switcher['menu']['delete'][0]['id_level'];
        $id_menu  = $_switcher['menu']['delete'][0]['id_menu'];

        $sql  = $koneksi->query("DELETE FROM `tb_user_menu_access` WHERE `tb_user_menu_access`.`id_menu` = '$id_menu' AND `tb_user_menu_access`.`id_level` = '$id_level'");
        if ($sql) {
            echo '
            <script type = "text/javascript">
                alert("berhasil");
            </script>
            ';
        } else {
            echo '
            <script type = "text/javascript">
                alert("gagal");
            </script>
            ';
        }
    }
}
