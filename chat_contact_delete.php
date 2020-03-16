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
$i=1;
while(!isset($_POST["$i"]))
{
$i+=1;
}
$_SESSION["To_User"]=$i;
$query="DELETE FROM `chat` WHERE `User_Id`=$i OR `To_User`=$i";
if(mysqli_query($con,$query))
{
}
echo'<script>window,location.href="index.php";</script>';
}
?>

