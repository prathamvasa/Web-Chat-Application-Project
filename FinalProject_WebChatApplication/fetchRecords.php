<?php

require 'Database_Connectivity.php';
    
    $name1 = $_GET['name1'];
    $name2 = $_GET['name2'];

    $user_name1;
    $user_name2;
    $username1=array();
    $timestamp=array();
    $message=array();
    $i=0;

    $query="
      Select `firstUsername`,`messages`, `currentTime` from `chatmessages` where `firstUsername`='$name1' AND `secondUsername` = '$name2'
      UNION
      Select `firstUsername`,`messages`, `currentTime` from `chatmessages` where `firstUsername`='$name2' AND `secondUsername` = '$name1'
      ORDER BY `currentTime`
    ";

    $result1=mysqli_query($conn,$query);
    $query_num_rows = mysqli_num_rows($result1);

    if($query_num_rows>0){
      $count = mysqli_num_rows($result1);
      while($query_row1=mysqli_fetch_array($result1))
      {

        global $username1,$timestamp,$message;
        global $i;
        global $name1,$name2;
        global $user_name1,$user_name2;

        
        $username1[$i]=$query_row1['firstUsername'];
        
        
        $timestamp[$i]= $query_row1['currentTime'];
        
        $message[$i]=$query_row1['messages'];
        
        $i++;
      }

      for($x=0;$x<$count;$x++){
        echo nl2br($username1[$x].'  '.$timestamp[$x].'  '.$message[$x]."\n");
      }
    }   
?>
