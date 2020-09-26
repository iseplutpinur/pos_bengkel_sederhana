<?php
// Databaase
// ===========================================================
// host database
$database_host = "localhost";
// username database
$database_user = "root";
// user password database
$database_pass = "";
// database name
$database_dbna = "db_pos_bengkel";

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
$tools['page_title'] = "PT. Agung Automall Jambi";

// default home page
$display_page = "page/home.php";

// default copyright
$tools['copyright'] = 2020;

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

function cekLogin($data = false)
{
    if ($data == false) return false;
    $id     = $data['id'];
    $result = query("SELECT * FROM `tb_user` WHERE id='$id'");
    if ($result) {
        if ($data['user'] == $result[0]['username'] && $data['pass'] == $result[0]['password']) {
            return true;
        } else return false;
    } else return false;
}


function getStokBarang($id)
{
    // barang masuk ========================================================
    $barang['masuk']['data'] = query("SELECT barang_masuk_jumlah FROM tb_barang_masuk WHERE tb_barang_masuk.id_barang_data = '$id'");
    $barang['masuk']['data'] = ($barang['masuk']['data']) ? $barang['masuk']['data'] : [];
    $barang['masuk']['jumlah'] = 0;
    foreach ($barang['masuk']['data'] as $b) {
        $barang['masuk']['jumlah'] += $b['barang_masuk_jumlah'];
    }
    // barang masuk ========================================================

    // barang masuk ========================================================
    $barang['keluar']['data'] = query("SELECT barang_keluar_jumlah FROM tb_barang_keluar WHERE tb_barang_keluar.id_barang_data = '$id'");
    $barang['keluar']['data'] = ($barang['keluar']['data']) ? $barang['keluar']['data'] : [];
    $barang['keluar']['jumlah'] = 0;
    foreach ($barang['keluar']['data'] as $b) {
        $barang['keluar']['jumlah'] += $b['barang_keluar_jumlah'];
    }
    // barang keluar ========================================================
    return $barang['masuk']['jumlah'] - $barang['keluar']['jumlah'];
}
