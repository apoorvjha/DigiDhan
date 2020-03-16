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
$_SESSION["To_User_Id"]=$i;
$query="SELECT * FROM `user` WHERE `User_Id`=$i";
if($is_query_run=mysqli_query($con,$query))
{
while($query_execute=mysqli_fetch_assoc($is_query_run))
{
$_SESSION["To_User_Name"]=$query_execute["User_Name"];
$_SESSION["To_User_Profile"]=$query_execute["User_Profile"];
}
}
#echo $_SESSION["To_User_Id"];
echo'<script>window.location.href="chat_contact.php";</script>';
}
?>

