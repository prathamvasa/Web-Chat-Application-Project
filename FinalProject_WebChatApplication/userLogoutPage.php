<?php
session_start();
$id_id=$_SESSION['new_id'];

require 'Database_Connectivity.php';

//Setting the status of the user as 0 after logout
$query5="UPDATE `users` SET `userStatus`='0' WHERE `ID`='$id_id'";
$result5=mysqli_query($conn,$query5);


//Destroying the session
session_unset();
session_destroy();
header('Location:Web_Project_Login_Page_1.php');
?>