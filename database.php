<?php
$hostname = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "carabao_center";
$conn = mysqli_connect($hostname, $dbUser, $dbPassword, $dbName );
if(!$conn){
    die("Something went wrong");
}


?>