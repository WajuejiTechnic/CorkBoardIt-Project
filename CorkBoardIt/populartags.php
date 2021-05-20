<?php
require "header.php";
?>

<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <h2>Popular Tags</h2>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <?php
                require "includes/dbh.php";

                $sql = "SELECT Tag.name as tag_name, COUNT(PushPin.id) as pushpin_count, COUNT(DISTINCT CorkBoard.id) as corkboard_count
                        FROM `Tag`
                        JOIN `PushPin` ON p_id = PushPin.id
                        JOIN `CorkBoard`ON c_id = CorkBoard.id
                        GROUP BY tag_name
                        ORDER BY pushpin_count DESC
                        LIMIT 5;";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo "<p>Popular Tags failed to populate</p>";
                } else {
                    echo "<table class=\"table\"><thead><tr><th scope=\"col\">Tag</th><th scope=\"col\">PushPins</th><th scope=\"col\">Unique CorkBoards</th></tr></thead><tbody>";
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td> 
                                    <a class=\"text\" href=\"search.php?query=" . $row["tag_name"] . "\">" . $row["tag_name"] . "</a>
                                </td>
                                <td>" . $row["pushpin_count"] . "</td>
                                <td>" . $row["corkboard_count"] . "</td>
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
