<?php
session_start();
if(!isset($_SESSION["User_Name"]))
{echo'<script>window.location.href="index.php";</script>';
}
$id=$_POST["id"];
$email=$_POST["email"];  
$acc=$_POST["bank_name"];  
$logo=$_FILES['logo']['name'];
$type=$_FILES['logo']['type'];
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
	$i=0;
	$ext='';                  # extension of the image
#+++++++++++++++++++++++++++++++++++++ extracting extension of the image  +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
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

#++++++++++++++++++++++++++++++++++++++ end of extraction of the extension of image +++++++++++++++++++++++++++++++++++++++++++++++++++++++

#++++++++++++++++++++++++++++++++++++++ check wheather the image extension is of accepted type or not +++++++++++++++++++++++++++++++++++++
	if($type!=='image/jpg' && $type!=='image/jpeg' && $type!=='image/png')
	{
		echo'<div class="error"><h1>ERROR</h1><br><font color="red">Unsupported image file type is uploaded. Please upload logo in either jpg, jpeg or png format only. You will be redirected to admin pannel page shortly<script>function err(){window.location.href="admin_pannel.php";}setTimeout(err,2000);</script></div>';
	}
#++++++++++++++++++++++++++++++++++++++ end of extension type checking ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	$con=mysqli_connect($server_address,$server_user,$server_password,$server_database);
	if(!$con)
	{
		echo'<div class="error"><h1>ERROR</h1><br><font color="red">The connection to the server is temporarily lost, Please try again later. You are being redirected to Home page.<script>function err(){window.location.href="login.html";}setTimeout(err,2000);</script></div>';
	}
	else
	{
		$query="INSERT INTO `ventures` VALUES ('$acc',$id,'$email','VENTURES_PIC/$acc.$ext')"; 
		if(mysqli_query($con,$query))
		{
			move_uploaded_file($_FILES['logo']['tmp_name'],"VENTURES_PIC/$acc.$ext");
			echo'<script>window.location.href="admin_pannel.php";</script></div>';
		}
		else
		{
			echo'query error';
		}



	}
}
?>
