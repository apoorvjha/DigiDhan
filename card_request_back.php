<?php
session_start();
if(!isset($_SESSION["User_Name"]))
{echo'<script>window.location.href="index.php";</script>';
}
$ctype=$_POST["ctype"];
$ename=$_POST["ename"];
$pa=$_POST["pa"];
$ma=$_POST["ma"];
#+++++++++++++++++++++++++++++++++++ server credentials ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$server_address="localhost";
$server_user="root";
$server_password="";
$server_database="DigiDhan";
#+++++++++++++++++++++++++++++++++++ End of server credentials  +++++++++++++++++++++++++++++++++++++++++++++++++++++++

$con=mysqli_connect($server_address,$server_user,$server_password,$server_database);
if(!$con)
{
	echo'<div class="error"><h1>ERROR</h1><br><font color="red">The connection to the server is temporarily lost, Please try again later. You are being redirected to login page.<script>function err(){window.location.href="login.html";}setTimeout(err,2000);</script></div>';
}
else
{
	$query="SELECT * FROM `card_request` WHERE User_Id=".$_SESSION["User_Id"];
	if($is_query_run=mysqli_query($con,$query))
	{
		while($query_execute=mysqli_fetch_assoc($is_query_run))
		{
			$card_type=$query_execute["Card_Type"];
			$user=$query_execute["User_Id"];
			if($ctype===$card_type && $user===$_SESSION["User_Id"])
			{
				echo'<div class="error"><h1>ERROR</h1><br><font color="red">You have already requested for same card.<script>function err(){window.location.href="services.php";}setTimeout(err,2000);</script></div>';
			}
		}
		$query1="INSERT INTO `card_request` VALUES (".$_SESSION["User_Id"].",'$ctype','$ename','$pa','$ma')";
		if(mysqli_query($con,$query1))
		{
			echo'<script>window.location.href="services.php";</script>';
		}
	}
}
?>
