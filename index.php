<?php
session_start();
include "config.php";
include "functions.php";
// ============================================================
// cek apakah user sudah login altau belum
if (!ceklogin($_SESSION['user'])) header('Location:login.php');

// Mengambil data untuk menu navigasi
$menuactive = [
    'menu' => '',
    'submenu' => ''
];

$level  = $_SESSION['user']['id_level'];
$menus  = query("SELECT * FROM tb_user_menu_access 
        INNER JOIN tb_user_menu 
        ON    tb_user_menu_access.id_menu  = tb_user_menu.id_menu
        WHERE tb_user_menu_access.id_level = '$level'
");

if ($menus) {
    for ($i = 0; $i < count($menus); $i++) {
        $id = $menus[$i]['id_menu'];

        // Mengambil data untuk sub menu
        $menus[$i]['submenu'] = query("SELECT * FROM tb_user_sub_menu_access 
            INNER JOIN tb_user_sub_menu 
            ON    tb_user_sub_menu_access.id_submenu   = tb_user_sub_menu.id_submenu
            WHERE tb_user_sub_menu_access.id_level = '$level'
            AND tb_user_sub_menu.id_menu='$id'
        ");

        // Mempersiapkan navigasi active dan display
        $menus[$i]['active'] = false;
        if ($menus[$i]['submenu']) {
            for ($j = 0; $j < count($menus[$i]['submenu']); $j++) {

                // menggabungkan url menu dan sub menu supaya bisa di akses
                $menus[$i]['submenu'][$j]['url_act'] = "?page=" . $menus[$i]['menu_url'] . "&submenu=" . $menus[$i]['submenu'][$j]['submenu_url'];

                // mencari menu dan sub menu navigasi active
                if ($menus[$i]['menu_url'] . $menus[$i]['submenu'][$j]['submenu_url'] == ($page . $submenu)) {
                    $display_page                        = $menus[$i]['submenu'][$j]['submenu_file'];
                    $menus[$i]['submenu'][$j]['active']  = true;
                    $menus[$i]['active']                 = true;
                    $temp['page']['title']               = $menus[$i]['submenu'][$j]['submenu_title'];
                    $menuactive['menu']                  = $menus[$i]['menu_title'];
                    $menuactive['submenu']               = $menus[$i]['submenu'][$j]['submenu_title'];
                } else {
                    $menus[$i]['submenu'][$j]['active'] = false;
                }
            }
            $menus[$i]['visible'] = true;
        } else {
            $menus[$i]['visible'] = false;
            $menus[$i]['active'] = false;
        }
    }
}
// ============================================================
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title><?= $tools['page_title']; ?></title>

    <link rel="icon" href="user.ico">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">

    <link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- jQuery -->
    <script src="assets/plugins/jquery/jquery.min.js"></script>

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <span class="nav-link">Login As: <?= $_SESSION['user']['level_title']; ?> | <span id="clockTopbar"></span></span>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="" class="brand-link">
                <img src="user.ico" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Toko MUS</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="assets/images/user_profile/<?= $_SESSION['user']['user_foto']; ?>" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?= $_SESSION['user']['user_nama']; ?></a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- dashboard active -->
                        <?php if ($page === "") : ?>
                            <li class="nav-item active">
                                <a href="index.php" class="nav-link active">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Dashboard</p>
                                </a>
                            </li>
                            <!-- dashboard nonactive -->
                        <?php else : ?>
                            <li class="nav-item">
                                <a href="index.php" class="nav-link">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Dashboard</p>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if ($menus) {
                            // menentukan menu dan sub menu yang active
                            foreach ($menus as $menu) {
                                if ($menu['visible']) {
                                    // jika menu active
                                    if ($menu['active']) {
                                        echo '
                                            <li class="nav-item has-treeview menu-open">
                                            <a href="#" class="nav-link active">
                                                <i class="nav-icon ' . $menu["menu_icon"] . '"></i>
                                                <p>
                                                ' . $menu["menu_title"] . '
                                                    <i class="right fas fa-angle-left"></i>
                                                </p>
                                            </a>
                                            <ul class="nav nav-treeview">
                                            ';
                                    } else {
                                        echo '
                                            <li class="nav-item has-treeview">
                                            <a href="#" class="nav-link">
                                                <i class="nav-icon ' . $menu["menu_icon"] . '"></i>
                                                <p>
                                                ' . $menu["menu_title"] . '
                                                    <i class="fas fa-angle-left right"></i>
                                                </p>
                                            </a>
                                            <ul class="nav nav-treeview">
                                            ';
                                    }

                                    // daftar sub menu
                                    if ($menu['submenu']) {
                                        foreach ($menu['submenu'] as $nav_submenu) {
                                            if ($nav_submenu['active']) {
                                                echo '
                                                <li class="nav-item">
                                                    <a href="' . $nav_submenu['url_act'] . '" class="nav-link active">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>' . $nav_submenu['submenu_title'] . '</p>
                                                    </a>
                                                </li>
                                                ';
                                            } else {
                                                echo '
                                                <li class="nav-item">
                                                    <a href="' . $nav_submenu['url_act'] . '" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>' . $nav_submenu['submenu_title'] . '</p>
                                                    </a>
                                                </li>
                                                ';
                                            }
                                        }
                                    }

                                    // tag tutup ul
                                    echo '</ul>';
                                    echo '</li>';
                                }
                            }
                        } ?>

                        <li class="nav-item">
                            <a href="logout.php" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Sign Out</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <?php if ($menuactive['menu'] != "") : ?>
                                <div class="col-sm-6">
                                    <h1 class="m-0 text-dark"><?php echo $menuactive['submenu']; ?></h1>
                                </div><!-- /.col -->
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-right">
                                        <li class="breadcrumb-item"><?php echo $menuactive['menu']; ?></li>
                                        <li class="breadcrumb-item active"><?php echo $menuactive['submenu']; ?></li>
                                    </ol>
                                </div><!-- /.col -->
                            <?php else : ?>
                                <div class="col-sm-6">
                                    <h1 class="m-0 text-dark">Dashboard</h1>
                                </div><!-- /.col -->
                            <?php endif; ?>
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
            </section>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- ================================================= -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- ================================================= -->
                            <!-- Alert -->
                            <div class="row" id="alert_display">
                            </div>
                            <script>
                                function setAlert(alert_title = 'hide_alert', alert_content = "", alert_color = 'succes', alert_location = '#alert_display') {
                                    if (alert_title == 'hide_alert') {
                                        document.querySelector(alert_location).innerHTML = '';
                                    } else {
                                        document.querySelector(alert_location).innerHTML = `
                                    <div class="col-md-12">
                                    <div class="alert alert-${alert_color} alert-dismissible show" role="alert">
                                    <strong>${alert_title}</strong>  ${alert_content}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    </div>
                                    `;
                                    }
                                }
                                <?php if ($_SESSION['alert']['show']) getAlert(); ?>
                            </script>
                            <!-- ================================================= -->
                            <?php
                            if (file_exists($display_page)) include $display_page;
                            else include "page/error.php";
                            ?>
                        </div>
                    </div>
                    <!-- ================================================= -->
                </div>
                <!--/. container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; <?php echo $tools['copyright']; ?> <a href=""><?php echo $tools['page_title']; ?></a>.</strong>
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- Bootstrap -->
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="assets/dist/js/adminlte.js"></script>

    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/clock.js"></script>
    <script>
        $(document).ready(function() {
            let tabel1 = $('#table1').DataTable({
                "columnDefs": [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                }],
                "order": [
                    [1, 'asc']
                ]
            });

            tabel1.on('order.dt search.dt', function() {
                tabel1.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
            <?php if ($temp['page']['title']) echo "document.title = '" . $temp['page']['title'] . " | " . $tools['page_title'] . "';" ?>
        });
    </script>
</body>

</html>