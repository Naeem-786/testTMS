<?php 
	session_start();
	session_unset();
	session_destroy();

	// redirecting the user to the login page
	header('Location: ./signin.php');

 ?>