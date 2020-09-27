<?php
$password = "admin";
$_hash = password_hash($password, PASSWORD_DEFAULT);
var_dump($_hash);
var_dump(password_verify($password, $_hash));
