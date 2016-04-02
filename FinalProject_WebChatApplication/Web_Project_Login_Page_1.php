<?php
session_start();

$p2UsernameErr=$p2PasswordErr="";
$p2CommonErr="";
$p2Username=$p2Password="";
$something1=$something2=0;
$status=0;
$y=true;
$oneLove=$twoLove="";

//This code executes after the user hits the submit button
if ($_SERVER["REQUEST_METHOD"] == "POST")
{

	//Checking if all the fields are set
	if(isset($_POST['username1'])&&isset($_POST['password1']))
	{
       
       //Check if the username field is empty
        if (empty($_POST['username1'])) 
       {
         $p2UsernameErr = "Username is required";
         $y=false;
       }
       else
       {
         $p2Username=$_POST['username1'];
       } 
      
	   //Check if the password field is empty
	   if (empty($_POST['password1'])) 
       {
         $p2PasswordErr = "Password is required";
         $y=false;
       } 

       else
       {
       	$p2Password=$_POST['password1'];
       }
       

       if($y)
       {
       	require 'Database_Connectivity.php';
       	$query="Select * from `Users` where `UserName`='$p2Username' and `Password`='$p2Password' ";
       	$result=mysqli_query($conn,$query);

       	if(mysqli_num_rows($result)!=0)
       	{   

       		$oneLove="Username and Password found successfully";
       		while($row=mysqli_fetch_array($result))
       		{
       			global $something1,$something2,$status,$twoLove;
       			$something1=$row["UserName"];
       			$something2=$row["ID"];
       		}
       		$_SESSION['new_username']=$something1;
       		$_SESSION['new_id']=$something2;


       		//Checking if the user has already logged in or not
            $query1="SELECT `userStatus` from `users` where `ID`='$something2'";
            $result1=mysqli_query($conn,$query1);
            while($row1=mysqli_fetch_array($result1))
            {	
               $status=$row1["userStatus"];
               if($status==0)
               {
               	$query2="UPDATE `users` SET `userStatus`='1' WHERE `ID`='$something2'";
               	$result2=mysqli_query($conn,$query2);
               	//go to the friends list window
               	header('Location:Friends_Window.php');

               }
               else
               {
               	$twoLove="However user is already logged in";
               }
               
            }



       	}//end of if loop

       
       else
       {
       	$p2CommonErr="Username or Password is invalid.";
       }

       }

       else
       {
       	$p2CommonErr= "There is some problem. Check again. Enter all the values again.";
       }
    }
      
	else
	{
		$p2CommonErr= "ALL FIELDS ARE NOT SET. ENTER THE VALUES AGAIN.";
	}
}
?>


<!DOCTYPE html>
<html>
<head>
	<title>LOGIN PAGE 1</title>
	<style>
	body
	{
		background-color:Aqua;
	}
	.page2
	{
	text-align: center;
	color:black;
	width:225px;
	height:35px;
	font-size:20px;
	}
	#p2division1
	{
		margin:40px;
		margin-top:75px;
		margin-left:500px;
	}
	.p2error
	{
		color:red;
	}
	.heading21
	{
		margin-left:500px;
    color:red;
	}
	#button_new_user
	{
		background-color: blue;
		font-family: Tahoma;
	}
	#abcdef
	{
		background-color: red;
		font-family: Tahoma;
	}
	</style>
</head>
<body>
	<div id="p2division1">
    <h2>Existing Users:</h2>
	<form action="Web_Project_Login_NewUsers_Page_2.php">
    <h2></h2>
		<input type="submit" value="New User" id="button_new_user" class="page2">
		<br>
		<br>
	</form>
    <h2>Returning Users:</h2>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		<input type="text" name="username1" value="<?php echo $p2Username; ?>" placeholder="Enter the username:" id="button_username_1" class="page2"><span class="p2error">*<?php echo $p2UsernameErr;?></span>
		<br>
		<br>
		<input type="password" name="password1" placeholder="Enter the password" id="button_password1" class="page2"><span class="p2error">*<?php echo $p2PasswordErr;?></span>
		<br>
		<br>
		<input type="submit" name="p2submit" value="SUBMIT" id="abcdef" class="page2"><span class="p2error"><?php echo $p2CommonErr;?></span>
		
	</form>
    </div>
    <h2 class="heading21" ><?php echo $oneLove;?></h2>
    <h2 class="heading21"><?php echo $twoLove;?></h2>
</body>
</html>