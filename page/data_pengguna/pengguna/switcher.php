<?php
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'detail') {
        include "detail.php";
    } else {
        include "display.php";
    }
} else {
    include "display.php";
}
