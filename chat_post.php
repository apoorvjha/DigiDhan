<?php
session_start();
$msg=$_POST["msg"];
#++++++++++++++++++++++++++++++++++++++  Server credentials  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$server_address="localhost";
$server_user="root";
$server_password="";
$server_database="DigiDhan";
#++++++++++++++++++++++++++++++++++++++  End of Server credentials  +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$con=mysqli_connect($server_address,$server_user,$server_password,$server_database);
if(!$con)
{
	echo'<div class="error"><h1>ERROR</h1><br><font color="red">The connection to the server is temporarily lost, Please try again later. You are being redirected to contact page.<script>function err(){window.location.href="contact_us.php";}setTimeout(err,2000);</script></div>';
}
else
{
date_default_timezone_set("India/New_Delhi");
$uid_super=0;
$q="SELECT * FROM `user` WHERE `User_Type`='super'";
$cur_date_time=date("d-M-Y::H:i");
if($is_query_run=mysqli_query($con,$q))
{
while($query_execute=mysqli_fetch_assoc($is_query_run))
{
$uid_super=$query_execute["User_Id"];
}
}
	if($_SESSION["User_Type"]!='super')
	{
		$query="INSERT INTO `chat`(`User_Id`,`Message`,`To_User`,`Read_Message`) VALUES(".$_SESSION["User_Id"].",'$msg',$uid_super,1)";
	}
	else
	{
		$query="INSERT INTO `chat`(`User_Id`,`Message`,`To_User`,`Read_Message`) VALUES($uid_super,'$msg',".$_SESSION["To_User_Id"].",1)";
	}
if(mysqli_query($con,$query))
{
echo'<script>window.location.href="chat_contact.php";</script>';
}
}


?>
