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
#+++++++++++++++++++++++++++++++++++++++ end of server credentials ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$con=mysqli_connect($server_address,$server_user,$server_password,$server_database);
if(!$con)
{
	echo'<div class="error"><h1>ERROR</h1><br><font color="red">The connection to the server is temporarily lost, Please try again later. You are being redirected to login page.<script>function err(){window.location.href="login.html";}setTimeout(err,2000);</script></div>';
}
else
{
if(isset($_POST["uname"]))
{
$query="UPDATE `user` SET `User_Name`='".$_POST["uname"]."' WHERE `User_Id`=".$_SESSION["User_Id"];
if(mysqli_query($con,$query))
{$_SESSION["User_Name"]=$_POST["uname"];
echo'<script>window.location.href="services.php";</script>';
}
}
if(isset($_POST["umail"]))
{
$query="UPDATE `user` SET `User_Mail`='".$_POST["umail"]."' WHERE `User_Id`=".$_SESSION["User_Id"];
if(mysqli_query($con,$query))
{$_SESSION["User_Mail"]=$_POST["umail"];
echo'<script>window.location.href="services.php";</script>';
}
}
if(isset($_FILES["uprofile"]["name"]))
{
$i=0;
$ext='';                  # extension of the image
$type=$_FILES["uprofile"]["type"];
while($i<strlen($type))
{
	if($type[$i]!=='/')
	{
		$i+=1;
	}
	else
	{
		break;
	}
}
$i+=1;
while($i<strlen($type))
{
	$ext=$ext.$type[$i];
	$i+=1;
}
if($type!=='image/jpg' && $type!=='image/jpeg' && $type!=='image/png')
	{

		echo'<div class="error"><h1>ERROR</h1><br><font color="red">Unsupported image file type is uploaded. Please upload your profile picture in either jpg, jpeg or png format only. You will be redirected to registration page shortly<script>function err(){window.location.href="register.php";}setTimeout(err,2000);</script></div>';
	}
$query="UPDATE `user` SET `User_Profile`='PROFILE_PIC/".$_SESSION["User_Name"].".$ext' WHERE `User_Id`=".$_SESSION["User_Id"];
if(mysqli_query($con,$query))
{
move_uploaded_file($_FILES['uprofile']['tmp_name'],"PROFILE_PIC/".$_SESSION["User_Name"].".$ext");
$_SESSION["User_Profile"]="PROFILE_PIC/".$_SESSION["User_Name"].".$ext";
echo'<script>window.location.href="services.php";</script>';
}
}



}
?>
