<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="CorkBoardIt - A lite photo sharing website.">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CorkBoardIt</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <style>
        body {
            padding-top: 70px;
            padding-bottom: 40px;
        }
        .login-form {
            width: 340px;
            margin: 50px auto;
        }
        .login-form form {
            margin-bottom: 15px;
            background: #f7f7f7;
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
            padding: 30px;
        }
        .login-form h2 {
            margin: 0 0 15px;
        }
        .form-control, .btn {
            min-height: 38px;
            border-radius: 2px;
        }
        .btn {
            font-size: 15px;
            font-weight: bold;
        }
        .row.no-gutters {
            margin-right: 0;
            margin-left: 0;
        }
        .row.no-gutters > [class^="col-"],
        .row.no-gutters > [class*=" col-"] {
            padding-right: 0;
            padding-left: 0;
        }
    </style>
	<style>
		.footer {
		  position: fixed;
		  left: 0;
		  bottom: 0;
		  width: 100%;
		  /* Set the fixed height of the footer here */
		  height: auto;
		  background-color: white;
		}
	</style>
</head>
<body>
    <header>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand">CorkBoardIt</a>
                </div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="index.php">Home</a></li>
                </ul>
				<ul class="nav navbar-nav navbar-right">
                    <li><a href="AboutUs.php">About Us</a></li>
					<?php
						if (isset($_SESSION['email'])) {
							echo '<li><a class="btn" href="includes/logout_action.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>';
						}
						else {
							echo '<li><a class="btn" href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
						}
					?>
				</ul>
            </div>
        </nav>
    </header>
