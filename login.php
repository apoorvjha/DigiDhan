<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="index.css">
<link rel="shortcut icon" href="SUPPORT_PIC/logo.jpeg" />  <!-- For inserting custom mini icon on the title tab of web pages -->
</head>
<body>
<?php
session_start();

#++++++++++++++++++++++++++++++++++++++   user supplied data +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$user_name=$_POST["uname"];
$password=$_POST["password"];
$email=$_POST["email"];
#++++++++++++++++++++++++++++++++++++++ End of user supplied data +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

#++++++++++++++++++++++++++++++++++++++  Server credentials  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$server_address="localhost";
$server_user="root";
$server_password="";
$server_database="DigiDhan";
#++++++++++++++++++++++++++++++++++++++  End of Server credentials  +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$con=mysqli_connect($server_address,$server_user,$server_password,$server_database);
if(!$con)
{
	echo'<div class="error"><h1>ERROR</h1><br><font color="red">The connection to the server is temporarily lost, Please try again later. You are being redirected to login page.<script>function err(){window.location.href="login.html";}setTimeout(err,2000);</script></div>';
}
else
{
$query="SELECT * FROM `user`";
	if($is_query_run=mysqli_query($con,$query))
	{
		while($query_execute=mysqli_fetch_assoc($is_query_run))
		{
#++++++++++++++++++++++++++++++++++++++++  Data fetched into dictionary "$query_execute" +++++++++++++++++++++++++++++++++++++
			$uid=$query_execute["User_Id"];
			$uname=$query_execute["User_Name"];
			$upwd=$query_execute["User_Password"];
			$umail=$query_execute["User_Mail"];
			$uas=$query_execute["User_Active_Status"];
			$uprofile=$query_execute["User_Profile"];
			$utype=$query_execute["User_Type"];
			$acc=$query_execute["Bank_Account_Number"];
#+++++++++++++++++++++++++++++++++++++++  End of data fetch operation ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			if($uname===$user_name && $upwd===$password && $umail===$email)
			{
#++++++++++++++++++++++++++++++++++++++ Setting up session variables  +++++++++++++++++++++++++++++++++++++++++++++++++++++++++
				$_SESSION["User_Id"]=$uid;
				$_SESSION["User_Name"]=$uname;
				$_SESSION["User_Mail"]=$umail;
				$_SESSION["User_Active_Status"]=$uas;
				$_SESSION["User_Profile"]=$uprofile;
				$_SESSION["User_Type"]=$utype;
				$_SESSION["Bank_Account_Number"]=$acc;


				if($_SESSION["User_Type"]!='super')
				{
#++++++++++++++++++++++++++++++++++++++  Server credentials  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
#$server_address="localhost";
#$server_user="root";
#$server_password="";
#$server_database="DigiDhan";
#++++++++++++++++++++++++++++++++++++++  End of Server credentials  +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
#$con=mysqli_connect($server_address,$server_user,$server_password,$server_database);
#if(!$con)
#{
#	echo'<div class="error"><h1>ERROR</h1><br><font color="red">The connection to the server is temporarily lost, Please try again later. You are being redirected to contact page.<script>function err(){window.location.href="contact_us.php";}setTimeout(err,2000);</script></div>';
#}
#else
#{
$q="SELECT * FROM `user` WHERE `User_Type`='super'";
if($is_query_run=mysqli_query($con,$q))
{
while($query_execute=mysqli_fetch_assoc($is_query_run))
{
$uname_super=$query_execute["User_Name"];
$uprofile_super=$query_execute["User_Profile"];
$tid=$query_execute["User_Id"];
}
}
$_SESSION["To_User_Id"]=$tid;
$_SESSION["To_User_Name"]=$uname_super;
$_SESSION["To_User_Profile"]=$uprofile_super;
}					

#++++++++++++++++++++++++++++++++++++++ End of setting session variables +++++++++++++++++++++++++++++++++++++++++++++++++++++

#++++++++++++++++++++++++++++++++++++++ Redirecting user to home page +++++++++++++++++++++++++++++++++++++++++++++++++++++++
				echo'<script>window.location.href="index.php"</script>';
#++++++++++++++++++++++++++++++++++++++ End of redirection ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			}
		}
	echo'<div class="error"><h1>ERROR</h1><br><font color="red">The credentials used for login are incorrect, Please try again later after validating the login credentials. You are being redirected to login page.<script>function err(){window.location.href="login.html";}setTimeout(err,2000);</script></div>';
	}
}
?>
</body>
</html>
