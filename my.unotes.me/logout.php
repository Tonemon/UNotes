<?php 
	session_start();
	include '_inc/dbconn.php';

	// Set information for logout process & last login
	$date=date('Y-m-d h:i:s');
	$id=$_SESSION['user_id'];
	$sql="UPDATE UNotesMAIN.users SET lastlogin='$date' WHERE id='$id'";
	mysql_query($sql) or die("Could not set your lastlogin time.");
	
	// set user status to offline
	$setoffline="UPDATE UNotesMAIN.users SET status='offline' WHERE id='$id'";
	mysql_query($setoffline) or die("Could not set your status to offline.");

	// destroy session and redirect to message 'logged out successfully'
	session_destroy();
	header('location:index?success=1');
?>