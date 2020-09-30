<?php
if (isset($_POST['simpan-ubah'])) {
	$level_title = $_POST['level_title_ubah'];
	$id_level = $_POST['id_level_ubah'];
	$sql  = $koneksi->query("UPDATE `tb_user_level` SET `level_title` = '$level_title' WHERE `tb_user_level`.`id_level` = '$id_level'");

	if ($sql)  echo '<script type = "text/javascript"> setAlert("Berhasil..! ", "Data berhasil diubah..", "success");</script>';
	else echo '<script type = "text/javascript">setAlert("Gagal..! ", "Data gagal diubah..", "danger");</script>';
}
?>

<div class="modal fade" id="modal-ubah">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Ubah Menu</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST">
					<div class="container-fluid">
						<div class="form-group">
							<label>Nama Level</label>
							<input class="form-control" name="level_title_ubah">
							<input hidden="" name="id_level_ubah">
						</div>
					</div>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="submit" name="simpan-ubah" class="btn btn-primary">Ubah</button>
				</form>
				<button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<script type="text/javascript">
	function ubahData(data) {
		document.querySelector('input[name=id_level_ubah]').value = data.dataset.id_level;
		document.querySelector('input[name=level_title_ubah]').value = data.dataset.level_title;
	}
</script>