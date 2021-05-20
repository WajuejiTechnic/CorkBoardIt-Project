<?php
require "header.php";
?>

<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <h2>Popular Sites</h2>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <?php
                require "includes/dbh.php";

                $sql = "SELECT SUBSTRING_INDEX(REPLACE(REPLACE(url,'http://',''),'https://',''),'/',1) as site, COUNT(*) as site_count 
                        FROM `PushPin` 
                        GROUP BY site
                        ORDER BY site_count DESC
                        LIMIT 5;";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo "<p>Popular Sites failed to populate</p>";
                } else {
                    echo "<table class=\"table\"><thead><tr><th scope=\"col\">Site</th><th scope=\"col\">PushPins</th></tr></thead><tbody>";
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>" . $row["site"] . "</td>
                                <td>" . $row["site_count"] . "</td>
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
