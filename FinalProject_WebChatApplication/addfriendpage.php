<?php
session_start();
require 'Database_Connectivity.php';

$friendName=$_POST['makhija'];
$friendID=0;



$query_check="Select * from `users` where `UserName`='$friendName'";
$result_check=mysqli_query($conn,$query_check);

if(mysqli_num_rows($result_check)>0)
{
  while($query_row=mysqli_fetch_array($result_check))
  {
    global $friendID;
    $friendID=$query_row['ID'];
    echo $friendID;

  }

}
else
{
  $error="Username you entered does not exist";
  $_SESSION['error']=$error;
}

$fw_userId=$_SESSION['new_id'];

$query_insert="Insert into `friends`(`user_id1`,`user_id2`) values ('$fw_userId','$friendID') ";
mysqli_query($conn,$query_insert);
$query_insert1="Insert into `friends`(`user_id1`,`user_id2`) values ('$friendID','$fw_userId') ";
mysqli_query($conn,$query_insert1);
header("Location: Friends_Window.php");

?>