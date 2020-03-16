<?php
session_start();
if(!isset($_SESSION["User_Name"]))
{
echo'<script>window.location.href="login.html";</script>';
}
?>
<!DOCTYPE html>
<html>
<head>
<script>
function validate()
{
var choice=document.getElementById("attri").value;
if(choice=='User_Name')
{
document.getElementById("attr").style.visibility='visible';
document.getElementById("in").style.visibility='visible';
document.getElementById("attr").innerHTML="New User Name";
document.getElementById("in").innerHTML='<input type="text" name="uname" class="input" placeholder="   New user name">';
}
if(choice=='User_Mail')
{
document.getElementById("attr").style.visibility='visible';
document.getElementById("in").style.visibility='visible';
document.getElementById("attr").innerHTML="New E-mail Id";
document.getElementById("in").innerHTML='<input type="email" name="umail" class="input" placeholder="   New E-mail">';
}
if(choice=='Profile')
{
document.getElementById("attr").style.visibility='visible';
document.getElementById("in").style.visibility='visible';
document.getElementById("attr").innerHTML="New Profile Picture";
document.getElementById("in").innerHTML='<input type="file" name="uprofile">';
}
if(choice=='Select')
{
document.getElementById("attr").style.visibility='hidden';
document.getElementById("in").style.visibility='hidden';
}

}
</script>
<link rel="stylesheet" type="text/css" href="index.css">
<title>Change credentials</title>
<link rel="shortcut icon" href="SUPPORT_PIC/logo.jpeg" /> <!-- For inserting custom mini icon on the title tab of web pages -->
</head>
<body>
<div class="header">
<img src="SUPPORT_PIC/logo.jpeg" height="106px" width="200px" class="logo_img">
<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<font color="#ddd" class="logo_text"><b>DigiDhan</b></font>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
<?php
if(isset($_SESSION["User_Name"]))
{
#+++++++++++++++++++++++++++++++++++++++++ Inserting profile picture of user and  username beside the logo +++++++++++++++++++++++++++ 
echo'<img src="'.$_SESSION["User_Profile"].'" height="50px." width="50px." class="profile">';
echo'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="white">Hi, '.$_SESSION["User_Name"].'</font>';
#++++++++++++++++++++++++++++++++++++++++ End of inserting profile picture and username ++++++++++++++++++++++++++++++++++++++++++++
}  
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
if(!isset($_SESSION["User_Name"]))
{
#+++++++++++++++++++++++++++++++++++ View of menu to guest users who are not logged in +++++++++++++++++++++++++++++++++
  echo'<li><a href="index.php">Home</a></li>';
  echo'<li><a href="ventures.php">Ventures</a></li>';
  echo'<li><a href="careers.php">Careers</a></li>';
  echo' <li><a href="login.html">Login</a></li>';
  echo'<li><a href="register.php">Register</a></li>';
  echo'<li><a href="about_us.php">About us</a></li>';
  echo'<li><a href="contact_us.php">Contact us</a></li>';
#+++++++++++++++++++++++++++++++++++ End of view of menu to non logged in guests +++++++++++++++++++++++++++++++++++++++++++
}
else
{
#+++++++++++++++++++++++++++++++++++ view of menu to logged in users +++++++++++++++++++++++++++++++++++++++++++++++++++++
  echo'<li><a href="index.php">Home</a></li>';
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
<div class="enclosure" align="center">
<br>
<!--
	main sections of the page!
-->
<form method="post" action="change_credit.php" enctype="multipart/form-data">
<div class="login">
<div class="loginhead"><center>Change Credit</center></div>
<table cellpadding="13px.">
<tr>
<td><font color="black"><b>Attribute to be changed</b></font></td>
<td><select name="attri" id="attri" onChange="validate();">
<option value="Select">select one attribute</option>
<option value="User_Name">User Name</option>
<option value="User_Mail">E-Mail Address</option>
<option value="Profile">Profile Picture</option>
</select></td>
</tr>
<tr>
<td><font color="black"><b><span id="attr"></span></b></font></td>
<td><span id="in"></span></td>
</tr>
<tr>
<td><input type="reset" value="Reset" class="del_btn"></td>
<td><input type="submit" value="Change" class="send_btn"></td>

</tr>
</table>
</form>
<br>
</div>

<?php
}
?>
<br>
<br>
<div class="footer">
<br>
&nbsp;&nbsp;<font color="red">Disclaimer :</font> The site is under continous monitoring for malicious activities and somebody caught indulged in such act is liable to serious punishment.<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The users are requested to contact us if they find anykind of difficulty in navigating the site to avail the services they are subscribed with. 
</div>
</body>
</html>

