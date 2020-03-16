<?php
session_start();
if(!(isset($_SESSION["User_Name"])))
{
echo'<script>window.location.href="login.html";</script>';
}
?>
<!DOCTYPE html>
<html>
<head>
<script>
var bal;
function validate()
{
	var date=document.getElementById("date_of_trans").value;
	var compo=date.split('-');
	var d=new Date();
	var cur_year=d.getFullYear();
	var cur_month=d.getMonth();
	var cur_day=d.getDate();
	var name=document.getElementById("payee_name").value;
	var amt=document.getElementById("price").value;	
	var amt_wrd=document.getElementById("amt_wrd").value;
	var amt_update=parseInt(amt);
	//alert(bal);
	if(cur_year<compo[0] || cur_year>compo[0])
	{
		/*
			date is wrong
		*/
		return false;
	}
	else
	{
		if(cur_month>compo[1] || (compo[1] - cur_month)>6)
		{
			/*
				date is wrong
			*/
			return false;
		}
		else
		{
			if(cur_day>compo[2])
			{
				/*
					date is wrong
				*/
				return false;
			}
			else
			{
				// date is correct
			}

		}
	}

if(name.length<16 || name.length>16 )
{
	alert("account number of the payee cannot be less than or greater than 16 digits long");
	return false;
}
if(amt.length<=3)
{
	alert("amount cannot be less than 1000");
	return false;
}
if(amt_wrd.length<=6)
{
	alert("amount cannot be less than 1000");
	return false;
}
if(amt_update>(bal-999))
{
	alert("Amount exceeds the minimum balance");
	return false;
}
return true;

}
function fetch_balance()
{
const xhr=new XMLHttpRequest();
xhr.onload=function(){
const serverResponse=document.getElementById("balance");
serverResponse.innerHTML=this.responseText;
bal=this.responseText;
};
xhr.open("POST","fetch_bal.php");
xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xhr.send();
}
function sync_ajax()
{fetch_balance();
setInterval(fetch_balance,2000);
}
</script>
<link rel="stylesheet" type="text/css" href="index.css">
<title>Cheque Corner</title>
<link rel="shortcut icon" href="SUPPORT_PIC/logo.jpeg" /> <!-- For inserting custom mini icon on the title tab of web pages -->
</head>
<body onLoad="sync_ajax();">
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
<div class="enclosure">
<br>
<div class="bal">Balance &nbsp;&nbsp; &#x20B9<span id="balance"></span></div>
<br>
<center>
<div class="chathead"><font color="White"><h2>Cheque Issue</h2></font></div>
</center>
<br>
<form action="check_deposit_back.php" method="post" onSubmit="return validate();" enctype="multipart/form-data">
<div class="virtual_check">
<!--
	@ a virtual check is much desired improvement over goodold paper check mechanism of money transfer.
		=> it saves paper.
		=> dependency is on the signature and other related credentials of the account provided.
		=> physical presence is not required of any person.
		=> many banking app use OCR to recognize the handwritten characters on the check which needs double authentication(models are not 100% fool proof!).
		=> the failure ratio can be crunched to minimum by using minimum recognition tasks.
-->
<?php

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
$query="SELECT * FROM `user` AS u,`ventures` AS v WHERE u.Bank_Name=v.Bank_Name AND u.User_Name='".$_SESSION["User_Name"]."'";
if($is_query_run=mysqli_query($con,$query))
{
while($query_execute=mysqli_fetch_assoc($is_query_run))
{
$logo=$query_execute["Bank_Logo"];
}
echo'<img src="'.$logo.'" class="b_logo">';
}
}
##################################  querying the db for account details to reference the virtual cheque ###########################3
$query1="SELECT * FROM `accounts` WHERE `Bank_Account_Number`='".$_SESSION["Bank_Account_Number"]."'";
if($is_query_run1=mysqli_query($con,$query1))
{
	while($query_execute1=mysqli_fetch_assoc($is_query_run1))
	{
		$balance=$query_execute1["Balance"];
		$acc_type=$query_execute1["Account_Type"];
		$ifsc=$query_execute1["IFSC"];
		$ccn=$query_execute1["Current_Cheque_Number"];		

	}
}

?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<? echo'<font color="blue" class="date_of_trans"><div class="box">IFSC &nbsp;&nbsp;&nbsp;'.$ifsc.'</div></font>'; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 <font color="blue" class="date_of_trans"><b>Date</b></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="date" name="date_of_trans" class="date_of_trans" id="date_of_trans">
<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <font color="blue" class="payee">PAY</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="payee_name" name="payee_name" id="payee_name" placeholder="  Payable to"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <font color="blue" class="payee">Order</font><br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="blue" class="payee">Ammount in words</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="payee_name" name="amt_wrd" id="amt_wrd" placeholder="  Payable amount in words">

<table rules="none" border="1" align="right"><tr><td><font color="blue">Rupees(&#x20B9)</font></td><td><input type="text" class="price" name="price" size="15" id="price"></td></table>
<br><br><br>
&nbsp;&nbsp;&nbsp;&nbsp;
<?php
echo'<font color="blue" class="date_of_trans"><div class="box">Account Number&nbsp;&nbsp;&nbsp;'.$_SESSION["Bank_Account_Number"].' </div></font>'; 
?>
<br><br>
<table rules="none" border="1" align="right"><tr><td><font color="blue">Signature</font></td><td><input type="file" name="signature" required></td></table>

<br><br>
<!--
resulted into failover so , goodold session is used to transfer this information.
<input type="hidden" name="check_no" value=<?php $ccn; ?>>
<input type="hidden" name="from" value=<?php $_SESSION["Bank_Account_Number"]; ?>>
-->
<?php $_SESSION["CCN"]=$ccn; ?>
<center>
<?php echo"<h2> $ccn </h2>" ?>
</center>
</div>
<br>
<center>
<input type="submit" value="Submit" class="send_btn">
<input type="reset"  value="Reset" class="del_btn">
</center>
</form>
<br>
<br>

<center>
<div class="chathead"><font color="White"><h2>Cheque Deposit</h2></font></div>
</center>
<br>
<form action="check_pic_deposit.php" method="post" enctype="multipart/form-data">
<table align="center" cellpadding="10px." bgcolor="white">
<tr>
<td><b>Cheque</b></td>
<td><input type="file" name="cheque"></td>
</tr>
<tr>
<td><b>Payer Account Number</b></td>
<td><input type="text" class="input" name="payer_acc_no" placeholder="   Cheque ordred by" required></td>
</tr>
<tr>
<td><b>Date of Transaction</b></td>
<td><input type="date" class="input" name="dot" required></td>
</tr>
<tr>
<td><b>Paid Amount</b></td>
<td><input type="text" class="input" name="amount" placeholder="   Amount" required></td>
</tr>
<tr>
<td><b>Cheque Number</b></td>
<td><input type="text" class="input" name="CCN" placeholder="   Cheque Number" required></td>
</tr>
<tr>
<td><input type="submit" value="Submit" class="send_btn"></td>
<td><input type="reset"  value="Reset" class="del_btn"></td>
</tr>
</table>
</center>
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


