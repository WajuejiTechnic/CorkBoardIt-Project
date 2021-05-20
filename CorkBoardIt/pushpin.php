<?php
    require "header.php";
	require "includes/dbh.php";

	$pid = $_GET['pid'];

	$sql = "SELECT `id`, `c_id`, `url`, `date_time`, `description` FROM `PushPin` WHERE id = ?";
	$stmt = mysqli_stmt_init($conn);
	mysqli_stmt_prepare($stmt, $sql);

	$pid = $_GET['pid'];

	mysqli_stmt_bind_param($stmt,"s",$pid);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$pushpin = mysqli_fetch_assoc($result);

	mysqli_stmt_close($stmt);

?>
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">

					<?php

                    $sql = "SELECT User.first_name, User.last_name, CorkBoard.name, CorkBoard.title, CorkBoard.email, CorkBoard.id FROM `User`,`CorkBoard`,`PushPin` WHERE User.email = CorkBoard.email AND CorkBoard.id =PushPin.c_id AND PushPin.id = ?";
					$stmt = mysqli_stmt_init($conn);
					mysqli_stmt_prepare($stmt, $sql);

					mysqli_stmt_bind_param($stmt,"s",$pid);
					mysqli_stmt_execute($stmt);
					$result = mysqli_stmt_get_result($stmt);
					$cboard = mysqli_fetch_assoc($result);

					echo "<h1>".$cboard["first_name"]." ". $cboard["last_name"] . "</h1>";

					mysqli_stmt_close($stmt);

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
							echo "<a href='./includes/follow_action.php?action=remove&email=".$cboard["email"]."&pid=".$pid."'><span class='glyphicon glyphicon-heart'></span> Stop Following User</a>";
						} else {
							echo "<a href='./includes/follow_action.php?action=add&email=".$cboard["email"]."&pid=".$pid."'><span class='glyphicon glyphicon-heart'></span> Follow User</a>";
						}
					}
                    ?>
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">

					<?php
							$sql = "SELECT
                                    CorkBoard.id as cid, CorkBoard.title, CorkBoard.password, User.first_name, User.last_name, PushPin.id, PushPin.c_id, PushPin.date_time, PushPin.url, PushPin.description
									FROM
                                    ((CorkBoard JOIN PushPin ON CorkBoard.id = PushPin.c_id) JOIN User ON CorkBoard.email = User.email)
									WHERE PushPin.id = ? ORDER BY PushPin.date_time DESC";
							$stmt = mysqli_stmt_init($conn);
							mysqli_stmt_prepare($stmt, $sql);

							mysqli_stmt_bind_param($stmt,"s",$pid);
							mysqli_stmt_execute($stmt);
							$result = mysqli_stmt_get_result($stmt);

							$rows = mysqli_fetch_all($result,MYSQLI_ASSOC);

							foreach($rows as $row) {
									$time = strtotime($row["date_time"]);
									echo "Pinned ".date("F d, Y", $time)." at ".date("g:iA", $time)." on <a href='corkboard.php?cid=" . $row["cid"] . "'>" . $row["title"] . "</a>";
									break;
							}
						?>
					<hr>
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8 text-center">
					<?php
						reset($rows);
						foreach($rows as $row) {
							$url_parts = parse_url($row["url"]);
							echo "<p class='text-right'>from ".$url_parts["host"]."</p>";
							
							echo "<a href='".$row["url"]."'>";
							echo "<img class='img-responsive center-block' src='". $row["url"] . "' alt='".$pushpin["description"]."'>";
							echo "</a>";
						}

						mysqli_stmt_close($stmt);
					?>
                </div>
                <div class="col-md-2"></div>
            </div>

			<div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
					<?php
						echo "<br><p>".$pushpin["description"]."</p><br>";

						$sql = "SELECT `name` FROM `Tag` WHERE `p_id` = ?";
						$stmt = mysqli_stmt_init($conn);
						mysqli_stmt_prepare($stmt, $sql);

						mysqli_stmt_bind_param($stmt,"s",$pid);
						mysqli_stmt_execute($stmt);
						$result = mysqli_stmt_get_result($stmt);
						$rows = mysqli_fetch_all($result,MYSQLI_ASSOC);
						$row_counts = count($rows);

						echo "<p>Tags:<b>";
						for($i = 0; $i < $row_counts; $i++) {
							if($i == ($row_counts - 1)) {
								echo "<b>".$rows[$i]["name"]."</b>";
							} else {
								echo "<b>".$rows[$i]["name"]."</b>, ";
							}
						}
						echo "</b></p>";

						/* free result set */
						$result->free();

						mysqli_stmt_close($stmt);

                    ?>
				<hr>
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
					<?php
						$sql = "SELECT first_name, last_name, u_email FROM `Likes`, `User` WHERE `u_email` = `email` AND `p_id` = ?";
						$stmt = mysqli_stmt_init($conn);
						mysqli_stmt_prepare($stmt, $sql);
						mysqli_stmt_bind_param($stmt,"s", $pid);
						mysqli_stmt_execute($stmt);
						$result = mysqli_stmt_get_result($stmt);
						$rows = mysqli_fetch_all($result,MYSQLI_ASSOC);
						$row_counts = count($rows);

						$didLike = False;

						echo "<p><span style='font-size:1.5em;' class='glyphicon glyphicon-thumbs-up'></span> ";
						for($i = 0; $i < $row_counts; $i++) {

							if($rows[$i]["u_email"] == $_SESSION["email"]) {
								$didLike = True;
							}

							if($i == ($row_counts - 1) && $row_counts > 1) {
								echo "and ";
							}
							
							echo "<b>".$rows[$i]["first_name"]." ".$rows[$i]["last_name"]."</b>";
							
							if($i < ($row_counts - 1) && $row_counts > 1) {
								echo ", ";
							}
						}
						echo "</p>";

						if(!$is_current_user) {
							if ($didLike){
								echo "<a href='like_pushpin.php?pid=".$pid."&liked=true'>Unlike</a>";
							} else {
								echo "<a href='like_pushpin.php?pid=".$pid."&liked=false'>Like</a>";
							}
						}
					?>
					<br>
					<br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
					<div class="row">
						<?php
							echo "<form class='form-inline' action='addcomments.php?pid=".$pid."' method='post'>";
						?>
							<div class="col-md-8">
							<textarea rows="5" id="comment" name="comment" class="form-control" placeholder="Put your Comments here" required="required" style="min-width:100%" maxlength="256"></textarea>
							</div>
							<div class="col-md-4">
							<button type="submit" name="addcomments" class="btn btn-primary">Post Comment</button>
							</div>
						</form>
					</div>
					<div class="row">
						<br><br>
						<?php
							$sql = "SELECT first_name, last_name, text FROM `User`, `Comment` WHERE `u_email` = `email` AND `p_id` = ? ORDER BY date_time DESC";
							$stmt = mysqli_stmt_init($conn);
							mysqli_stmt_prepare($stmt, $sql);

							mysqli_stmt_bind_param($stmt,"s",$pid);
							mysqli_stmt_execute($stmt);
							$result = mysqli_stmt_get_result($stmt);

							/* fetch associative array */
							while ($comment = mysqli_fetch_assoc($result)) {
								echo "<div class='row'>";
								echo "<div class='col-md-2'><p><b>".$comment["first_name"]." ".$comment["last_name"]."</b></p></div>";
								echo "<div class='col-md-10'><p>".$comment["text"]."</p></div>";
								echo "</div>";
							}
							mysqli_stmt_close($stmt);
						?>
					</div>
				</div>
				<div class="col-md-2"></div>
			</div>
        </div>
    </main>

<?php
    require "footer.php";
?>
