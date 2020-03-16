<?php
session_start();
echo'<table cellpadding="10px." border="2px." width="600px.">';
echo'<tr bgcolor="gray">';
echo'<th><font color="white">User Name</font></th>';
echo'<th><font color="white">User Mail</font></th>';
echo'<th><font color="white">Profile Picture</font></th>';
echo'<th><font color="white">Unread messages</font></th>';
echo'<th><font color="white">Action</font></th>';
echo'</tr>';

#++++++++++++++++++++++++++++++++++++++  Server credentials  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$server_address="localhost";
$server_user="root";
$server_password="";
$server_database="DigiDhan";
#++++++++++++++++++++++++++++++++++++++  End of Server credentials  +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$con=mysqli_connect($server_address,$server_user,$server_password,$server_database);
if(!$con)
{
	echo'<div class="error"><h1>ERROR</h1><br><font color="red">The connection to the server is temporarily lost, Please try again later. You are being redirected to login page.<script>function err(){window.location.href="login.html";}setTimeout(err,2000);</script></div>';
}
else
{
$query="SELECT * FROM `user`";
if($is_query_run=mysqli_query($con,$query))
{
while($query_execute=mysqli_fetch_assoc($is_query_run))
{
$uid=$query_execute["User_Id"];
$uname=$query_execute["User_Name"];
$up=$query_execute["User_Profile"];
$umail=$query_execute["User_Mail"];
$um=0;
$query1="SELECT * FROM `chat` WHERE `User_Id`=$uid AND NOT(`User_Id`=".$_SESSION["User_Id"].")";
if($is_query_run1=mysqli_query($con,$query1))
{
	while($query_execute1=mysqli_fetch_assoc($is_query_run1))
	{
		$u_id=$query_execute1["User_Id"];
		$tu=$query_execute1["To_User"];
		$temp=$query_execute1["Read_Message"];
		if($u_id==$uid)
		{
			$um+=$temp;
		}
	}
	if(isset($u_id))
{
	if($u_id==$uid)
	{
		echo'<tr bgcolor="white">';
		echo'<td><font color="gray">'.$uname.'</font></td>';
		echo'<td><a href="mailto:'.$umail.'">'.$umail.'</a></td>';
		echo'<td><img src="'.$up.'" class="profile"></td>';
		echo'<td><font color="gray">'.$um.'</font></td>';
		echo'<td><form action="chat_contact_read.php" method="post"><button type="submit" name="'.$uid.'" class="send_btn"><font color="white">Read</font></button></form>&nbsp;&nbsp;&nbsp;  <form action="chat_contact_delete.php" method="post"><button type="submit" name="'.$uid.'" class="del_btn"><font color="white">Delete</font></button></form>';
		echo'</td>';
		echo"</tr>";

	}
}
}
}
}
echo'</table><br><br>';
}
?>
