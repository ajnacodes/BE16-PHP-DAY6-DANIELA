<?php 

$localhost = "127.0.0.1";

$username = "root";

$password = "";

$dbname = "login";


// create connection
$connect = new mysqli($localhost, $username, $password, $dbname);

$connect2 = new mysqli($localhost, $username, $password, $dbname);

// check connection
if ($connect->connect_error){
    die("Connection failed: " . $connect->connect_error);
}