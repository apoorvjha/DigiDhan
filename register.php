<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="index.css">
<link rel="shortcut icon" href="SUPPORT_PIC/logo.jpeg" /> <!-- For setting custom mini icon on the title tab of web page -->
<title>Register</title>
<script>
function validate()
{ /*
	Function tob validate the form data supplied by users at time of registration 
	so that less computations need to be done at server.

  */
var uname=document.getElementById("uname").value;
var password=document.getElementById("password").value;
var repassword=document.getElementById("re-password").value;
var email=document.getElementById("email").value;
var acc=document.getElementById("account_no").value;
if(uname.length<3)
{alert("User name cannot be less than 3 letters long!");
return false;
}
if(password.length<7)
{alert("Password cannot be less than 7 letters long!");
return false;
}
if(password!=repassword)
{
alert("Password and retyped Password does not match!");
return false;
}
if((acc.length<16) || (acc.length>16))
{alert("Account Number cannot be greater than or less than 16 digits long!");
return false;
}

return true;
}

</script>
</head>
<body onLoad="findBank();">
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
<li><a href="login.html">Login</a></li>
<li><a class="active" href="">Register</a></li>
<li><a href="about_us.php">About us</a></li>
<li><a href="contact_us.php">Contact us</a></li>
</ul>
</div>
<form method="post" action="register_user.php" onSubmit="return validate();" enctype="multipart/form-data">
<div class="enclosure">
<br>
<center>
<div class="register">
<div class="loginhead"><center>Register</center></div>
<table cellpadding="13px.">
<tr>
<td><font color="black"><b>User Name</b></font></td>
<td><input type="text" name="uname" id="uname" class="input" placeholder="   User Name"></td>
</tr>
<tr>
<td><font color="black"><b>Password</b></font></td>
<td><input type="password" name="password" id="password" class="input" placeholder="   Password"></td>
</tr>
<tr>
<td><font color="black"><b>re-Password</b></font></td>
<td><input type="password" name="re-password" id="re-password" class="input" placeholder="   retype your Password"></td>
</tr>
<tr>
<td><font color="black"><b>Email</b></font></td>
<td><input type="email" name="email" class="input" id="email" placeholder="   Email" required></td>
</tr>
<tr>
<td><font color="black"><b>Profile Picture</b></font></td>
<td><input type="file" name="user_profile"></td>
</tr>
<tr>
<td><font color="black"><b>Bank Name</b></font></td>
<td>
<select name="Bank_Name">
<?php
#+++++++++++++++++++++++++++++++++++ server credentials ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$server_address="localhost";
$server_user="root";
$server_password="";
$server_database="DigiDhan";
#+++++++++++++++++++++++++++++++++++ End of server credentials  +++++++++++++++++++++++++++++++++++++++++++++++++++++++
$con=mysqli_connect($server_address,$server_user,$server_password,$server_database);
if(!$con)
{
	echo'<div class="error"><h1>ERROR</h1><br><font color="red">The connection to the server is temporarily lost, Please try again later. You are being redirected to login page.<script>function err(){window.location.href="login.html";}setTimeout(err,2000);</script></div>';
}
else
{

$query="SELECT * FROM `ventures`";
	if($is_query_run=mysqli_query($con,$query))
	{
		while($query_execute=mysqli_fetch_assoc($is_query_run))
		{
#+++++++++++++ fetching various ventured bank names to be chosen by user at time of registration in which they have their account +++++++ 
			$bank=$query_execute["Bank_Name"];
			echo'<option value="'.$bank.'">'.$bank.'</option>';
#++++++++++++++++++++++++++++++ End of setting options ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		}
	}
}


?>
</select>
<!-- 
AJAX in dynamic options based on entry in database.
<select>
<option>....</option>
<option>....</option>
<option>....</option>
</select>
-->
</td>
</tr>
<tr>
<td><font color="black"><b>Account Number</b></font></td>
<td><input type="text" name="account_no" class="input" id="account_no" placeholder="   Account Number" required></td>
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
