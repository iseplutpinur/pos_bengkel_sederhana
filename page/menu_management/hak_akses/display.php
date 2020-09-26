<?php
$user_level = query("SELECT * FROM `tb_user_level`");
?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?php echo $menuactive['menu'] . " " . $menuactive['submenu']; ?></h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="table1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th style="text-align:center;" width="25px">No</th>
                    <th style="text-align:center;">Nama Level</th>
                    <th style="text-align:center;" width="150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $nomor = 0;
                foreach ($user_level as $u_level) : ?>
                    <tr>
                        <td style="text-align:center;">
                            <?php echo ++$nomor; ?>
                        </td>
                        <td>
                            <?php echo $u_level['level_title']; ?>
                        </td>
                        <td>
                            <a href="<?= $_baseurl; ?>&aksi=hakakses&id=<?= $u_level['id_level']; ?>" class="btn btn-primary btn-sm"><i class="fa fa-folder"></i> Hak Akses</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th style="text-align:center;" width="25px">No</th>
                    <th style="text-align:center;">Nama Level</th>
                    <th style="text-align:center;" width="120px;">Aksi</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <!-- /.card-body -->
</div>