<?php
    require "header.php";
?>

    <main>
        <div class="login-form">
            <?php
                if (!empty($_GET['error'])) {
                    echo "<div class=\"alert alert-warning\">";
                        // Error Messages
                        if ($_GET['error'] == "invalidemailname") {
                            echo '<p class="font-weight-bold text-danger">Invalid e-mail and name!</p>';
                        }
                        else if ($_GET['error'] == "invalidemail") {
                            echo '<p class="font-weight-bold text-danger">Invalid e-mail!</p>';
                        }
                        else if ($_GET['error'] == "invalidname") {
                            echo '<p class="font-weight-bold text-danger">Invalid name!</p>';
                        }
                        else if ($_GET['error'] == "invalidpin") {
                            echo '<p class="font-weight-bold text-danger">Invalid pin!</p>';
                        }
                        else if ($_GET['error'] == "passwordcheck") {
                            echo '<p class="font-weight-bold text-danger">Your passwords do not match!</p>';
                        }
                        else if ($_GET['error'] == "emailtaken") {
                            echo '<p class="font-weight-bold text-danger">You already have an account.</p>';
                        }
                    echo "</div>";
                }
                else if (isset($_GET['signup'])){
                    if ($_GET['signup'] == "success") {
                        // Success message. Instruct the user to head to the Login page.
                        echo '<p class ="font-weight-bold text-success">Signup successful! Select the Login button.</p>';
                    }
                }
            ?>

            <form action="includes/signup_action.php" method="post">
                <!-- Header -->
                <h2 class="text-center">Sign up</h2>

                <!-- Form inputs -->
                <div class="form-group">
                    <input type="text" name="first_name" class="form-control" placeholder="First Name" required="required">
                    <input type="text" name="last_name" class="form-control" placeholder="Last Name" required="required">
                </div>
                <div class="form-group">
                    <input type="text" name="email" class="form-control" placeholder="Email" required="required">
                    <small class="form-text text-muted text-center">We'll never share your email with anyone else.</small>
                </div>
                <div class="form-group">
                    <input type="password" name="pin" class="form-control" placeholder="PIN - 4 digits" required="required">
                    <input type="password" name="pin-repeat" class="form-control" placeholder="Repeat PIN" required="required">
                </div>
                <div class="form-group">
                    <button type="submit" name="signup-submit" class="btn btn-primary btn-block">Sign up</button>
                </div>
            </form>
        </div>
    </main>

<?php
    require "footer.php";
?>
