<?php
	session_start();
	unset($_SESSION['session_phone']);
	session_destroy();
	header("location:index.php");
	?>
