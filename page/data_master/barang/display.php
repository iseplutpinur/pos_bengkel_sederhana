<?php
$querybuilder = "SELECT * FROM tb_barang_data 
                INNER JOIN tb_barang_kategori 
                ON 
                tb_barang_data.id_barang_kategori = tb_barang_kategori.id_barang_kategori";
$data = query($querybuilder);

?>

<div class="card">
    <div class="card-header d-flex justify-content-betwen">
        <div class="p-2 flex-fill bd-highlight">
            <h3 class="card-title"><?php echo $menuactive['menu'] . " " . $menuactive['submenu']; ?></h3>
        </div>
        <div class="p-1 flex-fill bd-highlight text-right">
            <a href="<?php echo $_baseurl; ?>&aksi=tambah" class="btn btn-primary btn-sm">Tambah</a>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="table1">
                <thead>
                    <tr>
                        <th width="25px">No</th>
                        <th>Nama</th>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>Stok</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $nomor = 0;
                    if ($data) :
                        foreach ($data as $d) : ?>
                            <tr>
                                <td><?php echo $nomor; ?></td>
                                <td><?php echo $d['barang_data_nama']; ?></td>
                                <td><?php echo $d['barang_data_kode']; ?></td>
                                <td><?php echo $d['barang_data_tanggal']; ?></td>
                                <td><?php echo $d['barang_data_stok']; ?></td>
                                <td><?php echo $d['barang_kategori_nama']; ?></td>
                                <td></td>
                            </tr>
                    <?php endforeach;
                    endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>