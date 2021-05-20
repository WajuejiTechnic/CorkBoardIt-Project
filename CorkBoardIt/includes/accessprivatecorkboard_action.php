<?php
    if (isset($_POST["login-submit"])) {

        session_start();
        require "dbh.php";

        //Set passed parameters
        $CBnum = $_POST['cid'];
        $password = $_POST["password"];

        //Validate passed parameters
        if (!preg_match("/^[a-zA-Z0-9\\s]*$/", $password)) {
            header("Location: ../accessprivatecorkboard.php?cid=" . $CBnum . "&error=invalidpassword");
            exit();
        }

        //Search for password and Access Private CorkBoard
        $sql = "SELECT password FROM CorkBoard WHERE CorkBoard.id=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../accessprivatecorkboard.php?cid=" . $CBnum . "&error=sqlerror1");
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt, "s", $CBnum);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                if ($password !== $row["password"]) {
                    header("Location: ../accessprivatecorkboard.php?cid=" . $CBnum . "&error=invalidpassword");
                    exit();
                }
                else if ($password == $row["password"]) {
                    header("Location: ../corkboard.php?cid=" .$CBnum);
                    exit();
                }
            }
        }

    }
    else {
        header("Location: ../index.php");
        exit();
    }
?>
