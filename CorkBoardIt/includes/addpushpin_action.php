<?php

    session_start();

    if (isset($_POST['addpushpin-submit'])) {

        require "dbh.php";

        $url = $_POST["url"];
        $description = $_POST["description"];

		if(!empty($_POST["tags"])) {
			$tmp = strtolower($_POST["tags"]);
			$tags = explode(",", $tmp);
			$tags = array_map('trim',$tags);
			$tags = array_unique($tags);
		} else {
			$tags = NULL;
		}
		
        if (strlen($url) > 128) {
            header("Location: ../addpushpin.php?cid=".$_GET['cid']."&error=urllength");
            exit();
        }

		$buffer = file_get_contents($url);
		$finfo = new finfo(FILEINFO_MIME_TYPE);
		
		if( strpos($finfo->buffer($buffer), 'image') === False) {
            header("Location: ../addpushpin.php?cid=".$_GET['cid']."&error=badurl");
            exit();
		}
		
		$sql = "INSERT INTO `PushPin` (c_id, url, date_time, description) VALUES (?, ?, CURRENT_TIMESTAMP, ?)";
		$stmt = mysqli_stmt_init($conn);

        mysqli_stmt_prepare($stmt, $sql);
		mysqli_stmt_bind_param($stmt, "sss", $_GET['cid'], $url, $description);
		mysqli_stmt_execute($stmt);

		$pid = mysqli_insert_id($conn);

		if($tags != NULL) {

			foreach($tags as $tag) {

				$tag = trim($tag);
				$sql = "INSERT INTO `Tag` (p_id, name) VALUES (?, ?)";
				mysqli_stmt_prepare($stmt, $sql);
				mysqli_stmt_bind_param($stmt, "ss", $pid, $tag);
				mysqli_stmt_execute($stmt);

			}

		}

		mysqli_close($conn);
		header("Location: ../corkboard.php?cid=".$_GET['cid']);
    }
    else {
        header("Location: ../index.php");
        exit();
    }
?>
