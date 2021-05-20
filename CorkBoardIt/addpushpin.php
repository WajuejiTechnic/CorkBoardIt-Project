<?php
    require "header.php";
    require "includes/dbh.php";
	
	$sql = "SELECT title FROM `CorkBoard` WHERE CorkBoard.id = ?";
	$stmt = mysqli_stmt_init($conn);
	mysqli_stmt_prepare($stmt, $sql);
	
	$cid = htmlspecialchars($_GET['cid']);
	
	mysqli_stmt_bind_param($stmt,"s",$cid);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$cboard = mysqli_fetch_assoc($result);
	mysqli_stmt_close($stmt);
?>
    <main>
		<?php
			if(!empty($_GET['error'])) {
				echo "<div class=\"alert alert-warning\">";
                    // Error Messages
					if($_GET["error"] == "urllength") {
						echo "<p class = text-center>The entered URL is too long. Please try again.</p>";
					} elseif($_GET["error"] == "badurl") {
						echo "<p class = text-center>The entered URL does not appear to be a valid image. Please try again.</p>";
					} else {
						echo "<p class = text-center>Unknown Error. Please try again.</p>";
					}

				echo "</div>";
			}
		?>
        <div class="col-md-4 col-md-offset-4 inline-headers">
            <?php
				echo "<form action='includes/addpushpin_action.php?cid=".$_GET['cid']."' method='post'>"
			?>
                <h1 class="text-left">Add PushPin</h1>
				<?php
					echo "<h2 class='text-left'>to ".$cboard["title"]."</h2>";
				?>
                <div class="form-group row">
                    <label>URL</label>
                    <input type="text" name="url" class="form-control" placeholder="https://image.png" required="required" maxlength="128">
                </div>
                <div class="form-group row">
                    <label>Description</label>
                    <textarea name="description" class="form-control" placeholder="A brief description of the image" rows="3" required="required" maxlength="256"></textarea>
                </div>
                <div class="form-group row">
                    <label>Tags</label>
                    <input type="text" name="tags" class="form-control" placeholder="Comma, Separated, Tags" maxlength="128">
                </div>
                <div class="form-group row">
                    <button type="submit" name="addpushpin-submit" class="btn btn-primary btn-block">Add</button>
                </div>
            </form>
        </div>
    </main>

<?php
    require "footer.php";
?>
