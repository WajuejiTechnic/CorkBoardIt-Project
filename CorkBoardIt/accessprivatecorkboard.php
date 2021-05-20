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
                    } elseif ($_GET["error"] == "invalidpassword") {
                        echo "<p class = text-center>Password is incorrect! Please try again.</p>";
                    }
                echo "</div>";
            }
        ?>
        <div class="login-form">
            <form action="includes/accessprivatecorkboard_action.php" method="post">
                <!-- Header -->
                <h2 class="text-center">Access Private CorkBoard</h2>
                <p class="text-danger"><span class="glyphicon glyphicon-minus-sign"></span> The CorkBoard you are trying to view is private. Please enter the CorkBoard's password to continue.</p>

                <!-- Hidden input field to capture the CorkBoardNo value in the url -->
                <input type="hidden" name="cid" value="<?php $CBnum = $_GET['cid']; echo $CBnum; ?>"/>

                <!-- Form Inputs -->
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required="required">
                </div>
                <div class="form-group">
                    <button type="submit" name="login-submit" class="btn btn-primary btn-block">Ok</button>
                </div>
            </form>
        </div>
    </main>

<?php
    require "footer.php";
?>
