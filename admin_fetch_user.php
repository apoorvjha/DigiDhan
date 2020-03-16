<?php
session_start();
if(!isset($_SESSION["User_Name"]))
{echo'<script>window.location.href="index.php";</script>';
}
?>
<script>
function activate()
{
const xhr=XMLHttpRequest();
xhr.onload=function{

};
xhr.open("POST","activation.php");
xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xhr.send();
}
function deactivate()
{
const xhr=XMLHttpRequest();
xhr.onload=function{

};
xhr.open("POST","admin_fetch_user.php");
xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xhr.send();

}
</script>
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
		echo'<table>';
		echo'<tr>';
		echo'<th>User Id</th>';
		echo'<th>User Name</th>';
		echo'<th>Profile Photo</th>';
		echo'<th>User Mail</th>';
		echo'<th>Bank Name</th>';
		echo'<th>Action</th>';
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
#+++++++++++++++++++++++++++++++++++++++  End of data fetch operation ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			if($utype!='admin' and $utype!='super')
			{
				if($uas==1)
				{
					echo'<tr>';
					echo"<td>$uid</td>";
					echo"<td>$uname</td>";
					echo'<td><img src="'.$uprofile.'" class="profile"></td>';
					echo'<td><a href="mailto:'.$umail.'">'.$umail.'</a></td>';
					echo"<td>$bank</td>";
					echo'<td><button class="del_btn" onClick="deactivate();">Deactivate<button></td>';
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
					echo'<td><button class="send_btn" onClick="activate();" value=>Activate<button></td>';
					echo'</tr>';
				}
			}
		}
		echo'</table>';
	}
}


?>
