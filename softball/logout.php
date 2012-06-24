<?php
session_start();
require_once 'libs/utils.php';

if ((isset($_SESSION['auth'])) && ($_SESSION['auth'] == TRUE)){
	unset($_SESSION['auth']);
	$indexPage = getAppRoot($_SERVER['PHP_SELF']);
	headerLocation($indexPage);
}

?>