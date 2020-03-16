<?php
$id=$_POST["vid"];
$bank_name=$_POST["bank_name"];
#++++++++++++++++++++++++++++++++++++++  Server credentials  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$server_address="localhost";
$server_user="root";
$server_password="";
$server_database="DigiDhan";
#++++++++++++++++++++++++++++++++++++++  End of Server credentials  +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$con=mysqli_connect($server_address,$server_user,$server_password,$server_database);
if(!$con)
{
	echo'<div class="error"><h1>ERROR</h1><br><font color="red">The connection to the server is temporarily lost, Please try again later. You are being redirected to home page.<script>function err(){window.location.href="index.php";}setTimeout(err,2000);</script></div>';
}
else
{
$query="DELETE FROM `ventures` WHERE `Venture_Id`=$id";
$query1="DELETE FROM `user` WHERE `Bank_Name`='$bank_name' AND `User_Type`!='super' AND `User_Type`!='admin'";
	if(mysqli_query($con,$query) && mysqli_query($con,$query1))
	{
		echo'<script>window.location.href="admin_pannel.php";</script>';
	}
}

?>
