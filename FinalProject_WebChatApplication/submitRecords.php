<?php
    

$serverName="localhost";
$dbName="PrathamVasa";
$userNameMain="root";
$passwordMain="";

// Create connection
$conn = mysqli_connect($serverName, $userNameMain, $passwordMain,$dbName);

//check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


    
    $friend1name = $_POST['userName1'];
    $friendname2 = $_POST['userName2'];
    $actual_chat_message = $_POST['messageBetween'];

    //Displaying the time in a correct format
    $datevalue=new DateTime("now",new DateTimeZone('America/Los_Angeles'));
    $timevalue = (string)$datevalue->format('Y-m-d H:i:s');
    $sql="INSERT INTO `chatmessages`(`firstUsername`,`secondUsername`,`messages`, `currentTime`) values ('$friend1name', '$friendname2', '$actual_chat_message', '$timevalue')";

    if (mysqli_query($conn, $sql)) 
    {
    echo "New record created successfully";
} 
else 
{
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}


  mysqli_close($conn);


    
  
?>