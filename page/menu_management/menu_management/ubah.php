<?php
if (isset($_POST['simpan-ubah'])) {
	$id_ubah    = $_POST['id_menu_ubah'];
	$menu_title = $_POST['menu_title_ubah'];
	$menu_icon  = $_POST['menu_icon_ubah'];
	$menu_url   = $_POST['menu_url_ubah'];
	$sql        = $koneksi->query("UPDATE `tb_user_menu` SET `menu_title` = '$menu_title', `menu_icon` = '$menu_icon', `menu_url` = '$menu_url' WHERE `tb_user_menu`.`id_menu` = '$id_ubah'");

	if ($sql) {
		echo '<script type = "text/javascript">setAlert("Berhasil..! ", "Data berhasil diubah..", "success");</script>';
	} else {
		echo '<script type = "text/javascript">setAlert("Gagal..! ", "Data gagal diubah..", "danger");</script>';
	}
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
					<input type="text" name="id_menu_ubah" value="" hidden="" required="">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Nama</label>
									<input class="form-control" name="menu_title_ubah" type="text" value="" required="">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Url</label>
									<input class="form-control" name="menu_url_ubah" type="text" value="" required="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Icon </label>
									<input class="form-control" name="menu_icon_ubah" type="text" value="" required="">
								</div>
							</div>
						</div>
					</div>
			</div>
			<div class="modal-footer justify-content-between">
				<input type="submit" name="simpan-ubah" value="Ubah" class="btn btn-primary">
				<button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
				</form>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<script type="text/javascript">
	function ubahData(data) {
		document.querySelector('input[name=id_menu_ubah]').value = data.dataset.id_menu;
		document.querySelector('input[name=menu_title_ubah]').value = data.dataset.menu_title;
		document.querySelector('input[name=menu_url_ubah]').value = data.dataset.menu_url;
		document.querySelector('input[name=menu_icon_ubah]').value = data.dataset.menu_icon;
	}
</script>