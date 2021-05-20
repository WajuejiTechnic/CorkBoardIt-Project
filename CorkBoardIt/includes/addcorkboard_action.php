<?php

    session_start();

    if (isset($_POST['addcorkboard-submit'])) {

        require "dbh.php";

        //Set passed parameters
        $CBtitle = $_POST["CBtitle"];
        $category = $_POST["category"];

        $CBVisibility = $_POST["cbvisibility"];
        if ($CBVisibility == "private") {
                $password = $_POST["password"];
        }

        //Validate passed parameters
        if (!preg_match("/^[a-zA-Z0-9\\s]*$/", $CBtitle))  {
            header("Location: ../addcorkboard.php?error=invalidCBtitle");
            exit();
        }
        //Insert CorkBoard into DB
        else {
            if ($CBVisibility == "public") {
                $sql = "INSERT INTO `CorkBoard` (email, title, date_time, name) VALUES (?, ?, CURRENT_TIMESTAMP, ?)";
            }
            elseif ($CBVisibility == "private") {
                $sql = "INSERT INTO `CorkBoard` (email, title, date_time, password, name) VALUES (?, ?, CURRENT_TIMESTAMP, ?, ?)";
            }

            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../addcorkboard.php?error=sqlerror1");
                exit();
            }
            else {
                if ($CBVisibility == "public") {
                    mysqli_stmt_bind_param($stmt, "sss", $_SESSION['email'], $CBtitle, $category);
                }
                elseif ($CBVisibility == "private") {
                    mysqli_stmt_bind_param($stmt, "ssss", $_SESSION['email'], $CBtitle, $password, $category);
                }

                mysqli_stmt_execute($stmt);

                //Load new CorkBoard
                $sql = "SELECT id, title, date_time FROM CorkBoard WHERE email=? AND title=? ORDER BY date_time DESC";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../addcorkboard.php?error=sqlerror2");
                    exit();
                }
                mysqli_stmt_bind_param($stmt, "ss", $_SESSION['email'], $CBtitle);
                mysqli_stmt_execute($stmt);

                $result = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_assoc($result);
                $cid = $row['id'];

                header("Location: ../corkboard.php?cid=".$cid);
                exit();
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
    else {
        header("Location: ../addcorkboard.php");
        exit();
    }
?>
