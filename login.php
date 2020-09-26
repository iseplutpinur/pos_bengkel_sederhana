<?php
session_start();
include "config.php";
if (isset($_SESSION['admin']) || isset($_SESSION['user'])) {
    header("location: index.php");
} else if (isset($_POST['login'])) {
    $nama = $_POST['username'];
    $pass = $_POST['password'];
    $data = query("SELECT * FROM `tb_user` INNER JOIN `tb_user_level` ON `tb_user`.`id_level` = `tb_user_level`.`id_level` WHERE `username`='$nama' AND `password`='$pass'");

    if ($data) {
        $_SESSION['user'] = [
            'user'        => $data[0]['username'],
            'nama'        => $data[0]['nama'],
            'pass'        => $data[0]['password'],
            'foto'        => $data[0]['foto'],
            'level'       => $data[0]['id_level'],
            'level_title' => $data[0]['title'],
            'id'          => $data[0]['id']
        ];

        $_SESSION['alert']['title'] = "";
        $_SESSION['alert']['color'] = "";
        $_SESSION['alert']['show']  = false;

        header("location:index.php");
    } else {
        echo '
        <script type = "text/javascript">
            alert("Username dan Password Anda Salah");
        </script>
    ';
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="user.ico">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="assets/index2.html"><b>Bengkel</b>POS</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Silahkan untuk login</p>
                <form action="" method="post">
                    <div class="input-group mb-3">
                        <input type="username" class="form-control" placeholder="Username" name="username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group mb-2">
                            <input type="password" class="form-control" id="login-password-input" name="password" placeholder="Password">
                            <div class="input-group-append" id="login-password-icon">
                                <div class="input-group-text"><span class="far fa-eye-slash"></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="assets/dist/js/adminlte.min.js"></script>
    <script>
        $('#login-password-icon').on('click', () => {
            let login_password_input = $('#login-password-input');
            let login_password_icon = $('#login-password-icon');
            if (login_password_input.attr('type') == 'password') {
                login_password_input.attr('type', 'text');
                login_password_icon.html('<div class="input-group-text"><span class="far fa-eye"></span></div>');
            } else if (login_password_input.attr('type') == 'text') {
                login_password_input.attr('type', 'password');
                login_password_icon.html('<div class="input-group-text"><span class="far fa-eye-slash"></span></div>');
            }
        });
    </script>
</body>

</html>