<?php
if (isset($_POST['simpan'])) {
    $_menu    = query("SELECT `id_menu` FROM `tb_user_menu`");
    $_submenu = query("SELECT `id_submenu` FROM `tb_user_sub_menu`");

    $_status_operasi = true;

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

    // tambah hak akses menu;
    if ($_switcher['menu']['insert']) {
        $queribuilder = "";
        foreach ($_switcher['menu']['insert'] as $insert) {
            $id_level = $insert['id_level'];
            $id_menu  = $insert['id_menu'];

            if ($queribuilder == "") $queribuilder .= "INSERT INTO `tb_user_menu_access` (`id_menu`, `id_level`) VALUES ('$id_menu', '$id_level')";
            else $queribuilder .= ", ('$id_menu', '$id_level')";
        }
        $sql  = $koneksi->query($queribuilder);
        if (!$sql) $_status_operasi = false;
    }

    // hapus hak akses menu;
    if ($_switcher['menu']['delete']) {
        $_status      = true;
        foreach ($_switcher['menu']['delete'] as $delete) {
            $id_level     = $delete['id_level'];
            $id_menu      = $delete['id_menu'];
            $sql          = $koneksi->query("DELETE FROM `tb_user_menu_access` WHERE `tb_user_menu_access`.`id_menu` = '$id_menu' AND `tb_user_menu_access`.`id_level` = '$id_level'");
            if (!$sql) $_status = false;
        }
        if (!$_status) $_status_operasi = false;
    }



    // =============================================================
    // tambah hak akses submenu;
    if ($_switcher['submenu']['insert']) {
        $queribuilder = "";
        foreach ($_switcher['submenu']['insert'] as $insert) {
            $id_level    = $insert['id_level'];
            $id_submenu  = $insert['id_submenu'];

            if ($queribuilder == "") $queribuilder .= "INSERT INTO `tb_user_sub_menu_access` (`id_submenu`, `id_level`) VALUES ('$id_submenu', '$id_level')";
            else $queribuilder .= ", ('$id_submenu', '$id_level')";
        }
        $sql  = $koneksi->query($queribuilder);
        if (!$sql)  $_status_operasi = false;
    }

    // hapus hak akses menu;
    if ($_switcher['submenu']['delete']) {
        $_status      = true;
        foreach ($_switcher['submenu']['delete'] as $delete) {
            $id_level        = $delete['id_level'];
            $id_submenu      = $delete['id_submenu'];
            $sql             = $koneksi->query("DELETE FROM `tb_user_sub_menu_access` WHERE `tb_user_sub_menu_access`.`id_submenu` = '$id_submenu' AND `tb_user_sub_menu_access`.`id_level` = '$id_level'");
            if (!$sql) $_status = false;
        }
        if (!$_status)  $_status_operasi = false;
    }

    if ($_status_operasi) {
        setAlert('Berhasil..! ', 'Data berhasil diubah..', 'success');
        echo '
        <script type = "text/javascript">
            window.location.href = "' . $_baseurl . '&aksi=hakakses&id=' . $id_level . '";
        </script>
        ';
    } else {
        setAlert('Gagal..! ', 'Data gagal diubah..', 'danger');
        echo '
        <script type = "text/javascript">
            window.location.href = "' . $_baseurl . '&aksi=hakakses&id=' . $id_level . '";
        </script>
        ';
    }
}
