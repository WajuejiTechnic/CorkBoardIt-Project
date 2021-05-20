<?php
	require "header.php";
	require "includes/dbh.php";
	
	$comment = $_POST["comment"];
	$pid = $_GET['pid'];
	

	$sql = "INSERT INTO `Comment` (u_email, p_id, date_time, text) VALUES (?, ?, CURRENT_TIMESTAMP, ?);";
	$stmt = mysqli_stmt_init($conn);
	mysqli_stmt_prepare($stmt, $sql);
	mysqli_stmt_bind_param($stmt,"sss", $_SESSION['email'],$pid, $comment);
	mysqli_stmt_execute($stmt);
	if ( mysqli_stmt_affected_rows($stmt) == 1) {

	header('Location: '.'pushpin.php?pid='.$pid);
	}
	else{
		echo 'something is wrong';
		echo $pid;
	}
?>
