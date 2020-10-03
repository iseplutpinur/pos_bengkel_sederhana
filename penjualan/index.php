<?php
// ==========================================================================================================
session_start();
date_default_timezone_set("Asia/Jakarta");
include '../config.php';
// ==========================================================================================================

// ==========================================================================================================
$_data = [
    'id_barang'   => '',
    'barcode'     => '',
    'nama_barang' => '',
    'harga_asal'  => '',
    'total_bayar' => 0,
    'stok'        => 0,
    'diskon'      => 0,
];
// ==========================================================================================================


// ==========================================================================================================
// Nomor transaksi
$_number_transaksi = query("SELECT MAX(`barang_keluar_nomor`) as `nomor` FROM `tb_barang_keluar` WHERE `barang_keluar_tanggal` = '2020-10-03'");
// ==========================================================================================================


// ==========================================================================================================
$_belanja = ['no' => 0, 'total' => 0, 'bayar' => 0, 'kembali' => 0];
if (isset($_POST['total-jumlah']) && ((isset($_POST['total-jumlah'])) ? $_POST['total-jumlah'] : 0) > 0) {
    $_belanja['no'] = intval($_POST['total-jumlah']);
    $_belanja['total'] = intval($_POST['total']);
    $_belanja['bayar'] = intval($_POST['bayar']);
    $_belanja['kembali'] = intval($_POST['kembali']);
}
// ==========================================================================================================


// ==========================================================================================================
if (isset($_POST['cari'])) {
    $_barcode = $_POST['barcode'];
    $result   = query("SELECT * FROM `tb_barang_data` WHERE `barang_data_kode` = '$_barcode'");
    if ($result) {
        $_data['id_barang']   = $result[0]['id_barang_data'];
        $_data['barcode']     = $result[0]['barang_data_kode'];
        $_data['nama_barang'] = $result[0]['barang_data_nama'];
        $_data['harga_asal']  = $result[0]['barang_data_harga_jual'];
        $_data['stok']        = $result[0]['barang_data_stok'];
        $_data['diskon']      = $result[0]['barang_data_diskon'];
    }
}
// ==========================================================================================================


// ==========================================================================================================
if (isset($_POST['tambah'])) {
    if ($_POST['id_barang'] != "") {
        $jumlah        = $_POST['jumlah'];
        $id_barang     = $_POST['id_barang'];
        $diskon_barang = ($_POST['diskon_barang'] == "") ? 0 : $_POST['diskon_barang'];
        $nama_barang   = $_POST['nama_barang'];
        $harga_jual    = $_POST['harga_jual'];
        $harga_asal    = $_POST['harga_asal'];
        $stok_barang   = $_POST['stok_barang'];

        $result = query("SELECT * FROM `tb_barang_data` WHERE `barang_data_kode` = '$jumlah'");
        if ($result) {
            $_data['id_barang']   = $result[0]['id_barang_data'];
            $_data['barcode']     = $result[0]['barang_data_kode'];
            $_data['nama_barang'] = $result[0]['barang_data_nama'];
            $_data['harga_asal']  = $result[0]['barang_data_harga_jual'];
            $_data['stok']        = $result[0]['barang_data_stok'];
            $_data['diskon']      = $result[0]['barang_data_diskon'];
            $jumlah = 1;
        }

        if ($jumlah <= $stok_barang) {
            $lama = query("SELECT `barang_keluar_data_jumlah` FROM `tb_barang_keluar_data_sementara` WHERE `id_barang_data` = '$id_barang' AND `barang_data_diskon` = '$diskon_barang'");
            if ($lama) {
                $total = $jumlah + $lama[0]['barang_keluar_data_jumlah'];
                $querybuilder = "UPDATE `tb_barang_keluar_data_sementara` SET `barang_keluar_data_jumlah` = '$total' WHERE `id_barang_data` = '$id_barang' AND `barang_data_diskon` = '$diskon_barang'";
                $koneksi->query($querybuilder);
            } else {
                $querybuilder = "INSERT INTO `tb_barang_keluar_data_sementara`
                (`id_barang_data`, `barang_keluar_data_nama`, `barang_data_diskon`, `barang_keluar_data_jumlah`, `barang_keluar_data_harga`, `barang_keluar_data_harga_asal`)
                VALUES
                ('$id_barang', '$nama_barang', '$diskon_barang', '$jumlah', '$harga_jual', '$harga_asal')";
                $koneksi->query($querybuilder);
            }
        } else {
            setAlert('Peringatan ', 'Jumlah barang tidak boleh melebihi stok..', 'danger');
        }
    }
}
// ==========================================================================================================
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Penjualan</title>
    <link rel="stylesheet" href="assets/bootstrap-4.4.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
</head>

<body>
    <?php if ($_belanja['no'] > 0) {
        if ($_belanja['bayar'] >= $_belanja['total']) {
            echo '<div hidden="">';
        }
    } ?>
    <!-- ================================================================================================ -->
    <!-- Header page -->
    <div class="container-fluid pt-3">
        <div class="row" id="alert_display"></div>
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg"><a href="reset.php" class="btn btn-danger btn-md btn-block font-weight-bold" id="btn_transaksi_baru">Transaksi Baru <i class="fas fa-shopping-cart"></i><i class="fas fa-shopping-cart"></i><i class="fas fa-shopping-cart"></i></a></div>
        </div>
    </div>
    <!-- ================================================================================================ -->

    <!-- ================================================================================================ -->
    <!-- Header main -->
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
    <!-- ================================================================================================ -->

    <!-- ================================================================================================ -->
    <!-- Hasil pencarian data barang berdasarkan barcode  -->
    <form method="post">
        <table style="margin:auto; width:98%;">
            <tr>
                <td><label for="barcode" class="font-weight-bold">ID Barang</label></td>
                <td><label for="nama_barang" class="font-weight-bold">Nama Barang</label></td>
                <td><label for="stok_barang" class="font-weight-bold">Diskon</label></td>
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
                        <input type="number" id="stok_barang" name="stok_barang" value="<?= $_data['stok']; ?>" hidden="">
                        <?php if ($_data['diskon'] == 0) : ?>
                            <input type="number" step="0.01" class="form-control form-control-sm" id="diskon_barang" name="diskon_barang" readonly="">
                        <?php else : ?>
                            <input type="number" step="0.01" class="form-control form-control-sm" id="diskon_barang" name="diskon_barang" value="<?= $_data['diskon']; ?>" onkeyup="diskonUbah()" onclick="diskonUbah()" max="100" min="0">
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
                            <input type="number" step="0.01" class="form-control form-control-sm" id="harga_jual" name="harga_jual" readonly="">
                        <?php else : ?>
                            <input type="number" step="0.01" class="form-control form-control-sm" id="harga_jual" name="harga_jual" value="<?= $_data['harga_asal'] - (($_data['harga_asal'] / 100) * $_data['diskon']); ?>" onkeyup="hargaJualUbah()" onclick="hargaJualUbah()" min="0" max="<?= $_data['harga_asal']; ?>">
                        <?php endif; ?>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <?php if ($_data['id_barang'] == '') : ?>
                            <input type="number" class="form-control form-control-sm" id="jumlah" name="jumlah" readonly="">
                        <?php else : ?>
                            <input type="number" class="form-control form-control-sm" id="jumlah" name="jumlah" value="1" required="" min="1">
                        <?php endif; ?>
                    </div>
                </td>
                <td style="white-space:nowrap">
                    <div class="form-group">
                        <button class="btn btn-success btn-sm" name="tambah" type="submit">Tambah <i class="far fa-paper-plane"></i></button>
                        <button class="btn btn-danger btn-sm" onclick="transaksiBatal()" type="button">Batal <i class="fas fa-times"></i></button>
                    </div>
                </td>
            </tr>
        </table>
    </form>
    <!-- ================================================================================================ -->

    <!-- ================================================================================================ -->
    <!-- Hasil scaner sebelum menjadi resi -->
    <form method="post">
        <table class="table table-hover table-striped" style="width:98%; margin:auto">
            <thead>
                <tr>
                    <th class="py-1" width="20px">No</th>
                    <th class="py-1">Nama Barang</th>
                    <th class="py-1 text-right" width="50px">Diskon</th>
                    <th class="py-1 text-right" width="200px">Harga Barang</th>
                    <th class="py-1" width="50px">Jumlah</th>
                    <th class="py-1 text-right">Total Harga</th>
                    <th class="py-1 text-center" width="100px">Aksi</th>
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
                            <td class="py-1 text-right"><?php echo ($struk['barang_data_diskon'] < 1) ? "" : $struk['barang_data_diskon'] . "%"; ?></td>
                            <td class="py-1 text-right"><?php echo 'Rp. ' . number_format($struk['barang_keluar_data_harga'], 0, ',', '.'); ?></td>
                            <td class="py-1 text-right"><?php echo $struk['barang_keluar_data_jumlah']; ?></td>
                            <td class="py-1 text-right"><?php echo 'Rp. ' . number_format($struk['barang_keluar_data_harga'] * $struk['barang_keluar_data_jumlah'], 0, ',', '.'); ?></td>
                            <td class="py-1 text-center">
                                <button class="btn btn-sm btn-danger" type="button" name="hapus-struk" onclick="hapusStruk('<?php echo $struk['id_barang_data']; ?>', '<?php echo $struk['barang_data_diskon']; ?>')">Hapus <i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                <?php
                        $_data['total_bayar'] += $struk['barang_keluar_data_harga'] * $struk['barang_keluar_data_jumlah'];
                    }
                } ?>

            </tbody>
            <tfooter>
                <tr class="bg-white">
                    <th class="py-1"></th>
                    <th class="py-1"></th>
                    <th class="py-1"></th>
                    <th class="py-1 text-right">Total Bayar</th>
                    <th class="py-1"></th>
                    <th class="py-1 text-right">
                        <input type="text" name="total" value="<?php echo $_data['total_bayar']; ?>" hidden="">
                        <input type="text" name="total-jumlah" value="<?php echo $no; ?>" hidden="">
                        <?php echo 'Rp. ' . number_format($_data['total_bayar'], 0, ',', '.'); ?>
                    </th>
                    <th class="py-1"></th>
                </tr>
                <tr class="bg-white">
                    <th colspan="3" class="py-1">
                        <div class="form-group py-0 my-0">
                            <button class="btn btn-success btn-sm my-0  mr-5" name="cetak" type="submit"><i class="fas fa-print"></i> Cetak</button>
                            <button class="btn btn-danger btn-sm my-0" type="button" onclick="transaksiBaru()"><i class="fas fa-trash-alt"></i> Batal</button>
                        </div>
                    </th>
                    <th colspan="4" class="py-1">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="font-weight-normal" for="bayar">Bayar:</label>
                                    <input type="number" class="form-control form-control-sm my-0" id="bayar" name="bayar" value="<?= $_belanja['bayar']; ?>">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="font-weight-normal" for="kembali">Kembali:</label>
                                    <input type="number" class="form-control form-control-sm my-0" id="kembali" name="kembali" value="<?= $_belanja['kembali']; ?>" readonly="">
                                </div>
                            </div>
                        </div>
                    </th>
                </tr>
            </tfooter>
        </table>
    </form>
    <hr>
    <!-- ================================================================================================ -->

    <!-- ================================================================================================ -->
    <!-- script plugin tambahan -->
    <script href="assets/uncomprees-jquery-3.4.1.js"></script>
    <script href="assets/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>
    <!-- ================================================================================================ -->

    <!-- ================================================================================================ -->
    <!-- Script Secript Pendukung -->
    <script>
        document.querySelector('#barcode-input').focus();
        const totalbayar = '<?php echo $_data['total_bayar']; ?>';
        const harga_asal = '<?php echo $_data['harga_asal']; ?>';

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

        // membatalkan transaksi
        function transaksiBatal() {
            let harga_jual = document.querySelector('input[name=harga_jual]');
            let jumlah = document.querySelector('input[name=jumlah]');
            let diskon_barang = document.querySelector('#diskon_barang');
            document.querySelector('#barcode').value = "";
            document.querySelector('input[name=id_barang]').value = "";
            document.querySelector('input[name=nama_barang]').value = "";
            document.querySelector('input[name=harga_asal]').value = "";

            harga_jual.setAttribute('readonly', '');
            jumlah.setAttribute('readonly', '');
            diskon_barang.setAttribute('readonly', '');
            harga_jual.value = "";
            jumlah.value = "";
            diskon_barang.value = "";

            document.querySelector('#barcode-input').focus();
        }



        // cek apakah jumlah ada isinya atau tidak kalau ada maka akan di focus
        let jumlah = document.querySelector('#jumlah');
        if (jumlah.value != "") {
            jumlah.focus();
            jumlah.select();
        }

        function diskonUbah() {
            let diskon_barang = document.querySelector('#diskon_barang');
            let harga_jual = document.querySelector('input[name=harga_jual]');
            harga_jual.value = Number(harga_asal) - ((Number(harga_asal) / 100) * Number(diskon_barang.value));
        }

        function hargaJualUbah() {
            let diskon_barang = document.querySelector('#diskon_barang');
            let harga_jual = document.querySelector('input[name=harga_jual]');
            const diskon = (Number(harga_asal) - Number(harga_jual.value)) * (100 / Number(harga_asal));
            diskon_barang.value = diskon;

            if (diskon_barang.readOnly) {
                diskon_barang.removeAttribute('readonly');
                diskon_barang.setAttribute('onclick', 'diskonUbah()');
                diskon_barang.setAttribute('onkeyup', 'diskonUbah()');
            }
        }

        function hapusStruk(id, diskon) {
            window.location.href = `hapus_transaksi.php?id_barang=${id}&diskon=${diskon}`;
        }
    </script>
    <!-- ================================================================================================ -->

    <!-- ================================================================================================ -->
    <!-- Script pembantu untu print kwetansi -->
    <?php
    if ($_belanja['no'] > 0) {
        if ($_belanja['bayar'] >= $_belanja['total']) {
            echo '
            </div>
            <div class="container-fluid  pt-3">
                <div class="row">
                    <div class="col-lg"><a href="reset.php" class="btn btn-danger btn-md btn-block font-weight-bold" id="btn_transaksi_baru">Transaksi Baru <i class="fas fa-shopping-cart"></i><i class="fas fa-shopping-cart"></i><i class="fas fa-shopping-cart"></i></a></div>
                </div>
            </div>';
            echo '<iframe src="print_resi.php?bayar=' . $_belanja['bayar'] . '&kembali=' . $_belanja['kembali'] . '&" frameborder="0" allowfullscreen style="width:100%;height:50vh;"></iframe>';
        } else {
            echo "
                <script>
                const bayar_print = document.querySelector('#bayar');
                 bayar_print.focus();
                 bayar_print.select();
                </script>
            ";
        }
    }
    ?>
    <!-- ================================================================================================ -->
</body>

</html>