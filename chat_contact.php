<?php
session_start();
if(!isset($_SESSION["User_Name"]))
{echo'<script>window.location.href="index.php";</script>';
}
?>
<!DOCTYPE html>
<html>
<head>
<script>
function validate()
{msg=document.getElementById("msg").value;
if(msg.length<1)
{
return false;
}
return true;
}
function fetch_chats(){
const xhr=new XMLHttpRequest();
xhr.onload=function(){
const serverResponse=document.getElementById("chatlets");
serverResponse.innerHTML=this.responseText;
};
xhr.open("POST","chat_fetch.php");
xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xhr.send();
}
function sync_chats()
{fetch_chats();
setInterval(fetch_chats,2000);
}
function chat_post()
{
if(validate()){
msg=document.getElementById("msg").value;
const xhr=new XMLHttpRequest();
xhr.onload=function(){
fetch_chats();
document.getElementById("msg").value=null;
};
xhr.open("POST","chat_post.php");
xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xhr.send("msg="+msg);
}
}
</script>
<link rel="stylesheet" type="text/css" href="index.css">
<title>Chat forum</title>
<link rel="shortcut icon" href="SUPPORT_PIC/logo.jpeg" /> <!-- For inserting custom mini icon on the title tab of web pages -->
</head>
<body onload="sync_chats();">
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
  echo'<li><a href="login.html">Login</a></li>';
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
	
			<?php
				if(!isset($_SESSION["User_Name"]))
				{
echo'<div class="error"><h1>ERROR</h1><br><font color="red">Please Login to avail this service.<script>function err(){window.location.href="login.html";}setTimeout(err,2000);</script></div><br>';

					
}					

				else
				{
#				if($_SESSION["User_Type"]!='super')
#				{
#++++++++++++++++++++++++++++++++++++++  Server credentials  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
#$server_address="localhost";
#$server_user="root";
#$server_password="";
#$server_database="DigiDhan";
#++++++++++++++++++++++++++++++++++++++  End of Server credentials  +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
#$con=mysqli_connect($server_address,$server_user,$server_password,$server_database);
#if(!$con)
#{
#	echo'<div class="error"><h1>ERROR</h1><br><font color="red">The connection to the server is temporarily lost, Please try again later. You are being redirected to contact page.<script>function err(){window.location.href="contact_us.php";}setTimeout(err,2000);</script></div>';
#}
#else
#{
#$q="SELECT * FROM `user` WHERE `User_Type`='super'";
#if($is_query_run=mysqli_query($con,$q))
#{
#while($query_execute=mysqli_fetch_assoc($is_query_run))
#{
#$uname_super=$query_execute["User_Name"];
#$uprofile_super=$query_execute["User_Profile"];
#}
#}

#$_SESSION["To_User_Name"]=$uname_super;
#$_SESSION["To_User_Profile"]=$uprofile_super;
#}					
#}
#++++++++++++++++++++++++++++++++++++++++++++ logged in user chat interface ++++++++++++++++++++++++++++++++++++++++++++++++++++
echo'<div class="chatbox">';
echo'<div class="chathead" align="left">';
echo'<div class="name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="'.$_SESSION["To_User_Profile"].'" class="profile">&nbsp;&nbsp;&nbsp;'.$_SESSION["To_User_Name"];
echo'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
echo'<button id="close" onclick="window.location.href="index.php";">X</button></div>';
echo'<br><br><br><br>';
echo'<center>';
					echo'<div class="chatlets" id="chatlets">'; 


					echo'</div>';
echo'<br>';
#echo'<form method="post" action="chat_post.php" onSubmit="return validate();">';
/*
	form to collect message from the user and post it to "chat_post.php" which in turn append 
	that into the database. 
*/
echo'<table cellpadding="2px.">';
echo'<tr>';
echo'<td><textarea placeholder="Type your message here!" class="msg" name="msg" id="msg"></textarea></td>';
echo'<td><input type="submit" value="Send" class="send_btn" onClick="chat_post();"></td>';
echo'</tr>';
echo'</table>';
#echo'</form>';
echo'</center>';


#++++++++++++++++++++++++++++++++++++++++++++ end of user chat interface +++++++++++++++++++++++++++++++++++++++++++++++++++++++

				}							
				
			?>
		</div>
	</div>
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

