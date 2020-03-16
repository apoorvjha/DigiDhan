<?php
session_start();
if(isset($_SESSION["User_Name"]) and $_SESSION["User_Type"]!='user')
{
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="index.css">
<title>Admin Pannel</title>
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

#+++++++++++++++++++++++++++++++++++++++++ Inserting profile picture of user and  username beside the logo +++++++++++++++++++++++++++ 
echo'<img src="'.$_SESSION["User_Profile"].'" height="50px." width="50px." class="profile">';
echo'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="white">Hi, '.$_SESSION["User_Name"].'</font>';
#++++++++++++++++++++++++++++++++++++++++ End of inserting profile picture and username ++++++++++++++++++++++++++++++++++++++++++++
echo'</div>';

#+++++++++ checking whether user has been activated after proper validation or not(means validation is pending) +++++++++++++++++++++++
if(isset($_SESSION["User_Active_Status"]) && $_SESSION["User_Active_Status"]==0)
{
echo'<br><br><br><div class="error"><h1>ERROR</h1><br><font color="red">Your account is not activated yet. You are requested to wait for the confirmation mail from our end. Sorry for any inconvenience!<script>function err(){window.location.href="logout.php";}setTimeout(err,2000);</script></div>';
}
#++++++++++++++++++++++++ End of checking validation credits of user ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

echo'<div class="menu"><ul>';

#+++++++++++++++++++++++++++++++++++ view of menu to logged in users +++++++++++++++++++++++++++++++++++++++++++++++++++++
  echo'<li><a  href="index.php">Home</a></li>';
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
{echo'<li><a class="active" href="">Admin Pannel</a></li>';
}
#++++++++++++++++++++++++++++++++++ End of view to special feature ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

?>
</ul>
</div>
<div class="enclosure">
<br>
<center>

<!--<table id="user_index">-->

<!--
@ ajax will handle the table content so that dynamic loading od data is possible without any page refreshes.
--> 
<!--</table>-->

<?php

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
$query="SELECT * FROM `user`";
	if($is_query_run=mysqli_query($con,$query))
	{
		echo'<table cellpadding="10px." border="2px." width="600px.">';
		echo'<tr bgcolor="blue">';
		echo'<th><font color="white">User Id</font></th>';
		echo'<th><font color="white">User Name</font></th>';
		echo'<th><font color="white">Profile Photo</font></th>';
		echo'<th><font color="white">User Mail</font></th>';
		echo'<th><font color="white">Bank Name</font></th>';
		echo'<th><font color="white">Action</font></th>';
		echo'</tr>';
		while($query_execute=mysqli_fetch_assoc($is_query_run))
		{
#++++++++++++++++++++++++++++++++++++++++  Data fetched into dictionary "$query_execute" +++++++++++++++++++++++++++++++++++++
			$uid=$query_execute["User_Id"];
			$uname=$query_execute["User_Name"];
			$umail=$query_execute["User_Mail"];
			$uas=$query_execute["User_Active_Status"];
			$uprofile=$query_execute["User_Profile"];
			$utype=$query_execute["User_Type"];
			$bank=$query_execute["Bank_Name"];
			$acc=$query_execute["Bank_Account_Number"];
#+++++++++++++++++++++++++++++++++++++++  End of data fetch operation ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			if($utype!='admin' and $utype!='super')
			{
				if($uas==1)
				{
					echo'<tr bgcolor="white">';
					echo"<td>$uid</td>";
					echo"<td>$uname</td>";
					echo'<td><img src="'.$uprofile.'" class="profile"></td>';
					echo'<td><a href="mailto:'.$umail.'">'.$umail.'</a></td>';
					echo"<td>$bank</td>";
					echo'<td><form method="post" action="deactivation.php"><input type="hidden" value="'.$acc.'" name="acc"><input type="hidden" value="'.$umail.'" name="mail"><input type="submit" value="Deactivate" class="del_btn"></form></td>';
					echo'</tr>';
				}
				else
				{
					echo'<tr>';
					echo"<td>$uid</td>";
					echo"<td>$uname</td>";
					echo'<td><img src="'.$uprofile.'" class="profile"></td>';
					echo'<td><a href="mailto:'.$umail.'">'.$umail.'</a></td>';
					echo"<td>$bank</td>";
					echo'<td><form method="post" action="activation.php"><input type="hidden" value="'.$acc.'" name="acc"><input type="hidden" value="'.$umail.'" name="mail"><input type="submit" value="Activate" class="send_btn"></form></td>';
					echo'</tr>';
				}
			}
		}
		echo'</table>';
	}
}


if($_SESSION["User_Type"]=='super')
{
# add or delete ventures.

		echo'<br><br><table cellpadding="10px." border="2px." width="600px.">';
		echo'<tr>';
		#setting up table headers.
		echo'<th bgcolor="blue"><font color="white">Venture Id</font></th>';
		echo'<th bgcolor="blue"><font color="white">Bank Name</font></th>';
		echo'<th bgcolor="blue"><font color="white">Bank Contact</font></th>';
		echo'<th bgcolor="blue"><font color="white">Bank Logo</font></th>';
		echo'<th bgcolor="blue"><font color="white">Action</font></th>';
		#end of setting up table headers.
		echo'</tr>';
#+++++++++++++++++++++++++++++++++++ server credentials ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
#$server_address="localhost";
#$server_user="root";
#$server_password="";
#$server_database="DigiDhan";
#+++++++++++++++++++++++++++++++++++ End of server credentials  +++++++++++++++++++++++++++++++++++++++++++++++++++++++
$con1=mysqli_connect($server_address,$server_user,$server_password,$server_database);
if(!$con1)
{
	echo'<div class="error"><h1>ERROR</h1><br><font color="red">The connection to the server is temporarily lost, Please try again later. You are being redirected to Home page.<script>function err(){window.location.href="index.php";}setTimeout(err,2000);</script></div>';
}
else
{$c=0;
	$query1="SELECT * FROM `ventures`";
	if($is_query_run1=mysqli_query($con1,$query1))
	{
		while($query_execute1=mysqli_fetch_assoc($is_query_run1))
		{
#+++++++++++++++++++++++++++++ Fetching out details of ventures from the database and princting it in tabular format ++++++++++++++
			$vid=$query_execute1["Venture_Id"];
			$B_name=$query_execute1["Bank_Name"];
			$contact=$query_execute1["Email"];
			$logo=$query_execute1["Bank_Logo"];
			$c=$vid;
			
			echo'<tr bgcolor="white">';
			echo'<td><font color="black">'.$vid.'</font></td>';
			echo'<td><font color="black">'.$B_name.'</font></td>';
			echo'<td><a href="mailto:'.$contact.'">'.$contact.'</a></td>';
			echo'<td><img src="'.$logo.'" height="100px." width="100px."></td>';
			echo'<td><form method="post" action="del_venture.php"><input type="hidden" value="'.$vid.'" name="vid"><input type="hidden" value="'.$B_name.'" name="bank_name"><input type="submit" value="Delete" class="del_btn"></form></td>';
			echo'</tr>';
#+++++++++++++++++++++++++++++++ End of fetching venture details and putting it on screen ++++++++++++++++++++++++++++++++++++++++ 
		}

	}
}
$c=$c+1;
echo'<tr bgcolor="white"><form method="post" action="add_venture.php" enctype="multipart/form-data"><td>'.$c.'<input type="hidden" value="'.$c.'" name="id"></td><td><input type="text" name="bank_name" class="input" placeholder="   Bank Name"></td><td><input type="email" name="email" class="input" placeholder="   Email"><td><input type="file" name="logo"></td><td><input type="submit" value="Add new venture" class="send_btn"></td></form></tr></table>';
}
?>


</center>
<br>
</div>
<br>
<br>
<div class="footer">
<br>
&nbsp;&nbsp;<font color="red">Disclaimer :</font> The site is under continous monitoring for malicious activities and somebody caught indulged in such act is liable to serious punishment.<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The users are requested to contact us if they find anykind of difficulty in navigating the site to avail the services they are subscribed with. 
</div>
</body>
</html>

<?php
}
else
{
echo'<br><br><br><div class="error"><h1>ERROR</h1><br><font color="red">Your credentials does not permit you to view this page1<script>function err(){window.location.href="index.php";}setTimeout(err,2000);</script></div>';
}
?>
