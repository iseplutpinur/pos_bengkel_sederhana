<?php
session_start();
include "config.php";

$logindata = [
    'alert' => [
        'status'  => false,
        'color'   => 'danger',
        'title'   => '',
        'content' => ''
    ],
    'username' => '',
    'password' => ''
];

if (isset($_SESSION['admin']) || isset($_SESSION['user'])) {
    header("location:index.php");
} else if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $logindata['username'] = $_POST['username'];
    $logindata['password'] = $_POST['password'];

    $data = query("SELECT * FROM `tb_user` INNER JOIN `tb_user_level` ON `tb_user`.`id_level` = `tb_user_level`.`id_level` WHERE `user_username`='$username'");

    // cek apakah username ada atau tidak
    if ($data) {
        // cek apakah password yang dimasukan sesuai atau tidak
        if (password_verify($password, $data[0]['user_password'])) {
            // cek apakah akun tersebut aktiv atau tidak
            if ($data[0]['user_active']) {
                $_SESSION['user'] = [
                    'user_username' => $data[0]['user_username'],
                    'user_nama'     => $data[0]['user_nama'],
                    'user_password' => $data[0]['user_password'],
                    'user_foto'     => $data[0]['user_foto'],
                    'id_level'      => $data[0]['id_level'],
                    'id_user'       => $data[0]['id_user'],
                    'level_title'   => $data[0]['level_title']
                ];

                $_SESSION['alert']['title'] = "";
                $_SESSION['alert']['color'] = "";
                $_SESSION['alert']['show']  = false;
                header("location:index.php");
            } else {
                $logindata['alert'] = [
                    'status'  => true,
                    'color'   => 'danger',
                    'title'   => 'Gagal..! ',
                    'content' => 'Akun anda dinonaktifkan silahkan hubungi Administrator..'
                ];
            }
        } else {
            $logindata['alert'] = [
                'status'  => true,
                'color'   => 'danger',
                'title'   => 'Gagal..! ',
                'content' => 'Password yang anda masukan salah..'
            ];
        }
    } else {
        $logindata['alert'] = [
            'status'  => true,
            'color'   => 'danger',
            'title'   => 'Gagal..! ',
            'content' => 'Username yang anda masukan tidak terdaftar..'
        ];
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
            <a href="assets/index2.html"><b>Toko</b>MUS</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <?php if ($logindata['alert']['status']) : ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-<?php echo $logindata['alert']['color']; ?> alert-dismissible show" role="alert">
                                <strong><?php echo $logindata['alert']['title']; ?></strong> <?php echo $logindata['alert']['content']; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <p class="login-box-msg">Silahkan untuk login</p>
                <form action="" method="post">
                    <div class="input-group mb-3">
                        <input type="username" class="form-control" placeholder="Username" name="username" value="<?php echo $logindata['username']; ?>">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group mb-2">
                            <input type="password" class="form-control" id="login-password-input" name="password" placeholder="Password" value="<?php echo $logindata['password']; ?>">
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