<?php
require "header.php";
?>

<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <h2>CorkBoard Statistics</h2>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <?php
                require "includes/dbh.php";

                $sql = "SELECT User.email AS user_email, User.first_name as user_first_name, User.last_name as user_last_name,
                        (SELECT COUNT(*) FROM CorkBoard WHERE CorkBoard.email = User.email AND CorkBoard.password IS NULL) as public_corkboards,
                        (SELECT COUNT(*) FROM `PushPin`JOIN `CorkBoard` ON PushPin.c_id = CorkBoard.id WHERE CorkBoard.email = User.email AND CorkBoard.password IS NULL) as public_pushpins,
                        (SELECT COUNT(*) FROM CorkBoard WHERE CorkBoard.email = User.email AND CorkBoard.password IS NOT NULL) as private_corkboards,
                        (SELECT COUNT(*) FROM `PushPin`JOIN `CorkBoard` ON PushPin.c_id = CorkBoard.id WHERE CorkBoard.email = User.email AND CorkBoard.password IS NOT NULL) as private_pushpins
                        FROM `User`
                        ORDER BY public_corkboards DESC, private_corkboards DESC, user_last_name ASC;";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo "<p>Corkboard Statistics failed to populate</p>";
                } else {
                    echo "<table class=\"table\"><thead><tr><th scope=\"col\">User</th><th scope=\"col\">Public CorkBoards</th><th scope=\"col\">Public PushPins</th><th scope=\"col\">Private CorkBoards</th><th scope=\"col\">Private PushPins</th></tr></thead><tbody>";
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $textColor = "color:black";
                        if ($row["user_email"] == $_SESSION['email']) {
                            $textColor = "color:red";
                        }
                        echo "<tr>
                                <td><p style=" . $textColor . ">" . $row["user_first_name"] . " " . $row["user_last_name"] . "</p></td>
                                <td><p style=" . $textColor . ">" . $row["public_corkboards"] . "</p></td>
                                <td><p style=" . $textColor . ">" . $row["public_pushpins"] . "</p></td>
                                <td><p style=" . $textColor . ">" . $row["private_corkboards"] . "</p></td>
                                <td><p style=" . $textColor . ">" . $row["private_pushpins"] . "</p></td>
                              </tr>";
                    }

                    echo "</tbody></table>";
                }
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                ?>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</main>

<?php
require "footer.php";
?>
