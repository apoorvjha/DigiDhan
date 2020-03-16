<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="index.css">
<link rel="shortcut icon" href="SUPPORT_PIC/logo.jpeg" /><!-- For inserting custom mini icon on the title tab of web pages -->
<title>Registration</title>
</head>
<body>
<div class="header">
<img src="SUPPORT_PIC/logo.jpeg" height="106px" width="200px" class="logo_img">
<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<font color="#ddd" class="logo_text"><b>DigiDhan</b></font>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
</div>
<div class="menu"><ul>
<li><a href="index.php">Home</a></li>
<li><a href="ventures.php">Ventures</a></li>
<li><a href="careers.php">Careers</a></li>
<li><a class="active" href="">Login</a></li>
<li><a href="register.php">Register</a></li>
<li><a href="about_us.php">About us</a></li>
<li><a href="contact_us.php">Contact us</a></li>
</ul>
</div>
<?php
#++++++++++++++++++++++++++++++++++++++   user supplied data +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$user_name=$_POST["uname"];
$pass=$_POST["password"];	
$email=$_POST["email"];
$profile_pic=$_FILES['user_profile']['name'];
$type=$_FILES['user_profile']['type'];
$acc=$_POST["account_no"];
$bank_name=$_POST["Bank_Name"];
#++++++++++++++++++++++++++++++++++++++  end of user supplied data ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

#++++++++++++++++++++++++++++++++++++++  Server credentials  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$server_address="localhost";
$server_user="root";
$server_password="";
$server_database="DigiDhan";
#+++++++++++++++++++++++++++++++++++++++ end of server credentials ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$i=0;
$ext='';                  # extension of the image
$flag=0;			  # variable used for checking wheather to proceed insertion of data in database or not.
#check wheather these same set of credentials already exits in the database or not!
#++++++++++++++++++++++++++++++++++++ query the database for duplicate data ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$con1=mysqli_connect($server_address,$server_user,$server_password,$server_database);
if(!$con1)
{
	echo'<div class="error"><h1>ERROR</h1><br><font color="red">The connection to the server is temporarily lost, Please try again later. You are being redirected to Home page.<script>function err(){window.location.href="login.html";}setTimeout(err,2000);</script></div>';
}
else
{
	$query="SELECT * FROM `user`";
	if($is_query_run=mysqli_query($con1,$query))
	{
		while($query_execute=mysqli_fetch_assoc($is_query_run))
		{
			$x=$query_execute["User_Name"];
			$y=$query_execute["User_Mail"];
			$z=$query_execute["Bank_Account_Number"];
			if($x===$user_name)
			{
				$flag=1;
				echo'<div class="error"><h1>ERROR</h1><br><font color="red">The user name already taken by another user. Please try another. You are being redirected to registration page.<script>function err(){window.location.href="register.php";}setTimeout(err,2000);</script></div>';
				
			}
			if($y===$email)
			{
				$flag=1;
				echo'<div class="error"><h1>ERROR</h1><br><font color="red">The user with same email id already exists. Please try again with another email id. You are being redirected to registration page.<script>function err(){window.location.href="register.php";}setTimeout(err,2000);</script></div>';
				
			}
			if($z===$acc)
			{
				$flag=1;
				echo'<div class="error"><h1>ERROR</h1><br><font color="red">The user with same account number already exists. Please try again with another account number. You are being redirected to registration page.<script>function err(){window.location.href="register.php";}setTimeout(err,2000);</script></div>';
				
			}

		}
	}
}

#+++++++++++++++++++++++++++++++++++++  end of checking for duplicate data  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
if($flag===0)
{
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
		echo'<div class="error"><h1>ERROR</h1><br><font color="red">Unsupported image file type is uploaded. Please upload your profile picture in either jpg, jpeg or png format only. You will be redirected to registration page shortly<script>function err(){window.location.href="register.php";}setTimeout(err,2000);</script></div>';
	}
#++++++++++++++++++++++++++++++++++++++ end of extension type checking ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

$con=mysqli_connect($server_address,$server_user,$server_password,$server_database);
if(!$con)
{
	echo'<div class="error"><h1>ERROR</h1><br><font color="red">The connection to the server is temporarily lost, Please try again later. You are being redirected to Home page.<script>function err(){window.location.href="login.html";}setTimeout(err,2000);</script></div>';
}
else
{
		$query="INSERT INTO `user` VALUES(NULL,0,'$email','$user_name','$pass','PROFILE_PIC/$user_name.$ext','user','$bank_name',$acc)";  # initially User_Active_Status is set to 0 so that untill we get verification from ventured bank he/she cannot avail the services.
		if(mysqli_query($con,$query))
		{
#+++++++++++++++++++++++++++++++++ Initiate User activation +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++#
#                                                                                                                            #
#                                                                                                                            #
#	/*                                                                                                                   #
#			$----- Naive approach for activation management script ------$                                       #
#	-> create a activation link for the user.                                                                            #
#	-> fetch respective bank contact details from database.                                                              #
#	-> send email containing the activation link to the bank using contact in the database.                              #
#	*/                                                                                                                   #
#                                                                                                                            #
#	/*                                                                                                                   #
#			$----- Role of PHP segment ------$                                                                   #
#	-> create a activation link for the user.                                                                            #
#	-> fetch respective bank contact details from database.                                                              #
#	-> append the link and contact details corresponding a particular user in activation table.                          #
#	-> when response arrives then toggle response value.                                                                 #
#	*/                                                                                                                   #
#                                                                                                                            #
#	/*                                                                                                                   #
#			$----- Role of Python segment ------$                                                                #
#	-> fetch respective details from the activation table.                                                               #
#	-> send mail to the contact detail of the bank.                                                                      #
#	*/														     #
#															     #
#+++++++++++++++++++++++++++++++++ End of User activation process +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++#
			
			$link="localhost:8080/signature/activate.php?mail=$email&acc=$acc";
			$query1="INSERT INTO `activation` VALUES('$email','$link','$bank_name',0)";
			if(mysqli_query($con,$query1))
			{
#++++++++++++++++++++++++++++++++ Activation process initiated +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++#
#																    #
#++++++++++++++++++++++++++++++++ End of activation process initiation +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++#
			}
			move_uploaded_file($_FILES['user_profile']['tmp_name'],"PROFILE_PIC/$user_name.$ext"); 
			echo'<div class="error"><h1>Congratulations</h1><br><font color="green">Registration succesful.<script>function err(){window.location.href="index.php";}setTimeout(err,2000);</script></div>';
		}
		else
		{
#			echo"failure in query!";
		}


}
}
?>

<br>
<div class="footer">
<br>
&nbsp;&nbsp;<font color="red">Disclaimer :</font> The site is under continous monitoring for malicious activities and somebody caught indulged in such act is liable to serious punishment.<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The users are requested to contact us if they find anykind of difficulty in navigating the site to avail the services they are subscribed with. 
</div>
</body>
</html>
