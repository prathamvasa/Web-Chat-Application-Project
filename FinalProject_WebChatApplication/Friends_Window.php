<?php
//Start the session for the user
session_start();

$fw_username1=$_SESSION['new_username'];
$fw_userId=$_SESSION['new_id'];
$no_friends="";

//Establish the connection with the database
require 'Database_Connectivity.php';


echo "<form action='userLogoutPage.php'>";
echo "<input type='submit' name='llogout' value='LOGOUT' id='logoutId' style='float:right;width:150px;height:50px;background-color:red;margin-right:30px'>";
echo "</form>";
echo "<h1>The person who has logged in right now is: ".$_SESSION['new_username']."</h1>";

//If the friend username is not found on the database
if(isset($_SESSION['error']))
{
  echo "<h1>".$_SESSION['error']."</h1>";

}

$_SESSION['error']="";

echo "<h2>Your friends are as follows:</h2>";


//Initially, search for the id corresponding to the username who is logged in
$sql = "SELECT `ID` FROM `Users` WHERE `UserName`='$fw_username1'";
$result = mysqli_query($conn, $sql);
$x=0;
$undne="";
$y=0;
$i1=0;
$arr=array();
$arr_index=0;
$arr_count=0;
$id_array=array();

if (mysqli_num_rows($result) > 0) 
{
    
    while($row = mysqli_fetch_array($result))
     {
     	global $x;
        $x=$row["ID"];
        
     }
}

$sql="SELECT `user_id2` FROM `friends` WHERE `user_id1`='$x'";
$result=mysqli_query($conn,$sql);

if(mysqli_num_rows($result)>0)
{
    //output the data of each row
    while($row=mysqli_fetch_array($result))
    {  
       global $y,$conn,$arr,$arr_index,$i;
       $y=$row["user_id2"];
       $sql1="SELECT `UserName` FROM `Users` WHERE `ID`='$y'";
       $result1=mysqli_query($conn,$sql1);
       if(mysqli_num_rows($result1)>0)
       {
       	while($row1=mysqli_fetch_array($result1))
       	{
       		$arr[$i]=$row1["UserName"];
       		$i=$i+1;

       	}
       }

    }


}

else
{
	$no_friends="No friends found. Press the ADD FRIEND button to add a new friend.";
}



//Collecting the ids of all the friends of the user who is logged in currently
$query1="SELECT * from `friends` WHERE `user_id1`='$fw_userId'";

  $result1=mysqli_query($conn,$query1);


  if(mysqli_num_rows($result1)>0)
  {
    
    while($query_row1=mysqli_fetch_array($result1))
    {
      global $i1;
      global $id_array;
      $id_array[$i1]=$query_row1['user_id2'];
      $i1++;
   
    }
  }






$arr_count=count($arr);




//Function to check if the user is logged in or not
function userLoggedin()
{
  if(isset($_SESSION['new_username'])&& !empty($_SESSION['new_username']))
  {
    return true;
  }
  else
  {
    return false;
  }

}


if(userLoggedin())
{
    $user_name=$_SESSION['new_username'];
    
}

  else 
  {
    header('Location:Web_Project_Login_Page_1.php'); 
  }





?>


<!DOCTYPE html>
<html>
<head>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<title>FRIENDS WINDOW</title>
<style>
body
{
	background-color: Aqua;
}
</style>

</head>
<body>

<h2><?php echo $no_friends;?></h2>


<script>
//Copying the count from php code to javascript code
var arr_count1=<?php echo $arr_count;?>;
var id_of_current_user='<?php echo $fw_userId ; ?>';
var un_of_current_user='<?php echo $fw_username1 ; ?>';
var sample_user_id=0;
var sample_friend_name=" ";

var js_arr_username=new Array();
var js_arr_ids=new Array();

//Copying the array of usernames from php to javascript
<?php foreach($arr as $key => $val){ ?>
js_arr_username.push('<?php echo $val; ?>');
    <?php } ?>

//Copying the array of ids from php to javascript
<?php foreach($id_array as $key => $val){ ?>
js_arr_ids.push('<?php echo $val; ?>');
    <?php } ?>




//Creating the divisions equivalent to the number of friends of the logged in user
for (var x11=0;x11<arr_count1;x11++) 
{
	

		var division=document.createElement("div")
		division.id="division"+x11+"";
		

		division.style.width="15%";
		division.style.height="50px";
		division.style.backgroundColor="yellow";

    division.style.textAlign="center";

		//Displaying the name of the friend within the div element
		division.innerHTML="<h3>"+js_arr_username[x11]+"</h3>";

    //Giving the attribute properties of username and ids to each username formes division element
    division.setAttribute('data-user-id', js_arr_ids[x11]);
    division.setAttribute('data-user-name', js_arr_username[x11]);
	
		document.body.appendChild(division);
  

}

    

for (var x11 = 0; x11 < arr_count1; x11++)
 {
  document.getElementById("division"+x11+"").addEventListener("click", function(x11)
  {
 

      var sample_user_id = x11.toElement.getAttribute('data-user-id');
      sample_friend_name = x11.toElement.getAttribute('data-user-name');

      document.getElementById("para1").innerHTML = '';

      //Creating the chat box text area
      var div1 = document.createElement('div');
      div1.setAttribute('id', 'chat1');
      div1.setAttribute('style', 'height:200px;width:50em;border: 1px solid; overflow:scroll;margin-left:200px;background-color:LawnGreen');
      document.getElementById('para1').appendChild(div1);



      var break_line1=document.createElement("br");
      document.getElementById('para1').appendChild(break_line1);

      var break_line2=document.createElement("br");
      document.getElementById('para1').appendChild(break_line2);
      

      //Creating the input field to feed the messages
      var user_msg1 = document.createElement("input");
      user_msg1.setAttribute('name', 'message_from_user1');
      user_msg1.setAttribute('id', 'message_from_user_id1');
      user_msg1.setAttribute('type', 'text');
      user_msg1.style.marginLeft="400px";
      user_msg1.style.height="50px";
      user_msg1.style.width="250px";
      
      document.getElementById('para1').appendChild(user_msg1);
      

      //Creating the SEND message button
      var send_button1 = document.createElement("input");
      send_button1.setAttribute('name', 'submitted_msg_from_user1');
      send_button1.setAttribute('id', 'submitted_msg_from_user_id1');
      send_button1.setAttribute('type', 'submit');
      send_button1.setAttribute('value', 'Send');
      send_button1.setAttribute('data-user-name', sample_friend_name);
      send_button1.setAttribute('onclick', 'submit_message()');
      send_button1.style.height="50px";
      send_button1.style.width="100px";

      
      document.getElementById('para1').appendChild(send_button1);

      var describe = document.createElement('h2');
      describe.innerHTML = "Chatting with: <b>" + sample_friend_name+"</b>";
      document.getElementById('para1').appendChild(describe);

  });



  //AJAX call to post the messages into the database
  function submit_message()
  {
    var message1 = document.getElementById('message_from_user_id1').value;
    var friend_id_name = document.getElementById('submitted_msg_from_user_id1').getAttribute('data-user-name');
    var object = {userName1: un_of_current_user, userName2: friend_id_name , messageBetween: message1};
    $.ajax
    ({ 
      type: "post",
      url: "submitRecords.php",
      data: {userName1: un_of_current_user, userName2: friend_id_name , messageBetween: message1},
      success:  function(abfg)
      {
        console.log(abfg);
        fetch_message();
        
      }
    });
  }

  
  //AJAX call to fetch the message from the database
  function fetch_message()
  {
    var friend_name1 = sample_friend_name;
    $.ajax({ 
    type: "get",
    url: "fetchRecords.php",
    data: {name1:un_of_current_user, name2:friend_name1},
    success:  function(data){
    document.getElementById('chat1').innerHTML = '';
    var data_el = document.createElement('div');
    data_el.innerHTML = data;
    document.getElementById('chat1').appendChild(data_el);
    var elem = document.getElementById('chat1');
    elem.scrollTop = elem.scrollHeight;
      }
    });
    setTimeout(function()
    {
      fetch_message();
    }, 1000)
  } 






  }//end of for loop

window.onload = fetch_message;
</script>



<p id="para1"></p>

<form action="addfriendpage.php" method="post">
<input type="submit" name="fw_submit" value="ADD FRIEND" id="add_friend_button" style="width:20%;height:50px;background-color:green;margin-top:15px">
<input type="text" name="makhija" id="makhija1" style="width:200px;height:38px;marginLeft:10px" placeholder="Enter Friend's Username">
</form>

<p id="para3"><?php echo $undne;?></p>


</body>
</html>