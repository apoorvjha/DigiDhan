<?php
session_start();
$bal=$_POST["bal"];
$ifsc=$_POST["ifsc"];
$ccn=$_POST["ccn"];
$type=$_POST["type"];
$ss1=$_FILES['ss1']['name'];
$ss2=$_FILES['ss2']['name'];
$ss3=$_FILES['ss3']['name'];
$ss4=$_FILES['ss4']['name'];
$ss5=$_FILES['ss5']['name'];
$ss6=$_FILES['ss6']['name'];
$ss7=$_FILES['ss7']['name'];
$ss8=$_FILES['ss8']['name'];
$ss9=$_FILES['ss9']['name'];
$ss10=$_FILES['ss10']['name'];

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
$query="INSERT INTO `accounts` VALUES (".$_SESSION["acc"].",$bal,'$type','$ifsc',$ccn)";
if(mysqli_query($con,$query))
{

	$j=1;
	while($j<11){
		$type1=$_FILES['ss'.$j]['type'];
		$i=0;
		$ext='';                  # extension of the image
		while($i<strlen($type1))
		{
			if($type1[$i]!=='/')
			{
				$i+=1;
			}
			else
			{
				break;
			}
		}
		$i+=1;
		while($i<strlen($type1))
		{
			$ext=$ext.$type1[$i];
			$i+=1;
		}
		if($type1!=='image/jpg' && $type1!=='image/jpeg' && $type1!=='image/png')
		{

			echo'<div class="error"><h1>ERROR</h1><br><font color="red">Unsupported image file type is uploaded. Please upload your profile picture in either jpg, jpeg or png format only. You will be redirected to registration page shortly<script>function err(){window.location.href="register.php";}setTimeout(err,2000);</script></div>';
		}
		$query1="INSERT INTO `Signature_Dataset` VALUES (".$_SESSION["acc"].",'SIGNATURE_PIC/".$_SESSION["acc"].$j.".$ext')";
		if(mysqli_query($con,$query1))
		{

			move_uploaded_file($_FILES['ss'.$j]['tmp_name'],"SIGNATURE_PIC/".$_SESSION["acc"].$j.".$ext");

		}
		else
		{
			echo $j;
		}	
		$j+=1;
	
	}
	
	echo'<script>window.location.href="admin_pannel.php";</script>';
	}
}
?>
