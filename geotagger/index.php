<?php
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