<?php
$id = $_SESSION['user']['id_user'];
$data = query("SELECT * FROM tb_user WHERE tb_user.id_user='$id'");
?>
<div class="container-fluid text-center">
    <center>
        <h3 size="+3" face="arial">Selamat Datang <?= $data[0]['user_nama']; ?></h3>
    </center>
    <img class="img-fluid" src="images/background/bg.jpg" alt="">
</div>