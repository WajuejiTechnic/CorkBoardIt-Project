<?php
require "header.php";
?>

<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <h2>PushPin Search Results</h2>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <?php
                require "includes/dbh.php";

                $searchQuery = $_GET["query"];

                $sql = "SELECT PushPin.id as pushpin_id, PushPin.description as pushpin_description, CorkBoard.title as corkboard_title, User.first_name as user_first_name, User.last_name as user_last_name, User.email AS user_email
                        FROM `PushPin`
                        JOIN `CorkBoard` ON PushPin.c_id = CorkBoard.id
                        JOIN `User` ON CorkBoard.email = User.email
                        WHERE CorkBoard.password IS NULL 
                        AND (PushPin.description LIKE '%$searchQuery%' 
                             OR EXISTS (SELECT * FROM `Tag` WHERE Tag.p_id = PushPin.id AND Tag.name LIKE '%$searchQuery%')
                             OR EXISTS (SELECT * FROM `Category` WHERE Category.name = CorkBoard.name AND Category.name LIKE '%$searchQuery%'));";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo "<p>PushPin Search Results failed to populate</p>";
                } else {
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $rowNum = 0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($rowNum == 0) {
                            echo "<table class=\"table\"><thead><tr><th scope=\"col\">PushPin Description</th><th scope=\"col\">CorkBoard</th><th scope=\"col\">Owner</th></tr></thead><tbody>";
                            $rowNum++;
                        }
                        echo "<tr>
                                <td><a class=\"text\" href=\"./pushpin.php?pid=" . $row["pushpin_id"] . "\">" . $row["pushpin_description"] . "</a></td>
                                <td>" . $row["corkboard_title"] . "</td>
                                <td>" . $row["user_first_name"] . " " . $row["user_last_name"] . "</td>
                              </tr>";
                    }

                    if ($rowNum == 0) {
                        echo "<p>No results for \"" . $searchQuery . "\"</p>";
                    } else {
                        echo "</tbody></table>";
                    }
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
