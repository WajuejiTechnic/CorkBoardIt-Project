<?php
    if (isset($_POST['signup-submit'])) {

        require "dbh.php";

        //Set passed parameters
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $email = $_POST["email"];
        $pin = $_POST["pin"];
        $pin_repeat = $_POST["pin-repeat"];

        //Validate passed parameters
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z]*$/", $first_name) || !preg_match("/^[a-zA-Z]*$/", $last_name)) {
            header("Location: ../signup.php?error=invalidemailname");
            exit();
        }
        else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: ../signup.php?error=invalidemail&fname=".$first_name."&lname=".$last_name);
            exit();
        }
        else if (!preg_match("/^[a-zA-Z]*$/", $first_name) || !preg_match("/^[a-zA-Z]*$/", $last_name)) {
            header("Location: ../signup.php?error=invalidname&email=".$email);
            exit();
        }
        else if (!preg_match("/^[0-9]*$/", $pin) || !preg_match("/^[0-9]*$/", $pin_repeat)) {
            header("Location: ../signup.php?error=invalidpin&fname=".$first_name."&lname=".$last_name."&email=".$email);
            exit();
        }
        else if ($pin !== $pin_repeat) {
            header("Location: ../signup.php?error=passwordcheck&fname=".$first_name."&lname=".$last_name."&email=".$email);
            exit();
        }
        //Signup User
        else {
            $sql = "SELECT email FROM `User` WHERE email=?";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../signup.php?error=sqlerror1");
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $resultCheck = mysqli_stmt_num_rows($stmt);
                if ($resultCheck > 0) {
                    header("Location: ../signup.php?error=emailtaken&fname=".$first_name."&lname=".$last_name);
                    exit();
                }
                else {
                    $sql = "INSERT INTO `User` VALUES (?, ?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ../signup.php?error=sqlerror2");
                        exit();
                    }
                    else {
                        /* $hashedPIN = password_hash($pin, PASSWORD_DEFAULT) */
                        /* if we hash the pin, we will need to alter the pin attribute of User */

                        mysqli_stmt_bind_param($stmt, "ssss", $email, $pin, $first_name, $last_name);
                        mysqli_stmt_execute($stmt);
                        header("Location: ../signup.php?signup=success");
                        exit();
                    }
                }
            }
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);

    }

    else {
        header("Location: ../signup.php?signup");
        exit();
    }
?>
