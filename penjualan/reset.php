<?php
include '../config.php';
$koneksi->query("TRUNCATE `db_toko_mulya_utama_sejahtera`.`tb_barang_keluar_data_sementara`");
if ($koneksi) {
    header('location:index.php');
} else {
    echo "Sistem mengalami kegagalan silahkan hubungi developer";
}
