<?php
include '../config.php';
if (isset($_GET['id_barang']) && isset($_GET['diskon'])) {
    $id_barang = $_GET['id_barang'];
    $diskon_barang = $_GET['diskon'];
    $querybuilder = "DELETE FROM `tb_barang_keluar_data_sementara` WHERE `id_barang_data` = '$id_barang' AND `barang_data_diskon` = '$diskon_barang'";
    $koneksi->query($querybuilder);
    header('location:index.php');
}
