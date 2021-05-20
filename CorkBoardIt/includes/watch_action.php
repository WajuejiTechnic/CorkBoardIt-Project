<?php

    session_start();

    if (isset($_GET['cid']) && isset($_GET['action'])) {

        require "dbh.php";

		if($_GET['action'] == 'add') {
			$sql = "INSERT INTO `Watches`(`u_email`,`c_id`) VALUES (?,?)";
		} elseif ($_GET['action'] == 'remove') {
			$sql = "DELETE FROM `Watches` WHERE `u_email`=? AND `c_id`=?";
		} else {
			header("Location: ../index.php");
			exit();
		}
		
		$stmt = mysqli_stmt_init($conn);
		mysqli_stmt_prepare($stmt, $sql);
		mysqli_stmt_bind_param($stmt, "ss", $_SESSION['email'], $_GET['cid']);
		mysqli_stmt_execute($stmt);
		
		header("Location: ../corkboard.php?cid=".$_GET['cid']);
		exit();
		
    } else {
		header("Location: ../index.php");
		exit();
	}
?>
