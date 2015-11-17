<?php

define('OFFSET_PATH', 3);
require_once(dirname(dirname(dirname(__FILE__))) . '/zp-core/admin-globals.php');
require_once('functions.php');

if (!zp_loggedin(MANAGE_ALL_ALBUM_RIGHTS)) {
	header("HTTP/1.0 403 " . gettext("Forbidden"));
	return;
}

if (isset($_GET["action"]))
{
	drawResults();
}
else if (isset($_POST["images"]))
{
	processRequest();
}
else
{
	require_once('form.php');
}
?>