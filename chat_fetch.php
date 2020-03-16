<?php
session_start();
if(!isset($_SESSION["User_Name"]))
{echo'<script>window.location.href="index.php";</script>';
}
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
	$query="SELECT * FROM `chat` WHERE `User_Id`=".$_SESSION["User_Id"]." OR `To_User`=".$_SESSION["User_Id"];
	if($is_query_run=mysqli_query($con,$query))
	{
		while($query_execute=mysqli_fetch_assoc($is_query_run))
		{
			$uid=$query_execute["User_Id"];
			$to_uid=$query_execute["To_User"];
			$msg=$query_execute["Message"];
			$ts=$query_execute["Timestamp"];
			$sts=$query_execute["Read_Message"];
			if($uid===$_SESSION["User_Id"] && $to_uid==$_SESSION["To_User_Id"])
			{
				echo'<br><div class="message1">';
				echo'<img src="'.$_SESSION["User_Profile"].'" class="profile">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="white">'.$msg.'</font><br><font color="gray">'.$ts;
				if($sts==0)
				{
					echo'&nbsp;&nbsp;&nbsp; Read';
				}
				else
				{
					echo'&nbsp;&nbsp;&nbsp; Sent';
				}
				echo'</font></div><br>';
			}
			if($to_uid===$_SESSION["User_Id"] && $uid==$_SESSION["To_User_Id"])
			{
				echo'<br><div class="message2">';
				echo'<img src="'.$_SESSION["To_User_Profile"].'" class="profile">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="white">'.$msg.'</font><br><font color="gray">'.$ts;
				$query1="UPDATE `chat` SET `Read_Message`=0 WHERE `To_User`=".$_SESSION["User_Id"];
				if(mysqli_query($con,$query1))
				{
				}
					echo'</font></div><br>';
			}
		}
	}
}
?>
