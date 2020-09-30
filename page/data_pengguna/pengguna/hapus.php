<?php
if (isset($_POST['simpan-hapus'])) {
	$id_user = $_POST['id_user_hapus'];
	$user_foto = $_POST['user_foto_hapus'];
	$koneksi->query("DELETE FROM `tb_user` WHERE `tb_user`.`id_user` = '$id_user'");

	if (mysqli_errno($koneksi) == 0) {
		if (file_exists("images/user_profile/$user_foto")) {
			unlink("images/user_profile/$user_foto");
		}
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
				<h4 class="modal-nama">Hapus Pengguna</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<h3 id="menu_nama_hapus"></h3>
			</div>
			<div class="modal-footer justify-content-between">
				<form method="POST">
					<input type="text" name="id_user_hapus" value="" hidden="">
					<input type="text" name="user_foto_hapus" value="" hidden="">
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
		document.querySelector('input[name=id_user_hapus]').value = data.dataset.id_user;
		document.querySelector('input[name=user_foto_hapus]').value = data.dataset.user_foto;
		document.querySelector('#menu_nama_hapus').innerHTML = `Apakah anda yakin akan menghapus Pengguna <b>${data.dataset.user_nama}</b>`;
	}
</script>