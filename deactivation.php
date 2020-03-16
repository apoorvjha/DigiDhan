<?php
session_start();
if(!isset($_SESSION["User_Name"]))
{
echo'<script>window.location.href="index.php";</script>';
}
$email=$_POST["mail"];  # LINK parameter mail (user mail)
$acc=$_POST["acc"];  # LINK parameter mail (user account)
#++++++++++++++++++++++++++++++++++++++  Server credentials  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$server_address="localhost";
$server_user="root";
$server_password="";
$server_database="DigiDhan";
#+++++++++++++++++++++++++++++++++++++++ end of server credentials ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$con=mysqli_connect($server_address,$server_user,$server_password,$server_database);
if(!$con)
{
	echo'<div class="error"><h1>ERROR</h1><br><font color="red">The connection to the server is temporarily lost, Please try again later. You are being redirected to admin pannel.<script>function err(){window.location.href="admin_pannel.php";}setTimeout(err,2000);</script></div>';
}
else
{
	$query="UPDATE `user` SET `User_Active_Status`=0 WHERE `Bank_Account_Number`=$acc AND `User_Mail`='$email'";
	$query1="UPDATE `activation` SET `Response`=0 WHERE `User_Mail`='$email'";
	if(mysqli_query($con,$query) && mysqli_query($con,$query1))
	{
#+++++++++++++++++++++++++++++++ Activation Successful !!!! ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		echo'<script>window.location.href="admin_pannel.php";</script>';
	}

}

