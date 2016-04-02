<?php
session_start();
$p3UsernameErr=$p3PasswordErr=$p3CPasswordErr=$p3FnameErr=$p3LnameErr=$p3EmailErr="";
$p3Username=$p3Password=$p3CPassword=$p3Fname=$p3Lname=$p3Email="";
$p3CommonErr="";
$passwordtemp="";
$abcd=0;

$x=true;


//This code executes only after the user hits the submit button
if ($_SERVER["REQUEST_METHOD"] == "POST")
{

    //Checking if all the fields are set
   if(isset($_POST['username1'])&&isset($_POST['password2'])&&isset($_POST['cpassword2'])&&isset($_POST['firstname'])&&isset($_POST['lastname']))
   {

   	//Check if the username is empty
       if (empty($_POST['username1'])) 
       {
         $p3UsernameErr = "Username is required";
         $x=false;
       } 
       else 
       {
         $p3Username = p3test_input($_POST['username1']);
       }


    //Check if the password field is empty
       if (empty($_POST['password2'])) 
       {
         $p3PasswordErr = "Password is required";
         $x=false;
       } 
       else 
       { 
         $passwordtemo = p3test_input($_POST['password2']);
         $p3Password=md5($passwordtemp);
         
       }


    //Check if the confirm password field is empty

       if (empty($_POST['cpassword2'])) 
       {
         $p3CPasswordErr = "Password is required";
         $x=false;
       } 
       else 
       {
         $p3CPassword = p3test_input($_POST['cpassword2']);
       }


    //Check if the First Name is empty
       if (empty($_POST['firstname'])) 
       {
         $p3FnameErr = "First Name is required";
         $x=false;
       } 
       else 
       {
         $p3Fname = p3test_input($_POST['firstname']);


         //Check that the first name contains only letters and whitespaces
         if (!preg_match("/^[a-zA-Z ]*$/",$p3Fname)) 
         {
           $p3FnameErr = "Only letters and white space allowed";
           $x=false; 
         } 
       }

    //Check if the Last Name is empty 
    if (empty($_POST['lastname'])) 
       {
         $p3LnameErr = "Last Name is required";
         $x=false;
       } 
       else 
       {
         $p3Lname = p3test_input($_POST['lastname']);

         //Check that the last name contains only letters and whitespaces
         if (!preg_match("/^[a-zA-Z ]*$/",$p3Lname)) 
         {
           $p3LnameErr = "Only letters and white space allowed";
           $x=false; 
         }

       }


       if(!empty($_POST['email']))
       {
       //check if the email is valid and well formed
        $p3Email = p3test_input($_POST['email']);
   
     if (!filter_var($p3Email, FILTER_VALIDATE_EMAIL)) 
     {
       $p3EmailErr = "Invalid email format"; 
       $x=false;
     } 

       }

     //check that the password and the confirm password fields are matching
     if($_POST['password2']!=$_POST['cpassword2'])
     {
        $p3PasswordErr="Passwords do not match.";
        $p3CPasswordErr="Passwords do not match.";
        $x=false;
     }

     //If everything is correct then put the user information inside the database
     
     	if($x)
     {
     	//include the file which performs the database connectivity
     	require 'Database_Connectivity.php'; 

     	//insert the values entered by the user
     	$sql = "INSERT INTO Users (FirstName,LastName,Email,UserName,Password)
                VALUES ('$p3Fname','$p3Lname','$p3Email','$p3Username','$p3Password')";

        
          $resulta=mysqli_query($conn,$sql);


      $sql1="select * from `Users` where `UserName`='$p3Username'";
      $resultb=mysqli_query($conn,$sql1);
      $a=0;
      if(mysqli_num_rows($resultb)>0){
        while($row11=mysqli_fetch_array($resultb)){
          global $a;
          $a=$row11["ID"];
          $_SESSION['new_id']=$a;
          $a1=$row11["UserName"];
          $_SESSION['new_username']=$a1;

          $query2="UPDATE `users` SET `userStatus`='1' WHERE `ID`='$a'";
        $result2=mysqli_query($conn,$query2);
      

          header("Location: Friends_Window.php");

  }

}
          
        mysqli_close($conn);        


     }//end of if

     else
     {
     	$p3CommonErr= "There is some problem. Check again. Enter all the values again.";
     }

}
   else
   {
   	$p3CommonErr= "ALL FIELDS ARE NOT SET. ENTER THE VALUES AGAIN.";
   }

}

function p3test_input($data) 
{
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

?>



<!DOCTYPE html>
<html>
<head>
	<title>LOGIN PAGE 2</title>
	<style>
	body
	{
		background-color:Aqua;
	}
	#p3division1
	{
		margin:40px;
		margin-top:120px;
		margin-left:475px;
	}
	.page3
	{
	text-align: center;
	color:black;
	width:300px;
	height:25px;
	font-size:20px;
	}
	.p3error
	{
		color:red;
	}
  #tptp
  {
    background-color: red;
  }
	</style>
</head>
<body>


	<div id="p3division1">
		<h2 class="page3">ENTER THE DETAILS BELOW:</h2>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		<input type="text" name="username1" value="<?php echo $p3Username;?>"placeholder="Enter the username:" id="p2username" class="page3"><span class="p3error">*<?php echo $p3UsernameErr;?></span>
		<br>
		<br>
		<input type="password" name="password2" placeholder="Enter the password" id="p2password" class="page3"><span class="p3error">*<?php echo $p3PasswordErr;?></span>
		<br>
		<br>
		<input type="password" name="cpassword2" placeholder="Enter the password again" id="p2cpassword" class="page3"><span class="p3error">*<?php echo $p3CPasswordErr;?></span>
		<br>
		<br>
		<input type="text" name="firstname" value="<?php echo $p3Fname;?>" placeholder="Enter the First Name:" id="p2firstname" class="page3"><span class="p3error">*<?php echo $p3FnameErr;?></span>
		<br>
		<br>
		<input type="text" name="lastname" value="<?php echo $p3Lname;?>" placeholder="Enter the Last Name:" id="p2lastname" class="page3"><span class="p3error">*<?php echo $p3LnameErr;?></span>
		<br>
		<br>
		<input type="text" name="email" value="<?php echo $p3Email;?>" placeholder="Enter the Email:" id="p2email" class="page3"><span class="p3error"><?php echo $p3EmailErr;?></span>
		<br>
		<br>
		<input type="submit" name="p3submit" value="SUBMIT" id="tptp" class="page3">
		<br>
		<br>
		<h1 class="page3"><?php echo $p3CommonErr;?></h1>
	</form>
    </div>
</body>
</html>