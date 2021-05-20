<?php
    if (isset($_POST["login-submit"])) {

        require "dbh.php";

		//Set passed parameters
        $email = $_POST["email"];
        $pin = $_POST["pin"];

		//Validate passed parameters
        if (!preg_match("/^[0-9]*$/", $pin)) {
            header("Location: ../login.php?error=wrongpin&email=".$email);
            exit();
        }

		if (!preg_match("/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/", $email)) {
            header("Location: ../login.php?error=nouser&email=".$email);
            exit();
        }

		//Search for email user
        $sql = "SELECT pin FROM `User` WHERE email=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../index.php?error=sqlerror1&email=".$email);
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
			
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                if ($pin !== $row["pin"]) {
                    header("Location: ../login.php?error=wrongpin&email=".$email);
                    exit();
                }
                else if ($pin == $row["pin"]) {
                    $sql = "SELECT `email`, `first_name`, `last_name` FROM `User` WHERE email=?";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ../login.php?error=sqlerror2&email=".$email);
                        exit();
                    }
                    else {
                        mysqli_stmt_bind_param($stmt, "s", $email);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $row = mysqli_fetch_assoc($result);

                        session_start();
                        $_SESSION['email'] = $row["email"];
                        $_SESSION['first_name'] = $row["first_name"];
                        $_SESSION['last_name'] = $row["last_name"];

                        header("Location: ../index.php?login=success&sessionemail=".$_SESSION['email']);
                        exit();
                    }
                }
                else {
                    header("Location: ../login.php?error=wrongpin&email=".$email);
                    exit();
                }
            }
            else {
                header("Location: ../login.php?error=nouser&email=".$email);
                exit();
            }
        }

    }
    else {
        header("Location: ../index.php");
        exit();
    }
?>
