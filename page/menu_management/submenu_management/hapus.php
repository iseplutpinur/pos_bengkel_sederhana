<?php
if (isset($_POST['simpan-hapus'])) {
	$id_menu = $_POST['id_submenu_hapus'];
	$koneksi->query("DELETE FROM `tb_user_sub_menu` WHERE `tb_user_sub_menu`.`id_submenu` = '$id_menu'");

	if (mysqli_errno($koneksi) == 0) {
		echo '<script type = "text/javascript">setAlert("Berhasil..! ", "Data berhasil dihapus..", "success");</script>';
	} else {
		echo '<script type = "text/javascript">setAlert("Gagal..! ", "Data gagal dihapus..", "danger");</script>';
	}
}
?>

<div class="modal fade" id="modal-hapus" style="display: none;" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content bg-danger">
			<div class="modal-header">
				<h4 class="modal-title">Hapus SubMenu</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<h3 id="menu_title_hapus"></h3>
			</div>
			<div class="modal-footer justify-content-between">
				<form method="POST">
					<input type="text" name="id_submenu_hapus" value="" hidden="">
					<button type="submit" class="btn btn-outline-light" name="simpan-hapus">Hapus</button>
				</form>
				<button type="button" class="btn btn-outline-light" data-dismiss="modal">Kembali</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<script>
	function hapusData(data) {
		document.querySelector('input[name=id_submenu_hapus]').value = data.dataset.id_submenu;
		document.querySelector('#menu_title_hapus').innerHTML = `Apakah anda yakin akan menghapus submenu <b>${data.dataset.submenu_title}</b>`;
	}
</script>