<?php
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'detail') {
        include "detail.php";
    } else if ($_GET['aksi'] == 'ubah') {
        include "ubah.php";
    } else if ($_GET['aksi'] == 'hapus') {
        include "hapus.php";
    } else {
        include "display.php";
    }
} else {
    include "display.php";
}
