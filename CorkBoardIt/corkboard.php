<?php
    require "header.php";
    require "includes/dbh.php";
?>

    <main>
		<div class="container-fluid">
			<div class="row">
				<div class="row">
					<div class="col-md-6 col-md-offset-2 inline-headers">
						<?php 
							$sql = "SELECT first_name, last_name, name, title, CorkBoard.email FROM `User`,`CorkBoard` WHERE User.email = CorkBoard.email AND CorkBoard.id = ?";
							$stmt = mysqli_stmt_init($conn);
							mysqli_stmt_prepare($stmt, $sql);
							
							$cid = htmlspecialchars($_GET['cid']);
							
							mysqli_stmt_bind_param($stmt,"s",$cid);
							mysqli_stmt_execute($stmt);
							$result = mysqli_stmt_get_result($stmt);
							$cboard = mysqli_fetch_assoc($result);
							mysqli_stmt_close($stmt);
							
							echo "<h1>".$cboard["first_name"]." ". $cboard["last_name"] . "</h1>";
							
							if($cboard["email"] == $_SESSION["email"]) {
								$is_current_user = True;

							} else {
								$is_current_user = False;
								
								$sql = "SELECT COUNT(*) FROM `Follows` WHERE email = ? AND f_email = ?";
								
								$stmt = mysqli_stmt_init($conn);
								mysqli_stmt_prepare($stmt, $sql);					
								mysqli_stmt_bind_param($stmt,"ss",$_SESSION['email'],$cboard["email"]);
								mysqli_stmt_execute($stmt);
								$results = mysqli_stmt_get_result($stmt);
								$follow = mysqli_fetch_assoc($results);
								mysqli_stmt_close($stmt);
						
								if(intval($follow['COUNT(*)']) > 0) {
									echo "<a href='./includes/follow_action.php?action=remove&email=".$cboard["email"]."&cid=".$_GET['cid']."'><span class='glyphicon glyphicon-heart'></span> Stop Following User</a>";
								} else {
									echo "<a href='./includes/follow_action.php?action=add&email=".$cboard["email"]."&cid=".$_GET['cid']."'><span class='glyphicon glyphicon-heart'></span> Follow User</a>";
								}
							}
							
						?>
					</div>
					<div class="col-md-2 text-right">
						<?php
							echo "<h3>".$cboard["name"]."</h2>";
						?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 col-md-offset-2">
						<?php
							echo "<h2>".$cboard["title"]."</h2>";
						?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 col-md-offset-2">
						<?php
							$sql = "SELECT id, url, date_time FROM PushPin WHERE c_id = ? ORDER BY date_time DESC";
							$stmt = mysqli_stmt_init($conn);
							mysqli_stmt_prepare($stmt, $sql);
							
							$cid = htmlspecialchars($_GET['cid']);
							
							mysqli_stmt_bind_param($stmt,"s",$cid);
							mysqli_stmt_execute($stmt);
							$result = mysqli_stmt_get_result($stmt);
						
							$rows = mysqli_fetch_all($result,MYSQLI_ASSOC);
							mysqli_stmt_close($stmt);
							foreach($rows as $row) {
									$time = strtotime($row["date_time"]);
									echo "<p>Last Updated ".date("F d, Y", $time)." at ".date("g:iA", $time)."</p>";
									break;
							}
						?>
					</div>
					<div class="col-md-2 text-right">
						<?php
							if($is_current_user) {
								echo "<a class=\"btn list-unstyled text-right\" href=\"addpushpin.php?cid=".$cid."\"><span class=\"glyphicon glyphicon-plus\"></span> Add PushPin</a>";
							}
						?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<?php
						reset($rows);
						$trows = ceil(count($rows));
						
						for($i=0; $i<$trows; $i++) {
							echo "<div class='row'>";
							
							for($j=0; $j<2; $j++) {
								$row = array_shift($rows);
								
								if($row != NULL) {
									echo "<div class='col-md-6'><div class='thumbnail'><a href='pushpin.php?pid=". strval($row["id"]) ."'><img src='". $row["url"] . "'></a></div></div>";
								}
							}
							
							echo "</div>";
						}
					?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-md-offset-2">
					<?php 
						$sql = "SELECT COUNT(*) FROM `Watches` WHERE c_id = ?";
						$stmt = mysqli_stmt_init($conn);
						mysqli_stmt_prepare($stmt, $sql);
						
						$cid = htmlspecialchars($_GET['cid']);
						
						mysqli_stmt_bind_param($stmt,"s",$cid);
						mysqli_stmt_execute($stmt);
						$result = mysqli_stmt_get_result($stmt);
					
						$rows = mysqli_fetch_assoc($result);
								
						echo "<p>This CorkBoard has <b>".$rows["COUNT(*)"]."</b> watchers.</p>";
					?>
				</div>
				<div class="col-md-2 text-right">
					<?php
						$sql = "SELECT COUNT(*) FROM `Watches` WHERE c_id = ? AND u_email = ?";
						$stmt = mysqli_stmt_init($conn);
						mysqli_stmt_prepare($stmt, $sql);
						
						$cid = htmlspecialchars($_GET['cid']);
						
						mysqli_stmt_bind_param($stmt,"ss",$cid,$_SESSION["email"]);
						mysqli_stmt_execute($stmt);
						$result = mysqli_stmt_get_result($stmt);
					
						$rows = mysqli_fetch_assoc($result);
						
						if(!$is_current_user) {
							if(intval($rows["COUNT(*)"]) > 0) {
								echo "<a href=\"./includes/watch_action.php?action=remove&cid=".$cid."\"><span class=\"glyphicon glyphicon-bell\"></span> Stop Watching CorkBoard</p>";
							} else {
								echo "<a href=\"./includes/watch_action.php?action=add&cid=".$cid."\"><span class=\"glyphicon glyphicon-bell\"></span> Watch CorkBoard</p>";
							}
						}
					?>
				</div>
			</div>
		</div>
    </main>

<?php
    require "footer.php";
?>
