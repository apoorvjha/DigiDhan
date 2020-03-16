<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" href="SUPPORT_PIC/logo.jpeg" /> <!-- For inserting custom mini icon on the title tab of web pages -->
<link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>
<?php
#+++++++++++++++++++++++++++++ destroying session variables(logging out)  +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$_SESSION["User_Id"]=null;
$_SESSION["User_Name"]=null;
$_SESSION["User_Mail"]=null;
$_SESSION["User_Active_Status"]=null;
$_SESSION["User_Profile"]=null;
$_SESSION["User_Type"]=null;
session_unset();
session_destroy();
#+++++++++++++++++++++++++++++ End of destroying session variables ++++++++++++++++++++++++++++++++++++++++++++++++++++
?>
<br><br><br><br><br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<div class="logout">
<h1>Logout successfull</h1><br>
<font color="green">You will be shortly redirected to home page.</font>
<script>function err(){window.location.href="index.php";}setTimeout(err,2000);</script>
</div>
</body>
</html>
