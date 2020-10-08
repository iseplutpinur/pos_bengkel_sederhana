<?php
// Databaase
// ===========================================================

// host database
$database_host = "127.0.0.1:3307";
// username database
$database_user = "root";
// user password database
$database_pass = "";
// database name
$database_dbna = "db_toko_mulya_utama_sejahtera";

$koneksi = mysqli_connect($database_host, $database_user, $database_pass, $database_dbna);


// fungsi query ke database
function query($query)
{
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        if ($result->num_rows > 0) {
            $rows = [];
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $rows[] = $row;
            }
            return $rows;
        } else return false;
    } else return false;
}


// ===========================================================
// query setting
$_settingApplication = query("SELECT * FROM tb_pengaturan");
// ===========================================================


// tools ======================================================
// Judul halaman
$tools['page_title'] = "Toko Mulya Utama Sejahtera";

// default home page
$display_page = "page/home.php";

// default copyright
$tools['copyright'] = date('yy');

// mode Ubah dan Delete Manajemen user
$tools['developer'] = true;

// print
$print = [];

// setting detail
$_settingDetail = [];

// tols from database
// ============================================================
foreach ($_settingApplication as $set) {
    $pengaturan = $set['pengaturan_title'];
    if ($pengaturan == 'laporan') {
        $_settingDetail['laporan'] = $set;
        $result = explode('$', $set['pengaturan_nilai']);
        $print['header'] = [
            'judul' => $result[0],
            'alamat' => $result[1]
        ];

        $print['footer'] = [
            'jabatan' => $result[2],
            'nama' => $result[3]
        ];
    } elseif ($pengaturan == 'nama_perusahaan') {
        $_settingDetail['nama_perusahaan'] = $set;
        $tools['page_title'] = $set['pengaturan_nilai'];
    } elseif ($pengaturan == 'tahuncopyright') {
        $_settingDetail['tahuncopyright'] = $set;
        $tools['copyright'] = $set['pengaturan_nilai'];
    } elseif ($pengaturan == 'default_home') {
        $_settingDetail['default_home'] = $set;
        $display_page = $set['pengaturan_nilai'];
    } elseif ($pengaturan == 'logo') {
        $_settingDetail['logo'] = $set;
        $tools['logo'] = $set['pengaturan_nilai'];
    } elseif ($pengaturan == 'pengembangan') {
        $_settingDetail['pengembangan'] = $set;
        $tools['pengembangan'] = $set['pengaturan_nilai'];
    }
}
// ============================================================
if (!$tools['pengembangan']) error_reporting(0);
// jangan dirubah <------
$temp['page']['title'] = false;
// --------------------->
//  ===========================================================

// mengecek apakah ada data get atau tidak
if (isset($_GET['page'])) $page = $_GET['page'];
else $page = "";

if (isset($_GET['submenu'])) $submenu = $_GET['submenu'];
else $submenu = "";

// mendefinisikan base url
$_baseurl = '?page=' . $page . '&submenu=' . $submenu;

function cekLogin()
{
    if (isset($_SESSION['user']['id_user']) && $_SESSION['user']['user_password']) {
        $id_user = $_SESSION['user']['id_user'];
        $result = query("SELECT `user_password`,`user_active` FROM `tb_user` WHERE id_user='$id_user'");
        if ($result) {
            if ($_SESSION['user']['user_password'] == $result[0]['user_password']) {
                if ($result[0]['user_active']) {
                    return true;
                } else return false;
            } else return false;
        } else return false;
    } else return false;
}
function setAlert($title = "", $conte = "", $color = "primary")
{
    $_SESSION['alert']['title'] = $title;
    $_SESSION['alert']['color'] = $color;
    $_SESSION['alert']['conte'] = $conte;
    $_SESSION['alert']['show'] = true;
}

function getAlert()
{
    $alert_color = $_SESSION['alert']['color'];
    $alert_title = $_SESSION['alert']['title'];
    $alert_conte = $_SESSION['alert']['conte'];

    echo 'setAlert("' . $alert_title . '", "' . $alert_conte . '", "' . $alert_color . '")';
    $_SESSION['alert']['show'] = false;
}
