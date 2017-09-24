<?php
	include '../utils/functions.php';

	$db = new adps_functions();
	// $db->sec_session_start(); // Our custom secure way of starting a PHP session.

	if (isset($_POST['username'], $_POST['password'])) {
	  $username = $_POST['username'];
	  $password = $_POST['password']; // The hashed password.
	  if ($userid = $db->login($username, $password) > 0) {
	      // Login success
	  		//echo 'success';
	      header('Location: ../pages/index.php');
	  } else {
	      // Login failed
	  		//echo 'failed';

	      header('Location: ../pages/login.php?error=1');
	  }
	} else {
	    // The correct POST variables were not sent to this page.
	    echo 'Invalid Request';
	}
/*
	$db_password = "admin";
	echo password_hash($db_password,PASSWORD_DEFAULT);*/
?>
