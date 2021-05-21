<?php

$hostname = "127.0.0.1";
$username = "root";
$password = "";
$database = "job_portal";

$con = mysqli_connect($hostname, $username, $password);

if (!$con) {
    die("connection failed");
} else {
    mysqli_select_db($con, $database);
}
