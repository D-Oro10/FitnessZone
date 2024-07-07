<?php

    $sname= "localhost:3306";
    $unmae= "root";
    $password = "";
    $db_name = "dba_gym";

    $conn = mysqli_connect($sname, $unmae, $password, $db_name);

    if (!$conn) {
        echo "Connection failed!";
    }