<?php
session_start();
#++++++++++++++++++++++++++++++++++++++  Server credentials  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$server_address="localhost";
$server_user="root";
$server_password="";
$server_database="DigiDhan";
#+++++++++++++++++++++++++++++++++++++++ end of server credentials ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$con=mysqli_connect($server_address,$server_user,$server_password,$server_database);
if(!$con)
{
	echo'<div class="error"><h1>ERROR</h1><br><font color="red">The connection to the server is temporarily lost, Please try again later. You are being redirected to services page.<script>function err(){window.location.href="services.php";}setTimeout(err,2000);</script></div>';
}
else
{
$query="SELECT * FROM `accounts` WHERE `Bank_Account_Number`=".$_SESSION["Bank_Account_Number"];
if($is_query_run=mysqli_query($con,$query))
{
while($query_execute=mysqli_fetch_assoc($is_query_run))
{echo $query_execute["Balance"];
}
}
}
?>
