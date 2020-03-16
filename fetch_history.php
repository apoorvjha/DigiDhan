<?php
session_start();
echo'<br><table cellpadding="10px." border="2px." width="650px." align="center">';
echo'<tr bgcolor="blue">';
echo'<th><font color="white">Transaction Id</font></th>';
echo'<th><font color="white">From</font></th>';
echo'<th><font color="white">To</font></th>';
echo'<th><font color="white">Mode</font></th>';
echo'<th><font color="white">Status</font></th>';
echo'<th><font color="white">Amount</font></th>';
echo'<th><font color="white">Date</font></th>';
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
$query="SELECT * FROM `transaction` WHERE `To_Bank_Account_Number`=".$_SESSION["Bank_Account_Number"]." OR `From_Bank_Account_Number`=".$_SESSION["Bank_Account_Number"];
if($is_query_run=mysqli_query($con,$query))
{
while($query_execute=mysqli_fetch_assoc($is_query_run))
{
$to=$query_execute["To_Bank_Account_Number"];
$from=$query_execute["From_Bank_Account_Number"];
$mode=$query_execute["mode"];
$status=$query_execute["Status"];
$bal=$query_execute["Amount"];
$date=$query_execute["Date_Of_Transaction"];
$tid=$query_execute["Transaction_Id"];
if($mode=='ONLINE')
{
echo'<tr bgcolor="white">';
echo'<td><font color="orange">'.$tid.'</font></font></td>';
echo'<td><font color="orange">'.$from.'</font></font></td>';
echo'<td><font color="orange">'.$to.'</font></td>';
echo'<td><font color="orange">Virtual Cheque</font></td>';
if($status==0)
{
echo'<td><font color="voilet">Pending</font></td>';
}
else if($status==1)
{
echo'<td><font color="green">Successful</font></td>';
}
else
{
echo'<td><font color="red">Cancelled</font></td>';
}
echo'<td><font color="red">'.$bal.'</font></td>';
echo'<td><font color="orange">'.$date.'</font></td>';
echo'</tr>';
}
else
{
echo'<tr bgcolor="white">';
echo'<td><font color="yellow">'.$tid.'</font></td>';
echo'<td><font color="yellow">'.$from.'</font></td>';
echo'<td><font color="yellow">'.$to.'</font></td>';
echo'<td><font color="yellow">Physical Cheque</font></td>';
if($status==0)
{
echo'<td><font color="voilet">Pending</font></td>';
}
else if($status==1)
{
echo'<td><font color="green">Successful</font></td>';
}
else
{
echo'<td><font color="red">Cancelled</font></td>';
}
echo'<td><font color="green">'.$bal.'</font></td>';
echo'<td><font color="yellow">'.$date.'</font></td>';
echo'</tr>';}
}
}
echo'</table><br>';
}
?>
