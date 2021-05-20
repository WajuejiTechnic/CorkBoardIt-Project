<?php

    session_start();

    if (isset($_GET['email']) && isset($_GET['action']) && (isset($_GET['cid']) || isset($_GET['pid']))) {

        require "dbh.php";

		if($_GET['action'] == 'add') {
			$sql = "INSERT INTO `Follows`(`email`,`f_email`) VALUES (?,?)";
		} elseif ($_GET['action'] == 'remove') {
			$sql = "DELETE FROM `Follows` WHERE `email`=? AND `f_email`=?";
		} else {
			header("Location: ../index.php");
			exit();
		}
		
		
		$stmt = mysqli_stmt_init($conn);
		mysqli_stmt_prepare($stmt, $sql);
		mysqli_stmt_bind_param($stmt, "ss", $_SESSION['email'], $_GET['email']);
		mysqli_stmt_execute($stmt);
		
		if(isset($_GET['cid'])) {
			header("Location: ../corkboard.php?cid=".$_GET['cid']);
			exit();
		} else {
			header("Location: ../pushpin.php?pid=".$_GET['pid']);
			exit();
		}
		
    } else {
		header("Location: ../index.php");
		exit();
	}
?>
