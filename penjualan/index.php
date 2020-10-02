<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include '../config.php';
$_data = [
    'id_barang'   => '',
    'barcode'     => '',
    'nama_barang' => '',
    'harga_asal'  => '',
    'total_bayar' => 0,
    'stok'        => 0,
];

if (isset($_POST['cari'])) {
    $_barcode = $_POST['barcode'];
    $result   = query("SELECT * FROM `tb_barang_data` WHERE `barang_data_kode` = '$_barcode'");
    if ($result) {
        $_data['id_barang']   = $result[0]['id_barang_data'];
        $_data['barcode']     = $result[0]['barang_data_kode'];
        $_data['nama_barang'] = $result[0]['barang_data_nama'];
        $_data['harga_asal']  = $result[0]['barang_data_harga_jual'];
        $_data['stok']        = $result[0]['barang_data_stok'];
    }
}


if (isset($_POST['tambah'])) {
    if ($_POST['id_barang'] != "") {
        $jumlah      = $_POST['jumlah'];
        $id_barang   = $_POST['id_barang'];
        $nama_barang = $_POST['nama_barang'];
        $harga_jual  = $_POST['harga_jual'];
        $stok_barang = $_POST['stok_barang'];

        $result = query("SELECT * FROM `tb_barang_data` WHERE `barang_data_kode` = '$jumlah'");
        if ($result) {
            $_data['id_barang']   = $result[0]['id_barang_data'];
            $_data['barcode']     = $result[0]['barang_data_kode'];
            $_data['nama_barang'] = $result[0]['barang_data_nama'];
            $_data['harga_asal']  = $result[0]['barang_data_harga_jual'];
            $_data['stok']        = $result[0]['barang_data_stok'];
            $jumlah = 1;
        }

        if ($jumlah <= $stok_barang) {
            $querybuilder = "INSERT INTO `tb_barang_keluar_data_sementara`
                (`id_barang_data`, `barang_keluar_data_nama`, `barang_keluar_data_jumlah`, `barang_keluar_data_harga`)
                VALUES
                ('$id_barang', '$nama_barang', '$jumlah', '$harga_jual')";
            $koneksi->query($querybuilder);
        } else {
            setAlert('Peringatan ', 'Jumlah barang tidak boleh melebihi stok..', 'Danger');
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penjualan</title>
    <link rel="stylesheet" href="assets/bootstrap-4.4.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
</head>
<div class="container-fluid pt-3">
    <div class="row">
        <div class="col-lg"><a href="reset.php" class="btn btn-danger btn-md btn-block font-weight-bold" id="btn_transaksi_baru">Transaksi Baru <i class="fas fa-shopping-cart"></i><i class="fas fa-shopping-cart"></i><i class="fas fa-shopping-cart"></i></a></div>
    </div>
</div>
<div class="container-fluid pt-3">
    <div class="row">
        <div class="col-md-7 py-2">
            <div class="row">
                <div class="col-lg-2">
                    <label for="kode_transaksi" class="col-form-label">Kode Transaksi</label>
                </div>
                <div class="col-lg-10">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" name="kode_transaksi" id="kode_transaksi" readonly="" value="TR<?php echo date('yymdhis'); ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2">
                    <label for="barcode-input" class="col-form-label">Barcode</label>
                </div>
                <div class="col-lg-10">
                    <form method="post">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" name="barcode" id="barcode-input">
                            <div class="input-group-append">
                                <button class="btn btn-danger btn-sm" name="cari" type="submit"><i class="fas fa-search"></i> Cari</button>
                                <button class="btn btn-primary btn-sm" type="reset"><i class="fas fa-sync-alt"></i> Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-5 py-2">
            <div class="row">
                <div class="col-lg-2">
                    <label for="tanggal" class="col-form-label">Tanggal Transaksi</label>
                </div>
                <div class="col-lg-10">
                    <div class="input-group">
                        <input type="date" class="form-control form-control-sm" name="tanggal" id="tanggal" readonly="" value="<?php echo date('yy-m-d'); ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2">
                    <label for="user" class="col-form-label">Kasir</label>
                </div>
                <div class="col-lg-10">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" name="user" id="user" readonly="" value="<?php echo $_SESSION['user']['user_nama']; ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<hr>




<form method="post">
    <table style="margin:auto; width:98%;">
        <tr>
            <td><label for="barcode" class="font-weight-bold">ID Barang</label></td>
            <td><label for="nama_barang" class="font-weight-bold">Nama Barang</label></td>
            <td><label for="stok_barang" class="font-weight-bold">Stok</label></td>
            <td><label for="harga_asal" class="font-weight-bold">Harga Asal</label></td>
            <td><label for="harga_jual" class="font-weight-bold">Harga Jual</label></td>
            <td style="width:100px"><label for="jumlah" class="font-weight-bold">Jumlah</label></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <div class="form-group">
                    <input type="text" class="form-control form-control-sm" id="barcode" name="barcode" readonly="" value="<?= $_data['barcode']; ?>">
                    <input type="text" id="id_barang" name="id_barang" value="<?= $_data['id_barang']; ?>" hidden="">
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="text" class="form-control form-control-sm" id="nama_barang" name="nama_barang" readonly="" value="<?= $_data['nama_barang']; ?>">
                </div>
            </td>
            <td>
                <div class="form-group">
                    <?php if ($_data['stok'] == 0) : ?>
                        <input type="number" class="form-control form-control-sm" id="stok_barang" name="stok_barang" readonly="">
                    <?php else : ?>
                        <input type="number" class="form-control form-control-sm" id="stok_barang" name="stok_barang" value="<?= $_data['stok']; ?>" readonly="">
                    <?php endif; ?>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="text" class="form-control form-control-sm" id="harga_asal" name="harga_asal" readonly="" value="<?= $_data['harga_asal']; ?>">
                </div>
            </td>
            <td>
                <div class="form-group">
                    <?php if ($_data['id_barang'] == '') : ?>
                        <input type="text" class="form-control form-control-sm" id="harga_jual" name="harga_jual" readonly="">
                    <?php else : ?>
                        <input type="text" class="form-control form-control-sm" id="harga_jual" name="harga_jual" value="<?= $_data['harga_asal']; ?>">
                    <?php endif; ?>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <?php if ($_data['id_barang'] == '') : ?>
                        <input type="text" class="form-control form-control-sm" id="jumlah" name="jumlah" readonly="">
                    <?php else : ?>
                        <input type="text" class="form-control form-control-sm" id="jumlah" name="jumlah" value="1" required="" min="1">
                    <?php endif; ?>
                </div>
            </td>
            <td style="white-space:nowrap">
                <div class="form-group">
                    <button class="btn btn-success btn-sm" name="tambah" type="submit">Tambah <i class="far fa-paper-plane"></i></button>
                    <button class="btn btn-danger btn-sm" type="reset">Batal <i class="fas fa-times"></i></button>
                </div>
            </td>
        </tr>
    </table>
</form>


<form method="post">
    <table class="table" style="width:98%; margin:auto">
        <thead>
            <tr>
                <th class="py-1" width="20px">No</th>
                <th class="py-1">Nama Barang</th>
                <th class="py-1">Harga Barang</th>
                <th class="py-1" width="50px">Jumlah</th>
                <th class="py-1">Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $datastruk = query("SELECT * FROM `tb_barang_keluar_data_sementara`");
            $no = 0;
            if ($datastruk) {
                foreach ($datastruk as $struk) { ?>
                    <tr>
                        <td class="py-1"><?php echo ++$no; ?></td>
                        <td class="py-1"><?php echo $struk['barang_keluar_data_nama']; ?></td>
                        <td class="py-1 text-right"><?php echo 'Rp. ' . number_format($struk['barang_keluar_data_harga'], 0, ',', '.'); ?></td>
                        <td class="py-1 text-right"><?php echo $struk['barang_keluar_data_jumlah']; ?></td>
                        <td class="py-1 text-right"><?php echo 'Rp. ' . number_format($struk['barang_keluar_data_harga'] * $struk['barang_keluar_data_jumlah'], 0, ',', '.'); ?></td>
                    </tr>
            <?php
                    $_data['total_bayar'] += $struk['barang_keluar_data_harga'] * $struk['barang_keluar_data_jumlah'];
                }
            } ?>

        </tbody>
        <tfooter>
            <tr>
                <th class="py-1"></th>
                <th class="py-1"></th>
                <th class="py-1">Total Bayar</th>
                <th class="py-1"></th>
                <th class="py-1 text-right"><?php echo 'Rp. ' . number_format($_data['total_bayar'], 0, ',', '.'); ?></th>
            </tr>
            <tr>
                <th colspan="2" class="py-1">
                    <div class="form-group py-0 my-0">
                        <button class="btn btn-success btn-sm my-0  mr-5" name="cetak" type="submit"><i class="fas fa-print"></i> Cetak</button>
                        <button class="btn btn-danger btn-sm my-0" type="button" onclick="transaksiBaru()"><i class="fas fa-trash-alt"></i> Batal</button>
                    </div>
                </th>
                <th colspan="3" class="py-1">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="font-weight-normal" for="bayar">Bayar:</label>
                                <input type="number" class="form-control form-control-sm my-0" id="bayar" name="bayar" value="0">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="font-weight-normal" for="kembali">Kembali:</label>
                                <input type="number" class="form-control form-control-sm my-0" id="kembali" name="kembali" value="0" readonly="">
                            </div>
                        </div>
                    </div>
                </th>
            </tr>
        </tfooter>
    </table>
</form>
<hr>

<body>
    <script href="assets/uncomprees-jquery-3.4.1.js"></script>
    <script href="assets/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>
    <script>
        document.querySelector('#barcode-input').focus();
        const totalbayar = '<?php echo $_data['total_bayar']; ?>';
        const hitungPembayaran = () => {
            let kembali = document.querySelector('#kembali');
            const bayar = document.querySelector('#bayar');
            kembali.value = (Number(bayar.value) - Number(totalbayar));

        }
        bayar.addEventListener('keyup', () => {
            hitungPembayaran();
        });
        bayar.addEventListener('click', () => {
            hitungPembayaran();
        });

        function transaksiBaru() {
            document.querySelector('#btn_transaksi_baru').click();
        }


        // cek apakah jumlah ada isinya atau tidak kalau ada maka akan di focus
        let jumlah = document.querySelector('#jumlah');
        if (jumlah.value != "") {
            jumlah.focus();
            jumlah.select();
        }
    </script>
</body>

</html>