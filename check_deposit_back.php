<?php
session_start();
if(!isset($_SESSION["User_Name"]))
{echo'<script>window.location.href="index.php";</script>';
}
#++++++++++++++++++++++++++++++++++++++++++ user supplied data aquisition +++++++++++++++++++++++++++++++++++++
$dot=$_POST["date_of_trans"];
$to_acc_no=$_POST["payee_name"];
$amt_wrd=$_POST["amt_wrd"];
$amt=$_POST["price"];
$sig=$_FILES['signature']['name'];
$type=$_FILES['signature']['type'];
$ccn=$_SESSION["CCN"];
$from=$_SESSION["Bank_Account_Number"];
$i=0;
$ext='';                  # extension of the image
echo $to_acc_no;
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



#++++++++++++++++++++++++++++++++++++++  Server credentials  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$server_address="localhost";
$server_user="root";
$server_password="";
$server_database="DigiDhan";
#+++++++++++++++++++++++++++++++++++++++ end of server credentials ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$con=mysqli_connect($server_address,$server_user,$server_password,$server_database);
if(!$con)
{
	echo'<div class="error"><h1>ERROR</h1><br><font color="red">The connection to the server is temporarily lost, Please try again later. You are being redirected to services page.<script>function err(){window.location.href="services.php";}setTimeout(err,2000);</script></div>';
}
else
{

if($type!=='image/jpg' && $type!=='image/jpeg' && $type!=='image/png')
	{

		echo'<div class="error"><h1>ERROR</h1><br><font color="red">Unsupported image file type is uploaded. Please upload your profile picture in either jpg, jpeg or png format only. You will be redirected to registration page shortly<script>function err(){window.location.href="register.php";}setTimeout(err,2000);</script></div>';
	}

$query="INSERT INTO `transaction`VALUES($to_acc_no,$from,$amt,'ONLINE',NULL,$ccn,'$dot','TRANSACTION_PIC/".$from."$ccn.$ext',0)";
if(mysqli_query($con,$query))
{
move_uploaded_file($_FILES['signature']['tmp_name'],"TRANSACTION_PIC/$from"."$ccn".".$ext");
$query1="UPDATE `accounts` set `Current_Cheque_Number`=`Current_Cheque_Number`+1 WHERE `Bank_Account_Number`=$from";
if(mysqli_query($con,$query1))
{
$fp=fopen("log.txt",'a');
fwrite($fp,"\n[$dot] ONLINE $to_acc_no $from $amt $ccn TRANSACTION_PIC/".$from."$ccn.$ext");
fclose($fp);
}
echo'<script>window.location.href="services.php";</script>';
}
else
{
echo'<script>alert("some problem occured while processing your transaction!");</script>';
}

}
?>
