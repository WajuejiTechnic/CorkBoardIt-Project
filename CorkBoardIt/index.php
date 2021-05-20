<?php
    require "header.php";

    if (!isset($_SESSION['email']) && basename($_SERVER['PHP_SELF']) != 'login.php') {
        header("Location: ./login.php");
        exit();
    }
?>
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <h1>Welcome <?php echo $_SESSION["first_name"]?> <?php echo $_SESSION["last_name"]?></h1>
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <hr>
                    <p class="h3">Recent CorkBoard Updates <a class="btn list-unstyled text-right" href="populartags.php"><span class="glyphicon glyphicon-tag"></span> Popular Tags</a><a class="btn list-unstyled text-right" href="popularsites.php"><span class="glyphicon glyphicon-fire"></span> Popular Sites</a><a class="btn list-unstyled text-right" href="corkboard_statistics.php"><span class="glyphicon glyphicon-book"></span> CorkBoard Statistics</a></p>
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <?php
                        require "includes/dbh.php";

                        $sql = "SELECT
                                    CorkBoard.id, CorkBoard.title, CorkBoard.password, User.first_name, User.last_name, PushPin.date_time
                                FROM
                                    ((CorkBoard JOIN PushPin ON CorkBoard.id = PushPin.c_id) JOIN User ON CorkBoard.email = User.email)
                                WHERE CorkBoard.email = ?
                                UNION
                                SELECT
                                    CorkBoard.id, CorkBoard.title, CorkBoard.password, User.first_name, User.last_name, PushPin.date_time
                                FROM
                                    (((CorkBoard JOIN PushPin ON CorkBoard.id = PushPin.c_id) JOIN Watches ON CorkBoard.id = Watches.c_id) JOIN User ON CorkBoard.email = User.email)
                                WHERE Watches.u_email = ?
                                UNION
                                SELECT
                                    CorkBoard.id, CorkBoard.title, CorkBoard.password, User.first_name, User.last_name, PushPin.date_time
                                FROM
                                    (((CorkBoard JOIN PushPin ON CorkBoard.id = PushPin.c_id) JOIN Follows ON CorkBoard.email = Follows.f_email) JOIN User ON CorkBoard.email = User.email)
                                WHERE Follows.email = ?
                                ORDER BY date_time DESC
                                LIMIT 4";
                        $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            echo '<p class="h5">Recent CorkBoard Updates failed to populate</li>';
                        }
                        else {
                            mysqli_stmt_bind_param($stmt, "sss",$_SESSION['email'],$_SESSION['email'],$_SESSION['email']);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            $rowcount = mysqli_num_rows($result);
                            if ($rowcount == 0) {
                                echo '<p class="h5">No Updates.</p>';
                            }
                            echo '<ul class="list-group list-group-flush">';
                            for ($rownum = 0; $rownum <= $rowcount-1; ++$rownum) {
                                $row = mysqli_fetch_assoc($result);

                                $date_time_string = strtotime($row["date_time"]);

                                if ($row["password"] !== null) {
                                    echo "<li class='list-group-item'><a href='accessprivatecorkboard.php?cid=" . $row["id"] . "'>" . $row["title"] . "</a>&nbsp&nbsp&nbsp<small class='text-danger'><strong>PRIVATE</strong></small>&nbsp&nbsp&nbspUpdated by " . $row["first_name"] . " " . $row["last_name"] . " on " . date("F j, Y", $date_time_string) . " at " . date("g:i a", $date_time_string) . "</li>";
                                }
                                else {
                                    echo "<li class='list-group-item'><a href='corkboard.php?cid=" . $row["id"] . "'>" . $row["title"] . "</a>&nbsp&nbsp&nbspUpdated by " . $row["first_name"] . " " . $row["last_name"] . " on " . date("F j, Y", $date_time_string) . " at " . date("g:i a", $date_time_string) . "</li>";
                                }

                            }
                        }
                    ?>
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <hr>
                    <p class="h3">My CorkBoards <a class="btn list-unstyled text-right" href="addcorkboard.php"><span class="glyphicon glyphicon-plus"></span> Add CorkBoard</a></p>
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">

                    <?php
                        require "includes/dbh.php";

                        $sql = "SELECT CorkBoard.id, CorkBoard.title, COUNT(*), CorkBoard.password, PushPin.url FROM (`CorkBoard` LEFT OUTER JOIN `PushPin` ON CorkBoard.id = PushPin.c_id) WHERE CorkBoard.email = ? GROUP BY id ORDER BY title";
                        $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            echo '<p class="h5">My CorkBoards failed to populate</li>';
                        }
                        else {
                            mysqli_stmt_bind_param($stmt, "s",$_SESSION['email']);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            $rowcount = mysqli_num_rows($result);
                            if ($rowcount == 0) {
                                echo '<p class="h5">You have no CorkBoards.</p>';
                            }

                            echo '<ul class="list-group list-group-flush">';

                            for ($rownum = 0; $rownum <= $rowcount-1; ++$rownum) {
                                $row = mysqli_fetch_assoc($result);

                                if ($row["password"] !== null && $row["url"] !== null) {
                                    echo "<li class='list-group-item'><a href='accessprivatecorkboard.php?cid=" . $row["id"] . "'>" . $row["title"] . "</a>&nbsp&nbsp&nbsp<small class='text-danger'><strong>PRIVATE</strong></small>&nbsp&nbsp&nbspwith " . $row["COUNT(*)"] . " PushPins</li>";
                                }
                                else if ($row["password"] !== null && $row["url"] == null) {
                                    echo "<li class='list-group-item'><a href='accessprivatecorkboard.php?cid=" . $row["id"] . "'>" . $row["title"] . "</a>&nbsp&nbsp&nbsp<small class='text-danger'><strong>PRIVATE</strong></small>&nbsp&nbsp&nbspwith 0 PushPins</li>";
                                }
                                else if ($row["url"] == null) {
                                    echo "<li class='list-group-item'><a href='corkboard.php?cid=" . $row["id"] . "'>" . $row["title"] . "</a>&nbsp&nbsp&nbspwith 0 PushPins</li>";
                                }
                                else {
                                    echo "<li class='list-group-item'><a href='corkboard.php?cid=" . $row["id"] . "'>" . $row["title"] . "</a>&nbsp&nbsp&nbspwith " . $row["COUNT(*)"] . " PushPins</li>";
                                }

                            }
                            echo '</ul>';
                        }
                        mysqli_stmt_close($stmt);
                        mysqli_close($conn);
                    ?>
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="row">
                <div class="col-md-2"></div>
                <form action="search.php" method="get">
                    <div class="col-md-7 form-group">
                        <input type="text" name="query" class="form-control" placeholder="Search" required="required">
                    </div>
                    <div class="col-md-1 form-group">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>
                <div class="col-md-2"></div>
            </div>
        </div>
    </main>

<?php
    require "footer.php";
?>
