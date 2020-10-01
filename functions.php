<?php
function setAlert($title = "", $conte = "", $color = "primary")
{
	$_SESSION['alert']['title'] = $title;
	$_SESSION['alert']['color'] = $color;
	$_SESSION['alert']['conte'] = $conte;
	$_SESSION['alert']['show'] = true;
}

function getAlert()
{
	$alert_color = $_SESSION['alert']['color'];
	$alert_title = $_SESSION['alert']['title'];
	$alert_conte = $_SESSION['alert']['conte'];

	echo 'setAlert("' . $alert_title . '", "' . $alert_conte . '", "' . $alert_color . '")';
	$_SESSION['alert']['show'] = false;
}
