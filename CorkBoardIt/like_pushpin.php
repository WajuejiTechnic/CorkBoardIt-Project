<?php
    require "header.php";
	require "includes/dbh.php";
	
	$pid = $_GET['pid'];
	$didLike = $_GET['liked'];

	if($didLike == 'true')
	{
	$sql = "DELETE FROM `likes` WHERE `u_email` = ? and `p_id` = ?";                   
	}
	else{
		$sql = "INSERT INTO `likes`(`u_email`, `p_id`) VALUES (?, ?)";                   
		
	}
		$stmt = mysqli_stmt_init($conn);
		mysqli_stmt_prepare($stmt, $sql);
				
		mysqli_stmt_bind_param($stmt,"ss", $_SESSION['email'],$pid);
		mysqli_stmt_execute($stmt);
		if ( mysqli_stmt_affected_rows($stmt) == 1) {

		header('Location: '.'pushpin.php?pid='.$pid);
		}
		else{
			echo 'something is wrong';
		}
	?>

<main>
    <div class="container-fluid">
	</div>
</main>
