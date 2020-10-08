<?php
// ==========================================================================================================
session_start();
date_default_timezone_set("Asia/Jakarta");
include '../config.php';
if (!isset($_SESSION['user'])) {
    echo "<h1 style='text-align:center;'>
    Sistem Bermasalah silahkan untuk langsung logout terlebih dahulu kemudian login lagi,<br>
    Tombol <b style='color: #f00;'>Transaksi Baru</b> Jangan Ditekan..!,<br>
    mohon maaf untuk ketidaknyamanannya Terima kasih..</h1>";
    die;
}
$result = query("SELECT * FROM `tb_barang_keluar_data_sementara`");
$data = ($result) ? $result : [];
$total = ['qty' => 0, 'total_harga' => 0, 'total_diskon' => 0];

$_heder = [
    'no_trx'  => date('yymdhis'),
    'tanggal' => date('yy-m-d'),
    'kasir'   => $_SESSION['user']['user_nama'],
    'id_user' => $_SESSION['user']['id_user']
];
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
                <td>:</td>
                <td>TR<?php echo date('yymdhisu'); ?></td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td><?php echo date('yy-m-d  h:i'); ?></td>
            </tr>
            <tr>
                <td>Kasir</td>
                <td>:</td>
                <td><?php echo $_SESSION['user']['user_nama']; ?></td>
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
                $total['total_harga'] += ($d['barang_keluar_data_harga_asal'] * $d['barang_keluar_data_jumlah']);
                $total['total_diskon'] += ($d['barang_keluar_data_jumlah'] * abs($d['barang_keluar_data_harga'] - $d['barang_keluar_data_harga_asal']));
            ?>
                <tr>
                    <td colspan="4"><?= $d['barang_keluar_data_nama']; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-align:right"><?= $d['barang_keluar_data_jumlah']; ?></td>
                    <td style="text-align:right"><?= number_format($d['barang_keluar_data_harga_asal'], 0, ',', '.'); ?></td>
                    <td style="text-align:right"><?= number_format($d['barang_keluar_data_harga_asal'] * $d['barang_keluar_data_jumlah'], 0, ',', '.'); ?></td>
                </tr>
                <?php if ($d['barang_data_diskon'] > 0) : ?>
                    <tr>
                        <td></td>
                        <td>Diskon:</td>
                        <td style="text-align:right"><?= $d['barang_data_diskon']; ?>%</td>
                        <td style="text-align:right">-<?= number_format($d['barang_keluar_data_jumlah'] * abs($d['barang_keluar_data_harga'] - $d['barang_keluar_data_harga_asal']), 0, ',', '.'); ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
            <tr>
                <td colspan="5">
                    <hr>
                </td>
            </tr>
            <tr>
                <td>Total:</td>
                <td style="text-align:right"><?= $total['qty']; ?></td>
                <td></td>
                <td style="text-align:right"><?= number_format($total['total_harga'], 0, ',', '.'); ?></td>
            </tr>
            <?php if ($total['total_diskon'] != 0) : ?>
                <tr>
                    <td>Diskon:</td>
                    <td></td>
                    <td></td>
                    <td style="text-align:right">-<?= number_format($total['total_diskon'], 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td>Total Harga:</td>
                    <td></td>
                    <td></td>
                    <td style="text-align:right"><?= number_format($total['total_harga'] - $total['total_diskon'], 0, ',', '.'); ?></td>
                </tr>
            <?php endif; ?>
            <tr>
                <td>Tunai:</td>
                <td></td>
                <td></td>
                <td style="text-align:right"><?= number_format($_GET['bayar'], 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <td>Kembali:</td>
                <td></td>
                <td></td>
                <td style="text-align:right"><?= number_format($_GET['kembali'], 0, ',', '.'); ?></td>
            </tr>
        </table>
        <hr>
        <p style="text-align:left">Barang Yang Sudah Dibeli tidak dapat ditukar atau dikembalikan "TERIMA KASIH"</p>
    </div>
</body>

</html>