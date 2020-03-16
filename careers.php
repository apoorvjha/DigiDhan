<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<script>
function validate1()
{
document.getElementById("ma").innerHTML=document.getElementById("pa").value;
document.getElementById("ma").style.visibility='hidden';
}
function validate2()
{
document.getElementById("ma").value="";
document.getElementById("ma").style.visibility='visible';
}
</script>

<link rel="stylesheet" type="text/css" href="index.css">
<title>Careers</title>
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
  echo'<li><a class="active" href="">Careers</a></li>';
  echo'<li><a href="login.html">Login</a></li>';
  echo'<li><a href="register.php">Register</a></li>';
  echo'<li><a href="about_us.php">About us</a></li>';
  echo'<li><a href="contact_us.php">Contact us</a></li>';
#+++++++++++++++++++++++++++++++++++ End of view of menu to non logged in guests +++++++++++++++++++++++++++++++++++++++++++
}
else
{
  echo'<li><a href="index.php">Home</a></li>';
  echo'<li><a href="ventures.php">Ventures</a></li>';
  echo'<li><a class="active" href="">Careers</a></li>';
  echo' <li><a href="logout.php">Logout</a></li>';
  echo'<li><a href="services.php">Services</a></li>';
  echo'<li><a  href="about_us.php">About us</a></li>';
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
}?>
</ul>
</div>

<!--

@ development details of the project

@ role description and distribution among development team members

@ etc.,

-->
<div class="enclosure">
<br>
<center>
<div class="register">
<div class="loginhead"><center>Application Form</center></div>
<form method="post" action="careers_back.php" enctype="multipart/form-data">
<table cellpadding="13px.">
<tr>
<td><font color="black"><b>Name</b></font></td>
<td><input type="text" name="name" id="name" class="input" placeholder="   Applicant's Full Name"></td>
</tr>
<tr>
<td><font color="black"><b>Date of Birth</b></font></td>
<td><input type="date" name="dob" id="dob" class="input"></td>
</tr>
<tr>
<td><font color="black"><b>Permanent Address</b></font></td>
<td><textarea placeholder="   Permanent Address" name="pa" class="msg" id="pa"></textarea></td>
</tr>
<tr>
<td colspan="2"><font color="black"><b>Is mailing address same as permanent address</b></font>&nbsp;&nbsp;&nbsp;<input type="radio" name="p_e_m" value="yes"onChange="validate1();" id="p_e_m1"><font color="black">Yes</font>&nbsp;&nbsp;<input type="radio" name="p_e_m" value="no" onChange="validate2();" id="p_e_m2"><font color="black">No</font></td>
</tr>
<tr>
<td><font color="black"><b>Mailing address</b></font></td>
<td><textarea placeholder="   Mailing address" class="msg" name="ma" id="ma"></textarea></td>
</tr>
<?php
if(!isset($_SESSION["User_Mail"]))
{
?>
<tr>
<td><font color="black"><b>Email Address</b></font></td>
<td><input type="email" name="email" id="email" class="input" placeholder="   john@example.com"></td>
</tr>
<?php
}
?>
<tr>
<td><font color="black"><b>Education qualification</b></font></td>
<td><select name="eq">
<option value="select">Select one</option>
<option value="bachlor">Bachlor</option>
<option value="masters">Masters</option>
<option value="doctorate">Doctorate</option>
</select>
</td>
</tr>
<tr>
<td><font color="black"><b>Education stream</b></font></td>
<td><select name="stream">
<option value="select">Select one</option>
<option value="Science">Science</option>
<option value="Arts">Arts</option>
<option value="Engineering">Engineering</option>
<option value="Finance">Finance</option>
</select>
</td>
</tr>
<tr>
<td><font color="black"><b>% obtained in highest qualification</b></font></td>
<td><input type="text" name="marks" id="marks" class="input" placeholder="   percentage obtained"></td>
</tr>
<tr>
<td><font color="black"><b>Resume</b></font></td>
<td><input type="file" name="resume"></td>
</tr>
<tr>
<tr>
<td><input type="reset" value="Reset" class="del_btn"></td>
<td><input type="submit" value="Register" class="send_btn"></td>
</tr>
</table>
</form>
</div>
</center>
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

