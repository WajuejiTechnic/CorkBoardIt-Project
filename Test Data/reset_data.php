<html>
<head>
</head>
<body>
<?php

	#Connect to database
	$servername = "localhost";
	$username = "gatechUser";
	$password = "gatech123";
	$dbname = "cs6400_fall2018_team123";

	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	#Recreate User table
	$sql = "DELETE FROM `User`";
	if ($conn->query($sql) === FALSE) {
			die("Drop user table failed");
	}

	$row = 1;
	if (($handle = fopen("User.csv", "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$sql = "INSERT INTO `User` (email, pin, first_name, last_name) VALUES ('$data[0]', '$data[1]', '$data[2]', '$data[3]')";
			if ($conn->query($sql) === FALSE) {
				die("User insert failed");
			}
			$row++;
		}
		fclose($handle);
		
		echo "<p>Inserted $row rows into user table</p>";
	}

	
	#Recreate Category table
	$sql = "DELETE FROM `Category`";
	if ($conn->query($sql) === FALSE) {
			die("Drop category table failed");
	}
	
	$row = 1;
	if (($handle = fopen("Category.csv", "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$sql = "INSERT INTO `Category` (name) VALUES ('$data[0]')";
			if ($conn->query($sql) === FALSE) {
				die("Category insert failed");
			}
			$row++;
		}
		fclose($handle);
		
		echo "<p>Inserted $row rows into category table</p>";
	}
	
	#Recreate CorkBoard table
	$sql = "DELETE FROM `CorkBoard`";
	if ($conn->query($sql) === FALSE) {
			die("Drop corkboard table failed");
	}
	
	$sql = "ALTER TABLE `CorkBoard` AUTO_INCREMENT = 1";
	if ($conn->query($sql) === FALSE) {
			die("Reset corkboard counter failed");
	}

	$row = 1;
	if (($handle = fopen("Corkboard.csv", "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			
			if (empty(trim($data[4])) === FALSE) {
				$sql = "INSERT INTO `CorkBoard` (email, title, date_time, name, password) VALUES ('$data[0]', '$data[1]', '$data[2]', '$data[3]', '$data[4]')";
			} else {
				$sql = "INSERT INTO `CorkBoard` (email, title, date_time, name) VALUES ('$data[0]', '$data[1]', '$data[2]', '$data[3]')";
			}
			
			if ($conn->query($sql) === FALSE) {
				die("CorkBoard insert failed");
			}
			$row++;
		}
		fclose($handle);
		
		echo "<p>Inserted $row rows into CorkBoard table</p>";
	}
	
	#Recreate PushPin table
	$sql = "DELETE FROM `PushPin`";
	if ($conn->query($sql) === FALSE) {
			die("Drop pushpin table failed");
	}

	$sql = "ALTER TABLE `PushPin` AUTO_INCREMENT = 1";
	if ($conn->query($sql) === FALSE) {
			die("Reset pushpin counter failed");
	}
	
	$row = 1;
	if (($handle = fopen("Pushpin.csv", "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			
			$sql = "INSERT INTO `PushPin` (c_id, url, date_time, description) VALUES ('$data[0]', '$data[1]', '$data[2]', '$data[3]')";
			if ($conn->query($sql) === FALSE) {
				die("PushPin insert failed");
			}
			$row++;
		}
		fclose($handle);
		
		echo "<p>Inserted $row rows into PushPin table</p>";
	}
	#Recreate Follows table
	$sql = "DELETE FROM `Follows`";
	if ($conn->query($sql) === FALSE) {
			die("Drop follows table failed");
	}

	$row = 1;
	if (($handle = fopen("Follows.csv", "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$sql = "INSERT INTO `Follows` (email, f_email) VALUES ('$data[0]', '$data[1]')";
			
			if ($conn->query($sql) === FALSE) {
				die("Follows insert failed");
			}
			$row++;
		}
		fclose($handle);
		
		echo "<p>Inserted $row rows into follows table</p>";
	}
	
	#Recreate Watches table
	$sql = "DELETE FROM`Watches`";
	if ($conn->query($sql) === FALSE) {
			die("Drop watches table failed");
	}

	$row = 1;
	if (($handle = fopen("Watches.csv", "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$sql = "INSERT INTO `Watches` (u_email, c_id) VALUES ('$data[0]', '$data[1]')";
			
			if ($conn->query($sql) === FALSE) {
				die("Watches insert failed");
			}
			$row++;
		}
		fclose($handle);
		
		echo "<p>Inserted $row rows into watches table</p>";
	}
	
	#Recreate Comment table
	$sql = "DELETE FROM `Comment`";
	if ($conn->query($sql) === FALSE) {
			die("Drop comment table failed");
	}

	$row = 1;
	if (($handle = fopen("Comment.csv", "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$sql = "INSERT INTO `Comment` (u_email, p_id, date_time, text) VALUES ('$data[0]', '$data[1]', '$data[2]', '$data[3]')";
			
			if ($conn->query($sql) === FALSE) {
				die("Comment insert failed");
			}
			$row++;
		}
		fclose($handle);
		
		echo "<p>Inserted $row rows into comment table</p>";
	}

	#Recreate tag table
	$sql = "DELETE FROM `Tag`";
	if ($conn->query($sql) === FALSE) {
			die("Drop tag table failed");
	}

	$row = 1;
	if (($handle = fopen("Tag.csv", "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$sql = "INSERT INTO `Tag` (p_id, name) VALUES ('$data[0]', '$data[1]')";
			
			if ($conn->query($sql) === FALSE) {
				die("Tag insert failed");
			}
			$row++;
		}
		fclose($handle);
		
		echo "<p>Inserted $row rows into tag table</p>";
	}

	#Recreate likes table
	$sql = "DELETE FROM `Likes`";
	if ($conn->query($sql) === FALSE) {
			die("Drop likes table failed");
	}

	$row = 1;
	if (($handle = fopen("Likes.csv", "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$sql = "INSERT INTO `Likes` (u_email, p_id) VALUES ('$data[0]', '$data[1]')";

			if ($conn->query($sql) === FALSE) {
				die("Likes insert failed");
			}
			$row++;
		}
		fclose($handle);
		
		echo "<p>Inserted $row rows into likes table</p>";
	}
	#Close Connection
	$conn->close();
	
?>
</body>