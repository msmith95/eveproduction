<?php
	if($_GET['action'] == "logout"){
		header('Location: http://www.newelementgaming.net/eve/index.php');
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    	);
		session_start();
		session_unset();
		session_destroy();
	}
?>