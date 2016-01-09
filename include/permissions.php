<?php
	session_start();
	$permissions = $_SESSION['permissions'];
	$member = substr($permissions, 0, 1);
	$industry = substr($permissions, 1,1);
	$ceo = substr($permissions, 2, 1);
	$leadership = substr($permissions, 3, 1);
	$loggedIn = $_SESSION['loggedIn'];

?>