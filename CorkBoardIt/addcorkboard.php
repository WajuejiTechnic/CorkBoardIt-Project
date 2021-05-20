<?php
    require "header.php";
?>

    <main>
        <div class="login-form">
            <form action="includes/addcorkboard_action.php" method="post">
                <h2 class="text-center">Add CorkBoard</h2>
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="CBtitle" class="form-control" placeholder="Title" required="required" maxlength="64">
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <br>
                    <select name="category" class="form-control" placeholder="Category" required="required">
                        <?php
                            require "includes/dbh.php";

                            $sql = "SELECT name FROM `Category` ORDER BY name";
                            $stmt = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                /* header("Location: ../addcorkboard.php?error=sqlerror1");
                                exit(); */
                                echo "<option>Category selection failed</option>";
                            }
                            else {
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                while ($row = mysqli_fetch_assoc($result)){
                                    echo "<option>" . $row["name"] . "</option>";
                                }
                            }
                            mysqli_stmt_close($stmt);
                            mysqli_close($conn);
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cbvisibility" value="public" checked>
                        <label class="form-check-label">Public</label>
                    </div>
                    <div class="form-row">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="cbvisibility" value="private">
                            <label class="form-check-label">Private</label>
                        </div>
                        <input type="password" name="password" class="form-control" placeholder="Enter Password">
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" name="addcorkboard-submit" class="btn btn-primary btn-block">Add CorkBoard</button>
                </div>
            </form>
        </div>
    </main>

<?php
    require "footer.php";
?>
