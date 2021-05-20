<?php

    $DB_Server = "localhost:8080";
    $DB_Username = "root";
    $DB_Password = "";
    $DB_Name = "cs6400_fall2018_team123";

    $conn = mysqli_connect("localhost","root","","cs6400_fall2018_team123");
    /*
    $conn = mysqli_connect($DB_Server, $DB_Username, $DB_Password, $DB_Name);
    */
    if (!$conn) {
        die("Connection to database failed: ".mysqli_connect_error());
    }



?>
