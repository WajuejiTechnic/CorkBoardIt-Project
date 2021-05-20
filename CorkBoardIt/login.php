<?php
    require "header.php";
?>
    <main>
		<?php
			if(!empty($_GET['error'])) {
				echo "<div class=\"alert alert-warning\">";
                    // Error Messages
					if($_GET["error"] == "sqlerror1") {
						echo "<p class = text-center>An internal error occured. Please try again.</p>";
					} elseif ($_GET["error"] == "sqlerror2") {
						echo "<p class = text-center>An internal error occured. Please try again.</p>";
					} elseif ($_GET["error"] == "wrongpin") {
						echo "<p class = text-center>Pin is incorrect! Please try again.</p>";
					} elseif ($_GET["error"] == "nouser") {
						echo "<p class = text-center>Email is incorrect. Please try again.</p>";
					}

				echo "</div>";
			}
		?>
        <div class="login-form">
            <form action="includes/login_action.php" method="post">
                <!-- Header -->
                <h2 class="text-center">Log in</h2>

                <!-- Form Inputs -->
                <div class="form-group">
					<?php
                        // Auto-populate the relevant user input form with data from previous attempt if there was an error
						if(!empty($_GET["email"])) {
							echo "<input type=\"text\" name=\"email\" class=\"form-control\" placeholder=\"Email\" required=\"required\" value=\"".$_GET["email"]."\">";
						} else {
							echo "<input type=\"text\" name=\"email\" class=\"form-control\" placeholder=\"Email\" required=\"required\">";
						}
					?>
                </div>
                <div class="form-group">
                    <input type="password" name="pin" class="form-control" placeholder="PIN" required="required">
                </div>
                <div class="form-group">
                    <button type="submit" name="login-submit" class="btn btn-primary btn-block">Log in</button>
                </div>
            </form>
        </div>
    </main>

<?php
    require "footer.php";
?>
