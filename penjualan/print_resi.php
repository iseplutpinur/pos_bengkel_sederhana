<?php
// ==========================================================================================================
session_start();
date_default_timezone_set("Asia/Jakarta");
include '../config.php';
if (!isset($_SESSION['user'])) {
    echo "<h1 style='text-align:center;'>
    Sistem Bermasalah silahkan untuk langsung logout terlebih dahulu kemudian login lagi,<br>
    Tombol <b style = 'color: #f00;'>Transaksi Baru</b> Jangan Ditekan..!, <br>
    mohon maaf untuk ketidaknyamanannya Terima kasih..</h1>";
    die;
}
$result = query("SELECT * FROM `tb_barang_keluar_data_sementara`");
$data   = ($result) ? $result : [];
$total  = ['qty' => 0, 'total_harga' => 0, 'total_diskon' => 0];

$no_trx  = $_GET['no_trx'];
$bnomor  = $_GET['no'];
$tanggal = date('yy-m-d');
$jam     = date('h:i:s');
$kasir   = $_SESSION['user']['user_nama'];
$id_user = $_SESSION['user']['id_user'];

// ==========================================================================================================
// Simpan data transaksi
$querybuilder = "INSERT INTO `tb_barang_keluar`
    (`id_barang_keluar`, `id_user`, `barang_keluar_kode_transaksi`, `barang_keluar_nomor`, `barang_keluar_tanggal`, `barang_data_waktu`)
    VALUES 
    (NULL, '$id_user', '$no_trx', '$bnomor', '$tanggal', '$jam')";
$koneksi->query($querybuilder);
// cek apakah query berhasil atau tidak
if (mysqli_errno($koneksi) != 0) {
    echo "<h1 style='text-align:center;'>
    Sistem Bermasalah silahkan untuk langsung hubungi petugas IT atau petugas terkait,<br>
    Tombol <b style = 'color: #f00;'>Transaksi Baru</b> Jangan Ditekan..!, <br>
    mohon maaf untuk ketidaknyamanannya Terima kasih..</h1>";
    die;
};

// mengambil id barang keluar untuk list baraung yang dibeli
$id_barang_keluar = query("SELECT MAX(`id_barang_keluar`) as `id` FROM `tb_barang_keluar`");
$id_barang_keluar = ($id_barang_keluar) ? $id_barang_keluar[0]['id'] : 1;


$querybuilder = "";
foreach ($result as $barang) {
    $id_barang_data                = $barang['id_barang_data'];
    $barang_data_diskon            = $barang['barang_data_diskon'];
    $barang_keluar_data_harga      = $barang['barang_keluar_data_harga'];
    $barang_keluar_data_jumlah     = $barang['barang_keluar_data_jumlah'];
    $barang_keluar_data_harga_asal = $barang['barang_keluar_data_harga_asal'];

    // mengurangi stok yang ada
    $_stok = query("SELECT `barang_data_stok` FROM `tb_barang_data` WHERE `id_barang_data` = '$id_barang_data'");
    $_stok = $_stok[0]['barang_data_stok'] - $barang_keluar_data_jumlah;
    $koneksi->query("UPDATE `tb_barang_data` SET `barang_data_stok` = '$_stok' WHERE `tb_barang_data`.`id_barang_data` = '$id_barang_data'");
    if (mysqli_errno($koneksi) != 0) {
        echo "<h1 style='text-align:center;'>
        Sistem Bermasalah silahkan untuk langsung hubungi petugas IT atau petugas terkait,<br>
        Tombol <b style = 'color: #f00;'>Transaksi Baru</b> Jangan Ditekan..!, <br>
        mohon maaf untuk ketidaknyamanannya Terima kasih..</h1>";
        die;
    };


    // memasukan data ke tabel barang keluar data 
    if ($querybuilder == "") {
        $querybuilder .= "INSERT INTO `tb_barang_keluar_data` 
            (`id_barang_keluar`, `id_barang_data`, `barang_keluar_data_diskon`, `barang_keluar_data_jumlah`, `barang_keluar_data_harga`, `barang_keluar_data_harga_asal`) 
            VALUES 
            ('$id_barang_keluar', '$id_barang_data', '$barang_data_diskon', '$barang_keluar_data_jumlah', '$barang_keluar_data_harga', '$barang_keluar_data_harga_asal')";
    } else $querybuilder .= ", ('$id_barang_keluar', '$id_barang_data', '$barang_data_diskon', '$barang_keluar_data_jumlah', '$barang_keluar_data_harga', '$barang_keluar_data_harga_asal')";
}

$koneksi->query($querybuilder);
// cek apakah query berhasil atau tidak
if (mysqli_errno($koneksi) != 0) {
    echo "<h1 style='text-align:center;'>
    Sistem Bermasalah silahkan untuk langsung hubungi petugas IT atau petugas terkait,<br>
    Tombol <b style = 'color: #f00;'>Transaksi Baru</b> Jangan Ditekan..!, <br>
    mohon maaf untuk ketidaknyamanannya Terima kasih..</h1>";
    die;
};


$koneksi->query("TRUNCATE `db_toko_mulya_utama_sejahtera`.`tb_barang_keluar_data_sementara`");
// ==========================================================================================================
?>

<html>

<head>
    <style>
        body {
            margin: 0;
            padding: 0;
            text-align: left;
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .print {
            padding: 2mm;
            width: 80mm;
            text-align: center;
            background-color: white;
            font: 9pt "Tahoma",
                "Helvetica";
            text-align: center;
        }

        th {
            padding: 7px;
        }

        td {

            padding: 7px
        }

        .ttd {
            float: right;
            text-align: center;
            margin-top: 10px;
        }

        table {
            padding: 0;
            border-collapse: collapse;
            margin: auto;
            background-color: #ffff;
            width: 100%;
            font: 9pt "Tahoma", "Helvetica";
        }

        table td,
        table th {
            text-align: left;
            margin: 0;
            padding: 0;
        }

        hr {
            padding: 0;
            border: 1px dashed #000;
        }

        p {
            padding: 0;
            margin: 0;
        }
    </style>
    <title>resi</title>
    <script>
        window.print();
    </script>
</head>

<body>
    <div class="print">
        <p>Toko Mulya Utama Sejahtera</p>
        <p>Sedia buku dan macam macam kebutuhan lainnya.</p>
        <p>Jl. Mekarwangi Cikadu Cianjur Jawa Barat 43271</p>
        <p>Tel: +6285789132505 E-mail: tokomus@gmail.com</p>
        <hr>
        <table>
            <tr>
                <td>No Trx</td>
                <td>: </td>
                <td><?php echo $no_trx ?></td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: </td>
                <td><?php echo $tanggal . " " . $jam; ?></td>
            </tr>
            <tr>
                <td>Kasir</td>
                <td>: </td>
                <td><?php echo $kasir; ?></td>
            </tr>
        </table>
        <hr>
        <table>
            <tr>
                <td style="text-align:left">Nama</td>
                <td style="text-align:center">Qty</td>
                <td style="text-align:center">Harga</td>
                <td style="text-align:center">Total</td>
            </tr>
            <?php foreach ($data as $d) :
                $total['qty']++;
                $total['total_harga']  += ($d['barang_keluar_data_harga_asal'] * $d['barang_keluar_data_jumlah']);
                $total['total_diskon'] += ($d['barang_keluar_data_jumlah'] * abs($d['barang_keluar_data_harga'] - $d['barang_keluar_data_harga_asal']));
            ?>
                <tr>
                    <td colspan="4">
                        <?= $d['barang_keluar_data_nama']; ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-align:right">
                        <?= $d['barang_keluar_data_jumlah']; ?>
                    </td>
                    <td style="text-align:right">
                        <?= number_format($d['barang_keluar_data_harga_asal'], 0, ',', '.'); ?>
                    </td>
                    <td style="text-align:right">
                        <?= number_format($d['barang_keluar_data_harga_asal'] * $d['barang_keluar_data_jumlah'], 0, ',', '.'); ?>
                    </td>
                </tr>
                <?php if ($d['barang_data_diskon'] > 0) : ?>
                    <tr>
                        <td></td>
                        <td>Diskon: </td>
                        <td style="text-align:right">
                            <?= $d['barang_data_diskon']; ?>%</td>
                        <td style="text-align:right">-
                            <?= number_format($d['barang_keluar_data_jumlah'] * abs($d['barang_keluar_data_harga'] - $d['barang_keluar_data_harga_asal']), 0, ',', '.'); ?>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
            <tr>
                <td colspan="5">
                    <hr>
                </td>
            </tr>
            <tr>
                <td>Total: </td>
                <td style="text-align:right">
                    <?= $total['qty']; ?>
                </td>
                <td></td>
                <td style="text-align:right">
                    <?= number_format($total['total_harga'], 0, ',', '.'); ?>
                </td>
            </tr>
            <?php if ($total['total_diskon'] != 0) : ?>
                <tr>
                    <td>Diskon: </td>
                    <td></td>
                    <td></td>
                    <td style="text-align:right">-
                        <?= number_format($total['total_diskon'], 0, ',', '.'); ?>
                    </td>
                </tr>
                <tr>
                    <td>Total Harga: </td>
                    <td></td>
                    <td></td>
                    <td style="text-align:right">
                        <?= number_format($total['total_harga'] - $total['total_diskon'], 0, ',', '.'); ?>
                    </td>
                </tr>
            <?php endif; ?>
            <tr>
                <td>Tunai: </td>
                <td></td>
                <td></td>
                <td style="text-align:right">
                    <?= number_format($_GET['bayar'], 0, ',', '.'); ?>
                </td>
            </tr>
            <tr>
                <td>Kembali: </td>
                <td></td>
                <td></td>
                <td style="text-align:right">
                    <?= number_format($_GET['kembali'], 0, ',', '.'); ?>
                </td>
            </tr>
        </table>
        <hr>
        <p style="text-align:left">Barang Yang Sudah Dibeli tidak dapat ditukar atau dikembalikan "TERIMA KASIH"</p>
    </div>
</body>

</html>