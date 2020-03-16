<?php
session_start();
$email=$_POST["mail"];  # LINK parameter mail (user mail)
$acc=$_POST["acc"];  # LINK parameter mail (user account)
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
	$query="UPDATE `user` SET `User_Active_Status`=1 WHERE `Bank_Account_Number`=$acc AND `User_Mail`='$email'";
	$query1="UPDATE `activation` SET `Response`=1 WHERE `User_Mail`='$email'";
	if(mysqli_query($con,$query) && mysqli_query($con,$query1))
	{
#+++++++++++++++++++++++++++++++ Activation Successful !!!! ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		$query2="SELECT * FROM `accounts` WHERE `Bank_Account_Number`=$acc";
		$query3="SELECT * FROM `Signature_Dataset` WHERE `Bank_Account_Number`=$acc";
		if($is_query_execute=mysqli_query($con,$query2))
		{$is_query_execute1=mysqli_query($con,$query3);
			if(!(mysqli_fetch_assoc($is_query_execute)) || !(mysqli_fetch_assoc($is_query_execute1)))
				{
$_SESSION["acc"]=$acc;
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="index.css">
<link rel="shortcut icon" href="SUPPORT_PIC/logo.jpeg" /> <!-- For setting custom mini icon on the title tab of web page -->
<title>Activation</title>
</head>
<body>
<div class="header">
<img src="SUPPORT_PIC/logo.jpeg" height="106px" width="200px" class="logo_img">
<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<font color="#ddd" class="logo_text"><b>DigiDhan</b></font>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
<?php

#+++++++++++++++++++++++++++++++++++++++++ Inserting profile picture of user and  username beside the logo +++++++++++++++++++++++++++ 
echo'<img src="'.$_SESSION["User_Profile"].'" height="50px." width="50px." class="profile">';
echo'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="white">Hi, '.$_SESSION["User_Name"].'</font>';
#++++++++++++++++++++++++++++++++++++++++ End of inserting profile picture and username ++++++++++++++++++++++++++++++++++++++++++++
  
?>
</div>
<?php
#+++++++++ checking whether user has been activated after proper validation or not(means validation is pending) +++++++++++++++++++++++
if(isset($_SESSION["User_Active_Status"]) && $_SESSION["User_Active_Status"]==0)
{
echo'<br><br><br><div class="error"><h1>ERROR</h1><br><font color="red">Your account is not activated yet. You are requested to wait for the confirmation mail from our end. Sorry for any inconvenience!<script>function err(){window.location.href="logout.php";}setTimeout(err,2000);</script></div>';
}
#++++++++++++++++++++++++ End of checking validation credits of user ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
else
{
?>
<div class="menu"><ul>
<?php

#+++++++++++++++++++++++++++++++++++ view of menu to logged in users +++++++++++++++++++++++++++++++++++++++++++++++++++++
  echo'<li><a class="active" href="">Home</a></li>';
  echo'<li><a href="ventures.php">Ventures</a></li>';
  echo'<li><a href="careers.php">Careers</a></li>';
  echo' <li><a href="logout.php">Logout</a></li>';
  echo'<li><a href="services.php">Services</a></li>';
  echo'<li><a href="about_us.php">About us</a></li>';
if($_SESSION["User_Type"]!='super')
{
  echo'<li><a href="contact_us.php">Contact us</a></li>';
}
else
{
echo'<li><a href="contact.php">Contact</a></li>';
}
#++++++++++++++++++++++++++++++++++ End of view of menu to logged in users +++++++++++++++++++++++++++++++++++++++++++++++++++++
#++++++++++++++++++++++++++++++++++ special feature of admin pannel exclusive for admin type users ++++++++++++++++++++++++++++
if($_SESSION["User_Type"]==="admin" or $_SESSION["User_Type"]==="super")
{echo'<li><a href="admin_pannel.php">Admin Pannel</a></li>';
}
#++++++++++++++++++++++++++++++++++ End of view to special feature ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
}
?>
</ul>
</div>
<form method="post" action="accounts_new.php" enctype="multipart/form-data">
<div class="enclosure">
<br>
<center>
<div class="register">
<div class="loginhead"><center>Accounts Datails</center></div>
<table cellpadding="13px.">
<tr>
<td><font color="black"><b>Balance(&#x20B9)</b></font></td>
<td><input type="text" name="bal" id="bal" class="input" placeholder="   Balance of Account"></td>
</tr>
<tr>
<td><font color="black"><b>IFSC</b></font></td>
<td><input type="text" name="ifsc" id="ifsc" class="input" placeholder="   IFSC"></td>
</tr>
<tr>
<td><font color="black"><b>Account Type</b></font></td>
<td><select name="type">
<option value="savings">Savings</option>
<option value="current">Current</option>
<option value="ventured">Ventured</option>
</select></td>
</tr>
<tr>
<td><font color="black"><b>Current Cheque Number</b></font></td>
<td><input type="text" name="ccn" id="ccn" class="input" placeholder="   Current Cheque Number"></td>
</tr>
<tr>
<td><font color="black"><b>Signature Specimen-1</b></font></td>
<td><input type="file" name="ss1" id="ss1"></td>
</tr>
<tr>
<td><font color="black"><b>Signature Specimen-2</b></font></td>
<td><input type="file" name="ss2" id="ss2"></td>
</tr><tr>
<td><font color="black"><b>Signature Specimen-3</b></font></td>
<td><input type="file" name="ss3" id="ss3"></td>
</tr><tr>
<td><font color="black"><b>Signature Specimen-4</b></font></td>
<td><input type="file" name="ss4" id="ss4"></td>
</tr><tr>
<td><font color="black"><b>Signature Specimen-5</b></font></td>
<td><input type="file" name="ss5" id="ss5"></td>
</tr><tr>
<td><font color="black"><b>Signature Specimen-6</b></font></td>
<td><input type="file" name="ss6" id="ss6"></td>
</tr><tr>
<td><font color="black"><b>Signature Specimen-7</b></font></td>
<td><input type="file" name="ss7" id="ss7"></td>
</tr><tr>
<td><font color="black"><b>Signature Specimen-8</b></font></td>
<td><input type="file" name="ss8" id="ss8"></td>
</tr><tr>
<td><font color="black"><b>Signature Specimen-9</b></font></td>
<td><input type="file" name="ss9" id="ss9"></td>
</tr><tr>
<td><font color="black"><b>Signature Specimen-10</b></font></td>
<td><input type="file" name="ss10" id="ss10"></td>
</tr>
<tr>
<td><input type="reset" value="Reset" class="del_btn"></td>
<td><input type="submit" value="Register" class="send_btn"></td>
</tr>
</table></div></center><br><br></div>
</form><br>
<div class="footer">
<br>
&nbsp;&nbsp;<font color="red">Disclaimer :</font> The site is under continous monitoring for malicious activities and somebody caught indulged in such act is liable to serious punishment.<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The users are requested to contact us if they find anykind of difficulty in navigating the site to avail the services they are subscribed with. 
</div>
</body>
</html>
<?php		
				}
			
		}
else{		
		echo'<script>window.location.href="admin_pannel.php";</script>';
}
	}

}
?>

