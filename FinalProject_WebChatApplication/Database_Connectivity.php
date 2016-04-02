<?php
$serverName="localhost";
$dbName="PrathamVasa";
$userNameMain="root";
$passwordMain="";

// Create connection
$conn = mysqli_connect($serverName, $userNameMain, $passwordMain,$dbName);

// Check connection
if (!$conn) 
{
    die("Connection failed: " . mysqli_connect_error());
}


?>

